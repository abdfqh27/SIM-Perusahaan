<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bus', function (Blueprint $table) {
            $table->id();
            $table->string('kode_bus', 50)->unique();
            $table->string('nama_bus');
            $table->foreignId('kategori_bus_id')->constrained('kategori_bus')->onDelete('restrict');
            $table->foreignId('sopir_id')->unique()->constrained('sopir')->onDelete('restrict');
            $table->string('warna_bus', 50);
            $table->string('nomor_polisi', 20)->unique();
            $table->enum('status', ['aktif', 'perawatan'])->default('aktif');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bus');
    }
};
