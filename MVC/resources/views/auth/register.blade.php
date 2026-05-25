@extends('layouts.app')

@section('title', 'Register')

@push('styles')
<style>
    .auth-container {
        padding: 12rem 0 8rem;
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 80vh;
    }

    .auth-card {
        background: var(--bg-card);
        border: 1px solid var(--border-color);
        padding: 4rem;
        border-radius: 4px;
        width: 100%;
        max-width: 500px;
        box-shadow: 0 30px 60px rgba(0,0,0,0.4);
    }

    .auth-title {
        font-size: 2.5rem;
        color: var(--text-primary);
        margin-bottom: 2rem;
        text-align: center;
    }

    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-label {
        display: block;
        margin-bottom: 0.5rem;
        color: var(--text-secondary);
        font-family: var(--font-heading);
    }

    .form-control {
        width: 100%;
        background: transparent;
        border: none;
        border-bottom: 1px solid var(--border-color);
        padding: 1rem 0;
        color: var(--text-primary);
        font-size: 1.1rem;
        font-family: var(--font-body);
        outline: none;
        transition: var(--transition-smooth);
    }

    .form-control:focus {
        border-bottom-color: var(--accent);
    }

    .error-msg {
        color: #ff4757;
        font-size: 0.9rem;
        margin-top: 0.5rem;
        display: block;
    }
</style>
@endpush

@section('content')
    <div class="container auth-container">
        <div class="auth-card gsap-reveal">
            <h1 class="auth-title">Create Account</h1>
            
            <form action="{{ route('register') }}" method="POST">
                @csrf
                
                <div class="form-group">
                    <label class="form-label" for="name">Full Name</label>
                    <input type="text" id="name" name="name" class="form-control" value="{{ old('name') }}" required autofocus>
                    @error('name')
                        <span class="error-msg">{{ $message }}</span>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label class="form-label" for="email">Email Address</label>
                    <input type="email" id="email" name="email" class="form-control" value="{{ old('email') }}" required>
                    @error('email')
                        <span class="error-msg">{{ $message }}</span>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label class="form-label" for="password">Password</label>
                    <input type="password" id="password" name="password" class="form-control" required>
                    @error('password')
                        <span class="error-msg">{{ $message }}</span>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label class="form-label" for="password_confirmation">Confirm Password</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" required>
                </div>
                
                <div style="margin-top: 3rem;">
                    <button type="submit" class="btn-primary" style="width: 100%;">Sign Up</button>
                </div>
                
                <div style="text-align: center; margin-top: 2rem;">
                    <span class="text-secondary">Already have an account? </span>
                    <a href="{{ route('login') }}" style="color: var(--accent); text-decoration: none;">Login</a>
                </div>
            </form>
        </div>
    </div>
@endsection
