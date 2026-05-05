@extends('layouts.main')
@section('title', 'Transaksi')
@section('content')
<div class="page-title">Data Transaksi</div>
<div class="card">
    @if($transaksis->isEmpty())
        <p style="color:#888;">Belum ada transaksi. Transaksi dibuat otomatis saat mekanik menandai service selesai.</p>
    @else
    <table>
        <thead><tr><th>No. Transaksi</th><th>No. Antrian</th><th>Pelanggan</th><th>Service</th><th>Total</th><th>Status</th><th>Metode</th><th>Aksi</th></tr></thead>
        <tbody>
        @foreach($transaksis as $t)
        <tr>
            <td><strong>{{ $t->nomor_transaksi }}</strong></td>
            <td>{{ $t->booking->nomor_antrian }}</td>
            <td>{{ $t->booking->user->name }}</td>
            <td>{{ $t->booking->service->nama_service }}</td>
            <td>Rp {{ number_format($t->total,0,',','.') }}</td>
            <td>
                <span class="badge badge-{{ $t->status_bayar }}">
                    {{ $t->status_bayar === 'lunas' ? 'Lunas' : 'Belum Bayar' }}
                </span>
            </td>
            <td>{{ $t->metode_bayar ?? '-' }}</td>
            <td>
                @if($t->status_bayar === 'belum_bayar')
                    <button onclick="openModal('bayar-{{ $t->id }}')" class="btn btn-success btn-sm">Lunasi</button>
                @else
                    <small style="color:#888;">{{ $t->dibayar_at?->format('d/m/Y H:i') }}</small>
                @endif
            </td>
        </tr>
        @endforeach
        </tbody>
    </table>
    @endif
</div>

@foreach($transaksis as $t)
@if($t->status_bayar === 'belum_bayar')
<div id="bayar-{{ $t->id }}" class="modal-overlay">
    <div class="modal-box">
        <button class="modal-close" onclick="closeModal('bayar-{{ $t->id }}')">&times;</button>
        <div class="modal-title">Konfirmasi Pembayaran</div>
        <p style="margin-bottom:14px;font-size:0.9rem;">
            Pelanggan: <strong>{{ $t->booking->user->name }}</strong><br>
            Service: {{ $t->booking->service->nama_service }}<br>
            Total: <strong style="color:#198754;">Rp {{ number_format($t->total,0,',','.') }}</strong>
        </p>
        <form method="POST" action="{{ route('admin.transaksi.lunas', $t) }}">
            @csrf
            <div class="form-group">
                <label>Metode Pembayaran</label>
                <select name="metode_bayar" class="form-control" required>
                    <option value="">-- Pilih --</option>
                    <option value="Tunai">Tunai</option>
                    <option value="Transfer Bank">Transfer Bank</option>
                    <option value="QRIS">QRIS</option>
                </select>
            </div>
            <button type="submit" class="btn btn-success">Konfirmasi Lunas</button>
        </form>
    </div>
</div>
@endif
@endforeach
@endsection
