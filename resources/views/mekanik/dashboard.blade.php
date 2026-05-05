@extends('layouts.main')
@section('title', 'Dashboard Mekanik')
@section('content')
<div class="page-title">Dashboard Mekanik</div>
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-num">{{ $tugas->count() }}</div>
        <div class="stat-label">Tugas Aktif</div>
    </div>
    <div class="stat-card">
        <div class="stat-num">{{ $selesai }}</div>
        <div class="stat-label">Selesai</div>
    </div>
</div>
<div class="card">
    <div class="card-title">Tugas Aktif</div>
    @if($tugas->isEmpty())
        <p style="color:#888;">Tidak ada tugas aktif saat ini.</p>
    @else
        <table>
            <thead><tr><th>No. Antrian</th><th>Pelanggan</th><th>Service</th><th>Kendaraan</th><th>Keluhan</th><th>Status</th><th>Aksi</th></tr></thead>
            <tbody>
            @foreach($tugas as $b)
            <tr>
                <td><strong>{{ $b->nomor_antrian }}</strong></td>
                <td>{{ $b->user->name }}</td>
                <td>{{ $b->service->nama_service }}</td>
                <td>{{ $b->kendaraan }} ({{ $b->plat_nomor }})</td>
                <td>{{ $b->keluhan ?? '-' }}</td>
                <td><span class="badge badge-{{ $b->status }}">{{ ucfirst($b->status) }}</span></td>
                <td>
                    <button onclick="openModal('modal-{{ $b->id }}')" class="btn btn-success btn-sm">Update</button>
                </td>
            </tr>
            @endforeach
            </tbody>
        </table>
    @endif
</div>

@foreach($tugas as $b)
<div id="modal-{{ $b->id }}" class="modal-overlay">
    <div class="modal-box">
        <button class="modal-close" onclick="closeModal('modal-{{ $b->id }}')">&times;</button>
        <div class="modal-title">Update Status - {{ $b->nomor_antrian }}</div>
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
                <label>Catatan Mekanik</label>
                <textarea name="catatan_mekanik" class="form-control" rows="3">{{ $b->catatan_mekanik }}</textarea>
            </div>
            <button type="submit" class="btn btn-success">Simpan</button>
        </form>
    </div>
</div>
@endforeach
@endsection
