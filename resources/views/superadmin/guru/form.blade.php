<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ isset($guru) ? 'Edit' : 'Tambah' }} Guru BK — SMPN 216 Jakarta</title>
    @php
        $logoUrl = \App\Models\Pengaturan::url('logo', 'logo-smpn216.png');
        $isEdit  = isset($guru);
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
        .scrollbar-thin::-webkit-scrollbar-thumb { background: rgba(255,255,255,.18); border-radius: 99px; }

        .card { background: #fff; border: 1px solid var(--line); border-radius: 14px; box-shadow: 0 1px 2px rgba(15,39,71,.05), 0 8px 24px -16px rgba(15,39,71,.18); }
        .h-title { font-size: .92rem; font-weight: 700; color: var(--ink); }
        .h-sub { font-size: .78rem; line-height: 1.6; color: var(--ink-3); margin-top: 3px; }
        .ico { width: 36px; height: 36px; border-radius: 10px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; background: var(--accent-soft); color: var(--accent); }

        /* ---------- Ringkasan akun (kiri) ---------- */
        .profile-top { padding: 28px 24px 22px; text-align: center; border-bottom: 1px solid var(--line);
            background: radial-gradient(260px 140px at 50% -40px, #E1E6FA 0%, transparent 75%), #fff; }
        .big-avatar { width: 76px; height: 76px; margin: 0 auto; border-radius: 50%; display: flex; align-items: center; justify-content: center;
            font-size: 1.5rem; font-weight: 800; color: #fff; background: linear-gradient(135deg, var(--accent), #2B78E0); box-shadow: 0 0 0 4px var(--accent-soft), 0 10px 20px -10px var(--accent); }
        .role-pill { display: inline-flex; align-items: center; gap: 5px; padding: 3px 11px; border-radius: 999px; background: var(--accent-soft); color: var(--accent); font-size: .74rem; font-weight: 700; }
        .info-row { display: flex; align-items: center; justify-content: space-between; gap: 12px; padding: 12px 0; border-bottom: 1px dashed var(--line); font-size: .8rem; }
        .info-row:last-child { border-bottom: 0; padding-bottom: 0; }
        .info-row dt { color: var(--ink-3); display: flex; align-items: center; gap: 8px; flex-shrink: 0; }
        .info-row dd { color: var(--ink); font-weight: 600; text-align: right; min-width: 0; overflow-wrap: anywhere; }
        .cap-row { display: flex; align-items: flex-start; gap: 10px; padding: 8px 0; font-size: .8rem; color: var(--ink-2); line-height: 1.5; }
        .cap-row .material-symbols-outlined { color: #0F8A5F; flex-shrink: 0; margin-top: 1px; font-variation-settings: 'FILL' 1, 'wght' 500, 'GRAD' 0, 'opsz' 24; }

        /* ---------- Form ---------- */
        .lbl { display: block; margin-bottom: 6px; font-size: .78rem; font-weight: 600; color: var(--ink-2); }
        .lbl small { font-weight: 400; color: #94A3B8; }
        .input { width: 100%; height: 44px; padding: 0 14px; border-radius: 11px; border: 1px solid var(--line); background: #fff; font-size: .86rem; color: var(--ink); transition: .15s; }
        .input::placeholder { color: #A3AEC0; }
        .input:focus { outline: none; border-color: var(--accent); box-shadow: 0 0 0 4px rgba(75,95,214,.12); }
        .btn-sa { display: inline-flex; align-items: center; justify-content: center; gap: 8px; height: 44px; padding: 0 22px; border-radius: 11px;
                  background: var(--accent); color: #fff; font-size: .84rem; font-weight: 600; transition: .15s; box-shadow: 0 6px 14px -8px var(--accent); }
        .btn-sa:hover { background: #3E50BF; }
        .btn-sa:active, .btn-line:active { transform: scale(.98); }
        .btn-line { display: inline-flex; align-items: center; justify-content: center; height: 44px; padding: 0 22px; border-radius: 11px;
                    border: 1px solid var(--line); background: #fff; color: var(--ink-2); font-size: .84rem; font-weight: 600; transition: .15s; }
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

    <header class="topbar h-16 bg-white/90 backdrop-blur-md border-b border-[#E3E8F0] flex items-center px-4 md:px-8 sticky top-0 z-30">
        <div class="flex items-center gap-3">
            <button id="hamburger-btn" onclick="openSidebar()" aria-label="Buka menu"
                    class="w-9 h-9 rounded-lg border border-[#E3E8F0] flex items-center justify-center hover:bg-[#ECEFFC] transition-colors lg:hidden">
                <span class="material-symbols-outlined text-[#475569]" style="font-size:20px">menu</span>
            </button>
            <a href="{{ route('superadmin.guru.index') }}" title="Kembali ke Data Guru BK" aria-label="Kembali"
               class="w-9 h-9 rounded-lg border border-[#E3E8F0] flex items-center justify-center hover:bg-[#ECEFFC] transition-colors">
                <span class="material-symbols-outlined text-[#475569]" style="font-size:20px">arrow_back</span>
            </a>
            <div>
                <h2 class="text-base md:text-lg font-bold text-[#14233B] leading-tight">{{ $isEdit ? 'Edit Akun Guru BK' : 'Tambah Akun Guru BK' }}</h2>
                <p class="text-xs text-[#6B7A90] hidden sm:block">{{ $isEdit ? 'Perbarui data akun Guru BK' : 'Buat akun baru untuk Guru BK' }}</p>
            </div>
        </div>
    </header>

    <div class="flex-1 p-4 md:p-8 space-y-6 max-w-[1400px] w-full mx-auto">

        @if($errors->any())
        <div class="bg-[#FDECEC] border border-[#F5C2C2] text-[#B42318] text-sm rounded-xl px-4 py-3" role="alert">
            <p class="font-semibold mb-1">Data belum bisa disimpan. Mohon periksa kembali:</p>
            <ul class="list-disc list-inside space-y-0.5">
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">

            {{-- ============ Kiri: ringkasan akun ============ --}}
            <aside class="lg:col-span-4 card overflow-hidden">

                @if($isEdit)
                <div class="profile-top">
                    <div class="big-avatar">{{ strtoupper(substr($guru->name, 0, 2)) }}</div>
                    <h3 class="text-base font-bold text-[#14233B] mt-4 leading-snug break-words">{{ $guru->name }}</h3>
                    <div class="mt-2">
                        <span class="role-pill">
                            <span class="material-symbols-outlined" style="font-size:14px">groups</span>Guru BK
                        </span>
                    </div>
                </div>

                <dl class="px-5 md:px-6 py-4">
                    <div class="info-row">
                        <dt><span class="material-symbols-outlined" style="font-size:18px">badge</span>NIP</dt>
                        <dd>{{ $guru->nip ?: '-' }}</dd>
                    </div>
                    <div class="info-row">
                        <dt><span class="material-symbols-outlined" style="font-size:18px">mail</span>Email</dt>
                        <dd>{{ $guru->email }}</dd>
                    </div>
                    @if($guru->created_at)
                    <div class="info-row">
                        <dt><span class="material-symbols-outlined" style="font-size:18px">event</span>Terdaftar</dt>
                        <dd>{{ $guru->created_at->format('d/m/Y') }}</dd>
                    </div>
                    @endif
                </dl>
                @else
                <div class="profile-top">
                    <div class="big-avatar">
                        <span class="material-symbols-outlined" style="font-size:34px">person_add</span>
                    </div>
                    <h3 class="text-base font-bold text-[#14233B] mt-4 leading-snug">Akun Guru BK baru</h3>
                    <div class="mt-2">
                        <span class="role-pill">
                            <span class="material-symbols-outlined" style="font-size:14px">groups</span>Guru BK
                        </span>
                    </div>
                </div>

                <div class="px-5 md:px-6 py-4">
                    <p class="text-xs font-bold text-[#475569] mb-1">Akun ini dapat</p>
                    <div class="cap-row">
                        <span class="material-symbols-outlined" style="font-size:18px">check_circle</span>
                        Meninjau hasil skrining siswa
                    </div>
                    <div class="cap-row">
                        <span class="material-symbols-outlined" style="font-size:18px">check_circle</span>
                        Menulis laporan BK
                    </div>
                </div>
                @endif
            </aside>

            {{-- ============ Kanan: form ============ --}}
            <section class="lg:col-span-8 card overflow-hidden">

                <div class="flex items-center gap-3 px-5 md:px-6 py-4 border-b border-[#E3E8F0]">
                    <div class="ico"><span class="material-symbols-outlined" style="font-size:20px">{{ $isEdit ? 'manage_accounts' : 'person_add' }}</span></div>
                    <div>
                        <h4 class="h-title">Data akun</h4>
                        <p class="h-sub">Akun ini dapat meninjau hasil skrining dan menulis laporan BK.</p>
                    </div>
                </div>

                <form method="POST" action="{{ $isEdit ? route('superadmin.guru.update', $guru->id) : route('superadmin.guru.store') }}">
                    @csrf
                    @if($isEdit)
                        @method('PUT')
                    @endif

                    <div class="p-5 md:p-6 grid grid-cols-1 sm:grid-cols-2 gap-5">

                        <div class="sm:col-span-2">
                            <label for="name" class="lbl">Nama lengkap</label>
                            <input id="name" type="text" name="name" value="{{ old('name', $guru->name ?? '') }}" required autocomplete="off"
                                   placeholder="Contoh: Siti Aminah, S.Pd." class="input">
                        </div>

                        <div>
                            <label for="nip" class="lbl">NIP <small>(opsional)</small></label>
                            <input id="nip" type="text" name="nip" value="{{ old('nip', $guru->nip ?? '') }}" autocomplete="off"
                                   placeholder="Nomor Induk Pegawai" class="input">
                        </div>

                        <div>
                            <label for="email" class="lbl">Email</label>
                            <input id="email" type="email" name="email" value="{{ old('email', $guru->email ?? '') }}" required autocomplete="off"
                                   placeholder="nama@email.com" class="input">
                        </div>

                        <div class="sm:col-span-2">
                            <label for="password" class="lbl">Password {!! $isEdit ? '<small>(kosongkan jika tidak diubah)</small>' : '' !!}</label>
                            <input id="password" type="password" name="password" {{ $isEdit ? '' : 'required' }} autocomplete="new-password"
                                   placeholder="{{ $isEdit ? 'Biarkan kosong untuk tetap memakai password lama' : 'Buat password untuk akun ini' }}" class="input">
                        </div>

                    </div>

                    <div class="flex flex-col-reverse sm:flex-row sm:justify-end gap-3 px-5 md:px-6 py-4 border-t border-[#E3E8F0] bg-[#FBFCFE]">
                        <a href="{{ route('superadmin.guru.index') }}" class="btn-line">Batal</a>
                        <button type="submit" class="btn-sa">
                            <span class="material-symbols-outlined" style="font-size:18px">{{ $isEdit ? 'check' : 'person_add' }}</span>
                            {{ $isEdit ? 'Simpan Perubahan' : 'Buat Akun' }}
                        </button>
                    </div>
                </form>
            </section>

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