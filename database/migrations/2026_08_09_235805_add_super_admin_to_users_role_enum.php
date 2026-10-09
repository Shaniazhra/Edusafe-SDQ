<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Sesuaikan daftar role di dalam ENUM() ini dengan hasil SHOW COLUMNS kamu
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('siswa','admin','super_admin') NOT NULL DEFAULT 'siswa'");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('siswa','admin') NOT NULL DEFAULT 'siswa'");
    }
};