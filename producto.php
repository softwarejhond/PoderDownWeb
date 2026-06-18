<?php
$id = (int)($_GET['id'] ?? 0);
if ($id <= 0) {
  header('Location: productos.php');
  exit;
}

$pageTitle = 'Producto — Poder Down';
$pageDescription = 'Detalle del producto';
$activePage = 'productos';
require 'components/header.php';
?>
<style>
  .pd-breadcrumb {
    display: flex;
    gap: .5rem;
    align-items: center;
    font-size: .82rem;
    margin-bottom: 1.5rem;
    flex-wrap: wrap;
  }

  .pd-breadcrumb a {
    color: var(--cami-turq);
    text-decoration: none;
  }

  .pd-breadcrumb a:hover {
    text-decoration: underline;
  }

  .pd-breadcrumb span {
    opacity: .45;
  }

  .pd-carousel-wrap {
    position: relative;
  }

  .pd-carousel {
    border-radius: 20px;
    overflow: hidden;
    background: linear-gradient(135deg, rgba(60, 174, 224, .12), rgba(0, 51, 102, .04));
    position: relative;
  }

  .pd-carousel .pd-slides {
    display: flex;
    transition: transform .45s cubic-bezier(.25, .46, .45, .94);
    will-change: transform;
  }

  .pd-carousel .pd-slide {
    min-width: 100%;
    height: 420px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: zoom-in;
    position: relative;
  }

  .pd-carousel .pd-slide img {
    width: 100%;
    height: 100%;
    object-fit: contain;
    padding: 1.5rem;
    user-select: none;
    pointer-events: auto;
  }

  .pd-carousel .pd-slide .no-img {
    position: absolute;
    inset: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 6rem;
    opacity: .15;
    pointer-events: none;
  }

  .pd-carousel .pd-btn-prev,
  .pd-carousel .pd-btn-next {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: rgba(26, 58, 92, .12);
    backdrop-filter: blur(4px);
    border: none;
    color: var(--cami-azul);
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    font-size: 1.2rem;
    opacity: .85;
    transition: opacity .2s, background .2s;
    z-index: 4;
  }

  .pd-carousel .pd-btn-prev:hover,
  .pd-carousel .pd-btn-next:hover {
    background: rgba(26, 58, 92, .22);
    opacity: 1;
  }

  .pd-carousel .pd-btn-prev {
    left: 10px;
  }

  .pd-carousel .pd-btn-next {
    right: 10px;
  }

  .pd-counter {
    position: absolute;
    bottom: 16px;
    right: 16px;
    background: rgba(26, 58, 92, .65);
    color: #fff;
    border-radius: 50px;
    padding: .2rem .7rem;
    font-size: .72rem;
    font-weight: 600;
    z-index: 5;
    pointer-events: none;
    letter-spacing: .3px;
  }

  .pd-dots {
    position: absolute;
    bottom: 12px;
    left: 50%;
    transform: translateX(-50%);
    display: flex;
    gap: 6px;
    z-index: 4;
  }

  .pd-dots .pd-dot {
    width: 10px;
    height: 10px;
    border-radius: 50%;
    background: var(--cami-azul);
    opacity: .3;
    border: none;
    cursor: pointer;
    padding: 0;
    transition: opacity .25s;
  }

  .pd-dots .pd-dot.active {
    opacity: 1;
    background: var(--cami-turq);
  }

  .pd-thumbnails {
    display: flex;
    gap: .5rem;
    margin-top: .8rem;
    overflow-x: auto;
    padding: .2rem .1rem;
    scrollbar-width: thin;
    scrollbar-color: var(--cami-border) transparent;
  }

  .pd-thumbnails::-webkit-scrollbar {
    height: 4px;
  }

  .pd-thumbnails::-webkit-scrollbar-thumb {
    background: var(--cami-border);
    border-radius: 4px;
  }

  .pd-thumb {
    flex-shrink: 0;
    width: 68px;
    height: 68px;
    border-radius: 12px;
    overflow: hidden;
    border: 3px solid transparent;
    cursor: pointer;
    transition: border-color .25s, opacity .25s;
    opacity: .5;
    background: linear-gradient(135deg, rgba(60, 174, 224, .08), rgba(0, 51, 102, .02));
  }

  .pd-thumb:hover {
    opacity: .75;
  }

  .pd-thumb.active {
    border-color: var(--cami-turq);
    opacity: 1;
  }

  .pd-thumb img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
  }

  .pd-thumb .thumb-placeholder {
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.3rem;
    color: var(--cami-border);
  }

  .pd-lightbox {
    display: none;
    position: fixed;
    inset: 0;
    background: rgba(0, 0, 0, .93);
    z-index: 9999;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: opacity .25s;
  }

  .pd-lightbox.open {
    display: flex;
    opacity: 1;
  }

  .pd-lightbox img {
    max-width: 92vw;
    max-height: 88vh;
    object-fit: contain;
    border-radius: 12px;
    box-shadow: 0 8px 40px rgba(0, 0, 0, .4);
  }

  .pd-lightbox .lb-close,
  .pd-lightbox .lb-prev,
  .pd-lightbox .lb-next {
    position: absolute;
    background: rgba(255, 255, 255, .12);
    border: none;
    color: white;
    border-radius: 50%;
    width: 44px;
    height: 44px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    font-size: 1.3rem;
    transition: background .2s;
    z-index: 2;
  }

  .pd-lightbox .lb-close:hover,
  .pd-lightbox .lb-prev:hover,
  .pd-lightbox .lb-next:hover {
    background: rgba(255, 255, 255, .28);
  }

  .pd-lightbox .lb-close {
    top: 20px;
    right: 20px;
  }

  .pd-lightbox .lb-prev {
    left: 16px;
    top: 50%;
    transform: translateY(-50%);
  }

  .pd-lightbox .lb-next {
    right: 16px;
    top: 50%;
    transform: translateY(-50%);
  }

  .pd-lightbox .lb-counter {
    position: absolute;
    bottom: 20px;
    left: 50%;
    transform: translateX(-50%);
    color: rgba(255, 255, 255, .65);
    font-size: .82rem;
    font-weight: 600;
  }

  .pd-info {
    padding: 1rem 0;
  }

  .pd-cat {
    display: inline-block;
    background: var(--cami-turq);
    color: var(--cami-azul);
    border-radius: 50px;
    padding: .3rem 1rem;
    font-size: .78rem;
    font-weight: 700;
    margin-bottom: .8rem;
  }

  .pd-nombre {
    font-family: var(--font-kranky);
    font-size: clamp(1.4rem, 3vw, 2rem);
    color: var(--cami-azul);
    margin: 0 0 .5rem;
    line-height: 1.2;
  }

  .pd-sku {
    font-size: .78rem;
    opacity: .4;
    margin-bottom: 1rem;
  }

  .pd-precio-wrap {
    display: flex;
    align-items: baseline;
    gap: 1rem;
    margin: 1.2rem 0;
  }

  .pd-precio {
    font-family: var(--font-kranky);
    font-size: 2.4rem;
    color: var(--cami-azul);
  }

  .pd-precio-old {
    font-size: 1.1rem;
    opacity: .35;
    text-decoration: line-through;
  }

  .pd-descripcion {
    font-size: .92rem;
    line-height: 1.9;
    opacity: .72;
    margin: 1rem 0 1.5rem;
  }

  .pd-stock {
    display: inline-flex;
    align-items: center;
    gap: .4rem;
    background: rgba(60, 174, 224, .12);
    color: var(--cami-azul);
    border-radius: 50px;
    padding: .4rem 1rem;
    font-size: .82rem;
    font-weight: 700;
  }

  .pd-stock.agotado {
    background: rgba(242, 103, 124, .15);
    color: var(--cami-coral);
  }

  .pd-actions {
    display: flex;
    gap: .8rem;
    flex-wrap: wrap;
    margin-top: 2rem;
  }

  .pd-actions .btn-p1,
  .pd-actions .btn-p-coral {
    padding: .8rem 2rem;
    font-size: .95rem;
    flex: 1;
    justify-content: center;
    min-width: 180px;
  }

  .pd-tags {
    margin-top: 1.5rem;
    padding-top: 1.2rem;
    border-top: 2px solid var(--cami-border);
  }

  .pd-tag {
    display: inline-block;
    background: var(--cami-bg);
    border-radius: 50px;
    padding: .25rem .8rem;
    font-size: .73rem;
    margin: .2rem;
    opacity: .7;
  }

  .pd-carousel.nophoto {
    height: 420px;
  }

  @media (max-width:767px) {
    .pd-carousel .pd-slide {
      height: 300px;
    }

    .pd-carousel.nophoto {
      height: 300px;
    }

    .pd-precio {
      font-size: 2rem;
    }

    .pd-actions .btn-p1,
    .pd-actions .btn-p-coral {
      min-width: 140px;
      font-size: .88rem;
      padding: .7rem 1.4rem;
    }
  }

  @media (max-width:575px) {
    .pd-carousel .pd-slide {
      height: 240px;
    }

    .pd-carousel .pd-slide img {
      padding: .5rem;
    }

    .pd-carousel.nophoto {
      height: 240px;
    }
  }
