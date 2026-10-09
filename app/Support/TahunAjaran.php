<?php

namespace App\Support;

use Carbon\CarbonInterface;

class TahunAjaran
{
    /**
     * Tahun mulai tahun ajaran untuk tanggal tertentu.
     * Tahun ajaran Indonesia dimulai bulan Juli.
     *
     * Contoh: Oktober 2026 -> 2026, Maret 2027 -> 2026.
     */
    public static function tahunMulai(?CarbonInterface $tanggal = null): int
    {
        $tanggal = $tanggal ?? now('Asia/Jakarta');

        return $tanggal->month >= 7
            ? $tanggal->year
            : $tanggal->year - 1;
    }

    /**
     * Tahun ajaran dalam format "2026/2027".
     */
    public static function sekarang(?CarbonInterface $tanggal = null): string
    {
        $mulai = self::tahunMulai($tanggal);

        return $mulai . '/' . ($mulai + 1);
    }
}