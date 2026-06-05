<!-- ===== FOOTER GRANDE — Poder Down ===== -->
<footer class="footer-landing" id="contacto">
  <div class="container">

    <div class="row g-4 pb-4">

      <!-- Columna 1: Marca -->
      <div class="col-md-4">
        <div class="mb-2">
          <img src="img/logos/logo_pd_horizontal.png" alt="Poder Down" style="height:50px;width:auto;object-fit:contain;">
        </div>
        <p class="fl-brand-desc">
          El poder de creer e incluir.<br>
          Inspirando desde la autenticidad y la inclusión real.
        </p>
        <div class="d-flex gap-2 mt-3">
          <a href="https://www.instagram.com/diaadiaconcami" target="_blank" rel="noopener noreferrer" class="fl-social-btn"><i class="bi bi-instagram"></i></a>
          <a href="#" class="fl-social-btn"><i class="bi bi-tiktok"></i></a>
          <a href="#" class="fl-social-btn"><i class="bi bi-facebook"></i></a>
          <a href="#" class="fl-social-btn"><i class="bi bi-youtube"></i></a>
        </div>
      </div>

      <!-- Columna 2: Navegación -->
      <div class="col-6 col-md-2">
        <p class="fl-col-title">Navegación</p>
        <ul class="list-unstyled d-flex flex-column gap-2 fl-list">
          <li><a href="#inicio">Inicio</a></li>
          <li><a href="#sobre-mi">Sobre mí</a></li>
          <li><a href="#catalogo">Productos</a></li>
          <li><a href="#deseo">Charlas</a></li>
          <li><a href="#galeria">Galería virtual</a></li>
          <li><a href="#blog">Blog</a></li>
          <li><a href="#contacto">Contacto</a></li>
        </ul>
      </div>

      <!-- Columna 3: Contacto -->
      <div class="col-6 col-md-2">
        <p class="fl-col-title">Contacto</p>
        <ul class="list-unstyled d-flex flex-column gap-2 fl-list">
          <li>
            <a href="mailto:info@poderdown.com" class="fl-contact-link">
              <i class="bi bi-envelope-fill fl-icon-accent"></i>info@poderdown.com
            </a>
          </li>
          <li>
            <a href="https://wa.me/573137468039" target="_blank" rel="noopener noreferrer" class="fl-contact-link">
              <i class="bi bi-whatsapp fl-icon-accent"></i>313 746 8039
            </a>
          </li>
          <li>
            <a href="https://www.instagram.com/diaadiaconcami" target="_blank" rel="noopener noreferrer" class="fl-contact-link">
              <i class="bi bi-instagram fl-icon-accent"></i>@diaadiaconcami
            </a>
          </li>
        </ul>
      </div>

      <!-- Columna 4: Newsletter -->
      <div class="col-md-4">
        <p class="fl-col-title">Únete a la comunidad</p>
        <p class="fl-newsletter-desc">Recibe inspiración y novedades de Poder Down directamente en tu correo.</p>
        <div class="d-flex gap-2 mt-3">
          <input type="email" class="fl-input" placeholder="tucorreo@email.com">
          <button class="fl-btn-send"><i class="bi bi-send-fill"></i></button>
        </div>
        <div class="mt-3">
          <a href="#contacto" class="fl-btn-invite"><i class="bi bi-mic"></i> Invítanos a participar</a>
        </div>
      </div>
    </div>

    <!-- Barra de confianza -->
    <div class="fl-trust-bar">
      <span class="fl-trust-item">🏆 +5 Conferencias Internacionales</span>
      <span class="fl-trust-item">🌎 +5 Países Alcanzados</span>
      <span class="fl-trust-item">🎨 Artista</span>
      <span class="fl-trust-item">🎤 Speaker Motivacional</span>
      <span class="fl-trust-item">💼 5 Empleos Exitosos</span>
    </div>

  </div>
</footer>

<!-- ===== FOOTER CHIQUITO FIJO ===== -->
<div class="fl-bar-fija">
  © <?php echo date('Y'); ?> Poder Down by <a href="https://www.agenciaeaglesoftware.com/" target="_blank" rel="noopener noreferrer" class="fl-eagle-link">Eagle Software</a>  — Todos los derechos reservados
  
</div>

<style>
@import url('https://fonts.googleapis.com/css2?family=Archivo:ital,wght@0,400;0,600;0,700;0,800;1,400&family=Oregano:ital@0;1&family=Nunito:wght@700;800;900&display=swap');

@font-face {
  font-family: 'Sparose';
  src: url('css/fonts/fonnts.com-Sparose.ttf') format('truetype');
  font-weight: normal;
  font-style: normal;
  font-display: swap;
}

/* ===== FOOTER GRANDE ===== */
.footer-landing {
  background: #ebeae4;
  border-top: 2px solid #d6d4cc;
  padding: 3rem 0 1rem; /* 5rem abajo para no quedar tapado por la barra fija */
  font-family: 'Archivo', sans-serif;
  color: #1A3A5C;
  box-shadow: 0 -4px 20px rgba(0,51,102,.06);
}

