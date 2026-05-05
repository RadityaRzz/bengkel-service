<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function jasaIndex()
    {
        $services = Service::where('aktif', true)->get();
        return view('user.jasa', compact('services'));
    }

    public function dashboard()
    {
        $user     = Auth::user();
        $bookings = Booking::where('user_id', $user->id)->latest()->take(5)->get();
        return view('user.dashboard', compact('user', 'bookings'));
    }

    public function bookingIndex()
    {
        $bookings = Booking::where('user_id', Auth::id())->with('service')->latest()->get();
        return view('user.booking.index', compact('bookings'));
    }

    public function bookingCreate()
    {
        $services = Service::where('aktif', true)->get();
        return view('user.booking.create', compact('services'));
    }

    public function bookingStore(Request $request)
    {
        $request->validate([
            'service_id'      => 'required|exists:services,id',
            'tanggal_booking' => 'required|date|after_or_equal:today',
            'kendaraan'       => 'required|string|max:100',
            'plat_nomor'      => 'required|string|max:20',
            'keluhan'         => 'nullable|string',
        ]);

        $service = Service::findOrFail($request->service_id);

        Booking::create([
            'nomor_antrian'   => Booking::generateNomorAntrian(),
            'user_id'         => Auth::id(),
            'service_id'      => $request->service_id,
            'tanggal_booking' => $request->tanggal_booking,
            'kendaraan'       => $request->kendaraan,
            'plat_nomor'      => strtoupper($request->plat_nomor),
            'keluhan'         => $request->keluhan,
            'status'          => 'menunggu',
            'total_harga'     => $service->harga,
        ]);

        return redirect()->route('user.booking')->with('success', 'Booking berhasil! Nomor antrian sudah dibuat.');
    }

    public function bookingShow(Booking $booking)
    {
        abort_if($booking->user_id !== Auth::id(), 403);
        return view('user.booking.show', compact('booking'));
    }

    public function bookingSertifikat(Booking $booking)
    {
        abort_if($booking->user_id !== Auth::id(), 403);
        abort_if($booking->status !== 'selesai', 404, 'Sertifikat hanya tersedia untuk booking yang sudah selesai.');
        return view('user.booking.sertifikat', compact('booking'));
    }

    public function bookingCancel(Booking $booking)    {
        abort_if($booking->user_id !== Auth::id(), 403);
        abort_if($booking->status !== 'menunggu', 400, 'Booking tidak bisa dibatalkan.');

        $booking->update(['status' => 'dibatalkan']);
        return back()->with('success', 'Booking berhasil dibatalkan.');
    }
}
