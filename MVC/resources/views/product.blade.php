@extends('layouts.app')

@section('title', $product->name)

@push('styles')
<style>
    .product-details-container {
        padding: 10rem 0 8rem;
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 5rem;
        align-items: start;
    }

    .product-image-container {
        position: sticky;
        top: 10rem;
    }

    .product-image {
        width: 100%;
        border-radius: 4px;
        box-shadow: 0 20px 40px rgba(0,0,0,0.3);
    }

    .product-info {
        padding-top: 2rem;
    }

    .product-title {
        font-size: 3.5rem;
        margin-bottom: 1rem;
        color: var(--text-primary);
    }

    .product-price {
        font-size: 2rem;
        color: var(--accent);
        margin-bottom: 2rem;
        display: block;
        font-family: var(--font-heading);
    }

    .product-description {
        font-size: 1.1rem;
        line-height: 1.8;
        color: var(--text-secondary);
        margin-bottom: 3rem;
    }

    .add-to-cart-form {
        display: flex;
        gap: 1rem;
    }

    .quantity-input {
        background: transparent;
        border: 1px solid var(--border-color);
        color: var(--text-primary);
        padding: 1rem;
        width: 80px;
        font-size: 1.1rem;
        text-align: center;
        outline: none;
    }
    
    .quantity-input:focus {
        border-color: var(--accent);
    }
</style>
@endpush

@section('content')
    <div class="container product-details-container">
        <div class="product-image-container gsap-reveal">
            <img src="{{ asset('images/' . $product->image) }}" alt="{{ $product->name }}" class="product-image">
        </div>
        
        <div class="product-info gsap-reveal">
            <h1 class="product-title">{{ $product->name }}</h1>
            <span class="product-price">₹{{ number_format($product->price, 2) }}</span>
            <div class="product-description">
                {{ $product->description }}
            </div>
            
            <form action="{{ url('/cart/add/' . $product->id) }}" method="POST" class="add-to-cart-form">
                @csrf
                <input type="number" name="quantity" value="1" min="1" class="quantity-input">
                <button type="submit" class="btn-primary">Add to Cart</button>
            </form>
        </div>
    </div>
@endsection
