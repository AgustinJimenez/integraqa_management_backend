<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class User extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'image',
        'utr',
        'enabled',
        'email_verification_token',
        'email_verified_at'
    ];

    static $rules = [
        'name' => ['bail', 'required', 'min:3', 'max:120'],
        'email' => ['bail', 'required', 'unique:users', 'max:90', 'email'],
        'password' => ['bail', 'required', "min:6"],
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
    }
    public static function boot()
    {

        parent::boot();

        static::creating(function ($user) {
            $exists = true;
            $email_verification_token = '';

            while($exists) {
                $email_verification_token = Str::random(30);
                $exists = User::where('email_verification_token', $email_verification_token)->exists();
            }

            $user->email_verification_token = $email_verification_token;
        });
        
        /*
        static::created(function ($user) {
            
        });

        static::creating(function ($note) {
            logger()->info("note creating!!!");
        });

        static::updating(function ($note) {
            logger()->info("note updating!!!");
        });
        static::deleting(function ($evaluation) {

        });
        */
        
    }

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    public static function validate(array $data): void {

        $validator = Validator::make($data, self::$rules );

        if($validator->fails())
            abort(401, $validator->errors() );
    }

}
