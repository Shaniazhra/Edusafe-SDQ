{{-- Panel kiri verifikasi email --}}

@php
    $heroImage = \App\Models\Pengaturan::url('hero');
@endphp

<aside class="verify-panel">
    <div class="verify-panel-top">
        <div class="verify-brand">
            <div class="verify-brand-mark">
                @php
                    $logo = \App\Models\Pengaturan::url('logo');
                @endphp

                @if ($logo)
                    <img src="{{ $logo }}" alt="Logo SMPN 216 Jakarta">
                @endif
            </div>

            <div class="verify-brand-text">
                <div class="verify-school-name">SMPN 216 Jakarta</div>
                <div class="verify-school-sub">
                    Sistem Informasi Layanan Bimbingan dan Konseling
                </div>
            </div>
        </div>
    </div>

    @if ($heroImage)
        <div class="verify-panel-image">
            <img
                src="{{ $heroImage }}"
                alt="Ilustrasi SMPN 216 Jakarta"
                onerror="this.style.display='none'"
            >
        </div>
    @endif

    <div class="verify-panel-art" aria-hidden="true">
        <svg
            class="verify-envelope"
            viewBox="0 0 240 190"
            xmlns="http://www.w3.org/2000/svg"
            fill="none"
        >
            <ellipse
                cx="120"
                cy="166"
                rx="83"
                ry="8"
                fill="#16324B"
                opacity=".13"
            />

            <rect
                x="23"
                y="36"
                width="194"
                height="119"
                rx="9"
                fill="#DCEBF6"
            />

            <path
                d="M23 48L120 116L217 48"
                stroke="#4E8FC4"
                stroke-width="3"
                stroke-linecap="round"
                stroke-linejoin="round"
            />

            <path
                d="M23 148L88 91M217 148L152 91"
                stroke="#B9D4E8"
                stroke-width="3"
                stroke-linecap="round"
            />

            <circle cx="185" cy="38" r="28" fill="#4C7A52"/>

            <circle
                cx="185"
                cy="38"
                r="22"
                stroke="#DCEBDF"
                stroke-width="1.5"
                stroke-dasharray="2 4"
            />

            <path
                d="M173 38L181 46L198 29"
                stroke="#FFFFFF"
                stroke-width="4"
                stroke-linecap="round"
                stroke-linejoin="round"
            />
        </svg>
    </div>

    <div class="verify-panel-copy">
        <h2>Satu langkah lagi</h2>

        <p>
            Verifikasi email memastikan akun hanya digunakan oleh pemiliknya,
            sehingga hasil skrining tetap rahasia dan aman.
        </p>
    </div>

    <div class="verify-panel-foot">
        <span class="verify-foot-line"></span>
        Dinas Pendidikan Provinsi DKI Jakarta
    </div>
</aside>