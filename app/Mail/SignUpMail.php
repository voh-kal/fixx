<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SignUpMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data
        //
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $address = 'larylivlynnxe@gmail.com';
        $subject = 'SIgn Up';
        $name = 'Product';

        return $this->view('email.signup_email')
                    ->from($address, $this->data['event_name'] ?? $name)
                    // ->cc($address, $name)
                    // ->bcc($address, $name)
                    ->replyTo($address, $name)
                    ->subject($this->data['subject']?? $subject)
                    ->with([ 
                        'themessage' => $this->data['message'],
                        'title' => $this->data['subject'] ?? $subject,
                        'link' => $this->data['link'] ?? ''
                    ]);
    }
    }
}
