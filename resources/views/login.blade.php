<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stefa - Sign In</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:wght@600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="/js/cart-store.js"></script>
    <style>
        :root {
            /* Palette: Brown, Pale Gold, Glowing Gold, plus a dark leather tone for the card */
            --brown: #603E1E;
            --pale: #F1D9A8;
            --gold: #FFC34D;
            --gold-deep: #F0AC1F;
            --leather: #24160A;
            --text-soft: #D9C193;     /* labels and secondary text on the dark card */
            --placeholder: #B39C76;
            --glass: rgba(36, 22, 10, 0.62);
            --glass-edge: rgba(241, 217, 168, 0.26);
            --field: rgba(255, 248, 232, 0.07);
            --field-edge: rgba(241, 217, 168, 0.28);
            --radius-card: 26px;
            --radius-field: 12px;
            --ease: cubic-bezier(0.22, 1, 0.36, 1);
        }

        * { box-sizing: border-box; }

        body {
            background-color: var(--leather);
            background-image: url('/images/login-bg.png');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
            font-family: 'Plus Jakarta Sans', system-ui, sans-serif;
            color: var(--pale);
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            padding: 24px;
            -webkit-font-smoothing: antialiased;
        }

        /* ---------- Dark glass card ---------- */
        .gateway-container {
            width: 100%;
            max-width: 432px;
            padding: 48px 44px 40px;
            border-radius: var(--radius-card);
            background: var(--glass);
            -webkit-backdrop-filter: blur(18px) saturate(1.2);
            backdrop-filter: blur(18px) saturate(1.2);
            border: 1px solid var(--glass-edge);
            box-shadow:
                0 1px 0 rgba(255, 224, 160, 0.18) inset,
                0 34px 70px -24px rgba(0, 0, 0, 0.6),
                0 10px 28px -12px rgba(0, 0, 0, 0.4);
            display: flex;
            flex-direction: column;
            align-items: center;
            animation: cardIn 0.7s var(--ease) both;
        }
        @keyframes cardIn {
            from { opacity: 0; transform: translateY(14px) scale(0.985); }
            to   { opacity: 1; transform: none; }
        }

        .brand {
            font-family: 'Fraunces', Georgia, serif;
            font-size: 38px;
            font-weight: 700;
            letter-spacing: 0.12em;
            text-align: center;
            line-height: 1;
            color: var(--pale);
        }
        .brand-accent { color: var(--gold); }

        .tagline {
            color: var(--text-soft);
            font-size: 14px;
            font-weight: 500;
            text-align: center;
            margin: 12px 0 34px;
        }

        /* ---------- Tab switcher with sliding highlight ---------- */
        .toggle-tabs {
            position: relative;
            display: grid;
            grid-template-columns: 1fr 1fr;
            width: 100%;
            padding: 5px;
            margin-bottom: 30px;
            border-radius: 14px;
            background: rgba(241, 217, 168, 0.10);
            border: 1px solid rgba(241, 217, 168, 0.14);
        }
        .tab-indicator {
            position: absolute;
            top: 5px;
            bottom: 5px;
            left: 5px;
            width: calc(50% - 5px);
            border-radius: 10px;
            background: var(--gold);
            box-shadow: 0 4px 14px rgba(255, 195, 77, 0.28);
            transition: transform 0.45s var(--ease);
        }
        .toggle-tabs[data-tab="register"] .tab-indicator { transform: translateX(100%); }

        .tab-btn {
            position: relative;
            z-index: 1;
            background: none;
            border: none;
            padding: 11px 0;
            font-family: inherit;
            font-size: 14px;
            font-weight: 600;
            color: var(--text-soft);
            cursor: pointer;
            border-radius: 10px;
            transition: color 0.25s ease;
        }
        .tab-btn.active { color: var(--leather); }
        .tab-btn:hover:not(.active) { color: #fff; }

        /* ---------- Forms ---------- */
        .auth-form { display: none; flex-direction: column; width: 100%; }
        .auth-form.active { display: flex; animation: formIn 0.45s var(--ease) both; }
        @keyframes formIn {
            from { opacity: 0; transform: translateY(8px); }
            to   { opacity: 1; transform: none; }
        }

        .form-group { display: flex; flex-direction: column; gap: 8px; margin-bottom: 20px; }

        label { font-size: 13px; font-weight: 600; color: var(--text-soft); }
        input {
            width: 100%;
            padding: 14px 16px;
            border-radius: var(--radius-field);
            border: 1px solid var(--field-edge);
            background: var(--field);
            font-family: inherit;
            font-size: 14px;
            font-weight: 500;
            color: #FFF8E8;
            outline: none;
            transition: border-color 0.2s ease, box-shadow 0.25s ease, background 0.2s ease;
        }
        input::placeholder { color: var(--placeholder); font-weight: 400; }
        input:hover { border-color: rgba(241, 217, 168, 0.5); }
        input:focus {
            border-color: var(--gold);
            background: rgba(255, 248, 232, 0.11);
            box-shadow: 0 0 0 4px rgba(255, 195, 77, 0.20);
        }
        /* Keep browser autofill from turning the fields white */
        input:-webkit-autofill {
            -webkit-text-fill-color: #FFF8E8;
            -webkit-box-shadow: 0 0 0 100px #3A2511 inset;
            caret-color: #FFF8E8;
        }

        .password-row { display: flex; justify-content: space-between; align-items: center; }
        .accent-link {
            font-size: 13px;
            font-weight: 600;
            color: var(--gold);
            text-decoration: none;
            border-radius: 4px;
            transition: color 0.2s ease;
        }
        .accent-link:hover { color: #fff; text-decoration: underline; text-underline-offset: 3px; }

        .form-message {
            display: none;
            background: rgba(255, 140, 110, 0.12);
            color: #FFB9A8;
            border: 1px solid rgba(255, 140, 110, 0.35);
            border-radius: var(--radius-field);
            padding: 11px 14px;
            font-size: 13px;
            font-weight: 500;
            margin: 0 0 6px;
        }

        /* ---------- Primary button: gold with hover glow and click ripple ---------- */
        .submit-btn {
            position: relative;
            overflow: hidden;
            width: 100%;
            margin-top: 8px;
            padding: 15px;
            border: none;
            border-radius: var(--radius-field);
            background: var(--gold);
            color: var(--leather);
            font-family: inherit;
            font-size: 15px;
            font-weight: 700;
            cursor: pointer;
            box-shadow: 0 12px 26px -12px rgba(255, 195, 77, 0.55);
            transition: transform 0.25s var(--ease), box-shadow 0.3s ease, background 0.2s ease;
        }
        .submit-btn:hover {
            background: #FFCE6B;
            transform: translateY(-2px);
            box-shadow: 0 18px 34px -12px rgba(255, 195, 77, 0.7);
        }
        .submit-btn:active { transform: translateY(0) scale(0.985); }
        .submit-btn:disabled { opacity: 0.6; cursor: not-allowed; transform: none; }
        .submit-btn span.btn-label { position: relative; z-index: 1; }

        .ripple {
            position: absolute;
            border-radius: 50%;
            background: rgba(96, 62, 30, 0.35);
            transform: scale(0);
            animation: ripple 0.65s ease-out forwards;
            pointer-events: none;
        }
        @keyframes ripple { to { transform: scale(1); opacity: 0; } }

        .guest-row {
            margin-top: 26px;
            text-align: center;
            font-size: 13px;
            color: var(--text-soft);
        }

        /* Keyboard focus */
        .tab-btn:focus-visible,
        .submit-btn:focus-visible,
        .accent-link:focus-visible {
            outline: 3px solid var(--gold);
            outline-offset: 3px;
        }

        /* ---------- Popup (loading, then success) ---------- */
        .popup-overlay {
            position: fixed;
            inset: 0;
            background: rgba(20, 12, 4, 0.66);
            -webkit-backdrop-filter: blur(6px);
            backdrop-filter: blur(6px);
            display: none;
            align-items: center;
            justify-content: center;
            padding: 20px;
            z-index: 1000;
        }
        .popup-overlay.show { display: flex; }
        .popup-card {
            width: 100%;
            max-width: 340px;
            padding: 38px 32px 32px;
            text-align: center;
            border-radius: 24px;
            background: none;
            border: none;
            box-shadow: none;
            animation: popIn 0.4s var(--ease);
        }
        .popup-card h3 { margin: 0 0 8px; font-family: 'Fraunces', Georgia, serif; font-size: 22px; font-weight: 600; color: var(--pale); }
        .popup-card p { margin: 0; color: var(--text-soft); font-size: 14px; line-height: 1.5; }
        .popup-card .swap { animation: textSwap 0.6s var(--ease) both; }
        @keyframes popIn {
            from { opacity: 0; transform: scale(0.92); }
            to   { opacity: 1; transform: scale(1); }
        }
        @keyframes textSwap {
            from { opacity: 0; transform: translateY(5px); }
            to   { opacity: 1; transform: none; }
        }

        /* ---------- Clock loader: dark sunburst-brushed dial, etched markers, gold orbital ring ---------- */
        .clock {
            position: relative;
            width: 96px;
            height: 96px;
            margin: 0 auto 24px;
            border-radius: 50%;
            background:
                repeating-conic-gradient(from 0deg, rgba(255, 235, 190, 0.05) 0deg 0.7deg, rgba(0, 0, 0, 0.07) 0.7deg 1.4deg),
                radial-gradient(circle at 34% 26%, #4B3520 0%, #2A1A0C 52%, #170D05 100%);
            box-shadow:
                inset 0 8px 14px rgba(0, 0, 0, 0.5),
                0 12px 26px -10px rgba(0, 0, 0, 0.75),
                0 0 40px rgba(255, 195, 77, 0.10);
        }
        /* Soft glass glare across the crystal */
        .clock::after {
            content: "";
            position: absolute;
            inset: 0;
            border-radius: 50%;
            background: linear-gradient(135deg, rgba(255, 244, 220, 0.12) 0%, rgba(255, 244, 220, 0) 42%);
            pointer-events: none;
        }
        .clock svg { position: absolute; inset: 0; width: 100%; height: 100%; overflow: visible; }

        .clock .hand { transform-box: view-box; transform-origin: 50px 50px; }

        /* Orbital ring: a faint track plus a gold arc that travels around it */
        .clock .ring-group { opacity: 0; transition: opacity 0.6s ease; }
        .clock.loading .ring-group { opacity: 1; }
        .clock.fading .ring-group { opacity: 0; transition-duration: 0.7s; }
        .clock .ring-arc { transform-box: view-box; transform-origin: 50px 50px; animation: orbit 3.6s linear infinite; }
        @keyframes orbit { to { transform: rotate(360deg); } }

        /* Gold pulse the moment the hands lock */
        .clock.locked { animation: lockGlow 1s var(--ease) both; }
        @keyframes lockGlow {
            0%   { box-shadow: inset 0 8px 14px rgba(0, 0, 0, 0.5), 0 12px 26px -10px rgba(0, 0, 0, 0.75), 0 0 40px rgba(255, 195, 77, 0.10); }
            35%  { box-shadow: inset 0 8px 14px rgba(0, 0, 0, 0.5), 0 12px 26px -10px rgba(0, 0, 0, 0.75), 0 0 44px rgba(255, 195, 77, 0.45); }
            100% { box-shadow: inset 0 8px 14px rgba(0, 0, 0, 0.5), 0 12px 26px -10px rgba(0, 0, 0, 0.75), 0 0 40px rgba(255, 195, 77, 0.14); }
        }


        /* ---------- STEFA wordmark: gold outline, then each letter springs up and fills with light ---------- */
        .logo-word {
            display: flex;
            justify-content: center;
            gap: 0.14em;
            margin: 2px 0 26px;
            font-family: 'Fraunces', Georgia, serif;
            font-size: 42px;
            font-weight: 700;
            line-height: 1;
        }
        .logo-letter {
            display: inline-block;
            color: transparent;
            -webkit-text-stroke: 1px rgba(255, 195, 77, 0.40);
            --fill: #FFC34D;
            transition: color 0.4s ease, -webkit-text-stroke-color 0.4s ease;
        }
        .logo-letter:first-child { --fill: #F1D9A8; }
        .logo-letter.lit {
            color: var(--fill);
            -webkit-text-stroke-color: transparent;
            text-shadow: 0 0 14px rgba(255, 195, 77, 0.38);
            animation: letterPop 0.6s cubic-bezier(0.34, 1.56, 0.64, 1) both, letterGlow 1.1s ease-out both;
        }
        @keyframes letterPop {
            from { transform: translateY(16px) scale(0.82); }
            to   { transform: none; }
        }
        @keyframes letterGlow {
            0%   { text-shadow: 0 0 0 rgba(255, 195, 77, 0); }
            30%  { text-shadow: 0 0 26px rgba(255, 195, 77, 0.95), 0 0 6px rgba(255, 240, 200, 0.8); }
            100% { text-shadow: 0 0 14px rgba(255, 195, 77, 0.38); }
        }
        .logo-word.complete { animation: wordGlow 1.1s var(--ease) both; }
        @keyframes wordGlow {
            0%   { filter: drop-shadow(0 0 0 rgba(255, 195, 77, 0)); }
            35%  { filter: drop-shadow(0 0 16px rgba(255, 195, 77, 0.6)); }
            100% { filter: drop-shadow(0 0 4px rgba(255, 195, 77, 0.2)); }
        }

        /* The clock materializes below the wordmark once every letter is lit */
        .clock {
            width: 84px;
            height: 84px;
            margin: 0 auto 26px;
            opacity: 0;
            transform: translateY(8px) scale(0.92);
            transition: opacity 0.6s ease, transform 0.6s var(--ease);
        }
        .clock.shown { opacity: 1; transform: none; }

        @media (max-width: 600px) {
            body { background-attachment: scroll; padding: 16px; }
            .gateway-container { padding: 40px 26px 32px; }
        }

        @media (prefers-reduced-motion: reduce) {
            *, *::before, *::after { animation-duration: 0.01ms !important; transition-duration: 0.01ms !important; }
            .clock .ring-arc { animation: none; }
        }
    </style>
</head>
<body>

    <div class="gateway-container">

        <div class="brand">S<span class="brand-accent">TEFA</span></div>
        <p class="tagline">Leather watch straps, made to be worn.</p>

        <!-- Tabs with sliding highlight -->
        <div class="toggle-tabs" id="toggle-tabs" data-tab="login" role="tablist">
            <span class="tab-indicator" aria-hidden="true"></span>
            <button type="button" class="tab-btn active" role="tab" aria-selected="true" onclick="switchForm('login-form', this)">Log In</button>
            <button type="button" class="tab-btn" role="tab" aria-selected="false" onclick="switchForm('register-form', this)">Sign Up</button>
        </div>

        <!-- Login Form -->
        <form id="login-form" class="auth-form active">
            <div class="form-group">
                <label for="login-email">Email address</label>
                <input type="email" id="login-email" placeholder="stefan@example.com" autocomplete="email" required>
            </div>
            <div class="form-group">
                <div class="password-row">
                    <label for="login-password">Password</label>
                    <a href="/forgot-password" class="accent-link">Forgot password?</a>
                </div>
                <input type="password" id="login-password" placeholder="••••••••" autocomplete="current-password" required>
            </div>
            <p class="form-message" id="login-message" role="alert"></p>
            <button type="submit" class="submit-btn" id="login-submit"><span class="btn-label">Log In</span></button>
        </form>

        <!-- Registration Form -->
        <form id="register-form" class="auth-form">
            <div class="form-group">
                <label for="register-name">Full name</label>
                <input type="text" id="register-name" placeholder="Stefan Dev" autocomplete="name" required>
            </div>
            <div class="form-group">
                <label for="register-email">Email address</label>
                <input type="email" id="register-email" placeholder="stefan@example.com" autocomplete="email" required>
            </div>
            <div class="form-group">
                <label for="register-password">Choose password</label>
                <input type="password" id="register-password" placeholder="Minimum 8 characters" minlength="8" autocomplete="new-password" required>
            </div>
            <div class="form-group">
                <label for="register-confirm">Confirm password</label>
                <input type="password" id="register-confirm" placeholder="Re-enter your password" minlength="8" autocomplete="new-password" required>
            </div>
            <p class="form-message" id="register-message" role="alert"></p>
            <button type="submit" class="submit-btn" id="register-submit"><span class="btn-label">Create Account</span></button>
        </form>

        <div class="guest-row">
            Just looking? <a href="/shop" class="accent-link">Browse as guest</a>
        </div>

    </div>

    <!-- Loading / success popup with the clock loader -->
    <div class="popup-overlay" id="success-popup" role="status" aria-live="polite">
        <div class="popup-card">
            <div class="logo-word" id="logo-word" aria-hidden="true">
                <span class="logo-letter">S</span><span class="logo-letter">T</span><span class="logo-letter">E</span><span class="logo-letter">F</span><span class="logo-letter">A</span>
            </div>
            <div class="clock" id="popup-clock" aria-hidden="true">
                <svg viewBox="0 0 100 100">
                    <!-- Orbital ring (visible while loading) -->
                    <g class="ring-group">
                        <circle cx="50" cy="50" r="54" fill="none" stroke="rgba(255,195,77,0.14)" stroke-width="1"></circle>
                        <circle class="ring-arc" cx="50" cy="50" r="54" fill="none" stroke="#FFC34D" stroke-width="1.6" stroke-linecap="round" stroke-dasharray="82 257"></circle>
                    </g>

                    <!-- Etched hour markers -->
                    <g stroke="#F1D9A8" stroke-linecap="round">
                        <g stroke-width="1.8" opacity="0.62">
                            <line x1="50" y1="7" x2="50" y2="14"></line>
                            <line x1="93" y1="50" x2="86" y2="50"></line>
                            <line x1="50" y1="93" x2="50" y2="86"></line>
                            <line x1="7" y1="50" x2="14" y2="50"></line>
                        </g>
                        <g stroke-width="1" opacity="0.38">
                            <line x1="71.5" y1="12.8" x2="68" y2="18.9"></line>
                            <line x1="87.2" y1="28.5" x2="81.1" y2="32"></line>
                            <line x1="87.2" y1="71.5" x2="81.1" y2="68"></line>
                            <line x1="71.5" y1="87.2" x2="68" y2="81.1"></line>
                            <line x1="28.5" y1="87.2" x2="32" y2="81.1"></line>
                            <line x1="12.8" y1="71.5" x2="18.9" y2="68"></line>
                            <line x1="12.8" y1="28.5" x2="18.9" y2="32"></line>
                            <line x1="28.5" y1="12.8" x2="32" y2="18.9"></line>
                        </g>
                    </g>

                    <!-- Hands: hour (pale gold, short) and minute (gold, long) with small counterweights -->
                    <g class="hand" id="clock-hour">
                        <line x1="50" y1="55" x2="50" y2="31" stroke="#F1D9A8" stroke-width="3.2" stroke-linecap="round"></line>
                    </g>
                    <g class="hand" id="clock-minute">
                        <line x1="50" y1="58" x2="50" y2="19" stroke="#FFC34D" stroke-width="2" stroke-linecap="round"></line>
                    </g>
                    <circle cx="50" cy="50" r="3.6" fill="#FFC34D"></circle>
                    <circle cx="50" cy="50" r="1.3" fill="#2A1A0C"></circle>
                </svg>
            </div>
            <h3 id="popup-title">Signing you in</h3>
            <p id="popup-text">One moment...</p>
        </div>
    </div>

    <!-- Authentication Script -->
    <script>
        const HOLD_AFTER_LOCK = 900;    // how long the locked clock and message stay before redirecting
        const SPIN_MIN = 500;           // the clock always spins at least this long before it locks

        // ---------- Clock loader ----------
        // Loading: both hands turn together (minute : hour = 12 : 1), slow and steady.
        // Success: they decelerate, the minute hand clicks in crisp steps, and both lock at 10:10.
        const clock = (function () {
            const root = document.getElementById('popup-clock');
            const hourEl = document.getElementById('clock-hour');
            const minEl = document.getElementById('clock-minute');
            const MIN_PERIOD = 6000;
            const HOUR_PERIOD = MIN_PERIOD * 12;
            const HOUR_TARGET = 305;     // 10:10 -> hour hand sits a sixth of the way past the 10
            const MIN_TARGET = 60;       // 10:10 -> minute hand on the 2
            const SETTLE_MS = 1400;
            const reduced = window.matchMedia('(prefers-reduced-motion: reduce)');
            let loops = [];
            let timers = [];
            let startedAt = 0;

            function rot(deg) { return 'rotate(' + deg + 'deg)'; }
            function setAngles(h, m) { hourEl.style.transform = rot(h); minEl.style.transform = rot(m); }
            function clearTimers() { timers.forEach(clearTimeout); timers = []; }
            function cancelAll() { loops.forEach(a => a.cancel()); loops = []; clearTimers(); }
            function turn(period) { return ((performance.now() - startedAt) / period * 360) % 360; }

            function start() {
                cancelAll();
                root.classList.remove('fading', 'locked');
                root.classList.add('loading');
                setAngles(0, 0);
                startedAt = performance.now();
                if (reduced.matches) return;
                loops = [
                    hourEl.animate([{ transform: rot(0) }, { transform: rot(360) }], { duration: HOUR_PERIOD, iterations: Infinity }),
                    minEl.animate([{ transform: rot(0) }, { transform: rot(360) }], { duration: MIN_PERIOD, iterations: Infinity })
                ];
            }

            function stop() {
                cancelAll();
                root.classList.remove('loading', 'fading', 'locked');
                setAngles(0, 0);
            }

            // Forward distance from the current angle to the target, plus a full extra turn when it is already close
            function forward(from, target, minimum) {
                let delta = (((target - from) % 360) + 360) % 360;
                if (delta < minimum) delta += 360;
                return from + delta;
            }

            function succeed() {
                return new Promise(function (resolve) {
                    const dur = reduced.matches ? 1 : SETTLE_MS;
                    const fromH = turn(HOUR_PERIOD);
                    const fromM = turn(MIN_PERIOD);
                    cancelAll();
                    setAngles(fromH, fromM);

                    const endH = forward(fromH, HOUR_TARGET, 40);
                    const endM = forward(fromM, MIN_TARGET, 120);

                    // Hour hand: long smooth deceleration, a tiny overshoot, then it settles back
                    const hourAnim = hourEl.animate([
                        { transform: rot(fromH), offset: 0, easing: 'cubic-bezier(0.25, 0.6, 0.3, 1)' },
                        { transform: rot(endH + 1.6), offset: 0.9, easing: 'ease-out' },
                        { transform: rot(endH), offset: 1 }
                    ], { duration: dur, fill: 'forwards' });

                    // Minute hand: smooth deceleration, six crisp clicks across the last 30 degrees, then a small recoil
                    const minAnim = minEl.animate([
                        { transform: rot(fromM), offset: 0, easing: 'cubic-bezier(0.25, 0.6, 0.3, 1)' },
                        { transform: rot(endM - 30), offset: 0.6, easing: 'steps(6, jump-end)' },
                        { transform: rot(endM + 2.2), offset: 0.92, easing: 'ease-out' },
                        { transform: rot(endM), offset: 1 }
                    ], { duration: dur, fill: 'forwards' });

                    // The golden ring fades out as the last click lands
                    timers.push(setTimeout(function () { root.classList.add('fading'); }, dur * 0.6));

                    minAnim.onfinish = function () {
                        setAngles(endH % 360, endM % 360);   // freeze exactly at 10:10
                        hourAnim.cancel();
                        minAnim.cancel();
                        root.classList.remove('loading');
                        root.classList.add('locked');
                        resolve();
                    };
                });
            }

            return { start: start, stop: stop, succeed: succeed, elapsed: function () { return performance.now() - startedAt; } };
        })();

        // ---------- Popup helpers ----------
        function setPopupText(title, text) {
            [['popup-title', title], ['popup-text', text]].forEach(function (pair) {
                const el = document.getElementById(pair[0]);
                el.textContent = pair[1];
                el.classList.remove('swap');
                void el.offsetWidth;   // restart the fade
                el.classList.add('swap');
            });
        }

        // Stage 1: the letters S T E F A light up one by one.
        // Stage 2: the clock fades in below and starts turning.
        const LETTER_START = 200;   // pause before the first letter
        const LETTER_STEP = 140;    // time between letters
        const CLOCK_DELAY = 400;    // pause after the last letter, before the clock appears
        let introTimers = [];

        function clearIntro() { introTimers.forEach(clearTimeout); introTimers = []; }

        function resetIntro() {
            clearIntro();
            document.querySelectorAll('.logo-letter').forEach(l => l.classList.remove('lit'));
            document.getElementById('logo-word').classList.remove('complete');
            document.getElementById('popup-clock').classList.remove('shown');
        }

        // Returns a promise that resolves when the clock has appeared and started turning
        function runIntro() {
            resetIntro();
            const reduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
            const step = reduced ? 0 : LETTER_STEP;
            const first = reduced ? 0 : LETTER_START;
            const letters = document.querySelectorAll('.logo-letter');

            return new Promise(function (resolve) {
                letters.forEach(function (letter, i) {
                    introTimers.push(setTimeout(() => letter.classList.add('lit'), first + i * step));
                });
                const clockAt = first + (letters.length - 1) * step + (reduced ? 0 : CLOCK_DELAY);
                introTimers.push(setTimeout(function () {
                    document.getElementById('popup-clock').classList.add('shown');
                    clock.start();
                    resolve();
                }, clockAt));
            });
        }

        function showPopup(title, text) {
            setPopupText(title, text);
            document.getElementById('success-popup').classList.add('show');
            return runIntro();
        }

        function hidePopup() {
            document.getElementById('success-popup').classList.remove('show');
            resetIntro();
            clock.stop();
        }

        function wait(ms) { return new Promise(resolve => setTimeout(resolve, ms)); }

        // ---------- Forms ----------
        function switchForm(formId, button) {
            document.querySelectorAll('.auth-form').forEach(form => form.classList.remove('active'));
            document.querySelectorAll('.tab-btn').forEach(tab => {
                tab.classList.remove('active');
                tab.setAttribute('aria-selected', 'false');
            });
            document.getElementById(formId).classList.add('active');
            button.classList.add('active');
            button.setAttribute('aria-selected', 'true');
            document.getElementById('toggle-tabs').dataset.tab = formId === 'register-form' ? 'register' : 'login';
            clearMessages();
        }

        function clearMessages() {
            document.querySelectorAll('.form-message').forEach(message => {
                message.textContent = '';
                message.style.display = 'none';
            });
        }

        function showMessage(id, text) {
            const message = document.getElementById(id);
            message.textContent = text;
            message.style.display = 'block';
        }

        function saveSession(data) {
            localStorage.setItem('auth_token', data.token);
            localStorage.setItem('auth_user', JSON.stringify(data.user));
            localStorage.setItem('user_authenticated', 'true');
        }

        function clearSession() {
            localStorage.removeItem('auth_token');
            localStorage.removeItem('auth_user');
            localStorage.removeItem('user_authenticated');
        }

        // Click ripple on the primary buttons
        document.querySelectorAll('.submit-btn').forEach(btn => {
            btn.addEventListener('pointerdown', function (e) {
                if (btn.disabled) return;
                const rect = btn.getBoundingClientRect();
                const size = Math.max(rect.width, rect.height) * 2;
                const dot = document.createElement('span');
                dot.className = 'ripple';
                dot.style.width = dot.style.height = size + 'px';
                dot.style.left = (e.clientX - rect.left - size / 2) + 'px';
                dot.style.top = (e.clientY - rect.top - size / 2) + 'px';
                btn.appendChild(dot);
                dot.addEventListener('animationend', () => dot.remove());
            });
        });

        async function submitAuth(url, payload, messageId, button, busyText, successTitle, successText, loadingTitle, loadingText) {
            const label = button.querySelector('.btn-label');
            const originalText = label.textContent;
            button.disabled = true;
            label.textContent = busyText;
            clearMessages();

            // The wordmark starts lighting up as soon as the request goes out
            const intro = showPopup(loadingTitle, loadingText);

            try {
                const response = await fetch(url, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify(payload)
                });

                const data = await response.json().catch(() => ({}));

                if (response.ok) {
                    saveSession(data);

                    // Bring the items a guest added into this customer's own cart
                    if (data.user && data.user.role !== 'admin') {
                        StefaCart.mergeGuestInto(StefaCart.ownerOf(data.user));
                    }

                    // Admins go to the control terminal, customers go to the shop
                    const isAdmin = data.user && data.user.role === 'admin';
                    const destination = isAdmin ? '/admin' : '/shop';

                    // Wait for the wordmark and clock to finish their entrance, and let the hands spin a little
                    await intro;
                    await wait(Math.max(0, SPIN_MIN - clock.elapsed()));

                    // The hands snap into 10:10, and the success message appears the moment they lock
                    await clock.succeed();
                    document.getElementById('logo-word').classList.add('complete');
                    setPopupText(
                        successTitle,
                        isAdmin ? 'Welcome back! Redirecting you to the admin dashboard...' : successText
                    );
                    await wait(HOLD_AFTER_LOCK);

                    window.location.href = destination;
                    return;
                }

                clearSession();
                hidePopup();

                if (response.status === 422 && data.errors) {
                    showMessage(messageId, Object.values(data.errors)[0][0]);
                } else {
                    showMessage(messageId, data.message || 'Something went wrong. Please try again.');
                }
            } catch (error) {
                hidePopup();
                showMessage(messageId, 'Could not reach the server. Please try again.');
            }

            button.disabled = false;
            label.textContent = originalText;
        }

        document.getElementById('login-form').addEventListener('submit', function (event) {
            event.preventDefault();

            submitAuth(
                '/api/login',
                {
                    email: document.getElementById('login-email').value,
                    password: document.getElementById('login-password').value
                },
                'login-message',
                document.getElementById('login-submit'),
                'Logging in...',
                'Login successful!',
                'Welcome back! Redirecting you to the shop...',
                'Signing you in',
                'Checking your details...'
            );
        });

        document.getElementById('register-form').addEventListener('submit', function (event) {
            event.preventDefault();

            const password = document.getElementById('register-password').value;
            const confirmation = document.getElementById('register-confirm').value;

            if (password !== confirmation) {
                showMessage('register-message', 'Passwords do not match.');
                return;
            }

            submitAuth(
                '/api/register',
                {
                    name: document.getElementById('register-name').value,
                    email: document.getElementById('register-email').value,
                    password: password,
                    password_confirmation: confirmation
                },
                'register-message',
                document.getElementById('register-submit'),
                'Creating account...',
                'Account created!',
                'Welcome to STEFA! Redirecting you to the shop...',
                'Creating your account',
                'Setting things up...'
            );
        });
    </script>

    <!-- Show / hide password eye toggle -->
    <script src="/js/password-toggle.js"></script>

</body>
</html>