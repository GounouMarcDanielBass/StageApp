<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ApplicationStatusChanged extends Mailable
{
    use Queueable, SerializesModels;

    public $application;
    public $newStatus;

    /**
     * Create a new message instance.
     */
    public function __construct($application, $newStatus)
    {
        $this->application = $application;
        $this->newStatus = $newStatus;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject('Application Status Updated')
                    ->view('emails.application-status-changed');
    }
}