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

  /* ─── VARIANTES ─── */
  .pd-variantes {
    margin: 1.2rem 0;
    display: flex;
    flex-direction: column;
    gap: 1rem;
  }

  .pd-var-grupo {}
  .pd-var-label {
    font-size: .78rem;
    font-weight: 700;
    color: var(--cami-azul);
    margin-bottom: .4rem;
    display: block;
  }
  .pd-var-label .var-selected {
    font-weight: 400;
    opacity: .55;
    margin-left: .3rem;
  }

  .pd-var-opciones {
    display: flex;
    gap: .45rem;
    flex-wrap: wrap;
  }

  .pd-var-btn {
    border: 2px solid var(--cami-border);
    border-radius: 50px;
    background: var(--cami-bg);
    color: var(--cami-azul);
    font-family: var(--font-playpen);
    font-weight: 600;
    font-size: .78rem;
    padding: .4rem 1rem;
    cursor: pointer;
    transition: all .2s;
    display: inline-flex;
    align-items: center;
    gap: .35rem;
    white-space: nowrap;
  }
  .pd-var-btn:hover:not(.disabled):not(.activo) {
    border-color: var(--cami-turq);
    background: rgba(60,174,224,.1);
  }
  .pd-var-btn.activo {
    background: var(--cami-turq);
    border-color: var(--cami-turq);
    color: var(--cami-azul);
  }
  .pd-var-btn.disabled {
    opacity: .3;
    cursor: not-allowed;
    text-decoration: line-through;
  }

  .pd-var-color {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    border: 3px solid var(--cami-border);
    cursor: pointer;
    transition: all .2s;
    position: relative;
    flex-shrink: 0;
  }
  .pd-var-color:hover:not(.disabled):not(.activo) {
    border-color: var(--cami-turq);
    transform: scale(1.12);
  }
  .pd-var-color.activo {
    border-color: var(--cami-azul);
    box-shadow: 0 0 0 3px rgba(60,174,224,.35);
  }
  .pd-var-color.disabled {
    opacity: .25;
    cursor: not-allowed;
  }
  .pd-var-color.disabled::after {
    content: '';
    position: absolute;
    top: 50%;
    left: 10%;
    width: 80%;
    height: 2px;
    background: var(--cami-coral);
    transform: translateY(-50%) rotate(-45deg);
    border-radius: 2px;
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
      const [prodRes, imgRes, varRes] = await Promise.all([
        fetch(`${API_URL}?action=product&id=${PRODUCTO_ID}`),
        fetch(`${API_URL}?action=product_images&id=${PRODUCTO_ID}`),
        fetch(`${API_URL}?action=product_variants&product_id=${PRODUCTO_ID}`)
      ]);
      const prod = await prodRes.json();
      const imgs = await imgRes.json();
      const vars = await varRes.json();

      if (!prod.exito || !prod.datos[0]) {
        document.getElementById('productoWrap').innerHTML = `
        <div class="col-12 empty-state"><i class="bi bi-emoji-frown"></i><p style="opacity:.6;">Producto no encontrado.</p>
        <a href="productos.php" class="btn-p2 mt-3">← Volver a tienda</a></div>`;
        return;
      }
      const p = prod.datos[0];
      const imagenes = imgs.exito ? imgs.datos : [];
      const variantes = vars.exito && vars.datos?.tiene_variantes ? vars.datos : null;
      const agotado = p.stock_agotado || parseInt(p.stock) === 0;

      document.getElementById('bcProducto').textContent = p.nombre;
      renderizar(p, imagenes, agotado, variantes);
    } catch (e) {
      document.getElementById('productoWrap').innerHTML = `
      <div class="col-12 empty-state"><i class="bi bi-wifi-off"></i><p>Error al cargar el producto.</p>
      <a href="productos.php" class="btn-p2 mt-3">← Volver a tienda</a></div>`;
    }
  }

  /* ─── CARRUSEL CUSTOM ─── */
  let slideActual = 0;
  let totalSlidesCarousel = 0;

  const COLOR_MAP = {
    rojo:'#E53935', azul:'#1E88E5', verde:'#43A047', amarillo:'#FDD835',
    naranja:'#FB8C00', naranjado:'#FB8C00', morado:'#8E24AA', purpura:'#8E24AA',
    rosado:'#EC407A', rosa:'#EC407A', negro:'#212121', blanco:'#FAFAFA',
    gris:'#9E9E9E', cafe:'#795548', marron:'#795548', beige:'#D7CCC8',
    dorado:'#FFD700', plateado:'#C0C0C0', turquesa:'#00BCD4',
    celeste:'#81D4FA', vino:'#722F37', mostaza:'#FFB300', oliva:'#827717',
    coral:'#FF7043', fucsia:'#D81B60', lila:'#CE93D8', violeta:'#7B1FA2',
    indigo:'#3F51B5', crema:'#FFF8E1', marfil:'#FFFFF0', chocolate:'#5D4037',
    salmon:'#FF8A65', menta:'#80CBC4', esmeralda:'#2E7D32', rubi:'#C62828',
    zafiro:'#1565C0', ambar:'#FFCA28', granate:'#880E4F', caqui:'#C5B358',
    terracota:'#CC5533', caramelo:'#AF6E4D', piel:'#DEB887', cobre:'#B87333',
    lavanda:'#B39DDB', oro:'#FFD700', plata:'#C0C0C0', bronce:'#CD7F32',
  };

  function traducirColor(nombre) {
    var key = nombre.trim().toLowerCase();
    if (COLOR_MAP[key]) return COLOR_MAP[key];
    return nombre;
  }

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