</style>

<div class="container" style="padding:2.5rem 0 4rem;">
  <div class="pd-breadcrumb">
    <a href="index.php"><i class="bi bi-house-fill"></i> Inicio</a>
    <span>/</span>
    <a href="productos.php">Tienda</a>
    <span>/</span>
    <span id="bcProducto">Cargando...</span>
  </div>

  <div class="row g-5 align-items-start" id="productoWrap">
    <div class="col-12 text-center py-5">
      <div class="spinner-border" style="color:var(--cami-turq);" role="status"></div>
      <p style="opacity:.6;margin-top:1rem;">Cargando producto...</p>
    </div>
  </div>
</div>

<div class="pd-lightbox" id="pdLightbox" onclick="if(event.target===this)cerrarLightbox()">
  <button class="lb-close" onclick="cerrarLightbox()" aria-label="Cerrar"><i class="bi bi-x-lg"></i></button>
  <button class="lb-prev" id="lbPrev" onclick="navegarLightbox(-1)" aria-label="Anterior"><i class="bi bi-chevron-left"></i></button>
  <button class="lb-next" id="lbNext" onclick="navegarLightbox(1)" aria-label="Siguiente"><i class="bi bi-chevron-right"></i></button>
  <span class="lb-counter" id="lbCounter"></span>
  <img src="" alt="" id="lbImg">
