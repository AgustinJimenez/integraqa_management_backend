<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use App\Models\User;
use Illuminate\Queue\SerializesModels;

class UserPasswordRecovery extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    protected $user;
    protected $verification_token;

    public function __construct(User $user, string $verification_token)
    {
        $this->user = $user;
        $this->verification_token = $verification_token;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $user = $this->user;
        $verification_token = $this->verification_token;
        $link = env('APP_FRONTEND_URL') . "/" . "password_reset/?rc=" .  $verification_token;

        return $this
            ->from( env('MAIL_FROM_ADDRESS', 'no-mail') )
            ->to($user->email)
            ->view("emails/user_password_recovery_confirmation")
            ->with(compact('user', 'link'));
    }
}
