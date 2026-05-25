@extends('layouts.app')

@section('title', 'Admin Command Center')

@push('styles')
<style>
    .admin-container {
        max-width: 1600px;
        margin: 0 auto;
        padding: 10rem 2rem 8rem;
    }

    .admin-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-end;
        margin-bottom: 3rem;
        border-bottom: 1px solid var(--border-color);
        padding-bottom: 2rem;
    }

    .live-indicator {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        background: rgba(40, 167, 69, 0.1);
        color: #28a745;
        padding: 0.5rem 1rem;
        border-radius: 30px;
        font-size: 0.85rem;
        font-weight: 600;
        letter-spacing: 1px;
        text-transform: uppercase;
    }

    .live-dot {
        width: 8px;
        height: 8px;
        background-color: #28a745;
        border-radius: 50%;
        animation: pulse 1.5s infinite;
    }

    @keyframes pulse {
        0% { box-shadow: 0 0 0 0 rgba(40, 167, 69, 0.7); }
        70% { box-shadow: 0 0 0 10px rgba(40, 167, 69, 0); }
        100% { box-shadow: 0 0 0 0 rgba(40, 167, 69, 0); }
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 2rem;
        margin-bottom: 4rem;
    }

    .stat-card {
        background: var(--bg-card);
        padding: 2.5rem;
        border-radius: 8px;
        border: 1px solid var(--border-color);
        position: relative;
        overflow: hidden;
    }

    .stat-card::after {
        content: '';
        position: absolute;
        top: 0; left: 0; right: 0; height: 2px;
        background: var(--accent);
    }

    .stat-value {
        color: var(--text-primary);
    }

    .stat-label {
        color: var(--text-secondary);
        text-transform: uppercase;
        letter-spacing: 2px;
        font-size: 0.85rem;
    }

    .admin-panel {
        background: var(--bg-card);
        padding: 3rem;
        border-radius: 8px;
        border: 1px solid var(--border-color);
        margin-bottom: 3rem;
    }

    .panel-title {
        font-size: 1.8rem;
        margin-bottom: 2rem;
        color: var(--text-primary);
        font-family: var(--font-heading);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .data-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0 0.5rem;
    }

    .data-table th {
        color: var(--text-secondary);
        text-transform: uppercase;
        font-size: 0.8rem;
        letter-spacing: 1.5px;
        padding: 1rem;
        text-align: left;
        border-bottom: 1px solid var(--border-color);
    }

    .data-table td {
        padding: 1.5rem 1rem;
        background: rgba(0, 0, 0, 0.02);
        border-top: 1px solid transparent;
        border-bottom: 1px solid transparent;
        transition: var(--transition-smooth);
    }
    
    .data-table tr:hover td {
        background: rgba(0, 0, 0, 0.04);
        border-color: rgba(0, 0, 0, 0.05);
    }

    .data-table tr td:first-child { border-top-left-radius: 6px; border-bottom-left-radius: 6px; }
    .data-table tr td:last-child { border-top-right-radius: 6px; border-bottom-right-radius: 6px; }

    .action-form {
        display: flex;
        gap: 0.5rem;
    }

    .status-select {
        background: #fff;
        color: var(--text-primary);
        border: 1px solid var(--border-color);
        padding: 0.4rem 0.8rem;
        border-radius: 4px;
        outline: none;
        font-size: 0.85rem;
    }

    .btn-update {
        background: var(--accent);
        color: #fff;
        border: none;
        padding: 0.4rem 1rem;
        border-radius: 4px;
        cursor: pointer;
        font-weight: bold;
        font-size: 0.85rem;
        transition: background 0.3s;
    }
    
    .btn-update:hover { background: var(--accent-hover); }

    .new-row {
        animation: highlight 3s ease;
    }

    @keyframes highlight {
        0% { background: rgba(212, 175, 55, 0.2); }
        100% { background: rgba(30, 34, 31, 0.4); }
    }
</style>
@endpush

