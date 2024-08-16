<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SalaryCreditMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public $salary_message;
    public function __construct($salary_message)
    {
        $this->salary_message = $salary_message;
    }

    public function build()
    {
        return $this->subject('Salary Creditad Information')
            ->view('emails.salaryCreditMail')
            ->with('salary_message', $this->salary_message);
    }
}
