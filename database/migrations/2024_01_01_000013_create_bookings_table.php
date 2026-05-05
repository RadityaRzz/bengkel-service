<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_antrian')->unique();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('service_id')->constrained()->onDelete('cascade');
            $table->foreignId('mekanik_id')->nullable()->constrained('users')->onDelete('set null');
            $table->date('tanggal_booking');
            $table->string('kendaraan');
            $table->string('plat_nomor');
            $table->text('keluhan')->nullable();
            $table->enum('status', ['menunggu', 'diproses', 'selesai', 'dibatalkan'])->default('menunggu');
            $table->text('catatan_mekanik')->nullable();
            $table->decimal('total_harga', 10, 2)->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
