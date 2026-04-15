<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Subscription;
use App\Models\SubscriptionPlan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Carbon;
use Stripe\Stripe;
use Stripe\Checkout\Session as StripeSession;

class PaymentController extends Controller
{

    public function checkout(SubscriptionPlan $plan)
    {
        return $this->stripeCheckout($plan);
    }

    private function stripeCheckout(SubscriptionPlan $plan)
    {
        $user = Auth::user();
        Stripe::setApiKey(config('services.stripe.secret'));

        try {
            $options = $this->getStripeSessionOptions($user, $plan);
            $checkoutSession = StripeSession::create($options);

            Payment::create([
                'user_id'        => $user->id,
                'plan_id'        => $plan->id,
                'amount'         => $plan->price,
                'gateway'        => 'stripe',
                'status'         => 'pending',
                'transaction_id' => $checkoutSession->id,
                'metadata'       => ['checkout_session_id' => $checkoutSession->id],
            ]);

            return redirect()->away($checkoutSession->url);

        } catch (\Exception $e) {
            Log::error('Stripe Checkout Failed', ['error' => $e->getMessage()]);
            return redirect()->route('subscriptions.plans')
                ->with('error', 'Checkout could not be initiated. Please try again later.');
        }
    }

    private function getStripeSessionOptions($user, SubscriptionPlan $plan): array
    {
        return [
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'usd',
                    'product_data' => [
                        'name' => 'WolfNet - ' . $plan->name,
                        'description' => $plan->duration_days . ' days of premium access',
                    ],
                    'unit_amount' => (int) ($plan->price * 100),
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => route('payment.stripe.success') . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('payment.fail'),
            'customer_email' => $user->email,
            'metadata' => [
                'user_id' => $user->id,
                'plan_id' => $plan->id,
            ],
        ];
    }

    public function stripeSuccess(Request $request)
    {
        $sessionId = $request->query('session_id');

        if (!$sessionId) {
            return redirect()->route('subscriptions.plans')->with('error', 'Invalid checkout session.');
        }

        // ─── Synchronous Verification ─────────────────────────────────
        // Fallback for local development or delayed webhooks.
        try {
            Stripe::setApiKey(config('services.stripe.secret'));
            $session = StripeSession::retrieve($sessionId);

            if ($session->payment_status === 'paid') {
                $payment = Payment::where('transaction_id', $sessionId)->first();

                if ($payment && $payment->status !== 'confirmed') {
                    $payment->update([
                        'status' => 'confirmed',
                        'metadata' => array_merge($payment->metadata ?? [], [
                            'stripe_payment_intent' => $session->payment_intent,
                        ])
                    ]);

                    $user = Auth::user() ?? \App\Models\User::find($payment->user_id);
                    $plan = SubscriptionPlan::find($payment->plan_id);

                    if ($user && $plan) {
                        $this->subscribe($user, $plan, $payment);
                    }
                }
            }
        } catch (\Exception $e) {
            Log::error('Synchronous Stripe Verification Failed', ['error' => $e->getMessage()]);
            // Continue to fallback check below
        }

        // Refresh payment record for final status check
        $payment = Payment::where('transaction_id', $sessionId)->first();

        if ($payment && $payment->status === 'confirmed') {
            return redirect()->route('subscriptions.index')
                ->with('success', 'Your subscription is active! Welcome to WolfNet.');
        }

        return redirect()->route('subscriptions.index')
            ->with('success', 'Payment received! We are activating your subscription now...');
    }

    public function fail(Request $request)
    {
        return redirect()->route('subscriptions.plans')
            ->with('error', 'Payment was cancelled or failed. Your account has not been charged.');
    }

    // subscription activation

    public function subscribe($user, SubscriptionPlan $plan, Payment $payment): void
    {
        if ($user->hasActiveSub()) {
            // early renewal (queue the new subscription)

            $current = $user->currentSubscription();

            Subscription::create([
                'user_id' => $user->id,
                'plan_id' => $plan->id,
                'payment_id' => $payment->id,
                'status' => 'queued',
                'starts_at' => $current->ends_at,
                'ends_at' => $current->ends_at->addDays($plan->duration_days),
            ]);
        } else {
            // fresh subscription (activate immediately)
            Subscription::create([
                'user_id' => $user->id,
                'plan_id' => $plan->id,
                'payment_id' => $payment->id,
                'status' => 'active',
                'starts_at' => Carbon::now(),
                'ends_at' => Carbon::now()->addDays($plan->duration_days),
            ]);
        }
    }

    // user's payment history (linked from profile page)

    public function index()
    {
        $payments = Auth::user()
            ->payments()
            ->with('plan')
            ->latest()
            ->paginate(15);

        return view('payments.index', compact('payments'));
    }

    public function show(Payment $payment)
    {
        abort_unless($payment->user_id === Auth::id(), 403);
        $payment->load(['plan', 'subscription']);
        return view('payments.show', compact('payment'));
    }

    // admin (full payment log)

    public function adminIndex()
    {
        abort_unless(Auth::user()?->isAdmin(), 403);

        $payments = Payment::with(['user', 'plan'])
            ->latest()
            ->paginate(30);

        return view('admin.payments.index', compact('payments'));
    }
}
