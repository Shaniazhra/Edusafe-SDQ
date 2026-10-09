<?php

namespace App\Console\Commands;

use App\Models\HasilSdq;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

/**
 * Hitung ulang hasil Naive Bayes untuk data SDQ yang tersimpan
 * dengan status "Tidak tersedia" (misalnya karena Flask tidak
 * terjangkau saat siswa mengirim kuesioner).
 *
 * Cara pakai:
 *   php artisan sdq:hitung-ulang-nb --dry-run   (lihat dulu, tidak menyimpan)
 *   php artisan sdq:hitung-ulang-nb             (hitung dan simpan)
 *   php artisan sdq:hitung-ulang-nb --limit=5   (coba 5 data pertama)
 *
 * Aman dijalankan berulang kali: hanya baris yang masih
 * "Tidak tersedia" yang diproses, baris lain tidak disentuh.
 */
class HitungUlangNaiveBayes extends Command
{
    protected $signature = 'sdq:hitung-ulang-nb
                            {--dry-run : Tampilkan hasilnya saja, tanpa menyimpan ke database}
                            {--limit=0 : Batasi jumlah data yang diproses (0 = semua)}';

    protected $description = 'Hitung ulang hasil Naive Bayes untuk data SDQ yang berstatus "Tidak tersedia"';

    /** Berhenti kalau Flask gagal sebanyak ini berturut-turut. */
    private const MAKS_GAGAL_BERUNTUN = 3;

    public function handle(): int
    {
        $url    = env('FLASK_SDQ_URL', 'http://127.0.0.1:5000/sdq');
        $dryRun = (bool) $this->option('dry-run');
        $limit  = max(0, (int) $this->option('limit'));

        $rows = HasilSdq::query()
            ->where(function ($q) {
                $q->whereNull('hasil_naive_bayes')
                  ->orWhere('hasil_naive_bayes', '')
                  ->orWhere('hasil_naive_bayes', 'Tidak tersedia');
            })
            ->orderBy('id')
            ->when($limit > 0, fn ($q) => $q->limit($limit))
            ->get();

        if ($rows->isEmpty()) {
            $this->info('Tidak ada data yang perlu dihitung ulang.');
            return self::SUCCESS;
        }

        $this->line("Flask   : {$url}");
        $this->line("Data    : {$rows->count()} baris berstatus \"Tidak tersedia\"");
        if ($dryRun) {
            $this->warn('Mode dry-run: tidak ada yang disimpan.');
        }
        $this->newLine();

        $bar = $this->output->createProgressBar($rows->count());
        $bar->start();

        $berhasil  = 0;
        $gagal     = 0;
        $beruntun  = 0;
        $galatAkhir = null;
        $contoh    = [];
        $berubahRisiko = 0;

        foreach ($rows as $h) {
            $galat = null;
            $json  = $this->hitung($url, $h, $galat);

            if ($json === null) {
                $gagal++;
                $beruntun++;
                $galatAkhir = $galat;
                $bar->advance();

                if ($beruntun >= self::MAKS_GAGAL_BERUNTUN) {
                    $bar->finish();
                    $this->newLine(2);
                    $this->error('Dihentikan: Flask gagal ' . self::MAKS_GAGAL_BERUNTUN . ' kali berturut-turut.');
                    $this->line("Penyebab terakhir: {$galatAkhir}");
                    $this->line('Periksa: Flask sedang berjalan, FLASK_SDQ_URL di .env benar (port 5000), lalu php artisan config:clear.');
                    return self::FAILURE;
                }
                continue;
            }

            $beruntun = 0;
            $nb       = $json['hasil_naive_bayes'];
            $risikoLama = $h->risiko_ai;
            $risikoBaru = in_array($nb, ['Borderline', 'High Risk'], true) ? 'YES' : 'NO';

            if ($risikoLama !== $risikoBaru) {
                $berubahRisiko++;
            }

            if (count($contoh) < 10) {
                $contoh[] = [
                    $h->id,
                    mb_substr((string) $h->nama, 0, 24),
                    $h->hasil_label,
                    $nb,
                    ($risikoLama ?? '-') . ' -> ' . $risikoBaru,
                ];
            }

            if (!$dryRun) {
                $h->hasil_naive_bayes = $nb;
                $h->prob_normal       = $json['probabilitas']['Normal']     ?? null;
                $h->prob_borderline   = $json['probabilitas']['Borderline'] ?? null;
                $h->prob_high_risk    = $json['probabilitas']['High Risk']  ?? null;
                $h->keputusan_akhir   = $json['keputusan_akhir'] ?? null;
                $h->tindakan          = $json['tindakan']        ?? null;
                $h->akurasi_model     = $json['akurasi_model']   ?? null;
                $h->cv_score          = $json['cv_score']        ?? null;
                $h->risiko_ai         = $risikoBaru;
                $h->prob_berisiko     = (float) (($h->prob_borderline ?? 0) + ($h->prob_high_risk ?? 0));
                $h->save();
            }

            $berhasil++;
            $bar->advance();
        }

        $bar->finish();
        $this->newLine(2);

        if ($contoh) {
            $this->table(
                ['ID', 'Nama', 'SDQ baku', 'Naive Bayes', 'Risiko AI'],
                $contoh
            );
            if ($berhasil > count($contoh)) {
                $this->line('(menampilkan 10 contoh pertama)');
            }
            $this->newLine();
        }

        $this->info(($dryRun ? 'Akan dihitung ulang : ' : 'Berhasil dihitung ulang : ') . $berhasil);
        if ($gagal > 0) {
            $this->warn("Gagal                  : {$gagal} (terakhir: {$galatAkhir})");
        }
        $this->line("Risiko AI berubah      : {$berubahRisiko} siswa");

        if ($dryRun) {
            $this->newLine();
            $this->line('Jalankan tanpa --dry-run untuk menyimpan.');
        }

        return $gagal > 0 ? self::FAILURE : self::SUCCESS;
    }

    /**
     * Panggil Flask untuk satu baris. Kembalikan array hasil, atau
     * null kalau gagal (alasannya dikirim lewat $galat).
     */
    private function hitung(string $url, HasilSdq $h, ?string &$galat): ?array
    {
        try {
            $res = Http::timeout(15)->post($url, [
                'emotional'     => (int) $h->skor_emotional,
                'hyperactivity' => (int) $h->skor_hyperactivity,
                'conduct'       => (int) $h->skor_conduct,
                'peer'          => (int) $h->skor_peer,
                'prosocial'     => (int) $h->skor_prosocial,
            ]);
        } catch (\Throwable $e) {
            $galat = get_class($e) . ': ' . $e->getMessage();
            return null;
        }

        if (!$res->successful()) {
            $galat = 'HTTP ' . $res->status() . ' ' . mb_substr($res->body(), 0, 120);
            return null;
        }

        $json = $res->json();
        $nb   = is_array($json) ? ($json['hasil_naive_bayes'] ?? null) : null;

        if (empty($nb) || $nb === 'Tidak tersedia') {
            $galat = 'Flask menjawab, tetapi hasil Naive Bayes tidak tersedia (model belum termuat?)';
            return null;
        }

        return $json;
    }
}