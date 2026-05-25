@extends('layouts.app')

@section('title', 'Wholesale & B2B Inquiries')

@push('styles')
<style>
    .b2b-container {
        padding: 10rem 0 8rem;
        max-width: 800px;
        margin: 0 auto;
    }

    .b2b-header {
        text-align: center;
        margin-bottom: 4rem;
    }

    .b2b-title {
        font-size: 3rem;
        color: var(--text-primary);
        margin-bottom: 1rem;
    }

    .form-group {
        margin-bottom: 2rem;
    }

    .form-label {
        display: block;
        margin-bottom: 0.5rem;
        color: var(--text-secondary);
        font-family: var(--font-heading);
        font-size: 1.1rem;
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

    textarea.form-control {
        resize: vertical;
        min-height: 120px;
    }

    .alert-success {
        background: rgba(212, 175, 55, 0.1);
        border: 1px solid var(--accent);
        color: var(--accent);
        padding: 1rem;
        margin-bottom: 2rem;
        border-radius: 4px;
    }
</style>
@endpush

@section('content')
    <div class="container b2b-container">
        <div class="b2b-header gsap-reveal">
            <h1 class="b2b-title">Partner with Us</h1>
            <p class="text-secondary">Elevate your retail collection with our luxury wooden toys and hampers.</p>
        </div>

        @if(session('success'))
            <div class="alert-success gsap-reveal">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ url('/b2b') }}" method="POST" class="gsap-reveal">
            @csrf
            <div class="form-group">
                <label class="form-label" for="name">Contact Name</label>
                <input type="text" id="name" name="name" class="form-control" required>
            </div>
            
            <div class="form-group">
                <label class="form-label" for="company">Company Name</label>
                <input type="text" id="company" name="company" class="form-control" required>
            </div>
            
            <div class="form-group">
                <label class="form-label" for="email">Email Address</label>
                <input type="email" id="email" name="email" class="form-control" required>
            </div>
            
            <div class="form-group">
                <label class="form-label" for="phone">Phone Number (Optional)</label>
                <input type="text" id="phone" name="phone" class="form-control">
            </div>
            
            <div class="form-group">
                <label class="form-label" for="message">Inquiry Details</label>
                <textarea id="message" name="message" class="form-control" required></textarea>
            </div>
            
            <button type="submit" class="btn-primary" style="width: 100%;">Submit Inquiry</button>
        </form>
    </div>
@endsection
