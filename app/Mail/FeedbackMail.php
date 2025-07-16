<?php

namespace App\Mail;

use App\Helpers\Setting;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class FeedbackMail extends Mailable
{
    use Queueable, SerializesModels;

    public $setting;
    public $recipient;
    public $event;
    public $downloadables;
    /**
     * Create a new message instance.
     *
     * @param $setting
     * @param $recipient
     */
    public function __construct($setting, $recipient, $event, $downloadables)
    {
        $this->setting = $setting;
        $this->recipient = $recipient;
        $this->event = $event;
        $this->downloadables = $downloadables;
    }

    /**
     * pwede
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mail.event-feedback')
            ->subject('Thanks for submitting a feedback');
    }
}
