{{-- Pemakaian: @include('partials.hero-slider') --}}
@php $slides = \App\Models\Pengaturan::heroSlides(); @endphp

<section class="hero" aria-label="Beranda">
    <div class="hero-slides" data-count="{{ count($slides) }}">
        @foreach ($slides as $i => $src)
            <div class="hero-slide {{ $i === 0 ? 'is-active' : '' }}"
                 style="background-image:url('{{ $src }}')"></div>
        @endforeach
    </div>
    <div class="hero-overlay"></div>

    <div class="hero-content">
        {{-- Ganti teks sesuai kebutuhan --}}
        <h1>Skrining Kesehatan Mental Siswa</h1>
        <p>Isi kuesioner SDQ dengan jujur. Hasilnya dipakai Guru BK untuk membantu kamu.</p>
        <a href="{{ route('login') }}" class="hero-btn">Mulai skrining</a>
    </div>

    @if (count($slides) > 1)
        <div class="hero-dots" role="tablist" aria-label="Pilih gambar">
            @foreach ($slides as $i => $src)
                <button type="button" class="hero-dot {{ $i === 0 ? 'is-active' : '' }}"
                        aria-label="Gambar {{ $i + 1 }}"></button>
            @endforeach
        </div>
    @endif
</section>

<style>
    .hero { position: relative; min-height: 460px; height: 70vh; max-height: 640px;
            overflow: hidden; display: flex; align-items: center; background: #1e3a5f; }
    .hero-slides, .hero-slide { position: absolute; inset: 0; }
    .hero-slide { background-size: cover; background-position: center;
                  opacity: 0; transition: opacity 1.8s ease-in-out; }
    .hero-slide.is-active { opacity: 1; }
    /* Overlay supaya teks tetap terbaca di gambar apa pun */
    .hero-overlay { position: absolute; inset: 0;
                    background: linear-gradient(90deg, rgba(15,35,60,.82) 0%, rgba(15,35,60,.45) 60%, rgba(15,35,60,.2) 100%); }
    .hero-content { position: relative; z-index: 2; color: #fff; max-width: 620px;
                    padding: 0 clamp(1.25rem, 6vw, 5rem); }
    .hero-content h1 { font-size: clamp(1.75rem, 4.5vw, 2.75rem); line-height: 1.2; margin: 0 0 .75rem; }
    .hero-content p { font-size: 1.05rem; line-height: 1.6; margin: 0 0 1.5rem; opacity: .95; }
    .hero-btn { display: inline-block; padding: .8rem 1.6rem; background: #fff; color: #1e3a5f;
                font-weight: 600; border-radius: 6px; text-decoration: none; }
    .hero-btn:hover { background: #e8eef6; }
    .hero-btn:focus-visible, .hero-dot:focus-visible { outline: 3px solid #9cc4ff; outline-offset: 2px; }
    .hero-dots { position: absolute; z-index: 2; bottom: 1.25rem; left: 50%;
                 transform: translateX(-50%); display: flex; gap: .5rem; }
    .hero-dot { width: 10px; height: 10px; border-radius: 50%; border: 0; padding: 0;
                background: rgba(255,255,255,.45); cursor: pointer; }
    .hero-dot.is-active { background: #fff; }
    @media (prefers-reduced-motion: reduce) { .hero-slide { transition: none; } }
</style>

<script>
(function () {
    var wrap = document.querySelector('.hero-slides');
    if (!wrap || +wrap.dataset.count < 2) return;          // 1 gambar = tanpa animasi

    var slides = wrap.querySelectorAll('.hero-slide');
    var dots   = document.querySelectorAll('.hero-dot');
    var reduce = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    var cur = 0, timer = null, DELAY = 6000;

    function show(n) {
        slides[cur].classList.remove('is-active');
        dots[cur] && dots[cur].classList.remove('is-active');
        cur = (n + slides.length) % slides.length;
        slides[cur].classList.add('is-active');
        dots[cur] && dots[cur].classList.add('is-active');
    }
    function start() { if (!reduce) timer = setInterval(function () { show(cur + 1); }, DELAY); }
    function stop()  { clearInterval(timer); }

    dots.forEach(function (d, i) {
        d.addEventListener('click', function () { stop(); show(i); start(); });
    });

    var hero = document.querySelector('.hero');
    hero.addEventListener('mouseenter', stop);
    hero.addEventListener('mouseleave', start);
    document.addEventListener('visibilitychange', function () { document.hidden ? stop() : start(); });

    start();
})();
</script>