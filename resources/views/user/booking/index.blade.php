@extends('layouts.main')
@section('title', 'Pesanan Saya')
@section('content')
<div class="page-title">Pesanan Saya</div>
<div style="margin-bottom:16px;">
    <a href="{{ route('user.booking.create') }}" class="btn btn-primary">+ Booking Baru</a>
</div>
<div class="card">
    @if($bookings->isEmpty())
        <p style="color:#888;">Belum ada booking.</p>
    @else
        <table>
            <thead><tr><th>No. Antrian</th><th>Service</th><th>Tanggal</th><th>Kendaraan</th><th>Plat</th><th>Status</th><th>Aksi</th></tr></thead>
            <tbody>
            @foreach($bookings as $b)
            <tr>
                <td><strong>{{ $b->nomor_antrian }}</strong></td>
                <td>{{ $b->service->nama_service }}</td>
                <td>{{ $b->tanggal_booking->format('d/m/Y') }}</td>
                <td>{{ $b->kendaraan }}</td>
                <td>{{ $b->plat_nomor }}</td>
                <td><span class="badge badge-{{ $b->status }}">{{ ucfirst($b->status) }}</span></td>
                <td><a href="{{ route('user.booking.show', $b) }}" class="btn btn-primary btn-sm">Detail</a></td>
            </tr>
            @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
