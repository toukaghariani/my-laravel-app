@extends('layouts.app')

@section('title', 'Subscription Plans — WolfNet')

@section('content')

{{-- ============================================================
     SUBSCRIPTION PLANS PAGE — WolfNet
     Backend TODO:
       - Route: GET /subscriptions/plans → SubscriptionController@plans
       - Route: POST /subscriptions/subscribe → SubscriptionController@subscribe
       - Pass $currentPlan (user's current plan)
       - Pass $plans (collection of plan objects)
     ============================================================ --}}

<div class="wn-plans-page">

    {{-- ── HERO ── --}}
    <div class="wn-plans-hero">
        <div class="wn-plans-hero-bg"></div>
        <div class="container wn-plans-hero-inner">
            <div class="wn-plans-hero-badge">🎬 WolfNet Premium</div>
            <h1 class="wn-plans-hero-title">
                Choose Your <span class="wn-red-text">Plan</span>
            </h1>
            <p class="wn-plans-hero-sub">
                Unlock unlimited streaming, HD quality, exclusive content and much more.
                Cancel anytime — no hidden fees.
            </p>

            {{-- Billing toggle --}}
            <div class="wn-billing-toggle">
                <span class="wn-billing-label" id="monthlyLabel" style="color:var(--wn-white)">Monthly</span>
                <div class="wn-toggle-switch" id="billingToggle" onclick="toggleBilling()">
                    <div class="wn-toggle-thumb" id="toggleThumb"></div>
                </div>
                <span class="wn-billing-label" id="yearlyLabel">Yearly</span>
                <span class="wn-save-badge" id="saveBadge">Save 20%</span>
            </div>
        </div>
    </div>

    {{-- ── PLANS GRID ── --}}
    <div class="container wn-plans-section">
        <div class="wn-plans-grid-full">

            {{-- ── PLAN: Basic ── --}}
            <div class="wn-plan-box" data-plan="basic">
                <div class="wn-plan-box-header">
                    <div class="wn-plan-icon">🆓</div>
                    <h3 class="wn-plan-box-name">Basic</h3>
                    <p class="wn-plan-box-desc">Perfect for casual viewers</p>
                    <div class="wn-plan-box-price">
                        <span class="wn-price-currency">TND</span>
                        <span class="wn-price-amount" data-monthly="0" data-yearly="0">0</span>
                        <span class="wn-price-period">/ month</span>
                    </div>
                </div>
                <ul class="wn-plan-box-features">
                    <li class="wn-feat-yes"><i class="bi bi-check-circle-fill"></i> Browse movies & series</li>
                    <li class="wn-feat-yes"><i class="bi bi-check-circle-fill"></i> Watch free trailers</li>
                    <li class="wn-feat-yes"><i class="bi bi-check-circle-fill"></i> Add to favorites</li>
                    <li class="wn-feat-yes"><i class="bi bi-check-circle-fill"></i> Basic search</li>
                    <li class="wn-feat-no"><i class="bi bi-x-circle-fill"></i> HD & 4K streaming</li>
                    <li class="wn-feat-no"><i class="bi bi-x-circle-fill"></i> Exclusive content</li>
                    <li class="wn-feat-no"><i class="bi bi-x-circle-fill"></i> Download offline</li>
                    <li class="wn-feat-no"><i class="bi bi-x-circle-fill"></i> Ad-free experience</li>
                    <li class="wn-feat-no"><i class="bi bi-x-circle-fill"></i> Multiple screens</li>
                </ul>
                <a href="{{ url('/register') }}" class="wn-plan-box-btn wn-btn-outline-plan">
                    Get Started Free
                </a>
            </div>

            {{-- ── PLAN: Premium (Featured) ── --}}
            <div class="wn-plan-box wn-plan-box-featured" data-plan="premium">
                <div class="wn-plan-popular-ribbon">⚡ Most Popular</div>
                <div class="wn-plan-box-header">
                    <div class="wn-plan-icon">👑</div>
                    <h3 class="wn-plan-box-name">Premium</h3>
                    <p class="wn-plan-box-desc">Best for individuals</p>
                    <div class="wn-plan-box-price">
                        <span class="wn-price-currency">TND</span>
                        <span class="wn-price-amount" data-monthly="15" data-yearly="12">15</span>
                        <span class="wn-price-period">/ month</span>
                    </div>
                    <p class="wn-yearly-note" id="premiumYearlyNote" style="display:none;">
                        Billed as <strong>144 TND/year</strong> — save 36 TND!
                    </p>
                </div>
                <ul class="wn-plan-box-features">
                    <li class="wn-feat-yes"><i class="bi bi-check-circle-fill"></i> Everything in Basic</li>
                    <li class="wn-feat-yes"><i class="bi bi-check-circle-fill"></i> HD & 4K streaming</li>
                    <li class="wn-feat-yes"><i class="bi bi-check-circle-fill"></i> Exclusive content</li>
                    <li class="wn-feat-yes"><i class="bi bi-check-circle-fill"></i> Download offline</li>
                    <li class="wn-feat-yes"><i class="bi bi-check-circle-fill"></i> Ad-free experience</li>
                    <li class="wn-feat-yes"><i class="bi bi-check-circle-fill"></i> 2 simultaneous screens</li>
                    <li class="wn-feat-yes"><i class="bi bi-check-circle-fill"></i> Watch history</li>
                    <li class="wn-feat-yes"><i class="bi bi-check-circle-fill"></i> Priority support</li>
                    <li class="wn-feat-no"><i class="bi bi-x-circle-fill"></i> Family sharing</li>
                </ul>
                {{-- TODO: action="{{ route('subscriptions.subscribe') }}" --}}
                <form method="POST" action="{{ url('/subscriptions/subscribe') }}">
                    @csrf
                    <input type="hidden" name="plan" value="premium">
                    <input type="hidden" name="billing" id="premiumBilling" value="monthly">
                    <button type="submit" class="wn-plan-box-btn wn-btn-primary-plan">
                        Subscribe Now
                    </button>
                </form>
            </div>

            {{-- ── PLAN: Ultimate ── --}}
            <div class="wn-plan-box" data-plan="ultimate">
                <div class="wn-plan-box-header">
                    <div class="wn-plan-icon">💎</div>
                    <h3 class="wn-plan-box-name">Ultimate</h3>
                    <p class="wn-plan-box-desc">Best for families</p>
                    <div class="wn-plan-box-price">
                        <span class="wn-price-currency">TND</span>
                        <span class="wn-price-amount" data-monthly="25" data-yearly="20">25</span>
                        <span class="wn-price-period">/ month</span>
                    </div>
                    <p class="wn-yearly-note" id="ultimateYearlyNote" style="display:none;">
                        Billed as <strong>240 TND/year</strong> — save 60 TND!
                    </p>
                </div>
                <ul class="wn-plan-box-features">
                    <li class="wn-feat-yes"><i class="bi bi-check-circle-fill"></i> Everything in Premium</li>
                    <li class="wn-feat-yes"><i class="bi bi-check-circle-fill"></i> 4 simultaneous screens</li>
                    <li class="wn-feat-yes"><i class="bi bi-check-circle-fill"></i> Family sharing (5 users)</li>
                    <li class="wn-feat-yes"><i class="bi bi-check-circle-fill"></i> Early access to new titles</li>
                    <li class="wn-feat-yes"><i class="bi bi-check-circle-fill"></i> Dolby Atmos audio</li>
                    <li class="wn-feat-yes"><i class="bi bi-check-circle-fill"></i> Ultra HD streaming</li>
                    <li class="wn-feat-yes"><i class="bi bi-check-circle-fill"></i> Unlimited downloads</li>
                    <li class="wn-feat-yes"><i class="bi bi-check-circle-fill"></i> Dedicated support</li>
                    <li class="wn-feat-yes"><i class="bi bi-check-circle-fill"></i> No ads ever</li>
                </ul>
                <form method="POST" action="{{ url('/subscriptions/subscribe') }}">
                    @csrf
                    <input type="hidden" name="plan" value="ultimate">
                    <input type="hidden" name="billing" id="ultimateBilling" value="monthly">
                    <button type="submit" class="wn-plan-box-btn wn-btn-outline-plan">
                        Subscribe Now
                    </button>
                </form>
            </div>

        </div>{{-- /grid --}}

        {{-- ── COMPARISON NOTE ── --}}
        <p class="wn-plans-note">
            <i class="bi bi-shield-fill-check text-success"></i>
            Secure payment via Flouci 🇹🇳 — Cancel anytime — No hidden fees
        </p>

    </div>{{-- /container --}}


    {{-- ── FEATURES COMPARISON TABLE ── --}}
    <div class="container wn-compare-section">
        <h2 class="wn-section-title text-center border-0 ps-0 mb-5">Full Feature Comparison</h2>
        <div class="wn-compare-table-wrap">
            <table class="wn-compare-table">
                <thead>
                    <tr>
                        <th>Feature</th>
                        <th>Basic</th>
                        <th class="wn-th-featured">Premium</th>
                        <th>Ultimate</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                    $features = [
                        ['name' => 'Browse movies & series',    'basic' => true,  'premium' => true,  'ultimate' => true],
                        ['name' => 'Watch trailers',            'basic' => true,  'premium' => true,  'ultimate' => true],
                        ['name' => 'Add to favorites',          'basic' => true,  'premium' => true,  'ultimate' => true],
                        ['name' => 'HD streaming (720p)',       'basic' => false, 'premium' => true,  'ultimate' => true],
                        ['name' => '4K Ultra HD streaming',     'basic' => false, 'premium' => true,  'ultimate' => true],
                        ['name' => 'Ad-free experience',        'basic' => false, 'premium' => true,  'ultimate' => true],
                        ['name' => 'Download offline',          'basic' => false, 'premium' => true,  'ultimate' => true],
                        ['name' => 'Exclusive content',         'basic' => false, 'premium' => true,  'ultimate' => true],
                        ['name' => 'Simultaneous screens',      'basic' => '1',   'premium' => '2',   'ultimate' => '4'],
                        ['name' => 'Family sharing',            'basic' => false, 'premium' => false, 'ultimate' => true],
                        ['name' => 'Dolby Atmos audio',         'basic' => false, 'premium' => false, 'ultimate' => true],
                        ['name' => 'Early access to titles',    'basic' => false, 'premium' => false, 'ultimate' => true],
                        ['name' => 'Dedicated support',         'basic' => false, 'premium' => false, 'ultimate' => true],
                    ];
                    @endphp
                    @foreach($features as $f)
                    <tr>
                        <td class="wn-feat-name">{{ $f['name'] }}</td>
                        <td class="wn-feat-cell">
                            @if($f['basic'] === true)
                                <span class="wn-feat-check">✓</span>
                            @elseif($f['basic'] === false)
                                <span class="wn-feat-x">✕</span>
                            @else
                                <span class="wn-feat-val">{{ $f['basic'] }}</span>
                            @endif
                        </td>
                        <td class="wn-feat-cell wn-td-featured">
                            @if($f['premium'] === true)
                                <span class="wn-feat-check">✓</span>
                            @elseif($f['premium'] === false)
                                <span class="wn-feat-x">✕</span>
                            @else
                                <span class="wn-feat-val">{{ $f['premium'] }}</span>
                            @endif
                        </td>
                        <td class="wn-feat-cell">
                            @if($f['ultimate'] === true)
                                <span class="wn-feat-check">✓</span>
                            @elseif($f['ultimate'] === false)
                                <span class="wn-feat-x">✕</span>
                            @else
                                <span class="wn-feat-val">{{ $f['ultimate'] }}</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>


    {{-- ── FAQ ── --}}
    <div class="container wn-faq-section">
        <h2 class="wn-section-title text-center border-0 ps-0 mb-5">Frequently Asked Questions</h2>
        <div class="wn-faq-list">

            @php
            $faqs = [
                ['q' => 'Can I cancel my subscription anytime?', 'a' => 'Yes! You can cancel your subscription at any time from your profile settings. You will continue to have access until the end of your billing period.'],
                ['q' => 'How does the yearly plan work?', 'a' => 'With the yearly plan you pay upfront for 12 months and save 20% compared to monthly billing. You get the same features as the monthly plan.'],
                ['q' => 'What payment methods are accepted?', 'a' => 'We accept payments via Flouci wallet (Tunisia) and major credit/debit cards through our secure payment gateway.'],
                ['q' => 'Can I upgrade or downgrade my plan?', 'a' => 'Absolutely! You can upgrade or downgrade your plan at any time. Changes take effect at the start of your next billing cycle.'],
                ['q' => 'Is there a free trial?', 'a' => 'Yes! New users get a 7-day free trial of the Premium plan. No credit card required to start.'],
            ];
            @endphp

            @foreach($faqs as $i => $faq)
            <div class="wn-faq-item" id="faq{{ $i }}">
                <button class="wn-faq-btn" onclick="toggleFaq({{ $i }})">
                    <span>{{ $faq['q'] }}</span>
                    <i class="bi bi-chevron-down wn-faq-icon" id="faqIcon{{ $i }}"></i>
                </button>
                <div class="wn-faq-answer" id="faqAnswer{{ $i }}" style="display:none;">
                    <p>{{ $faq['a'] }}</p>
                </div>
            </div>
            @endforeach

        </div>
    </div>

</div>{{-- /page --}}


@push('styles')
<style>
/* ── Page ── */
.wn-plans-page { min-height:100vh; background:var(--wn-dark); padding-bottom:80px; }

/* ── Hero ── */
.wn-plans-hero { position:relative; padding:110px 0 60px; text-align:center; overflow:hidden; }
.wn-plans-hero-bg { position:absolute; inset:0; background:radial-gradient(ellipse at 50% 0%, rgba(229,9,20,0.18) 0%, transparent 65%), linear-gradient(180deg,#0a0a0a 0%,var(--wn-dark) 100%); }
.wn-plans-hero-inner { position:relative; z-index:1; }
.wn-plans-hero-badge { display:inline-block; background:rgba(229,9,20,0.15); border:1px solid rgba(229,9,20,0.3); color:var(--wn-red); font-size:0.82rem; font-weight:700; padding:6px 18px; border-radius:20px; margin-bottom:20px; letter-spacing:0.05em; }
.wn-plans-hero-title { font-size:clamp(2.2rem,5vw,3.8rem); font-weight:800; color:var(--wn-white); letter-spacing:-0.03em; margin:0 0 16px; }
.wn-red-text { color:var(--wn-red); }
.wn-plans-hero-sub { color:#b0b0b0; font-size:1rem; max-width:520px; margin:0 auto 32px; line-height:1.6; }

/* ── Billing toggle ── */
.wn-billing-toggle { display:inline-flex; align-items:center; gap:12px; background:var(--wn-card); border:1px solid var(--wn-border); padding:10px 20px; border-radius:50px; }
.wn-billing-label { font-size:0.88rem; font-weight:600; color:var(--wn-muted); transition:color 0.2s; }
.wn-toggle-switch { width:44px; height:24px; background:var(--wn-border); border-radius:12px; cursor:pointer; position:relative; transition:background 0.3s; }
.wn-toggle-switch.on { background:var(--wn-red); }
.wn-toggle-thumb { position:absolute; top:3px; left:3px; width:18px; height:18px; background:white; border-radius:50%; transition:transform 0.3s; box-shadow:0 2px 6px rgba(0,0,0,0.3); }
.wn-toggle-switch.on .wn-toggle-thumb { transform:translateX(20px); }
.wn-save-badge { background:rgba(34,197,94,0.15); color:#22c55e; border:1px solid rgba(34,197,94,0.3); font-size:0.72rem; font-weight:700; padding:3px 10px; border-radius:10px; }

/* ── Plans section ── */
.wn-plans-section { padding-top:50px; }
.wn-plans-grid-full { display:grid; grid-template-columns:repeat(3,1fr); gap:24px; align-items:start; margin-bottom:24px; }

/* ── Plan box ── */
.wn-plan-box { background:var(--wn-card); border:1px solid var(--wn-border); border-radius:16px; padding:36px 28px; position:relative; transition:transform 0.25s, box-shadow 0.25s, border-color 0.25s; animation:wn-fadein 0.4s ease both; }
.wn-plan-box:hover { transform:translateY(-6px); box-shadow:0 20px 50px rgba(0,0,0,0.5); border-color:rgba(229,9,20,0.4); }
.wn-plan-box:nth-child(1){animation-delay:0.05s}
.wn-plan-box:nth-child(2){animation-delay:0.10s}
.wn-plan-box:nth-child(3){animation-delay:0.15s}

/* Featured plan */
.wn-plan-box-featured { border-color:var(--wn-red); background:linear-gradient(160deg,#1a0a0a 0%,var(--wn-card) 50%); transform:translateY(-10px); box-shadow:0 28px 60px rgba(229,9,20,0.25); }
.wn-plan-box-featured:hover { transform:translateY(-16px); }
.wn-plan-popular-ribbon { position:absolute; top:-14px; left:50%; transform:translateX(-50%); background:var(--wn-red); color:white; font-size:0.72rem; font-weight:800; padding:5px 18px; border-radius:20px; white-space:nowrap; letter-spacing:0.05em; }

/* Plan header */
.wn-plan-box-header { text-align:center; margin-bottom:28px; }
.wn-plan-icon { font-size:2.2rem; margin-bottom:12px; }
.wn-plan-box-name { font-size:1.4rem; font-weight:800; color:var(--wn-white); margin:0 0 6px; }
.wn-plan-box-desc { color:var(--wn-muted); font-size:0.82rem; margin:0 0 16px; }
.wn-plan-box-price { display:flex; align-items:baseline; justify-content:center; gap:4px; }
.wn-price-currency { font-size:1rem; font-weight:700; color:var(--wn-red); }
.wn-price-amount { font-size:3rem; font-weight:800; color:var(--wn-white); line-height:1; transition:all 0.3s; }
.wn-price-period { font-size:0.85rem; color:var(--wn-muted); }
.wn-yearly-note { font-size:0.78rem; color:#22c55e; margin:8px 0 0; text-align:center; }

/* Features list */
.wn-plan-box-features { list-style:none; padding:0; margin:0 0 28px; display:flex; flex-direction:column; gap:10px; }
.wn-feat-yes, .wn-feat-no { display:flex; align-items:center; gap:10px; font-size:0.86rem; }
.wn-feat-yes { color:var(--wn-text); }
.wn-feat-no { color:var(--wn-muted); opacity:0.5; text-decoration:line-through; }
.wn-feat-yes i { color:#22c55e; font-size:0.85rem; flex-shrink:0; }
.wn-feat-no i { color:#555; font-size:0.85rem; flex-shrink:0; }

/* Buttons */
.wn-plan-box-btn { display:block; width:100%; padding:14px; border-radius:10px; font-size:0.95rem; font-weight:700; text-align:center; cursor:pointer; border:none; text-decoration:none; transition:opacity 0.2s, transform 0.15s; }
.wn-plan-box-btn:hover { opacity:0.88; transform:translateY(-2px); }
.wn-btn-primary-plan { background:linear-gradient(135deg,var(--wn-red),#ff4d57); color:white; box-shadow:0 4px 20px rgba(229,9,20,0.4); }
.wn-btn-outline-plan { background:transparent; color:var(--wn-text); border:1.5px solid var(--wn-border); }
.wn-btn-outline-plan:hover { border-color:var(--wn-red); color:var(--wn-white); }

/* Plans note */
.wn-plans-note { text-align:center; color:var(--wn-muted); font-size:0.85rem; margin-top:8px; }

/* ── Compare table ── */
.wn-compare-section { margin-bottom:60px; }
.wn-compare-table-wrap { overflow-x:auto; border-radius:14px; border:1px solid var(--wn-border); }
.wn-compare-table { width:100%; border-collapse:collapse; }
.wn-compare-table th { padding:16px 20px; font-size:0.85rem; font-weight:700; color:var(--wn-muted); text-transform:uppercase; letter-spacing:0.06em; border-bottom:1px solid var(--wn-border); background:var(--wn-card); text-align:center; }
.wn-compare-table th:first-child { text-align:left; }
.wn-th-featured { color:var(--wn-red) !important; background:rgba(229,9,20,0.06) !important; }
.wn-compare-table td { padding:13px 20px; border-bottom:1px solid rgba(42,42,42,0.5); font-size:0.85rem; text-align:center; }
.wn-compare-table tr:last-child td { border-bottom:none; }
.wn-compare-table tr:hover td { background:rgba(255,255,255,0.02); }
.wn-feat-name { text-align:left !important; color:var(--wn-text); font-weight:500; }
.wn-feat-cell { }
.wn-td-featured { background:rgba(229,9,20,0.04); }
.wn-feat-check { color:#22c55e; font-weight:700; font-size:1rem; }
.wn-feat-x { color:#444; font-size:0.9rem; }
.wn-feat-val { color:var(--wn-white); font-weight:700; }

/* ── FAQ ── */
.wn-faq-section { margin-bottom:60px; }
.wn-faq-list { max-width:720px; margin:0 auto; display:flex; flex-direction:column; gap:8px; }
.wn-faq-item { background:var(--wn-card); border:1px solid var(--wn-border); border-radius:10px; overflow:hidden; transition:border-color 0.2s; }
.wn-faq-item:hover { border-color:rgba(229,9,20,0.3); }
.wn-faq-btn { width:100%; display:flex; align-items:center; justify-content:space-between; gap:16px; padding:16px 20px; background:transparent; border:none; color:var(--wn-white); font-size:0.92rem; font-weight:600; text-align:left; cursor:pointer; }
.wn-faq-icon { color:var(--wn-muted); transition:transform 0.3s; flex-shrink:0; }
.wn-faq-icon.open { transform:rotate(180deg); color:var(--wn-red); }
.wn-faq-answer { padding:0 20px 16px; color:#b0b0b0; font-size:0.88rem; line-height:1.7; }

@keyframes wn-fadein { from{opacity:0;transform:translateY(14px)}to{opacity:1;transform:translateY(0)} }

@media(max-width:992px) { .wn-plans-grid-full{grid-template-columns:1fr;max-width:440px;margin-left:auto;margin-right:auto} .wn-plan-box-featured{transform:none} .wn-plan-box-featured:hover{transform:translateY(-6px)} }
@media(max-width:576px) { .wn-billing-toggle{flex-wrap:wrap;justify-content:center} }
</style>
@endpush


@push('scripts')
<script>
/* ── Billing toggle (Monthly / Yearly) ── */
let isYearly = false;

function toggleBilling() {
    isYearly = !isYearly;
    const toggle = document.getElementById('billingToggle');
    const monthlyLabel = document.getElementById('monthlyLabel');
    const yearlyLabel = document.getElementById('yearlyLabel');

    toggle.classList.toggle('on', isYearly);

    monthlyLabel.style.color = isYearly ? 'var(--wn-muted)' : 'var(--wn-white)';
    yearlyLabel.style.color = isYearly ? 'var(--wn-white)' : 'var(--wn-muted)';

    // Update prices
    document.querySelectorAll('.wn-price-amount').forEach(function(el) {
        el.textContent = isYearly ? el.dataset.yearly : el.dataset.monthly;
    });

    // Show/hide yearly notes
    ['premium', 'ultimate'].forEach(function(plan) {
        const note = document.getElementById(plan + 'YearlyNote');
        if (note) note.style.display = isYearly ? 'block' : 'none';
    });

    // Update billing hidden inputs
    document.getElementById('premiumBilling').value = isYearly ? 'yearly' : 'monthly';
    document.getElementById('ultimateBilling').value = isYearly ? 'yearly' : 'monthly';
}

/* ── FAQ accordion ── */
function toggleFaq(i) {
    const answer = document.getElementById('faqAnswer' + i);
    const icon = document.getElementById('faqIcon' + i);
    const isOpen = answer.style.display !== 'none';

    // Close all
    document.querySelectorAll('[id^=faqAnswer]').forEach(a => a.style.display = 'none');
    document.querySelectorAll('[id^=faqIcon]').forEach(ic => ic.classList.remove('open'));

    // Open clicked if it was closed
    if (!isOpen) {
        answer.style.display = 'block';
        icon.classList.add('open');
    }
}
</script>
@endpush

@endsection