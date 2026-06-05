<?php
$pageTitle = 'Poder Down — El poder de creer e incluir';
$pageDescription = 'Descubre obras únicas de Cami y lleva el mensaje de Poder Down a tu espacio. Charlas, arte y productos para una inclusión real.';
$activePage = 'inicio';
$showNavSearch = true;
require 'components/header.php';
?>
<style>
  :root {
    --cami-turquesa: #3CAEE0;
  }
  /* HERO */
  .hero-section {
    background: var(--cami-bg);
    min-height: 92vh;
    display: flex;
    align-items: center;
    position: relative;
    overflow: hidden;
    padding: 4rem 0;
  }
  .hero-tagline {
    font-family: var(--font-kranky);
    font-size: clamp(2.6rem, 7vw, 5.5rem);
    color: var(--cami-azul);
    line-height: 1.05;
  }
  .hero-tagline .highlight { color: var(--cami-turq); }
  .hero-pill {
    display: inline-block;
    background: var(--cami-turq);
    color: var(--cami-azul);
    font-family: var(--font-playpen);
    font-weight: 700;
    font-size: .75rem;
    letter-spacing: 2px;
    text-transform: uppercase;
    border-radius: 50px;
    padding: .4rem 1.2rem;
    margin-bottom: 1.5rem;
  }
  .hero-sub {
    font-size: 1.05rem;
    line-height: 1.8;
    opacity: .75;
    max-width: 480px;
    margin: 1.4rem 0 2.2rem;
  }
  .hero-stats {
    display: flex;
    gap: 2.5rem;
    flex-wrap: wrap;
    margin-top: 2.5rem;
    padding-top: 2rem;
    border-top: 2px solid var(--cami-border);
  }
  .hero-stat-num {
    font-family: var(--font-kranky);
    font-size: 2rem;
    display: block;
    color: var(--cami-azul);
    line-height: 1;
  }
  .hero-stat-label {
    font-size: .74rem;
    font-weight: 600;
    opacity: .55;
    text-transform: uppercase;
    letter-spacing: 1px;
  }
  .hero-visual {
    position: relative;
    width: 100%;
    max-width: 420px;
    margin: 0 auto;
  }
  .blob-main {
    width: 380px;
    height: 380px;
    background: var(--cami-turq);
    border-radius: 46% 54% 62% 38% / 50% 44% 56% 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    animation: blobFloat 8s ease-in-out infinite alternate;
    margin: 0 auto;
  }
  .blob-main i { font-size: 9rem; color: rgba(0, 51, 102, .18); }
  .blob-dot-coral {
    position: absolute;
    bottom: 10px;
    right: 0;
    width: 90px;
    height: 90px;
    background: var(--cami-coral);
    border-radius: 50%;
    animation: blobFloat 6s ease-in-out infinite alternate-reverse;
  }
  .blob-dot-yellow {
    position: absolute;
    top: 20px;
    right: 30px;
    width: 55px;
    height: 55px;
    background: var(--cami-amarillo);
    border-radius: 50%;
    animation: blobFloat 7s ease-in-out infinite alternate;
  }
  @keyframes blobFloat {
    from { transform: translate(0,0) rotate(0deg) scale(1); }
    to { transform: translate(6px,12px) rotate(4deg) scale(1.03); }
  }
  /* MARQUEE */
  .marquee-strip {
    background: var(--cami-azul);
    padding: .9rem 0;
    overflow: hidden;
    white-space: nowrap;
  }
  .marquee-inner {
    display: inline-flex;
    gap: 3rem;
    animation: marquee 60s linear infinite;
  }
  .marquee-item {
    font-family: var(--font-kranky);
    font-size: 1rem;
    color: white;
    display: inline-flex;
    align-items: center;
    gap: .5rem;
    flex-shrink: 0;
  }
  .mdot { width: 7px; height: 7px; border-radius: 50%; display: inline-block; }
  @keyframes marquee {
    0% { transform: translateX(0); }
    100% { transform: translateX(-50%); }
  }
  /* SECTIONS GLOBAL */
  .section-eyebrow {
    font-family: var(--font-playpen);
    font-size: .78rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 2.5px;
    color: var(--cami-turq);
    display: flex;
    align-items: center;
    gap: .5rem;
    margin-bottom: .6rem;
  }
  .section-title {
    font-family: var(--font-kranky);
    font-size: clamp(2rem, 5vw, 3rem);
    color: var(--cami-azul);
    line-height: 1.1;
  }
  /* PÚBLICO */
  .publico-card {
    background: var(--cami-bg);
    border-radius: 20px;
    padding: 2rem 1.6rem;
    height: 100%;
    border-bottom: 4px solid transparent;
    transition: all .3s;
  }
  .publico-card:hover {
    border-bottom-color: var(--cami-turq);
    transform: translateY(-5px);
    box-shadow: 0 14px 36px rgba(0, 51, 102, .1);
  }
  .publico-icon {
    width: 58px; height: 58px; border-radius: 16px;
    display: flex; align-items: center; justify-content: center;
    font-size: 1.5rem; margin-bottom: 1.2rem;
  }
  .publico-title { font-family: var(--font-kranky); font-size: 1.2rem; color: var(--cami-azul); margin-bottom: .6rem; }
  .publico-desc { font-size: .87rem; line-height: 1.7; opacity: .72; margin: 0; }
  /* CAMI SECTION */
  .cami-section {
    background: var(--cami-azul);
    padding: 5rem 0;
    position: relative;
    overflow: hidden;
  }
  .cami-quote {
    font-family: var(--font-kranky);
    font-size: clamp(1.4rem, 3.5vw, 2.2rem);
    color: var(--cami-turq);
    line-height: 1.3;
    border-left: 4px solid var(--cami-turq);
    padding-left: 1.4rem;
    margin: 1.5rem 0;
  }
  .cami-body { color: rgba(255,255,255,.8); font-size: .95rem; line-height: 1.9; }
  .cami-chip {
    background: rgba(78,210,173,.15); color: var(--cami-turq);
    border: 1px solid rgba(78,210,173,.3); border-radius: 50px;
    padding: .35rem 1rem; font-size: .78rem; font-weight: 700; display: inline-block; margin: .2rem;
  }
  .cami-stat-big { font-family: var(--font-kranky); font-size: 3rem; color: var(--cami-turq); line-height: 1; }
  .cami-stat-sub { color: rgba(255,255,255,.6); font-size: .8rem; line-height: 1.4; }
  /* DESEO */
  .deseo-card {
    background: white; border-radius: 20px; padding: 2rem 1.8rem;
    height: 100%; position: relative; overflow: hidden; transition: all .3s;
  }
  .deseo-card:hover { transform: translateY(-5px); box-shadow: 0 20px 50px rgba(0,51,102,.1); }
  .deseo-num {
    font-family: var(--font-kranky); font-size: 4rem;
    position: absolute; top: 1rem; right: 1.4rem; opacity: .07; color: var(--cami-azul); line-height: 1;
  }
  .deseo-icon-wrap { width: 56px; height: 56px; border-radius: 14px; display: flex; align-items: center; justify-content: center; font-size: 1.4rem; margin-bottom: 1.2rem; }
  .deseo-title { font-family: var(--font-kranky); font-size: 1.15rem; margin-bottom: .5rem; }
  .deseo-desc { font-size: .84rem; line-height: 1.75; opacity: .7; margin: 0 0 .8rem; }
  .deseo-steps { display: flex; align-items: center; gap: .4rem; flex-wrap: wrap; font-size: .75rem; font-weight: 700; margin-top: .6rem; }
  .deseo-step { color: var(--cami-turq); }
  .deseo-arrow { color: var(--cami-border); }
  .deseo-ctas { display: flex; flex-wrap: wrap; gap: 1rem; justify-content: center; margin-top: 3.5rem; }
  /* FAQ */
  .faq-item { border-bottom: 2px solid var(--cami-border); padding: 1.4rem 0; cursor: pointer; }
  .faq-q { font-family: var(--font-playpen); font-weight: 700; font-size: .95rem; color: var(--cami-azul); display: flex; justify-content: space-between; align-items: center; margin: 0; }
  .faq-a { font-size: .88rem; line-height: 1.75; opacity: .72; margin-top: .8rem; display: none; }
  .faq-a.open { display: block; }
  .faq-icon { transition: transform .2s; color: var(--cami-turq); font-size: 1.1rem; flex-shrink: 0; }
  .faq-icon.open { transform: rotate(45deg); }
  /* SOCIAL / TESTIMONIALS */
  .social-section { background: var(--cami-azul); padding: 5rem 0; }
  .mini-banner { background: rgba(78,210,173,.12); border: 1px solid rgba(78,210,173,.25); border-radius: 16px; padding: 1.5rem 2rem; display: flex; gap: 2.5rem; flex-wrap: wrap; justify-content: center; margin-bottom: 3.5rem; }
  .mini-banner-num { font-family: var(--font-kranky); font-size: 2.2rem; color: var(--cami-turq); display: block; }
  .mini-banner-label { color: rgba(255,255,255,.6); font-size: .78rem; }
  .aliado-chip { background: rgba(255,255,255,.08); border: 1px solid rgba(255,255,255,.15); border-radius: 50px; padding: .4rem 1.1rem; font-size: .8rem; font-weight: 600; color: rgba(255,255,255,.75); display: inline-block; margin: .25rem; transition: all .2s; }
  .aliado-chip:hover { background: rgba(78,210,173,.2); color: var(--cami-turq); }
  .testimonial-card { background: rgba(255,255,255,.06); border: 1px solid rgba(255,255,255,.12); border-radius: 20px; padding: 1.8rem; }
  .testimonial-text { font-size: .92rem; line-height: 1.8; color: rgba(255,255,255,.8); font-style: italic; margin-bottom: 1rem; }
  .testimonial-author { font-weight: 700; font-size: .82rem; color: var(--cami-turq); }
  .cierre-grande { text-align: center; margin-top: 3.5rem; padding-top: 3rem; border-top: 1px solid rgba(255,255,255,.1); }
  .cierre-txt { font-family: var(--font-kranky); font-size: clamp(1.4rem, 3vw, 2.2rem); color: white; margin-bottom: 1.5rem; }
  /* BLOG */
  .blog-card { background: white; border-radius: 20px; overflow: hidden; height: 100%; transition: all .3s; }
  .blog-card:hover { transform: translateY(-4px); box-shadow: 0 16px 40px rgba(0,51,102,.1); }
  .blog-img { height: 160px; display: flex; align-items: center; justify-content: center; font-size: 3.5rem; }
  .blog-body { padding: 1.5rem; }
  .blog-title { font-family: var(--font-kranky); font-size: 1.05rem; color: var(--cami-azul); margin-bottom: .6rem; line-height: 1.3; }
  .blog-desc { font-size: .82rem; line-height: 1.7; opacity: .68; margin: 0; }
  /* ALIADOS CARRUSEL */
  .aliados-track-wrap { overflow: hidden; position: relative; padding: 1rem 0; }
  .aliados-track-wrap::before, .aliados-track-wrap::after { content: ''; position: absolute; top: 0; bottom: 0; width: 80px; z-index: 2; pointer-events: none; }
  .aliados-track-wrap::before { left: 0; background: linear-gradient(to right, white, transparent); }
  .aliados-track-wrap::after { right: 0; background: linear-gradient(to left, white, transparent); }
  .aliados-track { display: flex; gap: 1.5rem; animation: aliadosScroll 45s linear infinite; width: max-content; }
  .aliados-track:hover { animation-play-state: paused; }
  @keyframes aliadosScroll { 0% { transform: translateX(0); } 100% { transform: translateX(-50%); } }
  .aliado-logo-card { display: flex; align-items: center; justify-content: center; min-width: 180px; height: 80px; border: 2px solid var(--cami-border); border-radius: 16px; padding: .6rem 1rem; text-decoration: none; transition: all .28s; flex-shrink: 0; background: white; overflow: hidden; }
  .aliado-logo-card:hover { border-color: var(--cami-turq); transform: translateY(-4px); box-shadow: 0 10px 28px rgba(0,51,102,.12); }
  .aliado-logo-card svg { width: 100%; height: 100%; display: block; }
  /* ANIMACIONES */
  @keyframes fadeUp { from { opacity: 0; transform: translateY(22px); } to { opacity: 1; transform: translateY(0); } }
  .fade-up { animation: fadeUp .7s ease both; }
  .d1 { animation-delay: .1s; }
  .d2 { animation-delay: .22s; }
  .d3 { animation-delay: .34s; }
  .d4 { animation-delay: .46s; }
  /* SPLASH SCREEN */
  #splashScreen { animation: splashAutoHide 3s 2.8s forwards; position: fixed; inset: 0; z-index: 9999; display: flex; align-items: center; justify-content: center; background: var(--cami-azul); overflow: hidden; transition: opacity .6s ease, transform .6s ease; }
  #splashScreen.hidden { opacity: 0; transform: scale(1.04); pointer-events: none; }
  .splash-bg { position: absolute; inset: 0; overflow: hidden; }
  .splash-circle { position: absolute; border-radius: 50%; opacity: .18; }
  .splash-c1 { width: 500px; height: 500px; background: var(--cami-turq); top: -120px; right: -100px; animation: splashPulse 3s ease-in-out infinite alternate; }
  .splash-c2 { width: 350px; height: 350px; background: var(--cami-coral); bottom: -80px; left: -80px; animation: splashPulse 4s ease-in-out infinite alternate-reverse; }
  .splash-c3 { width: 200px; height: 200px; background: var(--cami-amarillo); top: 50%; left: 50%; transform: translate(-50%,-50%); opacity: .1; animation: splashPulse 2.5s ease-in-out infinite alternate; }
  .splash-dots { position: absolute; inset: 0; display: grid; grid-template-columns: repeat(6,1fr); gap: 60px; padding: 40px; opacity: .12; }
  .splash-dot { width: 8px; height: 8px; border-radius: 50%; background: white; align-self: center; justify-self: center; }
  @keyframes splashPulse { from { transform: scale(1) rotate(0deg); opacity: .15; } to { transform: scale(1.1) rotate(8deg); opacity: .22; } }
  .splash-content { position: relative; z-index: 1; text-align: center; display: flex; flex-direction: column; align-items: center; gap: 1.2rem; }
  .splash-logo { height: 90px; width: auto; object-fit: contain; filter: brightness(0) invert(1); animation: splashLogoIn .8s cubic-bezier(.34,1.56,.64,1) both; }
  @keyframes splashLogoIn { from { opacity: 0; transform: scale(.6) translateY(20px); } to { opacity: 1; transform: scale(1) translateY(0); } }
  .splash-tagline { font-family: var(--font-kranky); font-size: clamp(1.6rem,5vw,2.6rem); color: white; margin: 0; animation: splashFadeUp .7s .3s ease both; }
  .splash-bar { width: 200px; height: 4px; background: rgba(255,255,255,.2); border-radius: 4px; overflow: hidden; animation: splashFadeUp .5s .5s ease both; }
  .splash-progress { height: 100%; background: var(--cami-turq); border-radius: 4px; width: 0%; transition: width .1s linear; }
  @keyframes splashAutoHide { from { opacity: 1; pointer-events: auto; } to { opacity: 0; pointer-events: none; } }
  @keyframes splashFadeUp { from { opacity: 0; transform: translateY(12px); } to { opacity: 1; transform: translateY(0); } }
  @media (max-width:575px) { .splash-logo { height: 70px; } .splash-dots { grid-template-columns: repeat(4,1fr); gap: 40px; } }
  @media (max-width:359px) { .splash-dots { display: none; } }
  /* RESPONSIVE GENERAL */
  @media (max-width:1199px) { .hero-section { min-height: auto; padding: 3.5rem 0; } .hero-tagline { font-size: clamp(2.2rem,6vw,4rem); } }
  @media (max-width:991px) { .hero-section { padding: 3rem 0 2.5rem; } .blob-main { width: 300px; height: 300px; } .hero-sub { max-width: 100%; } }
  @media (max-width:767px) { .hero-section { padding: 2.5rem 0 2rem; } .hero-tagline { font-size: clamp(2rem,8vw,3rem); } .hero-sub { font-size: .95rem; margin: 1rem 0 1.8rem; } .hero-stats { gap: 1.2rem; margin-top: 2rem; padding-top: 1.5rem; } .hero-stat-num { font-size: 1.6rem; } .hero-visual { display: none; } section[style*="padding:5rem"] { padding: 3rem 0 !important; } .cami-section { padding: 3rem 0 !important; } .social-section { padding: 3rem 0 !important; } .section-title { font-size: clamp(1.7rem,6vw,2.4rem); } .cami-quote { font-size: 1.2rem; padding-left: 1rem; } .cami-stat-big { font-size: 2.2rem; } .deseo-card { padding: 1.5rem 1.3rem; } .mini-banner { gap: 1.5rem; padding: 1.2rem 1rem; } .mini-banner-num { font-size: 1.8rem; } .testimonial-card { padding: 1.4rem; } .testimonial-text { font-size: .86rem; } }
  @media (max-width:575px) { .hero-tagline { font-size: 2rem; } .hero-pill { font-size: .68rem; padding: .35rem 1rem; } .hero-stats { gap: 1rem; } .hero-stat-num { font-size: 1.4rem; } .hero-stat-label { font-size: .68rem; } .hero-section .d-flex.flex-wrap { flex-direction: column; align-items: flex-start; } .hero-section .btn-p1, .hero-section .btn-p2 { width: 100%; justify-content: center; } .marquee-item { font-size: .85rem; } .marquee-inner { gap: 2rem; } section[style*="padding:5rem"] { padding: 2.5rem 0 !important; } .cami-section { padding: 2.5rem 0 !important; } .social-section { padding: 2.5rem 0 !important; } .section-title { font-size: clamp(1.5rem,7vw,2rem); } .section-eyebrow { font-size: .7rem; } .publico-card { padding: 1.4rem 1.2rem; } .publico-title { font-size: 1.05rem; } .cami-quote { font-size: 1.05rem; } .cami-stat-big { font-size: 1.9rem; } .cami-body { font-size: .88rem; } .deseo-ctas { flex-direction: column; align-items: stretch; } .deseo-ctas .btn-p1, .deseo-ctas .btn-p2, .deseo-ctas .btn-p-coral { width: 100%; justify-content: center; } .deseo-steps { font-size: .7rem; } .faq-q { font-size: .88rem; } .faq-a { font-size: .83rem; } .faq-item { padding: 1.1rem 0; } .mini-banner { gap: 1rem .8rem; } .cierre-txt { font-size: 1.2rem; } .cierre-grande { margin-top: 2rem; padding-top: 2rem; } .blog-img { height: 120px; font-size: 2.8rem; } .blog-body { padding: 1rem; } .blog-title { font-size: .92rem; } .blog-desc { font-size: .76rem; } .aliado-logo-card { min-width: 150px; height: 68px; } .btn-p1, .btn-p2, .btn-p-coral { font-size: .85rem; padding: .65rem 1.4rem; } }
