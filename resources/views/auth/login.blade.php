@extends('layouts.app')

@section('title', 'Sign In - WolfNet')

@section('content')

<section class="wn-auth-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5 col-lg-4">

                <!-- Logo -->
                <div class="text-center mb-4">
                    <a href="{{ url('/') }}" class="wn-logo fs-2">WOLF<span>NET</span></a>
                </div>

                <!-- Card -->
                <div class="wn-auth-card">
                    <h2 class="wn-auth-title">Sign In</h2>

                    <!-- Error messages -->
                    @if($errors->any())
                        <div class="alert wn-alert-danger">
                            @foreach($errors->all() as $error)
                                <p class="mb-0 small">{{ $error }}</p>
                            @endforeach
                        </div>
                    @endif

                    <!-- Success message -->
                    @if(session('success'))
                        <div class="alert wn-alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form action="{{ url('/login') }}" method="POST">
                        @csrf

                        <!-- Email -->
                        <div class="mb-3">
                            <label class="wn-label">Email address</label>
                            <input type="email"
                                   name="email"
                                   class="form-control wn-input"
                                   placeholder="you@example.com"
                                   value="{{ old('email') }}"
                                   required>
                        </div>

                        <!-- Password -->
                        <div class="mb-3">
                            <label class="wn-label">Password</label>
                            <div class="input-group">
                                <input type="password"
                                       name="password"
                                       id="passwordField"
                                       class="form-control wn-input"
                                       placeholder="••••••••"
                                       required>
                                <button class="btn wn-input-addon"
                                        type="button"
                                        onclick="togglePassword()">
                                    <i class="bi bi-eye" id="eyeIcon"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Remember me -->
                        <div class="mb-4 d-flex align-items-center">
                            <input type="checkbox"
                                   name="remember"
                                   id="remember"
                                   class="wn-checkbox me-2">
                            <label for="remember" class="wn-label mb-0">Remember me</label>
                        </div>

                        <!-- Submit -->
                        <button type="submit" class="btn wn-btn-primary w-100 py-2">
                            Sign In
                        </button>

                    </form>

                    <!-- Divider -->
                    <div class="wn-auth-divider">
                        <span>New to WolfNet?</span>
                    </div>

                    <!-- Register link -->
                    <a href="{{ url('/register') }}"
                       class="btn wn-btn-outline w-100 py-2">
                        Create an account
                    </a>

                </div>
            </div>
        </div>
    </div>
</section>

@endsection

@section('scripts')
<script>
    function togglePassword() {
        const field = document.getElementById('passwordField');
        const icon = document.getElementById('eyeIcon');
        if (field.type === 'password') {
            field.type = 'text';
            icon.classList.replace('bi-eye', 'bi-eye-slash');
        } else {
            field.type = 'password';
            icon.classList.replace('bi-eye-slash', 'bi-eye');
        }
    }
</script>
@endsection