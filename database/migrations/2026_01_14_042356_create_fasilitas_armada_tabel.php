<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('fasilitas_armada', function (Blueprint $table) {
            $table->id();
            $table->foreignId('armada_id')->constrained('armada')->onDelete('cascade');
            $table->string('nama_fasilitas');
            $table->string('icon')->nullable();
            $table->boolean('tersedia')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fasilitas_armada');
    }
};