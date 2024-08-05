<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class BookingDetails extends Mailable
{
    use Queueable, SerializesModels;

    public $booking;
    public $user;
    public $imagePath;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($booking, $user, $imagePath = null)
    {
        $this->booking = $booking;
        $this->user = $user;
        $this->imagePath = $imagePath;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $email = $this->from($this->user->email)
                      ->view('emails.booking_Accept')
                      ->subject('Booking Accept')
                      ->with([
                          'booking' => $this->booking,
                          'user' => $this->user,
                      ]);

        if ($this->imagePath) {
            $email->attachFromStorage($this->imagePath);
        }

        return $email;
    }
}
