<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Alter ENUM to include 'cancelled'
        DB::statement("ALTER TABLE orders MODIFY COLUMN status ENUM('pending', 'paid', 'shipped', 'done', 'cancelled') DEFAULT 'pending'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert ENUM to remove 'cancelled' (Note: will fail if any row has 'cancelled' status)
        DB::statement("ALTER TABLE orders MODIFY COLUMN status ENUM('pending', 'paid', 'shipped', 'done') DEFAULT 'pending'");
    }
};
