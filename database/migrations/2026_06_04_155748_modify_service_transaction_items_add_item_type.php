<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Mengubah service_transaction_items agar bisa menampung 2 tipe item:
     *   1. 'sparepart' → pilih dari master sparepart (sparepart_id wajib)
     *   2. 'jasa'      → input manual jasa tambahan (item_name wajib)
     */
    public function up(): void
    {
        Schema::table('service_transaction_items', function (Blueprint $table) {
            // Hapus foreign key & kolom sparepart_id yang dulu wajib (constrained)
            $table->dropForeign(['sparepart_id']);
            $table->dropColumn('sparepart_id');
        });

        Schema::table('service_transaction_items', function (Blueprint $table) {
            // Tipe item: sparepart atau jasa tambahan
            $table->enum('item_type', ['sparepart', 'jasa'])->default('sparepart')->after('transaction_id');

            // FK sparepart (sekarang nullable — hanya diisi kalau item_type = 'sparepart')
            $table->foreignId('sparepart_id')->nullable()->constrained('spareparts')->nullOnDelete()->after('item_type');

            // Nama item manual (diisi kalau item_type = 'jasa')
            $table->string('item_name')->nullable()->after('sparepart_id');

            // Catatan opsional per baris item
            $table->string('note')->nullable()->after('item_name');

            // Tambahkan timestamps (sebelumnya tidak ada)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('service_transaction_items', function (Blueprint $table) {
            $table->dropTimestamps();
            $table->dropColumn(['item_type', 'item_name', 'note']);
            $table->dropForeign(['sparepart_id']);
            $table->dropColumn('sparepart_id');
        });

        Schema::table('service_transaction_items', function (Blueprint $table) {
            // Kembalikan ke struktur awal
            $table->foreignId('sparepart_id')->constrained('spareparts')->onDelete('cascade');
        });
    }
};
