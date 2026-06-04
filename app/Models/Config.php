<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Config extends Model
{
    use HasFactory;

    protected $fillable = [
        'mining_rate',
        'premium_mining_rate',
        'min_withdrawal',
        'max_withdrawal',
        'referral_bonus',
        'premium_referral_bonus',
        'maintenance_mode',
        'payment_address_evm',
        'payment_address_sol',
        'premium_fee',
        'min_app_version',
        'app_update_url',
    ];

    protected $casts = [
        'mining_rate' => 'float',
        'premium_mining_rate' => 'float',
        'min_withdrawal' => 'float',
        'max_withdrawal' => 'float',
        'referral_bonus' => 'float',
        'premium_referral_bonus' => 'float',
        'premium_fee' => 'float',
        'maintenance_mode' => 'boolean',
    ];
}
