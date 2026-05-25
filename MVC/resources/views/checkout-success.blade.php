@extends('layouts.app')

@section('title', 'Order Complete')

@push('styles')
<style>
    .success-container {
        padding: 15rem 0 10rem;
        text-align: center;
        min-height: 80vh;
    }

    .success-icon {
        font-size: 5rem;
        color: var(--accent);
        margin-bottom: 2rem;
    }

    .success-title {
        font-size: 3rem;
        color: var(--text-primary);
        font-family: var(--font-heading);
        margin-bottom: 1rem;
    }

    .success-text {
        font-size: 1.2rem;
        color: var(--text-secondary);
        max-width: 600px;
        margin: 0 auto 3rem;
        line-height: 1.6;
    }
</style>
@endpush

@section('content')
    <div class="container success-container gsap-reveal">
        <div class="success-icon">✦</div>
        <h1 class="success-title">Order Confirmed</h1>
        <p class="success-text">Thank you for your purchase. Your exquisite wooden piece is now being prepared for shipping. You will receive an email confirmation shortly.</p>
        
        <a href="{{ url('/') }}" class="btn-primary" style="margin-right: 1rem;">Return Home</a>
        @auth
        <a href="{{ route('dashboard') }}" class="btn-primary" style="background: transparent; border: 1px solid var(--accent); color: var(--accent);">View Orders</a>
        @endauth
    </div>
@endsection
