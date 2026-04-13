@extends('layouts.app')

@section('title', 'Checkout — WolfNet')

@section('content')
<div class="pt-24 pb-16 px-4 md:px-12 max-w-screen-2xl mx-auto">
    <div class="max-w-lg mx-auto">
        <div class="surface-card p-8">
            <h1 class="text-2xl font-bold text-white mb-6 text-center">Checkout</h1>

            @if(isset($plan))
                <div class="border-b border-surface-500 pb-6 mb-6">
                    <p class="text-gray-400 text-sm uppercase tracking-wider mb-2">Selected Plan</p>
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-lg font-semibold text-white">{{ $plan->name }}</h3>
                            <p class="text-sm text-gray-500">{{ $plan->duration_days }} days access</p>
                        </div>
                        <div class="text-right">
                            <span class="text-2xl font-bold text-white">{{ number_format($plan->price, 0) }}</span>
                            <span class="text-gray-500 text-sm ml-1">TND</span>
                        </div>
                    </div>
                </div>

                <ul class="space-y-2 mb-6 text-sm text-gray-400">
                    <li class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        Secure payment via Flouci
                    </li>
                    <li class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        Instant activation
                    </li>
                </ul>

                <form method="POST" action="{{ route('payment.checkout', $plan) }}">
                    @csrf
                    <button type="submit" class="btn-primary w-full text-base">
                        Proceed to Payment
                    </button>
                </form>

                <p class="text-center text-xs text-gray-600 mt-4">
                    By proceeding, you agree to our Terms of Service.
                </p>
            @else
                <div class="text-center py-8">
                    <p class="text-gray-500 mb-4">No plan selected.</p>
                    <a href="{{ route('subscriptions.plans') }}" class="btn-primary">View Plans</a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
