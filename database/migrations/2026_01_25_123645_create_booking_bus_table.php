<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('booking_bus', function (Blueprint $table) {
            $table->id();
            $table->foreignId('booking_id')->constrained('booking')->onDelete('cascade');
            $table->foreignId('bus_id')->constrained('bus')->onDelete('restrict');
            $table->timestamps();

            // Prevent duplicate bus in same booking
            $table->unique(['booking_id', 'bus_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('booking_bus');
    }
};
