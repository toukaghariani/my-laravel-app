<?php
/*
 * Created At: 2026-04-14T20:42:00Z
 * Author: Antigravity
 */

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\SubscriptionPlan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Stripe\Stripe;
use Stripe\Webhook;

class StripeWebhookController extends Controller
{
    /**
     * Handle the incoming Stripe webhook request.
     */
    public function handle(Request $request)
    {
        Stripe::setApiKey(config('services.stripe.secret'));

        $endpointSecret = config('services.stripe.webhook_secret');
        $payload = $request->getContent();
        $sigHeader = $request->header('Stripe-Signature');
        $event = null;

        try {
            // Verify signature (if secret is provided)
            if ($endpointSecret) {
                $event = Webhook::constructEvent($payload, $sigHeader, $endpointSecret);
            } else {
                // FALLBACK: Use payload directly if secret is not set (not recommended for production)
                $event = json_decode($payload);
            }
        } catch (\UnexpectedValueException $e) {
            Log::error('Webhook - Invalid Payload', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Invalid payload'], 400);
        } catch (\Stripe\Exception\SignatureVerificationException $e) {
            Log::error('Webhook - Signature Verification Failed', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Invalid signature'], 400);
        }

        // Handle the event
        switch ($event->type ?? $event->type) {
            case 'checkout.session.completed':
                $session = $event->data->object;
                $this->handleCheckoutSessionCompleted($session);
                break;

            default:
                Log::info('Webhook - Unhandled event type', ['type' => $event->type]);
        }

        return response()->json(['status' => 'success']);
    }

    /**
     * Process a successful checkout session.
     */
    protected function handleCheckoutSessionCompleted($session)
    {
        $payment = Payment::where('transaction_id', $session->id)->first();

        if (!$payment) {
            Log::error('Webhook - Payment record not found', ['session_id' => $session->id]);
            return;
        }

        if ($payment->status === 'confirmed') {
            Log::info('Webhook - Payment already confirmed', ['session_id' => $session->id]);
            return;
        }

        // Update payment status
        $payment->update([
            'status' => 'confirmed',
            'metadata' => array_merge($payment->metadata ?? [], [
                'stripe_customer' => $session->customer,
                'stripe_payment_intent' => $session->payment_intent,
            ])
        ]);

        // Activate subscription
        $user = User::find($payment->user_id);
        $plan = SubscriptionPlan::find($payment->plan_id);

        if ($user && $plan) {
            // Reuse the existing subscription logic from PaymentController
            (new PaymentController())->subscribe($user, $plan, $payment);
            Log::info('Webhook - Subscription activated', ['user_id' => $user->id, 'session_id' => $session->id]);
        } else {
            Log::error('Webhook - User or Plan missing', ['user_id' => $payment->user_id, 'plan_id' => $payment->plan_id]);
        }
    }
}
