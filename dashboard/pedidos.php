<?php
// ============================================================
// dashboard/pedidos.php
// DASHBOARD: Gestión de pedidos — tiempo real, sin registro
// ============================================================
require_once __DIR__ . '/../config/config.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Pedidos — <?= APP_NAME ?> Dashboard</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
  <link href="https://fonts.googleapis.com/css2?family=Kranky&family=Playpen+Sans:wght@400;600;700&display=swap" rel="stylesheet">
  <style>
    :root{--cami-bg:#ebeae4;--cami-turq:#4ed2ad;--cami-coral:#e45b63;--cami-amarillo:#efb810;--cami-azul:#003366;--cami-border:#d6d4cc;}
    body{background:var(--cami-bg);color:var(--cami-azul);font-family:'Playpen Sans',sans-serif;}

    .stat-card{border:none;border-radius:16px;transition:transform .2s,box-shadow .2s;}
    .stat-card:hover{transform:translateY(-3px);box-shadow:0 10px 28px rgba(0,0,0,.09);}
    .icon-wrap{width:50px;height:50px;border-radius:13px;display:flex;align-items:center;justify-content:center;font-size:1.35rem;}

    .tabla-card{border:none;border-radius:18px;overflow:hidden;box-shadow:0 2px 16px rgba(0,51,102,.07);}
    .pedido-row:hover{background:#f4fbf8;cursor:pointer;}

    .estado-badge{border-radius:50px;padding:.3rem .85rem;font-size:.72rem;font-weight:700;}
    .est-pendiente  {background:#fff3cd;color:#856404;}
    .est-confirmado {background:#cff4fc;color:#055160;}
    .est-preparando {background:#d0f5ea;color:#00704a;}
    .est-enviado    {background:#cfe2ff;color:#084298;}
    .est-entregado  {background:rgba(78,210,173,.2);color:#005a3c;}
    .est-cancelado  {background:#fde0e2;color:#a71d2a;}

    .btn-cami{background:var(--cami-turq);color:var(--cami-azul);border:none;border-radius:50px;font-weight:700;font-family:'Playpen Sans',sans-serif;}
    .btn-cami:hover{background:#3dbf9b;color:var(--cami-azul);}
    .btn-outline-cami{background:transparent;color:var(--cami-azul);border:2px solid var(--cami-azul);border-radius:50px;font-weight:600;font-family:'Playpen Sans',sans-serif;}
    .btn-outline-cami:hover{background:var(--cami-azul);color:white;}

    .input-search{border-radius:50px!important;border:2px solid var(--cami-border)!important;font-family:'Playpen Sans',sans-serif;}
    .input-search:focus{border-color:var(--cami-turq)!important;box-shadow:0 0 0 3px rgba(78,210,173,.2)!important;}
    .form-select{border:2px solid var(--cami-border);border-radius:12px;font-family:'Playpen Sans',sans-serif;}
    .form-select:focus{border-color:var(--cami-turq);box-shadow:0 0 0 3px rgba(78,210,173,.2);}

    .section-title{font-family:'Kranky',cursive;color:var(--cami-azul);}

    .modal-content{border:none;border-radius:20px;font-family:'Playpen Sans',sans-serif;}
    .modal-title{font-family:'Kranky',cursive;color:var(--cami-azul);}
    .modal-header{border-bottom:2px solid var(--cami-bg);}
    .modal-footer{border-top:2px solid var(--cami-bg);}

    .timeline{list-style:none;padding:0;margin:0;}
    .timeline li{display:flex;align-items:flex-start;gap:.8rem;padding:.6rem 0;border-left:2px solid var(--cami-border);padding-left:1.2rem;position:relative;}
    .timeline li.done{border-left-color:var(--cami-turq);}
    .tl-dot{width:14px;height:14px;border-radius:50%;background:var(--cami-border);position:absolute;left:-8px;top:.8rem;flex-shrink:0;}
    .tl-dot.done{background:var(--cami-turq);}
    .tl-label{font-weight:700;font-size:.88rem;color:var(--cami-azul);}
    .tl-sub{font-size:.76rem;opacity:.6;}

    .live-dot{display:inline-block;width:8px;height:8px;border-radius:50%;background:var(--cami-turq);animation:pulse 1.5s infinite;}
    @keyframes pulse{0%,100%{opacity:1;transform:scale(1);}50%{opacity:.5;transform:scale(1.3);}}

    /* Tabla items detalle */
    .item-row td{font-size:.85rem;padding:.5rem .8rem;}
    .codigo-badge{font-family:'Kranky',cursive;font-size:1rem;color:var(--cami-azul);background:rgba(78,210,173,.15);border-radius:8px;padding:.2rem .7rem;}
  </style>
</head>
<body>

<?php include BASE_PATH . '/app/views/partials/navbar_dashboard.php'; ?>

<div class="container-fluid py-4 px-4">

  <!-- ENCABEZADO -->
  <div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-3">
    <div>
      <h4 class="section-title mb-0">
        <i class="bi bi-bag-check me-2" style="color:var(--cami-turq)"></i>Pedidos
      </h4>
      <p class="text-muted small mb-0 d-flex align-items-center gap-2">
        <span class="live-dot"></span>
        Actualizando en tiempo real &nbsp;·&nbsp; <span id="ultimaAct">—</span>
      </p>
    </div>
  </div>

  <!-- STAT CARDS -->
  <div class="row g-3 mb-4">
    <?php
    $statDef = [
      ['bi-bag-check',       'rgba(78,210,173,.15)',  'var(--cami-turq)',    'Total pedidos',     'total',         ''],
      ['bi-hourglass-split', 'rgba(239,184,16,.2)',   'var(--cami-amarillo)','Pendientes',         'pendientes',    'por atender'],
      ['bi-truck',           'rgba(0,51,102,.1)',     'var(--cami-azul)',    'Enviados',           'enviados',      'en camino'],
      ['bi-currency-dollar', 'rgba(228,91,99,.15)',   'var(--cami-coral)',   'Ingresos totales',   'ingresos_total','COP acumulado'],
    ];
    foreach ($statDef as [$ico, $bg, $color, $tit, $key, $sub]):
    ?>
    <div class="col-6 col-lg-3">
      <div class="card stat-card h-100">
        <div class="card-body d-flex align-items-center gap-3 p-4">
          <div class="icon-wrap" style="background:<?= $bg ?>">
            <i class="bi <?= $ico ?>" style="color:<?= $color ?>"></i>
          </div>
          <div>
            <p class="text-muted small mb-1"><?= $tit ?></p>
            <h4 class="fw-bold mb-0 section-title" style="color:<?= $color ?>;" data-stat-pedido="<?= $key ?>">—</h4>
            <p class="text-muted mb-0" style="font-size:.7rem;"><?= $sub ?></p>
          </div>
        </div>
      </div>
    </div>
    <?php endforeach; ?>
  </div>

  <!-- FILTROS -->
  <div class="card border-0 shadow-sm mb-3" style="border-radius:16px;">
    <div class="card-body p-3">
      <div class="row g-2 align-items-center">
        <div class="col-md-5">
          <div class="input-group">
            <span class="input-group-text bg-white border-end-0 border-2" style="border-color:var(--cami-border);border-radius:50px 0 0 50px;">
              <i class="bi bi-search text-muted"></i>
            </span>
            <input type="text" id="inputBusqueda" class="form-control border-start-0 input-search"
                   placeholder="Código, nombre, email, teléfono..."
                   style="border-radius:0 50px 50px 0!important;">
          </div>
        </div>
        <div class="col-md-3">
          <select id="selectEstado" class="form-select" style="border-radius:50px!important;border:2px solid var(--cami-border);">
            <option value="">Todos los estados</option>
            <option value="pendiente">⏳ Pendiente</option>
            <option value="confirmado">✅ Confirmado</option>
            <option value="preparando">📦 Preparando</option>
            <option value="enviado">🚚 Enviado</option>
            <option value="entregado">🎉 Entregado</option>
            <option value="cancelado">❌ Cancelado</option>
          </select>
        </div>
        <div class="col-md-4 d-flex gap-2">
          <button class="btn btn-cami flex-grow-1" onclick="cargarPedidos()">
            <i class="bi bi-funnel-fill me-1"></i>Filtrar
          </button>
          <button class="btn btn-outline-cami" onclick="limpiarFiltros()" title="Limpiar">
            <i class="bi bi-x-lg"></i>
          </button>
        </div>
      </div>
    </div>
  </div>

  <!-- TABLA -->
  <div class="card tabla-card">
    <div class="card-header bg-white border-0 pt-4 pb-2 px-4 d-flex justify-content-between align-items-center">
      <h6 class="fw-bold mb-0 section-title" style="font-size:1rem;">Listado de pedidos</h6>
      <span class="badge rounded-pill px-3 py-2" style="background:var(--cami-turq);color:var(--cami-azul);font-weight:700;" id="contadorResultados">—</span>
    </div>
    <div class="card-body p-0">
      <div class="table-responsive">
        <table class="table table-hover mb-0 align-middle" style="font-size:.87rem;">
          <thead style="background:var(--cami-bg);">
            <tr>
              <th class="ps-4 py-3 text-muted fw-semibold" style="font-size:.73rem;">CÓDIGO</th>
              <th class="py-3 text-muted fw-semibold" style="font-size:.73rem;">CLIENTE</th>
              <th class="py-3 text-muted fw-semibold" style="font-size:.73rem;">CIUDAD</th>
              <th class="py-3 text-muted fw-semibold" style="font-size:.73rem;">TOTAL</th>
              <th class="py-3 text-muted fw-semibold" style="font-size:.73rem;">ESTADO</th>
              <th class="py-3 text-muted fw-semibold" style="font-size:.73rem;">FECHA</th>
              <th class="py-3 text-muted fw-semibold pe-4 text-end" style="font-size:.73rem;">ACCIONES</th>
            </tr>
          </thead>
          <tbody id="tablaPedidos"></tbody>
        </table>
      </div>
      <div id="tablaLoader" class="text-center py-5">
        <div class="spinner-border" style="color:var(--cami-turq);"></div>
        <p class="text-muted mt-2 small">Cargando pedidos...</p>
      </div>
      <div id="tablaVacia" class="text-center py-5 d-none">
        <i class="bi bi-inbox fs-1 text-muted"></i>
        <p class="text-muted mt-2">No hay pedidos con ese filtro.</p>
      </div>
    </div>
  </div>

</div>

<!-- ====================================================
     MODAL: DETALLE DE PEDIDO
==================================================== -->
<div class="modal fade" id="modalPedido" tabindex="-1" data-bs-backdrop="static">
  <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header px-4 pt-4">
        <div>
          <h5 class="modal-title mb-1" id="modalCodigo">Pedido</h5>
          <p class="text-muted small mb-0" id="modalFecha"></p>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body px-4" id="modalCuerpo">
        <div class="text-center py-4"><div class="spinner-border" style="color:var(--cami-turq);"></div></div>
      </div>
      <div class="modal-footer px-4 pb-4 d-flex flex-wrap gap-2 justify-content-between align-items-center">
        <div class="d-flex align-items-center gap-2">
          <label class="fw-bold small mb-0">Cambiar estado:</label>
          <select id="selectNuevoEstado" class="form-select form-select-sm" style="border-radius:50px;border:2px solid var(--cami-border);width:auto;">
            <option value="pendiente">⏳ Pendiente</option>
            <option value="confirmado">✅ Confirmado</option>
            <option value="preparando">📦 Preparando</option>
            <option value="enviado">🚚 Enviado</option>
            <option value="entregado">🎉 Entregado</option>
            <option value="cancelado">❌ Cancelado</option>
          </select>
          <button class="btn btn-cami btn-sm px-3" onclick="guardarEstado()">
            <i class="bi bi-check-lg"></i>Guardar
          </button>
        </div>
        <div class="d-flex gap-2">
          <button class="btn btn-outline-cami btn-sm px-3" onclick="imprimirFactura()">
            <i class="bi bi-printer me-1"></i>Factura
          </button>
          <button class="btn btn-outline-cami btn-sm" data-bs-dismiss="modal">Cerrar</button>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- ====================================================
     MODAL: FACTURA (print)
==================================================== -->
<div id="facturaArea" style="display:none;"></div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
const API_BASE  = '<?= API_URL ?>';
const CRUD_BASE = '<?= API_URL ?>/pedidos_crud.php';

let pedidoActualId = null;

const toast = (icon, title, timer = 2800) => Swal.fire({
  toast:true, position:'bottom-end', icon, title,
  showConfirmButton:false, timer, timerProgressBar:true,
  background:'#ebeae4', color:'#003366',
});

// ── CARGAR STATS ─────────────────────────────────────────────
async function cargarStats() {
  try {
    const res  = await fetch(`${API_BASE}/pedidos.php?resumen=1`);
    const json = await res.json();
    if (!json.exito || !json.datos[0]) return;
    const r = json.datos[0];
    document.querySelectorAll('[data-stat-pedido]').forEach(el => {
      const k   = el.dataset.statPedido;
      let   val = r[k] ?? '—';
      if (k === 'ingresos_total') val = '$' + Number(val).toLocaleString('es-CO',{minimumFractionDigits:0});
      else val = Number(val).toLocaleString('es-CO');
      el.textContent = val;
    });
    const now = new Date();
    const ua  = document.getElementById('ultimaAct');
    if (ua) ua.textContent = now.toLocaleTimeString('es-CO',{hour:'2-digit',minute:'2-digit',second:'2-digit'});

    // Badge de pendientes en navbar
    const badge = document.getElementById('badgePedidosPendientes');
    if (badge && r.pendientes > 0) {
      badge.textContent = r.pendientes;
      badge.style.display = 'inline-flex';
    } else if (badge) badge.style.display = 'none';
  } catch(e) {}
}

// ── CARGAR TABLA ─────────────────────────────────────────────
async function cargarPedidos() {
  const busqueda = document.getElementById('inputBusqueda').value.trim();
  const estado   = document.getElementById('selectEstado').value;

  const p = new URLSearchParams({ limite: 100 });
  if (busqueda) p.append('busqueda', busqueda);
  if (estado)   p.append('estado', estado);

  document.getElementById('tablaLoader').classList.remove('d-none');
  document.getElementById('tablaPedidos').innerHTML = '';
  document.getElementById('tablaVacia').classList.add('d-none');

  try {
    const res  = await fetch(`${API_BASE}/pedidos.php?${p}`);
    const json = await res.json();
    document.getElementById('tablaLoader').classList.add('d-none');

    if (!json.exito || json.datos.length === 0) {
      document.getElementById('tablaVacia').classList.remove('d-none');
      document.getElementById('contadorResultados').textContent = '0';
      return;
    }

    document.getElementById('contadorResultados').textContent = json.total + ' pedido' + (json.total !== 1 ? 's' : '');
    document.getElementById('tablaPedidos').innerHTML = json.datos.map(filaPedido).join('');
  } catch(e) {
    document.getElementById('tablaLoader').classList.add('d-none');
    toast('error','Error al cargar pedidos');
  }
}

// ── FILA ─────────────────────────────────────────────────────
function filaPedido(p) {
  const estadoMap = {
    pendiente:  ['⏳','est-pendiente'],
    confirmado: ['✅','est-confirmado'],
    preparando: ['📦','est-preparando'],
    enviado:    ['🚚','est-enviado'],
    entregado:  ['🎉','est-entregado'],
    cancelado:  ['❌','est-cancelado'],
  };
  const [icon, cls] = estadoMap[p.estado] || ['?',''];
  const fecha = new Date(p.created_at).toLocaleDateString('es-CO',{day:'2-digit',month:'short',year:'numeric'});
  const total = '$' + Number(p.total).toLocaleString('es-CO',{minimumFractionDigits:0});

  return `
  <tr class="pedido-row" onclick="verDetalle(${p.id})">
    <td class="ps-4"><span class="codigo-badge">${p.codigo}</span></td>
    <td>
      <p class="mb-0 fw-bold" style="font-size:.87rem;">${p.nombre}</p>
      <p class="mb-0 text-muted" style="font-size:.73rem;">${p.email}</p>
    </td>
    <td style="font-size:.82rem;">${p.ciudad}</td>
    <td class="fw-bold" style="color:var(--cami-azul);">${total}</td>
    <td><span class="estado-badge ${cls}">${icon} ${p.estado.charAt(0).toUpperCase()+p.estado.slice(1)}</span></td>
    <td style="font-size:.8rem;color:#888;">${fecha}</td>
    <td class="pe-4 text-end">
      <button class="btn btn-sm btn-cami px-3" onclick="event.stopPropagation();verDetalle(${p.id})">
        <i class="bi bi-eye"></i>
      </button>
    </td>
  </tr>`;
}

// ── DETALLE ───────────────────────────────────────────────────
async function verDetalle(id) {
  pedidoActualId = id;
  document.getElementById('modalCodigo').textContent = 'Cargando...';
  document.getElementById('modalCuerpo').innerHTML = '<div class="text-center py-4"><div class="spinner-border" style="color:var(--cami-turq);"></div></div>';
  const modal = new bootstrap.Modal(document.getElementById('modalPedido'));
  modal.show();

  try {
    const res  = await fetch(`${API_BASE}/pedidos.php?id=${id}`);
    const json = await res.json();
    if (!json.exito || !json.datos[0]) { toast('error','No se pudo cargar el pedido'); return; }
    const p = json.datos[0];

    document.getElementById('modalCodigo').innerHTML = `Pedido <span style="color:var(--cami-turq)">${p.codigo}</span>`;
    document.getElementById('modalFecha').textContent = 'Creado el ' + new Date(p.created_at).toLocaleString('es-CO');
    document.getElementById('selectNuevoEstado').value = p.estado;

    const estadoOrd = ['pendiente','confirmado','preparando','enviado','entregado'];
    const idx = estadoOrd.indexOf(p.estado);

    const items = p.items || [];
    const itemsHTML = items.length ? `
    <table class="table table-sm mb-0" style="font-size:.85rem;">
      <thead style="background:var(--cami-bg);">
        <tr><th>Producto</th><th class="text-center">Cant.</th><th class="text-end">Precio</th><th class="text-end">Subtotal</th></tr>
      </thead>
      <tbody>
        ${items.map(i => `
        <tr class="item-row">
          <td>${i.nombre}</td>
          <td class="text-center">${i.cantidad}</td>
          <td class="text-end">$${Number(i.precio).toLocaleString('es-CO',{minimumFractionDigits:0})}</td>
          <td class="text-end fw-bold">$${Number(i.subtotal).toLocaleString('es-CO',{minimumFractionDigits:0})}</td>
        </tr>`).join('')}
        <tr style="background:rgba(78,210,173,.1);">
          <td colspan="3" class="text-end fw-bold">Total</td>
          <td class="text-end fw-bold" style="font-family:'Kranky',cursive;font-size:1.1rem;color:var(--cami-azul);">
            $${Number(p.total).toLocaleString('es-CO',{minimumFractionDigits:0})}
          </td>
        </tr>
      </tbody>
    </table>` : '<p class="text-muted small">Sin items.</p>';

    document.getElementById('modalCuerpo').innerHTML = `
    <div class="row g-4">
      <!-- Datos de envío -->
      <div class="col-md-5">
        <h6 class="section-title mb-3" style="font-size:.95rem;"><i class="bi bi-person-fill me-2" style="color:var(--cami-turq)"></i>Datos del cliente</h6>
        <div class="d-flex flex-column gap-2" style="font-size:.88rem;">
          <div><i class="bi bi-person me-2 text-muted"></i><strong>Nombre:</strong> ${p.nombre}</div>
          <div><i class="bi bi-envelope me-2 text-muted"></i><strong>Email:</strong> ${p.email}</div>
          <div><i class="bi bi-telephone me-2 text-muted"></i><strong>Teléfono:</strong> ${p.telefono}</div>
          <div><i class="bi bi-geo-alt me-2 text-muted"></i><strong>Ciudad:</strong> ${p.ciudad}</div>
          <div><i class="bi bi-house me-2 text-muted"></i><strong>Dirección:</strong> ${p.direccion}</div>
          ${p.notas ? `<div><i class="bi bi-chat-left-text me-2 text-muted"></i><strong>Notas:</strong> ${p.notas}</div>` : ''}
        </div>

        <!-- Timeline -->
        <h6 class="section-title mt-4 mb-3" style="font-size:.95rem;"><i class="bi bi-truck me-2" style="color:var(--cami-turq)"></i>Seguimiento</h6>
        <ul class="timeline">
          ${estadoOrd.map((s,i) => {
            const done = i <= idx && p.estado !== 'cancelado';
            const labels = {pendiente:'Pedido recibido',confirmado:'Pedido confirmado',preparando:'Preparando envío',enviado:'En camino 🚚',entregado:'Entregado 🎉'};
            return `<li class="${done?'done':''}">
              <span class="tl-dot ${done?'done':''}"></span>
              <div>
                <p class="tl-label mb-0">${labels[s]}</p>
                <p class="tl-sub mb-0">${done?(i===idx?'Estado actual':'Completado'):'Pendiente'}</p>
              </div>
            </li>`;
          }).join('')}
          ${p.estado === 'cancelado' ? '<li style="border-left-color:#e45b63;"><span class="tl-dot" style="background:#e45b63;"></span><div><p class="tl-label mb-0" style="color:#e45b63;">❌ Cancelado</p></div></li>' : ''}
        </ul>
      </div>

      <!-- Items -->
      <div class="col-md-7">
        <h6 class="section-title mb-3" style="font-size:.95rem;"><i class="bi bi-bag me-2" style="color:var(--cami-turq)"></i>Productos del pedido</h6>
        <div class="card border-0" style="border-radius:12px;overflow:hidden;background:var(--cami-bg);">
          ${itemsHTML}
        </div>
      </div>
    </div>`;
  } catch(e) {
    toast('error','Error al cargar el pedido');
  }
}

// ── CAMBIAR ESTADO ────────────────────────────────────────────
async function guardarEstado() {
  if (!pedidoActualId) return;
  const estado = document.getElementById('selectNuevoEstado').value;

  const fd = new FormData();
  fd.append('action','estado');
  fd.append('id', pedidoActualId);
  fd.append('estado', estado);

  try {
    const res  = await fetch(CRUD_BASE, { method:'POST', body:fd });
    const json = await res.json();
    if (!json.exito) { toast('error', json.mensaje); return; }
    toast('success','✅ Estado actualizado');
    cargarPedidos();
    cargarStats();
  } catch(e) { toast('error','Error al actualizar'); }
}

// ── IMPRIMIR FACTURA ──────────────────────────────────────────
async function imprimirFactura() {
  if (!pedidoActualId) return;
  try {
    const res  = await fetch(`${API_BASE}/pedidos.php?id=${pedidoActualId}`);
    const json = await res.json();
    if (!json.exito || !json.datos[0]) { toast('error','No se pudo cargar'); return; }
    const p = json.datos[0];
    const items = p.items || [];

    const win = window.open('','_blank');
    win.document.write(`<!DOCTYPE html>
<html lang="es"><head><meta charset="UTF-8"><title>Factura ${p.codigo}</title>
<style>
  body{font-family:'Playpen Sans',sans-serif;margin:0;padding:2rem;color:#003366;}
  @import url('https://fonts.googleapis.com/css2?family=Kranky&family=Playpen+Sans:wght@400;600;700&display=swap');
  h1{font-family:'Kranky',cursive;font-size:2rem;color:#003366;margin:0;}
  .sub{color:#4ed2ad;font-size:.85rem;font-weight:700;}
  table{width:100%;border-collapse:collapse;margin-top:1.5rem;}
  th{background:#ebeae4;padding:.6rem .8rem;text-align:left;font-size:.8rem;color:#003366;}
  td{padding:.5rem .8rem;border-bottom:1px solid #ebeae4;font-size:.85rem;}
  .total-row{background:rgba(78,210,173,.15);font-weight:700;}
  .badge{background:#4ed2ad;color:#003366;border-radius:50px;padding:.2rem .7rem;font-size:.75rem;font-weight:700;}
  .info-grid{display:grid;grid-template-columns:1fr 1fr;gap:.5rem;margin:1.5rem 0;font-size:.88rem;}
  hr{border:none;border-top:2px solid #ebeae4;margin:1.2rem 0;}
  @media print{button{display:none;}}
</style></head><body>
<div style="display:flex;justify-content:space-between;align-items:flex-start;">
  <div><h1>Poder Down<span style="color:#4ed2ad">.</span></h1><p class="sub">Factura de compra</p></div>
  <div style="text-align:right;">
    <p style="font-family:'Kranky',cursive;font-size:1.4rem;margin:0;">${p.codigo}</p>
    <p style="font-size:.8rem;color:#888;">${new Date(p.created_at).toLocaleString('es-CO')}</p>
    <span class="badge">${p.estado}</span>
  </div>
</div>
<hr>
<div class="info-grid">
  <div><strong>Cliente:</strong> ${p.nombre}</div>
  <div><strong>Email:</strong> ${p.email}</div>
  <div><strong>Teléfono:</strong> ${p.telefono}</div>
  <div><strong>Ciudad:</strong> ${p.ciudad}</div>
  <div style="grid-column:1/-1;"><strong>Dirección:</strong> ${p.direccion}</div>
  ${p.notas ? `<div style="grid-column:1/-1;"><strong>Notas:</strong> ${p.notas}</div>` : ''}
</div>
<hr>
<table>
  <thead><tr><th>Producto</th><th>Precio</th><th>Cant.</th><th style="text-align:right;">Subtotal</th></tr></thead>
  <tbody>
    ${items.map(i=>`<tr><td>${i.nombre}</td><td>$${Number(i.precio).toLocaleString('es-CO',{minimumFractionDigits:0})}</td><td>${i.cantidad}</td><td style="text-align:right;">$${Number(i.subtotal).toLocaleString('es-CO',{minimumFractionDigits:0})}</td></tr>`).join('')}
    <tr class="total-row"><td colspan="3" style="text-align:right;">TOTAL</td><td style="text-align:right;font-family:'Kranky',cursive;font-size:1.1rem;">$${Number(p.total).toLocaleString('es-CO',{minimumFractionDigits:0})}</td></tr>
  </tbody>
</table>
<hr>
<p style="font-size:.75rem;color:#aaa;text-align:center;">© ${new Date().getFullYear()} Poder Down by María Camila González Torres · info@poderdown.com · 313 746 8039</p>
<button onclick="window.print()" style="margin-top:1rem;background:#4ed2ad;color:#003366;border:none;border-radius:50px;padding:.6rem 2rem;font-weight:700;cursor:pointer;font-size:.9rem;">🖨️ Imprimir / Guardar PDF</button>
</body></html>`);
    win.document.close();
  } catch(e) { toast('error','Error al generar factura'); }
}

function limpiarFiltros() {
  document.getElementById('inputBusqueda').value = '';
  document.getElementById('selectEstado').value = '';
  cargarPedidos();
}

// Búsqueda con debounce
let timerB;
document.getElementById('inputBusqueda').addEventListener('input', () => {
  clearTimeout(timerB);
  timerB = setTimeout(() => cargarPedidos(), 450);
});

// ── ARRANQUE + POLLING ────────────────────────────────────────
document.addEventListener('DOMContentLoaded', () => {
  cargarPedidos();
  cargarStats();
  // Tiempo real: cada 8 segundos
  setInterval(() => {
    cargarPedidos();
    cargarStats();
  }, 8000);
});
</script>
</body>
</html>
