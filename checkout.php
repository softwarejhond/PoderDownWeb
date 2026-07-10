<?php
$productoId = (int)($_GET['id'] ?? 0);
$precioDirecto = (float)($_GET['precio'] ?? 0);
$variantId = (int)($_GET['variant_id'] ?? 0);
$source = $_GET['source'] ?? '';

session_start();
$clienteLogueado = null;
if (isset($_SESSION['customer_id'])) {
    require_once __DIR__ . '/controller/conexion.php';
    require_once __DIR__ . '/controller/auth.php';
    $clienteLogueado = getCurrentUser();
    if ($clienteLogueado) {
        unset($clienteLogueado['password']);
    }
    mysqli_close($conn);
}

require 'controller/conexion.php';
$resEnvio = mysqli_query($conn, "SELECT valor FROM envio_config WHERE id = 1 LIMIT 1");
$costoEnvio = 0;
if ($resEnvio && $row = mysqli_fetch_assoc($resEnvio)) {
    $costoEnvio = (float) $row['valor'];
}
mysqli_close($conn);

$pageTitle = 'Checkout — Poder Down';
$pageDescription = 'Finaliza tu compra en Poder Down';
require 'components/header_simple.php';
?>
<style>
  .chk-card { background:white;border-radius:20px;padding:1.8rem 2rem;margin-bottom:1.5rem; }
  .chk-card-title { font-family:var(--font-kranky);font-size:1.15rem;margin-bottom:1.2rem;display:flex;align-items:center;gap:.5rem; }
  .chk-label { font-size:.82rem;font-weight:700;color:var(--cami-azul);display:block;margin-bottom:.3rem; }
  .chk-input { width:100%;padding:.65rem 1rem;border:2px solid var(--cami-border);border-radius:12px;font-family:var(--font-archivo);font-size:.88rem;outline:none;transition:border-color .2s;background:white; }
  .chk-input:focus { border-color:var(--cami-turq);box-shadow:0 0 0 3px rgba(60,174,224,.15); }
  .chk-input.error { border-color:var(--cami-coral); }
  .chk-select { width:100%;padding:.65rem 1rem;border:2px solid var(--cami-border);border-radius:12px;font-family:var(--font-archivo);font-size:.88rem;outline:none;transition:border-color .2s;background:white;appearance:none;background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' fill='%23003366' viewBox='0 0 16 16'%3E%3Cpath d='M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z'/%3E%3C/svg%3E");background-repeat:no-repeat;background-position:right 1rem center;padding-right:2.5rem; }
  .chk-select:focus { border-color:var(--cami-turq);box-shadow:0 0 0 3px rgba(60,174,224,.15); }
  .chk-select.error { border-color:var(--cami-coral); }
  .chk-row { display:grid;grid-template-columns:1fr 1fr;gap:.8rem; }
  .chk-row-3 { display:grid;grid-template-columns:1fr 1fr 1fr;gap:.8rem; }
  .chk-summary { display:flex;justify-content:space-between;align-items:center;padding:.8rem 0;border-bottom:1px solid var(--cami-border);font-size:.9rem; }
  .chk-summary:last-of-type { border-bottom:2px solid var(--cami-azul);font-weight:700; }
  .chk-total { font-family:var(--font-kranky);font-size:1.4rem;color:var(--cami-azul); }
  .chk-payment { background:rgba(60,174,224,.08);border-radius:16px;padding:1rem 1.4rem;display:flex;align-items:center;gap:1rem;flex-wrap:wrap; }
  .chk-payment i { font-size:1.4rem;color:var(--cami-turq); }
  .chk-payment p { margin:0;font-size:.85rem;opacity:.75; }
  .chk-payment strong { color:var(--cami-azul); }
  .chk-submit { width:100%;padding:.9rem;font-size:1.05rem;justify-content:center; }
  .chk-msg { display:none;text-align:center;padding:0 1rem; }
  .chk-msg.show { display:block; }
  .chk-msg-icon { font-size:3.5rem;color:var(--cami-turq);margin-bottom:.8rem; }
  .chk-msg h2 { font-family:var(--font-kranky);font-size:1.6rem;color:var(--cami-azul);margin-bottom:.5rem; }
  .chk-product-resume { display:flex;gap:1rem;align-items:center;padding:.8rem 0;border-bottom:1px solid var(--cami-border); }
  .chk-product-resume img { width:60px;height:60px;border-radius:12px;object-fit:cover;background:var(--cami-bg);flex-shrink:0; }
  .chk-product-resume .chk-placeholder { width:60px;height:60px;border-radius:12px;background:var(--cami-bg);display:flex;align-items:center;justify-content:center;font-size:1.4rem;color:var(--cami-border);flex-shrink:0; }
  .chk-product-resume .info { flex:1; }
  .chk-product-resume .info .name { font-weight:700;font-size:.88rem;margin:0; }
  .chk-product-resume .info .price { font-family:var(--font-kranky);font-size:1rem;color:var(--cami-azul);margin:.2rem 0 0; }
  .chk-loading { text-align:center;padding:3rem; }
  @media (max-width:575px) {
    .chk-card { padding:1.2rem 1rem; }
    .chk-row { grid-template-columns:1fr; }
    .chk-row-3 { grid-template-columns:1fr; }
    .chk-payment { flex-direction:column;text-align:center; }
  }
</style>

<div class="checkout-wrap">
  <div class="container checkout-container">
    <div id="chkContent">
      <div class="chk-loading">
        <div class="spinner-border" style="color:var(--cami-turq);" role="status"></div>
        <p style="opacity:.6;margin-top:1rem;">Preparando tu pedido...</p>
      </div>
    </div>
  </div>
</div>

<!-- FOOTER FIJO (solo barra) -->
<div class="fl-bar-fija">
  &copy; <?= date('Y') ?> Poder Down by <a href="https://www.agenciaeaglesoftware.com/" target="_blank" rel="noopener noreferrer" class="fl-eagle-link">Eagle Software</a> &mdash; Todos los derechos reservados
</div>

<style>
.fl-bar-fija {
  position: fixed; bottom: 0; left: 0; right: 0;
  background: #ebeae4; border-top: 2px solid #d6d4cc;
  padding: .75rem 1.5rem; text-align: center;
  font-size: .82rem; color: rgba(0,51,102,.6);
  font-family: 'Archivo', sans-serif;
  box-shadow: 0 -2px 12px rgba(0,51,102,.06);
  z-index: 1000;
}
.fl-eagle-link {
  color: #1A3A5C; text-decoration: none; font-weight: 700;
  font-family: 'Nunito','Gilroy',sans-serif; transition: color .2s;
}
.fl-eagle-link:hover { color: #3CAEE0; }
</style>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
const API_URL = 'components/productos/cargar_productos.php';
const BANKS_URL = 'components/megapagos/get_banks.php';
const PRODUCTO_ID = <?= $productoId ?>;
const PRECIO_DIRECTO = <?= $precioDirecto ?>;
const VARIANT_ID = <?= $variantId ?>;
const COSTO_ENVIO = <?= $costoEnvio ?>;
const CHECKOUT_SOURCE = '<?= $source ?>';
const CLIENTE_LOGUEADO = <?= $clienteLogueado ? json_encode($clienteLogueado) : 'null' ?>;

let productoActual = null;
let bancosDisponibles = [];

async function initCheckout() {
  if (CHECKOUT_SOURCE === 'cart') {
    await initCheckoutCart();
    return;
  }

  if (!PRODUCTO_ID) {
    document.getElementById('chkContent').innerHTML = `<div class="chk-card text-center"><p style="opacity:.6;">No se especificó un producto.</p><a href="productos.php" class="btn-p2 mt-3">← Ir a tienda</a></div>`;
    return;
  }

  try {
    const [resProd, resBanks] = await Promise.all([
      fetch(`${API_URL}?action=product&id=${PRODUCTO_ID}`),
      fetch(BANKS_URL)
    ]);
    const jsonProd = await resProd.json();
    const jsonBanks = await resBanks.json();

    if (jsonProd.exito && jsonProd.datos[0]) {
      productoActual = jsonProd.datos[0];
    } else {
      throw new Error('No encontrado');
    }

    if (jsonBanks.exito && jsonBanks.bancos) {
      bancosDisponibles = jsonBanks.bancos;
    }

    renderizarCheckout(productoActual, bancosDisponibles);
  } catch (e) {
    document.getElementById('chkContent').innerHTML = `<div class="chk-card text-center"><p style="opacity:.6;">Producto no disponible o error al cargar bancos.</p><a href="productos.php" class="btn-p2 mt-3">← Ir a tienda</a></div>`;
  }
}

async function initCheckoutCart() {
  const carrito = JSON.parse(localStorage.getItem('pd_carrito') || '[]');
  if (carrito.length === 0) {
    document.getElementById('chkContent').innerHTML = `<div class="chk-card text-center"><p style="opacity:.6;">Tu carrito está vacío.</p><a href="productos.php" class="btn-p2 mt-3">← Ir a tienda</a></div>`;
    return;
  }

  try {
    const resBanks = await fetch(BANKS_URL);
    const jsonBanks = await resBanks.json();
    if (jsonBanks.exito && jsonBanks.bancos) {
      bancosDisponibles = jsonBanks.bancos;
    }
  } catch (e) {}

  productoActual = { nombre: 'Pedido múltiple', precio: 0, imagen: '' };
  renderizarCheckoutCart(carrito, bancosDisponibles);
}

function renderizarCheckout(p, bancos) {
  const agotado = p.stock_agotado || parseInt(p.stock) === 0;
  if (agotado) {
    document.getElementById('chkContent').innerHTML = `<div class="chk-card text-center"><p style="opacity:.6;">Este producto está agotado.</p><a href="productos.php" class="btn-p2 mt-3">← Ir a tienda</a></div>`;
    return;
  }

  let variantNameHtml = '';
  if (VARIANT_ID > 0) {
    variantNameHtml = '<div style="font-size:.75rem;opacity:.5;margin-top:2px;">Variante #' + VARIANT_ID + '</div>';
  }

  const precio = PRECIO_DIRECTO > 0 ? PRECIO_DIRECTO : parseFloat(p.precio);
  const imgHtml = p.imagen
    ? `<img src="${p.imagen}" alt="${p.nombre.replace(/"/g,'&quot;')}" onerror="this.outerHTML='<div class=\\'chk-placeholder\\'><i class=\\'bi bi-image\\'></i></div>'">`
    : `<div class="chk-placeholder"><i class="bi bi-image"></i></div>`;

  let bancosOptions = '<option value="">Selecciona tu banco...</option>';
  if (bancos.length > 0) {
    bancos.forEach(b => {
      bancosOptions += `<option value="${b.code}" data-name="${b.name}">${b.name}</option>`;
    });
  }

  const html = `
    <div class="chk-card">
      <p class="chk-card-title"><i class="bi bi-bag-check-fill" style="color:var(--cami-turq);"></i> Resumen del pedido</p>
      <div class="chk-product-resume">
        ${imgHtml}
        <div class="info">
          <p class="name">${p.nombre}</p>
          ${variantNameHtml}
          <p class="price">$${Number(precio).toLocaleString('es-CO',{minimumFractionDigits:0})}</p>
        </div>
      </div>
      <div class="chk-summary"><span>Subtotal</span><span>$${Number(precio).toLocaleString('es-CO',{minimumFractionDigits:0})}</span></div>
      <div class="chk-summary"><span>Envío</span><span>$${Number(COSTO_ENVIO).toLocaleString('es-CO',{minimumFractionDigits:0})}</span></div>
      <div class="chk-summary"><span>Total</span><span class="chk-total">$${Number(precio + COSTO_ENVIO).toLocaleString('es-CO',{minimumFractionDigits:0})}</span></div>
    </div>

    <form id="checkoutForm" onsubmit="return procesarPedido(event)">
    <div class="chk-card">
      <p class="chk-card-title"><i class="bi bi-person-fill" style="color:var(--cami-turq);"></i> Datos de envío</p>
        <div style="display:flex;flex-direction:column;gap:.9rem;">
          <div>
            <label class="chk-label">Nombre completo *</label>
            <input type="text" class="chk-input" id="chkNombre" placeholder="Tu nombre" required maxlength="120">
          </div>
          <div>
            <label class="chk-label">Email *</label>
            <input type="email" class="chk-input" id="chkEmail" placeholder="tu@correo.com" required maxlength="120">
          </div>
          <div>
            <label class="chk-label">WhatsApp / Teléfono *</label>
            <input type="tel" class="chk-input" id="chkTelefono" placeholder="313 746 8039" required maxlength="30">
          </div>
          <div class="chk-row-3">
            <div>
              <label class="chk-label">Tipo de documento *</label>
              <select class="chk-select" id="chkTipoDocumento">
                <option value="CedulaDeCiudadania">Cédula de ciudadanía</option>
                <option value="CedulaDeExtranjeria">Cédula de extranjería</option>
                <option value="Nit">NIT</option>
                <option value="Pasaporte">Pasaporte</option>
                <option value="TarjetaDeIdentidad">Tarjeta de identidad</option>
              </select>
            </div>
            <div style="grid-column:span 2;">
              <label class="chk-label">Número de documento *</label>
              <input type="text" class="chk-input" id="chkDocumento" placeholder="Número de documento" required maxlength="20">
            </div>
          </div>
          <div class="chk-row">
            <div>
              <label class="chk-label">Ciudad *</label>
              <input type="text" class="chk-input" id="chkCiudad" placeholder="Medellín" required maxlength="100">
            </div>
            <div>
              <label class="chk-label">Dirección *</label>
              <input type="text" class="chk-input" id="chkDireccion" placeholder="Cra 10 #20-30" required maxlength="200">
            </div>
          </div>
          <div>
            <label class="chk-label">Notas adicionales (opcional)</label>
            <textarea class="chk-input" id="chkNotas" placeholder="Apartamento, instrucciones de entrega..." rows="2" style="resize:none;" maxlength="500"></textarea>
          </div>
        </div>
    </div>

    <div class="chk-card">
      <p class="chk-card-title"><i class="bi bi-credit-card-2-front-fill" style="color:var(--cami-turq);"></i> Método de pago</p>
      <div class="chk-payment">
        <i class="bi bi-bank"></i>
        <div><p><strong>PSE</strong> &mdash; Paga directamente desde tu banco de forma segura.</p></div>
      </div>
      <div style="margin-top:1rem;">
        <label class="chk-label">Selecciona tu banco *</label>
        <select class="chk-select" id="chkBanco" required onchange="actualizarBancoSeleccionado()">
          ${bancosOptions}
        </select>
      </div>
      <p style="font-size:.78rem;opacity:.5;margin-top:.8rem;"><i class="bi bi-shield-lock-fill"></i> Tus datos están seguros. No almacenamos información de pago.</p>
    </div>

    <button type="submit" class="btn-p1 chk-submit"><i class="bi bi-check2-circle"></i> Confirmar pedido</button>
    </form>

    <div class="text-center mt-3">
      <a href="producto.php?id=${PRODUCTO_ID}${VARIANT_ID > 0 ? '&variant_preselect=' + VARIANT_ID : ''}" style="font-size:.82rem;color:var(--cami-turq);"><i class="bi bi-arrow-left"></i> Volver al producto</a>
    </div>
  `;

  document.getElementById('chkContent').innerHTML = html;
  prefillForm();
}

function renderizarCheckoutCart(carrito, bancos) {
  let itemsHtml = '';
  let subtotal = 0;
  carrito.forEach(item => {
    const lineTotal = item.precio * item.cantidad;
    subtotal += lineTotal;
    const thumbHtml = item.imagen
      ? `<img src="${item.imagen}" alt="" onerror="this.outerHTML='<div class=\\'chk-placeholder\\'><i class=\\'bi bi-image\\'></i></div>'">`
      : `<div class="chk-placeholder"><i class="bi bi-image"></i></div>`;
    itemsHtml += `
      <div class="chk-product-resume">
        ${thumbHtml}
        <div class="info">
          <p class="name">${item.nombre.replace(/</g,'&lt;')}</p>
          ${item.variant_label ? '<div style="font-size:.7rem;opacity:.5;">' + item.variant_label.replace(/</g,'&lt;') + '</div>' : ''}
          <p class="price">$${Number(item.precio).toLocaleString('es-CO')} x ${item.cantidad} = $${Number(lineTotal).toLocaleString('es-CO')}</p>
        </div>
      </div>`;
  });
  const total = subtotal + COSTO_ENVIO;

  let bancosOptions = '<option value="">Selecciona tu banco...</option>';
  if (bancos.length > 0) {
    bancos.forEach(b => {
      bancosOptions += `<option value="${b.code}" data-name="${b.name}">${b.name}</option>`;
    });
  }

  const html = `
    <div class="chk-card">
      <p class="chk-card-title"><i class="bi bi-bag-check-fill" style="color:var(--cami-turq);"></i> Resumen del pedido (${carrito.length} producto${carrito.length > 1 ? 's' : ''})</p>
      ${itemsHtml}
      <div class="chk-summary"><span>Subtotal</span><span>$${Number(subtotal).toLocaleString('es-CO',{minimumFractionDigits:0})}</span></div>
      <div class="chk-summary"><span>Envío</span><span>$${Number(COSTO_ENVIO).toLocaleString('es-CO',{minimumFractionDigits:0})}</span></div>
      <div class="chk-summary"><span>Total</span><span class="chk-total">$${Number(total).toLocaleString('es-CO',{minimumFractionDigits:0})}</span></div>
    </div>

    <form id="checkoutForm" onsubmit="return procesarPedidoCart(event)">
    <div class="chk-card">
      <p class="chk-card-title"><i class="bi bi-person-fill" style="color:var(--cami-turq);"></i> Datos de envío</p>
        <div style="display:flex;flex-direction:column;gap:.9rem;">
          <div>
            <label class="chk-label">Nombre completo *</label>
            <input type="text" class="chk-input" id="chkNombre" placeholder="Tu nombre" required maxlength="120">
          </div>
          <div>
            <label class="chk-label">Email *</label>
            <input type="email" class="chk-input" id="chkEmail" placeholder="tu@correo.com" required maxlength="120">
          </div>
          <div>
            <label class="chk-label">WhatsApp / Teléfono *</label>
            <input type="tel" class="chk-input" id="chkTelefono" placeholder="313 746 8039" required maxlength="30">
          </div>
          <div class="chk-row-3">
            <div>
              <label class="chk-label">Tipo de documento *</label>
              <select class="chk-select" id="chkTipoDocumento">
                <option value="CedulaDeCiudadania">Cédula de ciudadanía</option>
                <option value="CedulaDeExtranjeria">Cédula de extranjería</option>
                <option value="Nit">NIT</option>
                <option value="Pasaporte">Pasaporte</option>
                <option value="TarjetaDeIdentidad">Tarjeta de identidad</option>
              </select>
            </div>
            <div style="grid-column:span 2;">
              <label class="chk-label">Número de documento *</label>
              <input type="text" class="chk-input" id="chkDocumento" placeholder="Número de documento" required maxlength="20">
            </div>
          </div>
          <div class="chk-row">
            <div>
              <label class="chk-label">Ciudad *</label>
              <input type="text" class="chk-input" id="chkCiudad" placeholder="Medellín" required maxlength="100">
            </div>
            <div>
              <label class="chk-label">Dirección *</label>
              <input type="text" class="chk-input" id="chkDireccion" placeholder="Cra 10 #20-30" required maxlength="200">
            </div>
          </div>
          <div>
            <label class="chk-label">Notas adicionales (opcional)</label>
            <textarea class="chk-input" id="chkNotas" placeholder="Apartamento, instrucciones de entrega..." rows="2" style="resize:none;" maxlength="500"></textarea>
          </div>
        </div>
    </div>

    <div class="chk-card">
      <p class="chk-card-title"><i class="bi bi-credit-card-2-front-fill" style="color:var(--cami-turq);"></i> Método de pago</p>
      <div class="chk-payment">
        <i class="bi bi-bank"></i>
        <div><p><strong>PSE</strong> &mdash; Paga directamente desde tu banco de forma segura.</p></div>
      </div>
      <div style="margin-top:1rem;">
        <label class="chk-label">Selecciona tu banco *</label>
        <select class="chk-select" id="chkBanco" required onchange="actualizarBancoSeleccionado()">
          ${bancosOptions}
        </select>
      </div>
      <p style="font-size:.78rem;opacity:.5;margin-top:.8rem;"><i class="bi bi-shield-lock-fill"></i> Tus datos están seguros. No almacenamos información de pago.</p>
    </div>

    <button type="submit" class="btn-p1 chk-submit"><i class="bi bi-check2-circle"></i> Confirmar pedido</button>
    </form>

    <div class="text-center mt-3">
      <a href="productos.php" style="font-size:.82rem;color:var(--cami-turq);"><i class="bi bi-arrow-left"></i> Volver a la tienda</a>
    </div>
  `;

  document.getElementById('chkContent').innerHTML = html;
  prefillForm();
}

function prefillForm() {
  if (!CLIENTE_LOGUEADO) return;
  const c = CLIENTE_LOGUEADO;
  if (c.first_name && c.last_name) {
    const el = document.getElementById('chkNombre');
    if (el) el.value = c.first_name + ' ' + c.last_name;
  }
  if (c.email) {
    const el = document.getElementById('chkEmail');
    if (el) el.value = c.email;
  }
  if (c.phone) {
    const el = document.getElementById('chkTelefono');
    if (el) el.value = c.phone;
  }
  if (c.document_number) {
    const el = document.getElementById('chkDocumento');
    if (el) el.value = c.document_number;
  }
  if (c.document_type) {
    const el = document.getElementById('chkTipoDocumento');
    if (el) {
      const map = { CC: 'CedulaDeCiudadania', CE: 'CedulaDeExtranjeria', TI: 'TarjetaDeIdentidad', NIT: 'Nit', PP: 'Pasaporte', PEP: 'Pasaporte' };
      if (map[c.document_type]) el.value = map[c.document_type];
    }
  }
}

function actualizarBancoSeleccionado() {
  const sel = document.getElementById('chkBanco');
}

async function procesarPedido(e) {
  e.preventDefault();
  const btn = e.target.querySelector('button[type="submit"]');
  if (btn) { btn.disabled = true; btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status"></span>Procesando...'; }

  const nombre = document.getElementById('chkNombre').value.trim().substring(0,120);
  const email = document.getElementById('chkEmail').value.trim().substring(0,120);
  const telefono = document.getElementById('chkTelefono').value.trim().substring(0,30);
  const ciudad = document.getElementById('chkCiudad').value.trim().substring(0,100);
  const direccion = document.getElementById('chkDireccion').value.trim().substring(0,200);
  const notas = document.getElementById('chkNotas').value.trim().substring(0,500);
  const tipoDocumento = document.getElementById('chkTipoDocumento').value;
  const documento = document.getElementById('chkDocumento').value.trim();
  const bancoSelect = document.getElementById('chkBanco');
  const bancoCodigo = bancoSelect.value;
  const bancoNombre = bancoSelect.options[bancoSelect.selectedIndex]?.getAttribute('data-name') || bancoSelect.options[bancoSelect.selectedIndex]?.text || '';

  let hasError = false;
  document.querySelectorAll('.chk-input,.chk-select').forEach(el => el.classList.remove('error'));
  if (!nombre) { document.getElementById('chkNombre').classList.add('error'); hasError = true; }
  if (!email || !email.includes('@')) { document.getElementById('chkEmail').classList.add('error'); hasError = true; }
  if (!telefono) { document.getElementById('chkTelefono').classList.add('error'); hasError = true; }
  if (!documento) { document.getElementById('chkDocumento').classList.add('error'); hasError = true; }
  if (!ciudad) { document.getElementById('chkCiudad').classList.add('error'); hasError = true; }
  if (!direccion) { document.getElementById('chkDireccion').classList.add('error'); hasError = true; }
  if (!bancoCodigo) { document.getElementById('chkBanco').classList.add('error'); hasError = true; }
  if (hasError) {
    if (btn) { btn.disabled = false; btn.innerHTML = '<i class="bi bi-check2-circle"></i> Confirmar pedido'; }
    Swal.fire({ icon:'warning', title:'Campos incompletos', text:'Completa todos los campos obligatorios.', confirmButtonColor:'#3CAEE0' });
    return false;
  }

  const precio = PRECIO_DIRECTO > 0 ? PRECIO_DIRECTO : parseFloat(productoActual.precio);
  const total = precio + COSTO_ENVIO;

  const body = {
    producto_id: PRODUCTO_ID,
    variant_id: VARIANT_ID > 0 ? VARIANT_ID : null,
    producto_nombre: productoActual.nombre,
    producto_precio: precio,
    nombre, email, telefono, ciudad, direccion, notas,
    tipo_documento: tipoDocumento,
    documento: documento,
    banco_codigo: bancoCodigo,
    banco_nombre: bancoNombre,
    cantidad: 1,
    total: total,
    costo_envio: COSTO_ENVIO,
    metodo_pago: 'megapagos_pse'
  };

  try {
    const res = await fetch('pedidos', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify(body)
    });
    const json = await res.json();

    if (json.exito && json.pse_url) {
      mostrarConfirmacion(json);
    } else {
      throw new Error(json.mensaje || 'Error al procesar el pedido');
    }
  } catch (e) {
    if (btn) { btn.disabled = false; btn.innerHTML = '<i class="bi bi-check2-circle"></i> Confirmar pedido'; }
    Swal.fire({ icon:'error', title:'Error', text:e.message || 'Hubo un problema. Contáctanos por WhatsApp.', confirmButtonColor:'#3CAEE0' });
  }
  return false;
}

async function procesarPedidoCart(e) {
  e.preventDefault();
  const btn = e.target.querySelector('button[type="submit"]');
  if (btn) { btn.disabled = true; btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status"></span>Procesando...'; }

  const nombre = document.getElementById('chkNombre').value.trim().substring(0,120);
  const email = document.getElementById('chkEmail').value.trim().substring(0,120);
  const telefono = document.getElementById('chkTelefono').value.trim().substring(0,30);
  const ciudad = document.getElementById('chkCiudad').value.trim().substring(0,100);
  const direccion = document.getElementById('chkDireccion').value.trim().substring(0,200);
  const notas = document.getElementById('chkNotas').value.trim().substring(0,500);
  const tipoDocumento = document.getElementById('chkTipoDocumento').value;
  const documento = document.getElementById('chkDocumento').value.trim();
  const bancoSelect = document.getElementById('chkBanco');
  const bancoCodigo = bancoSelect.value;
  const bancoNombre = bancoSelect.options[bancoSelect.selectedIndex]?.getAttribute('data-name') || bancoSelect.options[bancoSelect.selectedIndex]?.text || '';

  let hasError = false;
  document.querySelectorAll('.chk-input,.chk-select').forEach(el => el.classList.remove('error'));
  if (!nombre) { document.getElementById('chkNombre').classList.add('error'); hasError = true; }
  if (!email || !email.includes('@')) { document.getElementById('chkEmail').classList.add('error'); hasError = true; }
  if (!telefono) { document.getElementById('chkTelefono').classList.add('error'); hasError = true; }
  if (!documento) { document.getElementById('chkDocumento').classList.add('error'); hasError = true; }
  if (!ciudad) { document.getElementById('chkCiudad').classList.add('error'); hasError = true; }
  if (!direccion) { document.getElementById('chkDireccion').classList.add('error'); hasError = true; }
  if (!bancoCodigo) { document.getElementById('chkBanco').classList.add('error'); hasError = true; }
  if (hasError) {
    if (btn) { btn.disabled = false; btn.innerHTML = '<i class="bi bi-check2-circle"></i> Confirmar pedido'; }
    Swal.fire({ icon:'warning', title:'Campos incompletos', text:'Completa todos los campos obligatorios.', confirmButtonColor:'#3CAEE0' });
    return false;
  }

  const carrito = JSON.parse(localStorage.getItem('pd_carrito') || '[]');
  if (carrito.length === 0) {
    if (btn) { btn.disabled = false; btn.innerHTML = '<i class="bi bi-check2-circle"></i> Confirmar pedido'; }
    Swal.fire({ icon:'warning', title:'Carrito vacío', text:'Tu carrito está vacío. Agrega productos primero.', confirmButtonColor:'#3CAEE0' });
    return false;
  }

  const subtotal = carrito.reduce((a, i) => a + i.precio * i.cantidad, 0);
  const total = subtotal + COSTO_ENVIO;

  const body = {
    nombre, email, telefono, ciudad, direccion, notas,
    tipo_documento: tipoDocumento,
    documento: documento,
    banco_codigo: bancoCodigo,
    banco_nombre: bancoNombre,
    items: carrito.map(i => ({ producto_id: i.id, variant_id: i.variant_id || null, nombre: i.nombre, precio: i.precio, cantidad: i.cantidad })),
    total: total,
    subtotal: subtotal,
    costo_envio: COSTO_ENVIO,
    cantidad: carrito.reduce((a, i) => a + i.cantidad, 0),
    producto_nombre: carrito.length === 1 ? carrito[0].nombre : 'Pedido múltiple',
    producto_precio: carrito.length === 1 ? carrito[0].precio : (subtotal),
    metodo_pago: 'megapagos_pse',
    is_cart: true
  };

  try {
    const res = await fetch('pedidos', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify(body)
    });
    const json = await res.json();

    if (json.exito && json.pse_url) {
      localStorage.removeItem('pd_carrito');
      if (typeof actualizarContadorCarrito === 'function') actualizarContadorCarrito();
      mostrarConfirmacion(json);
    } else {
      throw new Error(json.mensaje || 'Error al procesar el pedido');
    }
  } catch (e) {
    if (btn) { btn.disabled = false; btn.innerHTML = '<i class="bi bi-check2-circle"></i> Confirmar pedido'; }
    Swal.fire({ icon:'error', title:'Error', text:e.message || 'Hubo un problema. Contáctanos por WhatsApp.', confirmButtonColor:'#3CAEE0' });
  }
  return false;
}

function mostrarConfirmacion(json) {
  document.getElementById('chkContent').innerHTML = `
    <div class="chk-card chk-msg show">
      <div class="chk-msg-icon"><i class="bi bi-check-circle-fill"></i></div>
      <h2>¡Pedido confirmado!</h2>
      <p style="opacity:.75;line-height:1.8;max-width:400px;margin:1rem auto;">
        Tu pedido ha sido registrado. Ahora serás redirigido a <strong>PSE</strong> para completar el pago de forma segura.<br>
        Código de pedido: <strong style="color:var(--cami-turq);">${json.codigo || '—'}</strong>
      </p>
      <a href="${json.pse_url}" class="btn-p1 mt-3" style="display:inline-flex;"><i class="bi bi-bank"></i> Ir a pagar con PSE</a>
      <p style="font-size:.78rem;opacity:.45;margin-top:1rem;">Serás redirigido a la plataforma de tu banco para completar el pago.</p>
    </div>`;
}

initCheckout();
</script>
</body>
</html>
