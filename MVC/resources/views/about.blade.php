@extends('layouts.app')

@section('title', 'Our Story - Super Industries')

@push('styles')
<style>
    .about-hero {
        height: 70vh;
        position: relative;
        display: flex;
        align-items: center;
        justify-content: center;
        text-align: center;
        overflow: hidden;
    }

    .about-hero img {
        position: absolute;
        top: 0; left: 0; width: 100%; height: 120%;
        object-fit: cover;
        z-index: -2;
        filter: brightness(0.6);
    }

    .about-hero-content {
        position: relative;
        z-index: 1;
        max-width: 800px;
        padding: 4rem;
        background: rgba(15, 17, 16, 0.65);
        backdrop-filter: blur(15px);
        border: 1px solid rgba(255,255,255,0.1);
        border-radius: 8px;
    }

    .about-title {
        font-size: 4.5rem;
        color: #fff;
        margin-bottom: 1rem;
        font-family: var(--font-heading);
    }

    .content-section {
        padding: 8rem 0;
        background: var(--bg-main);
    }

    .split-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 6rem;
        align-items: center;
    }

    .split-text h2 {
        font-size: 3rem;
        margin-bottom: 2rem;
        color: var(--text-primary);
    }

    .split-text p {
        font-size: 1.1rem;
        line-height: 1.8;
        color: var(--text-secondary);
        margin-bottom: 1.5rem;
    }

    .split-img img {
        width: 100%;
        border-radius: 8px;
        box-shadow: var(--shadow-soft);
    }

    .quote-section {
        padding: 8rem 0;
        text-align: center;
        background: var(--bg-card);
        border-top: 1px solid var(--border-color);
        border-bottom: 1px solid var(--border-color);
    }

    .quote-text {
        font-family: var(--font-heading);
        font-size: 2.5rem;
        color: var(--text-primary);
        max-width: 900px;
        margin: 0 auto;
        line-height: 1.4;
        font-style: italic;
    }
</style>
@endpush

@section('content')
    <!-- Hero -->
    <section class="about-hero">
        <img src="{{ asset('images/massive_parallax.png') }}" alt="Forest Parallax" id="aboutHeroImg">
        <div class="about-hero-content gsap-reveal">
            <span class="hero-subtitle" style="color: #d4af37;">Heritage & Craft</span>
            <h1 class="about-title">Our Story</h1>
            <p style="color: #e0e0e0; font-size: 1.2rem;">Creating heirlooms that transcend time.</p>
        </div>
    </section>

    <!-- History -->
    <section class="content-section container">
        <div class="split-grid">
            <div class="split-text gsap-reveal">
                <h2>Born from Nature.</h2>
                <p>Founded in 1998, Super Industries began with a singular vision: to create wooden pieces that are not just toys, but works of art. What started as a small artisan workshop has grown into a globally recognized luxury brand, cherished by families who value sustainability, craftsmanship, and elegant design.</p>
                <p>We source only the finest, certified-sustainable timber from around the globe. Every piece of mahogany, oak, and walnut is carefully selected for its unique grain and durability.</p>
            </div>
            <div class="split-img gsap-reveal">
                <img src="{{ asset('images/product_premium_blocks.png') }}" alt="Craftsmanship">
            </div>
        </div>
    </section>

    <!-- Quote -->
    <section class="quote-section">
        <div class="container gsap-reveal">
            <p class="quote-text">"True luxury is found in the meticulous attention to detail, and a deep, uncompromising respect for the materials nature provides."</p>
            <div style="margin-top: 2rem; color: var(--accent); letter-spacing: 2px; text-transform: uppercase;">— The Master Artisans</div>
        </div>
    </section>

    <!-- Craft -->
    <section class="content-section container">
        <div class="split-grid">
            <div class="split-img gsap-reveal">
                <img src="{{ asset('images/product_carved_train.png') }}" alt="Carved Train">
            </div>
            <div class="split-text gsap-reveal">
                <h2>The Art of the Heirloom</h2>
                <p>Our carving process is an exercise in patience. Each toy and hamper is hand-sculpted by master artisans who have dedicated their lives to understanding the nuances of wood.</p>
                <p>We believe in slow creation. There are no rushed assembly lines here. Just hands, tools, and the quiet pursuit of perfection. The result is a tactile experience that cannot be replicated by machinery.</p>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
<script>
    document.addEventListener("DOMContentLoaded", () => {
        gsap.to("#aboutHeroImg", {
            yPercent: 20,
            ease: "none",
            scrollTrigger: {
                trigger: ".about-hero",
                start: "top top",
                end: "bottom top",
                scrub: true
            }
        });
    });
</script>
@endpush
