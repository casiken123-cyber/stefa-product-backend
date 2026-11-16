<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stefa - My Account</title>
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
            --success: #1E8E5A;
            --success-soft: #E5F3EA;

            --radius-card: 18px;
            --radius-panel: 20px;
            --radius-ctl: 12px;

            --shadow-1: 0 1px 2px rgba(18, 24, 27, 0.04);
            --shadow-2: 0 8px 20px -8px rgba(18, 24, 27, 0.12);
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

        h1, h2, h3, h4 { font-family: 'Space Grotesk', sans-serif; }

        a:focus-visible, button:focus-visible, input:focus-visible, textarea:focus-visible, select:focus-visible {
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
        .logo {
            font-family: 'Space Grotesk', sans-serif;
            font-size: 25px;
            font-weight: 700;
            color: var(--ink);
            text-decoration: none;
            letter-spacing: -0.01em;
            line-height: 1;
        }
        .logo-accent { color: var(--mango); }
        .nav-links { display: flex; align-items: center; gap: 4px; }
        .nav-links a {
            text-decoration: none;
            color: var(--ink-soft);
            font-weight: 500;
            font-size: 14px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 9px 14px;
            border-radius: var(--radius-ctl);
            transition: background 0.2s var(--ease-in-out), color 0.2s var(--ease-in-out);
        }
        .nav-links a svg { width: 18px; height: 18px; }
        .nav-links a:hover { color: var(--ink); background: var(--surface-2); }
        .cart-count {
            min-width: 20px;
            height: 20px;
            padding: 0 6px;
            border-radius: 10px;
            background: var(--mango);
            color: var(--ink);
            font-family: 'IBM Plex Mono', monospace;
            font-size: 11px;
            font-weight: 600;
            display: none;
            align-items: center;
            justify-content: center;
        }
        .cart-count.has-items { display: inline-flex; }

        /* ===================== Layout ===================== */
        main {
            max-width: 1100px;
            margin: 48px auto 72px;
            padding: 0 32px;
            display: grid;
            grid-template-columns: 264px 1fr;
            gap: 32px;
            align-items: start;
        }
        @media (max-width: 800px) {
            nav { padding: 12px 20px; }
            main { grid-template-columns: 1fr; padding: 0 20px; margin-top: 28px; }
        }

        /* ===================== Sidebar ===================== */
        .profile-card {
            background: var(--surface);
            border: 1px solid var(--line);
            border-radius: var(--radius-panel);
            box-shadow: var(--shadow-1);
            padding: 32px 16px 16px;
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            position: sticky;
            top: 96px;
        }
        @media (max-width: 800px) { .profile-card { position: static; } }

        .avatar {
            width: 84px;
            height: 84px;
            border-radius: 50%;
            background: var(--teal);
            color: #fff;
            font-family: 'Space Grotesk', sans-serif;
            font-size: 32px;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 3px solid var(--mango);
            box-shadow: 0 0 0 4px var(--mango-tint);
            margin-bottom: 16px;
        }
        .profile-card h3 { margin: 0; font-size: 20px; line-height: 28px; font-weight: 700; letter-spacing: -0.01em; word-break: break-word; }
        .profile-email { margin: 2px 0 0; font-size: 13px; color: var(--ink-faint); word-break: break-all; }

        .sidebar-menu { display: flex; flex-direction: column; gap: 4px; margin-top: 24px; width: 100%; text-align: left; }
        .sidebar-link {
            position: relative;
            text-decoration: none;
            color: var(--ink-soft);
            font-size: 15px;
            font-weight: 500;
            padding: 10px 14px;
            min-height: 44px;
            display: flex;
            align-items: center;
            border-radius: var(--radius-ctl);
            transition: background 0.2s var(--ease-in-out), color 0.2s var(--ease-in-out);
        }
        .sidebar-link::before {
            content: "";
            position: absolute;
            left: 0;
            top: 10px;
            bottom: 10px;
            width: 3px;
            border-radius: 3px;
            background: var(--mango);
            transform: scaleY(0);
            transition: transform 0.32s var(--ease-out);
        }
        .sidebar-link:hover { background: var(--surface-2); color: var(--ink); }
        .sidebar-link.active { background: var(--mango-tint); color: var(--ink); font-weight: 600; }
        .sidebar-link.active::before { transform: scaleY(1); }
        .style-logout {
            color: var(--danger);
            margin-top: 12px;
        }
        .style-logout:hover { background: var(--danger-soft); color: var(--danger); }
        .logout-divider { height: 1px; background: var(--line); margin: 12px 8px 0; }

        /* ===================== Workspace ===================== */
        .workspace { display: flex; flex-direction: column; gap: 24px; min-width: 0; }

        /* Tab bar with sliding highlight */
        .tab-bar {
            position: relative;
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            background: var(--surface);
            border: 1px solid var(--line);
            padding: 5px;
            border-radius: 16px;
            box-shadow: var(--shadow-1);
        }
        .tab-indicator {
            position: absolute;
            top: 5px;
            bottom: 5px;
            left: 5px;
            width: calc((100% - 10px) / 4);
            border-radius: 11px;
            background: var(--mango-tint);
            transition: transform 0.45s var(--ease-out);
        }
        .tab-bar[data-index="1"] .tab-indicator { transform: translateX(100%); }
        .tab-bar[data-index="2"] .tab-indicator { transform: translateX(200%); }
        .tab-bar[data-index="3"] .tab-indicator { transform: translateX(300%); }
        .tab-btn {
            position: relative;
            z-index: 1;
            background: none;
            border: none;
            padding: 12px;
            font-size: 14px;
            font-weight: 600;
            color: var(--ink-soft);
            cursor: pointer;
            border-radius: 11px;
            font-family: 'Inter', sans-serif;
            transition: color 0.2s var(--ease-in-out);
        }
        .tab-btn:hover { color: var(--ink); }
        .tab-btn.active { color: var(--ink); }

        .tab-panel { display: none; flex-direction: column; gap: 24px; }
        .tab-panel.active { display: flex; animation: panelIn 0.4s var(--ease-out) both; }
        @keyframes panelIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: none; } }

        .details-panel {
            background: var(--surface);
            border: 1px solid var(--line);
            border-radius: var(--radius-panel);
            padding: 36px;
            box-shadow: var(--shadow-1);
        }
        @media (max-width: 560px) { .details-panel { padding: 24px 20px; } }
        h2 {
            font-size: 22px;
            line-height: 28px;
            font-weight: 700;
            margin: 0 0 28px 0;
            display: flex;
            align-items: center;
            gap: 12px;
            letter-spacing: -0.02em;
            color: var(--ink);
        }
        h2::before { content: ""; width: 8px; height: 8px; background: var(--mango); border-radius: 2px; display: inline-block; }

        /* Forms */
        .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px; }
        @media (max-width: 560px) { .form-row { grid-template-columns: 1fr; } }
        .form-group { display: flex; flex-direction: column; gap: 8px; transition: transform 0.3s var(--ease-out); }
        .form-group:focus-within { transform: scale(1.01); }

        label { font-size: 12px; font-weight: 600; color: var(--ink-soft); letter-spacing: 0.04em; }
        input, textarea, select {
            padding: 13px 16px;
            border-radius: var(--radius-ctl);
            border: 1px solid var(--line);
            font-size: 14px;
            outline: none;
            background: var(--surface-2);
            color: var(--ink);
            font-family: inherit;
            transition: border-color 0.2s var(--ease-in-out), background 0.2s var(--ease-in-out), box-shadow 0.2s var(--ease-in-out);
        }
        input:hover, textarea:hover, select:hover { border-color: #D3D6CD; }
        input:focus, textarea:focus, select:focus { border-color: var(--mango); background: var(--surface); box-shadow: var(--ring); }
        input[readonly] { color: var(--ink-faint); cursor: not-allowed; }

        /* Buttons */
        .save-btn {
            background: var(--ink);
            color: #fff;
            border: none;
            height: 44px;
            padding: 0 22px;
            border-radius: var(--radius-ctl);
            font-size: 14px;
            font-weight: 600;
            letter-spacing: 0.01em;
            cursor: pointer;
            transition: background 0.2s var(--ease-in-out), transform 0.2s var(--ease-out);
            width: fit-content;
            text-decoration: none;
            text-align: center;
            font-family: 'Inter', sans-serif;
        }
        .save-btn:hover { transform: translateY(-1px); }
        .save-btn:active { transform: scale(0.97); transition-duration: 0.12s; }
        .save-btn:disabled { opacity: 0.6; cursor: not-allowed; transform: none; }
        .save-btn.green-btn { background: var(--mango); color: var(--ink); }
        .save-btn.green-btn:hover { background: var(--mango-deep); }
        .save-btn.secondary-btn { background: var(--surface-2); color: var(--ink); border: 1px solid var(--line); }
        .save-btn.secondary-btn:hover { border-color: var(--mango); background: var(--mango-tint); }
        .save-btn.danger-btn { background: var(--danger-soft); color: var(--danger); }
        .save-btn.danger-btn:hover { background: #F5D2CE; }

        /* Orders */
        .order-item-box {
            border: 1px solid var(--line);
            border-radius: var(--radius-card);
            padding: 24px;
            margin-bottom: 16px;
            background: var(--surface);
            box-shadow: var(--shadow-1);
            transition: box-shadow 0.32s var(--ease-out), transform 0.32s var(--ease-out), opacity 0.3s ease;
        }
        .order-item-box:hover { box-shadow: var(--shadow-2); transform: translateY(-2px); }
        .order-item-box:last-child { margin-bottom: 0; }
        .order-item-box.removing { opacity: 0; transform: scale(0.98); }
        .order-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid var(--line);
            padding-bottom: 16px;
            margin-bottom: 16px;
            flex-wrap: wrap;
            gap: 8px;
        }
        .order-header strong { font-family: 'IBM Plex Mono', monospace; font-size: 14px; font-weight: 600; }
        .order-header span.date { color: var(--ink-faint); font-size: 12px; margin-left: 10px; }

        .status-badge {
            font-family: 'IBM Plex Mono', monospace;
            background: var(--teal-soft);
            color: var(--teal);
            padding: 5px 12px;
            border-radius: 30px;
            font-size: 11px;
            font-weight: 600;
            letter-spacing: 0.04em;
            display: inline-block;
        }
        .status-badge.complete { background: var(--success-soft); color: var(--success); }
        .status-badge.cancelled { background: var(--danger-soft); color: var(--danger); }

        .order-body { display: flex; justify-content: space-between; align-items: center; font-size: 14px; flex-wrap: wrap; gap: 12px; }
        .order-body p.item-name { margin: 0 0 4px; font-weight: 600; font-size: 15px; }
        .order-body p.item-sub { margin: 4px 0 0; color: var(--ink-soft); font-size: 13px; }
        .order-body p.item-sub.fulfilled { color: var(--success); font-weight: 600; }
        .order-body p.item-sub.cancelled-note { color: var(--danger); font-weight: 600; }
        .action-flex { display: flex; gap: 12px; align-items: center; }
        .price-tag { font-family: 'IBM Plex Mono', monospace; font-weight: 600; font-size: 18px; letter-spacing: -0.02em; }
        .reviewed-note { font-size: 13px; font-weight: 600; color: var(--success); }

        .unread-badge {
            display: none;
            min-width: 20px;
            height: 20px;
            padding: 0 6px;
            margin-left: 8px;
            border-radius: 10px;
            background: var(--mango);
            color: var(--ink);
            font-family: 'IBM Plex Mono', monospace;
            font-size: 11px;
            font-weight: 600;
            line-height: 20px;
            text-align: center;
        }
        .unread-badge.show { display: inline-block; }
        .notice-item {
            border: 1px solid var(--line);
            border-radius: var(--radius-card);
            padding: 16px 20px;
            margin-bottom: 12px;
            background: var(--surface);
        }
        .notice-item:last-child { margin-bottom: 0; }
        .notice-item.notice-new { border-color: var(--mango); background: var(--mango-tint); }
        .notice-item p { margin: 0 0 6px; font-size: 14px; font-weight: 500; line-height: 1.5; }
        .notice-item span { font-size: 12px; color: var(--ink-faint); }

        .empty-orders { color: var(--ink-soft); font-size: 14px; text-align: center; padding: 28px 0 8px; display: none; }
        .orders-status { color: var(--ink-soft); font-size: 14px; text-align: center; padding: 28px 0 8px; }

        /* Review form */
        .review-form-box { display: none; margin-top: 24px; padding-top: 24px; border-top: 1px solid var(--line); }
        .review-form-box.open { display: block; animation: panelIn 0.4s var(--ease-out) both; }
        .review-form-box h4 { font-size: 15px; font-weight: 700; margin: 0 0 16px 0; }
        .star-rating { display: flex; gap: 4px; }
        .star-rating .star { font-size: 28px; line-height: 1; cursor: pointer; color: var(--line); transition: color 0.1s, transform 0.2s var(--ease-spring); user-select: none; }
        .star-rating .star:hover { transform: scale(1.12); }
        .star-rating .star.filled { color: #E0A400; }
        .star-rating-label { font-size: 13px; color: var(--ink-soft); margin-top: 4px; }
        .review-done { color: var(--success); font-weight: 600; margin: 0; }

        /* Checkout info cards */
        .card-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
        @media (max-width: 560px) { .card-grid { grid-template-columns: 1fr; } }
        .info-card {
            background: var(--surface-2);
            border: 1px solid var(--line);
            border-radius: var(--radius-card);
            padding: 24px;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }
        .info-card h4 { margin: 0; font-size: 16px; font-weight: 600; }
        .info-card p { margin: 0; font-size: 14px; color: var(--ink-soft); line-height: 22px; }
        .info-card .save-btn { margin-top: 8px; }

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
            *, *::before, *::after { animation-duration: 0.01ms !important; transition-duration: 0.01ms !important; }
            .order-item-box:hover, .save-btn:hover { transform: none; }
        }
    </style>
</head>
<body>

    <nav>
        <a href="/shop" class="logo">S<span class="logo-accent">TEFA</span></a>
        <div class="nav-links">
            <a href="/shop">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7" rx="1.5"></rect><rect x="14" y="3" width="7" height="7" rx="1.5"></rect><rect x="3" y="14" width="7" height="7" rx="1.5"></rect><rect x="14" y="14" width="7" height="7" rx="1.5"></rect></svg>
                Products
            </a>
            <a href="/cart">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="21" r="1.5"></circle><circle cx="18" cy="21" r="1.5"></circle><path d="M2.5 3h2l2.7 12.4a2 2 0 0 0 2 1.6h7.6a2 2 0 0 0 2-1.6L21 8H6"></path></svg>
                Cart
                <span class="cart-count" id="cart-count">0</span>
            </a>
        </div>
    </nav>

    <main>
        <!-- Sidebar identity card -->
        <aside class="profile-card">
            <div class="avatar" id="avatar-initial" aria-hidden="true">S</div>
            <h3 id="sidebar-name">Your account</h3>
            <p class="profile-email" id="sidebar-email"></p>

            <div class="sidebar-menu">
                <a href="#" class="sidebar-link active" data-tab="info-section">Account Settings</a>
                <a href="#" class="sidebar-link" data-tab="orders-section">Order History</a>
                <a href="#" class="sidebar-link" data-tab="checkout-section">Checkout Info</a>
                <a href="#" class="sidebar-link" data-tab="notices-section">Notifications <span class="unread-badge" id="side-unread"></span></a>
                <a href="/cart" class="sidebar-link">Cart</a>
                <div class="logout-divider"></div>
                <a href="/shop" class="sidebar-link style-logout" id="logout-link">Log Out</a>
            </div>
        </aside>

        <section class="workspace">

            <div class="tab-bar" id="tab-bar" data-index="0" role="tablist">
                <span class="tab-indicator" aria-hidden="true"></span>
                <button class="tab-btn active" role="tab" data-tab="info-section">Account Settings</button>
                <button class="tab-btn" role="tab" data-tab="orders-section">Order History</button>
                <button class="tab-btn" role="tab" data-tab="checkout-section">Checkout Info</button>
                <button class="tab-btn" role="tab" data-tab="notices-section">Notifications <span class="unread-badge" id="tab-unread"></span></button>
            </div>

            <!-- TAB 1: Account settings (saved through the API) -->
            <div id="info-section" class="tab-panel active">
                <div class="details-panel">
                    <h2>Account information</h2>
                    <form id="profile-info-form">
                        <div class="form-row">
                            <div class="form-group">
                                <label for="input-full-name">Full name</label>
                                <input type="text" id="input-full-name" value="" required>
                            </div>
                            <div class="form-group">
                                <label for="input-email">Email address</label>
                                <input type="email" id="input-email" value="" readonly>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="input-phone">Contact phone number</label>
                                <input type="text" id="input-phone" placeholder="+63 917 123 4567" value="" required>
                            </div>
                            <div class="form-group">
                                <label for="input-city">Default shipping region / city</label>
                                <input type="text" id="input-city" placeholder="Tagoloan, Misamis Oriental" value="" required>
                            </div>
                        </div>

                        <div class="form-group" style="margin-bottom: 28px;">
                            <label for="input-address">Delivery street address</label>
                            <input type="text" id="input-address" placeholder="House/Apartment Number, Street Name, Barangay Name" value="" required>
                        </div>

                        <button type="submit" class="save-btn green-btn">Save changes</button>
                    </form>
                </div>

                <div class="details-panel">
                    <h2>Change password</h2>
                    <form id="password-form">
                        <div class="form-group" style="margin-bottom: 20px;">
                            <label for="pw-current">Current password</label>
                            <input type="password" id="pw-current" autocomplete="current-password" required>
                        </div>
                        <div class="form-row" style="margin-bottom: 28px;">
                            <div class="form-group">
                                <label for="pw-new">New password</label>
                                <input type="password" id="pw-new" minlength="8" placeholder="Minimum 8 characters" autocomplete="new-password" required>
                            </div>
                            <div class="form-group">
                                <label for="pw-confirm">Confirm new password</label>
                                <input type="password" id="pw-confirm" minlength="8" autocomplete="new-password" required>
                            </div>
                        </div>
                        <button type="submit" class="save-btn green-btn">Update password</button>
                    </form>
                </div>
            </div>

            <!-- TAB 2: Orders (loaded from the API) -->
            <div id="orders-section" class="tab-panel">
                <div class="details-panel">
                    <h2>Order history</h2>

                    <div id="orders-list">
                        <p class="orders-status">Loading your orders...</p>
                    </div>

                    <p class="empty-orders" id="empty-orders">You have no orders yet. Browse the shop to place your first one.</p>
                </div>
            </div>

            <!-- TAB 3: Checkout info -->
            <div id="checkout-section" class="tab-panel">
                <div class="details-panel">
                    <h2>Checkout information</h2>
                    <div class="card-grid">
                        <div class="info-card">
                            <h4>Shipping address</h4>
                            <p id="ship-summary"></p>
                            <button type="button" class="save-btn secondary-btn" data-tab-jump="info-section">Edit in account settings</button>
                        </div>
                        <div class="info-card">
                            <h4>Payment method</h4>
                            <p>Cash on Delivery is available at checkout.</p>
                            <a href="/checkout" class="save-btn secondary-btn" style="display: inline-flex; align-items: center; justify-content: center;">Go to checkout</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- TAB 4: Notifications (delivery updates the admin sends) -->
            <div id="notices-section" class="tab-panel">
                <div class="details-panel">
                    <h2>Notifications</h2>
                    <div id="notices-list">
                        <p class="orders-status">Loading your notifications...</p>
                    </div>
                </div>
            </div>

        </section>
    </main>

    <div class="toast" id="toast" role="status" aria-live="polite"></div>

    <script>
        // ---------- Session guard: profile is for logged-in users ----------
        if (localStorage.getItem('user_authenticated') !== 'true') {
            window.location.href = '/login';
        }

        function readJSON(key, fallback) {
            try { return JSON.parse(localStorage.getItem(key)) || fallback; } catch (e) { return fallback; }
        }
        function esc(value) {
            return String(value == null ? '' : value)
                .replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;')
                .replace(/"/g, '&quot;').replace(/'/g, '&#39;');
        }
        function money(n) { return '$' + Number(n || 0).toFixed(2); }

        let toastTimer;
        function showToast(message) {
            const toast = document.getElementById('toast');
            toast.textContent = message;
            toast.classList.add('show');
            clearTimeout(toastTimer);
            toastTimer = setTimeout(() => toast.classList.remove('show'), 2400);
        }

        function clearSession() {
            localStorage.removeItem('auth_token');
            localStorage.removeItem('auth_user');
            localStorage.removeItem('user_authenticated');
        }
        function sessionExpired() {
            clearSession();
            window.location.href = '/login';
        }
        function authHeaders() {
            return {
                'Authorization': 'Bearer ' + localStorage.getItem('auth_token'),
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            };
        }
        // First validation message from a failed response, or a fallback text
        function errorText(json, fallback) {
            if (json && json.errors) return Object.values(json.errors)[0][0];
            return (json && json.message) || fallback;
        }

        // ---------- Tabs ----------
        const TAB_ORDER = ['info-section', 'orders-section', 'checkout-section', 'notices-section'];

        function switchTab(sectionId) {
            document.querySelectorAll('.tab-panel').forEach(p => p.classList.remove('active'));
            document.getElementById(sectionId).classList.add('active');

            document.getElementById('tab-bar').dataset.index = TAB_ORDER.indexOf(sectionId);
            document.querySelectorAll('.tab-btn').forEach(b => b.classList.toggle('active', b.dataset.tab === sectionId));
            document.querySelectorAll('.sidebar-link[data-tab]').forEach(l => l.classList.toggle('active', l.dataset.tab === sectionId));

            if (sectionId === 'orders-section') loadOrders();
            if (sectionId === 'notices-section') loadNotices(true);
        }

        document.querySelectorAll('.tab-btn, .sidebar-link[data-tab]').forEach(el => {
            el.addEventListener('click', function (e) {
                e.preventDefault();
                switchTab(this.dataset.tab);
            });
        });
        document.querySelectorAll('[data-tab-jump]').forEach(el => {
            el.addEventListener('click', () => switchTab(el.dataset.tabJump));
        });

        // ---------- Profile data (GET/PUT /api/profile) ----------
        // The browser keeps a copy so checkout can prefill the shipping form instantly.
        const authUser = readJSON('auth_user', {});
        const saved = readJSON('stefashop_profile', {});

        const fields = {
            name: document.getElementById('input-full-name'),
            email: document.getElementById('input-email'),
            phone: document.getElementById('input-phone'),
            city: document.getElementById('input-city'),
            address: document.getElementById('input-address')
        };

        // Show the cached values straight away, then replace them with the saved ones
        fields.name.value = saved.name || authUser.name || '';
        fields.email.value = authUser.email || '';
        fields.phone.value = saved.phone || '';
        fields.city.value = saved.city || '';
        fields.address.value = saved.address || '';

        function cacheProfile() {
            localStorage.setItem('stefashop_profile', JSON.stringify({
                name: fields.name.value.trim(),
                phone: fields.phone.value.trim(),
                city: fields.city.value.trim(),
                address: fields.address.value.trim()
            }));
        }

        function refreshIdentity() {
            const name = fields.name.value.trim() || 'Your account';
            document.getElementById('sidebar-name').textContent = name;
            document.getElementById('sidebar-email').textContent = fields.email.value;
            document.getElementById('avatar-initial').textContent = name.charAt(0).toUpperCase();

            const summary = document.getElementById('ship-summary');
            summary.innerHTML = '';
            const lines = [name, fields.address.value, fields.city.value];
            lines.forEach((line, i) => {
                if (i > 0) summary.appendChild(document.createElement('br'));
                summary.appendChild(document.createTextNode(line));
            });
        }
        refreshIdentity();

        async function loadProfile() {
            try {
                const res = await fetch('/api/profile', { headers: authHeaders() });
                if (res.status === 401) { sessionExpired(); return; }
                if (!res.ok) return;

                const json = await res.json();
                const p = json.data || {};
                fields.name.value = p.name || '';
                fields.email.value = p.email || fields.email.value;
                fields.phone.value = p.phone || '';
                fields.city.value = p.city || '';
                fields.address.value = p.address || '';
                cacheProfile();
                refreshIdentity();
            } catch (err) {
                // keep the cached values
            }
        }

        document.getElementById('profile-info-form').addEventListener('submit', async function (e) {
            e.preventDefault();
            const button = this.querySelector('button[type="submit"]');
            button.disabled = true;

            try {
                const res = await fetch('/api/profile', {
                    method: 'PUT',
                    headers: authHeaders(),
                    body: JSON.stringify({
                        name: fields.name.value.trim(),
                        phone: fields.phone.value.trim(),
                        city: fields.city.value.trim(),
                        address: fields.address.value.trim()
                    })
                });

                if (res.status === 401) { sessionExpired(); return; }

                const json = await res.json().catch(() => ({}));
                if (!res.ok) throw new Error(errorText(json, 'Could not save your profile.'));

                cacheProfile();
                const user = readJSON('auth_user', {});
                user.name = fields.name.value.trim();
                localStorage.setItem('auth_user', JSON.stringify(user));
                refreshIdentity();
                showToast('Profile updated');
            } catch (err) {
                showToast(err.message);
            }

            button.disabled = false;
        });

        // ---------- Change password (PUT /api/profile/password) ----------
        document.getElementById('password-form').addEventListener('submit', async function (e) {
            e.preventDefault();

            const current = document.getElementById('pw-current').value;
            const next = document.getElementById('pw-new').value;
            const confirmation = document.getElementById('pw-confirm').value;

            if (next.length < 8) {
                showToast('The new password needs at least 8 characters.');
                return;
            }
            if (next !== confirmation) {
                showToast('The new passwords do not match.');
                return;
            }

            const button = this.querySelector('button[type="submit"]');
            button.disabled = true;

            try {
                const res = await fetch('/api/profile/password', {
                    method: 'PUT',
                    headers: authHeaders(),
                    body: JSON.stringify({
                        current_password: current,
                        password: next,
                        password_confirmation: confirmation
                    })
                });

                if (res.status === 401) { sessionExpired(); return; }

                const json = await res.json().catch(() => ({}));
                if (!res.ok) throw new Error(errorText(json, 'Could not change the password.'));

                this.reset();
                showToast('Password updated');
            } catch (err) {
                showToast(err.message);
            }

            button.disabled = false;
        });

        // ---------- Cart count ----------
        (function () {
            const total = readJSON('stefashop_cart', []).reduce((sum, item) => sum + (item.quantity || 1), 0);
            const badge = document.getElementById('cart-count');
            badge.textContent = total;
            badge.classList.toggle('has-items', total > 0);
        })();

        // ---------- Orders (from GET /api/orders) ----------
        const STATUS_META = {
            pending:    { label: 'Pending',             cls: '' },
            processing: { label: 'Processing delivery', cls: '' },
            completed:  { label: 'Delivered',           cls: 'complete' },
            cancelled:  { label: 'Cancelled',           cls: 'cancelled' }
        };

        let reviewedIds = new Set();      // product ids this customer already reviewed
        const orderItemsById = {};        // normalised items per order, used by the review form

        function formatDate(iso) {
            const d = new Date(iso);
            if (isNaN(d.getTime())) return '';
            return d.toLocaleDateString('en-US', { month: 'long', day: 'numeric', year: 'numeric' });
        }

        function itemName(item) {
            const p = item.product;
            return (p && (p.name || (p.data && p.data.name))) || item.product_name || item.name || 'Item';
        }

        function normalizeItem(item) {
            const p = item.product && (item.product.data || item.product);
            return {
                name: itemName(item),
                quantity: Number(item.quantity || 1),
                productId: item.product_id || (p && p.id) || null
            };
        }

        function needsReview(item) {
            return !item.productId || !reviewedIds.has(Number(item.productId));
        }

        function orderCardHtml(order) {
            const status = String(order.status || 'pending').toLowerCase();
            const meta = STATUS_META[status] || { label: status, cls: '' };
            const displayId = '#STF-' + String(order.id).padStart(5, '0');
            const items = (Array.isArray(order.items) ? order.items : []).map(normalizeItem);
            orderItemsById[order.id] = items;

            const itemLines = items.length
                ? items.map(it => '<p class="item-name">' + esc(it.name) + ' (' + it.quantity + 'x)</p>').join('')
                : '<p class="item-name">Order items</p>';

            let subLine = '<p class="item-sub">Free standard shipping</p>';
            let action = '<button type="button" class="save-btn danger-btn" onclick="cancelOrder(this)">Cancel order</button>';

            if (status === 'completed') {
                subLine = '<p class="item-sub fulfilled">\u2713 Delivered and paid</p>';
                action = items.some(needsReview)
                    ? '<button type="button" class="save-btn secondary-btn" onclick="openReview(this)">Leave a review</button>'
                    : '<span class="reviewed-note">\u2713 Reviewed</span>';
            } else if (status === 'cancelled') {
                subLine = '<p class="item-sub cancelled-note">This order was cancelled</p>';
                action = '';
            }

            return '' +
                '<div class="order-item-box" data-id="' + esc(order.id) + '" data-order="' + esc(displayId) + '">' +
                    '<div class="order-header">' +
                        '<div>' +
                            '<strong>' + esc(displayId) + '</strong>' +
                            '<span class="date">Placed on ' + esc(formatDate(order.created_at)) + '</span>' +
                        '</div>' +
                        '<span class="status-badge ' + meta.cls + '">' + esc(meta.label) + '</span>' +
                    '</div>' +
                    '<div class="order-body">' +
                        '<div>' + itemLines + subLine + '</div>' +
                        '<div class="action-flex">' +
                            '<span class="price-tag">' + money(order.total) + '</span>' +
                            action +
                        '</div>' +
                    '</div>' +
                '</div>';
        }

        async function loadOrders() {
            const list = document.getElementById('orders-list');
            const empty = document.getElementById('empty-orders');
            empty.style.display = 'none';

            if (!localStorage.getItem('auth_token')) {
                sessionExpired();
                return;
            }

            try {
                const responses = await Promise.all([
                    fetch('/api/orders', { headers: authHeaders() }),
                    fetch('/api/reviews/mine', { headers: authHeaders() }).catch(() => null)
                ]);
                const res = responses[0];
                const mineRes = responses[1];

                if (res.status === 401) { sessionExpired(); return; }
                if (res.status === 403) {
                    list.innerHTML = '<p class="orders-status">Order history is only available for customer accounts.</p>';
                    return;
                }

                if (mineRes && mineRes.ok) {
                    const mine = await mineRes.json();
                    reviewedIds = new Set((mine.data || []).map(r => Number(r.product_id)));
                }

                const json = await res.json();
                const orders = Array.isArray(json) ? json : (json.data || []);

                if (!orders.length) {
                    list.innerHTML = '';
                    empty.style.display = 'block';
                    return;
                }
                list.innerHTML = orders.map(orderCardHtml).join('');
            } catch (err) {
                list.innerHTML = '<p class="orders-status">Could not load your orders. Please try again.</p>';
            }
        }

        // Cancel through the API (PUT /api/orders/{id}), then reload the list
        async function cancelOrder(btn) {
            const box = btn.closest('.order-item-box');
            const id = box.dataset.id;
            const label = box.dataset.order;

            if (!confirm('Cancel order ' + label + '?')) return;

            btn.disabled = true;
            try {
                const res = await fetch('/api/orders/' + id, {
                    method: 'PUT',
                    headers: authHeaders(),
                    body: JSON.stringify({ status: 'cancelled' })
                });

                if (res.status === 401) { sessionExpired(); return; }

                const json = await res.json().catch(() => ({}));
                if (!res.ok) throw new Error(errorText(json, 'Could not cancel the order.'));

                showToast('Order ' + label + ' cancelled');
                loadOrders();
            } catch (err) {
                btn.disabled = false;
                showToast(err.message);
            }
        }

        // ---------- Reviews (POST /api/reviews) ----------
        let reviewCount = 0;

        // Older carts may not carry a product id, so look it up by name
        async function resolveProductId(name) {
            const res = await fetch('/api/products?search=' + encodeURIComponent(name), { headers: authHeaders() });
            if (res.status === 401) { sessionExpired(); throw new Error('AUTH'); }
            const json = await res.json();
            const match = (json.data || []).find(p => p.name === name);
            if (!match) throw new Error('Product not found: ' + name);
            return match.id;
        }

        function reviewFormHtml(items) {
            const options = items
                .map((it, i) => ({ it: it, i: i }))
                .filter(x => needsReview(x.it))
                .map(x => '<option value="' + x.i + '">' + esc(x.it.name) + '</option>')
                .join('');

            return '' +
                '<h4>Write your product review</h4>' +
                '<form class="review-form">' +
                    '<div style="display: grid; gap: 20px; margin-bottom: 20px;">' +
                        '<div class="form-group">' +
                            '<label for="review-product-' + reviewCount + '">Product</label>' +
                            '<select class="review-product" id="review-product-' + reviewCount + '">' + options + '</select>' +
                        '</div>' +
                        '<div class="form-group">' +
                            '<label>Star rating</label>' +
                            '<div class="star-rating">' +
                                '<span class="star" data-value="1">\u2605</span>' +
                                '<span class="star" data-value="2">\u2605</span>' +
                                '<span class="star" data-value="3">\u2605</span>' +
                                '<span class="star" data-value="4">\u2605</span>' +
                                '<span class="star" data-value="5">\u2605</span>' +
                            '</div>' +
                            '<div class="star-rating-label">Select a rating</div>' +
                            '<input type="hidden" name="rating">' +
                        '</div>' +
                        '<div class="form-group">' +
                            '<label for="review-text-' + reviewCount + '">Your feedback</label>' +
                            '<textarea id="review-text-' + reviewCount + '" rows="3" placeholder="Share your experience using this item..." required style="resize: none;"></textarea>' +
                        '</div>' +
                    '</div>' +
                    '<button type="submit" class="save-btn green-btn">Submit review</button>' +
                '</form>';
        }

        function openReview(btn) {
            const box = btn.closest('.order-item-box');
            const items = orderItemsById[box.dataset.id] || [];
            let formBox = box.querySelector('.review-form-box');

            if (!formBox) {
                reviewCount++;
                formBox = document.createElement('div');
                formBox.className = 'review-form-box';
                formBox.innerHTML = reviewFormHtml(items);
                box.appendChild(formBox);

                formBox.querySelectorAll('.star-rating').forEach(initStarRating);
                formBox.querySelector('.review-form').addEventListener('submit', async function (e) {
                    e.preventDefault();

                    const rating = formBox.querySelector('input[name="rating"]').value;
                    if (!rating) {
                        showToast('Please choose a star rating first.');
                        return;
                    }

                    const comment = formBox.querySelector('textarea').value.trim();
                    const item = items[Number(formBox.querySelector('.review-product').value)];
                    const submitBtn = e.target.querySelector('button[type="submit"]');
                    submitBtn.disabled = true;

                    try {
                        const productId = item.productId || await resolveProductId(item.name);

                        const res = await fetch('/api/reviews', {
                            method: 'POST',
                            headers: authHeaders(),
                            body: JSON.stringify({ product_id: productId, rating: Number(rating), comment: comment })
                        });

                        if (res.status === 401) { sessionExpired(); return; }

                        const json = await res.json().catch(() => ({}));
                        if (!res.ok) throw new Error(errorText(json, 'Could not submit the review.'));

                        reviewedIds.add(Number(productId));
                        formBox.innerHTML = '<p class="review-done">\u2713 Review submitted. Thank you for your feedback.</p>';
                        showToast('Review submitted');
                        setTimeout(loadOrders, 1500);
                    } catch (err) {
                        submitBtn.disabled = false;
                        if (err.message !== 'AUTH') showToast(err.message);
                    }
                });
            }

            formBox.classList.add('open');
            btn.style.display = 'none';
        }

        function initStarRating(container) {
            const stars = container.querySelectorAll('.star');
            const labelEl = container.parentElement.querySelector('.star-rating-label');
            const hiddenInput = container.parentElement.querySelector('input[type="hidden"]');
            const labels = { 1: 'Bad', 2: 'Poor', 3: 'Average', 4: 'Good', 5: 'Excellent' };
            let selected = 0;

            function render(value) {
                stars.forEach(s => s.classList.toggle('filled', Number(s.dataset.value) <= value));
                labelEl.textContent = value ? (value + ' / 5 \u2014 ' + labels[value]) : 'Select a rating';
            }

            stars.forEach(s => {
                s.addEventListener('mouseenter', () => render(Number(s.dataset.value)));
                s.addEventListener('click', () => {
                    selected = Number(s.dataset.value);
                    if (hiddenInput) hiddenInput.value = selected;
                    render(selected);
                });
            });
            container.addEventListener('mouseleave', () => render(selected));
            render(0);
        }

        // ---------- Notifications (GET /api/notices, POST /api/notices/read) ----------
        function setUnreadBadges(count) {
            ['side-unread', 'tab-unread'].forEach(id => {
                const badge = document.getElementById(id);
                badge.textContent = count;
                badge.classList.toggle('show', count > 0);
            });
        }

        function formatDateTime(iso) {
            const d = new Date(iso);
            if (isNaN(d.getTime())) return '';
            return d.toLocaleString('en-US', { month: 'short', day: 'numeric', year: 'numeric', hour: 'numeric', minute: '2-digit' });
        }

        function noticeHtml(notice) {
            return '<div class="notice-item' + (notice.read ? '' : ' notice-new') + '">' +
                '<p>' + esc(notice.message) + '</p>' +
                '<span>' + esc(formatDateTime(notice.created_at)) + '</span>' +
            '</div>';
        }

        // markRead: true when the tab is opened, so new items are still highlighted once
        async function loadNotices(markRead) {
            const list = document.getElementById('notices-list');
            try {
                const res = await fetch('/api/notices', { headers: authHeaders() });
                if (res.status === 401) { sessionExpired(); return; }
                if (res.status === 403) {
                    list.innerHTML = '<p class="orders-status">Notifications are only available for customer accounts.</p>';
                    return;
                }

                const json = await res.json();
                const notices = json.data || [];
                const unread = Number(json.unread || 0);
                setUnreadBadges(markRead ? 0 : unread);

                if (!notices.length) {
                    list.innerHTML = '<p class="orders-status">No notifications yet. You will see delivery updates for your orders here.</p>';
                    return;
                }
                list.innerHTML = notices.map(noticeHtml).join('');

                if (markRead && unread > 0) {
                    fetch('/api/notices/read', { method: 'POST', headers: authHeaders() }).catch(() => {});
                }
            } catch (err) {
                list.innerHTML = '<p class="orders-status">Could not load your notifications. Please try again.</p>';
            }
        }

        // ---------- Log out: revoke the token on the server, clear the session, keep the cart ----------
        document.getElementById('logout-link').addEventListener('click', function () {
            const token = localStorage.getItem('auth_token');
            if (token) {
                fetch('/api/logout', {
                    method: 'POST',
                    headers: {
                        'Authorization': 'Bearer ' + token,
                        'Accept': 'application/json'
                    },
                    keepalive: true
                });
            }
            clearSession();
        });

        // ---------- First load ----------
        loadProfile();
        loadOrders();
        loadNotices(false);
    </script>
</body>
</html>
