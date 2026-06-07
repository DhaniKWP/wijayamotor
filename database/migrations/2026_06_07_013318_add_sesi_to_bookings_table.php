<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->enum('sesi', ['pagi', 'siang'])->nullable()->after('tanggal');
            $table->time('jam')->nullable()->change();
        });
        
        // Buat data lama agar punya nilai default 'pagi' misalnya, atau dibiarkan nullable
        DB::table('bookings')->whereNull('sesi')->update(['sesi' => 'pagi']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn('sesi');
            $table->time('jam')->nullable(false)->change();
        });
    }
};
