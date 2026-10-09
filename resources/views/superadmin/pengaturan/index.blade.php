<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengaturan Tampilan — SMPN 216 Jakarta</title>
    <link rel="icon" type="image/png" href="{{ $logo }}">
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

        /* ---------- Judul kartu ---------- */
        .h-title { font-size: .92rem; font-weight: 700; color: var(--ink); }
        .h-sub { font-size: .78rem; line-height: 1.6; color: var(--ink-3); margin-top: 4px; }
        .ico { width: 36px; height: 36px; border-radius: 10px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; background: var(--accent-soft); color: var(--accent); }
        .pill { display: inline-flex; align-items: center; padding: 3px 11px; border-radius: 999px; font-size: .72rem; font-weight: 700; white-space: nowrap; background: #EDF1F7; color: var(--ink-2); }
        .pill.ok { background: #E3F5ED; color: #0F8A5F; }

        /* ---------- Tombol ---------- */
        .btn-sa { display: inline-flex; align-items: center; justify-content: center; gap: 8px; height: 42px; padding: 0 20px; border-radius: 11px;
                  background: var(--accent); color: #fff; font-size: .82rem; font-weight: 600; transition: .15s; box-shadow: 0 6px 14px -8px var(--accent); }
        .btn-sa:hover { background: #3E50BF; }
        .btn-sa:active { transform: scale(.98); }
        .btn-sa:disabled { opacity: .4; cursor: not-allowed; box-shadow: none; transform: none; }
        .btn-soft { display: inline-flex; align-items: center; justify-content: center; gap: 8px; height: 42px; padding: 0 18px; border-radius: 11px;
                    background: var(--accent-soft); color: var(--accent); font-size: .82rem; font-weight: 600; border: 1px solid var(--accent-line); transition: .15s; }
        .btn-soft:hover { background: #E1E6FA; }
        .btn-soft:disabled { opacity: .4; cursor: not-allowed; }
        .btn-danger { display: inline-flex; align-items: center; justify-content: center; gap: 8px; height: 42px; padding: 0 18px; border-radius: 11px;
                      background: #fff; color: #DC2626; font-size: .82rem; font-weight: 600; border: 1px solid #F2C4C4; transition: .15s; }
        .btn-danger:hover { background: #FBE9E9; }

        /* ---------- Input file ---------- */
        .btn-file { font-size: .82rem; color: var(--ink-3); }
        .btn-file::file-selector-button {
            margin-right: .75rem; padding: .55rem 1rem; border-radius: 10px; border: 1px solid var(--accent-line);
            font-size: .8rem; font-weight: 600; font-family: inherit; background: var(--accent-soft); color: var(--accent); cursor: pointer; transition: .15s;
        }
        .btn-file::file-selector-button:hover { background: #E1E6FA; }
        .hero-remove { accent-color: #E5484D; width: 16px; height: 16px; cursor: pointer; }

        /* ---------- Kotak gambar ---------- */
        .thumb { border: 1px solid var(--line); background: #F7F9FC; overflow: hidden; flex-shrink: 0; }
        .row-img { display: flex; align-items: center; gap: 16px; padding: 12px; border: 1px solid var(--line); border-radius: 12px; background: #fff; transition: opacity .15s; }
        .row-new { border: 1px dashed var(--accent-line); background: #F7F8FE; }

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
            #sidebar { position: sticky; top: 0; transform: translateX(0) !important; flex-shrink: 0; }
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
            <img src="{{ $logo }}" alt="Logo SMPN 216" class="w-full h-full object-contain">
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
        <a href="{{ route('superadmin.kuesioner.index') }}" class="nav-link">
            <span class="material-symbols-outlined" style="font-size:21px">quiz</span> Data Kuesioner
        </a>

        <p class="nav-label">Sistem</p>

        <a href="{{ route('superadmin.pengaturan.index') }}" class="nav-link active" aria-current="page">
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
                <h2 class="text-base md:text-lg font-bold text-[#14233B] leading-tight">Pengaturan Tampilan</h2>
                <p class="text-xs text-[#6B7A90] hidden sm:block">Atur logo dan gambar beranda</p>
            </div>
        </div>
    </header>

    <div class="flex-1 p-4 md:p-8 space-y-6 max-w-[1400px] w-full mx-auto">

        @if(session('success'))
        <div class="bg-[#E3F5ED] border border-[#A7F3D0] text-[#0F8A5F] text-sm font-semibold rounded-xl px-4 py-3" role="status">
            {{ session('success') }}
        </div>
        @endif

        @if($errors->any())
        <div class="bg-[#FDECEC] border border-[#F6C9C9] text-[#B42323] text-sm rounded-xl px-4 py-3 space-y-1" role="alert">
            @foreach($errors->all() as $e)
                <p>{{ $e }}</p>
            @endforeach
        </div>
        @endif

        {{-- ================= LOGO ================= --}}
        <form method="POST" action="{{ route('superadmin.pengaturan.update') }}" enctype="multipart/form-data"
              class="card p-5 md:p-6">
            @csrf
            <input type="hidden" name="section" value="logo">

            <div class="flex flex-col md:flex-row gap-6 md:gap-8">

                {{-- Kiri: judul dan keterangan --}}
                <div class="flex items-start gap-3 md:w-5/12 md:flex-shrink-0">
                    <span class="ico"><span class="material-symbols-outlined" style="font-size:20px">image</span></span>
                    <div class="min-w-0">
                        <div class="flex items-center gap-2 flex-wrap">
                            <h3 class="h-title">Logo</h3>
                            <span class="pill {{ $logoCustom ? 'ok' : '' }}">{{ $logoCustom ? 'Logo kustom' : 'Logo default' }}</span>
                        </div>
                        <p class="h-sub">Dipakai di sidebar dan halaman lain. Disarankan gambar persegi (rasio 1:1), format PNG dengan latar transparan. Maksimal 2 MB.</p>
                    </div>
                </div>

                {{-- Kanan: pratinjau, pilih file, dan tombol --}}
                <div class="flex-1 min-w-0 flex flex-col gap-4 md:border-l md:border-[#E3E8F0] md:pl-8">
                    <div class="flex items-center gap-5 flex-wrap p-4 rounded-xl bg-[#F7F9FC] border border-[#E3E8F0]">
                        <div class="w-20 h-20 rounded-full overflow-hidden border border-[#E3E8F0] bg-white flex-shrink-0">
                            <img id="prev_logo" src="{{ $logo }}" alt="Logo saat ini" class="w-full h-full object-contain">
                        </div>
                        <input type="file" id="logo_input" name="logo" accept=".jpg,.jpeg,.png,.webp"
                               class="btn-file min-w-0 max-w-full">
                    </div>

                    <div class="flex flex-wrap items-center justify-end gap-2">
                        @if($logoCustom)
                        <button type="submit" name="reset_logo" value="1" formnovalidate
                                onclick="return confirm('Kembalikan ke logo default? Logo kustom akan dihapus.')"
                                class="btn-danger">
                            <span class="material-symbols-outlined" style="font-size:18px">delete</span>
                            Hapus Logo Kustom
                        </button>
                        @endif
                        <button type="submit" id="logo_save" disabled class="btn-sa">
                            <span class="material-symbols-outlined" style="font-size:18px">save</span>
                            Simpan Logo
                        </button>
                    </div>
                </div>

            </div>
        </form>

        {{-- ================= GAMBAR BERANDA ================= --}}
        <form method="POST" action="{{ route('superadmin.pengaturan.update') }}" enctype="multipart/form-data"
              class="card p-5 md:p-6">
            @csrf
            <input type="hidden" name="section" value="hero">

            <div class="flex items-start justify-between gap-3">
                <div class="flex items-start gap-3">
                    <span class="ico"><span class="material-symbols-outlined" style="font-size:20px">photo_library</span></span>
                    <div>
                        <h3 class="h-title">Gambar beranda</h3>
                        <p class="h-sub">
                            Opsional. Tambahkan gambar sebanyak yang diperlukan (maksimal {{ $maxHero }}).
                            1 gambar tampil diam, 2 gambar atau lebih tampil sebagai slide. Ukuran disarankan 1600 x 900 px, maksimal 2 MB per file (JPG, PNG, atau WEBP).
                        </p>
                    </div>
                </div>
                <span id="hero_count" class="pill"></span>
            </div>

            <div class="mt-5">
                {{-- Gambar yang sudah tersimpan --}}
                @if(count($heroes))
                <div class="space-y-3 mb-3">
                    @foreach($heroes as $h)
                    <div class="hero-existing row-img">
                        <div class="thumb w-36 aspect-video rounded-lg">
                            <img src="{{ $h['url'] }}" alt="Gambar beranda" class="w-full h-full object-cover">
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-semibold text-[#14233B]">Gambar {{ $loop->iteration }}</p>
                            <p class="text-xs text-[#6B7A90] truncate">{{ basename($h['path']) }}</p>
                        </div>
                        <label class="inline-flex items-center gap-2 text-xs font-semibold text-[#475569] cursor-pointer flex-shrink-0">
                            <input type="checkbox" name="remove_hero[]" value="{{ $h['path'] }}" class="hero-remove">
                            Hapus
                        </label>
                    </div>
                    @endforeach
                </div>
                @endif

                {{-- Gambar baru (ditambah lewat tombol) --}}
                <div id="new_hero_list" class="space-y-3"></div>

                <p id="hero_empty" class="hidden text-xs text-[#6B7A90] text-center border border-dashed border-[#CBD5E1] rounded-xl py-8">
                    Belum ada gambar beranda. Klik "Tambah gambar" untuk menambahkan.
                </p>
            </div>

            <div class="flex flex-wrap items-center justify-between gap-2 mt-5">
                <button type="button" id="add_hero_btn" class="btn-soft">
                    <span class="material-symbols-outlined" style="font-size:18px">add_photo_alternate</span>
                    Tambah gambar
                </button>
                <button type="submit" class="btn-sa">
                    <span class="material-symbols-outlined" style="font-size:18px">save</span>
                    Simpan Gambar Beranda
                </button>
            </div>
        </form>

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
    window.addEventListener('resize', () => {
        if (window.innerWidth >= 1024) closeSidebar();
    });
    document.addEventListener('keydown', e => { if (e.key === 'Escape') closeSidebar(); });

    const MAX_SIZE = 2 * 1024 * 1024;
    const MAX_HERO = {{ $maxHero }};

    // ---------- LOGO ----------
    const logoInput = document.getElementById('logo_input');
    const logoSave  = document.getElementById('logo_save');
    logoInput.addEventListener('change', () => {
        const file = logoInput.files[0];
        if (!file) { logoSave.disabled = true; return; }
        if (file.size > MAX_SIZE) {
            alert('Ukuran file maksimal 2 MB.');
            logoInput.value = '';
            logoSave.disabled = true;
            return;
        }
        document.getElementById('prev_logo').src = URL.createObjectURL(file);
        logoSave.disabled = false;
    });

    // ---------- HERO ----------
    const list     = document.getElementById('new_hero_list');
    const addBtn   = document.getElementById('add_hero_btn');
    const countEl  = document.getElementById('hero_count');
    const emptyEl  = document.getElementById('hero_empty');

    function activeExisting() {
        return [...document.querySelectorAll('.hero-existing')]
            .filter(r => !r.querySelector('.hero-remove').checked).length;
    }
    function refreshHero() {
        const total = activeExisting() + list.children.length;
        countEl.textContent = total + ' / ' + MAX_HERO + ' gambar';
        addBtn.disabled = total >= MAX_HERO;
        emptyEl.classList.toggle('hidden', total > 0);
    }

    document.querySelectorAll('.hero-remove').forEach(cb => {
        cb.addEventListener('change', () => {
            cb.closest('.hero-existing').classList.toggle('opacity-40', cb.checked);
            refreshHero();
        });
    });

    addBtn.addEventListener('click', () => {
        if (activeExisting() + list.children.length >= MAX_HERO) return;

        const row = document.createElement('div');
        row.className = 'row-img row-new';
        row.innerHTML = `
            <div class="thumb w-36 aspect-video rounded-lg bg-white flex items-center justify-center">
                <img class="w-full h-full object-cover hidden" alt="Pratinjau">
                <span class="material-symbols-outlined text-[#94A3B8] ph" style="font-size:28px">image</span>
            </div>
            <div class="flex-1 min-w-0">
                <input type="file" name="hero_new[]" accept=".jpg,.jpeg,.png,.webp" class="btn-file w-full">
            </div>
            <button type="button" title="Batalkan" aria-label="Batalkan gambar" class="w-8 h-8 rounded-lg hover:bg-red-50 flex items-center justify-center flex-shrink-0">
                <span class="material-symbols-outlined text-[#6B7A90] hover:text-red-500" style="font-size:20px">close</span>
            </button>`;

        const input = row.querySelector('input[type=file]');
        const img   = row.querySelector('img');
        const ph    = row.querySelector('.ph');

        input.addEventListener('change', () => {
            const file = input.files[0];
            if (!file) return;
            if (file.size > MAX_SIZE) {
                alert('Ukuran file maksimal 2 MB.');
                input.value = '';
                return;
            }
            img.src = URL.createObjectURL(file);
            img.classList.remove('hidden');
            ph.classList.add('hidden');
        });
        row.querySelector('button').addEventListener('click', () => {
            row.remove();
            refreshHero();
        });

        list.appendChild(row);
        refreshHero();
    });

    refreshHero();
</script>

</body>
</html>