<?php
// Initialize Laravel
require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

header('Content-Type: text/plain');

// Check if user requested config clear
if (isset($_GET['clear'])) {
    echo "--- Clearing Configuration Cache ---\n";
    try {
        Illuminate\Support\Facades\Artisan::call('config:clear');
        echo "Artisan config:clear output:\n" . Illuminate\Support\Facades\Artisan::output() . "\n";
    } catch (\Exception $e) {
        echo "Error clearing config cache: " . $e->getMessage() . "\n";
    }
}

echo "--- Mail Configuration ---\n";
echo "Default Mailer: " . config('mail.default') . "\n";
echo "SMTP Host: " . config('mail.mailers.smtp.host') . "\n";
echo "SMTP Port: " . config('mail.mailers.smtp.port') . "\n";
echo "SMTP Encryption: " . config('mail.mailers.smtp.encryption') . "\n";
echo "SMTP Username: " . config('mail.mailers.smtp.username') . "\n";
echo "From Address: " . config('mail.from.address') . "\n";
echo "From Name: " . config('mail.from.name') . "\n";

echo "\n--- Testing Mail Sending ---\n";
try {
    Illuminate\Support\Facades\Mail::raw('Test email from TAN Network', function ($message) {
        $message->to('nforex61@gmail.com')
                ->subject('SMTP Test');
    });
    echo "SUCCESS: Email sent successfully!\n";
} catch (\Exception $e) {
    echo "ERROR: Failed to send email.\n";
    echo "Exception Message: " . $e->getMessage() . "\n";
    echo "Exception Trace:\n" . $e->getTraceAsString() . "\n";
}

echo "\nTo clear cached configuration in production, visit: https://tannetwork.online/tan-laravel/public/test-mail.php?clear=1\n";

