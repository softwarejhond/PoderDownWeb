<?php
http_response_code(404);
$pageTitle = 'Página no encontrada — Poder Down';
$pageDescription = 'La página que buscas no existe o ha sido movida. Explora la tienda y el arte de Cami en Poder Down.';
$activePage = '';
$metaRobots = 'noindex, follow';
require 'components/header.php';
?>
  <section style="background:white;padding:5rem 0;min-height:60vh;">
    <div class="container text-center">
      <div style="font-family:var(--font-kranky);font-size:6rem;font-weight:900;color:var(--cami-turq);line-height:1;">404</div>
      <h1 style="font-family:var(--font-kranky);margin-top:1rem;">Ups… esta página no existe</h1>
      <p style="opacity:.6;max-width:480px;margin:1rem auto 2rem;">
        Puede que el enlace esté roto o que la página haya sido movida.
        Pero el arte de Cami sigue aquí, a un clic de distancia.
      </p>
      <div class="d-flex justify-content-center gap-3 flex-wrap">
        <a href="index.php" class="btn-p1"><i class="bi bi-house"></i> Ir al inicio</a>
        <a href="productos.php" class="btn-p2"><i class="bi bi-shop"></i> Visitar la tienda</a>
        <a href="blog.php" class="btn-p2"><i class="bi bi-journal-text"></i> Leer el blog</a>
      </div>
    </div>
  </section>
<?php require_once __DIR__ . '/Footer.php'; ?>