let variantesData = null;
let seleccionActual = {};
let productoBase = null;

function renderizar(p, imagenes, agotado, variantes) {
  imagenesProducto = imagenes;
  productoBase = p;
  variantesData = variantes;
  seleccionActual = {};

  if (variantes) {
    variantes.atributos.forEach(attr => {
      const primerDisp = attr.valores.find(v => v.disponible);
      if (primerDisp) seleccionActual[attr.id] = primerDisp.id;
    });
  }

  const carouselHtml = construirCarousel(imagenes, p.nombre);
  const primeraImagen = imagenes.length > 0 ? imagenes[0].url : '';
  const tieneDescuento = p.precio_compare && parseFloat(p.precio_compare) > parseFloat(p.precio);
  const tags = p.tags ? p.tags.split(',').map(t => `<span class="pd-tag">${t.trim()}</span>`).join('') : '';

  const varianteEncontrada = encontrarVariante();
  const precioMostrar = varianteEncontrada && varianteEncontrada.precio !== null ? varianteEncontrada.precio : parseFloat(p.precio);
  const compareMostrar = varianteEncontrada && varianteEncontrada.precio_compare !== null ? varianteEncontrada.precio_compare : p.precio_compare;
  const stockMostrar = varianteEncontrada ? varianteEncontrada.stock : parseInt(p.stock);
  const agotadoVariante = stockMostrar === 0;
  const haySeleccionParcial = variantes && Object.keys(seleccionActual).length > 0;
  const varianteCompleta = variantes && variantes.atributos.every(a => seleccionActual[a.id]);
  const puedeComprar = variantes ? (varianteCompleta && !agotadoVariante) : !agotado;

  const variantesHtml = variantes ? construirSelectoresVariantes(variantes) : '';

  const stockLabel = variantes
    ? (varianteCompleta
        ? (agotadoVariante ? 'Agotado' : stockMostrar + ' disponibles')
        : 'Selecciona opciones')
    : (agotado ? 'Agotado' : p.stock + ' disponibles');

  const stockIcon = (variantes && !varianteCompleta) ? 'bi-dash-circle'
    : (agotadoVariante || agotado ? 'bi-x-circle-fill' : 'bi-check-circle-fill');
  const stockClass = (variantes && varianteCompleta && agotadoVariante) || agotado ? 'agotado' : '';

  const html = `
    <div class="col-lg-6">
      ${carouselHtml}
    </div>
    <div class="col-lg-6">
      <div class="pd-info">
        <span class="pd-cat">${p.categoria}</span>
        <h1 class="pd-nombre">${p.nombre}</h1>
        <p class="pd-sku">SKU: ${varianteEncontrada ? varianteEncontrada.sku : (p.sku || '—')}</p>
        <div class="pd-precio-wrap">
          <span class="pd-precio" id="pdPrecio">$${Number(precioMostrar).toLocaleString('es-CO',{minimumFractionDigits:0})}</span>
          ${compareMostrar && parseFloat(compareMostrar) > precioMostrar ? `<span class="pd-precio-old" id="pdPrecioOld">$${Number(compareMostrar).toLocaleString('es-CO',{minimumFractionDigits:0})}</span>` : ''}
        </div>
        <span class="pd-stock ${stockClass}" id="pdStock">
          <i class="bi ${stockIcon}"></i>
          ${stockLabel}
          ${p.is_digital ? '· Producto digital' : ''}
          ${!p.requiere_envio && !p.is_digital ? '· Sin envío' : ''}
        </span>
        ${variantesHtml}
        <p class="pd-descripcion">${p.descripcion || 'Sin descripción disponible.'}</p>
        <div class="pd-actions">
          <button class="btn-p1" id="btnAgregarCarrito" onclick="agregarAlCarritoConVariante()" ${!puedeComprar ? 'disabled' : ''}>
            <i class="bi bi-cart-plus"></i> Agregar al carrito
          </button>
          <button class="btn-p-coral" id="btnComprarAhora" onclick="comprarAhoraConVariante()" ${!puedeComprar ? 'disabled' : ''}>
            <i class="bi bi-lightning-charge-fill"></i> Comprar ahora
          </button>
        </div>
        ${tags ? `<div class="pd-tags">${tags}</div>` : ''}
      </div>
    </div>`;

  document.getElementById('productoWrap').innerHTML = html;
  inicializarCarousel();
}