</style>

<!-- SPLASH LOADING -->
<div id="splashScreen">
  <div class="splash-bg">
    <div class="splash-circle splash-c1"></div>
    <div class="splash-circle splash-c2"></div>
    <div class="splash-circle splash-c3"></div>
    <div class="splash-dots"><?php for ($i = 0; $i < 12; $i++): ?><div class="splash-dot"></div><?php endfor; ?></div>
  </div>
  <div class="splash-content">
    <img src="img/logos/logo_pd_horizontal.png" alt="Poder Down" class="splash-logo">
    <div class="splash-bar">
      <div class="splash-progress" id="splashProgress"></div>
    </div>
  </div>
</div>

<!-- HERO -->
<section class="hero-section" id="inicio">
  <div class="container position-relative" style="z-index:1;">
    <div class="row align-items-center g-5">
      <div class="col-lg-6">
        <span class="hero-pill fade-up d1"><i class="bi bi-stars me-1"></i>Poder Down by María Camila González Torres</span>
        <h1 class="hero-tagline fade-up d2">El poder de<br><span class="highlight">creer e incluir</span></h1>
        <p class="hero-sub fade-up d3">Descubre obras únicas de Cami y lleva el mensaje de Poder Down a tu espacio.</p>
        <div class="d-flex flex-wrap gap-3 fade-up d4">
          <a href="#catalogo" class="btn-p1"><i class="bi bi-bag-heart"></i>Lleva mi arte contigo</a>
          <a href="#sobre-mi" class="btn-p2"><i class="bi bi-person-heart"></i>Conoce mi historia</a>
        </div>
        <div class="hero-stats fade-up" style="animation-delay:.6s;">
          <div><span class="hero-stat-num">+150</span><span class="hero-stat-label">Experiencias<br>compartidas</span></div>
          <div><span class="hero-stat-num">+13K</span><span class="hero-stat-label">Personas<br>impactadas</span></div>
          <div><span class="hero-stat-num">+60</span><span class="hero-stat-label">Empresas de<br>varios sectores</span></div>
          <div><span class="hero-stat-num">+5</span><span class="hero-stat-label">Países<br>alcanzados</span></div>
        </div>
      </div>
      <div class="col-lg-6 d-flex justify-content-center fade-up d3">
        <div class="hero-visual">
          <div class="blob-main"><i class="bi bi-palette2"></i></div>
          <div class="blob-dot-coral"></div>
          <div class="blob-dot-yellow"></div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- MARQUEE -->
