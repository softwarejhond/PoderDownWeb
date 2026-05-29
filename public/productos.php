<?php
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
  <title>Tienda — Poder Down by María Camila González Torres</title>
  <meta name="description" content="Tienda oficial de Poder Down — Arte único de María Camila González Torres. Envíos a toda Colombia.">
  <meta property="og:title" content="Tienda Poder Down">
  <meta property="og:description" content="Lleva el arte y el mensaje de Cami contigo. Envíos a toda Colombia.">
  <meta property="og:type" content="website">
  <link rel="icon" type="image/png" href="<?= BASE_URL ?>/public/css/favicon_poderdown.png">
  <link rel="apple-touch-icon" href="<?= BASE_URL ?>/public/css/favicon_poderdown.png">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
  <link href="https://fonts.googleapis.com/css2?family=Archivo:ital,wght@0,400;0,500;0,600;0,700;0,800;0,900;1,400&family=Oregano:ital@0;1&family=Nunito:wght@700;800;900&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="<?= BASE_URL ?>/public/css/marca.css">
  <style>
    :root {
      --cami-bg: #ebeae4;
      --pd-azul: #3CAEE0; --cami-turq: #3CAEE0;
      --pd-coral: #F2677C; --cami-coral: #F2677C;
      --cami-amarillo: #F5C518;
      --pd-oscuro: #1A3A5C; --cami-azul: #1A3A5C;
      --cami-border: #d6d4cc;
      --font-gilroy:  'Nunito', 'Gilroy', sans-serif;
      --font-archivo: 'Archivo', sans-serif;
      --font-oregano: 'Oregano', cursive;
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
    .nav-link-cami.active { color: var(--cami-turq); border-bottom: 2px solid var(--cami-turq); }
    .badge-carrito { background: var(--cami-coral); color: white; border-radius: 50%; font-size: .65rem; width: 18px; height: 18px; display: inline-flex; align-items: center; justify-content: center; margin-left: -6px; margin-top: -10px; font-weight: 700; vertical-align: top; }

    /* BOTONES */
    .btn-p1 { background: var(--cami-turq); color: var(--cami-azul); border: none; border-radius: 50px; padding: .75rem 2rem; font-weight: 700; font-family: var(--font-playpen); font-size: .95rem; cursor: pointer; transition: all .2s; text-decoration: none; display: inline-flex; align-items: center; gap: .5rem; }
    .btn-p1:hover { background: #2d9ecf; transform: translateY(-2px); color: var(--cami-azul); }
    .btn-p2 { background: transparent; color: var(--cami-azul); border: 2px solid var(--cami-azul); border-radius: 50px; padding: .7rem 1.8rem; font-weight: 600; font-family: var(--font-playpen); font-size: .9rem; cursor: pointer; transition: all .2s; text-decoration: none; display: inline-flex; align-items: center; gap: .5rem; }
    .btn-p2:hover { background: var(--cami-azul); color: white; }
    .btn-carrito { background: var(--cami-azul); color: white; border: none; border-radius: 50px; padding: .5rem 1.4rem; font-weight: 700; font-family: var(--font-playpen); font-size: .88rem; cursor: pointer; transition: all .2s; display: inline-flex; align-items: center; gap: .4rem; }
    .btn-carrito:hover { background: #00254d; }

    /* PAGE HEADER */
    .page-header {
      background: var(--cami-azul);
      padding: 4rem 0 3rem;
      position: relative;
      overflow: hidden;
    }
    .page-header::before {
      content: '';
      position: absolute;
      top: -60px; right: -60px;
      width: 300px; height: 300px;
      background: rgba(60,174,224,.15);
      border-radius: 50%;
    }
    .page-header::after {
      content: '';
      position: absolute;
      bottom: -40px; left: 10%;
      width: 180px; height: 180px;
      background: rgba(242,103,124,.12);
      border-radius: 50%;
    }
    .page-header h1 { font-family: var(--font-kranky); color: white; font-size: clamp(2rem,5vw,3.5rem); margin: 0; }
    .page-header p { color: rgba(255,255,255,.7); font-size: 1rem; margin: .8rem 0 0; }
    .breadcrumb-cami { display: flex; gap: .5rem; align-items: center; margin-bottom: 1rem; font-size: .8rem; }
    .breadcrumb-cami a { color: var(--cami-turq); text-decoration: none; }
    .breadcrumb-cami a:hover { text-decoration: underline; }
    .breadcrumb-cami span { color: rgba(255,255,255,.45); }

    /* FILTROS */
    .filtro-bar { background: white; border-bottom: 2px solid var(--cami-border); padding: 1.2rem 0; position: sticky; top: 72px; z-index: 100; }
    .filtro-btn { background: var(--cami-bg); color: var(--cami-azul); border: 2px solid var(--cami-border); border-radius: 50px; padding: .45rem 1.2rem; font-family: var(--font-playpen); font-weight: 600; font-size: .82rem; cursor: pointer; transition: all .2s; white-space: nowrap; }
    .filtro-btn:hover, .filtro-btn.activo { background: var(--cami-turq); border-color: var(--cami-turq); color: var(--cami-azul); }
    .input-search-cami { border-radius: 50px !important; border: 2px solid var(--cami-border) !important; font-family: var(--font-playpen) !important; background: white !important; padding: .65rem 1.2rem !important; font-size: .9rem !important; }
    .input-search-cami:focus { border-color: var(--cami-turq) !important; box-shadow: 0 0 0 3px rgba(60,174,224,.2) !important; outline: none; }

    /* PRODUCT CARD */
    .product-card-cami { background: white; border-radius: 20px; overflow: hidden; cursor: pointer; transition: all .25s; height: 100%; }
    .product-card-cami:hover { transform: translateY(-6px); box-shadow: 0 20px 50px rgba(0,51,102,.12); }
    .product-card-cami .img-wrap { height: 200px; background: linear-gradient(135deg, rgba(60,174,224,.15), rgba(0,51,102,.05)); display: flex; align-items: center; justify-content: center; font-size: 4rem; position: relative; }
    .badge-cat { position: absolute; top: .8rem; left: .8rem; background: var(--cami-turq); color: var(--cami-azul); border-radius: 50px; padding: .25rem .8rem; font-size: .7rem; font-weight: 700; }
    .badge-agotado { position: absolute; top: .8rem; right: .8rem; background: var(--cami-coral); color: white; border-radius: 50px; padding: .25rem .8rem; font-size: .7rem; font-weight: 700; }
    .product-card-cami .card-body { padding: 1.3rem; }
    .product-name { font-family: var(--font-kranky); font-weight: 700; font-size: 1rem; margin: 0 0 .3rem; }
    .product-desc { font-size: .8rem; opacity: .6; margin: 0 0 .9rem; line-height: 1.5; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
    .product-footer { display: flex; justify-content: space-between; align-items: center; }
    .product-price { font-family: var(--font-kranky); font-size: 1.4rem; color: var(--cami-azul); }
    .btn-add-cami { background: var(--cami-azul); color: white; border: none; border-radius: 50%; width: 38px; height: 38px; display: flex; align-items: center; justify-content: center; font-size: 1.1rem; cursor: pointer; transition: all .2s; flex-shrink: 0; }
    .btn-add-cami:hover { background: var(--cami-turq); color: var(--cami-azul); transform: scale(1.1); }
    .btn-add-cami:disabled { background: #ccc; cursor: not-allowed; transform: none; }

    /* EMPTY STATE */
    .empty-state { text-align: center; padding: 5rem 2rem; }
    .empty-state i { font-size: 4rem; opacity: .2; display: block; margin-bottom: 1.2rem; }

    /* RESULTADO COUNT */
    .result-count { font-size: .85rem; opacity: .6; }

    /* HAMBURGUESA */
    .nav-mobile-toggle { display: none; background: none; border: 2px solid var(--cami-azul); border-radius: 8px; padding: .35rem .6rem; cursor: pointer; color: var(--cami-azul); font-size: 1.2rem; line-height: 1; }
    @media (max-width:991px) { .nav-mobile-toggle { display: flex; align-items: center; } }
    .nav-mobile-menu { display: none; flex-direction: column; background: var(--cami-bg); border-top: 2px solid var(--cami-border); padding: 1rem 1.5rem 1.2rem; gap: .2rem; }
    .nav-mobile-menu.open { display: flex; }
    .nav-mobile-menu .nav-link-cami { font-size: .92rem; padding: .6rem .4rem; border-bottom: 1px solid var(--cami-border); }
    .nav-mobile-menu .nav-link-cami:last-child { border-bottom: none; }

    /* RESPONSIVE */
    @media (max-width:575px) {
      .filtro-bar { top: 60px; }
      .navbar-brand-cami img { height: 34px; }
      .page-header { padding: 2.5rem 0 2rem; }
      .product-card-cami .img-wrap { height: 160px; }
      .product-name { font-size: .9rem; }
      .product-price { font-size: 1.2rem; }
    }

    /* FLOATING ELEMENTS (same as landing) */
    .fab-social { position:fixed; right:20px; bottom:80px; display:flex; flex-direction:column; gap:.6rem; z-index:999; }
    .fab-social a { width:44px; height:44px; border-radius:50%; display:flex; align-items:center; justify-content:center; color:white; text-decoration:none; font-size:1.1rem; transition:all .25s; box-shadow:0 4px 14px rgba(0,0,0,.2); }
    .fab-social a:hover { transform:scale(1.15) translateX(-4px); }
    .fab-ig  { background:#E1306C; }
    .fab-tk  { background:#000; }
    .fab-fb  { background:#1877F2; }
    .fab-yt  { background:#FF0000; }
    .fab-wa  { background:#25D366; }
    .fab-toggle { width:44px; height:44px; border-radius:50%; background:var(--cami-coral); color:white; border:none; cursor:pointer; font-size:1.1rem; display:flex; align-items:center; justify-content:center; box-shadow:0 4px 14px rgba(0,0,0,.25); transition:all .25s; }
    .fab-toggle:hover { transform:scale(1.1); }
    .fab-links { display:flex; flex-direction:column; gap:.6rem; overflow:hidden; max-height:0; transition:max-height .35s ease; }
    .fab-links.open { max-height:280px; }

    .btn-dyslexia { position:fixed; left:16px; bottom:80px; z-index:999; background:var(--cami-azul); color:white; border:none; border-radius:50px; padding:.55rem 1.1rem; font-family:var(--font-playpen); font-size:.78rem; font-weight:700; cursor:pointer; box-shadow:0 4px 14px rgba(0,0,0,.2); transition:all .25s; display:flex; align-items:center; gap:.4rem; }
    .btn-dyslexia:hover { background:var(--cami-turq); color:var(--cami-azul); transform:translateY(-2px); }
    body.dyslexia-mode { font-family:'OpenDyslexic', 'Comic Sans MS', cursive !important; letter-spacing:.05em; word-spacing:.1em; line-height:1.9 !important; }
    body.dyslexia-mode * { font-family:'OpenDyslexic', 'Comic Sans MS', cursive !important; letter-spacing:.05em; }
  </style>
</head>
<body>
<noscript><div style="background:#F2677C;color:white;text-align:center;padding:1rem;font-weight:700;">Esta página requiere JavaScript para funcionar correctamente.</div></noscript>

<!-- NAVBAR -->
<nav class="navbar-cami">
  <div class="container d-flex align-items-center justify-content-between flex-wrap gap-2">
    <a class="navbar-brand-cami" href="<?= BASE_URL ?>/public/landing.php">
      <img src="<?= BASE_URL ?>/public/css/logo_poderdown.png" alt="Poder Down">
    </a>
    <div class="d-none d-lg-flex align-items-center gap-3">
      <a class="nav-link-cami" href="<?= BASE_URL ?>/public/landing.php">Inicio</a>
      <a class="nav-link-cami" href="<?= BASE_URL ?>/public/landing.php#sobre-mi">Sobre mí</a>
      <a class="nav-link-cami active" href="<?= BASE_URL ?>/public/productos.php">Productos</a>
      <a class="nav-link-cami" href="<?= BASE_URL ?>/public/landing.php#galeria">Galería</a>
      <a class="nav-link-cami" href="<?= BASE_URL ?>/public/landing.php#blog">Blog</a>
      <a class="nav-link-cami" href="<?= BASE_URL ?>/public/landing.php#contacto">Contacto</a>
    </div>
    <div class="d-flex align-items-center gap-2">
      <button class="btn-carrito" onclick="verCarrito()">
        <i class="bi bi-bag-heart"></i>
        <span class="badge-carrito" id="contadorCarrito">0</span>
      </button>
      <button class="nav-mobile-toggle" onclick="toggleMobileMenu()" aria-label="Menú">
        <i class="bi bi-list" id="hamburger-icon"></i>
      </button>
    </div>
  </div>
  <div class="nav-mobile-menu" id="navMobileMenu">
    <a class="nav-link-cami" href="<?= BASE_URL ?>/public/landing.php" onclick="closeMobileMenu()">Inicio</a>
    <a class="nav-link-cami" href="<?= BASE_URL ?>/public/landing.php#sobre-mi" onclick="closeMobileMenu()">Sobre mí</a>
    <a class="nav-link-cami active" href="<?= BASE_URL ?>/public/productos.php" onclick="closeMobileMenu()">Productos</a>
    <a class="nav-link-cami" href="<?= BASE_URL ?>/public/landing.php#galeria" onclick="closeMobileMenu()">Galería</a>
    <a class="nav-link-cami" href="<?= BASE_URL ?>/public/landing.php#blog" onclick="closeMobileMenu()">Blog</a>
    <a class="nav-link-cami" href="<?= BASE_URL ?>/public/landing.php#contacto" onclick="closeMobileMenu()">Contacto</a>
  </div>
</nav>

<!-- PAGE HEADER -->
<div class="page-header">
  <div class="container position-relative" style="z-index:1;">
    <div class="breadcrumb-cami">
      <a href="<?= BASE_URL ?>/public/landing.php"><i class="bi bi-house-fill"></i> Inicio</a>
      <span>/</span>
      <span style="color:white;">Tienda</span>
    </div>
    <h1><i class="bi bi-bag-heart-fill me-2" style="color:var(--cami-turq);"></i>Tienda Poder Down</h1>
    <p>Lleva el arte y el mensaje de Cami contigo. Envíos a toda Colombia.</p>
  </div>
</div>

<!-- BARRA DE FILTROS -->
<div class="filtro-bar">
  <div class="container">
    <div class="d-flex align-items-center gap-3 flex-wrap">
      <div class="d-flex gap-2 flex-grow-1" style="min-width:200px;max-width:360px;">
        <input type="text" id="searchProductos" class="form-control input-search-cami flex-grow-1"
               placeholder="Buscar producto..."
               onkeydown="if(event.key==='Enter'){buscarProductos()}">
        <button class="btn-p1" style="white-space:nowrap;padding:.6rem 1.2rem;font-size:.85rem;" onclick="buscarProductos()">
          <i class="bi bi-search"></i>
        </button>
      </div>
      <div class="d-flex gap-2 flex-wrap" id="filtrosCategorias">
        <button class="filtro-btn activo" onclick="filtrarCategoria(this,'')" data-cat="">✨ Todos</button>
      </div>
    </div>
  </div>
</div>

<!-- GRID PRODUCTOS -->
<section style="padding:3rem 0 5rem;">
  <div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
      <p class="result-count mb-0" id="resultCount">Cargando productos...</p>
      <div class="d-flex gap-2 align-items-center">
        <span style="font-size:.8rem;opacity:.6;">Ordenar:</span>
        <select id="ordenSelect" class="form-select" style="width:auto;border-radius:50px;border:2px solid var(--cami-border);font-family:var(--font-playpen);font-size:.82rem;padding:.35rem 1rem;" onchange="cargarProductos(true)">
          <option value="nombre">Nombre A-Z</option>
          <option value="precio_asc">Precio ↑</option>
          <option value="precio_desc">Precio ↓</option>
        </select>
      </div>
    </div>
    <div class="row g-4" id="gridProductos">
      <div class="col-12 text-center py-5">
        <div class="spinner-border" style="color:var(--cami-turq);" role="status"></div>
        <p style="opacity:.6;margin-top:1rem;">Cargando el catálogo...</p>
      </div>
    </div>
    <div class="text-center mt-5 d-none" id="btnVerMasWrap">
      <button class="btn-p2" onclick="verMasProductos()"><i class="bi bi-plus-circle"></i>Ver más productos</button>
    </div>
  </div>
</section>

<!-- REDES SOCIALES FLOTANTES -->
<div class="fab-social">
  <button class="fab-toggle" id="fabToggle" onclick="toggleFabSocial()" title="Redes sociales">
    <i class="bi bi-share-fill" id="fabIcon"></i>
  </button>
  <div class="fab-links" id="fabLinks">
    <a href="https://www.instagram.com/diaadiaconcami" target="_blank" rel="noopener" class="fab-ig" title="Instagram">
      <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg>
    </a>
    <a href="https://www.tiktok.com/@diaadiaconcami" target="_blank" rel="noopener" class="fab-tk" title="TikTok">
      <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M19.59 6.69a4.83 4.83 0 01-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 01-2.88 2.5 2.89 2.89 0 01-2.89-2.89 2.89 2.89 0 012.89-2.89c.28 0 .54.04.79.1V9.01a6.33 6.33 0 00-.79-.05 6.34 6.34 0 00-6.34 6.34 6.34 6.34 0 006.34 6.34 6.34 6.34 0 006.33-6.34V8.69a8.18 8.18 0 004.78 1.52V6.77a4.85 4.85 0 01-1.01-.08z"/></svg>
    </a>
    <a href="https://www.facebook.com/poderdown" target="_blank" rel="noopener" class="fab-fb" title="Facebook">
      <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
    </a>
    <a href="https://www.youtube.com/@poderdown" target="_blank" rel="noopener" class="fab-yt" title="YouTube">
      <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M23.498 6.186a3.016 3.016 0 00-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 00.502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 002.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 002.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
    </a>
    <a href="https://wa.me/573137468039" target="_blank" rel="noopener" class="fab-wa" title="WhatsApp">
      <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
    </a>
  </div>
</div>

<!-- BOTÓN DISLEXIA -->
<button class="btn-dyslexia" id="btnDyslexia" onclick="toggleDyslexia()" title="Modo dislexia">
  <i class="bi bi-type"></i> <span id="dyslexiaLabel">Dislexia</span>
</button>

<?php require_once __DIR__ . '/footer.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
const API_BASE    = '<?= API_URL ?>';
const LIMITE_GRID = 12;
let offsetActual = 0, categoriaActual = '', busquedaActual = '', carrito = [], totalProductos = 0, fetchController = null;

function toggleMobileMenu() {
  const menu = document.getElementById('navMobileMenu');
  const icon = document.getElementById('hamburger-icon');
  menu.classList.toggle('open');
  icon.className = menu.classList.contains('open') ? 'bi bi-x-lg' : 'bi bi-list';
}
function closeMobileMenu() {
  const menu = document.getElementById('navMobileMenu');
  menu.classList.remove('open');
  document.getElementById('hamburger-icon').className = 'bi bi-list';
}

async function iniciarProductos() {
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
      btn.className = 'filtro-btn'; btn.dataset.cat = cat.categoria;
      btn.textContent = cat.categoria + ' (' + cat.total + ')';
      btn.onclick = () => filtrarCategoria(btn, cat.categoria);
      cont.appendChild(btn);
    });
  } catch(e) {}
}

async function cargarProductos(reiniciar = false) {
  if (reiniciar) {
    offsetActual = 0;
    document.getElementById('gridProductos').innerHTML = `
      <div class="col-12 text-center py-5">
        <div class="spinner-border" style="color:var(--cami-turq);"></div>
        <p style="opacity:.6;margin-top:1rem;">Cargando...</p>
      </div>`;
    document.getElementById('btnVerMasWrap').classList.add('d-none');
  }
  const orden  = document.getElementById('ordenSelect').value;
  const params = new URLSearchParams({ limite: LIMITE_GRID, offset: offsetActual });
  if (busquedaActual) params.append('busqueda', busquedaActual);
  try {
    const res  = await fetch(`${API_BASE}/productos.php?${params}`);
    const json = await res.json();
    if (reiniciar) document.getElementById('gridProductos').innerHTML = '';
    if (!json.exito || json.datos.length === 0) {
      if (reiniciar) {
        document.getElementById('gridProductos').innerHTML = `
          <div class="col-12 empty-state">
            <i class="bi bi-inbox"></i>
            <p style="opacity:.6;">No se encontraron productos.</p>
            <button class="btn-p2 mt-2" onclick="limpiarBusqueda()">Ver todos</button>
          </div>`;
        document.getElementById('resultCount').textContent = '0 productos';
      }
      return;
    }
    let productos = json.datos;
    if (categoriaActual) productos = productos.filter(p => p.categoria.toLowerCase() === categoriaActual.toLowerCase());

    // Ordenar
    if (orden === 'precio_asc') productos.sort((a,b) => a.precio - b.precio);
    else if (orden === 'precio_desc') productos.sort((a,b) => b.precio - a.precio);
    else productos.sort((a,b) => a.nombre.localeCompare(b.nombre));

    const grid = document.getElementById('gridProductos');
    productos.forEach(p => {
      const col = document.createElement('div');
      col.className = 'col-6 col-md-4 col-xl-3';
      col.innerHTML = tarjetaProducto(p);
      grid.appendChild(col);
    });
    totalProductos = grid.querySelectorAll('.product-card-cami').length;
    document.getElementById('resultCount').textContent = totalProductos + ' producto' + (totalProductos !== 1 ? 's' : '');
    const totalCargado = offsetActual + json.datos.length;
    document.getElementById('btnVerMasWrap').classList.toggle('d-none', totalCargado >= json.total);
    offsetActual += json.datos.length;
  } catch(e) {
    if (reiniciar) document.getElementById('gridProductos').innerHTML = `<div class="col-12 empty-state"><i class="bi bi-wifi-off"></i><p>Error al cargar. Reintenta.</p></div>`;
  }
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
      <p class="product-desc">${p.descripcion ?? 'Producto Poder Down'}</p>
      <div class="product-footer">
        <span class="product-price">$${Number(p.precio).toLocaleString('es-CO',{minimumFractionDigits:0})}</span>
        <button class="btn-add-cami"
          data-pid="${p.id}" data-nombre="${encodeURIComponent(p.nombre)}" data-precio="${p.precio}" onclick="agregarAlCarritoBtn(event,this)"
          ${agotado ? 'disabled' : ''} title="${agotado ? 'Agotado' : 'Agregar al carrito'}">
          <i class="bi bi-${agotado ? 'x' : 'plus-lg'}"></i>
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
  busquedaActual = document.getElementById('searchProductos')?.value?.trim() || '';
  categoriaActual = '';
  document.querySelectorAll('.filtro-btn').forEach(b => b.classList.remove('activo'));
  document.querySelector('.filtro-btn[data-cat=""]')?.classList.add('activo');
  cargarProductos(true);
}
function limpiarBusqueda() {
  document.getElementById('searchProductos').value = '';
  busquedaActual = ''; categoriaActual = '';
  document.querySelectorAll('.filtro-btn').forEach(b => b.classList.remove('activo'));
  document.querySelector('.filtro-btn[data-cat=""]')?.classList.add('activo');
  cargarProductos(true);
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
          <span style="background:${agotado?'#F2677C':'rgba(60,174,224,.18)'};color:${agotado?'white':'#1A3A5C'};border-radius:50px;padding:.35rem 1rem;font-size:.78rem;font-weight:700;">
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
function actualizarContadorCarrito() {
  const total = carrito.reduce((a,i) => a+i.cantidad, 0);
  document.getElementById('contadorCarrito').textContent = total;
}
function verCarrito() {
  if (!carrito.length) {
    Swal.fire({ title:`<span style="font-family:'Nunito','Gilroy',sans-serif">Carrito vacío 🛍️</span>`, html:`<p style="font-family:'Archivo',sans-serif">Agrega productos desde el catálogo.</p>`, confirmButtonColor:'#3CAEE0', confirmButtonText:'Seguir comprando' });
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
            <button onclick="cambiarCantidad(${i.id},-1)" style="background:#ebeae4;border:none;border-radius:50%;width:26px;height:26px;cursor:pointer;">−</button>
            <span style="background:#3CAEE0;color:#1A3A5C;border-radius:50px;padding:.2rem .7rem;font-size:.75rem;font-weight:700;">×${i.cantidad}</span>
            <button onclick="cambiarCantidad(${i.id},+1)" style="background:#3CAEE0;border:none;border-radius:50%;width:26px;height:26px;cursor:pointer;color:#1A3A5C;">+</button>
            <button onclick="quitarItem(${i.id})" style="background:rgba(242,103,124,.15);border:none;border-radius:50%;width:26px;height:26px;cursor:pointer;color:#F2677C;">✕</button>
          </div>
        </div>`).join('')}
      <div style="display:flex;justify-content:space-between;margin-top:1rem;font-weight:700;padding-top:.5rem;border-top:2px solid #ebeae4;">
        <span>${ti} artículo${ti!==1?'s':''}</span>
        <span style="color:#1A3A5C;font-family:'Nunito','Gilroy',sans-serif;font-size:1.1rem;">$${tp.toLocaleString('es-CO',{minimumFractionDigits:0})}</span>
      </div></div>`,
    confirmButtonText:'🛒 Finalizar compra', showCancelButton:true, cancelButtonText:'Seguir comprando', confirmButtonColor:'#3CAEE0',
  }).then(r => { if(r.isConfirmed) abrirCheckout(); });
}
function cambiarCantidad(id, delta) {
  const item = carrito.find(i => i.id === id);
  if (!item) return;
  item.cantidad = Math.max(1, item.cantidad + delta);
  actualizarContadorCarrito(); Swal.close(); setTimeout(() => verCarrito(), 50);
}
function quitarItem(id) {
  carrito = carrito.filter(i => i.id !== id);
  actualizarContadorCarrito(); Swal.close();
  if (carrito.length > 0) setTimeout(() => verCarrito(), 50);
}
function abrirCheckout() {
  const tp = carrito.reduce((a,i) => a+i.precio*i.cantidad, 0);
  Swal.fire({
    title:`<span style="font-family:'Nunito','Gilroy',sans-serif">Datos de envío</span>`,
    html:`<div style="text-align:left;font-family:'Archivo',sans-serif;display:flex;flex-direction:column;gap:.8rem;">
      <p style="font-size:.82rem;opacity:.6;margin:0;">Total: <strong>$${tp.toLocaleString('es-CO',{minimumFractionDigits:0})}</strong></p>
      <div><label style="font-size:.8rem;font-weight:700;color:#1A3A5C;">Nombre completo *</label>
        <input id="chkNombre" type="text" placeholder="Tu nombre" style="width:100%;padding:.6rem .9rem;border:2px solid #d6d4cc;border-radius:12px;font-size:.88rem;margin-top:.3rem;outline:none;box-sizing:border-box;"></div>
      <div><label style="font-size:.8rem;font-weight:700;color:#1A3A5C;">Email *</label>
        <input id="chkEmail" type="email" placeholder="tu@correo.com" style="width:100%;padding:.6rem .9rem;border:2px solid #d6d4cc;border-radius:12px;font-size:.88rem;margin-top:.3rem;outline:none;box-sizing:border-box;"></div>
      <div><label style="font-size:.8rem;font-weight:700;color:#1A3A5C;">WhatsApp *</label>
        <input id="chkTelefono" type="tel" placeholder="313 746 8039" style="width:100%;padding:.6rem .9rem;border:2px solid #d6d4cc;border-radius:12px;font-size:.88rem;margin-top:.3rem;outline:none;box-sizing:border-box;"></div>
      <div style="display:grid;grid-template-columns:1fr 1fr;gap:.6rem;">
        <div><label style="font-size:.8rem;font-weight:700;color:#1A3A5C;">Ciudad *</label>
          <input id="chkCiudad" type="text" placeholder="Medellín" style="width:100%;padding:.6rem .9rem;border:2px solid #d6d4cc;border-radius:12px;font-size:.88rem;margin-top:.3rem;outline:none;box-sizing:border-box;"></div>
        <div><label style="font-size:.8rem;font-weight:700;color:#1A3A5C;">Dirección *</label>
          <input id="chkDireccion" type="text" placeholder="Cra 10 #20-30" style="width:100%;padding:.6rem .9rem;border:2px solid #d6d4cc;border-radius:12px;font-size:.88rem;margin-top:.3rem;outline:none;box-sizing:border-box;"></div>
      </div>
      <p style="font-size:.73rem;color:#aaa;margin:0;">📦 Sin registro. Envíos a toda Colombia.</p>
    </div>`,
    confirmButtonText:'✅ Confirmar pedido', showCancelButton:true, cancelButtonText:'← Volver', confirmButtonColor:'#3CAEE0', width:520,
    preConfirm: () => {
      const nombre = (document.getElementById('chkNombre')?.value?.trim()   || '').substring(0,120);
      const email  = (document.getElementById('chkEmail')?.value?.trim()    || '').substring(0,120);
      const tel    = (document.getElementById('chkTelefono')?.value?.trim() || '').substring(0,30);
      const ciudad = (document.getElementById('chkCiudad')?.value?.trim()   || '').substring(0,100);
      const dir    = (document.getElementById('chkDireccion')?.value?.trim()|| '').substring(0,200);
      if (!nombre||!email||!tel||!ciudad||!dir) { Swal.showValidationMessage('Completa todos los campos (*)'); return false; }
      if (!email.includes('@')) { Swal.showValidationMessage('Email inválido'); return false; }
      return {nombre,email,telefono:tel,ciudad,direccion:dir};
    }
  }).then(async r => { if(!r.isConfirmed||!r.value){verCarrito();return;} await procesarCompra(r.value); });
}
async function procesarCompra(datosCliente) {
  Swal.fire({ title:'Procesando tu pedido...', allowOutsideClick:false, didOpen:()=>Swal.showLoading() });
  try {
    const body = { ...datosCliente, items: carrito.map(i=>({producto_id:i.id,nombre:i.nombre,precio:i.precio,cantidad:i.cantidad})), total: carrito.reduce((a,i)=>a+i.precio*i.cantidad,0) };
    const res  = await fetch(`${API_BASE}/pedidos.php`, { method:'POST', headers:{'Content-Type':'application/json'}, body:JSON.stringify(body) });
    const json = await res.json();
    if (json.exito || res.ok) {
      carrito = []; actualizarContadorCarrito();
      Swal.fire({ icon:'success', title:'¡Pedido confirmado! 🎉', html:`<p style="font-family:'Archivo',sans-serif">Recibiste un email de confirmación.</p>`, confirmButtonColor:'#3CAEE0' });
    } else throw new Error(json.mensaje||'Error');
  } catch(e) { Swal.fire({ icon:'error', title:'Oops...', text:'Hubo un problema. Contáctanos por WhatsApp.', confirmButtonColor:'#3CAEE0' }); }
}

// Redes flotantes
function toggleFabSocial() {
  const links = document.getElementById('fabLinks');
  const icon  = document.getElementById('fabIcon');
  links.classList.toggle('open');
  icon.className = links.classList.contains('open') ? 'bi bi-x-lg' : 'bi bi-share-fill';
}

// Modo dislexia
let dyslexiaOn = false;
function toggleDyslexia() {
  dyslexiaOn = !dyslexiaOn;
  document.body.classList.toggle('dyslexia-mode', dyslexiaOn);
  document.getElementById('dyslexiaLabel').textContent = dyslexiaOn ? 'Normal' : 'Dislexia';
  document.getElementById('btnDyslexia').style.background = dyslexiaOn ? 'var(--cami-turq)' : 'var(--cami-azul)';
  document.getElementById('btnDyslexia').style.color = dyslexiaOn ? 'var(--cami-azul)' : 'white';
  localStorage.setItem('dyslexia', dyslexiaOn ? '1' : '0');
}
if (localStorage.getItem('dyslexia') === '1') { dyslexiaOn = true; document.body.classList.add('dyslexia-mode'); document.getElementById('dyslexiaLabel').textContent = 'Normal'; document.getElementById('btnDyslexia').style.background = 'var(--cami-turq)'; document.getElementById('btnDyslexia').style.color = 'var(--cami-azul)'; }

iniciarProductos();
</script>
</body>
</html>