function construirSelectoresVariantes(variantes) {
  return variantes.atributos.map(attr => {
    const tipoClase = attr.tipo === 'color' ? 'pd-var-color' : 'pd-var-btn';
    const seleccionado = seleccionActual[attr.id] || null;

    const ops = attr.valores.map(v => {
      const activo = v.id === seleccionado ? ' activo' : '';
      const des = !v.disponible ? ' disabled' : '';
      if (attr.tipo === 'color') {
        const bg = v.color_hex || traducirColor(v.valor);
        return `<div class="pd-var-color${activo}${des}"
          onclick="${v.disponible ? `seleccionarVariante(${attr.id},${v.id})` : ''}"
          style="background:${bg};"
          title="${v.valor}${!v.disponible ? ' (agotado)' : ''}"></div>`;
      }
      return `<button class="pd-var-btn${activo}${des}"
        onclick="${v.disponible ? `seleccionarVariante(${attr.id},${v.id})` : ''}"
        ${!v.disponible ? 'disabled' : ''}>${v.valor}</button>`;
    }).join('');

    const nombreSeleccionado = seleccionado
      ? attr.valores.find(v => v.id === seleccionado)
      : null;
    const nombreMostrar = nombreSeleccionado ? ': ' + nombreSeleccionado.valor : '';

    return `<div class="pd-var-grupo">
      <span class="pd-var-label">${attr.nombre}<span class="var-selected">${nombreMostrar}</span></span>
      <div class="pd-var-opciones">${ops}</div>
    </div>`;
  }).join('');
}

function encontrarVariante() {
  if (!variantesData) return null;
  const keys = Object.keys(seleccionActual);
  if (keys.length === 0) return null;

  for (const v of variantesData.variantes) {
    let coincide = true;
    for (const attrId of keys) {
      if (v.atributos[attrId] !== seleccionActual[attrId]) {
        coincide = false;
        break;
      }
    }
    if (coincide) return v;
  }
  return null;
}

