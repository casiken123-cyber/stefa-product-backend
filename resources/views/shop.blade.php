<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stefa - Leather Watch Straps</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:wght@500;600;700&family=Inter:wght@400;500;600&family=IBM+Plex+Mono:wght@500;600&display=swap" rel="stylesheet">
    <script src="/js/cart-store.js"></script>
    <style>
        :root {
            /* Palette: Brown, Pale Gold, Glowing Gold, plus tints of them */
            --brown: #603E1E;
            --pale: #F1D9A8;
            --gold: #FFC34D;
            --gold-deep: #F0AC1F;
            --gold-tint: rgba(255, 195, 77, 0.24);

            --canvas: #FBF5E8;
            --surface: #FFFDF8;
            --surface-2: #F6EAD0;
            --line: #E6D3AB;
            --ink: #2B1B0C;
            --ink-soft: #6B5238;
            --ink-faint: #7A6648;

            /* Aliases used by the modal styles */
            --cloud: var(--surface-2);
            --panel: var(--surface);

            --radius-card: 16px;
            --radius-panel: 18px;
            --radius-ctl: 12px;
            --gutter: 24px;

            --shadow-1: 0 1px 2px rgba(43, 27, 12, 0.05);
            --shadow-3: 0 22px 44px -16px rgba(43, 27, 12, 0.24), 0 6px 14px -6px rgba(43, 27, 12, 0.10);
            --ring: 0 0 0 4px var(--gold-tint);

            --ease-out: cubic-bezier(0.16, 1, 0.3, 1);
            --ease-in-out: cubic-bezier(0.65, 0, 0.35, 1);
            --ease-spring: cubic-bezier(0.34, 1.56, 0.64, 1);
        }

        * { box-sizing: border-box; }
        body { background: var(--canvas); font-family: 'Inter', system-ui, sans-serif; color: var(--ink); margin: 0; -webkit-font-smoothing: antialiased; }
        h1, h2, h3, .display { font-family: 'Fraunces', Georgia, serif; }

        a:focus-visible, button:focus-visible, input:focus-visible, select:focus-visible, summary:focus-visible { outline: 3px solid var(--brown); outline-offset: 2px; }
        nav a:focus-visible, nav input:focus-visible { outline-color: var(--gold); }

        /* ===================== Top Navigation ===================== */
        nav { background: var(--brown); padding: 14px 48px; display: flex; justify-content: space-between; align-items: center; gap: 40px; position: sticky; top: 0; z-index: 10; }
        .logo { display: inline-flex; align-items: center; text-decoration: none; flex-shrink: 0; }
        .logo-word { font-family: 'Fraunces', Georgia, serif; font-size: 27px; font-weight: 700; color: var(--pale); letter-spacing: 0.02em; line-height: 1; }
        .logo-word .logo-span { color: var(--gold); }

        .search-wrap { position: relative; flex: 1; max-width: 520px; width: 100%; }
        .search-wrap svg { position: absolute; left: 16px; top: 50%; transform: translateY(-50%); width: 17px; height: 17px; color: var(--ink-faint); pointer-events: none; }
        .search-bar { width: 100%; height: 44px; background: var(--pale); border: 1px solid transparent; padding: 0 16px 0 44px; border-radius: var(--radius-ctl); font-size: 14px; font-family: inherit; color: var(--ink); outline: none; transition: background 0.2s var(--ease-in-out), box-shadow 0.2s var(--ease-in-out); }
        .search-bar::placeholder { color: var(--ink-faint); }
        .search-bar:focus { background: var(--surface); box-shadow: 0 0 0 4px rgba(255, 195, 77, 0.45); }

        .nav-links { display: flex; align-items: center; gap: 4px; flex-shrink: 0; }
        .nav-links a { text-decoration: none; color: var(--pale); font-weight: 500; font-size: 14px; display: inline-flex; align-items: center; gap: 8px; padding: 9px 14px; border-radius: var(--radius-ctl); transition: background 0.2s var(--ease-in-out), color 0.2s var(--ease-in-out); }
        .nav-links a svg { width: 18px; height: 18px; flex-shrink: 0; }
        .nav-links a:hover { color: #fff; background: rgba(241, 217, 168, 0.16); }
        .nav-links a.active { color: var(--gold); font-weight: 600; }
        #auth-slot { display: contents; }

        .cart-count { min-width: 20px; height: 20px; padding: 0 6px; border-radius: 10px; background: var(--gold); color: var(--ink); font-family: 'IBM Plex Mono', monospace; font-size: 11px; font-weight: 600; display: none; align-items: center; justify-content: center; }
        .cart-count.has-items { display: inline-flex; }
        .cart-count.bump { animation: bump 0.4s var(--ease-spring); }
        @keyframes bump { 0% { transform: scale(1); } 40% { transform: scale(1.35); } 100% { transform: scale(1); } }

        .nav-avatar-link { padding: 0 !important; margin-left: 6px; border-radius: 50% !important; line-height: 0; position: relative; }
        .avatar-dot { position: absolute; top: -4px; right: -4px; min-width: 18px; height: 18px; padding: 0 5px; border-radius: 9px; background: var(--gold); color: var(--ink); font-family: 'IBM Plex Mono', monospace; font-size: 10px; font-weight: 600; line-height: 14px; text-align: center; border: 2px solid var(--brown); }
        .nav-avatar { width: 40px; height: 40px; border-radius: 50%; border: 2px solid var(--gold); display: block; object-fit: cover; background: var(--pale); }

        /* ===================== Layout ===================== */
        .container { display: flex; max-width: 1260px; margin: 40px auto 64px; padding: 0 40px; gap: 32px; align-items: flex-start; }
        @media (max-width: 800px) {
            nav { padding: 12px 20px; gap: 16px; flex-wrap: wrap; }
            .search-wrap { order: 3; max-width: none; flex-basis: 100%; }
            .container { flex-direction: column; padding: 0 20px; }
        }

        /* Sidebar */
        .sidebar { background: var(--surface); border: 1px solid var(--line); border-radius: var(--radius-panel); box-shadow: var(--shadow-1); padding: 16px; width: 248px; min-width: 248px; position: sticky; top: 96px; max-height: calc(100vh - 116px); overflow-y: auto; }
        @media (max-width: 800px) { .sidebar { width: 100%; min-width: 0; position: static; max-height: none; } }
        .sidebar h2 { font-family: 'Inter', sans-serif; font-size: 13px; line-height: 16px; font-weight: 600; margin: 8px 12px 10px; color: var(--ink-faint); }
        .filter-block { padding-bottom: 14px; margin-bottom: 14px; border-bottom: 1px solid var(--line); }
        .filter-block:last-of-type { border-bottom: none; margin-bottom: 0; }
        .filter-group { display: flex; flex-direction: column; gap: 4px; }
        .filter-link { position: relative; text-decoration: none; color: var(--ink-soft); font-size: 15px; line-height: 24px; font-weight: 500; padding: 10px 14px; min-height: 44px; border-radius: var(--radius-ctl); transition: background 0.2s var(--ease-in-out), color 0.2s var(--ease-in-out); }
        .filter-link::before { content: ""; position: absolute; left: 0; top: 10px; bottom: 10px; width: 3px; border-radius: 3px; background: var(--gold-deep); transform: scaleY(0); transition: transform 0.32s var(--ease-out); }
        .filter-link:hover { background: var(--surface-2); color: var(--ink); }
        .filter-link.active { background: var(--gold-tint); color: var(--ink); font-weight: 600; }
        .filter-link.active::before { transform: scaleY(1); }

        .chip-row { display: flex; flex-wrap: wrap; gap: 8px; padding: 0 12px; }
        .chip { min-width: 56px; height: 40px; padding: 0 12px; border-radius: 10px; border: 1px solid var(--line); background: var(--surface); color: var(--ink-soft); font-family: 'IBM Plex Mono', monospace; font-size: 13px; font-weight: 600; cursor: pointer; transition: background 0.15s, border-color 0.15s, color 0.15s; }
        .chip:hover { border-color: var(--brown); color: var(--ink); }
        .chip[aria-pressed="true"] { background: var(--brown); border-color: var(--brown); color: var(--pale); }
        .check-list { display: flex; flex-direction: column; gap: 2px; padding: 0 6px; }
        .check-item { display: flex; align-items: center; gap: 10px; min-height: 36px; padding: 4px 8px; border-radius: 8px; font-size: 14px; color: var(--ink-soft); cursor: pointer; }
        .check-item:hover { background: var(--surface-2); color: var(--ink); }
        .check-item input { width: 17px; height: 17px; accent-color: var(--brown); cursor: pointer; flex-shrink: 0; }
        .filter-note { margin: 10px 12px 0; font-size: 13px; line-height: 20px; color: var(--ink-soft); }
        .filter-note summary { cursor: pointer; font-weight: 600; color: var(--brown); }
        .filter-note p { margin: 8px 0 0; }
        .clear-btn { display: none; width: calc(100% - 24px); margin: 14px 12px 0; height: 40px; border-radius: 10px; border: 1px solid var(--brown); background: none; color: var(--brown); font-family: inherit; font-size: 13px; font-weight: 600; cursor: pointer; }
        .clear-btn:hover { background: var(--brown); color: var(--pale); }
        .clear-btn.show { display: block; }

        /* Content */
        .content-area { flex: 1; width: 100%; min-width: 0; }
        .catalog-title { font-size: 34px; line-height: 42px; font-weight: 600; margin: 0 0 6px 0; letter-spacing: -0.01em; color: var(--brown); }
        .catalog-sub { margin: 0 0 20px; font-size: 15px; color: var(--ink-soft); }
        .toolbar { display: flex; justify-content: space-between; align-items: center; gap: 16px; margin-bottom: 20px; padding-bottom: 16px; border-bottom: 1px solid var(--line); flex-wrap: wrap; }
        .result-count { font-size: 14px; color: var(--ink-soft); margin: 0; }
        .sort-wrap { display: flex; align-items: center; gap: 10px; font-size: 14px; color: var(--ink-soft); }
        .sort-select { height: 40px; padding: 0 12px; border-radius: 10px; border: 1px solid var(--line); background: var(--surface); color: var(--ink); font-family: inherit; font-size: 14px; font-weight: 500; cursor: pointer; }
        .sort-select:hover { border-color: var(--brown); }

        .grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(260px, 1fr)); gap: var(--gutter); width: 100%; }
        .card { background: var(--surface); border-radius: var(--radius-card); border: 1px solid var(--line); box-shadow: var(--shadow-1); overflow: hidden; display: flex; flex-direction: column; cursor: pointer; transition: transform 0.32s var(--ease-out), box-shadow 0.32s var(--ease-out); }
        .card:hover { transform: translateY(-4px); box-shadow: var(--shadow-3); }
        .img-box { width: 100%; aspect-ratio: 4 / 3; background: var(--surface-2); overflow: hidden; display: block; border-bottom: 1px solid var(--line); }
        .img-box img { width: 100%; height: 100%; object-fit: cover; display: block; transition: transform 0.5s var(--ease-out); }
        .card:hover .img-box img { transform: scale(1.04); }

        .card-body { padding: 20px; display: flex; flex-direction: column; gap: 12px; flex: 1; }
        .card-body h3 { font-size: 19px; line-height: 26px; font-weight: 600; margin: 0; letter-spacing: -0.005em; }
        .tag { background: var(--surface-2); color: var(--brown); font-size: 12px; line-height: 16px; font-weight: 600; padding: 4px 10px; border-radius: 6px; width: fit-content; }
        .spec-line { display: flex; flex-wrap: wrap; align-items: center; gap: 8px; margin: 0; font-size: 13px; color: var(--ink-soft); }
        .lug-pill { font-family: 'IBM Plex Mono', monospace; font-size: 12px; font-weight: 600; background: var(--gold); color: var(--ink); padding: 3px 8px; border-radius: 6px; }
        .card-body .desc { font-size: 14px; line-height: 22px; color: var(--ink-soft); margin: 0; flex: 1; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; line-clamp: 2; overflow: hidden; }
        .price { font-family: 'IBM Plex Mono', monospace; font-size: 20px; line-height: 28px; font-weight: 600; letter-spacing: -0.02em; color: var(--ink); }

        .card-actions { display: flex; align-items: stretch; gap: 8px; margin-top: 4px; }
        .icon-btn { width: 44px; height: 44px; flex-shrink: 0; border-radius: var(--radius-ctl); border: 1px solid var(--line); background: var(--surface); color: var(--ink-soft); display: flex; align-items: center; justify-content: center; cursor: pointer; transition: border-color 0.2s var(--ease-in-out), color 0.2s var(--ease-in-out), background 0.2s var(--ease-in-out), transform 0.12s ease; }
        .icon-btn svg { width: 19px; height: 19px; }
        .icon-btn:hover { border-color: var(--brown); color: var(--brown); background: var(--gold-tint); }
        .icon-btn:active { transform: scale(0.96); }
        .icon-btn.added { border-color: var(--brown); color: var(--pale); background: var(--brown); animation: bump 0.4s var(--ease-spring); }

        .buy-btn { flex: 1; height: 44px; background: var(--gold); color: var(--ink); border: none; padding: 0 16px; border-radius: var(--radius-ctl); font-size: 14px; line-height: 20px; font-weight: 600; font-family: 'Inter', sans-serif; cursor: pointer; transition: background 0.2s var(--ease-in-out), transform 0.2s var(--ease-out); }
        .buy-btn:hover { background: var(--gold-deep); transform: translateY(-1px); }
        .buy-btn:active { transform: scale(0.97); transition-duration: 0.12s; }

        .stock-note { font-size: 12px; font-weight: 600; width: fit-content; padding: 3px 10px; border-radius: 20px; }
        .stock-note.low { background: #FFE9B8; color: #7A4A00; }
        .stock-note.out { background: #FBE9E7; color: #A93434; }
        .buy-btn:disabled, .icon-btn:disabled { opacity: 0.45; cursor: not-allowed; transform: none; }
        .empty-state { color: var(--ink-soft); font-size: 14px; padding: 24px 0; grid-column: 1 / -1; }

        .toast { position: fixed; left: 50%; bottom: 28px; transform: translate(-50%, 16px); background: var(--brown); color: var(--pale); padding: 12px 18px; border-radius: var(--radius-ctl); font-size: 14px; font-weight: 500; box-shadow: var(--shadow-3); opacity: 0; pointer-events: none; transition: opacity 0.2s var(--ease-in-out), transform 0.32s var(--ease-out); z-index: 200; }
        .toast.show { opacity: 1; transform: translate(-50%, 0); }

        /* ===================== Product Detail Modal ===================== */
        .modal-overlay { display: none; position: fixed; inset: 0; background: rgba(43, 27, 12, 0.5); backdrop-filter: blur(2px); z-index: 100; align-items: center; justify-content: center; padding: 24px; }
        .modal-overlay.open { display: flex; }
        .modal-box { background: var(--panel); border-radius: 20px; max-width: 800px; width: 100%; max-height: 88vh; overflow-y: auto; position: relative; box-shadow: 0 24px 60px -12px rgba(43, 27, 12, 0.3), 0 8px 24px -8px rgba(43, 27, 12, 0.14); border: 1px solid var(--line); scrollbar-width: thin; scrollbar-color: var(--line) transparent; animation: modalIn 0.32s var(--ease-out); }
        @keyframes modalIn { from { opacity: 0; transform: translateY(12px) scale(0.98); } to { opacity: 1; transform: none; } }
        .modal-close { position: absolute; top: 20px; right: 20px; width: 36px; height: 36px; border-radius: 50%; border: none; background: var(--cloud); color: var(--ink-soft); font-size: 15px; cursor: pointer; z-index: 2; transition: background 0.2s, color 0.2s; }
        .modal-close:hover { background: var(--pale); color: var(--ink); }
        .modal-top { display: flex; gap: 0; flex-wrap: wrap; }
        .modal-img { width: 280px; min-width: 240px; flex: 1; height: 280px; align-self: flex-start; background: var(--cloud); margin: 24px 0 24px 24px; border-radius: 14px; overflow: hidden; }
        .modal-img img { width: 100%; height: 100%; object-fit: cover; display: block; }
        .modal-info { flex: 1.15; min-width: 260px; padding: 32px 32px 28px 28px; }
        .modal-info .tag { display: inline-block; margin-bottom: 14px; }
        .modal-info h2 { font-size: 26px; line-height: 32px; margin: 0 0 10px 0; letter-spacing: -0.01em; font-weight: 600; color: var(--brown); padding-right: 36px; }
        .modal-rating { display: flex; align-items: center; gap: 8px; font-size: 13px; color: var(--ink-soft); margin-bottom: 16px; }
        .modal-rating .stars { color: #C98A00; letter-spacing: 1px; }
        .modal-price { font-family: 'IBM Plex Mono', monospace; font-size: 24px; font-weight: 600; margin-bottom: 16px; letter-spacing: -0.02em; }
        .modal-desc { font-size: 14px; color: var(--ink-soft); line-height: 1.7; margin: 0 0 20px; }

        .specs { display: none; margin: 0 0 16px; }
        .specs.show { display: block; }
        .specs h3 { font-family: 'Inter', sans-serif; font-size: 13px; font-weight: 600; margin: 0 0 8px; color: var(--ink-faint); }
        .spec-list { margin: 0; border: 1px solid var(--line); border-radius: 12px; padding: 4px 14px; background: var(--surface-2); }
        .spec-list div { display: flex; justify-content: space-between; gap: 16px; padding: 8px 0; border-bottom: 1px solid var(--line); font-size: 13px; }
        .spec-list div:last-child { border-bottom: none; }
        .spec-list dt { color: var(--ink-soft); font-weight: 500; }
        .spec-list dd { margin: 0; font-weight: 600; text-align: right; color: var(--ink); }
        .lug-tip { display: none; margin: 0 0 20px; padding: 12px 14px; border-radius: 12px; background: var(--gold-tint); border-left: 3px solid var(--gold-deep); font-size: 13px; line-height: 20px; color: var(--ink); }
        .lug-tip.show { display: block; }
        .lug-tip strong { font-weight: 600; }

        .modal-actions { display: flex; gap: 10px; }
        .modal-actions .icon-btn { width: 50px; height: 50px; }
        .modal-actions .icon-btn svg { width: 21px; height: 21px; }
        .modal-actions .buy-btn { height: 50px; font-size: 15px; }

        .modal-reviews { padding: 28px 32px 32px; border-top: 1px solid var(--line); }
        .modal-reviews-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px; }
        .modal-reviews h3 { font-size: 15px; font-weight: 700; margin: 0; color: var(--ink-soft); font-family: 'Inter', sans-serif; }
        .review-toggle-btn { background: var(--cloud); color: var(--ink); border: 1px solid var(--line); padding: 8px 14px; border-radius: 10px; font-size: 13px; font-weight: 600; font-family: 'Inter', sans-serif; cursor: pointer; transition: border-color 0.2s, color 0.2s; }
        .review-toggle-btn:hover { border-color: var(--brown); color: var(--brown); }
        .review-form { display: none; flex-direction: column; gap: 12px; background: var(--cloud); border-radius: 14px; padding: 18px; margin-bottom: 18px; }
        .review-form.open { display: flex; }
        .star-input { display: flex; gap: 4px; }
        .star-btn { background: none; border: none; cursor: pointer; padding: 2px; font-size: 22px; line-height: 1; color: var(--line); transition: color 0.1s; }
        .star-btn.filled { color: #E0A400; }
        .review-form textarea { width: 100%; border: 1px solid var(--line); border-radius: 10px; padding: 10px 12px; font-family: inherit; font-size: 13px; color: var(--ink); resize: vertical; min-height: 70px; outline: none; background: var(--panel); transition: border-color 0.2s, box-shadow 0.2s; }
        .review-form textarea:focus { border-color: var(--gold-deep); box-shadow: var(--ring); }
        .review-form-actions { display: flex; justify-content: flex-end; gap: 8px; }
        .review-cancel-btn { background: none; border: none; color: var(--ink-soft); font-size: 13px; font-weight: 600; font-family: 'Inter', sans-serif; cursor: pointer; padding: 9px 14px; }
        .review-cancel-btn:hover { color: var(--ink); }
        .review-submit-btn { background: var(--brown); color: var(--pale); border: none; padding: 9px 18px; border-radius: 10px; font-size: 13px; font-weight: 600; font-family: 'Inter', sans-serif; cursor: pointer; transition: background 0.2s; }
        .review-submit-btn:hover { background: var(--ink); }
        .review-submit-btn:disabled { opacity: 0.6; cursor: not-allowed; }
        .review-empty { font-size: 13px; color: var(--ink-soft); background: var(--cloud); border-radius: 14px; padding: 20px; text-align: center; }
        .review-item { border-bottom: 1px solid var(--line); padding: 18px 4px; }
        .review-item:first-child { padding-top: 4px; }
        .review-item:last-child { border-bottom: none; padding-bottom: 4px; }
        .review-item .review-head { display: flex; justify-content: space-between; font-size: 13px; font-weight: 600; margin-bottom: 6px; }
        .review-item .review-stars { color: #C98A00; font-size: 12px; }
        .review-item p { margin: 4px 0 0; font-size: 13px; color: var(--ink-soft); line-height: 1.6; }

        @media (prefers-reduced-motion: reduce) {
            *, *::before, *::after { animation-duration: 0.01ms !important; transition-duration: 0.01ms !important; }
            .card:hover, .buy-btn:hover { transform: none; }
        }
    </style>
</head>
<body>

    @php
        $activeCategory = request('category');
        // The sidebar follows the categories the admin manages
        $categoryNames = \App\Models\Category::orderBy('name')->pluck('name');
        // Filter options are built from the strap details that exist on the products
        $lugWidths = $products->pluck('lug_width')->filter()->unique()->sort()->values();
        $leatherTypes = $products->pluck('leather_type')->filter()->unique(fn ($v) => mb_strtolower($v))->sort()->values();
        $colorNames = $products->pluck('color')->filter()->unique(fn ($v) => mb_strtolower($v))->sort()->values();
    @endphp

    <!-- Top Navigation -->
    <nav>
        <a href="/shop" class="logo">
            <span class="logo-word">S<span class="logo-span">TEFA</span></span>
        </a>

        <div class="search-wrap">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="7"></circle><path d="M20 20l-3.5-3.5"></path></svg>
            <input type="text" id="product-search" class="search-bar" placeholder="Search by name..." aria-label="Search products" autocomplete="off">
        </div>

        <div class="nav-links">
            <a href="/shop" class="active">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7" rx="1.5"></rect><rect x="14" y="3" width="7" height="7" rx="1.5"></rect><rect x="3" y="14" width="7" height="7" rx="1.5"></rect><rect x="14" y="14" width="7" height="7" rx="1.5"></rect></svg>
                Products
            </a>
            <a href="/cart" aria-label="Open shopping bag">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="21" r="1.5"></circle><circle cx="18" cy="21" r="1.5"></circle><path d="M2.5 3h2l2.7 12.4a2 2 0 0 0 2 1.6h7.6a2 2 0 0 0 2-1.6L21 8H6"></path></svg>
                Cart
                <span class="cart-count" id="cart-count">0</span>
            </a>
            <!-- Guest links by default; JS swaps in the avatar when logged in -->
            <span id="auth-slot">
                <a href="/login">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"></path><path d="M10 17l5-5-5-5"></path><path d="M15 12H3"></path></svg>
                    Log-In
                </a>
                <a href="/login">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M19 8v6M22 11h-6"></path></svg>
                    Sign-Up
                </a>
            </span>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container">
        <aside class="sidebar" aria-label="Filters">
            <div class="filter-block">
                <h2>Categories</h2>
                <div class="filter-group">
                    <a href="/shop" class="filter-link {{ !$activeCategory ? 'active' : '' }}">All Products</a>
                    @foreach($categoryNames as $categoryName)
                        <a href="/shop?category={{ urlencode($categoryName) }}" class="filter-link {{ $activeCategory === $categoryName ? 'active' : '' }}">{{ $categoryName }}</a>
                    @endforeach
                </div>
            </div>

            @if($lugWidths->count())
                <div class="filter-block">
                    <h2>Lug width</h2>
                    <div class="chip-row" id="lug-chips">
                        @foreach($lugWidths as $w)
                            <button type="button" class="chip" data-value="{{ $w }}" aria-pressed="false">{{ $w }} mm</button>
                        @endforeach
                    </div>
                    <details class="filter-note">
                        <summary>Not sure of your lug width?</summary>
                        <p>Measure the gap between the two lugs, the horns where the strap attaches, in millimetres. Your watch's manual or product page usually lists it too. A strap only fits if its width matches.</p>
                    </details>
                </div>
            @endif

            @if($leatherTypes->count())
                <div class="filter-block">
                    <h2>Leather</h2>
                    <div class="check-list" data-group="leather">
                        @foreach($leatherTypes as $t)
                            <label class="check-item"><input type="checkbox" value="{{ mb_strtolower($t) }}"> {{ $t }}</label>
                        @endforeach
                    </div>
                </div>
            @endif

            @if($colorNames->count())
                <div class="filter-block">
                    <h2>Colour</h2>
                    <div class="check-list" data-group="color">
                        @foreach($colorNames as $c)
                            <label class="check-item"><input type="checkbox" value="{{ mb_strtolower($c) }}"> {{ $c }}</label>
                        @endforeach
                    </div>
                </div>
            @endif

            <div class="filter-block">
                <div class="check-list">
                    <label class="check-item"><input type="checkbox" id="quick-only"> Quick-release only</label>
                </div>
                <button type="button" class="clear-btn" id="clear-filters">Clear filters</button>
            </div>
        </aside>

        <main class="content-area">
            <h1 class="catalog-title">Leather watch straps</h1>
            <p class="catalog-sub">Each width and colour is its own strap. Pick your lug width first, then your leather.</p>

            <div class="toolbar">
                <p class="result-count" id="result-count" aria-live="polite"></p>
                <label class="sort-wrap">Sort by
                    <select id="sort-select" class="sort-select">
                        <option value="featured">Featured</option>
                        <option value="low">Price: low to high</option>
                        <option value="high">Price: high to low</option>
                    </select>
                </label>
            </div>

            <div class="grid" id="product-grid">
                @forelse($products as $product)
                    <div class="card"
                         onclick="openProductModal(this)"
                         data-id="{{ $product->id }}"
                         data-order="{{ $loop->index }}"
                         data-name="{{ $product->name }}"
                         data-price="{{ $product->price }}"
                         data-image="{{ $product->image_url }}"
                         data-category="{{ $product->category }}"
                         data-stock="{{ $product->stock }}"
                         data-description="{{ $product->description }}"
                         data-lug="{{ $product->lug_width }}"
                         data-leather="{{ $product->leather_type }}"
                         data-color="{{ $product->color }}"
                         data-buckle="{{ $product->buckle }}"
                         data-length="{{ $product->length }}"
                         data-quick="{{ $product->quick_release ? 1 : 0 }}"
                         @if(isset($product->reviews) && count($product->reviews))
                         data-reviews='{{ json_encode($product->reviews->map(fn($r) => ["author" => $r->author_name ?? "Verified Buyer", "rating" => $r->rating, "comment" => $r->comment])) }}'
                         @endif
                    >
                        <div class="img-box">
                            <img src="{{ $product->image_url }}" alt="{{ $product->name }}" loading="lazy">
                        </div>
                        <div class="card-body">
                            <h3>{{ $product->name }}</h3>
                            <span class="tag">{{ $product->category }}</span>
                            @if($product->lug_width || $product->color)
                                <p class="spec-line">
                                    @if($product->lug_width)<span class="lug-pill">{{ $product->lug_width }} mm</span>@endif
                                    @if($product->leather_type || $product->color)<span>{{ collect([$product->leather_type, $product->color])->filter()->implode(' · ') }}</span>@endif
                                </p>
                            @endif
                            <p class="desc">{{ $product->description }}</p>
                            <span class="price">${{ number_format($product->price, 2) }}</span>
                            @if($product->stock <= 0)
                                <span class="stock-note out">Out of stock</span>
                            @elseif($product->stock <= 5)
                                <span class="stock-note low">Only {{ $product->stock }} left</span>
                            @endif
                            <div class="card-actions">
                                <button class="icon-btn" title="Add to Cart" aria-label="Add {{ $product->name }} to cart" onclick="event.stopPropagation(); addFromCard(this)" @if($product->stock <= 0) disabled @endif>
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="21" r="1.5"></circle><circle cx="18" cy="21" r="1.5"></circle><path d="M2.5 3h2l2.7 12.4a2 2 0 0 0 2 1.6h7.6a2 2 0 0 0 2-1.6L21 8H6"></path></svg>
                                </button>
                                <button class="buy-btn" onclick="event.stopPropagation(); buyFromCard(this)" @if($product->stock <= 0) disabled @endif>Buy Now</button>
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="empty-state">No products are in the store yet.</p>
                @endforelse
                <p class="empty-state" id="filter-empty" style="display: none;">No products match these filters. Clear a filter or try a different search.</p>
            </div>
        </main>
    </div>

    <div class="toast" id="toast" role="status" aria-live="polite"></div>

    <!-- Product Details Modal -->
    <div class="modal-overlay" id="product-modal" onclick="if(event.target === this) closeProductModal()">
        <div class="modal-box">
            <button class="modal-close" onclick="closeProductModal()" aria-label="Close">✕</button>
            <div class="modal-top">
                <div class="modal-img"><img id="modal-img" src="" alt=""></div>
                <div class="modal-info">
                    <span class="tag" id="modal-category"></span>
                    <h2 id="modal-name"></h2>
                    <div class="modal-rating">
                        <span class="stars" id="modal-stars">☆☆☆☆☆</span>
                        <span id="modal-rating-text">No reviews yet</span>
                    </div>
                    <div class="modal-price" id="modal-price"></div>
                    <p class="modal-desc" id="modal-desc"></p>

                    <div class="specs" id="modal-specs">
                        <h3>Specifications</h3>
                        <dl class="spec-list" id="modal-spec-list"></dl>
                    </div>
                    <div class="lug-tip" id="modal-lug-tip"></div>

                    <div class="modal-actions">
                        <button class="icon-btn" id="modal-cart-btn" title="Add to Cart" aria-label="Add to Cart">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="21" r="1.5"></circle><circle cx="18" cy="21" r="1.5"></circle><path d="M2.5 3h2l2.7 12.4a2 2 0 0 0 2 1.6h7.6a2 2 0 0 0 2-1.6L21 8H6"></path></svg>
                        </button>
                        <button class="buy-btn" id="modal-buy-btn">Buy Now</button>
                    </div>
                </div>
            </div>
            <div class="modal-reviews">
                <div class="modal-reviews-header">
                    <h3 id="modal-reviews-heading">Reviews</h3>
                    <button class="review-toggle-btn" id="review-toggle-btn" onclick="toggleReviewForm()">Write a Review</button>
                </div>
                <div class="review-form" id="review-form">
                    <div class="star-input" id="review-star-input">
                        <button type="button" class="star-btn" data-value="1" onclick="setReviewRating(1)">★</button>
                        <button type="button" class="star-btn" data-value="2" onclick="setReviewRating(2)">★</button>
                        <button type="button" class="star-btn" data-value="3" onclick="setReviewRating(3)">★</button>
                        <button type="button" class="star-btn" data-value="4" onclick="setReviewRating(4)">★</button>
                        <button type="button" class="star-btn" data-value="5" onclick="setReviewRating(5)">★</button>
                    </div>
                    <textarea id="review-comment" placeholder="Share your thoughts about this product..."></textarea>
                    <div class="review-form-actions">
                        <button type="button" class="review-cancel-btn" onclick="toggleReviewForm(false)">Cancel</button>
                        <button type="button" class="review-submit-btn" onclick="submitReview()">Submit Review</button>
                    </div>
                </div>
                <div id="modal-reviews-list"></div>
            </div>
        </div>
    </div>

    <script>
        const DEFAULT_AVATAR = 'data:image/svg+xml;utf8,' + encodeURIComponent(`
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 40 40">
                <rect width="40" height="40" fill="#F1D9A8"/>
                <circle cx="20" cy="16" r="7" fill="#603E1E"/>
                <path d="M6 36c0-8 6-13 14-13s14 5 14 13" fill="#603E1E"/>
            </svg>
        `);

        const CART_ICON = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="21" r="1.5"></circle><circle cx="18" cy="21" r="1.5"></circle><path d="M2.5 3h2l2.7 12.4a2 2 0 0 0 2 1.6h7.6a2 2 0 0 0 2-1.6L21 8H6"></path></svg>';
        const CHECK_ICON = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12.5l4.5 4.5L19 7.5"></path></svg>';

        // Logged-in users see their avatar in place of the guest links
        if (localStorage.getItem('user_authenticated') === 'true') {
            const slot = document.getElementById('auth-slot');
            if (slot) {
                slot.innerHTML = `
                    <a href="/profile" class="nav-avatar-link" title="Go to My Profile">
                        <img id="nav-avatar" class="nav-avatar" alt="Your profile">
                    </a>
                `;

                const navAvatar = document.getElementById('nav-avatar');
                function setNavAvatar(url) {
                    navAvatar.onerror = function () { this.onerror = null; this.src = DEFAULT_AVATAR; };
                    navAvatar.src = url || DEFAULT_AVATAR;
                }

                // Show the cached photo instantly, then confirm it with the server
                let cachedProfile = null;
                try { cachedProfile = JSON.parse(localStorage.getItem('stefashop_profile')); } catch (e) {}
                setNavAvatar(cachedProfile && cachedProfile.avatar_url);

                fetch('/api/profile', {
                    headers: { 'Authorization': 'Bearer ' + localStorage.getItem('auth_token'), 'Accept': 'application/json' }
                })
                    .then(r => (r.ok ? r.json() : null))
                    .then(j => {
                        if (!j || !j.data) return;
                        const url = j.data.avatar_url || '';
                        setNavAvatar(url);
                        if (cachedProfile) {
                            cachedProfile.avatar_url = url;
                            localStorage.setItem('stefashop_profile', JSON.stringify(cachedProfile));
                        }
                    })
                    .catch(() => {});

                // A badge on the avatar when the customer has unread delivery updates
                fetch('/api/notices', {
                    headers: { 'Authorization': 'Bearer ' + localStorage.getItem('auth_token'), 'Accept': 'application/json' }
                })
                    .then(r => (r.ok ? r.json() : null))
                    .then(j => {
                        if (!j || Number(j.unread) < 1) return;
                        const link = slot.querySelector('.nav-avatar-link');
                        if (!link) return;
                        const dot = document.createElement('span');
                        dot.className = 'avatar-dot';
                        dot.textContent = j.unread;
                        link.appendChild(dot);
                    })
                    .catch(() => {});
            }
        }

        // ---------- Cart helpers ----------
        function readCart() {
            return StefaCart.read();
        }

        function updateCartCount(animate) {
            const total = readCart().reduce((sum, item) => sum + (item.quantity || 1), 0);
            const badge = document.getElementById('cart-count');
            badge.textContent = total;
            badge.classList.toggle('has-items', total > 0);
            if (animate) {
                badge.classList.remove('bump');
                void badge.offsetWidth;
                badge.classList.add('bump');
            }
        }

        let toastTimer;
        function showToast(message) {
            const toast = document.getElementById('toast');
            toast.textContent = message;
            toast.classList.add('show');
            clearTimeout(toastTimer);
            toastTimer = setTimeout(() => toast.classList.remove('show'), 2200);
        }

        // Adds the item, or raises its quantity if it is already in the bag.
        function addProductToCart(id, name, price, imageUrl, category) {
            const cartItems = readCart();
            const existing = cartItems.find(item => String(item.id) === String(id));
            if (existing) {
                existing.quantity = (existing.quantity || 1) + 1;
            } else {
                cartItems.push({ id: Number(id), name: name, price: parseFloat(price), image: imageUrl, category: category, quantity: 1 });
            }
            StefaCart.write(cartItems);
            updateCartCount(true);
            showToast(name + ' added to your bag');
        }

        function addFromCard(btn) {
            const d = btn.closest('.card').dataset;
            addProductToCart(d.id, d.name, d.price, d.image, d.category);
            flashAdded(btn);
        }

        function flashAdded(btn) {
            btn.classList.add('added');
            btn.innerHTML = CHECK_ICON;
            setTimeout(() => {
                btn.classList.remove('added');
                btn.innerHTML = CART_ICON;
            }, 1200);
        }

        // Buy Now sends only this item to checkout (same key the cart page uses)
        function buyNowProduct(id, name, price, imageUrl, category) {
            addProductToCart(id, name, price, imageUrl, category);
            const item = { id: Number(id), name: name, price: parseFloat(price), image: imageUrl, category: category, quantity: 1, selected: true };
            localStorage.setItem('stefashop_checkout_items', JSON.stringify([item]));
            window.location.href = '/checkout';
        }

        function buyFromCard(btn) {
            const d = btn.closest('.card').dataset;
            buyNowProduct(d.id, d.name, d.price, d.image, d.category);
        }

        // ---------- Search, filters and sorting (all in the browser) ----------
        const grid = document.getElementById('product-grid');
        const cards = Array.from(grid.querySelectorAll('.card'));
        const emptyNote = document.getElementById('filter-empty');
        const filters = { term: '', sort: 'featured', quick: false, lug: new Set(), leather: new Set(), color: new Set() };

        function anyFilterActive() {
            return filters.term !== '' || filters.quick || filters.lug.size || filters.leather.size || filters.color.size;
        }

        function applyFilters() {
            let visible = 0;
            cards.forEach(card => {
                const d = card.dataset;
                const ok =
                    (!filters.term || d.name.toLowerCase().includes(filters.term)) &&
                    (!filters.lug.size || filters.lug.has(d.lug)) &&
                    (!filters.leather.size || filters.leather.has((d.leather || '').toLowerCase())) &&
                    (!filters.color.size || filters.color.has((d.color || '').toLowerCase())) &&
                    (!filters.quick || d.quick === '1');
                card.style.display = ok ? '' : 'none';
                if (ok) visible++;
            });

            const sorted = cards.slice().sort((a, b) => {
                if (filters.sort === 'low') return parseFloat(a.dataset.price) - parseFloat(b.dataset.price);
                if (filters.sort === 'high') return parseFloat(b.dataset.price) - parseFloat(a.dataset.price);
                return Number(a.dataset.order) - Number(b.dataset.order);
            });
            sorted.forEach(card => grid.insertBefore(card, emptyNote));

            emptyNote.style.display = (cards.length && visible === 0) ? 'block' : 'none';
            document.getElementById('result-count').textContent =
                visible + (visible === 1 ? ' product' : ' products') + (anyFilterActive() ? ' match' : '');
            document.getElementById('clear-filters').classList.toggle('show', anyFilterActive());
        }

        document.getElementById('product-search').addEventListener('input', function () {
            filters.term = this.value.trim().toLowerCase();
            applyFilters();
        });
        document.getElementById('sort-select').addEventListener('change', function () {
            filters.sort = this.value;
            applyFilters();
        });
        document.getElementById('quick-only').addEventListener('change', function () {
            filters.quick = this.checked;
            applyFilters();
        });
        document.querySelectorAll('#lug-chips .chip').forEach(chip => {
            chip.addEventListener('click', function () {
                const on = this.getAttribute('aria-pressed') !== 'true';
                this.setAttribute('aria-pressed', on ? 'true' : 'false');
                on ? filters.lug.add(this.dataset.value) : filters.lug.delete(this.dataset.value);
                applyFilters();
            });
        });
        document.querySelectorAll('.check-list[data-group] input').forEach(box => {
            box.addEventListener('change', function () {
                const set = filters[this.closest('.check-list').dataset.group];
                this.checked ? set.add(this.value) : set.delete(this.value);
                applyFilters();
            });
        });
        document.getElementById('clear-filters').addEventListener('click', function () {
            filters.term = ''; filters.quick = false;
            filters.lug.clear(); filters.leather.clear(); filters.color.clear();
            document.getElementById('product-search').value = '';
            document.getElementById('quick-only').checked = false;
            document.querySelectorAll('.check-list[data-group] input').forEach(b => { b.checked = false; });
            document.querySelectorAll('#lug-chips .chip').forEach(c => c.setAttribute('aria-pressed', 'false'));
            applyFilters();
        });

        // ---------- Modal reviews (saved through POST /api/reviews) ----------
        let currentModalReviews = [];
        let currentReviewRating = 0;
        let currentModalProductId = null;
        let currentModalCard = null;

        function renderModalReviews(reviews) {
            const reviewsList = document.getElementById('modal-reviews-list');
            const starsEl = document.getElementById('modal-stars');
            const ratingText = document.getElementById('modal-rating-text');
            const reviewsHeading = document.getElementById('modal-reviews-heading');
            reviewsList.innerHTML = '';

            if (reviews.length > 0) {
                const avg = reviews.reduce((sum, r) => sum + Number(r.rating || 0), 0) / reviews.length;
                starsEl.innerText = '★'.repeat(Math.round(avg)) + '☆'.repeat(5 - Math.round(avg));
                ratingText.innerText = avg.toFixed(1) + ' (' + reviews.length + ' review' + (reviews.length > 1 ? 's' : '') + ')';
                reviewsHeading.innerText = 'Reviews (' + reviews.length + ')';

                reviews.forEach(r => {
                    const item = document.createElement('div');
                    item.className = 'review-item';
                    const stars = '★'.repeat(Number(r.rating || 0)) + '☆'.repeat(5 - Number(r.rating || 0));
                    item.innerHTML = `
                        <div class="review-head">
                            <span class="review-author"></span>
                            <span class="review-stars">${stars}</span>
                        </div>
                        <p></p>
                    `;
                    item.querySelector('.review-author').innerText = r.author || 'Verified Buyer';
                    item.querySelector('p').innerText = r.comment || '';
                    reviewsList.appendChild(item);
                });
            } else {
                starsEl.innerText = '☆☆☆☆☆';
                ratingText.innerText = 'No reviews yet';
                reviewsHeading.innerText = 'Reviews';
                reviewsList.innerHTML = '<div class="review-empty">No reviews yet for this product.</div>';
            }
        }

        function toggleReviewForm(show) {
            const form = document.getElementById('review-form');
            const shouldOpen = show === undefined ? !form.classList.contains('open') : show;
            form.classList.toggle('open', shouldOpen);
            if (shouldOpen) {
                currentReviewRating = 0;
                updateStarInput();
                document.getElementById('review-comment').value = '';
            }
        }

        function setReviewRating(value) {
            currentReviewRating = value;
            updateStarInput();
        }

        function updateStarInput() {
            document.querySelectorAll('#review-star-input .star-btn').forEach(btn => {
                btn.classList.toggle('filled', Number(btn.dataset.value) <= currentReviewRating);
            });
        }

        async function submitReview() {
            if (currentReviewRating === 0) {
                showToast('Please select a star rating first.');
                return;
            }

            const token = localStorage.getItem('auth_token');
            if (!token || localStorage.getItem('user_authenticated') !== 'true') {
                showToast('Please log in to write a review.');
                setTimeout(() => { window.location.href = '/login'; }, 1200);
                return;
            }

            const comment = document.getElementById('review-comment').value.trim();
            if (!comment) {
                showToast('Please write a short comment.');
                return;
            }

            const submitBtn = document.querySelector('.review-submit-btn');
            submitBtn.disabled = true;

            try {
                const res = await fetch('/api/reviews', {
                    method: 'POST',
                    headers: {
                        'Authorization': 'Bearer ' + token,
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        product_id: currentModalProductId,
                        rating: currentReviewRating,
                        comment: comment
                    })
                });

                if (res.status === 401) {
                    showToast('Your session expired. Please log in again.');
                    setTimeout(() => { window.location.href = '/login'; }, 1200);
                    return;
                }
                if (res.status === 403) {
                    showToast('Only customer accounts can write reviews.');
                    return;
                }

                const json = await res.json().catch(() => ({}));
                if (!res.ok) {
                    const first = json.errors ? Object.values(json.errors)[0][0] : null;
                    throw new Error(first || json.message || 'Could not submit your review.');
                }

                const user = JSON.parse(localStorage.getItem('auth_user') || '{}');
                currentModalReviews.push({ author: user.name || 'You', rating: currentReviewRating, comment: comment });
                if (currentModalCard) currentModalCard.dataset.reviews = JSON.stringify(currentModalReviews);
                renderModalReviews(currentModalReviews);
                toggleReviewForm(false);
                showToast('Review submitted');
            } catch (err) {
                showToast(err.message);
            } finally {
                submitBtn.disabled = false;
            }
        }

        // Specifications table and lug-width tip inside the product modal
        function renderSpecs(d) {
            const rows = [];
            if (d.lug) rows.push(['Lug width', d.lug + ' mm']);
            if (d.leather) rows.push(['Leather', d.leather]);
            if (d.color) rows.push(['Colour', d.color]);
            if (d.buckle) rows.push(['Buckle', d.buckle]);
            if (d.length) rows.push(['Length', d.length]);
            if (rows.length) rows.push(['Quick-release spring bars', d.quick === '1' ? 'Yes' : 'No']);

            const list = document.getElementById('modal-spec-list');
            list.innerHTML = '';
            rows.forEach(r => {
                const row = document.createElement('div');
                const dt = document.createElement('dt');
                const dd = document.createElement('dd');
                dt.textContent = r[0];
                dd.textContent = r[1];
                row.appendChild(dt);
                row.appendChild(dd);
                list.appendChild(row);
            });
            document.getElementById('modal-specs').classList.toggle('show', rows.length > 0);

            const tip = document.getElementById('modal-lug-tip');
            if (d.lug) {
                tip.innerHTML = '<strong>Check your lug width before you buy.</strong> This strap fits a <span></span> mm gap between the lugs, the horns where the strap attaches. Measure yours in millimetres with a ruler, or look it up in your watch\'s manual.';
                tip.querySelector('span').textContent = d.lug;
                tip.classList.add('show');
            } else {
                tip.classList.remove('show');
            }
        }

        function openProductModal(cardEl) {
            const id = cardEl.dataset.id;
            const name = cardEl.dataset.name;
            const price = cardEl.dataset.price;
            const image = cardEl.dataset.image;
            const category = cardEl.dataset.category;
            const description = cardEl.dataset.description;

            document.getElementById('modal-img').src = image;
            document.getElementById('modal-img').alt = name;
            document.getElementById('modal-category').innerText = category;
            document.getElementById('modal-name').innerText = name;
            document.getElementById('modal-price').innerText = '$' + parseFloat(price).toFixed(2);
            document.getElementById('modal-desc').innerText = description;
            renderSpecs(cardEl.dataset);

            const modalCartBtn = document.getElementById('modal-cart-btn');
            modalCartBtn.onclick = function () {
                addProductToCart(id, name, price, image, category);
                flashAdded(modalCartBtn);
            };
            document.getElementById('modal-buy-btn').onclick = function () { buyNowProduct(id, name, price, image, category); };

            // Sold-out products cannot be added or bought
            const soldOut = Number(cardEl.dataset.stock) <= 0;
            modalCartBtn.disabled = soldOut;
            document.getElementById('modal-buy-btn').disabled = soldOut;

            let reviews = [];
            if (cardEl.dataset.reviews) {
                try { reviews = JSON.parse(cardEl.dataset.reviews); } catch (e) { reviews = []; }
            }
            currentModalReviews = reviews;
            currentModalProductId = Number(cardEl.dataset.id);
            currentModalCard = cardEl;
            toggleReviewForm(false);
            renderModalReviews(currentModalReviews);

            document.getElementById('product-modal').classList.add('open');
        }

        function closeProductModal() {
            document.getElementById('product-modal').classList.remove('open');
        }

        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') closeProductModal();
        });

        updateCartCount(false);
        applyFilters();
    </script>

</body>
</html>