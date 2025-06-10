<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ResetPasswordMail extends Mailable
{
    use Queueable, SerializesModels;

    public $token;
    public $resetUrl;

    /**
     * Create a new message instance.
     *
     * @param string $token
     * @return void
     */
    public function __construct($token)
    {
        $this->token = $token;
        $this->resetUrl = config('app.url')."/reset-password?token=".$token;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('إعادة تعيين كلمة المرور')
                    ->view('emails.reset_password')
                    ->with([
                        'token' => $this->token,
                        'resetUrl' => $this->resetUrl,
                    ]);
    }
}