</div>

<?php require_once __DIR__ . '/Footer.php'; ?>

<script src="node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
<script src="node_modules/sweetalert2/dist/sweetalert2.all.min.js"></script>

<script>
const API_URL = 'components/productos/cargar_productos.php';
const PRODUCTO_ID = <?= $id ?>;
let imagenesProducto = [];

  /* ─── TOGGLES (header) ─── */
  function toggleMobileMenu() {
    const m = document.getElementById('navMobileMenu'),
      i = document.getElementById('hamburger-icon');
    m.classList.toggle('open');
    i.className = m.classList.contains('open') ? 'bi bi-x-lg' : 'bi bi-list';
  }

  function closeMobileMenu() {
    document.getElementById('navMobileMenu').classList.remove('open');
    document.getElementById('hamburger-icon').className = 'bi bi-list';
  }

  async function cargarProducto() {
    try {
      const [prodRes, imgRes] = await Promise.all([
        fetch(`${API_URL}?action=product&id=${PRODUCTO_ID}`),
        fetch(`${API_URL}?action=product_images&id=${PRODUCTO_ID}`)
      ]);
      const prod = await prodRes.json();
      const imgs = await imgRes.json();

      if (!prod.exito || !prod.datos[0]) {
        document.getElementById('productoWrap').innerHTML = `
        <div class="col-12 empty-state"><i class="bi bi-emoji-frown"></i><p style="opacity:.6;">Producto no encontrado.</p>
        <a href="productos.php" class="btn-p2 mt-3">← Volver a tienda</a></div>`;
        return;
      }
      const p = prod.datos[0];
      const imagenes = imgs.exito ? imgs.datos : [];
      const agotado = p.stock_agotado || parseInt(p.stock) === 0;

      document.getElementById('bcProducto').textContent = p.nombre;
      renderizar(p, imagenes, agotado);
    } catch (e) {
      document.getElementById('productoWrap').innerHTML = `
      <div class="col-12 empty-state"><i class="bi bi-wifi-off"></i><p>Error al cargar el producto.</p>
      <a href="productos.php" class="btn-p2 mt-3">← Volver a tienda</a></div>`;
    }
  }

  /* ─── CARRUSEL CUSTOM ─── */
  let slideActual = 0;
  let totalSlidesCarousel = 0;

  function construirCarousel(imagenes, nombreProducto) {
    if (!imagenes.length) {
      return `<div class="pd-carousel-wrap"><div class="pd-carousel nophoto d-flex align-items-center justify-content-center"><i class="bi bi-image no-img"></i></div></div>`;
    }

    totalSlidesCarousel = imagenes.length;
    slideActual = 0;

    let slidesHtml = '',
      dotsHtml = '',
      thumbsHtml = '';
    imagenes.forEach((img, i) => {
      const altText = (img.alt || nombreProducto).replace(/"/g, '&quot;');
      slidesHtml += `<div class="pd-slide">
      <img src="${img.url}" alt="${altText}" loading="${i===0?'eager':'lazy'}" onerror="this.style.display='none';this.nextElementSibling.style.display='flex'" onclick="abrirLightbox(${i})">
      <div class="no-img" style="display:none"><i class="bi bi-image"></i></div>
    </div>`;
      dotsHtml += `<button class="pd-dot${i===0?' active':''}" onclick="irASlide(${i})" aria-label="Imagen ${i+1}"></button>`;
      thumbsHtml += `<div class="pd-thumb${i===0?' active':''}" onclick="irASlide(${i})">
      <img src="${img.url}" alt="${altText}" loading="lazy" onerror="this.style.display='none';this.nextElementSibling.style.display='flex'">
      <div class="thumb-placeholder" style="display:none"><i class="bi bi-image"></i></div>
    </div>`;
    });

    const controles = imagenes.length > 1 ? `
    <button class="pd-btn-prev" onclick="slideAnterior()" aria-label="Anterior"><i class="bi bi-chevron-left"></i></button>
    <button class="pd-btn-next" onclick="slideSiguiente()" aria-label="Siguiente"><i class="bi bi-chevron-right"></i></button>` : '';

    return `<div class="pd-carousel-wrap" id="pdCarouselWrap">
    <div class="pd-carousel" id="pdCarousel">
      <span class="pd-counter">1 / ${imagenes.length}</span>
      <div class="pd-slides" id="pdSlides">${slidesHtml}</div>
      <div class="pd-dots">${dotsHtml}</div>
      ${controles}
    </div>
    ${imagenes.length > 1 ? `<div class="pd-thumbnails">${thumbsHtml}</div>` : ''}
  </div>`;
  }

  function irASlide(index) {
    if (index < 0 || index >= totalSlidesCarousel) return;
    slideActual = index;
    const slides = document.getElementById('pdSlides');
    if (slides) slides.style.transform = `translateX(-${index * 100}%)`;

    document.querySelectorAll('.pd-dot').forEach((d, i) => d.classList.toggle('active', i === index));
    document.querySelectorAll('.pd-thumb').forEach((t, i) => t.classList.toggle('active', i === index));
    const counter = document.querySelector('.pd-counter');
    if (counter) counter.textContent = `${index + 1} / ${totalSlidesCarousel}`;
  }

  function slideAnterior() {
    irASlide((slideActual - 1 + totalSlidesCarousel) % totalSlidesCarousel);
  }

  function slideSiguiente() {
    irASlide((slideActual + 1) % totalSlidesCarousel);
  }

  function inicializarCarousel() {
    const slides = document.getElementById('pdSlides');
    if (!slides || totalSlidesCarousel <= 1) return;

    let touchStartX = 0,
      touchEndX = 0;
    slides.addEventListener('touchstart', e => {
      touchStartX = e.touches[0].clientX;
    }, {
      passive: true
    });
    slides.addEventListener('touchend', e => {
      touchEndX = e.changedTouches[0].clientX;
      const diff = touchStartX - touchEndX;
      if (Math.abs(diff) > 50) {
        if (diff > 0) slideSiguiente();
        else slideAnterior();
      }
    });

    document.addEventListener('keydown', function tecladoCarousel(e) {
      if (!document.getElementById('pdCarousel')) {
        document.removeEventListener('keydown', tecladoCarousel);
        return;
      }
      if (e.key === 'ArrowLeft') {
        e.preventDefault();
        slideAnterior();
      }
      if (e.key === 'ArrowRight') {
        e.preventDefault();
        slideSiguiente();
      }
      if (e.key === 'Escape') {
        cerrarLightbox();
      }
    });
  }

  /* ─── LIGHTBOX ─── */
  let indiceLightbox = 0;

  function abrirLightbox(index) {
    if (!imagenesProducto.length) return;
    indiceLightbox = index;
    const img = imagenesProducto[index];
    if (!img) return;
    const lb = document.getElementById('pdLightbox');
    const lbImg = document.getElementById('lbImg');
    lbImg.src = img.url;
    lbImg.alt = img.alt || '';
    document.getElementById('lbCounter').textContent = imagenesProducto.length > 1 ? `${index + 1} / ${imagenesProducto.length}` : '';
    document.getElementById('lbPrev').style.display = imagenesProducto.length > 1 ? '' : 'none';
    document.getElementById('lbNext').style.display = imagenesProducto.length > 1 ? '' : 'none';
    lb.classList.add('open');
    document.body.style.overflow = 'hidden';
  }

  function cerrarLightbox() {
    document.getElementById('pdLightbox').classList.remove('open');
    document.body.style.overflow = '';
  }

  function navegarLightbox(dir) {
    if (!imagenesProducto.length) return;
    indiceLightbox = (indiceLightbox + dir + imagenesProducto.length) % imagenesProducto.length;
    const img = imagenesProducto[indiceLightbox];
    document.getElementById('lbImg').src = img.url;
    document.getElementById('lbImg').alt = img.alt || '';
    document.getElementById('lbCounter').textContent = `${indiceLightbox + 1} / ${imagenesProducto.length}`;
  }

function renderizar(p, imagenes, agotado) {
  imagenesProducto = imagenes;
  const carouselHtml = construirCarousel(imagenes, p.nombre);
  const primeraImagen = imagenes.length > 0 ? imagenes[0].url : '';

    const tieneDescuento = p.precio_compare && parseFloat(p.precio_compare) > parseFloat(p.precio);
    const tags = p.tags ? p.tags.split(',').map(t => `<span class="pd-tag">${t.trim()}</span>`).join('') : '';

    const html = `
    <div class="col-lg-6">
      ${carouselHtml}
    </div>
    <div class="col-lg-6">
      <div class="pd-info">
        <span class="pd-cat">${p.categoria}</span>
        <h1 class="pd-nombre">${p.nombre}</h1>
        <p class="pd-sku">SKU: ${p.sku || '—'}</p>
        <div class="pd-precio-wrap">
          <span class="pd-precio">$${Number(p.precio).toLocaleString('es-CO',{minimumFractionDigits:0})}</span>
          ${tieneDescuento ? `<span class="pd-precio-old">$${Number(p.precio_compare).toLocaleString('es-CO',{minimumFractionDigits:0})}</span>` : ''}
        </div>
        <span class="pd-stock ${agotado?'agotado':''}">
          <i class="bi ${agotado?'bi-x-circle-fill':'bi-check-circle-fill'}"></i>
          ${agotado ? 'Agotado' : p.stock + ' disponibles'}
          ${p.is_digital ? '· Producto digital' : ''}
          ${!p.requiere_envio && !p.is_digital ? '· Sin envío' : ''}
        </span>
        <p class="pd-descripcion">${p.descripcion || 'Sin descripción disponible.'}</p>
        <div class="pd-actions">
          <button class="btn-p1" onclick="agregarAlCarrito(${p.id},'${encodeURIComponent(p.nombre)}',${p.precio},'${primeraImagen.replace(/'/g,"\\'")}')" ${agotado?'disabled':''}>
            <i class="bi bi-cart-plus"></i> Agregar al carrito
          </button>
          <button class="btn-p-coral" onclick="comprarAhora(${p.id},${p.precio})" ${agotado?'disabled':''}>
            <i class="bi bi-lightning-charge-fill"></i> Comprar ahora
          </button>
        </div>
        ${tags ? `<div class="pd-tags">${tags}</div>` : ''}
      </div>
    </div>`;

    document.getElementById('productoWrap').innerHTML = html;
    inicializarCarousel();
}

  /* ─── COMPRAR AHORA ─── */
  function comprarAhora(id, precio) {
    window.location.href = `checkout.php?id=${id}&precio=${precio}`;
  }

  /* ─── FAB / DISLEXIA ─── */
  function toggleFabSocial() {
    const l = document.getElementById('fabSocialLinks'),
      i = document.getElementById('fabIconMain');
    l.classList.toggle('open');
    i.className = l.classList.contains('open') ? 'bi bi-x-lg' : 'bi bi-share-fill';
  }
  document.addEventListener('click', e => {
    const w = document.getElementById('fabSocialWrap');
    if (w && !w.contains(e.target)) {
      document.getElementById('fabSocialLinks')?.classList.remove('open');
      const i = document.getElementById('fabIconMain');
      if (i) i.className = 'bi bi-share-fill';
    }
  });

  let dyslexiaOn = localStorage.getItem('pd_dyslexia') === '1';

  function applyDyslexia() {
    document.body.classList.toggle('dyslexia-mode', dyslexiaOn);
    const l = document.getElementById('dyslexiaLabelMain'),
      b = document.getElementById('btnDyslexiaFloat');
    if (l) l.textContent = dyslexiaOn ? 'Normal' : 'Dislexia';
    if (b) {
      b.style.background = dyslexiaOn ? 'var(--cami-turq)' : 'var(--cami-azul)';
      b.style.color = dyslexiaOn ? 'var(--cami-azul)' : 'white';
    }
  }

  function toggleDyslexia() {
    dyslexiaOn = !dyslexiaOn;
    localStorage.setItem('pd_dyslexia', dyslexiaOn ? '1' : '0');
    applyDyslexia();
  }
  applyDyslexia();

  cargarProducto();
</script>
</body>

</html>
