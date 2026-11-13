<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stefa - Sign In</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --cream: #FBF9F5;
            --obsidian: #111111;
            --muted: #5F5A53;
            --terracotta: #E07A5F;
            --terracotta-text: #B5513A; /* darker terracotta so small text stays readable */
            --glass: rgba(251, 249, 245, 0.74);
            --glass-edge: rgba(255, 255, 255, 0.65);
            --field: rgba(255, 255, 255, 0.72);
            --field-edge: rgba(17, 17, 17, 0.10);
            --radius-card: 28px;
            --radius-field: 12px;
            --ease: cubic-bezier(0.22, 1, 0.36, 1);
        }

        * { box-sizing: border-box; }

        body {
            background-color: #A9795A;
            background-image: url('/images/BckStefa.png');
            background-size: cover;
            background-position: center top;
            background-repeat: no-repeat;
            background-attachment: fixed;
            font-family: 'Plus Jakarta Sans', system-ui, sans-serif;
            color: var(--obsidian);
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            padding: 24px;
            -webkit-font-smoothing: antialiased;
        }

        /* ---------- Glass card ---------- */
        .gateway-container {
            width: 100%;
            max-width: 432px;
            padding: 48px 44px 40px;
            border-radius: var(--radius-card);
            background: var(--glass);
            -webkit-backdrop-filter: blur(22px) saturate(1.25);
            backdrop-filter: blur(22px) saturate(1.25);
            border: 1px solid var(--glass-edge);
            box-shadow:
                0 1px 0 rgba(255, 255, 255, 0.7) inset,
                0 30px 60px -24px rgba(60, 30, 10, 0.35),
                0 8px 24px -12px rgba(60, 30, 10, 0.18);
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
            font-size: 30px;
            font-weight: 700;
            letter-spacing: 0.14em;
            text-align: center;
            line-height: 1;
        }
        .brand-accent { color: var(--terracotta); }

        .tagline {
            color: var(--muted);
            font-size: 14px;
            font-weight: 500;
            letter-spacing: 0.01em;
            text-align: center;
            margin: 12px 0 36px;
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
            background: rgba(17, 17, 17, 0.06);
        }
        .tab-indicator {
            position: absolute;
            top: 5px;
            bottom: 5px;
            left: 5px;
            width: calc(50% - 5px);
            border-radius: 10px;
            background: #FFFFFF;
            box-shadow: 0 2px 8px rgba(17, 17, 17, 0.10);
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
            letter-spacing: 0.01em;
            color: var(--muted);
            cursor: pointer;
            border-radius: 10px;
            transition: color 0.25s ease;
        }
        .tab-btn.active { color: var(--obsidian); }
        .tab-btn:hover:not(.active) { color: var(--obsidian); }

        /* ---------- Forms ---------- */
        .auth-form { display: none; flex-direction: column; width: 100%; }
        .auth-form.active { display: flex; animation: formIn 0.45s var(--ease) both; }
        @keyframes formIn {
            from { opacity: 0; transform: translateY(8px); }
            to   { opacity: 1; transform: none; }
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 8px;
            margin-bottom: 20px;
            transition: transform 0.3s var(--ease);
        }
        .form-group:focus-within { transform: scale(1.015); }

        label {
            font-size: 12px;
            font-weight: 600;
            letter-spacing: 0.04em;
            color: var(--muted);
        }
        input {
            width: 100%;
            padding: 14px 16px;
            border-radius: var(--radius-field);
            border: 1px solid var(--field-edge);
            background: var(--field);
            font-family: inherit;
            font-size: 14px;
            font-weight: 500;
            color: var(--obsidian);
            outline: none;
            transition: border-color 0.2s ease, box-shadow 0.25s ease, background 0.2s ease;
        }
        input::placeholder { color: #8E877E; font-weight: 400; }
        input:hover { border-color: rgba(17, 17, 17, 0.22); }
        input:focus {
            border-color: var(--terracotta);
            background: #FFFFFF;
            box-shadow: 0 0 0 4px rgba(224, 122, 95, 0.20);
        }

        .password-row { display: flex; justify-content: space-between; align-items: center; }
        .accent-link {
            font-size: 12.5px;
            font-weight: 600;
            color: var(--terracotta-text);
            text-decoration: none;
            border-radius: 4px;
            transition: color 0.2s ease;
        }
        .accent-link:hover { color: var(--obsidian); text-decoration: underline; text-underline-offset: 3px; }

        .form-message {
            display: none;
            background: rgba(181, 81, 58, 0.10);
            color: #8F3B27;
            border: 1px solid rgba(181, 81, 58, 0.28);
            border-radius: var(--radius-field);
            padding: 11px 14px;
            font-size: 13px;
            font-weight: 500;
            margin: 0 0 6px;
        }

        /* ---------- Primary button: hover glow + click ripple ---------- */
        .submit-btn {
            position: relative;
            overflow: hidden;
            width: 100%;
            margin-top: 8px;
            padding: 15px;
            border: none;
            border-radius: var(--radius-field);
            background: var(--obsidian);
            color: #FFFFFF;
            font-family: inherit;
            font-size: 14px;
            font-weight: 600;
            letter-spacing: 0.04em;
            cursor: pointer;
            box-shadow: 0 10px 22px -12px rgba(17, 17, 17, 0.55);
            transition: transform 0.25s var(--ease), box-shadow 0.3s ease;
        }
        .submit-btn::after {
            content: "";
            position: absolute;
            inset: 0;
            background: radial-gradient(circle at 50% 120%, rgba(224, 122, 95, 0.55), transparent 65%);
            opacity: 0;
            transition: opacity 0.35s ease;
            pointer-events: none;
        }
        .submit-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 16px 28px -12px rgba(224, 122, 95, 0.65), 0 10px 22px -12px rgba(17, 17, 17, 0.5);
        }
        .submit-btn:hover::after { opacity: 1; }
        .submit-btn:active { transform: translateY(0) scale(0.985); }
        .submit-btn:disabled { opacity: 0.6; cursor: not-allowed; transform: none; }
        .submit-btn span.btn-label { position: relative; z-index: 1; }

        .ripple {
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.35);
            transform: scale(0);
            animation: ripple 0.65s ease-out forwards;
            pointer-events: none;
        }
        @keyframes ripple { to { transform: scale(1); opacity: 0; } }

        .guest-row {
            margin-top: 26px;
            text-align: center;
            font-size: 13px;
            color: var(--muted);
        }
        .guest-row .accent-link { font-size: 13px; }

        /* Keyboard focus */
        .tab-btn:focus-visible,
        .submit-btn:focus-visible,
        .accent-link:focus-visible {
            outline: 3px solid rgba(224, 122, 95, 0.55);
            outline-offset: 3px;
        }

        /* ---------- Success popup ---------- */
        .popup-overlay {
            position: fixed;
            inset: 0;
            background: rgba(17, 17, 17, 0.35);
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
            background: var(--cream);
            box-shadow: 0 30px 60px -20px rgba(17, 17, 17, 0.4);
            animation: popIn 0.4s var(--ease);
        }
        .popup-icon {
            width: 60px;
            height: 60px;
            margin: 0 auto 18px;
            border-radius: 50%;
            background: rgba(224, 122, 95, 0.16);
            color: var(--terracotta-text);
            font-size: 28px;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .popup-card h3 { margin: 0 0 8px; font-size: 20px; font-weight: 700; }
        .popup-card p { margin: 0; color: var(--muted); font-size: 14px; line-height: 1.5; }
        @keyframes popIn {
            from { opacity: 0; transform: scale(0.92); }
            to   { opacity: 1; transform: scale(1); }
        }

        @media (max-width: 600px) {
            body { background-attachment: scroll; padding: 16px; }
            .gateway-container { padding: 40px 26px 32px; }
        }

        @media (prefers-reduced-motion: reduce) {
            *, *::before, *::after { animation-duration: 0.01ms !important; transition-duration: 0.01ms !important; }
        }
    </style>
</head>
<body>

    <div class="gateway-container">

        <div class="brand">S<span class="brand-accent">TEFA</span></div>
        <p class="tagline">Elevate your style.</p>

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
            Just looking? <a href="/shop" class="accent-link">Browse as guest →</a>
        </div>

    </div>

    <!-- Success popup -->
    <div class="popup-overlay" id="success-popup" role="status" aria-live="polite">
        <div class="popup-card">
            <div class="popup-icon">✓</div>
            <h3 id="popup-title">Login successful!</h3>
            <p id="popup-text">Redirecting you to the shop...</p>
        </div>
    </div>

    <!-- Authentication Script (API logic unchanged) -->
    <script>
        const REDIRECT_DELAY = 1500;

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

        function showSuccessPopup(title, text) {
            document.getElementById('popup-title').textContent = title;
            document.getElementById('popup-text').textContent = text;
            document.getElementById('success-popup').classList.add('show');
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

        async function submitAuth(url, payload, messageId, button, busyText, successTitle, successText) {
            const label = button.querySelector('.btn-label');
            const originalText = label.textContent;
            button.disabled = true;
            label.textContent = busyText;
            clearMessages();

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
                    showSuccessPopup(successTitle, successText);
                    setTimeout(() => { window.location.href = '/shop'; }, REDIRECT_DELAY);
                    return;
                }

                clearSession();

                if (response.status === 422 && data.errors) {
                    showMessage(messageId, Object.values(data.errors)[0][0]);
                } else {
                    showMessage(messageId, data.message || 'Something went wrong. Please try again.');
                }
            } catch (error) {
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
                'Welcome back! Redirecting you to the shop...'
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
                'Welcome to STEFA! Redirecting you to the shop...'
            );
        });
    </script>

</body>
</html>