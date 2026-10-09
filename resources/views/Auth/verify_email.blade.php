<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Email — MindCheck SMPN 216 Jakarta</title>
    <link rel="icon" type="image/png" href="{{ \App\Models\Pengaturan::url('logo', 'logo-smpn216.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Source+Serif+4:opsz,wght@8..60,500;8..60,600;8..60,700&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    @vite('resources/css/tema.css')
    
    <style>
        /* ============ Warna (sama dengan beranda, login, dan registrasi) ============ */
        :root {
            --navy: #16324B; --navy-deep: #0E2338; --blue: #4E8FC4; --blue-soft: #DCEBF6;
            --bg: #F5F9FC; --leaf: #4C7A52; --leaf-soft: #E5EFE6; --ink: #16324B; --ink-soft: #52687D; --line: #D8E6F0;
            --error-bg: #FBEAEA; --error-ink: #B4453F; --ok-bg: #E7F5EC; --ok-ink: #2F6B45;
        }
        * { box-sizing: border-box; }
        html, body { margin: 0; min-height: 100%; background: #fff; color: var(--ink); font-family: 'Inter', system-ui, sans-serif; -webkit-font-smoothing: antialiased; }
        a { color: inherit; text-decoration: none; }
        h1, h2, .serif { font-family: 'Source Serif 4', Georgia, serif; }
        :focus-visible { outline: 3px solid var(--blue); outline-offset: 2px; border-radius: 4px; }

        /* ============ Susunan halaman: panel kiri penuh + isi di kanan ============ */
        .page { min-height: 100vh; display: grid; grid-template-columns: minmax(0, 1fr); position: relative; }
        .page::before {
            content: ""; position: absolute; top: 0; left: 0; right: 0; height: 5px; z-index: 5;
            background: linear-gradient(90deg, var(--navy) 0%, var(--blue) 50%, var(--leaf) 100%);
        }
        @media (min-width: 960px) { .page { grid-template-columns: minmax(380px, 5fr) minmax(0, 7fr); } }

        /* ---------- Panel kiri ---------- */
        .side {
            position: relative; isolation: isolate; color: #EAF2F8;
            padding: 36px 24px 28px;
            display: flex; flex-direction: column; justify-content: space-between; gap: 20px;
            background: url('{{ asset("gedung_216.jpeg") }}') center/cover no-repeat;
        }
        .side::before {
            content: ""; position: absolute; inset: 0; z-index: -1;
            background:
                radial-gradient(420px 300px at 100% 0%, rgba(78,143,196,.35), transparent 65%),
                linear-gradient(180deg, rgba(14,35,56,.9) 0%, rgba(22,50,75,.88) 55%, rgba(14,35,56,.96) 100%);
        }
        @media (min-width: 960px) { .side { padding: 48px 48px 36px; position: sticky; top: 0; height: 100vh; } }

        .brand { display: flex; align-items: center; gap: 14px; }
        .brand-mark {
            width: 48px; height: 48px; border-radius: 50%; background: #fff; flex-shrink: 0;
            border: 1.5px solid rgba(255,255,255,.5); padding: 3px;
            display: flex; align-items: center; justify-content: center; overflow: hidden;
        }
        .brand-mark img { width: 100%; height: 100%; object-fit: contain; }
        .brand-name { font-family: 'Source Serif 4', Georgia, serif; font-size: 17px; font-weight: 600; color: #fff; line-height: 1.25; }
        .brand-sub { font-size: 12px; color: #B9CADA; margin-top: 3px; }

        .art { display: flex; flex-direction: column; align-items: center; text-align: center; padding: 8px 0; }
        .art svg { width: 190px; height: auto; overflow: visible; }
        .art h2 { margin: 20px 0 0; font-size: 26px; font-weight: 600; color: #fff; letter-spacing: -.2px; }
        .art p { margin: 10px auto 0; max-width: 330px; font-size: 13.5px; line-height: 1.75; color: #C9DAE7; }
        @media (min-width: 960px) { .art svg { width: 260px; } .art h2 { font-size: 30px; } }
        @media (max-width: 959px) { .art p { display: none; } .art h2 { margin-top: 12px; font-size: 22px; } .art svg { width: 130px; } }

        .side-foot { font-size: 12px; line-height: 1.6; color: #A9BFD2; text-align: center; }
        @media (max-width: 959px) { .side-foot { display: none; } }

        /* Ilustrasi amplop: melayang pelan */
        .env { animation: floaty 5.5s ease-in-out infinite; transform-origin: center; }
        .seal { transform-box: fill-box; transform-origin: center; animation: pop .7s .4s cubic-bezier(.34,1.56,.64,1) both; }
        @keyframes floaty { 50% { transform: translateY(-9px); } }
        @keyframes pop { from { transform: scale(.3); opacity: 0; } to { transform: scale(1); opacity: 1; } }

        /* ---------- Isi kanan (tanpa kartu) ---------- */
        .main { display: flex; flex-direction: column; justify-content: center; padding: 36px 24px 40px; background: linear-gradient(180deg, var(--blue-soft) 0%, #fff 260px); }
        @media (min-width: 960px) { .main { padding: 56px 72px; } }
        .content { width: 100%; max-width: 520px; }
        .rise { animation: rise .55s cubic-bezier(.2,.7,.2,1) both; animation-delay: var(--d, 0s); }
        @keyframes rise { from { opacity: 0; transform: translateY(14px); } }

        /* Penunjuk langkah */
        .stepper { list-style: none; margin: 0 0 34px; padding: 0; display: flex; }
        .stepper li { position: relative; flex: 1; padding-right: 10px; }
        .stepper li:last-child { flex: 0 0 auto; padding-right: 0; }
        .stepper li:not(:last-child)::after {
            content: ""; position: absolute; top: 13px; left: 36px; right: 8px; height: 2px; background: var(--line);
        }
        .stepper li.done:not(:last-child)::after { background: var(--leaf); }
        .dot {
            width: 28px; height: 28px; border-radius: 50%; display: flex; align-items: center; justify-content: center;
            font-size: 12px; font-weight: 700; border: 2px solid var(--line); background: #fff; color: var(--ink-soft);
        }
        .done .dot { background: var(--leaf); border-color: var(--leaf); color: #fff; }
        .now .dot { background: var(--navy); border-color: var(--navy); color: #fff; animation: ring 2.4s ease-out infinite; }
        @keyframes ring { 0% { box-shadow: 0 0 0 0 rgba(22,50,75,.3); } 70%, 100% { box-shadow: 0 0 0 10px rgba(22,50,75,0); } }
        .step-label { display: block; margin-top: 8px; font-size: 12px; font-weight: 600; color: var(--ink-soft); line-height: 1.35; }
        .now .step-label { color: var(--navy); }
        .done .step-label { color: var(--leaf); }

        .eyebrow { display: flex; align-items: center; gap: 10px; font-size: 12px; font-weight: 700; letter-spacing: .12em; text-transform: uppercase; color: var(--blue); }
        .eyebrow::before { content: ""; width: 28px; height: 2px; background: var(--blue); }

        h1 { margin: 14px 0 0; font-size: clamp(2rem, 4.6vw, 2.7rem); line-height: 1.14; font-weight: 600; letter-spacing: -.02em; color: var(--navy); }
        h1 em { font-style: normal; color: var(--blue); }
        .lead { margin: 16px 0 0; font-size: 15px; line-height: 1.8; color: var(--ink-soft); max-width: 460px; }

        /* Alamat email, bergaya alamat tujuan surat */
        .addr { margin-top: 26px; padding: 4px 0 14px; border-bottom: 2px dashed #B9CFE2; }
        .addr small { display: block; font-size: 11px; font-weight: 700; letter-spacing: .12em; text-transform: uppercase; color: var(--ink-soft); }
        .addr strong {
            display: flex; align-items: center; gap: 10px; margin-top: 8px;
            font-family: 'Source Serif 4', Georgia, serif; font-size: 20px; font-weight: 600; color: var(--navy); word-break: break-all; line-height: 1.35;
        }
        .addr svg { flex-shrink: 0; }

        /* Pemberitahuan (tanpa kotak, hanya garis di sisi) */
        .note { margin-top: 22px; padding: 4px 0 4px 14px; font-size: 13.5px; font-weight: 500; line-height: 1.65; border-left: 4px solid; }
        .note.ok { color: var(--ok-ink); border-color: var(--ok-ink); background: linear-gradient(90deg, var(--ok-bg), transparent); }
        .note.err { color: var(--error-ink); border-color: var(--error-ink); background: linear-gradient(90deg, var(--error-bg), transparent); }

        /* Panduan 3 langkah */
        .guide-title { display: flex; align-items: center; gap: 12px; margin-top: 32px; font-size: 11px; font-weight: 800; letter-spacing: .12em; text-transform: uppercase; color: var(--ink-soft); }
        .guide-title::after { content: ""; flex: 1; height: 1px; background: var(--line); }
        .guide { list-style: none; margin: 16px 0 0; padding: 0; counter-reset: g; }
        .guide li { position: relative; padding: 0 0 16px 40px; font-size: 14px; line-height: 1.65; color: var(--ink-soft); counter-increment: g; }
        .guide li:last-child { padding-bottom: 0; }
        .guide li::before {
            content: counter(g); position: absolute; left: 0; top: 0; width: 26px; height: 26px; border-radius: 50%;
            display: flex; align-items: center; justify-content: center; font-size: 12px; font-weight: 700;
            background: var(--blue-soft); color: var(--navy);
        }
        .guide li:not(:last-child)::after { content: ""; position: absolute; left: 12px; top: 30px; bottom: 4px; width: 2px; background: var(--line); }
        .guide b { color: var(--navy); font-weight: 600; }

        /* Tombol */
        .btn {
            margin-top: 30px; width: 100%; display: inline-flex; align-items: center; justify-content: center; gap: 10px;
            background: var(--navy); color: #fff; border: 1.5px solid var(--navy);
            font-family: inherit; font-weight: 600; font-size: 15px; padding: 15px 22px; border-radius: 8px; cursor: pointer;
            box-shadow: 0 12px 22px -14px rgba(22,50,75,.7);
            transition: background .15s ease, transform .12s ease;
        }
        .btn:hover { background: var(--navy-deep); }
        .btn:active { transform: scale(.99); }
        .btn:disabled { opacity: .65; cursor: default; box-shadow: none; }
        .btn svg { transition: transform .15s ease; }
        .btn:not(:disabled):hover svg { transform: translateX(3px); }

        .home { display: inline-block; margin-top: 16px; font-size: 13.5px; font-weight: 600; color: var(--navy); border-bottom: 1.5px solid var(--blue); padding-bottom: 1px; }
        .home:hover { color: var(--blue); }

        .help { margin-top: 28px; padding-top: 18px; border-top: 1px solid var(--line); font-size: 13px; line-height: 1.75; color: var(--ink-soft); }
        .help strong { color: var(--navy); font-weight: 600; }

        .logout-line { margin-top: 18px; font-size: 13.5px; color: var(--ink-soft); }
        .logout-line form { display: inline; }
        .logout-line button { background: none; border: none; padding: 0; font: inherit; font-weight: 700; color: var(--navy); cursor: pointer; border-bottom: 1.5px solid var(--blue); }
        .logout-line button:hover { color: var(--blue); }

        @media (max-width: 480px) {
            .stepper { margin-bottom: 26px; }
            .step-label { font-size: 11px; }
            .addr strong { font-size: 17px; }
        }
        @media (prefers-reduced-motion: reduce) {
            .env, .seal, .now .dot, .rise { animation: none !important; }
            .btn, .btn svg { transition: none !important; }
        }
    </style>
</head>
<body>
<div class="page">

    {{-- ===== Panel kiri ===== --}}
    <aside class="side">
        <a href="/" class="brand" aria-label="Kembali ke beranda MindCheck">
            <span class="brand-mark"><img src="{{ \App\Models\Pengaturan::url('logo', 'logo-smpn216.png') }}" alt="Logo SMPN 216 Jakarta"></span>
            <span>
                <span class="brand-name" style="display:block">SMPN 216 Jakarta</span>
                <span class="brand-sub" style="display:block">Portal Skrining Kesehatan Mental</span>
            </span>
        </a>

        <div class="art">
            {{-- Ilustrasi amplop dengan segel --}}
            <svg viewBox="0 0 260 200" fill="none" role="img" aria-label="Ilustrasi amplop email" class="env">
                <ellipse cx="130" cy="186" rx="86" ry="8" fill="rgba(0,0,0,.28)"/>
                <rect x="30" y="52" width="200" height="124" rx="12" fill="#EAF2F8"/>
                <rect x="52" y="30" width="156" height="110" rx="6" fill="#fff"/>
                <rect x="70" y="50" width="86" height="6" rx="3" fill="#DCEBF6"/>
                <rect x="70" y="66" width="120" height="6" rx="3" fill="#DCEBF6"/>
                <rect x="70" y="82" width="104" height="6" rx="3" fill="#DCEBF6"/>
                <path d="M30 64c0-6.6 5.4-12 12-12h176c6.6 0 12 5.4 12 12v100c0 6.6-5.4 12-12 12H42c-6.6 0-12-5.4-12-12V64Z" fill="#DCEBF6"/>
                <path d="M30 64l100 66 100-66" stroke="#4E8FC4" stroke-width="3" stroke-linejoin="round" stroke-linecap="round"/>
                <path d="M30 168l72-58M230 168l-72-58" stroke="#B9D3EA" stroke-width="3" stroke-linecap="round"/>
                <g class="seal">
                    <circle cx="196" cy="62" r="26" fill="#4C7A52"/>
                    <circle cx="196" cy="62" r="21" stroke="rgba(255,255,255,.55)" stroke-width="1.5" stroke-dasharray="3 3"/>
                    <path d="M185 62.5l8 8 15-16" stroke="#fff" stroke-width="4.5" stroke-linecap="round" stroke-linejoin="round"/>
                </g>
            </svg>
            <h2>Satu langkah lagi</h2>
            <p>Verifikasi email memastikan akun hanya digunakan oleh pemiliknya, sehingga hasil skrining tetap rahasia dan aman.</p>
        </div>

        <div class="side-foot">Dinas Pendidikan Provinsi DKI Jakarta</div>
    </aside>

    {{-- ===== Isi kanan ===== --}}
    <main class="main">
        <div class="content">

            <ol class="stepper rise" aria-label="Tahapan pendaftaran">
                <li class="done">
                    <span class="dot" aria-hidden="true"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="3.4" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12.5l4.5 4.5L19 7.5"/></svg></span>
                    <span class="step-label">Daftar akun</span>
                </li>
                <li class="now" aria-current="step">
                    <span class="dot" aria-hidden="true">2</span>
                    <span class="step-label">Verifikasi email</span>
                </li>
                <li>
                    <span class="dot" aria-hidden="true">3</span>
                    <span class="step-label">Mulai skrining</span>
                </li>
            </ol>

            <div class="rise" style="--d:.06s">
                <p class="eyebrow">Langkah 2 dari 3</p>
                <h1>Periksa emailmu untuk <em>mengaktifkan</em> akun</h1>
                <p class="lead">Kami telah mengirim tautan verifikasi ke alamat berikut. Akunmu akan aktif setelah tautan tersebut dibuka.</p>

                <div class="addr">
                    <small>Dikirim ke</small>
                    <strong>
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#4E8FC4" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="3" y="5" width="18" height="14" rx="2"/><path d="M3 7l9 6 9-6"/></svg>
                        <span>{{ auth()->user()->email }}</span>
                    </strong>
                </div>

                @if (session('success'))
                    <div class="note ok" role="status">{{ session('success') }}</div>
                @endif
                @if ($errors->any())
                    <div class="note err" role="alert">{{ $errors->first() }}</div>
                @endif
            </div>

            <div class="rise" style="--d:.12s">
                <div class="guide-title">Langkah selanjutnya</div>
                <ol class="guide">
                    <li><b>Buka kotak masuk emailmu</b> dan cari pesan dari MindCheck.</li>
                    <li><b>Klik tombol verifikasi</b> di dalam pesan tersebut.</li>
                    <li><b>Kembali ke sini</b> dan mulailah mengisi skrining.</li>
                </ol>

                <form method="POST" action="{{ route('verification.send') }}" id="resendForm">
                    @csrf
                    <button type="submit" class="btn" id="btnResend">
                        <span id="btnLabel">Kirim ulang tautan verifikasi</span>
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
                    </button>
                </form>

                <a href="/" class="home">Sudah memverifikasi? Lanjut ke beranda</a>

                <p class="help"><strong>Email tidak masuk?</strong> Periksa folder spam atau promosi. Jika salah memasukkan alamat email saat mendaftar, keluarlah terlebih dahulu, lalu daftar ulang atau temui admin sekolah.</p>

                <div class="logout-line">
                    <form method="POST" action="/logout">
                        @csrf
                        Bukan kamu? <button type="submit">Keluar</button>
                    </form>
                </div>
            </div>

        </div>
    </main>
</div>

<script>
    (function () {
        var KEY = 'verifikasiKirimUlang';
        var WAIT = 60; // detik
        var form  = document.getElementById('resendForm');
        var btn   = document.getElementById('btnResend');
        var label = document.getElementById('btnLabel');
        var normal = label.textContent;

        function sisa() {
            var t = 0;
            try { t = parseInt(localStorage.getItem(KEY) || '0', 10); } catch (e) {}
            return Math.max(0, WAIT - Math.floor((Date.now() - t) / 1000));
        }

        function tick() {
            var s = sisa();
            if (s > 0) {
                btn.disabled = true;
                label.textContent = 'Kirim ulang dalam ' + s + ' detik';
                setTimeout(tick, 1000);
            } else {
                btn.disabled = false;
                label.textContent = normal;
            }
        }

        form.addEventListener('submit', function () {
            try { localStorage.setItem(KEY, String(Date.now())); } catch (e) {}
            btn.disabled = true;
            label.textContent = 'Mengirim...';
        });

        tick();
    })();
</script>
</body>
</html>