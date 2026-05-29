<?php
// ============================================================
// public/landing.php
// LANDING PAGE — "Poder Down by María Camila González Torres"
// Propuesta: El poder de creer e incluir
// Paleta: #ebeae4 | #3CAEE0 | #F2677C | #F5C518 | #1A3A5C
// Tipografías: Kranky (display) + Playpen Sans (cuerpo)
// ============================================================
require_once __DIR__ . '/../config/config.php';

// ── Security headers ─────────────────────────────────────────
header('X-Frame-Options: DENY');
header('X-Content-Type-Options: nosniff');
header('X-XSS-Protection: 1; mode=block');
header('Referrer-Policy: strict-origin-when-cross-origin');
header('Permissions-Policy: geolocation=(), camera=(), microphone=()');
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0">
  <title>Poder Down — El poder de creer e incluir</title>

  <!-- Favicon -->
  <link rel="icon" type="image/png" href="<?= BASE_URL ?>/public/css/favicon_poderdown.png">
  <link rel="apple-touch-icon" href="<?= BASE_URL ?>/public/css/favicon_poderdown.png">

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
  <!-- Tipografías Manual de Marca Poder Down:
       Gilroy (T1 Títulos) → Nunito ExtraBold como fallback web
       Archivo (T2 Cuerpo de texto)
       Oregano (T3 Palabras puntuales) -->
  <link href="https://fonts.googleapis.com/css2?family=Archivo:ital,wght@0,400;0,500;0,600;0,700;0,800;0,900;1,400&family=Oregano:ital@0;1&family=Nunito:wght@700;800;900&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="<?= BASE_URL ?>/public/css/marca.css">

  <style>
    :root {
      --cami-bg: #ebeae4;
      --pd-azul: #3CAEE0; --cami-turq: #3CAEE0; --cami-turquesa: #3CAEE0;
      --pd-coral: #F2677C; --cami-coral: #F2677C;
      --cami-amarillo: #F5C518;
      --pd-oscuro: #1A3A5C; --cami-azul: #1A3A5C;
      --cami-border: #d6d4cc;
      /* Tipografías */
      --font-gilroy:  'Nunito', 'Gilroy', sans-serif;
      --font-archivo: 'Archivo', sans-serif;
      --font-oregano: 'Oregano', cursive;
      /* Alias legacy */
      --font-kranky:  var(--font-gilroy);
      --font-playpen: var(--font-archivo);
    }
    * { box-sizing: border-box; }
    body { background: var(--cami-bg); color: var(--cami-azul); font-family: var(--font-playpen); margin: 0; }

    /* NAVBAR */
    .navbar-cami { background: var(--cami-bg); border-bottom: 2px solid var(--cami-border); position: sticky; top: 0; z-index: 1000; padding: .8rem 0; }
    .navbar-brand-cami { text-decoration: none; display: flex; align-items: center; }
    .navbar-brand-cami img { height: 44px; width: auto; object-fit: contain; }
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

    /* ============================================================
       RESPONSIVE — cobertura completa de dispositivos
       XS  < 360px  (mobile pequeño: Galaxy A, iPhone SE)
       SM  360-575px (mobile estándar)
       MD  576-767px (mobile grande / phablet)
       LG  768-991px (tablet portrait)
       XL  992-1199px (tablet landscape / laptop pequeño)
       XXL ≥1200px   (desktop)
    ============================================================ */

    /* ---- NAVBAR ---- */
    @media (max-width:991px) {
      /* En tablet/mobile el search se oculta (d-none d-md-block ya lo maneja Bootstrap) */
      .navbar-cami { padding:.6rem 0; }
      .navbar-brand-cami img { height:36px; }
    }
    @media (max-width:575px) {
      .navbar-brand-cami img { height:30px; }
      .btn-carrito { padding:.45rem .9rem; font-size:.8rem; }
    }

    /* ---- HERO ---- */
    @media (max-width:1199px) {
      .hero-section { min-height: auto; padding: 3.5rem 0; }
      .hero-tagline { font-size: clamp(2.2rem, 6vw, 4rem); }
    }
    @media (max-width:991px) {
      /* En tablet el visual blob baja debajo del texto */
      .hero-section { padding: 3rem 0 2.5rem; }
      .blob-main { width: 300px; height: 300px; }
      .hero-sub { max-width: 100%; }
    }
    @media (max-width:767px) {
      .hero-section { padding: 2.5rem 0 2rem; }
      .hero-tagline { font-size: clamp(2rem, 8vw, 3rem); }
      .hero-sub { font-size: .95rem; margin: 1rem 0 1.8rem; }
      .hero-stats { gap: 1.2rem; margin-top: 2rem; padding-top: 1.5rem; }
      .hero-stat-num { font-size: 1.6rem; }
      /* Ocultar el blob visual en mobile para no ocupar espacio */
      .hero-visual { display: none; }
    }
    @media (max-width:575px) {
      .hero-tagline { font-size: 2rem; }
      .hero-pill { font-size: .68rem; padding: .35rem 1rem; }
      .hero-stats { gap: 1rem; }
      .hero-stat-num { font-size: 1.4rem; }
      .hero-stat-label { font-size: .68rem; }
      /* Botones hero en columna en mobile pequeño */
      .hero-section .d-flex.flex-wrap { flex-direction: column; align-items: flex-start; }
      .hero-section .btn-p1,
      .hero-section .btn-p2 { width: 100%; justify-content: center; }
    }
    @media (max-width:359px) {
      .hero-tagline { font-size: 1.75rem; }
    }

    /* ---- MARQUEE ---- */
    @media (max-width:575px) {
      .marquee-item { font-size: .85rem; }
      .marquee-inner { gap: 2rem; }
    }

    /* ---- SECCIONES GENERALES ---- */
    @media (max-width:767px) {
      section[style*="padding:5rem"] { padding: 3rem 0 !important; }
      .cami-section { padding: 3rem 0 !important; }
      .social-section { padding: 3rem 0 !important; }
      .section-title { font-size: clamp(1.7rem, 6vw, 2.4rem); }
    }
    @media (max-width:575px) {
      section[style*="padding:5rem"] { padding: 2.5rem 0 !important; }
      .cami-section { padding: 2.5rem 0 !important; }
      .social-section { padding: 2.5rem 0 !important; }
      .section-title { font-size: clamp(1.5rem, 7vw, 2rem); }
      .section-eyebrow { font-size: .7rem; }
    }

    /* ---- CARDS PÚBLICO ---- */
    @media (max-width:575px) {
      .publico-card { padding: 1.4rem 1.2rem; }
      .publico-title { font-size: 1.05rem; }
    }

    /* ---- BLOQUE CAMI ---- */
    @media (max-width:767px) {
      .cami-quote { font-size: 1.2rem; padding-left: 1rem; }
      .cami-stat-big { font-size: 2.2rem; }
    }
    @media (max-width:575px) {
      .cami-quote { font-size: 1.05rem; }
      .cami-stat-big { font-size: 1.9rem; }
      .cami-body { font-size: .88rem; }
      /* Stats en 2 columnas en mobile (ya es col-6, bien) */
    }

    /* ---- DESEO CARDS ---- */
    @media (max-width:767px) {
      .deseo-card { padding: 1.5rem 1.3rem; }
    }
    @media (max-width:575px) {
      .deseo-ctas { flex-direction: column; align-items: stretch; }
      .deseo-ctas .btn-p1,
      .deseo-ctas .btn-p2,
      .deseo-ctas .btn-p-coral { width: 100%; justify-content: center; }
      .deseo-steps { font-size: .7rem; }
    }

    /* ---- CATÁLOGO / SEARCH ---- */
    @media (max-width:767px) {
      #filtrosCategorias { gap: .4rem; }
      .filtro-btn { font-size: .76rem; padding: .35rem .85rem; }
    }
    @media (max-width:575px) {
      /* Search a ancho completo */
      #searchLanding { font-size: .82rem !important; }
      .product-card-cami .img-wrap { height: 140px; }
    }
    /* En mobile el grid de productos: 2 columnas fijas */
    @media (max-width:575px) {
      #gridProductos .col-6 { width: 50% !important; }
      .product-name { font-size: .82rem; }
      .product-price { font-size: 1.1rem; }
    }
    @media (max-width:359px) {
      /* En mobile muy pequeño: 1 columna */
      #gridProductos .col-6 { width: 100% !important; }
    }

    /* ---- FAQ ---- */
    @media (max-width:575px) {
      .faq-q { font-size: .88rem; }
      .faq-a { font-size: .83rem; }
      .faq-item { padding: 1.1rem 0; }
    }

    /* ---- PRUEBA SOCIAL ---- */
    @media (max-width:767px) {
      .mini-banner { gap: 1.5rem; padding: 1.2rem 1rem; }
      .mini-banner-num { font-size: 1.8rem; }
      .testimonial-card { padding: 1.4rem; }
      .testimonial-text { font-size: .86rem; }
    }
    @media (max-width:575px) {
      .mini-banner { gap: 1rem .8rem; }
      .cierre-txt { font-size: 1.2rem; }
      .cierre-grande { margin-top: 2rem; padding-top: 2rem; }
    }

    /* ---- GALERÍA / BLOG ---- */
    @media (max-width:575px) {
      .blog-img { height: 120px; font-size: 2.8rem; }
      .blog-body { padding: 1rem; }
      .blog-title { font-size: .92rem; }
      .blog-desc { font-size: .76rem; }
    }

    /* ---- BOTONES GLOBALES — mobile full-width helper ---- */
    @media (max-width:400px) {
      .btn-p1, .btn-p2, .btn-p-coral {
        font-size: .85rem;
        padding: .65rem 1.4rem;
      }
    }

    /* ============================================================
       ALIADOS CARRUSEL
    ============================================================ */
    .aliados-track-wrap {
      overflow: hidden;
      position: relative;
      padding: 1rem 0;
    }
    .aliados-track-wrap::before,
    .aliados-track-wrap::after {
      content: '';
      position: absolute;
      top: 0; bottom: 0;
      width: 80px;
      z-index: 2;
      pointer-events: none;
    }
    .aliados-track-wrap::before { left: 0; background: linear-gradient(to right, white, transparent); }
    .aliados-track-wrap::after  { right: 0; background: linear-gradient(to left, white, transparent); }
    .aliados-track {
      display: flex;
      gap: 1.5rem;
      animation: aliadosScroll 28s linear infinite;
      width: max-content;
    }
    .aliados-track:hover { animation-play-state: paused; }
    @keyframes aliadosScroll {
      0%   { transform: translateX(0); }
      100% { transform: translateX(-50%); }
    }
        .aliado-logo-card {
      display: flex;
      align-items: center;
      justify-content: center;
      min-width: 180px;
      height: 80px;
      border: 2px solid var(--cami-border);
      border-radius: 16px;
      padding: .6rem 1rem;
      text-decoration: none;
      transition: all .28s;
      flex-shrink: 0;
      background: white;
      overflow: hidden;
    }
    .aliado-logo-card:hover {
      border-color: var(--cami-turq);
      transform: translateY(-4px);
      box-shadow: 0 10px 28px rgba(0,51,102,.12);
    }
    .aliado-logo-card svg {
      width: 100%;
      height: 100%;
      display: block;
    }
    @media (max-width:575px) {
      .aliado-logo-card { min-width: 150px; height: 68px; }
    }

    /* ============================================================
       REDES SOCIALES FLOTANTES
    ============================================================ */
    .fab-social-wrap {
      position: fixed;
      right: 18px;
      bottom: 58px;
      z-index: 998;
      display: flex;
      flex-direction: column;
      align-items: center;
      gap: .55rem;
    }
    .fab-toggle-btn {
      width: 46px; height: 46px;
      border-radius: 50%;
      background: var(--cami-coral);
      color: white;
      border: none;
      cursor: pointer;
      font-size: 1.05rem;
      display: flex; align-items: center; justify-content: center;
      box-shadow: 0 4px 16px rgba(242,103,124,.4);
      transition: all .25s;
      order: 1;
    }
    .fab-toggle-btn:hover { transform: scale(1.1) rotate(10deg); }
    .fab-social-links {
      display: flex;
      flex-direction: column;
      gap: .5rem;
      overflow: hidden;
      max-height: 0;
      transition: max-height .4s cubic-bezier(.4,0,.2,1), opacity .3s;
      opacity: 0;
      order: 0;
    }
    .fab-social-links.open { max-height: 320px; opacity: 1; }
    .fab-soc {
      width: 42px; height: 42px;
      border-radius: 50%;
      display: flex; align-items: center; justify-content: center;
      color: white;
      text-decoration: none;
      transition: all .22s;
      box-shadow: 0 3px 12px rgba(0,0,0,.22);
      transform: scale(0.8);
    }
    .fab-social-links.open .fab-soc { transform: scale(1); }
    .fab-soc:hover { transform: scale(1.15) translateX(-5px); }
    .fab-ig { background: linear-gradient(135deg,#f09433,#e6683c,#dc2743,#cc2366,#bc1888); }
    .fab-tk { background: #010101; }
    .fab-fb { background: #1877F2; }
    .fab-yt { background: #FF0000; }
    .fab-wa { background: #25D366; }
    @media (max-width:575px) {
      .fab-social-wrap { right: 12px; bottom: 52px; }
      .fab-soc { width: 38px; height: 38px; }
      .fab-toggle-btn { width: 42px; height: 42px; }
    }

    /* ============================================================
       BOTÓN DISLEXIA FLOTANTE
    ============================================================ */
    .btn-dyslexia-float {
      position: fixed;
      left: 16px;
      bottom: 58px;
      z-index: 998;
      background: var(--cami-azul);
      color: white;
      border: none;
      border-radius: 50px;
      padding: .55rem 1rem;
      font-family: var(--font-playpen);
      font-size: .75rem;
      font-weight: 700;
      cursor: pointer;
      box-shadow: 0 4px 14px rgba(0,51,102,.28);
      transition: all .25s;
      display: flex;
      align-items: center;
      gap: .4rem;
    }
    .btn-dyslexia-float:hover { background: var(--cami-turq); color: var(--cami-azul); transform: translateY(-2px); }
    .dyslexia-icon { font-size: .95rem; font-weight: 900; }
    body.dyslexia-mode { font-family: 'Comic Sans MS', 'Trebuchet MS', cursive !important; letter-spacing: .04em; word-spacing: .12em; line-height: 1.95 !important; }
    body.dyslexia-mode * { font-family: 'Comic Sans MS', 'Trebuchet MS', cursive !important; }
    body.dyslexia-mode p, body.dyslexia-mode li { font-size: 1.05em; }
    @media (max-width:575px) {
      .btn-dyslexia-float { left: 10px; bottom: 52px; font-size: .7rem; padding: .48rem .85rem; }
    }

    /* ============================================================
       SPLASH SCREEN
    ============================================================ */
    #splashScreen {
      animation: splashAutoHide 3s 2.8s forwards;
      position: fixed;
      inset: 0;
      z-index: 9999;
      display: flex;
      align-items: center;
      justify-content: center;
      background: var(--cami-azul);
      overflow: hidden;
      transition: opacity .6s ease, transform .6s ease;
    }
    #splashScreen.hidden {
      opacity: 0;
      transform: scale(1.04);
      pointer-events: none;
    }
    .splash-bg {
      position: absolute;
      inset: 0;
      overflow: hidden;
    }
    .splash-circle {
      position: absolute;
      border-radius: 50%;
      opacity: .18;
    }
    .splash-c1 {
      width: 500px; height: 500px;
      background: var(--cami-turq);
      top: -120px; right: -100px;
      animation: splashPulse 3s ease-in-out infinite alternate;
    }
    .splash-c2 {
      width: 350px; height: 350px;
      background: var(--cami-coral);
      bottom: -80px; left: -80px;
      animation: splashPulse 4s ease-in-out infinite alternate-reverse;
    }
    .splash-c3 {
      width: 200px; height: 200px;
      background: var(--cami-amarillo);
      top: 50%; left: 50%;
      transform: translate(-50%,-50%);
      opacity: .1;
      animation: splashPulse 2.5s ease-in-out infinite alternate;
    }
    .splash-dots {
      position: absolute;
      inset: 0;
      display: grid;
      grid-template-columns: repeat(6, 1fr);
      gap: 60px;
      padding: 40px;
      opacity: .12;
    }
    .splash-dot {
      width: 8px; height: 8px;
      border-radius: 50%;
      background: white;
      align-self: center;
      justify-self: center;
    }
    @keyframes splashPulse {
      from { transform: scale(1) rotate(0deg); opacity: .15; }
      to   { transform: scale(1.1) rotate(8deg); opacity: .22; }
    }
    .splash-content {
      position: relative;
      z-index: 1;
      text-align: center;
      display: flex;
      flex-direction: column;
      align-items: center;
      gap: 1.2rem;
    }
    .splash-logo {
      height: 90px;
      width: auto;
      object-fit: contain;
      filter: brightness(0) invert(1);
      animation: splashLogoIn .8s cubic-bezier(.34,1.56,.64,1) both;
    }
    @keyframes splashLogoIn {
      from { opacity: 0; transform: scale(.6) translateY(20px); }
      to   { opacity: 1; transform: scale(1) translateY(0); }
    }
    .splash-tagline {
      font-family: var(--font-kranky);
      font-size: clamp(1.6rem, 5vw, 2.6rem);
      color: white;
      margin: 0;
      letter-spacing: .02em;
      animation: splashFadeUp .7s .3s ease both;
    }
    .splash-bar {
      width: 200px;
      height: 4px;
      background: rgba(255,255,255,.2);
      border-radius: 4px;
      overflow: hidden;
      animation: splashFadeUp .5s .5s ease both;
    }
    .splash-progress {
      height: 100%;
      background: var(--cami-turq);
      border-radius: 4px;
      width: 0%;
      transition: width .1s linear;
    }
    @keyframes splashAutoHide {
      from { opacity: 1; pointer-events: auto; }
      to   { opacity: 0; pointer-events: none; }
    }
    @keyframes splashFadeUp {
      from { opacity: 0; transform: translateY(12px); }
      to   { opacity: 1; transform: translateY(0); }
    }
    @media (max-width:575px) {
      .splash-logo { height: 70px; }
      .splash-dots { grid-template-columns: repeat(4, 1fr); gap: 40px; }
    }
    @media (max-width:359px) {
      .splash-dots { display: none; }
    }

    /* ---- MOBILE MENU — hamburguesa ---- */
    /* Bootstrap d-none d-lg-flex oculta el nav en <992px
       Añadimos un botón hamburguesa custom */
    .nav-mobile-toggle {
      display: none;
      background: none;
      border: 2px solid var(--cami-azul);
      border-radius: 8px;
      padding: .35rem .6rem;
      cursor: pointer;
      color: var(--cami-azul);
      font-size: 1.2rem;
      line-height: 1;
    }
    @media (max-width:991px) {
      .nav-mobile-toggle { display: flex; align-items: center; }
    }
    .nav-mobile-menu {
      display: none;
      flex-direction: column;
      background: var(--cami-bg);
      border-top: 2px solid var(--cami-border);
      padding: 1rem 1.5rem 1.2rem;
      gap: .2rem;
    }
    .nav-mobile-menu.open { display: flex; }
    .nav-mobile-menu .nav-link-cami {
      font-size: .92rem;
      padding: .6rem .4rem;
      border-bottom: 1px solid var(--cami-border);
    }
    .nav-mobile-menu .nav-link-cami:last-child { border-bottom: none; }
    /* Search en mobile menu */
    .nav-mobile-menu .input-search-cami { width: 100% !important; margin-top: .6rem; }
  </style>
</head>
<body>
<noscript><div style="background:#F2677C;color:white;text-align:center;padding:1rem;font-weight:700;">Esta página requiere JavaScript para funcionar correctamente.</div></noscript>

<!-- NAVBAR -->
<nav class="navbar-cami">
  <div class="container d-flex align-items-center justify-content-between flex-wrap gap-2">
    <a class="navbar-brand-cami" href="#inicio">
      <img src="<?= BASE_URL ?>/public/css/logo_poderdown.png" alt="Poder Down by María Camila González Torres" class="logo-poderdown">
    </a>
    <div class="d-none d-lg-flex align-items-center gap-3">
      <a class="nav-link-cami" href="#inicio">Inicio</a>
      <a class="nav-link-cami" href="#sobre-mi">Sobre mí</a>
      <a class="nav-link-cami" href="<?= BASE_URL ?>/public/productos.php">Productos</a>
      <a class="nav-link-cami" href="#galeria">Galería permanente</a>
      <a class="nav-link-cami" href="#blog">Blog</a>
      <a class="nav-link-cami" href="#contacto">Contacto</a>
    </div>
    <div class="d-flex align-items-center gap-2">
      <input type="text" id="searchNavbar" class="form-control input-search-cami d-none d-md-block"
             style="width:210px;padding:.45rem 1rem!important;font-size:.82rem!important;"
             placeholder="¿Qué buscas?"
             onkeydown="if(event.key==='Enter'){buscarProductos()}">
      <button class="btn-carrito" onclick="verCarrito()">
        <i class="bi bi-bag-heart"></i>
        <span class="badge-carrito" id="contadorCarrito">0</span>
      </button>
      <!-- Hamburguesa mobile -->
      <button class="nav-mobile-toggle" onclick="toggleMobileMenu()" aria-label="Menú">
        <i class="bi bi-list" id="hamburger-icon"></i>
      </button>
    </div>
  </div>
  <!-- Menú desplegable mobile -->
  <div class="nav-mobile-menu" id="navMobileMenu">
    <a class="nav-link-cami" href="#inicio"      onclick="closeMobileMenu()">Inicio</a>
    <a class="nav-link-cami" href="#sobre-mi"    onclick="closeMobileMenu()">Sobre mí</a>
    <a class="nav-link-cami" href="<?= BASE_URL ?>/public/productos.php" onclick="closeMobileMenu()">Productos</a>
    <a class="nav-link-cami" href="#galeria"     onclick="closeMobileMenu()">Galería permanente</a>
    <a class="nav-link-cami" href="#blog"        onclick="closeMobileMenu()">Blog</a>
    <a class="nav-link-cami" href="#contacto"    onclick="closeMobileMenu()">Contacto</a>
    <input type="text" class="form-control input-search-cami mt-2"
           placeholder="¿Qué producto o servicio buscas?"
           onkeydown="if(event.key==='Enter'){buscarProductos();closeMobileMenu()}">
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
      ['#3CAEE0','Inclusión real'],['#F2677C','Arte único'],['#F5C518','Charlas testimoniales'],
      ['#3CAEE0','Síndrome de Down'],['#F2677C','Neuroplasticidad'],['#F5C518','Poder Down'],
      ['#3CAEE0','Bachillerato'],['#F2677C','UdeA UIncluye'],['#F5C518','Speaker internacional'],
      ['#3CAEE0','13.000 personas'],['#F2677C','60+ empresas'],['#F5C518','Coloreando mi vida'],
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
          <a href="<?= BASE_URL ?>/public/productos.php" class="btn-p2 mt-3" style="font-size:.8rem;padding:.5rem 1.2rem;">Ver tienda →</a>
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
      <a href="<?= BASE_URL ?>/public/productos.php" class="btn-p1"><i class="bi bi-shop"></i>Explorar tienda</a>
      <a href="#galeria"  class="btn-p2"><i class="bi bi-easel2"></i>Ver galería</a>
      <a href="#contacto" class="btn-p-coral"><i class="bi bi-mic"></i>Invitación a participar</a>
      <a href="#blog"     class="btn-p2"><i class="bi bi-journal-richtext"></i>Descubre mi blog</a>
    </div>
  </div>
</section>

<!-- CATÁLOGO — PREVIEW HERO HACIA SUBPÁGINA -->
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
      <a href="<?= BASE_URL ?>/public/productos.php" class="btn-p1" style="font-size:1rem;padding:.85rem 2.2rem;">
        <i class="bi bi-shop"></i> Ver toda la tienda
      </a>
      <p style="margin-top:1rem;font-size:.8rem;opacity:.5;">+productos disponibles con envío a toda Colombia</p>
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

<!-- ============================================================ SECCIÓN ALIADOS — CARRUSEL CON LOGOS REALES ============================================================ -->
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
          [
            'nombre' => 'La Casa de Carlota',
            'url'    => 'https://lacasadecarlota.com',
            'svg'    => '<svg viewBox="0 0 160 70" xmlns="http://www.w3.org/2000/svg"><rect width="160" height="70" rx="8" fill="#FFF0F5"/><path d="M20 50 L20 28 L35 20 L50 28 L50 50 Z" fill="#E91E8C" opacity="0.9"/><rect x="27" y="38" width="16" height="12" fill="white"/><text x="60" y="36" font-family="Arial,sans-serif" font-weight="700" font-size="11" fill="#C2185B">La Casa</text><text x="60" y="50" font-family="Arial,sans-serif" font-weight="700" font-size="11" fill="#C2185B">de Carlota</text></svg>',
          ],
          [
            'nombre' => 'Comfama',
            'url'    => 'https://comfama.com.co',
            'svg'    => '<svg viewBox="0 0 160 70" xmlns="http://www.w3.org/2000/svg"><rect width="160" height="70" rx="8" fill="#fff"/><circle cx="30" cy="35" r="18" fill="#E91E8C"/><circle cx="30" cy="35" r="11" fill="white"/><circle cx="30" cy="35" r="6" fill="#E91E8C"/><text x="56" y="31" font-family="Arial,sans-serif" font-weight="900" font-size="18" fill="#E91E8C">comfama</text><text x="58" y="47" font-family="Arial,sans-serif" font-size="8" fill="#666" letter-spacing="1">CAJA DE COMPENSACIÓN</text></svg>',
          ],
          [
            'nombre' => 'SENA',
            'url'    => 'https://www.sena.edu.co',
            'svg'    => '<svg viewBox="0 0 160 70" xmlns="http://www.w3.org/2000/svg"><rect width="160" height="70" rx="8" fill="#fff"/><polygon points="22,55 22,25 38,15 54,25 54,55" fill="#007A3D"/><circle cx="38" cy="33" r="7" fill="white"/><circle cx="38" cy="33" r="3" fill="#007A3D"/><line x1="31" y1="33" x2="45" y2="33" stroke="white" stroke-width="1.5"/><line x1="38" y1="26" x2="38" y2="40" stroke="white" stroke-width="1.5"/><text x="62" y="30" font-family="Arial Black,Arial,sans-serif" font-weight="900" font-size="20" fill="#007A3D">SENA</text><text x="62" y="46" font-family="Arial,sans-serif" font-size="7" fill="#555" letter-spacing="0.5">Servicio Nacional de Aprendizaje</text></svg>',
          ],
          [
            'nombre' => 'Universidad San Martín',
            'url'    => 'https://www.sanmartin.edu.co',
            'svg'    => '<svg viewBox="0 0 160 70" xmlns="http://www.w3.org/2000/svg"><rect width="160" height="70" rx="8" fill="#fff"/><circle cx="30" cy="35" r="18" fill="#8B1A1A" opacity="0.9"/><text x="30" y="40" text-anchor="middle" font-family="Times New Roman,serif" font-weight="700" font-size="14" fill="white">USM</text><text x="56" y="26" font-family="Arial,sans-serif" font-weight="700" font-size="9" fill="#8B1A1A">UNIVERSIDAD</text><text x="56" y="38" font-family="Arial,sans-serif" font-weight="900" font-size="11" fill="#8B1A1A">SAN MARTÍN</text><text x="56" y="50" font-family="Arial,sans-serif" font-size="8" fill="#999">Colombia</text></svg>',
          ],
          [
            'nombre' => 'Colegio San Ignacio',
            'url'    => 'https://www.sanignacio.edu.co',
            'svg'    => '<svg viewBox="0 0 160 70" xmlns="http://www.w3.org/2000/svg"><rect width="160" height="70" rx="8" fill="#fff"/><rect x="14" y="17" width="32" height="36" rx="3" fill="#003087"/><text x="30" y="29" text-anchor="middle" font-family="Times New Roman,serif" font-weight="700" font-size="9" fill="white">IHS</text><line x1="18" y1="33" x2="42" y2="33" stroke="#C5A028" stroke-width="1"/><text x="30" y="45" text-anchor="middle" font-family="Arial,sans-serif" font-size="7" fill="white">Jesuitas</text><text x="55" y="26" font-family="Arial,sans-serif" font-weight="700" font-size="9" fill="#003087">COLEGIO</text><text x="55" y="38" font-family="Arial,sans-serif" font-weight="900" font-size="10" fill="#003087">SAN IGNACIO</text><text x="55" y="50" font-family="Arial,sans-serif" font-size="8" fill="#999">de Loyola</text></svg>',
          ],
          [
            'nombre' => 'Universidad María Cano',
            'url'    => 'https://www.mariacano.edu.co',
            'svg'    => '<svg viewBox="0 0 160 70" xmlns="http://www.w3.org/2000/svg"><rect width="160" height="70" rx="8" fill="#fff"/><circle cx="28" cy="35" r="18" fill="#1B5E20"/><path d="M20 35 Q28 22 36 35 Q28 48 20 35Z" fill="#C5A028" opacity="0.9"/><text x="28" y="39" text-anchor="middle" font-family="Arial,sans-serif" font-weight="700" font-size="9" fill="white">UMC</text><text x="54" y="25" font-family="Arial,sans-serif" font-weight="700" font-size="8" fill="#1B5E20">UNIVERSIDAD</text><text x="54" y="37" font-family="Arial,sans-serif" font-weight="900" font-size="10" fill="#1B5E20">MARÍA CANO</text><text x="54" y="50" font-family="Arial,sans-serif" font-size="7.5" fill="#666">Medellín, Colombia</text></svg>',
          ],
          [
            'nombre' => 'UdeA',
            'url'    => 'https://www.udea.edu.co',
            'svg'    => '<svg viewBox="0 0 160 70" xmlns="http://www.w3.org/2000/svg"><rect width="160" height="70" rx="8" fill="#fff"/><circle cx="28" cy="35" r="18" fill="#006633"/><circle cx="28" cy="35" r="14" fill="none" stroke="#C5A028" stroke-width="1.5"/><text x="28" y="40" text-anchor="middle" font-family="Times New Roman,serif" font-weight="700" font-size="13" fill="white">U</text><text x="54" y="24" font-family="Arial,sans-serif" font-weight="700" font-size="8" fill="#006633">UNIVERSIDAD</text><text x="54" y="36" font-family="Arial,sans-serif" font-weight="900" font-size="12" fill="#006633">de Antioquia</text><text x="54" y="50" font-family="Arial,sans-serif" font-size="8" fill="#888">Alma Máter</text></svg>',
          ],
          [
            'nombre' => 'Lupines',
            'url'    => '#',
            'svg'    => '<svg viewBox="0 0 160 70" xmlns="http://www.w3.org/2000/svg"><rect width="160" height="70" rx="8" fill="#FFF8F0"/><circle cx="22" cy="25" r="7" fill="#9C27B0" opacity="0.8"/><circle cx="35" cy="22" r="7" fill="#E91E8C" opacity="0.8"/><circle cx="48" cy="25" r="7" fill="#FF9800" opacity="0.8"/><path d="M25 32 Q35 52 45 32" fill="#4CAF50" opacity="0.7"/><text x="58" y="33" font-family="Arial,sans-serif" font-weight="700" font-size="16" fill="#9C27B0">Lupines</text><text x="60" y="47" font-family="Arial,sans-serif" font-size="8" fill="#888">Fundación</text></svg>',
          ],
          [
            'nombre' => 'Artesas',
            'url'    => '#',
            'svg'    => '<svg viewBox="0 0 160 70" xmlns="http://www.w3.org/2000/svg"><rect width="160" height="70" rx="8" fill="#FFFBF0"/><rect x="14" y="14" width="40" height="40" rx="4" fill="none" stroke="#C77800" stroke-width="2"/><path d="M20 44 Q34 20 48 44" fill="none" stroke="#C77800" stroke-width="2.5"/><circle cx="34" cy="26" r="4" fill="#C77800" opacity="0.7"/><text x="62" y="33" font-family="Georgia,serif" font-weight="700" font-size="16" fill="#8B5A00">Artesas</text><text x="62" y="48" font-family="Arial,sans-serif" font-size="8" fill="#AAA">Arte e inclusión</text></svg>',
          ],
          [
            'nombre' => 'Sin Etiquetas',
            'url'    => '#',
            'svg'    => '<svg viewBox="0 0 160 70" xmlns="http://www.w3.org/2000/svg"><rect width="160" height="70" rx="8" fill="#F5FFF8"/><circle cx="35" cy="35" r="18" fill="none" stroke="#2196F3" stroke-width="2.5"/><line x1="22" y1="22" x2="48" y2="48" stroke="#F44336" stroke-width="3" stroke-linecap="round"/><text x="60" y="28" font-family="Arial,sans-serif" font-weight="700" font-size="10" fill="#1976D2">Sin</text><text x="60" y="42" font-family="Arial,sans-serif" font-weight="700" font-size="10" fill="#1976D2">Etiquetas</text><text x="60" y="54" font-family="Arial,sans-serif" font-size="7.5" fill="#888">Fundación</text></svg>',
          ],
          [
            'nombre' => 'DiversoLab',
            'url'    => '#',
            'svg'    => '<svg viewBox="0 0 160 70" xmlns="http://www.w3.org/2000/svg"><rect width="160" height="70" rx="8" fill="#F8F0FF"/><rect x="14" y="20" width="12" height="30" rx="3" fill="#9C27B0"/><rect x="30" y="28" width="12" height="22" rx="3" fill="#3F51B5"/><rect x="46" y="24" width="12" height="26" rx="3" fill="#00BCD4"/><text x="66" y="29" font-family="Arial,sans-serif" font-weight="900" font-size="13" fill="#6A0DAD">Diverso</text><text x="66" y="44" font-family="Arial,sans-serif" font-weight="900" font-size="13" fill="#00BCD4">Lab</text><text x="66" y="56" font-family="Arial,sans-serif" font-size="7.5" fill="#888">Inclusión laboral</text></svg>',
          ],
          [
            'nombre' => 'Municipio de Medellín',
            'url'    => 'https://www.medellin.gov.co',
            'svg'    => '<svg viewBox="0 0 160 70" xmlns="http://www.w3.org/2000/svg"><rect width="160" height="70" rx="8" fill="#fff"/><circle cx="28" cy="35" r="18" fill="#00703C"/><path d="M20 40 L28 22 L36 40 Z" fill="white" opacity="0.9"/><rect x="24" y="38" width="8" height="6" fill="#00703C"/><text x="54" y="24" font-family="Arial,sans-serif" font-weight="700" font-size="8" fill="#00703C">MUNICIPIO DE</text><text x="54" y="37" font-family="Arial,sans-serif" font-weight="900" font-size="12" fill="#00703C">Medellín</text><text x="54" y="50" font-family="Arial,sans-serif" font-size="8" fill="#999">Alcaldía</text></svg>',
          ],
          [
            'nombre' => 'Crear Unidos',
            'url'    => '#',
            'svg'    => '<svg viewBox="0 0 160 70" xmlns="http://www.w3.org/2000/svg"><rect width="160" height="70" rx="8" fill="#FFF5F0"/><circle cx="22" cy="35" r="10" fill="#FF7043" opacity="0.9"/><circle cx="38" cy="35" r="10" fill="#FFA726" opacity="0.9"/><circle cx="30" cy="28" r="10" fill="#EF5350" opacity="0.85"/><text x="56" y="30" font-family="Arial,sans-serif" font-weight="700" font-size="12" fill="#D84315">Crear</text><text x="56" y="46" font-family="Arial,sans-serif" font-weight="700" font-size="12" fill="#E65100">Unidos</text><text x="56" y="57" font-family="Arial,sans-serif" font-size="7" fill="#AAA">Corporación</text></svg>',
          ],
        ];
        // Duplicar para loop infinito
        $todos = array_merge($aliados_logos, $aliados_logos);
        foreach ($todos as $al):
          $href = htmlspecialchars($al['url'], ENT_QUOTES, 'UTF-8');
          $name = htmlspecialchars($al['nombre'], ENT_QUOTES, 'UTF-8');
        ?>
        <a href="<?= $href ?>" target="<?= $al['url'] !== '#' ? '_blank' : '_self' ?>" rel="noopener noreferrer"
           class="aliado-logo-card" aria-label="<?= $name ?>" title="<?= $name ?>">
          <?= $al['svg'] ?>
        </a>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
</section>

<!-- ============================================================ BLOQUE 8: FOOTER ============================================================ -->
<?php require_once __DIR__ . '/footer.php'; ?>

<!-- ============================================================ REDES SOCIALES FLOTANTES ============================================================ -->
<div class="fab-social-wrap" id="fabSocialWrap">
  <button class="fab-toggle-btn" id="fabToggleBtn" onclick="toggleFabSocial()" title="Seguir en redes">
    <i class="bi bi-share-fill" id="fabIconMain"></i>
  </button>
  <div class="fab-social-links" id="fabSocialLinks">
    <a href="https://www.instagram.com/diaadiaconcami" target="_blank" rel="noopener" class="fab-soc fab-ig" title="Instagram">
      <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg>
    </a>
    <a href="https://www.tiktok.com/@diaadiaconcami" target="_blank" rel="noopener" class="fab-soc fab-tk" title="TikTok">
      <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M19.59 6.69a4.83 4.83 0 01-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 01-2.88 2.5 2.89 2.89 0 01-2.89-2.89 2.89 2.89 0 012.89-2.89c.28 0 .54.04.79.1V9.01a6.33 6.33 0 00-.79-.05 6.34 6.34 0 00-6.34 6.34 6.34 6.34 0 006.34 6.34 6.34 6.34 0 006.33-6.34V8.69a8.18 8.18 0 004.78 1.52V6.77a4.85 4.85 0 01-1.01-.08z"/></svg>
    </a>
    <a href="https://www.facebook.com/poderdown" target="_blank" rel="noopener" class="fab-soc fab-fb" title="Facebook">
      <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
    </a>
    <a href="https://www.youtube.com/@poderdown" target="_blank" rel="noopener" class="fab-soc fab-yt" title="YouTube">
      <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M23.498 6.186a3.016 3.016 0 00-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 00.502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 002.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 002.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
    </a>
    <a href="https://wa.me/573137468039" target="_blank" rel="noopener" class="fab-soc fab-wa" title="WhatsApp">
      <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
    </a>
  </div>
</div>

<!-- BOTÓN DISLEXIA -->
<button class="btn-dyslexia-float" id="btnDyslexiaFloat" onclick="toggleDyslexia()" title="Activar modo dislexia">
  <span class="dyslexia-icon">𝐀𝐚</span>
  <span id="dyslexiaLabelMain">Dislexia</span>
</button>

<!-- SPLASH LOADING -->
<div id="splashScreen">
  <div class="splash-bg">
    <div class="splash-circle splash-c1"></div>
    <div class="splash-circle splash-c2"></div>
    <div class="splash-circle splash-c3"></div>
    <div class="splash-dots">
      <?php for($i=0;$i<12;$i++): ?><div class="splash-dot"></div><?php endfor; ?>
    </div>
  </div>
  <div class="splash-content">
    <img src="<?= BASE_URL ?>/public/css/logo_poderdown.png" alt="Poder Down" class="splash-logo">
    <div class="splash-bar"><div class="splash-progress" id="splashProgress"></div></div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
const API_BASE    = '<?= API_URL ?>';
const LIMITE_GRID = 8;
let offsetActual = 0, categoriaActual = '', busquedaActual = '', carrito = [], fetchController = null;

function toggleFaq(i) {
  const a = document.getElementById('faq-a-'+i);
  const icon = document.getElementById('faq-icon-'+i);
  const open = a.classList.toggle('open');
  icon.classList.toggle('open', open);
}

async function iniciarLanding() {
  await cargarPreviewProductos();
}

async function cargarPreviewProductos() {
  try {
    const res  = await fetch(`${API_BASE}/productos.php?limite=4&offset=0`);
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
  } catch(e) {
    const grid = document.getElementById('tiendaPreviewGrid');
    if (grid) grid.innerHTML = '';
  }
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
          data-pid="${p.id}" data-nombre="${encodeURIComponent(p.nombre)}" data-precio="${p.precio}" onclick="agregarAlCarritoBtn(event,this)"
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
      title: `<span style="font-family:'Nunito','Gilroy',sans-serif">${p.nombre}</span>`,
      html: `<div style="font-family:'Archivo',sans-serif;text-align:left;">
        <span style="background:#3CAEE0;color:#1A3A5C;border-radius:50px;padding:.3rem .9rem;font-size:.73rem;font-weight:700;">${p.categoria}</span>
        <p style="margin-top:1rem;font-size:.88rem;opacity:.75;line-height:1.8;">${p.descripcion ?? 'Sin descripción.'}</p>
        <div style="display:flex;justify-content:space-between;align-items:center;margin-top:1rem;">
          <span style="font-family:'Nunito','Gilroy',sans-serif;font-size:1.9rem;color:#1A3A5C;">$${Number(p.precio).toLocaleString('es-CO',{minimumFractionDigits:0})}</span>
          <span style="background:${agotado?'#F2677C':'rgba(78,210,173,.18)'};color:${agotado?'white':'#1A3A5C'};border-radius:50px;padding:.35rem 1rem;font-size:.78rem;font-weight:700;">
            ${agotado?'😕 Sin stock':'✅ '+p.stock+' disponibles'}
          </span>
        </div></div>`,
      showCancelButton: true,
      confirmButtonText: agotado ? '🔔 Notificarme' : '🛍️ Agregar al carrito',
      cancelButtonText: 'Cerrar', confirmButtonColor: '#3CAEE0',
    }).then(r => { if(r.isConfirmed && !agotado) agregarAlCarritoDirecto(p.id, p.nombre, p.precio); });
  } catch(e) {}
}

