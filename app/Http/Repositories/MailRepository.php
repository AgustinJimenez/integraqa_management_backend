<?php namespace App\Http\Repositories;

use App\Mail\UserRegisterConfirmation;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

class MailRepository {

    public static function sendEmailConfirmation(User $user) {

        try {

            $message = (new UserRegisterConfirmation($user))->onQueue('emails');

            Mail::to($user)->queue($message);

        } catch (\Exception $error) {
            abort(500, 'cant_send_confirmation_email');
        }
    }

}