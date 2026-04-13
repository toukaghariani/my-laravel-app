@extends('layouts.app')

@section('title', 'Payment #' . $payment->id . ' — WolfNet')

@section('content')
<div class="pt-24 pb-12 px-4 md:px-12 max-w-screen-2xl mx-auto">
    <div class="max-w-lg mx-auto">
        <a href="{{ route('payments.index') }}" class="text-gray-500 hover:text-white text-sm mb-4 inline-flex items-center gap-1 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            Back to Payments
        </a>

        <div class="surface-card p-6">
            <h1 class="text-2xl font-bold text-white mb-6">Payment Details</h1>
            <dl class="space-y-4 text-sm">
                <div class="flex justify-between"><dt class="text-gray-500">Transaction ID</dt><dd class="text-white font-mono text-xs">{{ $payment->transaction_id ?? '—' }}</dd></div>
                <div class="flex justify-between"><dt class="text-gray-500">Plan</dt><dd class="text-white">{{ $payment->plan->name ?? '—' }}</dd></div>
                <div class="flex justify-between"><dt class="text-gray-500">Amount</dt><dd class="text-white">{{ number_format($payment->amount, 2) }} TND</dd></div>
                <div class="flex justify-between"><dt class="text-gray-500">Status</dt><dd>
                    @if($payment->status === 'completed')
                        <span class="badge badge-free">Completed</span>
                    @else
                        <span class="badge bg-surface-500 text-gray-400 border border-surface-400">{{ ucfirst($payment->status) }}</span>
                    @endif
                </dd></div>
                <div class="flex justify-between"><dt class="text-gray-500">Date</dt><dd class="text-gray-300">{{ $payment->created_at->format('M d, Y \a\t h:i A') }}</dd></div>
            </dl>
        </div>
    </div>
</div>
@endsection
