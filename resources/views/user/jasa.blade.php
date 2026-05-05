@extends('layouts.main')
@section('title', 'Menu Jasa')
@section('content')

@php
$serviceImages = [
    'Ganti Oli Mesin'  => 'https://images.unsplash.com/photo-1609630875171-b1321377ee65?w=800&q=80',
    'Tune Up Ringan'   => 'https://images.unsplash.com/photo-1486262715619-67b85e0b08d3?w=800&q=80',
    'Servis Rem'       => 'https://images.unsplash.com/photo-1558618666-fcd25c85cd64?w=800&q=80',
    'Ganti Ban'        => 'https://images.unsplash.com/photo-1580273916550-e323be2ae537?w=800&q=80',
    'Servis AC'        => 'https://images.unsplash.com/photo-1621905251189-08b45d6a269e?w=800&q=80',
    'Tune Up Besar'    => 'https://images.unsplash.com/photo-1530046339160-ce3e530c7d2f?w=800&q=80',
    'Service CVT'      => 'https://images.unsplash.com/photo-1568772585407-9361f9bf3a87?w=800&q=80',
];
$defaultImg = 'https://images.unsplash.com/photo-1486262715619-67b85e0b08d3?w=800&q=80';
@endphp

<!-- HERO -->
<div style="
    background: url('https://images.unsplash.com/photo-1530046339160-ce3e530c7d2f?w=1400&q=80') center/cover;
    border-radius: 20px; padding: 52px 40px; margin-bottom: 32px;
    position: relative; overflow: hidden;
    box-shadow: 0 8px 32px rgba(0,0,0,0.25);
" class="hero-pad">
    <div style="position:absolute;inset:0;background:linear-gradient(135deg,rgba(10,25,50,0.88) 0%,rgba(26,60,110,0.7) 100%);border-radius:20px;"></div>
    <div style="position:relative;z-index:1;color:white;max-width:560px;">
        <div style="font-size:0.85rem;letter-spacing:3px;text-transform:uppercase;opacity:0.7;margin-bottom:8px;">Bengkel Service</div>
        <h2 style="font-size:2.2rem;font-weight:900;margin-bottom:12px;line-height:1.2;" class="hero-title">
            Layanan Terbaik<br>untuk Kendaraan Anda &#128663;
        </h2>
        <p style="opacity:0.8;font-size:1rem;margin-bottom:24px;line-height:1.6;">
            Kami menyediakan berbagai layanan servis kendaraan dengan teknisi berpengalaman dan peralatan modern.
        </p>
        <a href="{{ route('user.booking.create') }}" class="btn btn-warning" style="font-size:1rem;padding:13px 30px;">
            &#128295; Booking Sekarang
        </a>
    </div>
</div>

<!-- STATS BAR -->
<div style="display:grid;grid-template-columns:repeat(3,1fr);gap:16px;margin-bottom:32px;" class="stats-bar">
    <div class="stat-card" style="border-top-color:#f9c74f;">
        <div class="stat-num" style="color:#f9c74f;font-size:1.8rem;">{{ $services->count() }}</div>
        <div class="stat-label">Jenis Layanan</div>
    </div>
    <div class="stat-card" style="border-top-color:#198754;">
        <div class="stat-num" style="color:#198754;font-size:1.8rem;">3+</div>
        <div class="stat-label">Mekanik Berpengalaman</div>
    </div>
    <div class="stat-card" style="border-top-color:#2563b0;">
        <div class="stat-num" style="color:#2563b0;font-size:1.8rem;">1 Jam</div>
        <div class="stat-label">Estimasi Tercepat</div>
    </div>
</div>

<!-- JUDUL SECTION -->
<div style="color:white;font-size:1.3rem;font-weight:800;margin-bottom:20px;display:flex;align-items:center;gap:10px;">
    <span style="background:rgba(249,199,79,0.2);border:1.5px solid rgba(249,199,79,0.4);padding:4px 14px;border-radius:20px;font-size:0.85rem;color:#f9c74f;">SEMUA LAYANAN</span>
</div>

