(function () {
  if (window._carritoInit) return;
  window._carritoInit = true;

  var carrito = JSON.parse(localStorage.getItem('pd_carrito') || '[]');
  window.carrito = carrito;

  var modalHtml =
    '<div class="cart-overlay" id="cartOverlay" onclick="if(event.target===this)cerrarCarrito()">' +
    '  <div class="cart-modal" id="cartModal">' +
    '    <div class="cart-header">' +
    '      <span class="cart-title"><i class="bi bi-bag-heart-fill"></i> Mi carrito</span>' +
    '      <button class="cart-close" onclick="cerrarCarrito()" aria-label="Cerrar"><i class="bi bi-x-lg"></i></button>' +
    '    </div>' +
    '    <div class="cart-items" id="cartItems"></div>' +
    '    <div class="cart-footer" id="cartFooter">' +
    '      <div class="cart-total-row">' +
    '        <span>Total</span>' +
    '        <span class="cart-total" id="cartTotal">$0</span>' +
    '      </div>' +
    '      <button class="btn-p1 cart-checkout-btn" id="cartCheckoutBtn" onclick="abrirCheckout()">' +
    '        <i class="bi bi-credit-card"></i> Finalizar compra' +
    '      </button>' +
    '      <p class="cart-shipping-note">Envíos a toda Colombia</p>' +
    '    </div>' +
    '    <div class="cart-empty" id="cartEmpty" style="display:none">' +
    '      <i class="bi bi-bag" style="font-size:3.5rem;opacity:.12;display:block;margin-bottom:1rem;"></i>' +
    '      <p style="margin:0;opacity:.5;">Tu carrito está vacío</p>' +
    '      <button class="btn-p2" style="margin-top:1.2rem;font-size:.8rem;padding:.5rem 1.4rem;" onclick="cerrarCarrito()">Seguir comprando</button>' +
    '    </div>' +
    '  </div>' +
    '</div>';

  var styleEl = document.createElement('style');
  styleEl.textContent =
    '.cart-overlay { display:none;position:fixed;inset:0;background:rgba(0,0,0,.55);z-index:9999;align-items:center;justify-content:center;padding:1rem; }' +
    '.cart-overlay.open { display:flex; }' +
    '.cart-modal { background:#fff;border-radius:24px;width:100%;max-width:460px;max-height:85vh;display:flex;flex-direction:column;box-shadow:0 16px 48px rgba(26,58,92,.18);animation:cartFadeIn .3s ease;overflow:hidden; }' +
    '@keyframes cartFadeIn { from{opacity:0;transform:translateY(20px) scale(.97);} to{opacity:1;transform:translateY(0) scale(1);} }' +
    '.cart-header { display:flex;justify-content:space-between;align-items:center;padding:1.2rem 1.4rem;border-bottom:2px solid var(--cami-border,#d6d4cc); }' +
    '.cart-title { font-family:var(--font-kranky,"Nunito",sans-serif);font-size:1.25rem;color:var(--cami-azul);display:flex;align-items:center;gap:.5rem; }' +
    '.cart-close { background:none;border:none;color:var(--cami-azul);font-size:1.2rem;cursor:pointer;opacity:.5;transition:opacity .2s;padding:4px; }' +
    '.cart-close:hover { opacity:1; }' +
    '.cart-items { flex:1;overflow-y:auto;padding:.6rem 1.2rem;max-height:50vh; }' +
    '.cart-items::-webkit-scrollbar { width:4px; }' +
    '.cart-items::-webkit-scrollbar-thumb { background:var(--cami-border);border-radius:4px; }' +
    '.cart-item { display:flex;align-items:center;gap:.8rem;padding:.8rem 0;border-bottom:1px solid var(--cami-border,#d6d4cc); }' +
    '.cart-item:last-child { border-bottom:none; }' +
    '.cart-item-thumb { width:52px;height:52px;border-radius:12px;flex-shrink:0;overflow:hidden;background:linear-gradient(135deg,rgba(60,174,224,.1),rgba(0,51,102,.03));display:flex;align-items:center;justify-content:center; }' +
    '.cart-item-thumb img { width:100%;height:100%;object-fit:cover; }' +
    '.cart-item-thumb .thumb-fallback { font-size:1.3rem;color:var(--cami-border); }' +
    '.cart-item-info { flex:1;min-width:0; }' +
    '.cart-item-name { font-family:var(--font-playpen,"Archivo",sans-serif);font-weight:600;font-size:.85rem;color:var(--cami-azul);overflow:hidden;text-overflow:ellipsis;white-space:nowrap; }' +
    '.cart-item-price { font-family:var(--font-kranky,"Nunito",sans-serif);font-size:.9rem;color:var(--cami-turq);margin-top:2px; }' +
    '.cart-variant-badge { display:inline-block;background:rgba(60,174,224,.12);color:var(--cami-azul);border-radius:50px;padding:.12rem .6rem;font-size:.68rem;font-weight:700;margin-top:3px;max-width:100%;overflow:hidden;text-overflow:ellipsis;white-space:nowrap; }' +
    '.cart-item-qty { display:flex;align-items:center;gap:.35rem;flex-shrink:0; }' +
    '.cart-qty-btn { width:28px;height:28px;border-radius:50%;border:none;display:flex;align-items:center;justify-content:center;cursor:pointer;font-size:.85rem;transition:all .15s;font-weight:700; }' +
    '.cart-qty-btn.minus { background:var(--cami-bg,#ebeae4);color:var(--cami-azul); }' +
    '.cart-qty-btn.minus:hover { background:var(--cami-coral,#F2677C);color:#fff; }' +
    '.cart-qty-btn.plus { background:var(--cami-turq,#3CAEE0);color:var(--cami-azul); }' +
    '.cart-qty-btn.plus:hover { background:var(--cami-azul);color:#fff; }' +
    '.cart-qty-num { font-weight:700;font-size:.8rem;min-width:22px;text-align:center;color:var(--cami-azul); }' +
    '.cart-item-remove { background:rgba(242,103,124,.12);border:none;border-radius:50%;width:28px;height:28px;display:flex;align-items:center;justify-content:center;cursor:pointer;color:var(--cami-coral,#F2677C);font-size:.75rem;flex-shrink:0;transition:all .15s; }' +
    '.cart-item-remove:hover { background:var(--cami-coral,#F2677C);color:#fff; }' +
    '.cart-footer { padding:1rem 1.4rem 1.4rem;border-top:2px solid var(--cami-border,#d6d4cc); }' +
    '.cart-total-row { display:flex;justify-content:space-between;align-items:center;margin-bottom:1rem;font-family:var(--font-playpen,"Archivo",sans-serif);font-weight:700;font-size:.92rem;color:var(--cami-azul); }' +
    '.cart-total { font-family:var(--font-kranky,"Nunito",sans-serif);font-size:1.4rem;color:var(--cami-azul); }' +
    '.cart-checkout-btn { width:100%;justify-content:center;font-size:.95rem;padding:.82rem 2rem; }' +
    '.cart-shipping-note { text-align:center;font-size:.7rem;opacity:.45;margin:.6rem 0 0; }' +
    '.cart-empty { text-align:center;padding:3rem 1.5rem 2rem;display:flex;flex-direction:column;align-items:center; }' +
    '@media (max-width:480px) { .cart-modal { border-radius:20px 20px 0 0;max-height:90vh; } .cart-overlay { align-items:flex-end; } ' +
    '  .cart-item-thumb { width:44px;height:44px; } .cart-item-name { font-size:.8rem; } .cart-item-price { font-size:.82rem; } }';

  document.head.appendChild(styleEl);
  document.body.insertAdjacentHTML('beforeend', modalHtml);

  function guardar() {
    localStorage.setItem('pd_carrito', JSON.stringify(carrito));
  }

  function formatearPrecio(val) {
    return '$' + Number(val).toLocaleString('es-CO', { minimumFractionDigits: 0 });
  }

  function renderizarCarrito() {
    var itemsEl = document.getElementById('cartItems');
    var footerEl = document.getElementById('cartFooter');
    var emptyEl = document.getElementById('cartEmpty');
    var checkoutBtn = document.getElementById('cartCheckoutBtn');

    if (!carrito.length) {
      itemsEl.innerHTML = '';
      footerEl.style.display = 'none';
      emptyEl.style.display = 'flex';
      if (checkoutBtn) checkoutBtn.style.display = 'none';
    } else {
      emptyEl.style.display = 'none';
      footerEl.style.display = 'block';
      if (checkoutBtn) checkoutBtn.style.display = '';

      itemsEl.innerHTML = carrito.map(function (item, idx) {
        var thumbHtml = item.imagen
          ? '<img src="' + item.imagen + '" alt="" onerror="this.style.display=\'none\';this.nextElementSibling.style.display=\'flex\'"><span class="thumb-fallback" style="display:none"><i class="bi bi-image"></i></span>'
          : '<span class="thumb-fallback"><i class="bi bi-image"></i></span>';
        var vid = item.variant_id || 0;
        var variantBadge = item.variant_label
          ? '<span class="cart-variant-badge">' + item.variant_label.replace(/</g, '&lt;').replace(/>/g, '&gt;') + '</span>'
          : '';
        return '<div class="cart-item">' +
          '<div class="cart-item-thumb">' + thumbHtml + '</div>' +
          '<div class="cart-item-info">' +
          '<div class="cart-item-name">' + item.nombre.replace(/</g, '&lt;').replace(/>/g, '&gt;') + '</div>' +
          variantBadge +
          '<div class="cart-item-price">' + formatearPrecio(item.precio) + ' c/u</div>' +
          '</div>' +
          '<div class="cart-item-qty">' +
          '<button class="cart-qty-btn minus" onclick="cambiarCantidad(' + item.id + ',-1,' + vid + ')" aria-label="Restar">\u2212</button>' +
          '<span class="cart-qty-num">\u00d7' + item.cantidad + '</span>' +
          '<button class="cart-qty-btn plus" onclick="cambiarCantidad(' + item.id + ',1,' + vid + ')" aria-label="Sumar">+</button>' +
          '</div>' +
          '<button class="cart-item-remove" onclick="quitarItem(' + item.id + ',' + vid + ')" aria-label="Quitar"><i class="bi bi-trash3"></i></button>' +
          '</div>';
      }).join('');

      var total = carrito.reduce(function (a, i) { return a + i.precio * i.cantidad; }, 0);
      document.getElementById('cartTotal').textContent = formatearPrecio(total);
    }
  }

  window.actualizarContadorCarrito = function () {
    var contador = document.getElementById('contadorCarrito');
    if (!contador) return;
    var total = carrito.reduce(function (a, i) { return a + i.cantidad; }, 0);
    contador.textContent = total;
  };

  window.agregarAlCarrito = function (id, nombre, precio, imagen, variantId, variantLabel) {
    nombre = typeof nombre === 'string' && nombre.indexOf('%') !== -1 ? decodeURIComponent(nombre) : nombre;
    variantId = variantId || null;
    variantLabel = variantLabel || '';
    var ex = carrito.find(function (i) { return i.id === id && i.variant_id === variantId; });
    if (ex) { ex.cantidad++; }
    else { carrito.push({ id: id, variant_id: variantId, variant_label: variantLabel, nombre: nombre, precio: Number(precio), cantidad: 1, imagen: imagen || '' }); }
    guardar();
    actualizarContadorCarrito();
    if (typeof Swal !== 'undefined') {
      Swal.fire({
        toast: true, position: 'bottom-end', icon: 'success',
        title: '\u00a1' + nombre + ' agregado!', showConfirmButton: false,
        timer: 2200, timerProgressBar: true, background: '#ebeae4', color: '#1A3A5C'
      });
    }
  };

  window.agregarAlCarritoBtn = function (event, el) {
    if (event) { event.stopPropagation(); event.preventDefault(); }
    var id = parseInt(el.dataset.pid);
    var nombre = decodeURIComponent(el.dataset.nombre);
    var precio = parseFloat(el.dataset.precio);
    var imagen = el.dataset.imagen || '';
    var variantId = el.dataset.variantId ? parseInt(el.dataset.variantId) : null;
    var variantLabel = el.dataset.variantLabel || '';
    window.agregarAlCarrito(id, nombre, precio, imagen, variantId, variantLabel);
  };

  window.verCarrito = function () {
    renderizarCarrito();
    document.getElementById('cartOverlay').classList.add('open');
    document.body.style.overflow = 'hidden';
  };

  window.cerrarCarrito = function () {
    document.getElementById('cartOverlay').classList.remove('open');
    document.body.style.overflow = '';
  };

  window.cambiarCantidad = function (id, delta, variantId) {
    var item = carrito.find(function (i) { return i.id === id && (i.variant_id || null) === (variantId || null); });
    if (!item) return;
    item.cantidad += delta;
    if (item.cantidad <= 0) {
      carrito = carrito.filter(function (i) { return !(i.id === id && (i.variant_id || null) === (variantId || null)); });
    }
    guardar();
    actualizarContadorCarrito();
    renderizarCarrito();
  };

  window.quitarItem = function (id, variantId) {
    carrito = carrito.filter(function (i) { return !(i.id === id && (i.variant_id || null) === (variantId || null)); });
    guardar();
    actualizarContadorCarrito();
    renderizarCarrito();
  };

  window.abrirCheckout = function () {
    var tp = carrito.reduce(function (a, i) { return a + i.precio * i.cantidad; }, 0);
    if (tp <= 0) return;
    window.location.href = 'checkout.php?source=cart';
  };

  window._procesarCompra = async function (datosCliente) {
    if (typeof Swal === 'undefined') return;
    Swal.fire({ title: 'Procesando tu pedido...', allowOutsideClick: false, didOpen: function () { Swal.showLoading(); } });
    try {
      var body = {
        nombre: datosCliente.nombre, email: datosCliente.email,
        telefono: datosCliente.telefono, ciudad: datosCliente.ciudad, direccion: datosCliente.direccion,
        items: carrito.map(function (i) { return { producto_id: i.id, variant_id: i.variant_id || null, nombre: i.nombre, precio: i.precio, cantidad: i.cantidad }; }),
        total: carrito.reduce(function (a, i) { return a + i.precio * i.cantidad; }, 0)
      };
      var res = await fetch('pedidos', { method: 'POST', headers: { 'Content-Type': 'application/json' }, body: JSON.stringify(body) });
      var json = await res.json();
      if (json.exito || res.ok) {
        carrito = []; guardar(); actualizarContadorCarrito(); cerrarCarrito();
        Swal.fire({ icon: 'success', title: '\u00a1Pedido confirmado! \uD83C\uDF89', html: '<p style="font-family:var(--font-archivo)">Recibiste un email de confirmación.</p>', confirmButtonColor: '#3CAEE0' });
      } else throw new Error(json.mensaje || 'Error');
    } catch (e) {
      Swal.fire({ icon: 'error', title: 'Oops...', text: 'Hubo un problema. Contáctanos por WhatsApp.', confirmButtonColor: '#3CAEE0' });
    }
  };

  actualizarContadorCarrito();
})();
