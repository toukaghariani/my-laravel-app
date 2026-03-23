@extends('layouts.app')

@section('title', 'Premium — WolfNet')

@section('content')

<div class="wn-premium-page">

    {{-- HERO --}}
    <div class="wn-premium-hero">
        <div class="wn-premium-hero-bg"></div>
        <div class="container wn-premium-hero-inner">
            <div class="wn-premium-crown">♛</div>
            <h1 class="wn-premium-hero-title">Go <span class="wn-red-text">Premium</span></h1>
            <p class="wn-premium-hero-sub">Unlock everything WolfNet has to offer — no limits, no ads, just pure cinema.</p>
        </div>
    </div>

    {{-- PLANS --}}
    <div class="container wn-plans-container">

        <h2 class="wn-section-title text-center border-0 ps-0 mb-5">Choose Your Plan</h2>

        <div class="wn-plans-grid">

            {{-- Basic --}}
            <div class="wn-plan-card">
                <div class="wn-plan-header">
                    <span class="wn-plan-badge">Free</span>
                    <h3 class="wn-plan-name">Basic</h3>
                    <div class="wn-plan-price">
                        <span class="wn-price-amount">0</span>
                        <span class="wn-price-currency">TND</span>
                        <span class="wn-price-period">/ month</span>
                    </div>
                </div>
                <ul class="wn-plan-features">
                    <li class="wn-feature-item wn-feature-yes"><i class="bi bi-check-circle-fill"></i> Browse movies & series</li>
                    <li class="wn-feature-item wn-feature-yes"><i class="bi bi-check-circle-fill"></i> Watch trailers</li>
                    <li class="wn-feature-item wn-feature-yes"><i class="bi bi-check-circle-fill"></i> Add to favorites</li>
                    <li class="wn-feature-item wn-feature-no"><i class="bi bi-x-circle-fill"></i> HD & 4K streaming</li>
                    <li class="wn-feature-item wn-feature-no"><i class="bi bi-x-circle-fill"></i> Exclusive content</li>
                    <li class="wn-feature-item wn-feature-no"><i class="bi bi-x-circle-fill"></i> Download offline</li>
                    <li class="wn-feature-item wn-feature-no"><i class="bi bi-x-circle-fill"></i> Ad-free experience</li>
                </ul>
                <a href="{{ url('/register') }}" class="wn-plan-btn wn-plan-btn-outline">Get Started Free</a>
            </div>

            {{-- Premium --}}
            <div class="wn-plan-card wn-plan-featured">
                <div class="wn-plan-popular-tag">⚡ Most Popular</div>
                <div class="wn-plan-header">
                    <span class="wn-plan-badge wn-badge-red">Premium</span>
                    <h3 class="wn-plan-name">Premium</h3>
                    <div class="wn-plan-price">
                        <span class="wn-price-amount">15</span>
                        <span class="wn-price-currency">TND</span>
                        <span class="wn-price-period">/ month</span>
                    </div>
                </div>
                <ul class="wn-plan-features">
                    <li class="wn-feature-item wn-feature-yes"><i class="bi bi-check-circle-fill"></i> Browse movies & series</li>
                    <li class="wn-feature-item wn-feature-yes"><i class="bi bi-check-circle-fill"></i> Watch trailers</li>
                    <li class="wn-feature-item wn-feature-yes"><i class="bi bi-check-circle-fill"></i> Add to favorites</li>
                    <li class="wn-feature-item wn-feature-yes"><i class="bi bi-check-circle-fill"></i> HD & 4K streaming</li>
                    <li class="wn-feature-item wn-feature-yes"><i class="bi bi-check-circle-fill"></i> Exclusive content</li>
                    <li class="wn-feature-item wn-feature-yes"><i class="bi bi-check-circle-fill"></i> Download offline</li>
                    <li class="wn-feature-item wn-feature-yes"><i class="bi bi-check-circle-fill"></i> Ad-free experience</li>
                </ul>
                <button class="wn-plan-btn wn-plan-btn-primary" onclick="showPaymentForm('premium', 15)">
                    Subscribe Now
                </button>
            </div>

            {{-- Ultimate --}}
            <div class="wn-plan-card">
                <div class="wn-plan-header">
                    <span class="wn-plan-badge">Ultimate</span>
                    <h3 class="wn-plan-name">Ultimate</h3>
                    <div class="wn-plan-price">
                        <span class="wn-price-amount">25</span>
                        <span class="wn-price-currency">TND</span>
                        <span class="wn-price-period">/ month</span>
                    </div>
                </div>
                <ul class="wn-plan-features">
                    <li class="wn-feature-item wn-feature-yes"><i class="bi bi-check-circle-fill"></i> Everything in Premium</li>
                    <li class="wn-feature-item wn-feature-yes"><i class="bi bi-check-circle-fill"></i> 4 simultaneous screens</li>
                    <li class="wn-feature-item wn-feature-yes"><i class="bi bi-check-circle-fill"></i> Family sharing (5 users)</li>
                    <li class="wn-feature-item wn-feature-yes"><i class="bi bi-check-circle-fill"></i> Priority support</li>
                    <li class="wn-feature-item wn-feature-yes"><i class="bi bi-check-circle-fill"></i> Early access to new titles</li>
                    <li class="wn-feature-item wn-feature-yes"><i class="bi bi-check-circle-fill"></i> Download offline</li>
                    <li class="wn-feature-item wn-feature-yes"><i class="bi bi-check-circle-fill"></i> Ad-free experience</li>
                </ul>
                <button class="wn-plan-btn wn-plan-btn-outline" onclick="showPaymentForm('ultimate', 25)">
                    Subscribe Now
                </button>
            </div>

        </div>
    </div>

    {{-- PAYMENT MODAL --}}
    <div class="wn-modal-backdrop" id="paymentModal" style="display:none;" onclick="closeModal(event)">
        <div class="wn-modal-box">
            <button class="wn-modal-close" onclick="hidePaymentForm()">&#10005;</button>
            <div class="wn-modal-header">
                <div class="wn-modal-icon">💳</div>
                <h3 class="wn-modal-title">Complete Payment</h3>
                <p class="wn-modal-subtitle">
                    Plan: <strong id="modalPlanName" class="text-danger">Premium</strong> —
                    <strong id="modalPlanPrice">15 TND</strong> / month
                </p>
            </div>
            <form class="wn-payment-form" method="POST" action="{{ url('/premium/pay') }}" id="paymentForm">
                @csrf
                <input type="hidden" name="plan" id="planInput" value="premium">
                <input type="hidden" name="amount" id="amountInput" value="15">
                <div class="wn-form-group">
                    <label class="wn-form-label">Cardholder Name</label>
                    <input type="text" name="cardholder_name" class="wn-input" placeholder="Your full name" required>
                </div>
                <div class="wn-form-group">
                    <label class="wn-form-label">Card Number</label>
                    <div class="wn-card-input-wrap">
                        <input type="text" name="card_number" class="wn-input" placeholder="1234 5678 9012 3456" maxlength="19" id="cardNumber" required>
                        <span class="wn-card-icon" id="cardTypeIcon">💳</span>
                    </div>
                </div>
                <div class="wn-form-row">
                    <div class="wn-form-group">
                        <label class="wn-form-label">Expiry Date</label>
                        <input type="text" name="expiry" class="wn-input" placeholder="MM / YY" maxlength="7" id="expiryInput" required>
                    </div>
                    <div class="wn-form-group">
                        <label class="wn-form-label">CVV</label>
                        <input type="password" name="cvv" class="wn-input" placeholder="•••" maxlength="4" required>
                    </div>
                </div>
                <button type="submit" class="wn-plan-btn wn-plan-btn-primary w-100 mt-3" id="payBtn">
                    <span id="payBtnText">🔒 Pay Securely</span>
                </button>
                <p class="wn-secure-note">
                    <i class="bi bi-shield-lock-fill"></i>
                    Simulated payment — no real charges. Powered by Paymee/Stripe test mode.
                </p>
            </form>
        </div>
    </div>

    {{-- WHY PREMIUM --}}
    <div class="wn-premium-features">
        <div class="container">
            <h2 class="wn-section-title text-center border-0 ps-0 mb-5">Why Go Premium?</h2>
            <div class="row g-4 text-center">
                <div class="col-md-3 col-6">
                    <div class="wn-prem-feat">
                        <div class="wn-prem-feat-icon">🎬</div>
                        <h6 class="text-white mt-3">4K Ultra HD</h6>
                        <p class="text-muted small">Crystal clear quality on any screen.</p>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="wn-prem-feat">
                        <div class="wn-prem-feat-icon">📥</div>
                        <h6 class="text-white mt-3">Download & Watch</h6>
                        <p class="text-muted small">Save titles for offline viewing.</p>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="wn-prem-feat">
                        <div class="wn-prem-feat-icon">🚫</div>
                        <h6 class="text-white mt-3">Zero Ads</h6>
                        <p class="text-muted small">Uninterrupted viewing experience.</p>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="wn-prem-feat">
                        <div class="wn-prem-feat-icon">🔓</div>
                        <h6 class="text-white mt-3">Exclusive Content</h6>
                        <p class="text-muted small">Access titles unavailable on Basic.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

