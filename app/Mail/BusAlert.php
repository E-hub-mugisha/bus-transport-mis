<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class BusAlert extends Mailable
{
    use Queueable, SerializesModels;

    public $messageContent;

    /**
     * Create a new message instance.
     */
    public function __construct($messageContent)
    {
        $this->messageContent = $messageContent;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject('EDURIDE Bus Alert')
                    ->view('emails.bus_alert')
                    ->with(['messageContent' => $this->messageContent]);
    }
}
