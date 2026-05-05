@extends('layouts.main')
@section('title', 'Kelola Booking')
@section('content')
<div class="page-title">Kelola Booking</div>
<div class="card">
    @if($bookings->isEmpty())
        <p style="color:#888;">Belum ada booking.</p>
    @else
    <table>
        <thead><tr><th>No. Antrian</th><th>Pelanggan</th><th>Service</th><th>Tanggal</th><th>Kendaraan</th><th>Status</th><th>Mekanik</th><th>Aksi</th></tr></thead>
        <tbody>
        @foreach($bookings as $b)
        <tr>
            <td><strong>{{ $b->nomor_antrian }}</strong></td>
            <td>{{ $b->user->name }}</td>
            <td>{{ $b->service->nama_service }}</td>
            <td>{{ $b->tanggal_booking->format('d/m/Y') }}</td>
            <td>{{ $b->kendaraan }} ({{ $b->plat_nomor }})</td>
            <td><span class="badge badge-{{ $b->status }}">{{ ucfirst($b->status) }}</span></td>
            <td>{{ $b->mekanik?->name ?? '-' }}</td>
            <td>
                @if($b->status === 'menunggu')
                    <button onclick="openModal('assign-{{ $b->id }}')" class="btn btn-primary btn-sm">Tugaskan</button>
                @endif
            </td>
        </tr>
        @endforeach
        </tbody>
    </table>
    @endif
</div>

@foreach($bookings as $b)
@if($b->status === 'menunggu')
<div id="assign-{{ $b->id }}" class="modal-overlay">
    <div class="modal-box">
        <button class="modal-close" onclick="closeModal('assign-{{ $b->id }}')">&times;</button>
        <div class="modal-title">Tugaskan Mekanik - {{ $b->nomor_antrian }}</div>
        <p style="font-size:0.88rem;color:#555;margin-bottom:14px;">
            Pelanggan: {{ $b->user->name }}<br>
            Service: {{ $b->service->nama_service }}<br>
            Kendaraan: {{ $b->kendaraan }} ({{ $b->plat_nomor }})
        </p>
        <form method="POST" action="{{ route('admin.booking.assign', $b) }}">
            @csrf
            <div class="form-group">
                <label>Pilih Mekanik</label>
                <select name="mekanik_id" class="form-control" required>
                    <option value="">-- Pilih --</option>
                    @foreach($mekaniks as $m)
                        <option value="{{ $m->id }}">{{ $m->name }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Tugaskan</button>
        </form>
    </div>
</div>
@endif
@endforeach
@endsection
