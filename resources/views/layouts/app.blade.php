<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Bengkel Service' }}</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Segoe UI', Arial, sans-serif; background: #f0f4f8; color: #333; }

        /* NAVBAR */
        .navbar {
            background: #1a3c6e;
            color: white;
            padding: 0 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            height: 56px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.2);
        }
        .navbar-brand { font-size: 1.2rem; font-weight: 700; letter-spacing: 1px; }
        .navbar-brand span { color: #f9c74f; }
        .navbar-user { display: flex; align-items: center; gap: 12px; font-size: 0.9rem; }
        .navbar-user .badge-role {
            background: #f9c74f; color: #1a3c6e;
            padding: 2px 10px; border-radius: 12px;
            font-weight: 700; font-size: 0.75rem; text-transform: uppercase;
        }
        .btn-logout {
            background: #e63946; color: white; border: none;
            padding: 5px 14px; border-radius: 4px; cursor: pointer; font-size: 0.85rem;
        }
        .btn-logout:hover { background: #c1121f; }

        /* SIDEBAR */
        .layout { display: flex; min-height: calc(100vh - 56px); }
        .sidebar {
            width: 220px; background: #1e4d8c; color: white;
            padding: 20px 0; flex-shrink: 0;
        }
        .sidebar a {
            display: block; padding: 10px 24px; color: #cce0ff;
            text-decoration: none; font-size: 0.9rem; transition: background 0.2s;
        }
        .sidebar a:hover, .sidebar a.active { background: #2563b0; color: white; }
        .sidebar .menu-label {
            padding: 14px 24px 6px; font-size: 0.7rem;
            text-transform: uppercase; color: #7fb3e8; letter-spacing: 1px;
        }

        /* MAIN */
        .main { flex: 1; padding: 24px; }
        .page-title { font-size: 1.4rem; font-weight: 700; color: #1a3c6e; margin-bottom: 20px; border-bottom: 3px solid #f9c74f; padding-bottom: 8px; display: inline-block; }

        /* CARD */
        .card { background: white; border-radius: 8px; box-shadow: 0 1px 4px rgba(0,0,0,0.1); padding: 20px; margin-bottom: 20px; }
        .card-title { font-size: 1rem; font-weight: 700; color: #1a3c6e; margin-bottom: 14px; }

        /* STAT CARDS */
        .stats-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(160px, 1fr)); gap: 16px; margin-bottom: 24px; }
        .stat-card { background: white; border-radius: 8px; padding: 16px; text-align: center; box-shadow: 0 1px 4px rgba(0,0,0,0.1); border-top: 4px solid #1a3c6e; }
        .stat-card .stat-num { font-size: 2rem; font-weight: 700; color: #1a3c6e; }
        .stat-card .stat-label { font-size: 0.8rem; color: #666; margin-top: 4px; }

        /* TABLE */
        table { width: 100%; border-collapse: collapse; font-size: 0.88rem; }
        th { background: #1a3c6e; color: white; padding: 10px 12px; text-align: left; }
        td { padding: 9px 12px; border-bottom: 1px solid #e8edf3; }
        tr:hover td { background: #f5f8ff; }

        /* BADGE STATUS */
        .badge { padding: 3px 10px; border-radius: 12px; font-size: 0.75rem; font-weight: 600; }
        .badge-menunggu  { background: #fff3cd; color: #856404; }
        .badge-diproses  { background: #cfe2ff; color: #084298; }
        .badge-selesai   { background: #d1e7dd; color: #0a3622; }
        .badge-dibatalkan{ background: #f8d7da; color: #842029; }
        .badge-lunas     { background: #d1e7dd; color: #0a3622; }
        .badge-belum     { background: #fff3cd; color: #856404; }

        /* FORM */
        .form-group { margin-bottom: 14px; }
        .form-group label { display: block; font-size: 0.85rem; font-weight: 600; color: #1a3c6e; margin-bottom: 4px; }
        .form-control {
            width: 100%; padding: 8px 12px; border: 1px solid #c8d6e5;
            border-radius: 4px; font-size: 0.9rem; outline: none;
        }
        .form-control:focus { border-color: #1a3c6e; box-shadow: 0 0 0 2px rgba(26,60,110,0.15); }
        .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; }

        /* BUTTONS */
        .btn { padding: 8px 18px; border-radius: 4px; border: none; cursor: pointer; font-size: 0.88rem; font-weight: 600; text-decoration: none; display: inline-block; }
        .btn-primary   { background: #1a3c6e; color: white; }
        .btn-primary:hover { background: #2563b0; }
        .btn-success   { background: #198754; color: white; }
        .btn-success:hover { background: #146c43; }
        .btn-warning   { background: #f9c74f; color: #1a3c6e; }
        .btn-warning:hover { background: #e9b800; }
        .btn-danger    { background: #e63946; color: white; }
        .btn-danger:hover { background: #c1121f; }
        .btn-sm { padding: 4px 12px; font-size: 0.8rem; }

        /* ALERT */
        .alert { padding: 10px 16px; border-radius: 4px; margin-bottom: 16px; font-size: 0.9rem; }
        .alert-success { background: #d1e7dd; color: #0a3622; border-left: 4px solid #198754; }
        .alert-danger  { background: #f8d7da; color: #842029; border-left: 4px solid #e63946; }

        /* MODAL */
        .modal-overlay { display:none; position:fixed; inset:0; background:rgba(0,0,0,0.5); z-index:1000; align-items:center; justify-content:center; }
        .modal-overlay.open { display:flex; }
        .modal-box { background:white; border-radius:8px; padding:24px; width:100%; max-width:480px; }
        .modal-title { font-size:1.1rem; font-weight:700; color:#1a3c6e; margin-bottom:16px; }
        .modal-close { float:right; cursor:pointer; font-size:1.2rem; color:#666; background:none; border:none; }
    </style>
</head>
<body>
<nav class="navbar">
    <div class="navbar-brand">&#9881; Bengkel <span>Service</span></div>
    <div class="navbar-user">
        <span>{{ Auth::user()->name }}</span>
        <span class="badge-role">{{ Auth::user()->role }}</span>
        <form method="POST" action="{{ route('logout') }}" style="display:inline">
            @csrf
            <button type="submit" class="btn-logout">Keluar</button>
        </form>
    </div>
</nav>
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
            <a href="{{ route('user.booking') }}"        class="{{ request()->routeIs('user.booking') ? 'active' : '' }}">&#128203; Pesanan Saya</a>
            <a href="{{ route('user.booking.create') }}" class="{{ request()->routeIs('user.booking.create') ? 'active' : '' }}">&#43; Booking Baru</a>
        @endif
    </aside>
    <main class="main">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if($errors->any())
            <div class="alert alert-danger">
                @foreach($errors->all() as $e) {{ $e }}<br> @endforeach
            </div>
        @endif
        {{ $slot }}
    </main>
</div>
<script>
function openModal(id) { document.getElementById(id).classList.add('open'); }
function closeModal(id) { document.getElementById(id).classList.remove('open'); }
</script>
</body>
</html>
