<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Kuesioner — SMPN 216 Jakarta</title>
    @php
        $logoUrl = \App\Models\Pengaturan::url('logo', 'logo-smpn216.png');
    @endphp
    <link rel="icon" type="image/png" href="{{ $logoUrl }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">

    <style>
        /* ============ Token: sama dengan Dashboard Super Admin ============ */
        :root {
            --bg: #F3F5F9; --ink: #14233B; --ink-2: #475569; --ink-3: #6B7A90; --line: #E3E8F0;
            --accent: #4B5FD6; --accent-soft: #ECEFFC; --accent-line: #C9D0F6; --accent-glow: #8D9BF0;
        }
        body {
            font-family: 'Plus Jakarta Sans', system-ui, sans-serif; color: var(--ink);
            background: radial-gradient(900px 420px at 90% -100px, #E1E6FA 0%, transparent 70%), var(--bg);
            background-attachment: fixed;
        }
        .material-symbols-outlined { font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24; }
        :focus-visible { outline: 2px solid var(--accent); outline-offset: 2px; }
        .scrollbar-thin::-webkit-scrollbar { width: 6px; height: 6px; }
        .scrollbar-thin::-webkit-scrollbar-thumb { background: #CBD5E1; border-radius: 99px; }

        .card { background: #fff; border: 1px solid var(--line); border-radius: 14px; box-shadow: 0 1px 2px rgba(15,39,71,.05), 0 8px 24px -16px rgba(15,39,71,.18); }

        /* ---------- Komponen halaman detail ---------- */
        .h-title { font-size: .9rem; font-weight: 700; color: var(--ink); }
        .h-sub { font-size: .75rem; color: var(--ink-3); margin-top: 2px; }
        .ico { width: 36px; height: 36px; border-radius: 10px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; background: var(--accent-soft); color: var(--accent); }
        .avatar-lg { width: 56px; height: 56px; border-radius: 50%; background: var(--accent-soft); color: var(--accent); display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 1.05rem; flex-shrink: 0; }
        .kelas-pill { display: inline-flex; align-items: center; padding: 3px 10px; border-radius: 999px; background: var(--accent-soft); color: var(--accent); font-size: .74rem; font-weight: 700; }
        .badge { display: inline-flex; align-items: center; gap: 6px; padding: 5px 13px; border-radius: 999px; font-size: .78rem; font-weight: 700; white-space: nowrap; }
        .badge::before { content: ''; width: 6px; height: 6px; border-radius: 50%; background: currentColor; }
        .badge.ok   { background: #E3F5ED; color: #0F8A5F; }
        .badge.warn { background: #FDF1DC; color: #B7690B; }
        .badge.act  { background: #EEE8FB; color: #6D3FD0; }
        .badge.none { background: #EDF1F7; color: #475569; }
        .bar { position: relative; height: 8px; border-radius: 99px; background: #EDF1F7; overflow: hidden; }
        .bar > i { position: absolute; left: 0; top: 0; bottom: 0; width: calc(var(--p) * 1%); border-radius: 99px; background: var(--c, var(--accent)); }
        .skor { padding: 16px; border-radius: 12px; border: 1px solid var(--line); background: #fff; transition: border-color .15s, background .15s; }
        .skor:hover { border-color: var(--accent-line); background: #FAFBFF; }
        .prob { padding: 16px; border-radius: 12px; border: 1px solid var(--line); background: #fff; }
        .note { padding: 14px 16px; border-radius: 12px; background: #F7F9FC; border: 1px solid var(--line); }
        .btn-del { display: inline-flex; align-items: center; gap: 8px; height: 42px; padding: 0 18px; border-radius: 11px; border: 1px solid #F2C4C4; background: #fff; color: #D13B3B; font-size: .82rem; font-weight: 600; transition: .15s; }
        .btn-del:hover { background: #FBE9E9; }
        .btn-del:active { transform: scale(.98); }
        .btn-line { display: inline-flex; align-items: center; justify-content: center; gap: 6px; height: 42px; padding: 0 18px; border-radius: 11px; border: 1px solid var(--line); background: #fff; color: var(--ink-2); font-size: .82rem; font-weight: 600; transition: .15s; }
        .btn-line:hover { background: var(--accent-soft); border-color: var(--accent-line); color: var(--accent); }

        /* ---------- Header ---------- */
        .topbar::before { content: ''; position: absolute; left: 0; right: 0; top: 0; height: 3px; background: linear-gradient(90deg, #12143A 0%, var(--accent) 55%, #2B78E0 100%); }

        /* ---------- Sidebar: sama dengan Dashboard Super Admin ---------- */
        #sidebar-overlay { display: none; position: fixed; inset: 0; background: rgba(14,16,48,.55); z-index: 40; }
        #sidebar-overlay.open { display: block; }
        #sidebar { position: fixed; top: 0; left: 0; height: 100vh; width: 272px; z-index: 50; display: flex; flex-direction: column; padding: 22px 14px 16px;
            background: linear-gradient(180deg, #1A1D52 0%, #12143A 100%); color: #fff; transform: translateX(-100%); transition: transform .3s cubic-bezier(.4,0,.2,1); }
        #sidebar.open { transform: translateX(0); }
        #sidebar::after { content: ''; position: absolute; inset: 0; pointer-events: none;
            background: radial-gradient(260px 220px at 0% 0%, rgba(141,155,240,.3), transparent 70%), radial-gradient(240px 240px at 100% 100%, rgba(75,95,214,.28), transparent 70%); }
        #sidebar > * { position: relative; z-index: 1; }
        .admin-badge { display: flex; align-items: center; gap: 10px; margin: 16px 0 0; padding: 10px 12px; border-radius: 12px; background: rgba(255,255,255,.06); border: 1px solid rgba(255,255,255,.1); }
        .admin-badge .ab-ico { width: 30px; height: 30px; border-radius: 9px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; background: rgba(141,155,240,.28); color: #C9D0F6; }
        .admin-badge .ab-t { display: block; font-size: .8rem; font-weight: 700; color: #fff; line-height: 1.2; }
        .admin-badge .ab-s { display: block; margin-top: 2px; font-size: .68rem; color: #A9B2DC; line-height: 1.2; }
        .nav-label { display: flex; align-items: center; gap: 10px; padding: 0 12px; margin: 22px 0 8px; font-size: .72rem; font-weight: 600; color: #8D98CC; }
        .nav-label::after { content: ''; flex: 1; height: 1px; background: rgba(255,255,255,.1); }
        .nav-link { position: relative; display: flex; align-items: center; gap: 12px; padding: 11px 12px; margin-bottom: 4px; border-radius: 10px; font-size: .85rem; font-weight: 500; color: #B9C0E6; transition: .15s; }
        .nav-link:hover { background: rgba(255,255,255,.07); color: #fff; }
        .nav-link.active { background: linear-gradient(90deg, rgba(141,155,240,.34), rgba(141,155,240,.08)); box-shadow: inset 0 0 0 1px rgba(168,178,246,.28); color: #fff; font-weight: 600; }
        .nav-link.active::before { content: ''; position: absolute; left: -14px; top: 9px; bottom: 9px; width: 4px; border-radius: 0 4px 4px 0; background: var(--accent-glow); }
        .nav-link.active .material-symbols-outlined { color: #B5BFFA; font-variation-settings: 'FILL' 1, 'wght' 500, 'GRAD' 0, 'opsz' 24; }
        .side-user { margin-top: auto; padding: 12px; border-radius: 12px; background: rgba(255,255,255,.07); border: 1px solid rgba(255,255,255,.1); display: flex; align-items: center; gap: 10px; }
        .side-user .s-avatar { width: 40px; height: 40px; border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0; font-size: .85rem; font-weight: 700; color: #fff; background: var(--accent); box-shadow: 0 0 0 2px rgba(141,155,240,.5); }
        .side-user .logout { margin-left: auto; width: 34px; height: 34px; border-radius: 9px; display: flex; align-items: center; justify-content: center; color: #A9B2DC; transition: .15s; }
        .side-user .logout:hover { background: rgba(229,72,77,.18); color: #FF8A8E; }

        @media (min-width: 1024px) {
            #sidebar { position: sticky; transform: translateX(0) !important; flex-shrink: 0; }
            #sidebar-overlay { display: none !important; }
            #hamburger-btn { display: none !important; }
        }
        @media (prefers-reduced-motion: reduce) { #sidebar, .skor { transition: none !important; } }
    </style>
</head>

<body class="flex min-h-screen">

<div id="sidebar-overlay" onclick="closeSidebar()"></div>

{{-- ================= SIDEBAR ================= --}}
<aside id="sidebar" aria-label="Navigasi utama">

    <a href="{{ url('/') }}" title="Lihat halaman beranda" class="flex items-center gap-3 px-2 py-1 hover:opacity-90 transition-opacity">
        <div class="w-11 h-11 rounded-xl overflow-hidden bg-white flex-shrink-0 p-1">
            <img src="{{ $logoUrl }}" alt="Logo SMPN 216" class="w-full h-full object-contain">
        </div>
        <div class="leading-tight min-w-0">
            <h1 class="text-[15px] font-bold text-white">SMPN 216 Jakarta</h1>
            <p class="text-[11.5px] text-[#A9B2DC] mt-0.5">Skrining Kesehatan Mental</p>
        </div>
    </a>

    <div class="admin-badge">
        <span class="ab-ico"><span class="material-symbols-outlined" style="font-size:18px">shield_person</span></span>
        <span class="min-w-0">
            <span class="ab-t">Super Admin</span>
            <span class="ab-s">Akses penuh sistem</span>
        </span>
    </div>

    <nav class="flex-1 overflow-y-auto scrollbar-thin mt-1">
        <p class="nav-label">Menu utama</p>

        <a href="{{ route('superadmin.dashboard') }}" class="nav-link">
            <span class="material-symbols-outlined" style="font-size:21px">dashboard</span> Dashboard
        </a>
        <a href="{{ route('superadmin.guru.index') }}" class="nav-link">
            <span class="material-symbols-outlined" style="font-size:21px">groups</span> Data Guru BK
        </a>
        <a href="{{ route('superadmin.siswa.index') }}" class="nav-link">
            <span class="material-symbols-outlined" style="font-size:21px">school</span> Data Siswa
        </a>
        <a href="{{ route('superadmin.kuesioner.index') }}" class="nav-link active" aria-current="page">
            <span class="material-symbols-outlined" style="font-size:21px">quiz</span> Data Kuesioner
        </a>

        <p class="nav-label">Sistem</p>

        <a href="{{ route('superadmin.pengaturan.index') }}" class="nav-link">
            <span class="material-symbols-outlined" style="font-size:21px">settings</span> Pengaturan Tampilan
        </a>
    </nav>

    <div class="side-user">
        <div class="s-avatar">{{ strtoupper(substr(Auth::user()->name, 0, 2)) }}</div>
        <div class="overflow-hidden min-w-0">
            <p class="text-sm font-semibold truncate text-white">{{ Auth::user()->name }}</p>
            <p class="text-xs text-[#A9B2DC] truncate">Super Admin</p>
        </div>
        <form method="POST" action="/logout" class="ml-auto">
            @csrf
            <button type="submit" title="Keluar" aria-label="Keluar" class="logout">
                <span class="material-symbols-outlined" style="font-size:19px">logout</span>
            </button>
        </form>
    </div>
</aside>

{{-- ================= MAIN ================= --}}
<main class="flex-1 min-w-0 flex flex-col">

    <header class="topbar h-16 bg-white/90 backdrop-blur-md border-b border-[#E3E8F0] flex items-center px-4 md:px-8 sticky top-0 z-30">
        <div class="flex items-center gap-3 min-w-0">
            <button id="hamburger-btn" onclick="openSidebar()" aria-label="Buka menu"
                    class="w-9 h-9 rounded-lg border border-[#E3E8F0] flex items-center justify-center hover:bg-[#ECEFFC] transition-colors lg:hidden flex-shrink-0">
                <span class="material-symbols-outlined text-[#475569]" style="font-size:20px">menu</span>
            </button>
            <a href="{{ route('superadmin.kuesioner.index') }}" title="Kembali ke Data Kuesioner" aria-label="Kembali"
               class="w-9 h-9 rounded-lg border border-[#E3E8F0] flex items-center justify-center hover:bg-[#ECEFFC] transition-colors flex-shrink-0">
                <span class="material-symbols-outlined text-[#475569]" style="font-size:20px">arrow_back</span>
            </a>
            <div class="min-w-0">
                <h2 class="text-base md:text-lg font-bold text-[#14233B] leading-tight">Detail Hasil Kuesioner</h2>
                <p class="text-xs text-[#6B7A90] hidden sm:block truncate">{{ $hasil->nama }} — Kelas {{ $hasil->kelas }} — {{ $hasil->created_at->format('d/m/Y H:i') }}</p>
            </div>
        </div>
    </header>

    {{-- Lebar penuh: margin kiri-kanan sama dengan header (px-4 / md:px-8) --}}
    <div class="flex-1 px-4 md:px-8 py-4 md:py-8 w-full space-y-6">

        @if(session('success'))
        <div class="bg-[#E3F5ED] border border-[#A7F3D0] text-[#0F8A5F] text-sm font-semibold rounded-xl px-4 py-3" role="status">
            {{ session('success') }}
        </div>
        @endif

        @php
            $warna = fn ($label) => match($label) {
                'Normal'     => 'ok',
                'Borderline' => 'warn',
                'Abnormal'   => 'act',
                default      => 'none',
            };
            $keputusan = $hasil->keputusan_akhir ?? $hasil->hasil_label;
            $total     = (int) $hasil->total_kesulitan;
            $persen    = min(100, max(0, round($total / 40 * 100)));
            $warnaBar  = match($warna($hasil->hasil_label)) { 'ok' => '#0F8A5F', 'warn' => '#B7690B', 'act' => '#6D3FD0', default => '#6B7A90' };

            // Skor per aspek (maksimal 10 tiap aspek)
            $aspek = [
                ['n' => 'Emosional',    'v' => $hasil->skor_emotional,     'c' => '#4B5FD6', 'icon' => 'sentiment_neutral'],
                ['n' => 'Perilaku',     'v' => $hasil->skor_conduct,       'c' => '#4B5FD6', 'icon' => 'psychology'],
                ['n' => 'Hiperaktif',   'v' => $hasil->skor_hyperactivity, 'c' => '#4B5FD6', 'icon' => 'bolt'],
                ['n' => 'Teman sebaya', 'v' => $hasil->skor_peer,          'c' => '#4B5FD6', 'icon' => 'diversity_3'],
                ['n' => 'Prososial',    'v' => $hasil->skor_prosocial,     'c' => '#0F8A5F', 'icon' => 'volunteer_activism'],
            ];

            $nbAda = filled($hasil->hasil_naive_bayes) && stripos((string) $hasil->hasil_naive_bayes, 'tidak tersedia') === false;

            // Flask mengirim peluang dalam persen (0-100). Kalau tersimpan sebagai pecahan (0-1),
            // otomatis dikalikan 100 supaya tampil benar di kedua kasus.
            $pn = (float) ($hasil->prob_normal ?? 0);
            $pb = (float) ($hasil->prob_borderline ?? 0);
            $ph = (float) ($hasil->prob_high_risk ?? 0);
            $kali = (($pn + $pb + $ph) > 0 && ($pn + $pb + $ph) <= 1.5) ? 100 : 1;
            $probs = [
                ['n' => 'Normal',     'v' => $pn * $kali, 'c' => '#0F8A5F'],
                ['n' => 'Borderline', 'v' => $pb * $kali, 'c' => '#B7690B'],
                ['n' => 'High Risk',  'v' => $ph * $kali, 'c' => '#6D3FD0'],
            ];
        @endphp

        {{-- ===== Ringkasan ===== --}}
        <section class="card p-5 md:p-6">
            <div class="grid grid-cols-1 lg:grid-cols-5 gap-6 lg:gap-8 items-center">

                <div class="lg:col-span-2 flex items-center gap-4 min-w-0">
                    <span class="avatar-lg">{{ strtoupper(substr($hasil->nama, 0, 2)) }}</span>
                    <div class="min-w-0">
                        <h3 class="text-lg font-bold text-[#14233B] leading-tight truncate">{{ $hasil->nama }}</h3>
                        <div class="flex flex-wrap items-center gap-2 mt-2">
                            @if($hasil->kelas)<span class="kelas-pill">Kelas {{ $hasil->kelas }}</span>@endif
                            <span class="text-xs text-[#6B7A90]">{{ $hasil->created_at->format('d/m/Y, H:i') }} WIB</span>
                        </div>
                    </div>
                </div>

                <div class="lg:col-span-3 lg:pl-8 lg:border-l border-[#E3E8F0]">
                    <div class="flex flex-wrap items-start justify-between gap-3">
                        <div>
                            <p class="text-xs font-semibold text-[#475569]">Total skor kesulitan</p>
                            <p class="text-4xl font-extrabold text-[#14233B] leading-none mt-2">{{ $total }}<span class="text-base font-medium text-[#6B7A90]">/40</span></p>
                        </div>
                        <div class="text-right">
                            <p class="text-xs font-semibold text-[#475569] mb-2">Hasil skoring SDQ</p>
                            <span class="badge {{ $warna($hasil->hasil_label) }}">{{ $hasil->hasil_label ?: '-' }}</span>
                        </div>
                    </div>
                    <div class="bar mt-4" style="--p:{{ $persen }};--c:{{ $warnaBar }}" role="img" aria-label="Skor {{ $total }} dari 40"><i></i></div>
                    <p class="text-xs text-[#6B7A90] mt-2.5">Gabungan empat aspek kesulitan. Aspek prososial tidak dihitung dalam total.</p>
                </div>
            </div>
        </section>

        {{-- ===== Skor per aspek ===== --}}
        <section class="card p-5 md:p-6">
            <div class="flex items-start gap-3">
                <span class="ico"><span class="material-symbols-outlined" style="font-size:20px">insights</span></span>
                <div>
                    <h4 class="h-title">Skor per aspek</h4>
                    <p class="h-sub">Setiap aspek bernilai 0 sampai 10.</p>
                </div>
            </div>

            <div class="grid grid-cols-2 lg:grid-cols-5 gap-3 mt-5">
                @foreach($aspek as $a)
                <div class="skor {{ $loop->last ? 'col-span-2 lg:col-span-1' : '' }}">
                    <div class="flex items-center gap-1.5 text-[#6B7A90]">
                        <span class="material-symbols-outlined" style="font-size:17px;color:{{ $a['c'] }}">{{ $a['icon'] }}</span>
                        <span class="text-xs font-semibold">{{ $a['n'] }}</span>
                    </div>
                    <p class="text-2xl font-extrabold text-[#14233B] mt-2 leading-none">{{ $a['v'] ?? '-' }}<span class="text-xs font-medium text-[#6B7A90]">/10</span></p>
                    <div class="bar mt-3" style="--p:{{ min(100, max(0, ((int) ($a['v'] ?? 0)) * 10)) }};--c:{{ $a['c'] }}"><i></i></div>
                </div>
                @endforeach
            </div>
        </section>

        {{-- ===== Analisis Naive Bayes ===== --}}
        <section class="card p-5 md:p-6">
            <div class="flex items-start gap-3">
                <span class="ico"><span class="material-symbols-outlined" style="font-size:20px">query_stats</span></span>
                <div>
                    <h4 class="h-title">Analisis Naive Bayes</h4>
                    <p class="h-sub">Peluang tiap kategori hasil menurut model.</p>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-5 gap-6 lg:gap-8 mt-5">

                {{-- Kiri: peluang tiap kategori --}}
                <div class="lg:col-span-3">
                    @if($nbAda)
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                        @foreach($probs as $p)
                        <div class="prob">
                            <p class="text-xs font-semibold text-[#6B7A90]">{{ $p['n'] }}</p>
                            <p class="text-2xl font-extrabold mt-1.5 leading-none" style="color:{{ $p['c'] }}">{{ number_format($p['v'], 1, ',', '.') }}%</p>
                            <div class="bar mt-3" style="--p:{{ min(100, max(0, round($p['v']))) }};--c:{{ $p['c'] }}"><i></i></div>
                        </div>
                        @endforeach
                    </div>
                    @else
                    <div class="note flex items-start gap-3">
                        <span class="material-symbols-outlined text-[#6B7A90]" style="font-size:20px">info</span>
                        <p class="text-sm text-[#475569] leading-relaxed">Perhitungan Naive Bayes belum tersedia untuk data ini. Keputusan akhir mengikuti hasil skoring SDQ.</p>
                    </div>
                    @endif
                </div>

                {{-- Kanan: prediksi, keputusan, tindakan --}}
                <div class="lg:col-span-2 lg:pl-8 lg:border-l border-[#E3E8F0]">
                    <dl class="divide-y divide-[#E3E8F0]">
                        <div class="flex flex-wrap items-center justify-between gap-2 pb-3.5">
                            <dt class="text-sm text-[#6B7A90]">Prediksi Naive Bayes</dt>
                            <dd class="text-sm font-semibold text-[#14233B]">{{ $nbAda ? $hasil->hasil_naive_bayes : 'Tidak tersedia' }}</dd>
                        </div>
                        <div class="flex flex-wrap items-center justify-between gap-2 py-3.5">
                            <dt class="text-sm text-[#6B7A90]">Keputusan akhir</dt>
                            <dd><span class="badge {{ $warna($keputusan) }}">{{ $keputusan ?: '-' }}</span></dd>
                        </div>
                    </dl>

                    <div class="note mt-1 flex items-start gap-3">
                        <span class="ico" style="width:32px;height:32px"><span class="material-symbols-outlined" style="font-size:18px">task_alt</span></span>
                        <div class="min-w-0">
                            <p class="text-xs font-semibold text-[#6B7A90]">Tindakan yang disarankan</p>
                            <p class="text-sm font-semibold text-[#14233B] mt-1 leading-relaxed">{{ $hasil->tindakan ?: '-' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- ===== Aksi ===== --}}
        <div class="flex flex-col-reverse sm:flex-row sm:items-center sm:justify-between gap-3">
            <a href="{{ route('superadmin.kuesioner.index') }}" class="btn-line">
                <span class="material-symbols-outlined" style="font-size:18px">arrow_back</span>
                Kembali ke daftar
            </a>
            <form method="POST" action="{{ route('superadmin.kuesioner.destroy', $hasil->id) }}"
                  onsubmit="return confirm('Hapus data kuesioner ini secara permanen?\n\nData yang dihapus tidak bisa dikembalikan.');">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn-del w-full sm:w-auto justify-center">
                    <span class="material-symbols-outlined" style="font-size:18px">delete</span>
                    Hapus data ini
                </button>
            </form>
        </div>

        <footer class="pt-4 border-t border-[#E3E8F0] flex justify-between items-center flex-wrap gap-2">
            <p class="text-xs text-[#6B7A90]">© {{ date('Y') }} SMPN 216 Jakarta — Portal Skrining Kesehatan Mental Siswa</p>
            <p class="text-xs text-[#6B7A90]">Super Admin Panel</p>
        </footer>
    </div>
</main>

<script>
    function openSidebar() {
        document.getElementById('sidebar').classList.add('open');
        document.getElementById('sidebar-overlay').classList.add('open');
        document.body.style.overflow = 'hidden';
    }
    function closeSidebar() {
        document.getElementById('sidebar').classList.remove('open');
        document.getElementById('sidebar-overlay').classList.remove('open');
        document.body.style.overflow = '';
    }
    window.addEventListener('resize', () => { if (window.innerWidth >= 1024) closeSidebar(); });
    document.addEventListener('keydown', e => { if (e.key === 'Escape') closeSidebar(); });
</script>

</body>
</html>