@extends('layouts.app')

@section('title', 'Payment History — WolfNet')

@section('content')
<div class="pt-24 pb-12 px-4 md:px-12 max-w-screen-2xl mx-auto">
    <div class="max-w-3xl mx-auto">
        <h1 class="text-3xl font-bold text-white mb-8">Payment History</h1>

        @if($payments->count())
            <div class="surface-card overflow-hidden">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Plan</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($payments as $payment)
                            <tr>
                                <td>{{ $payment->created_at->format('M d, Y') }}</td>
                                <td class="text-white">{{ $payment->plan->name ?? '—' }}</td>
                                <td>{{ number_format($payment->amount, 2) }} TND</td>
                                <td>
                                    @if($payment->status === 'completed')
                                        <span class="badge badge-free">Completed</span>
                                    @elseif($payment->status === 'pending')
                                        <span class="badge bg-yellow-500/20 text-yellow-400 border border-yellow-500/30">Pending</span>
                                    @else
                                        <span class="badge bg-red-500/20 text-red-400 border border-red-500/30">{{ ucfirst($payment->status) }}</span>
                                    @endif
                                </td>
                                <td class="text-right">
                                    <a href="{{ route('payments.show', $payment) }}" class="text-brand hover:text-brand-hover text-sm transition-colors">Details</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="mt-6">{{ $payments->links() }}</div>
        @else
            <div class="surface-card p-8 text-center">
                <p class="text-gray-500">No payments yet.</p>
            </div>
        @endif
    </div>
</div>
@endsection
