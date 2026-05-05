@extends('layouts.main')
@section('title', 'Booking Baru')
@section('content')
<div class="page-title">Booking Service Baru</div>

<form method="POST" action="{{ route('user.booking.store') }}" id="bookingForm">
    @csrf
    <!-- hidden input yang akan diisi JS saat pilih kartu -->
    <input type="hidden" name="service_id" id="service_id" value="{{ old('service_id') }}">

    <!-- STEP 1: PILIH SERVICE -->
    <div style="margin-bottom:28px;">
        <div style="color:white;font-size:1.1rem;font-weight:700;margin-bottom:16px;opacity:0.9;">
            &#49;&#65039;&#8419; Pilih Jenis Service
        </div>

        @php
        $serviceImages = [
            'Ganti Oli Mesin'  => 'https://images.unsplash.com/photo-1609630875171-b1321377ee65?w=600&q=80',
            'Tune Up Ringan'   => 'https://images.unsplash.com/photo-1486262715619-67b85e0b08d3?w=600&q=80',
            'Servis Rem'       => 'https://images.unsplash.com/photo-1558618666-fcd25c85cd64?w=600&q=80',
            'Ganti Ban'        => 'https://images.unsplash.com/photo-1580273916550-e323be2ae537?w=600&q=80',
            'Servis AC'        => 'https://images.unsplash.com/photo-1621905251189-08b45d6a269e?w=600&q=80',
            'Tune Up Besar'    => 'https://images.unsplash.com/photo-1530046339160-ce3e530c7d2f?w=600&q=80',
            'Service CVT'      => 'https://images.unsplash.com/photo-1568772585407-9361f9bf3a87?w=600&q=80',
        ];
        $defaultImg = 'https://images.unsplash.com/photo-1486262715619-67b85e0b08d3?w=600&q=80';
        @endphp

        <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(200px,1fr));gap:16px;">
            @foreach($services as $s)
            @php $img = $serviceImages[$s->nama_service] ?? $defaultImg; @endphp
            <div class="service-card" data-id="{{ $s->id }}" onclick="pilihService(this)"
                 style="
                    border-radius:16px; overflow:hidden; cursor:pointer;
                    border: 2.5px solid transparent;
                    box-shadow: 0 4px 16px rgba(0,0,0,0.15);
                    transition: all 0.3s cubic-bezier(0.4,0,0.2,1);
                    background: rgba(255,255,255,0.9);
                    backdrop-filter: blur(12px);
                 ">
                <!-- Foto -->
                <div style="height:130px;overflow:hidden;position:relative;">
                    <img src="{{ $img }}" alt="{{ $s->nama_service }}"
                         style="width:100%;height:100%;object-fit:cover;transition:transform 0.4s ease;">
                    <div style="position:absolute;inset:0;background:linear-gradient(to top,rgba(26,60,110,0.6) 0%,transparent 60%);"></div>
                </div>
                <!-- Info -->
                <div style="padding:14px;">
                    <div style="font-weight:800;font-size:0.95rem;color:#1a3c6e;margin-bottom:4px;">{{ $s->nama_service }}</div>
                    <div style="font-size:0.8rem;color:#555;margin-bottom:8px;">{{ $s->deskripsi ?? 'Layanan profesional bengkel' }}</div>
                    <div style="display:flex;justify-content:space-between;align-items:center;">
                        <span style="font-weight:800;color:#198754;font-size:0.95rem;">Rp {{ number_format($s->harga,0,',','.') }}</span>
                        <span style="font-size:0.75rem;color:#888;background:#f0f4f8;padding:2px 8px;border-radius:10px;">&#128336; {{ $s->estimasi_jam }} jam</span>
                    </div>
                </div>
                <!-- Checkmark -->
                <div class="check-mark" style="
                    display:none; position:absolute; top:10px; right:10px;
                    background:#f9c74f; color:#1a3c6e; border-radius:50%;
                    width:28px;height:28px;align-items:center;justify-content:center;
                    font-weight:900;font-size:1rem;box-shadow:0 2px 8px rgba(249,199,79,0.5);
                ">&#10003;</div>
            </div>
            @endforeach
        </div>

        <!-- Pesan pilihan -->
        <div id="pesan-service" style="
            margin-top:16px; padding:14px 18px; border-radius:12px;
            background:rgba(249,199,79,0.15); border:1.5px solid rgba(249,199,79,0.4);
            color:white; font-size:0.9rem; display:none;
            animation: slideDown 0.3s ease;
        ">
            &#10003; Anda memilih: <strong id="nama-service-terpilih"></strong> &mdash;
            <span id="harga-service-terpilih" style="color:#f9c74f;font-weight:700;"></span>
        </div>
        @keyframes slideDown { from{opacity:0;transform:translateY(-8px)} to{opacity:1;transform:translateY(0)} }
    </div>

    <!-- STEP 2: DETAIL KENDARAAN -->
    <div style="color:white;font-size:1.1rem;font-weight:700;margin-bottom:16px;opacity:0.9;">
        &#50;&#65039;&#8419; Detail Kendaraan & Jadwal
    </div>
    <div class="card" style="max-width:640px;">
        <div class="form-row">
            <div class="form-group">
                <label>Tanggal Booking</label>
                <input type="date" name="tanggal_booking" class="form-control"
                       value="{{ old('tanggal_booking', date('Y-m-d')) }}"
                       min="{{ date('Y-m-d') }}" required>
            </div>
            <div class="form-group">
                <label>Plat Nomor</label>
                <input type="text" name="plat_nomor" class="form-control"
                       value="{{ old('plat_nomor') }}" placeholder="B 1234 ABC" required>
            </div>
        </div>
        <div class="form-group">
            <label>Jenis Kendaraan</label>
            <input type="text" name="kendaraan" class="form-control"
                   value="{{ old('kendaraan') }}" placeholder="Contoh: Honda Beat 2022" required>
        </div>
        <div class="form-group">
            <label>Keluhan / Keterangan</label>
            <textarea name="keluhan" class="form-control" rows="3"
                      placeholder="Ceritakan keluhan kendaraan Anda...">{{ old('keluhan') }}</textarea>
        </div>
        <div style="display:flex;gap:12px;margin-top:4px;">
            <button type="submit" class="btn btn-primary" id="btnSubmit" disabled
                    style="opacity:0.5;cursor:not-allowed;">
                &#128295; Buat Booking
            </button>
            <a href="{{ route('user.booking') }}" class="btn btn-warning">Batal</a>
        </div>
        <div id="warn-service" style="margin-top:10px;font-size:0.82rem;color:#f9c74f;display:none;">
            &#9888; Pilih jenis service terlebih dahulu di atas.
        </div>
    </div>
