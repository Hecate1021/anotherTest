<!DOCTYPE html>
<html>
<head>
    <title>Booking Cancelled</title>
</head>
<body>
    <h1>Booking Cancelled</h1>
    <p>The following booking has been cancelled:</p>
    <ul>
        <li>Booking ID: {{ $booking->id }}</li>
        <li>Room: {{ $booking->room->name }}</li>
        <li>Cancelled by: {{ $booking->user->name }}  Email{{ $booking->user->email }}</li>
        <li>Reason: {{ $reason }}</li>
    </ul>
</body>
</html>
