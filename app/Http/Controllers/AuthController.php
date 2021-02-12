<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Repositories\MailRepository;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'emailConfirmation', 'register']]);
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
        $verification_code = $request->only('verification_code');
        $user = User::where([
            ['email_verification_token', $verification_code]
        ])
        ->firstOrFail();
        
        if($user->email_verified_at)
            return abort(400, 'user_is_already_verified');
        
        $user->update([
            'email_verified_at' => now()->toDateTimeString() ,
        ]);    
    }

}