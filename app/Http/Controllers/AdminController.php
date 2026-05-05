<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Booking;
use App\Models\Service;
use App\Models\Transaksi;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'total_booking'    => Booking::count(),
            'menunggu'         => Booking::where('status', 'menunggu')->count(),
            'diproses'         => Booking::where('status', 'diproses')->count(),
            'selesai'          => Booking::where('status', 'selesai')->count(),
            'total_pelanggan'  => User::where('role', 'user')->count(),
            'total_mekanik'    => User::where('role', 'mekanik')->count(),
            'pendapatan'       => Transaksi::where('status_bayar', 'lunas')->sum('total'),
        ];
        $bookingTerbaru = Booking::with('user', 'service')->latest()->take(5)->get();
        return view('admin.dashboard', compact('stats', 'bookingTerbaru'));
    }

    // ---- BOOKING ----
    public function bookingIndex()
    {
        $bookings  = Booking::with('user', 'service', 'mekanik')->latest()->get();
        $mekaniks  = User::where('role', 'mekanik')->get();
        return view('admin.booking.index', compact('bookings', 'mekaniks'));
    }

    public function bookingAssign(Request $request, Booking $booking)
    {
        $request->validate(['mekanik_id' => 'required|exists:users,id']);
        $booking->update(['mekanik_id' => $request->mekanik_id, 'status' => 'diproses']);
        return back()->with('success', 'Mekanik berhasil ditugaskan.');
    }

    // ---- SERVICE ----
    public function serviceIndex()
    {
        $services = Service::latest()->get();
        return view('admin.service.index', compact('services'));
    }

    public function serviceStore(Request $request)
    {
        $request->validate([
            'nama_service'  => 'required|string|max:100',
            'harga'         => 'required|numeric|min:0',
            'estimasi_jam'  => 'required|integer|min:1',
            'deskripsi'     => 'nullable|string',
        ]);
        Service::create($request->only('nama_service', 'harga', 'estimasi_jam', 'deskripsi') + ['aktif' => true]);
        return back()->with('success', 'Service berhasil ditambahkan.');
    }

    public function serviceUpdate(Request $request, Service $service)
    {
        $request->validate([
            'nama_service'  => 'required|string|max:100',
            'harga'         => 'required|numeric|min:0',
            'estimasi_jam'  => 'required|integer|min:1',
        ]);
        $service->update($request->only('nama_service', 'harga', 'estimasi_jam', 'deskripsi', 'aktif'));
        return back()->with('success', 'Service berhasil diperbarui.');
    }

    public function serviceDestroy(Service $service)
    {
        $service->delete();
        return back()->with('success', 'Service berhasil dihapus.');
    }

    // ---- BARANG ----
    public function barangIndex()
    {
        $barangs = Barang::latest()->get();
        return view('admin.barang.index', compact('barangs'));
    }

    public function barangStore(Request $request)
    {
        $request->validate([
            'nama_barang'  => 'required|string|max:100',
            'kode_barang'  => 'required|string|unique:barangs',
            'stok'         => 'required|integer|min:0',
            'harga'        => 'required|numeric|min:0',
            'satuan'       => 'required|string|max:20',
        ]);
        Barang::create($request->only('nama_barang', 'kode_barang', 'stok', 'harga', 'satuan'));
        return back()->with('success', 'Barang berhasil ditambahkan.');
    }

    public function barangUpdate(Request $request, Barang $barang)
    {
        $request->validate([
            'nama_barang' => 'required|string|max:100',
            'stok'        => 'required|integer|min:0',
            'harga'       => 'required|numeric|min:0',
        ]);
        $barang->update($request->only('nama_barang', 'stok', 'harga', 'satuan'));
        return back()->with('success', 'Barang berhasil diperbarui.');
    }

    public function barangDestroy(Barang $barang)
    {
        $barang->delete();
        return back()->with('success', 'Barang berhasil dihapus.');
    }

    // ---- PELANGGAN ----
    public function pelangganIndex()
    {
        $pelanggans = User::where('role', 'user')->withCount('bookings')->latest()->get();
        return view('admin.pelanggan.index', compact('pelanggans'));
    }

    // ---- MEKANIK ----
    public function mekanikIndex()
    {
        $mekaniks = User::where('role', 'mekanik')->withCount('tugasMekanik')->latest()->get();
        return view('admin.mekanik.index', compact('mekaniks'));
    }

    public function mekanikStore(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:100',
            'email'    => 'required|email|unique:users',
            'password' => 'required|min:6',
            'telepon'  => 'nullable|string|max:20',
        ]);
        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => bcrypt($request->password),
            'role'     => 'mekanik',
            'telepon'  => $request->telepon,
        ]);
        return back()->with('success', 'Mekanik berhasil ditambahkan.');
    }

    public function mekanikDestroy(User $user)
    {
        abort_if($user->role !== 'mekanik', 403);
        $user->delete();
        return back()->with('success', 'Mekanik berhasil dihapus.');
    }

    // ---- TRANSAKSI ----
    public function transaksiIndex()
    {
        $transaksis = Transaksi::with('booking.user', 'booking.service')->latest()->get();
        return view('admin.transaksi.index', compact('transaksis'));
    }

    public function transaksiLunas(Request $request, Transaksi $transaksi)
    {
        $request->validate(['metode_bayar' => 'required|string']);
        $transaksi->update([
            'status_bayar' => 'lunas',
            'metode_bayar' => $request->metode_bayar,
            'dibayar_at'   => now(),
        ]);
        return back()->with('success', 'Transaksi berhasil dilunasi.');
    }
}
