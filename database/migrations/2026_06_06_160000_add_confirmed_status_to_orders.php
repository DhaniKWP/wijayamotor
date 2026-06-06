<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Update enum column to add 'confirmed' status
        DB::statement("ALTER TABLE orders MODIFY COLUMN status ENUM('pending','confirmed','done') NOT NULL DEFAULT 'pending'");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE orders MODIFY COLUMN status ENUM('pending','paid','shipped','done') NOT NULL DEFAULT 'pending'");
    }
};
