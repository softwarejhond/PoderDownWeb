<?php
$pageTitle = 'Tienda — Poder Down by María Camila González Torres';
$pageDescription = 'Tienda oficial de Poder Down — Arte único de María Camila González Torres. Envíos a toda Colombia.';
$activePage = 'productos';
$ogTitle = 'Tienda Poder Down';
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
    top: -60px;
    right: -60px;
    width: 300px;
    height: 300px;
    background: rgba(60, 174, 224, .15);
    border-radius: 50%;
  }
  .page-header::after {
    content: '';
    position: absolute;
    bottom: -40px;
    left: 10%;
    width: 180px;
    height: 180px;
    background: rgba(242, 103, 124, .12);
    border-radius: 50%;
  }
  .page-header h1 {
    font-family: var(--font-kranky);
    color: white;
    font-size: clamp(2rem, 5vw, 3.5rem);
    margin: 0;
  }
  .page-header p { color: rgba(255,255,255,.7); font-size: 1rem; margin: .8rem 0 0; }
  .breadcrumb-cami { display: flex; gap: .5rem; align-items: center; margin-bottom: 1rem; font-size: .8rem; }
  .breadcrumb-cami a { color: var(--cami-turq); text-decoration: none; }
  .breadcrumb-cami a:hover { text-decoration: underline; }
  .breadcrumb-cami span { color: rgba(255,255,255,.45); }

  /* FILTROS */
  .filtro-bar {
    background: white;
    border-bottom: 2px solid var(--cami-border);
    padding: 1.2rem 0;
    position: sticky;
    top: 72px;
    z-index: 100;
  }
  .filtro-range {
    border-radius: 50px !important;
    border: 2px solid var(--cami-border) !important;
    font-family: var(--font-playpen) !important;
    background: var(--cami-bg) !important;
    padding: .4rem .8rem !important;
    font-size: .82rem !important;
    width: 100px !important;
  }
  .filtro-range:focus {
    border-color: var(--cami-turq) !important;
    box-shadow: 0 0 0 3px rgba(60, 174, 224, .2) !important;
    outline: none;
  }
  .filtro-label { font-size: .78rem; opacity: .6; white-space: nowrap; }
  .filtro-check { display: flex; align-items: center; gap: .4rem; font-size: .82rem; font-weight: 600; cursor: pointer; white-space: nowrap; }
  .filtro-check input { width: 16px; height: 16px; accent-color: var(--cami-turq); cursor: pointer; }
  .filtro-clear { background: none; border: none; color: var(--cami-coral); font-size: .78rem; font-weight: 700; cursor: pointer; text-decoration: underline; padding: 0; }
  .filtro-clear:hover { opacity: .7; }

  /* CATEGORÍAS ACORDEÓN */
  .cat-toggle {
    background: none;
    border: none;
    color: var(--cami-azul);
    font-family: var(--font-playpen);
    font-weight: 700;
    font-size: .82rem;
    cursor: pointer;
    padding: 0;
    display: flex;
    align-items: center;
    gap: .4rem;
    opacity: .7;
    transition: opacity .2s;
  }
  .cat-toggle:hover { opacity: 1; }
  .cat-toggle i { transition: transform .25s; font-size: .7rem; }
  .cat-toggle.open i { transform: rotate(180deg); }
  .cat-body { overflow: hidden; transition: max-height .35s ease, opacity .3s ease; max-height: 0; opacity: 0; }
  .cat-body.open { max-height: 300px; opacity: 1; }

  /* PAGINACIÓN */
  .pagination-cami {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: .35rem;
    margin-top: 2.5rem;
    flex-wrap: wrap;
  }
  .page-btn {
    min-width: 38px;
    height: 38px;
    border-radius: 50px;
    border: 2px solid var(--cami-border);
    background: white;
    color: var(--cami-azul);
    font-family: var(--font-playpen);
    font-weight: 700;
    font-size: .82rem;
    cursor: pointer;
    transition: all .2s;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 0 .6rem;
  }
  .page-btn:hover:not(.activo):not(:disabled) {
    border-color: var(--cami-turq);
    background: rgba(60, 174, 224, .1);
  }
  .page-btn.activo {
    background: var(--cami-turq);
    border-color: var(--cami-turq);
    color: var(--cami-azul);
  }
  .page-btn:disabled {
    opacity: .3;
    cursor: not-allowed;
  }
  .page-btn-nav {
    background: var(--cami-bg);
    font-size: .9rem;
  }
  .page-info {
    font-size: .8rem;
    opacity: .55;
    margin: 0 1rem;
    white-space: nowrap;
  }

  /* PRODUCT IMG */
  .product-card-cami .img-wrap { overflow: hidden; }
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

  @media (max-width:575px) {
    .filtro-bar { top: 60px; }
    .page-header { padding: 2.5rem 0 2rem; }
    .filtro-range { width: 80px !important; font-size: .76rem !important; padding: .3rem .6rem !important; }
    .page-btn { min-width: 34px; height: 34px; font-size: .76rem; }
  }
