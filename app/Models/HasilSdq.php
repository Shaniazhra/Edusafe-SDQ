<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HasilSdq extends Model
{
    protected $table = 'hasil_sdq';

    protected $fillable = [
        'nama', 'kelas',
        'sdq1','sdq2','sdq3','sdq4','sdq5',
        'sdq6','sdq7','sdq8','sdq9','sdq10',
        'sdq11','sdq12','sdq13','sdq14','sdq15',
        'sdq16','sdq17','sdq18','sdq19','sdq20',
        'sdq21','sdq22','sdq23','sdq24','sdq25',
        'skor_emotional','skor_conduct',
        'skor_hyperactivity','skor_peer','skor_prosocial',
        'total_kesulitan','hasil_label',
        'samuel_depresi','samuel_kecemasan',
        'samuel_kesejahteraan','samuel_kelompok',
        'risiko_ai','prob_berisiko',
        'hasil_naive_bayes',
        'prob_normal','prob_borderline','prob_high_risk',
        'keputusan_akhir','tindakan',
        'akurasi_model','cv_score',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Interpretasi per-subskala untuk siswa ini.
     * Threshold: skor >= 5 (dari 10) = terindikasi.
     * Untuk prosocial, logikanya dibalik (skor tinggi = baik).
     */
    public function interpretasiSubskala(): array
    {
        $subskala = [
            'emotional' => [
                'label' => 'Gejala Emosional',
                'skor'  => $this->skor_emotional,
                'color' => '#3B82F6',
                'below' => 'Kondisi emosional relatif stabil — jarang cemas, sedih berlebihan, atau mengeluh sakit tanpa sebab jelas.',
                'above' => 'Terindikasi gejala emosional: mudah cemas, sering sedih/tidak bahagia, khawatir berlebihan, atau keluhan fisik terkait stres.',
            ],
            'conduct' => [
                'label' => 'Masalah Perilaku',
                'skor'  => $this->skor_conduct,
                'color' => '#1D4ED8',
                'below' => 'Mampu mengendalikan diri dengan baik — jarang menunjukkan perilaku menentang atau agresif.',
                'above' => 'Terindikasi masalah perilaku: mudah marah, sering berbohong, melanggar aturan, atau bersikap agresif ke orang lain.',
            ],
            'hyperactivity' => [
                'label' => 'Hiperaktivitas',
                'skor'  => $this->skor_hyperactivity,
                'color' => '#F59E0B',
                'below' => 'Mampu berkonsentrasi dengan baik dan tidak menunjukkan gejala hiperaktif berlebihan.',
                'above' => 'Terindikasi kesulitan fokus, gelisah, impulsif, atau sulit menyelesaikan tugas hingga tuntas.',
            ],
            'peer' => [
                'label' => 'Masalah Teman Sebaya',
                'skor'  => $this->skor_peer,
                'color' => '#0284C7',
                'below' => 'Relasi sosial cenderung baik — memiliki teman dan tidak menunjukkan tanda dikucilkan.',
                'above' => 'Terindikasi kesulitan berteman, cenderung menyendiri, atau sering diganggu/dikucilkan teman sebaya.',
            ],
            'prosocial' => [
                'label'   => 'Perilaku Prososial',
                'skor'    => $this->skor_prosocial,
                'color'   => '#10B981',
                'reverse' => true,
                'below'   => 'Terindikasi kurangnya perilaku prososial — jarang menunjukkan empati, berbagi, atau membantu orang lain.',
                'above'   => 'Menunjukkan perilaku prososial yang baik — suka menolong, berbagi, dan peduli terhadap orang lain.',
            ],
        ];

        foreach ($subskala as $key => &$item) {
            $item['persen']  = round(($item['skor'] / 10) * 100);
            $item['tinggi']  = $item['skor'] >= 5;
            $item['catatan'] = $item['tinggi'] ? $item['above'] : $item['below'];

            if (!empty($item['reverse'])) {
                $item['warna_catatan'] = $item['tinggi'] ? 'text-[#059669]' : 'text-[#D97706]';
            } else {
                $item['warna_catatan'] = $item['tinggi'] ? 'text-[#D97706]' : 'text-[#059669]';
            }
        }
        unset($item);

        return $subskala;
    }
}