<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('layanan', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('slug')->unique();
            $table->text('deskripsi_singkat')->nullable();
            $table->longText('deskripsi_lengkap')->nullable();
            $table->string('icon')->nullable();
            $table->string('gambar')->nullable();
            $table->text('fasilitas')->nullable(); // JSON array
            $table->unsignedInteger('urutan')->unique();
            $table->boolean('unggulan')->default(false);
            $table->boolean('aktif')->default(true);
            $table->timestamps();

            // Index untuk performa query
            $table->index('urutan');
            $table->index('aktif');
            $table->index('unggulan');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('layanan');
    }
};
