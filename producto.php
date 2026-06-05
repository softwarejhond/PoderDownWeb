<?php
$id = (int)($_GET['id'] ?? 0);
if ($id <= 0) { header('Location: productos.php'); exit; }

$pageTitle = 'Producto — Poder Down';
$pageDescription = 'Detalle del producto';
$activePage = 'productos';
require 'components/header.php';
?>
<style>
  .pd-breadcrumb { display:flex;gap:.5rem;align-items:center;font-size:.82rem;margin-bottom:1.5rem;flex-wrap:wrap; }
  .pd-breadcrumb a { color:var(--cami-turq);text-decoration:none; }
  .pd-breadcrumb a:hover { text-decoration:underline; }
  .pd-breadcrumb span { opacity:.45; }
  .pd-carousel { border-radius:20px;overflow:hidden;background:linear-gradient(135deg,rgba(60,174,224,.12),rgba(0,51,102,.04)); }
  .pd-carousel .carousel-item { height:420px;display:flex;align-items:center;justify-content:center; }
  .pd-carousel .carousel-item img { width:100%;height:100%;object-fit:contain;padding:1.5rem; }
  .pd-carousel .carousel-item .no-img { font-size:6rem;opacity:.15; }
  .pd-carousel .carousel-indicators { bottom:-10px; }
  .pd-carousel .carousel-indicators button { width:10px;height:10px;border-radius:50%;background:var(--cami-azul);opacity:.3; }
  .pd-carousel .carousel-indicators button.active { opacity:1;background:var(--cami-turq); }
  .pd-carousel .carousel-control-prev,.pd-carousel .carousel-control-next { width:44px;height:44px;border-radius:50%;background:rgba(0,0,0,.08);top:50%;transform:translateY(-50%); }
  .pd-carousel .carousel-control-prev-icon,.pd-carousel .carousel-control-next-icon { filter:invert(.4); }
  .pd-info { padding:1rem 0; }
  .pd-cat { display:inline-block;background:var(--cami-turq);color:var(--cami-azul);border-radius:50px;padding:.3rem 1rem;font-size:.78rem;font-weight:700;margin-bottom:.8rem; }
  .pd-nombre { font-family:var(--font-kranky);font-size:clamp(1.4rem,3vw,2rem);color:var(--cami-azul);margin:0 0 .5rem;line-height:1.2; }
  .pd-sku { font-size:.78rem;opacity:.4;margin-bottom:1rem; }
  .pd-precio-wrap { display:flex;align-items:baseline;gap:1rem;margin:1.2rem 0; }
  .pd-precio { font-family:var(--font-kranky);font-size:2.4rem;color:var(--cami-azul); }
  .pd-precio-old { font-size:1.1rem;opacity:.35;text-decoration:line-through; }
  .pd-descripcion { font-size:.92rem;line-height:1.9;opacity:.72;margin:1rem 0 1.5rem; }
  .pd-stock { display:inline-flex;align-items:center;gap:.4rem;background:rgba(60,174,224,.12);color:var(--cami-azul);border-radius:50px;padding:.4rem 1rem;font-size:.82rem;font-weight:700; }
  .pd-stock.agotado { background:rgba(242,103,124,.15);color:var(--cami-coral); }
  .pd-actions { display:flex;gap:.8rem;flex-wrap:wrap;margin-top:2rem; }
  .pd-actions .btn-p1,.pd-actions .btn-p-coral { padding:.8rem 2rem;font-size:.95rem;flex:1;justify-content:center;min-width:180px; }
  .pd-tags { margin-top:1.5rem;padding-top:1.2rem;border-top:2px solid var(--cami-border); }
  .pd-tag { display:inline-block;background:var(--cami-bg);border-radius:50px;padding:.25rem .8rem;font-size:.73rem;margin:.2rem;opacity:.7; }
  @media (max-width:767px) {
    .pd-carousel .carousel-item { height:300px; }
    .pd-precio { font-size:2rem; }
    .pd-actions .btn-p1,.pd-actions .btn-p-coral { min-width:140px;font-size:.88rem;padding:.7rem 1.4rem; }
  }
  @media (max-width:575px) {
    .pd-carousel .carousel-item { height:240px; }
    .pd-carousel .carousel-item img { padding:.5rem; }
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

<?php require_once __DIR__ . '/footer.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
const API_URL = 'components/productos/cargar_productos.php';
const PRODUCTO_ID = <?= $id ?>;
let carrito = [];

/* ─── TOGGLES (header) ─── */
function toggleMobileMenu() {
  const m = document.getElementById('navMobileMenu'), i = document.getElementById('hamburger-icon');
  m.classList.toggle('open'); i.className = m.classList.contains('open') ? 'bi bi-x-lg' : 'bi bi-list';
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

function renderizar(p, imagenes, agotado) {
  // Carrusel
  let carouselHtml;
  if (imagenes.length > 0) {
    let items = '', indicators = '';
    imagenes.forEach((img, i) => {
      const active = i === 0 ? ' active' : '';
      items += `<div class="carousel-item${active}">
        <img src="${img.url}" alt="${(img.alt||p.nombre).replace(/"/g,'&quot;')}" onerror="this.outerHTML='<div class=\\'carousel-item${active}\\'><div class=\\'no-img\\'><i class=\\'bi bi-image\\'></i></div></div>'">
      </div>`;
      indicators += `<button type="button" data-bs-target="#pdCarousel" data-bs-slide-to="${i}" class="${active? 'active':''}" aria-label="${img.alt||'Imagen '+(i+1)}"></button>`;
    });
    carouselHtml = `<div id="pdCarousel" class="carousel slide pd-carousel" data-bs-ride="false">
      <div class="carousel-indicators">${indicators}</div>
      <div class="carousel-inner">${items}</div>
      ${imagenes.length > 1 ? `
      <button class="carousel-control-prev" type="button" data-bs-target="#pdCarousel" data-bs-slide="prev"><span class="carousel-control-prev-icon"></span></button>
      <button class="carousel-control-next" type="button" data-bs-target="#pdCarousel" data-bs-slide="next"><span class="carousel-control-next-icon"></span></button>` : ''}
    </div>`;
  } else {
    carouselHtml = `<div class="pd-carousel d-flex align-items-center justify-content-center" style="height:420px;"><i class="bi bi-image no-img"></i></div>`;
  }

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
          <button class="btn-p1" onclick="agregarAlCarrito(${p.id},'${encodeURIComponent(p.nombre)}',${p.precio})" ${agotado?'disabled':''}>
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
}

/* ─── AGREGAR AL CARRITO ─── */
function agregarAlCarrito(id, nombre, precio) {
  nombre = decodeURIComponent(nombre);
  const ex = carrito.find(i => i.id === id);
  if (ex) ex.cantidad++;
  else carrito.push({ id, nombre, precio: Number(precio), cantidad: 1 });
  actualizarContadorCarrito();
  Swal.fire({ toast: true, position: 'bottom-end', icon: 'success', title: `¡${nombre} agregado!`, showConfirmButton: false, timer: 2200, timerProgressBar: true, background: '#ebeae4', color: '#1A3A5C' });
}
function actualizarContadorCarrito() {
  document.getElementById('contadorCarrito').textContent = carrito.reduce((a,i) => a+i.cantidad, 0);
}

/* ─── COMPRAR AHORA ─── */
function comprarAhora(id, precio) {
  window.location.href = `checkout.php?id=${id}&precio=${precio}`;
}

/* ─── CARRITO (modal) ─── */
function verCarrito() {
  if (!carrito.length) {
    Swal.fire({ title: '<span style="font-family:var(--font-kranky)">Carrito vacío 🛍️</span>', html: '<p style="font-family:var(--font-archivo)">Agrega productos desde el catálogo.</p>', confirmButtonColor: '#3CAEE0', confirmButtonText: 'Seguir comprando' });
    return;
  }
  const ti = carrito.reduce((a,i)=>a+i.cantidad,0), tp = carrito.reduce((a,i)=>a+i.precio*i.cantidad,0);
  Swal.fire({
    title: '<span style="font-family:var(--font-kranky)">Mi carrito 🛍️</span>',
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
  }).then(r=>{if(r.isConfirmed) window.location.href='checkout.php?'+carrito.map(i=>'items[]='+i.id+'&qty[]='+i.cantidad).join('&')+'&total='+tp;});
}
function cambiarCantidad(id, delta) {
  const item = carrito.find(i=>i.id===id); if(!item) return;
  item.cantidad = Math.max(1, item.cantidad+delta); actualizarContadorCarrito();
  Swal.close(); setTimeout(()=>verCarrito(), 50);
}
function quitarItem(id) {
  carrito = carrito.filter(i=>i.id!==id); actualizarContadorCarrito();
  Swal.close(); if(carrito.length>0) setTimeout(()=>verCarrito(), 50);
}

/* ─── FAB / DISLEXIA (mismos que en header) ─── */
function toggleFabSocial() {
  const l=document.getElementById('fabSocialLinks'),i=document.getElementById('fabIconMain');
  l.classList.toggle('open');i.className=l.classList.contains('open')?'bi bi-x-lg':'bi bi-share-fill';
}
document.addEventListener('click',e=>{const w=document.getElementById('fabSocialWrap');if(w&&!w.contains(e.target)){document.getElementById('fabSocialLinks')?.classList.remove('open');const i=document.getElementById('fabIconMain');if(i)i.className='bi bi-share-fill';}});

let dyslexiaOn=localStorage.getItem('pd_dyslexia')==='1';
function applyDyslexia(){document.body.classList.toggle('dyslexia-mode',dyslexiaOn);const l=document.getElementById('dyslexiaLabelMain'),b=document.getElementById('btnDyslexiaFloat');if(l)l.textContent=dyslexiaOn?'Normal':'Dislexia';if(b){b.style.background=dyslexiaOn?'var(--cami-turq)':'var(--cami-azul)';b.style.color=dyslexiaOn?'var(--cami-azul)':'white';}}
function toggleDyslexia(){dyslexiaOn=!dyslexiaOn;localStorage.setItem('pd_dyslexia',dyslexiaOn?'1':'0');applyDyslexia();}
applyDyslexia();

cargarProducto();
</script>
</body>
</html>