</style>

<!-- PAGE HEADER -->
<div class="page-header">
  <div class="container position-relative" style="z-index:1;">
    <div class="breadcrumb-cami">
      <a href="index.php"><i class="bi bi-house-fill"></i> Inicio</a>
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
      <div class="d-flex gap-2" style="min-width:200px;max-width:360px;flex:1;">
        <input type="text" id="searchProductos" class="form-control input-search-cami flex-grow-1"
          placeholder="Buscar producto..."
          onkeydown="if(event.key==='Enter'){aplicarFiltros()}">
        <button class="btn-p1" style="white-space:nowrap;padding:.6rem 1.2rem;font-size:.85rem;" onclick="aplicarFiltros()">
          <i class="bi bi-search"></i>
        </button>
      </div>
      <div class="d-flex gap-2 align-items-center flex-wrap">
        <span class="filtro-label">Precio:</span>
        <input type="number" id="precioMin" class="form-control filtro-range" placeholder="Mín" min="0" step="1000">
        <span style="opacity:.3;">—</span>
        <input type="number" id="precioMax" class="form-control filtro-range" placeholder="Máx" min="0" step="1000">
      </div>
      <label class="filtro-check">
        <input type="checkbox" id="soloStock" onchange="aplicarFiltros()">
        Solo disponibles
      </label>
      <button class="filtro-clear" onclick="limpiarFiltros()">Limpiar filtros</button>
    </div>

    <!-- CATEGORÍAS ACORDEÓN -->
    <div class="mt-3">
      <button class="cat-toggle" id="catToggle" onclick="toggleCategorias()">
        <i class="bi bi-chevron-down"></i> Filtrar por categoría
      </button>
      <div class="cat-body" id="catBody">
        <div class="d-flex gap-2 flex-wrap pt-2" id="filtrosCategorias">
          <button class="filtro-btn activo" onclick="filtrarCategoria(this,0)" data-cat-id="0">✨ Todos</button>
        </div>
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
        <select id="ordenSelect" class="form-select" style="width:auto;border-radius:50px;border:2px solid var(--cami-border);font-family:var(--font-playpen);font-size:.82rem;padding:.35rem 1rem;" onchange="irAPagina(1)">
          <option value="nombre">Nombre A-Z</option>
          <option value="precio_asc">Precio ↑</option>
          <option value="precio_desc">Precio ↓</option>
          <option value="nuevos">Más nuevos</option>
          <option value="vendidos">Más vendidos</option>
        </select>
      </div>
    </div>
    <div class="row g-4" id="gridProductos">
      <div class="col-12 text-center py-5">
        <div class="spinner-border" style="color:var(--cami-turq);" role="status"></div>
        <p style="opacity:.6;margin-top:1rem;">Cargando el catálogo...</p>
      </div>
    </div>
    <!-- PAGINACIÓN -->
    <div class="pagination-cami" id="paginacionWrap"></div>
  </div>
</section>

<?php require_once __DIR__ . '/footer.php'; ?>

<script src="node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
<script src="node_modules/sweetalert2/dist/sweetalert2.all.min.js"></script>

<script>
const API_URL = 'components/productos/cargar_productos.php';
const PROD_POR_PAGINA = 16;
let paginaActual = 1,
  categoriaId = 0,
  totalProductos = 0;

/* ─── MOBILE MENU ─── */
function toggleMobileMenu() {
  document.getElementById('navMobileMenu').classList.toggle('open');
  document.getElementById('hamburger-icon').className =
    document.getElementById('navMobileMenu').classList.contains('open') ? 'bi bi-x-lg' : 'bi bi-list';
}
function closeMobileMenu() {
  document.getElementById('navMobileMenu').classList.remove('open');
  document.getElementById('hamburger-icon').className = 'bi bi-list';
}

/* ─── CATEGORÍAS ACORDEÓN ─── */
function toggleCategorias() {
  document.getElementById('catBody').classList.toggle('open');
  document.getElementById('catToggle').classList.toggle('open');
}

/* ─── INICIO ─── */
async function iniciarProductos() {
  await cargarCategorias();
  await irAPagina(1);
}

/* ─── CATEGORÍAS ─── */
async function cargarCategorias() {
  try {
    const res = await fetch(`${API_URL}?action=categories`);
    const json = await res.json();
    if (!json.exito) return;
    const cont = document.getElementById('filtrosCategorias');
    json.datos.forEach(c => {
      if (c.total_productos === 0) return;
      const btn = document.createElement('button');
      btn.className = 'filtro-btn';
      btn.dataset.catId = c.id;
      btn.textContent = c.name + ' (' + c.total_productos + ')';
      btn.onclick = () => filtrarCategoria(btn, c.id);
      cont.appendChild(btn);
    });
  } catch (e) {}
}

