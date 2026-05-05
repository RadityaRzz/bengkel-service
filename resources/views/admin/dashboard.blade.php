@extends('layouts.main')
@section('title', 'Dashboard Admin')
@section('content')
<div class="page-title">Dashboard Admin</div>
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-num">{{ $stats['total_booking'] }}</div>
        <div class="stat-label">Total Booking</div>
    </div>
    <div class="stat-card" style="border-top-color:#f9c74f;">
        <div class="stat-num" style="color:#856404;">{{ $stats['menunggu'] }}</div>
        <div class="stat-label">Menunggu</div>
    </div>
    <div class="stat-card" style="border-top-color:#2563b0;">
        <div class="stat-num" style="color:#2563b0;">{{ $stats['diproses'] }}</div>
        <div class="stat-label">Diproses</div>
    </div>
    <div class="stat-card" style="border-top-color:#198754;">
        <div class="stat-num" style="color:#198754;">{{ $stats['selesai'] }}</div>
        <div class="stat-label">Selesai</div>
    </div>
    <div class="stat-card">
        <div class="stat-num">{{ $stats['total_pelanggan'] }}</div>
        <div class="stat-label">Pelanggan</div>
    </div>
    <div class="stat-card">
        <div class="stat-num">{{ $stats['total_mekanik'] }}</div>
        <div class="stat-label">Mekanik</div>
    </div>
    <div class="stat-card" style="border-top-color:#198754;">
        <div class="stat-num" style="color:#198754;font-size:1.3rem;">Rp {{ number_format($stats['pendapatan'],0,',','.') }}</div>
        <div class="stat-label">Pendapatan</div>
    </div>
</div>
<div class="card">
    <div class="card-title">Booking Terbaru</div>
    <table>
        <thead><tr><th>No. Antrian</th><th>Pelanggan</th><th>Service</th><th>Tanggal</th><th>Status</th></tr></thead>
        <tbody>
        @foreach($bookingTerbaru as $b)
        <tr>
            <td><strong>{{ $b->nomor_antrian }}</strong></td>
            <td>{{ $b->user->name }}</td>
            <td>{{ $b->service->nama_service }}</td>
            <td>{{ $b->tanggal_booking->format('d/m/Y') }}</td>
            <td><span class="badge badge-{{ $b->status }}">{{ ucfirst($b->status) }}</span></td>
        </tr>
        @endforeach
        </tbody>
    </table>
</div>
@endsection
