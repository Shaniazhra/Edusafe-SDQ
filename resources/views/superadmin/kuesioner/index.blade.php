<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Kuesioner — SMPN 216 Jakarta</title>
    @php
        $logoUrl  = \App\Models\Pengaturan::url('logo', 'logo-smpn216.png');
        $adaFilter = request('cari') || request('label');
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

        /* ---------- Filter ---------- */
        .lbl { display: block; margin-bottom: 6px; font-size: .75rem; font-weight: 600; color: var(--ink-2); }
        .input { width: 100%; height: 42px; padding: 0 14px; border-radius: 11px; border: 1px solid var(--line); background: #fff; font-size: .84rem; color: var(--ink); transition: .15s; }
        .input::placeholder { color: #A3AEC0; }
        .input:focus { outline: none; border-color: var(--accent); box-shadow: 0 0 0 4px rgba(75,95,214,.12); }
        select.input { padding-right: 36px; appearance: none; -webkit-appearance: none;
            background: #fff url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='%236B7A90' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpath d='m6 9 6 6 6-6'/%3E%3C/svg%3E") no-repeat right 12px center; }
        .btn-sa { display: inline-flex; align-items: center; justify-content: center; gap: 8px; height: 42px; padding: 0 20px; border-radius: 11px;
                  background: var(--accent); color: #fff; font-size: .82rem; font-weight: 600; transition: .15s; box-shadow: 0 6px 14px -8px var(--accent); }
        .btn-sa:hover { background: #3E50BF; }
        .btn-sa:active { transform: scale(.98); }
        .link-reset { display: inline-flex; align-items: center; height: 42px; padding: 0 6px; font-size: .78rem; font-weight: 600; color: var(--ink-3); }
        .link-reset:hover { color: var(--accent); text-decoration: underline; }

        /* ---------- Tabel ---------- */
        .tbl th { padding: 12px 18px; text-align: left; font-size: .7rem; font-weight: 700; letter-spacing: .04em;
                  text-transform: uppercase; color: var(--ink-3); background: #F7F9FC; border-bottom: 1px solid var(--line); white-space: nowrap; }
        .tbl td { padding: 14px 18px; font-size: .82rem; border-bottom: 1px solid var(--line); vertical-align: middle; }
        .tbl tbody tr:hover { background: #FAFBFE; }
        .tbl tbody tr:last-child td { border-bottom: 0; }
        .avatar { width: 38px; height: 38px; border-radius: 50%; background: var(--accent-soft); color: var(--accent);
                  display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: .8rem; flex-shrink: 0; }
        .kelas-pill { display: inline-flex; align-items: center; padding: 3px 10px; border-radius: 999px; background: var(--accent-soft); color: var(--accent); font-size: .74rem; font-weight: 700; }
        .badge { display: inline-flex; align-items: center; gap: 6px; padding: 4px 11px; border-radius: 999px; font-size: .74rem; font-weight: 700; white-space: nowrap; }
        .badge::before { content: ''; width: 6px; height: 6px; border-radius: 50%; background: currentColor; }
        .badge.ok   { background: #E3F5ED; color: #0F8A5F; }
        .badge.warn { background: #FDF1DC; color: #B7690B; }
        .badge.act  { background: #EEE8FB; color: #6D3FD0; }
        .badge.none { background: #EDF1F7; color: #475569; }
        .icon-btn { width: 34px; height: 34px; display: flex; align-items: center; justify-content: center; border-radius: 9px; border: 1px solid var(--line); background: #fff; transition: .15s; }
        .icon-btn.edit:hover { background: var(--accent-soft); border-color: var(--accent-line); }
        .icon-btn.reset:hover { background: #FDF1DC; border-color: #F1D9A8; }
        .icon-btn.del:hover { background: #FBE9E9; border-color: #F2C4C4; }

        /* ---------- Pagination ---------- */
        .pg-wrap { display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 12px; padding: 14px 18px; border-top: 1px solid var(--line); background: #FBFCFE; }
        .pg-info { font-size: .78rem; color: var(--ink-3); }
        .pg-info b { color: var(--ink); font-weight: 700; }
        .pg-list { display: flex; align-items: center; gap: 6px; flex-wrap: wrap; }
        .pg-btn { min-width: 36px; height: 36px; padding: 0 10px; display: inline-flex; align-items: center; justify-content: center; border-radius: 10px;
                  border: 1px solid var(--line); background: #fff; font-size: .8rem; font-weight: 600; color: var(--ink-2); transition: .15s; }
        a.pg-btn:hover { background: var(--accent-soft); border-color: var(--accent-line); color: var(--accent); }
        .pg-btn.on { background: var(--accent); border-color: var(--accent); color: #fff; box-shadow: 0 6px 14px -8px var(--accent); }
        .pg-btn.off { color: #C3CCDA; background: #F7F9FC; cursor: not-allowed; }
        .pg-dots { padding: 0 4px; color: var(--ink-3); font-size: .8rem; }
        @media (max-width: 559px) { .pg-wrap { justify-content: center; text-align: center; } }

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
        <div class="flex items-center gap-3">
            <button id="hamburger-btn" onclick="openSidebar()" aria-label="Buka menu"
                    class="w-9 h-9 rounded-lg border border-[#E3E8F0] flex items-center justify-center hover:bg-[#ECEFFC] transition-colors lg:hidden">
                <span class="material-symbols-outlined text-[#475569]" style="font-size:20px">menu</span>
            </button>
            <div>
                <h2 class="text-base md:text-lg font-bold text-[#14233B] leading-tight">Data Kuesioner</h2>
                <p class="text-xs text-[#6B7A90] hidden sm:block">Seluruh hasil pengisian SDQ siswa</p>
            </div>
        </div>
    </header>

    <div class="flex-1 p-4 md:p-8 space-y-6 max-w-[1400px] w-full mx-auto">

        @if(session('success'))
        <div class="bg-[#E3F5ED] border border-[#A7F3D0] text-[#0F8A5F] text-sm font-semibold rounded-xl px-4 py-3" role="status">
            {{ session('success') }}
        </div>
        @endif

        {{-- ===== Filter ===== --}}
        <form method="GET" action="{{ route('superadmin.kuesioner.index') }}" class="card p-4 md:p-5 flex flex-wrap gap-3 items-end">
            <div class="flex-1 min-w-[180px]">
                <label for="cari" class="lbl">Cari nama</label>
                <input id="cari" type="text" name="cari" value="{{ request('cari') }}" placeholder="Nama siswa" autocomplete="off" class="input">
            </div>
            <div class="w-full sm:w-52">
                <label for="label" class="lbl">Hasil SDQ</label>
                <select id="label" name="label" class="input">
                    <option value="">Semua hasil</option>
                    <option value="Normal" {{ request('label') === 'Normal' ? 'selected' : '' }}>Normal</option>
                    <option value="Borderline" {{ request('label') === 'Borderline' ? 'selected' : '' }}>Borderline</option>
                    <option value="Abnormal" {{ request('label') === 'Abnormal' ? 'selected' : '' }}>Abnormal</option>
                </select>
            </div>
            <button type="submit" class="btn-sa">
                <span class="material-symbols-outlined" style="font-size:18px">search</span>
                Filter
            </button>
            @if($adaFilter)
            <a href="{{ route('superadmin.kuesioner.index') }}" class="link-reset">Reset</a>
            @endif
        </form>

        {{-- ===== Tabel ===== --}}
        <section class="card overflow-hidden">
            <div class="overflow-x-auto scrollbar-thin">
                <table class="tbl w-full" style="min-width:820px">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Kelas</th>
                            <th>Total</th>
                            <th>Hasil SDQ</th>
                            <th>Keputusan akhir</th>
                            <th>Tanggal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($kuesionerList as $s)
                        @php
                            $kelasBadge = match($s->hasil_label) {
                                'Normal'     => 'ok',
                                'Borderline' => 'warn',
                                'Abnormal'   => 'act',
                                default      => 'none',
                            };
                            $keputusan = $s->keputusan_akhir ?? $s->hasil_label;
                            $kelasKep  = match($keputusan) {
                                'Normal'     => 'ok',
                                'Borderline' => 'warn',
                                'Abnormal'   => 'act',
                                default      => 'none',
                            };
                        @endphp
                        <tr>
                            <td>
                                <div class="flex items-center gap-3">
                                    <span class="avatar">{{ strtoupper(substr($s->nama, 0, 2)) }}</span>
                                    <span class="font-semibold text-[#14233B]">{{ $s->nama }}</span>
                                </div>
                            </td>
                            <td>
                                @if($s->kelas)
                                    <span class="kelas-pill">{{ $s->kelas }}</span>
                                @else
                                    <span class="text-[#475569]">-</span>
                                @endif
                            </td>
                            <td class="font-bold text-[#14233B]">{{ $s->total_kesulitan }}<span class="text-[#6B7A90] font-normal">/40</span></td>
                            <td><span class="badge {{ $kelasBadge }}">{{ $s->hasil_label ?: '-' }}</span></td>
                            <td><span class="badge {{ $kelasKep }}">{{ $keputusan ?: '-' }}</span></td>
                            <td class="text-xs text-[#6B7A90] whitespace-nowrap">{{ $s->created_at->format('d/m/Y') }}</td>
                            <td>
                                <div class="flex justify-start gap-2">
                                    <a href="{{ route('superadmin.kuesioner.detail', $s->id) }}" class="icon-btn edit" title="Lihat detail" aria-label="Lihat detail {{ $s->nama }}">
                                        <span class="material-symbols-outlined text-[#4B5FD6]" style="font-size:17px">visibility</span>
                                    </a>
                                    {{-- Nama dan tanggal lewat data-attribute supaya tanda petik tidak merusak konfirmasi --}}
                                    <form method="POST" action="{{ route('superadmin.kuesioner.destroy', $s->id) }}"
                                          data-nama="{{ $s->nama }}" data-tanggal="{{ $s->created_at->format('d/m/Y') }}"
                                          onsubmit="return confirm('Hapus data kuesioner ' + this.dataset.nama + ' tanggal ' + this.dataset.tanggal + '?\n\nData yang dihapus tidak bisa dikembalikan.');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="icon-btn del" title="Hapus" aria-label="Hapus data {{ $s->nama }}">
                                            <span class="material-symbols-outlined text-red-500" style="font-size:17px">delete</span>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-16">
                                <span class="material-symbols-outlined text-[#CBD5E1]" style="font-size:40px">{{ $adaFilter ? 'search_off' : 'quiz' }}</span>
                                <p class="text-sm font-semibold text-[#14233B] mt-2">{{ $adaFilter ? 'Data kuesioner tidak ditemukan' : 'Belum ada data kuesioner' }}</p>
                                <p class="text-xs text-[#6B7A90] mt-1">{{ $adaFilter ? 'Coba ubah kelas atau hasil SDQ.' : 'Hasil pengisian SDQ siswa akan muncul di sini.' }}</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($kuesionerList->total() > 0)
            @php
                $kuesionerList->withQueryString();
                $hal   = $kuesionerList->currentPage();
                $akhir = $kuesionerList->lastPage();

                // Nomor halaman yang ditampilkan: pertama, terakhir, dan sekitar halaman aktif
                $nomor = collect([1, $akhir, $hal - 1, $hal, $hal + 1])
                    ->filter(fn ($n) => $n >= 1 && $n <= $akhir)
                    ->unique()->sort()->values();
            @endphp
            <nav class="pg-wrap" aria-label="Navigasi halaman">
                <p class="pg-info">
                    Menampilkan <b>{{ $kuesionerList->firstItem() }}–{{ $kuesionerList->lastItem() }}</b>
                    dari <b>{{ number_format($kuesionerList->total()) }}</b> pengisian
                </p>

                @if($kuesionerList->hasPages())
                <div class="pg-list">
                    @if($kuesionerList->onFirstPage())
                        <span class="pg-btn off" aria-disabled="true"><span class="material-symbols-outlined" style="font-size:18px">chevron_left</span></span>
                    @else
                        <a href="{{ $kuesionerList->previousPageUrl() }}" class="pg-btn" rel="prev" aria-label="Halaman sebelumnya"><span class="material-symbols-outlined" style="font-size:18px">chevron_left</span></a>
                    @endif

                    @foreach($nomor as $i => $n)
                        @if($i > 0 && $n - $nomor[$i - 1] > 1)
                            <span class="pg-dots">…</span>
                        @endif
                        @if($n === $hal)
                            <span class="pg-btn on" aria-current="page">{{ $n }}</span>
                        @else
                            <a href="{{ $kuesionerList->url($n) }}" class="pg-btn" aria-label="Halaman {{ $n }}">{{ $n }}</a>
                        @endif
                    @endforeach

                    @if($kuesionerList->hasMorePages())
                        <a href="{{ $kuesionerList->nextPageUrl() }}" class="pg-btn" rel="next" aria-label="Halaman berikutnya"><span class="material-symbols-outlined" style="font-size:18px">chevron_right</span></a>
                    @else
                        <span class="pg-btn off" aria-disabled="true"><span class="material-symbols-outlined" style="font-size:18px">chevron_right</span></span>
                    @endif
                </div>
                @endif
            </nav>
            @endif
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
</script>

</body>
</html>