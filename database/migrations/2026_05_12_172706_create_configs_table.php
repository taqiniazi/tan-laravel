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
        Schema::create('configs', function (Blueprint $table) {
            $table->id();
            $table->decimal('mining_rate', 10, 4)->default(0.01);
            $table->decimal('min_withdrawal', 20, 8)->default(10);
            $table->decimal('max_withdrawal', 20, 8)->default(1000);
            $table->decimal('referral_bonus', 20, 8)->default(10);
            $table->boolean('maintenance_mode')->default(false);
            $table->string('payment_address_evm')->nullable();
            $table->string('payment_address_sol')->nullable();
            $table->decimal('premium_fee', 20, 8)->default(10.0);
            $table->string('min_app_version')->default('1.0.0');
            $table->string('app_update_url')->default('https://tannetwork.online');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('configs');
    }
};
