<?php

namespace App\Http\Controllers;

use App\Models\SubscriptionPlan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubscriptionPlanController extends Controller
{
    // All methods are admin-only — gate() is called at the top of each.

    public function index()
    {
        $this->gate();
        $plans = SubscriptionPlan::withCount('subscriptions')->orderBy('price')->get();
        return view('admin.plans.index', compact('plans'));
    }

    public function create()
    {
        $this->gate();
        return view('admin.plans.create');
    }

    public function store(Request $request)
    {
        $this->gate();

        $validated = $request->validate([
            'name'          => 'required|string|max:100|unique:subscriptionplans,name',
            'price'         => 'required|numeric|min:0',
            'duration_days' => 'required|integer|min:1',
            'features'      => 'nullable|string',
        ]);

        $plan = SubscriptionPlan::create($validated);

        return redirect()->route('admin.plans.index')
            ->with('success', 'Plan "' . $plan->name . '" has been created.');
    }

    public function edit(SubscriptionPlan $plan)
    {
        $this->gate();
        return view('admin.plans.edit', compact('plan'));
    }

    public function update(Request $request, SubscriptionPlan $plan)
    {
        $this->gate();

        $validated = $request->validate([
            'name'          => 'required|string|max:100|unique:subscriptionplans,name,' . $plan->id,
            'price'         => 'required|numeric|min:0',
            'duration_days' => 'required|integer|min:1',
            'features'      => 'nullable|string',
        ]);

        $plan->update($validated);

        return redirect()->route('admin.plans.index')
            ->with('success', 'Plan "' . $plan->name . '" has been updated.');
    }

    public function destroy(SubscriptionPlan $plan)
    {
        $this->gate();

        // Cannot delete a plan that still has active or queued subscribers
        $blockingStatuses = ['active', 'queued'];
        if ($plan->subscriptions()->whereIn('status', $blockingStatuses)->exists()) {
            return back()->with('error', 'Cannot delete a plan with active or queued subscribers.');
        }

        $name = $plan->name;
        $plan->delete();

        return redirect()->route('admin.plans.index')
            ->with('success', 'Plan "' . $name . '" has been deleted.');
    }

    private function gate(): void
    {
        abort_unless(Auth::check() && Auth::user()->isAdmin(), 403, 'Administrator access required.');
    }
}
