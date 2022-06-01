<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;

class VerifyEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user)
    {
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        // $hash = base64_encode(Hash::make($this->user->email . $this->user->lastname));
        $hash = Crypt::encrypt($this->user->email);

        $url = route('register.edit', $hash);
        $data = array(
            'email' => $this->user->email,
            'url' => $url
        );
        return $this->from(env('MAIL_USERNAME'), 'Example')
            ->view('email.verify', $data);
        // return $this->view('view.name');
    }
}
