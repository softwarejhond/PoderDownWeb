<?php
$pageTitle = $pageTitle ?? 'Poder Down — El poder de creer e incluir';
$pageDescription = $pageDescription ?? 'Descubre obras únicas de Cami y lleva el mensaje de Poder Down a tu espacio.';
$activePage = $activePage ?? 'inicio';
$showNavSearch = $showNavSearch ?? false;
$ogTitle = $ogTitle ?? 'Poder Down';

require_once __DIR__ . '/../controller/auth.php';
$isLoggedIn = isLoggedIn();
$currentUser = $isLoggedIn ? getCurrentUser() : null;
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0">
  <title><?= htmlspecialchars($pageTitle) ?></title>
  <meta name="description" content="<?= htmlspecialchars($pageDescription) ?>">
  <meta property="og:title" content="<?= htmlspecialchars($ogTitle) ?>">
  <meta property="og:description" content="<?= htmlspecialchars($pageDescription) ?>">
  <meta property="og:type" content="website">
  <link rel="icon" type="image/png" href="img/logos/pd_icono.png">
  <link rel="apple-touch-icon" href="img/logos/pd_icono.png">
  <link rel="stylesheet" href="node_modules/bootstrap/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="node_modules/bootstrap-icons/font/bootstrap-icons.css">
  <link href="https://fonts.googleapis.com/css2?family=Archivo:ital,wght@0,400;0,500;0,600;0,700;0,800;0,900;1,400&family=Oregano:ital@0;1&family=Nunito:wght@700;800;900&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="css/marca.css">
  <style>
    :root {
      --cami-bg: #ebeae4;
      --pd-azul: #3CAEE0;
      --cami-turq: #3CAEE0;
      --cami-turquesa: #3CAEE0;
      --pd-coral: #F2677C;
      --cami-coral: #F2677C;
      --cami-amarillo: #F5C518;
      --pd-oscuro: #1A3A5C;
      --cami-azul: #1A3A5C;
      --cami-border: #d6d4cc;
      --font-gilroy: 'Nunito', 'Gilroy', sans-serif;
      --font-archivo: 'Archivo', sans-serif;
      --font-oregano: 'Oregano', cursive;
      --font-kranky: var(--font-gilroy);
      --font-playpen: var(--font-archivo);
    }
    * { box-sizing: border-box; }
    html {
      scroll-behavior: smooth;
      scroll-padding-top: 80px;
    }
    body {
      background: var(--cami-bg);
      color: var(--cami-azul);
      font-family: var(--font-playpen);
      margin: 0;
    }
    /* NAVBAR */
    .navbar-cami {
      background: var(--cami-bg);
      border-bottom: 2px solid var(--cami-border);
      position: sticky;
      top: 0;
      z-index: 1000;
      padding: .8rem 0;
    }
    .navbar-brand-cami {
      text-decoration: none;
      display: flex;
      align-items: center;
    }
    .navbar-brand-cami img {
      height: 44px;
      width: auto;
      object-fit: contain;
    }
    .nav-link-cami {
      font-family: var(--font-playpen);
      font-weight: 600;
      color: var(--cami-azul);
      font-size: .88rem;
      text-decoration: none;
      transition: color .2s;
      padding: .3rem .6rem;
    }
    .nav-link-cami:hover { color: var(--cami-coral); }
    .nav-link-cami.active {
      color: var(--cami-turq);
      border-bottom: 2px solid var(--cami-turq);
    }
    .cart-count {
      font-weight: 800;
      font-size: .92rem;
      margin-left: .1rem;
    }
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
    @media (max-width:991px) { .nav-mobile-toggle { display: flex; align-items: center; } }
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
    /* BOTONES GLOBALES */
    .btn-p1 {
      background: var(--cami-turq);
      color: var(--cami-azul);
      border: none;
      border-radius: 50px;
      padding: .75rem 2rem;
      font-weight: 700;
      font-family: var(--font-playpen);
      font-size: .95rem;
      cursor: pointer;
      transition: all .2s;
      text-decoration: none;
      display: inline-flex;
      align-items: center;
      gap: .5rem;
    }
    .btn-p1:hover {
      background: #2d9ecf;
      transform: translateY(-2px);
      color: var(--cami-azul);
    }
    .btn-p2 {
      background: transparent;
      color: var(--cami-azul);
      border: 2px solid var(--cami-azul);
      border-radius: 50px;
      padding: .7rem 1.8rem;
      font-weight: 600;
      font-family: var(--font-playpen);
      font-size: .9rem;
      cursor: pointer;
      transition: all .2s;
      text-decoration: none;
      display: inline-flex;
      align-items: center;
      gap: .5rem;
    }
    .btn-p2:hover {
      background: var(--cami-azul);
      color: white;
    }
    .btn-p-coral {
      background: var(--cami-coral);
      color: white;
      border: none;
      border-radius: 50px;
      padding: .75rem 2rem;
      font-weight: 700;
      font-family: var(--font-playpen);
      font-size: .95rem;
      cursor: pointer;
      transition: all .2s;
      text-decoration: none;
      display: inline-flex;
      align-items: center;
      gap: .5rem;
    }
    .btn-p-coral:hover {
      background: #c94851;
      transform: translateY(-2px);
      color: white;
    }
    .btn-carrito {
      background: var(--cami-azul);
      color: white;
      border: none;
      border-radius: 50px;
      padding: .5rem 1.4rem;
      font-weight: 700;
      font-family: var(--font-playpen);
      font-size: .88rem;
      cursor: pointer;
      transition: all .2s;
      display: inline-flex;
      align-items: center;
      gap: .4rem;
    }
    .btn-carrito:hover {
      background: #00254d;
    }
    .btn-user {
      background: transparent;
      color: var(--cami-azul);
      border: 2px solid var(--cami-border);
      border-radius: 50px;
      padding: .42rem 1.1rem;
      font-weight: 700;
      font-family: var(--font-playpen);
      font-size: .82rem;
      cursor: pointer;
      transition: all .2s;
      display: inline-flex;
      align-items: center;
      gap: .35rem;
      text-decoration: none;
    }
    .btn-user:hover {
      background: var(--cami-azul);
      color: #fff;
      border-color: var(--cami-azul);
    }
    .btn-user-logged {
      background: var(--cami-turq);
      color: #fff;
      border: none;
      border-radius: 50px;
      padding: .42rem 1.1rem;
      font-weight: 700;
      font-family: var(--font-playpen);
      font-size: .82rem;
      cursor: pointer;
      transition: all .2s;
      display: inline-flex;
      align-items: center;
      gap: .35rem;
      text-decoration: none;
    }
    .btn-user-logged:hover {
      background: var(--cami-azul);
      color: #fff;
    }
    .user-dropdown {
      position: relative;
      display: inline-block;
    }
    .user-dropdown-menu {
      display: none;
      position: absolute;
      right: 0;
      top: calc(100% + 8px);
      background: #fff;
      border-radius: 16px;
      box-shadow: 0 8px 32px rgba(26,58,92,.14);
      min-width: 180px;
      z-index: 1000;
      padding: .5rem 0;
      animation: ddFadeIn .2s ease;
    }
    @keyframes ddFadeIn {
      from { opacity: 0; transform: translateY(-8px); }
      to   { opacity: 1; transform: translateY(0); }
    }
    .user-dropdown-menu.show { display: block; }
    .user-dropdown-menu a {
      display: block;
      padding: .55rem 1.2rem;
      font-size: .84rem;
      color: var(--cami-azul);
      text-decoration: none;
      font-family: var(--font-playpen);
      font-weight: 600;
      transition: background .15s;
    }
    .user-dropdown-menu a:hover { background: var(--cami-bg); }
    .user-dropdown-menu hr {
      margin: .3rem 0;
      border-color: var(--cami-border);
      opacity: .5;
    }
    /* FILTROS Y SEARCH */
    .filtro-btn {
      background: var(--cami-bg);
      color: var(--cami-azul);
      border: 2px solid var(--cami-border);
      border-radius: 50px;
      padding: .45rem 1.2rem;
      font-family: var(--font-playpen);
      font-weight: 600;
      font-size: .82rem;
      cursor: pointer;
      transition: all .2s;
      white-space: nowrap;
    }
    .filtro-btn:hover,
    .filtro-btn.activo {
      background: var(--cami-turq);
      border-color: var(--cami-turq);
      color: var(--cami-azul);
    }
    .input-search-cami {
      border-radius: 50px !important;
      border: 2px solid var(--cami-border) !important;
      font-family: var(--font-playpen) !important;
      background: white !important;
      padding: .65rem 1.2rem !important;
      font-size: .9rem !important;
    }
    .input-search-cami:focus {
      border-color: var(--cami-turq) !important;
      box-shadow: 0 0 0 3px rgba(60, 174, 224, .2) !important;
      outline: none;
    }
    /* PRODUCT CARD (usada en ambas páginas) */
    .product-card-cami {
      background: white;
      border-radius: 20px;
      overflow: hidden;
      cursor: pointer;
      transition: all .25s;
      height: 100%;
    }
    .product-card-cami:hover {
      transform: translateY(-6px);
      box-shadow: 0 20px 50px rgba(0, 51, 102, .12);
    }
    .product-card-cami .img-wrap {
      height: 200px;
      background: linear-gradient(135deg, rgba(60, 174, 224, .15), rgba(0, 51, 102, .05));
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 4rem;
      position: relative;
      overflow: hidden;
    }
    .product-card-cami .img-wrap img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      position: absolute;
      inset: 0;
    }
    .product-card-cami .img-wrap .img-placeholder {
      font-size: 4rem;
      display: flex;
      align-items: center;
      justify-content: center;
      width: 100%;
      height: 100%;
      position: absolute;
      inset: 0;
      background: linear-gradient(135deg, rgba(60, 174, 224, .15), rgba(0, 51, 102, .05));
    }
    .badge-cat {
      position: absolute;
      top: .8rem;
      left: .8rem;
      background: var(--cami-turq);
      color: var(--cami-azul);
      border-radius: 50px;
      padding: .25rem .8rem;
      font-size: .7rem;
      font-weight: 700;
    }
    .badge-agotado {
      position: absolute;
      top: .8rem;
      right: .8rem;
      background: var(--cami-coral);
      color: white;
      border-radius: 50px;
      padding: .25rem .8rem;
      font-size: .7rem;
      font-weight: 700;
    }
    .badge-variantes {
      position: absolute;
      top: 2.5rem;
      left: .8rem;
      background: var(--cami-azul);
      color: white;
      border-radius: 50px;
      padding: .18rem .65rem;
      font-size: .66rem;
      font-weight: 700;
      opacity: .85;
    }
    .product-card-cami .card-body { padding: 1.3rem; }
    .product-name {
      font-family: var(--font-kranky);
      font-weight: 700;
      font-size: 1rem;
      margin: 0 0 .3rem;
    }
    .product-desc {
      font-size: .8rem;
      opacity: .6;
      margin: 0 0 .9rem;
      line-height: 1.5;
      display: -webkit-box;
      -webkit-line-clamp: 2;
      -webkit-box-orient: vertical;
      overflow: hidden;
    }
    .product-footer {
      display: flex;
      justify-content: space-between;
      align-items: center;
    }
    .product-price {
      font-family: var(--font-kranky);
      font-size: 1.4rem;
      color: var(--cami-azul);
    }
    .btn-add-cami {
      background: var(--cami-azul);
      color: white;
      border: none;
      border-radius: 50%;
      width: 38px;
      height: 38px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 1.1rem;
      cursor: pointer;
      transition: all .2s;
      flex-shrink: 0;
    }
    .btn-add-cami:hover {
      background: var(--cami-turq);
      color: var(--cami-azul);
      transform: scale(1.1);
    }
    .btn-add-cami:disabled {
      background: #ccc;
      cursor: not-allowed;
      transform: none;
    }
    /* EMPTY STATE */
    .empty-state {
      text-align: center;
      padding: 5rem 2rem;
    }
    .empty-state i {
      font-size: 4rem;
      opacity: .2;
      display: block;
      margin-bottom: 1.2rem;
    }
    .result-count {
      font-size: .85rem;
      opacity: .6;
    }
    /* REDES SOCIALES FLOTANTES */
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
      width: 46px;
      height: 46px;
      border-radius: 50%;
      background: var(--cami-coral);
      color: white;
      border: none;
      cursor: pointer;
      font-size: 1.05rem;
      display: flex;
      align-items: center;
      justify-content: center;
      box-shadow: 0 4px 16px rgba(242, 103, 124, .4);
      transition: all .25s;
      order: 1;
    }
    .fab-toggle-btn:hover {
      transform: scale(1.1) rotate(10deg);
    }
    .fab-social-links {
      display: flex;
      flex-direction: column;
      gap: .5rem;
      overflow: hidden;
      max-height: 0;
      transition: max-height .4s cubic-bezier(.4, 0, .2, 1), opacity .3s;
      opacity: 0;
      order: 0;
    }
    .fab-social-links.open {
      max-height: 320px;
      opacity: 1;
    }
    .fab-soc {
      width: 42px;
      height: 42px;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      color: white;
      text-decoration: none;
      transition: all .22s;
      box-shadow: 0 3px 12px rgba(0, 0, 0, .22);
      transform: scale(0.8);
    }
    .fab-social-links.open .fab-soc { transform: scale(1); }
    .fab-soc:hover { transform: scale(1.15) translateX(-5px); }
    .fab-ig { background: linear-gradient(135deg, #f09433, #e6683c, #dc2743, #cc2366, #bc1888); }
    .fab-tk { background: #010101; }
    .fab-fb { background: #1877F2; }
    .fab-yt { background: #FF0000; }
    .fab-wa { background: #25D366; }
    @media (max-width:575px) {
      .fab-social-wrap { right: 12px; bottom: 52px; }
      .fab-soc { width: 38px; height: 38px; }
      .fab-toggle-btn { width: 42px; height: 42px; }
    }
    /* BOTÓN DISLEXIA */
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
      box-shadow: 0 4px 14px rgba(0, 51, 102, .28);
      transition: all .25s;
      display: flex;
      align-items: center;
      gap: .4rem;
    }
    .btn-dyslexia-float:hover {
      background: var(--cami-turq);
      color: var(--cami-azul);
      transform: translateY(-2px);
    }
    body.dyslexia-mode {
      font-family: 'Comic Sans MS', 'Trebuchet MS', cursive !important;
      letter-spacing: .04em;
      word-spacing: .12em;
      line-height: 1.95 !important;
    }
    body.dyslexia-mode * { font-family: 'Comic Sans MS', 'Trebuchet MS', cursive !important; }
    body.dyslexia-mode p,
    body.dyslexia-mode li { font-size: 1.05em; }
    @media (max-width:575px) {
      .btn-dyslexia-float { left: 10px; bottom: 52px; font-size: .7rem; padding: .48rem .85rem; }
    }
    /* RESPONSIVE NAVBAR */
    @media (max-width:991px) {
      .navbar-cami { padding: .6rem 0; }
      .navbar-brand-cami img { height: 36px; }
    }
    @media (max-width:575px) {
      .navbar-brand-cami img { height: 30px; }
      .btn-carrito { padding: .45rem .9rem; font-size: .8rem; }
      .btn-user, .btn-user-logged { padding: .4rem .8rem; font-size: .75rem; }
      .product-card-cami .img-wrap { height: 160px; }
      .product-name { font-size: .9rem; }
      .product-price { font-size: 1.2rem; }
    }
    .nav-mobile-menu .input-search-cami {
      width: 100% !important;
      margin-top: .6rem;
    }
  </style>
</head>
<body>
  <?php require_once __DIR__ . '/wcag.php'; ?>
  <noscript>
    <div style="background:#F2677C;color:white;text-align:center;padding:1rem;font-weight:700;">Esta página requiere JavaScript para funcionar correctamente.</div>
  </noscript>

  <!-- NAVBAR -->
  <nav class="navbar-cami">
    <div class="container d-flex align-items-center justify-content-between flex-wrap gap-2">
      <a class="navbar-brand-cami" href="<?= $activePage === 'inicio' ? '#inicio' : 'index.php' ?>">
        <img src="img/logos/logo_pd_horizontal.png" alt="Poder Down">
      </a>
      <div class="d-none d-lg-flex align-items-center gap-3">
        <a class="nav-link-cami <?= $activePage === 'inicio' ? 'active' : '' ?>" href="<?= $activePage === 'inicio' ? '#inicio' : 'index.php' ?>" data-section="inicio">Inicio</a>
        <a class="nav-link-cami" href="<?= $activePage === 'inicio' ? '#sobre-mi' : 'index.php#sobre-mi' ?>" data-section="sobre-mi">Sobre mí</a>
        <a class="nav-link-cami <?= $activePage === 'productos' ? 'active' : '' ?>" href="productos.php">Productos</a>
        <a class="nav-link-cami <?= $activePage === 'galeria' ? 'active' : '' ?>" href="galeria.php">Galería</a>
        <a class="nav-link-cami <?= $activePage === 'blog' ? 'active' : '' ?>" href="blog.php">Blog</a>
        <a class="nav-link-cami" href="<?= $activePage === 'inicio' ? '#contacto' : 'index.php#contacto' ?>" data-section="contacto">Contacto</a>
        <a class="nav-link-cami" href="<?= $activePage === 'inicio' ? '#faq' : 'index.php#faq' ?>" data-section="faq">FAQ</a>
      </div>
      <div class="d-flex align-items-center gap-2">
        <?php if ($showNavSearch): ?>
        <input type="text" id="searchNavbar" class="form-control input-search-cami d-none d-md-block"
          style="width:210px;padding:.45rem 1rem!important;font-size:.82rem!important;"
          placeholder="¿Qué buscas?"
          onkeydown="if(event.key==='Enter'){buscarProductos()}">
        <?php endif; ?>
        <button class="btn-carrito" onclick="verCarrito()">
          <i class="bi bi-cart3"></i>
          <span class="cart-count" id="contadorCarrito">0</span>
        </button>
        <?php if ($isLoggedIn): ?>
        <div class="user-dropdown">
          <button class="btn-user-logged" onclick="toggleUserMenu(event)" aria-label="Mi cuenta">
            <i class="bi bi-person-circle"></i> <span class="d-none d-md-inline"><?= htmlspecialchars(explode(' ', $currentUser['first_name'])[0]) ?></span>
          </button>
          <div class="user-dropdown-menu" id="userDropdown">
            <a href="perfil.php"><i class="bi bi-person me-1"></i> Mi Perfil</a>
            <a href="#"><i class="bi bi-box-seam me-1"></i> Mis Pedidos</a>
            <hr>
            <a href="logout.php" style="color:var(--pd-coral);"><i class="bi bi-box-arrow-right me-1"></i> Cerrar Sesión</a>
          </div>
        </div>
        <?php else: ?>
        <a href="login.php" class="btn-user">
          <i class="bi bi-person"></i> <span class="d-none d-md-inline">Ingresar</span>
        </a>
        <?php endif; ?>
        <button class="nav-mobile-toggle" onclick="toggleMobileMenu()" aria-label="Menú">
          <i class="bi bi-list" id="hamburger-icon"></i>
        </button>
      </div>
    </div>
    <div class="nav-mobile-menu" id="navMobileMenu">
      <a class="nav-link-cami <?= $activePage === 'inicio' ? 'active' : '' ?>" href="<?= $activePage === 'inicio' ? '#inicio' : 'index.php' ?>" data-section="inicio" onclick="closeMobileMenu()">Inicio</a>
      <a class="nav-link-cami" href="<?= $activePage === 'inicio' ? '#sobre-mi' : 'index.php#sobre-mi' ?>" data-section="sobre-mi" onclick="closeMobileMenu()">Sobre mí</a>
      <a class="nav-link-cami <?= $activePage === 'productos' ? 'active' : '' ?>" href="productos.php" onclick="closeMobileMenu()">Productos</a>
      <a class="nav-link-cami <?= $activePage === 'galeria' ? 'active' : '' ?>" href="galeria.php" onclick="closeMobileMenu()">Galería</a>
      <a class="nav-link-cami <?= $activePage === 'blog' ? 'active' : '' ?>" href="blog.php" onclick="closeMobileMenu()">Blog</a>
      <a class="nav-link-cami" href="<?= $activePage === 'inicio' ? '#contacto' : 'index.php#contacto' ?>" data-section="contacto" onclick="closeMobileMenu()">Contacto</a>
      <a class="nav-link-cami" href="<?= $activePage === 'inicio' ? '#faq' : 'index.php#faq' ?>" data-section="faq" onclick="closeMobileMenu()">FAQ</a>
      <?php if ($isLoggedIn): ?>
      <a class="nav-link-cami" href="perfil.php" onclick="closeMobileMenu()"><i class="bi bi-person me-1"></i> Mi Perfil</a>
      <a class="nav-link-cami" href="logout.php" onclick="closeMobileMenu()" style="color:var(--pd-coral);"><i class="bi bi-box-arrow-right me-1"></i> Cerrar Sesión</a>
      <?php else: ?>
      <a class="nav-link-cami <?= $activePage === 'login' ? 'active' : '' ?>" href="login.php" onclick="closeMobileMenu()"><i class="bi bi-box-arrow-in-right me-1"></i> Iniciar Sesión</a>
      <a class="nav-link-cami <?= $activePage === 'registro' ? 'active' : '' ?>" href="registro.php" onclick="closeMobileMenu()"><i class="bi bi-person-plus me-1"></i> Registrarte</a>
      <?php endif; ?>
      <?php if (!$showNavSearch): ?>
      <input type="text" class="form-control input-search-cami mt-2"
        placeholder="Buscar producto..."
        onkeydown="if(event.key==='Enter'){buscarProductos();closeMobileMenu()}">
      <?php endif; ?>
    </div>
  </nav>
  <script>
  function toggleUserMenu(e) {
    e.stopPropagation();
    var menu = document.getElementById('userDropdown');
    if (menu) menu.classList.toggle('show');
  }
  document.addEventListener('click', function(e) {
    var menu = document.getElementById('userDropdown');
    if (menu && menu.classList.contains('show') && !e.target.closest('.user-dropdown')) {
      menu.classList.remove('show');
    }
  });
  </script>
  <script src="components/carrito.js"></script>
