<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Mail\BookingCancelled;
use App\Mail\BookingDetails;
use App\Models\Booking;
use App\Models\Image;
use App\Models\PaymentRecord;
use App\Models\Review;
use App\Models\Room;
use App\Models\TemporyImage;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class BookingController extends Controller
{
    public function booking($id)
    {
        $room = Room::findOrFail($id);
        return view('user.booking', compact('room'));
    }
    public function store(Request $request)
{
    $validator = Validator::make($request->all(), [
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255',
        'contact_no' => 'required|string|max:20',
        'number_of_visitors' => 'required|integer|min:1',
        'payment' => 'required',
        'check_in_date' => 'required|date',
        'check_out_date' => 'required|date|after_or_equal:check_in_date',
    ]);

    if ($validator->fails()) {
        $temporaryImages = TemporyImage::all();
        foreach ($temporaryImages as $temporaryImage) {
            Storage::deleteDirectory('images/tmp/' . $temporaryImage->folder);
            $temporaryImage->delete();
        }
        return redirect('/')->withErrors($validator)->withInput();
    }

    $checkInDate = Carbon::createFromFormat('m/d/Y', $request->check_in_date)->format('Y-m-d');
    $checkOutDate = Carbon::createFromFormat('m/d/Y', $request->check_out_date)->format('Y-m-d');

    // Find the room to get the resort ID
    $room = Room::find($request->room_id);
    if (!$room) {
        return redirect('/')->withErrors(['room_id' => 'Invalid room selected.'])->withInput();
    }

    // Create a new booking record
    $booking = new Booking();
    $booking->room_id = $request->room_id;
    $booking->user_id = Auth::user()->id;
    $booking->resort_id = $room->user_id; // Add the resort_id here
    $booking->name = $request->name;
    $booking->email = $request->email;
    $booking->contact_no = $request->contact_no;
    $booking->number_of_visitors = $request->number_of_visitors;
    $booking->payment = $request->payment;
    $booking->check_in_date = $checkInDate;
    $booking->check_out_date = $checkOutDate;

    // Save the booking to get its ID
    $booking->save();

    // Handle payment photo upload if exists
    $temporaryImages = TemporyImage::all();
    $imagePath = null;

    foreach ($temporaryImages as $temporaryImage) {
        $finalPath = 'images/' . $temporaryImage->folder . '/' . $temporaryImage->file;
        Storage::copy('images/tmp/' . $temporaryImage->folder . '/' . $temporaryImage->file, $finalPath);

        // Create a new PaymentRecord
        $paymentRecord = PaymentRecord::create([
            'booking_id' => $booking->id,
            'payment_name' => $temporaryImage->file,
            'payment_path' => $finalPath
        ]);

        // Save the final path of the image
        $imagePath = $finalPath;

        // Cleanup the temporary directory and delete the temporary image record
        Storage::deleteDirectory('images/tmp/' . $temporaryImage->folder);
        $temporaryImage->delete();
    }

    // Update the room status to 'occupied'
    $room->status = 'occupied';
    $room->save();

    // Send booking details email to the resort owner
    $resortOwner = User::find($room->user_id);
    Mail::to($resortOwner->email)->send(new BookingDetails($booking, Auth::user(), $imagePath));

    // Redirect with a success message
    return redirect()->route('user.mybooking')->with('success', 'Booking created successfully.');
}


    //Update Details of Booking
    public function updateBooking(Request $request, Booking $booking)
    {
        $request->validate([
            'room_name' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'contact_no' => 'required|string|max:255',
            'payment' => 'required|numeric',
            // 'status' => 'required|in:Pending,Accept,Cancel,Check Out',
        ]);

        $booking->room->update(['name' => $request->room_name]);
        $booking->update([
            'name' => $request->name,
            'email' => $request->email,
            'contact_no' => $request->contact_no,
            'payment' => $request->payment,
            'status' => $request->status,
        ]);

        return redirect()->route('resort.booking')->with('success', 'Booking updated successfully.');
    }
    //Check Out
    public function check_outView(Booking $booking){
        return view('resort.booking.bookingCheckOut', compact('booking'));

    }
    public function check_out(Request $request, Booking $booking)
{
    $request->validate([
        'room_name' => 'required|string|max:255',
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'contact_no' => 'required|string|max:255',
        'payment' => 'required|numeric',
    ]);



    $booking->room->update(['name' => $request->room_name]);
    $booking->update([
        'name' => $request->name,
        'email' => $request->email,
        'contact_no' => $request->contact_no,
        'payment' => $request->final_payment, // Updated to use the correct input name
        'status' => 'Check Out',
    ]);

    return redirect()->route('resort.booking')->with('success', 'Check Out successfully.');
}


    public function mybooking()
    {
        $user = Auth::user();
        $bookings = Booking::with(['room.images', 'room.reviews.user', 'resort.userInfo'])
            ->where('user_id', $user->id)
            ->get();

        $pendingCount = $bookings->where('status', 'Pending')->count();
        $acceptCount = $bookings->where('status', 'Accept')->count();
        $reviewCount = $bookings->where('status', 'Check Out')->count();
        $cancelCount = $bookings->where('status', 'Cancel')->count();

        // Create an array to store user reviews for each booking
        $userReviews = [];

        foreach ($bookings as $booking) {
            $userReview = Review::where('user_id', $user->id)
                ->where('booking_id', $booking->id)
                ->first();

            $userReviews[$booking->id] = $userReview;
        }

        return view('user.mybooking', compact('bookings', 'user', 'pendingCount', 'acceptCount', 'reviewCount', 'cancelCount', 'userReviews'));
    }



    public function bookingCancel(Request $request, $id)
    {
        // Validate the request
        $request->validate([
            'reason' => 'required|string|max:255',
        ]);

        // Find the booking by ID
        $booking = Booking::findOrFail($id);

        // Update the booking status to 'Cancelled' and save the reason
        $booking->status = 'Cancel';
        $booking->reason = $request->input('reason');
        $booking->save();

        // Find the associated room and update its status to 'available'
        $room = Room::find($booking->room_id);
        if ($room) {
            $room->status = 'available';
            $room->save();
        }

        // Get the owner's email from the room's owner
        $resortEmail = $room->owner->email; // Adjust based on your relationship

        // Get the user's email and name
        $user = auth()->user();
        $userEmail = $user->email;
        $userName = $user->name;

        // Send the cancellation email
        Mail::to($resortEmail)->send(new BookingCancelled($booking, $request->input('reason'), $userEmail, $userName));

        // Redirect back with a success message
        return redirect()->route('user.mybooking')->with('success', 'Booking cancelled successfully.');
    }
    public function calendar()
    {
        return view('resort.booking.calendar');
    }

    public function getEvents()
    {
        $bookings = Booking::with('room')->get();

        $events = $bookings->map(function ($booking) {
            if ($booking->room) {
                return [
                    'title' => $booking->room->name,
                    'start' => $booking->check_in_date,
                    'end' => Carbon::parse($booking->check_out_date)->addDay()->toDateString(),
                    'color' => $this->getStatusColor($booking->status),
                ];
            }
            return null;
        })->filter()->values();

        Log::info($events); // Log the events for debugging

        return response()->json($events);
    }


    private function getStatusColor($status)
    {
        switch ($status) {
            case 'Accept':
                return 'green';
            case 'Pending':
                return 'orange';
            case 'Cancel':
                return 'red';
            case 'Check Out':
                return 'yellow';
            default:
                return 'gray';
        }
    }

    public function bookingAccept($id)
{
    // Retrieve the booking by its ID
    $booking = Booking::find($id);

    // Check if the booking exists
    if ($booking) {
        // Update the booking status to 'Check Out'
        $booking->update([
            'status' => 'Accept',
        ]);

        return redirect()->route('resort.booking')->with('success', 'Booking accept successfully.');
    } else {
        return redirect()->route('resort.booking')->with('error', 'Booking not found.');
    }
}

}
