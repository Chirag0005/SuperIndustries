@extends('layouts.app')

@section('title', 'Your Cart')

@push('styles')
<style>
    .cart-container {
        padding: 10rem 0 8rem;
    }

    .cart-title {
        font-size: 3rem;
        margin-bottom: 3rem;
    }

    .cart-table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 3rem;
    }

    .cart-table th {
        text-align: left;
        padding-bottom: 1rem;
        border-bottom: 1px solid var(--border-color);
        color: var(--text-secondary);
        font-family: var(--font-heading);
    }

    .cart-table td {
        padding: 2rem 0;
        border-bottom: 1px solid var(--border-color);
        vertical-align: middle;
    }

    .cart-item-info {
        display: flex;
        align-items: center;
        gap: 2rem;
    }

    .cart-item-img {
        width: 100px;
        height: 100px;
        object-fit: cover;
        border-radius: 4px;
    }

    .cart-item-title {
        font-size: 1.2rem;
        font-family: var(--font-heading);
    }

    .cart-summary {
        background: var(--bg-card);
        padding: 3rem;
        border-radius: 4px;
        text-align: right;
    }

    .cart-total {
        font-size: 2rem;
        color: var(--accent);
        margin-bottom: 2rem;
        display: block;
        font-family: var(--font-heading);
    }
</style>
@endpush

@section('content')
    <div class="container cart-container">
        <h1 class="cart-title gsap-reveal">Your Cart</h1>
        
        @if(session('cart') && count(session('cart')) > 0)
            <table class="cart-table gsap-reveal">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Total</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @php $total = 0; @endphp
                    @foreach(session('cart') as $id => $details)
                        @php $total += $details['price'] * $details['quantity']; @endphp
                        <tr>
                            <td>
                                <div class="cart-item-info">
                                    <img src="{{ asset('images/' . $details['image']) }}" alt="{{ $details['name'] }}" class="cart-item-img">
                                    <span class="cart-item-title">{{ $details['name'] }}</span>
                                </div>
                            </td>
                            <td>{{ $details['quantity'] }}</td>
                            <td style="color: var(--accent);">₹{{ number_format($details['price'], 2) }}</td>
                            <td style="color: var(--accent);">₹{{ number_format($details['price'] * $details['quantity'], 2) }}</td>
                            <td>
                                <form action="{{ url('/cart/remove/' . $id) }}" method="POST">
                                    @csrf
                                    <button type="submit" style="background:none; border:none; color:var(--text-secondary); cursor:pointer;">Remove</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            
            <div class="cart-summary gsap-reveal">
                <span style="color: var(--text-secondary); margin-right: 1rem; font-size: 1.2rem;">Total:</span>
                <span class="cart-total">₹{{ number_format($total, 2) }}</span>
                <a href="{{ url('/checkout') }}" class="btn-primary">Proceed to Checkout</a>
            </div>
        @else
            <div class="gsap-reveal" style="text-align: center; padding: 4rem 0;">
                <p class="text-secondary" style="font-size: 1.2rem; margin-bottom: 2rem;">Your cart is currently empty.</p>
                <a href="{{ url('/shop') }}" class="btn-primary">Continue Shopping</a>
            </div>
        @endif
    </div>
@endsection
