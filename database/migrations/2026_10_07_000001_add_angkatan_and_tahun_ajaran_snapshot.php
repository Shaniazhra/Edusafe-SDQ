<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * - users.angkatan          : tahun masuk siswa (mis. 2024), tidak berubah.
     * - hasil_sdq.tahun_ajaran  : snapshot tahun ajaran saat skrining diisi
     *                             (mis. 2025/2026), tidak berubah.
     *
     * Kolom users.tahun_ajaran TIDAK diubah/dihapus.
     */
    public function up(): void
    {
        if (!Schema::hasColumn('users', 'angkatan')) {
            Schema::table('users', function (Blueprint $table) {
                $table->unsignedSmallInteger('angkatan')
                    ->nullable()
                    ->after('tahun_ajaran')
                    ->index();
            });
        }

        if (!Schema::hasColumn('hasil_sdq', 'tahun_ajaran')) {
            Schema::table('hasil_sdq', function (Blueprint $table) {
                $table->string('tahun_ajaran', 9)
                    ->nullable()
                    ->after('kelas')
                    ->index();
            });
        }

        // 1) Siswa AKTIF: angkatan dihitung dari kelas saat ini.
        //    users.tahun_ajaran tidak dipakai karena hampir semuanya NULL
        //    dan ada nilai yang tidak masuk akal.
        //    Kelas 7 -> angkatan = tahun mulai ajaran ini
        //    Kelas 8 -> tahun mulai - 1
        //    Kelas 9 -> tahun mulai - 2
        $now   = now('Asia/Jakarta');
        $mulai = $now->month >= 7 ? $now->year : $now->year - 1;

        DB::update("
            UPDATE users
            SET angkatan = ? - (CAST(LEFT(TRIM(kelas), 1) AS UNSIGNED) - 7)
            WHERE role = 'siswa'
              AND status = 'aktif'
              AND angkatan IS NULL
              AND TRIM(kelas) REGEXP '^[7-9]-'
        ", [$mulai]);

        // 2) Cadangan untuk siswa lain yang belum terisi:
        //    ambil 4 digit awal users.tahun_ajaran kalau ada.
        DB::statement("
            UPDATE users
            SET angkatan = CAST(LEFT(tahun_ajaran, 4) AS UNSIGNED)
            WHERE role = 'siswa'
              AND angkatan IS NULL
              AND tahun_ajaran REGEXP '^[0-9]{4}'
        ");

        // Isi tahun ajaran hasil_sdq lama dari tanggal skrining.
        // Tahun ajaran mulai bulan Juli.
        DB::statement("
            UPDATE hasil_sdq
            SET tahun_ajaran = CONCAT(
                IF(MONTH(created_at) >= 7, YEAR(created_at), YEAR(created_at) - 1),
                '/',
                IF(MONTH(created_at) >= 7, YEAR(created_at), YEAR(created_at) - 1) + 1
            )
            WHERE tahun_ajaran IS NULL
              AND created_at IS NOT NULL
        ");
    }

    public function down(): void
    {
        if (Schema::hasColumn('hasil_sdq', 'tahun_ajaran')) {
            Schema::table('hasil_sdq', function (Blueprint $table) {
                $table->dropIndex(['tahun_ajaran']);
                $table->dropColumn('tahun_ajaran');
            });
        }

        if (Schema::hasColumn('users', 'angkatan')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropIndex(['angkatan']);
                $table->dropColumn('angkatan');
            });
        }
    }
};