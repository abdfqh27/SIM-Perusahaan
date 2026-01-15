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
            $table->string('tipe_bus'); // SHD, HDD, Elf, HiAce
            $table->integer('kapasitas');
            $table->text('deskripsi')->nullable();
            $table->string('gambar_utama')->nullable();
            $table->text('galeri')->nullable(); // JSON array
            $table->integer('urutan')->default(0);
            $table->boolean('unggulan')->default(false);
            $table->boolean('tersedia')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('armada');
    }
};