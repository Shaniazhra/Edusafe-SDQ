<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelas {{ $kode }} — SMPN 216 Jakarta</title>
    <link rel="icon" type="image/png" href="{{ asset('logo-smpn216.png') }}">

    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Source+Serif+4:wght@400;500;600;700;800&family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght@100..700&display=swap" rel="stylesheet">
    @vite('resources/css/tema.css')
    <style>
        :root {
            --navy: #0F2747;
            --brand: #1D5FBF;
            --brand-soft: #E8F0FB;
            --bg: #F3F5F9;
            --ink: #14233B;
            --ink-2: #475569;
            --ink-3: #6B7A90;
            --line: #E3E8F0;
            --ok: #0F8A5F;
            --ok-bg: #E3F5ED;
            --warn: #B7690B;
            --warn-bg: #FDF1DC;
            --act: #6D3FD0;
            --act-bg: #EEE8FB;
            --ai: #0A78B5;
            --ai-bg: #E2F2FA;
        }

        body {
            font-family: 'Plus Jakarta Sans', system-ui, sans-serif;
            color: var(--ink);
            background:
                radial-gradient(900px 400px at 85% -80px, #DCE8FA 0%, transparent 70%),
                var(--bg);
            background-attachment: fixed;
        }

        .material-symbols-outlined {
            font-variation-settings:
                'FILL' 0,
                'wght' 400,
                'GRAD' 0,
                'opsz' 24;
        }

        .scrollbar-thin::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }

        .scrollbar-thin::-webkit-scrollbar-thumb {
            background: #CBD5E1;
            border-radius: 99px;
        }

        :focus-visible {
            outline: 2px solid var(--brand);
            outline-offset: 2px;
        }

        /* SIDEBAR */
        #sidebar-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(15,39,71,.5);
            z-index: 40;
        }

        #sidebar-overlay.open {
            display: block;
        }

        #sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: 272px;
            z-index: 50;
            display: flex;
            flex-direction: column;
            padding: 22px 14px 16px;
            background: linear-gradient(180deg, #0F2747 0%, #0B1F3A 100%);
            color: #fff;
            transform: translateX(-100%);
            transition: transform .3s cubic-bezier(.4,0,.2,1);
        }

        #sidebar.open {
            transform: translateX(0);
        }

        #sidebar::after {
            content: '';
            position: absolute;
            inset: 0;
            pointer-events: none;
            background:
                radial-gradient(260px 220px at 0% 0%, rgba(91,157,245,.28), transparent 70%),
                radial-gradient(240px 240px at 100% 100%, rgba(91,157,245,.16), transparent 70%);
        }

        #sidebar > * {
            position: relative;
            z-index: 1;
        }

        .nav-label {
            padding: 0 12px;
            margin: 22px 0 8px;
            font-size: .72rem;
            font-weight: 600;
            color: #7F97B8;
        }

        .nav-link {
            position: relative;
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 11px 12px;
            margin-bottom: 4px;
            border-radius: 10px;
            font-size: .85rem;
            font-weight: 500;
            color: #B7C7DD;
            transition: .15s;
        }

        .nav-link:hover {
            background: rgba(255,255,255,.07);
            color: #fff;
        }

        .nav-link.active {
            background: linear-gradient(
                90deg,
                rgba(91,157,245,.32),
                rgba(91,157,245,.08)
            );
            box-shadow: inset 0 0 0 1px rgba(143,187,250,.25);
            color: #fff;
            font-weight: 600;
        }

        .nav-link.active::before {
            content: '';
            position: absolute;
            left: -14px;
            top: 9px;
            bottom: 9px;
            width: 4px;
            border-radius: 0 4px 4px 0;
            background: #5B9DF5;
        }

        .nav-link.active .material-symbols-outlined {
            color: #8FBBFA;
            font-variation-settings:
                'FILL' 1,
                'wght' 500,
                'GRAD' 0,
                'opsz' 24;
        }

        .side-user {
            margin-top: auto;
            padding: 12px;
            border-radius: 12px;
            background: rgba(255,255,255,.07);
            border: 1px solid rgba(255,255,255,.1);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .side-user .logout {
            margin-left: auto;
            width: 34px;
            height: 34px;
            border-radius: 9px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #9FB3CF;
            transition: .15s;
        }

        .side-user .logout:hover {
            background: rgba(229,72,77,.18);
            color: #FF8A8E;
        }

        @media (min-width: 1024px) {
            #sidebar {
                position: sticky;
                transform: translateX(0) !important;
                flex-shrink: 0;
            }

            #sidebar-overlay {
                display: none !important;
            }

            #hamburger-btn {
                display: none !important;
            }
        }

        @media (prefers-reduced-motion: reduce) {
            #sidebar {
                transition: none !important;
            }
        }

        /* CONTENT */
        .page-content {
            background: transparent;
        }

        .table-card {
            background: #fff;
            border: 1px solid #E3E8F0;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(15,39,71,.025);
        }

        .btn-detail {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            font-size: .75rem;
            font-weight: 600;
            color: #2563EB;
            padding: 6px 12px;
            border-radius: 9px;
            border: 1px solid #E2E8F0;
            transition: .15s;
        }

        .btn-detail:hover {
            background: #EFF6FF;
        }
    </style>
