@extends('layouts.app')

@section('title', 'Secure Payment')

@push('styles')
<style>
    .payment-container {
        padding: 12rem 0 8rem;
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 80vh;
    }

    .payment-card {
        background: var(--bg-card);
        border: 1px solid var(--border-color);
        border-radius: 8px;
        width: 100%;
        max-width: 600px;
        box-shadow: 0 30px 60px rgba(0,0,0,0.5);
        overflow: hidden;
    }

    .payment-header {
        padding: 3rem 3rem 2rem;
        text-align: center;
        border-bottom: 1px solid var(--border-color);
        background: rgba(15, 17, 16, 0.4);
    }

    .payment-title {
        font-size: 2rem;
        color: var(--text-primary);
        margin-bottom: 0.5rem;
        font-family: var(--font-heading);
    }

    .order-total {
        font-size: 2.5rem;
        color: var(--accent);
        font-family: var(--font-heading);
    }

    .payment-tabs {
        display: flex;
        border-bottom: 1px solid var(--border-color);
    }

    .payment-tab {
        flex: 1;
        padding: 1.5rem;
        text-align: center;
        background: rgba(25, 28, 26, 0.4);
        color: var(--text-secondary);
        cursor: pointer;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 1px;
        font-size: 0.9rem;
        transition: var(--transition-smooth);
        border-bottom: 2px solid transparent;
    }

    .payment-tab.active {
        background: transparent;
        color: var(--accent);
        border-bottom-color: var(--accent);
    }

    .payment-body {
        padding: 3rem;
    }

    .tab-content {
        display: none;
        animation: fadeIn 0.4s ease;
    }

    .tab-content.active {
        display: block;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .form-group {
        margin-bottom: 1.5rem;
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

    .upi-mock {
        text-align: center;
        padding: 2rem 0;
    }

    .qr-placeholder {
        width: 200px;
        height: 200px;
        margin: 0 auto 2rem;
        background: #fff;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
        overflow: hidden;
    }

    .qr-placeholder::before {
        content: 'QR CODE';
        color: #000;
        font-weight: bold;
        font-size: 1.2rem;
        letter-spacing: 2px;
    }
    
    .qr-placeholder::after {
        content: '';
        position: absolute;
        top: 0; left: 0; right: 0; bottom: 0;
        background: linear-gradient(45deg, rgba(0,0,0,0.1) 25%, transparent 25%, transparent 75%, rgba(0,0,0,0.1) 75%, rgba(0,0,0,0.1)),
                    linear-gradient(45deg, rgba(0,0,0,0.1) 25%, transparent 25%, transparent 75%, rgba(0,0,0,0.1) 75%, rgba(0,0,0,0.1));
        background-size: 20px 20px;
        background-position: 0 0, 10px 10px;
        opacity: 0.3;
    }

    .payment-footer {
        padding: 2rem 3rem 3rem;
    }

</style>
@endpush

@section('content')
    <div class="container payment-container">
        <div class="payment-card gsap-reveal">
            
            <div class="payment-header">
                <h1 class="payment-title">Order #{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</h1>
                <div class="order-total">₹{{ number_format($order->total_amount, 2) }}</div>
            </div>

            <div class="payment-tabs">
                <div class="payment-tab active" onclick="switchTab('card')">Credit Card</div>
                <div class="payment-tab" onclick="switchTab('upi')">UPI Payment</div>
            </div>

            <form action="{{ url('/payment/' . $order->id . '/process') }}" method="POST" id="paymentForm">
                @csrf
                <input type="hidden" name="payment_method" id="paymentMethod" value="card">

                <div class="payment-body">
                    <!-- Card Tab -->
                    <div id="tab-card" class="tab-content active">
                        <div class="form-group">
                            <label class="form-label">Name on Card</label>
                            <input type="text" class="form-control" value="{{ auth()->user()->name }}" id="cardName">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Card Number</label>
                            <input type="text" class="form-control" placeholder="**** **** **** ****" id="cardNumber">
                        </div>
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem;">
                            <div class="form-group">
                                <label class="form-label">Expiry (MM/YY)</label>
                                <input type="text" class="form-control" placeholder="12/26" id="cardExpiry">
                            </div>
                            <div class="form-group">
                                <label class="form-label">CVC</label>
                                <input type="text" class="form-control" placeholder="123" id="cardCvc">
                            </div>
                        </div>
                    </div>

                    <!-- UPI Tab -->
                    <div id="tab-upi" class="tab-content">
                        <div class="upi-mock">
                            <div class="qr-placeholder"></div>
                            <p class="text-secondary" style="margin-bottom: 2rem;">Scan with any UPI app (GPay, PhonePe, Paytm)</p>
                            
                            <div style="display: flex; align-items: center; gap: 1rem; text-transform: uppercase; color: var(--text-secondary); margin-bottom: 2rem;">
                                <div style="flex: 1; height: 1px; background: var(--border-color);"></div>
                                OR
                                <div style="flex: 1; height: 1px; background: var(--border-color);"></div>
                            </div>

                            <div class="form-group" style="text-align: left;">
                                <label class="form-label">Enter UPI ID</label>
                                <input type="text" class="form-control" placeholder="username@upi" id="upiId">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="payment-footer">
                    <button type="button" onclick="submitPayment()" class="btn-primary" style="width: 100%; display: flex; justify-content: space-between; align-items: center;">
                        <span id="btnText">Pay Securely</span>
                        <span>₹{{ number_format($order->total_amount, 2) }}</span>
                    </button>
                    <p style="text-align: center; margin-top: 1rem; font-size: 0.8rem; color: var(--text-secondary);">Your payment is securely processed. End-to-end encrypted.</p>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    function switchTab(tab) {
        // Update tabs UI
        document.querySelectorAll('.payment-tab').forEach(t => t.classList.remove('active'));
        event.currentTarget.classList.add('active');

        // Show content
        document.querySelectorAll('.tab-content').forEach(c => c.classList.remove('active'));
        document.getElementById('tab-' + tab).classList.add('active');

        // Update hidden input
        document.getElementById('paymentMethod').value = tab;
        
        // Update button text
        document.getElementById('btnText').innerText = tab === 'upi' ? 'Verify & Pay via UPI' : 'Pay via Credit Card';
    }

    function submitPayment() {
        // Basic mock validation
        const method = document.getElementById('paymentMethod').value;
        if (method === 'card') {
            if (!document.getElementById('cardName').value || !document.getElementById('cardNumber').value) {
                alert('Please fill out your card details.');
                return;
            }
        } else {
            // For UPI, if they didn't enter an ID, we assume they "scanned"
        }
        
        // Simulate processing
        const btn = document.querySelector('button[type="button"]');
        btn.innerHTML = '<span>Processing...</span>';
        btn.style.opacity = '0.7';
        btn.style.pointerEvents = 'none';

        setTimeout(() => {
            document.getElementById('paymentForm').submit();
        }, 1500);
    }
</script>
@endpush
