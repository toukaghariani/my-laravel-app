@extends('layouts.app')

@section('title', 'Register - WolfNet')

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
                    <h2 class="wn-auth-title">Create Account</h2>

                    <!-- Error messages -->
                    @if($errors->any())
                        <div class="alert wn-alert-danger">
                            @foreach($errors->all() as $error)
                                <p class="mb-0 small">{{ $error }}</p>
                            @endforeach
                        </div>
                    @endif

                    <form action="{{ url('/register') }}" method="POST">
                        @csrf

                        <!-- Name -->
                        <div class="mb-3">
                            <label class="wn-label">Full Name</label>
                            <input type="text"
                                   name="name"
                                   class="form-control wn-input"
                                   placeholder="John Doe"
                                   value="{{ old('name') }}"
                                   required>
                        </div>

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
                                       placeholder="Min. 8 characters"
                                       required>
                                <button class="btn wn-input-addon"
                                        type="button"
                                        onclick="togglePassword()">
                                    <i class="bi bi-eye" id="eyeIcon"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Confirm Password -->
                        <div class="mb-4">
                            <label class="wn-label">Confirm Password</label>
                            <input type="password"
                                   name="password_confirmation"
                                   class="form-control wn-input"
                                   placeholder="Repeat your password"
                                   required>
                        </div>

                        <!-- Submit -->
                        <button type="submit" class="btn wn-btn-primary w-100 py-2">
                            Create Account
                        </button>

                    </form>

                    <!-- Divider -->
                    <div class="wn-auth-divider">
                        <span>Already have an account?</span>
                    </div>

                    <!-- Login link -->
                    <a href="{{ url('/login') }}"
                       class="btn wn-btn-outline w-100 py-2">
                        Sign In
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