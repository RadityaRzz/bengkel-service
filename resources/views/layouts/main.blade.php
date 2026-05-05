<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Bengkel Service')</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            background-attachment: fixed;
            color: #333; overflow-x: hidden; min-height: 100vh;
        }

        /* ── GLASSMORPHISM BACKGROUND ── */
        body::before {
            content: ''; position: fixed; inset: 0;
            background: url('https://images.unsplash.com/photo-1486262715619-67b85e0b08d3?w=1920&q=80') center/cover;
            opacity: 0.08; z-index: -1; filter: blur(2px);
        }

        /* ── PAGE LOADER ── */
        #page-loader {
            position: fixed; inset: 0;
            background: linear-gradient(135deg, #1a3c6e 0%, #0f2744 100%);
            display: flex; flex-direction: column; align-items: center; justify-content: center;
            z-index: 9999; transition: opacity 0.5s ease, visibility 0.5s ease;
        }
        #page-loader.hide { opacity: 0; visibility: hidden; }
        #page-loader .gear {
            font-size: 4rem; animation: spin 1s linear infinite;
            filter: drop-shadow(0 0 20px #f9c74f);
        }
        #page-loader .loader-text {
            color: white; font-size: 1.1rem; font-weight: 700; margin-top: 16px;
            letter-spacing: 4px; animation: blink 1.2s ease-in-out infinite;
        }
        @keyframes spin  { to { transform: rotate(360deg); } }
        @keyframes blink { 0%,100% { opacity: 1; } 50% { opacity: 0.4; } }

        /* ── FADE IN ── */
        .fade-in { opacity: 0; transform: translateY(20px); transition: opacity 0.6s ease, transform 0.6s ease; }
        .fade-in.visible { opacity: 1; transform: translateY(0); }

        /* ── NAVBAR GLASS ── */
        .navbar {
            background: rgba(26, 60, 110, 0.85);
            backdrop-filter: blur(12px) saturate(180%);
            -webkit-backdrop-filter: blur(12px) saturate(180%);
            border-bottom: 1px solid rgba(255,255,255,0.1);
            color: white; padding: 0 28px;
            display: flex; align-items: center; justify-content: space-between;
            height: 60px; box-shadow: 0 4px 24px rgba(0,0,0,0.15);
            position: sticky; top: 0; z-index: 100;
        }
        .navbar-brand { font-size: 1.3rem; font-weight: 800; letter-spacing: 1.5px; }
        .navbar-brand span { color: #f9c74f; text-shadow: 0 0 10px rgba(249,199,79,0.5); }
        .navbar-user { display: flex; align-items: center; gap: 14px; font-size: 0.9rem; }
        .badge-role {
            background: linear-gradient(135deg, #f9c74f 0%, #f3a952 100%);
            color: #1a3c6e; padding: 3px 12px; border-radius: 14px;
            font-weight: 700; font-size: 0.75rem; text-transform: uppercase;
            box-shadow: 0 2px 8px rgba(249,199,79,0.3);
        }
        .btn-logout {
            background: linear-gradient(135deg, #e63946 0%, #c1121f 100%);
            color: white; border: none; padding: 6px 16px; border-radius: 6px;
            cursor: pointer; font-size: 0.85rem; font-weight: 600;
            transition: transform 0.2s, box-shadow 0.2s;
            box-shadow: 0 2px 8px rgba(230,57,70,0.3);
        }
        .btn-logout:hover { transform: translateY(-2px); box-shadow: 0 4px 16px rgba(230,57,70,0.4); }

        /* ── LAYOUT ── */
        .layout { display: flex; min-height: calc(100vh - 60px); }

        /* ── SIDEBAR GLASS ── */
        .sidebar {
            width: 240px;
            background: rgba(30, 77, 140, 0.75);
            backdrop-filter: blur(16px) saturate(180%);
            -webkit-backdrop-filter: blur(16px) saturate(180%);
            border-right: 1px solid rgba(255,255,255,0.1);
            color: white; padding: 24px 0; flex-shrink: 0;
            box-shadow: 4px 0 24px rgba(0,0,0,0.1);
        }
        .sidebar a {
            display: block; padding: 12px 24px; color: rgba(255,255,255,0.85);
            text-decoration: none; font-size: 0.92rem; font-weight: 500;
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
            border-left: 3px solid transparent; margin: 2px 0;
        }
        .sidebar a:hover {
            background: rgba(37, 99, 176, 0.4);
            color: white; padding-left: 32px;
            border-left-color: rgba(249,199,79,0.6);
        }
        .sidebar a.active {
            background: rgba(37, 99, 176, 0.6);
            color: white; border-left-color: #f9c74f;
            box-shadow: inset 0 0 20px rgba(249,199,79,0.1);
        }
        .sidebar .menu-label {
            padding: 18px 24px 8px; font-size: 0.7rem;
            text-transform: uppercase; color: rgba(255,255,255,0.5);
            letter-spacing: 2px; font-weight: 700;
        }

        /* ── MAIN ── */
        .main { flex: 1; padding: 28px; }
        .page-title {
            font-size: 1.6rem; font-weight: 800; color: white;
            margin-bottom: 24px; padding-bottom: 10px;
            text-shadow: 0 2px 8px rgba(0,0,0,0.2);
            border-bottom: 3px solid rgba(249,199,79,0.6);
            display: inline-block;
        }

        /* ── CARD GLASS ── */
        .card {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(20px) saturate(180%);
            -webkit-backdrop-filter: blur(20px) saturate(180%);
            border: 1px solid rgba(255,255,255,0.3);
            border-radius: 16px; padding: 24px; margin-bottom: 24px;
            box-shadow: 0 8px 32px rgba(0,0,0,0.1);
            transition: transform 0.3s, box-shadow 0.3s;
        }
        .card:hover { transform: translateY(-4px); box-shadow: 0 12px 48px rgba(0,0,0,0.15); }
        .card-title { font-size: 1.1rem; font-weight: 700; color: #1a3c6e; margin-bottom: 16px; }

        /* ── STAT CARDS GLASS ── */
        .stats-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(170px, 1fr)); gap: 18px; margin-bottom: 28px; }
        .stat-card {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(16px) saturate(180%);
            -webkit-backdrop-filter: blur(16px) saturate(180%);
            border: 1px solid rgba(255,255,255,0.4);
            border-radius: 14px; padding: 20px; text-align: center;
            box-shadow: 0 4px 16px rgba(0,0,0,0.08);
            border-top: 4px solid #1a3c6e;
            transition: transform 0.3s, box-shadow 0.3s;
        }
        .stat-card:hover { transform: translateY(-6px) scale(1.02); box-shadow: 0 12px 32px rgba(26,60,110,0.2); }
        .stat-card .stat-num { font-size: 2.2rem; font-weight: 800; color: #1a3c6e; }
        .stat-card .stat-label { font-size: 0.82rem; color: #555; margin-top: 6px; font-weight: 600; }

        /* ── TABLE ── */
        table { width: 100%; border-collapse: collapse; font-size: 0.9rem; }
        th {
            background: linear-gradient(135deg, #1a3c6e 0%, #2563b0 100%);
            color: white; padding: 12px 14px; text-align: left; font-weight: 600;
        }
        td { padding: 11px 14px; border-bottom: 1px solid rgba(0,0,0,0.06); transition: background 0.2s; }
        tr:hover td { background: rgba(26,60,110,0.04); }

        /* ── BADGE ── */
        .badge { padding: 4px 12px; border-radius: 14px; font-size: 0.75rem; font-weight: 700; }
        .badge-menunggu   { background: linear-gradient(135deg, #fff3cd 0%, #ffe69c 100%); color: #856404; }
        .badge-diproses   { background: linear-gradient(135deg, #cfe2ff 0%, #9ec5fe 100%); color: #084298; }
        .badge-selesai    { background: linear-gradient(135deg, #d1e7dd 0%, #a3cfbb 100%); color: #0a3622; }
        .badge-dibatalkan { background: linear-gradient(135deg, #f8d7da 0%, #f1aeb5 100%); color: #842029; }
        .badge-lunas      { background: linear-gradient(135deg, #d1e7dd 0%, #a3cfbb 100%); color: #0a3622; }
        .badge-belum_bayar{ background: linear-gradient(135deg, #fff3cd 0%, #ffe69c 100%); color: #856404; }

        /* ── FORM ── */
        .form-group { margin-bottom: 16px; }
        .form-group label { display: block; font-size: 0.88rem; font-weight: 700; color: #1a3c6e; margin-bottom: 6px; }
        .form-control {
            width: 100%; padding: 10px 14px;
            border: 2px solid rgba(26,60,110,0.15);
            border-radius: 8px; font-size: 0.92rem; outline: none;
            background: rgba(255,255,255,0.9);
            transition: border-color 0.2s, box-shadow 0.2s, background 0.2s;
        }
        .form-control:focus {
            border-color: #1a3c6e;
            box-shadow: 0 0 0 4px rgba(26,60,110,0.1);
            background: white;
        }
        .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }

        /* ── BUTTONS ── */
        .btn {
            padding: 10px 22px; border-radius: 8px; border: none; cursor: pointer;
            font-size: 0.9rem; font-weight: 700; text-decoration: none; display: inline-block;
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        .btn:hover { transform: translateY(-2px); box-shadow: 0 6px 20px rgba(0,0,0,0.15); }
        .btn:active { transform: translateY(0); }
        .btn-primary  { background: linear-gradient(135deg, #1a3c6e 0%, #2563b0 100%); color: white; }
        .btn-success  { background: linear-gradient(135deg, #198754 0%, #146c43 100%); color: white; }
        .btn-warning  { background: linear-gradient(135deg, #f9c74f 0%, #f3a952 100%); color: #1a3c6e; }
        .btn-danger   { background: linear-gradient(135deg, #e63946 0%, #c1121f 100%); color: white; }
        .btn-sm { padding: 6px 14px; font-size: 0.82rem; }

        /* ── ALERT ── */
        .alert {
            padding: 12px 18px; border-radius: 10px; margin-bottom: 18px; font-size: 0.92rem;
            animation: slideDown 0.4s ease;
            background: rgba(255,255,255,0.95);
            backdrop-filter: blur(10px);
            box-shadow: 0 4px 16px rgba(0,0,0,0.1);
        }
        .alert-success { border-left: 5px solid #198754; color: #0a3622; }
        .alert-danger  { border-left: 5px solid #e63946; color: #842029; }
        @keyframes slideDown { from { opacity: 0; transform: translateY(-12px); } to { opacity: 1; transform: translateY(0); } }

        /* ── MODAL GLASS ── */
        .modal-overlay {
            display: none; position: fixed; inset: 0;
            background: rgba(0,0,0,0); z-index: 1000;
            align-items: center; justify-content: center;
            transition: background 0.3s;
        }
        .modal-overlay.open { display: flex; background: rgba(0,0,0,0.6); backdrop-filter: blur(4px); }
        .modal-box {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px) saturate(180%);
            -webkit-backdrop-filter: blur(20px) saturate(180%);
            border: 1px solid rgba(255,255,255,0.3);
            border-radius: 16px; padding: 28px;
            width: 100%; max-width: 500px;
            box-shadow: 0 16px 64px rgba(0,0,0,0.3);
            transform: scale(0.85) translateY(30px); opacity: 0;
            transition: transform 0.35s cubic-bezier(0.4, 0, 0.2, 1), opacity 0.35s ease;
        }
        .modal-overlay.open .modal-box { transform: scale(1) translateY(0); opacity: 1; }
        .modal-title { font-size: 1.2rem; font-weight: 800; color: #1a3c6e; margin-bottom: 18px; }
        .modal-close {
            float: right; cursor: pointer; font-size: 1.4rem; color: #666;
            background: none; border: none;
            transition: color 0.2s, transform 0.3s;
        }
        .modal-close:hover { color: #e63946; transform: rotate(90deg); }

        /* ── RIPPLE ── */
        .btn { position: relative; overflow: hidden; }
        .ripple {
            position: absolute; border-radius: 50%;
            background: rgba(255,255,255,0.4);
            transform: scale(0); animation: ripple-anim 0.6s ease-out;
            pointer-events: none;
        }
        @keyframes ripple-anim { to { transform: scale(4); opacity: 0; } }

        /* ── RESPONSIVE ── */
        .table-wrap { width: 100%; overflow-x: auto; -webkit-overflow-scrolling: touch; }

        /* Hamburger */
        .hamburger {
            display: none; background: none; border: none;
            cursor: pointer; padding: 6px; color: white; font-size: 1.5rem;
        }

        @media (max-width: 768px) {
            .hamburger { display: block; }

            .sidebar {
                position: fixed; left: -260px; top: 60px;
                height: calc(100vh - 60px); z-index: 200;
                transition: left 0.3s cubic-bezier(0.4,0,0.2,1);
                box-shadow: 4px 0 24px rgba(0,0,0,0.3);
            }
            .sidebar.open { left: 0; }

            .sidebar-overlay {
                display: none; position: fixed; inset: 0;
                background: rgba(0,0,0,0.5); z-index: 199;
                backdrop-filter: blur(2px);
            }
            .sidebar-overlay.open { display: block; }

            .layout { display: block; }
            .main { padding: 16px; }

            .stats-grid { grid-template-columns: repeat(2, 1fr); gap: 12px; }
            .form-row { grid-template-columns: 1fr; }

            .page-title { font-size: 1.2rem; }

            table { font-size: 0.8rem; }
            th, td { padding: 8px 10px; }

            .navbar { padding: 0 16px; height: 56px; }
            .navbar-brand { font-size: 1rem; }
            .navbar-user span:first-child { display: none; }

            .modal-box { margin: 16px; max-width: calc(100% - 32px); padding: 20px; }
        }

        @media (max-width: 480px) {
            .stats-grid { grid-template-columns: 1fr 1fr; }
            .btn { padding: 8px 14px; font-size: 0.82rem; }
        }
    </style>
</head>
<body>

<!-- PAGE LOADER -->
<div id="page-loader">
    <div class="gear">&#9881;</div>
    <div class="loader-text">BENGKEL SERVICE</div>
</div>

<nav class="navbar">
    <div style="display:flex;align-items:center;gap:12px;">
        <button class="hamburger" id="hamburger" aria-label="Menu">&#9776;</button>
        <div class="navbar-brand">&#9881; Bengkel <span>Service</span></div>
    </div>
    <div class="navbar-user">
        <span>{{ Auth::user()->name }}</span>
        <span class="badge-role">{{ Auth::user()->role }}</span>
        <form method="POST" action="{{ route('logout') }}" style="display:inline">
            @csrf
            <button type="submit" class="btn-logout">Keluar</button>
        </form>
    </div>
</nav>

<!-- Sidebar overlay (mobile) -->
<div class="sidebar-overlay" id="sidebarOverlay"></div>

<div class="layout">
    <aside class="sidebar">
        @if(Auth::user()->isAdmin())
            <div class="menu-label">Admin</div>
            <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">&#127968; Dashboard</a>
            <a href="{{ route('admin.booking') }}"   class="{{ request()->routeIs('admin.booking*') ? 'active' : '' }}">&#128203; Booking</a>
            <a href="{{ route('admin.service') }}"   class="{{ request()->routeIs('admin.service*') ? 'active' : '' }}">&#128295; Jenis Service</a>
            <a href="{{ route('admin.barang') }}"    class="{{ request()->routeIs('admin.barang*') ? 'active' : '' }}">&#128230; Barang</a>
            <a href="{{ route('admin.pelanggan') }}" class="{{ request()->routeIs('admin.pelanggan*') ? 'active' : '' }}">&#128100; Pelanggan</a>
            <a href="{{ route('admin.mekanik') }}"   class="{{ request()->routeIs('admin.mekanik*') ? 'active' : '' }}">&#128736; Mekanik</a>
            <a href="{{ route('admin.transaksi') }}" class="{{ request()->routeIs('admin.transaksi*') ? 'active' : '' }}">&#128176; Transaksi</a>
        @elseif(Auth::user()->isMekanik())
            <div class="menu-label">Mekanik</div>
            <a href="{{ route('mekanik.dashboard') }}" class="{{ request()->routeIs('mekanik.dashboard') ? 'active' : '' }}">&#127968; Dashboard</a>
            <a href="{{ route('mekanik.service') }}"   class="{{ request()->routeIs('mekanik.service*') ? 'active' : '' }}">&#128295; Daftar Service</a>
        @else
            <div class="menu-label">User</div>
            <a href="{{ route('user.dashboard') }}"      class="{{ request()->routeIs('user.dashboard') ? 'active' : '' }}">&#127968; Dashboard</a>
            <a href="{{ route('user.jasa') }}"           class="{{ request()->routeIs('user.jasa') ? 'active' : '' }}">&#128295; Menu Jasa</a>
            <a href="{{ route('user.booking') }}"        class="{{ request()->routeIs('user.booking') ? 'active' : '' }}">&#128203; Pesanan Saya</a>
            <a href="{{ route('user.booking.create') }}" class="{{ request()->routeIs('user.booking.create') ? 'active' : '' }}">&#43; Booking Baru</a>
        @endif
    </aside>

    <main class="main">
        @if(session('success'))
            <div class="alert alert-success">&#10003; {{ session('success') }}</div>
        @endif
        @if($errors->any())
            <div class="alert alert-danger">
                @foreach($errors->all() as $e) &#9888; {{ $e }}<br> @endforeach
            </div>
        @endif
        <div class="fade-in">
            @yield('content')
        </div>
    </main>
</div>

<script>
    window.addEventListener('load', () => {
        setTimeout(() => document.getElementById('page-loader').classList.add('hide'), 600);
    });

    document.addEventListener('DOMContentLoaded', () => {
        setTimeout(() => {
            document.querySelectorAll('.fade-in').forEach(el => el.classList.add('visible'));
        }, 650);

        // Hamburger toggle
    const hamburger = document.getElementById('hamburger');
    const sidebar    = document.querySelector('.sidebar');
    const overlay    = document.getElementById('sidebarOverlay');
    if (hamburger) {
        hamburger.addEventListener('click', () => {
            sidebar.classList.toggle('open');
            overlay.classList.toggle('open');
        });
        overlay.addEventListener('click', () => {
            sidebar.classList.remove('open');
            overlay.classList.remove('open');
        });
    }

    // Wrap tables for horizontal scroll on mobile
    document.querySelectorAll('table').forEach(t => {
        if (!t.closest('.table-wrap')) {
            const wrap = document.createElement('div');
            wrap.classList.add('table-wrap');
            t.parentNode.insertBefore(wrap, t);
            wrap.appendChild(t);
        }
    });
        document.querySelectorAll('.stat-num').forEach(el => {
            const target = parseInt(el.innerText.replace(/[^0-9]/g, ''));
            if (isNaN(target) || target === 0) return;
            let current = 0;
            const step = Math.ceil(target / 50);
            const timer = setInterval(() => {
                current = Math.min(current + step, target);
                el.innerText = current.toLocaleString('id-ID');
                if (current >= target) clearInterval(timer);
            }, 25);
        });

        // Ripple effect
        document.querySelectorAll('.btn').forEach(btn => {
            btn.addEventListener('click', function(e) {
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
        });
    });

    function openModal(id) {
        const el = document.getElementById(id);
        el.style.display = 'flex';
        requestAnimationFrame(() => el.classList.add('open'));
    }
    function closeModal(id) {
        const el = document.getElementById(id);
        el.classList.remove('open');
        setTimeout(() => { el.style.display = 'none'; }, 350);
    }
    document.addEventListener('click', e => {
        if (e.target.classList.contains('modal-overlay')) {
            e.target.classList.remove('open');
            setTimeout(() => { e.target.style.display = 'none'; }, 350);
        }
    });
</script>
</body>
</html>