/* ─── CARGAR PÁGINA ─── */
async function irAPagina(pagina) {
  paginaActual = pagina;
  const offset = (paginaActual - 1) * PROD_POR_PAGINA;

  document.getElementById('gridProductos').innerHTML = `
    <div class="col-12 text-center py-5">
      <div class="spinner-border" style="color:var(--cami-turq);" role="status"></div>
      <p style="opacity:.6;margin-top:1rem;">Cargando...</p>
    </div>`;
  document.getElementById('paginacionWrap').innerHTML = '';

  const busqueda = document.getElementById('searchProductos')?.value?.trim() || '';
  const precioMin = document.getElementById('precioMin')?.value?.trim() || '';
  const precioMax = document.getElementById('precioMax')?.value?.trim() || '';
  const soloStock = document.getElementById('soloStock')?.checked || false;
  const orden = document.getElementById('ordenSelect').value;

  const params = new URLSearchParams({ action: 'products', limite: PROD_POR_PAGINA, offset });
  if (busqueda) params.append('busqueda', busqueda);
  if (categoriaId > 0) params.append('categoria_id', categoriaId);
  if (precioMin !== '') params.append('precio_min', precioMin);
  if (precioMax !== '') params.append('precio_max', precioMax);
  if (soloStock) params.append('solo_stock', '1');
  params.append('orden', orden);

  try {
    const res = await fetch(`${API_URL}?${params}`);
    const json = await res.json();
    const grid = document.getElementById('gridProductos');
    grid.innerHTML = '';

    if (!json.exito || !json.datos.length) {
      grid.innerHTML = `
        <div class="col-12 empty-state">
          <i class="bi bi-inbox"></i>
          <p style="opacity:.6;">No se encontraron productos.</p>
          <button class="btn-p2 mt-2" onclick="limpiarFiltros()">Ver todos</button>
        </div>`;
      document.getElementById('resultCount').textContent = '0 productos';
      return;
    }

    totalProductos = json.total;
    json.datos.forEach(p => {
      const col = document.createElement('div');
      col.className = 'col-6 col-md-4 col-xl-3';
      col.innerHTML = tarjetaProducto(p);
      grid.appendChild(col);
    });

    document.getElementById('resultCount').textContent =
      totalProductos + ' producto' + (totalProductos !== 1 ? 's' : '');
    renderPaginacion(totalProductos);
  } catch (e) {
    document.getElementById('gridProductos').innerHTML =
      `<div class="col-12 empty-state"><i class="bi bi-wifi-off"></i><p>Error al cargar. Reintenta.</p></div>`;
  }
}

