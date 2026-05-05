@extends('layouts.main')
@section('title', 'Detail Booking')
@section('content')
<div class="page-title">Detail Booking</div>
<div class="card" style="max-width:600px;">
    <div style="text-align:center;padding:16px 0 24px;">
        <div style="font-size:0.85rem;color:#666;">Nomor Antrian</div>
        <div style="font-size:2.5rem;font-weight:800;color:#1a3c6e;letter-spacing:2px;">{{ $booking->nomor_antrian }}</div>
        <span class="badge badge-{{ $booking->status }}" style="font-size:0.9rem;padding:5px 16px;">{{ ucfirst($booking->status) }}</span>
    </div>
    <table style="font-size:0.9rem;">
        <tr><td style="width:40%;color:#666;padding:8px 0;">Service</td><td><strong>{{ $booking->service->nama_service }}</strong></td></tr>
        <tr><td style="color:#666;padding:8px 0;">Tanggal</td><td>{{ $booking->tanggal_booking->format('d F Y') }}</td></tr>
        <tr><td style="color:#666;padding:8px 0;">Kendaraan</td><td>{{ $booking->kendaraan }}</td></tr>
        <tr><td style="color:#666;padding:8px 0;">Plat Nomor</td><td>{{ $booking->plat_nomor }}</td></tr>
        <tr><td style="color:#666;padding:8px 0;">Keluhan</td><td>{{ $booking->keluhan ?? '-' }}</td></tr>
        <tr><td style="color:#666;padding:8px 0;">Mekanik</td><td>{{ $booking->mekanik?->name ?? 'Belum ditugaskan' }}</td></tr>
        <tr><td style="color:#666;padding:8px 0;">Catatan Mekanik</td><td>{{ $booking->catatan_mekanik ?? '-' }}</td></tr>
        <tr><td style="color:#666;padding:8px 0;">Total Harga</td><td><strong>Rp {{ number_format($booking->total_harga,0,',','.') }}</strong></td></tr>
    </table>

    @if($booking->transaksi)
    <div style="margin-top:16px;padding:14px;background:#f0f9f4;border-radius:6px;border-left:4px solid #198754;">
        <div style="font-size:0.85rem;color:#0a3622;font-weight:700;">Info Pembayaran</div>
        <div style="font-size:0.88rem;margin-top:6px;">
            No. Transaksi: <strong>{{ $booking->transaksi->nomor_transaksi }}</strong><br>
            Status: <span class="badge badge-{{ $booking->transaksi->status_bayar }}">
                {{ $booking->transaksi->status_bayar === 'lunas' ? 'Lunas' : 'Belum Bayar' }}
            </span><br>
            @if($booking->transaksi->status_bayar === 'lunas')
                Metode: {{ $booking->transaksi->metode_bayar }}<br>
                Dibayar: {{ $booking->transaksi->dibayar_at->format('d/m/Y H:i') }}
            @endif
        </div>
    </div>
    @endif

    <div style="margin-top:20px;display:flex;gap:10px;flex-wrap:wrap;">
        <a href="{{ route('user.booking') }}" class="btn btn-warning">Kembali</a>
        @if($booking->status === 'selesai')
            <a href="{{ route('user.booking.sertifikat', $booking) }}" class="btn btn-success" target="_blank">
                &#127881; Lihat Sertifikat
            </a>
        @endif
        @if($booking->status === 'menunggu')
            <form method="POST" action="{{ route('user.booking.cancel', $booking) }}" onsubmit="return confirm('Yakin ingin membatalkan booking ini?')">
                @csrf
                <button type="submit" class="btn btn-danger">Batalkan Booking</button>
            </form>
        @endif
    </div>
</div>
@endsection
