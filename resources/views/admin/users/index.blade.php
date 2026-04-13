@extends('layouts.app')

@section('title', 'Manage Users — Admin — WolfNet')

@section('content')
<div class="pt-24 pb-12 px-4 md:px-12 max-w-screen-2xl mx-auto">
    <div class="flex items-center justify-between mb-8">
        <h1 class="text-3xl font-bold text-white">Manage Users</h1>
        <a href="{{ route('admin.dashboard') }}" class="btn-outline btn-sm">← Dashboard</a>
    </div>

    <div class="surface-card overflow-hidden">
        <table class="admin-table">
            <thead><tr><th>Name</th><th>Email</th><th>Joined</th><th>Subscription</th><th class="text-right">Actions</th></tr></thead>
            <tbody>
                @forelse($users as $user)
                    <tr>
                        <td class="text-white font-medium">{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->created_at->format('M d, Y') }}</td>
                        <td>
                            @if($user->hasActiveSub()) <span class="badge badge-free">Active</span>
                            @else <span class="badge bg-surface-500 text-gray-400 border border-surface-400">None</span>
                            @endif
                        </td>
                        <td class="text-right">
                            <a href="{{ route('admin.users.show', $user) }}" class="text-brand hover:text-brand-hover text-sm transition-colors">View</a>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="text-center text-gray-500 py-8">No users.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-6">{{ $users->links() }}</div>
</div>
@endsection
