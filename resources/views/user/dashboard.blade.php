@extends('layouts.main')
@section('title', 'Dashboard')
@section('content')

<!-- HERO BANNER -->
<div style="
    background: url('https://images.unsplash.com/photo-1558618666-fcd25c85cd64?w=1200&q=80') center/cover;
    border-radius: 20px; padding: 48px 40px; margin-bottom: 28px; position: relative; overflow: hidden;
    box-shadow: 0 8px 32px rgba(0,0,0,0.2);
">
    <div style="position:absolute;inset:0;background:linear-gradient(135deg,rgba(26,60,110,0.85) 0%,rgba(15,39,68,0.7) 100%);border-radius:20px;"></div>
    <div style="position:relative;z-index:1;color:white;">
        <div style="font-size:0.9rem;opacity:0.8;margin-bottom:6px;letter-spacing:2px;text-transform:uppercase;">Selamat datang</div>
        <div style="font-size:2rem;font-weight:800;margin-bottom:8px;">{{ Auth::user()->name }} 👋</div>
        <div style="font-size:1rem;opacity:0.85;margin-bottom:24px;">Booking service kendaraan Anda dengan mudah dan cepat.</div>
        <a href="{{ route('user.booking.create') }}" class="btn btn-warning" style="font-size:1rem;padding:12px 28px;">
            &#128295; Booking Sekarang
        </a>
    </div>
</div>

<!-- STAT CARDS -->
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-num">{{ Auth::user()->bookings()->count() }}</div>
        <div class="stat-label">Total Booking</div>
    </div>
    <div class="stat-card" style="border-top-color:#f9c74f;">
        <div class="stat-num" style="color:#856404;">{{ Auth::user()->bookings()->where('status','menunggu')->count() }}</div>
        <div class="stat-label">Menunggu</div>
    </div>
    <div class="stat-card" style="border-top-color:#2563b0;">
        <div class="stat-num" style="color:#2563b0;">{{ Auth::user()->bookings()->where('status','diproses')->count() }}</div>
        <div class="stat-label">Diproses</div>
    </div>
    <div class="stat-card" style="border-top-color:#198754;">
        <div class="stat-num" style="color:#198754;">{{ Auth::user()->bookings()->where('status','selesai')->count() }}</div>
        <div class="stat-label">Selesai</div>
    </div>
</div>

<!-- FOTO LAYANAN -->
<div style="display:grid;grid-template-columns:repeat(3,1fr);gap:18px;margin-bottom:28px;">
    <div style="border-radius:14px;overflow:hidden;box-shadow:0 4px 16px rgba(0,0,0,0.12);position:relative;height:160px;">
        <img src="https://images.unsplash.com/photo-1486262715619-67b85e0b08d3?w=600&q=80"
             alt="Servis Mesin" style="width:100%;height:100%;object-fit:cover;">
        <div style="position:absolute;inset:0;background:linear-gradient(to top,rgba(26,60,110,0.8) 0%,transparent 60%);"></div>
        <div style="position:absolute;bottom:14px;left:14px;color:white;font-weight:700;font-size:0.95rem;">&#128295; Servis Mesin</div>
    </div>
    <div style="border-radius:14px;overflow:hidden;box-shadow:0 4px 16px rgba(0,0,0,0.12);position:relative;height:160px;">
        <img src="https://images.unsplash.com/photo-1609630875171-b1321377ee65?w=600&q=80"
             alt="Ganti Oli" style="width:100%;height:100%;object-fit:cover;">
        <div style="position:absolute;inset:0;background:linear-gradient(to top,rgba(26,60,110,0.8) 0%,transparent 60%);"></div>
        <div style="position:absolute;bottom:14px;left:14px;color:white;font-weight:700;font-size:0.95rem;">&#128167; Ganti Oli</div>
    </div>
    <div style="border-radius:14px;overflow:hidden;box-shadow:0 4px 16px rgba(0,0,0,0.12);position:relative;height:160px;">
        <img src="https://images.unsplash.com/photo-1558618666-fcd25c85cd64?w=600&q=80"
             alt="CVT & Transmisi" style="width:100%;height:100%;object-fit:cover;">
        <div style="position:absolute;inset:0;background:linear-gradient(to top,rgba(26,60,110,0.8) 0%,transparent 60%);"></div>
        <div style="position:absolute;bottom:14px;left:14px;color:white;font-weight:700;font-size:0.95rem;">&#9881; CVT & Transmisi</div>
    </div>
</div>

<!-- BOOKING TERBARU -->
<div class="card">
    <div class="card-title">&#128203; Booking Terbaru</div>
    @if($bookings->isEmpty())
        <div style="text-align:center;padding:32px 0;">
            <div style="font-size:3rem;margin-bottom:12px;">&#128663;</div>
            <p style="color:#888;font-size:0.95rem;">Belum ada booking.</p>
            <a href="{{ route('user.booking.create') }}" class="btn btn-primary" style="margin-top:14px;">Buat Booking Pertama</a>
        </div>
    @else
        <table>
            <thead><tr><th>No. Antrian</th><th>Service</th><th>Tanggal</th><th>Kendaraan</th><th>Status</th><th>Aksi</th></tr></thead>
            <tbody>
            @foreach($bookings as $b)
            <tr>
                <td><strong>{{ $b->nomor_antrian }}</strong></td>
                <td>{{ $b->service->nama_service }}</td>
                <td>{{ $b->tanggal_booking->format('d/m/Y') }}</td>
                <td>{{ $b->kendaraan }} ({{ $b->plat_nomor }})</td>
                <td><span class="badge badge-{{ $b->status }}">{{ ucfirst($b->status) }}</span></td>
                <td><a href="{{ route('user.booking.show', $b) }}" class="btn btn-primary btn-sm">Detail</a></td>
            </tr>
            @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
