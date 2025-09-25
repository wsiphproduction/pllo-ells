<?php

namespace App\Mail;

use App\Helpers\Setting;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ClusterModifyMail extends Mailable
{
    use Queueable, SerializesModels;

    public $setting;
    public $admin;

    /**
     * Create a new message instance.
     * 
     * @param $setting
     * @param $clientInfo
     */
    public function __construct($setting, $admin)
    {
        $this->setting = $setting;
        $this->admin = $admin;
    }

    /**
     * pwede
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mail.cluster-modify-notification')
            ->subject('Cluster Modify Notification');
    }
}