<div class="marquee-strip">
  <div class="marquee-inner">
    <?php
    $items = [
      ['#3CAEE0', 'Inclusión real'], ['#F2677C', 'Arte único'], ['#F5C518', 'Charlas testimoniales'],
      ['#3CAEE0', 'Síndrome de Down'], ['#F2677C', 'Neuroplasticidad'], ['#F5C518', 'Poder Down'],
      ['#3CAEE0', 'Bachillerato'], ['#F2677C', 'UdeA UIncluye'], ['#F5C518', 'Speaker internacional'],
      ['#3CAEE0', '13.000 personas'], ['#F2677C', '60+ empresas'], ['#F5C518', 'Coloreando mi vida'],
    ];
    foreach (array_merge($items, $items) as $it): ?>
      <span class="marquee-item"><span class="mdot" style="background:<?= $it[0] ?>"></span><?= $it[1] ?></span>
    <?php endforeach; ?>
  </div>
</div>

<!-- PÚBLICO -->
<section style="background:white;padding:5rem 0;" id="publico">
  <div class="container">
    <div class="text-center mb-5">
      <p class="section-eyebrow justify-content-center"><i class="bi bi-people-fill"></i>Únete al movimiento</p>
      <h2 class="section-title">¿Cómo puedes ser parte<br>de este movimiento?</h2>
    </div>
    <div class="row g-4">
      <div class="col-sm-6 col-lg-3">
        <div class="publico-card">
          <div class="publico-icon" style="background:rgba(239,184,16,.18);"><i class="bi bi-journal-richtext" style="color:var(--cami-amarillo);"></i></div>
          <p class="publico-title">Blog</p>
          <p class="publico-desc">Testimonios, experiencias para padres y profesionales desde una historia de vida real.</p>
          <a href="#blog" class="btn-p2 mt-3" style="font-size:.8rem;padding:.5rem 1.2rem;">Leer artículos →</a>
        </div>
      </div>
      <div class="col-sm-6 col-lg-3">
        <div class="publico-card">
          <div class="publico-icon" style="background:rgba(228,91,99,.12);"><i class="bi bi-palette2" style="color:var(--cami-coral);"></i></div>
          <p class="publico-title">Arte</p>
          <p class="publico-desc">Arte único lleno de color, emoción y significado profundo creado por Cami.</p>
          <a href="#galeria" class="btn-p2 mt-3" style="font-size:.8rem;padding:.5rem 1.2rem;">Ver galería →</a>
        </div>
      </div>
      <div class="col-sm-6 col-lg-3">
        <div class="publico-card">
          <div class="publico-icon" style="background:rgba(78,210,173,.18);"><i class="bi bi-bag-heart" style="color:var(--cami-turq);"></i></div>
          <p class="publico-title">Productos</p>
          <p class="publico-desc">Lleva mi arte y mi mensaje contigo y para regalar a quienes amas.</p>
          <a href="productos.php" class="btn-p2 mt-3" style="font-size:.8rem;padding:.5rem 1.2rem;">Ver tienda →</a>
        </div>
      </div>
      <div class="col-sm-6 col-lg-3">
        <div class="publico-card">
          <div class="publico-icon" style="background:rgba(0,51,102,.1);"><i class="bi bi-mic" style="color:var(--cami-azul);"></i></div>
          <p class="publico-title">Charlas</p>
          <p class="publico-desc">Comparto mi vivencia como punto de apoyo para la inclusión familiar, académica y laboral.</p>
          <a href="#contacto" class="btn-p2 mt-3" style="font-size:.8rem;padding:.5rem 1.2rem;">Invítame →</a>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- CAMI -->
<section class="cami-section" id="sobre-mi">
  <div class="container">
    <div class="row align-items-center g-5">
      <div class="col-lg-6">
        <p class="section-eyebrow" style="color:var(--cami-turq);"><i class="bi bi-heart-fill"></i>Mi historia</p>
        <h2 class="section-title" style="color:white;">Soy Cami<span style="color:var(--cami-turq);">.</span></h2>
        <blockquote class="cami-quote">"Si le das oportunidades a una persona con Síndrome de Down desde pequeña, puede lograr grandes cosas."</blockquote>
        <p class="cami-body">La neuroplasticidad funciona mejor cuando empezamos temprano. Mi familia siempre creyó en mí, me llevaron a terapias y me dieron las mismas oportunidades que a mi hermana.</p>
        <p class="cami-body mt-3">Finalicé mi bachillerato, estudié en la <strong style="color:var(--cami-turq);">Universidad de Antioquia</strong> en el programa UIncluye para personas con discapacidad intelectual, he trabajado en varias empresas. He participado en eventos nacionales e internacionales, compartido en más de 150 experiencias con más de 13.000 personas impactadas y más de 60 empresas de varios sectores.</p>
        <div class="mt-4">
          <span class="cami-chip">🎓 Bachillerato completo</span>
          <span class="cami-chip">🎓 UdeA UIncluye</span>
          <span class="cami-chip">💼 5+ empleos exitosos</span>
          <span class="cami-chip">🌍 +5 países</span>
          <span class="cami-chip">🎨 Artista</span>
          <span class="cami-chip">🎤 Speaker motivacional</span>
        </div>
      </div>
      <div class="col-lg-6">
        <div class="row g-3">
          <div class="col-6 text-center"><div style="background:rgba(78,210,173,.12);border-radius:20px;padding:2rem 1rem;"><span class="cami-stat-big">+150</span><p class="cami-stat-sub mt-1">Experiencias<br>compartidas</p></div></div>
          <div class="col-6 text-center"><div style="background:rgba(228,91,99,.1);border-radius:20px;padding:2rem 1rem;"><span class="cami-stat-big" style="color:var(--cami-coral);">+13K</span><p class="cami-stat-sub mt-1">Personas<br>impactadas</p></div></div>
          <div class="col-6 text-center"><div style="background:rgba(239,184,16,.1);border-radius:20px;padding:2rem 1rem;"><span class="cami-stat-big" style="color:var(--cami-amarillo);">+60</span><p class="cami-stat-sub mt-1">Empresas de<br>múltiples sectores</p></div></div>
          <div class="col-6 text-center"><div style="background:rgba(255,255,255,.06);border-radius:20px;padding:2rem 1rem;"><span class="cami-stat-big" style="color:white;">+5</span><p class="cami-stat-sub mt-1">Países<br>alcanzados</p></div></div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- DESEO -->
