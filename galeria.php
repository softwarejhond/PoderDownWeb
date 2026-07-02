<?php
$slug = $_GET['slug'] ?? null;

if ($slug) {
    require_once __DIR__ . '/components/galeria/cargar_galerias.php';
    $galeria = getGaleriaBySlug($slug);
    if (!$galeria) {
        header('HTTP/1.0 404 Not Found');
        $pageTitle = 'Galería no encontrada — Poder Down';
        $pageDescription = 'La galería que buscas no existe o ha sido retirada.';
        $activePage = 'galeria';
        require 'components/header.php';
        echo '<section style="background:white;padding:5rem 0;min-height:60vh;"><div class="container text-center"><i class="bi bi-images" style="font-size:4rem;opacity:.2;display:block;margin-bottom:1rem;"></i><h2 style="font-family:var(--font-kranky);">Galería no encontrada</h2><p style="opacity:.6;">La galería que buscas no existe o ha sido retirada.</p><a href="galeria.php" class="btn-p1 mt-3"><i class="bi bi-arrow-left"></i> Volver a las galerías</a></div></section>';
        require_once __DIR__ . '/Footer.php';
        exit;
    }
    $pageTitle = htmlspecialchars($galeria['title']) . ' — Galería Poder Down';
    $pageDescription = htmlspecialchars($galeria['excerpt'] ?? '');
    $activePage = 'galeria';
    $ogTitle = htmlspecialchars($galeria['title']);
    require 'components/header.php';
    $obras = $galeria['obras'] ?? [];
    ?>
    <style>
      .gal-hero {
        background: var(--cami-azul);
        padding: 5rem 0 3rem;
        position: relative;
        overflow: hidden;
        text-align: center;
      }
      .gal-hero::before {
        content: '';
        position: absolute;
        top: -80px; left: -80px;
        width: 340px; height: 340px;
        background: rgba(60,174,224,.18);
        border-radius: 50%;
      }
      .gal-hero::after {
        content: '';
        position: absolute;
        bottom: -100px; right: -80px;
        width: 300px; height: 300px;
        background: rgba(242,103,124,.14);
        border-radius: 50%;
      }
      .gal-eyebrow {
        font-family: var(--font-playpen);
        font-weight: 600;
        letter-spacing: .3em;
        font-size: .72rem;
        color: var(--cami-turq);
        text-transform: uppercase;
      }
      .gal-title {
        font-family: var(--font-kranky);
        color: white;
        font-size: clamp(2rem, 5vw, 3.4rem);
        margin: .4rem 0 .3rem;
      }
      .gal-sub {
        color: rgba(255,255,255,.72);
        font-size: .95rem;
        max-width: 640px;
        margin: .6rem auto 0;
      }

      .gal-body { background: var(--cami-bg); padding: 2rem 0 4rem; }

      /* ---------- Escenario carrusel 3D ---------- */
      .stage-wrap { position: relative; padding: 1.5rem 0 1rem; }
      .stage {
        perspective: 2000px;
        perspective-origin: 50% 45%;
        height: 600px;
        position: relative;
        display: flex;
        align-items: center;
        justify-content: center;
      }
      .ring {
        position: relative;
        width: 440px;
        height: 520px;
        transform-style: preserve-3d;
        transition: transform 1s cubic-bezier(.65,.05,.25,1);
      }
      .frame {
        position: absolute;
        top: 50%; left: 50%;
        width: 400px;
        height: 500px;
        border-radius: 14px;
        backface-visibility: hidden;
        transition: width .45s ease, height .45s ease;
      }
      .frame-inner {
        width: 100%;
        height: 100%;
        padding: 12px;
        background: linear-gradient(120deg,
          var(--cami-turq), var(--cami-coral) 30%, var(--cami-amarillo, #F5C518) 55%, var(--cami-coral) 75%, var(--cami-turq) 100%);
        background-size: 300% 300%;
        animation: frameFlow 6s ease-in-out infinite;
        border-radius: 16px;
        box-shadow:
          0 25px 45px -18px rgba(0,51,102,.35),
          0 0 0 1px rgba(255,255,255,.5) inset;
      }
      @keyframes frameFlow {
        0% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
        100% { background-position: 0% 50%; }
      }
      .frame.is-active .frame-inner { animation-duration: 3.5s; }
      .frame-mat {
        width: 100%;
        height: 100%;
        background: white;
        border-radius: 10px;
        padding: 8px;
      }
      .frame-mat img {
        width: 100%;
        height: 100%;
        object-fit: contain;
        display: block;
        border-radius: 6px;
        filter: saturate(.95) contrast(1.02);
      }
      .frame-tag {
        position: absolute;
        bottom: -16px;
        left: 50%;
        transform: translateX(-50%);
        background: var(--cami-coral);
        border: 2px solid white;
        color: #fff;
        font-family: var(--font-playpen);
        font-weight: 600;
        font-size: .62rem;
        letter-spacing: .08em;
        padding: 4px 12px;
        white-space: nowrap;
        text-transform: uppercase;
        border-radius: 20px;
        opacity: 0;
        box-shadow: 0 6px 14px -4px rgba(0,51,102,.35);
        transition: opacity .5s ease;
      }
      .frame.is-active .frame-tag { opacity: 1; }
      .frame:not(.is-active) .frame-mat img { filter: saturate(.35) brightness(.92); }
      .frame:not(.is-active) .frame-inner {
        background: linear-gradient(120deg, #cfd6da, #e4e2da 35%, #d7d5cb 65%, #e4e2da 100%);
        background-size: 300% 300%;
        animation-duration: 9s;
        opacity: .85;
      }
      @media (prefers-reduced-motion: reduce) {
        .frame-inner { animation: none; }
        .ring { transition: none; }
      }
      .spotlight {
        position: absolute;
        top: -60px; left: 50%;
        transform: translateX(-50%);
        width: 640px; height: 420px;
        background: radial-gradient(ellipse at center, rgba(60,174,224,.14), transparent 65%);
        pointer-events: none;
      }
      .floor-shadow {
        position: absolute;
        bottom: 6px; left: 50%;
        transform: translateX(-50%);
        width: 340px; height: 34px;
        background: radial-gradient(ellipse at center, rgba(0,51,102,.18), transparent 70%);
        filter: blur(2px);
      }
      .nav-btn {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        width: 54px; height: 54px;
        border-radius: 50%;
        border: none;
        background: white;
        color: var(--cami-turq);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
        box-shadow: 0 10px 22px -10px rgba(0,51,102,.35);
        transition: background .25s ease, color .25s ease, box-shadow .25s ease;
        z-index: 6;
      }
      .nav-btn.prev { left: clamp(4px, 3vw, 40px); }
      .nav-btn.next { right: clamp(4px, 3vw, 40px); }
      .nav-btn:hover {
        background: var(--cami-turq);
        color: #fff;
        box-shadow: 0 14px 26px -10px rgba(0,51,102,.45);
      }
      .nav-btn:active { transform: translateY(-50%) scale(.94); }

      .plaque-zone {
        max-width: 640px;
        margin: 2.2rem auto 0;
        text-align: center;
        padding: 1.6rem 1.6rem 1.4rem;
        background: white;
        border-radius: 22px;
        box-shadow: 0 20px 40px -22px rgba(0,51,102,.25);
        min-height: 190px;
      }
      .plaque-num {
        font-family: var(--font-playpen);
        font-weight: 700;
        color: var(--cami-amarillo, #F5C518);
        background: var(--cami-azul);
        display: inline-block;
        padding: .25rem .8rem;
        border-radius: 20px;
        font-size: .68rem;
        letter-spacing: .2em;
        text-transform: uppercase;
      }
      .plaque-title {
        font-family: var(--font-kranky);
        font-size: clamp(1.5rem, 3vw, 2.1rem);
        color: var(--cami-azul);
        margin: .7rem 0 .15rem;
      }
      .plaque-meta {
        font-family: var(--font-playpen);
        font-weight: 600;
        color: var(--cami-coral);
        font-size: .8rem;
        letter-spacing: .04em;
        margin-bottom: 1rem;
      }
      .plaque-desc {
        color: var(--cami-azul);
        opacity: .8;
        font-size: 1.02rem;
        line-height: 1.65;
      }

      .thumbs {
        display: flex;
        justify-content: center;
        gap: .7rem;
        flex-wrap: wrap;
        margin: 2.2rem auto 1rem;
        max-width: 760px;
        padding: 0 1rem;
      }
      .thumb {
        width: 58px; height: 70px;
        padding: 4px;
        background: white;
        cursor: pointer;
        opacity: .55;
        border-radius: 10px;
        box-shadow: 0 6px 14px -8px rgba(0,51,102,.3);
        transition: .3s ease;
        border: none;
      }
      .thumb.active {
        opacity: 1;
        transform: translateY(-4px);
        box-shadow: 0 0 0 3px var(--cami-amarillo, #F5C518), 0 10px 18px -6px rgba(0,51,102,.35);
      }
      .thumb img {
        width: 100%; height: 100%;
        object-fit: cover;
        display: block;
        border-radius: 6px;
      }
      .gal-hint {
        text-align: center;
        font-family: var(--font-playpen);
        font-weight: 600;
        font-size: .74rem;
        letter-spacing: .1em;
        text-transform: uppercase;
        color: var(--cami-azul);
        opacity: .5;
        margin-top: 1.5rem;
      }
      @media (max-width: 576px) {
        .stage { height: 460px; }
        .ring { width: 300px; height: 380px; }
        .nav-btn { width: 44px; height: 44px; font-size: 1.05rem; }
        .thumb { width: 46px; height: 56px; }
      }
    </style>

    <section class="gal-hero">
      <div class="container position-relative" style="z-index:1;">
        <a href="galeria.php" class="d-inline-flex align-items-center gap-2 mb-3" style="color:var(--cami-turq);text-decoration:none;font-size:.85rem;font-weight:600;"><i class="bi bi-arrow-left"></i> Volver a las galerías</a>
        <div class="gal-eyebrow">Colección Poder Down</div>
        <h1 class="gal-title"><?= htmlspecialchars($galeria['title']) ?></h1>
        <?php if (!empty($galeria['excerpt'])): ?>
        <p class="gal-sub"><?= htmlspecialchars($galeria['excerpt']) ?></p>
        <?php endif; ?>
        <p class="gal-sub" style="margin-top:.4rem;font-size:.82rem;opacity:.6;">
          <i class="bi bi-person-circle me-1"></i><?= htmlspecialchars(mb_convert_case($galeria['author'], MB_CASE_TITLE, 'UTF-8')) ?>
          &nbsp;·&nbsp;<?= count($obras) ?> obra<?= count($obras) === 1 ? '' : 's' ?>
        </p>
      </div>
    </section>

    <section class="gal-body">
      <div class="container">
        <?php if (empty($obras)): ?>
          <div class="empty-state text-center" style="padding:4rem 2rem;">
            <i class="bi bi-image" style="font-size:3.5rem;opacity:.15;display:block;margin-bottom:1rem;"></i>
            <p style="font-family:var(--font-kranky);font-size:1.3rem;opacity:.5;">Esta galería aún no tiene obras</p>
          </div>
        <?php else: ?>
        <div class="stage-wrap">
          <div class="spotlight"></div>
          <button class="nav-btn prev" id="prevBtn" aria-label="Anterior">&#10094;</button>
          <div class="stage">
            <div class="ring" id="ring"></div>
            <div class="floor-shadow"></div>
          </div>
          <button class="nav-btn next" id="nextBtn" aria-label="Siguiente">&#10095;</button>
        </div>

        <div class="plaque-zone">
          <div class="plaque-num" id="plaqueNum">OBRA N.º 01</div>
          <h2 class="plaque-title" id="plaqueTitle"></h2>
          <div class="plaque-meta" id="plaqueMeta"></div>
          <p class="plaque-desc" id="plaqueDesc"></p>
        </div>

        <div class="thumbs" id="thumbs"></div>
        <p class="gal-hint">Toque una miniatura o use las flechas para girar la sala</p>
        <?php endif; ?>

        <div class="text-center pt-4">
          <a href="galeria.php" class="btn-p1"><i class="bi bi-arrow-left"></i> Volver a las galerías</a>
        </div>
      </div>
    </section>

    <?php if (!empty($obras)): ?>
    <script>
    const obras = <?= json_encode(array_map(function ($o) {
        return [
            'img' => $o['img'],
            'title' => $o['title'],
            'meta' => $o['meta'] ?? '',
            'desc' => $o['descripcion'] ?? '',
        ];
    }, $obras), JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) ?>;

    const ring = document.getElementById('ring');
    const thumbsWrap = document.getElementById('thumbs');
    const n = obras.length;
    const angleStep = 360 / n;

    const isSmall = window.matchMedia('(max-width: 576px)').matches;
    // Caja límite: el marco crece dentro de estos máximos manteniendo la proporción real de la foto
    const BOX = isSmall ? { w: 300, h: 380 } : { w: 460, h: 540 };
    const PAD = 40; // padding del marco (frame-inner 12 + frame-mat 8) por lado * 2
    const radius = n > 1 ? Math.round(BOX.w / (2 * Math.tan(Math.PI / n))) + 90 : 0;
    let current = 0;

    function placeFrame(frame, i) {
      frame.style.transform = `translate(-50%, -50%) rotateY(${i * angleStep}deg) translateZ(${radius}px)`;
    }

    function sizeFrameToImage(frame, img) {
      const nw = img.naturalWidth, nh = img.naturalHeight;
      if (!nw || !nh) return;
      const ratio = nw / nh;
      // Ajustar el área de imagen dentro de la caja y sumar el padding del marco
      let iw = BOX.w - PAD, ih = BOX.h - PAD;
      let w = ih * ratio, h = ih;
      if (w > iw) { w = iw; h = iw / ratio; }
      frame.style.width = (w + PAD) + 'px';
      frame.style.height = (h + PAD) + 'px';
    }

    obras.forEach((o, i) => {
      const frame = document.createElement('div');
      frame.className = 'frame';
      frame.innerHTML = `
        <div class="frame-inner">
          <div class="frame-mat">
            <img alt="${o.title}">
          </div>
        </div>
        <div class="frame-tag">${o.title}</div>
      `;
      ring.appendChild(frame);
      placeFrame(frame, i);

      const img = frame.querySelector('img');
      const applySize = () => sizeFrameToImage(frame, img);
      img.addEventListener('load', applySize);
      img.src = o.img;
      if (img.complete) applySize();

      const th = document.createElement('button');
      th.className = 'thumb';
      th.type = 'button';
      th.setAttribute('aria-label', o.title);
      th.innerHTML = `<img src="${o.img}" alt="${o.title}">`;
      th.addEventListener('click', () => goTo(i));
      thumbsWrap.appendChild(th);
    });

    const frames = document.querySelectorAll('.frame');
    const thumbs = document.querySelectorAll('.thumb');

    function render() {
      ring.style.transform = `rotateY(${-current * angleStep}deg)`;
      frames.forEach((f, i) => f.classList.toggle('is-active', i === current));
      thumbs.forEach((t, i) => t.classList.toggle('active', i === current));
      const o = obras[current];
      document.getElementById('plaqueNum').textContent = `OBRA N.º ${String(current + 1).padStart(2, '0')}`;
      document.getElementById('plaqueTitle').textContent = o.title;
      document.getElementById('plaqueMeta').textContent = o.meta;
      document.getElementById('plaqueDesc').textContent = o.desc;
    }

    function goTo(i) {
      current = (i + n) % n;
      render();
    }

    document.getElementById('nextBtn').addEventListener('click', () => goTo(current + 1));
    document.getElementById('prevBtn').addEventListener('click', () => goTo(current - 1));
    document.addEventListener('keydown', (e) => {
      if (e.key === 'ArrowRight') goTo(current + 1);
      if (e.key === 'ArrowLeft') goTo(current - 1);
    });

    render();
    </script>
    <?php endif; ?>

    <?php
    require_once __DIR__ . '/Footer.php';
    exit;
}

$page = isset($_GET['page']) ? max(1, (int) $_GET['page']) : 1;
$search = trim($_GET['busqueda'] ?? '');
$perPage = 15;

require_once __DIR__ . '/components/galeria/cargar_galerias.php';
$galerias = getGalerias($page, $perPage, $search);
$total = getTotalGalerias($search);
$totalPages = max(1, ceil($total / $perPage));

$pageTitle = 'Galerías — Arte y momentos | Poder Down';
$pageDescription = 'Colecciones de fotografías y obras que celebran la diversidad desde la mirada de Poder Down.';
$activePage = 'galeria';
$ogTitle = 'Galerías Poder Down';
require 'components/header.php';
?>

<style>
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
  .page-header h1 {
    font-family: var(--font-kranky);
    color: white;
    font-size: clamp(2rem,5vw,3.5rem);
    margin: 0;
  }
  .page-header p { color: rgba(255,255,255,.7); font-size: 1rem; margin: .8rem 0 0; }
  .breadcrumb-cami { display: flex; gap: .5rem; align-items: center; margin-bottom: 1rem; font-size: .8rem; }
  .breadcrumb-cami a { color: var(--cami-turq); text-decoration: none; }
  .breadcrumb-cami a:hover { text-decoration: underline; }
  .breadcrumb-cami span { color: rgba(255,255,255,.45); }

  .blog-list-card {
    background: white;
    border-radius: 20px;
    overflow: hidden;
    height: 100%;
    transition: all .3s;
    text-decoration: none;
    display: block;
    position: relative;
  }
  .blog-list-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 16px 40px rgba(0,51,102,.1);
  }
  .blog-list-img {
    aspect-ratio: 16 / 9;
    width: 100%;
    background-size: cover;
    background-position: center;
    display: flex;
    align-items: center;
    justify-content: center;
    position: relative;
  }
  .blog-list-img-placeholder {
    aspect-ratio: 16 / 9;
    width: 100%;
    background: linear-gradient(135deg,rgba(60,174,224,.12),rgba(242,103,124,.08));
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2.5rem;
    color: var(--cami-border);
  }
  .gal-count-badge {
    position: absolute;
    top: .7rem; right: .7rem;
    background: rgba(0,51,102,.78);
    color: #fff;
    font-family: var(--font-playpen);
    font-weight: 600;
    font-size: .7rem;
    padding: .28rem .7rem;
    border-radius: 20px;
    display: flex;
    align-items: center;
    gap: .3rem;
    backdrop-filter: blur(2px);
  }
  .blog-list-body { padding: 1.5rem; }
  .blog-list-title {
    font-family: var(--font-kranky);
    font-size: 1.1rem;
    color: var(--cami-azul);
    margin-bottom: .5rem;
    line-height: 1.3;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
  }
  .blog-list-excerpt {
    font-size: .84rem;
    line-height: 1.7;
    color: var(--cami-azul);
    opacity: .65;
    margin-bottom: .8rem;
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
  }
  .blog-list-meta {
    font-size: .74rem;
    opacity: .45;
    display: flex;
    align-items: center;
    gap: .8rem;
  }

  .search-input {
    border-radius: 50px !important;
    border: 2px solid var(--cami-border) !important;
    font-family: var(--font-playpen) !important;
    background: white !important;
    padding: .7rem 1.4rem !important;
    font-size: .92rem !important;
    max-width: 400px;
    width: 100%;
  }
  .search-input:focus {
    border-color: var(--cami-turq) !important;
    box-shadow: 0 0 0 3px rgba(60,174,224,.2) !important;
    outline: none;
  }

  .pagination .page-link {
    border-radius: 50px !important;
    margin: 0 .15rem;
    border: 2px solid var(--cami-border);
    color: var(--cami-azul);
    font-weight: 600;
    font-family: var(--font-playpen);
    font-size: .85rem;
    padding: .45rem 1rem;
    transition: all .2s;
  }
  .pagination .page-link:hover {
    background: var(--cami-turq);
    border-color: var(--cami-turq);
    color: var(--cami-azul);
  }
  .pagination .page-item.active .page-link {
    background: var(--cami-turq);
    border-color: var(--cami-turq);
    color: var(--cami-azul);
  }
  .pagination .page-item.disabled .page-link {
    opacity: .35;
    pointer-events: none;
  }

  .empty-state { text-align: center; padding: 4rem 2rem; }
  .empty-state i { font-size: 3.5rem; opacity: .15; display: block; margin-bottom: 1rem; }

  @media (max-width:767px) {
    .page-header { padding: 3rem 0 2rem; }
    .blog-list-body { padding: 1.2rem; }
    .blog-list-title { font-size: 1rem; }
  }
</style>

<section class="page-header">
  <div class="container position-relative" style="z-index:1;">
    <div class="breadcrumb-cami">
      <a href="index.php">Inicio</a><span>/</span><span>Galerías</span>
    </div>
    <h1>Galerías<span style="color:var(--cami-turq);">.</span></h1>
    <p>Colecciones de fotografías y obras que celebran la diversidad y el arte.</p>
  </div>
</section>

<section style="background:var(--cami-bg);padding:3rem 0 5rem;">
  <div class="container">
    <form method="get" action="galeria.php" class="d-flex justify-content-center mb-5">
      <div class="input-group" style="max-width:450px;width:100%;">
        <input type="search" name="busqueda" class="form-control search-input" placeholder="Buscar galerías..." value="<?= htmlspecialchars($search) ?>">
        <button class="btn-p1" type="submit" style="border-radius:0 50px 50px 0;padding:.7rem 1.5rem;"><i class="bi bi-search"></i></button>
      </div>
    </form>

    <?php if (empty($galerias)): ?>
      <div class="empty-state">
        <i class="bi bi-images"></i>
        <p style="font-family:var(--font-kranky);font-size:1.3rem;opacity:.5;">No se encontraron galerías</p>
        <?php if ($search): ?>
          <p style="opacity:.4;font-size:.88rem;">Intenta con otra palabra clave.</p>
          <a href="galeria.php" class="btn-p2 mt-3" style="font-size:.82rem;">Ver todas las galerías</a>
        <?php else: ?>
          <p style="opacity:.4;font-size:.88rem;">Próximamente publicaremos nuevas colecciones.</p>
          <a href="index.php" class="btn-p2 mt-3" style="font-size:.82rem;">Volver al inicio</a>
        <?php endif; ?>
      </div>
    <?php else: ?>
      <div class="row g-4">
        <?php foreach ($galerias as $gal):
          $imgSrc = !empty($gal['featured_image']) ? htmlspecialchars($gal['featured_image']) : '';
          $galUrl = 'galeria.php?slug=' . urlencode($gal['slug']);
          $totalObras = (int) ($gal['total_obras'] ?? 0);
        ?>
        <div class="col-md-6 col-lg-4">
          <a href="<?= $galUrl ?>" class="blog-list-card">
            <?php if ($imgSrc): ?>
            <div class="blog-list-img" style="background-image:url('<?= $imgSrc ?>');">
              <span class="gal-count-badge"><i class="bi bi-images"></i><?= $totalObras ?></span>
            </div>
            <?php else: ?>
            <div class="blog-list-img-placeholder">
              <i class="bi bi-images"></i>
              <span class="gal-count-badge"><i class="bi bi-images"></i><?= $totalObras ?></span>
            </div>
            <?php endif; ?>
            <div class="blog-list-body">
              <p class="blog-list-title"><?= htmlspecialchars($gal['title']) ?></p>
              <p class="blog-list-excerpt"><?= htmlspecialchars($gal['excerpt'] ?? '') ?></p>
              <div class="blog-list-meta">
                <span><i class="bi bi-person-circle me-1"></i><?= htmlspecialchars(mb_convert_case($gal['author'], MB_CASE_TITLE, 'UTF-8')) ?></span>
                <span><i class="bi bi-calendar3 me-1"></i><?= htmlspecialchars(date('d/m/Y', strtotime($gal['created_at']))) ?></span>
              </div>
            </div>
          </a>
        </div>
        <?php endforeach; ?>
      </div>

      <?php if ($totalPages > 1): ?>
      <nav class="mt-5">
        <ul class="pagination justify-content-center flex-wrap">
          <li class="page-item <?= $page <= 1 ? 'disabled' : '' ?>">
            <a class="page-link" href="galeria.php?page=<?= $page - 1 ?><?= $search ? '&busqueda=' . urlencode($search) : '' ?>"><i class="bi bi-chevron-left"></i></a>
          </li>
          <?php for ($i = 1; $i <= $totalPages; $i++): ?>
          <li class="page-item <?= $i === $page ? 'active' : '' ?>">
            <a class="page-link" href="galeria.php?page=<?= $i ?><?= $search ? '&busqueda=' . urlencode($search) : '' ?>"><?= $i ?></a>
          </li>
          <?php endfor; ?>
          <li class="page-item <?= $page >= $totalPages ? 'disabled' : '' ?>">
            <a class="page-link" href="galeria.php?page=<?= $page + 1 ?><?= $search ? '&busqueda=' . urlencode($search) : '' ?>"><i class="bi bi-chevron-right"></i></a>
          </li>
        </ul>
      </nav>
      <?php endif; ?>
    <?php endif; ?>
  </div>
</section>

<?php require_once __DIR__ . '/Footer.php'; ?>

<script src="node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
