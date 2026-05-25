@extends('layouts.app')

@section('title', 'Gallery & Shop')

@push('styles')
<style>
    .shop-header {
        padding: 10rem 0 4rem;
        text-align: center;
    }

    .shop-title {
        font-size: 3.5rem;
        color: var(--text-primary);
        margin-bottom: 1rem;
    }

    .shop-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
        gap: 3rem;
        padding-bottom: 8rem;
    }

    .product-card {
        background: var(--bg-card);
        border: 1px solid var(--border-color);
        padding: 4rem;
        border-radius: 8px;
        box-shadow: 0 20px 40px rgba(0,0,0,0.03);
        transition: var(--transition-smooth);
        text-decoration: none;
        display: block;
        color: var(--text-primary);
    }

    .product-card:hover {
        transform: translateY(-10px);
        border-color: var(--accent);
        box-shadow: 0 20px 40px rgba(0,0,0,0.08);
    }

    .product-img-wrapper {
        width: 100%;
        height: 350px;
        overflow: hidden;
        margin-bottom: 2rem;
        border-radius: 2px;
    }

    .product-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 1.5s cubic-bezier(0.16, 1, 0.3, 1);
    }

    .product-card:hover .product-img {
        transform: scale(1.08);
    }

    .product-meta {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .product-title {
        font-size: 1.5rem;
        font-family: var(--font-heading);
    }

    .product-price {
        font-size: 1.2rem;
        color: var(--accent);
    }
</style>
@endpush

@section('content')
    <div class="container">
        <div class="container page-header gsap-reveal" style="padding: 10rem 0 4rem; text-align: center;">
            <h1 class="page-title" style="font-size: 3.5rem; color: var(--text-primary); margin-bottom: 1rem;">Gallery & Shop</h1>
            <p class="text-secondary" style="margin-bottom: 2rem;">Discover our exquisite collection of sustainable luxury wooden toys and hampers.</p>
            
            <form action="{{ url('/shop') }}" method="GET" style="margin-top: 2rem; display: flex; gap: 1rem; justify-content: center;">
                <input type="text" name="search" placeholder="Search by name..." value="{{ request('search') }}" style="padding: 1rem; width: 300px; background: transparent; border: 1px solid var(--border-color); color: var(--text-primary); outline: none; border-radius: 4px; font-family: var(--font-body);">
                <select name="category" style="padding: 1rem; background: transparent; border: 1px solid var(--border-color); color: var(--text-primary); outline: none; border-radius: 4px; font-family: var(--font-body);">
                    <option value="" style="color: #000;">All Categories</option>
                    <option value="premium-soft-toys" style="color: #000;" {{ request('category') == 'premium-soft-toys' ? 'selected' : '' }}>Soft Toys</option>
                    <option value="luxury-hampers" style="color: #000;" {{ request('category') == 'luxury-hampers' ? 'selected' : '' }}>Hampers</option>
                </select>
                <button type="submit" class="btn-primary" style="padding: 1rem 2rem;">Filter</button>
            </form>
        </div>

        <div class="shop-grid">
            @foreach($products as $product)
                <a href="{{ url('/product/' . $product->slug) }}" class="product-card gsap-reveal">
                    <div class="product-img-wrapper">
                        <img src="{{ asset('images/' . $product->image) }}" alt="{{ $product->name }}" class="product-img">
                    </div>
                    <div class="product-meta">
                        <h3 class="product-title">{{ $product->name }}</h3>
                        <span class="product-price">₹{{ number_format($product->price, 2) }}</span>
                    </div>
                </a>
            @endforeach
        </div>

        <div class="pagination-container gsap-reveal" style="margin-top: 3rem; display: flex; justify-content: center;">
            {{ $products->links() }}
        </div>
    </div>
@endsection