function agregarAlCarrito(event, id, nombre, precio) { event.stopPropagation(); agregarAlCarritoDirecto(id, nombre, precio); }
function agregarAlCarritoBtn(event, el) {
  event.stopPropagation();
  const id     = parseInt(el.dataset.pid);
  const nombre = decodeURIComponent(el.dataset.nombre);
  const precio = parseFloat(el.dataset.precio);
  agregarAlCarritoDirecto(id, nombre, precio);
}
function agregarAlCarritoDirecto(id, nombre, precio) {
  const ex = carrito.find(i => i.id === id);
  if (ex) ex.cantidad++; else carrito.push({id, nombre, precio: Number(precio), cantidad: 1});
  actualizarContadorCarrito();
  Swal.fire({ toast:true, position:'bottom-end', icon:'success', title:`¡${nombre} agregado!`, showConfirmButton:false, timer:2200, timerProgressBar:true, background:'#ebeae4', color:'#1A3A5C' });
}
function verCarrito() {
  if (!carrito.length) {
    Swal.fire({ title:`<span style="font-family:'Nunito','Gilroy',sans-serif">Carrito vacío 🛍️</span>`, html:`<p style="font-family:'Archivo',sans-serif">Agrega productos desde el catálogo.</p>`, confirmButtonColor:'#3CAEE0', confirmButtonText:'Ver catálogo' })
      .then(r => { if(r.isConfirmed) document.getElementById('catalogo').scrollIntoView({behavior:'smooth'}); });
    return;
  }
  const ti = carrito.reduce((a,i) => a+i.cantidad, 0);
  const tp = carrito.reduce((a,i) => a+i.precio*i.cantidad, 0);
  Swal.fire({
    title:`<span style="font-family:'Nunito','Gilroy',sans-serif">Mi carrito 🛍️</span>`,
    html:`<div style="text-align:left;font-family:'Archivo',sans-serif;">
      ${carrito.map(i=>`
        <div style="display:flex;justify-content:space-between;align-items:center;padding:.55rem 0;border-bottom:1px solid #ebeae4;gap:.5rem;">
          <span style="font-size:.88rem;flex:1;">${i.nombre.replace(/</g,"&lt;").replace(/>/g,"&gt;")}</span>
          <div style="display:flex;align-items:center;gap:.4rem;flex-shrink:0;">
            <button onclick="cambiarCantidad(${i.id},-1)" style="background:#ebeae4;border:none;border-radius:50%;width:26px;height:26px;cursor:pointer;font-size:.9rem;display:flex;align-items:center;justify-content:center;">−</button>
            <span style="background:#3CAEE0;color:#1A3A5C;border-radius:50px;padding:.2rem .7rem;font-size:.75rem;font-weight:700;min-width:30px;text-align:center;" id="qty-${i.id}">×${i.cantidad}</span>
            <button onclick="cambiarCantidad(${i.id},+1)" style="background:#3CAEE0;border:none;border-radius:50%;width:26px;height:26px;cursor:pointer;font-size:.9rem;color:#1A3A5C;display:flex;align-items:center;justify-content:center;">+</button>
            <button onclick="quitarItem(${i.id})" style="background:rgba(228,91,99,.15);border:none;border-radius:50%;width:26px;height:26px;cursor:pointer;font-size:.8rem;color:#F2677C;display:flex;align-items:center;justify-content:center;">✕</button>
          </div>
        </div>`).join('')}
      <div style="display:flex;justify-content:space-between;margin-top:1rem;font-weight:700;padding-top:.5rem;border-top:2px solid #ebeae4;">
        <span>${ti} artículo${ti!==1?'s':''}</span>
        <span style="color:#1A3A5C;font-family:'Nunito','Gilroy',sans-serif;font-size:1.1rem;" id="totalCarritoDisplay">$${tp.toLocaleString('es-CO',{minimumFractionDigits:0})}</span>
      </div></div>`,
    confirmButtonText:'🛒 Finalizar compra', showCancelButton:true, cancelButtonText:'Seguir comprando', confirmButtonColor:'#3CAEE0',
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
    title: `<span style="font-family:'Nunito','Gilroy',sans-serif">Datos de envío</span>`,
    html: `
    <div style="text-align:left;font-family:'Archivo',sans-serif;display:flex;flex-direction:column;gap:.8rem;">
      <p style="font-size:.82rem;opacity:.6;margin:0;">Total a pagar: <strong style="color:#1A3A5C;font-size:1rem;">$${tp.toLocaleString('es-CO',{minimumFractionDigits:0})}</strong></p>
      <div>
        <label style="font-size:.8rem;font-weight:700;color:#1A3A5C;">Nombre completo *</label>
        <input id="chkNombre" type="text" placeholder="Tu nombre completo" style="width:100%;padding:.6rem .9rem;border:2px solid #d6d4cc;border-radius:12px;font-family:'Archivo',sans-serif;font-size:.88rem;margin-top:.3rem;outline:none;box-sizing:border-box;">
      </div>
      <div>
        <label style="font-size:.8rem;font-weight:700;color:#1A3A5C;">Email *</label>
        <input id="chkEmail" type="email" placeholder="tu@correo.com" style="width:100%;padding:.6rem .9rem;border:2px solid #d6d4cc;border-radius:12px;font-family:'Archivo',sans-serif;font-size:.88rem;margin-top:.3rem;outline:none;box-sizing:border-box;">
      </div>
      <div>
        <label style="font-size:.8rem;font-weight:700;color:#1A3A5C;">WhatsApp / Teléfono *</label>
        <input id="chkTelefono" type="tel" placeholder="313 746 8039" style="width:100%;padding:.6rem .9rem;border:2px solid #d6d4cc;border-radius:12px;font-family:'Archivo',sans-serif;font-size:.88rem;margin-top:.3rem;outline:none;box-sizing:border-box;">
      </div>
      <div style="display:grid;grid-template-columns:1fr 1fr;gap:.6rem;">
        <div>
          <label style="font-size:.8rem;font-weight:700;color:#1A3A5C;">Ciudad *</label>
          <input id="chkCiudad" type="text" placeholder="Medellín" style="width:100%;padding:.6rem .9rem;border:2px solid #d6d4cc;border-radius:12px;font-family:'Archivo',sans-serif;font-size:.88rem;margin-top:.3rem;outline:none;box-sizing:border-box;">
        </div>
        <div>
          <label style="font-size:.8rem;font-weight:700;color:#1A3A5C;">Dirección *</label>
          <input id="chkDireccion" type="text" placeholder="Cra 10 #20-30" style="width:100%;padding:.6rem .9rem;border:2px solid #d6d4cc;border-radius:12px;font-family:'Archivo',sans-serif;font-size:.88rem;margin-top:.3rem;outline:none;box-sizing:border-box;">
        </div>
      </div>
      <div>
        <label style="font-size:.8rem;font-weight:700;color:#1A3A5C;">Notas adicionales (opcional)</label>
        <textarea id="chkNotas" placeholder="Apartamento, instrucciones de entrega..." rows="2" style="width:100%;padding:.6rem .9rem;border:2px solid #d6d4cc;border-radius:12px;font-family:'Archivo',sans-serif;font-size:.88rem;margin-top:.3rem;outline:none;resize:none;box-sizing:border-box;"></textarea>
      </div>
      <p style="font-size:.73rem;color:#aaa;margin:0;">📦 Sin registro. Recibirás confirmación por email. Envíos a toda Colombia.</p>
    </div>`,
    confirmButtonText: '✅ Confirmar pedido',
    showCancelButton: true,
    cancelButtonText: '← Volver al carrito',
    confirmButtonColor: '#3CAEE0',
    width: 520,
    preConfirm: () => {
      const nombre   = (document.getElementById('chkNombre')?.value?.trim()   || '').substring(0,120);
      const email    = (document.getElementById('chkEmail')?.value?.trim()    || '').substring(0,120);
      const telefono = (document.getElementById('chkTelefono')?.value?.trim() || '').substring(0,30);
      const ciudad   = (document.getElementById('chkCiudad')?.value?.trim()   || '').substring(0,100);
      const dir      = (document.getElementById('chkDireccion')?.value?.trim()|| '').substring(0,200);
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
      title: `<span style="font-family:'Nunito','Gilroy',sans-serif;color:#1A3A5C">¡Pedido confirmado! 🎉</span>`,
      html: `<div style="font-family:'Archivo',sans-serif;text-align:left;">
        <div style="background:rgba(78,210,173,.15);border-radius:12px;padding:1rem;margin-bottom:1rem;text-align:center;">
          <p style="font-family:'Nunito','Gilroy',sans-serif;font-size:1.4rem;color:#1A3A5C;margin:0;">Código: <strong style="color:#3CAEE0;">${pedido.codigo}</strong></p>
          <p style="font-size:.8rem;opacity:.6;margin:.3rem 0 0;">Guarda este código para rastrear tu pedido</p>
        </div>
        <p style="font-size:.88rem;line-height:1.7;margin:0;">
          ✅ Tu pedido ha sido recibido correctamente.<br>
          📧 Te contactaremos a <strong>${datosCliente.email}</strong> con los detalles.<br>
          📦 Envío a: ${datosCliente.ciudad} — ${datosCliente.direccion}<br>
          📞 Si tienes preguntas: <a href="https://wa.me/573137468039" style="color:#3CAEE0;">313 746 8039</a>
        </p>
      </div>`,
      confirmButtonText: '🏠 Volver a la tienda',
      confirmButtonColor: '#3CAEE0',
      allowOutsideClick: false,
    }).then(() => {
      cargarPreviewProductos(); // Refresca preview
    });
  } catch(e) {
    Swal.fire({ icon:'error', title:'Error al procesar', text: e.message || 'Intenta de nuevo o escríbenos por WhatsApp.', confirmButtonColor:'#3CAEE0' });
  }
}
function actualizarContadorCarrito() {
  document.getElementById('contadorCarrito').textContent = carrito.reduce((a,i)=>a+i.cantidad,0);
}