</form>

<style>
.service-card { position: relative; }
.service-card:hover { transform: translateY(-6px) scale(1.02); box-shadow: 0 12px 32px rgba(0,0,0,0.2) !important; }
.service-card:hover img { transform: scale(1.08); }
.service-card.selected {
    border-color: #f9c74f !important;
    box-shadow: 0 0 0 4px rgba(249,199,79,0.3), 0 12px 32px rgba(0,0,0,0.2) !important;
}
.service-card.selected .check-mark { display: flex !important; }
</style>

<script>
const serviceData = {
    @foreach($services as $s)
    {{ $s->id }}: { nama: "{{ $s->nama_service }}", harga: "Rp {{ number_format($s->harga,0,',','.') }}" },
    @endforeach
};

function pilihService(el) {
    // reset semua
    document.querySelectorAll('.service-card').forEach(c => c.classList.remove('selected'));
    // pilih yang diklik
    el.classList.add('selected');
    const id = el.dataset.id;
    document.getElementById('service_id').value = id;

    // tampilkan pesan
    const pesan = document.getElementById('pesan-service');
    pesan.style.display = 'block';
    document.getElementById('nama-service-terpilih').innerText = serviceData[id].nama;
    document.getElementById('harga-service-terpilih').innerText = serviceData[id].harga;

    // aktifkan tombol submit
    const btn = document.getElementById('btnSubmit');
    btn.disabled = false;
    btn.style.opacity = '1';
    btn.style.cursor = 'pointer';
    document.getElementById('warn-service').style.display = 'none';
}

// Cegah submit kalau belum pilih service
document.getElementById('bookingForm').addEventListener('submit', function(e) {
    if (!document.getElementById('service_id').value) {
        e.preventDefault();
        document.getElementById('warn-service').style.display = 'block';
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }
});

// Restore pilihan kalau ada old value (validasi gagal)
const oldId = "{{ old('service_id') }}";
if (oldId) {
    const card = document.querySelector(`.service-card[data-id="${oldId}"]`);
    if (card) pilihService(card);
}
</script>
@endsection
