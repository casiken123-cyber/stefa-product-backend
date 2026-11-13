<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stefa - Shopping Bag</title>
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
            --danger: #B63A3A;
            --danger-soft: #FBE9E7;

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
        .back-link {
            text-decoration: none;
            color: var(--ink-soft);
            font-size: 14px;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 9px 14px;
            border-radius: var(--radius-ctl);
            transition: background 0.2s var(--ease-in-out), color 0.2s var(--ease-in-out);
        }
        .back-link:hover { color: var(--ink); background: var(--surface-2); }
        .back-link svg { width: 16px; height: 16px; transition: transform 0.32s var(--ease-out); }
        .back-link:hover svg { transform: translateX(-3px); }

        /* ===================== Layout ===================== */
        main { max-width: 1160px; margin: 40px auto 72px; padding: 0 40px; }
        .page-title {
            font-size: 32px;
            line-height: 40px;
            font-weight: 700;
            margin: 0 0 24px 0;
            letter-spacing: -0.02em;
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .page-title::before { content: ""; width: 8px; height: 8px; background: var(--mango); border-radius: 2px; display: inline-block; }

        .cart-wrapper { display: grid; grid-template-columns: 1fr 360px; gap: 28px; align-items: start; }
        @media (max-width: 900px) {
            nav { padding: 12px 20px; }
            main { padding: 0 20px; margin-top: 28px; }
            .cart-wrapper { grid-template-columns: 1fr; }
        }

        .cart-items-panel {
            background: var(--surface);
            border: 1px solid var(--line);
            border-radius: var(--radius-panel);
            box-shadow: var(--shadow-1);
            overflow: hidden;
        }

        /* Toolbar: select all + remove selected */
        .cart-toolbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 16px 28px;
            border-bottom: 1px solid var(--line);
            background: var(--surface-2);
            gap: 12px;
        }
        .select-all { display: flex; align-items: center; gap: 12px; font-size: 14px; font-weight: 600; color: var(--ink); cursor: pointer; }
        .remove-selected {
            background: none;
            border: none;
            color: var(--danger);
            font-family: inherit;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            padding: 8px 12px;
            border-radius: 10px;
            transition: background 0.2s var(--ease-in-out);
        }
        .remove-selected:hover { background: var(--danger-soft); }
        .remove-selected:disabled { color: var(--ink-faint); cursor: not-allowed; background: none; }

        .items-list { padding: 0 28px; }

        .item-row {
            display: flex;
            align-items: center;
            gap: 16px;
            padding: 20px 0;
            border-bottom: 1px solid var(--line);
            transition: opacity 0.3s ease, transform 0.3s var(--ease-out);
            animation: rowIn 0.4s var(--ease-out) both;
            animation-delay: calc(min(var(--i, 0), 6) * 40ms);
        }
        @keyframes rowIn { from { opacity: 0; transform: translateY(8px); } to { opacity: 1; transform: none; } }
        .item-row:last-child { border-bottom: none; }
        .item-row.removing { opacity: 0; transform: translateX(16px); }
        .item-row.unselected .item-thumb, .item-row.unselected .item-details { opacity: 0.55; }

        .item-select, .select-all input { width: 18px; height: 18px; accent-color: var(--mango); cursor: pointer; flex-shrink: 0; }

        .item-thumb {
            width: 76px;
            height: 76px;
            background: var(--surface-2);
            border: 1px solid var(--line);
            border-radius: 14px;
            overflow: hidden;
            flex-shrink: 0;
            transition: opacity 0.2s ease;
        }
        .item-thumb img { width: 100%; height: 100%; object-fit: cover; display: block; }

        .item-details { flex: 1; min-width: 0; display: flex; flex-direction: column; gap: 6px; transition: opacity 0.2s ease; }
        .item-name {
            font-family: 'Space Grotesk', sans-serif;
            font-size: 16px;
            line-height: 22px;
            font-weight: 600;
            margin: 0;
            color: var(--ink);
            letter-spacing: -0.01em;
        }
        .item-tag {
            background: var(--surface-2);
            color: var(--teal);
            font-family: 'IBM Plex Mono', monospace;
            font-size: 11px;
            line-height: 16px;
            font-weight: 500;
            padding: 3px 8px;
            border-radius: 6px;
            width: fit-content;
            text-transform: uppercase;
            letter-spacing: 0.04em;
        }
        .item-unit { font-size: 13px; color: var(--ink-faint); }

        .qty-box {
            display: flex;
            align-items: center;
            border: 1px solid var(--line);
            border-radius: var(--radius-ctl);
            overflow: hidden;
            background: var(--surface-2);
            flex-shrink: 0;
            transition: border-color 0.2s var(--ease-in-out), box-shadow 0.2s var(--ease-in-out);
        }
        .qty-box:focus-within { border-color: var(--mango); box-shadow: var(--ring); }
        .qty-btn {
            background: none;
            border: none;
            width: 36px;
            height: 40px;
            font-size: 16px;
            font-weight: 600;
            color: var(--ink);
            cursor: pointer;
            transition: background 0.2s var(--ease-in-out), color 0.2s var(--ease-in-out);
        }
        .qty-btn:hover { background: var(--mango-tint); }
        .qty-btn:active { transform: scale(0.92); }
        .qty-input {
            width: 42px;
            height: 40px;
            text-align: center;
            font-size: 14px;
            font-weight: 600;
            font-family: 'Inter', sans-serif;
            color: var(--ink);
            border: none;
            border-left: 1px solid var(--line);
            border-right: 1px solid var(--line);
            background: var(--surface);
            outline: none;
            -moz-appearance: textfield;
        }
        .qty-input::-webkit-outer-spin-button,
        .qty-input::-webkit-inner-spin-button { -webkit-appearance: none; margin: 0; }

        .item-price {
            font-family: 'IBM Plex Mono', monospace;
            font-size: 16px;
            font-weight: 600;
            letter-spacing: -0.02em;
            color: var(--ink);
            width: 88px;
            text-align: right;
            flex-shrink: 0;
        }

        .item-delete {
            background: none;
            border: none;
            width: 36px;
            height: 36px;
            border-radius: 50%;
            color: var(--ink-faint);
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            transition: background 0.2s var(--ease-in-out), color 0.2s var(--ease-in-out);
        }
        .item-delete:hover { background: var(--danger-soft); color: var(--danger); }
        .item-delete svg { width: 18px; height: 18px; }

        @media (max-width: 640px) {
            .cart-toolbar, .items-list { padding-left: 20px; padding-right: 20px; }
            .item-row { flex-wrap: wrap; row-gap: 12px; }
            .item-details { flex-basis: calc(100% - 140px); }
            .item-price { width: auto; margin-left: auto; }
        }

        /* Empty state */
        .empty-cart { text-align: center; padding: 72px 24px; }
        .empty-cart h3 { margin: 0 0 8px; font-size: 20px; font-weight: 600; }
        .empty-cart p { margin: 0 0 24px; color: var(--ink-soft); font-size: 14px; }

        /* ===================== Summary ===================== */
        .checkout-side {
            background: var(--surface);
            border: 1px solid var(--line);
            border-radius: var(--radius-panel);
            padding: 28px;
            position: sticky;
            top: 96px;
            box-shadow: var(--shadow-1);
        }
        @media (max-width: 900px) { .checkout-side { position: static; } }
        .checkout-side h3 { margin: 0 0 20px 0; font-size: 18px; font-weight: 600; letter-spacing: -0.01em; }
        .summary-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 14px;
            color: var(--ink-soft);
            margin-bottom: 14px;
        }
        .summary-row span:last-child { font-family: 'IBM Plex Mono', monospace; font-weight: 600; font-size: 13px; color: var(--ink); }
        .summary-row .free { color: var(--teal) !important; }
        .total-box {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-top: 1px dashed var(--line);
            padding-top: 18px;
            margin-top: 6px;
            margin-bottom: 22px;
        }
        .total-box .total-label { font-size: 15px; font-weight: 600; color: var(--ink); }
        .total-box .total-value {
            font-family: 'IBM Plex Mono', monospace;
            font-size: 24px;
            font-weight: 600;
            color: var(--ink);
            letter-spacing: -0.02em;
        }

        .checkout-btn, .primary-link {
            background: var(--mango);
            color: var(--ink);
            display: block;
            text-decoration: none;
            text-align: center;
            width: 100%;
            height: 50px;
            line-height: 50px;
            padding: 0;
            border: none;
            border-radius: var(--radius-ctl);
            font-size: 15px;
            font-weight: 600;
            letter-spacing: 0.01em;
            font-family: 'Inter', sans-serif;
            cursor: pointer;
            transition: background 0.2s var(--ease-in-out), transform 0.2s var(--ease-out), box-shadow 0.3s var(--ease-out);
            box-shadow: 0 10px 24px -12px rgba(255, 122, 41, 0.6);
        }
        .checkout-btn:hover, .primary-link:hover { background: var(--mango-deep); transform: translateY(-1px); }
        .checkout-btn:active, .primary-link:active { transform: scale(0.98); transition-duration: 0.12s; }
        .checkout-btn:disabled { background: var(--surface-2); color: var(--ink-faint); cursor: not-allowed; box-shadow: none; transform: none; }
        .primary-link { display: inline-block; width: auto; padding: 0 28px; }
        .secure-note { margin: 14px 0 0; font-size: 12px; color: var(--ink-faint); text-align: center; }

        /* Toast */
        .toast {
            position: fixed;
            left: 50%;
            bottom: 28px;
            transform: translate(-50%, 16px);
            background: var(--ink);
            color: #fff;
            padding: 12px 18px;
            border-radius: var(--radius-ctl);
            font-size: 14px;
            font-weight: 500;
            box-shadow: var(--shadow-3);
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.2s var(--ease-in-out), transform 0.32s var(--ease-out);
            z-index: 200;
        }
        .toast.show { opacity: 1; transform: translate(-50%, 0); }

        @media (prefers-reduced-motion: reduce) {
            *, *::before, *::after { animation-duration: 0.01ms !important; animation-delay: 0ms !important; transition-duration: 0.01ms !important; }
        }
    </style>
