<!-- ============================================================
   components/wcag.php
   Sidebar de Accesibilidad WCAG 2.1 — Poder Down
   Incluye: tamaño texto, contraste, daltonismo, dislexia,
   lectura por hover, mascara lectora, pausa animaciones, etc.
============================================================ -->
<style>
:root {
  --wcag-accent: #3CAEE0;
  --wcag-bg: #ffffff;
  --wcag-text: #1A3A5C;
  --wcag-border: #d6d4cc;
}

#wcag-fab {
  position: fixed;
  left: 16px;
  bottom: 120px;
  z-index: 9997;
  width: 64px;
  height: 64px;
  border-radius: 50%;
  background: var(--wcag-accent);
  color: #fff;
  border: none;
  cursor: pointer;
  font-size: 1.35rem;
  display: flex;
  align-items: center;
  justify-content: center;
  box-shadow: 0 4px 18px rgba(60,174,224,.4);
  transition: transform .25s, box-shadow .25s;
}
#wcag-fab:hover { transform: scale(1.12) rotate(8deg); box-shadow: 0 6px 24px rgba(60,174,224,.55); }
#wcag-fab:focus-visible { outline: 3px solid #1A3A5C; outline-offset: 3px; }

#wcag-overlay {
  position: fixed; inset: 0;
  background: rgba(26,58,92,.35);
  z-index: 9998;
  display: none;
  opacity: 0;
  transition: opacity .3s;
}
#wcag-overlay.open { display: block; opacity: 1; }

#wcag-sidebar {
  position: fixed; top: 0; left: 0;
  width: 380px; max-width: 92vw;
  height: 100vh; max-height: 100dvh;
  background: var(--wcag-bg);
  z-index: 9999;
  transform: translateX(-100%);
  transition: transform .35s cubic-bezier(.4,0,.2,1);
  display: flex; flex-direction: column;
  box-shadow: 4px 0 36px rgba(26,58,92,.15);
  overflow: hidden;
  color: var(--wcag-text);
  font-family: 'Archivo', sans-serif;
}
#wcag-sidebar.open { transform: translateX(0); }

#wcag-sidebar-header {
  display: flex; align-items: center; justify-content: space-between;
  padding: 1.2rem 1.4rem;
  border-bottom: 2px solid var(--wcag-border);
  flex-shrink: 0;
}
#wcag-sidebar-header h3 {
  margin: 0;
  font-family: 'Nunito', 'Gilroy', sans-serif;
  font-weight: 800; font-size: 1.2rem;
  display: flex; align-items: center; gap: .5rem;
}
#wcag-sidebar-header h3 i { color: var(--wcag-accent); }
#wcag-close-btn {
  background: none;
  border: 2px solid var(--wcag-border);
  border-radius: 50%;
  width: 34px; height: 34px;
  cursor: pointer;
  font-size: 1.3rem;
  display: flex; align-items: center; justify-content: center;
  color: var(--wcag-text);
  transition: all .2s;
  line-height: 1;
}
#wcag-close-btn:hover { border-color: var(--wcag-text); background: var(--wcag-border); }
#wcag-close-btn:focus-visible { outline: 3px solid #1A3A5C; outline-offset: 2px; }

#wcag-scroll { flex: 1; overflow-y: auto; padding: 1rem 1.4rem 2rem; }

.wcag-group { margin-bottom: 1.5rem; }
.wcag-group-title {
  font-size: .72rem; text-transform: uppercase;
  letter-spacing: 2px; font-weight: 700;
  color: var(--wcag-accent);
  margin-bottom: .7rem;
  display: flex; align-items: center; gap: .5rem;
}

