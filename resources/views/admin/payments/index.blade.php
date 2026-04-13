@extends('layouts.app')

@section('title', 'All Payments — Admin — WolfNet')

@section('content')
<div class="pt-24 pb-12 px-4 md:px-12 max-w-screen-2xl mx-auto">
    <div class="flex items-center justify-between mb-8">
        <h1 class="text-3xl font-bold text-white">All Payments</h1>
        <a href="{{ route('admin.dashboard') }}" class="btn-outline btn-sm">← Dashboard</a>
    </div>
    <div class="surface-card overflow-hidden">
        <table class="admin-table">
            <thead><tr><th>User</th><th>Plan</th><th>Amount</th><th>Status</th><th>Date</th></tr></thead>
            <tbody>
                @forelse($payments as $payment)
                    <tr>
                        <td class="text-white">{{ $payment->user->name ?? '—' }}</td>
                        <td>{{ $payment->plan->name ?? '—' }}</td>
                        <td>{{ number_format($payment->amount, 2) }} TND</td>
                        <td>
                            @if($payment->status === 'completed') <span class="badge badge-free">Completed</span>
                            @else <span class="badge bg-surface-500 text-gray-400 border border-surface-400">{{ ucfirst($payment->status) }}</span>
                            @endif
                        </td>
                        <td>{{ $payment->created_at->format('M d, Y') }}</td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="text-center text-gray-500 py-8">No payments.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-6">{{ $payments->links() }}</div>
</div>
@endsection
