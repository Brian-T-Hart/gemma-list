<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SharedGlistMail extends Mailable
{
    use Queueable, SerializesModels;

    public $shareData;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($shareData)
    {
        $this->shareData = $shareData;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.share');
    }
}
