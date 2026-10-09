@php
    $logoUrl = \App\Models\Pengaturan::url('logo', 'logo-smpn216.png');
@endphp
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasil Skrining Saya — SMPN 216 Jakarta</title>
    <link rel="icon" type="image/png" href="{{ $logoUrl }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Source+Serif+4:wght@400;500;600;700&display=swap" rel="stylesheet">
    @vite('resources/css/tema.css')
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">
    <style>
        :root {
            --navy: #0F2747; --brand: #1D5FBF; --brand-deep: #174E9E; --brand-soft: #E8F0FB; --bg: #F3F5F9;
            --ink: #14233B; --ink-2: #475569; --ink-3: #6B7A90; --line: #E3E8F0;
            --ok: #0F8A5F;   --ok-bg: #E3F5ED;
            --warn: #B7690B; --warn-bg: #FDF1DC;
            --bad: #B93838;  --bad-bg: #FCE9E9;
            --ai: #0A78B5;   --ai-bg: #E2F2FA;
        }

        html { scroll-behavior: smooth; scroll-padding-top: 80px; }
        body { font-family: var(--font-sans); color: var(--ink);
            background: radial-gradient(900px 400px at 85% -80px, #DCE8FA 0%, transparent 70%), var(--bg); background-attachment: fixed; }
        .material-symbols-outlined { font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24; }
        :focus-visible { outline: 2px solid var(--brand); outline-offset: 2px; }

        /* Komponen dasar */
        .card { background: #fff; border: 1px solid var(--line); border-radius: 14px; box-shadow: 0 1px 2px rgba(15,39,71,.05), 0 8px 24px -16px rgba(15,39,71,.18); }
        .ico { width: 36px; height: 36px; border-radius: 10px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; background: var(--brand-soft); color: var(--brand); }
        .h-title { font-size: .9rem; font-weight: 700; color: var(--ink); }
        .h-sub { font-size: .75rem; color: var(--ink-3); margin-top: 2px; }
        .badge { display: inline-block; padding: 3px 10px; border-radius: 999px; font-size: .72rem; font-weight: 700; white-space: nowrap; }
        .b-ok { background: var(--ok-bg); color: var(--ok); }
        .b-warn { background: var(--warn-bg); color: var(--warn); }
        .b-bad { background: var(--bad-bg); color: var(--bad); }
        .b-ai { background: var(--ai-bg); color: var(--ai); }

        .btn { display: inline-flex; align-items: center; justify-content: center; gap: 8px; padding: 12px 22px; min-height: 46px; border-radius: 12px; font-size: .875rem; font-weight: 700; transition: transform .12s ease, background .15s ease, border-color .15s ease, color .15s ease; border: 1px solid transparent; cursor: pointer; }
        .btn:active { transform: scale(.98); }
        .btn-primary { background: var(--brand); color: #fff; box-shadow: 0 10px 20px -12px var(--brand); }
        .btn-primary:hover { background: var(--brand-deep); }
        .btn-ghost { background: #fff; color: var(--ink-2); border-color: var(--line); }
        .btn-ghost:hover { color: var(--brand); border-color: #B9D0F2; background: var(--brand-soft); }
        .btn-white { display: inline-flex; align-items: center; justify-content: center; gap: 8px; padding: 12px 20px; border-radius: 12px; background: #fff; color: var(--navy); font-size: .875rem; font-weight: 700; box-shadow: 0 10px 20px -10px rgba(0,0,0,.25); transition: background .15s, transform .12s; }
        .btn-white:hover { background: var(--brand-soft); }

        /* Hero */
        .hero { position: relative; overflow: hidden; border-radius: 20px; padding: 28px; color: #fff; background: linear-gradient(120deg, #0B1F3A 0%, #15407F 55%, #2B78E0 100%); box-shadow: 0 18px 40px -18px rgba(21,64,127,.65); }
        .hero-ring { position: absolute; border-radius: 50%; border: 1px solid rgba(255,255,255,.14); pointer-events: none; }
        .hero-ring.r1 { width: 380px; height: 380px; right: -90px; top: -150px; background: radial-gradient(circle, rgba(255,255,255,.12), transparent 70%); }
        .hero-ring.r2 { width: 230px; height: 230px; right: 190px; bottom: -130px; }
        .hero-chip { display: inline-flex; align-items: center; gap: 7px; padding: 8px 13px; border-radius: 10px; background: rgba(255,255,255,.1); border: 1px solid rgba(255,255,255,.2); font-size: .78rem; font-weight: 600; line-height: 1.2; }
        .hero-initial { width: 60px; height: 60px; border-radius: 16px; flex-shrink: 0; display: flex; align-items: center; justify-content: center; background: rgba(255,255,255,.14); border: 1px solid rgba(255,255,255,.22); font-size: 1.15rem; font-weight: 800; }
        .ring-arc { stroke-dasharray: var(--len) 400; animation: ringfill 1.1s .2s cubic-bezier(.4,0,.2,1) both; }
        @keyframes ringfill { from { stroke-dasharray: 0 400; } }
        .sdq-pill { display: inline-block; padding: 4px 13px; border-radius: 999px; background: #fff; font-size: .72rem; font-weight: 800; box-shadow: 0 6px 14px -8px rgba(0,0,0,.4); }

        /* Pengingat */
        .remind { padding: 18px 20px; display: flex; flex-direction: column; gap: 16px; }
        @media (min-width: 768px) { .remind { flex-direction: row; align-items: center; justify-content: space-between; } }
        .remind.due { border-color: #9DBDEB; background: linear-gradient(135deg, #F4F8FE 0%, #EAF2FD 100%); box-shadow: 0 0 0 3px rgba(29,95,191,.08), 0 12px 28px -16px rgba(29,95,191,.4); }
        .remind.due .ico { background: var(--brand); color: #fff; }
        .rbar { height: 8px; border-radius: 999px; background: #E7ECF4; overflow: hidden; }
        .rbar > i { display: block; height: 100%; border-radius: 999px; background: linear-gradient(90deg, #5B9DF5, var(--brand)); transition: width 1s cubic-bezier(.4,0,.2,1); }

        /* Kartu aspek */
        .acard { position: relative; overflow: hidden; display: flex; flex-direction: column; padding: 18px 16px 16px; transition: transform .2s, box-shadow .2s; }
        .acard:hover { transform: translateY(-3px); box-shadow: 0 14px 28px -14px rgba(15,39,71,.35); }
        .acard::before { content: ''; position: absolute; left: 0; right: 0; top: 0; height: 4px; background: var(--c); }
        .acard .tile { width: 44px; height: 44px; border-radius: 13px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; color: #fff; background: linear-gradient(135deg, var(--c), color-mix(in srgb, var(--c) 65%, #fff)); box-shadow: 0 8px 16px -6px var(--c); }
        .bar-track { height: 8px; border-radius: 999px; background: #EEF1F6; overflow: hidden; }
        .animate-bar { height: 100%; border-radius: 999px; transition: width 1s cubic-bezier(.4,0,.2,1); }
        .dot { width: 8px; height: 8px; border-radius: 50%; display: inline-block; margin-right: 6px; }
        .more summary { list-style: none; }
        .more summary::-webkit-details-marker { display: none; }
        .more .chev { transition: transform .2s ease; }
        .more[open] .chev { transform: rotate(180deg); }
        .step-n { width: 30px; height: 30px; border-radius: 50%; background: var(--brand); color: #fff; font-weight: 700; font-size: .85rem; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }

        /* Menu bawah (HP) */
        .bottom-nav { position: fixed; z-index: 40; left: 50%; transform: translateX(-50%); bottom: calc(14px + env(safe-area-inset-bottom)); width: calc(100% - 28px); max-width: 440px; display: flex; align-items: center; justify-content: space-between; gap: 4px; padding: 8px; background: #fff; border-radius: 999px; box-shadow: 0 14px 34px -10px rgba(15,39,71,.38), 0 2px 6px rgba(15,39,71,.08); }
        .bn-item { display: flex; align-items: center; justify-content: center; gap: 8px; height: 46px; min-width: 46px; padding: 0 12px; border-radius: 999px; color: var(--brand); font-size: .85rem; font-weight: 600; white-space: nowrap; background: transparent; border: 0; cursor: pointer; transition: background .2s ease, color .2s ease, padding .2s ease; }
        .bn-item .material-symbols-outlined { font-variation-settings: 'FILL' 1, 'wght' 500, 'GRAD' 0, 'opsz' 24; }
        .bn-item .label { display: none; }
        .bn-item:not(.active):hover { background: var(--brand-soft); }
        .bn-item.active { background: var(--brand); color: #fff; padding: 0 20px; }
        .bn-item.active .label { display: inline; }
        @media (min-width: 1024px) { .bottom-nav { display: none; } }

        @media (prefers-reduced-motion: reduce) {
            html { scroll-behavior: auto; }
            .acard, .animate-bar, .bn-item, .rbar > i { transition: none !important; }
            .ring-arc { animation: none !important; }
        }
    </style>
</head>
<body class="flex min-h-screen">

@php
    // ================= DATA =================
    // $riwayat       : semua hasil milik siswa ini (terbaru di atas), dipakai untuk pengingat isi ulang
    // $hasilTerakhir : hasil terbaru
    $riwayat = isset($riwayat) ? collect($riwayat)->values() : collect();
    $terbaru = $hasilTerakhir ?? $riwayat->first();
    $h       = $terbaru;
    $isRisikoAI = $h && ($h->risiko_ai ?? '') === 'YES';

    // ================= PENGATURAN =================
    $intervalHari = 90;   // saran jarak antar pengisian (hari), samakan dengan detail riwayat BK

    // ================= STATUS =================
    $warna = [
        'hijau'  => ['bar' => '#16A47A', 'fg' => '#0F8A5F', 'badge' => 'b-ok',   'label' => 'Baik'],
        'kuning' => ['bar' => '#E39A25', 'fg' => '#B7690B', 'badge' => 'b-warn', 'label' => 'Perlu diperhatikan'],
        'merah'  => ['bar' => '#D95454', 'fg' => '#B93838', 'badge' => 'b-bad',  'label' => 'Perlu dukungan'],
    ];
    // Pola risiko dari AI pada hasil Normal diperlakukan sebagai "Perlu diperhatikan"
    $kunciStatus = function ($r) {
        $ai = ($r->risiko_ai ?? '') === 'YES';
        return ($ai && $r->hasil_label === 'Normal') ? 'Borderline' : ($r->hasil_label ?? 'Normal');
    };

    // ================= DEFINISI ASPEK =================
    $defAspek = [
        ['key' => 'skor_emotional', 'judul' => 'Perasaan', 'label' => 'Gejala Emosional', 'icon' => 'mood', 'reverse' => false, 'cut' => [5, 6],
         'teks' => [
            'hijau'  => 'Suasana hatimu terlihat cukup seimbang akhir-akhir ini.',
            'kuning' => 'Sepertinya ada beberapa hal yang cukup menyita pikiranmu. Bercerita kepada orang yang kamu percaya bisa terasa melegakan.',
            'merah'  => 'Sepertinya ada cukup banyak hal yang sedang kamu bawa sendiri. Kamu tidak harus menghadapinya sendirian, Guru BK siap menemanimu kapan pun kamu mau.']],
        ['key' => 'skor_conduct', 'judul' => 'Sikap dan aturan', 'label' => 'Masalah Perilaku', 'icon' => 'rule', 'reverse' => false, 'cut' => [3, 4],
         'teks' => [
            'hijau'  => 'Kamu terlihat cukup mudah menyesuaikan diri dengan aturan dan situasi di sekitarmu.',
            'kuning' => 'Menyesuaikan diri dengan aturan atau situasi tertentu kadang terasa menantang. Itu wajar dan bisa dilatih pelan-pelan.',
            'merah'  => 'Mungkin ada situasi yang terasa cukup berat dihadapi akhir-akhir ini. Guru BK bisa menjadi teman bertukar pikiran tanpa menghakimi.']],
        ['key' => 'skor_hyperactivity', 'judul' => 'Fokus dan energi', 'label' => 'Hiperaktivitas', 'icon' => 'center_focus_strong', 'reverse' => false, 'cut' => [5, 6],
         'teks' => [
            'hijau'  => 'Kamu terlihat cukup mudah memusatkan perhatian pada kegiatan belajar.',
            'kuning' => 'Memusatkan perhatian mungkin terasa agak menantang di beberapa waktu. Cara belajar yang pas bisa membantu.',
            'merah'  => 'Belajar dan menyelesaikan tugas mungkin terasa lebih melelahkan dari biasanya. Guru BK dapat membantumu mencari cara yang cocok.']],
        ['key' => 'skor_peer', 'judul' => 'Pertemanan', 'label' => 'Hubungan dengan Teman Sebaya', 'icon' => 'groups', 'reverse' => false, 'cut' => [2, 3],
         'teks' => [
            'hijau'  => 'Hubunganmu dengan teman-teman terlihat cukup nyaman.',
            'kuning' => 'Pertemanan kadang punya naik turunnya sendiri. Berbincang dengan seseorang dapat membantumu melihatnya lebih jelas.',
            'merah'  => 'Mungkin ada hal di lingkungan pertemananmu yang ingin kamu ceritakan. Ruang BK selalu terbuka untukmu.']],
        ['key' => 'skor_prosocial', 'judul' => 'Peduli dan berbagi', 'label' => 'Perilaku Prososial', 'icon' => 'volunteer_activism', 'reverse' => true, 'cut' => [4, 5],
         'teks' => [
            'hijau'  => 'Kamu terlihat peduli dan senang membantu orang lain. Pertahankan ya.',
            'kuning' => 'Kepedulianmu sudah terlihat dan masih bisa tumbuh lewat hal-hal kecil sehari-hari.',
            'merah'  => 'Kepedulian bisa dimulai dari hal kecil, misalnya menyapa atau menemani teman. Kamu bisa mencobanya pelan-pelan.']],
    ];
    // Status (hijau/kuning/merah) satu aspek dari nilainya
    $statusAspek = function ($a, $val) {
        [$low, $high] = $a['cut'];
        return !$a['reverse']
            ? ($val <= $low ? 'hijau' : ($val <= $high ? 'kuning' : 'merah'))
            : ($val <= $low ? 'merah' : ($val <= $high ? 'kuning' : 'hijau'));
    };
    $subskala = $h ? array_map(fn ($a) => $a + ['val' => (int) $h->{$a['key']}], $defAspek) : [];

    // ================= RINGKASAN HERO =================
    $ringkasan = [
        'Normal'     => ['Kondisimu terlihat baik.', 'Hasil skriningmu menunjukkan keadaan yang baik. Teruslah menjaga kebiasaan baikmu dan bercerita kepada orang yang kamu percaya.'],
        'Borderline' => ['Ada beberapa hal yang perlu diperhatikan.', 'Tidak perlu khawatir. Hasil ini hanya gambaran awal, dan Guru BK dengan senang hati menemanimu berbincang kapan saja.'],
        'Abnormal'   => ['Kamu tidak sendirian.', 'Guru BK siap mendampingimu. Datanglah ke ruang BK kapan pun kamu merasa nyaman untuk berbincang.'],
    ];
    $sdqTone = [
        'Normal'     => ['Normal', '#0F8A5F', '#34D399'],
        'Borderline' => ['Perlu diperhatikan', '#B7690B', '#FBBF24'],
        'Abnormal'   => ['Perlu dukungan', '#B93838', '#FDA4AF'],
    ];
    $tone    = $sdqTone[$h->hasil_label ?? 'Normal'] ?? $sdqTone['Normal'];
    $ringC   = 2 * M_PI * 46;
    $ringLen = $h ? round(min(1, max(0, $h->total_kesulitan / 40)) * $ringC, 1) : 0;

    // ================= WAKTU =================
    $sekarang    = now('Asia/Jakarta')->locale('id');
    $jam         = (int) $sekarang->format('H');
    $sapaan      = $jam < 11 ? 'Selamat pagi' : ($jam < 15 ? 'Selamat siang' : ($jam < 18 ? 'Selamat sore' : 'Selamat malam'));
    $namaDepan   = \Illuminate\Support\Str::words(Auth::user()->name ?? '', 1, '');
    $inisial     = strtoupper(substr(Auth::user()->name ?? 'S', 0, 2));
    $tglSkrining = $h ? $h->created_at->copy()->timezone('Asia/Jakarta')->locale('id') : null;
    $rg          = $ringkasan[$h ? $kunciStatus($h) : 'Normal'] ?? $ringkasan['Normal'];

    // Tahun ajaran saat hasil terbaru diisi (snapshot). Hasil lama yang belum
    // terisi dihitung dari tanggal skriningnya.
    $tahunAjaran = $h
        ? ($h->tahun_ajaran ?: \App\Support\TahunAjaran::sekarang($h->created_at))
        : null;

    // ================= PENGINGAT ISI ULANG (berdasar hasil TERBARU) =================
    $infoUlang = null;
    if ($terbaru) {
        $tglTerbaru = $terbaru->created_at->copy()->timezone('Asia/Jakarta')->locale('id');
        $hariSejak  = (int) floor($sekarang->copy()->startOfDay()->diffInDays($tglTerbaru->copy()->startOfDay(), true));
        $sisaHari   = $intervalHari - $hariSejak;
        $infoUlang  = [
            'tgl'        => $tglTerbaru->translatedFormat('j F Y'),
            'sisa'       => max(0, $sisaHari),
            'sudah'      => $sisaHari <= 0,
            'berikutnya' => $tglTerbaru->copy()->addDays($intervalHari)->translatedFormat('j F Y'),
            'persen'     => min(100, round($hariSejak / $intervalHari * 100)),
            'lalu'       => $hariSejak === 0 ? 'hari ini' : $hariSejak . ' hari lalu',
        ];
    }
@endphp

{{-- ================= SIDEBAR (desktop) ================= --}}
@include('partials.sidebar_dashboard_siswa')

{{-- ================= MAIN ================= --}}
<main class="flex-1 min-w-0 flex flex-col pb-28 lg:pb-0">

    <header class="h-16 bg-white/90 backdrop-blur-md border-b border-[#E3E8F0] flex items-center justify-between px-4 md:px-8 sticky top-0 z-30">
        <a href="{{ url('/') }}" class="flex items-center gap-2.5 min-w-0 lg:hidden">
            <span class="w-9 h-9 rounded-xl overflow-hidden border border-[#E3E8F0] flex-shrink-0">
                <img src="{{ $logoUrl }}" alt="Logo SMPN 216" class="w-full h-full object-contain">
            </span>
            <span class="font-bold text-[15px] truncate">SMPN 216 Jakarta</span>
        </a>
        <div class="hidden lg:block">
            <h2 class="text-base md:text-lg font-bold text-[#14233B] leading-tight">Hasil Skrining Saya</h2>
            <p class="text-xs text-[#6B7A90]">Lihat hasil dan saran dari skriningmu</p>
        </div>
        <span class="text-xs font-medium text-[#475569] hidden sm:flex items-center gap-2 px-3 py-2 rounded-lg bg-[#F3F5F9] border border-[#E3E8F0]">
            <span class="material-symbols-outlined" style="font-size:16px">calendar_today</span>
            {{ $sekarang->isoFormat('dddd, D MMMM Y') }}
        </span>
    </header>

    <div class="flex-1 px-4 md:px-8 py-4 md:py-8 space-y-6 w-full">

        @if(session('info'))
        <div class="bg-[#E8F0FB] border border-[#CFE0F7] text-[#1D4F9C] text-sm font-medium px-4 py-3 rounded-xl flex items-center gap-2" role="status">
            <span class="material-symbols-outlined" style="font-size:20px">info</span>
            {{ session('info') }}
        </div>
        @endif

        <div class="space-y-6">

        @if($h)

            {{-- Hero: sapaan + ringkasan + total skor --}}
            <section class="hero">
                <div class="hero-ring r1"></div><div class="hero-ring r2"></div>
                <div class="relative flex flex-col lg:flex-row lg:items-center justify-between gap-6">
                    <div class="flex items-center gap-4 min-w-0">
                        <div class="hero-initial hidden sm:flex" aria-hidden="true">{{ $inisial }}</div>
                        <div class="min-w-0 max-w-2xl">
                            <h3 class="text-xl md:text-2xl font-bold leading-tight">{{ $sapaan }}, {{ $namaDepan }}</h3>
                            <p class="text-sm text-blue-100 mt-2 leading-relaxed">
                                <strong class="text-white">{{ $rg[0] }}</strong> {{ $rg[1] }}
                            </p>
                            <div class="mt-4 flex flex-wrap gap-2">
                                <span class="hero-chip"><span class="material-symbols-outlined" style="font-size:16px">fiber_new</span>Hasil terbaru</span>
                                <span class="hero-chip"><span class="material-symbols-outlined" style="font-size:16px">school</span>Kelas {{ Auth::user()->kelas }}</span>
                                <span class="hero-chip"><span class="material-symbols-outlined" style="font-size:16px">date_range</span>Tahun Ajaran {{ $tahunAjaran }}</span>
                                @if(!empty(Auth::user()->nis))
                                <span class="hero-chip"><span class="material-symbols-outlined" style="font-size:16px">badge</span>NIS {{ Auth::user()->nis }}</span>
                                @endif
                                <span class="hero-chip"><span class="material-symbols-outlined" style="font-size:16px">calendar_month</span>{{ $tglSkrining->translatedFormat('j F Y') }}</span>
                                <span class="hero-chip"><span class="material-symbols-outlined" style="font-size:16px">schedule</span>{{ $tglSkrining->format('H.i') }} WIB · {{ $tglSkrining->diffForHumans() }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="flex flex-col items-center gap-2 flex-shrink-0 self-start lg:self-center lg:mr-2">
                        <div class="relative" style="width:108px;height:108px" role="img" aria-label="Total skor kesulitan {{ $h->total_kesulitan }} dari 40">
                            <svg viewBox="0 0 108 108" width="108" height="108" class="-rotate-90" aria-hidden="true">
                                <circle cx="54" cy="54" r="46" fill="none" stroke="rgba(255,255,255,.28)" stroke-width="8"/>
                                <circle class="ring-arc" cx="54" cy="54" r="46" fill="none" stroke="{{ $tone[2] }}" stroke-width="8" stroke-linecap="round" style="--len:{{ $ringLen }}"/>
                            </svg>
                            <div class="absolute inset-0 flex flex-col items-center justify-center">
                                <span class="text-3xl font-extrabold leading-none">{{ $h->total_kesulitan }}</span>
                                <span class="text-xs text-white/85 mt-1">dari 40</span>
                            </div>
                        </div>
                        <p class="text-xs text-white/85">Total skor kesulitan</p>
                        <span class="sdq-pill" style="color:{{ $tone[1] }}">SDQ: {{ $tone[0] }}</span>
                    </div>
                </div>
            </section>

            {{-- Pengingat isi ulang --}}
            @if($infoUlang)
            <section class="card remind {{ $infoUlang['sudah'] ? 'due' : '' }}" aria-labelledby="judul-ulang">
                <div class="flex items-start gap-3 min-w-0 flex-1">
                    <span class="ico"><span class="material-symbols-outlined" style="font-size:20px">{{ $infoUlang['sudah'] ? 'notifications_active' : 'event_repeat' }}</span></span>
                    <div class="min-w-0 flex-1">
                        <h4 id="judul-ulang" class="h-title">{{ $infoUlang['sudah'] ? 'Sudah waktunya mengisi ulang' : 'Pengisian berikutnya' }}</h4>
                        <p class="h-sub" style="font-size:.8rem;line-height:1.6">
                            @if($infoUlang['sudah'])
                                Terakhir kamu mengisi pada {{ $infoUlang['tgl'] }} ({{ $infoUlang['lalu'] }}). Mengisi secara berkala membantu kamu dan Guru BK melihat perkembanganmu.
                            @else
                                Terakhir mengisi pada {{ $infoUlang['tgl'] }} ({{ $infoUlang['lalu'] }}). Disarankan mengisi lagi sekitar <strong class="text-[#14233B]">{{ $infoUlang['berikutnya'] }}</strong>, kira-kira {{ $infoUlang['sisa'] }} hari lagi. Kalau merasa ada perubahan, kamu boleh mengisi lebih awal.
                            @endif
                        </p>
                        <div class="mt-3 max-w-md">
                            <div class="rbar" role="img" aria-label="{{ $infoUlang['persen'] }} persen menuju waktu isi ulang"><i data-bar style="width:{{ $infoUlang['persen'] }}%"></i></div>
                            <div class="flex justify-between text-[11px] text-[#6B7A90] mt-1.5">
                                <span>Terakhir mengisi</span><span>{{ $infoUlang['sudah'] ? 'Waktunya isi ulang' : 'Disarankan isi ulang' }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                <a href="/sdq" class="btn {{ $infoUlang['sudah'] ? 'btn-primary' : 'btn-ghost' }} w-full md:w-auto flex-shrink-0">
                    <span class="material-symbols-outlined" style="font-size:19px">assignment</span>
                    {{ $infoUlang['sudah'] ? 'Isi kuesioner sekarang' : 'Isi lebih awal' }}
                </a>
            </section>
            @endif

            {{-- Hasil per aspek --}}
            <section aria-labelledby="judul-aspek">
                <div class="flex items-start gap-3 mb-4">
                    <span class="ico"><span class="material-symbols-outlined" style="font-size:20px">bar_chart</span></span>
                    <div>
                        <h4 id="judul-aspek" class="h-title">Hasil per aspek</h4>
                        <p class="h-sub">Ada 5 hal yang dilihat dari jawabanmu. Buka &quot;Penjelasan&quot; untuk membaca lebih lanjut.</p>
                        <div class="flex flex-wrap gap-x-4 gap-y-1 mt-2 text-xs text-[#475569]" aria-label="Arti warna">
                            <span><i class="dot" style="background:#16A47A"></i>Baik</span>
                            <span><i class="dot" style="background:#E39A25"></i>Perlu diperhatikan</span>
                            <span><i class="dot" style="background:#D95454"></i>Perlu dukungan</span>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-2 md:grid-cols-6 xl:grid-cols-5 gap-3 md:gap-4">
                    @foreach($subskala as $a)
                        @php
                            $status = $statusAspek($a, $a['val']);
                            $w = $warna[$status];
                            $span = ($loop->iteration === 5 ? 'col-span-2' : '')
                                  . ' ' . ($loop->iteration <= 3 ? 'md:col-span-2' : 'md:col-span-3')
                                  . ' xl:col-span-1';
                        @endphp
                        <article class="card acard {{ $span }}" style="--c:{{ $w['fg'] }}">
                            <div class="flex items-start justify-between gap-2">
                                <span class="tile"><span class="material-symbols-outlined" style="font-size:24px">{{ $a['icon'] }}</span></span>
                                <span class="text-xl font-extrabold leading-none mt-1" style="color:{{ $w['fg'] }}">{{ $a['val'] }}<span class="text-[11px] font-semibold text-[#6B7A90]">/10</span></span>
                            </div>
                            <h5 class="text-[13px] font-semibold text-[#14233B] mt-3 leading-tight">{{ $a['judul'] }}</h5>
                            <p class="text-[11.5px] text-[#6B7A90] mt-0.5 leading-snug">{{ $a['label'] }}</p>
                            <div class="bar-track mt-3" role="img" aria-label="{{ $a['judul'] }}: {{ $a['val'] }} dari 10">
                                <div data-bar class="animate-bar" style="width:{{ ($a['val'] / 10) * 100 }}%;background:{{ $w['bar'] }}"></div>
                            </div>
                            <span class="badge {{ $w['badge'] }} mt-3 self-start">{{ $w['label'] }}</span>
                            <details class="more mt-3 pt-3 border-t border-[#E3E8F0]" {{ $status !== 'hijau' ? 'open' : '' }}>
                                <summary class="flex items-center justify-between text-xs font-semibold text-[#1D5FBF] cursor-pointer">
                                    Penjelasan
                                    <span class="material-symbols-outlined chev" style="font-size:18px">expand_more</span>
                                </summary>
                                <p class="text-xs leading-relaxed text-[#475569] mt-2">{{ $a['teks'][$status] }}</p>
                            </details>
                        </article>
                    @endforeach
                </div>
            </section>

            {{-- Catatan dari sistem (AI) --}}
            <section class="card acard" style="--c:#0A78B5;padding:20px 18px 18px">
                <div class="flex items-center gap-3">
                    <span class="tile"><span class="material-symbols-outlined" style="font-size:24px">auto_awesome</span></span>
                    <div class="min-w-0 flex-1">
                        <h4 class="text-[15px] font-bold leading-tight text-[#14233B]">Catatan untukmu</h4>
                        <p class="text-[11.5px] text-[#6B7A90] mt-0.5">Dari analisis otomatis (AI) untuk membantu Guru BK</p>
                    </div>
                </div>
                @if($isRisikoAI)
                    <p class="mt-3.5"><span class="badge b-ai">Disarankan berbincang dengan Guru BK</span></p>
                    <p class="text-[13.5px] leading-relaxed text-[#475569] mt-2">Berdasarkan jawabanmu, ada beberapa hal yang akan lebih baik dibicarakan secara langsung. Ini bukan hukuman maupun teguran. Guru BK akan mengajakmu berbincang dengan nyaman agar kamu merasa didukung.</p>
                @else
                    <p class="mt-3.5"><span class="badge b-ok">Tidak ada yang perlu dikhawatirkan</span></p>
                    <p class="text-[13.5px] leading-relaxed text-[#475569] mt-2">Kondisimu terlihat baik. Tetap jaga diri dengan beristirahat cukup, bercerita kepada orang yang kamu percaya, dan melakukan hal yang kamu sukai.</p>
                @endif
            </section>

            {{-- Yang bisa dilakukan --}}
            <section aria-labelledby="judul-langkah">
                <div class="flex items-start gap-3 mb-4">
                    <span class="ico"><span class="material-symbols-outlined" style="font-size:20px">lightbulb</span></span>
                    <div>
                        <h4 id="judul-langkah" class="h-title">Apa yang bisa kamu lakukan?</h4>
                        <p class="h-sub">Tidak harus semuanya. Pilih yang paling nyaman untukmu.</p>
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="card p-4 flex gap-3 items-start">
                        <span class="ico"><span class="material-symbols-outlined" style="font-size:20px">forum</span></span>
                        <p class="text-[13px] leading-relaxed text-[#475569]"><b class="block text-sm text-[#14233B] mb-0.5">Temui Guru BK</b>Ruang BK terbuka untuk semua siswa, kapan saja.</p>
                    </div>
                    <div class="card p-4 flex gap-3 items-start">
                        <span class="ico"><span class="material-symbols-outlined" style="font-size:20px">group</span></span>
                        <p class="text-[13px] leading-relaxed text-[#475569]"><b class="block text-sm text-[#14233B] mb-0.5">Bercerita kepada orang terdekat</b>Misalnya keluarga atau wali kelas yang kamu percaya.</p>
                    </div>
                    <div class="card p-4 flex gap-3 items-start">
                        <span class="ico"><span class="material-symbols-outlined" style="font-size:20px">spa</span></span>
                        <p class="text-[13px] leading-relaxed text-[#475569]"><b class="block text-sm text-[#14233B] mb-0.5">Jaga dirimu</b>Istirahat cukup dan lakukan hal yang kamu sukai.</p>
                    </div>
                </div>
                <p class="text-xs leading-relaxed text-[#6B7A90] mt-4">Skrining ini bukan tes dan bukan diagnosis. Hasilnya hanya dapat dilihat olehmu dan Guru BK.</p>
            </section>

        @else

            {{-- Belum ada hasil --}}
            <section class="hero">
                <div class="hero-ring r1"></div><div class="hero-ring r2"></div>
                <div class="relative flex flex-col lg:flex-row lg:items-center justify-between gap-6">
                    <div class="flex items-center gap-4 min-w-0">
                        <div class="hero-initial hidden sm:flex" aria-hidden="true">{{ $inisial }}</div>
                        <div class="min-w-0 max-w-2xl">
                            <span class="hero-chip"><span class="material-symbols-outlined" style="font-size:16px">assignment</span>Belum ada hasil skrining</span>
                            <h3 class="text-xl md:text-2xl font-bold mt-3 leading-tight">{{ $sapaan }}, {{ $namaDepan }}</h3>
                            <p class="text-sm text-blue-100 mt-2 leading-relaxed">Kamu belum mengisi kuesioner. Isi terlebih dahulu agar hasilmu muncul di sini. Pengisiannya sekitar 10 sampai 15 menit.</p>
                        </div>
                    </div>
                    <a href="/sdq" class="btn-white flex-shrink-0 self-start lg:self-center">
                        <span class="material-symbols-outlined" style="font-size:18px">assignment</span>
                        Mulai isi kuesioner
                    </a>
                </div>
            </section>

            <section aria-labelledby="judul-cara">
                <div class="flex items-start gap-3 mb-4">
                    <span class="ico"><span class="material-symbols-outlined" style="font-size:20px">checklist</span></span>
                    <div>
                        <h4 id="judul-cara" class="h-title">Caranya mudah</h4>
                        <p class="h-sub">Hanya tiga langkah</p>
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="card p-4 flex gap-3 items-start">
                        <span class="step-n">1</span>
                        <p class="text-[13px] leading-relaxed text-[#475569]"><b class="block text-sm text-[#14233B] mb-0.5">Isi kuesioner</b>Jawab 25 pernyataan dengan jujur. Tidak ada jawaban benar atau salah.</p>
                    </div>
                    <div class="card p-4 flex gap-3 items-start">
                        <span class="step-n">2</span>
                        <p class="text-[13px] leading-relaxed text-[#475569]"><b class="block text-sm text-[#14233B] mb-0.5">Kirim jawabanmu</b>Periksa kembali, lalu kirim.</p>
                    </div>
                    <div class="card p-4 flex gap-3 items-start">
                        <span class="step-n">3</span>
                        <p class="text-[13px] leading-relaxed text-[#475569]"><b class="block text-sm text-[#14233B] mb-0.5">Lihat hasilnya</b>Hasilmu langsung tampil di halaman ini.</p>
                    </div>
                </div>
            </section>

        @endif
        </div>

        <footer class="pt-4 border-t border-[#E3E8F0] flex justify-between items-center flex-wrap gap-2">
            <p class="text-xs text-[#6B7A90]">© 2026 SMPN 216 Jakarta — Portal Skrining Kesehatan Mental Siswa</p>
            <p class="text-xs text-[#6B7A90]">Powered by SDQ + Analisis AI</p>
        </footer>

    </div>
</main>

{{-- ================= MENU BAWAH (HP) ================= --}}
<nav class="bottom-nav" aria-label="Menu utama">
    <a href="/dashboard-siswa" class="bn-item active" aria-label="Hasil Saya" title="Hasil Saya" aria-current="page">
        <span class="material-symbols-outlined" style="font-size:22px">clinical_notes</span>
        <span class="label">Hasil Saya</span>
    </a>
    <a href="/sdq" class="bn-item {{ request()->is('sdq*') ? 'active' : '' }}" aria-label="Isi Kuesioner" title="Isi Kuesioner">
        <span class="material-symbols-outlined" style="font-size:22px">assignment</span>
        <span class="label">Isi Kuesioner</span>
    </a>
    <form method="POST" action="/logout" class="contents">
        @csrf
        <button type="submit" class="bn-item" aria-label="Keluar" title="Keluar">
            <span class="material-symbols-outlined" style="font-size:22px">logout</span>
            <span class="label">Keluar</span>
        </button>
    </form>
</nav>

<script>
    // Animasi isi bar saat halaman dibuka (nilai akhir tetap tampil bila JS mati)
    (function () {
        if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;
        document.querySelectorAll('[data-bar]').forEach(function (el) {
            var w = el.style.width;
            el.style.width = '0';
            requestAnimationFrame(function () {
                requestAnimationFrame(function () { el.style.width = w; });
            });
        });
    })();
</script>

</body>
</html>