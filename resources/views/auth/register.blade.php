@extends('layouts.app')

@section('title', 'Create Account — WolfNet')

@section('content')
<div class="min-h-screen flex items-center justify-center pt-20 pb-12 px-4">
    <div class="w-full max-w-md">
        <div class="surface-card p-8 md:p-10">
            <h1 class="text-3xl font-bold text-white mb-2">Create Account</h1>
            <p class="text-gray-500 text-sm mb-8">Join WolfNet and start streaming</p>

            <form method="POST" action="{{ route('register') }}" class="space-y-5">
                @csrf

                {{-- Name --}}
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-300 mb-1.5">Name</label>
                    <input id="name" type="text" name="name" value="{{ old('name') }}"
                           class="input-dark" required autofocus autocomplete="name"
                           placeholder="Your name">
                    @error('name')
                        <p class="mt-1.5 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Email --}}
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-300 mb-1.5">Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}"
                           class="input-dark" required autocomplete="username"
                           placeholder="you@example.com">
                    @error('email')
                        <p class="mt-1.5 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Password --}}
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-300 mb-1.5">Password</label>
                    <input id="password" type="password" name="password"
                           class="input-dark" required autocomplete="new-password"
                           placeholder="Min 8 characters">
                    @error('password')
                        <p class="mt-1.5 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Confirm Password --}}
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-300 mb-1.5">Confirm Password</label>
                    <input id="password_confirmation" type="password" name="password_confirmation"
                           class="input-dark" required autocomplete="new-password"
                           placeholder="Repeat password">
                    @error('password_confirmation')
                        <p class="mt-1.5 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Submit --}}
                <button type="submit" class="btn-primary w-full text-base">
                    Create Account
                </button>
            </form>

            <p class="mt-6 text-center text-sm text-gray-500">
                Already have an account?
                <a href="{{ route('login') }}" class="text-white hover:text-brand transition-colors font-medium">Sign in</a>
            </p>
        </div>
    </div>
</div>
@endsection
