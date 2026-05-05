<?php

namespace Database\Seeders;

use App\Models\Barang;
use App\Models\Service;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ============================================================
        // ADMIN & MEKANIK dibuat di sini (tidak bisa daftar sendiri)
        // Login menggunakan akun di bawah ini
        // ============================================================

        // Admin
        User::create([
            'name'     => 'Admin Bengkel',
            'email'    => 'admin@bengkel.com',
            'password' => Hash::make('password'),
            'role'     => 'admin',
        ]);

        // Mekanik
        User::create([
            'name'     => 'Budi Santoso',
            'email'    => 'budi@bengkel.com',
            'password' => Hash::make('password'),
            'role'     => 'mekanik',
            'telepon'  => '081234567890',
        ]);

        User::create([
            'name'     => 'Andi Prasetyo',
            'email'    => 'andi@bengkel.com',
            'password' => Hash::make('password'),
            'role'     => 'mekanik',
            'telepon'  => '081234567891',
        ]);

        User::create([
            'name'     => 'Riko Firmansyah',
            'email'    => 'riko@bengkel.com',
            'password' => Hash::make('password'),
            'role'     => 'mekanik',
            'telepon'  => '081234567892',
        ]);

        // ============================================================
        // PELANGGAN bisa daftar sendiri lewat halaman /register
        // Akun di bawah hanya untuk demo/testing
        // ============================================================

        User::create([
            'name'     => 'Pelanggan Demo',
            'email'    => 'user@bengkel.com',
            'password' => Hash::make('password'),
            'role'     => 'user',
            'telepon'  => '08123456789',
            'alamat'   => 'Jl. Contoh No. 1',
        ]);

        // Services
        $services = [
            ['nama_service' => 'Ganti Oli Mesin',    'harga' => 75000,  'estimasi_jam' => 1, 'deskripsi' => 'Penggantian oli mesin standar'],
            ['nama_service' => 'Tune Up Ringan',      'harga' => 150000, 'estimasi_jam' => 2, 'deskripsi' => 'Busi, filter udara, karburator'],
            ['nama_service' => 'Servis Rem',          'harga' => 100000, 'estimasi_jam' => 2, 'deskripsi' => 'Cek dan ganti kampas rem'],
            ['nama_service' => 'Ganti Ban',           'harga' => 50000,  'estimasi_jam' => 1, 'deskripsi' => 'Pemasangan ban baru'],
            ['nama_service' => 'Servis AC',           'harga' => 200000, 'estimasi_jam' => 3, 'deskripsi' => 'Cuci dan isi freon AC'],
            ['nama_service' => 'Tune Up Besar',       'harga' => 350000, 'estimasi_jam' => 4, 'deskripsi' => 'Servis lengkap mesin'],
        ];

        foreach ($services as $s) {
            Service::create($s + ['aktif' => true]);
        }

        // Barang
        $barangs = [
            ['nama_barang' => 'Oli Mesin 1L',    'kode_barang' => 'OLI-001', 'stok' => 50, 'harga' => 45000, 'satuan' => 'botol'],
            ['nama_barang' => 'Busi NGK',         'kode_barang' => 'BSI-001', 'stok' => 30, 'harga' => 25000, 'satuan' => 'pcs'],
            ['nama_barang' => 'Filter Udara',     'kode_barang' => 'FLT-001', 'stok' => 20, 'harga' => 35000, 'satuan' => 'pcs'],
            ['nama_barang' => 'Kampas Rem Depan', 'kode_barang' => 'REM-001', 'stok' => 15, 'harga' => 65000, 'satuan' => 'set'],
            ['nama_barang' => 'Freon AC R134a',   'kode_barang' => 'FRN-001', 'stok' => 10, 'harga' => 80000, 'satuan' => 'kaleng'],
        ];

        foreach ($barangs as $b) {
            Barang::create($b);
        }
    }
}
