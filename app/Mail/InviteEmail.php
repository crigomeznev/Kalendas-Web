<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class InviteEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $inviter, $email;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($inviter, $email)
    {
        $this->inviter = $inviter;
        $this->email = $email;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $data = array(
            'inviter' => $this->inviter,
            'email' => $this->email,
            'url' => route('register.create', ['email' => $this->email])
        );

        return $this->from(env('MAIL_USERNAME'), 'Kalendas Admin')
            ->view('email.invitation', $data);
        // return $this->view('view.name');
    }
}
