@extends('layouts.app')

@section('title', 'Admin Dashboard — WolfNet')

@section('content')
<div class="pt-24 pb-12 px-4 md:px-12 max-w-screen-2xl mx-auto">

    {{-- Header --}}
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-3xl font-bold text-white mb-1">Admin Dashboard</h1>
            <p class="text-gray-500 text-sm">Overview of your platform</p>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('admin.content.index') }}" class="btn-outline btn-sm">Manage Videos</a>
            <a href="{{ route('admin.users') }}" class="btn-outline btn-sm">Manage Users</a>
        </div>
    </div>

    {{-- Stats Grid --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-10">
        <div class="surface-card p-5">
            <p class="text-xs text-gray-500 uppercase tracking-wider mb-1">Total Users</p>
            <p class="text-3xl font-bold text-white">{{ number_format($stats['users'] ?? 0) }}</p>
        </div>
        <div class="surface-card p-5">
            <p class="text-xs text-gray-500 uppercase tracking-wider mb-1">Total Content</p>
            <p class="text-3xl font-bold text-white">{{ number_format($stats['content'] ?? 0) }}</p>
        </div>
        <div class="surface-card p-5">
            <p class="text-xs text-gray-500 uppercase tracking-wider mb-1">Active Subs</p>
            <p class="text-3xl font-bold text-brand">{{ number_format($stats['subscriptions'] ?? 0) }}</p>
        </div>
        <div class="surface-card p-5">
            <p class="text-xs text-gray-500 uppercase tracking-wider mb-1">Revenue</p>
            <p class="text-3xl font-bold text-green-400">{{ number_format($stats['revenue'] ?? 0) }} <span class="text-sm text-gray-500">TND</span></p>
        </div>
    </div>

    {{-- Recent Users --}}
    <div class="surface-card overflow-hidden">
        <div class="px-6 py-4 border-b border-surface-500 flex items-center justify-between">
            <h2 class="text-lg font-semibold text-white">Recent Users</h2>
            <a href="{{ route('admin.users') }}" class="text-sm text-brand hover:text-brand-hover transition-colors">View All</a>
        </div>
        <div class="overflow-x-auto">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Joined</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentUsers as $user)
                        <tr>
                            <td class="font-medium text-white">{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->created_at->format('M d, Y') }}</td>
                            <td>
                                @if($user->hasActiveSub())
                                    <span class="badge badge-free">Subscribed</span>
                                @else
                                    <span class="badge bg-surface-500 text-gray-400 border border-surface-400">Free</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="text-center text-gray-500 py-8">No users yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Admin Quick Links --}}
    <div class="grid grid-cols-2 md:grid-cols-6 gap-4 mt-8">
        <a href="{{ route('admin.tmdb.search') }}" class="surface-card p-5 text-center hover:bg-surface-600 transition-colors group ring-1 ring-brand/20">
            <svg class="w-7 h-7 text-brand group-hover:text-brand-hover mx-auto mb-2 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
            <span class="text-sm text-gray-300 group-hover:text-white transition-colors">Search TMDB</span>
        </a>
        <form method="POST" action="{{ route('admin.tmdb.import-trending') }}" class="surface-card hover:bg-surface-600 transition-colors group ring-1 ring-brand/20">
            @csrf
            <button type="submit" class="w-full h-full p-5 text-center appearance-none">
                <svg class="w-7 h-7 text-brand group-hover:text-brand-hover mx-auto mb-2 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
                <span class="text-sm text-gray-300 group-hover:text-white transition-colors">Import Trending</span>
            </button>
        </form>
        <a href="{{ route('admin.content.index') }}" class="surface-card p-5 text-center hover:bg-surface-600 transition-colors group">
            <svg class="w-7 h-7 text-gray-500 group-hover:text-brand mx-auto mb-2 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 4v16M17 4v16M3 8h4m10 0h4M3 12h18M3 16h4m10 0h4M4 20h16a1 1 0 001-1V5a1 1 0 00-1-1H4a1 1 0 00-1 1v14a1 1 0 001 1z"/></svg>
            <span class="text-sm text-gray-300 group-hover:text-white transition-colors">Videos</span>
        </a>
        <a href="{{ route('admin.plans.index') }}" class="surface-card p-5 text-center hover:bg-surface-600 transition-colors group">
            <svg class="w-7 h-7 text-gray-500 group-hover:text-brand mx-auto mb-2 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
            <span class="text-sm text-gray-300 group-hover:text-white transition-colors">Plans</span>
        </a>
        <a href="{{ route('admin.subscriptions') }}" class="surface-card p-5 text-center hover:bg-surface-600 transition-colors group">
            <svg class="w-7 h-7 text-gray-500 group-hover:text-brand mx-auto mb-2 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <span class="text-sm text-gray-300 group-hover:text-white transition-colors">Subscriptions</span>
        </a>
        <a href="{{ route('admin.payments') }}" class="surface-card p-5 text-center hover:bg-surface-600 transition-colors group">
            <svg class="w-7 h-7 text-gray-500 group-hover:text-brand mx-auto mb-2 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"/></svg>
            <span class="text-sm text-gray-300 group-hover:text-white transition-colors">Payments</span>
        </a>
    </div>
</div>
@endsection
