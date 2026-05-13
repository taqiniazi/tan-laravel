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
        'maintenance_mode',
        'payment_address_evm',
        'payment_address_sol',
        'premium_fee',
        'min_app_version',
        'app_update_url',
    ];
}
