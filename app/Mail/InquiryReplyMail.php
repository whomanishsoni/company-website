<?php

namespace App\Mail;

use App\Models\MailInquiry;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class InquiryReplyMail extends Mailable
{
    use Queueable, SerializesModels;

    public $inquiry;

    public function __construct(MailInquiry $inquiry)
    {
        $this->inquiry = $inquiry;
    }

    public function build()
    {
        return $this->subject('Re: ' . $this->inquiry->subject)
            ->markdown('emails.inquiry-reply')
            ->with([
                'inquiry' => $this->inquiry,
                'reply' => $this->inquiry->message
            ]);
    }
}
