<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Super Industries - Luxury Wooden Soft Toys and Hampers. Eco-friendly, premium craftsmanship for the finest experiences.">
    <title>Super Industries | @yield('title', 'Luxury Wooden Toys')</title>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar">
        <div class="container">
            <a href="{{ url('/') }}" class="logo">SUPER INDUSTRIES</a>
            <div class="nav-links">
                <a href="{{ url('/') }}" class="{{ request()->is('/') ? 'active' : '' }}">Home</a>
                <a href="{{ url('/shop') }}" class="{{ request()->is('shop') ? 'active' : '' }}">Gallery & Shop</a>
                <a href="{{ url('/b2b') }}" class="{{ request()->is('b2b') ? 'active' : '' }}">B2B / Wholesale</a>
                <a href="{{ url('/cart') }}" class="{{ request()->is('cart') ? 'active' : '' }}">Cart</a>
                
                <button class="theme-toggle-btn" id="themeToggle" aria-label="Toggle Dark Mode">
                    <svg id="themeIcon" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <!-- Moon icon for default light mode -->
                        <path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"></path>
                    </svg>
                </button>
                
                @guest
                    <a href="{{ url('/login') }}" class="{{ request()->is('login') ? 'active' : '' }}">Login</a>
                    <a href="{{ url('/register') }}" class="{{ request()->is('register') ? 'active' : '' }}">Sign Up</a>
                @endguest
                @auth
                    <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">Dashboard</a>
                    <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                @endauth
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Mega Footer -->
    <footer>
        <div class="container" style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 4rem; padding-bottom: 4rem; border-bottom: 1px solid var(--border-color); margin-bottom: 2rem;">
            <div>
                <a href="{{ url('/') }}" class="logo" style="font-size: 1.5rem; margin-bottom: 1.5rem; display: block;">SUPER INDUSTRIES</a>
                <p style="color: var(--text-secondary); line-height: 1.8; margin-bottom: 1.5rem;">The pinnacle of sustainable, artisanal woodcraft. Creating heirlooms for the next generation since 1998.</p>
                <div style="display: flex; gap: 1rem;">
                    <a href="https://instagram.com/superindustries" target="_blank" style="color: var(--text-primary); text-decoration: none; font-weight: 600;">IG</a>
                    <a href="https://facebook.com/superindustries" target="_blank" style="color: var(--text-primary); text-decoration: none; font-weight: 600;">FB</a>
                    <a href="https://pinterest.com/superindustries" target="_blank" style="color: var(--text-primary); text-decoration: none; font-weight: 600;">PT</a>
                </div>
            </div>
            
            <div>
                <h4 style="font-family: var(--font-heading); font-size: 1.2rem; margin-bottom: 1.5rem; color: var(--text-primary);">Shop</h4>
                <ul style="list-style: none; padding: 0;">
                    <li style="margin-bottom: 0.8rem;"><a href="{{ url('/shop?category=premium-soft-toys') }}" style="color: var(--text-secondary); text-decoration: none;">Wooden Soft Toys</a></li>
                    <li style="margin-bottom: 0.8rem;"><a href="{{ url('/shop?category=luxury-hampers') }}" style="color: var(--text-secondary); text-decoration: none;">Luxury Hampers</a></li>
                    <li style="margin-bottom: 0.8rem;"><a href="{{ url('/shop') }}" style="color: var(--text-secondary); text-decoration: none;">All Collections</a></li>
                    <li style="margin-bottom: 0.8rem;"><a href="{{ url('/pages/gift-cards') }}" style="color: var(--text-secondary); text-decoration: none;">Gift Cards</a></li>
                </ul>
            </div>

            <div>
                <h4 style="font-family: var(--font-heading); font-size: 1.2rem; margin-bottom: 1.5rem; color: var(--text-primary);">The Brand</h4>
                <ul style="list-style: none; padding: 0;">
                    <li style="margin-bottom: 0.8rem;"><a href="{{ url('/about') }}" style="color: var(--text-secondary); text-decoration: none;">Our Story</a></li>
                    <li style="margin-bottom: 0.8rem;"><a href="{{ url('/b2b') }}" style="color: var(--text-secondary); text-decoration: none;">B2B / Wholesale</a></li>
                    <li style="margin-bottom: 0.8rem;"><a href="{{ url('/pages/sustainability') }}" style="color: var(--text-secondary); text-decoration: none;">Sustainability</a></li>
                    <li style="margin-bottom: 0.8rem;"><a href="{{ url('/pages/press-media') }}" style="color: var(--text-secondary); text-decoration: none;">Press & Media</a></li>
                </ul>
            </div>

            <div>
                <h4 style="font-family: var(--font-heading); font-size: 1.2rem; margin-bottom: 1.5rem; color: var(--text-primary);">Client Care</h4>
                <ul style="list-style: none; padding: 0;">
                    <li style="margin-bottom: 0.8rem;"><a href="{{ url('/pages/contact-us') }}" style="color: var(--text-secondary); text-decoration: none;">Contact Us</a></li>
                    <li style="margin-bottom: 0.8rem;"><a href="{{ url('/pages/shipping-returns') }}" style="color: var(--text-secondary); text-decoration: none;">Shipping & Returns</a></li>
                    <li style="margin-bottom: 0.8rem;"><a href="{{ url('/pages/care-instructions') }}" style="color: var(--text-secondary); text-decoration: none;">Care Instructions</a></li>
                    <li style="margin-bottom: 0.8rem;"><a href="{{ url('/pages/faq') }}" style="color: var(--text-secondary); text-decoration: none;">FAQ</a></li>
                </ul>
            </div>
        </div>
        
        <div class="container" style="display: flex; justify-content: space-between; align-items: center; color: var(--text-secondary); font-size: 0.85rem;">
            <p>&copy; {{ date('Y') }} Super Industries. All Rights Reserved.</p>
            <div style="display: flex; gap: 2rem;">
                <a href="{{ url('/pages/privacy-policy') }}" style="color: var(--text-secondary); text-decoration: none;">Privacy Policy</a>
                <a href="{{ url('/pages/terms-of-service') }}" style="color: var(--text-secondary); text-decoration: none;">Terms of Service</a>
            </div>
        </div>
    </footer>
    @stack('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const toggleBtn = document.getElementById('themeToggle');
            const htmlTag = document.documentElement;
            const themeIcon = document.getElementById('themeIcon');
            
            // Check local storage or system preference
            const savedTheme = localStorage.getItem('theme');
            if (savedTheme) {
                htmlTag.setAttribute('data-theme', savedTheme);
                updateIcon(savedTheme);
            }

            toggleBtn.addEventListener('click', () => {
                const currentTheme = htmlTag.getAttribute('data-theme');
                const newTheme = currentTheme === 'light' ? 'dark' : 'light';
                
                htmlTag.setAttribute('data-theme', newTheme);
                localStorage.setItem('theme', newTheme);
                updateIcon(newTheme);
            });

            function updateIcon(theme) {
                if (theme === 'dark') {
                    // Sun Icon
                    themeIcon.innerHTML = '<circle cx="12" cy="12" r="5"></circle><line x1="12" y1="1" x2="12" y2="3"></line><line x1="12" y1="21" x2="12" y2="23"></line><line x1="4.22" y1="4.22" x2="5.64" y2="5.64"></line><line x1="18.36" y1="18.36" x2="19.78" y2="19.78"></line><line x1="1" y1="12" x2="3" y2="12"></line><line x1="21" y1="12" x2="23" y2="12"></line><line x1="4.22" y1="19.78" x2="5.64" y2="18.36"></line><line x1="18.36" y1="5.64" x2="19.78" y2="4.22"></line>';
                } else {
                    // Moon Icon
                    themeIcon.innerHTML = '<path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"></path>';
                }
            }
        });
    </script>
</body>
</html>
