<?php

namespace App\Http\Controllers;

use App\Models\Content;
use App\Models\Payment;
use App\Models\Subscription;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    // dashboard

    public function dashboard()
    {
        $this->gate();

        $stats = [
            'total_users'        => User::count(),
            'active_users'       => User::where('status', 'active')->count(),
            'suspended_users'    => User::where('status', 'suspended')->count(),
            'total_content'      => Content::count(),
            'premium_content'    => Content::where('is_premium', true)->count(),
            'active_subs'        => Subscription::where('status', 'active')
                                                ->where('ends_at', '>', now())
                                                ->count(),
            'revenue_total'      => Payment::where('status', 'confirmed')->sum('amount'),
            'revenue_this_month' => Payment::where('status', 'confirmed')
                                           ->whereMonth('created_at', now()->month)
                                           ->whereYear('created_at', now()->year)
                                           ->sum('amount'),
        ];

        $recentUsers = User::latest()->limit(5)->get();

        return view('admin.dashboard', compact('stats', 'recentUsers'));
    }

    // user management

    // list all users with optional search or filter
    public function manageUsers(Request $request)
    {
        $this->gate();

        $query = User::query();

        if ($request->filled('search')) {
            $term = $request->search;
            $query->where(fn ($q) =>
                $q->where('name', 'like', "%{$term}%")
                  ->orWhere('email', 'like', "%{$term}%")
            );
        }

        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $users = $query->latest()->paginate(25)->withQueryString();

        return view('admin.users.index', compact('users'));
    }

    // show one user's full profile (admin view)

    public function showUser(User $user)
    {
        $this->gate();
        $user->load(['subscriptions.plan', 'payments.plan']);
        return view('admin.users.show', compact('user'));
    }

    // suspend a user account

    public function suspendUser(User $user)
    {
        $this->gate();

        if ($user->id === Auth::id()) {
            return back()->with('error', 'You cannot suspend your own account.');
        }

        $user->update(['status' => 'suspended']);

        return back()->with('success', $user->name . ' has been suspended.');
    }

    // reactivate a suspended user account

    public function reactivateUser(User $user)
    {
        $this->gate();

        $user->update(['status' => 'active']);

        return back()->with('success', $user->name . "'s account has been reactivated.");
    }


    private function gate(): void
    {
        abort_unless(Auth::check() && Auth::user()->isAdmin(), 403, 'Administrator access required.');
    }
}