function seleccionarVariante(attrId, valueId) {
  if (!variantesData) return;
  seleccionActual[attrId] = valueId;

  const variante = encontrarVariante();
  const p = productoBase;

  const precioMostrar = variante && variante.precio !== null ? variante.precio : parseFloat(p.precio);
  const compareMostrar = variante && variante.precio_compare !== null ? variante.precio_compare : p.precio_compare;
  const stockMostrar = variante ? variante.stock : parseInt(p.stock);
  const varianteCompleta = variantesData.atributos.every(a => seleccionActual[a.id]);
  const agotadoVariante = varianteCompleta && stockMostrar === 0;
  const puedeComprar = varianteCompleta && !agotadoVariante;

  const precioEl = document.getElementById('pdPrecio');
  if (precioEl) precioEl.textContent = '$' + Number(precioMostrar).toLocaleString('es-CO', { minimumFractionDigits: 0 });

  const oldEl = document.getElementById('pdPrecioOld');
  if (oldEl) {
    if (compareMostrar && parseFloat(compareMostrar) > precioMostrar) {
      oldEl.textContent = '$' + Number(compareMostrar).toLocaleString('es-CO', { minimumFractionDigits: 0 });
      oldEl.style.display = '';
    } else {
      oldEl.style.display = 'none';
    }
  }

  const stockEl = document.getElementById('pdStock');
  if (stockEl) {
    const icon = stockEl.querySelector('i');
    if (varianteCompleta) {
      stockEl.className = 'pd-stock ' + (agotadoVariante ? 'agotado' : '');
      if (icon) icon.className = 'bi ' + (agotadoVariante ? 'bi-x-circle-fill' : 'bi-check-circle-fill');
      stockEl.childNodes[stockEl.childNodes.length - 1].textContent = agotadoVariante ? 'Agotado' : stockMostrar + ' disponibles';
    } else {
      stockEl.className = 'pd-stock';
      if (icon) icon.className = 'bi bi-dash-circle';
      stockEl.childNodes[stockEl.childNodes.length - 1].textContent = 'Selecciona opciones';
    }
    let extras = '';
    if (p.is_digital) extras += '· Producto digital';
    if (!p.requiere_envio && !p.is_digital) extras += '· Sin envío';
    if (extras && stockEl.childNodes.length > 2) {
      stockEl.childNodes[stockEl.childNodes.length - 1].textContent += ' ' + extras;
    }
  }

  const skuEl = document.querySelector('.pd-sku');
  if (skuEl && variante) skuEl.textContent = 'SKU: ' + variante.sku;

  const btnCart = document.getElementById('btnAgregarCarrito');
  const btnBuy = document.getElementById('btnComprarAhora');
  if (btnCart) btnCart.disabled = !puedeComprar;
  if (btnBuy) btnBuy.disabled = !puedeComprar;

  const labels = document.querySelectorAll('.pd-var-label .var-selected');
  variantesData.atributos.forEach(attr => {
    const selId = seleccionActual[attr.id];
    const valObj = selId ? attr.valores.find(v => v.id === selId) : null;
    labels.forEach(l => {
      if (l.parentElement && l.parentElement.textContent.startsWith(attr.nombre)) {
        l.textContent = valObj ? ': ' + valObj.valor : '';
      }
    });
  });

  document.querySelectorAll('.pd-var-color, .pd-var-btn').forEach(el => el.classList.remove('activo'));
  variantesData.atributos.forEach(attr => {
    const selId = seleccionActual[attr.id];
    if (selId) {
      document.querySelectorAll(`.pd-var-color[onclick*="seleccionarVariante(${attr.id},${selId})"], .pd-var-btn[onclick*="seleccionarVariante(${attr.id},${selId})"]`).forEach(el => el.classList.add('activo'));
    }
  });
}

function construirLabelVariante() {
  if (!variantesData) return '';
  return variantesData.atributos.map(attr => {
    const selId = seleccionActual[attr.id];
    const valObj = selId ? attr.valores.find(v => v.id === selId) : null;
    return valObj ? valObj.valor : '';
  }).filter(Boolean).join(' / ');
}

function agregarAlCarritoConVariante() {
  const p = productoBase;
  const variante = encontrarVariante();
  const precio = variante && variante.precio !== null ? variante.precio : parseFloat(p.precio);
  const varianteId = variante ? variante.id : null;
  const primeraImagen = imagenesProducto.length > 0 ? imagenesProducto[0].url : '';
  const imagenVariante = variante && variante.imagen ? variante.imagen : primeraImagen;
  const variantLabel = construirLabelVariante();
  window.agregarAlCarrito(p.id, encodeURIComponent(p.nombre), precio, imagenVariante.replace(/'/g, "\\'"), varianteId, variantLabel);
}

function comprarAhoraConVariante() {
  const p = productoBase;
  const variante = encontrarVariante();
  const precio = variante && variante.precio !== null ? variante.precio : parseFloat(p.precio);
  const varianteId = variante ? variante.id : null;
  window.location.href = `checkout.php?id=${p.id}&precio=${precio}${varianteId ? '&variant_id=' + varianteId : ''}`;
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
