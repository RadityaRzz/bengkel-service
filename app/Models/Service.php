<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = ['nama_service', 'deskripsi', 'harga', 'estimasi_jam', 'aktif'];

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}