['searchLanding','searchNavbar'].forEach(id => {
  document.getElementById(id)?.addEventListener('keydown', e => { if(e.key==='Enter') buscarProductos(); });
});

/* ---- Mobile menu ---- */
function toggleMobileMenu() {
  const menu = document.getElementById('navMobileMenu');
  const icon = document.getElementById('hamburger-icon');
  const open = menu.classList.toggle('open');
  icon.className = open ? 'bi bi-x-lg' : 'bi bi-list';
}
function closeMobileMenu() {
  document.getElementById('navMobileMenu').classList.remove('open');
  document.getElementById('hamburger-icon').className = 'bi bi-list';
}
// Cerrar menú al hacer scroll
window.addEventListener('scroll', () => {
  if (document.getElementById('navMobileMenu').classList.contains('open')) closeMobileMenu();
}, { passive: true });

/* ============================================================
   REDES SOCIALES FLOTANTES
============================================================ */
function toggleFabSocial() {
  const links = document.getElementById('fabSocialLinks');
  const icon  = document.getElementById('fabIconMain');
  links.classList.toggle('open');
  icon.className = links.classList.contains('open') ? 'bi bi-x-lg' : 'bi bi-share-fill';
}
// Close on outside click
document.addEventListener('click', (e) => {
  const wrap = document.getElementById('fabSocialWrap');
  if (wrap && !wrap.contains(e.target)) {
    document.getElementById('fabSocialLinks').classList.remove('open');
    document.getElementById('fabIconMain').className = 'bi bi-share-fill';
  }
});

