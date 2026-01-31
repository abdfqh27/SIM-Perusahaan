<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('armada', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('slug')->unique();
            $table->string('tipe_bus');
            $table->integer('kapasitas_min');
            $table->integer('kapasitas_max');
            $table->text('deskripsi')->nullable();
            // Gambar (akan dikonversi ke WebP)
            $table->string('gambar_utama')->nullable();
            // Galeri (JSON array untuk multiple gambar)
            $table->json('galeri')->nullable();
            $table->json('fasilitas')->nullable();
            $table->integer('urutan')->unique();
            $table->boolean('unggulan')->default(false);
            $table->boolean('tersedia')->default(true);
            $table->timestamps();

            // Index untuk performa query
            $table->index('tipe_bus');
            $table->index('unggulan');
            $table->index('tersedia');
            $table->index('urutan');
            $table->index(['kapasitas_min', 'kapasitas_max']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('armada');
    }
};