@section('content')
    <div class="admin-container">
        <div class="admin-header gsap-reveal">
            <div>
                <h1 class="page-title" style="margin: 0; font-size: 4rem;">Command Center</h1>
                <p class="text-secondary" style="font-size: 1.2rem; margin-top: 0.5rem;">Super Industries Global Dashboard</p>
            </div>
            <div class="live-indicator">
                <div class="live-dot"></div>
                Live System Active
            </div>
        </div>
        
        <div class="stats-grid gsap-reveal">
            <div class="stat-card">
                <div class="stat-value" id="statOrders">{{ $ordersCount }}</div>
                <div class="stat-label">Total Orders</div>
            </div>
            <div class="stat-card">
                <div class="stat-value">{{ $productsCount }}</div>
                <div class="stat-label">Products Active</div>
            </div>
            <div class="stat-card">
                <div class="stat-value">{{ $inquiries->count() }}</div>
                <div class="stat-label">B2B Inquiries</div>
            </div>
        </div>

        <div class="admin-panel gsap-reveal">
            <h2 class="panel-title">
                Global Order Stream
                <span style="font-size: 0.9rem; font-family: var(--font-body); color: var(--text-secondary); font-weight: normal;">Auto-refreshing every 3s</span>
            </h2>
            
            <div style="overflow-x: auto;">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Customer</th>
                            <th>Gateway</th>
                            <th>Amount</th>
                            <th>Time</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="ordersTableBody">
                        <!-- Populated by JS -->
                    </tbody>
                </table>
                <p id="noOrdersMsg" class="text-secondary" style="display: none; padding: 2rem;">No orders found.</p>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    document.addEventListener("DOMContentLoaded", () => {
        let lastOrderCount = 0;

        function fetchLiveOrders() {
            fetch('/admin/orders/live')
                .then(response => response.json())
                .then(orders => {
                    const tbody = document.getElementById('ordersTableBody');
                    const noMsg = document.getElementById('noOrdersMsg');
                    const statOrders = document.getElementById('statOrders');
                    
                    if (orders.error) return;

                    if (orders.length === 0) {
                        tbody.innerHTML = '';
                        noMsg.style.display = 'block';
                        return;
                    }

                    noMsg.style.display = 'none';
                    statOrders.innerText = orders.length;

                    // If we have a new order, we might want to highlight the top row
                    let isNewOrder = false;
                    if (lastOrderCount > 0 && orders.length > lastOrderCount) {
                        isNewOrder = true;
                    }
                    lastOrderCount = orders.length;

                    // Rebuild HTML
                    let html = '';
                    orders.forEach((order, index) => {
                        const dateObj = new Date(order.created_at);
                        const dateStr = dateObj.toLocaleString('en-US', { month: 'short', day: 'numeric', year: 'numeric', hour: '2-digit', minute: '2-digit' });
                        const paddedId = String(order.id).padStart(5, '0');
                        
                        const userName = order.user ? order.user.name : 'Guest';
                        const userEmail = order.user ? order.user.email : '';

                        let paymentBadge = '';
                        if (order.payment_method === 'upi') {
                            paymentBadge = '<span style="background: #e6f2ff; color: #0056b3; padding: 0.3rem 0.6rem; border-radius: 4px; font-size: 0.75rem; font-weight: bold; letter-spacing: 1px;">UPI</span>';
                        } else {
                            paymentBadge = '<span style="background: #f0f0f0; color: #333; padding: 0.3rem 0.6rem; border-radius: 4px; font-size: 0.75rem; font-weight: bold; letter-spacing: 1px;">CARD</span>';
                        }

                        let statusBadge = '';
                        if (order.status === 'pending') {
                            statusBadge = '<span style="background: rgba(255, 193, 7, 0.1); color: #ffc107; padding: 0.4rem 0.8rem; border-radius: 20px; font-size: 0.8rem; border: 1px solid rgba(255, 193, 7, 0.2);">Pending</span>';
                        } else if (order.status === 'processing') {
                            statusBadge = '<span style="background: rgba(40, 167, 69, 0.1); color: #28a745; padding: 0.4rem 0.8rem; border-radius: 20px; font-size: 0.8rem; border: 1px solid rgba(40, 167, 69, 0.2);">Processing</span>';
                        } else if (order.status === 'shipped') {
                            statusBadge = '<span style="background: rgba(23, 162, 184, 0.1); color: #17a2b8; padding: 0.4rem 0.8rem; border-radius: 20px; font-size: 0.8rem; border: 1px solid rgba(23, 162, 184, 0.2);">Shipped</span>';
                        } else if (order.status === 'delivered') {
                            statusBadge = '<span style="background: rgba(108, 117, 125, 0.1); color: #adb5bd; padding: 0.4rem 0.8rem; border-radius: 20px; font-size: 0.8rem; border: 1px solid rgba(108, 117, 125, 0.2);">Delivered</span>';
                        }

                        const csrfToken = document.querySelector('meta[name="csrf-token"]') ? document.querySelector('meta[name="csrf-token"]').getAttribute('content') : '{{ csrf_token() }}';
                        
                        const actionUrl = `{{ url('/admin/orders') }}/${order.id}/status`;

                        const rowClass = (isNewOrder && index === 0) ? 'new-row' : '';

                        html += `
                            <tr class="${rowClass}">
                                <td style="font-family: var(--font-heading); color: var(--accent); font-size: 1.1rem;">#${paddedId}</td>
                                <td>
                                    <div style="font-weight: 600; color: var(--text-primary);">${userName}</div>
                                    <div style="font-size: 0.8rem; color: var(--text-secondary); margin-top: 0.2rem;">${userEmail}</div>
                                </td>
                                <td>${paymentBadge}</td>
                                <td style="font-family: var(--font-heading); font-size: 1.1rem;">₹${parseFloat(order.total_amount).toFixed(2)}</td>
                                <td style="color: var(--text-secondary); font-size: 0.85rem;">${dateStr}</td>
                                <td>${statusBadge}</td>
                                <td>
                                    <form action="${actionUrl}" method="POST" class="action-form">
                                        <input type="hidden" name="_token" value="${csrfToken}">
                                        <select name="status" class="status-select">
                                            <option value="pending" ${order.status === 'pending' ? 'selected' : ''}>Pending</option>
                                            <option value="processing" ${order.status === 'processing' ? 'selected' : ''}>Processing</option>
                                            <option value="shipped" ${order.status === 'shipped' ? 'selected' : ''}>Shipped</option>
                                            <option value="delivered" ${order.status === 'delivered' ? 'selected' : ''}>Delivered</option>
                                        </select>
                                        <button type="submit" class="btn-update">Update</button>
                                    </form>
                                </td>
                            </tr>
                        `;
                    });

                    tbody.innerHTML = html;
                })
                .catch(error => console.error('Error fetching live orders:', error));
        }

        // Initial fetch
        fetchLiveOrders();

        // Poll every 3 seconds
        setInterval(fetchLiveOrders, 3000);
    });
</script>
@endpush
