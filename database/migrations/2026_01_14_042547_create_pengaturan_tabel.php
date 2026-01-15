<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pengaturan', function (Blueprint $table) {
            $table->id();
            $table->string('nama_perusahaan', 255)->nullable();
            $table->string('tagline', 255)->nullable();
            $table->text('deskripsi')->nullable();
            
            $table->text('alamat')->nullable();
            $table->string('telepon', 50)->nullable();
            $table->string('whatsapp', 50)->nullable();
            $table->string('email', 100)->nullable();
            
            $table->string('facebook', 255)->nullable();
            $table->string('instagram', 255)->nullable();
            $table->string('twitter', 255)->nullable();
            $table->string('youtube', 255)->nullable();
            
            $table->string('meta_title', 255)->nullable();
            $table->text('meta_description')->nullable();
            $table->text('meta_keywords')->nullable();
            
            $table->string('logo', 255)->nullable();
            $table->string('favicon', 255)->nullable();
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengaturan');
    }
};