@extends('layouts.app')

@section('title', 'My Dashboard')

@push('styles')
<style>
    .dashboard-container {
        padding: 10rem 0 8rem;
    }

    .dashboard-grid {
        display: grid;
        grid-template-columns: 1fr 3fr;
        gap: 4rem;
        margin-top: 4rem;
    }

    .sidebar {
        background: var(--bg-card);
        padding: 2rem;
        border-radius: 4px;
        border: 1px solid var(--border-color);
        height: fit-content;
    }

    .sidebar-link {
        display: block;
        padding: 1rem 0;
        color: var(--text-secondary);
        text-decoration: none;
        border-bottom: 1px solid var(--border-color);
        transition: var(--transition-smooth);
    }

    .sidebar-link:hover, .sidebar-link.active {
        color: var(--accent);
    }

    .dashboard-content {
        background: var(--bg-card);
        padding: 3rem;
        border-radius: 4px;
        border: 1px solid var(--border-color);
    }

    .content-title {
        font-size: 2rem;
        margin-bottom: 2rem;
        color: var(--text-primary);
        font-family: var(--font-heading);
    }

    .info-group {
        margin-bottom: 1.5rem;
    }
    
    .info-label {
        color: var(--text-secondary);
        font-size: 0.9rem;
        margin-bottom: 0.5rem;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .info-value {
        font-size: 1.2rem;
        color: var(--text-primary);
    }

    /* Mock Orders Table */
    .orders-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 2rem;
    }

    .orders-table th, .orders-table td {
        padding: 1rem;
        text-align: left;
        border-bottom: 1px solid var(--border-color);
    }

    .orders-table th {
        color: var(--text-secondary);
        font-weight: normal;
        text-transform: uppercase;
        font-size: 0.9rem;
        letter-spacing: 1px;
    }

    .status-badge {
        padding: 0.3rem 0.8rem;
        border-radius: 20px;
        font-size: 0.85rem;
    }

    .status-processing {
        background: rgba(255, 193, 7, 0.2);
        color: #ffc107;
    }

    .status-completed {
        background: rgba(40, 167, 69, 0.2);
        color: #28a745;
    }
</style>
@endpush

@section('content')
    <div class="container dashboard-container">
        <h1 class="page-title gsap-reveal">My Account</h1>
        
        <div class="dashboard-grid">
            <div class="sidebar gsap-reveal">
                <a href="{{ route('dashboard') }}" class="sidebar-link active">Profile Overview</a>
                <a href="#orders" class="sidebar-link">Order History</a>
                <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="sidebar-link" style="color: #ff4757;">Logout</a>
            </div>

            <div class="dashboard-content gsap-reveal">
                <h2 class="content-title">Personal Information</h2>
                
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem;">
                    <div class="info-group">
                        <div class="info-label">Full Name</div>
                        <div class="info-value">{{ auth()->user()->name }}</div>
                    </div>
                    <div class="info-group">
                        <div class="info-label">Email Address</div>
                        <div class="info-value">{{ auth()->user()->email }}</div>
                    </div>
                    <div class="info-group">
                        <div class="info-label">Account Created</div>
                        <div class="info-value">{{ auth()->user()->created_at->format('F j, Y') }}</div>
                    </div>
                </div>

                <hr style="border-color: var(--border-color); margin: 3rem 0;" id="orders">

                <h2 class="content-title">Recent Orders</h2>
                
                @if($orders->count() > 0)
                    <table class="orders-table">
                        <thead>
                            <tr>
                                <th>Order ID</th>
                                <th>Date</th>
                                <th>Total</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($orders as $order)
                            <tr>
                                <td>#{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</td>
                                <td>{{ $order->created_at->format('M d, Y') }}</td>
                                <td>₹{{ number_format($order->total_amount, 2) }}</td>
                                <td>
                                    @if($order->status == 'pending')
                                        <span class="status-badge" style="background: rgba(255, 193, 7, 0.2); color: #ffc107;">Pending Payment</span>
                                    @elseif($order->status == 'processing')
                                        <span class="status-badge" style="background: rgba(40, 167, 69, 0.2); color: #28a745;">Processing</span>
                                    @else
                                        <span class="status-badge" style="background: rgba(0,0,0,0.05); color: var(--text-primary);">{{ ucfirst($order->status) }}</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <p class="text-secondary">You haven't placed any orders yet.</p>
                    <a href="{{ url('/shop') }}" class="btn-primary" style="margin-top: 1rem;">Shop Now</a>
                @endif
            </div>
        </div>
    </div>
@endsection
