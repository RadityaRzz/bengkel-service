<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('transaksis', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_transaksi')->unique();
            $table->foreignId('booking_id')->constrained()->onDelete('cascade');
            $table->decimal('total', 10, 2);
            $table->enum('status_bayar', ['belum_bayar', 'lunas'])->default('belum_bayar');
            $table->string('metode_bayar')->nullable();
            $table->timestamp('dibayar_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transaksis');
    }
};
