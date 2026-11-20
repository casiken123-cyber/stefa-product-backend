<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Forgot password</title>
    @include('partials.auth-style')
</head>
<body>
<div class="card">
    <h1>Forgot password?</h1>
    <p class="sub">Enter your email and we'll send you a reset link.</p>

    <label for="email">Email</label>
    <input id="email" type="email" autocomplete="email" placeholder="you@example.com">

    <button id="send">Send reset link</button>
    <div id="msg" class="msg"></div>
    <div class="back"><a href="/login">Back to login</a></div>
</div>

<script>
const btn = document.getElementById('send');
const msg = document.getElementById('msg');

function show(text, ok) { msg.textContent = text; msg.className = 'msg ' + (ok ? 'ok' : 'err'); }

btn.addEventListener('click', async () => {
    const email = document.getElementById('email').value.trim();
    if (!email) return show('Please enter your email.', false);

    btn.disabled = true;
    try {
        const res = await fetch('/api/forgot-password', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'Accept': 'application/json' },
            body: JSON.stringify({ email })
        });
        const data = await res.json();
        if (res.ok) show(data.message, true);
        else if (res.status === 429) show('Too many attempts. Please wait a minute and try again.', false);
        else show(data.errors?.email?.[0] || data.message || 'Something went wrong.', false);
    } catch (e) {
        show('Could not reach the server.', false);
    }
    btn.disabled = false;
});
</script>
</body>
</html>