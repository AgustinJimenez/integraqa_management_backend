<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Repositories\MailRepository;
use App\Models\VerificationToken;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'emailConfirmation', 'register', 'passwordRecovery', 'passwordResetCodeCheck', 'passwordReset']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login()
    {
        $credentials = request(['email', 'password']);

        $user = User::where('email', $credentials['email'])->first();

        if(!$user)
            return abort(400, 'user_doesnt_exists');
        else if(!$user->email_verified_at)
            return abort(400, 'user_is_not_verified');
        else if(!$user->enabled)
            return abort(400, 'user_is_unabled');
            

        if (! $token = auth()->attempt($credentials))
            return abort(401, 'invalid_credentials');
        

        return $this->respondWithToken($token);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json(auth()->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }

    public function register(Request $request){

        $data = $request->only([ 'name', 'email', 'password' ]);
        User::validate( $data );

        DB::beginTransaction();

        $user = User::create( $data );
        MailRepository::sendEmailConfirmation($user);

        DB::commit();
    }

    public function emailConfirmation(Request $request){
        $verification_code = $request->get('verification_code');
        $user = User::whereHas('verification_tokens', function($verification_token_table) use (&$verification_code){
            $verification_token_table->where('value', $verification_code)
            ->where('type', VerificationToken::$types['user_email_verification'] )
            ->IsNotExpired();
        })
        ->firstOrFail();
        
        if($user->email_verified_at)
            return abort(400, 'user_is_already_verified');
        
        $user->update([
            'email_verified_at' => now()->toDateTimeString() ,
        ]);    
    }

    public function passwordRecovery(Request $request){

        $email = $request->get('email');
        $user = User::where([
            ['email', $email]
        ])
        ->firstOrFail();

        VerificationToken::bindNewUniqueToken($user, VerificationToken::$types['user_password_recovery']);

        MailRepository::sendPasswordRecoveryEmail($user);
    }

    public function passwordResetCodeCheck(Request $request){
        $reset_code = $request->get('reset_code');
        VerificationToken::where([
            ['value', $reset_code],
            ['type', VerificationToken::$types['user_password_recovery']]
        ])
        ->isNotExpired()
        ->firstOrFail();
    }

    public function passwordReset(Request $request){

        $new_password = $request->get('new_password');
        $reset_code = $request->get('reset_code');

        $validator = Validator::make( compact('new_password'), ['new_password' => ['bail', 'required', "min:6"]] );
        
        if($validator->fails())
            abort(400, $validator->errors()->first() );

        \DB::beginTransaction();

        $verification_code = VerificationToken::with('entity')
        ->where([
            ['value', $reset_code],
            ['type', VerificationToken::$types['user_password_recovery']]
        ])
        ->isNotExpired()
        ->firstOrFail();

        $user = $verification_code->entity;
        
        $user->password = $new_password;

        $user->update();

        VerificationToken::where([
            ['entity_id', $user->id],
            ['type', VerificationToken::$types['user_password_recovery']]
        ])
        ->delete();

        \DB::commit();
    }

}