@push('styles')
<style>
.wn-premium-page { min-height: 100vh; background: var(--wn-dark); padding-bottom: 80px; }
.wn-premium-hero { position: relative; padding: 130px 0 60px; text-align: center; overflow: hidden; }
.wn-premium-hero-bg { position: absolute; inset: 0; background: radial-gradient(ellipse at 50% 0%, rgba(229,9,20,0.18) 0%, transparent 70%), linear-gradient(180deg, #0a0a0a 0%, var(--wn-dark) 100%); z-index: 0; }
.wn-premium-hero-inner { position: relative; z-index: 1; }
.wn-premium-crown { font-size: 3rem; line-height: 1; margin-bottom: 16px; animation: wn-float 3s ease-in-out infinite; }
.wn-premium-hero-title { font-size: clamp(2.4rem, 5vw, 4rem); font-weight: 800; color: var(--wn-white); letter-spacing: -0.03em; margin: 0 0 16px; }
.wn-red-text { color: var(--wn-red); }
.wn-premium-hero-sub { color: var(--wn-muted); font-size: 1.05rem; max-width: 500px; margin: 0 auto; }
.wn-plans-container { padding-top: 50px; }
.wn-plans-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 24px; align-items: start; }
.wn-plan-card { background: var(--wn-card); border: 1px solid var(--wn-border); border-radius: 14px; padding: 32px 28px; position: relative; transition: transform 0.25s ease, box-shadow 0.25s ease, border-color 0.25s ease; animation: wn-fadein 0.4s ease both; }
.wn-plan-card:hover { transform: translateY(-6px); box-shadow: 0 20px 50px rgba(0,0,0,0.5); border-color: var(--wn-red); }
.wn-plan-card:nth-child(1) { animation-delay: 0.05s; }
.wn-plan-card:nth-child(2) { animation-delay: 0.10s; }
.wn-plan-card:nth-child(3) { animation-delay: 0.15s; }
.wn-plan-featured { border-color: var(--wn-red); background: linear-gradient(145deg, #1f1010 0%, var(--wn-card) 60%); transform: translateY(-8px); box-shadow: 0 24px 60px rgba(229,9,20,0.2); }
.wn-plan-featured:hover { transform: translateY(-14px); }
.wn-plan-popular-tag { position: absolute; top: -14px; left: 50%; transform: translateX(-50%); background: var(--wn-red); color: var(--wn-white); font-size: 0.75rem; font-weight: 700; padding: 4px 16px; border-radius: 20px; white-space: nowrap; letter-spacing: 0.05em; }
.wn-plan-header { margin-bottom: 24px; }
.wn-plan-badge { display: inline-block; font-size: 0.72rem; font-weight: 700; letter-spacing: 0.1em; text-transform: uppercase; background: var(--wn-border); color: var(--wn-muted); padding: 3px 10px; border-radius: 4px; margin-bottom: 10px; }
.wn-badge-red { background: rgba(229,9,20,0.15); color: var(--wn-red); }
.wn-plan-name { font-size: 1.5rem; font-weight: 700; color: var(--wn-white); margin: 0 0 12px; }
.wn-plan-price { display: flex; align-items: baseline; gap: 4px; }
.wn-price-amount { font-size: 2.8rem; font-weight: 800; color: var(--wn-white); line-height: 1; }
.wn-price-currency { font-size: 1rem; font-weight: 600; color: var(--wn-red); }
.wn-price-period { font-size: 0.85rem; color: var(--wn-muted); }
.wn-plan-features { list-style: none; padding: 0; margin: 0 0 28px; display: flex; flex-direction: column; gap: 10px; }
.wn-feature-item { display: flex; align-items: center; gap: 10px; font-size: 0.88rem; }
.wn-feature-yes { color: var(--wn-text); }
.wn-feature-no { color: var(--wn-muted); text-decoration: line-through; opacity: 0.5; }
.wn-feature-yes i { color: #22c55e; font-size: 0.9rem; }
.wn-feature-no i { color: #555; font-size: 0.9rem; }
.wn-plan-btn { display: block; width: 100%; padding: 13px; border-radius: 8px; font-size: 0.95rem; font-weight: 700; text-align: center; cursor: pointer; border: none; text-decoration: none; transition: opacity 0.2s, transform 0.15s; }
.wn-plan-btn:hover { opacity: 0.88; transform: translateY(-2px); }
.wn-plan-btn-primary { background: var(--wn-red); color: var(--wn-white); }
.wn-plan-btn-outline { background: transparent; color: var(--wn-text); border: 1px solid var(--wn-border); }
.wn-plan-btn-outline:hover { border-color: var(--wn-red); color: var(--wn-white); }
.wn-modal-backdrop { position: fixed; inset: 0; background: rgba(0,0,0,0.85); z-index: 1050; display: flex; align-items: center; justify-content: center; padding: 20px; animation: wn-fadein 0.2s ease; }
.wn-modal-box { background: var(--wn-card); border: 1px solid var(--wn-border); border-radius: 16px; padding: 40px 36px; width: 100%; max-width: 460px; position: relative; animation: wn-slideup 0.3s ease; }
.wn-modal-close { position: absolute; top: 16px; right: 16px; background: var(--wn-border); border: none; color: var(--wn-muted); border-radius: 50%; width: 32px; height: 32px; cursor: pointer; font-size: 0.8rem; display: flex; align-items: center; justify-content: center; transition: background 0.2s, color 0.2s; }
.wn-modal-close:hover { background: var(--wn-red); color: var(--wn-white); }
.wn-modal-header { text-align: center; margin-bottom: 28px; }
.wn-modal-icon { font-size: 2.5rem; margin-bottom: 10px; }
.wn-modal-title { font-size: 1.4rem; font-weight: 700; color: var(--wn-white); margin: 0 0 6px; }
.wn-modal-subtitle { color: var(--wn-muted); font-size: 0.9rem; margin: 0; }
.wn-payment-form { display: flex; flex-direction: column; gap: 16px; }
.wn-form-group { display: flex; flex-direction: column; gap: 6px; }
.wn-form-label { font-size: 0.82rem; font-weight: 600; color: var(--wn-muted); text-transform: uppercase; letter-spacing: 0.06em; }
.wn-form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
.wn-card-input-wrap { position: relative; }
.wn-card-input-wrap .wn-input { padding-right: 42px; }
.wn-card-icon { position: absolute; right: 12px; top: 50%; transform: translateY(-50%); font-size: 1.1rem; pointer-events: none; }
.wn-secure-note { text-align: center; color: var(--wn-muted); font-size: 0.78rem; margin: 8px 0 0; }
.wn-secure-note i { color: #22c55e; margin-right: 4px; }
.wn-premium-features { padding: 70px 0 0; }
.wn-prem-feat { padding: 28px 20px; background: var(--wn-card); border: 1px solid var(--wn-border); border-radius: 12px; }
.wn-prem-feat p { color: #b0b0b0 !important; }
.wn-prem-feat-icon { font-size: 2rem; }
.wn-premium-alert { display: flex; align-items: center; gap: 10px; padding: 14px 20px; border-radius: 8px; margin-bottom: 0; position: fixed; top: 80px; left: 50%; transform: translateX(-50%); z-index: 9999; min-width: 340px; animation: wn-fadein 0.3s ease; }
@keyframes wn-fadein { from { opacity: 0; transform: translateY(14px); } to { opacity: 1; transform: translateY(0); } }
@keyframes wn-slideup { from { opacity: 0; transform: translateY(30px); } to { opacity: 1; transform: translateY(0); } }
@keyframes wn-float { 0%, 100% { transform: translateY(0); } 50% { transform: translateY(-10px); } }
@media (max-width: 992px) { .wn-plans-grid { grid-template-columns: 1fr; max-width: 440px; margin: 0 auto; } .wn-plan-featured { transform: none; } }
@media (max-width: 480px) { .wn-modal-box { padding: 28px 20px; } .wn-form-row { grid-template-columns: 1fr; } }
</style>
@endpush

@push('scripts')
<script>
function showPaymentForm(plan, amount) {
    document.getElementById('modalPlanName').textContent = plan.charAt(0).toUpperCase() + plan.slice(1);
    document.getElementById('modalPlanPrice').textContent = amount + ' TND';
    document.getElementById('planInput').value = plan;
    document.getElementById('amountInput').value = amount;
    document.getElementById('paymentModal').style.display = 'flex';
    document.body.style.overflow = 'hidden';
}
function hidePaymentForm() {
    document.getElementById('paymentModal').style.display = 'none';
    document.body.style.overflow = '';
}
function closeModal(e) {
    if (e.target === document.getElementById('paymentModal')) hidePaymentForm();
}
document.addEventListener('keydown', function(e) { if (e.key === 'Escape') hidePaymentForm(); });
document.getElementById('cardNumber').addEventListener('input', function() {
    let val = this.value.replace(/\D/g, '').substring(0, 16);
    this.value = val.match(/.{1,4}/g)?.join(' ') || val;
});
document.getElementById('expiryInput').addEventListener('input', function() {
    let val = this.value.replace(/\D/g, '').substring(0, 4);
    if (val.length >= 2) val = val.substring(0, 2) + ' / ' + val.substring(2);
    this.value = val;
});
document.getElementById('paymentForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const btn = document.getElementById('payBtn');
    const btnText = document.getElementById('payBtnText');
    btn.disabled = true;
    btnText.textContent = '⏳ Processing...';
    setTimeout(function() {
        hidePaymentForm();
        btn.disabled = false;
        btnText.textContent = '🔒 Pay Securely';
        const alert = document.createElement('div');
        alert.className = 'wn-alert-success wn-premium-alert';
        alert.innerHTML = '<i class="bi bi-check-circle-fill me-2"></i><strong>Payment successful!</strong> Welcome to WolfNet Premium 🎉 <button onclick="this.parentElement.remove()" style="background:none;border:none;color:inherit;margin-left:auto;cursor:pointer;">✕</button>';
        document.body.appendChild(alert);
        setTimeout(() => alert.remove(), 5000);
    }, 2000);
});
</script>
@endpush

@endsection