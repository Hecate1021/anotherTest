<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class BookingCancelled extends Mailable
{
    use Queueable, SerializesModels;

    public $booking;
    public $reason;
    public $userEmail;
    public $userName;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($booking, $reason, $userEmail, $userName)
    {
        $this->booking = $booking;
        $this->reason = $reason;
        $this->userEmail = $userEmail;
        $this->userName = $userName;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.booking_cancelled')
                    ->with([
                        'booking' => $this->booking,
                        'reason' => $this->reason,
                    ])
                    ->from($this->userEmail, $this->userName)
                    ->subject('Booking Cancelled');
    }
}
