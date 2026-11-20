<style>
    :root { --brown:#603E1E; --pale-gold:#F1D9A8; --gold:#FFC34D; }
    * { box-sizing: border-box; }
    body {
        margin: 0; min-height: 100vh; display: grid; place-items: center; padding: 16px;
        font-family: system-ui, sans-serif; color: var(--pale-gold);
        background: linear-gradient(rgba(20,12,6,.65), rgba(20,12,6,.65)), url('/images/login-bg.png') center/cover;
    }
    .card {
        width: 100%; max-width: 400px; padding: 32px; border-radius: 16px;
        background: rgba(30,20,12,.7); backdrop-filter: blur(10px);
        border: 1px solid rgba(241,217,168,.2);
    }
    h1 { margin: 0 0 6px; font-size: 1.5rem; color: var(--gold); }
    p.sub { margin: 0 0 20px; font-size: .9rem; opacity: .8; }
    label { display: block; margin: 14px 0 6px; font-size: .85rem; }
    input {
        width: 100%; padding: 11px 12px; border-radius: 8px; font-size: 1rem;
        border: 1px solid rgba(241,217,168,.3); background: rgba(0,0,0,.35); color: #fff;
    }
    input:focus { outline: 2px solid var(--gold); }
    button {
        width: 100%; margin-top: 20px; padding: 12px; border: 0; border-radius: 8px;
        font-size: 1rem; font-weight: 600; cursor: pointer; background: var(--gold); color: var(--brown);
    }
    button:hover { filter: brightness(1.08); }
    button:disabled { opacity: .6; cursor: wait; }
    .msg { margin-top: 16px; padding: 10px 12px; border-radius: 8px; font-size: .9rem; display: none; }
    .msg.ok { display: block; background: rgba(90,160,90,.25); }
    .msg.err { display: block; background: rgba(190,70,60,.3); }
    a { color: var(--gold); }
    .back { margin-top: 18px; text-align: center; font-size: .9rem; }
</style>