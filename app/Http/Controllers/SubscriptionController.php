<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
use App\Models\SubscriptionPlan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubscriptionController extends Controller
{

    //plan listing

    public function plans()
    {
        $plans = SubscriptionPlan::orderBy('price')->get();
        return view('subscriptions.plans', compact('plans'));
    }

    //user sub management

    public function index()
    {
        $user   = Auth::user();
        $active = $user->currentSubscription()?->load('plan');
        $queued = $user->queuedSubscription()?->load('plan');

        return view('subscriptions.index', compact('active', 'queued'));
    }

    //Cancel the user's active subscription IMMEDIATELY.

    public function cancel()
    {
        $user         = Auth::user();
        $subscription = $user->currentSubscription();

        if (!$subscription) {
            return redirect()->route('subscriptions.index')
                ->with('warning', 'No active subscription found to cancel.');
        }

        // immediate cancellation
        $subscription->update(['status' => 'cancelled']);

        return redirect()->route('subscriptions.index')
            ->with('success', 'Your subscription has been cancelled. Premium access has been revoked immediately.');
    }

    // subscription overview(admin)

    public function adminIndex()
    {
        abort_unless(Auth::user()?->isAdmin(), 403);

        $subscriptions = Subscription::with(['user', 'plan'])
            ->latest()
            ->paginate(30);

        return view('admin.subscriptions.index', compact('subscriptions'));
    }
}
