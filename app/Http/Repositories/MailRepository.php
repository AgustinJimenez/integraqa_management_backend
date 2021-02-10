<?php namespace App\Http\Repositories;

use App\Mail\UserRegisterConfirmation;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

class MailRepository {

    public static function sendEmailConfirmation(User $user) {

        $message = (new UserRegisterConfirmation($user))->onQueue('emails');

        Mail::to($user)->queue($message);
    }

}