<section style="background:var(--cami-bg);padding:5rem 0;" id="deseo">
  <div class="container">
    <div class="text-center mb-5">
      <p class="section-eyebrow justify-content-center"><i class="bi bi-stars"></i>Conéctate</p>
      <h2 class="section-title">4 Formas de Conectar<br><span style="color:var(--cami-turq);">con mi Mundo</span></h2>
    </div>
    <div class="row g-4">
      <div class="col-md-6">
        <div class="deseo-card"><span class="deseo-num">1</span>
          <div class="deseo-icon-wrap" style="background:rgba(78,210,173,.15);"><i class="bi bi-bag-heart" style="color:var(--cami-turq);"></i></div>
          <p class="deseo-title">Lleva mi arte contigo</p><p class="deseo-desc">Visitar mi tienda es muy fácil. Encuentra productos únicos con mi arte para ti o para regalar.</p>
          <div class="deseo-steps"><span class="deseo-step">Elige tu favorito</span><span class="deseo-arrow">→</span><span class="deseo-step">Compra en 3 clics</span><span class="deseo-arrow">→</span><span class="deseo-step">Recibe en casa</span></div>
          <a href="#catalogo" class="btn-p1 mt-3" style="font-size:.85rem;padding:.6rem 1.4rem;"><i class="bi bi-shop"></i>Explorar tienda</a>
        </div>
      </div>
      <div class="col-md-6">
        <div class="deseo-card"><span class="deseo-num">2</span>
          <div class="deseo-icon-wrap" style="background:rgba(228,91,99,.12);"><i class="bi bi-mic" style="color:var(--cami-coral);"></i></div>
          <p class="deseo-title">Invítame a participar</p>
          <p class="deseo-desc">Charlas testimoniales que sensibilizan y cambian perspectivas sobre la inclusión en colegios, universidades, empresas y familias.</p>
          <div class="deseo-steps"><span class="deseo-step">Contacta</span><span class="deseo-arrow">→</span><span class="deseo-step">Agenda llamada</span><span class="deseo-arrow">→</span><span class="deseo-step">Compartamos</span></div>
          <a href="#contacto" class="btn-p-coral mt-3" style="font-size:.85rem;padding:.6rem 1.4rem;"><i class="bi bi-calendar-event"></i>Invitar a participar</a>
        </div>
      </div>
      <div class="col-md-6">
        <div class="deseo-card"><span class="deseo-num">3</span>
          <div class="deseo-icon-wrap" style="background:rgba(239,184,16,.15);"><i class="bi bi-images" style="color:var(--cami-amarillo);"></i></div>
          <p class="deseo-title">Enamórate de mi arte</p>
          <p class="deseo-desc">Pinturas únicas disponibles para disfrutar en mi galería permanente. Arte lleno de color, emoción y significado profundo.</p>
          <div class="deseo-steps"><span class="deseo-step">Explora galería</span><span class="deseo-arrow">→</span><span class="deseo-step">Disfruta</span><span class="deseo-arrow">→</span><span class="deseo-step">Comparte</span></div>
          <a href="#galeria" class="btn-p2 mt-3" style="font-size:.85rem;padding:.6rem 1.4rem;"><i class="bi bi-easel2"></i>Ver galería</a>
        </div>
      </div>
      <div class="col-md-6">
        <div class="deseo-card"><span class="deseo-num">4</span>
          <div class="deseo-icon-wrap" style="background:rgba(0,51,102,.1);"><i class="bi bi-journal-text" style="color:var(--cami-azul);"></i></div>
          <p class="deseo-title">Conoce mi mensaje</p>
          <p class="deseo-desc">Las personas con Síndrome de Down podemos hacer más de lo que te imaginas. El límite es la confianza y la formación.</p>
          <div class="deseo-steps"><span class="deseo-step">Accede al blog</span><span class="deseo-arrow">→</span><span class="deseo-step">Lee y piensa</span><span class="deseo-arrow">→</span><span class="deseo-step">Comparte</span></div>
          <a href="#blog" class="btn-p2 mt-3" style="font-size:.85rem;padding:.6rem 1.4rem;"><i class="bi bi-book"></i>Descubre mi blog</a>
        </div>
      </div>
    </div>
    <div class="deseo-ctas">
      <a href="productos.php" class="btn-p1"><i class="bi bi-shop"></i>Explorar tienda</a>
      <a href="#galeria" class="btn-p2"><i class="bi bi-easel2"></i>Ver galería</a>
      <a href="#contacto" class="btn-p-coral"><i class="bi bi-mic"></i>Invitación a participar</a>
      <a href="#blog" class="btn-p2"><i class="bi bi-journal-richtext"></i>Descubre mi blog</a>
    </div>
  </div>
</section>

<!-- CATÁLOGO PREVIEW -->
<section style="background:white;padding:5rem 0;" id="catalogo">
  <div class="container">
    <div class="text-center mb-5">
      <p class="section-eyebrow justify-content-center"><i class="bi bi-bag-heart-fill" style="color:var(--cami-turq)"></i>Tienda Poder Down</p>
      <h2 class="section-title">Lleva mi arte contigo<span style="color:var(--cami-turq);">.</span></h2>
      <p style="opacity:.65;margin-top:.5rem;max-width:480px;margin-left:auto;margin-right:auto;">Productos únicos creados por Cami, llenos de color y significado. Envíos a toda Colombia.</p>
    </div>
    <div class="row g-4 mb-5" id="tiendaPreviewGrid">
      <div class="col-12 text-center py-4">
        <div class="spinner-border" style="color:var(--cami-turq);" role="status"></div>
        <p style="opacity:.6;margin-top:1rem;font-size:.88rem;">Cargando vista previa...</p>
      </div>
    </div>
    <div class="text-center">
      <a href="productos.php" class="btn-p1" style="font-size:1rem;padding:.85rem 2.2rem;"><i class="bi bi-shop"></i> Ver toda la tienda</a>
      <p style="margin-top:1rem;font-size:.8rem;opacity:.5;">+productos disponibles con envío a toda Colombia</p>
    </div>
  </div>
</section>

<!-- FAQ -->
<section style="background:var(--cami-bg);padding:5rem 0;" id="faq">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-8">
        <div class="text-center mb-5">
          <p class="section-eyebrow justify-content-center"><i class="bi bi-question-circle-fill"></i>Preguntas frecuentes</p>
          <h2 class="section-title">Preguntas Frecuentes</h2>
        </div>
        <?php $faqs = [
          ['¿Para quién son las charlas de Camila?','Para colegios, universidades, empresas y cualquier organización que busque inspiración e inclusión real.'],
          ['¿Camila viaja a otros países?','Sí, Cami ha dado charlas en más de 4 países y sigue expandiendo su impacto internacional.'],
          ['¿Camila asiste a los eventos sola o requiere apoyo?','Camila siempre asiste acompañada de un apoyo familiar para garantizar la mejor experiencia.'],
          ['¿Las charlas de Cami tienen costo?','Para instituciones educativas y entidades sin ánimo de lucro no tienen costo, solo el desplazamiento. Para empresas, contáctanos para cotización.'],
          ['¿Cómo puedo comprar sus productos?','A través de la tienda virtual en esta misma página, con envíos a toda Colombia. ¡Sin necesidad de crear cuenta!'],
          ['¿Las conferencias son solo presenciales?','Principalmente presenciales para mayor impacto, pero se evalúan casos especiales en modalidad virtual.'],
        ]; foreach ($faqs as $i => [$q, $a]): ?>
          <div class="faq-item" onclick="toggleFaq(<?= $i ?>)">
            <p class="faq-q"><?= htmlspecialchars($q) ?><i class="bi bi-plus-circle faq-icon" id="faq-icon-<?= $i ?>"></i></p>
            <p class="faq-a" id="faq-a-<?= $i ?>"><?= htmlspecialchars($a) ?></p>
          </div>
        <?php endforeach; ?>
        <div class="text-center mt-4"><a href="#catalogo" class="btn-p1"><i class="bi bi-bag-heart"></i>Ir a la tienda</a></div>
      </div>
    </div>
  </div>
</section>