</head>

<body class="flex min-h-screen">

@include('partials.sidebar_dashboard_gurubk')

{{-- MAIN --}}
<main class="flex-1 min-w-0 flex flex-col">

    <div class="page-content flex-1 overflow-y-auto scrollbar-thin p-4 md:p-8 space-y-6">

        {{-- TOMBOL LULUS --}}
        @if(preg_match('/^9-\d+$/', trim($kode)) && $siswaList->count() > 0)

            <form action="{{ route('kelas.lulus', ['kode' => $kode]) }}"
                  method="POST"
                  onsubmit="return confirm('Yakin semua siswa aktif di kelas {{ $kode }} sudah lulus? Data SDQ tetap akan disimpan.');">

                @csrf

                <button type="submit"
                        class="inline-flex items-center px-4 py-2.5 rounded-lg bg-green-600 text-white text-sm font-semibold hover:bg-green-700 transition">

                    <span class="material-symbols-outlined align-middle mr-1.5" style="font-size:18px">
                        school
                    </span>

                    Tandai Semua Siswa Lulus

                </button>

            </form>

        @endif

        {{-- TABEL --}}
        <section class="table-card">

            <div class="px-5 py-4 border-b border-[#E3E8F0] flex items-center justify-between">

                <div>
                    <h3 class="text-sm font-bold text-[#14233B]">
                        Data Siswa
                    </h3>

                    <p class="text-xs text-[#6B7A90] mt-0.5">
                        Daftar siswa dan hasil skrining terakhir
                    </p>
                </div>

            </div>

            <div class="overflow-x-auto scrollbar-thin">

                <table class="w-full text-sm">

                    <thead>
                        <tr class="bg-[#EFF6FF] text-xs text-[#1E40AF] uppercase tracking-wide">

                            <th class="px-5 py-3 text-left font-semibold">
                                Nama
                            </th>

                            <th class="px-5 py-3 text-left font-semibold">
                                NIS
                            </th>

                            <th class="px-5 py-3 text-left font-semibold">
                                Hasil Terakhir
                            </th>

                            <th class="px-5 py-3 text-left font-semibold">
                                Total Skor
                            </th>

                            <th class="px-5 py-3 text-left font-semibold">
                                Tanggal Isi
                            </th>

                            <th class="px-5 py-3 text-left font-semibold">
                                Aksi
                            </th>

                        </tr>
                    </thead>

                    <tbody class="divide-y divide-[#E2E8F0]">

                        @forelse($siswaList as $siswa)

                            @php
                                $h = $siswa->hasil_terakhir;

                                $badge = match($h->hasil_label ?? null) {
                                    'Normal'     => 'bg-[#D1FAE5] text-[#059669]',
                                    'Borderline' => 'bg-[#FEF3C7] text-[#D97706]',
                                    'Abnormal'   => 'bg-[#EDE9FE] text-[#7C3AED]',
                                    default      => 'bg-[#E2E8F0] text-[#475569]',
                                };
                            @endphp

                            <tr class="hover:bg-[#F8FAFC] transition-colors">

                                <td class="px-5 py-3.5 font-semibold text-[#1E293B]">
                                    {{ $siswa->name }}
                                </td>

                                <td class="px-5 py-3.5 text-[#64748B]">
                                    {{ $siswa->nis ?? '-' }}
                                </td>

                                <td class="px-5 py-3.5">

                                    @if($h)

                                        <span class="px-2.5 py-1 rounded-full text-xs font-bold {{ $badge }}">
                                            {{ $h->hasil_label }}
                                        </span>

                                    @else

                                        <span class="text-xs text-[#94A3B8] italic">
                                            Belum mengisi
                                        </span>

                                    @endif

                                </td>

                                <td class="px-5 py-3.5 text-[#64748B]">
                                    {{ $h ? $h->total_kesulitan . '/40' : '-' }}
                                </td>

                                <td class="px-5 py-3.5 text-[#64748B] text-xs">
                                    {{ $h ? $h->created_at->format('d/m/Y') : '-' }}
                                </td>

                                <td class="px-5 py-3.5 text-left">

                                    @if($h)

                                        <a href="/riwayat/{{ $h->id }}"
                                           class="btn-detail">

                                            Detail

                                            <span class="material-symbols-outlined" style="font-size:13px">
                                                chevron_right
                                            </span>

                                        </a>

                                    @else

                                        <span class="text-xs text-[#CBD5E1]">
                                            -
                                        </span>

                                    @endif

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="6"
                                    class="px-5 py-16 text-center text-[#64748B] text-sm">

                                    Tidak ada siswa di kelas ini

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </section>

        <footer class="pt-4 border-t border-[#E3E8F0] flex justify-between items-center flex-wrap gap-2">

            <p class="text-xs text-[#6B7A90]">
                © 2026 SMPN 216 Jakarta — Portal Skrining Kesehatan Mental Siswa
            </p>

            <p class="text-xs text-[#6B7A90]">
                Powered by SDQ + Gaussian Naive Bayes
            </p>

        </footer>

    </div>

</main>

</body>
</html>