@extends('layouts.main')
@section('title', 'Jenis Service')
@section('content')
<div class="page-title">Jenis Service</div>
<div style="margin-bottom:16px;">
    <button onclick="openModal('modal-tambah')" class="btn btn-primary">+ Tambah Service</button>
</div>
<div class="card">
    <table>
        <thead><tr><th>Nama Service</th><th>Harga</th><th>Estimasi</th><th>Status</th><th>Aksi</th></tr></thead>
        <tbody>
        @foreach($services as $s)
        <tr>
            <td><strong>{{ $s->nama_service }}</strong><br><small style="color:#888;">{{ $s->deskripsi }}</small></td>
            <td>Rp {{ number_format($s->harga,0,',','.') }}</td>
            <td>{{ $s->estimasi_jam }} jam</td>
            <td><span class="badge {{ $s->aktif ? 'badge-selesai' : 'badge-dibatalkan' }}">{{ $s->aktif ? 'Aktif' : 'Nonaktif' }}</span></td>
            <td style="display:flex;gap:6px;">
                <button onclick="openModal('edit-{{ $s->id }}')" class="btn btn-warning btn-sm">Edit</button>
                <form method="POST" action="{{ route('admin.service.destroy', $s) }}" onsubmit="return confirm('Hapus service ini?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                </form>
            </td>
        </tr>
        @endforeach
        </tbody>
    </table>
</div>

<!-- Modal Tambah -->
<div id="modal-tambah" class="modal-overlay">
    <div class="modal-box">
        <button class="modal-close" onclick="closeModal('modal-tambah')">&times;</button>
        <div class="modal-title">Tambah Service</div>
        <form method="POST" action="{{ route('admin.service.store') }}">
            @csrf
            <div class="form-group"><label>Nama Service</label><input type="text" name="nama_service" class="form-control" required></div>
            <div class="form-row">
                <div class="form-group"><label>Harga (Rp)</label><input type="number" name="harga" class="form-control" required></div>
                <div class="form-group"><label>Estimasi (jam)</label><input type="number" name="estimasi_jam" class="form-control" value="1" required></div>
            </div>
            <div class="form-group"><label>Deskripsi</label><textarea name="deskripsi" class="form-control" rows="2"></textarea></div>
            <button type="submit" class="btn btn-primary">Simpan</button>
        </form>
    </div>
</div>

@foreach($services as $s)
<div id="edit-{{ $s->id }}" class="modal-overlay">
    <div class="modal-box">
        <button class="modal-close" onclick="closeModal('edit-{{ $s->id }}')">&times;</button>
        <div class="modal-title">Edit Service</div>
        <form method="POST" action="{{ route('admin.service.update', $s) }}">
            @csrf @method('PUT')
            <div class="form-group"><label>Nama Service</label><input type="text" name="nama_service" class="form-control" value="{{ $s->nama_service }}" required></div>
            <div class="form-row">
                <div class="form-group"><label>Harga</label><input type="number" name="harga" class="form-control" value="{{ $s->harga }}" required></div>
                <div class="form-group"><label>Estimasi (jam)</label><input type="number" name="estimasi_jam" class="form-control" value="{{ $s->estimasi_jam }}" required></div>
            </div>
            <div class="form-group"><label>Deskripsi</label><textarea name="deskripsi" class="form-control" rows="2">{{ $s->deskripsi }}</textarea></div>
            <div class="form-group">
                <label>Status</label>
                <select name="aktif" class="form-control">
                    <option value="1" {{ $s->aktif ? 'selected' : '' }}>Aktif</option>
                    <option value="0" {{ !$s->aktif ? 'selected' : '' }}>Nonaktif</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Simpan</button>
        </form>
    </div>
</div>
@endforeach
@endsection
