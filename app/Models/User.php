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
    protected $fillable = [
        'name',
        'email',
        'password',
        'country',
        'city',
        'profile_image',
        'balance',
        'base_balance',
        'mining_rate',
        'last_mining_start_time',
        'is_mining_active',
        'is_premium',
        'premium_expiry',
        'referral_code',
        'referred_by',
        'referral_earnings',
        'total_earned_from_mining',
        'role',
        'fcm_token',
        'ip_address',
        'device_id',
        'is_flagged',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'balance' => 'float',
        'base_balance' => 'float',
        'mining_rate' => 'float',
        'referral_earnings' => 'float',
        'total_earned_from_mining' => 'float',
        'is_mining_active' => 'boolean',
        'is_premium' => 'boolean',
        'is_flagged' => 'boolean',
    ];
}