<!-- PRUEBA SOCIAL -->
<section class="social-section" id="aliados">
  <div class="container">
    <div class="mini-banner">
      <div class="mini-banner-item text-center"><span class="mini-banner-num">+30</span><span class="mini-banner-label">Charlas internacionales</span></div>
      <div class="mini-banner-item text-center"><span class="mini-banner-num">+5</span><span class="mini-banner-label">Países alcanzados</span></div>
      <div class="mini-banner-item text-center"><span class="mini-banner-num">🎤</span><span class="mini-banner-label">Una sola misión</span></div>
    </div>
    <div class="text-center mb-4"><p class="section-eyebrow justify-content-center" style="color:var(--cami-turq);"><i class="bi bi-building"></i>Aliados que confían en mí</p></div>
    <div class="text-center mb-5">
      <?php $aliados = ['La Casa de Carlota','Comfama','Universidad San Martín','Colegio San Ignacio','SENA','Universidad María Cano','UdeA','Lupines','Artesas','Sin Etiquetas','DiversoLab','Municipio de Medellín','Crear Unidos'];
      foreach ($aliados as $al): ?><span class="aliado-chip"><?= htmlspecialchars($al) ?></span><?php endforeach; ?>
    </div>
    <div class="text-center mb-4"><p class="section-eyebrow justify-content-center" style="color:var(--cami-turq);"><i class="bi bi-chat-quote-fill"></i>Qué dicen de mí, los que me conocen</p></div>
    <div class="row g-4 mb-5">
      <div class="col-md-6"><div class="testimonial-card"><p class="testimonial-text">"Camila cambió completamente la perspectiva de nuestros colaboradores sobre la inclusión. Su autenticidad es verdaderamente inspiradora."</p><p class="testimonial-author">— Directora de Talento Humano, Nutresa</p></div></div>
      <div class="col-md-6"><div class="testimonial-card"><p class="testimonial-text">"Como padre de un niño con Síndrome de Down, la conferencia de Camila me dio esperanza y herramientas concretas para el camino."</p><p class="testimonial-author">— Padre de familia, Conferencia Sin Etiquetas</p></div></div>
    </div>
    <div class="cierre-grande">
      <p class="cierre-txt">No solo compras productos o contratas una charla.<br><span style="color:var(--cami-turq);">Inviertes en un mundo más inclusivo y consciente.</span></p>
      <a href="#deseo" class="btn-p1" style="font-size:1rem;padding:.9rem 2.5rem;"><i class="bi bi-lightning-charge-fill"></i>Hablemos hoy</a>
    </div>
  </div>
</section>

<!-- GALERÍA -->
<section style="background:white;padding:5rem 0;" id="galeria">
  <div class="container">
    <div class="text-center mb-5">
      <p class="section-eyebrow justify-content-center"><i class="bi bi-easel2-fill"></i>Galería permanente</p>
      <h2 class="section-title">Enamórate de mi arte<span style="color:var(--cami-turq);">.</span></h2>
      <p style="opacity:.65;">Pinturas únicas disponibles para disfrutar.</p>
    </div>
    <div class="row g-4">
      <?php $obras = [['🌈','Colores del alma','Acrílico sobre lienzo','Alegría pura'],['🌸','Florecer','Técnica mixta','Resiliencia y vida'],['🌊','Marea de colores','Acuarela','Libertad interior'],['🦋','Metamorfosis','Óleo sobre lienzo','Transformación real'],['🌟','Brillar diferente','Acrílico','El poder de ser tú'],['🎨','El mundo en colores','Técnica mixta','Visión propia']];
      foreach ($obras as [$emoji, $titulo, $tecnica, $desc]): ?>
        <div class="col-6 col-md-4"><div class="blog-card"><div class="blog-img" style="background:linear-gradient(135deg,rgba(78,210,173,.2),rgba(239,184,16,.15));"><?= $emoji ?></div><div class="blog-body"><p class="blog-title"><?= htmlspecialchars($titulo) ?></p><p class="blog-desc"><strong><?= htmlspecialchars($tecnica) ?></strong> — <?= htmlspecialchars($desc) ?></p></div></div></div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- BLOG -->
<section style="background:var(--cami-bg);padding:5rem 0;" id="blog">
  <div class="container">
    <div class="text-center mb-5">
      <p class="section-eyebrow justify-content-center"><i class="bi bi-journal-richtext-fill"></i>Blog</p>
      <h2 class="section-title">Día a día con Cami<span style="color:var(--cami-turq);">.</span></h2>
    </div>
    <div class="row g-4">
      <div class="col-md-4"><div class="blog-card"><div class="blog-img" style="background:rgba(78,210,173,.15);">📋</div><div class="blog-body"><span style="background:rgba(78,210,173,.2);color:var(--cami-azul);border-radius:50px;padding:.3rem .9rem;font-size:.72rem;font-weight:700;letter-spacing:1px;display:inline-block;margin-bottom:.8rem;">Para padres</span><p class="blog-title">Qué hacer cuando recibes el diagnóstico</p><p class="blog-desc">Guía de la Fundación Sin Etiquetas con pasos concretos para el camino inicial.</p><a href="#" class="btn-p2 mt-3" style="font-size:.78rem;padding:.45rem 1rem;">Leer artículo →</a></div></div></div>
      <div class="col-md-4"><div class="blog-card"><div class="blog-img" style="background:rgba(228,91,99,.1);">🧠</div><div class="blog-body"><span style="background:rgba(228,91,99,.15);color:var(--cami-coral);border-radius:50px;padding:.3rem .9rem;font-size:.72rem;font-weight:700;letter-spacing:1px;display:inline-block;margin-bottom:.8rem;">Para profesionales</span><p class="blog-title">Mitos sobre Síndrome de Down que debes conocer</p><p class="blog-desc">Por Fundación Lupines y Corporación Crear Unidos. La verdad que cambia perspectivas.</p><a href="#" class="btn-p2 mt-3" style="font-size:.78rem;padding:.45rem 1rem;">Leer artículo →</a></div></div></div>
      <div class="col-md-4"><div class="blog-card"><div class="blog-img" style="background:rgba(239,184,16,.15);">💼</div><div class="blog-body"><span style="background:rgba(239,184,16,.2);color:#7a5f00;border-radius:50px;padding:.3rem .9rem;font-size:.72rem;font-weight:700;letter-spacing:1px;display:inline-block;margin-bottom:.8rem;">Para entidades</span><p class="blog-title">Inclusión laboral: Ajustes razonables</p><p class="blog-desc">Por DiversoLab. Cómo crear entornos de trabajo verdaderamente inclusivos.</p><a href="#" class="btn-p2 mt-3" style="font-size:.78rem;padding:.45rem 1rem;">Leer artículo →</a></div></div></div>
    </div>
    <div class="text-center mt-5"><a href="#" class="btn-p1"><i class="bi bi-journal-richtext"></i>Leer más artículos</a></div>
  </div>
</section>

