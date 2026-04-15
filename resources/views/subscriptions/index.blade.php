@extends('layouts.app')

@section('title', 'My Subscription — WolfNet')

@section('content')
<div class="pt-24 pb-12 px-4 md:px-12 max-w-screen-2xl mx-auto">
    <div class="max-w-2xl mx-auto">
        <h1 class="text-3xl font-bold text-white mb-8">My Subscription</h1>

        {{-- Active --}}
        @if($active)
            <div class="surface-card p-6 mb-6">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-lg font-semibold text-white">Active Plan</h2>
                    <span class="badge badge-free">Active</span>
                </div>
                <div class="space-y-2 text-sm text-gray-400">
                    <p><span class="text-gray-500">Plan:</span> <span class="text-white">{{ $active->plan->name ?? '—' }}</span></p>
                    <p><span class="text-gray-500">Started:</span> {{ $active->starts_at->format('M d, Y') }}</p>
                    <p><span class="text-gray-500">Expires:</span> {{ $active->ends_at->format('M d, Y') }}</p>
                    <p><span class="text-gray-500">Days remaining:</span> <span class="text-white">{{ now()->diffInDays($active->ends_at) }}</span></p>
                </div>
                <form method="POST" action="{{ route('subscriptions.cancel') }}" class="mt-4" onsubmit="return confirm('Cancel your subscription?')">
                    @csrf
                    <button type="submit" class="btn-danger btn-sm">Cancel Subscription</button>
                </form>
            </div>
        @else
            <div class="surface-card p-6 mb-6 text-center">
                <p class="text-gray-500 mb-4">You don't have an active subscription.</p>
                <a href="{{ route('subscriptions.plans') }}" class="btn-primary btn-sm">Browse Plans</a>
            </div>
        @endif

        {{-- Queued --}}
        @if($queued)
            <div class="surface-card p-6">
                <h2 class="text-lg font-semibold text-white mb-4">Queued Subscription</h2>
                <div class="flex items-center justify-between py-2 px-3 bg-surface-600 rounded-md text-sm">
                    <span class="text-gray-300">{{ $queued->plan->name ?? '—' }}</span>
                    <span class="text-gray-500">Starts {{ $queued->starts_at->format('M d, Y') }}</span>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
