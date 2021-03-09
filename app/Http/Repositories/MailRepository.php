<?php namespace App\Http\Repositories;

use App\Mail\UserPasswordRecovery;
use App\Mail\UserRegisterConfirmation;
use App\Models\User;
use App\Models\VerificationToken;
use Illuminate\Support\Facades\Mail;

class MailRepository {

    public static function sendEmailConfirmation(User $user) {

        $user->loadMissing(['verification_tokens' => function ($query) {
            $query
            ->where('type', VerificationToken::$types['user_email_verification'] )
            ->IsNotExpired();
        }]);
        $verification_token = $user->verification_tokens->first();

        try {

            $message = (new UserRegisterConfirmation($user, $verification_token->value))->onQueue('emails');

            Mail::to($user)->queue($message);

        } catch (\Exception $error) {
            abort(500, 'cant_send_confirmation_email');
        }
    }

    public static function sendPasswordRecoveryEmail(User &$user) {

        $user->loadMissing(['verification_tokens' => function ($verification_tokens_table) {
            $verification_tokens_table
            ->where('type', VerificationToken::$types['user_password_recovery'] )
            ->IsNotExpired();
        }]);
        $verification_token = $user->verification_tokens->first();

        try {

            $message = (new UserPasswordRecovery($user, $verification_token->value))->onQueue('emails');

            Mail::to($user)->queue($message);

        } catch (\Exception $error) {
            abort(500, 'cant_send_password_recovery_email');
        }
    }

}