.fl-brand {
  font-family: 'Nunito', 'Gilroy', sans-serif;
  font-size: 1.7rem;
  color: #1A3A5C;
  margin: 0;
  line-height: 1;
}
.fl-brand-dot { color: #3CAEE0; }
.fl-brand-desc {
  font-size: .85rem;
  line-height: 1.75;
  color: rgba(0,51,102,.65);
  max-width: 260px;
  margin-top: .8rem;
  margin-bottom: 0;
}

.fl-social-btn {
  width: 36px; height: 36px;
  border-radius: 50%;
  background: #1A3A5C;
  color: white;
  display: inline-flex;
  align-items: center;
  justify-content: center;
  font-size: .95rem;
  text-decoration: none;
  transition: background .2s, transform .2s;
}
.fl-social-btn:hover {
  background: #3CAEE0;
  color: #1A3A5C;
  transform: translateY(-3px);
}

.fl-col-title {
  color: #1A3A5C;
  font-weight: 700;
  font-size: .9rem;
  margin-bottom: 1rem;
}
.fl-list a {
  font-size: .86rem;
  color: rgba(0,51,102,.65);
  text-decoration: none;
  transition: color .2s;
}
.fl-list a:hover { color: #3CAEE0; }

.fl-contact-link {
  display: flex;
  align-items: center;
  gap: .4rem;
  font-size: .86rem;
  color: rgba(0,51,102,.65);
  text-decoration: none;
  transition: color .2s;
}
.fl-contact-link:hover { color: #3CAEE0; }
.fl-icon-accent { color: #3CAEE0; }

.fl-newsletter-desc {
  font-size: .84rem;
  color: rgba(0,51,102,.65);
  line-height: 1.7;
  margin: 0;
}
.fl-input {
  flex: 1;
  padding: .55rem .9rem;
  border: 2px solid #d6d4cc;
  border-radius: 50px;
  font-family: 'Archivo', sans-serif;
  font-size: .84rem;
  color: #1A3A5C;
  background: white;
  outline: none;
  transition: border-color .2s;
}
.fl-input:focus { border-color: #3CAEE0; }
.fl-btn-send {
  background: #F2677C;
  color: white;
  border: none;
  border-radius: 50px;
  padding: .55rem 1rem;
  font-size: .9rem;
  cursor: pointer;
  transition: background .2s, transform .2s;
  display: inline-flex;
  align-items: center;
}
.fl-btn-send:hover { background: #c94851; transform: translateY(-2px); }

.fl-btn-invite {
  background: #3CAEE0;
  color: #1A3A5C;
  border: none;
  border-radius: 50px;
  padding: .6rem 1.4rem;
  font-size: .84rem;
  font-weight: 700;
  font-family: 'Archivo', sans-serif;
  cursor: pointer;
  text-decoration: none;
  display: inline-flex;
  align-items: center;
  gap: .4rem;
  transition: transform .2s, box-shadow .2s;
}
.fl-btn-invite:hover {
  transform: translateY(-2px);
  box-shadow: 0 8px 22px rgba(78,210,173,.4);
  color: #1A3A5C;
}

.fl-trust-bar {
  display: flex;
  flex-wrap: wrap;
  gap: .6rem 1.4rem;
  justify-content: center;
  padding: 1.2rem 0;
  border-top: 1px dashed #d6d4cc;
  border-bottom: 1px dashed #d6d4cc;
  margin: 1.5rem 0;
}
.fl-trust-item {
  font-size: .78rem;
  font-weight: 700;
  color: rgba(0,51,102,.7);
  letter-spacing: .3px;
}

.fl-divider { border-color: #d6d4cc; margin: 0 0 1rem; }

.fl-bottom {
  display: flex;
  justify-content: space-between;
  align-items: center;
  flex-wrap: wrap;
  gap: .5rem;
}
.fl-copy {
  font-size: .78rem;
  color: rgba(0,51,102,.5);
  margin: 0;
}
.fl-made {
  font-size: .78rem;
  color: rgba(0,51,102,.45);
  margin: 0;
}

/* ===== BARRA FIJA ===== */
.fl-bar-fija {
  position: fixed;
  bottom: 0;
  left: 0;
  right: 0;
  background: #ebeae4;
  border-top: 2px solid #d6d4cc;
  padding: .75rem 1.5rem;
  text-align: center;
  font-size: .82rem;
  color: rgba(0,51,102,.6);
  font-family: 'Archivo', sans-serif;
  box-shadow: 0 -2px 12px rgba(0,51,102,.06);
  z-index: 1000;
}

/* Compartidos */
.fl-heart { color: #F2677C; }
.fl-eagle-link {
  color: #1A3A5C;
  text-decoration: none;
  font-weight: 700;
  font-family: 'Sparose', sans-serif;
  transition: color .2s;
}
.fl-eagle-link:hover { color: #3CAEE0; }

/* ===== RESPONSIVE FOOTER ===== */
@media (max-width:767px) {
  .footer-landing { padding: 2.5rem 0 1rem; }
  .fl-brand-desc { max-width: 100%; }
  .fl-trust-bar { gap: .4rem 1rem; }
  .fl-trust-item { font-size: .72rem; }
}
@media (max-width:575px) {
  .footer-landing { padding: 2rem 0 1rem; }
  /* Logo footer más pequeño */
  .footer-landing img[alt="Poder Down"] { height: 38px !important; }
  /* Columnas de nav y contacto en una fila */
  .fl-col-title { font-size: .84rem; margin-bottom: .7rem; }
  .fl-list a,
  .fl-contact-link { font-size: .8rem; }
  /* Newsletter full width */
  .fl-input { font-size: .8rem; padding: .48rem .8rem; }
  .fl-trust-bar { flex-direction: column; align-items: center; gap: .3rem; }
  .fl-trust-item { font-size: .73rem; text-align: center; }
  /* Barra fija más compacta */
  .fl-bar-fija { font-size: .73rem; padding: .6rem 1rem; }
}
@media (max-width:359px) {
  .footer-landing { padding: 1.5rem 0 .8rem; }
}
</style>