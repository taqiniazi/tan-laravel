<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Config;

class ConfigController extends Controller
{
    public function getConfig()
    {
        $config = Config::first();
        
        if (!$config) {
            // Seed default config if not exists
            $config = Config::create([
                'mining_rate' => 0.01,
                'min_withdrawal' => 10,
                'max_withdrawal' => 1000,
                'referral_bonus' => 10,
                'maintenance_mode' => false,
                'min_app_version' => '1.0.0',
                'app_update_url' => 'https://tannetwork.online'
            ]);
        }

        return response()->json($config);
    }

    public function updateConfig(Request $request)
    {
        $config = Config::first();
        if (!$config) {
            $config = new Config();
        }

        $config->fill($request->all());
        $config->save();

        return response()->json($config);
    }
}
