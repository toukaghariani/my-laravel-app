@extends('layouts.app')

@section('title', 'Sign In — WolfNet')

@section('content')
<div class="min-h-screen flex items-center justify-center pt-20 pb-12 px-4">
    <div class="w-full max-w-md">
        {{-- Card --}}
        <div class="surface-card p-8 md:p-10">
            <h1 class="text-3xl font-bold text-white mb-2">Sign In</h1>
            <p class="text-gray-500 text-sm mb-8">Welcome back to WolfNet</p>

            {{-- Session Status --}}
            @if(session('status'))
                <div class="mb-4 text-sm text-green-400 bg-green-900/30 border border-green-800 rounded-md px-4 py-3">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="space-y-5">
                @csrf

                {{-- Email --}}
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-300 mb-1.5">Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}"
                           class="input-dark" required autofocus autocomplete="username"
                           placeholder="you@example.com">
                    @error('email')
                        <p class="mt-1.5 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Password --}}
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-300 mb-1.5">Password</label>
                    <input id="password" type="password" name="password"
                           class="input-dark" required autocomplete="current-password"
                           placeholder="••••••••">
                    @error('password')
                        <p class="mt-1.5 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Remember + Forgot --}}
                <div class="flex items-center justify-between">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="remember"
                               class="rounded bg-surface-600 border-surface-400 text-brand focus:ring-brand/50 focus:ring-offset-0">
                        <span class="text-sm text-gray-400">Remember me</span>
                    </label>
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="text-sm text-brand hover:text-brand-hover transition-colors">
                            Forgot password?
                        </a>
                    @endif
                </div>

                {{-- Submit --}}
                <button type="submit" class="btn-primary w-full text-base">
                    Sign In
                </button>
            </form>

            {{-- Register link --}}
            <p class="mt-6 text-center text-sm text-gray-500">
                New to WolfNet?
                <a href="{{ route('register') }}" class="text-white hover:text-brand transition-colors font-medium">Create an account</a>
            </p>
        </div>
    </div>
</div>
@endsection