/* ─── TARJETA PRODUCTO ─── */
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
      <p class="product-desc">${p.descripcion_corta || p.descripcion || 'Producto Poder Down'}</p>
      <div class="product-footer">
        <span class="product-price">$${Number(p.precio).toLocaleString('es-CO',{minimumFractionDigits:0})}</span>
        <button class="btn-add-cami"
          data-pid="${p.id}" data-nombre="${encodeURIComponent(p.nombre)}" data-precio="${p.precio}" data-imagen="${p.imagen || ''}" onclick="agregarAlCarritoBtn(event,this)"
          ${agotado ? 'disabled' : ''} title="${agotado ? 'Agotado' : 'Agregar al carrito'}">
          <i class="bi bi-${agotado ? 'x' : 'plus-lg'}"></i>
        </button>
      </div>
    </div>
  </div>`;
}

/* ─── PAGINACIÓN ─── */
function renderPaginacion(total) {
  const totalPaginas = Math.ceil(total / PROD_POR_PAGINA);
  const wrap = document.getElementById('paginacionWrap');
  if (totalPaginas <= 1) { wrap.innerHTML = ''; return; }

  let html = '';
  html += `<button class="page-btn page-btn-nav" onclick="irAPagina(${paginaActual - 1})" ${paginaActual <= 1 ? 'disabled' : ''}><i class="bi bi-chevron-left"></i></button>`;

  const maxVisibles = 5;
  let inicio = Math.max(1, paginaActual - Math.floor(maxVisibles / 2));
  let fin = Math.min(totalPaginas, inicio + maxVisibles - 1);
  if (fin - inicio + 1 < maxVisibles) inicio = Math.max(1, fin - maxVisibles + 1);

  if (inicio > 1) {
    html += `<button class="page-btn" onclick="irAPagina(1)">1</button>`;
    if (inicio > 2) html += `<span class="page-info">…</span>`;
  }
  for (let i = inicio; i <= fin; i++) {
    html += `<button class="page-btn ${i === paginaActual ? 'activo' : ''}" onclick="irAPagina(${i})">${i}</button>`;
  }
  if (fin < totalPaginas) {
    if (fin < totalPaginas - 1) html += `<span class="page-info">…</span>`;
    html += `<button class="page-btn" onclick="irAPagina(${totalPaginas})">${totalPaginas}</button>`;
  }

  html += `<button class="page-btn page-btn-nav" onclick="irAPagina(${paginaActual + 1})" ${paginaActual >= totalPaginas ? 'disabled' : ''}><i class="bi bi-chevron-right"></i></button>`;
  wrap.innerHTML = html;
}

/* ─── FILTROS ─── */
function filtrarCategoria(btn, catId) {
  document.querySelectorAll('.filtro-btn').forEach(b => b.classList.remove('activo'));
  btn.classList.add('activo');
  categoriaId = catId;
  irAPagina(1);
}

function aplicarFiltros() {
  categoriaId = 0;
  document.querySelectorAll('.filtro-btn').forEach(b => b.classList.remove('activo'));
  document.querySelector('.filtro-btn[data-cat-id="0"]')?.classList.add('activo');
  irAPagina(1);
}

function limpiarFiltros() {
  document.getElementById('searchProductos').value = '';
  document.getElementById('precioMin').value = '';
  document.getElementById('precioMax').value = '';
  document.getElementById('soloStock').checked = false;
  categoriaId = 0;
  document.querySelectorAll('.filtro-btn').forEach(b => b.classList.remove('activo'));
  document.querySelector('.filtro-btn[data-cat-id="0"]')?.classList.add('activo');
  irAPagina(1);
}

/* ─── VER PRODUCTO ─── */
async function verProducto(id) {
  try {
    const res = await fetch(`${API_URL}?action=product&id=${id}`);
    const json = await res.json();
    if (!json.exito || !json.datos[0]) throw new Error();
    const p = json.datos[0];
    const agotado = p.stock_agotado || parseInt(p.stock) === 0;
    const imgHtml = p.imagen
      ? `<div style="text-align:center;margin-bottom:1rem;background:linear-gradient(135deg,rgba(60,174,224,.12),rgba(0,51,102,.04));border-radius:16px;padding:1rem;"><img src="${p.imagen}" alt="${p.nombre.replace(/"/g,'&quot;')}" style="max-height:220px;max-width:100%;object-fit:contain;border-radius:12px;" onerror="this.style.display='none'"></div>`
      : '';
    Swal.fire({
      title: `<span style="font-family:var(--font-kranky)">${p.nombre}</span>`,
      html: `<div style="font-family:var(--font-archivo);text-align:left;">
        ${imgHtml}
        <span style="background:var(--cami-turq);color:var(--cami-azul);border-radius:50px;padding:.3rem .9rem;font-size:.73rem;font-weight:700;">${p.categoria}</span>
        <p style="margin-top:.8rem;font-size:.88rem;opacity:.75;line-height:1.8;">${p.descripcion || 'Sin descripción.'}</p>
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
    }).then(r => {
      if (r.isConfirmed && !agotado) agregarAlCarrito(p.id, p.nombre, p.precio, p.imagen || '');
    });
  } catch (e) {}
}

/* ─── REDES FLOTANTES ─── */
function toggleFabSocial() {
  const links=document.getElementById('fabSocialLinks'),icon=document.getElementById('fabIconMain');
  links.classList.toggle('open');icon.className=links.classList.contains('open')?'bi bi-x-lg':'bi bi-share-fill';
}
document.addEventListener('click',e=>{const w=document.getElementById('fabSocialWrap');if(w&&!w.contains(e.target)){document.getElementById('fabSocialLinks')?.classList.remove('open');const i=document.getElementById('fabIconMain');if(i)i.className='bi bi-share-fill';}});

/* ─── DISLEXIA ─── */
let dyslexiaOn=localStorage.getItem('pd_dyslexia')==='1';
function applyDyslexia(){document.body.classList.toggle('dyslexia-mode',dyslexiaOn);const l=document.getElementById('dyslexiaLabelMain'),b=document.getElementById('btnDyslexiaFloat');if(l)l.textContent=dyslexiaOn?'Normal':'Dislexia';if(b){b.style.background=dyslexiaOn?'var(--cami-turq)':'var(--cami-azul)';b.style.color=dyslexiaOn?'var(--cami-azul)':'white';}}
function toggleDyslexia(){dyslexiaOn=!dyslexiaOn;localStorage.setItem('pd_dyslexia',dyslexiaOn?'1':'0');applyDyslexia();}
applyDyslexia();

iniciarProductos();
</script>
</body>
</html>
