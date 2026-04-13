@extends('layouts.app')

@section('title', $user->name . ' — Admin — WolfNet')

@section('content')
<div class="pt-24 pb-12 px-4 md:px-12 max-w-screen-2xl mx-auto">
    <div class="max-w-2xl mx-auto">
        <a href="{{ route('admin.users') }}" class="text-gray-500 hover:text-white text-sm mb-4 inline-flex items-center gap-1 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            Back to Users
        </a>

        <div class="surface-card p-6">
            <div class="flex items-center gap-4 mb-6">
                <div class="w-14 h-14 rounded-full bg-gradient-to-br from-brand to-red-700 flex items-center justify-center text-white font-bold text-xl">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </div>
                <div>
                    <h1 class="text-2xl font-bold text-white">{{ $user->name }}</h1>
                    <p class="text-gray-500 text-sm">{{ $user->email }}</p>
                </div>
            </div>
            <dl class="space-y-3 text-sm mb-6">
                <div class="flex justify-between"><dt class="text-gray-500">Joined</dt><dd class="text-gray-300">{{ $user->created_at->format('M d, Y') }}</dd></div>
                <div class="flex justify-between"><dt class="text-gray-500">Role</dt><dd>{{ $user->isAdmin() ? 'Admin' : 'User' }}</dd></div>
                <div class="flex justify-between"><dt class="text-gray-500">Subscription</dt><dd>
                    @if($user->hasActiveSub()) <span class="badge badge-free">Active</span>
                    @else <span class="text-gray-500">None</span>
                    @endif
                </dd></div>
            </dl>
            <div class="flex gap-2">
                @if($user->status !== 'suspended')
                    <form method="POST" action="{{ route('admin.users.suspend', $user) }}" onsubmit="return confirm('Suspend this user?')">@csrf<button class="btn-danger btn-sm">Suspend</button></form>
                @else
                    <form method="POST" action="{{ route('admin.users.reactivate', $user) }}">@csrf<button class="btn-primary btn-sm">Reactivate</button></form>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