/* ============================================================
   MODO DISLEXIA
============================================================ */
let dyslexiaOn = localStorage.getItem('pd_dyslexia') === '1';
function applyDyslexia() {
  document.body.classList.toggle('dyslexia-mode', dyslexiaOn);
  const label = document.getElementById('dyslexiaLabelMain');
  const btn   = document.getElementById('btnDyslexiaFloat');
  if (label) label.textContent = dyslexiaOn ? 'Normal' : 'Dislexia';
  if (btn) {
    btn.style.background = dyslexiaOn ? 'var(--cami-turq)' : 'var(--cami-azul)';
    btn.style.color      = dyslexiaOn ? 'var(--cami-azul)' : 'white';
  }
}
function toggleDyslexia() {
  dyslexiaOn = !dyslexiaOn;
  localStorage.setItem('pd_dyslexia', dyslexiaOn ? '1' : '0');
  applyDyslexia();
}
applyDyslexia();

/* ============================================================
   SPLASH SCREEN
============================================================ */
(function() {
  const splash   = document.getElementById('splashScreen');
  const progress = document.getElementById('splashProgress');
  if (!splash) return;

  let pct = 0;
  const tick = setInterval(() => {
    pct += Math.random() * 18 + 4;
    if (pct > 100) pct = 100;
    if (progress) progress.style.width = pct + '%';
    if (pct >= 100) {
      clearInterval(tick);
      setTimeout(() => {
        splash.classList.add('hidden');
        setTimeout(() => splash.remove(), 700);
      }, 250);
    }
  }, 80);

  // Fallback hard stop after 2.5s
  setTimeout(() => {
    clearInterval(tick);
    if (progress) progress.style.width = '100%';
    setTimeout(() => {
      splash.classList.add('hidden');
      setTimeout(() => splash.remove(), 700);
    }, 200);
  }, 2500);
})();

document.addEventListener('DOMContentLoaded', iniciarLanding);
</script>
</body>
</html>