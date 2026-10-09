<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Hapus baris kosong sisa firstOrCreate lama (belum ada rekomendasi)
        DB::table('laporan_bk')
            ->where(function ($q) {
                $q->whereNull('rekomendasi')->orWhere('rekomendasi', '');
            })
            ->delete();

        // 2. Hapus duplikat per hasil_sdq_id, sisakan yang terbaru
        $duplikat = DB::table('laporan_bk')
            ->select('hasil_sdq_id')
            ->groupBy('hasil_sdq_id')
            ->havingRaw('COUNT(*) > 1')
            ->pluck('hasil_sdq_id');

        foreach ($duplikat as $sdqId) {
            $idTerbaru = DB::table('laporan_bk')
                ->where('hasil_sdq_id', $sdqId)
                ->max('id');

            DB::table('laporan_bk')
                ->where('hasil_sdq_id', $sdqId)
                ->where('id', '!=', $idTerbaru)
                ->delete();
        }

        // 3. Tambah kolom yang dipakai model/controller tapi belum ada di migration awal,
        //    dan pasang unique index (unique() di migration awal tidak berlaku
        //    karena ditulis setelah constrained()).
        Schema::table('laporan_bk', function (Blueprint $table) {
            if (!Schema::hasColumn('laporan_bk', 'rekomendasi_sistem')) {
                $table->text('rekomendasi_sistem')->nullable()->after('rekomendasi');
            }

            $table->unique('hasil_sdq_id', 'laporan_bk_hasil_sdq_id_unique');
        });
    }

    public function down(): void
    {
        Schema::table('laporan_bk', function (Blueprint $table) {
            $table->dropUnique('laporan_bk_hasil_sdq_id_unique');

            if (Schema::hasColumn('laporan_bk', 'rekomendasi_sistem')) {
                $table->dropColumn('rekomendasi_sistem');
            }
        });
    }
};