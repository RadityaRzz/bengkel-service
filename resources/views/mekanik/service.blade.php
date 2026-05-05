@extends('layouts.main')
@section('title', 'Daftar Service')
@section('content')
<div class="page-title">Daftar Service Masuk</div>
<div class="card">
    @if($bookings->isEmpty())
        <p style="color:#888;">Belum ada service yang ditugaskan.</p>
    @else
        <table>
            <thead><tr><th>No. Antrian</th><th>Pelanggan</th><th>Service</th><th>Kendaraan</th><th>Tanggal</th><th>Keluhan</th><th>Status</th><th>Aksi</th></tr></thead>
            <tbody>
            @foreach($bookings as $b)
            <tr>
                <td><strong>{{ $b->nomor_antrian }}</strong></td>
                <td>{{ $b->user->name }}</td>
                <td>{{ $b->service->nama_service }}</td>
                <td>{{ $b->kendaraan }} ({{ $b->plat_nomor }})</td>
                <td>{{ $b->tanggal_booking->format('d/m/Y') }}</td>
                <td>{{ $b->keluhan ?? '-' }}</td>
                <td><span class="badge badge-{{ $b->status }}">{{ ucfirst($b->status) }}</span></td>
                <td>
                    @if(in_array($b->status, ['menunggu','diproses']))
                        <button onclick="openModal('modal-{{ $b->id }}')" class="btn btn-success btn-sm">Update</button>
                    @else
                        <span style="color:#888;font-size:0.8rem;">Selesai</span>
                    @endif
                </td>
            </tr>
            @endforeach
            </tbody>
        </table>
    @endif
</div>

@foreach($bookings as $b)
@if(in_array($b->status, ['menunggu','diproses']))
<div id="modal-{{ $b->id }}" class="modal-overlay">
    <div class="modal-box">
        <button class="modal-close" onclick="closeModal('modal-{{ $b->id }}')">&times;</button>
        <div class="modal-title">Update - {{ $b->nomor_antrian }}</div>
        <form method="POST" action="{{ route('mekanik.service.status', $b) }}">
            @csrf
            <div class="form-group">
                <label>Status</label>
                <select name="status" class="form-control" required>
                    <option value="diproses" {{ $b->status=='diproses'?'selected':'' }}>Diproses</option>
                    <option value="selesai">Selesai</option>
                </select>
            </div>
            <div class="form-group">
                <label>Catatan</label>
                <textarea name="catatan_mekanik" class="form-control" rows="3">{{ $b->catatan_mekanik }}</textarea>
            </div>
            <button type="submit" class="btn btn-success">Simpan</button>
        </form>
    </div>
</div>
@endif
@endforeach
@endsection
