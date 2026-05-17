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
            $table->string('cabang')->after('service_id')->nullable();
            $table->string('jenis_servis')->after('cabang')->default('berkala');
            $table->integer('kilometer')->after('jenis_servis')->nullable();
            $table->json('addons')->after('kilometer')->nullable(); // Simpan array Spooring/AC
            $table->integer('estimasi_harga')->after('addons')->nullable();
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
