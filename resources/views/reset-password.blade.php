<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Reset password</title>
    @include('partials.auth-style')
</head>
<body>
<div class="card">
    <h1>Set a new password</h1>
    <p class="sub" id="who"></p>

    <label for="password">New password</label>
    <input id="password" type="password" autocomplete="new-password" placeholder="At least 8 characters">

    <label for="confirm">Confirm password</label>
    <input id="confirm" type="password" autocomplete="new-password">

    <button id="save">Reset password</button>
    <div id="msg" class="msg"></div>
    <div class="back"><a href="/login">Back to login</a></div>
</div>

<script>
const params = new URLSearchParams(location.search);
const token = params.get('token');
const email = params.get('email');
const btn = document.getElementById('save');
const msg = document.getElementById('msg');

document.getElementById('who').textContent = email ? 'For ' + email : '';

function show(text, ok) { msg.textContent = text; msg.className = 'msg ' + (ok ? 'ok' : 'err'); }

if (!token || !email) {
    show('This reset link is incomplete. Please request a new one.', false);
    btn.disabled = true;
}

btn.addEventListener('click', async () => {
    const password = document.getElementById('password').value;
    const password_confirmation = document.getElementById('confirm').value;

    if (password.length < 8) return show('Password must be at least 8 characters.', false);
    if (password !== password_confirmation) return show('Passwords do not match.', false);

    btn.disabled = true;
    try {
        const res = await fetch('/api/reset-password', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'Accept': 'application/json' },
            body: JSON.stringify({ token, email, password, password_confirmation })
        });
        const data = await res.json();
        if (res.ok) {
            show(data.message + ' Redirecting to login…', true);
            setTimeout(() => location.href = '/login', 2000);
            return;
        }
        if (res.status === 429) show('Too many attempts. Please wait a minute.', false);
        else show(data.errors?.password?.[0] || data.message || 'Something went wrong.', false);
    } catch (e) {
        show('Could not reach the server.', false);
    }
    btn.disabled = false;
});
</script>
</body>
</html>