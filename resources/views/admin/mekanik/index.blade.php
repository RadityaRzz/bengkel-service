@extends('layouts.main')
@section('title', 'Kelola Mekanik')
@section('content')
<div class="page-title">Kelola Mekanik</div>
<div style="margin-bottom:16px;">
    <button onclick="openModal('modal-tambah')" class="btn btn-primary">+ Tambah Mekanik</button>
</div>
<div class="card">
    <table>
        <thead><tr><th>Nama</th><th>Email</th><th>Telepon</th><th>Total Tugas</th><th>Bergabung</th><th>Aksi</th></tr></thead>
        <tbody>
        @foreach($mekaniks as $m)
        <tr>
            <td><strong>{{ $m->name }}</strong></td>
            <td>{{ $m->email }}</td>
            <td>{{ $m->telepon ?? '-' }}</td>
            <td>{{ $m->tugas_mekanik_count }}</td>
            <td>{{ $m->created_at->format('d/m/Y') }}</td>
            <td>
                <form method="POST" action="{{ route('admin.mekanik.destroy', $m) }}" onsubmit="return confirm('Hapus mekanik ini?')">
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
        <div class="modal-title">Tambah Mekanik</div>
        <form method="POST" action="{{ route('admin.mekanik.store') }}">
            @csrf
            <div class="form-group"><label>Nama</label><input type="text" name="name" class="form-control" required></div>
            <div class="form-group"><label>Email</label><input type="email" name="email" class="form-control" required></div>
            <div class="form-group"><label>Password</label><input type="password" name="password" class="form-control" required></div>
            <div class="form-group"><label>Telepon</label><input type="text" name="telepon" class="form-control"></div>
            <button type="submit" class="btn btn-primary">Simpan</button>
        </form>
    </div>
</div>
@endsection
