<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class StageProgressUpdated extends Mailable
{
    use Queueable, SerializesModels;

    public $stage;
    public $progress;

    /**
     * Create a new message instance.
     */
    public function __construct($stage, $progress)
    {
        $this->stage = $stage;
        $this->progress = $progress;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject('Stage Progress Updated')
                    ->view('emails.stage-progress-updated');
    }
}