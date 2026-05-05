<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = ['name', 'email', 'password', 'role', 'telepon', 'alamat'];
    protected $hidden   = ['password', 'remember_token'];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
        ];
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function tugasMekanik()
    {
        return $this->hasMany(Booking::class, 'mekanik_id');
    }

    public function isAdmin(): bool    { return $this->role === 'admin'; }
    public function isMekanik(): bool  { return $this->role === 'mekanik'; }
    public function isUser(): bool     { return $this->role === 'user'; }
}
