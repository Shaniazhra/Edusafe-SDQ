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
        Schema::table('laporan_bk', function (Blueprint $table) {
            // Cek nama index asli di MySQL secara langsung
            $indexExists = DB::select("SHOW INDEX FROM laporan_bk WHERE Key_name = 'laporan_bk_hasil_sdq_id_unique'");

            if (!empty($indexExists)) {
                $table->dropUnique('laporan_bk_hasil_sdq_id_unique');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('laporan_bk', function (Blueprint $table) {
            $table->unique('hasil_sdq_id');
        });
    }
};