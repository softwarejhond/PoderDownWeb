<!-- ===== FOOTER MINI — Barra fija inferior ===== -->
<div class="fl-bar-fija">
  &copy; <?php echo date('Y'); ?> Poder Down by <a href="https://www.agenciaeaglesoftware.com/" target="_blank" rel="noopener noreferrer" class="fl-eagle-link">Eagle Software</a> &mdash; Todos los derechos reservados
</div>

<style>
@font-face {
  font-family: 'Sparose';
  src: url('css/fonts/fonnts.com-Sparose.ttf') format('truetype');
  font-weight: normal;
  font-style: normal;
  font-display: swap;
}

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

.fl-eagle-link {
  color: #1A3A5C;
  text-decoration: none;
  font-weight: 700;
  font-family: 'Sparose', sans-serif;
  transition: color .2s;
}
.fl-eagle-link:hover { color: #3CAEE0; }

@media (max-width:575px) {
  .fl-bar-fija { font-size: .73rem; padding: .6rem 1rem; }
}
</style>
