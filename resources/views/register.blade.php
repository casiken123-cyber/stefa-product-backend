<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>StefaShop - Register Account</title>
    <style>
        body { background-color: #f0fdf4; font-family: system-ui, -apple-system, sans-serif; color: #0f172a; margin: 0; display: flex; align-items: center; justify-content: center; min-height: 100vh; }
        .auth-card { background: white; width: 100%; max-width: 400px; padding: 40px; border-radius: 24px; border: 1px solid #e2e8f0; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.02); }
        .logo { font-size: 24px; font-weight: 800; text-align: center; margin-bottom: 8px; letter-spacing: -0.5px; }
        .logo-dark { color: #10b981; }
        .subtitle { text-align: center; color: #64748b; font-size: 14px; margin-bottom: 32px; line-height: 1.4; }
        
        .form-group { display: flex; flex-direction: column; gap: 8px; margin-bottom: 20px; }
        label { font-size: 13px; font-weight: 600; color: #475569; }
        input { padding: 12px 16px; border-radius: 12px; border: 1px solid #e2e8f0; font-size: 14px; outline: none; background: #f8fafc; }
        input:focus { border-color: #10b981; background: white; }
        
        .btn { background: #10b981; color: white; width: 100%; border: none; padding: 14px; border-radius: 12px; font-size: 14px; font-weight: 600; cursor: pointer; margin-top: 10px; transition: background 0.2s; }
        .btn:hover { background: #059669; }
        .switch-text { text-align: center; font-size: 13px; color: #64748b; margin-top: 24px; }
        .switch-text a { color: #0f172a; text-decoration: none; font-weight: 600; }
    </style>
</head>
<body>

    <div class="auth-card">
        <div class="logo">STEFA<span class="logo-dark">SHOP</span></div>
        <p class="subtitle">Create a shopper profile account to activate add-to-cart operations and full ordering workflows.</p>

        <form action="/register" method="POST" onsubmit="event.preventDefault(); alert('Registration Account Form Sent! Simulating custom onboarding logic...'); window.location.href='/login';">
            <div class="form-group">
                <label>Full Name</label>
                <input type="text" placeholder="Stefan Dev" required>
            </div>
            <div class="form-group">
                <label>Email Address</label>
                <input type="email" placeholder="stefan@example.com" required>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" placeholder="Choose secure password" required>
            </div>
            <button type="submit" class="btn">Register Account</button>
        </form>

        <p class="switch-text">Already have a customer account? <a href="/login">Sign In</a></p>
    </div>

</body>
</html>
