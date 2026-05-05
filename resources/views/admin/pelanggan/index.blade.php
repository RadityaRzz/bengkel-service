@extends('layouts.main')
@section('title', 'Data Pelanggan')
@section('content')
<div class="page-title">Data Pelanggan</div>
<div class="card">
    <table>
        <thead><tr><th>Nama</th><th>Email</th><th>Telepon</th><th>Alamat</th><th>Total Booking</th><th>Bergabung</th></tr></thead>
        <tbody>
        @foreach($pelanggans as $p)
        <tr>
            <td><strong>{{ $p->name }}</strong></td>
            <td>{{ $p->email }}</td>
            <td>{{ $p->telepon ?? '-' }}</td>
            <td>{{ $p->alamat ?? '-' }}</td>
            <td>{{ $p->bookings_count }}</td>
            <td>{{ $p->created_at->format('d/m/Y') }}</td>
        </tr>
        @endforeach
        </tbody>
    </table>
</div>
@endsection
