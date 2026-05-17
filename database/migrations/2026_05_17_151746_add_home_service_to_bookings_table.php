<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('bookings', function (Blueprint $table) {
        // Buat nandain ini booking di bengkel atau home service
        $table->string('tipe_booking')->default('bengkel')->after('service_id'); 
        // Buat nyimpen alamat lengkap + patokan
        $table->text('alamat_lengkap')->nullable()->after('cabang');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            //
        });
    }
};
