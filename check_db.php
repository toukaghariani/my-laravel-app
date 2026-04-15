<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== Local DB Counts ===\n";
echo "Users: " . App\Models\User::count() . "\n";
echo "Content: " . App\Models\Content::count() . "\n";
echo "Active Subs: " . App\Models\Subscription::where('status', 'active')->where('ends_at', '>', now())->count() . "\n";
echo "Revenue (Confirmed Payments): " . App\Models\Payment::where('status', 'confirmed')->sum('amount') . "\n";
echo "Pending Payments: " . App\Models\Payment::where('status', 'pending')->count() . "\n";
