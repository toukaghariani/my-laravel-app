@extends('layouts.app')

@section('title', 'Manage Plans — Admin — WolfNet')

@section('content')
<div class="pt-24 pb-12 px-4 md:px-12 max-w-screen-2xl mx-auto">
    <div class="flex items-center justify-between mb-8">
        <h1 class="text-3xl font-bold text-white">Subscription Plans</h1>
        <div class="flex gap-2">
            <a href="{{ route('admin.dashboard') }}" class="btn-outline btn-sm">← Dashboard</a>
            <a href="{{ route('admin.plans.create') }}" class="btn-primary btn-sm">+ Add Plan</a>
        </div>
    </div>
    <div class="surface-card overflow-hidden">
        <table class="admin-table">
            <thead><tr><th>Name</th><th>Price</th><th>Duration</th><th class="text-right">Actions</th></tr></thead>
            <tbody>
                @forelse($plans as $plan)
                    <tr>
                        <td class="text-white font-medium">{{ $plan->name }}</td>
                        <td>{{ number_format($plan->price, 2) }} TND</td>
                        <td>{{ $plan->duration_days }} days</td>
                        <td class="text-right flex items-center justify-end gap-3">
                            <a href="{{ route('admin.plans.edit', $plan) }}" class="text-gray-400 hover:text-white transition-colors"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg></a>
                            <form method="POST" action="{{ route('admin.plans.destroy', $plan) }}" onsubmit="return confirm('Delete?')">@csrf @method('DELETE')<button class="text-gray-400 hover:text-red-400 transition-colors"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg></button></form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="text-center text-gray-500 py-8">No plans configured.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
