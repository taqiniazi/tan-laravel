<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\User::create([
            'name' => 'Admin',
            'email' => 'admin@tannetwork.online',
            'password' => \Illuminate\Support\Facades\Hash::make('ManuKhan@1122'),
            'role' => 'admin',
            'referral_code' => 'ADMIN1',
        ]);

        \App\Models\Config::create([
            'mining_rate' => 0.01,
            'min_withdrawal' => 10,
            'max_withdrawal' => 1000,
            'referral_bonus' => 10,
            'maintenance_mode' => false,
            'min_app_version' => '1.0.0',
            'app_update_url' => 'https://tannetwork.online'
        ]);
    }
}
