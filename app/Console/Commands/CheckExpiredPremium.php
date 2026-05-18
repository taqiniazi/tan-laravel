<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Notifications\PremiumSubscriptionNotification;
use Carbon\Carbon;

class CheckExpiredPremium extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:check-expired-premium';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Downgrade users with expired premium subscriptions and send notifications';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $now = now();

        // 1. Process Expired Users
        $expiredUsers = User::where('is_premium', true)
            ->where('premium_expiry', '<', $now)
            ->get();

        foreach ($expiredUsers as $user) {
            $user->update([
                'is_premium' => false,
                'mining_rate' => 0.01, // Reset to standard rate
            ]);

            $user->notify(new PremiumSubscriptionNotification('expired'));
            $this->info("User {$user->email} has been downgraded (expired).");
        }

        // 2. Process Users expiring in 3 days (Warning)
        $warningDate = $now->copy()->addDays(3);
        $expiringSoonUsers = User::where('is_premium', true)
            ->whereDate('premium_expiry', $warningDate->toDateString())
            ->get();

        foreach ($expiringSoonUsers as $user) {
            $user->notify(new PremiumSubscriptionNotification('expiring_soon', $user->premium_expiry->toFormattedDateString()));
            $this->info("Sent expiration warning to {$user->email}.");
        }

        $this->info('Premium subscription check completed.');
    }
}
