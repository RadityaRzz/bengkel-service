<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MekanikController extends Controller
{
    public function dashboard()
    {
        $user   = Auth::user();
        $tugas  = Booking::where('mekanik_id', $user->id)->whereIn('status', ['menunggu', 'diproses'])->with('user', 'service')->get();
        $selesai = Booking::where('mekanik_id', $user->id)->where('status', 'selesai')->count();
        return view('mekanik.dashboard', compact('user', 'tugas', 'selesai'));
    }

    public function daftarService()
    {
        $bookings = Booking::where('mekanik_id', Auth::id())
            ->with('user', 'service')
            ->latest()
            ->get();
        return view('mekanik.service', compact('bookings'));
    }

    public function updateStatus(Request $request, Booking $booking)
    {
        abort_if($booking->mekanik_id !== Auth::id(), 403);

        $request->validate([
            'status'          => 'required|in:diproses,selesai',
            'catatan_mekanik' => 'nullable|string',
        ]);

        $booking->update([
            'status'          => $request->status,
            'catatan_mekanik' => $request->catatan_mekanik,
        ]);

        if ($request->status === 'selesai') {
            \App\Models\Transaksi::create([
                'nomor_transaksi' => \App\Models\Transaksi::generateNomor(),
                'booking_id'      => $booking->id,
                'total'           => $booking->total_harga,
                'status_bayar'    => 'belum_bayar',
            ]);
        }

        return back()->with('success', 'Status berhasil diperbarui.');
    }
}
