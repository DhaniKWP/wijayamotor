<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('vehicle_id')->constrained()->onDelete('cascade');
            $table->foreignId('service_id')->constrained()->onDelete('cascade');
            
            // Kolom baru digabungin langsung ke sini
            $table->string('tipe_booking')->default('bengkel');
            $table->string('cabang')->nullable();
            $table->text('alamat_lengkap')->nullable();
            $table->string('jenis_servis')->default('berkala');
            $table->integer('kilometer')->nullable();
            $table->json('addons')->nullable();
            $table->decimal('estimasi_harga', 12, 2)->default(0);

            $table->date('tanggal');
            $table->time('jam');
            $table->text('keluhan')->nullable();
            $table->enum('status', ['pending', 'confirmed', 'process', 'done', 'cancelled'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
