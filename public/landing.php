<?php
// ============================================================
// public/landing.php
// LANDING PAGE — "Poder Down by María Camila González Torres"
// Propuesta: El poder de creer e incluir
// Paleta: #ebeae4 | #4ed2ad | #e45b63 | #efb810 | #003366
// Tipografías: Kranky (display) + Playpen Sans (cuerpo)
// ============================================================
require_once __DIR__ . '/../config/config.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Poder Down — El poder de creer e incluir</title>

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
  <link href="https://fonts.googleapis.com/css2?family=Kranky&family=Playpen+Sans:wght@400;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="<?= BASE_URL ?>/public/css/marca.css">

  <style>
    :root {
      --cami-bg: #ebeae4; --cami-turq: #4ed2ad; --cami-coral: #e45b63;
      --cami-amarillo: #efb810; --cami-azul: #003366; --cami-border: #d6d4cc;
      --font-kranky: 'Kranky', cursive; --font-playpen: 'Playpen Sans', sans-serif;
    }
    * { box-sizing: border-box; }
    body { background: var(--cami-bg); color: var(--cami-azul); font-family: var(--font-playpen); margin: 0; }

    /* NAVBAR */
    .navbar-cami { background: var(--cami-bg); border-bottom: 2px solid var(--cami-border); position: sticky; top: 0; z-index: 1000; padding: .8rem 0; }
    .navbar-brand-cami { font-family: var(--font-kranky); font-size: 1.5rem; color: var(--cami-azul); text-decoration: none; }
    .navbar-brand-cami .punto { color: var(--cami-turq); }
    .nav-link-cami { font-family: var(--font-playpen); font-weight: 600; color: var(--cami-azul); font-size: .88rem; text-decoration: none; transition: color .2s; padding: .3rem .6rem; }
    .nav-link-cami:hover { color: var(--cami-coral); }
    .badge-carrito { background: var(--cami-coral); color: white; border-radius: 50%; font-size: .65rem; width: 18px; height: 18px; display: inline-flex; align-items: center; justify-content: center; margin-left: -6px; margin-top: -10px; font-weight: 700; vertical-align: top; }

    /* BOTONES GLOBALES */
    .btn-p1 { background: var(--cami-turq); color: var(--cami-azul); border: none; border-radius: 50px; padding: .75rem 2rem; font-weight: 700; font-family: var(--font-playpen); font-size: .95rem; cursor: pointer; transition: all .2s; text-decoration: none; display: inline-flex; align-items: center; gap: .5rem; }
    .btn-p1:hover { background: #3dbf9b; transform: translateY(-2px); color: var(--cami-azul); }
    .btn-p2 { background: transparent; color: var(--cami-azul); border: 2px solid var(--cami-azul); border-radius: 50px; padding: .7rem 1.8rem; font-weight: 600; font-family: var(--font-playpen); font-size: .9rem; cursor: pointer; transition: all .2s; text-decoration: none; display: inline-flex; align-items: center; gap: .5rem; }
    .btn-p2:hover { background: var(--cami-azul); color: white; }
    .btn-p-coral { background: var(--cami-coral); color: white; border: none; border-radius: 50px; padding: .75rem 2rem; font-weight: 700; font-family: var(--font-playpen); font-size: .95rem; cursor: pointer; transition: all .2s; text-decoration: none; display: inline-flex; align-items: center; gap: .5rem; }
    .btn-p-coral:hover { background: #c94851; transform: translateY(-2px); color: white; }
    .btn-carrito { background: var(--cami-azul); color: white; border: none; border-radius: 50px; padding: .5rem 1.4rem; font-weight: 700; font-family: var(--font-playpen); font-size: .88rem; cursor: pointer; transition: all .2s; display: inline-flex; align-items: center; gap: .4rem; }
    .btn-carrito:hover { background: #00254d; }

    /* HERO */
    .hero-section { background: var(--cami-bg); min-height: 92vh; display: flex; align-items: center; position: relative; overflow: hidden; padding: 4rem 0; }
    .hero-tagline { font-family: var(--font-kranky); font-size: clamp(2.6rem, 7vw, 5.5rem); color: var(--cami-azul); line-height: 1.05; }
    .hero-tagline .highlight { color: var(--cami-turq); }
    .hero-pill { display: inline-block; background: var(--cami-turq); color: var(--cami-azul); font-family: var(--font-playpen); font-weight: 700; font-size: .75rem; letter-spacing: 2px; text-transform: uppercase; border-radius: 50px; padding: .4rem 1.2rem; margin-bottom: 1.5rem; }
    .hero-sub { font-size: 1.05rem; line-height: 1.8; opacity: .75; max-width: 480px; margin: 1.4rem 0 2.2rem; }
    .hero-stats { display: flex; gap: 2.5rem; flex-wrap: wrap; margin-top: 2.5rem; padding-top: 2rem; border-top: 2px solid var(--cami-border); }
    .hero-stat-num { font-family: var(--font-kranky); font-size: 2rem; display: block; color: var(--cami-azul); line-height: 1; }
    .hero-stat-label { font-size: .74rem; font-weight: 600; opacity: .55; text-transform: uppercase; letter-spacing: 1px; }
    .hero-visual { position: relative; width: 100%; max-width: 420px; margin: 0 auto; }
    .blob-main { width: 380px; height: 380px; background: var(--cami-turq); border-radius: 46% 54% 62% 38% / 50% 44% 56% 50%; display: flex; align-items: center; justify-content: center; animation: blobFloat 8s ease-in-out infinite alternate; margin: 0 auto; }
    .blob-main i { font-size: 9rem; color: rgba(0,51,102,.18); }
    .blob-dot-coral { position: absolute; bottom: 10px; right: 0; width: 90px; height: 90px; background: var(--cami-coral); border-radius: 50%; animation: blobFloat 6s ease-in-out infinite alternate-reverse; }
    .blob-dot-yellow { position: absolute; top: 20px; right: 30px; width: 55px; height: 55px; background: var(--cami-amarillo); border-radius: 50%; animation: blobFloat 7s ease-in-out infinite alternate; }
    @keyframes blobFloat { from { transform: translate(0,0) rotate(0deg) scale(1); } to { transform: translate(6px,12px) rotate(4deg) scale(1.03); } }

    /* MARQUEE */
    .marquee-strip { background: var(--cami-azul); padding: .9rem 0; overflow: hidden; white-space: nowrap; }
    .marquee-inner { display: inline-flex; gap: 3rem; animation: marquee 22s linear infinite; }
    .marquee-item { font-family: var(--font-kranky); font-size: 1rem; color: white; display: inline-flex; align-items: center; gap: .5rem; flex-shrink: 0; }
    .mdot { width: 7px; height: 7px; border-radius: 50%; display: inline-block; }
    @keyframes marquee { 0% { transform: translateX(0); } 100% { transform: translateX(-50%); } }

    /* SECTIONS */
    .section-eyebrow { font-family: var(--font-playpen); font-size: .78rem; font-weight: 700; text-transform: uppercase; letter-spacing: 2.5px; color: var(--cami-turq); display: flex; align-items: center; gap: .5rem; margin-bottom: .6rem; }
    .section-title { font-family: var(--font-kranky); font-size: clamp(2rem, 5vw, 3rem); color: var(--cami-azul); line-height: 1.1; }

    /* BLOQUE PÚBLICO */
    .publico-card { background: var(--cami-bg); border-radius: 20px; padding: 2rem 1.6rem; height: 100%; border-bottom: 4px solid transparent; transition: all .3s; }
    .publico-card:hover { border-bottom-color: var(--cami-turq); transform: translateY(-5px); box-shadow: 0 14px 36px rgba(0,51,102,.1); }
    .publico-icon { width: 58px; height: 58px; border-radius: 16px; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; margin-bottom: 1.2rem; }
    .publico-title { font-family: var(--font-kranky); font-size: 1.2rem; color: var(--cami-azul); margin-bottom: .6rem; }
    .publico-desc { font-size: .87rem; line-height: 1.7; opacity: .72; margin: 0; }

    /* BLOQUE CAMI */
    .cami-section { background: var(--cami-azul); padding: 5rem 0; position: relative; overflow: hidden; }
    .cami-quote { font-family: var(--font-kranky); font-size: clamp(1.4rem, 3.5vw, 2.2rem); color: var(--cami-turq); line-height: 1.3; border-left: 4px solid var(--cami-turq); padding-left: 1.4rem; margin: 1.5rem 0; }
    .cami-body { color: rgba(255,255,255,.8); font-size: .95rem; line-height: 1.9; }
    .cami-chip { background: rgba(78,210,173,.15); color: var(--cami-turq); border: 1px solid rgba(78,210,173,.3); border-radius: 50px; padding: .35rem 1rem; font-size: .78rem; font-weight: 700; display: inline-block; margin: .2rem; }
    .cami-stat-big { font-family: var(--font-kranky); font-size: 3rem; color: var(--cami-turq); line-height: 1; }
    .cami-stat-sub { color: rgba(255,255,255,.6); font-size: .8rem; line-height: 1.4; }

    /* BLOQUE DESEO */
    .deseo-card { background: white; border-radius: 20px; padding: 2rem 1.8rem; height: 100%; position: relative; overflow: hidden; transition: all .3s; }
    .deseo-card:hover { transform: translateY(-5px); box-shadow: 0 20px 50px rgba(0,51,102,.1); }
    .deseo-num { font-family: var(--font-kranky); font-size: 4rem; position: absolute; top: 1rem; right: 1.4rem; opacity: .07; color: var(--cami-azul); line-height: 1; }
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

    /* PRUEBA SOCIAL */
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
    .cierre-txt { font-family: var(--font-kranky); font-size: clamp(1.4rem,3vw,2.2rem); color: white; margin-bottom: 1.5rem; }

    /* BLOG */
    .blog-card { background: white; border-radius: 20px; overflow: hidden; height: 100%; transition: all .3s; }
    .blog-card:hover { transform: translateY(-4px); box-shadow: 0 16px 40px rgba(0,51,102,.1); }
    .blog-img { height: 160px; display: flex; align-items: center; justify-content: center; font-size: 3.5rem; }
    .blog-body { padding: 1.5rem; }
    .blog-title { font-family: var(--font-kranky); font-size: 1.05rem; color: var(--cami-azul); margin-bottom: .6rem; line-height: 1.3; }
    .blog-desc { font-size: .82rem; line-height: 1.7; opacity: .68; margin: 0; }

    /* CATÁLOGO */
    .filtro-btn { background: white; color: var(--cami-azul); border: 2px solid var(--cami-border); border-radius: 50px; padding: .4rem 1.1rem; font-family: var(--font-playpen); font-weight: 600; font-size: .82rem; cursor: pointer; transition: all .2s; white-space: nowrap; }
    .filtro-btn:hover, .filtro-btn.activo { background: var(--cami-turq); border-color: var(--cami-turq); color: var(--cami-azul); }
    .input-search-cami { border-radius: 50px !important; border: 2px solid var(--cami-border) !important; font-family: var(--font-playpen) !important; background: white !important; padding: .65rem 1.2rem !important; font-size: .9rem !important; }
    .input-search-cami:focus { border-color: var(--cami-turq) !important; box-shadow: 0 0 0 3px rgba(78,210,173,.2) !important; outline: none; }

    /* PRODUCT CARD */
    .product-card-cami { background: var(--cami-bg); border-radius: 18px; overflow: hidden; cursor: pointer; transition: all .25s; }
    .product-card-cami:hover { transform: translateY(-5px); box-shadow: 0 14px 36px rgba(0,51,102,.12); }
    .product-card-cami .img-wrap { height: 170px; background: linear-gradient(135deg, rgba(78,210,173,.2), rgba(0,51,102,.06)); display: flex; align-items: center; justify-content: center; font-size: 3rem; position: relative; }
    .badge-cat { position: absolute; top: .7rem; left: .7rem; background: var(--cami-turq); color: var(--cami-azul); border-radius: 50px; padding: .2rem .7rem; font-size: .68rem; font-weight: 700; }
    .badge-agotado { position: absolute; top: .7rem; right: .7rem; background: var(--cami-coral); color: white; border-radius: 50px; padding: .2rem .7rem; font-size: .68rem; font-weight: 700; }
    .product-card-cami .card-body { padding: 1.1rem; }
    .product-name { font-weight: 700; font-size: .9rem; margin: 0 0 .2rem; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
    .product-desc { font-size: .76rem; opacity: .6; margin: 0 0 .8rem; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
    .product-footer { display: flex; justify-content: space-between; align-items: center; }
    .product-price { font-family: var(--font-kranky); font-size: 1.25rem; color: var(--cami-azul); }
    .btn-add-cami { background: var(--cami-azul); color: white; border: none; border-radius: 50%; width: 34px; height: 34px; display: flex; align-items: center; justify-content: center; font-size: 1rem; cursor: pointer; transition: all .2s; }
    .btn-add-cami:hover { background: var(--cami-turq); color: var(--cami-azul); }
    .btn-add-cami:disabled { background: #ccc; cursor: not-allowed; }

    /* FOOTER */


    /* ANIMACIONES */
    @keyframes fadeUp { from { opacity:0; transform:translateY(22px); } to { opacity:1; transform:translateY(0); } }
    .fade-up { animation: fadeUp .7s ease both; }
    .d1{animation-delay:.1s;} .d2{animation-delay:.22s;} .d3{animation-delay:.34s;} .d4{animation-delay:.46s;}

    @media (max-width:576px) { .hero-tagline{font-size:2.4rem;} .blob-main{width:270px;height:270px;} .hero-stats{gap:1.5rem;} .deseo-ctas{flex-direction:column;align-items:center;} }
  </style>
</head>
<body>

<!-- NAVBAR -->
<nav class="navbar-cami">
  <div class="container d-flex align-items-center justify-content-between flex-wrap gap-2">
    <a class="navbar-brand-cami" href="#inicio">Poder Down<span class="punto">.</span></a>
    <div class="d-none d-lg-flex align-items-center gap-3">
      <a class="nav-link-cami" href="#inicio">Inicio</a>
      <a class="nav-link-cami" href="#sobre-mi">Sobre mí</a>
      <a class="nav-link-cami" href="#catalogo">Productos</a>
      <a class="nav-link-cami" href="#galeria">Galería permanente</a>
      <a class="nav-link-cami" href="#blog">Blog</a>
      <a class="nav-link-cami" href="#contacto">Contacto</a>
    </div>
    <div class="d-flex align-items-center gap-3">
      <input type="text" id="searchNavbar" class="form-control input-search-cami d-none d-md-block"
             style="width:230px;padding:.45rem 1rem!important;font-size:.82rem!important;"
             placeholder="¿Qué producto o servicio buscas?"
             onkeydown="if(event.key==='Enter'){buscarProductos()}">
      <button class="btn-carrito" onclick="verCarrito()">
        <i class="bi bi-bag-heart"></i>
        <span class="badge-carrito" id="contadorCarrito">0</span>
      </button>
    </div>
  </div>
</nav>

<!-- ============================================================ BLOQUE 1: HERO ============================================================ -->
<section class="hero-section" id="inicio">
  <div class="container position-relative" style="z-index:1;">
    <div class="row align-items-center g-5">
      <div class="col-lg-6">
        <span class="hero-pill fade-up d1"><i class="bi bi-stars me-1"></i>Poder Down by María Camila González Torres</span>
        <h1 class="hero-tagline fade-up d2">
          El poder de<br><span class="highlight">creer e incluir</span>
        </h1>
        <p class="hero-sub fade-up d3">
          Descubre obras únicas de Cami y lleva el mensaje de Poder Down a tu espacio.
        </p>
        <div class="d-flex flex-wrap gap-3 fade-up d4">
          <a href="#catalogo" class="btn-p1"><i class="bi bi-bag-heart"></i>Lleva mi arte contigo</a>
          <a href="#sobre-mi" class="btn-p2"><i class="bi bi-person-heart"></i>Conoce mi historia</a>
        </div>
        <div class="hero-stats fade-up" style="animation-delay:.6s;">
          <div><span class="hero-stat-num">+150</span><span class="hero-stat-label">Experiencias<br>compartidas</span></div>
          <div><span class="hero-stat-num">+13K</span><span class="hero-stat-label">Personas<br>impactadas</span></div>
          <div><span class="hero-stat-num">+60</span><span class="hero-stat-label">Empresas<br>de varios sectores</span></div>
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
      ['#4ed2ad','Inclusión real'],['#e45b63','Arte único'],['#efb810','Charlas testimoniales'],
      ['#4ed2ad','Síndrome de Down'],['#e45b63','Neuroplasticidad'],['#efb810','Poder Down'],
      ['#4ed2ad','Bachillerato'],['#e45b63','UdeA UIncluye'],['#efb810','Speaker internacional'],
      ['#4ed2ad','13.000 personas'],['#e45b63','60+ empresas'],['#efb810','Coloreando mi vida'],
    ];
    foreach (array_merge($items,$items) as $it): ?>
    <span class="marquee-item"><span class="mdot" style="background:<?= $it[0] ?>"></span><?= $it[1] ?></span>
    <?php endforeach; ?>
  </div>
</div>

<!-- ============================================================ BLOQUE 2: OPCIONES POR PÚBLICO ============================================================ -->
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
          <a href="#catalogo" class="btn-p2 mt-3" style="font-size:.8rem;padding:.5rem 1.2rem;">Ver tienda →</a>
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

<!-- ============================================================ BLOQUE 3: DIFERENCIACIÓN — CAMI ============================================================ -->
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
          <div class="col-6 text-center">
            <div style="background:rgba(78,210,173,.12);border-radius:20px;padding:2rem 1rem;">
              <span class="cami-stat-big">+150</span>
              <p class="cami-stat-sub mt-1">Experiencias<br>compartidas</p>
            </div>
          </div>
          <div class="col-6 text-center">
            <div style="background:rgba(228,91,99,.1);border-radius:20px;padding:2rem 1rem;">
              <span class="cami-stat-big" style="color:var(--cami-coral);">+13K</span>
              <p class="cami-stat-sub mt-1">Personas<br>impactadas</p>
            </div>
          </div>
          <div class="col-6 text-center">
            <div style="background:rgba(239,184,16,.1);border-radius:20px;padding:2rem 1rem;">
              <span class="cami-stat-big" style="color:var(--cami-amarillo);">+60</span>
              <p class="cami-stat-sub mt-1">Empresas de<br>múltiples sectores</p>
            </div>
          </div>
          <div class="col-6 text-center">
            <div style="background:rgba(255,255,255,.06);border-radius:20px;padding:2rem 1rem;">
              <span class="cami-stat-big" style="color:white;">+5</span>
              <p class="cami-stat-sub mt-1">Países<br>alcanzados</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ============================================================ BLOQUE 4: DESEO — 4 FORMAS ============================================================ -->
<section style="background:var(--cami-bg);padding:5rem 0;" id="deseo">
  <div class="container">
    <div class="text-center mb-5">
      <p class="section-eyebrow justify-content-center"><i class="bi bi-stars"></i>Conéctate</p>
      <h2 class="section-title">4 Formas de Conectar<br><span style="color:var(--cami-turq);">con mi Mundo</span></h2>
    </div>
    <div class="row g-4">
      <div class="col-md-6">
        <div class="deseo-card">
          <span class="deseo-num">1</span>
          <div class="deseo-icon-wrap" style="background:rgba(78,210,173,.15);"><i class="bi bi-bag-heart" style="color:var(--cami-turq);"></i></div>
          <p class="deseo-title">Lleva mi arte contigo</p>
          <p class="deseo-desc">Visitar mi tienda es muy fácil. Encuentra productos únicos con mi arte para ti o para regalar.</p>
          <div class="deseo-steps">
            <span class="deseo-step">Elige tu favorito</span><span class="deseo-arrow">→</span>
            <span class="deseo-step">Compra en 3 clics</span><span class="deseo-arrow">→</span>
            <span class="deseo-step">Recibe en casa</span>
          </div>
          <a href="#catalogo" class="btn-p1 mt-3" style="font-size:.85rem;padding:.6rem 1.4rem;"><i class="bi bi-shop"></i>Explorar tienda</a>
        </div>
      </div>
      <div class="col-md-6">
        <div class="deseo-card">
          <span class="deseo-num">2</span>
          <div class="deseo-icon-wrap" style="background:rgba(228,91,99,.12);"><i class="bi bi-mic" style="color:var(--cami-coral);"></i></div>
          <p class="deseo-title">Invítame a participar</p>
          <p class="deseo-desc">Charlas testimoniales que sensibilizan y cambian perspectivas sobre la inclusión en colegios, universidades, empresas y familias.</p>
          <div class="deseo-steps">
            <span class="deseo-step">Contacta</span><span class="deseo-arrow">→</span>
            <span class="deseo-step">Agenda llamada</span><span class="deseo-arrow">→</span>
            <span class="deseo-step">Compartamos</span>
          </div>
          <a href="#contacto" class="btn-p-coral mt-3" style="font-size:.85rem;padding:.6rem 1.4rem;"><i class="bi bi-calendar-event"></i>Invitación a participar</a>
        </div>
      </div>
      <div class="col-md-6">
        <div class="deseo-card">
          <span class="deseo-num">3</span>
          <div class="deseo-icon-wrap" style="background:rgba(239,184,16,.15);"><i class="bi bi-images" style="color:var(--cami-amarillo);"></i></div>
          <p class="deseo-title">Enamórate de mi arte</p>
          <p class="deseo-desc">Pinturas únicas disponibles para disfrutar en mi galería permanente. Arte lleno de color, emoción y significado profundo.</p>
          <div class="deseo-steps">
            <span class="deseo-step">Explora galería</span><span class="deseo-arrow">→</span>
            <span class="deseo-step">Disfruta</span><span class="deseo-arrow">→</span>
            <span class="deseo-step">Comparte</span>
          </div>
          <a href="#galeria" class="btn-p2 mt-3" style="font-size:.85rem;padding:.6rem 1.4rem;"><i class="bi bi-easel2"></i>Ver galería</a>
        </div>
      </div>
      <div class="col-md-6">
        <div class="deseo-card">
          <span class="deseo-num">4</span>
          <div class="deseo-icon-wrap" style="background:rgba(0,51,102,.1);"><i class="bi bi-journal-text" style="color:var(--cami-azul);"></i></div>
          <p class="deseo-title">Conoce mi mensaje</p>
          <p class="deseo-desc">Las personas con Síndrome de Down podemos hacer más de lo que te imaginas. El límite es la confianza y la formación.</p>
          <div class="deseo-steps">
            <span class="deseo-step">Accede al blog</span><span class="deseo-arrow">→</span>
            <span class="deseo-step">Lee y piensa</span><span class="deseo-arrow">→</span>
            <span class="deseo-step">Comparte</span>
          </div>
          <a href="#blog" class="btn-p2 mt-3" style="font-size:.85rem;padding:.6rem 1.4rem;"><i class="bi bi-book"></i>Descubre mi blog</a>
        </div>
      </div>
    </div>
    <div class="deseo-ctas">
      <a href="#catalogo" class="btn-p1"><i class="bi bi-shop"></i>Explorar tienda</a>
      <a href="#galeria"  class="btn-p2"><i class="bi bi-easel2"></i>Ver galería</a>
      <a href="#contacto" class="btn-p-coral"><i class="bi bi-mic"></i>Invitación a participar</a>
      <a href="#blog"     class="btn-p2"><i class="bi bi-journal-richtext"></i>Descubre mi blog</a>
    </div>
  </div>
</section>

<!-- CATÁLOGO -->
<section style="background:white;padding:5rem 0;" id="catalogo">
  <div class="container">
    <div class="text-center mb-4">
      <p class="section-eyebrow justify-content-center"><i class="bi bi-bag-heart-fill" style="color:var(--cami-turq)"></i>Tienda</p>
      <h2 class="section-title">Lleva mi arte contigo<span style="color:var(--cami-turq);">.</span></h2>
      <p style="opacity:.65;margin-top:.5rem;">Productos únicos de Cami. Envíos a toda Colombia.</p>
    </div>
    <div class="row justify-content-center mb-4">
      <div class="col-md-5">
        <div class="d-flex gap-2">
          <input type="text" id="searchLanding" class="form-control input-search-cami flex-grow-1"
                 placeholder="¿Qué producto o servicio buscas?"
                 onkeydown="if(event.key==='Enter'){buscarProductos()}">
          <button class="btn-p1" style="white-space:nowrap;padding:.65rem 1.4rem;" onclick="buscarProductos()">Buscar</button>
        </div>
      </div>
    </div>
    <div class="d-flex gap-2 flex-wrap justify-content-center mb-5" id="filtrosCategorias">
      <button class="filtro-btn activo" onclick="filtrarCategoria(this,'')" data-cat="">✨ Todos</button>
    </div>
    <div class="row g-4" id="gridProductos">
      <div class="col-12 text-center py-5" id="gridLoader">
        <div class="spinner-border" style="color:var(--cami-turq);" role="status"></div>
        <p style="opacity:.6;margin-top:1rem;">Cargando el catálogo...</p>
      </div>
    </div>
    <div class="text-center mt-5 d-none" id="btnVerMasWrap">
      <button class="btn-p2" onclick="verMasProductos()"><i class="bi bi-plus-circle"></i>Ver más productos</button>
    </div>
  </div>
</section>

<!-- ============================================================ BLOQUE 5: FAQ ============================================================ -->
<section style="background:var(--cami-bg);padding:5rem 0;" id="faq">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-8">
        <div class="text-center mb-5">
          <p class="section-eyebrow justify-content-center"><i class="bi bi-question-circle-fill"></i>Preguntas frecuentes</p>
          <h2 class="section-title">Preguntas Frecuentes</h2>
        </div>
        <?php
        $faqs = [
          ['¿Para quién son las charlas de Camila?','Para colegios, universidades, empresas y cualquier organización que busque inspiración e inclusión real.'],
          ['¿Camila viaja a otros países?','Sí, Cami ha dado charlas en más de 4 países y sigue expandiendo su impacto internacional.'],
          ['¿Camila asiste a los eventos sola o requiere apoyo?','Camila siempre asiste acompañada de un apoyo familiar para garantizar la mejor experiencia.'],
          ['¿Las charlas de Cami tienen costo?','Para instituciones educativas y entidades sin ánimo de lucro no tienen costo, solo el desplazamiento. Para empresas, contáctanos para cotización.'],
          ['¿Cómo puedo comprar sus productos?','A través de la tienda virtual en esta misma página, con envíos a toda Colombia. ¡Sin necesidad de crear cuenta!'],
          ['¿Las conferencias son solo presenciales?','Principalmente presenciales para mayor impacto, pero se evalúan casos especiales en modalidad virtual.'],
        ];
        foreach ($faqs as $i => [$q, $a]):
        ?>
        <div class="faq-item" onclick="toggleFaq(<?= $i ?>)">
          <p class="faq-q">
            <?= htmlspecialchars($q) ?>
            <i class="bi bi-plus-circle faq-icon" id="faq-icon-<?= $i ?>"></i>
          </p>
          <p class="faq-a" id="faq-a-<?= $i ?>"><?= htmlspecialchars($a) ?></p>
        </div>
        <?php endforeach; ?>
        <div class="text-center mt-4">
          <a href="#catalogo" class="btn-p1"><i class="bi bi-bag-heart"></i>Ir a la tienda</a>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ============================================================ BLOQUE 6: PRUEBA SOCIAL ============================================================ -->
<section class="social-section" id="aliados">
  <div class="container">
    <div class="mini-banner">
      <div class="mini-banner-item text-center"><span class="mini-banner-num">+30</span><span class="mini-banner-label">Charlas internacionales</span></div>
      <div class="mini-banner-item text-center"><span class="mini-banner-num">+5</span><span class="mini-banner-label">Países alcanzados</span></div>
      <div class="mini-banner-item text-center"><span class="mini-banner-num">🎤</span><span class="mini-banner-label">Una sola misión</span></div>
    </div>
    <div class="text-center mb-4">
      <p class="section-eyebrow justify-content-center" style="color:var(--cami-turq);"><i class="bi bi-building"></i>Aliados que confían en mí</p>
    </div>
    <div class="text-center mb-5">
      <?php
      $aliados = ['La Casa de Carlota','Comfama','Universidad San Martín','Colegio San Ignacio','SENA','Universidad María Cano','UdeA','Lupines','Artesas','Sin Etiquetas','DiversoLab','Municipio de Medellín','Crear Unidos'];
      foreach ($aliados as $al): ?><span class="aliado-chip"><?= htmlspecialchars($al) ?></span><?php endforeach; ?>
    </div>
    <div class="text-center mb-4">
      <p class="section-eyebrow justify-content-center" style="color:var(--cami-turq);"><i class="bi bi-chat-quote-fill"></i>Qué dicen de mí, los que me conocen</p>
    </div>
    <div class="row g-4 mb-5">
      <div class="col-md-6">
        <div class="testimonial-card">
          <p class="testimonial-text">"Camila cambió completamente la perspectiva de nuestros colaboradores sobre la inclusión. Su autenticidad es verdaderamente inspiradora."</p>
          <p class="testimonial-author">— Directora de Talento Humano, Nutresa</p>
        </div>
      </div>
      <div class="col-md-6">
        <div class="testimonial-card">
          <p class="testimonial-text">"Como padre de un niño con Síndrome de Down, la conferencia de Camila me dio esperanza y herramientas concretas para el camino."</p>
          <p class="testimonial-author">— Padre de familia, Conferencia Sin Etiquetas</p>
        </div>
      </div>
    </div>
    <div class="cierre-grande">
      <p class="cierre-txt">No solo compras productos o contratas una charla.<br><span style="color:var(--cami-turq);">Inviertes en un mundo más inclusivo y consciente.</span></p>
      <a href="#deseo" class="btn-p1" style="font-size:1rem;padding:.9rem 2.5rem;"><i class="bi bi-lightning-charge-fill"></i>Hablemos hoy</a>
    </div>
  </div>
</section>

<!-- GALERÍA PERMANENTE -->
<section style="background:white;padding:5rem 0;" id="galeria">
  <div class="container">
    <div class="text-center mb-5">
      <p class="section-eyebrow justify-content-center"><i class="bi bi-easel2-fill"></i>Galería permanente</p>
      <h2 class="section-title">Enamórate de mi arte<span style="color:var(--cami-turq);">.</span></h2>
      <p style="opacity:.65;">Pinturas únicas disponibles para disfrutar.</p>
    </div>
    <div class="row g-4">
      <?php
      $obras = [
        ['🌈','Colores del alma','Acrílico sobre lienzo','Alegría pura'],
        ['🌸','Florecer','Técnica mixta','Resiliencia y vida'],
        ['🌊','Marea de colores','Acuarela','Libertad interior'],
        ['🦋','Metamorfosis','Óleo sobre lienzo','Transformación real'],
        ['🌟','Brillar diferente','Acrílico','El poder de ser tú'],
        ['🎨','El mundo en colores','Técnica mixta','Visión propia'],
      ];
      foreach ($obras as [$emoji,$titulo,$tecnica,$desc]):
      ?>
      <div class="col-6 col-md-4">
        <div class="blog-card">
          <div class="blog-img" style="background:linear-gradient(135deg,rgba(78,210,173,.2),rgba(239,184,16,.15));"><?= $emoji ?></div>
          <div class="blog-body">
            <p class="blog-title"><?= htmlspecialchars($titulo) ?></p>
            <p class="blog-desc"><strong><?= htmlspecialchars($tecnica) ?></strong> — <?= htmlspecialchars($desc) ?></p>
          </div>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- ============================================================ BLOQUE 7: BLOG ============================================================ -->
<section style="background:var(--cami-bg);padding:5rem 0;" id="blog">
  <div class="container">
    <div class="text-center mb-5">
      <p class="section-eyebrow justify-content-center"><i class="bi bi-journal-richtext-fill"></i>Blog</p>
      <h2 class="section-title">Día a día con Cami<span style="color:var(--cami-turq);">.</span></h2>
    </div>
    <div class="row g-4">
      <div class="col-md-4">
        <div class="blog-card">
          <div class="blog-img" style="background:rgba(78,210,173,.15);">📋</div>
          <div class="blog-body">
            <span style="background:rgba(78,210,173,.2);color:var(--cami-azul);border-radius:50px;padding:.3rem .9rem;font-size:.72rem;font-weight:700;letter-spacing:1px;display:inline-block;margin-bottom:.8rem;">Para padres</span>
            <p class="blog-title">Qué hacer cuando recibes el diagnóstico</p>
            <p class="blog-desc">Guía de la Fundación Sin Etiquetas con pasos concretos para el camino inicial.</p>
            <a href="#" class="btn-p2 mt-3" style="font-size:.78rem;padding:.45rem 1rem;">Leer artículo →</a>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="blog-card">
          <div class="blog-img" style="background:rgba(228,91,99,.1);">🧠</div>
          <div class="blog-body">
            <span style="background:rgba(228,91,99,.15);color:var(--cami-coral);border-radius:50px;padding:.3rem .9rem;font-size:.72rem;font-weight:700;letter-spacing:1px;display:inline-block;margin-bottom:.8rem;">Para profesionales</span>
            <p class="blog-title">Mitos sobre Síndrome de Down que debes conocer</p>
            <p class="blog-desc">Por Fundación Lupines y Corporación Crear Unidos. La verdad que cambia perspectivas.</p>
            <a href="#" class="btn-p2 mt-3" style="font-size:.78rem;padding:.45rem 1rem;">Leer artículo →</a>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="blog-card">
          <div class="blog-img" style="background:rgba(239,184,16,.15);">💼</div>
          <div class="blog-body">
            <span style="background:rgba(239,184,16,.2);color:#7a5f00;border-radius:50px;padding:.3rem .9rem;font-size:.72rem;font-weight:700;letter-spacing:1px;display:inline-block;margin-bottom:.8rem;">Para entidades</span>
            <p class="blog-title">Inclusión laboral: Ajustes razonables</p>
            <p class="blog-desc">Por DiversoLab. Cómo crear entornos de trabajo verdaderamente inclusivos.</p>
            <a href="#" class="btn-p2 mt-3" style="font-size:.78rem;padding:.45rem 1rem;">Leer artículo →</a>
          </div>
        </div>
      </div>
    </div>
    <div class="text-center mt-5">
      <a href="#" class="btn-p1"><i class="bi bi-journal-richtext"></i>Leer más artículos</a>
    </div>
  </div>
</section>

<!-- ============================================================ BLOQUE 8: FOOTER ============================================================ -->
<?php require_once __DIR__ . '/footer.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
const API_BASE    = '<?= API_URL ?>';
const LIMITE_GRID = 8;
let offsetActual = 0, categoriaActual = '', busquedaActual = '', carrito = [];

function toggleFaq(i) {
  const a = document.getElementById('faq-a-'+i);
  const icon = document.getElementById('faq-icon-'+i);
  const open = a.classList.toggle('open');
  icon.classList.toggle('open', open);
}

async function iniciarLanding() {
  await cargarCategorias();
  await cargarProductos(true);
}

async function cargarCategorias() {
  try {
    const res  = await fetch(`${API_BASE}/productos.php?stats=1`);
    const json = await res.json();
    if (!json.exito) return;
    const cont = document.getElementById('filtrosCategorias');
    (json.datos.por_categoria || []).forEach(cat => {
      const btn = document.createElement('button');
      btn.className = 'filtro-btn'; btn.dataset.cat = cat.categoria; btn.textContent = cat.categoria;
      btn.onclick = () => filtrarCategoria(btn, cat.categoria);
      cont.appendChild(btn);
    });
  } catch(e) {}
}

async function cargarProductos(reiniciar = false) {
  if (reiniciar) {
    offsetActual = 0;
    document.getElementById('gridProductos').innerHTML = `
      <div class="col-12 text-center py-5" id="gridLoader">
        <div class="spinner-border" style="color:var(--cami-turq);"></div>
        <p style="opacity:.6;margin-top:1rem;">Cargando...</p>
      </div>`;
    document.getElementById('btnVerMasWrap').classList.add('d-none');
  }
  const params = new URLSearchParams({ limite: LIMITE_GRID, offset: offsetActual });
  if (busquedaActual) params.append('busqueda', busquedaActual);
  try {
    const res  = await fetch(`${API_BASE}/productos.php?${params}`);
    const json = await res.json();
    const loader = document.getElementById('gridLoader');
    if (loader) loader.remove();
    if (!json.exito || json.datos.length === 0) {
      if (reiniciar) document.getElementById('gridProductos').innerHTML = `
        <div class="col-12 text-center py-5">
          <i class="bi bi-inbox" style="font-size:3rem;opacity:.3;"></i>
          <p style="opacity:.6;margin-top:1rem;">No se encontraron productos.</p>
        </div>`;
      return;
    }
    let productos = json.datos;
    if (categoriaActual) productos = productos.filter(p => p.categoria.toLowerCase() === categoriaActual.toLowerCase());
    const grid = document.getElementById('gridProductos');
    productos.forEach(p => {
      const col = document.createElement('div');
      col.className = 'col-6 col-md-4 col-lg-3';
      col.innerHTML = tarjetaProducto(p);
      grid.appendChild(col);
    });
    const totalCargado = offsetActual + json.datos.length;
    document.getElementById('btnVerMasWrap').classList.toggle('d-none', totalCargado >= json.total);
    offsetActual += json.datos.length;
  } catch(e) { const l = document.getElementById('gridLoader'); if(l) l.remove(); }
}

function tarjetaProducto(p) {
  const agotado = parseInt(p.stock) === 0;
  return `
  <div class="product-card-cami" onclick="verProducto(${p.id})">
    <div class="img-wrap">
      <i class="bi bi-image" style="color:var(--cami-border);"></i>
      <span class="badge-cat">${p.categoria}</span>
      ${agotado ? '<span class="badge-agotado">Agotado</span>' : ''}
    </div>
    <div class="card-body">
      <p class="product-name">${p.nombre}</p>
      <p class="product-desc">${p.descripcion ?? ''}</p>
      <div class="product-footer">
        <span class="product-price">$${Number(p.precio).toLocaleString('es-CO',{minimumFractionDigits:0})}</span>
        <button class="btn-add-cami"
          onclick="agregarAlCarrito(event,${p.id},'${p.nombre.replace(/'/g,"\\'")}',${p.precio})"
          ${agotado ? 'disabled' : ''}>
          <i class="bi bi-plus-lg"></i>
        </button>
      </div>
    </div>
  </div>`;
}

function filtrarCategoria(btn, cat) {
  document.querySelectorAll('.filtro-btn').forEach(b => b.classList.remove('activo'));
  btn.classList.add('activo'); categoriaActual = cat; cargarProductos(true);
}
function buscarProductos() {
  busquedaActual = document.getElementById('searchLanding')?.value?.trim()
    || document.getElementById('searchNavbar')?.value?.trim() || '';
  categoriaActual = '';
  document.querySelectorAll('.filtro-btn').forEach(b => b.classList.remove('activo'));
  document.querySelector('.filtro-btn[data-cat=""]')?.classList.add('activo');
  cargarProductos(true);
  document.getElementById('catalogo').scrollIntoView({behavior:'smooth'});
}
function verMasProductos() { cargarProductos(false); }

async function verProducto(id) {
  try {
    const res = await fetch(`${API_BASE}/productos.php?id=${id}`);
    const json = await res.json();
    if (!json.exito || !json.datos[0]) throw new Error();
    const p = json.datos[0]; const agotado = parseInt(p.stock) === 0;
    Swal.fire({
      title: `<span style="font-family:'Kranky',cursive">${p.nombre}</span>`,
      html: `<div style="font-family:'Playpen Sans',sans-serif;text-align:left;">
        <span style="background:#4ed2ad;color:#003366;border-radius:50px;padding:.3rem .9rem;font-size:.73rem;font-weight:700;">${p.categoria}</span>
        <p style="margin-top:1rem;font-size:.88rem;opacity:.75;line-height:1.8;">${p.descripcion ?? 'Sin descripción.'}</p>
        <div style="display:flex;justify-content:space-between;align-items:center;margin-top:1rem;">
          <span style="font-family:'Kranky',cursive;font-size:1.9rem;color:#003366;">$${Number(p.precio).toLocaleString('es-CO',{minimumFractionDigits:0})}</span>
          <span style="background:${agotado?'#e45b63':'rgba(78,210,173,.18)'};color:${agotado?'white':'#003366'};border-radius:50px;padding:.35rem 1rem;font-size:.78rem;font-weight:700;">
            ${agotado?'😕 Sin stock':'✅ '+p.stock+' disponibles'}
          </span>
        </div></div>`,
      showCancelButton: true,
      confirmButtonText: agotado ? '🔔 Notificarme' : '🛍️ Agregar al carrito',
      cancelButtonText: 'Cerrar', confirmButtonColor: '#4ed2ad',
    }).then(r => { if(r.isConfirmed && !agotado) agregarAlCarritoDirecto(p.id, p.nombre, p.precio); });
  } catch(e) {}
}

function agregarAlCarrito(event, id, nombre, precio) { event.stopPropagation(); agregarAlCarritoDirecto(id, nombre, precio); }
function agregarAlCarritoDirecto(id, nombre, precio) {
  const ex = carrito.find(i => i.id === id);
  if (ex) ex.cantidad++; else carrito.push({id, nombre, precio: Number(precio), cantidad: 1});
  actualizarContadorCarrito();
  Swal.fire({ toast:true, position:'bottom-end', icon:'success', title:`¡${nombre} agregado!`, showConfirmButton:false, timer:2200, timerProgressBar:true, background:'#ebeae4', color:'#003366' });
}
function verCarrito() {
  if (!carrito.length) {
    Swal.fire({ title:`<span style="font-family:'Kranky',cursive">Carrito vacío 🛍️</span>`, html:`<p style="font-family:'Playpen Sans',sans-serif">Agrega productos desde el catálogo.</p>`, confirmButtonColor:'#4ed2ad', confirmButtonText:'Ver catálogo' })
      .then(r => { if(r.isConfirmed) document.getElementById('catalogo').scrollIntoView({behavior:'smooth'}); });
    return;
  }
  const ti = carrito.reduce((a,i) => a+i.cantidad, 0);
  const tp = carrito.reduce((a,i) => a+i.precio*i.cantidad, 0);
  Swal.fire({
    title:`<span style="font-family:'Kranky',cursive">Mi carrito 🛍️</span>`,
    html:`<div style="text-align:left;font-family:'Playpen Sans',sans-serif;">
      ${carrito.map(i=>`
        <div style="display:flex;justify-content:space-between;align-items:center;padding:.55rem 0;border-bottom:1px solid #ebeae4;gap:.5rem;">
          <span style="font-size:.88rem;flex:1;">${i.nombre}</span>
          <div style="display:flex;align-items:center;gap:.4rem;flex-shrink:0;">
            <button onclick="cambiarCantidad(${i.id},-1)" style="background:#ebeae4;border:none;border-radius:50%;width:26px;height:26px;cursor:pointer;font-size:.9rem;display:flex;align-items:center;justify-content:center;">−</button>
            <span style="background:#4ed2ad;color:#003366;border-radius:50px;padding:.2rem .7rem;font-size:.75rem;font-weight:700;min-width:30px;text-align:center;" id="qty-${i.id}">×${i.cantidad}</span>
            <button onclick="cambiarCantidad(${i.id},+1)" style="background:#4ed2ad;border:none;border-radius:50%;width:26px;height:26px;cursor:pointer;font-size:.9rem;color:#003366;display:flex;align-items:center;justify-content:center;">+</button>
            <button onclick="quitarItem(${i.id})" style="background:rgba(228,91,99,.15);border:none;border-radius:50%;width:26px;height:26px;cursor:pointer;font-size:.8rem;color:#e45b63;display:flex;align-items:center;justify-content:center;">✕</button>
          </div>
        </div>`).join('')}
      <div style="display:flex;justify-content:space-between;margin-top:1rem;font-weight:700;padding-top:.5rem;border-top:2px solid #ebeae4;">
        <span>${ti} artículo${ti!==1?'s':''}</span>
        <span style="color:#003366;font-family:'Kranky',cursive;font-size:1.1rem;" id="totalCarritoDisplay">$${tp.toLocaleString('es-CO',{minimumFractionDigits:0})}</span>
      </div></div>`,
    confirmButtonText:'🛒 Finalizar compra', showCancelButton:true, cancelButtonText:'Seguir comprando', confirmButtonColor:'#4ed2ad',
  }).then(r => { if(r.isConfirmed) abrirCheckout(); });
}

function cambiarCantidad(id, delta) {
  const item = carrito.find(i => i.id === id);
  if (!item) return;
  item.cantidad = Math.max(1, item.cantidad + delta);
  actualizarContadorCarrito();
  // Cierra y reabre para refrescar
  Swal.close();
  setTimeout(() => verCarrito(), 50);
}
function quitarItem(id) {
  carrito = carrito.filter(i => i.id !== id);
  actualizarContadorCarrito();
  Swal.close();
  if (carrito.length > 0) setTimeout(() => verCarrito(), 50);
}

// ── CHECKOUT SIN REGISTRO ─────────────────────────────────────
function abrirCheckout() {
  const tp = carrito.reduce((a,i) => a+i.precio*i.cantidad, 0);
  Swal.fire({
    title: `<span style="font-family:'Kranky',cursive">Datos de envío</span>`,
    html: `
    <div style="text-align:left;font-family:'Playpen Sans',sans-serif;display:flex;flex-direction:column;gap:.8rem;">
      <p style="font-size:.82rem;opacity:.6;margin:0;">Total a pagar: <strong style="color:#003366;font-size:1rem;">$${tp.toLocaleString('es-CO',{minimumFractionDigits:0})}</strong></p>
      <div>
        <label style="font-size:.8rem;font-weight:700;color:#003366;">Nombre completo *</label>
        <input id="chkNombre" type="text" placeholder="Tu nombre completo" style="width:100%;padding:.6rem .9rem;border:2px solid #d6d4cc;border-radius:12px;font-family:'Playpen Sans',sans-serif;font-size:.88rem;margin-top:.3rem;outline:none;box-sizing:border-box;">
      </div>
      <div>
        <label style="font-size:.8rem;font-weight:700;color:#003366;">Email *</label>
        <input id="chkEmail" type="email" placeholder="tu@correo.com" style="width:100%;padding:.6rem .9rem;border:2px solid #d6d4cc;border-radius:12px;font-family:'Playpen Sans',sans-serif;font-size:.88rem;margin-top:.3rem;outline:none;box-sizing:border-box;">
      </div>
      <div>
        <label style="font-size:.8rem;font-weight:700;color:#003366;">WhatsApp / Teléfono *</label>
        <input id="chkTelefono" type="tel" placeholder="313 746 8039" style="width:100%;padding:.6rem .9rem;border:2px solid #d6d4cc;border-radius:12px;font-family:'Playpen Sans',sans-serif;font-size:.88rem;margin-top:.3rem;outline:none;box-sizing:border-box;">
      </div>
      <div style="display:grid;grid-template-columns:1fr 1fr;gap:.6rem;">
        <div>
          <label style="font-size:.8rem;font-weight:700;color:#003366;">Ciudad *</label>
          <input id="chkCiudad" type="text" placeholder="Medellín" style="width:100%;padding:.6rem .9rem;border:2px solid #d6d4cc;border-radius:12px;font-family:'Playpen Sans',sans-serif;font-size:.88rem;margin-top:.3rem;outline:none;box-sizing:border-box;">
        </div>
        <div>
          <label style="font-size:.8rem;font-weight:700;color:#003366;">Dirección *</label>
          <input id="chkDireccion" type="text" placeholder="Cra 10 #20-30" style="width:100%;padding:.6rem .9rem;border:2px solid #d6d4cc;border-radius:12px;font-family:'Playpen Sans',sans-serif;font-size:.88rem;margin-top:.3rem;outline:none;box-sizing:border-box;">
        </div>
      </div>
      <div>
        <label style="font-size:.8rem;font-weight:700;color:#003366;">Notas adicionales (opcional)</label>
        <textarea id="chkNotas" placeholder="Apartamento, instrucciones de entrega..." rows="2" style="width:100%;padding:.6rem .9rem;border:2px solid #d6d4cc;border-radius:12px;font-family:'Playpen Sans',sans-serif;font-size:.88rem;margin-top:.3rem;outline:none;resize:none;box-sizing:border-box;"></textarea>
      </div>
      <p style="font-size:.73rem;color:#aaa;margin:0;">📦 Sin registro. Recibirás confirmación por email. Envíos a toda Colombia.</p>
    </div>`,
    confirmButtonText: '✅ Confirmar pedido',
    showCancelButton: true,
    cancelButtonText: '← Volver al carrito',
    confirmButtonColor: '#4ed2ad',
    width: 520,
    preConfirm: () => {
      const nombre   = document.getElementById('chkNombre')?.value?.trim();
      const email    = document.getElementById('chkEmail')?.value?.trim();
      const telefono = document.getElementById('chkTelefono')?.value?.trim();
      const ciudad   = document.getElementById('chkCiudad')?.value?.trim();
      const dir      = document.getElementById('chkDireccion')?.value?.trim();
      if (!nombre || !email || !telefono || !ciudad || !dir) {
        Swal.showValidationMessage('Por favor completa todos los campos obligatorios (*)');
        return false;
      }
      if (!email.includes('@')) {
        Swal.showValidationMessage('Email inválido');
        return false;
      }
      return { nombre, email, telefono, ciudad, direccion: dir, notas: document.getElementById('chkNotas')?.value?.trim() || '' };
    }
  }).then(async r => {
    if (!r.isConfirmed || !r.value) { verCarrito(); return; }
    await procesarCompra(r.value);
  });
}

async function procesarCompra(datosCliente) {
  Swal.fire({
    title: 'Procesando tu pedido...',
    html: '<div style="font-family:\'Playpen Sans\',sans-serif;">Un momento, estamos confirmando tu compra 🛍️</div>',
    allowOutsideClick: false,
    didOpen: () => Swal.showLoading(),
  });
  try {
    const body = {
      ...datosCliente,
      items: carrito.map(i => ({ id: i.id, nombre: i.nombre, precio: i.precio, cantidad: i.cantidad })),
    };
    const res  = await fetch(API_BASE + '/pedidos.php', { method: 'POST', headers: {'Content-Type':'application/json'}, body: JSON.stringify(body) });
    const json = await res.json();
    if (!json.exito || !json.datos[0]) throw new Error(json.mensaje || 'Error al crear pedido');
    const pedido = json.datos[0];

    // Vaciar carrito
    carrito = [];
    actualizarContadorCarrito();

    Swal.fire({
      title: `<span style="font-family:'Kranky',cursive;color:#003366">¡Pedido confirmado! 🎉</span>`,
      html: `<div style="font-family:'Playpen Sans',sans-serif;text-align:left;">
        <div style="background:rgba(78,210,173,.15);border-radius:12px;padding:1rem;margin-bottom:1rem;text-align:center;">
          <p style="font-family:'Kranky',cursive;font-size:1.4rem;color:#003366;margin:0;">Código: <strong style="color:#4ed2ad;">${pedido.codigo}</strong></p>
          <p style="font-size:.8rem;opacity:.6;margin:.3rem 0 0;">Guarda este código para rastrear tu pedido</p>
        </div>
        <p style="font-size:.88rem;line-height:1.7;margin:0;">
          ✅ Tu pedido ha sido recibido correctamente.<br>
          📧 Te contactaremos a <strong>${datosCliente.email}</strong> con los detalles.<br>
          📦 Envío a: ${datosCliente.ciudad} — ${datosCliente.direccion}<br>
          📞 Si tienes preguntas: <a href="https://wa.me/573137468039" style="color:#4ed2ad;">313 746 8039</a>
        </p>
      </div>`,
      confirmButtonText: '🏠 Volver a la tienda',
      confirmButtonColor: '#4ed2ad',
      allowOutsideClick: false,
    }).then(() => {
      cargarProductos(true); // Refresca stock
    });
  } catch(e) {
    Swal.fire({ icon:'error', title:'Error al procesar', text: e.message || 'Intenta de nuevo o escríbenos por WhatsApp.', confirmButtonColor:'#4ed2ad' });
  }
}
function actualizarContadorCarrito() {
  document.getElementById('contadorCarrito').textContent = carrito.reduce((a,i)=>a+i.cantidad,0);
}

['searchLanding','searchNavbar'].forEach(id => {
  document.getElementById(id)?.addEventListener('keydown', e => { if(e.key==='Enter') buscarProductos(); });
});

document.addEventListener('DOMContentLoaded', iniciarLanding);
</script>
</body>
</html>