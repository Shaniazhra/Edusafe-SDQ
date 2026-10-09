<!DOCTYPE html>
<html lang="id">
<head>
    <title>Data Guru BK — SMPN 216 Jakarta</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @php
        $logoUrl  = \App\Models\Pengaturan::url('logo', 'logo-smpn216.png');
        $sekarang = now('Asia/Jakarta')->locale('id');
    @endphp
    <link rel="icon" type="image/png" href="{{ $logoUrl }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">

    <style>
        /* ============ Token: sama dengan Dashboard Super Admin ============ */
        :root {
            --navy: #0F2747; --brand: #1D5FBF; --bg: #F3F5F9;
            --ink: #14233B; --ink-2: #475569; --ink-3: #6B7A90; --line: #E3E8F0;
            --accent: #4B5FD6;
            --accent-soft: #ECEFFC;
            --accent-line: #C9D0F6;
            --accent-glow: #8D9BF0;
        }
        [hidden] { display: none !important; }
        body {
            font-family: 'Plus Jakarta Sans', system-ui, sans-serif; color: var(--ink);
            background: radial-gradient(900px 420px at 90% -100px, #E1E6FA 0%, transparent 70%), var(--bg);
            background-attachment: fixed;
        }
        .material-symbols-outlined { font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24; }
        :focus-visible { outline: 2px solid var(--accent); outline-offset: 2px; }
        .scrollbar-thin::-webkit-scrollbar { width: 6px; height: 6px; }
        .scrollbar-thin::-webkit-scrollbar-thumb { background: #CBD5E1; border-radius: 99px; }

        /* ---------- Komponen dasar ---------- */
        .card { background: #fff; border: 1px solid var(--line); border-radius: 14px; box-shadow: 0 1px 2px rgba(15,39,71,.05), 0 8px 24px -16px rgba(15,39,71,.18); }
        .h-title { font-size: .9rem; font-weight: 700; color: var(--ink); }
        .h-sub { font-size: .75rem; color: var(--ink-3); margin-top: 2px; }
        .ico { width: 36px; height: 36px; border-radius: 10px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; background: var(--accent-soft); color: var(--accent); }

        .btn-sa { display: inline-flex; align-items: center; gap: 8px; height: 40px; padding: 0 16px; border-radius: 11px;
                  background: var(--accent); color: #fff; font-size: .82rem; font-weight: 600; transition: .15s;
                  box-shadow: 0 6px 14px -8px var(--accent); }
        .btn-sa:hover { background: #3E50BF; }
        .icon-btn { width: 34px; height: 34px; display: flex; align-items: center; justify-content: center; border-radius: 9px;
                    border: 1px solid var(--line); background: #fff; transition: .15s; }
        .icon-btn.edit:hover { background: var(--accent-soft); border-color: var(--accent-line); }
        .icon-btn.del:hover { background: #FBE9E9; border-color: #F2C4C4; }

        /* ---------- Header ---------- */
        .topbar::before { content: ''; position: absolute; left: 0; right: 0; top: 0; height: 3px; background: linear-gradient(90deg, #12143A 0%, var(--accent) 55%, #2B78E0 100%); }

        /* ---------- Banner ---------- */
        .hero { position: relative; overflow: hidden; border-radius: 20px; padding: 28px; color: #fff;
                background: linear-gradient(125deg, #0E1030 0%, #1A1D52 50%, #3B4BC0 100%); box-shadow: 0 18px 40px -18px rgba(40,50,160,.6); }
        .hero::before { content: ''; position: absolute; inset: 0; pointer-events: none;
            background-image: linear-gradient(rgba(255,255,255,.07) 1px, transparent 1px), linear-gradient(90deg, rgba(255,255,255,.07) 1px, transparent 1px);
            background-size: 32px 32px;
            -webkit-mask-image: linear-gradient(100deg, transparent 20%, #000 100%); mask-image: linear-gradient(100deg, transparent 20%, #000 100%); }
        .hero::after { content: ''; position: absolute; width: 420px; height: 420px; right: -120px; top: -170px; border-radius: 50%; pointer-events: none;
            background: radial-gradient(circle, rgba(141,155,240,.42), transparent 68%); }
        .hero > .in { position: relative; z-index: 1; }
        .hero-chip { display: inline-flex; align-items: center; gap: 6px; padding: 5px 12px; border-radius: 8px; background: rgba(255,255,255,.1); border: 1px solid rgba(255,255,255,.2); font-size: .74rem; font-weight: 600; letter-spacing: .03em; }

        /* ---------- Tabel ---------- */
        .tbl th { padding: 12px 18px; text-align: left; font-size: .7rem; font-weight: 700; letter-spacing: .04em;
                  text-transform: uppercase; color: var(--ink-3); background: #F7F9FC; border-bottom: 1px solid var(--line); white-space: nowrap; }
        .tbl td { padding: 14px 18px; font-size: .82rem; border-bottom: 1px solid var(--line); vertical-align: middle; }
        .tbl tbody tr:hover { background: #FAFBFE; }
        .tbl tbody tr:last-child td { border-bottom: 0; }
        .avatar { width: 38px; height: 38px; border-radius: 50%; background: var(--accent-soft); color: var(--accent);
                  display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: .8rem; flex-shrink: 0; }

        /* ---------- Sidebar: sama dengan Dashboard Super Admin ---------- */
        #sidebar-overlay { display: none; position: fixed; inset: 0; background: rgba(14,16,48,.55); z-index: 40; }
        #sidebar-overlay.open { display: block; }
        #sidebar { position: fixed; top: 0; left: 0; height: 100vh; width: 272px; z-index: 50; display: flex; flex-direction: column; padding: 22px 14px 16px;
            background: linear-gradient(180deg, #1A1D52 0%, #12143A 100%); color: #fff; transform: translateX(-100%); transition: transform .3s cubic-bezier(.4,0,.2,1); }
        #sidebar.open { transform: translateX(0); }
        #sidebar::after { content: ''; position: absolute; inset: 0; pointer-events: none;
            background: radial-gradient(260px 220px at 0% 0%, rgba(141,155,240,.3), transparent 70%), radial-gradient(240px 240px at 100% 100%, rgba(75,95,214,.28), transparent 70%); }
        #sidebar > * { position: relative; z-index: 1; }
        .admin-badge { display: inline-flex; align-items: center; gap: 5px; margin: 14px 8px 0; padding: 4px 10px; border-radius: 8px; background: rgba(141,155,240,.18); border: 1px solid rgba(141,155,240,.35); color: #C9D0F6; font-size: .68rem; font-weight: 700; letter-spacing: .08em; text-transform: uppercase; align-self: flex-start; }
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
        @media (max-width: 479px) { .hero { padding: 22px 18px; } }
        @media (prefers-reduced-motion: reduce) { #sidebar { transition: none !important; } }
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

    <span class="admin-badge">
        <span class="material-symbols-outlined" style="font-size:14px">shield_person</span>
        Super Admin
    </span>

    <nav class="flex-1 overflow-y-auto scrollbar-thin mt-1">
        <p class="nav-label">Menu utama</p>

        <a href="{{ route('superadmin.dashboard') }}" class="nav-link">
            <span class="material-symbols-outlined" style="font-size:21px">dashboard</span> Dashboard
        </a>
        <a href="{{ route('superadmin.guru.index') }}" class="nav-link active" aria-current="page">
            <span class="material-symbols-outlined" style="font-size:21px">groups</span> Data Guru BK
        </a>
        <a href="{{ route('superadmin.siswa.index') }}" class="nav-link">
            <span class="material-symbols-outlined" style="font-size:21px">school</span> Data Siswa
        </a>
        <a href="{{ route('superadmin.kuesioner.index') }}" class="nav-link">
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

    <header class="topbar h-16 bg-white/90 backdrop-blur-md border-b border-[#E3E8F0] flex items-center justify-between px-4 md:px-8 sticky top-0 z-30">
        <div class="flex items-center gap-3">
            <button id="hamburger-btn" onclick="openSidebar()" aria-label="Buka menu"
                    class="w-9 h-9 rounded-lg border border-[#E3E8F0] flex items-center justify-center hover:bg-[#ECEFFC] transition-colors lg:hidden">
                <span class="material-symbols-outlined text-[#475569]" style="font-size:20px">menu</span>
            </button>
            <div>
                <h2 class="text-base md:text-lg font-bold text-[#14233B] leading-tight">Data Guru BK</h2>
                <p class="text-xs text-[#6B7A90] hidden sm:block">Kelola akun Guru Bimbingan Konseling</p>
            </div>
        </div>
        <a href="{{ route('superadmin.guru.create') }}" class="btn-sa">
            <span class="material-symbols-outlined" style="font-size:18px">add</span>
            <span class="hidden sm:inline">Tambah Guru BK</span>
        </a>
    </header>

    <div class="flex-1 p-4 md:p-8 space-y-6 max-w-[1400px] w-full mx-auto">

        @if(session('success'))
        <div class="bg-[#E3F5ED] border border-[#A7F3D0] text-[#0F8A5F] text-sm font-semibold rounded-xl px-4 py-3" role="status">
            {{ session('success') }}
        </div>
        @endif

        {{-- ===== Banner ===== --}}
        <section class="hero">
            <div class="in flex flex-col md:flex-row md:items-end justify-between gap-5">
                <div class="min-w-0 max-w-2xl">
                    <span class="hero-chip">
                        <span class="material-symbols-outlined" style="font-size:16px">groups</span>
                        {{ $guruList->count() }} AKUN GURU BK
                    </span>
                    <h3 class="text-2xl md:text-3xl font-extrabold mt-3 leading-tight">Data Guru BK</h3>
                    <p class="text-sm text-indigo-100 mt-2 leading-relaxed">
                        Tambah, ubah, atau hapus akun Guru Bimbingan Konseling yang mengelola hasil skrining siswa.
                    </p>
                </div>

                @if($guruList->count() > 0)
                <div class="relative w-full md:w-72 flex-shrink-0">
                    <span class="material-symbols-outlined absolute left-3.5 top-1/2 -translate-y-1/2 text-[#94A3B8] pointer-events-none" style="font-size:18px">search</span>
                    <input id="cari-guru" type="search" placeholder="Cari nama, NIP, atau email" aria-label="Cari Guru BK" autocomplete="off"
                           class="w-full h-11 pl-10 pr-4 rounded-xl bg-white/95 text-sm font-medium text-[#14233B] placeholder:text-[#94A3B8] placeholder:font-normal border border-transparent focus:outline-none focus:ring-4 focus:ring-white/35">
                </div>
                @endif
            </div>
        </section>

        {{-- ===== Tabel ===== --}}
        <section class="card overflow-hidden">

            <div class="flex items-center gap-3 px-5 py-4 border-b border-[#E3E8F0]">
                <div class="ico"><span class="material-symbols-outlined" style="font-size:20px">badge</span></div>
                <div>
                    <h4 class="h-title">Daftar akun Guru BK</h4>
                    <p class="h-sub">Akun yang dapat meninjau hasil skrining dan menulis laporan BK</p>
                </div>
            </div>

            <div class="overflow-x-auto scrollbar-thin">
                <table class="tbl w-full" style="min-width:680px">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>NIP</th>
                            <th>Email</th>
                            <th>Terdaftar</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($guruList as $guru)
                        <tr data-cari="{{ strtolower($guru->name . ' ' . ($guru->nip ?? '') . ' ' . $guru->email) }}">
                            <td>
                                <div class="flex items-center gap-3">
                                    <span class="avatar">{{ strtoupper(substr($guru->name, 0, 2)) }}</span>
                                    <span class="font-semibold text-[#14233B]">{{ $guru->name }}</span>
                                </div>
                            </td>
                            <td class="text-[#475569]">{{ $guru->nip ?: '-' }}</td>
                            <td class="text-[#475569]">{{ $guru->email }}</td>
                            <td class="text-xs text-[#6B7A90] whitespace-nowrap">{{ $guru->created_at->format('d/m/Y') }}</td>
                            <td>
                                <div class="flex justify-start gap-2">
                                    <a href="{{ route('superadmin.guru.edit', $guru->id) }}" class="icon-btn edit" title="Edit" aria-label="Edit {{ $guru->name }}">
                                        <span class="material-symbols-outlined text-[#4B5FD6]" style="font-size:17px">edit</span>
                                    </a>
                                    {{-- Nama lewat data-nama supaya tanda petik di nama tidak merusak konfirmasi --}}
                                    <form method="POST" action="{{ route('superadmin.guru.destroy', $guru->id) }}"
                                          data-nama="{{ $guru->name }}"
                                          onsubmit="return confirm('Hapus akun Guru BK ' + this.dataset.nama + '?\n\nAkun ini tidak akan bisa login lagi.');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="icon-btn del" title="Hapus" aria-label="Hapus {{ $guru->name }}">
                                            <span class="material-symbols-outlined text-red-500" style="font-size:17px">delete</span>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-16">
                                <span class="material-symbols-outlined text-[#CBD5E1]" style="font-size:40px">groups</span>
                                <p class="text-sm font-semibold text-[#14233B] mt-2">Belum ada akun Guru BK</p>
                                <p class="text-xs text-[#6B7A90] mt-1">Klik "Tambah Guru BK" untuk membuat akun pertama.</p>
                            </td>
                        </tr>
                        @endforelse

                        <tr id="guru-kosong" hidden>
                            <td colspan="5" class="text-center py-14">
                                <span class="material-symbols-outlined text-[#CBD5E1]" style="font-size:40px">search_off</span>
                                <p class="text-sm font-semibold text-[#14233B] mt-2">Guru BK tidak ditemukan</p>
                                <p class="text-xs text-[#6B7A90] mt-1">Coba kata kunci lain.</p>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>

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

    // Cari guru (nama, NIP, email)
    (function () {
        var input = document.getElementById('cari-guru');
        if (!input) return;
        var rows = Array.from(document.querySelectorAll('tr[data-cari]'));
        var kosong = document.getElementById('guru-kosong');

        input.addEventListener('input', function () {
            var q = input.value.trim().toLowerCase();
            var ada = 0;
            rows.forEach(function (r) {
                var cocok = !q || r.dataset.cari.indexOf(q) !== -1;
                r.hidden = !cocok;
                if (cocok) ada++;
            });
            kosong.hidden = ada > 0;
        });
    })();
</script>

</body>
</html>