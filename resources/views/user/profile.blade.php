@extends('layouts.app')

@section('title', 'Profile — WolfNet')

@section('content')
<div class="pt-24 pb-12 px-4 md:px-12 max-w-screen-2xl mx-auto">
    <div class="max-w-2xl mx-auto">

        {{-- Header --}}
        <div class="flex items-center gap-4 mb-10">
            <div class="w-16 h-16 rounded-full bg-gradient-to-br from-brand to-red-700 flex items-center justify-center text-white font-bold text-2xl ring-2 ring-white/10">
                {{ strtoupper(substr($user->name, 0, 1)) }}
            </div>
            <div>
                <h1 class="text-2xl font-bold text-white">{{ $user->name }}</h1>
                <p class="text-gray-500 text-sm">{{ $user->email }}</p>
            </div>
        </div>

        {{-- Profile Form --}}
        <div class="surface-card p-6 md:p-8">
            <h2 class="text-lg font-semibold text-white mb-6">Edit Profile</h2>

            <form method="POST" action="{{ route('user.profile.update') }}" class="space-y-5">
                @csrf
                @method('PUT')

                {{-- Name --}}
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-300 mb-1.5">Name</label>
                    <input id="name" type="text" name="name" value="{{ old('name', $user->name) }}"
                           class="input-dark" required>
                    @error('name')
                        <p class="mt-1.5 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Email (read-only) --}}
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-1.5">Email</label>
                    <input type="email" value="{{ $user->email }}"
                           class="input-dark !bg-surface-800 !text-gray-500 cursor-not-allowed" disabled>
                    <p class="mt-1 text-xs text-gray-600">Email cannot be changed.</p>
                </div>

                {{-- New Password --}}
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-300 mb-1.5">New Password</label>
                    <input id="password" type="password" name="password"
                           class="input-dark" autocomplete="new-password"
                           placeholder="Leave blank to keep current">
                    @error('password')
                        <p class="mt-1.5 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Confirm Password --}}
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-300 mb-1.5">Confirm New Password</label>
                    <input id="password_confirmation" type="password" name="password_confirmation"
                           class="input-dark" autocomplete="new-password"
                           placeholder="Repeat new password">
                </div>

                <div class="pt-2">
                    <button type="submit" class="btn-primary">Save Changes</button>
                </div>
            </form>
        </div>

        {{-- Subscription Info --}}
        <div class="surface-card p-6 md:p-8 mt-6">
            <h2 class="text-lg font-semibold text-white mb-4">Subscription</h2>
            @if($user->hasActiveSub())
                @php $sub = $user->currentSubscription(); @endphp
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-white font-medium">{{ $sub->plan->name ?? 'Premium' }}</p>
                        <p class="text-sm text-gray-500">Expires {{ $sub->ends_at->format('M d, Y') }}</p>
                    </div>
                    <span class="badge badge-free">Active</span>
                </div>
            @else
                <p class="text-gray-500 mb-4">You don't have an active subscription.</p>
                <a href="{{ route('subscriptions.plans') }}" class="btn-primary btn-sm">View Plans</a>
            @endif
        </div>

        {{-- Quick Links --}}
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mt-6">
            <a href="{{ route('watchlist.index') }}" class="surface-card p-5 text-center hover:bg-surface-600 transition-colors group">
                <svg class="w-6 h-6 text-gray-500 group-hover:text-brand mx-auto mb-2 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/></svg>
                <span class="text-sm text-gray-300 group-hover:text-white transition-colors">My List</span>
            </a>
            <a href="{{ route('watchhistory.index') }}" class="surface-card p-5 text-center hover:bg-surface-600 transition-colors group">
                <svg class="w-6 h-6 text-gray-500 group-hover:text-brand mx-auto mb-2 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <span class="text-sm text-gray-300 group-hover:text-white transition-colors">Watch History</span>
            </a>
            <a href="{{ route('payments.index') }}" class="surface-card p-5 text-center hover:bg-surface-600 transition-colors group">
                <svg class="w-6 h-6 text-gray-500 group-hover:text-brand mx-auto mb-2 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                <span class="text-sm text-gray-300 group-hover:text-white transition-colors">Payments</span>
            </a>
        </div>
    </div>
</div>
@endsection
