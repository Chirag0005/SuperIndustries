@extends('layouts.app')

@section('title', 'Checkout')

@push('styles')
<style>
    .checkout-container {
        padding: 10rem 0 8rem;
        max-width: 800px;
        margin: 0 auto;
    }

    .checkout-title {
        font-size: 3rem;
        color: var(--text-primary);
        margin-bottom: 3rem;
        text-align: center;
    }

    .checkout-form {
        background: var(--bg-card);
        padding: 3rem;
        border-radius: 4px;
        border: 1px solid var(--border-color);
    }

    .form-group {
        margin-bottom: 2rem;
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

    .order-summary {
        margin-top: 3rem;
        padding-top: 2rem;
        border-top: 1px solid var(--border-color);
        text-align: right;
    }

    .order-total {
        font-size: 1.5rem;
        color: var(--accent);
        margin-bottom: 2rem;
        display: block;
    }
</style>
@endpush

@section('content')
    <div class="container checkout-container">
        <h1 class="checkout-title gsap-reveal">Secure Checkout</h1>
        
        <div class="checkout-form gsap-reveal">
            <form action="{{ url('/checkout') }}" method="POST">
                @csrf
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem;">
                    <div class="form-group">
                        <label class="form-label" for="first_name">First Name</label>
                        <input type="text" id="first_name" name="first_name" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="last_name">Last Name</label>
                        <input type="text" id="last_name" name="last_name" class="form-control" required>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label" for="email">Email Address</label>
                    <input type="email" id="email" name="email" class="form-control" required>
                </div>

                <div class="form-group">
                    <label class="form-label" for="address">Shipping Address</label>
                    <input type="text" id="address" name="address" class="form-control" required>
                </div>

                <div class="form-group">
                    <label class="form-label" for="card">Card Details (Mock - do not enter real info)</label>
                    <input type="text" id="card" name="card" class="form-control" placeholder="**** **** **** ****" required>
                </div>

                <div class="order-summary">
                    @php 
                        $total = 0; 
                        if(session('cart')) {
                            foreach(session('cart') as $details) {
                                $total += $details['price'] * $details['quantity'];
                            }
                        }
                    @endphp
                    <span class="order-total">Total to Pay: ₹{{ number_format($total, 2) }}</span>
                    <button type="submit" class="btn-primary" style="width: 100%;">Complete Purchase</button>
                </div>
            </form>
        </div>
    </div>
@endsection
