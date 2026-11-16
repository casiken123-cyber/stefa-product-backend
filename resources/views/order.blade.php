<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stefa - Checkout</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@500;600;700&family=Inter:wght@400;500;600&family=IBM+Plex+Mono:wght@500;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --canvas: #FAFAF7;
            --surface: #FFFFFF;
            --surface-2: #F3F4EF;
            --line: #E7E9E2;
            --ink: #12181B;
            --ink-soft: #4A5459;
            --ink-faint: #7C8680;
            --mango: #FF7A29;
            --mango-deep: #E15F0F;
            --mango-tint: rgba(255, 122, 41, 0.12);
            --teal: #0E4C47;
            --teal-soft: #E6EFEE;
            --success: #1E8E5A;
            --success-soft: #E5F3EA;

            --radius-card: 18px;
            --radius-panel: 20px;
            --radius-ctl: 12px;

            --shadow-1: 0 1px 2px rgba(18, 24, 27, 0.04);
            --shadow-3: 0 22px 44px -16px rgba(18, 24, 27, 0.20), 0 6px 14px -6px rgba(18, 24, 27, 0.08);
            --ring: 0 0 0 4px var(--mango-tint);

            --ease-out: cubic-bezier(0.16, 1, 0.3, 1);
            --ease-in-out: cubic-bezier(0.65, 0, 0.35, 1);
            --ease-spring: cubic-bezier(0.34, 1.56, 0.64, 1);
        }

        * { box-sizing: border-box; }

        body {
            background: var(--canvas);
            font-family: 'Inter', system-ui, sans-serif;
            color: var(--ink);
            margin: 0;
            -webkit-font-smoothing: antialiased;
        }

        h1, h2, h3 { font-family: 'Space Grotesk', sans-serif; }

        a:focus-visible, button:focus-visible, input:focus-visible {
            outline: 3px solid rgba(255, 122, 41, 0.55);
            outline-offset: 2px;
        }

        /* ===================== Navigation ===================== */
        nav {
            background: var(--surface);
            border-bottom: 1px solid var(--line);
            padding: 14px 48px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 10;
        }
        .logo { display: inline-flex; align-items: center; text-decoration: none; }
        .logo-word {
            font-family: 'Space Grotesk', sans-serif;
            font-size: 25px;
            font-weight: 700;
            color: var(--ink);
            letter-spacing: -0.01em;
            line-height: 1;
        }
        .logo-word .logo-span { color: var(--mango); }
        .nav-right { display: flex; align-items: center; gap: 16px; }
        .nav-context { font-size: 14px; font-weight: 500; color: var(--ink-soft); display: inline-flex; align-items: center; gap: 8px; }
        .nav-context svg { width: 16px; height: 16px; color: var(--teal); }
        .back-link {
            text-decoration: none;
            color: var(--ink-soft);
            font-size: 14px;
            font-weight: 500;
            padding: 9px 14px;
            border-radius: var(--radius-ctl);
            transition: background 0.2s var(--ease-in-out), color 0.2s var(--ease-in-out);
        }
        .back-link:hover { color: var(--ink); background: var(--surface-2); }

        /* ===================== Layout ===================== */
        main {
            max-width: 1160px;
            margin: 40px auto 72px;
            padding: 0 40px;
            display: grid;
            grid-template-columns: 1fr 392px;
            gap: 28px;
            align-items: start;
        }
        @media (max-width: 900px) {
            nav { padding: 12px 20px; }
            .nav-context { display: none; }
            main { grid-template-columns: 1fr; padding: 0 20px; margin-top: 28px; }
        }
        .page-title {
            grid-column: 1 / -1;
            font-size: 32px;
            line-height: 40px;
            font-weight: 700;
            margin: 0;
            letter-spacing: -0.02em;
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .page-title::before { content: ""; width: 8px; height: 8px; background: var(--mango); border-radius: 2px; display: inline-block; }

        .checkout-block {
            background: var(--surface);
            border: 1px solid var(--line);
            border-radius: var(--radius-panel);
            padding: 32px;
            margin-bottom: 24px;
            box-shadow: var(--shadow-1);
        }
        .checkout-block:last-child { margin-bottom: 0; }
        @media (max-width: 560px) { .checkout-block { padding: 24px 20px; } }
        h2 {
            font-size: 20px;
            line-height: 28px;
            font-weight: 600;
            margin: 0 0 24px 0;
            letter-spacing: -0.01em;
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .step-num {
            background: var(--mango);
            color: var(--ink);
            width: 28px;
            height: 28px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 13px;
            font-weight: 700;
            font-family: 'Inter', sans-serif;
            flex-shrink: 0;
        }

        /* Forms */
        .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 16px; }
        @media (max-width: 560px) { .form-row { grid-template-columns: 1fr; } }
        .form-group { display: flex; flex-direction: column; gap: 8px; transition: transform 0.3s var(--ease-out); }
        .form-group:focus-within { transform: scale(1.01); }
        label { font-size: 12px; font-weight: 600; letter-spacing: 0.04em; color: var(--ink-soft); }
        input[type="text"], input[type="tel"] {
            padding: 13px 16px;
            border-radius: var(--radius-ctl);
            border: 1px solid var(--line);
            font-size: 14px;
            font-family: inherit;
            color: var(--ink);
            outline: none;
            background: var(--surface-2);
            transition: border-color 0.2s var(--ease-in-out), background 0.2s var(--ease-in-out), box-shadow 0.2s var(--ease-in-out);
        }
        input::placeholder { color: var(--ink-faint); }
        input[type="text"]:hover, input[type="tel"]:hover { border-color: #D3D6CD; }
        input[type="text"]:focus, input[type="tel"]:focus { border-color: var(--mango); background: var(--surface); box-shadow: var(--ring); }
        input.invalid { border-color: #B63A3A; }

        /* Payment options */
        .pay-options { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
        @media (max-width: 560px) { .pay-options { grid-template-columns: 1fr; } }
        .pay-card {
            position: relative;
            border: 1px solid var(--line);
            border-radius: var(--radius-card);
            padding: 18px;
            display: flex;
            align-items: center;
            gap: 12px;
            cursor: pointer;
            font-weight: 600;
            font-size: 14px;
            color: var(--ink);
            background: var(--surface);
            transition: border-color 0.2s var(--ease-in-out), background 0.2s var(--ease-in-out), box-shadow 0.2s var(--ease-in-out);
        }
        .pay-card input { margin: 0; width: 18px; height: 18px; accent-color: var(--mango); }
        .pay-card:hover { border-color: var(--mango); }
        .pay-card.active { border-color: var(--mango); background: var(--mango-tint); box-shadow: var(--ring); }
        .pay-card.disabled { cursor: not-allowed; background: var(--surface-2); color: var(--ink-faint); }
        .pay-card.disabled:hover { border-color: var(--line); }
        .pay-soon {
            margin-left: auto;
            font-family: 'IBM Plex Mono', monospace;
            font-size: 11px;
            font-weight: 500;
            letter-spacing: 0.04em;
            background: var(--surface);
            border: 1px solid var(--line);
            color: var(--ink-faint);
            padding: 3px 8px;
            border-radius: 6px;
        }
        .pay-note { margin: 14px 0 0; font-size: 13px; color: var(--ink-soft); line-height: 20px; }

        /* ===================== Summary ===================== */
        .summary-sidebar {
            background: var(--surface);
            border: 1px solid var(--line);
            border-radius: var(--radius-panel);
            padding: 28px;
            position: sticky;
            top: 96px;
            box-shadow: var(--shadow-1);
        }
        @media (max-width: 900px) { .summary-sidebar { position: static; } }
        .summary-sidebar h3 { margin: 0 0 20px 0; font-size: 18px; font-weight: 600; letter-spacing: -0.01em; }

        .summary-items { display: flex; flex-direction: column; gap: 16px; margin-bottom: 20px; padding-bottom: 20px; border-bottom: 1px solid var(--line); max-height: 300px; overflow-y: auto; }
        .summary-item { display: flex; align-items: center; gap: 12px; }
        .summary-thumb {
            position: relative;
            width: 56px;
            height: 56px;
            border-radius: 12px;
            border: 1px solid var(--line);
            background: var(--surface-2);
            flex-shrink: 0;
        }
        .summary-thumb img { width: 100%; height: 100%; object-fit: cover; display: block; border-radius: 11px; }
        .summary-qty {
            position: absolute;
            top: -7px;
            right: -7px;
            min-width: 20px;
            height: 20px;
            padding: 0 5px;
            border-radius: 10px;
            background: var(--ink);
            color: #fff;
            font-family: 'IBM Plex Mono', monospace;
            font-size: 11px;
            font-weight: 600;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .summary-name { flex: 1; min-width: 0; font-size: 14px; font-weight: 500; line-height: 20px; }
        .summary-name small { display: block; color: var(--ink-faint); font-size: 12px; }
        .summary-line { font-family: 'IBM Plex Mono', monospace; font-weight: 600; font-size: 13px; }

        .summary-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 14px;
            color: var(--ink-soft);
            margin-bottom: 14px;
        }
        .summary-row span:last-child { font-family: 'IBM Plex Mono', monospace; font-weight: 600; color: var(--ink); font-size: 13px; }
        .summary-row .free { color: var(--teal); }
        .total-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 15px;
            font-weight: 600;
            border-top: 1px dashed var(--line);
            padding-top: 18px;
            margin-top: 6px;
        }
        .total-row span:last-child { font-family: 'IBM Plex Mono', monospace; font-size: 24px; font-weight: 600; letter-spacing: -0.02em; }

        .place-order-btn {
            background: var(--mango);
            color: var(--ink);
            width: 100%;
            height: 50px;
            border: none;
            border-radius: var(--radius-ctl);
            font-size: 15px;
            font-weight: 600;
            letter-spacing: 0.01em;
            font-family: 'Inter', sans-serif;
            cursor: pointer;
            margin-top: 22px;
            transition: background 0.2s var(--ease-in-out), transform 0.2s var(--ease-out), box-shadow 0.3s var(--ease-out);
            box-shadow: 0 10px 24px -12px rgba(255, 122, 41, 0.6);
        }
        .place-order-btn:hover { background: var(--mango-deep); transform: translateY(-1px); }
        .place-order-btn:active { transform: scale(0.98); transition-duration: 0.12s; }
        .place-order-btn:disabled { background: var(--surface-2); color: var(--ink-faint); cursor: not-allowed; box-shadow: none; transform: none; }
        .secure-note { margin: 14px 0 0; font-size: 12px; color: var(--ink-faint); text-align: center; }

        /* Empty state */
        .empty-checkout { grid-column: 1 / -1; text-align: center; padding: 72px 24px; background: var(--surface); border: 1px solid var(--line); border-radius: var(--radius-panel); }
        .empty-checkout h2 { justify-content: center; margin-bottom: 8px; }
        .empty-checkout h2::before { display: none; }
        .empty-checkout p { margin: 0 0 24px; color: var(--ink-soft); font-size: 14px; }
        .primary-link {
            display: inline-block;
            background: var(--mango);
            color: var(--ink);
            text-decoration: none;
            height: 48px;
            line-height: 48px;
            padding: 0 28px;
            border-radius: var(--radius-ctl);
            font-size: 15px;
            font-weight: 600;
            transition: background 0.2s var(--ease-in-out), transform 0.2s var(--ease-out);
        }
        .primary-link:hover { background: var(--mango-deep); transform: translateY(-1px); }
        .secondary-link {
            display: inline-block;
            color: var(--ink);
            text-decoration: none;
            height: 48px;
            line-height: 46px;
            padding: 0 24px;
            border: 1px solid var(--line);
            border-radius: var(--radius-ctl);
            font-size: 15px;
            font-weight: 600;
            background: var(--surface);
            transition: border-color 0.2s var(--ease-in-out), background 0.2s var(--ease-in-out);
        }
        .secondary-link:hover { border-color: var(--mango); background: var(--mango-tint); }

        /* Success dialog */
        .popup-overlay {
            position: fixed;
            inset: 0;
            background: rgba(18, 24, 27, 0.45);
            -webkit-backdrop-filter: blur(4px);
            backdrop-filter: blur(4px);
            display: none;
            align-items: center;
            justify-content: center;
            padding: 20px;
            z-index: 300;
        }
        .popup-overlay.show { display: flex; }
        .popup-card {
            background: var(--surface);
            border-radius: 24px;
            padding: 40px 32px 32px;
            width: 100%;
            max-width: 400px;
            text-align: center;
            box-shadow: var(--shadow-3);
            animation: popIn 0.45s var(--ease-spring);
        }
        @keyframes popIn { from { opacity: 0; transform: scale(0.9); } to { opacity: 1; transform: scale(1); } }
        .popup-icon {
            width: 64px;
            height: 64px;
            margin: 0 auto 20px;
            border-radius: 50%;
            background: var(--success-soft);
            color: var(--success);
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .popup-icon svg { width: 30px; height: 30px; }
        .popup-card h3 { margin: 0 0 8px; font-size: 22px; font-weight: 700; letter-spacing: -0.01em; }
        .popup-card p { margin: 0 0 6px; color: var(--ink-soft); font-size: 14px; line-height: 22px; }
        .order-id { font-family: 'IBM Plex Mono', monospace; font-weight: 600; color: var(--ink); font-size: 16px; margin: 14px 0 6px !important; }
        .popup-actions { display: flex; flex-direction: column; gap: 10px; margin-top: 24px; }
        .popup-actions a { line-height: 46px; height: 48px; text-align: center; }

        @media (prefers-reduced-motion: reduce) {
            *, *::before, *::after { animation-duration: 0.01ms !important; transition-duration: 0.01ms !important; }
        }
    </style>
</head>
<body>

    <nav>
        <a href="/shop" class="logo">
            <span class="logo-word">S<span class="logo-span">TEFA</span></span>
        </a>
        <div class="nav-right">
            <span class="nav-context">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="4" y="11" width="16" height="10" rx="2"></rect><path d="M8 11V8a4 4 0 0 1 8 0v3"></path></svg>
                Secure checkout
            </span>
            <a href="/cart" class="back-link">Back to bag</a>
        </div>
    </nav>

    <main id="checkout-main">
        <h1 class="page-title">Checkout</h1>

        <!-- Left: shipping and payment -->
        <section id="checkout-form-area">
            <form id="checkout-form" novalidate>
                <div class="checkout-block">
                    <h2><span class="step-num">1</span> Shipping information</h2>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="ship-name">Recipient full name</label>
                            <input type="text" id="ship-name" placeholder="Stefan Dev" autocomplete="name" required>
                        </div>
                        <div class="form-group">
                            <label for="ship-phone">Contact phone number</label>
                            <input type="tel" id="ship-phone" placeholder="+63 917 123 4567" autocomplete="tel" required>
                        </div>
                    </div>
                    <div class="form-group" style="margin-bottom: 16px;">
                        <label for="ship-address">Street address / apartment / suite</label>
                        <input type="text" id="ship-address" placeholder="123 Emerald Street, Barangay Center" autocomplete="street-address" required>
                    </div>
                    <div class="form-row" style="margin-bottom: 0;">
                        <div class="form-group">
                            <label for="ship-city">City / municipality</label>
                            <input type="text" id="ship-city" placeholder="Tagoloan" autocomplete="address-level2" required>
                        </div>
                        <div class="form-group">
                            <label for="ship-zip">Postal zip code</label>
                            <input type="text" id="ship-zip" placeholder="9001" autocomplete="postal-code" required>
                        </div>
                    </div>
                </div>

                <div class="checkout-block">
                    <h2><span class="step-num">2</span> Payment method</h2>
                    <div class="pay-options">
                        <label class="pay-card active">
                            <input type="radio" name="payment" value="Cash on Delivery" checked>
                            <span>Cash on Delivery</span>
                        </label>
                        <label class="pay-card disabled">
                            <input type="radio" name="payment" value="Card" disabled>
                            <span>Credit / Debit Card</span>
                            <span class="pay-soon">Soon</span>
                        </label>
                    </div>
                    <p class="pay-note">Pay in cash when your order arrives. Card payments aren't connected yet.</p>
                </div>
            </form>
        </section>

        <!-- Right: real order summary -->
        <aside class="summary-sidebar" id="summary-sidebar">
            <h3>Order summary</h3>
            <div class="summary-items" id="summary-items"></div>

            <div class="summary-row">
                <span>Items subtotal</span>
                <span id="sum-subtotal">$0.00</span>
            </div>
            <div class="summary-row">
                <span>Estimated shipping</span>
                <span class="free">FREE</span>
            </div>
            <div class="summary-row">
                <span>Tax</span>
                <span>$0.00</span>
            </div>

            <div class="total-row">
                <span>Total due</span>
                <span id="sum-total">$0.00</span>
            </div>

            <button type="submit" form="checkout-form" class="place-order-btn" id="place-order-btn">Place order</button>
            <p class="secure-note">You'll get an order number as soon as it's placed.</p>
        </aside>
    </main>

    <!-- Success dialog -->
    <div class="popup-overlay" id="success-popup" role="dialog" aria-modal="true" aria-labelledby="popup-title">
        <div class="popup-card">
            <div class="popup-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12.5l4.5 4.5L19 7.5"></path></svg>
            </div>
            <h3 id="popup-title">Order placed</h3>
            <p class="order-id" id="popup-order-id"></p>
            <p>Estimated delivery in 3-5 business days. Pay in cash when it arrives.</p>
            <div class="popup-actions">
                <a href="/profile" class="primary-link">View my orders</a>
                <a href="/shop" class="secondary-link">Keep shopping</a>
            </div>
        </div>
    </div>

    <script>
        // Checkout is for logged-in shoppers. Their items stay saved in the browser.
        if (localStorage.getItem('user_authenticated') !== 'true') {
            window.location.href = '/login';
        }

        function readJSON(key, fallback) {
            try { return JSON.parse(localStorage.getItem(key)) || fallback; } catch (e) { return fallback; }
        }
        function money(n) { return '$' + Number(n).toFixed(2); }
        function esc(value) {
            return String(value == null ? '' : value)
                .replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;')
                .replace(/"/g, '&quot;').replace(/'/g, '&#39;');
        }

        const FALLBACK_THUMB = 'data:image/svg+xml;utf8,' + encodeURIComponent(`
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 68 68">
                <rect width="68" height="68" fill="#F3F4EF"/>
                <path d="M20 44l9-11 7 8 6-7 11 13H20z" fill="#CBD3CE"/>
                <circle cx="26" cy="24" r="5" fill="#CBD3CE"/>
            </svg>
        `);

        // The items the cart (or Buy Now) sent over
        const items = readJSON('stefashop_checkout_items', []);
        const subtotal = items.reduce((sum, item) => sum + item.price * item.quantity, 0);

        // ---------- Empty state ----------
        if (items.length === 0) {
            document.getElementById('checkout-main').innerHTML = `
                <h1 class="page-title">Checkout</h1>
                <div class="empty-checkout">
                    <h2>Nothing to check out yet</h2>
                    <p>Pick the items you want in your bag first, then come back here.</p>
                    <a href="/cart" class="primary-link">Go to my bag</a>
                </div>`;
        } else {
            // ---------- Summary ----------
            document.getElementById('summary-items').innerHTML = items.map(item => `
                <div class="summary-item">
                    <div class="summary-thumb">
                        <img src="${esc(item.image || FALLBACK_THUMB)}" alt="" onerror="this.onerror=null; this.src=FALLBACK_THUMB;">
                        <span class="summary-qty">${item.quantity}</span>
                    </div>
                    <div class="summary-name">${esc(item.name)}<small>${esc(item.category)}</small></div>
                    <div class="summary-line">${money(item.price * item.quantity)}</div>
                </div>
            `).join('');
            document.getElementById('sum-subtotal').textContent = money(subtotal);
            document.getElementById('sum-total').textContent = money(subtotal);

            // ---------- Prefill shipping from the saved profile ----------
            const authUser = readJSON('auth_user', {});
            const profile = readJSON('stefashop_profile', {});
            document.getElementById('ship-name').value = profile.name || authUser.name || '';
            document.getElementById('ship-phone').value = profile.phone || '';
            document.getElementById('ship-address').value = profile.address || '';
            document.getElementById('ship-city').value = profile.city || '';

            // ---------- Payment card highlight ----------
            document.querySelectorAll('.pay-card input[type="radio"]').forEach(radio => {
                radio.addEventListener('change', () => {
                    document.querySelectorAll('.pay-card').forEach(card => card.classList.remove('active'));
                    radio.closest('.pay-card').classList.add('active');
                });
            });

            // ---------- Place order ----------
            const form = document.getElementById('checkout-form');
            const placeBtn = document.getElementById('place-order-btn');
            const required = ['ship-name', 'ship-phone', 'ship-address', 'ship-city', 'ship-zip'].map(id => document.getElementById(id));

            required.forEach(input => input.addEventListener('input', () => input.classList.remove('invalid')));

            form.addEventListener('submit', async function (e) {
                e.preventDefault();

                const missing = required.filter(input => !input.value.trim());
                required.forEach(input => input.classList.toggle('invalid', !input.value.trim()));
                if (missing.length) {
                    missing[0].focus();
                    return;
                }

                const token = localStorage.getItem('auth_token');
                if (!token) {
                    window.location.href = '/login';
                    return;
                }

                const originalText = placeBtn.textContent;
                placeBtn.disabled = true;
                placeBtn.textContent = 'Placing order...';

                const headers = {
                    'Authorization': 'Bearer ' + token,
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                };

                try {
                    // The bag stores names, not product ids, so look each id up first
                    const apiItems = [];
                    for (const item of items) {
                        let productId = item.id;
                        if (!productId) {
                            const res = await fetch('/api/products?search=' + encodeURIComponent(item.name), { headers });
                            if (res.status === 401) throw new Error('AUTH');
                            const json = await res.json();
                            const match = (json.data || []).find(p => p.name === item.name);
                            if (!match) throw new Error('Product not found: ' + item.name);
                            productId = match.id;
                        }
                        apiItems.push({ product_id: productId, quantity: item.quantity });
                    }

                    const response = await fetch('/api/orders', {
                        method: 'POST',
                        headers: headers,
                        body: JSON.stringify({ items: apiItems })
                    });

                    if (response.status === 401) throw new Error('AUTH');
                    if (response.status === 403) throw new Error('Only customer accounts can place orders.');

                    const result = await response.json();
                    if (!response.ok) throw new Error(result.message || 'Could not place the order.');

                    const apiOrder = result.data || result;
                    const orderId = '#STF-' + String(apiOrder.id).padStart(5, '0');

                    const order = {
                        id: orderId,
                        api_id: apiOrder.id,
                        placed_at: new Date().toISOString(),
                        payment: document.querySelector('input[name="payment"]:checked').value,
                        status: 'Processing delivery',
                        total: subtotal,
                        items: items,
                        shipping: {
                            name: required[0].value.trim(),
                            phone: required[1].value.trim(),
                            address: required[2].value.trim(),
                            city: required[3].value.trim(),
                            zip: required[4].value.trim()
                        }
                    };

                    // Keep a local copy of the shipping details, then take the purchased items out of the bag
                    const orders = readJSON('stefashop_orders', []);
                    orders.unshift(order);
                    localStorage.setItem('stefashop_orders', JSON.stringify(orders));

                    const boughtNames = items.map(item => item.name);
                    const remaining = readJSON('stefashop_cart', []).filter(item => !boughtNames.includes(item.name));
                    localStorage.setItem('stefashop_cart', JSON.stringify(remaining));
                    localStorage.removeItem('stefashop_checkout_items');

                    document.getElementById('popup-order-id').textContent = 'Order ' + orderId;
                    document.getElementById('success-popup').classList.add('show');
                } catch (err) {
                    placeBtn.disabled = false;
                    placeBtn.textContent = originalText;
                    if (err.message === 'AUTH') {
                        alert('Your session has expired. Please log in again.');
                        window.location.href = '/login';
                    } else {
                        alert(err.message);
                    }
                }
            });
        }
    </script>

</body>
</html>