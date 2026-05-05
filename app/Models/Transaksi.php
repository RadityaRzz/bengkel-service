<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    protected $fillable = ['nomor_transaksi', 'booking_id', 'total', 'status_bayar', 'metode_bayar', 'dibayar_at'];

    protected $casts = ['dibayar_at' => 'datetime'];

    public function booking() { return $this->belongsTo(Booking::class); }

    public static function generateNomor(): string
    {
        $prefix = 'TRX-' . date('Ymd') . '-';
        $last   = self::whereDate('created_at', today())->count() + 1;
        return $prefix . str_pad($last, 3, '0', STR_PAD_LEFT);
    }
}
