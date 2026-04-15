<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// Try to manually verify the latest pending payment
$payment = App\Models\Payment::where('status', 'pending')->latest()->first();
echo "Testing payment #{$payment->id} tx:{$payment->transaction_id}\n\n";

try {
    \Stripe\Stripe::setApiKey(config('services.stripe.secret'));
    echo "Stripe key set: " . substr(config('services.stripe.secret'), 0, 12) . "...\n";
    
    $session = \Stripe\Checkout\Session::retrieve($payment->transaction_id);
    echo "Session payment_status: {$session->payment_status}\n";
    echo "Session status: {$session->status}\n";
    
    if ($session->payment_status === 'paid') {
        echo "\n✅ Payment IS confirmed on Stripe side!\n";
        echo "Attempting to confirm locally...\n";
        
        $payment->update([
            'status' => 'confirmed',
            'metadata' => array_merge($payment->metadata ?? [], [
                'stripe_payment_intent' => $session->payment_intent,
            ])
        ]);
        
        $user = App\Models\User::find($payment->user_id);
        $plan = App\Models\SubscriptionPlan::find($payment->plan_id);
        
        echo "User: {$user->name}, Plan: {$plan->name} ({$plan->duration_days} days)\n";
        
        // Create subscription
        $sub = App\Models\Subscription::create([
            'user_id' => $user->id,
            'plan_id' => $plan->id,
            'payment_id' => $payment->id,
            'status' => 'active',
            'starts_at' => now(),
            'ends_at' => now()->addDays($plan->duration_days),
        ]);
        
        echo "✅ Subscription created: #{$sub->id} ends_at:{$sub->ends_at}\n";
    } else {
        echo "\n❌ Payment NOT confirmed on Stripe.\n";
    }
    
} catch (\Exception $e) {
    echo "\n❌ ERROR: " . get_class($e) . ": " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . ":" . $e->getLine() . "\n";
}