<!-- GRID JASA -->
<div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(280px,1fr));gap:22px;margin-bottom:32px;" class="jasa-grid">
    @foreach($services as $s)
    @php $img = $serviceImages[$s->nama_service] ?? $defaultImg; @endphp
    <div class="jasa-card" style="
        border-radius:18px; overflow:hidden;
        background:rgba(255,255,255,0.92);
        backdrop-filter:blur(16px);
        box-shadow:0 4px 20px rgba(0,0,0,0.12);
        border:1px solid rgba(255,255,255,0.3);
        transition:all 0.35s cubic-bezier(0.4,0,0.2,1);
    ">
        <!-- Foto -->
        <div style="height:180px;overflow:hidden;position:relative;">
            <img src="{{ $img }}" alt="{{ $s->nama_service }}"
                 class="jasa-img"
                 style="width:100%;height:100%;object-fit:cover;transition:transform 0.5s ease;">
            <div style="position:absolute;inset:0;background:linear-gradient(to top,rgba(26,60,110,0.75) 0%,transparent 55%);"></div>
            <!-- Badge estimasi -->
            <div style="position:absolute;top:12px;right:12px;background:rgba(249,199,79,0.95);color:#1a3c6e;padding:4px 12px;border-radius:20px;font-size:0.75rem;font-weight:800;">
                &#128336; {{ $s->estimasi_jam }} jam
            </div>
            <!-- Nama di foto -->
            <div style="position:absolute;bottom:14px;left:16px;color:white;font-weight:800;font-size:1.05rem;text-shadow:0 2px 6px rgba(0,0,0,0.4);">
                {{ $s->nama_service }}
            </div>
        </div>

        <!-- Konten -->
        <div style="padding:18px;">
            <p style="font-size:0.88rem;color:#555;line-height:1.6;margin-bottom:16px;min-height:42px;">
                {{ $s->deskripsi ?? 'Layanan servis profesional oleh teknisi berpengalaman.' }}
            </p>

            <!-- Fitur -->
            <div style="display:flex;flex-wrap:wrap;gap:6px;margin-bottom:16px;">
                <span style="background:#f0f4f8;color:#1a3c6e;padding:3px 10px;border-radius:10px;font-size:0.75rem;font-weight:600;">&#10003; Bergaransi</span>
                <span style="background:#f0f4f8;color:#1a3c6e;padding:3px 10px;border-radius:10px;font-size:0.75rem;font-weight:600;">&#10003; Teknisi Ahli</span>
                <span style="background:#f0f4f8;color:#1a3c6e;padding:3px 10px;border-radius:10px;font-size:0.75rem;font-weight:600;">&#10003; Spare Part Asli</span>
            </div>

            <!-- Harga & Tombol -->
            <div style="display:flex;align-items:center;justify-content:space-between;">
                <div>
                    <div style="font-size:0.75rem;color:#888;">Mulai dari</div>
                    <div style="font-size:1.3rem;font-weight:900;color:#198754;">
                        Rp {{ number_format($s->harga,0,',','.') }}
                    </div>
                </div>
                <a href="{{ route('user.booking.create') }}?service={{ $s->id }}"
                   class="btn btn-primary btn-sm"
                   style="padding:9px 18px;font-size:0.85rem;">
                    Booking &#8594;
                </a>
            </div>
        </div>
    </div>
    @endforeach
</div>

<!-- INFO TAMBAHAN dihapus -->

<style>
.jasa-card:hover { transform: translateY(-8px); box-shadow: 0 16px 48px rgba(0,0,0,0.18) !important; }
.jasa-card:hover .jasa-img { transform: scale(1.08); }

@media (max-width: 768px) {
    .jasa-grid { grid-template-columns: 1fr !important; }
    .sert-grid { grid-template-columns: 1fr 1fr !important; }
    .stats-bar  { grid-template-columns: 1fr !important; }
    .hero-pad   { padding: 28px 20px !important; }
    .hero-title { font-size: 1.4rem !important; }
    .cta-banner { flex-direction: column !important; text-align: center; }
}
@media (max-width: 480px) {
    .sert-grid { grid-template-columns: 1fr !important; }
}
</style>

