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
use App\Models\{VerificationToken};
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

        static::created(function ($user) {

            VerificationToken::bindNewUniqueToken($user, VerificationToken::$types['user_email_verification']);

        }); 
        static::deleting(function ($user) {
            $user->verification_tokens()->delete();
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
            abort(400, $validator->errors()->first() );
    }

    public function verification_tokens()
    {
        return $this->morphMany(VerificationToken::class, 'entity');
    }

}