</head>
<body>

    <nav>
        <a href="/shop" class="logo">
            <span class="logo-word">S<span class="logo-span">TEFA</span></span>
        </a>
        <a href="/shop" class="back-link">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 12H5M12 19l-7-7 7-7"></path></svg>
            Back to catalog
        </a>
    </nav>

    <main>
        <h1 class="page-title">Your shopping bag</h1>

        <div class="cart-wrapper">
            <div class="cart-items-panel" id="cart-panel">
                <div class="cart-toolbar" id="cart-toolbar">
                    <label class="select-all">
                        <input type="checkbox" id="select-all">
                        <span id="select-all-label">Select all</span>
                    </label>
                    <button type="button" class="remove-selected" id="remove-selected">Remove selected</button>
                </div>
                <div class="items-list" id="cart-list-container"></div>
            </div>

            <aside class="checkout-side">
                <h3>Order summary</h3>
                <div class="summary-row">
                    <span id="cart-selected-count">0 items selected</span>
                    <span id="cart-items-subtotal">$0.00</span>
                </div>
                <div class="summary-row">
                    <span>Shipping</span>
                    <span class="free">FREE</span>
                </div>
                <div class="total-box">
                    <span class="total-label">Cart subtotal</span>
                    <span class="total-value" id="cart-grand-total">$0.00</span>
                </div>
                <button class="checkout-btn" id="checkout-btn" onclick="proceedToCheckout()">Proceed to shipping info</button>
                <p class="secure-note">Only the items you tick go to checkout.</p>
            </aside>
        </div>
    </main>

    <div class="toast" id="toast" role="status" aria-live="polite"></div>

    <script>
        const listContainer = document.getElementById("cart-list-container");
        const totalDisplay = document.getElementById("cart-grand-total");
        const subtotalDisplay = document.getElementById("cart-items-subtotal");
        const selectedCountDisplay = document.getElementById("cart-selected-count");
        const checkoutBtn = document.getElementById("checkout-btn");
        const selectAllBox = document.getElementById("select-all");
        const selectAllLabel = document.getElementById("select-all-label");
        const removeSelectedBtn = document.getElementById("remove-selected");
        const toolbar = document.getElementById("cart-toolbar");

        const MAX_QTY = 99;

        const FALLBACK_THUMB = 'data:image/svg+xml;utf8,' + encodeURIComponent(`
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 68 68">
                <rect width="68" height="68" fill="#F3F4EF"/>
                <path d="M20 44l9-11 7 8 6-7 11 13H20z" fill="#CBD3CE"/>
                <circle cx="26" cy="24" r="5" fill="#CBD3CE"/>
            </svg>
        `);

        // Escapes text before it goes into innerHTML, so product names can't break or inject markup
        function esc(value) {
            return String(value == null ? '' : value)
                .replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;')
                .replace(/"/g, '&quot;').replace(/'/g, '&#39;');
        }

        function money(n) { return '$' + Number(n).toFixed(2); }

        let toastTimer;
        function showToast(message) {
            const toast = document.getElementById('toast');
            toast.textContent = message;
            toast.classList.add('show');
            clearTimeout(toastTimer);
            toastTimer = setTimeout(() => toast.classList.remove('show'), 2200);
        }

        let cartItems = [];
        try { cartItems = JSON.parse(localStorage.getItem("stefashop_cart")) || []; } catch (e) { cartItems = []; }
        // Default every item to selected the first time it's seen
        cartItems = cartItems.map(item => ({ selected: true, quantity: 1, ...item }));

        function persistCart() {
            localStorage.setItem("stefashop_cart", JSON.stringify(cartItems));
        }

        function renderCart() {
            if (cartItems.length === 0) {
                toolbar.style.display = 'none';
                listContainer.innerHTML = `
                    <div class="empty-cart">
                        <h3>Your bag is empty</h3>
                        <p>Add something you like and it will show up here.</p>
                        <a href="/shop" class="primary-link">Browse the shop</a>
                    </div>`;
                recalcTotal();
                return;
            }

            toolbar.style.display = 'flex';
            listContainer.innerHTML = cartItems.map((item, index) => `
                <div class="item-row ${item.selected ? '' : 'unselected'}" data-index="${index}" style="--i: ${index}">
                    <input type="checkbox" class="item-select" aria-label="Select ${esc(item.name)}" ${item.selected ? 'checked' : ''} onchange="toggleSelect(${index}, this.checked)">
                    <div class="item-thumb">
                        <img src="${esc(item.image || FALLBACK_THUMB)}" alt="${esc(item.name)}" onerror="this.onerror=null; this.src=FALLBACK_THUMB;">
                    </div>
                    <div class="item-details">
                        <p class="item-name">${esc(item.name)}</p>
                        <span class="item-tag">${esc(item.category)}</span>
                        <span class="item-unit">${money(item.price)} each</span>
                    </div>
                    <div class="qty-box">
                        <button type="button" class="qty-btn" aria-label="Decrease quantity" onclick="stepQty(${index}, -1)">−</button>
                        <input type="number" class="qty-input" min="1" max="${MAX_QTY}" value="${item.quantity}" aria-label="Quantity" onchange="setQty(${index}, this.value)">
                        <button type="button" class="qty-btn" aria-label="Increase quantity" onclick="stepQty(${index}, 1)">+</button>
                    </div>
                    <div class="item-price">${money(item.price * item.quantity)}</div>
                    <button type="button" class="item-delete" title="Remove item" aria-label="Remove ${esc(item.name)}" onclick="deleteItem(${index})">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M4 7h16M9 7V4h6v3M6 7l1 13h10l1-13"></path></svg>
                    </button>
                </div>
            `).join("");

            recalcTotal();
        }

        function recalcTotal() {
            const selectedItems = cartItems.filter(item => item.selected);
            const total = selectedItems.reduce((sum, item) => sum + item.price * item.quantity, 0);
            const units = selectedItems.reduce((sum, item) => sum + item.quantity, 0);

            totalDisplay.innerText = money(total);
            subtotalDisplay.innerText = money(total);
            selectedCountDisplay.innerText = units + (units === 1 ? " item selected" : " items selected");
            checkoutBtn.disabled = selectedItems.length === 0;

            // Toolbar state
            const allSelected = cartItems.length > 0 && selectedItems.length === cartItems.length;
            selectAllBox.checked = allSelected;
            selectAllBox.indeterminate = selectedItems.length > 0 && !allSelected;
            selectAllLabel.innerText = selectedItems.length > 0
                ? selectedItems.length + " of " + cartItems.length + " selected"
                : "Select all";
            removeSelectedBtn.disabled = selectedItems.length === 0;

            persistCart();
        }

        function toggleSelect(index, checked) {
            cartItems[index].selected = checked;
            const row = listContainer.querySelector(`.item-row[data-index="${index}"]`);
            if (row) row.classList.toggle('unselected', !checked);
            recalcTotal();
        }

        selectAllBox.addEventListener('change', function () {
            cartItems.forEach(item => { item.selected = selectAllBox.checked; });
            renderCart();
        });

        removeSelectedBtn.addEventListener('click', function () {
            const count = cartItems.filter(item => item.selected).length;
            if (count === 0) return;
            cartItems = cartItems.filter(item => !item.selected);
            persistCart();
            renderCart();
            showToast(count + (count === 1 ? " item removed" : " items removed"));
        });

        function setQty(index, value) {
            let qty = parseInt(value, 10);
            if (isNaN(qty) || qty < 1) qty = 1;
            if (qty > MAX_QTY) qty = MAX_QTY;
            cartItems[index].quantity = qty;
            const row = listContainer.querySelector(`.item-row[data-index="${index}"]`);
            row.querySelector(".qty-input").value = qty;
            row.querySelector(".item-price").innerText = money(cartItems[index].price * qty);
            recalcTotal();
        }

        function stepQty(index, delta) {
            setQty(index, (cartItems[index].quantity || 1) + delta);
        }

        function deleteItem(index) {
            const name = cartItems[index].name;
            const row = listContainer.querySelector(`.item-row[data-index="${index}"]`);
            if (row) row.classList.add('removing');
            setTimeout(() => {
                cartItems.splice(index, 1);
                persistCart();
                renderCart();
                showToast(name + " removed from your bag");
            }, 280);
        }

        // Carries only the checked items forward to checkout, leaving the
        // full bag (including unselected items) intact in storage.
        function proceedToCheckout() {
            const selectedItems = cartItems.filter(item => item.selected);
            if (selectedItems.length === 0) return;
            localStorage.setItem("stefashop_checkout_items", JSON.stringify(selectedItems));
            window.location.href = "/checkout";
        }

        document.addEventListener("DOMContentLoaded", renderCart);
    </script>

</body>
</html>