<!-- ALIADOS CARRUSEL -->
<section style="background:white;padding:4rem 0;" id="nuestros-aliados">
  <div class="container">
    <div class="text-center mb-4">
      <p class="section-eyebrow justify-content-center"><i class="bi bi-building-check"></i>Aliados que creen en Poder Down</p>
      <h2 class="section-title">Organizaciones que confían<br><span style="color:var(--cami-turq);">en este mensaje</span></h2>
    </div>
    <div class="aliados-track-wrap">
      <div class="aliados-track" id="aliadosTrack">
        <?php
        $aliados_logos = [
          ['nombre'=>'La Casa de Carlota','url'=>'https://lacasadecarlota.com','svg'=>'<svg viewBox="0 0 160 70" xmlns="http://www.w3.org/2000/svg"><rect width="160" height="70" rx="8" fill="#FFF0F5"/><path d="M20 50 L20 28 L35 20 L50 28 L50 50 Z" fill="#E91E8C" opacity="0.9"/><rect x="27" y="38" width="16" height="12" fill="white"/><text x="60" y="36" font-family="Arial,sans-serif" font-weight="700" font-size="11" fill="#C2185B">La Casa</text><text x="60" y="50" font-family="Arial,sans-serif" font-weight="700" font-size="11" fill="#C2185B">de Carlota</text></svg>'],
          ['nombre'=>'Comfama','url'=>'https://comfama.com.co','svg'=>'<svg viewBox="0 0 160 70" xmlns="http://www.w3.org/2000/svg"><rect width="160" height="70" rx="8" fill="#fff"/><circle cx="30" cy="35" r="18" fill="#E91E8C"/><circle cx="30" cy="35" r="11" fill="white"/><circle cx="30" cy="35" r="6" fill="#E91E8C"/><text x="56" y="31" font-family="Arial,sans-serif" font-weight="900" font-size="18" fill="#E91E8C">comfama</text><text x="58" y="47" font-family="Arial,sans-serif" font-size="8" fill="#666" letter-spacing="1">CAJA DE COMPENSACIÓN</text></svg>'],
          ['nombre'=>'SENA','url'=>'https://www.sena.edu.co','svg'=>'<svg viewBox="0 0 160 70" xmlns="http://www.w3.org/2000/svg"><rect width="160" height="70" rx="8" fill="#fff"/><polygon points="22,55 22,25 38,15 54,25 54,55" fill="#007A3D"/><circle cx="38" cy="33" r="7" fill="white"/><circle cx="38" cy="33" r="3" fill="#007A3D"/><text x="62" y="30" font-family="Arial Black,Arial,sans-serif" font-weight="900" font-size="20" fill="#007A3D">SENA</text><text x="62" y="46" font-family="Arial,sans-serif" font-size="7" fill="#555" letter-spacing="0.5">Servicio Nacional de Aprendizaje</text></svg>'],
          ['nombre'=>'Universidad San Martín','url'=>'https://www.sanmartin.edu.co','svg'=>'<svg viewBox="0 0 160 70" xmlns="http://www.w3.org/2000/svg"><rect width="160" height="70" rx="8" fill="#fff"/><circle cx="30" cy="35" r="18" fill="#8B1A1A" opacity="0.9"/><text x="30" y="40" text-anchor="middle" font-family="Times New Roman,serif" font-weight="700" font-size="14" fill="white">USM</text><text x="56" y="26" font-family="Arial,sans-serif" font-weight="700" font-size="9" fill="#8B1A1A">UNIVERSIDAD</text><text x="56" y="38" font-family="Arial,sans-serif" font-weight="900" font-size="11" fill="#8B1A1A">SAN MARTÍN</text><text x="56" y="50" font-family="Arial,sans-serif" font-size="8" fill="#999">Colombia</text></svg>'],
          ['nombre'=>'Colegio San Ignacio','url'=>'https://www.sanignacio.edu.co','svg'=>'<svg viewBox="0 0 160 70" xmlns="http://www.w3.org/2000/svg"><rect width="160" height="70" rx="8" fill="#fff"/><rect x="14" y="17" width="32" height="36" rx="3" fill="#003087"/><text x="30" y="29" text-anchor="middle" font-family="Times New Roman,serif" font-weight="700" font-size="9" fill="white">IHS</text><line x1="18" y1="33" x2="42" y2="33" stroke="#C5A028" stroke-width="1"/><text x="30" y="45" text-anchor="middle" font-family="Arial,sans-serif" font-size="7" fill="white">Jesuitas</text><text x="55" y="26" font-family="Arial,sans-serif" font-weight="700" font-size="9" fill="#003087">COLEGIO</text><text x="55" y="38" font-family="Arial,sans-serif" font-weight="900" font-size="10" fill="#003087">SAN IGNACIO</text><text x="55" y="50" font-family="Arial,sans-serif" font-size="8" fill="#999">de Loyola</text></svg>'],
          ['nombre'=>'Universidad María Cano','url'=>'https://www.mariacano.edu.co','svg'=>'<svg viewBox="0 0 160 70" xmlns="http://www.w3.org/2000/svg"><rect width="160" height="70" rx="8" fill="#fff"/><circle cx="28" cy="35" r="18" fill="#1B5E20"/><path d="M20 35 Q28 22 36 35 Q28 48 20 35Z" fill="#C5A028" opacity="0.9"/><text x="28" y="39" text-anchor="middle" font-family="Arial,sans-serif" font-weight="700" font-size="9" fill="white">UMC</text><text x="54" y="25" font-family="Arial,sans-serif" font-weight="700" font-size="8" fill="#1B5E20">UNIVERSIDAD</text><text x="54" y="37" font-family="Arial,sans-serif" font-weight="900" font-size="10" fill="#1B5E20">MARÍA CANO</text><text x="54" y="50" font-family="Arial,sans-serif" font-size="7.5" fill="#666">Medellín, Colombia</text></svg>'],
          ['nombre'=>'UdeA','url'=>'https://www.udea.edu.co','svg'=>'<svg viewBox="0 0 160 70" xmlns="http://www.w3.org/2000/svg"><rect width="160" height="70" rx="8" fill="#fff"/><circle cx="28" cy="35" r="18" fill="#006633"/><circle cx="28" cy="35" r="14" fill="none" stroke="#C5A028" stroke-width="1.5"/><text x="28" y="40" text-anchor="middle" font-family="Times New Roman,serif" font-weight="700" font-size="13" fill="white">U</text><text x="54" y="24" font-family="Arial,sans-serif" font-weight="700" font-size="8" fill="#006633">UNIVERSIDAD</text><text x="54" y="36" font-family="Arial,sans-serif" font-weight="900" font-size="12" fill="#006633">de Antioquia</text><text x="54" y="50" font-family="Arial,sans-serif" font-size="8" fill="#888">Alma Máter</text></svg>'],
          ['nombre'=>'Lupines','url'=>'#','svg'=>'<svg viewBox="0 0 160 70" xmlns="http://www.w3.org/2000/svg"><rect width="160" height="70" rx="8" fill="#FFF8F0"/><circle cx="22" cy="25" r="7" fill="#9C27B0" opacity="0.8"/><circle cx="35" cy="22" r="7" fill="#E91E8C" opacity="0.8"/><circle cx="48" cy="25" r="7" fill="#FF9800" opacity="0.8"/><path d="M25 32 Q35 52 45 32" fill="#4CAF50" opacity="0.7"/><text x="58" y="33" font-family="Arial,sans-serif" font-weight="700" font-size="16" fill="#9C27B0">Lupines</text><text x="60" y="47" font-family="Arial,sans-serif" font-size="8" fill="#888">Fundación</text></svg>'],
          ['nombre'=>'Artesas','url'=>'#','svg'=>'<svg viewBox="0 0 160 70" xmlns="http://www.w3.org/2000/svg"><rect width="160" height="70" rx="8" fill="#FFFBF0"/><rect x="14" y="14" width="40" height="40" rx="4" fill="none" stroke="#C77800" stroke-width="2"/><path d="M20 44 Q34 20 48 44" fill="none" stroke="#C77800" stroke-width="2.5"/><circle cx="34" cy="26" r="4" fill="#C77800" opacity="0.7"/><text x="62" y="33" font-family="Georgia,serif" font-weight="700" font-size="16" fill="#8B5A00">Artesas</text><text x="62" y="48" font-family="Arial,sans-serif" font-size="8" fill="#AAA">Arte e inclusión</text></svg>'],
          ['nombre'=>'Sin Etiquetas','url'=>'#','svg'=>'<svg viewBox="0 0 160 70" xmlns="http://www.w3.org/2000/svg"><rect width="160" height="70" rx="8" fill="#F5FFF8"/><circle cx="35" cy="35" r="18" fill="none" stroke="#2196F3" stroke-width="2.5"/><line x1="22" y1="22" x2="48" y2="48" stroke="#F44336" stroke-width="3" stroke-linecap="round"/><text x="60" y="28" font-family="Arial,sans-serif" font-weight="700" font-size="10" fill="#1976D2">Sin</text><text x="60" y="42" font-family="Arial,sans-serif" font-weight="700" font-size="10" fill="#1976D2">Etiquetas</text><text x="60" y="54" font-family="Arial,sans-serif" font-size="7.5" fill="#888">Fundación</text></svg>'],
          ['nombre'=>'DiversoLab','url'=>'#','svg'=>'<svg viewBox="0 0 160 70" xmlns="http://www.w3.org/2000/svg"><rect width="160" height="70" rx="8" fill="#F8F0FF"/><rect x="14" y="20" width="12" height="30" rx="3" fill="#9C27B0"/><rect x="30" y="28" width="12" height="22" rx="3" fill="#3F51B5"/><rect x="46" y="24" width="12" height="26" rx="3" fill="#00BCD4"/><text x="66" y="29" font-family="Arial,sans-serif" font-weight="900" font-size="13" fill="#6A0DAD">Diverso</text><text x="66" y="44" font-family="Arial,sans-serif" font-weight="900" font-size="13" fill="#00BCD4">Lab</text><text x="66" y="56" font-family="Arial,sans-serif" font-size="7.5" fill="#888">Inclusión laboral</text></svg>'],
          ['nombre'=>'Municipio de Medellín','url'=>'https://www.medellin.gov.co','svg'=>'<svg viewBox="0 0 160 70" xmlns="http://www.w3.org/2000/svg"><rect width="160" height="70" rx="8" fill="#fff"/><circle cx="28" cy="35" r="18" fill="#00703C"/><path d="M20 40 L28 22 L36 40 Z" fill="white" opacity="0.9"/><rect x="24" y="38" width="8" height="6" fill="#00703C"/><text x="54" y="24" font-family="Arial,sans-serif" font-weight="700" font-size="8" fill="#00703C">MUNICIPIO DE</text><text x="54" y="37" font-family="Arial,sans-serif" font-weight="900" font-size="12" fill="#00703C">Medellín</text><text x="54" y="50" font-family="Arial,sans-serif" font-size="8" fill="#999">Alcaldía</text></svg>'],
          ['nombre'=>'Crear Unidos','url'=>'#','svg'=>'<svg viewBox="0 0 160 70" xmlns="http://www.w3.org/2000/svg"><rect width="160" height="70" rx="8" fill="#FFF5F0"/><circle cx="22" cy="35" r="10" fill="#FF7043" opacity="0.9"/><circle cx="38" cy="35" r="10" fill="#FFA726" opacity="0.9"/><circle cx="30" cy="28" r="10" fill="#EF5350" opacity="0.85"/><text x="56" y="30" font-family="Arial,sans-serif" font-weight="700" font-size="12" fill="#D84315">Crear</text><text x="56" y="46" font-family="Arial,sans-serif" font-weight="700" font-size="12" fill="#E65100">Unidos</text><text x="56" y="57" font-family="Arial,sans-serif" font-size="7" fill="#AAA">Corporación</text></svg>'],
        ];
        $todos = array_merge($aliados_logos, $aliados_logos);
        foreach ($todos as $al): $href = htmlspecialchars($al['url'], ENT_QUOTES, 'UTF-8'); $name = htmlspecialchars($al['nombre'], ENT_QUOTES, 'UTF-8'); ?>
          <a href="<?= $href ?>" target="<?= $al['url'] !== '#' ? '_blank' : '_self' ?>" rel="noopener noreferrer" class="aliado-logo-card" aria-label="<?= $name ?>" title="<?= $name ?>"><?= $al['svg'] ?></a>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
