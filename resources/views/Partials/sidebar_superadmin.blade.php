<!DOCTYPE html>
<html lang="id">
<head>
    <title>Dashboard Super Admin — SMPN 216 Jakarta</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    @php
        $logoUrl    = \App\Models\Pengaturan::url('logo', 'logo-smpn216.png');
        $sekarang   = now('Asia/Jakarta')->locale('id');
        $persenAbn  = $totalKuesioner > 0 ? round($cntAbnormal / $totalKuesioner * 100) : 0;
        $rasio      = $totalGuru > 0 ? round($totalSiswa / $totalGuru) : null;
        $rataIsi    = $totalSiswa > 0 ? number_format($totalKuesioner / $totalSiswa, 1, ',', '.') : '-';
        $totalAkun  = $totalGuru + $totalSiswa;
        $namaDepan  = \Illuminate\Support\Str::title(\Illuminate\Support\Str::words(Auth::user()->name, 2, ''));

        // Warna status sama dengan dashboard Guru BK dan Siswa:
        // biru = umum, hijau = baik, kuning = waspada, ungu = abnormal
        $stats = [
            ['label' => 'Guru BK',             'val' => $totalGuru,      'sub' => 'Akun aktif',                'icon' => 'groups',         'c' => '#1D5FBF', 'cs' => '#E8F0FB', 'href' => route('superadmin.guru.index')],
            ['label' => 'Siswa terdaftar',     'val' => $totalSiswa,     'sub' => 'Akun siswa',                'icon' => 'school',         'c' => '#0F8A5F', 'cs' => '#E3F5ED', 'href' => route('superadmin.siswa.index')],
            ['label' => 'Pengisian kuesioner', 'val' => $totalKuesioner, 'sub' => 'Seluruh hasil SDQ',         'icon' => 'quiz',           'c' => '#B7690B', 'cs' => '#FDF1DC', 'href' => route('superadmin.kuesioner.index')],
            ['label' => 'Kasus abnormal',      'val' => $cntAbnormal,    'sub' => $persenAbn . '% dari pengisian', 'icon' => 'priority_high', 'c' => '#6D3FD0', 'cs' => '#EEE8FB', 'href' => route('superadmin.kuesioner.index', ['label' => 'Abnormal'])],
        ];

        $aksi = [
            ['t' => 'Tambah akun Guru BK',     's' => 'Buat akun Guru BK baru',             'icon' => 'person_add',      'href' => route('superadmin.guru.create')],
            ['t' => 'Kelola data siswa',       's' => 'Edit, reset password, hapus',        'icon' => 'manage_accounts', 'href' => route('superadmin.siswa.index')],
            ['t' => 'Lihat data kuesioner',    's' => 'Semua hasil skrining SDQ',           'icon' => 'fact_check',      'href' => route('superadmin.kuesioner.index')],
            ['t' => 'Logo & gambar beranda',   's' => 'Atur tampilan portal',               'icon' => 'image',           'href' => route('superadmin.pengaturan.index')],
        ];
    @endphp

    <link rel="icon" type="image/png" href="{{ $logoUrl }}">

    <script src="https://cdn.tailwindcss.com"></script>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Source+Serif+4:wght@400;500;600;700&display=swap" rel="stylesheet">

    @vite('resources/css/tema.css')

    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">

    <style>
        /* ============ Token: keluarga warna sama dengan Guru BK dan Siswa ============ */
        :root {
            --navy: #0F2747; --brand: #1D5FBF; --brand-soft: #E8F0FB; --bg: #F3F5F9;
            --ink: #14233B; --ink-2: #475569; --ink-3: #6B7A90; --line: #E3E8F0;
            --ok: #0F8A5F;   --ok-bg: #E3F5ED;
            --warn: #B7690B; --warn-bg: #FDF1DC;
            --act: #6D3FD0;  --act-bg: #EEE8FB;

            /* Pembeda Super Admin: keluarga indigo */
            --ind-950: #12143A;
            --ind-900: #1A1D52;
            --accent: #4B5FD6;
            --accent-soft: #ECEFFC;
            --accent-line: #C9D0F6;
            --accent-glow: #8D9BF0;
        }

        body {
            font-family: 'Inter', system-ui, sans-serif;
            color: var(--ink);
            background: radial-gradient(900px 420px at 90% -100px, #E1E6FA 0%, transparent 70%), var(--bg);
            background-attachment: fixed;
        }

        h1, h2, h3, h4 {
            font-family: 'Source Serif 4', Georgia, serif;
        }

        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }

        :focus-visible {
            outline: 2px solid var(--accent);
            outline-offset: 2px;
        }

        .scrollbar-thin::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }

        .scrollbar-thin::-webkit-scrollbar-thumb {
            background: rgba(255,255,255,.18);
            border-radius: 99px;
        }


        /* ---------- Komponen dasar ---------- */

        .card {
            background: #fff;
            border: 1px solid var(--line);
            border-radius: 14px;
            box-shadow:
                0 1px 2px rgba(15,39,71,.05),
                0 8px 24px -16px rgba(15,39,71,.18);
        }

        .ico {
            width: 36px;
            height: 36px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            background: var(--accent-soft);
            color: var(--accent);
        }

        .h-title {
            font-size: .9rem;
            font-weight: 700;
            color: var(--ink);
        }

        .h-sub {
            font-size: .75rem;
            color: var(--ink-3);
            margin-top: 2px;
        }


        /* ---------- Header ---------- */

        .topbar::before {
            content: '';
            position: absolute;
            left: 0;
            right: 0;
            top: 0;
            height: 3px;
            background: linear-gradient(
                90deg,
                var(--ind-950) 0%,
                var(--accent) 55%,
                #2B78E0 100%
            );
        }

        .role-pill {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 12px;
            border-radius: 999px;
            background: var(--accent-soft);
            border: 1px solid var(--accent-line);
            color: var(--accent);
            font-size: .72rem;
            font-weight: 700;
            letter-spacing: .02em;
        }


        /* ---------- Banner: pola garis kisi dan panel total akun ---------- */

        .hero {
            position: relative;
            overflow: hidden;
            border-radius: 20px;
            padding: 28px;
            color: #fff;
            background: linear-gradient(
                125deg,
                #0E1030 0%,
                #1A1D52 50%,
                #3B4BC0 100%
            );
            box-shadow: 0 18px 40px -18px rgba(40,50,160,.6);
        }

        .hero::before {
            content: '';
            position: absolute;
            inset: 0;
            pointer-events: none;
            background-image:
                linear-gradient(
                    rgba(255,255,255,.07) 1px,
                    transparent 1px
                ),
                linear-gradient(
                    90deg,
                    rgba(255,255,255,.07) 1px,
                    transparent 1px
                );
            background-size: 32px 32px;
            -webkit-mask-image: linear-gradient(
                100deg,
                transparent 20%,
                #000 100%
            );
            mask-image: linear-gradient(
                100deg,
                transparent 20%,
                #000 100%
            );
        }

        .hero::after {
            content: '';
            position: absolute;
            width: 420px;
            height: 420px;
            right: -120px;
            top: -170px;
            border-radius: 50%;
            pointer-events: none;
            background: radial-gradient(
                circle,
                rgba(141,155,240,.42),
                transparent 68%
            );
        }

        .hero > .in {
            position: relative;
            z-index: 1;
        }

        .hero-chip {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 5px 12px;
            border-radius: 8px;
            background: rgba(255,255,255,.1);
            border: 1px solid rgba(255,255,255,.2);
            font-size: .74rem;
            font-weight: 600;
            letter-spacing: .03em;
        }

        .btn-white {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 11px 18px;
            border-radius: 10px;
            background: #fff;
            color: var(--ind-900);
            font-size: .82rem;
            font-weight: 700;
            box-shadow: 0 10px 20px -10px rgba(0,0,0,.35);
            transition: background .15s, transform .12s;
        }

        .btn-white:hover {
            background: var(--accent-soft);
        }

        .btn-ghost-light {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 11px 18px;
            border-radius: 10px;
            border: 1px solid rgba(255,255,255,.4);
            color: #fff;
            font-size: .82rem;
            font-weight: 700;
            transition: background .15s;
        }

        .btn-ghost-light:hover {
            background: rgba(255,255,255,.14);
        }

        .btn-white:active,
        .btn-ghost-light:active {
            transform: scale(.98);
        }

        .glass {
            border-radius: 14px;
            padding: 16px 18px;
            background: rgba(255,255,255,.1);
            border: 1px solid rgba(255,255,255,.2);
            backdrop-filter: blur(6px);
            -webkit-backdrop-filter: blur(6px);
            min-width: 210px;
        }


        /* ---------- Strip angka: satu kartu menyatu, dibagi garis tipis ---------- */

        .strip {
            display: grid;
            grid-template-columns: 1fr;
            overflow: hidden;
        }

        .strip a {
            position: relative;
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 18px 20px;
            transition: background .18s;
            border-bottom: 1px solid var(--line);
        }

        .strip a:last-child {
            border-bottom: 0;
        }

        .strip a:hover {
            background: #FAFBFE;
        }

        .strip a::after {
            content: '';
            position: absolute;
            left: 0;
            right: 0;
            bottom: -1px;
            height: 3px;
            background: var(--c);
            transform: scaleX(0);
            transform-origin: left;
            transition: transform .25s;
        }

        .strip a:hover::after {
            transform: scaleX(1);
        }

        .strip .tile {
            width: 44px;
            height: 44px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            background: var(--cs);
            color: var(--c);
        }

        .strip .num {
            font-size: 1.75rem;
            font-weight: 800;
            line-height: 1.05;
            color: var(--c);
        }

        @media (min-width: 560px) {
            .strip {
                grid-template-columns: 1fr 1fr;
            }

            .strip a {
                border-bottom: 1px solid var(--line);
            }

            .strip a:nth-child(odd) {
                border-right: 1px solid var(--line);
            }

            .strip a:nth-last-child(-n+2) {
                border-bottom: 0;
            }
        }

        @media (min-width: 1280px) {
            .strip {
                grid-template-columns: repeat(4, 1fr);
            }

            .strip a,
            .strip a:nth-child(odd),
            .strip a:nth-last-child(-n+2) {
                border-bottom: 0;
                border-right: 1px solid var(--line);
            }

            .strip a:last-child {
                border-right: 0;
            }
        }


        /* ---------- Aksi cepat: ubin dengan ikon di atas ---------- */

        .quick {
            position: relative;
            display: block;
            padding: 16px;
            border-radius: 14px;
            border: 1px solid var(--line);
            background: #fff;
            transition: .18s;
        }

        .quick:hover {
            border-color: #B8C2F2;
            background: var(--accent-soft);
            transform: translateY(-2px);
            box-shadow: 0 12px 24px -16px rgba(75,95,214,.55);
        }

        .quick .qi {
            width: 40px;
            height: 40px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: var(--brand-soft);
            color: var(--brand);
            transition: .18s;
        }

        .quick:hover .qi {
            background: var(--accent);
            color: #fff;
        }

        .quick .qt {
            display: block;
            margin-top: 14px;
            font-size: .86rem;
            font-weight: 700;
            color: var(--ink);
            line-height: 1.3;
        }

        .quick .qs {
            display: block;
            margin-top: 3px;
            font-size: .74rem;
            color: var(--ink-3);
        }

        .quick .go {
            position: absolute;
            top: 14px;
            right: 14px;
            color: #B4C0D2;
            transition: .18s;
        }

        .quick:hover .go {
            color: var(--accent);
            transform: translate(2px, -2px);
        }


        /* ---------- Batang proporsi ---------- */

        .bar {
            position: relative;
            height: 12px;
            border-radius: 99px;
            background: #EDF1F7;
            overflow: hidden;
        }

        .bar > i {
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: calc(var(--p) * 1%);
            min-width: 0;
            border-radius: 99px;
            background: linear-gradient(
                90deg,
                #8D6BE0,
                var(--act)
            );
        }


        @media (max-width: 479px) {
            .hero {
                padding: 22px 18px;
            }

            .glass {
                min-width: 0;
                width: 100%;
            }
        }

        @media (prefers-reduced-motion: reduce) {
            #sidebar,
            .quick,
            .quick .go,
            .quick .qi,
            .strip a,
            .strip a::after {
                transition: none !important;
            }
        }
    </style>
