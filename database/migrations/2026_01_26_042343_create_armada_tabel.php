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
            $table->foreignId('kategori_bus_id')->constrained('kategori_bus')->cascadeOnDelete();
            $table->text('deskripsi')->nullable();
            $table->string('gambar_utama')->nullable();
            $table->json('galeri')->nullable();
            $table->json('fasilitas')->nullable();
            $table->integer('urutan')->unique();
            $table->boolean('unggulan')->default(false);
            $table->boolean('tersedia')->default(true);
            $table->timestamps();

            $table->index('kategori_bus_id');
            $table->index('unggulan');
            $table->index('tersedia');
            $table->index('urutan');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('armada');
    }
};
