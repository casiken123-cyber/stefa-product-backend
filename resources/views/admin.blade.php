<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>StefaShop - Administrative Master Control Center</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:wght@600;700&family=Inter:wght@400;500;600&family=IBM+Plex+Mono:wght@500;600&display=swap" rel="stylesheet">
    <style>
        :root {
            /* Palette: Brown, Pale Gold, Glowing Gold, plus leather tones */
            --brown: #603E1E;
            --pale: #F1D9A8;
            --gold: #FFC34D;
            --gold-deep: #F0AC1F;
            --gold-tint: rgba(255, 195, 77, 0.22);
            --leather: #2A1A0B;
            --leather-2: #3A2411;

            --ink: #2B1B0C;
            --ink-soft: #6B5238;
            --ink-faint: #7A6648;
            --canvas: #FBF5E8;
            --panel: #FFFDF8;
            --cloud: #F6EAD0;
            --line: #E6D3AB;
            --row-line: #F0E3C4;

            --danger: #B3382F;
            --danger-soft: #FBE7E2;
            --success: #2F7D4F;
            --success-soft: #E3F0E5;
            --info: #603E1E;
            --info-soft: #F1D9A8;
            --warn: #8A5200;
            --warn-soft: #FFE9B8;

            --radius-lg: 14px;
            --radius-md: 10px;
        }

        * { box-sizing: border-box; }
        body.locked { visibility: hidden; }

        body {
            font-family: 'Inter', system-ui, sans-serif;
            background: var(--canvas);
            color: var(--ink);
            margin: 0;
            display: flex;
            height: 100vh;
            overflow: hidden;
            -webkit-font-smoothing: antialiased;
        }

        h1, h2, h3, .display { font-family: 'Fraunces', Georgia, serif; }

        a:focus-visible, button:focus-visible, input:focus-visible, select:focus-visible, textarea:focus-visible {
            outline: 3px solid var(--brown);
            outline-offset: 2px;
        }
        aside a:focus-visible { outline-color: var(--gold); }

        /* ---------- Sidebar: dark leather with a stitched edge ---------- */
        aside {
            width: 264px;
            flex-shrink: 0;
            color: #E5D2A8;
            display: flex;
            flex-direction: column;
            padding: 26px 24px 26px 22px;
            overflow-y: auto;
            background:
                repeating-linear-gradient(to bottom, rgba(241, 217, 168, 0.34) 0 7px, transparent 7px 13px) right 9px top 14px / 2px calc(100% - 28px) no-repeat,
                linear-gradient(180deg, var(--leather-2), var(--leather));
        }
        .admin-brand {
            font-family: 'Fraunces', Georgia, serif;
            font-size: 26px;
            font-weight: 700;
            color: var(--pale);
            margin-bottom: 30px;
            text-decoration: none;
            letter-spacing: 0.04em;
            line-height: 1.1;
        }
        .admin-brand span { color: var(--gold); }
        .admin-brand small {
            display: block;
            margin-top: 6px;
            font-family: 'Inter', sans-serif;
            font-size: 12px;
            font-weight: 500;
            letter-spacing: 0;
            color: #B39C76;
        }
        .sidebar-section-title {
            font-size: 12px;
            font-weight: 600;
            color: #B39C76;
            margin: 22px 0 8px 12px;
        }
        .menu-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 14px;
            color: #E5D2A8;
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            border-radius: var(--radius-md);
            margin-bottom: 4px;
            transition: background 0.15s, color 0.15s;
        }
        .menu-link:hover { background: rgba(241, 217, 168, 0.09); color: #fff; }
        .menu-link.active {
            background: rgba(255, 195, 77, 0.16);
            box-shadow: inset 3px 0 0 var(--gold);
            color: #fff;
            font-weight: 600;
        }

        /* ---------- Content workspace ---------- */
        main { flex: 1; display: flex; flex-direction: column; background: var(--canvas); overflow-y: auto; min-width: 0; }
        header {
            position: sticky;
            top: 0;
            z-index: 5;
            background: var(--panel);
            padding: 16px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid var(--line);
        }
        header > div { font-weight: 600; color: var(--ink-soft); font-size: 14px; }
        header a { text-decoration: none; color: var(--danger); font-size: 13px; font-weight: 600; }
        header a:hover { color: #8C2820; }

        .workspace-view-panel { padding: 32px 36px; display: none; }
        .workspace-view-panel.active { display: block; }

        h1 { font-size: 28px; line-height: 36px; font-weight: 600; margin: 0 0 6px 0; letter-spacing: -0.01em; color: var(--brown); }
        .sub-heading { font-size: 14px; color: var(--ink-soft); margin: 0 0 24px 0; max-width: 70ch; }

        /* ---------- KPI stat cards ----------
           Every card uses the same 4-slot layout so heights, icon size,
           label position and number baseline match across all cards:
             1. top row    : icon badge (left) + trend / status chip (right)
             2. label      : one line, never wraps
             3. value      : large monospaced number
             4. footer     : time range or short context
        */
        .stats-grid { display: grid; grid-template-columns: repeat(4, minmax(0, 1fr)); gap: 18px; margin-bottom: 32px; }
        .stat-card {
            display: grid;
            grid-template-rows: auto auto 1fr auto;
            row-gap: 4px;
            min-height: 176px;
            padding: 18px 20px 16px;
            background: var(--panel);
            border: 1px solid var(--line);
            border-radius: var(--radius-lg);
            transition: transform 0.25s ease, box-shadow 0.25s ease;
        }
        .stat-card:hover { transform: translateY(-3px); box-shadow: 0 16px 30px -18px rgba(43, 27, 12, 0.4); }

        .stat-top { display: flex; align-items: center; justify-content: space-between; gap: 10px; min-height: 40px; }
        .stat-ico { width: 40px; height: 40px; flex-shrink: 0; border-radius: 12px; display: flex; align-items: center; justify-content: center; background: var(--gold-tint); color: var(--brown); }
        .stat-ico svg { width: 20px; height: 20px; }

        .stat-label {
            margin: 10px 0 0;
            font-size: 13px;
            line-height: 18px;
            font-weight: 500;
            color: var(--ink-soft);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .stat-value {
            align-self: center;
            margin: 0;
            font-family: 'IBM Plex Mono', monospace;
            font-size: 30px;
            line-height: 40px;
            font-weight: 600;
            letter-spacing: -0.02em;
            color: var(--ink);
            font-variant-numeric: tabular-nums;
            white-space: nowrap;
        }
        .stat-foot {
            display: flex;
            align-items: center;
            gap: 6px;
            min-height: 28px;
            padding-top: 10px;
            border-top: 1px dashed var(--line);
            font-size: 12px;
            line-height: 16px;
            font-weight: 500;
            color: var(--ink-faint);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        /* Trend / status chips */
        .stat-chip {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            height: 24px;
            padding: 0 9px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: 600;
            white-space: nowrap;
            background: var(--cloud);
            color: var(--ink-soft);
        }
        .stat-chip svg { width: 11px; height: 11px; }
        .stat-chip.up { background: var(--success-soft); color: var(--success); }
        .stat-chip.down { background: var(--danger-soft); color: var(--danger); }
        .stat-chip.warn { background: var(--warn-soft); color: var(--warn); }
        .stat-chip.info { background: var(--info-soft); color: var(--info); }

        /* The first card (sales) is the one to look at */
        .stats-grid .stat-card:first-child { background: var(--brown); border-color: var(--brown); }
        .stats-grid .stat-card:first-child .stat-label { color: #E5D2A8; }
        .stats-grid .stat-card:first-child .stat-value { color: var(--gold); }
        .stats-grid .stat-card:first-child .stat-ico { background: rgba(255, 195, 77, 0.18); color: var(--gold); }
        .stats-grid .stat-card:first-child .stat-foot { border-top-color: rgba(241, 217, 168, 0.28); color: #CDB78C; }
        .stats-grid .stat-card:first-child .stat-chip { background: rgba(241, 217, 168, 0.16); color: var(--pale); }
        .stats-grid .stat-card:first-child .stat-chip.up { background: rgba(120, 209, 150, 0.2); color: #A8E6BD; }
        .stats-grid .stat-card:first-child .stat-chip.down { background: rgba(255, 138, 124, 0.2); color: #FFC1B8; }

        /* ---------- Tables (scroll sideways when wider than the panel) ---------- */
        .table-card { background: var(--panel); border-radius: var(--radius-lg); border: 1px solid var(--line); overflow-x: auto; }
        table { width: 100%; border-collapse: collapse; text-align: left; font-size: 14px; }
        th {
            background: var(--cloud);
            padding: 13px 14px;
            font-weight: 600;
            color: var(--ink-soft);
            font-size: 13px;
            border-bottom: 1px solid var(--line);
            white-space: nowrap;
        }
        td { padding: 14px 14px; border-bottom: 1px solid var(--row-line); color: var(--ink); vertical-align: middle; }
        tbody tr:hover td { background: #FFF8E8; }
        tr:last-child td { border-bottom: none; }
        td strong { font-weight: 600; }
        td.table-note { text-align: center; color: var(--ink-soft); padding: 32px 24px; }
        tbody tr:hover td.table-note { background: transparent; }

        /* ---------- Badges ---------- */
        .badge {
            background: var(--cloud);
            color: var(--ink-soft);
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            display: inline-block;
        }
        .badge.green { background: var(--success-soft); color: var(--success); }
        .badge.blue { background: var(--info-soft); color: var(--info); }
        .badge.orange { background: var(--warn-soft); color: var(--warn); }
        .badge.red { background: var(--danger-soft); color: var(--danger); }

        /* ---------- Buttons ---------- */
        .action-btn {
            background: var(--panel);
            border: 1px solid var(--line);
            padding: 6px 12px;
            border-radius: 8px;
            font-size: 12px;
            font-weight: 600;
            cursor: pointer;
            color: var(--brown);
            margin-right: 4px;
            font-family: 'Inter', sans-serif;
            transition: background 0.15s, border-color 0.15s, color 0.15s;
        }
        .action-btn:hover { background: var(--cloud); border-color: var(--brown); }
        .action-btn.danger { color: var(--danger); }
        .action-btn.danger:hover { background: var(--danger-soft); border-color: var(--danger); }
        .action-btn:disabled { opacity: 0.6; cursor: not-allowed; }
        .action-btn.primary-btn {
            background: var(--gold);
            color: var(--ink);
            border: none;
            padding: 10px 18px;
            font-size: 13px;
            font-weight: 700;
            border-radius: var(--radius-md);
            margin-bottom: 16px;
        }
        .action-btn.primary-btn:hover { background: var(--gold-deep); }

        .thumb { width: 44px; height: 44px; border-radius: 10px; object-fit: cover; border: 1px solid var(--line); background: var(--cloud); display: block; }
        .status-select {
            padding: 7px 10px;
            border-radius: 8px;
            border: 1px solid var(--line);
            background: var(--panel);
            font-family: 'Inter', sans-serif;
            font-size: 13px;
            font-weight: 600;
            color: var(--ink);
            cursor: pointer;
        }
        .status-select:hover:not(:disabled) { border-color: var(--brown); }
        .order-items-cell { font-size: 13px; color: var(--ink-soft); line-height: 1.5; }
        .ship-cell { font-size: 13px; color: var(--ink-soft); line-height: 1.5; min-width: 170px; }
        .order-actions { display: flex; flex-direction: column; align-items: flex-start; gap: 6px; }
        .order-actions .action-btn { margin-right: 0; white-space: nowrap; }
        .ship-cell strong { color: var(--ink); }
        .ship-cell .ship-pay { display: inline-block; margin-top: 4px; }
        .money { font-family: 'IBM Plex Mono', monospace; font-weight: 600; }
        .stars { color: #C98A00; letter-spacing: 2px; white-space: nowrap; font-size: 15px; }
        .comment-cell { max-width: 320px; font-size: 13px; color: var(--ink-soft); line-height: 1.5; }

        /* ---------- Modals ---------- */
        .modal-overlay {
            position: fixed;
            inset: 0;
            background: rgba(43, 27, 12, 0.55);
            display: none;
            align-items: center;
            justify-content: center;
            padding: 20px;
            z-index: 100;
        }
        .modal-overlay.show { display: flex; }
        .modal-card {
            background: var(--panel);
            border: 1px solid var(--line);
            border-radius: 18px;
            width: 100%;
            max-width: 540px;
            max-height: 92vh;
            overflow-y: auto;
            padding: 28px;
            box-shadow: 0 30px 60px -20px rgba(43, 27, 12, 0.5);
        }
        .modal-card h2 { margin: 0 0 20px 0; font-size: 24px; font-weight: 600; color: var(--brown); }
        .field { display: flex; flex-direction: column; gap: 6px; margin-bottom: 16px; }
        .field-row { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; }
        .field label { font-size: 13px; font-weight: 600; color: var(--ink-soft); }
        .field input, .field textarea, .field select {
            padding: 11px 14px;
            border-radius: 10px;
            border: 1px solid var(--line);
            background: var(--cloud);
            font-family: inherit;
            font-size: 14px;
            color: var(--ink);
            outline: none;
        }
        .field input:focus, .field textarea:focus, .field select:focus {
            border-color: var(--gold-deep);
            background: var(--panel);
            box-shadow: 0 0 0 4px var(--gold-tint);
        }
        .check-row { display: flex; align-items: center; gap: 10px; margin-bottom: 16px; font-size: 14px; font-weight: 500; color: var(--ink); cursor: pointer; }
        .check-row input { width: 18px; height: 18px; accent-color: var(--brown); cursor: pointer; }
        .strap-cell { font-size: 13px; color: var(--ink-soft); line-height: 1.5; min-width: 150px; }
        .strap-cell strong { color: var(--ink); }
        .modal-error { display: none; background: var(--danger-soft); color: var(--danger); border: 1px solid #F0C4BE; border-radius: 10px; padding: 10px 14px; font-size: 13px; font-weight: 500; margin-bottom: 14px; }
        .modal-actions { display: flex; justify-content: flex-end; gap: 10px; margin-top: 8px; }
        .modal-actions .action-btn { margin: 0; padding: 10px 18px; font-size: 13px; }
        .image-preview { width: 84px; height: 84px; border-radius: 12px; object-fit: cover; border: 1px solid var(--line); background: var(--cloud); margin-top: 6px; display: none; }
        .info-lines { background: var(--cloud); border: 1px solid var(--line); border-radius: 12px; padding: 6px 16px; margin-bottom: 16px; }
        .info-lines div { display: flex; justify-content: space-between; gap: 16px; padding: 9px 0; border-bottom: 1px solid var(--line); font-size: 13px; }
        .info-lines div:last-child { border-bottom: none; }
        .info-lines span { color: var(--ink-soft); font-weight: 600; }
        .info-lines em { font-style: normal; text-align: right; word-break: break-word; }

        /* ---------- Toasts (top right) ---------- */
        .toast-stack { position: fixed; top: 20px; right: 20px; z-index: 400; display: flex; flex-direction: column; gap: 10px; width: min(380px, calc(100vw - 32px)); pointer-events: none; }
        .toast { pointer-events: auto; display: flex; align-items: flex-start; gap: 12px; padding: 14px 14px 14px 16px; border-radius: 14px; background: var(--brown); color: var(--pale); box-shadow: 0 18px 38px -16px rgba(43, 27, 12, 0.55); font-size: 14px; line-height: 20px; font-weight: 500; animation: toastIn 0.35s cubic-bezier(0.16, 1, 0.3, 1) both; }
        .toast.error { background: #7A2A22; color: #FBE7E2; }
        .toast.leaving { animation: toastOut 0.25s ease forwards; }
        .toast-icon { flex-shrink: 0; width: 22px; height: 22px; border-radius: 50%; background: var(--gold); color: var(--ink); display: flex; align-items: center; justify-content: center; font-size: 12px; font-weight: 700; }
        .toast.error .toast-icon { background: #FBE7E2; color: #7A2A22; }
        .toast-text { flex: 1; min-width: 0; word-break: break-word; padding-top: 1px; }
        .toast-close { flex-shrink: 0; background: none; border: none; color: inherit; opacity: 0.7; cursor: pointer; font-size: 12px; padding: 4px; border-radius: 6px; }
        .toast-close:hover { opacity: 1; background: rgba(255, 255, 255, 0.12); }
        @keyframes toastIn { from { opacity: 0; transform: translateX(24px); } to { opacity: 1; transform: none; } }
        @keyframes toastOut { to { opacity: 0; transform: translateX(24px); } }

        /* ---------- Small dialogs, steppers, clear buttons and preset chips ---------- */
        .modal-card.sm { max-width: 460px; }
        .modal-sub { margin: -10px 0 18px; font-size: 14px; color: var(--ink-soft); line-height: 20px; }
        .field-hint { margin: 2px 0 0; font-size: 13px; color: var(--ink-soft); }
        .field-meta { display: flex; justify-content: space-between; gap: 12px; font-size: 12px; color: var(--ink-faint); }
        .field textarea { resize: vertical; min-height: 96px; line-height: 1.5; }

        .stepper { display: flex; align-items: stretch; border: 1px solid var(--line); border-radius: 10px; background: var(--cloud); overflow: hidden; }
        .stepper:focus-within { border-color: var(--gold-deep); background: var(--panel); box-shadow: 0 0 0 4px var(--gold-tint); }
        .stepper button { width: 46px; border: none; background: none; font-size: 20px; color: var(--brown); cursor: pointer; }
        .stepper button:hover { background: var(--gold-tint); }
        .field .stepper input { flex: 1; min-width: 0; border: none; border-left: 1px solid var(--line); border-right: 1px solid var(--line); border-radius: 0; background: transparent; text-align: center; font-family: 'IBM Plex Mono', monospace; font-size: 18px; font-weight: 600; box-shadow: none; -moz-appearance: textfield; }
        .field .stepper input:focus { box-shadow: none; background: transparent; }
        .stepper input::-webkit-outer-spin-button, .stepper input::-webkit-inner-spin-button,
        .input-wrap input[type="number"]::-webkit-outer-spin-button, .input-wrap input[type="number"]::-webkit-inner-spin-button { -webkit-appearance: none; margin: 0; }

        .input-wrap { position: relative; }
        .input-wrap input { width: 100%; padding-right: 42px; }
        .input-wrap input[type="number"] { -moz-appearance: textfield; }
        .clear-x { position: absolute; right: 8px; top: 50%; transform: translateY(-50%); width: 26px; height: 26px; border: none; border-radius: 50%; background: var(--line); color: var(--ink-soft); font-size: 11px; cursor: pointer; display: none; align-items: center; justify-content: center; }
        .clear-x:hover { background: var(--brown); color: var(--pale); }
        .input-wrap.has-value .clear-x { display: flex; }

        .chips { display: flex; flex-wrap: wrap; gap: 6px; margin-top: 2px; }
        .chips:empty { display: none; }
        .chip { height: 28px; padding: 0 10px; border-radius: 999px; border: 1px solid var(--line); background: var(--panel); color: var(--ink-soft); font-family: 'Inter', sans-serif; font-size: 12px; font-weight: 600; cursor: pointer; transition: background 0.15s, border-color 0.15s, color 0.15s; }
        .chip:hover { border-color: var(--brown); color: var(--ink); }
        .chip[aria-pressed="true"] { background: var(--brown); border-color: var(--brown); color: var(--pale); }
        .chips-label { font-size: 12px; font-weight: 600; color: var(--ink-faint); margin: 0 0 6px; }

        .modal-actions .action-btn.ghost { margin-right: auto; background: none; border-color: transparent; color: var(--ink-soft); }
        .modal-actions .action-btn.ghost:hover { background: var(--cloud); border-color: var(--line); color: var(--brown); }
        .action-btn.danger-solid { background: var(--danger); color: #fff; border: none; }
        .action-btn.danger-solid:hover { background: #8C2820; }

        /* Keep browser autofill from turning fields blue */
        .field input:-webkit-autofill, .field textarea:-webkit-autofill, .field select:-webkit-autofill {
            -webkit-box-shadow: 0 0 0 100px var(--cloud) inset;
            -webkit-text-fill-color: var(--ink);
            caret-color: var(--ink);
        }

        /* ---------- Dashboard polish ---------- */
        .hero { display: flex; justify-content: space-between; align-items: flex-end; gap: 16px; margin-bottom: 24px; }
        .hero h1 { margin: 0 0 4px; }
        .hero .sub-heading { margin: 0; }
        .hero-date { font-size: 13px; font-weight: 500; color: var(--ink-soft); white-space: nowrap; }
        .dash-grid { display: grid; grid-template-columns: 2fr 1fr; gap: 18px; margin-bottom: 18px; }
        .panel { background: var(--panel); border: 1px solid var(--line); border-radius: var(--radius-lg); padding: 22px; min-width: 0; }
        .panel h2 { font-family: 'Inter', sans-serif; font-size: 15px; font-weight: 600; margin: 0 0 4px; }
        .panel-sub { margin: 0; font-size: 13px; color: var(--ink-soft); }
        .bars { display: flex; align-items: stretch; gap: 8px; height: 200px; margin-top: 18px; padding-bottom: 2px; border-bottom: 1px solid var(--line); }
        .bar-col { flex: 1; min-width: 0; display: flex; flex-direction: column; align-items: center; }
        .bar-val { height: 16px; font-family: 'IBM Plex Mono', monospace; font-size: 11px; color: var(--ink-soft); white-space: nowrap; }
        .bar-track { flex: 1; width: 100%; position: relative; }
        .bar { position: absolute; bottom: 0; left: 50%; transform: translateX(-50%); width: 100%; max-width: 40px; height: 0; border-radius: 8px 8px 2px 2px; background: var(--pale); transition: height 0.8s cubic-bezier(0.16, 1, 0.3, 1); }
        .bar.today { background: var(--gold); }
        .bar-col:hover .bar { background: var(--gold-deep); }
        .bar-days { display: flex; gap: 8px; margin-top: 8px; }
        .bar-days span { flex: 1; text-align: center; font-size: 11px; color: var(--ink-faint); }
        .st-row { margin-top: 16px; }
        .st-head { display: flex; justify-content: space-between; gap: 12px; font-size: 13px; margin-bottom: 6px; color: var(--ink-soft); font-weight: 500; }
        .st-head strong { color: var(--ink); font-family: 'IBM Plex Mono', monospace; }
        .st-track { height: 8px; border-radius: 4px; background: var(--cloud); overflow: hidden; }
        .st-fill { height: 100%; width: 0; border-radius: 4px; transition: width 0.8s cubic-bezier(0.16, 1, 0.3, 1); }
        .st-fill.pending { background: var(--gold-deep); }
        .st-fill.processing { background: var(--brown); }
        .st-fill.completed { background: var(--success); }
        .st-fill.cancelled { background: var(--danger); }
        .panel .table-card { border: none; border-radius: 0; margin-top: 12px; }
        .panel .table-note { padding: 20px; }
        @media (max-width: 1100px) { .dash-grid { grid-template-columns: 1fr; } }

        /* ---------- Smaller screens ---------- */
        @media (max-width: 1100px) {
            .stats-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); }
        }
        @media (max-width: 820px) {
            body { flex-direction: column; height: auto; min-height: 100vh; overflow: auto; }
            aside { width: 100%; padding: 20px; background: linear-gradient(180deg, var(--leather-2), var(--leather)); }
            main { overflow: visible; }
            header { padding: 14px 20px; position: static; }
            .workspace-view-panel { padding: 24px 20px; }
            .field-row { grid-template-columns: 1fr; }
            .hero { flex-direction: column; align-items: flex-start; }
        }
        @media (max-width: 560px) {
            .stats-grid { grid-template-columns: 1fr; }
            .stat-card { min-height: 164px; }
        }
        @media (prefers-reduced-motion: reduce) {
            *, *::before, *::after { transition-duration: 0.01ms !important; animation-duration: 0.01ms !important; }
            .stat-card:hover { transform: none; }
        }
    </style>
</head>
<body class="locked">

    <!--  Administrative Navigation Sidebar Container -->
    <aside>
        <a href="/admin" class="admin-brand">STEFA<span>SHOP</span> <small>Admin Terminal</small></a>

        <nav style="display: flex; flex-direction: column; flex: 1;">
            <a href="#" class="menu-link active" onclick="switchAdminTab('dashboard', this)">Admin Dashboard</a>

            <div class="sidebar-section-title">Identity & Access</div>
            <a href="#" class="menu-link" onclick="switchAdminTab('users', this)">User Management</a>
            <a href="#" class="menu-link" onclick="switchAdminTab('admins', this)">Admin Accounts</a>

            <div class="sidebar-section-title">Storefront Content</div>
            <a href="#" class="menu-link" onclick="switchAdminTab('categories', this)">Category Management</a>
            <a href="#" class="menu-link" onclick="switchAdminTab('products', this)">Product Management</a>
            <a href="#" class="menu-link" onclick="switchAdminTab('inventory', this)">Inventory Stocks</a>

            <div class="sidebar-section-title">Fulfillment & Operations</div>
            <a href="#" class="menu-link" onclick="switchAdminTab('orders', this)">Orders</a>
            <a href="#" class="menu-link" onclick="switchAdminTab('reviews', this)">Buyer Reviews</a>

            <div class="sidebar-section-title">Analytics</div>
            <a href="#" class="menu-link" onclick="switchAdminTab('reports', this)">Sales Report</a>
        </nav>
    </aside>

    <!--  Right Side Content Output Workspaces Panel Window -->
    <main>
        <header>
            <div id="operator-label">System Operator Workspace Session</div>
            <a href="/login" id="exit-link">Exit Control Terminal →</a>
        </header>

        <!-- PANEL SECTION 1: DASHBOARD -->
        <section id="tab-dashboard" class="workspace-view-panel active">
            <div class="hero">
                <div>
                    <h1 id="hello">Control Panel Dashboard</h1>
                    <p class="sub-heading">Here is how STEFA is doing today.</p>
                </div>
                <span class="hero-date" id="hero-date"></span>
            </div>

            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-top">
                        <span class="stat-ico"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="9"></circle><path d="M14.5 9a2.5 2 0 0 0-2.5-1.5c-1.4 0-2.5.7-2.5 2s1 1.7 2.5 2 2.5.7 2.5 2-1.1 2-2.5 2A2.5 2 0 0 1 9.5 15M12 6.5v1.5M12 16v1.5"></path></svg></span>
                        <span class="stat-chip" id="stat-sales-chip">&mdash;</span>
                    </div>
                    <p class="stat-label" title="Gross Marketplace Sales">Gross Marketplace Sales</p>
                    <h3 class="stat-value" id="stat-sales">...</h3>
                    <div class="stat-foot" id="stat-sales-foot">All time &middot; excludes cancelled</div>
                </div>
                <div class="stat-card">
                    <div class="stat-top">
                        <span class="stat-ico"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="9" cy="8" r="3.5"></circle><path d="M2.5 20c0-3.5 3-6 6.5-6s6.5 2.5 6.5 6M16 4.5a3.5 3.5 0 0 1 0 7M18 14.5c2 .7 3.5 2.6 3.5 5.5"></path></svg></span>
                        <span class="stat-chip info" id="stat-users-chip">Customers</span>
                    </div>
                    <p class="stat-label" title="Active Users">Active Users</p>
                    <h3 class="stat-value" id="stat-users">...</h3>
                    <div class="stat-foot" id="stat-users-foot">Registered accounts</div>
                </div>
                <div class="stat-card">
                    <div class="stat-top">
                        <span class="stat-ico"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 8h14l-1 12H6L5 8zM9 8V6a3 3 0 0 1 6 0v2"></path></svg></span>
                        <span class="stat-chip" id="stat-orders-chip">&mdash;</span>
                    </div>
                    <p class="stat-label" title="Fulfillment Order Traffic">Fulfillment Order Traffic</p>
                    <h3 class="stat-value" id="stat-orders">...</h3>
                    <div class="stat-foot" id="stat-orders-foot">All orders to date</div>
                </div>
                <div class="stat-card">
                    <div class="stat-top">
                        <span class="stat-ico"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M12 3l9 16H3L12 3zM12 10v4M12 17h.01"></path></svg></span>
                        <span class="stat-chip" id="stat-low-chip">&mdash;</span>
                    </div>
                    <p class="stat-label" title="Stock Warning Low Units">Stock Warning Low Units</p>
                    <h3 class="stat-value" id="stat-low">...</h3>
                    <div class="stat-foot" id="stat-low-foot">Flagged at 5 units or fewer</div>
                </div>
            </div>

            <div class="dash-grid">
                <div class="panel">
                    <h2>Sales, last 7 days</h2>
                    <p class="panel-sub">Cancelled orders are not counted.</p>
                    <div class="bars" id="dash-bars"></div>
                    <div class="bar-days" id="dash-bars-days"></div>
                </div>
                <div class="panel">
                    <h2>Orders by status</h2>
                    <p class="panel-sub">All orders to date.</p>
                    <div id="dash-status"></div>
                </div>
            </div>

            <div class="panel">
                <h2>Recent orders</h2>
                <div class="table-card">
                    <table>
                        <thead><tr><th>Order</th><th>Customer</th><th>Total</th><th>Status</th><th>Placed</th></tr></thead>
                        <tbody id="dash-recent"><tr><td colspan="5" class="table-note">Loading orders...</td></tr></tbody>
                    </table>
                </div>
            </div>
        </section>

        <!-- PANEL SECTION 2: USER MANAGEMENT DIRECTORY (live from the API) -->
        <section id="tab-users" class="workspace-view-panel">
            <h1>User Account Directory</h1>
            <p class="sub-heading">View customer details, update their name and email, or remove accounts that have no orders.</p>
            <div class="table-card">
                <table>
                    <thead><tr><th>User ID</th><th>Customer Name</th><th>Email Address</th><th>Orders</th><th>Total Spent</th><th>Actions Control</th></tr></thead>
                    <tbody id="users-body"><tr><td colspan="6" class="table-note">Loading users...</td></tr></tbody>
                </table>
            </div>
        </section>

        <!-- PANEL SECTION 2B: ADMIN ACCOUNTS (live from the API) -->
        <section id="tab-admins" class="workspace-view-panel">
            <h1>Administrator Accounts</h1>
            <p class="sub-heading">Create, edit or remove the accounts that can sign in to this terminal. You cannot delete your own account.</p>
            <button class="action-btn primary-btn" onclick="openAdminModal(null)">Add Admin Account</button>
            <div class="table-card">
                <table>
                    <thead><tr><th>Admin ID</th><th>Name</th><th>Email Address</th><th>Role</th><th>Created</th><th>Actions Control</th></tr></thead>
                    <tbody id="admins-body"><tr><td colspan="6" class="table-note">Loading admin accounts...</td></tr></tbody>
                </table>
            </div>
        </section>

        <!-- PANEL SECTION 3: CATEGORIES ALLOCATIONS MANAGEMENT (live from the API) -->
        <section id="tab-categories" class="workspace-view-panel">
            <h1>Category Inventory Framework</h1>
            <p class="sub-heading">Add, rename or remove store departments. Renaming a category also updates its products.</p>
            <button class="action-btn primary-btn" onclick="openCategoryModal(null)">Add Category Selection</button>
            <div class="table-card">
                <table>
                    <thead><tr><th>System Department ID</th><th>Category Title Name</th><th>Products Bound Count</th><th>Actions Control</th></tr></thead>
                    <tbody id="categories-body"><tr><td colspan="4" class="table-note">Loading categories...</td></tr></tbody>
                </table>
            </div>
        </section>

        <!-- PANEL SECTION 4: PRODUCT MANAGEMENT WORKSPACE (live from the API) -->
        <section id="tab-products" class="workspace-view-panel">
            <h1>Store Catalog Items Registry</h1>
            <p class="sub-heading">Configure product parameters data properties, description layouts, and prices.</p>
            <button class="action-btn primary-btn" onclick="openProductModal(null)">Add Product to Store</button>
            <div class="table-card">
                <table>
                    <thead><tr><th>Image</th><th>Product Name</th><th>Category</th><th>Strap Details</th><th>Price</th><th>Stock</th><th>Actions Control</th></tr></thead>
                    <tbody id="products-body"><tr><td colspan="7" class="table-note">Loading products...</td></tr></tbody>
                </table>
            </div>
        </section>

        <!-- PANEL SECTION 5: INVENTORY STOCKS (live from the API) -->
        <section id="tab-inventory" class="workspace-view-panel">
            <h1>Inventory Stock Levels</h1>
            <p class="sub-heading">Monitor stock counts and update them. Products with 5 units or fewer are flagged as low.</p>
            <div class="table-card">
                <table>
                    <thead><tr><th>Product Name</th><th>Category</th><th>Units In Stock</th><th>Status</th><th>Actions Control</th></tr></thead>
                    <tbody id="inventory-body"><tr><td colspan="5" class="table-note">Loading inventory...</td></tr></tbody>
                </table>
            </div>
        </section>

        <!-- PANEL SECTION 6: ORDERS (live from the API) -->
        <section id="tab-orders" class="workspace-view-panel">
            <h1>Customer Orders</h1>
            <p class="sub-heading">Review every order, see where it must be delivered, and update its fulfillment status. Cancelled orders can be deleted.</p>
            <div class="table-card">
                <table>
                    <thead><tr><th>Order</th><th>Customer</th><th>Delivery Details</th><th>Items</th><th>Total</th><th>Placed</th><th>Status</th><th>Delivery Update</th></tr></thead>
                    <tbody id="orders-body"><tr><td colspan="8" class="table-note">Loading orders...</td></tr></tbody>
                </table>
            </div>
        </section>

        <!-- PANEL SECTION 7: BUYER REVIEWS (live from the API) -->
        <section id="tab-reviews" class="workspace-view-panel">
            <h1>Buyer Reviews</h1>
            <p class="sub-heading">Feedback customers left on products from their completed orders. Remove reviews that break your rules.</p>
            <div class="table-card">
                <table>
                    <thead><tr><th>Product</th><th>Customer</th><th>Rating</th><th>Comment</th><th>Date</th><th>Actions Control</th></tr></thead>
                    <tbody id="reviews-body"><tr><td colspan="6" class="table-note">Loading reviews...</td></tr></tbody>
                </table>
            </div>
        </section>

        <!-- PANEL SECTION 8: SALES REPORT -->
        <section id="tab-reports" class="workspace-view-panel">
            <h1>Sales Report</h1>
            <p class="sub-heading">Summary built from live order and catalog data. Cancelled orders are not counted in sales.</p>
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-top">
                        <span class="stat-ico"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="9"></circle><path d="M14.5 9a2.5 2 0 0 0-2.5-1.5c-1.4 0-2.5.7-2.5 2s1 1.7 2.5 2 2.5.7 2.5 2-1.1 2-2.5 2A2.5 2 0 0 1 9.5 15M12 6.5v1.5M12 16v1.5"></path></svg></span>
                        <span class="stat-chip" id="rep-sales-chip">&mdash;</span>
                    </div>
                    <p class="stat-label" title="Gross Sales">Gross Sales</p>
                    <h3 class="stat-value" id="rep-sales">...</h3>
                    <div class="stat-foot" id="rep-sales-foot">All time &middot; excludes cancelled</div>
                </div>
                <div class="stat-card">
                    <div class="stat-top">
                        <span class="stat-ico"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 8h14l-1 12H6L5 8zM9 8V6a3 3 0 0 1 6 0v2"></path></svg></span>
                        <span class="stat-chip" id="rep-orders-chip">&mdash;</span>
                    </div>
                    <p class="stat-label" title="Total Orders">Total Orders</p>
                    <h3 class="stat-value" id="rep-orders">...</h3>
                    <div class="stat-foot" id="rep-orders-foot">All orders to date</div>
                </div>
                <div class="stat-card">
                    <div class="stat-top">
                        <span class="stat-ico"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M4 19V5M4 19h16M8 15l3-4 3 2 5-6"></path></svg></span>
                        <span class="stat-chip" id="rep-avg-chip">&mdash;</span>
                    </div>
                    <p class="stat-label" title="Average Order Value">Average Order Value</p>
                    <h3 class="stat-value" id="rep-avg">...</h3>
                    <div class="stat-foot" id="rep-avg-foot">Sales divided by orders</div>
                </div>
                <div class="stat-card">
                    <div class="stat-top">
                        <span class="stat-ico"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="4" y="4" width="16" height="16" rx="3"></rect><path d="M4 10h16M10 10v10"></path></svg></span>
                        <span class="stat-chip info" id="rep-products-chip">Live</span>
                    </div>
                    <p class="stat-label" title="Products In Catalog">Products In Catalog</p>
                    <h3 class="stat-value" id="rep-products">...</h3>
                    <div class="stat-foot" id="rep-products-foot">Items currently in the store</div>
                </div>
            </div>

            <div class="dash-grid">
                <div class="panel">
                    <h2>Sales, last 14 days</h2>
                    <p class="panel-sub">Daily revenue from non-cancelled orders.</p>
                    <div class="bars" id="rep-bars"></div>
                    <div class="bar-days" id="rep-bars-days"></div>
                </div>
                <div class="panel">
                    <h2>Best sellers</h2>
                    <p class="panel-sub">Units sold, top 5 products.</p>
                    <div id="rep-top"></div>
                </div>
            </div>
        </section>
    </main>

    <!-- Add / edit product modal -->
    <div class="modal-overlay" id="product-modal" role="dialog" aria-modal="true" aria-labelledby="product-modal-title">
        <div class="modal-card">
            <h2 id="product-modal-title">Add product</h2>
            <p class="modal-error" id="product-error" role="alert"></p>
            <form id="product-form" novalidate autocomplete="off">
                <div class="field">
                    <label for="p-name">Product name</label>
                    <input type="text" id="p-name" maxlength="255" required>
                </div>
                <div class="field">
                    <label for="p-description">Description</label>
                    <textarea id="p-description" rows="3" style="resize: none;"></textarea>
                </div>
                <div class="field-row">
                    <div class="field">
                        <label for="p-price">Price ($)</label>
                        <input type="number" id="p-price" min="0" step="0.01" required>
                    </div>
                    <div class="field">
                        <label for="p-stock">Stock</label>
                        <input type="number" id="p-stock" min="0" step="1" required>
                    </div>
                </div>
                <div class="field">
                    <label for="p-category">Category</label>
                    <div class="input-wrap">
                        <input type="text" id="p-category" maxlength="255" autocomplete="off" placeholder="Pick a category below or type a new one">
                        <button type="button" class="clear-x" data-clear="p-category" aria-label="Clear category">&#10005;</button>
                    </div>
                    <div class="chips" data-fill="p-category"></div>
                </div>

                <!-- Watch strap details: every field is free text, the chips are only shortcuts -->
                <div class="field-row">
                    <div class="field">
                        <label for="p-lug">Lug width (mm)</label>
                        <div class="input-wrap">
                            <input type="number" id="p-lug" min="6" max="40" step="1" autocomplete="off" placeholder="For example: 20">
                            <button type="button" class="clear-x" data-clear="p-lug" aria-label="Clear lug width">&#10005;</button>
                        </div>
                        <div class="chips" data-fill="p-lug" data-values="16,18,19,20,21,22,24" data-suffix=" mm"></div>
                    </div>
                    <div class="field">
                        <label for="p-length">Length</label>
                        <div class="input-wrap">
                            <input type="text" id="p-length" maxlength="20" autocomplete="off" placeholder="For example: Standard">
                            <button type="button" class="clear-x" data-clear="p-length" aria-label="Clear length">&#10005;</button>
                        </div>
                        <div class="chips" data-fill="p-length" data-values="Standard,Short,Long,Extra long"></div>
                    </div>
                </div>
                <div class="field-row">
                    <div class="field">
                        <label for="p-leather">Leather type</label>
                        <div class="input-wrap">
                            <input type="text" id="p-leather" maxlength="50" autocomplete="off" placeholder="For example: Full-grain calfskin">
                            <button type="button" class="clear-x" data-clear="p-leather" aria-label="Clear leather type">&#10005;</button>
                        </div>
                        <div class="chips" data-fill="p-leather" data-values="Full-grain calfskin,Calfskin,Suede,Saffiano,Crocodile-embossed,Vegan leather"></div>
                    </div>
                    <div class="field">
                        <label for="p-color">Colour</label>
                        <div class="input-wrap">
                            <input type="text" id="p-color" maxlength="50" autocomplete="off" placeholder="For example: Cognac brown">
                            <button type="button" class="clear-x" data-clear="p-color" aria-label="Clear colour">&#10005;</button>
                        </div>
                        <div class="chips" data-fill="p-color" data-values="Black,Brown,Tan,Cognac,Navy,Grey"></div>
                    </div>
                </div>
                <div class="field">
                    <label for="p-buckle">Buckle</label>
                    <div class="input-wrap">
                        <input type="text" id="p-buckle" maxlength="50" autocomplete="off" placeholder="For example: Brushed steel pin buckle">
                        <button type="button" class="clear-x" data-clear="p-buckle" aria-label="Clear buckle">&#10005;</button>
                    </div>
                </div>
                <label class="check-row" for="p-quick">
                    <input type="checkbox" id="p-quick">
                    Quick-release spring bars
                </label>

                <div class="field">
                    <label for="p-image">Product image (JPG, PNG or WEBP, max 2 MB)</label>
                    <input type="file" id="p-image" accept="image/jpeg,image/png,image/webp">
                    <img class="image-preview" id="p-image-preview" alt="Image preview">
                </div>
                <div class="modal-actions">
                    <button type="button" class="action-btn ghost" id="product-reset" title="Put every field back the way it was when this form opened">Undo changes</button>
                    <button type="button" class="action-btn" onclick="closeModal('product-modal')">Cancel</button>
                    <button type="submit" class="action-btn primary-btn" id="product-save" style="margin: 0;">Save product</button>
                </div>
            </form>
        </div>
    </div>

    <!-- User details / edit modal -->
    <div class="modal-overlay" id="user-modal" role="dialog" aria-modal="true" aria-labelledby="user-modal-title">
        <div class="modal-card">
            <h2 id="user-modal-title">User details</h2>
            <p class="modal-error" id="user-error" role="alert"></p>
            <form id="user-form" novalidate>
                <div class="field">
                    <label for="u-name">Full name</label>
                    <input type="text" id="u-name" maxlength="255" required>
                </div>
                <div class="field">
                    <label for="u-email">Email address</label>
                    <input type="email" id="u-email" maxlength="255" required>
                </div>
                <div class="info-lines" id="user-info"></div>
                <div class="modal-actions">
                    <button type="button" class="action-btn" onclick="closeModal('user-modal')">Close</button>
                    <button type="submit" class="action-btn primary-btn" id="user-save" style="margin: 0;">Save changes</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Add / rename category modal -->
    <div class="modal-overlay" id="category-modal" role="dialog" aria-modal="true" aria-labelledby="category-modal-title">
        <div class="modal-card">
            <h2 id="category-modal-title">Add category</h2>
            <p class="modal-error" id="category-error" role="alert"></p>
            <form id="category-form" novalidate>
                <div class="field">
                    <label for="c-name">Category name</label>
                    <input type="text" id="c-name" maxlength="255" required>
                </div>
                <div class="modal-actions">
                    <button type="button" class="action-btn" onclick="closeModal('category-modal')">Cancel</button>
                    <button type="submit" class="action-btn primary-btn" id="category-save" style="margin: 0;">Save category</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Add / edit admin modal -->
    <div class="modal-overlay" id="admin-modal" role="dialog" aria-modal="true" aria-labelledby="admin-modal-title">
        <div class="modal-card">
            <h2 id="admin-modal-title">Add admin account</h2>
            <p class="modal-error" id="admin-error" role="alert"></p>
            <form id="admin-form" novalidate>
                <div class="field">
                    <label for="a-name">Full name</label>
                    <input type="text" id="a-name" maxlength="255" required>
                </div>
                <div class="field">
                    <label for="a-email">Email address</label>
                    <input type="email" id="a-email" maxlength="255" required>
                </div>
                <div class="field">
                    <label for="a-role">Role (optional)</label>
                    <input type="text" id="a-role" maxlength="50" placeholder="For example: Manager">
                </div>
                <div class="field">
                    <label for="a-password" id="a-password-label">Password</label>
                    <input type="password" id="a-password" minlength="8" autocomplete="new-password">
                </div>
                <div class="modal-actions">
                    <button type="button" class="action-btn" onclick="closeModal('admin-modal')">Cancel</button>
                    <button type="submit" class="action-btn primary-btn" id="admin-save" style="margin: 0;">Save admin</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Update stock dialog -->
    <div class="modal-overlay" id="stock-modal" role="dialog" aria-modal="true" aria-labelledby="stock-modal-title">
        <div class="modal-card sm">
            <h2 id="stock-modal-title">Update stock</h2>
            <p class="modal-sub" id="stock-modal-sub"></p>
            <p class="modal-error" id="stock-error" role="alert"></p>
            <form id="stock-form" novalidate>
                <div class="field">
                    <label for="stock-input">New stock quantity</label>
                    <div class="stepper">
                        <button type="button" data-step="-1" aria-label="Decrease stock by one">&minus;</button>
                        <input type="number" id="stock-input" min="0" step="1" inputmode="numeric" autocomplete="off" required>
                        <button type="button" data-step="1" aria-label="Increase stock by one">+</button>
                    </div>
                    <p class="field-hint" id="stock-hint"></p>
                </div>
                <div class="modal-actions">
                    <button type="button" class="action-btn" onclick="closeModal('stock-modal')">Cancel</button>
                    <button type="submit" class="action-btn primary-btn" id="stock-save" style="margin: 0;">Save stock</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Delivery update dialog -->
    <div class="modal-overlay" id="notify-modal" role="dialog" aria-modal="true" aria-labelledby="notify-modal-title">
        <div class="modal-card sm">
            <h2 id="notify-modal-title">Send delivery update</h2>
            <p class="modal-sub" id="notify-modal-sub"></p>
            <p class="modal-error" id="notify-error" role="alert"></p>
            <form id="notify-form" novalidate>
                <div class="field">
                    <label for="notify-text">Message to the customer</label>
                    <textarea id="notify-text" rows="4" maxlength="255" placeholder="For example: Your order is out for delivery and should arrive today."></textarea>
                    <div class="field-meta"><span>The customer sees this in their Notifications tab.</span><span id="notify-count">0 / 255</span></div>
                </div>
                <div class="field">
                    <p class="chips-label">Quick replies</p>
                    <div class="chips" id="notify-templates">
                        <button type="button" class="chip" data-text="Your order is being prepared and will ship soon.">Being prepared</button>
                        <button type="button" class="chip" data-text="Your order is out for delivery and should arrive today. Please have the payment ready.">Out for delivery</button>
                        <button type="button" class="chip" data-text="Your order has been delivered. Thank you for shopping with STEFA!">Delivered</button>
                    </div>
                </div>
                <div class="modal-actions">
                    <button type="button" class="action-btn" onclick="closeModal('notify-modal')">Cancel</button>
                    <button type="submit" class="action-btn primary-btn" id="notify-save" style="margin: 0;">Send update</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Confirmation dialog (replaces the browser's confirm box) -->
    <div class="modal-overlay" id="confirm-modal" role="alertdialog" aria-modal="true" aria-labelledby="confirm-title">
        <div class="modal-card sm">
            <h2 id="confirm-title">Are you sure?</h2>
            <p class="modal-sub" id="confirm-message" style="margin-top: 0;"></p>
            <div class="modal-actions">
                <button type="button" class="action-btn" id="confirm-cancel">Cancel</button>
                <button type="button" class="action-btn primary-btn" id="confirm-ok" style="margin: 0;">Confirm</button>
            </div>
        </div>
    </div>

    <div class="toast-stack" id="toast-stack" aria-live="polite"></div>

    <script>
        // ---------- Guard: only a logged-in admin may use this page ----------
        function readJSON(key, fallback) {
            try { return JSON.parse(localStorage.getItem(key)) || fallback; } catch (e) { return fallback; }
        }
        const token = localStorage.getItem('auth_token');
        const adminUser = readJSON('auth_user', {});

        function clearSession() {
            localStorage.removeItem('auth_token');
            localStorage.removeItem('auth_user');
            localStorage.removeItem('user_authenticated');
        }
        function forceLogin() {
            clearSession();
            window.location.href = '/login';
        }
        if (!token || adminUser.role !== 'admin') {
            forceLogin();
        }

        document.getElementById('operator-label').textContent =
            'System Operator Workspace Session' + (adminUser.name ? ' - ' + adminUser.name : '');

        // ---------- Helpers ----------
        function esc(value) {
            return String(value == null ? '' : value)
                .replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;')
                .replace(/"/g, '&quot;').replace(/'/g, '&#39;');
        }
        function money(n) { return '$' + Number(n || 0).toFixed(2); }
        function formatDate(iso) {
            const d = new Date(iso);
            return isNaN(d.getTime()) ? '' : d.toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' });
        }
        function pad(n, size) { return String(n).padStart(size, '0'); }

        const FALLBACK_THUMB = 'data:image/svg+xml;utf8,' + encodeURIComponent(
            '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 68 68"><rect width="68" height="68" fill="#F6EAD0"/>' +
            '<path d="M20 44l9-11 7 8 6-7 11 13H20z" fill="#D9C193"/><circle cx="26" cy="24" r="5" fill="#D9C193"/></svg>'
        );

        // Toasts appear in the top right corner. type: 'success' (default) or 'error'
        function showToast(message, type) {
            const stack = document.getElementById('toast-stack');
            const isError = type === 'error';

            const toast = document.createElement('div');
            toast.className = 'toast ' + (isError ? 'error' : 'success');
            toast.setAttribute('role', isError ? 'alert' : 'status');

            const icon = document.createElement('span');
            icon.className = 'toast-icon';
            icon.textContent = isError ? '!' : '\u2713';

            const text = document.createElement('span');
            text.className = 'toast-text';
            text.textContent = message;

            const close = document.createElement('button');
            close.type = 'button';
            close.className = 'toast-close';
            close.setAttribute('aria-label', 'Dismiss');
            close.textContent = '\u2715';

            function dismiss() {
                toast.classList.add('leaving');
                setTimeout(() => toast.remove(), 250);
            }
            close.addEventListener('click', dismiss);

            toast.append(icon, text, close);
            stack.appendChild(toast);
            while (stack.children.length > 4) stack.firstElementChild.remove();
            setTimeout(dismiss, isError ? 6500 : 4200);
        }

        // One place for every API call: adds the token, handles 401/403 and error messages
        async function api(path, options) {
            options = options || {};
            const headers = Object.assign(
                { 'Authorization': 'Bearer ' + token, 'Accept': 'application/json' },
                options.headers || {}
            );
            const res = await fetch(path, Object.assign({}, options, { headers: headers }));

            if (res.status === 401 || res.status === 403) {
                forceLogin();
                throw new Error('AUTH');
            }

            const json = await res.json().catch(() => ({}));
            if (!res.ok) {
                const firstError = json.errors ? Object.values(json.errors)[0][0] : null;
                throw new Error(firstError || json.message || 'Request failed.');
            }
            return json;
        }

        const JSON_HEADERS = { 'Content-Type': 'application/json' };

        // ---------- Modals ----------
        // Some dialogs need to know when they were closed (for example the confirm dialog)
        const modalHooks = {};
        function openModal(id) { document.getElementById(id).classList.add('show'); }
        function closeModal(id) {
            document.getElementById(id).classList.remove('show');
            if (modalHooks[id]) modalHooks[id]();
        }
        function showModalError(id, text) {
            const box = document.getElementById(id);
            box.textContent = text;
            box.style.display = text ? 'block' : 'none';
        }

        document.querySelectorAll('.modal-overlay').forEach(overlay => {
            overlay.addEventListener('click', function (e) {
                if (e.target === overlay) closeModal(overlay.id);
            });
        });
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') document.querySelectorAll('.modal-overlay.show').forEach(o => closeModal(o.id));
        });

        // ---------- Confirmation dialog: await askConfirm({...}) gives true or false ----------
        let confirmResolver = null;
        function settleConfirm(value) {
            if (!confirmResolver) return;
            const resolve = confirmResolver;
            confirmResolver = null;
            resolve(value);
        }
        function askConfirm(options) {
            return new Promise(resolve => {
                settleConfirm(false);
                confirmResolver = resolve;
                document.getElementById('confirm-title').textContent = options.title || 'Are you sure?';
                document.getElementById('confirm-message').textContent = options.message || '';
                const ok = document.getElementById('confirm-ok');
                ok.textContent = options.confirmLabel || 'Confirm';
                ok.classList.toggle('danger-solid', !!options.danger);
                ok.classList.toggle('primary-btn', !options.danger);
                openModal('confirm-modal');
                ok.focus();
            });
        }
        modalHooks['confirm-modal'] = () => settleConfirm(false);
        document.getElementById('confirm-ok').addEventListener('click', function () {
            settleConfirm(true);
            closeModal('confirm-modal');
        });
        document.getElementById('confirm-cancel').addEventListener('click', () => closeModal('confirm-modal'));

        // ---------- Tabs ----------
        function switchAdminTab(name, link) {
            document.querySelectorAll('.workspace-view-panel').forEach(p => p.classList.remove('active'));
            document.getElementById('tab-' + name).classList.add('active');
            document.querySelectorAll('.menu-link').forEach(l => l.classList.remove('active'));
            if (link) link.classList.add('active');

            if (name === 'dashboard' || name === 'reports') loadStats();
            if (name === 'users') loadUsers();
            if (name === 'admins') loadAdmins();
            if (name === 'categories') loadCategories();
            if (name === 'products' || name === 'inventory') loadProducts();
            if (name === 'orders') loadOrders();
            if (name === 'reviews') loadReviews();
        }

        // ---------- KPI card helpers ----------
        const ARROW_UP = '<svg viewBox="0 0 12 12" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M6 10V2M2.5 5.5L6 2l3.5 3.5"></path></svg>';
        const ARROW_DOWN = '<svg viewBox="0 0 12 12" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M6 2v8M2.5 6.5L6 10l3.5-3.5"></path></svg>';

        // Fill the chip (top right) and footer (bottom) of a KPI card
        function setMeta(id, chipHtml, chipClass, footText) {
            const chip = document.getElementById(id + '-chip');
            if (chip && chipHtml != null) {
                chip.className = 'stat-chip' + (chipClass ? ' ' + chipClass : '');
                chip.innerHTML = chipHtml;
            }
            const foot = document.getElementById(id + '-foot');
            if (foot && footText != null) {
                foot.textContent = footText;
                foot.title = footText;
            }
        }

        // Compare a number with the same-sized period before it
        function trendChip(cur, prev) {
            if (!prev && !cur) return { html: '0%', cls: '' };
            if (!prev) return { html: ARROW_UP + 'New', cls: 'up' };
            const pct = Math.round((cur - prev) / prev * 100);
            if (pct === 0) return { html: '0%', cls: '' };
            return pct > 0
                ? { html: ARROW_UP + pct + '%', cls: 'up' }
                : { html: ARROW_DOWN + Math.abs(pct) + '%', cls: 'down' };
        }

        // Sales total and order count for n days, ending `offset` days before today
        function windowStats(orders, n, offset) {
            const end = new Date();
            end.setHours(0, 0, 0, 0);
            end.setDate(end.getDate() - offset + 1);
            const start = new Date(end);
            start.setDate(start.getDate() - n);
            let sales = 0;
            let count = 0;
            orders.forEach(o => {
                if (o.status === 'cancelled') return;
                const t = new Date(o.created_at);
                if (t >= start && t < end) { sales += Number(o.total) || 0; count++; }
            });
            return { sales: sales, count: count };
        }

        // ---------- Dashboard and sales report (GET /api/admin/stats) ----------
        async function loadStats() {
            try {
                const s = await api('/api/admin/stats');

                countUp('stat-sales', s.sales, money);
                countUp('stat-users', s.users);
                countUp('stat-orders', s.orders);
                countUp('stat-low', s.low_stock, v => Math.round(v) + (Math.round(v) === 1 ? ' Item' : ' Items'));
                if (s.low_stock > 0) setMeta('stat-low', 'Restock soon', 'warn');
                else setMeta('stat-low', 'All stocked', 'up');

                countUp('rep-sales', s.sales, money);
                countUp('rep-orders', s.orders);
                countUp('rep-avg', s.orders ? s.sales / s.orders : 0, money);
                countUp('rep-products', s.products);

                loadInsights();

                // The API accepted this account as an admin, so the page can be shown
                document.body.classList.remove('locked');
            } catch (err) {
                if (err.message !== 'AUTH') {
                    // A network or server error is not an access problem, so show the page and the message
                    document.body.classList.remove('locked');
                    showToast(err.message, 'error');
                }
            }
        }

        // ---------- Users (GET /api/admin/users, PUT and DELETE /api/admin/users/{id}) ----------
        let usersCache = [];
        let editingUserId = null;

        function renderUsers() {
            const body = document.getElementById('users-body');
            if (!usersCache.length) {
                body.innerHTML = '<tr><td colspan="6" class="table-note">No customers have registered yet.</td></tr>';
                return;
            }
            body.innerHTML = usersCache.map(u => (
                '<tr>' +
                    '<td class="money">#USR-' + pad(u.id, 4) + '</td>' +
                    '<td><strong>' + esc(u.name) + '</strong></td>' +
                    '<td>' + esc(u.email) + '</td>' +
                    '<td>' + Number(u.orders_count) + '</td>' +
                    '<td class="money">' + money(u.spent) + '</td>' +
                    '<td>' +
                        '<button class="action-btn" onclick="openUserModal(' + Number(u.id) + ')">Details / Edit</button>' +
                        '<button class="action-btn danger" onclick="deleteUser(' + Number(u.id) + ')">Delete</button>' +
                    '</td>' +
                '</tr>'
            )).join('');
        }

        async function loadUsers() {
            try {
                const json = await api('/api/admin/users');
                usersCache = json.data || [];
                renderUsers();
            } catch (err) {
                if (err.message !== 'AUTH') document.getElementById('users-body').innerHTML = '<tr><td colspan="6" class="table-note">Could not load users.</td></tr>';
            }
        }

        function openUserModal(id) {
            const u = usersCache.find(item => Number(item.id) === id);
            if (!u) return;
            editingUserId = id;
            showModalError('user-error', '');
            document.getElementById('user-modal-title').textContent = 'User #USR-' + pad(u.id, 4);
            document.getElementById('u-name').value = u.name || '';
            document.getElementById('u-email').value = u.email || '';
            document.getElementById('user-info').innerHTML =
                '<div><span>Phone</span><em>' + esc(u.phone || '-') + '</em></div>' +
                '<div><span>City / region</span><em>' + esc(u.city || '-') + '</em></div>' +
                '<div><span>Delivery address</span><em>' + esc(u.address || '-') + '</em></div>' +
                '<div><span>Orders placed</span><em>' + Number(u.orders_count) + '</em></div>' +
                '<div><span>Total spent</span><em>' + money(u.spent) + '</em></div>' +
                '<div><span>Joined</span><em>' + esc(formatDate(u.created_at)) + '</em></div>';
            openModal('user-modal');
        }

        document.getElementById('user-form').addEventListener('submit', async function (e) {
            e.preventDefault();
            showModalError('user-error', '');

            const saveBtn = document.getElementById('user-save');
            saveBtn.disabled = true;
            try {
                await api('/api/admin/users/' + editingUserId, {
                    method: 'PUT',
                    headers: JSON_HEADERS,
                    body: JSON.stringify({
                        name: document.getElementById('u-name').value.trim(),
                        email: document.getElementById('u-email').value.trim()
                    })
                });
                closeModal('user-modal');
                showToast('User updated');
                loadUsers();
            } catch (err) {
                if (err.message !== 'AUTH') showModalError('user-error', err.message);
            }
            saveBtn.disabled = false;
        });

        async function deleteUser(id) {
            const u = usersCache.find(item => Number(item.id) === id);
            if (!u) return;
            if (!(await askConfirm({ title: 'Delete this account?', message: 'The account of ' + u.name + ' will be removed. This cannot be undone.', confirmLabel: 'Delete account', danger: true }))) return;
            try {
                await api('/api/admin/users/' + id, { method: 'DELETE' });
                showToast('User deleted');
                loadUsers();
                loadStats();
            } catch (err) {
                if (err.message !== 'AUTH') showToast(err.message, 'error');
            }
        }

        // ---------- Admin accounts (GET/POST/PUT/DELETE /api/admins) ----------
        let adminsCache = [];
        let editingAdminId = null;

        function renderAdmins() {
            const body = document.getElementById('admins-body');
            if (!adminsCache.length) {
                body.innerHTML = '<tr><td colspan="6" class="table-note">No admin accounts found.</td></tr>';
                return;
            }
            body.innerHTML = adminsCache.map(a => {
                const isMe = Number(a.id) === Number(adminUser.id);
                return '<tr>' +
                    '<td class="money">#ADM-' + pad(a.id, 3) + '</td>' +
                    '<td><strong>' + esc(a.name) + '</strong>' + (isMe ? ' <span class="badge green">You</span>' : '') + '</td>' +
                    '<td>' + esc(a.email) + '</td>' +
                    '<td>' + esc(a.role || '-') + '</td>' +
                    '<td>' + esc(formatDate(a.created_at) || '-') + '</td>' +
                    '<td>' +
                        '<button class="action-btn" onclick="openAdminModal(' + Number(a.id) + ')">Edit</button>' +
                        (isMe ? '' : '<button class="action-btn danger" onclick="deleteAdmin(' + Number(a.id) + ')">Delete</button>') +
                    '</td>' +
                '</tr>';
            }).join('');
        }

        async function loadAdmins() {
            try {
                const json = await api('/api/admins');
                adminsCache = json.data || [];
                renderAdmins();
            } catch (err) {
                if (err.message !== 'AUTH') document.getElementById('admins-body').innerHTML = '<tr><td colspan="6" class="table-note">Could not load admin accounts.</td></tr>';
            }
        }

        function openAdminModal(id) {
            editingAdminId = id;
            showModalError('admin-error', '');
            document.getElementById('admin-form').reset();

            if (id === null) {
                document.getElementById('admin-modal-title').textContent = 'Add admin account';
                document.getElementById('a-password-label').textContent = 'Password (minimum 8 characters)';
            } else {
                const a = adminsCache.find(item => Number(item.id) === id);
                if (!a) return;
                document.getElementById('admin-modal-title').textContent = 'Edit admin #ADM-' + pad(a.id, 3);
                document.getElementById('a-name').value = a.name || '';
                document.getElementById('a-email').value = a.email || '';
                document.getElementById('a-role').value = a.role || '';
                document.getElementById('a-password-label').textContent = 'New password (leave empty to keep the current one)';
            }
            openModal('admin-modal');
            document.getElementById('a-name').focus();
        }

        document.getElementById('admin-form').addEventListener('submit', async function (e) {
            e.preventDefault();
            showModalError('admin-error', '');

            const name = document.getElementById('a-name').value.trim();
            const email = document.getElementById('a-email').value.trim();
            const role = document.getElementById('a-role').value.trim();
            const password = document.getElementById('a-password').value;
            const isNew = editingAdminId === null;

            if (!name || !email) {
                showModalError('admin-error', 'Name and email are required.');
                return;
            }
            if (isNew && password.length < 8) {
                showModalError('admin-error', 'The password needs at least 8 characters.');
                return;
            }

            const payload = { name: name, email: email };
            if (role) payload.role = role;
            if (password) payload.password = password;

            const saveBtn = document.getElementById('admin-save');
            saveBtn.disabled = true;
            try {
                await api(isNew ? '/api/admins' : '/api/admins/' + editingAdminId, {
                    method: isNew ? 'POST' : 'PUT',
                    headers: JSON_HEADERS,
                    body: JSON.stringify(payload)
                });
                closeModal('admin-modal');
                showToast(isNew ? 'Admin account created' : 'Admin account updated');
                loadAdmins();
            } catch (err) {
                if (err.message !== 'AUTH') showModalError('admin-error', err.message);
            }
            saveBtn.disabled = false;
        });

        async function deleteAdmin(id) {
            const a = adminsCache.find(item => Number(item.id) === id);
            if (!a) return;
            if (!(await askConfirm({ title: 'Delete this admin account?', message: a.name + ' will be removed and signed out everywhere.', confirmLabel: 'Delete admin', danger: true }))) return;
            try {
                await api('/api/admins/' + id, { method: 'DELETE' });
                showToast('Admin account deleted');
                loadAdmins();
            } catch (err) {
                if (err.message !== 'AUTH') showToast(err.message, 'error');
            }
        }

        // ---------- Categories (GET/POST/PUT/DELETE /api/categories) ----------
        let categoriesCache = [];
        let editingCategoryId = null;

        // The category shortcuts under the product form's Category field
        function fillCategoryOptions() {
            renderChips(document.querySelector('.chips[data-fill="p-category"]'), categoriesCache.map(c => c.name));
        }

        function renderCategories() {
            const body = document.getElementById('categories-body');
            if (!categoriesCache.length) {
                body.innerHTML = '<tr><td colspan="4" class="table-note">No categories yet. Click "Add Category Selection" to create one.</td></tr>';
                return;
            }
            body.innerHTML = categoriesCache.map(c => (
                '<tr>' +
                    '<td class="money">#CAT-' + pad(c.id, 3) + '</td>' +
                    '<td><strong>' + esc(c.name) + '</strong></td>' +
                    '<td>' + Number(c.products_count) + ' Items</td>' +
                    '<td>' +
                        '<button class="action-btn" onclick="openCategoryModal(' + Number(c.id) + ')">Edit Category</button>' +
                        '<button class="action-btn danger" onclick="deleteCategory(' + Number(c.id) + ')">Delete</button>' +
                    '</td>' +
                '</tr>'
            )).join('');
        }

        async function loadCategories() {
            try {
                const json = await api('/api/categories');
                categoriesCache = json.data || [];
                renderCategories();
                fillCategoryOptions();
            } catch (err) {
                if (err.message !== 'AUTH') document.getElementById('categories-body').innerHTML = '<tr><td colspan="4" class="table-note">Could not load categories.</td></tr>';
            }
        }

        function openCategoryModal(id) {
            editingCategoryId = id;
            showModalError('category-error', '');
            const nameInput = document.getElementById('c-name');
            if (id === null) {
                document.getElementById('category-modal-title').textContent = 'Add category';
                nameInput.value = '';
            } else {
                const c = categoriesCache.find(item => Number(item.id) === id);
                if (!c) return;
                document.getElementById('category-modal-title').textContent = 'Rename category';
                nameInput.value = c.name;
            }
            openModal('category-modal');
            nameInput.focus();
        }

        document.getElementById('category-form').addEventListener('submit', async function (e) {
            e.preventDefault();
            showModalError('category-error', '');

            const name = document.getElementById('c-name').value.trim();
            if (!name) {
                showModalError('category-error', 'Enter a category name.');
                return;
            }

            const saveBtn = document.getElementById('category-save');
            saveBtn.disabled = true;
            try {
                const isNew = editingCategoryId === null;
                await api(isNew ? '/api/categories' : '/api/categories/' + editingCategoryId, {
                    method: isNew ? 'POST' : 'PUT',
                    headers: JSON_HEADERS,
                    body: JSON.stringify({ name: name })
                });
                closeModal('category-modal');
                showToast(isNew ? 'Category added' : 'Category renamed');
                loadCategories();
            } catch (err) {
                if (err.message !== 'AUTH') showModalError('category-error', err.message);
            }
            saveBtn.disabled = false;
        });

        async function deleteCategory(id) {
            const c = categoriesCache.find(item => Number(item.id) === id);
            if (!c) return;
            if (!(await askConfirm({ title: 'Delete this category?', message: 'The category "' + c.name + '" will be removed.', confirmLabel: 'Delete category', danger: true }))) return;
            try {
                await api('/api/categories/' + id, { method: 'DELETE' });
                showToast('Category deleted');
                loadCategories();
            } catch (err) {
                if (err.message !== 'AUTH') showToast(err.message, 'error');
            }
        }

        // ---------- Products (GET/POST/PUT/DELETE /api/products) ----------
        let productsCache = [];

        async function fetchAllProducts() {
            let page = 1;
            let last = 1;
            let all = [];
            do {
                const json = await api('/api/products?page=' + page);
                all = all.concat(json.data || []);
                last = (json.meta && json.meta.last_page) || 1;
                page++;
            } while (page <= last);
            return all;
        }

        // One short line of strap details for the products table
        function strapSummary(p) {
            const parts = [];
            if (p.lug_width) parts.push('<strong>' + Number(p.lug_width) + ' mm</strong>');
            if (p.leather_type) parts.push(esc(p.leather_type));
            if (p.color) parts.push(esc(p.color));
            if (p.buckle) parts.push(esc(p.buckle));
            if (p.length) parts.push(esc(p.length) + ' length');
            if (p.quick_release) parts.push('Quick-release');
            return parts.length ? parts.join('<br>') : '-';
        }

        function stockBadge(stock) {
            if (stock <= 0) return '<span class="badge red">Out of stock</span>';
            if (stock <= 5) return '<span class="badge orange">Low stock</span>';
            return '<span class="badge green">In stock</span>';
        }

        function renderProducts() {
            const body = document.getElementById('products-body');
            if (!productsCache.length) {
                body.innerHTML = '<tr><td colspan="7" class="table-note">No products yet. Click "Add Product to Store" to create one.</td></tr>';
                return;
            }
            body.innerHTML = productsCache.map(p => (
                '<tr>' +
                    '<td><img class="thumb" src="' + esc(p.image_url || FALLBACK_THUMB) + '" alt="" onerror="this.onerror=null; this.src=FALLBACK_THUMB;"></td>' +
                    '<td><strong>' + esc(p.name) + '</strong></td>' +
                    '<td>' + esc(p.category || '-') + '</td>' +
                    '<td class="strap-cell">' + strapSummary(p) + '</td>' +
                    '<td class="money">' + money(p.price) + '</td>' +
                    '<td>' + esc(p.stock) + '</td>' +
                    '<td>' +
                        '<button class="action-btn" onclick="openProductModal(' + Number(p.id) + ')">Edit</button>' +
                        '<button class="action-btn danger" onclick="deleteProduct(' + Number(p.id) + ')">Delete</button>' +
                    '</td>' +
                '</tr>'
            )).join('');
        }

        function renderInventory() {
            const body = document.getElementById('inventory-body');
            if (!productsCache.length) {
                body.innerHTML = '<tr><td colspan="5" class="table-note">No products yet.</td></tr>';
                return;
            }
            body.innerHTML = productsCache.map(p => (
                '<tr>' +
                    '<td><strong>' + esc(p.name) + '</strong></td>' +
                    '<td>' + esc(p.category || '-') + '</td>' +
                    '<td class="money">' + esc(p.stock) + '</td>' +
                    '<td>' + stockBadge(Number(p.stock)) + '</td>' +
                    '<td><button class="action-btn" onclick="openStockModal(' + Number(p.id) + ')">Update stock</button></td>' +
                '</tr>'
            )).join('');
        }

        async function loadProducts() {
            try {
                productsCache = await fetchAllProducts();
                renderProducts();
                renderInventory();
            } catch (err) {
                if (err.message !== 'AUTH') {
                    document.getElementById('products-body').innerHTML = '<tr><td colspan="7" class="table-note">Could not load products.</td></tr>';
                    document.getElementById('inventory-body').innerHTML = '<tr><td colspan="5" class="table-note">Could not load inventory.</td></tr>';
                }
            }
        }

        // ---------- Update stock dialog (PUT /api/products/{id}) ----------
        let stockEditId = null;
        const stockInput = document.getElementById('stock-input');

        function stockLabel(n) {
            if (n <= 0) return 'Out of stock';
            if (n <= 5) return 'Low stock';
            return 'In stock';
        }

        function updateStockHint() {
            const product = productsCache.find(p => Number(p.id) === stockEditId);
            const current = product ? Number(product.stock) : 0;
            const raw = stockInput.value.trim();
            document.getElementById('stock-hint').textContent = /^\d+$/.test(raw)
                ? 'Currently ' + current + ' in stock. After saving: ' + stockLabel(Number(raw)) + '.'
                : 'Currently ' + current + ' in stock.';
        }

        function openStockModal(id) {
            const product = productsCache.find(p => Number(p.id) === id);
            if (!product) return;
            stockEditId = id;
            showModalError('stock-error', '');
            document.getElementById('stock-modal-sub').textContent = product.name;
            stockInput.value = product.stock;
            updateStockHint();
            openModal('stock-modal');
            stockInput.focus();
            stockInput.select();
        }

        stockInput.addEventListener('input', updateStockHint);
        document.querySelectorAll('#stock-modal [data-step]').forEach(btn => {
            btn.addEventListener('click', function () {
                const raw = stockInput.value.trim();
                const current = /^\d+$/.test(raw) ? Number(raw) : 0;
                stockInput.value = Math.max(0, current + Number(btn.dataset.step));
                updateStockHint();
                stockInput.focus();
            });
        });

        document.getElementById('stock-form').addEventListener('submit', async function (e) {
            e.preventDefault();
            showModalError('stock-error', '');

            const raw = stockInput.value.trim();
            if (!/^\d+$/.test(raw)) {
                showModalError('stock-error', 'Enter a whole number, 0 or higher.');
                stockInput.focus();
                return;
            }

            const stock = parseInt(raw, 10);
            const product = productsCache.find(p => Number(p.id) === stockEditId);
            const saveBtn = document.getElementById('stock-save');
            saveBtn.disabled = true;
            try {
                await api('/api/products/' + stockEditId, {
                    method: 'PUT',
                    headers: JSON_HEADERS,
                    body: JSON.stringify({ stock: stock })
                });
                closeModal('stock-modal');
                showToast('Stock for "' + (product ? product.name : 'product') + '" is now ' + stock + ' (' + stockLabel(stock) + ').');
                loadProducts();
                loadStats();
            } catch (err) {
                if (err.message !== 'AUTH') showModalError('stock-error', err.message);
            }
            saveBtn.disabled = false;
        });

        async function deleteProduct(id) {
            const product = productsCache.find(p => Number(p.id) === id);
            if (!product) return;
            if (!(await askConfirm({ title: 'Delete this product?', message: '"' + product.name + '" will be removed from the store. This cannot be undone.', confirmLabel: 'Delete product', danger: true }))) return;
            try {
                await api('/api/products/' + id, { method: 'DELETE' });
                showToast('Product deleted');
                loadProducts();
                loadStats();
            } catch (err) {
                if (err.message !== 'AUTH') showToast(err.message, 'error');
            }
        }

        // ---------- Add / edit product modal ----------
        let editingId = null;
        const productForm = document.getElementById('product-form');
        const imageInput = document.getElementById('p-image');
        const imagePreview = document.getElementById('p-image-preview');

        // ---------- Free-text fields with clear buttons and preset chips ----------
        // The chips are only shortcuts: the admin can always type anything else.
        function syncField(input) {
            const wrap = input.closest('.input-wrap');
            if (wrap) wrap.classList.toggle('has-value', input.value !== '');
            const chips = document.querySelector('.chips[data-fill="' + input.id + '"]');
            if (chips) {
                const typed = input.value.trim().toLowerCase();
                chips.querySelectorAll('.chip').forEach(chip => {
                    chip.setAttribute('aria-pressed', String(typed !== '' && chip.dataset.value.toLowerCase() === typed));
                });
            }
        }

        function setField(id, value) {
            const input = document.getElementById(id);
            input.value = value == null ? '' : value;
            syncField(input);
        }

        function renderChips(container, values) {
            if (!container) return;
            container.innerHTML = '';
            values.forEach(value => {
                const chip = document.createElement('button');
                chip.type = 'button';
                chip.className = 'chip';
                chip.dataset.value = value;
                chip.textContent = value + (container.dataset.suffix || '');
                chip.setAttribute('aria-pressed', 'false');
                container.appendChild(chip);
            });
            const input = document.getElementById(container.dataset.fill);
            if (input) syncField(input);
        }

        document.querySelectorAll('.chips[data-fill][data-values]').forEach(container => {
            renderChips(container, container.dataset.values.split(','));
        });

        document.getElementById('product-form').addEventListener('click', function (e) {
            const clear = e.target.closest('.clear-x');
            if (clear) {
                setField(clear.dataset.clear, '');
                document.getElementById(clear.dataset.clear).focus();
                return;
            }
            const chip = e.target.closest('.chips[data-fill] .chip');
            if (chip) {
                const id = chip.closest('.chips').dataset.fill;
                // Clicking a chip fills the field; clicking the chosen chip again empties it
                setField(id, chip.getAttribute('aria-pressed') === 'true' ? '' : chip.dataset.value);
            }
        });
        document.getElementById('product-form').addEventListener('input', function (e) {
            if (e.target.matches('input')) syncField(e.target);
        });

        // What the form held when it opened: the saved product, or empty for a new one.
        // The Reset button puts every field back to this.
        const PRODUCT_FIELDS = ['p-name', 'p-description', 'p-price', 'p-stock', 'p-category', 'p-lug', 'p-length', 'p-leather', 'p-color', 'p-buckle'];
        let productSnapshot = {};
        let snapshotImage = '';

        function applyProductSnapshot() {
            PRODUCT_FIELDS.forEach(id => setField(id, productSnapshot[id]));
            document.getElementById('p-quick').checked = !!productSnapshot.quick;
            imageInput.value = '';
            if (snapshotImage) {
                imagePreview.src = snapshotImage;
                imagePreview.style.display = 'block';
            } else {
                imagePreview.removeAttribute('src');
                imagePreview.style.display = 'none';
            }
        }

        function openProductModal(id) {
            editingId = id;
            productForm.reset();
            showModalError('product-error', '');

            // The category shortcuts come from the categories table
            loadCategories();

            const snap = { quick: false };
            PRODUCT_FIELDS.forEach(f => { snap[f] = ''; });
            snapshotImage = '';

            if (id === null) {
                document.getElementById('product-modal-title').textContent = 'Add product';
            } else {
                const p = productsCache.find(item => Number(item.id) === id);
                if (!p) return;
                document.getElementById('product-modal-title').textContent = 'Edit product';
                snap['p-name'] = p.name || '';
                snap['p-description'] = p.description || '';
                snap['p-price'] = p.price == null ? '' : String(p.price);
                snap['p-stock'] = p.stock == null ? '' : String(p.stock);
                snap['p-category'] = p.category || '';
                snap['p-lug'] = p.lug_width || '';
                snap['p-length'] = p.length || '';
                snap['p-leather'] = p.leather_type || '';
                snap['p-color'] = p.color || '';
                snap['p-buckle'] = p.buckle || '';
                snap.quick = !!p.quick_release;
                snapshotImage = p.image_url || '';
            }

            productSnapshot = snap;
            document.getElementById('product-reset').textContent = id === null ? 'Clear form' : 'Undo changes';
            applyProductSnapshot();
            openModal('product-modal');
            document.getElementById('p-name').focus();
        }

        document.getElementById('product-reset').addEventListener('click', function () {
            applyProductSnapshot();
            showModalError('product-error', '');
            document.getElementById('p-name').focus();
        });

        imageInput.addEventListener('change', function () {
            const file = imageInput.files[0];
            if (!file) return;
            imagePreview.src = URL.createObjectURL(file);
            imagePreview.style.display = 'block';
        });

        productForm.addEventListener('submit', async function (e) {
            e.preventDefault();
            showModalError('product-error', '');

            const name = document.getElementById('p-name').value.trim();
            const price = document.getElementById('p-price').value;
            const stock = document.getElementById('p-stock').value;
            if (!name || price === '' || stock === '') {
                showModalError('product-error', 'Name, price and stock are required.');
                return;
            }

            const fd = new FormData();
            fd.append('name', name);
            fd.append('description', document.getElementById('p-description').value.trim());
            fd.append('price', price);
            fd.append('stock', stock);
            fd.append('category', document.getElementById('p-category').value.trim());
            fd.append('lug_width', document.getElementById('p-lug').value);
            fd.append('length', document.getElementById('p-length').value);
            fd.append('leather_type', document.getElementById('p-leather').value.trim());
            fd.append('color', document.getElementById('p-color').value.trim());
            fd.append('buckle', document.getElementById('p-buckle').value.trim());
            fd.append('quick_release', document.getElementById('p-quick').checked ? '1' : '0');
            if (imageInput.files[0]) fd.append('image', imageInput.files[0]);

            let url = '/api/products';
            if (editingId !== null) {
                // The route is PUT, but files only travel in a POST body, so the method is spoofed
                url += '/' + editingId;
                fd.append('_method', 'PUT');
            }

            const saveBtn = document.getElementById('product-save');
            saveBtn.disabled = true;
            saveBtn.textContent = 'Saving...';

            try {
                await api(url, { method: 'POST', body: fd });
                closeModal('product-modal');
                showToast(editingId === null ? 'Product added' : 'Product updated');
                loadProducts();
                loadStats();
            } catch (err) {
                if (err.message !== 'AUTH') showModalError('product-error', err.message);
            }

            saveBtn.disabled = false;
            saveBtn.textContent = 'Save product';
        });

        // ---------- Orders (GET /api/admin/orders, PUT and DELETE /api/admin/orders/{id}) ----------
        let ordersCache = [];
        const ORDER_STATUSES = ['pending', 'processing', 'completed', 'cancelled'];
        // Orders only move forward; delivered and cancelled orders are final
        const NEXT_STATUS = {
            pending: ['processing', 'completed', 'cancelled'],
            processing: ['completed', 'cancelled'],
            completed: [],
            cancelled: []
        };

        // Where the order must be delivered. Orders placed before shipping details were saved show a dash.
        function shippingCellHtml(s) {
            if (!s || (!s.name && !s.address)) {
                return '<span class="order-items-cell">-</span>';
            }
            const place = [s.address, s.city, s.zip].filter(Boolean).map(esc).join(', ');
            return '<strong>' + esc(s.name || '-') + '</strong>' +
                (s.phone ? '<br>' + esc(s.phone) : '') +
                (place ? '<br>' + place : '') +
                (s.payment_method ? '<br><span class="badge ship-pay">' + esc(s.payment_method) + '</span>' : '');
        }

        function orderRowHtml(o) {
            const items = (o.items || []).map(it => esc(it.name || 'Item') + ' (' + Number(it.quantity || 1) + 'x)').join('<br>');
            const customer = o.customer
                ? '<strong>' + esc(o.customer.name) + '</strong><br><span class="order-items-cell">' + esc(o.customer.email) + '</span>'
                : '<span class="order-items-cell">Unknown</span>';
            const allowed = NEXT_STATUS[o.status] || [];
            const locked = allowed.length === 0;
            const options = ORDER_STATUSES.map(s => {
                const enabled = s === o.status || allowed.includes(s);
                return '<option value="' + s + '"' + (s === o.status ? ' selected' : '') + (enabled ? '' : ' disabled') + '>' +
                    s.charAt(0).toUpperCase() + s.slice(1) + '</option>';
            }).join('');

            return '<tr>' +
                '<td class="money">#STF-' + pad(o.id, 5) + '</td>' +
                '<td>' + customer + '</td>' +
                '<td class="ship-cell">' + shippingCellHtml(o.shipping) + '</td>' +
                '<td class="order-items-cell">' + (items || '-') + '</td>' +
                '<td class="money">' + money(o.total) + '</td>' +
                '<td>' + esc(formatDate(o.created_at)) + '</td>' +
                '<td><select class="status-select"' + (locked ? ' disabled title="This order is final and cannot be changed"' : '') + ' onchange="changeOrderStatus(' + Number(o.id) + ', this)">' + options + '</select></td>' +
                '<td class="order-actions">' +
                    '<button class="action-btn" onclick="openNotifyModal(' + Number(o.id) + ')">Send update</button>' +
                    (o.status === 'cancelled'
                        ? '<button class="action-btn danger" onclick="deleteOrder(' + Number(o.id) + ')">Delete</button>'
                        : '') +
                '</td>' +
            '</tr>';
        }

        async function loadOrders() {
            const body = document.getElementById('orders-body');
            try {
                const json = await api('/api/admin/orders');
                const orders = json.data || [];
                ordersCache = orders;
                body.innerHTML = orders.length
                    ? orders.map(orderRowHtml).join('')
                    : '<tr><td colspan="8" class="table-note">No orders yet.</td></tr>';
            } catch (err) {
                if (err.message !== 'AUTH') body.innerHTML = '<tr><td colspan="8" class="table-note">Could not load orders.</td></tr>';
            }
        }

        async function changeOrderStatus(id, select) {
            select.disabled = true;
            try {
                await api('/api/admin/orders/' + id, {
                    method: 'PUT',
                    headers: JSON_HEADERS,
                    body: JSON.stringify({ status: select.value })
                });
                showToast('Order #STF-' + pad(id, 5) + ' set to ' + select.value + '. The customer was notified.');
                loadStats();
                loadOrders(); // refresh so the Delete button appears on cancelled orders
            } catch (err) {
                if (err.message !== 'AUTH') {
                    showToast(err.message, 'error');
                    loadOrders();
                }
            }
            select.disabled = false;
        }

        // ---------- Delivery update dialog (POST /api/admin/orders/{id}/notify) ----------
        let notifyOrderId = null;
        const notifyText = document.getElementById('notify-text');

        function updateNotifyCount() {
            document.getElementById('notify-count').textContent = notifyText.value.length + ' / 255';
        }

        function openNotifyModal(id) {
            const order = ordersCache.find(o => Number(o.id) === id);
            notifyOrderId = id;
            showModalError('notify-error', '');
            document.getElementById('notify-modal-sub').textContent =
                'Order #STF-' + pad(id, 5) + (order && order.customer ? ' \u00B7 ' + order.customer.name : '');
            notifyText.value = '';
            updateNotifyCount();
            openModal('notify-modal');
            notifyText.focus();
        }

        notifyText.addEventListener('input', updateNotifyCount);
        document.querySelectorAll('#notify-templates .chip').forEach(chip => {
            chip.addEventListener('click', function () {
                notifyText.value = chip.dataset.text;
                updateNotifyCount();
                notifyText.focus();
            });
        });

        document.getElementById('notify-form').addEventListener('submit', async function (e) {
            e.preventDefault();
            showModalError('notify-error', '');

            const message = notifyText.value.trim();
            if (!message) {
                showModalError('notify-error', 'Write a message for the customer first.');
                notifyText.focus();
                return;
            }

            const order = ordersCache.find(o => Number(o.id) === notifyOrderId);
            const saveBtn = document.getElementById('notify-save');
            saveBtn.disabled = true;
            try {
                await api('/api/admin/orders/' + notifyOrderId + '/notify', {
                    method: 'POST',
                    headers: JSON_HEADERS,
                    body: JSON.stringify({ message: message })
                });
                closeModal('notify-modal');
                showToast('Delivery update sent' + (order && order.customer ? ' to ' + order.customer.name : '') + '.');
            } catch (err) {
                if (err.message !== 'AUTH') showModalError('notify-error', err.message);
            }
            saveBtn.disabled = false;
        });

        // Delete a cancelled order (DELETE /api/admin/orders/{id})
        async function deleteOrder(id) {
            if (!(await askConfirm({ title: 'Delete this order?', message: 'Order #STF-' + pad(id, 5) + ' will be deleted permanently. This cannot be undone.', confirmLabel: 'Delete order', danger: true }))) return;
            try {
                await api('/api/admin/orders/' + id, { method: 'DELETE' });
                showToast('Order deleted');
                loadOrders();
                loadStats();
            } catch (err) {
                if (err.message !== 'AUTH') showToast(err.message, 'error');
            }
        }

        // ---------- Reviews (GET /api/admin/reviews, DELETE /api/admin/reviews/{id}) ----------
        let reviewsCache = [];

        function starText(rating) {
            const n = Math.max(0, Math.min(5, Number(rating) || 0));
            return '\u2605'.repeat(n) + '\u2606'.repeat(5 - n);
        }

        function renderReviews() {
            const body = document.getElementById('reviews-body');
            if (!reviewsCache.length) {
                body.innerHTML = '<tr><td colspan="6" class="table-note">No reviews yet. Customers can review products after an order is marked completed.</td></tr>';
                return;
            }
            body.innerHTML = reviewsCache.map(r => (
                '<tr>' +
                    '<td><strong>' + esc(r.product ? r.product.name : 'Deleted product') + '</strong></td>' +
                    '<td>' + esc(r.customer ? r.customer.name : 'Unknown') + '</td>' +
                    '<td><span class="stars">' + starText(r.rating) + '</span></td>' +
                    '<td class="comment-cell">' + esc(r.comment) + '</td>' +
                    '<td>' + esc(formatDate(r.created_at)) + '</td>' +
                    '<td><button class="action-btn danger" onclick="deleteReview(' + Number(r.id) + ')">Delete</button></td>' +
                '</tr>'
            )).join('');
        }

        async function loadReviews() {
            try {
                const json = await api('/api/admin/reviews');
                reviewsCache = json.data || [];
                renderReviews();
            } catch (err) {
                if (err.message !== 'AUTH') document.getElementById('reviews-body').innerHTML = '<tr><td colspan="6" class="table-note">Could not load reviews.</td></tr>';
            }
        }

        async function deleteReview(id) {
            if (!(await askConfirm({ title: 'Delete this review?', message: 'The review will be removed from the product. This cannot be undone.', confirmLabel: 'Delete review', danger: true }))) return;
            try {
                await api('/api/admin/reviews/' + id, { method: 'DELETE' });
                showToast('Review deleted');
                loadReviews();
            } catch (err) {
                if (err.message !== 'AUTH') showToast(err.message, 'error');
            }
        }

        // ---------- Exit: revoke the token on the server, clear the session ----------
        document.getElementById('exit-link').addEventListener('click', function () {
            fetch('/api/logout', {
                method: 'POST',
                headers: { 'Authorization': 'Bearer ' + token, 'Accept': 'application/json' },
                keepalive: true
            });
            clearSession();
            ['stefashop_cart', 'stefashop_checkout_items', 'stefashop_profile', 'stefashop_orders']
                .forEach(key => localStorage.removeItem(key));
        });

        // ---------- Dashboard visuals ----------
        (function () {
            const h = new Date().getHours();
            const hello = h < 12 ? 'Good morning' : h < 18 ? 'Good afternoon' : 'Good evening';
            document.getElementById('hello').textContent = hello + (adminUser.name ? ', ' + adminUser.name : '');
            document.getElementById('hero-date').textContent =
                new Date().toLocaleDateString('en-US', { weekday: 'long', month: 'long', day: 'numeric', year: 'numeric' });
        })();

        // Numbers count up from zero when the dashboard loads
        function countUp(id, to, fmt) {
            const el = document.getElementById(id);
            const end = Number(to) || 0;
            const show = v => { el.textContent = fmt ? fmt(v) : Math.round(v); };
            if (matchMedia('(prefers-reduced-motion: reduce)').matches) { show(end); return; }
            const start = performance.now();
            (function tick(now) {
                const p = Math.min(1, (now - start) / 700);
                show(end * (1 - Math.pow(1 - p, 3)));
                if (p < 1) requestAnimationFrame(tick);
            })(start);
        }

        // Daily sales totals for the last n days (cancelled orders are skipped)
        function lastDays(orders, n) {
            const days = [];
            for (let i = n - 1; i >= 0; i--) {
                const d = new Date();
                d.setHours(0, 0, 0, 0);
                d.setDate(d.getDate() - i);
                days.push({ date: d, key: d.toDateString(), value: 0 });
            }
            orders.forEach(o => {
                if (o.status === 'cancelled') return;
                const day = days.find(x => x.key === new Date(o.created_at).toDateString());
                if (day) day.value += Number(o.total) || 0;
            });
            return days;
        }

        function drawBars(id, days) {
            const el = document.getElementById(id);
            const max = Math.max(...days.map(d => d.value), 1);
            el.innerHTML = days.map((d, i) =>
                '<div class="bar-col" title="' + esc(d.date.toLocaleDateString('en-US', { month: 'short', day: 'numeric' }) + ': ' + money(d.value)) + '">' +
                    '<span class="bar-val">' + (d.value && days.length <= 8 ? '$' + Math.round(d.value) : '') + '</span>' +
                    '<div class="bar-track"><div class="bar' + (i === days.length - 1 ? ' today' : '') + '" data-h="' + Math.max(3, Math.round(d.value / max * 100)) + '"></div></div>' +
                '</div>'
            ).join('');
            document.getElementById(id + '-days').innerHTML = days.map((d, i) =>
                '<span>' + (days.length > 8
                    ? (i % 2 ? '' : d.date.getDate())
                    : d.date.toLocaleDateString('en-US', { weekday: 'short' })) + '</span>'
            ).join('');
            requestAnimationFrame(() => requestAnimationFrame(() =>
                el.querySelectorAll('.bar').forEach(b => { b.style.height = b.dataset.h + '%'; })));
        }

        function drawStatus(orders) {
            const counts = { pending: 0, processing: 0, completed: 0, cancelled: 0 };
            orders.forEach(o => { if (counts[o.status] !== undefined) counts[o.status]++; });
            const total = orders.length || 1;
            const el = document.getElementById('dash-status');
            el.innerHTML = Object.keys(counts).map(k =>
                '<div class="st-row"><div class="st-head"><span>' + k.charAt(0).toUpperCase() + k.slice(1) + '</span><strong>' + counts[k] + '</strong></div>' +
                '<div class="st-track"><div class="st-fill ' + k + '" data-w="' + Math.round(counts[k] / total * 100) + '"></div></div></div>'
            ).join('');
            requestAnimationFrame(() => requestAnimationFrame(() =>
                el.querySelectorAll('.st-fill').forEach(f => { f.style.width = f.dataset.w + '%'; })));
        }

        function drawRecent(orders) {
            const BADGE = { pending: 'orange', processing: 'blue', completed: 'green', cancelled: 'red' };
            const latest = orders.slice()
                .sort((a, b) => new Date(b.created_at) - new Date(a.created_at) || b.id - a.id)
                .slice(0, 5);
            document.getElementById('dash-recent').innerHTML = latest.length
                ? latest.map(o =>
                    '<tr><td class="money">#STF-' + pad(o.id, 5) + '</td>' +
                    '<td><strong>' + esc(o.customer ? o.customer.name : 'Unknown') + '</strong></td>' +
                    '<td class="money">' + money(o.total) + '</td>' +
                    '<td><span class="badge ' + (BADGE[o.status] || '') + '">' + esc(o.status) + '</span></td>' +
                    '<td>' + esc(formatDate(o.created_at)) + '</td></tr>').join('')
                : '<tr><td colspan="5" class="table-note">No orders yet.</td></tr>';
        }

        function drawTop(orders) {
            const sold = {};
            orders.forEach(o => {
                if (o.status === 'cancelled') return;
                (o.items || []).forEach(it => {
                    const key = it.name || 'Item';
                    sold[key] = (sold[key] || 0) + Number(it.quantity || 1);
                });
            });
            const top = Object.entries(sold).sort((a, b) => b[1] - a[1]).slice(0, 5);
            const max = top.length ? top[0][1] : 1;
            const el = document.getElementById('rep-top');
            el.innerHTML = top.length
                ? top.map(t =>
                    '<div class="st-row"><div class="st-head"><span>' + esc(t[0]) + '</span><strong>' + t[1] + '</strong></div>' +
                    '<div class="st-track"><div class="st-fill processing" data-w="' + Math.round(t[1] / max * 100) + '"></div></div></div>').join('')
                : '<p class="panel-sub" style="margin-top: 16px;">No sales yet.</p>';
            requestAnimationFrame(() => requestAnimationFrame(() =>
                el.querySelectorAll('.st-fill').forEach(f => { f.style.width = f.dataset.w + '%'; })));
        }

        // Trend chips and footers on the KPI cards, built from the orders list
        function drawKpiMeta(orders) {
            // Dashboard: last 7 days against the 7 days before
            const w7 = windowStats(orders, 7, 0);
            const p7 = windowStats(orders, 7, 7);
            const salesTrend = trendChip(w7.sales, p7.sales);
            setMeta('stat-sales', salesTrend.html, salesTrend.cls, 'Last 7 days: ' + money(w7.sales));
            const ordersTrend = trendChip(w7.count, p7.count);
            const pending = orders.filter(o => o.status === 'pending').length;
            const processing = orders.filter(o => o.status === 'processing').length;
            setMeta('stat-orders', ordersTrend.html, ordersTrend.cls, pending + ' pending \u00B7 ' + processing + ' processing');

            // Sales report: last 14 days against the 14 days before
            const w14 = windowStats(orders, 14, 0);
            const p14 = windowStats(orders, 14, 14);
            const repSales = trendChip(w14.sales, p14.sales);
            setMeta('rep-sales', repSales.html, repSales.cls, 'Last 14 days: ' + money(w14.sales));
            const repOrders = trendChip(w14.count, p14.count);
            setMeta('rep-orders', repOrders.html, repOrders.cls, 'Last 14 days: ' + w14.count + (w14.count === 1 ? ' order' : ' orders'));
            const avgNow = w14.count ? w14.sales / w14.count : 0;
            const avgPrev = p14.count ? p14.sales / p14.count : 0;
            const repAvg = trendChip(avgNow, avgPrev);
            setMeta('rep-avg', repAvg.html, repAvg.cls, 'Last 14 days: ' + money(avgNow));
        }

        // Charts and lists are built from the orders list; the stat cards still work without it
        async function loadInsights() {
            try {
                const json = await api('/api/admin/orders');
                const orders = json.data || [];
                drawBars('dash-bars', lastDays(orders, 7));
                drawBars('rep-bars', lastDays(orders, 14));
                drawStatus(orders);
                drawRecent(orders);
                drawTop(orders);
                drawKpiMeta(orders);
            } catch (err) { /* ignore: AUTH is handled in api(), other errors only affect the charts */ }
        }

        // ---------- First load ----------
        loadStats();
    </script>

    <!-- Show / hide password eye toggle -->
    <script src="/js/password-toggle.js"></script>

</body>
</html>