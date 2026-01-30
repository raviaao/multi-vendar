<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

     public function isAdmin()
    {
        return $this->role === 'admin';
    }

   protected $fillable = [
    'name',
    'email',
    'phone',
    'password',
    'role',
    'phone_verified',
    'phone_verification_code',
    'phone_verification_sent_at',
    'phone_verified_at',
];

protected $casts = [
    'phone_verified' => 'boolean',
    'phone_verification_sent_at' => 'datetime',
    'phone_verified_at' => 'datetime',
    'otp_blocked_until' => 'datetime',
];

// OTP related methods
public function canReceiveOTP()
{
    if ($this->otp_blocked_until && now()->lt($this->otp_blocked_until)) {
        return false;
    }

    return true;
}

public function incrementOTPAttempts()
{
    $this->otp_attempts++;

    if ($this->otp_attempts >= 5) {
        $this->otp_blocked_until = now()->addHours(1);
    }

    $this->save();
}

public function resetOTPAttempts()
{
    $this->otp_attempts = 0;
    $this->otp_blocked_until = null;
    $this->save();
}

public function isPhoneVerified()
{
    return $this->phone_verified;
}

    // /**
    //  * The attributes that should be hidden for serialization.
    //  *
    //  * @var array<int, string>
    //  */
    // protected $hidden = [
    //     'password',
    //     'remember_token',
    // ];

    // /**
    //  * The attributes that should be cast.
    //  *
    //  * @var array<string, string>
    //  */
    // protected $casts = [
    //     'email_verified_at' => 'datetime',
    //     'password' => 'hashed',
    // ];
}
