<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stefa - My Account</title>
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
            --gold-ring: rgba(255, 195, 77, 0.30);

            --canvas: #FBF5E8;
            --surface: #FFFDF8;
            --surface-2: #F6EAD0;
            --line: #E6D3AB;
            --ink: #2B1B0C;
            --ink-soft: #6B5238;
            --ink-faint: #7A6648;
            --danger: #B3382F;
            --danger-soft: #FBE7E2;
            --success: #2F7D4F;
            --success-soft: #E3F0E5;

            --radius-card: 16px;
            --radius-panel: 20px;
            --radius-ctl: 12px;

            --shadow-1: 0 1px 2px rgba(43, 27, 12, 0.05);
            --shadow-2: 0 8px 20px -8px rgba(43, 27, 12, 0.16);
            --shadow-panel: 0 18px 40px -22px rgba(43, 27, 12, 0.22), 0 2px 6px -2px rgba(43, 27, 12, 0.06);
            --shadow-3: 0 22px 44px -16px rgba(43, 27, 12, 0.24), 0 6px 14px -6px rgba(43, 27, 12, 0.10);
            --ring: 0 0 0 4px var(--gold-tint);

            --ease-out: cubic-bezier(0.16, 1, 0.3, 1);
            --ease-in-out: cubic-bezier(0.65, 0, 0.35, 1);
            --ease-spring: cubic-bezier(0.34, 1.56, 0.64, 1);

            /* Sidebar grid: every row uses the same left padding, icon column and gap */
            --menu-row-h: 46px;
            --menu-pad-x: 16px;
            --menu-icon: 20px;
            --menu-gap: 12px;
            --menu-sub-indent: 30px;
            --topbar-h: 62px;
        }

        * { box-sizing: border-box; }

        body { background: var(--canvas); font-family: 'Inter', system-ui, sans-serif; color: var(--ink); margin: 0; -webkit-font-smoothing: antialiased; }
        h1, h2, h3, h4 { font-family: 'Fraunces', Georgia, serif; }

        a:focus-visible, button:focus-visible, input:focus-visible, textarea:focus-visible, select:focus-visible { outline: 3px solid var(--brown); outline-offset: 2px; }
        .top-nav a:focus-visible { outline-color: var(--gold); }

        /* ===================== Top navigation ===================== */
        .top-nav { background: var(--brown); padding: 14px 48px; min-height: var(--topbar-h); display: flex; justify-content: space-between; align-items: center; position: sticky; top: 0; z-index: 10; }
        .logo { font-family: 'Fraunces', Georgia, serif; font-size: 27px; font-weight: 700; color: var(--pale); text-decoration: none; letter-spacing: 0.02em; line-height: 1; }
        .logo-accent { color: var(--gold); }
        .nav-links { display: flex; align-items: center; gap: 4px; }
        .nav-links a { text-decoration: none; color: var(--pale); font-weight: 500; font-size: 14px; display: inline-flex; align-items: center; gap: 8px; padding: 9px 14px; border-radius: var(--radius-ctl); transition: background 0.2s var(--ease-in-out), color 0.2s var(--ease-in-out); }
        .nav-links a svg { width: 18px; height: 18px; }
        .nav-links a:hover { color: #fff; background: rgba(241, 217, 168, 0.16); }
        .cart-count { min-width: 20px; height: 20px; padding: 0 6px; border-radius: 10px; background: var(--gold); color: var(--ink); font-family: 'IBM Plex Mono', monospace; font-size: 11px; font-weight: 600; display: none; align-items: center; justify-content: center; }
        .cart-count.has-items { display: inline-flex; }

        /* ===================== Layout ===================== */
        main { max-width: 1120px; margin: 48px auto 72px; padding: 0 32px; display: grid; grid-template-columns: 288px minmax(0, 1fr); gap: 32px; align-items: start; }
        @media (max-width: 800px) {
            .top-nav { padding: 12px 20px; }
            main { grid-template-columns: 1fr; padding: 0 20px; margin-top: 28px; }
        }

        /* ===================== Sidebar (user card + navigation) ===================== */
        .profile-card { background: var(--surface); border: 1px solid var(--line); border-radius: var(--radius-panel); box-shadow: var(--shadow-panel); padding: 36px 18px 18px; display: flex; flex-direction: column; align-items: center; text-align: center; position: sticky; top: 96px; }
        @media (max-width: 800px) { .profile-card { position: static; } }

        /* Profile picture: shows the photo when there is one, otherwise the first letter of the name.
           A soft light-gold ring frames it. */
        .avatar { position: relative; overflow: hidden; width: 96px; height: 96px; border-radius: 50%; background: var(--brown); color: var(--pale); font-family: 'Fraunces', Georgia, serif; font-size: 38px; font-weight: 700; display: flex; align-items: center; justify-content: center; border: 3px solid var(--gold); box-shadow: 0 0 0 7px var(--gold-ring), 0 14px 26px -12px rgba(96, 62, 30, 0.55); margin-bottom: 22px; flex-shrink: 0; }
        .avatar img { position: absolute; inset: 0; width: 100%; height: 100%; object-fit: cover; display: none; }
        .avatar.has-photo img { display: block; }
        .avatar.has-photo .avatar-letter { display: none; }

        /* Click or drop an image on the circle to change the photo */
        .avatar-upload { cursor: pointer; }
        .avatar-upload > * { pointer-events: none; }   /* keeps drag events from flickering over child elements */
        .avatar-upload:focus-visible { outline: 3px solid var(--brown); outline-offset: 6px; }
        .avatar-upload.dragover { box-shadow: 0 0 0 7px var(--gold-ring), 0 0 0 11px rgba(240, 172, 31, 0.45); }
        .avatar-overlay { position: absolute; inset: 0; display: flex; flex-direction: column; align-items: center; justify-content: center; gap: 4px; background: rgba(43, 27, 12, 0.62); color: #fff; font-family: 'Inter', sans-serif; font-size: 11px; font-weight: 600; line-height: 1.2; text-align: center; opacity: 0; transition: opacity 0.25s var(--ease-in-out); }
        .avatar-overlay svg { width: 22px; height: 22px; }
        .avatar-letter { transition: opacity 0.25s var(--ease-in-out); }
        .avatar-upload:hover .avatar-overlay,
        .avatar-upload:focus-visible .avatar-overlay,
        .avatar-upload.dragover .avatar-overlay,
        .avatar-upload.busy .avatar-overlay { opacity: 1; }
        .avatar-upload:hover .avatar-letter,
        .avatar-upload:focus-visible .avatar-letter,
        .avatar-upload.dragover .avatar-letter,
        .avatar-upload.busy .avatar-letter { opacity: 0; }

        .profile-card h3 { margin: 0; font-size: 23px; line-height: 30px; font-weight: 600; letter-spacing: -0.01em; color: var(--brown); word-break: break-word; }
        .profile-email { margin: 4px 0 0; font-size: 13px; line-height: 20px; color: var(--ink-faint); word-break: break-all; }

        .photo-remove { background: none; border: none; color: var(--danger); font-family: 'Inter', sans-serif; font-size: 13px; font-weight: 600; padding: 8px 12px; border-radius: 10px; cursor: pointer; transition: background 0.2s var(--ease-in-out); }
        .photo-remove:hover { background: var(--danger-soft); }
        .profile-card .photo-remove { margin-top: 8px; font-size: 12px; padding: 6px 12px; }
        .photo-remove:disabled { opacity: 0.6; cursor: not-allowed; }

        /* ---- Sidebar menu: one column, one left edge, identical rows ---- */
        .sidebar-menu { display: flex; flex-direction: column; align-items: stretch; gap: 4px; width: 100%; margin-top: 24px; padding-top: 18px; border-top: 1px solid var(--line); text-align: left; }

        /* Each row is a 3-column grid: [icon] [label] [optional badge] */
        .sidebar-link {
            position: relative;
            display: grid;
            grid-template-columns: var(--menu-icon) minmax(0, 1fr) auto;
            align-items: center;
            column-gap: var(--menu-gap);
            width: 100%;
            height: var(--menu-row-h);
            padding: 0 var(--menu-pad-x);
            border-radius: 999px;
            text-decoration: none;
            color: var(--ink-soft);
            font-size: 15px;
            font-weight: 500;
            line-height: 1.2;
            white-space: nowrap;
            transition: background 0.2s var(--ease-in-out), color 0.2s var(--ease-in-out), box-shadow 0.2s var(--ease-in-out);
        }
        .sidebar-link svg { width: var(--menu-icon); height: var(--menu-icon); justify-self: center; color: var(--ink-faint); transition: color 0.2s var(--ease-in-out); }
        .sidebar-link .link-label { overflow: hidden; text-overflow: ellipsis; }
        .sidebar-link:hover { background: var(--surface-2); color: var(--ink); }
        .sidebar-link:hover svg { color: var(--brown); }

        /* Active state: a subtle capsule that spans the full row, so it is always centered in the list */
        .sidebar-link.active { background: var(--gold-tint); color: var(--ink); font-weight: 600; box-shadow: inset 0 0 0 1px rgba(240, 172, 31, 0.45), 0 1px 2px rgba(96, 62, 30, 0.08); }
        .sidebar-link.active svg { color: var(--brown); }

        /* Change password: indented under Account Settings, smaller and quieter */
        .sidebar-link.sub-link { height: 38px; padding-left: calc(var(--menu-pad-x) + var(--menu-sub-indent)); padding-right: 12px; font-size: 13px; font-weight: 500; color: var(--ink-faint); }
        .sidebar-link.sub-link svg { width: 16px; height: 16px; }
        .sidebar-link.sub-link { grid-template-columns: 16px minmax(0, 1fr) auto; column-gap: 10px; }
        .sidebar-link.sub-link.active { color: var(--ink); }
        /* Elbow connector from the parent row down to this one */
        .sidebar-link.sub-link::before { content: ""; position: absolute; left: calc(var(--menu-pad-x) + 9px); top: -10px; height: 29px; width: 12px; border-left: 2px solid var(--line); border-bottom: 2px solid var(--line); border-bottom-left-radius: 8px; pointer-events: none; }
        .secure-tag { justify-self: end; font-size: 9.5px; font-weight: 700; letter-spacing: 0.06em; text-transform: uppercase; color: var(--success); background: var(--success-soft); padding: 3px 8px; border-radius: 999px; line-height: 1; }

        .unread-badge { display: none; justify-self: end; min-width: 20px; height: 20px; padding: 0 6px; border-radius: 10px; background: var(--gold); color: var(--ink); font-family: 'IBM Plex Mono', monospace; font-size: 11px; font-weight: 600; line-height: 20px; text-align: center; }
        .unread-badge.show { display: inline-block; }

        /* Separator before Log Out, then Log Out on the same grid as every other row */
        .logout-divider { height: 1px; background: var(--line); margin: 10px var(--menu-pad-x) 6px; }
        .style-logout { color: var(--danger); }
        .style-logout svg { color: var(--danger); }
        .style-logout:hover { background: var(--danger-soft); color: var(--danger); }
        .style-logout:hover svg { color: var(--danger); }

        /* ===================== Workspace ===================== */
        .workspace { display: flex; flex-direction: column; gap: 24px; min-width: 0; }

        .tab-panel { display: none; flex-direction: column; gap: 24px; scroll-margin-top: calc(var(--topbar-h) + 24px); }
        .tab-panel.active { display: flex; animation: panelIn 0.4s var(--ease-out) both; }
        @keyframes panelIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: none; } }

        /* Every content card shares the sidebar's radius, border and shadow */
        .details-panel { background: var(--surface); border: 1px solid var(--line); border-radius: var(--radius-panel); padding: 40px; box-shadow: var(--shadow-panel); }
        @media (max-width: 560px) { .details-panel { padding: 26px 20px; } }
        h2 { font-size: 28px; line-height: 34px; font-weight: 600; margin: 0 0 6px 0; letter-spacing: -0.01em; color: var(--brown); }
        h2:focus { outline: none; }
        .panel-sub { margin: 0 0 30px; font-size: 14px; line-height: 22px; color: var(--ink-soft); }

        /* Forms */
        .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 22px; margin-bottom: 22px; }
        @media (max-width: 560px) { .form-row { grid-template-columns: 1fr; } }
        .form-group { display: flex; flex-direction: column; gap: 8px; }

        label { font-size: 13px; font-weight: 600; color: var(--ink-soft); }
        input, textarea, select { height: 48px; padding: 0 16px; border-radius: var(--radius-ctl); border: 1.5px solid var(--line); font-size: 14px; outline: none; background: var(--surface); color: var(--ink); font-family: inherit; transition: border-color 0.2s var(--ease-in-out), background 0.2s var(--ease-in-out), box-shadow 0.2s var(--ease-in-out); }
        textarea { height: auto; padding: 13px 16px; }
        input::placeholder, textarea::placeholder { color: #A8967A; }
        input:hover, textarea:hover, select:hover { border-color: #CDB88A; }
        input:focus, textarea:focus, select:focus { border-color: var(--gold-deep); background: #fff; box-shadow: var(--ring); }
        input[readonly] { background: var(--surface-2); color: var(--ink-faint); cursor: not-allowed; }
        input[readonly]:hover { border-color: var(--line); }

        .form-actions { display: flex; justify-content: flex-end; margin-top: 34px; padding-top: 24px; border-top: 1px solid var(--line); }

        /* Buttons */
        .save-btn { background: var(--brown); color: var(--pale); border: none; height: 46px; padding: 0 24px; border-radius: var(--radius-ctl); font-size: 14px; font-weight: 600; cursor: pointer; transition: background 0.2s var(--ease-in-out), transform 0.2s var(--ease-out), box-shadow 0.2s var(--ease-out); width: fit-content; text-decoration: none; text-align: center; font-family: 'Inter', sans-serif; }
        .save-btn:hover { transform: translateY(-1px); }
        .save-btn:active { transform: scale(0.97); transition-duration: 0.12s; }
        .save-btn:disabled { opacity: 0.6; cursor: not-allowed; transform: none; }
        .save-btn.green-btn { background: var(--gold); color: var(--ink); font-weight: 700; min-width: 160px; box-shadow: 0 12px 22px -10px rgba(240, 172, 31, 0.75), 0 2px 4px rgba(43, 27, 12, 0.08); }
        .save-btn.green-btn:hover { background: var(--gold-deep); box-shadow: 0 16px 26px -10px rgba(240, 172, 31, 0.85), 0 2px 4px rgba(43, 27, 12, 0.08); }
        .save-btn.secondary-btn { background: var(--surface-2); color: var(--ink); border: 1px solid var(--line); }
        .save-btn.secondary-btn:hover { border-color: var(--brown); background: var(--gold-tint); }
        .save-btn.danger-btn { background: var(--danger-soft); color: var(--danger); }
        .save-btn.danger-btn:hover { background: #F5D2CE; }

        /* Orders */
        .order-item-box { border: 1px solid var(--line); border-radius: var(--radius-card); padding: 24px; margin-bottom: 16px; background: var(--surface); box-shadow: var(--shadow-1); transition: box-shadow 0.32s var(--ease-out), transform 0.32s var(--ease-out), opacity 0.3s ease; }
        .order-item-box:hover { box-shadow: var(--shadow-2); transform: translateY(-2px); }
        .order-item-box:last-child { margin-bottom: 0; }
        .order-item-box.removing { opacity: 0; transform: scale(0.98); }
        .order-header { display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid var(--line); padding-bottom: 16px; margin-bottom: 16px; flex-wrap: wrap; gap: 8px; }
        .order-header strong { font-family: 'IBM Plex Mono', monospace; font-size: 14px; font-weight: 600; }
        .order-header span.date { color: var(--ink-faint); font-size: 12px; margin-left: 10px; }

        .status-badge { background: var(--gold-tint); color: var(--brown); padding: 5px 12px; border-radius: 30px; font-size: 12px; font-weight: 600; display: inline-block; }
        .status-badge.complete { background: var(--success-soft); color: var(--success); }
        .status-badge.cancelled { background: var(--danger-soft); color: var(--danger); }

        .order-body { display: flex; justify-content: space-between; align-items: center; font-size: 14px; flex-wrap: wrap; gap: 12px; }
        .order-body p.item-name { margin: 0 0 4px; font-weight: 600; font-size: 15px; }
        .order-body p.item-sub { margin: 4px 0 0; color: var(--ink-soft); font-size: 13px; }
        .order-body p.item-sub.fulfilled { color: var(--success); font-weight: 600; }
        .order-body p.item-sub.cancelled-note { color: var(--danger); font-weight: 600; }
        .action-flex { display: flex; gap: 12px; align-items: center; }
        .price-tag { font-family: 'IBM Plex Mono', monospace; font-weight: 600; font-size: 18px; letter-spacing: -0.02em; }
        .reviewed-tag { display: inline-flex; align-items: center; gap: 7px; height: 38px; padding: 0 16px; border-radius: 999px; background: var(--surface-2); border: 1px solid var(--line); color: var(--ink-faint); font-size: 12.5px; font-weight: 600; letter-spacing: 0.01em; cursor: not-allowed; user-select: none; pointer-events: none; }
        .reviewed-tag svg { width: 14px; height: 14px; flex-shrink: 0; }

        /* Delivery details shown at the bottom of each order (dashed rule = stitch line) */
        .delivery-box { margin-top: 16px; padding-top: 16px; border-top: 2px dashed var(--line); font-size: 13px; color: var(--ink-soft); line-height: 1.6; }
        .delivery-box p { margin: 0; }
        .delivery-box strong { color: var(--ink); }
        .delivery-title { display: block; font-size: 13px; font-weight: 600; color: var(--brown); margin-bottom: 4px; }
        .delivery-pay { margin-top: 8px; }

        .notice-item { border: 1px solid var(--line); border-radius: var(--radius-card); padding: 16px 20px; margin-bottom: 12px; background: var(--surface); }
        .notice-item:last-child { margin-bottom: 0; }
        .notice-item.notice-new { border-color: var(--gold-deep); background: var(--gold-tint); }
        .notice-item p { margin: 0 0 6px; font-size: 14px; font-weight: 500; line-height: 1.5; }
        .notice-item span { font-size: 12px; color: var(--ink-faint); }
        .notice-item { position: relative; padding-right: 60px; transition: opacity 0.28s ease, transform 0.28s ease; }
        .notice-item.removing { opacity: 0; transform: scale(0.98); }
        .notice-delete { position: absolute; top: 50%; right: 14px; transform: translateY(-50%); width: 34px; height: 34px; display: inline-flex; align-items: center; justify-content: center; border-radius: 50%; border: 1px solid transparent; background: transparent; color: var(--ink-faint); cursor: pointer; opacity: 0; transition: opacity 0.25s ease, background 0.2s, color 0.2s, border-color 0.2s; }
        .notice-delete svg { width: 16px; height: 16px; }
        .notice-item:hover .notice-delete, .notice-delete:focus-visible { opacity: 1; }
        .notice-delete:hover { background: var(--danger-soft); color: var(--danger); border-color: #F0C9C3; }
        .notice-delete:disabled { opacity: 0.5; cursor: not-allowed; }
        @media (hover: none) { .notice-delete { opacity: 1; } }
        .notices-toolbar { display: flex; justify-content: flex-end; margin: -10px 0 16px; }
        .notices-toolbar .save-btn { height: 38px; padding: 0 16px; font-size: 13px; }
        .notices-toolbar[hidden] { display: none; }

        .empty-orders { color: var(--ink-soft); font-size: 14px; text-align: center; padding: 28px 0 8px; display: none; }
        .orders-status { color: var(--ink-soft); font-size: 14px; text-align: center; padding: 28px 0 8px; }

        /* Review form */
        .review-form-box { display: none; margin-top: 24px; padding-top: 24px; border-top: 1px solid var(--line); }
        .review-form-box.open { display: block; animation: panelIn 0.4s var(--ease-out) both; }
        .review-form-box h4 { font-size: 17px; font-weight: 600; color: var(--brown); margin: 0 0 16px 0; }
        .star-rating { display: flex; gap: 4px; }
        .star-rating .star { font-size: 28px; line-height: 1; cursor: pointer; color: var(--line); transition: color 0.1s, transform 0.2s var(--ease-spring); user-select: none; }
        .star-rating .star:hover { transform: scale(1.12); }
        .star-rating .star.filled { color: #E0A400; }
        .star-rating-label { font-size: 13px; color: var(--ink-soft); margin-top: 4px; }
        .review-done { color: var(--success); font-weight: 600; margin: 0; }

        /* Payment & shipping info cards */
        .card-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
        @media (max-width: 560px) { .card-grid { grid-template-columns: 1fr; } }
        .info-card { background: var(--surface-2); border: 1px solid var(--line); border-radius: var(--radius-card); padding: 24px; display: flex; flex-direction: column; gap: 10px; }
        .info-card h4 { margin: 0; font-size: 18px; font-weight: 600; color: var(--brown); }
        .info-card p { margin: 0; font-size: 14px; color: var(--ink-soft); line-height: 22px; }
        .info-card .save-btn { margin-top: 8px; }

        /* Toast */
        .toast { position: fixed; left: 50%; bottom: 28px; transform: translate(-50%, 16px); background: var(--brown); color: var(--pale); padding: 12px 18px; border-radius: var(--radius-ctl); font-size: 14px; font-weight: 500; box-shadow: var(--shadow-3); opacity: 0; pointer-events: none; transition: opacity 0.2s var(--ease-in-out), transform 0.32s var(--ease-out); z-index: 200; }
        .toast.show { opacity: 1; transform: translate(-50%, 0); }
        /* Success toast: brand brown with a gold check */
        .toast.success { display: flex; align-items: center; gap: 10px; padding: 13px 20px 13px 14px; background: linear-gradient(180deg, #6B4723 0%, #55371A 100%); letter-spacing: 0.005em; }
        .toast.success::before { content: "\2713"; flex-shrink: 0; width: 22px; height: 22px; border-radius: 50%; background: var(--gold); color: var(--ink); font-size: 12px; font-weight: 700; display: flex; align-items: center; justify-content: center; }

        /* My reviews */
        .review-card { border: 1px solid var(--line); border-radius: var(--radius-card); padding: 22px 24px; margin-bottom: 16px; background: var(--surface); box-shadow: var(--shadow-1); transition: box-shadow 0.32s var(--ease-out), opacity 0.3s ease, transform 0.3s ease; }
        .review-card:last-child { margin-bottom: 0; }
        .review-card.removing { opacity: 0; transform: scale(0.98); }
        .review-card-head { display: flex; justify-content: space-between; align-items: flex-start; gap: 12px; flex-wrap: wrap; margin-bottom: 10px; }
        .review-card-head h4 { margin: 0; font-size: 17px; font-weight: 600; color: var(--brown); }
        .review-meta { font-size: 12px; color: var(--ink-faint); margin-top: 2px; }
        .review-stars { font-size: 18px; letter-spacing: 2px; color: #E0A400; white-space: nowrap; }
        .review-stars .off { color: var(--line); }
        .review-text { margin: 0; font-size: 14px; line-height: 22px; color: var(--ink-soft); word-break: break-word; }
        .review-actions { display: flex; justify-content: flex-end; gap: 6px; margin-top: 10px; opacity: 0; transform: translateY(2px); transition: opacity 0.25s ease, transform 0.25s var(--ease-out); }
        .review-card:hover .review-actions, .review-actions:focus-within { opacity: 1; transform: none; }
        @media (hover: none) { .review-actions { opacity: 1; } }
        .review-icon-btn { width: 34px; height: 34px; display: inline-flex; align-items: center; justify-content: center; border-radius: 50%; border: 1px solid transparent; background: transparent; color: var(--ink-faint); cursor: pointer; transition: background 0.2s, color 0.2s, border-color 0.2s; }
        .review-icon-btn svg { width: 16px; height: 16px; }
        .review-icon-btn:hover { background: var(--surface-2); color: var(--brown); border-color: var(--line); }
        .review-icon-btn.danger:hover { background: var(--danger-soft); color: var(--danger); border-color: #F0C9C3; }
        .review-icon-btn:disabled { opacity: 0.5; cursor: not-allowed; }
        .review-edit { display: none; margin-top: 16px; padding-top: 16px; border-top: 1px solid var(--line); }
        .review-card.editing .review-edit { display: block; animation: panelIn 0.4s var(--ease-out) both; }
        .review-card.editing .review-text, .review-card.editing .review-actions { display: none; }
        .review-edit .edit-actions { display: flex; gap: 10px; margin-top: 18px; }

        @media (prefers-reduced-motion: reduce) {
            *, *::before, *::after { animation-duration: 0.01ms !important; transition-duration: 0.01ms !important; }
            .order-item-box:hover, .save-btn:hover { transform: none; }
        }
    </style>
</head>
<body>

    <nav class="top-nav" aria-label="Main navigation">
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
        <!-- Sidebar: identity card and the only navigation on this page -->
        <aside class="profile-card">
            <div class="avatar avatar-upload" id="avatar-box" role="button" tabindex="0" aria-label="Change profile photo">
                <span class="avatar-letter" id="avatar-initial">S</span>
                <img id="avatar-img" alt="">
                <div class="avatar-overlay">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"></path><circle cx="12" cy="13" r="4"></circle></svg>
                    <span class="overlay-text">Add photo</span>
                </div>
            </div>
            <h3 id="sidebar-name">Your account</h3>
            <p class="profile-email" id="sidebar-email"></p>
            <button type="button" class="photo-remove" id="avatar-remove" style="display: none;">Remove photo</button>
            <input type="file" id="avatar-file" accept="image/jpeg,image/png,image/webp" hidden>

            <!-- Every link below is a direct child of one flex column, so they all share the same left edge -->
            <nav class="sidebar-menu" aria-label="Account navigation">
                <a href="#" class="sidebar-link active" data-tab="info-section">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="4" y="11" width="16" height="10" rx="2.5"></rect><path d="M8 11V7a4 4 0 0 1 8 0v4"></path></svg>
                    <span class="link-label">Account Settings</span>
                </a>
                <a href="#" class="sidebar-link sub-link" data-tab="password-section">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="8" cy="15" r="4"></circle><path d="M11 12l9-9M16 7l3 3M14 9l2 2"></path></svg>
                    <span class="link-label">Change password</span>
                    <span class="secure-tag">Secure</span>
                </a>
                <a href="#" class="sidebar-link" data-tab="orders-section">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M6 3h12v18l-3-2-3 2-3-2-3 2V3z"></path><path d="M9.5 8h5M9.5 12h5"></path></svg>
                    <span class="link-label">Order History</span>
                </a>
                <a href="#" class="sidebar-link" data-tab="reviews-section">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M12 3l2.7 5.6 6.1.9-4.4 4.3 1 6.1L12 17l-5.4 2.9 1-6.1L3.2 9.5l6.1-.9L12 3z"></path></svg>
                    <span class="link-label">My Reviews</span>
                </a>
                <a href="#" class="sidebar-link" data-tab="checkout-section">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="2.5" y="5" width="19" height="14" rx="2.5"></rect><path d="M2.5 10h19M6.5 15h4"></path></svg>
                    <span class="link-label">Payment &amp; Shipping</span>
                </a>
                <a href="#" class="sidebar-link" data-tab="notices-section">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M6 9a6 6 0 0 1 12 0c0 6 2.5 7.5 2.5 7.5h-17S6 15 6 9z"></path><path d="M10 20a2 2 0 0 0 4 0"></path></svg>
                    <span class="link-label">Notifications</span>
                    <span class="unread-badge" id="side-unread"></span>
                </a>
                <a href="/cart" class="sidebar-link">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="9" cy="21" r="1.5"></circle><circle cx="18" cy="21" r="1.5"></circle><path d="M2.5 3h2l2.7 12.4a2 2 0 0 0 2 1.6h7.6a2 2 0 0 0 2-1.6L21 8H6"></path></svg>
                    <span class="link-label">Cart</span>
                </a>
                <div class="logout-divider" role="separator"></div>
                <a href="/shop" class="sidebar-link style-logout" id="logout-link">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M9 3H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h4"></path><path d="M16 17l5-5-5-5"></path><path d="M21 12H9"></path></svg>
                    <span class="link-label">Log Out</span>
                </a>
            </nav>
        </aside>

        <section class="workspace" id="workspace">

            <!-- Account Settings (saved through the API) -->
            <div id="info-section" class="tab-panel active">
                <div class="details-panel">
                    <h2 tabindex="-1">Account Information</h2>
                    <p class="panel-sub">Keep your details up to date so checkout and delivery stay quick.</p>

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

                        <div class="form-group">
                            <label for="input-address">Delivery street address</label>
                            <input type="text" id="input-address" placeholder="House/Apartment Number, Street Name, Barangay Name" value="" required>
                        </div>

                        <div class="form-actions">
                            <button type="submit" class="save-btn green-btn">Save changes</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Change password (its own page, opened from the sidebar) -->
            <div id="password-section" class="tab-panel">
                <div class="details-panel">
                    <h2 tabindex="-1">Change Password</h2>
                    <p class="panel-sub">Choose a strong password you do not use anywhere else. You will stay signed in on this device.</p>

                    <form id="password-form">
                        <div class="form-group" style="margin-bottom: 22px;">
                            <label for="pw-current">Current password</label>
                            <input type="password" id="pw-current" autocomplete="current-password" required>
                        </div>
                        <div class="form-row" style="margin-bottom: 0;">
                            <div class="form-group">
                                <label for="pw-new">New password</label>
                                <input type="password" id="pw-new" minlength="8" placeholder="Minimum 8 characters" autocomplete="new-password" required>
                            </div>
                            <div class="form-group">
                                <label for="pw-confirm">Confirm new password</label>
                                <input type="password" id="pw-confirm" minlength="8" autocomplete="new-password" required>
                            </div>
                        </div>

                        <div class="form-actions">
                            <button type="submit" class="save-btn green-btn">Update password</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Orders (loaded from the API) -->
            <div id="orders-section" class="tab-panel">
                <div class="details-panel">
                    <h2 tabindex="-1">Order History</h2>
                    <p class="panel-sub">Track, cancel or review the orders you have placed.</p>

                    <div id="orders-list">
                        <p class="orders-status">Loading your orders...</p>
                    </div>

                    <p class="empty-orders" id="empty-orders">You have no orders yet. Browse the shop to place your first one.</p>
                </div>
            </div>

            <!-- My reviews (edit or delete) -->
            <div id="reviews-section" class="tab-panel">
                <div class="details-panel">
                    <h2 tabindex="-1">My Reviews</h2>
                    <p class="panel-sub">Edit or delete the reviews you have written.</p>
                    <div id="reviews-list">
                        <p class="orders-status">Loading your reviews...</p>
                    </div>
                </div>
            </div>

            <!-- Payment & shipping -->
            <div id="checkout-section" class="tab-panel">
                <div class="details-panel">
                    <h2 tabindex="-1">Payment &amp; Shipping</h2>
                    <p class="panel-sub">What we use when you check out.</p>
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

            <!-- Notifications (delivery updates the admin sends) -->
            <div id="notices-section" class="tab-panel">
                <div class="details-panel">
                    <h2 tabindex="-1">Notifications</h2>
                    <p class="panel-sub">Delivery updates for your orders appear here.</p>
                    <div class="notices-toolbar" id="notices-toolbar" hidden>
                        <button type="button" class="save-btn secondary-btn" id="clear-notices">Clear all</button>
                    </div>
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
        function showToast(message, kind) {
            const toast = document.getElementById('toast');
            toast.textContent = message;
            toast.classList.toggle('success', kind === 'success');
            toast.classList.add('show');
            clearTimeout(toastTimer);
            toastTimer = setTimeout(() => toast.classList.remove('show'), 2400);
        }

        // Everything that belongs to the signed-in person, so nothing is left behind for the next visitor
        function clearSession() {
            ['auth_token', 'auth_user', 'user_authenticated', 'stefashop_profile', 'stefashop_orders']
                .forEach(key => localStorage.removeItem(key));
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

        // ---------- Sidebar navigation ----------
        const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)');

        // Bring the top header of the opened panel into view (smooth, and instant for reduced-motion users).
        // The panel's scroll-margin-top keeps it clear of the sticky top bar.
        function scrollPanelToTop(panel) {
            panel.scrollIntoView({ behavior: reduceMotion.matches ? 'auto' : 'smooth', block: 'start' });

            // Move keyboard / screen reader focus to the panel heading without causing a second scroll
            const heading = panel.querySelector('h2');
            if (heading) heading.focus({ preventScroll: true });
        }

        function switchTab(sectionId, options) {
            const panel = document.getElementById(sectionId);
            if (!panel) return;

            document.querySelectorAll('.tab-panel').forEach(p => p.classList.remove('active'));
            panel.classList.add('active');
            document.querySelectorAll('.sidebar-link[data-tab]').forEach(l => l.classList.toggle('active', l.dataset.tab === sectionId));

            if (sectionId === 'orders-section') loadOrders();
            if (sectionId === 'reviews-section') loadReviews();
            if (sectionId === 'notices-section') loadNotices(true);

            // Wait one frame so the newly shown panel has its final position before scrolling
            if (!options || options.scroll !== false) {
                requestAnimationFrame(() => scrollPanelToTop(panel));
            }
        }

        document.querySelectorAll('.sidebar-link[data-tab]').forEach(el => {
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

        // URL of the profile picture ('' = no photo, the first letter of the name is shown instead)
        let currentAvatar = saved.avatar_url || '';

        function cacheProfile() {
            localStorage.setItem('stefashop_profile', JSON.stringify({
                name: fields.name.value.trim(),
                phone: fields.phone.value.trim(),
                city: fields.city.value.trim(),
                address: fields.address.value.trim(),
                avatar_url: currentAvatar
            }));
        }

        // Show the photo in the sidebar, or fall back to the initial letter
        function setAvatar(url) {
            currentAvatar = url || '';
            [['avatar-box', 'avatar-img']].forEach(function (pair) {
                const box = document.getElementById(pair[0]);
                const img = document.getElementById(pair[1]);
                if (currentAvatar) {
                    img.src = currentAvatar;
                    box.classList.add('has-photo');
                } else {
                    img.removeAttribute('src');
                    box.classList.remove('has-photo');
                }
            });
            document.getElementById('avatar-remove').style.display = currentAvatar ? '' : 'none';
            document.querySelectorAll('.overlay-text').forEach(function (el) {
                el.textContent = currentAvatar ? 'Change photo' : 'Add photo';
            });
        }

        // If the picture file cannot be loaded, show the initial letter instead
        ['avatar-img'].forEach(function (id) {
            document.getElementById(id).addEventListener('error', function () {
                this.parentElement.classList.remove('has-photo');
            });
        });

        function refreshIdentity() {
            const name = fields.name.value.trim() || 'Your account';
            const initial = name.charAt(0).toUpperCase();
            document.getElementById('sidebar-name').textContent = name;
            document.getElementById('sidebar-email').textContent = fields.email.value;
            document.getElementById('avatar-initial').textContent = initial;

            const summary = document.getElementById('ship-summary');
            summary.innerHTML = '';
            const lines = [name, fields.address.value, fields.city.value];
            lines.forEach((line, i) => {
                if (i > 0) summary.appendChild(document.createElement('br'));
                summary.appendChild(document.createTextNode(line));
            });
        }
        refreshIdentity();
        setAvatar(currentAvatar);

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
                setAvatar(p.avatar_url || '');
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

        // ---------- Profile photo (POST and DELETE /api/profile/avatar) ----------
        const AVATAR_TYPES = ['image/jpeg', 'image/png', 'image/webp'];
        const AVATAR_MAX_BYTES = 2 * 1024 * 1024;
        const avatarFile = document.getElementById('avatar-file');
        const avatarRemove = document.getElementById('avatar-remove');
        const avatarBoxes = ['avatar-box'].map(id => document.getElementById(id));
        let avatarBusy = false;

        // Upload a photo that was chosen or dropped
        async function uploadAvatar(file) {
            if (!file || avatarBusy) return;

            if (AVATAR_TYPES.indexOf(file.type) === -1) {
                showToast('Choose a JPG, PNG or WEBP image.');
                return;
            }
            if (file.size > AVATAR_MAX_BYTES) {
                showToast('The photo is too large. The limit is 2 MB.');
                return;
            }

            // Show the new photo right away, and go back to the old one if the upload fails
            const previous = currentAvatar;
            setAvatar(URL.createObjectURL(file));
            avatarBusy = true;
            avatarRemove.disabled = true;
            avatarBoxes.forEach(function (box) {
                box.classList.add('busy');
                box.querySelector('.overlay-text').textContent = 'Uploading...';
            });

            try {
                const fd = new FormData();
                fd.append('avatar', file);

                // No Content-Type header here: the browser sets it for the file upload
                const res = await fetch('/api/profile/avatar', {
                    method: 'POST',
                    headers: {
                        'Authorization': 'Bearer ' + localStorage.getItem('auth_token'),
                        'Accept': 'application/json'
                    },
                    body: fd
                });

                if (res.status === 401) { sessionExpired(); return; }

                const json = await res.json().catch(() => ({}));
                if (!res.ok) throw new Error(errorText(json, 'Could not upload the photo.'));

                setAvatar((json.data && json.data.avatar_url) || '');
                cacheProfile();
                showToast('Profile photo updated');
            } catch (err) {
                setAvatar(previous);
                showToast(err.message);
            }

            avatarBusy = false;
            avatarRemove.disabled = false;
            avatarBoxes.forEach(box => box.classList.remove('busy'));
        }

        // Pick a file: click (or Enter / Space) on the avatar circle
        avatarFile.addEventListener('change', function () {
            const file = avatarFile.files[0];
            avatarFile.value = '';   // lets the same file be chosen again later
            uploadAvatar(file);
        });

        avatarBoxes.forEach(function (box) {
            function openPicker() { if (!avatarBusy) avatarFile.click(); }

            box.addEventListener('click', openPicker);
            box.addEventListener('keydown', function (e) {
                if (e.key === 'Enter' || e.key === ' ') {
                    e.preventDefault();
                    openPicker();
                }
            });

            // Drag an image file over the circle, then drop it
            ['dragenter', 'dragover'].forEach(function (type) {
                box.addEventListener(type, function (e) {
                    e.preventDefault();
                    box.classList.add('dragover');
                });
            });
            ['dragleave', 'dragend'].forEach(function (type) {
                box.addEventListener(type, function () { box.classList.remove('dragover'); });
            });
            box.addEventListener('drop', function (e) {
                e.preventDefault();
                box.classList.remove('dragover');
                const files = e.dataTransfer && e.dataTransfer.files;
                if (files && files.length) uploadAvatar(files[0]);
            });
        });

        avatarRemove.addEventListener('click', async function () {
            if (!confirm('Remove your profile photo?')) return;

            avatarRemove.disabled = true;

            try {
                const res = await fetch('/api/profile/avatar', { method: 'DELETE', headers: authHeaders() });

                if (res.status === 401) { sessionExpired(); return; }

                const json = await res.json().catch(() => ({}));
                if (!res.ok) throw new Error(errorText(json, 'Could not remove the photo.'));

                setAvatar('');
                cacheProfile();
                showToast('Profile photo removed');
            } catch (err) {
                showToast(err.message);
            }

            avatarRemove.disabled = false;
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
            const total = StefaCart.read().reduce((sum, item) => sum + (item.quantity || 1), 0);
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

        let reviewedIds = new Set();      // 'orderId:productId' keys this customer already reviewed
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

        // Each purchase (order + product) can be reviewed once, so buying the same strap again lets you review it again
        function reviewKey(orderId, productId) { return Number(orderId) + ':' + Number(productId); }

        function needsReview(item, orderId) {
            return !item.productId || !reviewedIds.has(reviewKey(orderId, item.productId));
        }

        // Delivery details work with both response shapes: order.shipping.{...} or flat shipping_* fields
        function shippingOf(order) {
            const s = order.shipping || {};
            return {
                name: s.name || order.shipping_name || '',
                phone: s.phone || order.shipping_phone || '',
                address: s.address || order.shipping_address || '',
                city: s.city || order.shipping_city || '',
                zip: s.zip || order.shipping_zip || '',
                payment: s.payment_method || order.payment_method || ''
            };
        }

        // Orders placed before shipping details were saved have none, so nothing is shown for them
        function deliveryHtml(order) {
            const s = shippingOf(order);
            if (!s.name && !s.address) return '';

            const place = [s.address, s.city, s.zip].filter(Boolean).map(esc).join(', ');
            return '<div class="delivery-box">' +
                '<span class="delivery-title">Deliver to</span>' +
                '<p><strong>' + esc(s.name || '-') + '</strong>' + (s.phone ? ' \u00B7 ' + esc(s.phone) : '') + '</p>' +
                (place ? '<p>' + place + '</p>' : '') +
                (s.payment ? '<span class="status-badge delivery-pay">' + esc(s.payment) + '</span>' : '') +
            '</div>';
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
                action = items.some(it => needsReview(it, order.id))
                    ? '<button type="button" class="save-btn secondary-btn" onclick="openReview(this)">Leave a review</button>'
                    : '<span class="reviewed-tag" role="status" aria-disabled="true" title="You have already reviewed this purchase"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="5" y="11" width="14" height="9" rx="2"></rect><path d="M8 11V8a4 4 0 0 1 8 0v3"></path></svg>Reviewed \u2713</span>';
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
                    deliveryHtml(order) +
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
                    reviewedIds = new Set((mine.data || []).map(r => reviewKey(r.order_id, r.product_id)));
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

        function reviewFormHtml(items, orderId) {
            const options = items
                .map((it, i) => ({ it: it, i: i }))
                .filter(x => needsReview(x.it, orderId))
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
                formBox.innerHTML = reviewFormHtml(items, box.dataset.id);
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
                            body: JSON.stringify({ product_id: productId, order_id: Number(box.dataset.id), rating: Number(rating), comment: comment })
                        });

                        if (res.status === 401) { sessionExpired(); return; }

                        const json = await res.json().catch(() => ({}));
                        if (!res.ok) throw new Error([404, 405].includes(res.status) || res.status >= 500 ? 'We couldn\'t submit your review. Please try again.' : errorText(json, 'We couldn\'t submit your review. Please try again.'));

                        reviewedIds.add(reviewKey(box.dataset.id, productId));
                        formBox.innerHTML = '<p class="review-done">\u2713 Review submitted. Thank you for your feedback.</p>';
                        showToast('Review submitted successfully', 'success');
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

        function initStarRating(container, initial) {
            const stars = container.querySelectorAll('.star');
            const labelEl = container.parentElement.querySelector('.star-rating-label');
            const hiddenInput = container.parentElement.querySelector('input[type="hidden"]');
            const labels = { 1: 'Bad', 2: 'Poor', 3: 'Average', 4: 'Good', 5: 'Excellent' };
            let selected = Number(initial) || 0;
            if (hiddenInput && selected) hiddenInput.value = selected;

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
            render(selected);
        }

        // ---------- My reviews (GET /api/reviews/mine, PUT and DELETE /api/reviews/{id}) ----------
        const PENCIL_ICON = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M12 20h9"></path><path d="M16.5 3.5a2.1 2.1 0 0 1 3 3L7 19l-4 1 1-4z"></path></svg>';
        const TRASH_ICON = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M3 6h18"></path><path d="M8 6V4h8v2"></path><path d="M19 6l-1 14H6L5 6"></path><path d="M10 11v6M14 11v6"></path></svg>';
        let myReviews = [];

        function reviewProductName(r) {
            const p = r.product && (r.product.data || r.product);
            return (p && p.name) || r.product_name || ('Product #' + r.product_id);
        }

        function starsHtml(rating) {
            const n = Math.max(0, Math.min(5, Number(rating) || 0));
            return '<span class="review-stars" aria-label="' + n + ' out of 5 stars">' +
                '\u2605'.repeat(n) + '<span class="off">' + '\u2605'.repeat(5 - n) + '</span></span>';
        }

        function reviewCardHtml(r) {
            const edited = r.updated_at && r.created_at && r.updated_at !== r.created_at;
            return '<div class="review-card" data-id="' + esc(r.id) + '">' +
                '<div class="review-card-head">' +
                    '<div><h4>' + esc(reviewProductName(r)) + '</h4>' +
                    '<div class="review-meta">' + esc(formatDate(r.created_at)) + (r.order_id ? ' \u00B7 Order #STF-' + String(r.order_id).padStart(5, '0') : '') + (edited ? ' \u00B7 edited' : '') + '</div></div>' +
                    starsHtml(r.rating) +
                '</div>' +
                '<p class="review-text">' + esc(r.comment || '') + '</p>' +
                '<div class="review-actions">' +
                    '<button type="button" class="review-icon-btn" data-action="edit" title="Edit review" aria-label="Edit your review">' + PENCIL_ICON + '</button>' +
                    '<button type="button" class="review-icon-btn danger" data-action="delete" title="Delete review" aria-label="Delete your review">' + TRASH_ICON + '</button>' +
                '</div>' +
                '<form class="review-edit">' +
                    '<div class="form-group">' +
                        '<label>Star rating</label>' +
                        '<div class="star-rating">' +
                            [1, 2, 3, 4, 5].map(i => '<span class="star" data-value="' + i + '">\u2605</span>').join('') +
                        '</div>' +
                        '<div class="star-rating-label">Select a rating</div>' +
                        '<input type="hidden" name="rating">' +
                    '</div>' +
                    '<div class="form-group" style="margin-top: 16px;">' +
                        '<label for="edit-text-' + esc(r.id) + '">Your feedback</label>' +
                        '<textarea id="edit-text-' + esc(r.id) + '" rows="3" required style="resize: none;"></textarea>' +
                    '</div>' +
                    '<div class="edit-actions">' +
                        '<button type="submit" class="save-btn green-btn">Save changes</button>' +
                        '<button type="button" class="save-btn secondary-btn" data-action="cancel">Cancel</button>' +
                    '</div>' +
                '</form>' +
            '</div>';
        }

        function renderReviews() {
            const list = document.getElementById('reviews-list');
            if (!myReviews.length) {
                list.innerHTML = '<p class="orders-status">You have not written any reviews yet. After an order is delivered, you can review its products from Order History.</p>';
                return;
            }
            list.innerHTML = myReviews.map(reviewCardHtml).join('');
        }

        async function loadReviews() {
            const list = document.getElementById('reviews-list');
            try {
                const res = await fetch('/api/reviews/mine', { headers: authHeaders() });
                if (res.status === 401) { sessionExpired(); return; }
                if (res.status === 403) {
                    list.innerHTML = '<p class="orders-status">Reviews are only available for customer accounts.</p>';
                    return;
                }
                const json = await res.json();
                myReviews = Array.isArray(json) ? json : (json.data || []);
                reviewedIds = new Set(myReviews.map(r => reviewKey(r.order_id, r.product_id)));
                renderReviews();
            } catch (err) {
                list.innerHTML = '<p class="orders-status">Could not load your reviews. Please try again.</p>';
            }
        }

        function openReviewEdit(card, review) {
            const form = card.querySelector('.review-edit');
            if (!form.dataset.ready) {
                initStarRating(form.querySelector('.star-rating'), review.rating);
                form.dataset.ready = '1';
                form.addEventListener('submit', e => { e.preventDefault(); saveReviewEdit(card, review, form); });
            }
            form.querySelector('textarea').value = review.comment || '';
            card.classList.add('editing');
            form.querySelector('textarea').focus();
        }

        async function saveReviewEdit(card, review, form) {
            const rating = Number(form.querySelector('input[name="rating"]').value);
            const comment = form.querySelector('textarea').value.trim();
            if (!rating) { showToast('Please choose a star rating first.'); return; }
            if (!comment) { showToast('Please write your feedback.'); return; }

            const button = form.querySelector('button[type="submit"]');
            button.disabled = true;
            try {
                const res = await fetch('/api/reviews/' + review.id, {
                    method: 'PUT',
                    headers: authHeaders(),
                    body: JSON.stringify({ rating: rating, comment: comment })
                });
                if (res.status === 401) { sessionExpired(); return; }
                const json = await res.json().catch(() => ({}));
                if (!res.ok) throw new Error([404, 405].includes(res.status) || res.status >= 500 ? 'We couldn\'t update your review. Please try again.' : errorText(json, 'We couldn\'t update your review. Please try again.'));

                const updated = json.data || {};
                Object.assign(review, { rating: rating, comment: comment, updated_at: updated.updated_at || new Date().toISOString() });
                renderReviews();
                showToast('Review updated successfully', 'success');
            } catch (err) {
                button.disabled = false;
                showToast(err.message);
            }
        }

        async function deleteReview(card, review) {
            if (!confirm('Delete your review of ' + reviewProductName(review) + '? This cannot be undone.')) return;

            const buttons = card.querySelectorAll('button');
            buttons.forEach(b => b.disabled = true);
            try {
                const res = await fetch('/api/reviews/' + review.id, { method: 'DELETE', headers: authHeaders() });
                if (res.status === 401) { sessionExpired(); return; }
                const json = await res.json().catch(() => ({}));
                if (!res.ok) throw new Error([404, 405].includes(res.status) || res.status >= 500 ? 'We couldn\'t delete your review. Please try again.' : errorText(json, 'We couldn\'t delete your review. Please try again.'));

                card.classList.add('removing');
                setTimeout(function () {
                    myReviews = myReviews.filter(r => r.id !== review.id);
                    reviewedIds.delete(reviewKey(review.order_id, review.product_id));   // the product can be reviewed again from Order History
                    renderReviews();
                }, 300);
                showToast('Review deleted successfully', 'success');
            } catch (err) {
                buttons.forEach(b => b.disabled = false);
                showToast(err.message);
            }
        }

        document.getElementById('reviews-list').addEventListener('click', function (e) {
            const btn = e.target.closest('[data-action]');
            if (!btn) return;
            const card = btn.closest('.review-card');
            const review = myReviews.find(r => String(r.id) === card.dataset.id);
            if (!review) return;

            if (btn.dataset.action === 'edit') openReviewEdit(card, review);
            if (btn.dataset.action === 'cancel') card.classList.remove('editing');
            if (btn.dataset.action === 'delete') deleteReview(card, review);
        });

        // ---------- Notifications (GET /api/notices, POST /api/notices/read) ----------
        function setUnreadBadges(count) {
            const badge = document.getElementById('side-unread');
            badge.textContent = count;
            badge.classList.toggle('show', count > 0);
        }

        function formatDateTime(iso) {
            const d = new Date(iso);
            if (isNaN(d.getTime())) return '';
            return d.toLocaleString('en-US', { month: 'short', day: 'numeric', year: 'numeric', hour: 'numeric', minute: '2-digit' });
        }

        const NOTICE_TRASH_ICON = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M3 6h18"></path><path d="M8 6V4h8v2"></path><path d="M19 6l-1 14H6L5 6"></path><path d="M10 11v6M14 11v6"></path></svg>';
        const NOTICES_EMPTY = '<p class="orders-status">No notifications yet. You will see delivery updates for your orders here.</p>';

        function noticeHtml(notice) {
            return '<div class="notice-item' + (notice.read ? '' : ' notice-new') + '" data-id="' + esc(notice.id) + '">' +
                '<p>' + esc(notice.message) + '</p>' +
                '<span>' + esc(formatDateTime(notice.created_at)) + '</span>' +
                '<button type="button" class="notice-delete" data-action="delete-notice" title="Delete notification" aria-label="Delete this notification">' + NOTICE_TRASH_ICON + '</button>' +
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
                document.getElementById('notices-toolbar').hidden = !notices.length;

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

        // ---------- Delete notifications (DELETE /api/notices/{id} and DELETE /api/notices) ----------
        function afterNoticesChanged() {
            const list = document.getElementById('notices-list');
            const left = list.querySelectorAll('.notice-item').length;
            document.getElementById('notices-toolbar').hidden = left === 0;
            if (!left) list.innerHTML = NOTICES_EMPTY;
        }

        // Our own wording instead of raw server errors
        function noticeError(res, json, fallback) {
            return [404, 405].includes(res.status) || res.status >= 500 ? fallback : errorText(json, fallback);
        }

        async function deleteNotice(item, btn) {
            btn.disabled = true;
            try {
                const res = await fetch('/api/notices/' + item.dataset.id, { method: 'DELETE', headers: authHeaders() });
                if (res.status === 401) { sessionExpired(); return; }

                const json = await res.json().catch(() => ({}));
                if (!res.ok) throw new Error(noticeError(res, json, 'We couldn\'t delete this notification. Please try again.'));

                item.classList.add('removing');
                setTimeout(function () { item.remove(); afterNoticesChanged(); }, 280);
                showToast('Notification deleted successfully', 'success');
            } catch (err) {
                btn.disabled = false;
                showToast(err.message);
            }
        }

        async function clearNotices(btn) {
            if (!confirm('Delete all your notifications? This cannot be undone.')) return;

            btn.disabled = true;
            try {
                const res = await fetch('/api/notices', { method: 'DELETE', headers: authHeaders() });
                if (res.status === 401) { sessionExpired(); return; }

                const json = await res.json().catch(() => ({}));
                if (!res.ok) throw new Error(noticeError(res, json, 'We couldn\'t clear your notifications. Please try again.'));

                document.getElementById('notices-list').innerHTML = NOTICES_EMPTY;
                document.getElementById('notices-toolbar').hidden = true;
                setUnreadBadges(0);
                showToast('All notifications cleared', 'success');
            } catch (err) {
                showToast(err.message);
            }
            btn.disabled = false;
        }

        document.getElementById('notices-list').addEventListener('click', function (e) {
            const btn = e.target.closest('[data-action="delete-notice"]');
            if (!btn) return;
            const item = btn.closest('.notice-item');
            if (item) deleteNotice(item, btn);
        });
        document.getElementById('clear-notices').addEventListener('click', function () { clearNotices(this); });

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
            localStorage.removeItem('stefashop_checkout_items');
        });

        // ---------- First load ----------
        loadProfile();
        loadOrders();
        loadNotices(false);
    </script>

    <!-- Show / hide password eye toggle -->
    <script src="/js/password-toggle.js"></script>
</body>
</html>