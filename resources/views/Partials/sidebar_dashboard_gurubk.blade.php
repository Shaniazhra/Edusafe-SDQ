{{-- Sidebar Guru BK: dipakai semua halaman lewat @include('partials.sidebar') --}}
{{-- Kartu tindakan hanya tampil bila halaman mengirim $cntTindakan (dashboard) --}}
{{-- CSS sidebar umum ada di tema.css; di sini hanya CSS khusus kartu tindakan --}}

<style>
    .side-card {
        margin-bottom: 12px;
        padding: 14px;
        border-radius: 14px;
        background: linear-gradient(135deg, rgba(91,157,245,.28), rgba(91,157,245,.08));
        border: 1px solid rgba(143,187,250,.25);
    }

    .side-card b {
        font-size: 1.5rem;
        font-weight: 800;
        line-height: 1;
    }
</style>

@php
    $adaTahun = \Illuminate\Support\Facades\Route::has('riwayat.angkatan.index');
    $onTahun = $adaTahun && request()->routeIs('riwayat.angkatan*');
    $onRiwayat = !$onTahun && (request()->is('riwayat') || request()->is('riwayat/*'));
@endphp

<div id="sidebar-overlay" onclick="closeSidebar()"></div>

<aside id="sidebar" aria-label="Navigasi utama">

    <a href="{{ url('/') }}"
       title="Lihat halaman beranda"
       class="flex items-center gap-3 px-2 py-1 hover:opacity-90 transition-opacity">

        {{-- Background putih logo dihapus --}}
        <div class="w-11 h-11 overflow-hidden flex-shrink-0">
            <img src="{{ \App\Models\Pengaturan::url('logo', 'logo-smpn216.png') }}"
                 alt="Logo SMPN 216"
                 class="w-full h-full object-contain">
        </div>

        <div class="leading-tight min-w-0">
            <h1 class="text-[16px] font-semibold text-white">SMPN 216 Jakarta</h1>
            <p class="text-[12px] text-[#9FB3CF] mt-0.5">
                Skrining Kesehatan Mental
            </p>
        </div>
    </a>

    <nav class="flex-1 overflow-y-auto scrollbar-thin mt-2">

        <p class="nav-label">Menu utama</p>

        <a href="/dashboard"
           class="nav-link {{ request()->is('dashboard') ? 'active' : '' }}">
            <span class="material-symbols-outlined" style="font-size:21px">
                dashboard
            </span>
            Dashboard
        </a>

        <a href="/riwayat"
           class="nav-link {{ $onRiwayat ? 'active' : '' }}">
            <span class="material-symbols-outlined" style="font-size:21px">
                clinical_notes
            </span>
            Riwayat Skrining
        </a>

        <a href="{{ route('kelas.index') }}"
           class="nav-link {{ request()->routeIs('kelas.*') ? 'active' : '' }}">
            <span class="material-symbols-outlined" style="font-size:21px">
                groups
            </span>
            Data per Kelas
        </a>

        {{-- Menu Tahun Angkatan --}}
        @if($adaTahun)
            <a href="{{ route('riwayat.angkatan.index') }}"
               class="nav-link {{ $onTahun ? 'active' : '' }}">
                <span class="material-symbols-outlined" style="font-size:21px">
                    school
                </span>
                Tahun Angkatan
            </a>
        @endif

    </nav>

    @if(isset($cntTindakan, $totalSiswa))
        <div class="side-card">
            <p class="text-[12px] text-[#B7C7DD]">
                Perlu tindakan hari ini
            </p>

            <div class="flex items-end justify-between mt-1.5">
                <b>{{ $cntTindakan }}</b>

                <span class="text-xs text-[#B7C7DD]">
                    dari {{ $totalSiswa }} siswa
                </span>
            </div>

            <div class="h-1.5 rounded-full bg-white/15 mt-3 overflow-hidden">
                <div class="h-full rounded-full bg-[#8FBBFA]"
                     style="width:{{ $totalSiswa > 0 ? round($cntTindakan / $totalSiswa * 100) : 0 }}%">
                </div>
            </div>
        </div>
    @endif

    <div class="side-user">

        <div class="w-10 h-10 rounded-full bg-[#3B7DDD] flex items-center justify-center text-white font-bold text-sm flex-shrink-0">
            {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
        </div>

        <div class="overflow-hidden min-w-0">
            <p class="text-sm font-semibold truncate text-white">
                {{ Auth::user()->name }}
            </p>

            <p class="text-xs text-[#9FB3CF] truncate">
                Guru BK
            </p>
        </div>

        <form method="POST" action="/logout" class="ml-auto">
            @csrf

            <button type="submit"
                    title="Keluar"
                    aria-label="Keluar"
                    class="logout">
                <span class="material-symbols-outlined" style="font-size:19px">
                    logout
                </span>
            </button>
        </form>

    </div>

</aside>

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
        if (window.innerWidth >= 1024) {
            closeSidebar();
        }
    });

    document.addEventListener('keydown', e => {
        if (e.key === 'Escape') {
            closeSidebar();
        }
    });
</script>