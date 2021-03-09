<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use App\Models\User;

class VerificationToken extends Model
{
    use HasFactory;
    public static $types = [
        'user_email_verification' => 'user_email_verification',
        'user_password_recovery' => 'user_password_recovery',
    ];
    protected $table = 'verifications_tokens';
    protected $fillable = [
        'value',
        'type',
        'deadline',
        'entity_id',
        'entity_type'
    ];
    public function entity()
    {
        return $this->morphTo();
    }
    public function scopeIsNotExpired($query)
    {
        $query
        ->whereDate('deadline', '>', now()->toDateTimeString());
    }

    public static function bindNewUniqueToken($object, $type){
        $exists = true;
        $email_verification_token = '';

        while($exists) {
            $email_verification_token = Str::random(30);
            $exists = VerificationToken::where('value', $email_verification_token)->exists();
        }
        VerificationToken::create([
            'value' => $email_verification_token,
            'type' => self::$types[$type],
            'deadline' => now()->addWeek()->toDateTimeString(),
            'entity_id' => $object->id,
            'entity_type'=> get_class($object),
        ]);
    }

}
