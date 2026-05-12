<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('country')->nullable();
            $table->string('city')->nullable();
            $table->string('profile_image')->nullable();
            $table->decimal('balance', 20, 8)->default(0);
            $table->decimal('base_balance', 20, 8)->default(0);
            $table->decimal('mining_rate', 10, 4)->default(0.01);
            $table->timestamp('last_mining_start_time')->nullable();
            $table->boolean('is_mining_active')->default(false);
            $table->boolean('is_premium')->default(false);
            $table->timestamp('premium_expiry')->nullable();
            $table->string('referral_code')->unique();
            $table->string('referred_by')->nullable();
            $table->decimal('referral_earnings', 20, 8)->default(0);
            $table->decimal('total_earned_from_mining', 20, 8)->default(0);
            $table->string('role')->default('user');
            $table->string('fcm_token')->nullable();
            $table->string('ip_address')->nullable();
            $table->string('device_id')->nullable();
            $table->boolean('is_flagged')->default(false);
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
