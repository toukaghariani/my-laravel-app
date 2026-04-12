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

class PaymentController extends Controller
{

    public function checkout(SubscriptionPlan $plan)
    {
        $user = Auth::user();

        // Build the Flouci "generate_payment" payload(in millimes)

        $amountMillimes = (int) ($plan->price * 1000);

        $payload = [
            'app_token'              => config('services.flouci.app_token'),
            'app_secret'             => config('services.flouci.app_secret'),
            'accept_card'            => true,
            'amount'                 => $amountMillimes,
            'success_link'           => route('payment.success'),
            'fail_link'              => route('payment.fail'),
            'session_timeout_secs'   => 1200,
            'developer_tracking_id'  => 'wolfnet-' . $user->id . '-' . time(),
        ];

        $response = Http::post('https://developers.flouci.com/api/generate_payment', $payload);

        if (!$response->successful() || !($response->json('success') === true)) {
            Log::error('Flouci generate_payment failed', [
                'status'  => $response->status(),
                'body'    => $response->json(),
                'user_id' => $user->id,
                'plan_id' => $plan->id,
            ]);

            return redirect()->route('subscriptions.plans')
                ->with('error', 'Payment gateway is unavailable. Please try again later.');
        }

        $flouciPaymentId = $response->json('result.payment_id');
        $flouciLink      = $response->json('result.link');

        // Persist the pending payment record before leaving our app
        Payment::create([
            'user_id'        => $user->id,
            'plan_id'        => $plan->id,
            'amount'         => $plan->price,
            'status'         => 'pending',
            'transaction_id' => $flouciPaymentId,
        ]);

        // Store plan_id in session so success() can retrieve it
        // (Flouci only gives us back payment_id in the redirect)
        session(['wolfnet_pending_plan_id' => $plan->id]);

        return redirect()->away($flouciLink);
    }

    // Flouci redirects here after the user pays(MUST verify the payment with Flouci before activating anything)

    public function success(Request $request)
    {
        $user            = Auth::user();
        $flouciPaymentId = $request->query('payment_id');

        if (!$flouciPaymentId) {
            return redirect()->route('subscriptions.plans')
                ->with('error', 'Invalid payment callback. Please contact support.');
        }

        //Flouci verification
        $verification = Http::withHeaders([
            'apppublic' => config('services.flouci.app_token'),
            'appsecret' => config('services.flouci.app_secret'),
        ])->get("https://developers.flouci.com/api/verify_payment/{$flouciPaymentId}");

        if (!$verification->successful() || $verification->json('result.status') !== 'SUCCESS') {
            Log::warning('Flouci payment verification failed', [
                'payment_id' => $flouciPaymentId,
                'user_id'    => $user->id,
                'response'   => $verification->json(),
            ]);

            // Mark our pending record as failed
            Payment::where('transaction_id', $flouciPaymentId)
                   ->where('user_id', $user->id)
                   ->update(['status' => 'failed']);

            return redirect()->route('payment.fail')
                ->with('error', 'Payment could not be verified. Please try again.');
        }

        // Payment confirmed (update our record)
        $payment = Payment::where('transaction_id', $flouciPaymentId)
                          ->where('user_id', $user->id)
                          ->first();

        if (!$payment) {
            // Should never happen, but defensively handle it
            return redirect()->route('subscriptions.plans')
                ->with('error', 'Payment record not found. Contact support.');
        }

        $payment->update(['status' => 'confirmed']);

        // Retrieve plan from session (set in checkout())
        $planId = session()->pull('wolfnet_pending_plan_id');
        $plan   = SubscriptionPlan::find($planId ?? $payment->plan_id);

        if (!$plan) {
            Log::error('Plan not found after payment confirmation', ['payment_id' => $payment->id]);
            return redirect()->route('subscriptions.plans')
                ->with('error', 'Plan configuration error. Contact support.');
        }

        // ── Activate subscription (PRIVATE — never a direct route) ─
        $this->subscribe($user, $plan, $payment);

        return redirect()->route('subscriptions.index')
            ->with('success', 'Payment confirmed! Your subscription to "' . $plan->name . '" is now active.');
    }

    // Flouci redirects here when the user cancels or card fails.

    public function fail(Request $request)
    {
        $flouciPaymentId = $request->query('payment_id');

        if ($flouciPaymentId) {
            Payment::where('transaction_id', $flouciPaymentId)
                   ->where('user_id', Auth::id())
                   ->update(['status' => 'failed']);
        }

        session()->forget('wolfnet_pending_plan_id');

        return redirect()->route('subscriptions.plans')
            ->with('error', 'Payment failed or was cancelled. You have not been charged. Please try again.');
    }

    // subscription activation
    // Never exposed as a route!! (Called only from success() after)
    // Flouci confirms payment (handles both fresh subscriptions and early-renewal subscriptions(queued ones))

    private function subscribe($user, SubscriptionPlan $plan, Payment $payment): void
    {
        if ($user->hasActiveSub()) {
            // early renewal (queue the new subscription)

            $current = $user->currentSubscription();

            Subscription::create([
                'user_id'    => $user->id,
                'plan_id'    => $plan->id,
                'payment_id' => $payment->id,
                'status'     => 'queued',
                'starts_at'  => $current->ends_at,
                'ends_at'    => $current->ends_at->addDays($plan->duration_days),
            ]);
        } else {
            // fresh subscription (activate immediately)
            Subscription::create([
                'user_id'    => $user->id,
                'plan_id'    => $plan->id,
                'payment_id' => $payment->id,
                'status'     => 'active',
                'starts_at'  => Carbon::now(),
                'ends_at'    => Carbon::now()->addDays($plan->duration_days),
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
