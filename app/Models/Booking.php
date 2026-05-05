<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
        'nomor_antrian', 'user_id', 'service_id', 'mekanik_id',
        'tanggal_booking', 'kendaraan', 'plat_nomor', 'keluhan',
        'status', 'catatan_mekanik', 'total_harga',
    ];

    protected $casts = ['tanggal_booking' => 'date'];

    public function user()     { return $this->belongsTo(User::class); }
    public function service()  { return $this->belongsTo(Service::class); }
    public function mekanik()  { return $this->belongsTo(User::class, 'mekanik_id'); }
    public function transaksi(){ return $this->hasOne(Transaksi::class); }

    public static function generateNomorAntrian(): string
    {
        $prefix = 'ANT-' . date('Ymd') . '-';
        $last   = self::whereDate('created_at', today())->count() + 1;
        return $prefix . str_pad($last, 3, '0', STR_PAD_LEFT);
    }
}
