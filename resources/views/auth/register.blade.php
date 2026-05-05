<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar - Bengkel Service</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            min-height: 100vh; overflow-x: hidden;
            display: flex; align-items: center; justify-content: center;
            padding: 24px 16px;
        }

        /* ── BACKGROUND ── */
        .bg {
            position: fixed; inset: 0; z-index: -1;
            background: url('https://images.unsplash.com/photo-1486262715619-67b85e0b08d3?w=1920&q=80') center/cover no-repeat;
        }
        .bg::after {
            content: ''; position: absolute; inset: 0;
            background: linear-gradient(135deg, rgba(10,25,50,0.9) 0%, rgba(26,60,110,0.8) 100%);
        }

        /* ── PARTICLES ── */
        .particles { position: fixed; inset: 0; z-index: 0; pointer-events: none; }
        .particle {
            position: absolute; border-radius: 50%;
            background: rgba(249,199,79,0.12);
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
            padding: 40px 36px;
            width: 100%; max-width: 460px;
            box-shadow: 0 16px 64px rgba(0,0,0,0.4), inset 0 1px 0 rgba(255,255,255,0.2);
            animation: cardIn 0.7s cubic-bezier(0.4, 0, 0.2, 1) both;
        }
        @keyframes cardIn {
            from { opacity: 0; transform: translateY(40px) scale(0.95); }
            to   { opacity: 1; transform: translateY(0) scale(1); }
        }

        /* ── LOGO ── */
        .logo { text-align: center; margin-bottom: 28px; }
        .logo .gear-icon {
            font-size: 2.5rem; display: block; margin-bottom: 8px;
            animation: spin 8s linear infinite;
            filter: drop-shadow(0 0 10px rgba(249,199,79,0.6));
        }
        @keyframes spin { to { transform: rotate(360deg); } }
        .logo h1 { font-size: 1.6rem; font-weight: 800; color: white; }
        .logo h1 span { color: #f9c74f; text-shadow: 0 0 16px rgba(249,199,79,0.5); }
        .logo p { color: rgba(255,255,255,0.55); font-size: 0.85rem; margin-top: 4px; }

        /* ── FORM ── */
        .form-group { margin-bottom: 16px; }
        .form-group label {
            display: block; font-size: 0.78rem; font-weight: 700;
            color: rgba(255,255,255,0.75); margin-bottom: 5px;
            letter-spacing: 0.5px; text-transform: uppercase;
        }
        .form-control {
            width: 100%; padding: 11px 14px;
            background: rgba(255,255,255,0.1);
            border: 1.5px solid rgba(255,255,255,0.2);
            border-radius: 10px; font-size: 0.92rem;
            color: white; outline: none;
            transition: all 0.3s ease;
        }
        .form-control::placeholder { color: rgba(255,255,255,0.35); }
        .form-control:focus {
            background: rgba(255,255,255,0.18);
            border-color: #f9c74f;
            box-shadow: 0 0 0 4px rgba(249,199,79,0.15);
        }
        .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; }

        /* ── BUTTON ── */
        .btn-reg {
            width: 100%; padding: 13px;
            background: linear-gradient(135deg, #f9c74f 0%, #f3a952 100%);
            color: #1a3c6e; border: none; border-radius: 10px;
            font-size: 1rem; font-weight: 800; cursor: pointer; margin-top: 6px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 20px rgba(249,199,79,0.35);
            position: relative; overflow: hidden;
        }
        .btn-reg:hover { transform: translateY(-2px); box-shadow: 0 8px 28px rgba(249,199,79,0.5); }
        .btn-reg:active { transform: translateY(0); }

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
        .bottom-link { text-align: center; margin-top: 18px; font-size: 0.88rem; color: rgba(255,255,255,0.55); }
        .bottom-link a { color: #f9c74f; font-weight: 700; text-decoration: none; }
        .bottom-link a:hover { text-decoration: underline; }

        /* ── RESPONSIVE ── */
        @media (max-width: 480px) {
            body { padding: 16px 12px; }
            .glass-wrap { padding: 28px 18px; border-radius: 18px; }
            .logo h1 { font-size: 1.4rem; }
            .logo .gear-icon { font-size: 2rem; }
            .form-row { grid-template-columns: 1fr; gap: 0; }
            .btn-reg { padding: 12px; font-size: 0.95rem; }
            .steps { margin-bottom: 18px; }
        }
        @media (max-height: 700px) {
            .logo { margin-bottom: 16px; }
            .logo .gear-icon { font-size: 1.8rem; }
            .form-group { margin-bottom: 10px; }
            .glass-wrap { padding: 24px 20px; }
        }

        /* ── STEP INDICATOR ── */
        .steps {
            display: flex; justify-content: center; gap: 8px; margin-bottom: 24px;
        }
        .step {
            width: 8px; height: 8px; border-radius: 50%;
            background: rgba(255,255,255,0.2); transition: all 0.3s;
        }
        .step.active { background: #f9c74f; width: 24px; border-radius: 4px; }
    </style>
</head>
<body>
<div class="bg"></div>
<div class="particles" id="particles"></div>

<div class="glass-wrap">
    <div class="logo">
        <span class="gear-icon">&#9881;</span>
        <h1>Bengkel <span>Service</span></h1>
        <p>Daftar sebagai pelanggan baru</p>
    </div>

    <div class="steps">
        <div class="step active"></div>
        <div class="step"></div>
        <div class="step"></div>
    </div>

    @if($errors->any())
        <div class="alert">
            @foreach($errors->all() as $e) &#9888; {{ $e }}<br> @endforeach
        </div>
    @endif

    <form method="POST" action="{{ route('register.post') }}" id="regForm">
        @csrf
        <div class="form-group">
            <label>Nama Lengkap</label>
            <input type="text" name="name" class="form-control"
                   value="{{ old('name') }}" placeholder="Nama lengkap Anda" required>
        </div>
        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" class="form-control"
                   value="{{ old('email') }}" placeholder="email@contoh.com" required>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label>No. Telepon</label>
                <input type="text" name="telepon" class="form-control"
                       value="{{ old('telepon') }}" placeholder="08xxxxxxxxxx">
            </div>
            <div class="form-group">
                <label>Alamat</label>
                <input type="text" name="alamat" class="form-control"
                       value="{{ old('alamat') }}" placeholder="Kota / Alamat">
            </div>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" class="form-control"
                       placeholder="Min. 6 karakter" required>
            </div>
            <div class="form-group">
                <label>Konfirmasi</label>
                <input type="password" name="password_confirmation" class="form-control"
                       placeholder="Ulangi password" required>
            </div>
        </div>
        <button type="submit" class="btn-reg" id="btnReg">
            <span id="btnText">Daftar Sekarang</span>
        </button>
    </form>

    <div class="bottom-link">
        Sudah punya akun? <a href="{{ route('login') }}">Masuk di sini</a>
    </div>
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
            opacity:${Math.random() * 0.3 + 0.1};
        `;
        container.appendChild(p);
    }

    // Step indicator on input focus
    const inputs = document.querySelectorAll('.form-control');
    const steps  = document.querySelectorAll('.step');
    inputs.forEach((input, i) => {
        input.addEventListener('focus', () => {
            const step = Math.min(Math.floor(i / 2), 2);
            steps.forEach((s, si) => s.classList.toggle('active', si === step));
        });
    });

    // Ripple
    document.getElementById('btnReg').addEventListener('click', function(e) {
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

    // Loading state
    document.getElementById('regForm').addEventListener('submit', function() {
        const btn = document.getElementById('btnReg');
        btn.disabled = true;
        document.getElementById('btnText').innerText = 'Mendaftarkan...';
    });
</script>
</body>
</html>
