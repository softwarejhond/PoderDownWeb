<?php
$productoId = (int)($_GET['id'] ?? 0);
$precioDirecto = (float)($_GET['precio'] ?? 0);
$variantId = (int)($_GET['variant_id'] ?? 0);

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
  .chk-row { display:grid;grid-template-columns:1fr 1fr;gap:.8rem; }
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
const PRODUCTO_ID = <?= $productoId ?>;
const PRECIO_DIRECTO = <?= $precioDirecto ?>;
const VARIANT_ID = <?= $variantId ?>;

async function initCheckout() {
  if (!PRODUCTO_ID) {
    document.getElementById('chkContent').innerHTML = `<div class="chk-card text-center"><p style="opacity:.6;">No se especificó un producto.</p><a href="productos.php" class="btn-p2 mt-3">← Ir a tienda</a></div>`;
    return;
  }

  let p = null;
  try {
    const res = await fetch(`${API_URL}?action=product&id=${PRODUCTO_ID}`);
    const json = await res.json();
    if (json.exito && json.datos[0]) p = json.datos[0];
    else throw new Error('No encontrado');
  } catch (e) {
    document.getElementById('chkContent').innerHTML = `<div class="chk-card text-center"><p style="opacity:.6;">Producto no disponible.</p><a href="productos.php" class="btn-p2 mt-3">← Ir a tienda</a></div>`;
    return;
  }

  renderizarCheckout(p);
}

function renderizarCheckout(p) {
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
      <div class="chk-summary"><span>Envío</span><span>${p.requiere_envio ? 'Por calcular' : 'Gratis'}</span></div>
      <div class="chk-summary"><span>Total</span><span class="chk-total">$${Number(precio).toLocaleString('es-CO',{minimumFractionDigits:0})}</span></div>
    </div>

    <div class="chk-card">
      <p class="chk-card-title"><i class="bi bi-person-fill" style="color:var(--cami-turq);"></i> Datos de envío</p>
      <form id="checkoutForm" onsubmit="return procesarPedido(event)">
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
        <i class="bi bi-shield-lock-fill"></i>
        <div><p><strong>ePayco</strong> &mdash; Recibirás un enlace de pago seguro por correo o WhatsApp para completar la transacción con tu tarjeta de crédito, débito o en efectivo.</p></div>
      </div>
      <p style="font-size:.78rem;opacity:.5;margin-top:.8rem;">🔒 Tus datos están seguros. No almacenamos información de pago.</p>
    </div>

    <button type="submit" class="btn-p1 chk-submit"><i class="bi bi-check2-circle"></i> Confirmar pedido</button>
    </form>

    <div class="text-center mt-3">
      <a href="producto.php?id=${PRODUCTO_ID}${VARIANT_ID > 0 ? '&variant_preselect=' + VARIANT_ID : ''}" style="font-size:.82rem;color:var(--cami-turq);"><i class="bi bi-arrow-left"></i> Volver al producto</a>
    </div>
  `;

  document.getElementById('chkContent').innerHTML = html;
}

async function procesarPedido(e) {
  e.preventDefault();
  const nombre = document.getElementById('chkNombre').value.trim().substring(0,120);
  const email = document.getElementById('chkEmail').value.trim().substring(0,120);
  const telefono = document.getElementById('chkTelefono').value.trim().substring(0,30);
  const ciudad = document.getElementById('chkCiudad').value.trim().substring(0,100);
  const direccion = document.getElementById('chkDireccion').value.trim().substring(0,200);
  const notas = document.getElementById('chkNotas').value.trim().substring(0,500);

  let hasError = false;
  document.querySelectorAll('.chk-input').forEach(el => el.classList.remove('error'));
  if (!nombre) { document.getElementById('chkNombre').classList.add('error'); hasError = true; }
  if (!email || !email.includes('@')) { document.getElementById('chkEmail').classList.add('error'); hasError = true; }
  if (!telefono) { document.getElementById('chkTelefono').classList.add('error'); hasError = true; }
  if (!ciudad) { document.getElementById('chkCiudad').classList.add('error'); hasError = true; }
  if (!direccion) { document.getElementById('chkDireccion').classList.add('error'); hasError = true; }
  if (hasError) {
    Swal.fire({ icon:'warning', title:'Campos incompletos', text:'Completa todos los campos obligatorios.', confirmButtonColor:'#3CAEE0' });
    return false;
  }

  Swal.fire({ title:'Procesando tu pedido...', allowOutsideClick:false, didOpen:()=>Swal.showLoading() });

  const body = {
    producto_id: PRODUCTO_ID,
    variant_id: VARIANT_ID > 0 ? VARIANT_ID : null,
    nombre, email, telefono, ciudad, direccion, notas,
    cantidad: 1,
    total: PRECIO_DIRECTO > 0 ? PRECIO_DIRECTO : 0,
    metodo_pago: 'epayco',
    items: [{ producto_id: PRODUCTO_ID, variant_id: VARIANT_ID > 0 ? VARIANT_ID : null, nombre: 'Producto', precio: PRECIO_DIRECTO, cantidad: 1 }]
  };

  try {
    const res = await fetch('pedidos.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify(body)
    });
    const json = await res.json();

    if (json.exito || res.ok) {
      document.getElementById('chkContent').innerHTML = `
        <div class="chk-card chk-msg show">
          <div class="chk-msg-icon"><i class="bi bi-check-circle-fill"></i></div>
          <h2>¡Pedido confirmado! 🎉</h2>
          <p style="opacity:.75;line-height:1.8;max-width:400px;margin:1rem auto;">
            Recibirás un enlace de pago por <strong>ePayco</strong> en tu correo y WhatsApp para completar la transacción.<br>
            Código de pedido: <strong style="color:var(--cami-turq);">${json.codigo || json.datos?.[0]?.codigo || '—'}</strong>
          </p>
          <a href="productos.php" class="btn-p1 mt-3" style="display:inline-flex;"><i class="bi bi-shop"></i> Seguir comprando</a>
        </div>`;
    } else {
      throw new Error(json.mensaje || 'Error al procesar');
    }
  } catch (e) {
    Swal.fire({ icon:'error', title:'Error', text:'Hubo un problema. Contáctanos por WhatsApp.', confirmButtonColor:'#3CAEE0' });
  }
  return false;
}

initCheckout();
</script>
</body>
</html>
