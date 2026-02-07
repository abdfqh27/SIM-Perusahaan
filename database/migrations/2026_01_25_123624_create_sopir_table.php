<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sopir', function (Blueprint $table) {
            $table->id();
            $table->string('nama_sopir');
            $table->string('nik', 20)->unique();
            $table->string('no_sim', 20)->unique();
            $table->enum('jenis_sim', ['SIM A', 'SIM B1', 'SIM B2']);
            $table->string('no_hp');
            $table->text('alamat');
            $table->enum('status', ['aktif', 'nonaktif', 'cuti'])->default('aktif');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sopir');
    }
};