.wcag-options { display: flex; flex-wrap: wrap; gap: .4rem; }
.wcag-opt {
  background: #f5f4f0;
  border: 2px solid transparent;
  border-radius: 10px;
  padding: .5rem .75rem;
  font-size: .78rem; font-weight: 600;
  cursor: pointer;
  transition: all .2s;
  color: var(--wcag-text);
  font-family: 'Archivo', sans-serif;
  display: flex; align-items: center; gap: .35rem;
  white-space: nowrap;
}
.wcag-opt:hover { background: #e8e6e0; border-color: var(--wcag-border); }
.wcag-opt.active { background: var(--wcag-accent); color: #fff; border-color: var(--wcag-accent); }
.wcag-opt:focus-visible { outline: 3px solid #1A3A5C; outline-offset: 2px; }

.wcag-range-group { margin-top: .5rem; }
.wcag-range-label {
  display: flex; justify-content: space-between;
  font-size: .76rem; font-weight: 600;
  margin-bottom: .25rem; color: var(--wcag-text);
}
.wcag-range {
  width: 100%;
  -webkit-appearance: none; appearance: none;
  height: 6px; border-radius: 6px;
  background: var(--wcag-border);
  outline: none;
}
.wcag-range::-webkit-slider-thumb {
  -webkit-appearance: none; appearance: none;
  width: 20px; height: 20px; border-radius: 50%;
  background: var(--wcag-accent);
  cursor: pointer; border: 2px solid #fff;
  box-shadow: 0 2px 6px rgba(0,0,0,.15);
}

/* Toggle — label es toda la fila, clickea el checkbox nativamente */
.wcag-toggle-row {
  display: flex; align-items: center; justify-content: space-between;
  padding: .55rem 0;
  border-bottom: 1px solid #f0efe9;
  cursor: pointer;
  user-select: none;
}
.wcag-toggle-row > span:first-child {
  font-size: .82rem; font-weight: 600;
  display: flex; align-items: center; gap: .45rem;
  color: var(--wcag-text);
}
.wcag-switch {
  position: relative;
  width: 44px; height: 26px;
  flex-shrink: 0;
  display: inline-block;
}
.wcag-switch input { opacity: 0; width: 0; height: 0; position: absolute; }
.wcag-switch .slider {
  position: absolute; inset: 0;
  background: #ccc;
  border-radius: 26px;
  transition: background .25s;
  pointer-events: none;
}
.wcag-switch .slider::before {
  content: '';
  position: absolute;
  height: 20px; width: 20px;
  left: 3px; bottom: 3px;
  background: white;
  border-radius: 50%;
  transition: transform .25s;
}
.wcag-switch input:checked + .slider { background: var(--wcag-accent); }
.wcag-switch input:checked + .slider::before { transform: translateX(18px); }
.wcag-switch input:focus-visible + .slider { outline: 3px solid #1A3A5C; outline-offset: 3px; }

#wcag-reset-all {
  width: 100%;
  padding: .7rem;
  border: 2px solid var(--wcag-border);
  border-radius: 12px;
  background: #fff;
  cursor: pointer;
  font-weight: 700; font-size: .85rem;
  color: var(--wcag-text);
  font-family: 'Archivo', sans-serif;
  transition: all .2s;
  margin-top: .5rem;
}
#wcag-reset-all:hover { background: #f5f4f0; border-color: var(--wcag-text); }

#wcag-reading-status {
  display: none;
  position: fixed; bottom: 20px; left: 50%;
  transform: translateX(-50%);
  background: var(--wcag-accent);
  color: #fff;
  padding: .5rem 1.2rem;
  border-radius: 50px;
  font-size: .8rem; font-weight: 700;
  z-index: 10000;
  font-family: 'Archivo', sans-serif;
  box-shadow: 0 4px 16px rgba(60,174,224,.4);
  pointer-events: none;
}

/* ===== ESTADOS WCAG ===== */
body.wcag-high-contrast {
  filter: contrast(1.4) brightness(1.15);
}
body.wcag-high-contrast * {
  background-color: #000 !important;
  color: #fff !important;
  border-color: #fff !important;
}
body.wcag-high-contrast a { color: #FFEB3B !important; text-decoration: underline !important; }

body.wcag-grayscale {
  filter: grayscale(1);
}

body.wcag-big-cursor,
body.wcag-big-cursor * {
  cursor: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 36 36"><polygon points="4,4 4,30 14,22 18,34 22,32 18,20 28,18" fill="%231A3A5C" stroke="%23fff" stroke-width="2"/></svg>') 4 4, auto !important;
}
body.wcag-big-cursor a,
body.wcag-big-cursor button,
body.wcag-big-cursor [role="button"],
body.wcag-big-cursor input[type="submit"],
body.wcag-big-cursor select,
body.wcag-big-cursor .btn-p1,
body.wcag-big-cursor .btn-p2,
body.wcag-big-cursor .btn-p-coral,
body.wcag-big-cursor .btn-carrito,
body.wcag-big-cursor .btn-user,
body.wcag-big-cursor .btn-user-logged {
  cursor: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 36 36"><polygon points="4,4 4,30 14,22 18,34 22,32 18,20 28,18" fill="%23F2677C" stroke="%23fff" stroke-width="2"/></svg>') 4 4, pointer !important;
}

body.wcag-highlight-links a {
  text-decoration: underline !important;
  text-decoration-thickness: 2px !important;
  text-underline-offset: 3px !important;
  background: rgba(60,174,224,.18) !important;
  padding: .1em .3em !important;
  border-radius: 4px !important;
}

body.wcag-focus-outline *:focus-visible {
  outline: 4px solid #F2677C !important;
  outline-offset: 3px !important;
}

body.wcag-pause-anim *,
body.wcag-pause-anim *::before,
body.wcag-pause-anim *::after {
  animation-play-state: paused !important;
  animation-duration: 0s !important;
  animation-iteration-count: 1 !important;
  transition-duration: 0s !important;
  transition-delay: 0s !important;
}

body.wcag-dyslexia {
  font-family: 'Comic Sans MS', 'Trebuchet MS', 'OpenDyslexic', cursive !important;
  letter-spacing: .05em !important;
  word-spacing: .14em !important;
  line-height: 1.9 !important;
}
body.wcag-dyslexia * { font-family: 'Comic Sans MS', 'Trebuchet MS', 'OpenDyslexic', cursive !important; }

body.wcag-readable-font {
  font-family: 'Atkinson Hyperlegible', 'Archivo', 'Arial', sans-serif !important;
}
body.wcag-readable-font * { font-family: 'Atkinson Hyperlegible', 'Archivo', 'Arial', sans-serif !important; }

/* Mascara lectora */
#wcag-reading-mask {
  display: none;
  position: fixed;
  left: 0; right: 0;
  height: 180px;
  background: linear-gradient(to bottom, transparent 0%, rgba(60,174,224,.18) 40%, rgba(60,174,224,.18) 60%, transparent 100%);
  pointer-events: none;
  z-index: 9995;
}

#wcag-sidebar-footer {
  padding: .8rem 1.4rem;
  border-top: 1px solid var(--wcag-border);
  font-size: .7rem; opacity: .5;
  flex-shrink: 0; text-align: center;
}

@media (max-width:575px) {
  #wcag-fab { left: 10px; bottom: 100px; width: 42px; height: 42px; font-size: 1.2rem; }
  #wcag-sidebar { width: 100vw; max-width: 100vw; }
  .wcag-opt { padding: .4rem .6rem; font-size: .73rem; }
}
</style>

<button id="wcag-fab" aria-label="Abrir panel de accesibilidad" title="Accesibilidad WCAG 2.1">
  <i class="bi bi-universal-access"></i>
</button>

<div id="wcag-overlay" aria-hidden="true"></div>

<aside id="wcag-sidebar" aria-label="Panel de accesibilidad" role="dialog" aria-modal="true">
  <div id="wcag-sidebar-header">
    <h3><i class="bi bi-universal-access-circle"></i> Accesibilidad</h3>
    <button id="wcag-close-btn" aria-label="Cerrar panel de accesibilidad">&times;</button>
  </div>
  <div id="wcag-scroll">

    <div class="wcag-group">
      <p class="wcag-group-title"><i class="bi bi-fonts"></i> Tamaño de texto</p>
      <div class="wcag-options">
        <button class="wcag-opt active" data-wcag="font-size" data-value="100">Normal</button>
        <button class="wcag-opt" data-wcag="font-size" data-value="120">Mediano</button>
        <button class="wcag-opt" data-wcag="font-size" data-value="150">Grande</button>
        <button class="wcag-opt" data-wcag="font-size" data-value="200">Extra grande</button>
      </div>
    </div>

    <div class="wcag-group">
      <p class="wcag-group-title"><i class="bi bi-text-paragraph"></i> Espaciado de texto</p>
      <div class="wcag-range-group">
        <div class="wcag-range-label"><span>Altura de línea</span><span id="wcag-lh-val">1.5</span></div>
        <input type="range" class="wcag-range" id="wcag-line-height" min="1.2" max="2.5" step="0.1" value="1.5">
      </div>
      <div class="wcag-range-group mt-2">
        <div class="wcag-range-label"><span>Espaciado letras (em)</span><span id="wcag-ls-val">0</span></div>
        <input type="range" class="wcag-range" id="wcag-letter-spacing" min="0" max="0.25" step="0.01" value="0">
      </div>
      <div class="wcag-range-group mt-2">
        <div class="wcag-range-label"><span>Espaciado palabras (em)</span><span id="wcag-ws-val">0</span></div>
        <input type="range" class="wcag-range" id="wcag-word-spacing" min="0" max="0.4" step="0.02" value="0">
      </div>
    </div>

    <div class="wcag-group">
      <p class="wcag-group-title"><i class="bi bi-text-left"></i> Alineación</p>
      <div class="wcag-options">
        <button class="wcag-opt" data-wcag="text-align" data-value="left">Izquierda</button>
        <button class="wcag-opt" data-wcag="text-align" data-value="justify">Justificado</button>
        <button class="wcag-opt" data-wcag="text-align" data-value="center">Centro</button>
        <button class="wcag-opt" data-wcag="text-align" data-value="right">Derecha</button>
      </div>
    </div>

    <div class="wcag-group">
      <p class="wcag-group-title"><i class="bi bi-type"></i> Tipografía</p>
      <div class="wcag-options">
        <button class="wcag-opt active" data-wcag="font-family" data-value="default">Por defecto</button>
        <button class="wcag-opt" data-wcag="font-family" data-value="readable">Alta legibilidad</button>
        <button class="wcag-opt" data-wcag="font-family" data-value="dyslexia">Dislexia</button>
      </div>
    </div>

    <div class="wcag-group">
      <p class="wcag-group-title"><i class="bi bi-palette"></i> Contraste y color</p>
      <label class="wcag-toggle-row" for="wcag-high-contrast">
        <span><i class="bi bi-circle-half"></i> Alto contraste</span>
        <span class="wcag-switch"><input type="checkbox" id="wcag-high-contrast"><span class="slider"></span></span>
      </label>
      <label class="wcag-toggle-row" for="wcag-grayscale">
        <span><i class="bi bi-droplet"></i> Escala de grises</span>
        <span class="wcag-switch"><input type="checkbox" id="wcag-grayscale"><span class="slider"></span></span>
      </label>
      <div class="wcag-range-group mt-2">
        <div class="wcag-range-label"><span>Saturación</span><span id="wcag-sat-val">100%</span></div>
        <input type="range" class="wcag-range" id="wcag-saturation" min="0" max="200" step="10" value="100">
      </div>
    </div>

    <div class="wcag-group">
      <p class="wcag-group-title"><i class="bi bi-eye"></i> Ayudas visuales</p>
      <label class="wcag-toggle-row" for="wcag-big-cursor">
        <span><i class="bi bi-cursor"></i> Cursor grande</span>
        <span class="wcag-switch"><input type="checkbox" id="wcag-big-cursor"><span class="slider"></span></span>
      </label>
      <label class="wcag-toggle-row" for="wcag-highlight-links">
        <span><i class="bi bi-link-45deg"></i> Resaltar enlaces</span>
        <span class="wcag-switch"><input type="checkbox" id="wcag-highlight-links"><span class="slider"></span></span>
      </label>
      <label class="wcag-toggle-row" for="wcag-focus-outline">
        <span><i class="bi bi-bounding-box-circles"></i> Foco visible grande</span>
        <span class="wcag-switch"><input type="checkbox" id="wcag-focus-outline"><span class="slider"></span></span>
      </label>
      <label class="wcag-toggle-row" for="wcag-reading-mask-toggle">
        <span><i class="bi bi-window-plus"></i> Máscara de lectura</span>
        <span class="wcag-switch"><input type="checkbox" id="wcag-reading-mask-toggle"><span class="slider"></span></span>
      </label>
    </div>

    <div class="wcag-group">
      <p class="wcag-group-title"><i class="bi bi-volume-up"></i> Ayudas de lectura</p>
      <label class="wcag-toggle-row" for="wcag-read-hover">
        <span><i class="bi bi-headphones"></i> Leer al pasar el mouse</span>
        <span class="wcag-switch"><input type="checkbox" id="wcag-read-hover"><span class="slider"></span></span>
      </label>
      <label class="wcag-toggle-row" for="wcag-pause-anim">
        <span><i class="bi bi-pause-circle"></i> Pausar animaciones</span>
        <span class="wcag-switch"><input type="checkbox" id="wcag-pause-anim"><span class="slider"></span></span>
      </label>
    </div>

    <button id="wcag-reset-all"><i class="bi bi-arrow-counterclockwise"></i> Restablecer todo</button>
  </div>
  <div id="wcag-sidebar-footer">WCAG 2.1 · Poder Down</div>
</aside>

<div id="wcag-reading-mask" aria-hidden="true"></div>
<div id="wcag-reading-status" aria-live="assertive"></div>

<script>
(function() {
  'use strict';

  var STORAGE_KEY = 'wcag_pd_settings';
  var defaults = {
    fontSize: 100,
    lineHeight: 1.5,
    letterSpacing: 0,
    wordSpacing: 0,
    textAlign: 'left',
    fontFamily: 'default',
    highContrast: false,
    grayscale: false,
    saturation: 100,
    bigCursor: false,
    highlightLinks: false,
    focusOutline: false,
    readingMask: false,
    readHover: false,
    pauseAnim: false
  };

  var settings = {};
  var sidebarOpen = false;
  var hoverTimeout = null;

  /* ===== PERSISTENCIA ===== */
  function loadSettings() {
    try {
      var stored = localStorage.getItem(STORAGE_KEY);
      settings = stored ? Object.assign({}, defaults, JSON.parse(stored)) : Object.assign({}, defaults);
    } catch (e) {
      settings = Object.assign({}, defaults);
    }
  }

  function saveSettings() {
    try { localStorage.setItem(STORAGE_KEY, JSON.stringify(settings)); } catch (e) {}
  }

  /* ===== APLICAR ===== */
  function applyAll() {
    var html = document.documentElement;
    var body = document.body;

    html.style.fontSize = settings.fontSize + '%';

    body.style.lineHeight = settings.lineHeight !== 1.5 ? String(settings.lineHeight) : '';
    body.style.letterSpacing = settings.letterSpacing ? settings.letterSpacing + 'em' : '';
    body.style.wordSpacing = settings.wordSpacing ? settings.wordSpacing + 'em' : '';

    var alignMap = { left: '', justify: 'justify', center: 'center', right: 'right' };
    body.style.textAlign = alignMap[settings.textAlign] || '';

    body.classList.toggle('wcag-high-contrast', settings.highContrast);
    body.classList.toggle('wcag-grayscale', settings.grayscale);
    body.classList.toggle('wcag-big-cursor', settings.bigCursor);
    body.classList.toggle('wcag-highlight-links', settings.highlightLinks);
    body.classList.toggle('wcag-focus-outline', settings.focusOutline);
    body.classList.toggle('wcag-dyslexia', settings.fontFamily === 'dyslexia');
    body.classList.toggle('wcag-readable-font', settings.fontFamily === 'readable');
    body.classList.toggle('wcag-pause-anim', settings.pauseAnim);

    html.style.filter = settings.saturation !== 100 ? 'saturate(' + (settings.saturation / 100) + ')' : '';

    updateReadingMask();
  }

  /* ===== SINCRONIZAR UI ===== */
  function syncUI() {
    var fontBtns = document.querySelectorAll('[data-wcag="font-size"]');
    fontBtns.forEach(function(b) { b.classList.toggle('active', b.dataset.value === String(settings.fontSize)); });

    var alignBtns = document.querySelectorAll('[data-wcag="text-align"]');
    alignBtns.forEach(function(b) { b.classList.toggle('active', b.dataset.value === settings.textAlign); });

    var famBtns = document.querySelectorAll('[data-wcag="font-family"]');
    famBtns.forEach(function(b) { b.classList.toggle('active', b.dataset.value === settings.fontFamily); });

    document.getElementById('wcag-line-height').value = settings.lineHeight;
    document.getElementById('wcag-lh-val').textContent = settings.lineHeight;

    document.getElementById('wcag-letter-spacing').value = settings.letterSpacing;
    document.getElementById('wcag-ls-val').textContent = settings.letterSpacing.toFixed(2);

    document.getElementById('wcag-word-spacing').value = settings.wordSpacing;
    document.getElementById('wcag-ws-val').textContent = settings.wordSpacing.toFixed(2);

    document.getElementById('wcag-saturation').value = settings.saturation;
    document.getElementById('wcag-sat-val').textContent = settings.saturation + '%';

    document.getElementById('wcag-high-contrast').checked = settings.highContrast;
    document.getElementById('wcag-grayscale').checked = settings.grayscale;
    document.getElementById('wcag-big-cursor').checked = settings.bigCursor;
    document.getElementById('wcag-highlight-links').checked = settings.highlightLinks;
    document.getElementById('wcag-focus-outline').checked = settings.focusOutline;
    document.getElementById('wcag-reading-mask-toggle').checked = settings.readingMask;
    document.getElementById('wcag-read-hover').checked = settings.readHover;
    document.getElementById('wcag-pause-anim').checked = settings.pauseAnim;
  }

  /* ===== SIDEBAR ===== */
  function openSidebar() {
    document.getElementById('wcag-sidebar').classList.add('open');
    document.getElementById('wcag-overlay').classList.add('open');
    document.getElementById('wcag-overlay').style.display = 'block';
    document.body.style.overflow = 'hidden';
    sidebarOpen = true;
    document.getElementById('wcag-close-btn').focus();
  }

  function closeSidebar() {
    document.getElementById('wcag-sidebar').classList.remove('open');
    document.getElementById('wcag-overlay').classList.remove('open');
    document.getElementById('wcag-overlay').style.display = 'none';
    document.body.style.overflow = '';
    sidebarOpen = false;
    document.getElementById('wcag-fab').focus();
  }

  /* ===== LECTURA POR HOVER ===== */
  function speakText(text) {
    if (!text || !text.trim()) return;
    window.speechSynthesis.cancel();
    var u = new SpeechSynthesisUtterance(text.trim());
    u.lang = 'es-CO';
    u.rate = 0.95;
    u.pitch = 1;
    u.volume = 1;

    var voices = window.speechSynthesis.getVoices();
    var es = voices.find(function(v) { return v.lang.startsWith('es'); });
    if (es) u.voice = es;

    u.onstart = function() {
      var st = document.getElementById('wcag-reading-status');
      st.style.display = 'block';
      st.textContent = 'Leyendo...';
    };
    u.onend = function() {
      document.getElementById('wcag-reading-status').style.display = 'none';
    };
    u.onerror = function() {
      document.getElementById('wcag-reading-status').style.display = 'none';
    };
    window.speechSynthesis.speak(u);
  }

  function getTextFromElement(el) {
    if (!el) return '';
    var tag = el.tagName.toLowerCase();
    if (tag === 'img') return el.alt ? 'Imagen: ' + el.alt : '';
    if (tag === 'svg') return '';
    if (tag === 'input' || tag === 'textarea' || tag === 'select') {
      var label = el.getAttribute('aria-label') || el.getAttribute('placeholder') || el.getAttribute('name') || '';
      return label ? 'Campo: ' + label : '';
    }
    var ariaLabel = el.getAttribute('aria-label');
    if (ariaLabel) return ariaLabel;
    var text = (el.textContent || '').replace(/\s+/g, ' ').trim();
    if (text.length > 350) text = text.substring(0, 350) + '';
    return text;
  }

  function handleReadHoverOver(e) {
    if (!settings.readHover) return;
    var target = e.target;
    if (!target || target === document.body || target === document.documentElement) return;
    if (target.closest('#wcag-sidebar') || target.closest('#wcag-fab') || target.closest('#wcag-overlay')) return;

    var text = getTextFromElement(target);
    if (!text || text.length < 2) return;

    if (hoverTimeout) clearTimeout(hoverTimeout);
    hoverTimeout = setTimeout(function() {
      speakText(text);
    }, 700);
  }

  function handleReadHoverOut() {
    if (hoverTimeout) { clearTimeout(hoverTimeout); hoverTimeout = null; }
    window.speechSynthesis.cancel();
    document.getElementById('wcag-reading-status').style.display = 'none';
  }

  function updateReadHoverListeners() {
    if (settings.readHover) {
      document.addEventListener('mouseover', handleReadHoverOver, { passive: true });
      document.addEventListener('mouseout', handleReadHoverOut, { passive: true });
      document.addEventListener('focusin', handleReadHoverOver, { passive: true });
      document.addEventListener('focusout', handleReadHoverOut, { passive: true });
    } else {
      document.removeEventListener('mouseover', handleReadHoverOver);
      document.removeEventListener('mouseout', handleReadHoverOut);
      document.removeEventListener('focusin', handleReadHoverOver);
      document.removeEventListener('focusout', handleReadHoverOut);
      window.speechSynthesis.cancel();
      document.getElementById('wcag-reading-status').style.display = 'none';
    }
  }

  /* ===== MASCARA DE LECTURA ===== */
  function updateReadingMask() {
    var mask = document.getElementById('wcag-reading-mask');
    mask.style.display = settings.readingMask ? 'block' : 'none';
  }

  function moveReadingMask(e) {
    if (!settings.readingMask) return;
    var mask = document.getElementById('wcag-reading-mask');
    var y = e.clientY;
    var h = mask.offsetHeight;
    mask.style.top = (y - h / 2) + 'px';
  }

  /* ===== HANDLERS ===== */
  function handleOptClick(e) {
    var btn = e.target.closest('.wcag-opt');
    if (!btn) return;
    var key = btn.dataset.wcag;
    var value = btn.dataset.value;
    if (!key) return;

    if (key === 'font-size') settings.fontSize = parseInt(value, 10);
    else if (key === 'text-align') settings.textAlign = value;
    else if (key === 'font-family') settings.fontFamily = value;

    saveSettings();
    applyAll();
    syncUI();
  }

  /* Cambio en checkboxes — el label nativo ya los togglea */
  function handleCheckboxChange(e) {
    var cb = e.target;
    if (!cb || cb.type !== 'checkbox') return;
    var id = cb.id;
    if (!id) return;

    var keyMap = {
      'wcag-high-contrast': 'highContrast',
      'wcag-grayscale': 'grayscale',
      'wcag-big-cursor': 'bigCursor',
      'wcag-highlight-links': 'highlightLinks',
      'wcag-focus-outline': 'focusOutline',
      'wcag-reading-mask-toggle': 'readingMask',
      'wcag-read-hover': 'readHover',
      'wcag-pause-anim': 'pauseAnim'
    };
    var key = keyMap[id];
    if (!key) return;

    settings[key] = cb.checked;

    if (key === 'readHover') updateReadHoverListeners();
    if (key === 'readingMask') updateReadingMask();

    saveSettings();
    applyAll();
  }

  function handleRangeInput(e) {
    var slider = e.target;
    if (!slider.classList.contains('wcag-range')) return;
    var id = slider.id;
    var value = parseFloat(slider.value);

    if (id === 'wcag-line-height') {
      settings.lineHeight = value;
      document.getElementById('wcag-lh-val').textContent = value.toFixed(1);
    } else if (id === 'wcag-letter-spacing') {
      settings.letterSpacing = value;
      document.getElementById('wcag-ls-val').textContent = value.toFixed(2);
    } else if (id === 'wcag-word-spacing') {
      settings.wordSpacing = value;
      document.getElementById('wcag-ws-val').textContent = value.toFixed(2);
    } else if (id === 'wcag-saturation') {
      settings.saturation = value;
      document.getElementById('wcag-sat-val').textContent = value + '%';
    }

    saveSettings();
    applyAll();
  }

  function resetAll() {
    settings = Object.assign({}, defaults);
    saveSettings();
    applyAll();
    syncUI();
    updateReadHoverListeners();
    updateReadingMask();
  }

  function handleKeyDown(e) {
    if (e.key === 'Escape' && sidebarOpen) {
      closeSidebar();
    }
  }

  /* ===== INIT ===== */
  function init() {
    loadSettings();

    document.getElementById('wcag-fab').addEventListener('click', openSidebar);
    document.getElementById('wcag-close-btn').addEventListener('click', closeSidebar);
    document.getElementById('wcag-overlay').addEventListener('click', closeSidebar);
    document.getElementById('wcag-scroll').addEventListener('click', handleOptClick);
    document.getElementById('wcag-scroll').addEventListener('change', handleCheckboxChange);
    document.getElementById('wcag-scroll').addEventListener('input', handleRangeInput);
    document.getElementById('wcag-reset-all').addEventListener('click', resetAll);

    document.addEventListener('keydown', handleKeyDown);
    document.addEventListener('mousemove', moveReadingMask, { passive: true });

    applyAll();
    syncUI();
    updateReadHoverListeners();

    if (window.speechSynthesis) {
      window.speechSynthesis.getVoices();
      if (window.speechSynthesis.onvoiceschanged !== undefined) {
        window.speechSynthesis.onvoiceschanged = function() { window.speechSynthesis.getVoices(); };
      }
    }
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', init);
  } else {
    init();
  }
})();
</script>
