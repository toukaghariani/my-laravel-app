@extends('layouts.app')

@section('title', 'Create Plan — Admin — WolfNet')

@section('content')
<div class="pt-24 pb-12 px-4 md:px-12 max-w-screen-2xl mx-auto">
    <div class="max-w-lg mx-auto">
        <h1 class="text-2xl font-bold text-white mb-6">Create Plan</h1>
        <div class="surface-card p-6">
            <form method="POST" action="{{ route('admin.plans.store') }}" class="space-y-5">
                @csrf
                <div><label class="block text-sm text-gray-300 mb-1">Name</label><input type="text" name="name" value="{{ old('name') }}" class="input-dark" required>@error('name')<p class="mt-1 text-sm text-red-400">{{ $message }}</p>@enderror</div>
                <div><label class="block text-sm text-gray-300 mb-1">Price (TND)</label><input type="number" step="0.01" name="price" value="{{ old('price') }}" class="input-dark" required>@error('price')<p class="mt-1 text-sm text-red-400">{{ $message }}</p>@enderror</div>
                <div><label class="block text-sm text-gray-300 mb-1">Duration (days)</label><input type="number" name="duration_days" value="{{ old('duration_days') }}" class="input-dark" required>@error('duration_days')<p class="mt-1 text-sm text-red-400">{{ $message }}</p>@enderror</div>
                <div class="flex gap-3"><button type="submit" class="btn-primary">Create</button><a href="{{ route('admin.plans.index') }}" class="btn-outline btn-sm">Cancel</a></div>
            </form>
        </div>
    </div>
</div>
@endsection
