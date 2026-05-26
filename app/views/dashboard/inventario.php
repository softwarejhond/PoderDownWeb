<?php
// ============================================================
// app/views/dashboard/inventario.php
// VISTA: Inventario con CRUD completo
// Variables del controlador: $productos, $resumen, $porCategoria,
//   $categorias, $totalPaginas, $paginaActual
// ============================================================
if (!defined('BASE_PATH')) {
    require_once __DIR__ . '/../../../config/config.php';
    require_once BASE_PATH . '/app/controllers/ProductoController.php';
    $ctrl = new ProductoController();
    $ctrl->indexDashboard();
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Inventario — <?= APP_NAME ?> Dashboard</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
  <link href="https://fonts.googleapis.com/css2?family=Kranky&family=Playpen+Sans:wght@400;600;700&display=swap" rel="stylesheet">
  <style>
    :root{--cami-bg:#ebeae4;--cami-turq:#4ed2ad;--cami-coral:#e45b63;--cami-amarillo:#efb810;--cami-azul:#003366;--cami-border:#d6d4cc;}
    body{background:var(--cami-bg);color:var(--cami-azul);font-family:'Playpen Sans',sans-serif;}

    /* Stat cards */
    .stat-card{border:none;border-radius:16px;transition:transform .2s,box-shadow .2s;}
    .stat-card:hover{transform:translateY(-3px);box-shadow:0 10px 28px rgba(0,0,0,.09);}
    .icon-wrap{width:50px;height:50px;border-radius:13px;display:flex;align-items:center;justify-content:center;font-size:1.35rem;}

    /* Tabla */
    .tabla-card{border:none;border-radius:18px;overflow:hidden;box-shadow:0 2px 16px rgba(0,51,102,.07);}
    .product-row:hover{background:#f4fbf8;}
    .badge-stock-ok   {background:#d0f5ea;color:#00704a;font-weight:700;}
    .badge-stock-bajo {background:#fff3cd;color:#856404;font-weight:700;}
    .badge-stock-vacio{background:#fde0e2;color:#a71d2a;font-weight:700;}

    /* Botones fila */
    .btn-fila{border:none;background:transparent;border-radius:8px;padding:.3rem .5rem;font-size:.95rem;transition:all .15s;cursor:pointer;}
    .btn-fila:hover{transform:scale(1.15);}
    .btn-editar{color:var(--cami-azul);}  .btn-editar:hover{background:rgba(0,51,102,.1);}
    .btn-borrar{color:var(--cami-coral);} .btn-borrar:hover{background:rgba(228,91,99,.12);}
    .btn-toggle{color:#888;}              .btn-toggle:hover{background:#eee;}
    .btn-stock-edit{color:var(--cami-turq);} .btn-stock-edit:hover{background:rgba(78,210,173,.15);}

    /* Inputs */
    .input-search{border-radius:50px!important;border:2px solid var(--cami-border)!important;font-family:'Playpen Sans',sans-serif;}
    .input-search:focus{border-color:var(--cami-turq)!important;box-shadow:0 0 0 3px rgba(78,210,173,.2)!important;}
    .form-control,.form-select{border:2px solid var(--cami-border);border-radius:12px;font-family:'Playpen Sans',sans-serif;}
    .form-control:focus,.form-select:focus{border-color:var(--cami-turq);box-shadow:0 0 0 3px rgba(78,210,173,.2);}
    .form-label{font-weight:700;font-size:.85rem;color:var(--cami-azul);}

    /* Modales */
    .modal-content{border:none;border-radius:20px;font-family:'Playpen Sans',sans-serif;}
    .modal-header{border-bottom:2px solid var(--cami-bg);}
    .modal-footer{border-top:2px solid var(--cami-bg);}
    .modal-title{font-family:'Kranky',cursive;color:var(--cami-azul);}

    /* Botones de marca */
    .btn-cami{background:var(--cami-turq);color:var(--cami-azul);border:none;border-radius:50px;font-weight:700;font-family:'Playpen Sans',sans-serif;}
    .btn-cami:hover,.btn-cami:active{background:#3dbf9b;color:var(--cami-azul);}
    .btn-danger-cami{background:var(--cami-coral);color:white;border:none;border-radius:50px;font-weight:700;font-family:'Playpen Sans',sans-serif;}
    .btn-danger-cami:hover{background:#c94851;color:white;}
    .btn-outline-cami{background:transparent;color:var(--cami-azul);border:2px solid var(--cami-azul);border-radius:50px;font-weight:600;font-family:'Playpen Sans',sans-serif;}
    .btn-outline-cami:hover{background:var(--cami-azul);color:white;}

    /* Preview imagen */
    .img-preview{width:100%;height:160px;border-radius:14px;border:2px dashed var(--cami-border);
      display:flex;align-items:center;justify-content:center;background:var(--cami-bg);cursor:pointer;
      transition:border-color .2s;overflow:hidden;}
    .img-preview:hover{border-color:var(--cami-turq);}
    .img-preview img{width:100%;height:100%;object-fit:cover;}

    /* Paginador */
    .page-link{font-family:'Playpen Sans',sans-serif;border-radius:10px!important;margin:0 2px;color:var(--cami-azul);}
    .page-item.active .page-link{background:var(--cami-turq);border-color:var(--cami-turq);color:var(--cami-azul);}

    .section-title{font-family:'Kranky',cursive;color:var(--cami-azul);}
    .badge-activo  {background:rgba(78,210,173,.2);color:#00704a;border-radius:50px;padding:.3rem .8rem;font-size:.72rem;font-weight:700;}
    .badge-inactivo{background:rgba(108,117,125,.15);color:#555;border-radius:50px;padding:.3rem .8rem;font-size:.72rem;font-weight:700;}
  </style>
</head>
<body>

<?php include BASE_PATH . '/app/views/partials/navbar_dashboard.php'; ?>

<div class="container-fluid py-4 px-4">

  <!-- ENCABEZADO -->
  <div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-3">
    <div>
      <h4 class="section-title mb-0"><i class="bi bi-box-seam me-2" style="color:var(--cami-turq)"></i>Inventario de Productos</h4>
      <p class="text-muted small mb-0 d-flex align-items-center gap-2">
        <?= MOCK_MODE ? '⚠️ Modo prueba — sin base de datos' : '✅ Conectado a MySQL' ?>
        <span class="text-muted" style="font-size:.7rem;"><i class="bi bi-circle-fill" style="color:#4ed2ad;font-size:.5rem;"></i> <span id="ultimaActualizacion">En vivo</span></span>
      </p>
    </div>
    <button class="btn btn-cami px-4" onclick="abrirModalCrear()">
      <i class="bi bi-plus-lg me-2"></i>Nuevo producto
    </button>
  </div>

  <!-- STAT CARDS -->
  <div class="row g-3 mb-4">
    <?php
    $stats = [
      ['bi-box-seam',         'rgba(78,210,173,.15)',  'var(--cami-turq)',    'Total productos',   $resumen['total_productos'] ?? 0,                                         'activos en tienda'],
      ['bi-stack',            'rgba(0,51,102,.1)',     'var(--cami-azul)',    'Unidades en stock',  number_format($resumen['total_stock'] ?? 0),                             'unidades totales'],
      ['bi-currency-dollar',  'rgba(239,184,16,.2)',   'var(--cami-amarillo)','Valor inventario',   '$'.number_format($resumen['valor_inventario'] ?? 0, 2, ',', '.'),       'valor estimado'],
      ['bi-exclamation-circle','rgba(228,91,99,.15)', 'var(--cami-coral)',   'Sin stock',           $resumen['sin_stock'] ?? 0,                                               'agotados'],
    ];
    $statKeys = ['total_productos','total_stock','valor_inventario','sin_stock'];
    foreach ($stats as $loop => [$ico, $bg, $color, $titulo, $valor, $sub]):
    ?>
    <div class="col-6 col-lg-3">
      <div class="card stat-card h-100">
        <div class="card-body d-flex align-items-center gap-3 p-4">
          <div class="icon-wrap" style="background:<?= $bg ?>"><i class="bi <?= $ico ?>" style="color:<?= $color ?>"></i></div>
          <div>
            <p class="text-muted small mb-1"><?= $titulo ?></p>
            <h4 class="fw-bold mb-0" style="color:<?= $color ?>;font-family:'Kranky',cursive;" data-stat="<?= $statKeys[$loop] ?? '' ?>"><?= $valor ?></h4>
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
                   placeholder="Buscar producto..." style="border-radius:0 50px 50px 0!important;">
          </div>
        </div>
        <div class="col-md-3">
          <select id="selectCategoria" class="form-select" style="border-radius:50px!important;border:2px solid var(--cami-border);">
            <option value="">Todas las categorías</option>
            <?php foreach ($porCategoria as $cat): ?>
            <option value="<?= htmlspecialchars($cat['categoria']) ?>">
              <?= htmlspecialchars($cat['categoria']) ?> (<?= $cat['cantidad'] ?>)
            </option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="col-md-2">
          <select id="selectOrden" class="form-select" style="border-radius:50px!important;border:2px solid var(--cami-border);">
            <option value="p.created_at DESC">Más recientes</option>
            <option value="p.nombre ASC">Nombre A→Z</option>
            <option value="p.precio ASC">Menor precio</option>
            <option value="p.precio DESC">Mayor precio</option>
            <option value="p.stock ASC">Menor stock</option>
            <option value="p.stock DESC">Mayor stock</option>
          </select>
        </div>
        <div class="col-md-2 d-flex gap-2">
          <button class="btn btn-cami flex-grow-1" onclick="cargarProductos(1)">
            <i class="bi bi-funnel-fill me-1"></i>Filtrar
          </button>
          <button class="btn btn-outline-cami" onclick="limpiarFiltros()" title="Limpiar filtros">
            <i class="bi bi-x-lg"></i>
          </button>
        </div>
      </div>
    </div>
  </div>

  <!-- TABLA -->
  <div class="card tabla-card">
    <div class="card-header bg-white border-0 pt-4 pb-2 px-4 d-flex justify-content-between align-items-center">
      <h6 class="fw-bold mb-0 section-title" style="font-size:1rem;">Listado de productos</h6>
      <div class="d-flex gap-2 align-items-center">
        <span class="badge rounded-pill px-3 py-2" style="background:var(--cami-turq);color:var(--cami-azul);font-weight:700;" id="contadorResultados">—</span>
        <button class="btn btn-sm btn-outline-cami" onclick="cargarProductos(paginaActual)" title="Actualizar">
          <i class="bi bi-arrow-clockwise"></i>
        </button>
      </div>
    </div>
    <div class="card-body p-0">
      <div class="table-responsive">
        <table class="table table-hover mb-0 align-middle" style="font-size:.88rem;">
          <thead style="background:var(--cami-bg);">
            <tr>
              <th class="ps-4 py-3 text-muted fw-semibold" style="font-size:.74rem;">ID</th>
              <th class="py-3 text-muted fw-semibold" style="font-size:.74rem;">PRODUCTO</th>
              <th class="py-3 text-muted fw-semibold" style="font-size:.74rem;">CATEGORÍA</th>
              <th class="py-3 text-muted fw-semibold" style="font-size:.74rem;">PRECIO</th>
              <th class="py-3 text-muted fw-semibold" style="font-size:.74rem;">STOCK</th>
              <th class="py-3 text-muted fw-semibold" style="font-size:.74rem;">ESTADO</th>
              <th class="py-3 text-muted fw-semibold pe-4 text-end" style="font-size:.74rem;">ACCIONES</th>
            </tr>
          </thead>
          <tbody id="tablaProductos"></tbody>
        </table>
      </div>
      <div id="tablaLoader" class="text-center py-5">
        <div class="spinner-border" style="color:var(--cami-turq);"></div>
        <p class="text-muted mt-2 small">Cargando inventario...</p>
      </div>
      <div id="tablaVacia" class="text-center py-5 d-none">
        <i class="bi bi-inbox fs-1 text-muted"></i>
        <p class="text-muted mt-2">No hay productos con ese filtro.</p>
      </div>
    </div>
    <div class="card-footer bg-white border-0 pb-4 px-4">
      <nav id="paginadorWrap" class="d-none">
        <ul class="pagination pagination-sm justify-content-center mb-0" id="paginador"></ul>
      </nav>
    </div>
  </div>

</div>

<!-- ====================================================
     MODAL: CREAR / EDITAR PRODUCTO
==================================================== -->
<div class="modal fade" id="modalProducto" tabindex="-1" data-bs-backdrop="static">
  <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header px-4 pt-4">
        <h5 class="modal-title" id="modalProductoTitulo">Nuevo producto</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body px-4">
        <input type="hidden" id="fProductoId">
        <div class="row g-3">

          <!-- Imagen -->
          <div class="col-12">
            <label class="form-label">Imagen del producto</label>
            <div class="img-preview" id="imgPreview" onclick="document.getElementById('fImagen').click()">
              <div class="text-center text-muted" id="imgPlaceholder">
                <i class="bi bi-cloud-arrow-up fs-1 d-block mb-1"></i>
                <small>Clic para subir imagen</small><br>
                <small style="font-size:.72rem;">JPG · PNG · WEBP · máx 5MB</small>
              </div>
            </div>
            <input type="file" id="fImagen" accept="image/*" class="d-none" onchange="previsualizarImagen(this)">
          </div>

          <!-- Nombre -->
          <div class="col-md-8">
            <label class="form-label">Nombre del producto *</label>
            <input type="text" id="fNombre" class="form-control" placeholder="Ej: Camiseta Floral Cami" maxlength="200">
          </div>

          <!-- Categoría -->
          <div class="col-md-4">
            <label class="form-label">Categoría *</label>
            <select id="fCategoria" class="form-select">
              <option value="">Seleccionar...</option>
              <?php if (!MOCK_MODE): ?>
                <?php foreach ($categorias as $cat): ?>
                <option value="<?= $cat['id'] ?>" data-nombre="<?= htmlspecialchars($cat['nombre']) ?>">
                  <?= htmlspecialchars($cat['nombre']) ?>
                </option>
                <?php endforeach; ?>
              <?php else: ?>
                <option value="Electrónica" data-nombre="Electrónica">Electrónica</option>
                <option value="Ropa"        data-nombre="Ropa">Ropa</option>
                <option value="Hogar"       data-nombre="Hogar">Hogar</option>
                <option value="Deportes"    data-nombre="Deportes">Deportes</option>
                <option value="Libros"      data-nombre="Libros">Libros</option>
              <?php endif; ?>
            </select>
          </div>

          <!-- Descripción -->
          <div class="col-12">
            <label class="form-label">Descripción</label>
            <textarea id="fDescripcion" class="form-control" rows="3"
                      placeholder="Características, tallas, colores disponibles..."></textarea>
          </div>

          <!-- Precio -->
          <div class="col-md-4">
            <label class="form-label">Precio *</label>
            <div class="input-group">
              <span class="input-group-text" style="border-radius:12px 0 0 12px;border:2px solid var(--cami-border);border-right:none;">$</span>
              <input type="number" id="fPrecio" class="form-control" placeholder="0.00" min="0" step="0.01"
                     style="border-radius:0 12px 12px 0;">
            </div>
          </div>

          <!-- Stock -->
          <div class="col-md-4">
            <label class="form-label">Stock *</label>
            <input type="number" id="fStock" class="form-control" placeholder="0" min="0" step="1">
          </div>

          <!-- Estado -->
          <div class="col-md-4">
            <label class="form-label">Estado</label>
            <select id="fActivo" class="form-select">
              <option value="1">✅ Activo (visible en tienda)</option>
              <option value="0">⏸️ Inactivo (oculto)</option>
            </select>
          </div>

        </div>
      </div>
      <div class="modal-footer px-4 pb-4 gap-2">
        <button type="button" class="btn btn-outline-cami px-4" data-bs-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-cami px-5" id="btnGuardar" onclick="guardarProducto()">
          <i class="bi bi-check-lg me-2"></i>Guardar producto
        </button>
      </div>
    </div>
  </div>
</div>

<!-- ====================================================
     MODAL: AJUSTE DE STOCK
==================================================== -->
<div class="modal fade" id="modalStock" tabindex="-1" data-bs-backdrop="static">
  <div class="modal-dialog modal-sm modal-dialog-centered">
    <div class="modal-content text-center">
      <div class="modal-header px-4 pt-4">
        <h5 class="modal-title">Ajustar stock</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body px-4">
        <input type="hidden" id="sId">
        <p class="fw-bold mb-1" id="sNombre" style="font-size:.9rem;"></p>
        <p class="text-muted small mb-3">Usa los botones o escribe el valor exacto</p>

        <div class="d-flex align-items-center justify-content-center gap-2 mb-3">
          <button class="btn btn-outline-cami btn-sm" style="border-radius:50%;width:36px;height:36px;padding:0;" onclick="deltaStock(-10)">-10</button>
          <button class="btn btn-outline-cami btn-sm" style="border-radius:50%;width:34px;height:34px;padding:0;" onclick="deltaStock(-1)">-1</button>
          <span id="sStockVal" style="font-family:'Kranky',cursive;font-size:2.8rem;color:var(--cami-azul);min-width:70px;">0</span>
          <button class="btn btn-cami btn-sm" style="border-radius:50%;width:34px;height:34px;padding:0;" onclick="deltaStock(+1)">+1</button>
          <button class="btn btn-cami btn-sm" style="border-radius:50%;width:36px;height:36px;padding:0;" onclick="deltaStock(+10)">+10</button>
        </div>

        <div class="mb-2">
          <label class="form-label">Valor exacto</label>
          <input type="number" id="sExacto" class="form-control text-center" min="0"
                 placeholder="Ej: 100" style="font-size:1.1rem;font-weight:700;">
        </div>
      </div>
      <div class="modal-footer px-4 pb-4 gap-2 justify-content-center">
        <button class="btn btn-outline-cami px-3" data-bs-dismiss="modal">Cancelar</button>
        <button class="btn btn-cami px-4" onclick="guardarStock()">
          <i class="bi bi-check-lg me-1"></i>Guardar stock
        </button>
      </div>
    </div>
  </div>
</div>

<!-- ====================================================
     MODAL: CONFIRMAR ELIMINAR
==================================================== -->
<div class="modal fade" id="modalEliminar" tabindex="-1">
  <div class="modal-dialog modal-sm modal-dialog-centered">
    <div class="modal-content text-center">
      <div class="modal-body px-4 pt-4 pb-2">
        <div style="width:60px;height:60px;border-radius:50%;background:rgba(228,91,99,.1);
                    display:flex;align-items:center;justify-content:center;margin:0 auto 1rem;">
          <i class="bi bi-trash3" style="font-size:1.5rem;color:var(--cami-coral);"></i>
        </div>
        <h6 class="section-title mb-2">¿Eliminar producto?</h6>
        <p class="fw-semibold small mb-1" id="eNombre">—</p>
        <p class="text-muted" style="font-size:.8rem;">Esta acción es <strong>permanente</strong>.</p>
        <input type="hidden" id="eId">
      </div>
      <div class="modal-footer border-0 justify-content-center gap-2 pb-4">
        <button class="btn btn-outline-cami px-4" data-bs-dismiss="modal">Cancelar</button>
        <button class="btn btn-danger-cami px-4" onclick="confirmarEliminar()">
          <i class="bi bi-trash3 me-1"></i>Eliminar
        </button>
      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
// ============================================================
// INVENTARIO — CRUD completo
// ============================================================
const API_BASE  = '<?= API_URL ?>';
const CRUD_BASE = '<?= API_URL ?>/productos_crud.php';
const MOCK      = <?= MOCK_MODE ? 'true' : 'false' ?>;

let paginaActual = 1;
const POR_PAGINA = 15;
let stockModal   = 0;

// Toast
const toast = (icon, title, timer = 2800) => Swal.fire({
  toast:true, position:'bottom-end', icon, title,
  showConfirmButton:false, timer, timerProgressBar:true,
  background:'#ebeae4', color:'#003366',
});

// ── CARGAR TABLA ─────────────────────────────────────────────
async function cargarProductos(pagina = 1) {
  paginaActual = pagina;
  const busqueda  = document.getElementById('inputBusqueda').value.trim();
  const categoria = document.getElementById('selectCategoria').value;
  const orden     = document.getElementById('selectOrden').value;
  const offset    = (pagina - 1) * POR_PAGINA;

  const p = new URLSearchParams({ limite: POR_PAGINA, offset, orden });
  if (busqueda)  p.append('busqueda', busqueda);
  if (categoria) p.append('categoria', categoria);

  document.getElementById('tablaLoader').classList.remove('d-none');
  document.getElementById('tablaProductos').innerHTML = '';
  document.getElementById('tablaVacia').classList.add('d-none');
  document.getElementById('paginadorWrap').classList.add('d-none');

  try {
    const res  = await fetch(`${API_BASE}/productos.php?${p}`);
    const json = await res.json();
    document.getElementById('tablaLoader').classList.add('d-none');

    if (!json.exito || json.datos.length === 0) {
      document.getElementById('tablaVacia').classList.remove('d-none');
      document.getElementById('contadorResultados').textContent = '0';
      return;
    }

    document.getElementById('contadorResultados').textContent =
      json.total + ' producto' + (json.total !== 1 ? 's' : '');
    document.getElementById('tablaProductos').innerHTML = json.datos.map(fila).join('');

    const totalPags = Math.ceil(json.total / POR_PAGINA);
    if (totalPags > 1) {
      renderPaginador(totalPags);
      document.getElementById('paginadorWrap').classList.remove('d-none');
    }
  } catch(e) {
    document.getElementById('tablaLoader').classList.add('d-none');
    toast('error', 'Error al cargar el inventario');
  }
}

// ── FILA ─────────────────────────────────────────────────────
function fila(p) {
  const stock = parseInt(p.stock);
  let badge;
  if (stock === 0)     badge = `<span class="badge badge-stock-vacio rounded-pill px-3 py-1">Agotado</span>`;
  else if (stock <= 5) badge = `<span class="badge badge-stock-bajo rounded-pill px-3 py-1"><i class="bi bi-exclamation-circle me-1"></i>${stock}</span>`;
  else                 badge = `<span class="badge badge-stock-ok rounded-pill px-3 py-1"><i class="bi bi-check-circle me-1"></i>${stock}</span>`;

  const img = p.imagen && p.imagen !== 'default.jpg'
    ? `<img src="<?= BASE_URL ?>/public/img/productos/${p.imagen}" style="width:42px;height:42px;border-radius:10px;object-fit:cover;">`
    : `<div style="width:42px;height:42px;border-radius:10px;background:var(--cami-bg);display:flex;align-items:center;justify-content:center;min-width:42px;"><i class="bi bi-image text-muted"></i></div>`;

  const nom = p.nombre.replace(/'/g,"\\'");
  return `
  <tr class="product-row">
    <td class="ps-4 text-muted" style="font-size:.78rem;">#${p.id}</td>
    <td>
      <div class="d-flex align-items-center gap-2">
        ${img}
        <div>
          <p class="mb-0 fw-bold" style="font-size:.88rem;">${p.nombre}</p>
          <p class="mb-0 text-muted" style="font-size:.72rem;max-width:200px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">${p.descripcion ?? '—'}</p>
        </div>
      </div>
    </td>
    <td><span style="background:rgba(78,210,173,.15);color:var(--cami-azul);border-radius:50px;padding:.25rem .75rem;font-size:.75rem;font-weight:700;">${p.categoria}</span></td>
    <td class="fw-bold" style="color:var(--cami-azul);">$${Number(p.precio).toLocaleString('es-CO',{minimumFractionDigits:2})}</td>
    <td>
      <div class="d-flex align-items-center gap-1">
        <button class="btn-fila btn-stock-edit" onclick="abrirStock(${p.id},'${nom}',${p.stock})" title="Ajustar stock">
          <i class="bi bi-pencil-fill" style="font-size:.7rem;"></i>
        </button>
        ${badge}
      </div>
    </td>
    <td><span class="${p.activo == 1 ? 'badge-activo' : 'badge-inactivo'}">${p.activo == 1 ? '✅ Activo' : '⏸️ Inactivo'}</span></td>
    <td class="pe-4 text-end">
      <button class="btn-fila btn-editar"  onclick="abrirEditar(${p.id})"          title="Editar"><i class="bi bi-pencil-square fs-5"></i></button>
      <button class="btn-fila btn-toggle"  onclick="toggleEstado(${p.id},${p.activo},'${nom}')" title="${p.activo==1?'Desactivar':'Activar'}"><i class="bi ${p.activo==1?'bi-eye-slash':'bi-eye'} fs-5"></i></button>
      <button class="btn-fila btn-borrar"  onclick="abrirEliminar(${p.id},'${nom}')" title="Eliminar"><i class="bi bi-trash3 fs-5"></i></button>
    </td>
  </tr>`;
}

function renderPaginador(total) {
  let h = `<li class="page-item ${paginaActual===1?'disabled':''}"><a class="page-link" href="#" onclick="cargarProductos(${paginaActual-1});return false;"><i class="bi bi-chevron-left"></i></a></li>`;
  for (let i = 1; i <= total; i++)
    h += `<li class="page-item ${i===paginaActual?'active':''}"><a class="page-link" href="#" onclick="cargarProductos(${i});return false;">${i}</a></li>`;
  h += `<li class="page-item ${paginaActual===total?'disabled':''}"><a class="page-link" href="#" onclick="cargarProductos(${paginaActual+1});return false;"><i class="bi bi-chevron-right"></i></a></li>`;
  document.getElementById('paginador').innerHTML = h;
}

function limpiarFiltros() {
  document.getElementById('inputBusqueda').value = '';
  document.getElementById('selectCategoria').value = '';
  document.getElementById('selectOrden').value = 'p.created_at DESC';
  cargarProductos(1);
}

// ── MODAL CREAR ───────────────────────────────────────────────
function abrirModalCrear() {
  document.getElementById('modalProductoTitulo').textContent = '✨ Nuevo producto';
  ['fProductoId','fNombre','fDescripcion','fPrecio','fStock'].forEach(id => document.getElementById(id).value = '');
  document.getElementById('fActivo').value = '1';
  document.getElementById('fCategoria').value = '';
  document.getElementById('fImagen').value = '';
  resetImg();
  new bootstrap.Modal(document.getElementById('modalProducto')).show();
}

// ── MODAL EDITAR ──────────────────────────────────────────────
async function abrirEditar(id) {
  try {
    const res  = await fetch(`${API_BASE}/productos.php?id=${id}`);
    const json = await res.json();
    if (!json.exito || !json.datos[0]) { toast('error','No se pudo cargar el producto'); return; }
    const p = json.datos[0];

    document.getElementById('modalProductoTitulo').textContent = '✏️ Editar producto';
    document.getElementById('fProductoId').value  = p.id;
    document.getElementById('fNombre').value       = p.nombre;
    document.getElementById('fDescripcion').value  = p.descripcion ?? '';
    document.getElementById('fPrecio').value       = p.precio;
    document.getElementById('fStock').value        = p.stock;
    document.getElementById('fActivo').value       = p.activo ?? 1;
    document.getElementById('fImagen').value       = '';

    // Seleccionar categoría por id (modo real) o nombre (mock)
    const sel = document.getElementById('fCategoria');
    for (const opt of sel.options) {
      if (opt.value == p.categoria_id || opt.value === p.categoria || opt.dataset.nombre === p.categoria) {
        opt.selected = true; break;
      }
    }

    if (p.imagen && p.imagen !== 'default.jpg')
      mostrarImg(`<?= BASE_URL ?>/public/img/productos/${p.imagen}`);
    else resetImg();

    new bootstrap.Modal(document.getElementById('modalProducto')).show();
  } catch(e) { toast('error','Error al cargar el producto'); }
}

// ── GUARDAR (crear/editar) ────────────────────────────────────
async function guardarProducto() {
  const id     = document.getElementById('fProductoId').value;
  const nombre = document.getElementById('fNombre').value.trim();
  const cat    = document.getElementById('fCategoria').value;
  const precio = document.getElementById('fPrecio').value;
  const stock  = document.getElementById('fStock').value;

  if (!nombre) { toast('warning','El nombre es obligatorio'); return; }
  if (!cat)    { toast('warning','Selecciona una categoría'); return; }
  if (!precio || precio < 0) { toast('warning','Precio inválido'); return; }
  if (stock === '' || stock < 0) { toast('warning','Stock inválido'); return; }

  const btn = document.getElementById('btnGuardar');
  btn.disabled = true;
  btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Guardando...';

  const fd = new FormData();
  fd.append('action',      id ? 'actualizar' : 'crear');
  if (id) fd.append('id', id);
  fd.append('nombre',      nombre);
  fd.append('descripcion', document.getElementById('fDescripcion').value);
  fd.append('precio',      precio);
  fd.append('stock',       stock);
  fd.append('activo',      document.getElementById('fActivo').value);
  fd.append('categoria_id', cat);
  const catSel = document.getElementById('fCategoria');
  fd.append('categoria_nombre', catSel.options[catSel.selectedIndex]?.dataset?.nombre || cat);
  const img = document.getElementById('fImagen');
  if (img.files[0]) fd.append('imagen', img.files[0]);

  try {
    const res  = await fetch(CRUD_BASE, { method:'POST', body:fd });
    const json = await res.json();
    btn.disabled = false;
    btn.innerHTML = '<i class="bi bi-check-lg me-2"></i>Guardar producto';
    if (!json.exito) { toast('error', json.mensaje || 'Error al guardar'); return; }
    bootstrap.Modal.getInstance(document.getElementById('modalProducto'))?.hide();
    toast('success', id ? '✅ Producto actualizado' : '🎉 Producto creado');
    cargarProductos(paginaActual);
  } catch(e) {
    btn.disabled = false;
    btn.innerHTML = '<i class="bi bi-check-lg me-2"></i>Guardar producto';
    toast('error','Error de conexión');
  }
}

// ── MODAL STOCK ───────────────────────────────────────────────
function abrirStock(id, nombre, stock) {
  document.getElementById('sId').value = id;
  document.getElementById('sNombre').textContent = nombre;
  document.getElementById('sStockVal').textContent = stock;
  document.getElementById('sExacto').value = '';
  stockModal = parseInt(stock);
  new bootstrap.Modal(document.getElementById('modalStock')).show();
}
function deltaStock(d) {
  stockModal = Math.max(0, stockModal + d);
  document.getElementById('sStockVal').textContent = stockModal;
  document.getElementById('sExacto').value = '';
}
async function guardarStock() {
  const id     = document.getElementById('sId').value;
  const exacto = document.getElementById('sExacto').value;
  const nuevo  = exacto !== '' ? parseInt(exacto) : stockModal;
  if (isNaN(nuevo) || nuevo < 0) { toast('warning','Stock inválido'); return; }

  const fd = new FormData();
  fd.append('action','stock'); fd.append('id',id); fd.append('stock_exacto',nuevo);

  try {
    const res  = await fetch(CRUD_BASE, { method:'POST', body:fd });
    const json = await res.json();
    if (!json.exito) { toast('error', json.mensaje); return; }
    bootstrap.Modal.getInstance(document.getElementById('modalStock'))?.hide();
    toast('success', `📦 Stock actualizado a ${json.datos.nuevo_stock ?? nuevo} unidades`);
    cargarProductos(paginaActual);
  } catch(e) { toast('error','Error al actualizar stock'); }
}

// ── TOGGLE ESTADO ─────────────────────────────────────────────
async function toggleEstado(id, actual, nombre) {
  const nuevo  = actual == 1 ? 0 : 1;
  const accion = nuevo ? 'activar' : 'desactivar';

  const conf = await Swal.fire({
    title: `¿${accion.charAt(0).toUpperCase()+accion.slice(1)}?`,
    text: `"${nombre}" quedará ${nuevo ? 'visible' : 'oculto'} en la tienda.`,
    icon: 'question',
    showCancelButton: true,
    confirmButtonText: `Sí, ${accion}`,
    cancelButtonText: 'Cancelar',
    confirmButtonColor: nuevo ? '#4ed2ad' : '#e45b63',
  });
  if (!conf.isConfirmed) return;

  const fd = new FormData();
  fd.append('action','estado'); fd.append('id',id); fd.append('activo',nuevo);

  try {
    const res  = await fetch(CRUD_BASE, { method:'POST', body:fd });
    const json = await res.json();
    if (!json.exito) { toast('error', json.mensaje); return; }
    toast('success', nuevo ? '✅ Producto activado' : '⏸️ Producto desactivado');
    cargarProductos(paginaActual);
  } catch(e) { toast('error','Error al cambiar estado'); }
}

// ── ELIMINAR ──────────────────────────────────────────────────
function abrirEliminar(id, nombre) {
  document.getElementById('eId').value = id;
  document.getElementById('eNombre').textContent = nombre;
  new bootstrap.Modal(document.getElementById('modalEliminar')).show();
}
async function confirmarEliminar() {
  const id = document.getElementById('eId').value;
  const fd = new FormData();
  fd.append('action','eliminar'); fd.append('id',id);
  try {
    const res  = await fetch(CRUD_BASE, { method:'POST', body:fd });
    const json = await res.json();
    bootstrap.Modal.getInstance(document.getElementById('modalEliminar'))?.hide();
    if (!json.exito) { toast('error', json.mensaje); return; }
    toast('success','🗑️ Producto eliminado');
    cargarProductos(paginaActual);
  } catch(e) { toast('error','Error al eliminar'); }
}

// ── IMAGEN ────────────────────────────────────────────────────
function previsualizarImagen(input) {
  if (!input.files[0]) return;
  const r = new FileReader();
  r.onload = e => mostrarImg(e.target.result);
  r.readAsDataURL(input.files[0]);
}
function mostrarImg(src) {
  document.getElementById('imgPreview').innerHTML = `<img src="${src}" alt="preview">`;
}
function resetImg() {
  document.getElementById('imgPreview').innerHTML = `
    <div class="text-center text-muted">
      <i class="bi bi-cloud-arrow-up fs-1 d-block mb-1"></i>
      <small>Clic para subir imagen</small><br>
      <small style="font-size:.72rem;">JPG · PNG · WEBP · máx 5MB</small>
    </div>`;
}

// ── Búsqueda con debounce ─────────────────────────────────────
let timerB;
document.getElementById('inputBusqueda').addEventListener('input', () => {
  clearTimeout(timerB);
  timerB = setTimeout(() => cargarProductos(1), 450);
});

document.addEventListener('DOMContentLoaded', () => {
  cargarProductos(1);
  actualizarStats();
  // Tiempo real: polling cada 8 segundos
  setInterval(() => {
    cargarProductos(paginaActual);
    actualizarStats();
  }, 8000);
});

// ── STATS EN TIEMPO REAL ─────────────────────────────────────
async function actualizarStats() {
  try {
    const res  = await fetch(`${API_BASE}/productos.php?stats=1`);
    const json = await res.json();
    if (!json.exito) return;
    const r = json.datos.resumen || json.datos[0] || {};
    // Actualiza las stat-cards sin recargar la página
    const cards = document.querySelectorAll('[data-stat]');
    cards.forEach(el => {
      const key = el.dataset.stat;
      if (r[key] !== undefined) {
        let val = r[key];
        if (key === 'valor_inventario') val = '$' + Number(val).toLocaleString('es-CO', {minimumFractionDigits:2});
        else val = Number(val).toLocaleString('es-CO');
        el.textContent = val;
      }
    });
    // Indicador de última actualización
    const ind = document.getElementById('ultimaActualizacion');
    if (ind) {
      const now = new Date();
      ind.textContent = 'Actualizado ' + now.toLocaleTimeString('es-CO', {hour:'2-digit',minute:'2-digit',second:'2-digit'});
    }
  } catch(e) {}
}
</script>
</body>
</html>
