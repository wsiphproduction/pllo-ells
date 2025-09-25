<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Contracts\Queue\ShouldQueue;

class UpdateRequestApproveMail extends Mailable
{
    use Queueable, SerializesModels;

    public $setting;
    public $member;

    /**
     * Create a new message instance.
     * 
     * @param $setting
     * @param $member
     */
    public function __construct($setting, $member)
    {
        $this->setting = $setting;
        $this->member = $member;
    }

    /**
     * 
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mail.update-request-approve')
            ->subject('Cluster Update Approved');
    }
}
