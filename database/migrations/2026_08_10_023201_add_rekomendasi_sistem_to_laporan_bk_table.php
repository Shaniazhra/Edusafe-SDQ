<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('laporan_bk', function (Blueprint $table) {
            $table->text('rekomendasi_sistem')->nullable()->after('rekomendasi');
        });
    }

    public function down(): void
    {
        Schema::table('laporan_bk', function (Blueprint $table) {
            $table->dropColumn('rekomendasi_sistem');
        });
    }
};