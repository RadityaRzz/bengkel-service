<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Bengkel Service</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            min-height: 100vh; overflow: hidden;
            display: flex; align-items: center; justify-content: center;
        }

        /* ── BACKGROUND ── */
        .bg {
            position: fixed; inset: 0; z-index: -1;
            background: url('https://images.unsplash.com/photo-1558618666-fcd25c85cd64?w=1920&q=80') center/cover no-repeat;
        }
        .bg::after {
            content: ''; position: absolute; inset: 0;
            background: linear-gradient(135deg, rgba(10,25,50,0.88) 0%, rgba(26,60,110,0.75) 100%);
        }

        /* ── FLOATING PARTICLES ── */
        .particles { position: fixed; inset: 0; z-index: 0; pointer-events: none; }
        .particle {
            position: absolute; border-radius: 50%;
            background: rgba(249,199,79,0.15);
            animation: float linear infinite;
        }
        @keyframes float {
            0%   { transform: translateY(100vh) scale(0); opacity: 0; }
            10%  { opacity: 1; }
            90%  { opacity: 1; }
            100% { transform: translateY(-100px) scale(1); opacity: 0; }
        }

        /* ── GLASS CARD ── */
        .glass-wrap {
            position: relative; z-index: 1;
            background: rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(24px) saturate(180%);
            -webkit-backdrop-filter: blur(24px) saturate(180%);
            border: 1px solid rgba(255, 255, 255, 0.18);
            border-radius: 24px;
            padding: 44px 40px;
            width: 100%; max-width: 420px;
            box-shadow: 0 16px 64px rgba(0,0,0,0.4), inset 0 1px 0 rgba(255,255,255,0.2);
            animation: cardIn 0.7s cubic-bezier(0.4, 0, 0.2, 1) both;
        }
        @keyframes cardIn {
            from { opacity: 0; transform: translateY(40px) scale(0.95); }
            to   { opacity: 1; transform: translateY(0) scale(1); }
        }

        /* ── LOGO ── */
        .logo { text-align: center; margin-bottom: 32px; }
        .logo .gear-icon {
            font-size: 3rem; display: block; margin-bottom: 10px;
            animation: spin 8s linear infinite;
            filter: drop-shadow(0 0 12px rgba(249,199,79,0.6));
        }
        @keyframes spin { to { transform: rotate(360deg); } }
        .logo h1 { font-size: 1.8rem; font-weight: 800; color: white; letter-spacing: 1px; }
        .logo h1 span { color: #f9c74f; text-shadow: 0 0 16px rgba(249,199,79,0.5); }
        .logo p { color: rgba(255,255,255,0.6); font-size: 0.88rem; margin-top: 6px; }

        /* ── FORM ── */
        .form-group { margin-bottom: 18px; }
        .form-group label {
            display: block; font-size: 0.82rem; font-weight: 700;
            color: rgba(255,255,255,0.8); margin-bottom: 6px; letter-spacing: 0.5px;
            text-transform: uppercase;
        }
        .form-control {
            width: 100%; padding: 12px 16px;
            background: rgba(255,255,255,0.1);
            border: 1.5px solid rgba(255,255,255,0.2);
            border-radius: 10px; font-size: 0.95rem;
            color: white; outline: none;
            transition: all 0.3s ease;
        }
        .form-control::placeholder { color: rgba(255,255,255,0.4); }
        .form-control:focus {
            background: rgba(255,255,255,0.18);
            border-color: #f9c74f;
            box-shadow: 0 0 0 4px rgba(249,199,79,0.15);
        }

        /* ── BUTTON ── */
        .btn-login {
            width: 100%; padding: 13px;
            background: linear-gradient(135deg, #f9c74f 0%, #f3a952 100%);
            color: #1a3c6e; border: none; border-radius: 10px;
            font-size: 1rem; font-weight: 800; cursor: pointer; margin-top: 8px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 20px rgba(249,199,79,0.35);
            position: relative; overflow: hidden;
        }
        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 28px rgba(249,199,79,0.5);
        }
        .btn-login:active { transform: translateY(0); }

        /* ripple */
        .ripple {
            position: absolute; border-radius: 50%;
            background: rgba(255,255,255,0.4);
            transform: scale(0); animation: ripple-anim 0.6s ease-out;
            pointer-events: none;
        }
        @keyframes ripple-anim { to { transform: scale(4); opacity: 0; } }

        /* ── ALERT ── */
        .alert {
            padding: 10px 14px; border-radius: 8px; margin-bottom: 16px;
            font-size: 0.88rem; animation: slideDown 0.4s ease;
            background: rgba(230,57,70,0.2);
            border: 1px solid rgba(230,57,70,0.4);
            color: #ffb3b8;
        }
        @keyframes slideDown { from { opacity:0; transform:translateY(-8px); } to { opacity:1; transform:translateY(0); } }

        /* ── LINK ── */
        .bottom-link { text-align: center; margin-top: 20px; font-size: 0.88rem; color: rgba(255,255,255,0.55); }
        .bottom-link a { color: #f9c74f; font-weight: 700; text-decoration: none; transition: opacity 0.2s; }
        .bottom-link a:hover { opacity: 0.8; text-decoration: underline; }
        .bottom-note { text-align: center; margin-top: 10px; font-size: 0.75rem; color: rgba(255,255,255,0.3); }

        /* ── RESPONSIVE ── */
        @media (max-width: 480px) {
            .glass-wrap { padding: 32px 22px; border-radius: 18px; margin: 16px; width: calc(100% - 32px); }
            .logo h1 { font-size: 1.5rem; }
            .logo .gear-icon { font-size: 2.4rem; }
            .btn-login { padding: 12px; font-size: 0.95rem; }
        }
        @media (max-height: 600px) {
            .logo { margin-bottom: 18px; }
            .logo .gear-icon { font-size: 2rem; }
            .form-group { margin-bottom: 12px; }
        }

        /* ── DIVIDER ── */
        .divider {
            display: flex; align-items: center; gap: 12px;
            margin: 20px 0; color: rgba(255,255,255,0.3); font-size: 0.8rem;
        }
        .divider::before, .divider::after {
            content: ''; flex: 1; height: 1px;
            background: rgba(255,255,255,0.15);
        }
    </style>
</head>
<body>
<div class="bg"></div>

<!-- Floating particles -->
<div class="particles" id="particles"></div>

<div class="glass-wrap">
    <div class="logo">
        <span class="gear-icon">&#9881;</span>
        <h1>Bengkel <span>Service</span></h1>
        <p>Sistem Booking Service Kendaraan</p>
    </div>

    @if($errors->any())
        <div class="alert">&#9888; {{ $errors->first() }}</div>
    @endif

    <form method="POST" action="{{ route('login.post') }}" id="loginForm">
        @csrf
        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" class="form-control"
                   value="{{ old('email') }}" placeholder="email@contoh.com" required>
        </div>
        <div class="form-group">
            <label>Password</label>
            <input type="password" name="password" class="form-control"
                   placeholder="••••••••" required>
        </div>
        <button type="submit" class="btn-login" id="btnLogin">
            <span id="btnText">Masuk</span>
        </button>
    </form>

    <div class="divider">atau</div>

    <div class="bottom-link">
        Pelanggan baru? <a href="{{ route('register') }}">Daftar di sini</a>
    </div>
    <div class="bottom-note">Admin &amp; Mekanik menggunakan akun dari bengkel.</div>
</div>

<script>
    // Particles
    const container = document.getElementById('particles');
    for (let i = 0; i < 18; i++) {
        const p = document.createElement('div');
        p.classList.add('particle');
        const size = Math.random() * 60 + 10;
        p.style.cssText = `
            width:${size}px; height:${size}px;
            left:${Math.random() * 100}%;
            animation-duration:${Math.random() * 12 + 8}s;
            animation-delay:${Math.random() * 10}s;
            opacity:${Math.random() * 0.4 + 0.1};
        `;
        container.appendChild(p);
    }

    // Ripple
    document.getElementById('btnLogin').addEventListener('click', function(e) {
        const ripple = document.createElement('span');
        ripple.classList.add('ripple');
        const rect = this.getBoundingClientRect();
        const size = Math.max(rect.width, rect.height);
        ripple.style.width = ripple.style.height = size + 'px';
        ripple.style.left = (e.clientX - rect.left - size / 2) + 'px';
        ripple.style.top  = (e.clientY - rect.top  - size / 2) + 'px';
        this.appendChild(ripple);
        setTimeout(() => ripple.remove(), 600);
    });

    // Loading state on submit
    document.getElementById('loginForm').addEventListener('submit', function() {
        const btn = document.getElementById('btnLogin');
        btn.disabled = true;
        document.getElementById('btnText').innerText = 'Memproses...';
    });
</script>
</body>
</html>