</section>

<!-- FOOTER -->
<?php require_once __DIR__ . '/footer.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
const API_URL = 'components/productos/cargar_productos.php';
const LIMITE_GRID = 8;
let offsetActual = 0, categoriaActual = '', busquedaActual = '', carrito = [];

function toggleFaq(i) {
  const a = document.getElementById('faq-a-'+i);
  const icon = document.getElementById('faq-icon-'+i);
  const open = a.classList.toggle('open');
  icon.classList.toggle('open', open);
}
function toggleMobileMenu() {
  const m = document.getElementById('navMobileMenu');
  const i = document.getElementById('hamburger-icon');
  m.classList.toggle('open');
  i.className = m.classList.contains('open') ? 'bi bi-x-lg' : 'bi bi-list';
}
function closeMobileMenu() {
  document.getElementById('navMobileMenu').classList.remove('open');
  document.getElementById('hamburger-icon').className = 'bi bi-list';
}
document.addEventListener('DOMContentLoaded', iniciarLanding);

async function iniciarLanding() {
  await cargarPreviewProductos();
}

async function cargarPreviewProductos() {
  try {
    const res = await fetch(`${API_URL}?action=products&limite=4&offset=0`);
    const json = await res.json();
    const grid = document.getElementById('tiendaPreviewGrid');
    if (!grid) return;
    grid.innerHTML = '';
    if (!json.exito || !json.datos.length) {
      grid.innerHTML = `<div class="col-12 text-center"><p style="opacity:.5;">Próximamente productos disponibles.</p></div>`;
      return;
    }
    json.datos.forEach(p => {
      const col = document.createElement('div');
      col.className = 'col-6 col-md-3';
      col.innerHTML = tarjetaProducto(p);
      grid.appendChild(col);
    });
  } catch (e) {
    const grid = document.getElementById('tiendaPreviewGrid');
    if (grid) grid.innerHTML = '';
  }
}

function tarjetaProducto(p) {
  const agotado = p.stock_agotado || parseInt(p.stock) === 0;
  const imgHtml = p.imagen
    ? `<img src="${p.imagen}" alt="${p.nombre.replace(/"/g,'&quot;')}" loading="lazy" onerror="this.style.display='none';this.nextElementSibling.style.display='flex'"><div class="img-placeholder" style="display:none"><i class="bi bi-image" style="color:var(--cami-border);"></i></div>`
    : `<div class="img-placeholder"><i class="bi bi-image" style="color:var(--cami-border);"></i></div>`;
  return `
  <div class="product-card-cami" onclick="window.location='producto.php?id=${p.id}'">
    <div class="img-wrap" style="position:relative">
      ${imgHtml}
      <span class="badge-cat">${p.categoria}</span>
      ${agotado ? '<span class="badge-agotado">Agotado</span>' : ''}
    </div>
    <div class="card-body">
      <p class="product-name">${p.nombre}</p>
      <p class="product-desc">${p.descripcion_corta || p.descripcion || ''}</p>
      <div class="product-footer">
        <span class="product-price">$${Number(p.precio).toLocaleString('es-CO',{minimumFractionDigits:0})}</span>
        <button class="btn-add-cami"
          data-pid="${p.id}" data-nombre="${encodeURIComponent(p.nombre)}" data-precio="${p.precio}" onclick="agregarAlCarritoBtn(event,this)"
          ${agotado ? 'disabled' : ''}>
          <i class="bi bi-plus-lg"></i>
        </button>
      </div>
    </div>
  </div>`;
}

async function verProducto(id) {
  try {
    const res = await fetch(`${API_URL}?action=product&id=${id}`);
    const json = await res.json();
    if (!json.exito || !json.datos[0]) throw new Error();
    const p = json.datos[0];
    const agotado = p.stock_agotado || parseInt(p.stock) === 0;
    Swal.fire({
      title: `<span style="font-family:var(--font-kranky)">${p.nombre}</span>`,
      html: `<div style="font-family:var(--font-archivo);text-align:left;">
        <span style="background:var(--cami-turq);color:var(--cami-azul);border-radius:50px;padding:.3rem .9rem;font-size:.73rem;font-weight:700;">${p.categoria}</span>
        <p style="margin-top:1rem;font-size:.88rem;opacity:.75;line-height:1.8;">${p.descripcion || 'Sin descripción.'}</p>
        <div style="display:flex;justify-content:space-between;align-items:center;margin-top:1rem;">
          <span style="font-family:var(--font-kranky);font-size:1.9rem;color:var(--cami-azul);">$${Number(p.precio).toLocaleString('es-CO',{minimumFractionDigits:0})}</span>
          <span style="background:${agotado?'var(--cami-coral)':'rgba(60,174,224,.18)'};color:${agotado?'white':'var(--cami-azul)'};border-radius:50px;padding:.35rem 1rem;font-size:.78rem;font-weight:700;">
            ${agotado?'Sin stock':'✅ '+p.stock+' disponibles'}
          </span>
        </div></div>`,
      showCancelButton: true,
      confirmButtonText: agotado ? '🔔 Notificarme' : '🛍️ Agregar al carrito',
      cancelButtonText: 'Cerrar',
      confirmButtonColor: '#3CAEE0',
    }).then(r => { if (r.isConfirmed && !agotado) agregarAlCarritoDirecto(p.id, p.nombre, p.precio); });
  } catch (e) {}
}

/* ─── CARRITO ─── */
function agregarAlCarritoBtn(event, el) {
  event.stopPropagation();
  const id = parseInt(el.dataset.pid);
  const nombre = decodeURIComponent(el.dataset.nombre);
  const precio = parseFloat(el.dataset.precio);
  agregarAlCarritoDirecto(id, nombre, precio);
}
function agregarAlCarritoDirecto(id, nombre, precio) {
  const ex = carrito.find(i => i.id === id);
  if (ex) ex.cantidad++;
  else carrito.push({ id, nombre, precio: Number(precio), cantidad: 1 });
  actualizarContadorCarrito();
  Swal.fire({ toast: true, position: 'bottom-end', icon: 'success', title: `¡${nombre} agregado!`, showConfirmButton: false, timer: 2200, timerProgressBar: true, background: '#ebeae4', color: '#1A3A5C' });
}
function verCarrito() {
  if (!carrito.length) {
    Swal.fire({ title: `<span style="font-family:var(--font-kranky)">Carrito vacío 🛍️</span>`, html: `<p style="font-family:var(--font-archivo)">Agrega productos desde el catálogo.</p>`, confirmButtonColor: '#3CAEE0', confirmButtonText: 'Seguir comprando' });
    return;
  }
  const ti = carrito.reduce((a,i) => a+i.cantidad, 0);
  const tp = carrito.reduce((a,i) => a+i.precio*i.cantidad, 0);
  Swal.fire({
    title: `<span style="font-family:var(--font-kranky)">Mi carrito 🛍️</span>`,
    html: `<div style="text-align:left;font-family:var(--font-archivo);">${carrito.map(i=>`
      <div style="display:flex;justify-content:space-between;align-items:center;padding:.55rem 0;border-bottom:1px solid var(--cami-border);gap:.5rem;">
        <span style="font-size:.88rem;flex:1;">${i.nombre.replace(/</g,"&lt;").replace(/>/g,"&gt;")}</span>
        <div style="display:flex;align-items:center;gap:.4rem;flex-shrink:0;">
          <button onclick="cambiarCantidad(${i.id},-1)" style="background:var(--cami-bg);border:none;border-radius:50%;width:26px;height:26px;cursor:pointer;">−</button>
          <span style="background:var(--cami-turq);color:var(--cami-azul);border-radius:50px;padding:.2rem .7rem;font-size:.75rem;font-weight:700;">×${i.cantidad}</span>
          <button onclick="cambiarCantidad(${i.id},+1)" style="background:var(--cami-turq);border:none;border-radius:50%;width:26px;height:26px;cursor:pointer;color:var(--cami-azul);">+</button>
          <button onclick="quitarItem(${i.id})" style="background:rgba(242,103,124,.15);border:none;border-radius:50%;width:26px;height:26px;cursor:pointer;color:var(--cami-coral);">✕</button>
        </div>
      </div>`).join('')}
      <div style="display:flex;justify-content:space-between;margin-top:1rem;font-weight:700;padding-top:.5rem;border-top:2px solid var(--cami-border);"><span>${ti} artículo${ti!==1?'s':''}</span><span style="color:var(--cami-azul);font-family:var(--font-kranky);font-size:1.1rem;">$${tp.toLocaleString('es-CO',{minimumFractionDigits:0})}</span></div></div>`,
    confirmButtonText: '🛒 Finalizar compra', showCancelButton: true, cancelButtonText: 'Seguir comprando', confirmButtonColor: '#3CAEE0',
  }).then(r => { if (r.isConfirmed) abrirCheckout(); });
}
function cambiarCantidad(id, delta) {
  const item = carrito.find(i => i.id === id);
  if (!item) return;
  item.cantidad = Math.max(1, item.cantidad + delta);
  actualizarContadorCarrito();
  Swal.close();
  setTimeout(() => verCarrito(), 50);
}
function quitarItem(id) {
  carrito = carrito.filter(i => i.id !== id);
  actualizarContadorCarrito();
  Swal.close();
  if (carrito.length > 0) setTimeout(() => verCarrito(), 50);
}
function actualizarContadorCarrito() { document.getElementById('contadorCarrito').textContent = carrito.reduce((a,i) => a+i.cantidad, 0); }

