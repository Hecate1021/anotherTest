<!DOCTYPE html>
<html>
<head>
    <title>New Booking Details</title>
</head>
<body>
    <h1>New Booking Details</h1>
    <p>Dear Resort Owner,</p>
    <p>A new booking has been made with the following details:</p>
    <ul>
        <li><strong>Name:</strong> {{ $user->name }}</li>
        <li><strong>Email:</strong> {{ $user->email }}</li>
        <li><strong>Contact Number:</strong> {{ $booking->contact_no }}</li>
        <li><strong>Number of Visitors:</strong> {{ $booking->number_of_visitors }}</li>
        <li><strong>Payment:</strong> {{ $booking->payment }}</li>
        <li><strong>Check-in Date:</strong> {{ $booking->check_in_date }}</li>
        <li><strong>Check-out Date:</strong> {{ $booking->check_out_date }}</li>
    </ul>
    @if ($imagePath)
        <p><strong>Payment Image:</strong></p>
        <img src="{{ $message->embed(storage_path('app/public/' . $imagePath)) }}" alt="Payment Image">
    @endif
    <p>Thank you,</p>
    <p>Your Booking System</p>
</body>
</html>
