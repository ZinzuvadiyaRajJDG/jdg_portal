<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class LeaveApproveMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public $leaveData;
    public $user_name;
    public function __construct($leaveData,$user_name)
    {
        $this->leaveData = $leaveData;
        $this->user_name = $user_name;
    }

    public function build()
    {
        return $this->subject('Leave Application Approved')
            ->view('emails.leaveApprovedMails')
            ->with('leaveData', $this->leaveData)
            ->with('user_name', $this->user_name);
    }
}