function abrirCheckout() {
  const tp = carrito.reduce((a,i) => a+i.precio*i.cantidad, 0);
  Swal.fire({
    title: `<span style="font-family:var(--font-kranky)">Datos de envío</span>`,
    html: `<div style="text-align:left;font-family:var(--font-archivo);display:flex;flex-direction:column;gap:.8rem;">
      <p style="font-size:.82rem;opacity:.6;margin:0;">Total: <strong>$${tp.toLocaleString('es-CO',{minimumFractionDigits:0})}</strong></p>
      <div><label style="font-size:.8rem;font-weight:700;color:var(--cami-azul);">Nombre completo *</label><input id="chkNombre" type="text" placeholder="Tu nombre" style="width:100%;padding:.6rem .9rem;border:2px solid var(--cami-border);border-radius:12px;font-size:.88rem;margin-top:.3rem;outline:none;box-sizing:border-box;"></div>
      <div><label style="font-size:.8rem;font-weight:700;color:var(--cami-azul);">Email *</label><input id="chkEmail" type="email" placeholder="tu@correo.com" style="width:100%;padding:.6rem .9rem;border:2px solid var(--cami-border);border-radius:12px;font-size:.88rem;margin-top:.3rem;outline:none;box-sizing:border-box;"></div>
      <div><label style="font-size:.8rem;font-weight:700;color:var(--cami-azul);">WhatsApp *</label><input id="chkTelefono" type="tel" placeholder="313 746 8039" style="width:100%;padding:.6rem .9rem;border:2px solid var(--cami-border);border-radius:12px;font-size:.88rem;margin-top:.3rem;outline:none;box-sizing:border-box;"></div>
      <div style="display:grid;grid-template-columns:1fr 1fr;gap:.6rem;"><div><label style="font-size:.8rem;font-weight:700;color:var(--cami-azul);">Ciudad *</label><input id="chkCiudad" type="text" placeholder="Medellín" style="width:100%;padding:.6rem .9rem;border:2px solid var(--cami-border);border-radius:12px;font-size:.88rem;margin-top:.3rem;outline:none;box-sizing:border-box;"></div><div><label style="font-size:.8rem;font-weight:700;color:var(--cami-azul);">Dirección *</label><input id="chkDireccion" type="text" placeholder="Cra 10 #20-30" style="width:100%;padding:.6rem .9rem;border:2px solid var(--cami-border);border-radius:12px;font-size:.88rem;margin-top:.3rem;outline:none;box-sizing:border-box;"></div></div>
      <p style="font-size:.73rem;color:#aaa;margin:0;">📦 Sin registro. Envíos a toda Colombia.</p></div>`,
    confirmButtonText: '✅ Confirmar pedido', showCancelButton: true, cancelButtonText: '← Volver', confirmButtonColor: '#3CAEE0', width: 520,
    preConfirm: () => {
      const n=(document.getElementById('chkNombre')?.value?.trim()||'').substring(0,120);
      const e=(document.getElementById('chkEmail')?.value?.trim()||'').substring(0,120);
      const t=(document.getElementById('chkTelefono')?.value?.trim()||'').substring(0,30);
      const c=(document.getElementById('chkCiudad')?.value?.trim()||'').substring(0,100);
      const d=(document.getElementById('chkDireccion')?.value?.trim()||'').substring(0,200);
      if(!n||!e||!t||!c||!d){Swal.showValidationMessage('Completa todos los campos (*)');return false;}
      if(!e.includes('@')){Swal.showValidationMessage('Email inválido');return false;}
      return{nombre:n,email:e,telefono:t,ciudad:c,direccion:d};
    }
  }).then(async r=>{if(!r.isConfirmed||!r.value){verCarrito();return;}await procesarCompra(r.value);});
}
async function procesarCompra(datosCliente) {
  Swal.fire({title:'Procesando tu pedido...',allowOutsideClick:false,didOpen:()=>Swal.showLoading()});
  try{
    const body={...datosCliente,items:carrito.map(i=>({producto_id:i.id,nombre:i.nombre,precio:i.precio,cantidad:i.cantidad})),total:carrito.reduce((a,i)=>a+i.precio*i.cantidad,0)};
    const res=await fetch('pedidos.php',{method:'POST',headers:{'Content-Type':'application/json'},body:JSON.stringify(body)});
    const json=await res.json();
    if(json.exito||res.ok){carrito=[];actualizarContadorCarrito();Swal.fire({icon:'success',title:'¡Pedido confirmado! 🎉',html:`<p style="font-family:var(--font-archivo)">Recibiste un email de confirmación.</p>`,confirmButtonColor:'#3CAEE0'});}
    else throw new Error(json.mensaje||'Error');
  }catch(e){Swal.fire({icon:'error',title:'Oops...',text:'Hubo un problema. Contáctanos por WhatsApp.',confirmButtonColor:'#3CAEE0'});}
}

/* ─── REDES FLOTANTES ─── */
function toggleFabSocial() {
  const links = document.getElementById('fabSocialLinks');
  const icon = document.getElementById('fabIconMain');
  links.classList.toggle('open');
  icon.className = links.classList.contains('open') ? 'bi bi-x-lg' : 'bi bi-share-fill';
}
document.addEventListener('click', (e) => {
  const wrap = document.getElementById('fabSocialWrap');
  if (wrap && !wrap.contains(e.target)) {
    document.getElementById('fabSocialLinks')?.classList.remove('open');
    const icon = document.getElementById('fabIconMain');
    if (icon) icon.className = 'bi bi-share-fill';
  }
});

/* ─── DISLEXIA ─── */
let dyslexiaOn = localStorage.getItem('pd_dyslexia') === '1';
function applyDyslexia() {
  document.body.classList.toggle('dyslexia-mode', dyslexiaOn);
  const label = document.getElementById('dyslexiaLabelMain');
  const btn = document.getElementById('btnDyslexiaFloat');
  if (label) label.textContent = dyslexiaOn ? 'Normal' : 'Dislexia';
  if (btn) { btn.style.background = dyslexiaOn ? 'var(--cami-turq)' : 'var(--cami-azul)'; btn.style.color = dyslexiaOn ? 'var(--cami-azul)' : 'white'; }
}
function toggleDyslexia() { dyslexiaOn = !dyslexiaOn; localStorage.setItem('pd_dyslexia', dyslexiaOn ? '1' : '0'); applyDyslexia(); }
applyDyslexia();

/* ─── SPLASH ─── */
(function() {
  const splash = document.getElementById('splashScreen');
  const progress = document.getElementById('splashProgress');
  if (!splash) return;
  let pct = 0;
  const tick = setInterval(() => {
    pct += Math.random() * 18 + 4;
    if (pct > 100) pct = 100;
    if (progress) progress.style.width = pct + '%';
    if (pct >= 100) { clearInterval(tick); setTimeout(() => { splash.classList.add('hidden'); setTimeout(() => splash.remove(), 700); }, 250); }
  }, 80);
  setTimeout(() => { clearInterval(tick); if (progress) progress.style.width = '100%'; setTimeout(() => { splash.classList.add('hidden'); setTimeout(() => splash.remove(), 700); }, 200); }, 2500);
})();

function buscarProductos() {
  busquedaActual = document.getElementById('searchNavbar')?.value?.trim() || '';
  window.location.href = 'productos.php' + (busquedaActual ? '?busqueda=' + encodeURIComponent(busquedaActual) : '');
}
</script>
</body>
</html>
