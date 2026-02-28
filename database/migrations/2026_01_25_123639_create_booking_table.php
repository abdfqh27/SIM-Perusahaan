<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('booking', function (Blueprint $table) {
            $table->id();
            $table->string('kode_booking')->unique();
            $table->string('nama_pemesan');
            $table->string('no_hp_pemesan', 15);
            $table->string('email_pemesan')->nullable();
            $table->string('tujuan');
            $table->string('tempat_jemput');
            $table->date('tanggal_berangkat');
            $table->date('tanggal_selesai');
            $table->time('jam_berangkat');
            $table->decimal('total_pembayaran', 15, 2);
            $table->decimal('nominal_dp', 15, 2)->nullable();
            $table->enum('metode_pembayaran', ['cash', 'transfer']);
            $table->enum('status_pembayaran', ['belum_bayar', 'dp', 'lunas'])->default('belum_bayar');
            $table->enum('status_booking', ['draft', 'confirmed', 'selesai', 'batal'])->default('draft');
            $table->text('catatan')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('booking');
    }
};
