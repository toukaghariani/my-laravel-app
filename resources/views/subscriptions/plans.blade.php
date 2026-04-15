@extends('layouts.app')

@section('title', 'Plans & Pricing — WolfNet')

@section('content')
    <div class="pt-24 pb-16 px-4 md:px-12 max-w-screen-2xl mx-auto">

        {{-- Header --}}
        <div class="text-center mb-12">
            <h1 class="text-4xl md:text-5xl font-extrabold text-white mb-4">Choose Your Plan</h1>
            <p class="text-gray-400 text-lg max-w-xl mx-auto">Unlock premium content, ad-free streaming, and unlimited
                access to our full library.</p>
        </div>

        {{-- Plans Grid --}}
        @if($plans->count())
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 max-w-5xl mx-auto">
                @foreach($plans as $index => $plan)
                    <div
                        class="relative surface-card p-8 flex flex-col items-center text-center transition-all duration-300 hover:border-brand/50 hover:shadow-lg hover:shadow-brand/5 {{ $index === 1 ? 'ring-2 ring-brand' : '' }}">
                        {{-- Popular badge --}}
                        @if($index === 1)
                            <div class="absolute -top-3 left-1/2 -translate-x-1/2">
                                <span class="bg-brand text-white text-xs font-bold px-4 py-1 rounded-full uppercase tracking-wider">Most
                                    Popular</span>
                            </div>
                        @endif

                        <h3 class="text-xl font-bold text-white mb-2 mt-2">{{ $plan->name }}</h3>

                        <div class="mb-6">
                            <span class="text-4xl font-extrabold text-white">{{ number_format($plan->price, 0) }}</span>
                            <span class="text-gray-500 text-sm ml-1">TND</span>
                            <p class="text-gray-500 text-sm mt-1">{{ $plan->duration_days }} days</p>
                        </div>

                        {{-- Features --}}
                        <ul class="space-y-3 mb-8 text-sm text-gray-400 w-full">
                            <li class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-green-500 flex-shrink-0" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                Access all premium content
                            </li>
                            <li class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-green-500 flex-shrink-0" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                HD streaming quality
                            </li>
                            <li class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-green-500 flex-shrink-0" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                Watch on any device
                            </li>
                        </ul>

                        @auth
                            <form method="POST" action="{{ route('payment.checkout', $plan) }}" class="w-full">
                                @csrf
                                <button type="submit" class="{{ $index === 1 ? 'btn-primary' : 'btn-outline' }} w-full">
                                    Subscribe Now
                                </button>
                            </form>
                        @else
                            <a href="{{ route('register') }}" class="{{ $index === 1 ? 'btn-primary' : 'btn-outline' }} w-full">
                                Get Started
                            </a>
                        @endauth
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-16">
                <p class="text-gray-500 text-lg">No plans available at the moment.</p>
            </div>
        @endif

        {{-- FAQ-like section --}}
        <div class="max-w-2xl mx-auto mt-16 text-center">
            <h2 class="text-2xl font-bold text-white mb-4">Questions?</h2>
            <p class="text-gray-500">All subscriptions include full access to our premium library. Cancel anytime. Payments
                are processed securely through Stripe.</p>
        </div>
    </div>
@endsection