</head>


<body class="flex min-h-screen">


{{-- ================= SIDEBAR ================= --}}
@include('partials.sidebar_superadmin')


{{-- ================= MAIN ================= --}}
<main class="flex-1 min-w-0 flex flex-col">

    <header class="topbar h-16 bg-white/90 backdrop-blur-md border-b border-[#E3E8F0] flex items-center justify-between px-4 md:px-8 sticky top-0 z-30">

        <div class="flex items-center gap-3">

            <button
                id="hamburger-btn"
                onclick="openSidebar()"
                aria-label="Buka menu"
                class="w-9 h-9 rounded-lg border border-[#E3E8F0] flex items-center justify-center hover:bg-[#ECEFFC] transition-colors lg:hidden"
            >
                <span
                    class="material-symbols-outlined text-[#475569]"
                    style="font-size:20px"
                >
                    menu
                </span>
            </button>

            <div>
                <h2 class="text-base md:text-lg font-bold text-[#14233B] leading-tight">
                    Dashboard Super Admin
                </h2>

                <p class="text-xs text-[#6B7A90] hidden sm:block">
                    Kelola seluruh data sistem MindCheck
                </p>
            </div>

        </div>


        <div class="flex items-center gap-2">

            <span class="role-pill hidden md:inline-flex">
                <span
                    class="material-symbols-outlined"
                    style="font-size:15px"
                >
                    shield_person
                </span>

                Super Admin
            </span>

            <span class="text-xs font-medium text-[#475569] hidden sm:flex items-center gap-2 px-3 py-2 rounded-lg bg-[#F3F5F9] border border-[#E3E8F0]">

                <span
                    class="material-symbols-outlined"
                    style="font-size:16px"
                >
                    calendar_today
                </span>

                {{ $sekarang->isoFormat('dddd, D MMMM Y') }}

            </span>

        </div>

    </header>


    <div class="flex-1 p-4 md:p-8 space-y-6 max-w-[1400px] w-full mx-auto">

        @if(session('success'))
        <div
            class="bg-[#E3F5ED] border border-[#A7F3D0] text-[#0F8A5F] text-sm font-semibold rounded-xl px-4 py-3"
            role="status"
        >
            {{ session('success') }}
        </div>
        @endif


        {{-- ===== Banner ===== --}}
        <section class="hero">

            <div class="in flex flex-col lg:flex-row lg:items-center justify-between gap-6">

                <div class="min-w-0 max-w-2xl">

                    <span class="hero-chip">

                        <span
                            class="material-symbols-outlined"
                            style="font-size:16px"
                        >
                            verified_user
                        </span>

                        AKSES PENUH SISTEM

                    </span>


                    <h3 class="text-2xl md:text-3xl font-extrabold mt-3 leading-tight">
                        Halo, {{ $namaDepan }}
                    </h3>


                    <p class="text-sm text-indigo-100 mt-2 leading-relaxed">
                        Kelola akun Guru BK dan siswa, pantau data kuesioner SDQ, dan atur tampilan portal dari satu tempat.
                    </p>


                    <div class="flex flex-wrap gap-3 mt-5">

                        <a
                            href="{{ route('superadmin.guru.create') }}"
                            class="btn-white"
                        >
                            <span
                                class="material-symbols-outlined"
                                style="font-size:18px"
                            >
                                person_add
                            </span>

                            Tambah Guru BK
                        </a>


                        <a
                            href="{{ route('superadmin.siswa.index') }}"
                            class="btn-ghost-light"
                        >
                            <span
                                class="material-symbols-outlined"
                                style="font-size:18px"
                            >
                                school
                            </span>

                            Kelola siswa
                        </a>

                    </div>

                </div>


                <div class="glass flex-shrink-0">

                    <p class="text-[11px] font-semibold tracking-wider uppercase text-indigo-200">
                        Total akun terdaftar
                    </p>

                    <p class="text-3xl font-extrabold mt-1 leading-none">
                        {{ number_format($totalAkun) }}
                    </p>

                    <div class="mt-3 pt-3 border-t border-white/15 flex items-center justify-between text-xs text-indigo-100">
                        <span>
                            {{ number_format($totalGuru) }} Guru BK
                        </span>

                        <span>
                            {{ number_format($totalSiswa) }} siswa
                        </span>
                    </div>

                </div>

            </div>

        </section>


        {{-- ===== Ringkasan angka (satu strip menyatu) ===== --}}
        <section
            class="card strip"
            aria-label="Ringkasan angka"
        >

            @foreach($stats as $st)

            <a
                href="{{ $st['href'] }}"
                style="--c:{{ $st['c'] }};--cs:{{ $st['cs'] }}"
            >

                <span class="tile">

                    <span
                        class="material-symbols-outlined"
                        style="font-size:24px"
                    >
                        {{ $st['icon'] }}
                    </span>

                </span>


                <span class="min-w-0">

                    <span class="num block">
                        {{ number_format($st['val']) }}
                    </span>

                    <span class="block text-[13px] font-semibold text-[#14233B] mt-1">
                        {{ $st['label'] }}
                    </span>

                    <span class="block text-[11.5px] text-[#6B7A90] mt-0.5">
                        {{ $st['sub'] }}
                    </span>

                </span>

            </a>

            @endforeach

        </section>


        <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">


            {{-- ===== Aksi cepat ===== --}}
            <section class="card p-5 md:p-6 xl:col-span-2">

                <div class="flex items-start gap-3">

                    <span class="ico">
                        <span
                            class="material-symbols-outlined"
                            style="font-size:20px"
                        >
                            bolt
                        </span>
                    </span>

                    <div>

                        <h4 class="h-title">
                            Aksi cepat
                        </h4>

                        <p class="h-sub">
                            Tugas yang paling sering dilakukan.
                        </p>

                    </div>

                </div>


                <div class="grid grid-cols-1 min-[480px]:grid-cols-2 gap-3 md:gap-4 mt-5">

                    @foreach($aksi as $a)

                    <a
                        href="{{ $a['href'] }}"
                        class="quick"
                    >

                        <span class="qi">

                            <span
                                class="material-symbols-outlined"
                                style="font-size:22px"
                            >
                                {{ $a['icon'] }}
                            </span>

                        </span>


                        <span
                            class="material-symbols-outlined go"
                            style="font-size:20px"
                        >
                            arrow_outward
                        </span>


                        <span class="qt">
                            {{ $a['t'] }}
                        </span>

                        <span class="qs">
                            {{ $a['s'] }}
                        </span>

                    </a>

                    @endforeach

                </div>

            </section>


            {{-- ===== Ringkasan sistem ===== --}}
            <section class="card p-5 md:p-6">

                <div class="flex items-start gap-3">

                    <span class="ico">

                        <span
                            class="material-symbols-outlined"
                            style="font-size:20px"
                        >
                            insights
                        </span>

                    </span>

                    <div>

                        <h4 class="h-title">
                            Ringkasan sistem
                        </h4>

                        <p class="h-sub">
                            Gambaran singkat dari data saat ini.
                        </p>

                    </div>

                </div>


                <div class="mt-6">

                    <div class="flex items-end justify-between gap-3">

                        <div class="min-w-0">

                            <p class="text-xs font-semibold text-[#475569]">
                                Proporsi kasus abnormal
                            </p>

                            <p class="text-sm font-bold text-[#14233B] mt-1">
                                {{ number_format($cntAbnormal) }}
                                dari
                                {{ number_format($totalKuesioner) }}
                                pengisian
                            </p>

                        </div>


                        <p class="text-2xl font-extrabold text-[#6D3FD0] leading-none">
                            {{ $persenAbn }}%
                        </p>

                    </div>


                    <div
                        class="bar mt-3"
                        style="--p:{{ $persenAbn }}"
                        role="img"
                        aria-label="Kasus abnormal {{ $persenAbn }} persen"
                    >
                        <i></i>
                    </div>

                </div>


                <div class="mt-6 pt-5 border-t border-[#E3E8F0] space-y-3">

                    <div class="flex items-center justify-between text-sm">

                        <span class="text-[#6B7A90]">
                            Siswa per Guru BK
                        </span>

                        <span class="font-bold text-[#14233B]">
                            {{ $rasio !== null ? $rasio : '-' }}
                        </span>

                    </div>


                    <div class="flex items-center justify-between text-sm">

                        <span class="text-[#6B7A90]">
                            Rata-rata pengisian per siswa
                        </span>

                        <span class="font-bold text-[#14233B]">
                            {{ $rataIsi }}
                        </span>

                    </div>


                    <div class="flex items-center justify-between text-sm">

                        <span class="text-[#6B7A90]">
                            Total akun terdaftar
                        </span>

                        <span class="font-bold text-[#14233B]">
                            {{ number_format($totalAkun) }}
                        </span>

                    </div>

                </div>

            </section>

        </div>


        <footer class="pt-4 border-t border-[#E3E8F0] flex justify-between items-center flex-wrap gap-2">

            <p class="text-xs text-[#6B7A90]">
                © {{ date('Y') }} SMPN 216 Jakarta — Portal Skrining Kesehatan Mental Siswa
            </p>

            <p class="text-xs text-[#6B7A90]">
                Super Admin Panel
            </p>

        </footer>

    </div>

</main>

</body>
</html>