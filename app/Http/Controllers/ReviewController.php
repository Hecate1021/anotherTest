<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function store(Request $request,)
    {
        $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'booking_id' => 'required',
            'resort_id' => 'required|exists:users,id',
            'review' => 'required|string|max:255',
            'rating' => 'required|integer|between:1,5',
        ]);

        $review = new Review([

            'room_id' => $request->room_id,
            'booking_id' => $request->booking_id,
            'resort_id' => $request->resort_id,
            'user_id' => Auth::id(),
            'review' => $request->review,
            'rating' => $request->rating,
        ]);

        $review->save();

        return redirect()->back()->with('success', 'Review submitted successfully!');
    }


}
