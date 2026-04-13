@extends('layouts.app')

@section('title', 'All Subscriptions — Admin — WolfNet')

@section('content')
<div class="pt-24 pb-12 px-4 md:px-12 max-w-screen-2xl mx-auto">
    <div class="flex items-center justify-between mb-8">
        <h1 class="text-3xl font-bold text-white">All Subscriptions</h1>
        <a href="{{ route('admin.dashboard') }}" class="btn-outline btn-sm">← Dashboard</a>
    </div>
    <div class="surface-card overflow-hidden">
        <table class="admin-table">
            <thead><tr><th>User</th><th>Plan</th><th>Status</th><th>Ends</th></tr></thead>
            <tbody>
                @forelse($subscriptions as $sub)
                    <tr>
                        <td class="text-white">{{ $sub->user->name ?? '—' }}</td>
                        <td>{{ $sub->plan->name ?? '—' }}</td>
                        <td>
                            @if($sub->isActive()) <span class="badge badge-free">Active</span>
                            @else <span class="badge bg-surface-500 text-gray-400 border border-surface-400">Expired</span>
                            @endif
                        </td>
                        <td>{{ $sub->ends_at->format('M d, Y') }}</td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="text-center text-gray-500 py-8">No subscriptions.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-6">{{ $subscriptions->links() }}</div>
</div>
@endsection