<!-- ══════════════════════════════════════════════════════ -->
<!-- SECTION SERTIFIKAT & PENGHARGAAN                      -->
<!-- ══════════════════════════════════════════════════════ -->
<div style="margin-top:40px;">

    <!-- Judul -->
    <div style="text-align:center;margin-bottom:28px;">
        <span style="background:rgba(249,199,79,0.2);border:1.5px solid rgba(249,199,79,0.4);padding:4px 16px;border-radius:20px;font-size:0.85rem;color:#f9c74f;font-weight:700;letter-spacing:2px;">SERTIFIKAT & PENGHARGAAN</span>
        <div style="color:white;font-size:1.6rem;font-weight:900;margin-top:12px;">Bengkel Kami Telah Tersertifikasi &#127942;</div>
        <div style="color:rgba(255,255,255,0.6);font-size:0.9rem;margin-top:6px;">Dipercaya oleh ratusan pelanggan dengan standar kualitas terjamin</div>
    </div>

    <!-- Grid Sertifikat -->
    <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(260px,1fr));gap:20px;margin-bottom:32px;" class="sert-grid">

        @php
        $sertifikats = [
            [
                'img'   => 'https://images.unsplash.com/photo-1589829545856-d10d557cf95f?w=600&q=80',
                'judul' => 'Sertifikat Kompetensi Mekanik',
                'lembaga' => 'BNSP Indonesia',
                'tahun'   => '2023',
                'warna'   => '#f9c74f',
            ],
            [
                'img'   => 'https://images.unsplash.com/photo-1554224155-6726b3ff858f?w=600&q=80',
                'judul' => 'ISO 9001:2015 Quality Management',
                'lembaga' => 'Badan Sertifikasi Nasional',
                'tahun'   => '2022',
                'warna'   => '#4ade80',
            ],
            [
                'img'   => 'https://images.unsplash.com/photo-1567427017947-545c5f8d16ad?w=600&q=80',
                'judul' => 'Bengkel Terpercaya Pilihan Konsumen',
                'lembaga' => 'Yayasan Konsumen Indonesia',
                'tahun'   => '2024',
                'warna'   => '#60a5fa',
            ],
            [
                'img'   => 'https://images.unsplash.com/photo-1521791136064-7986c2920216?w=600&q=80',
                'judul' => 'Penghargaan Pelayanan Terbaik',
                'lembaga' => 'Asosiasi Bengkel Indonesia',
                'tahun'   => '2024',
                'warna'   => '#f472b6',
            ],
        ];
        @endphp

        @foreach($sertifikats as $s)
        <div style="
            border-radius:18px; overflow:hidden;
            background:rgba(255,255,255,0.9);
            backdrop-filter:blur(16px);
            box-shadow:0 4px 20px rgba(0,0,0,0.12);
            border:1px solid rgba(255,255,255,0.3);
            transition:all 0.35s cubic-bezier(0.4,0,0.2,1);
            position:relative;
        " class="sert-card">
            <!-- Foto -->
            <div style="height:160px;overflow:hidden;position:relative;">
                <img src="{{ $s['img'] }}" alt="{{ $s['judul'] }}"
                     class="sert-img"
                     style="width:100%;height:100%;object-fit:cover;transition:transform 0.5s ease;filter:brightness(0.85);">
                <!-- Overlay gradient -->
                <div style="position:absolute;inset:0;background:linear-gradient(to top,rgba(10,25,50,0.85) 0%,transparent 50%);"></div>
                <!-- Badge tahun -->
                <div style="position:absolute;top:12px;left:12px;background:{{ $s['warna'] }};color:#1a3c6e;padding:3px 12px;border-radius:20px;font-size:0.75rem;font-weight:800;">
                    {{ $s['tahun'] }}
                </div>
                <!-- Icon sertifikat -->
                <div style="position:absolute;top:10px;right:12px;font-size:1.8rem;filter:drop-shadow(0 2px 4px rgba(0,0,0,0.3));">&#127942;</div>
                <!-- Lembaga di foto -->
                <div style="position:absolute;bottom:12px;left:14px;color:rgba(255,255,255,0.8);font-size:0.78rem;font-weight:600;">
                    {{ $s['lembaga'] }}
                </div>
            </div>
            <!-- Konten -->
            <div style="padding:16px 18px;">
                <div style="font-weight:800;color:#1a3c6e;font-size:0.95rem;line-height:1.4;margin-bottom:10px;">
                    {{ $s['judul'] }}
                </div>
                <div style="display:flex;align-items:center;gap:8px;">
                    <div style="width:28px;height:4px;border-radius:2px;background:{{ $s['warna'] }};"></div>
                    <span style="font-size:0.78rem;color:#888;">Terverifikasi & Aktif</span>
                    <span style="margin-left:auto;font-size:1rem;">&#9989;</span>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Banner kepercayaan -->
    <div style="
        background: linear-gradient(135deg, rgba(26,60,110,0.85) 0%, rgba(37,99,176,0.75) 100%);
        backdrop-filter: blur(16px);
        border: 1px solid rgba(255,255,255,0.15);
        border-radius: 18px;
        padding: 32px 36px;
        display: flex; align-items: center; justify-content: space-between;
        flex-wrap: wrap; gap: 20px;
        box-shadow: 0 8px 32px rgba(0,0,0,0.15);
    " class="cta-banner">
        <div>
            <div style="color:white;font-size:1.4rem;font-weight:900;margin-bottom:6px;">
                Siap Melayani Kendaraan Anda &#128293;
            </div>
            <div style="color:rgba(255,255,255,0.7);font-size:0.92rem;">
                Booking sekarang dan rasakan perbedaan layanan kami yang profesional.
            </div>
        </div>
        <a href="{{ route('user.booking.create') }}" class="btn btn-warning" style="font-size:1rem;padding:13px 32px;white-space:nowrap;">
            &#128295; Booking Sekarang
        </a>
    </div>

</div>

<style>
.sert-card:hover { transform: translateY(-6px); box-shadow: 0 16px 40px rgba(0,0,0,0.2) !important; }
.sert-card:hover .sert-img { transform: scale(1.06); filter: brightness(1) !important; }
</style>
@endsection
