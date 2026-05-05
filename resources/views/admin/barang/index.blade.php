@extends('layouts.main')
@section('title', 'Kelola Barang')
@section('content')
<div class="page-title">Kelola Barang</div>
<div style="margin-bottom:16px;">
    <button onclick="openModal('modal-tambah')" class="btn btn-primary">+ Tambah Barang</button>
</div>
<div class="card">
    <table>
        <thead><tr><th>Kode</th><th>Nama Barang</th><th>Stok</th><th>Satuan</th><th>Harga</th><th>Aksi</th></tr></thead>
        <tbody>
        @foreach($barangs as $b)
        <tr>
            <td><code>{{ $b->kode_barang }}</code></td>
            <td>{{ $b->nama_barang }}</td>
            <td>{{ $b->stok }}</td>
            <td>{{ $b->satuan }}</td>
            <td>Rp {{ number_format($b->harga,0,',','.') }}</td>
            <td style="display:flex;gap:6px;">
                <button onclick="openModal('edit-{{ $b->id }}')" class="btn btn-warning btn-sm">Edit</button>
                <form method="POST" action="{{ route('admin.barang.destroy', $b) }}" onsubmit="return confirm('Hapus barang ini?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                </form>
            </td>
        </tr>
        @endforeach
        </tbody>
    </table>
</div>

<div id="modal-tambah" class="modal-overlay">
    <div class="modal-box">
        <button class="modal-close" onclick="closeModal('modal-tambah')">&times;</button>
        <div class="modal-title">Tambah Barang</div>
        <form method="POST" action="{{ route('admin.barang.store') }}">
            @csrf
            <div class="form-row">
                <div class="form-group"><label>Nama Barang</label><input type="text" name="nama_barang" class="form-control" required></div>
                <div class="form-group"><label>Kode Barang</label><input type="text" name="kode_barang" class="form-control" required></div>
            </div>
            <div class="form-row">
                <div class="form-group"><label>Stok</label><input type="number" name="stok" class="form-control" value="0" required></div>
                <div class="form-group"><label>Satuan</label><input type="text" name="satuan" class="form-control" value="pcs" required></div>
            </div>
            <div class="form-group"><label>Harga (Rp)</label><input type="number" name="harga" class="form-control" required></div>
            <button type="submit" class="btn btn-primary">Simpan</button>
        </form>
    </div>
</div>

@foreach($barangs as $b)
<div id="edit-{{ $b->id }}" class="modal-overlay">
    <div class="modal-box">
        <button class="modal-close" onclick="closeModal('edit-{{ $b->id }}')">&times;</button>
        <div class="modal-title">Edit Barang</div>
        <form method="POST" action="{{ route('admin.barang.update', $b) }}">
            @csrf @method('PUT')
            <div class="form-group"><label>Nama Barang</label><input type="text" name="nama_barang" class="form-control" value="{{ $b->nama_barang }}" required></div>
            <div class="form-row">
                <div class="form-group"><label>Stok</label><input type="number" name="stok" class="form-control" value="{{ $b->stok }}" required></div>
                <div class="form-group"><label>Satuan</label><input type="text" name="satuan" class="form-control" value="{{ $b->satuan }}" required></div>
            </div>
            <div class="form-group"><label>Harga</label><input type="number" name="harga" class="form-control" value="{{ $b->harga }}" required></div>
            <button type="submit" class="btn btn-primary">Simpan</button>
        </form>
    </div>
</div>
@endforeach
@endsection
