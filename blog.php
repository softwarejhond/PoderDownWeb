<?php
$slug = $_GET['slug'] ?? null;

if ($slug) {
    require_once __DIR__ . '/components/blog/cargar_blogs.php';
    require_once __DIR__ . '/components/blog/markdown.php';
    $post = getBlogBySlug($slug);
    if (!$post) {
        header('HTTP/1.0 404 Not Found');
        $pageTitle = 'Artículo no encontrado — Poder Down';
        $pageDescription = 'El artículo que buscas no existe o ha sido retirado.';
        $activePage = 'blog';
        require 'components/header.php';
        echo '<section style="background:white;padding:5rem 0;min-height:60vh;"><div class="container text-center"><i class="bi bi-journal-x" style="font-size:4rem;opacity:.2;display:block;margin-bottom:1rem;"></i><h2 style="font-family:var(--font-kranky);">Artículo no encontrado</h2><p style="opacity:.6;">El artículo que buscas no existe o ha sido retirado.</p><a href="blog.php" class="btn-p1 mt-3"><i class="bi bi-arrow-left"></i> Volver al blog</a></div></section>';
        require_once __DIR__ . '/Footer.php';
        exit;
    }
    $pageTitle = htmlspecialchars($post['title']) . ' — Blog Poder Down';
    $pageDescription = htmlspecialchars($post['excerpt'] ?? '');
    $activePage = 'blog';
    $ogTitle = htmlspecialchars($post['title']);
    require 'components/header.php';
    $contentHtml = renderMarkdown($post['content']);
    $imgSrc = !empty($post['featured_image']) ? htmlspecialchars($post['featured_image']) : '';
    ?>
    <style>
      .post-hero {
        background: var(--cami-azul);
        padding: 6rem 0 4rem;
        position: relative;
        overflow: hidden;
      }
      .post-hero::before {
        content: '';
        position: absolute;
        top: -80px; right: -80px;
        width: 350px; height: 350px;
        background: rgba(60,174,224,.12);
        border-radius: 50%;
      }
      .post-hero::after {
        content: '';
        position: absolute;
        bottom: -60px; left: 5%;
        width: 200px; height: 200px;
        background: rgba(242,103,124,.08);
        border-radius: 50%;
      }
      .post-meta {
        display: flex;
        gap: 1.5rem;
        flex-wrap: wrap;
        align-items: center;
        color: rgba(255,255,255,.65);
        font-size: .85rem;
      }
      .post-content {
        max-width: 800px;
        margin: 0 auto;
        padding: 3rem 0 5rem;
      }
      .post-content h2,
      .post-content h3,
      .post-content h4 {
        font-family: var(--font-kranky);
        color: var(--cami-azul);
        margin: 2rem 0 1rem;
      }
      .post-content h2 { font-size: 1.8rem; }
      .post-content h3 { font-size: 1.4rem; }
      .post-content h4 { font-size: 1.15rem; }
      .post-content p {
        font-size: 1.02rem;
        line-height: 1.95;
        color: var(--cami-azul);
        opacity: .82;
        margin-bottom: 1.4rem;
      }
      .post-content img {
        border-radius: 16px;
        margin: 1.5rem 0;
        max-width: 100%;
        height: auto;
      }
      .post-content ul, .post-content ol {
        padding-left: 1.5rem;
        margin-bottom: 1.4rem;
      }
      .post-content li {
        font-size: 1rem;
        line-height: 1.9;
        opacity: .82;
        margin-bottom: .4rem;
      }
      .post-content pre {
        background: var(--cami-azul);
        color: rgba(255,255,255,.85);
        border-radius: 12px;
        padding: 1.2rem 1.5rem;
        overflow-x: auto;
        font-size: .9rem;
        margin: 1.5rem 0;
      }
      .post-content code {
        font-family: 'Courier New', monospace;
      }
      .post-content a {
        color: var(--cami-turq);
        text-decoration: underline;
        text-underline-offset: 3px;
      }
      .post-content a:hover { color: var(--cami-coral); }
      .post-content blockquote {
        border-left: 4px solid var(--cami-turq);
        padding: .8rem 1.4rem;
        margin: 1.5rem 0;
        background: rgba(60,174,224,.06);
        border-radius: 0 12px 12px 0;
      }
      .post-featured-img {
        aspect-ratio: 16 / 9;
        width: 100%;
        object-fit: cover;
        border-radius: 20px;
        margin: -2rem auto 0;
        display: block;
        position: relative;
        z-index: 1;
        box-shadow: 0 12px 40px rgba(0,51,102,.15);
      }
      @media (max-width:767px) {
        .post-hero { padding: 4rem 0 3rem; }
        .post-content { padding: 2rem 0 4rem; }
        .post-content h2 { font-size: 1.5rem; }
        .post-content p { font-size: .95rem; }
        .post-featured-img { border-radius: 14px; margin-top: -1.5rem; }
      }
    </style>
    <section class="post-hero">
      <div class="container position-relative" style="z-index:1;">
        <a href="blog.php" class="d-inline-flex align-items-center gap-2 mb-3" style="color:var(--cami-turq);text-decoration:none;font-size:.85rem;font-weight:600;"><i class="bi bi-arrow-left"></i> Volver al blog</a>
        <h1 style="font-family:var(--font-kranky);color:white;font-size:clamp(1.8rem,5vw,3rem);max-width:700px;"><?= htmlspecialchars($post['title']) ?></h1>
        <div class="post-meta mt-3">
          <span><i class="bi bi-person-circle me-1"></i><?= htmlspecialchars(mb_convert_case($post['author'], MB_CASE_TITLE, 'UTF-8')) ?></span>
          <span><i class="bi bi-calendar3 me-1"></i><?= htmlspecialchars(date('d \d\e M, Y', strtotime($post['created_at']))) ?></span>
        </div>
      </div>
    </section>
    <?php if ($imgSrc): ?>
    <div class="container"><img src="<?= $imgSrc ?>" alt="<?= htmlspecialchars($post['title']) ?>" class="post-featured-img"></div>
    <?php endif; ?>
    <div class="container">
      <div class="post-content">
        <?= $contentHtml ?>
      </div>
      <div class="text-center pb-5">
        <hr style="opacity:.15;margin-bottom:2rem;">
        <a href="blog.php" class="btn-p1"><i class="bi bi-arrow-left"></i> Volver al blog</a>
      </div>
    </div>
    <?php
    require_once __DIR__ . '/Footer.php';
    exit;
}

$page = isset($_GET['page']) ? max(1, (int) $_GET['page']) : 1;
$search = trim($_GET['busqueda'] ?? '');
$perPage = 15;

require_once __DIR__ . '/components/blog/cargar_blogs.php';
$blogs = getBlogs($page, $perPage, $search);
$total = getTotalBlogs($search);
$totalPages = max(1, ceil($total / $perPage));

$pageTitle = 'Blog — Día a día con Cami | Poder Down';
$pageDescription = 'Testimonios, experiencias y artículos de inclusión real desde una historia de vida.';
$activePage = 'blog';
$ogTitle = 'Blog Poder Down';
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
    top: -60px; right: -60px;
    width: 300px; height: 300px;
    background: rgba(60,174,224,.15);
    border-radius: 50%;
  }
  .page-header::after {
    content: '';
    position: absolute;
    bottom: -40px; left: 10%;
    width: 180px; height: 180px;
    background: rgba(242,103,124,.12);
    border-radius: 50%;
  }
  .page-header h1 {
    font-family: var(--font-kranky);
    color: white;
    font-size: clamp(2rem,5vw,3.5rem);
    margin: 0;
  }
  .page-header p { color: rgba(255,255,255,.7); font-size: 1rem; margin: .8rem 0 0; }
  .breadcrumb-cami { display: flex; gap: .5rem; align-items: center; margin-bottom: 1rem; font-size: .8rem; }
  .breadcrumb-cami a { color: var(--cami-turq); text-decoration: none; }
  .breadcrumb-cami a:hover { text-decoration: underline; }
  .breadcrumb-cami span { color: rgba(255,255,255,.45); }

  .blog-list-card {
    background: white;
    border-radius: 20px;
    overflow: hidden;
    height: 100%;
    transition: all .3s;
    text-decoration: none;
    display: block;
  }
  .blog-list-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 16px 40px rgba(0,51,102,.1);
  }
  .blog-list-img {
    aspect-ratio: 16 / 9;
    width: 100%;
    background-size: cover;
    background-position: center;
    display: flex;
    align-items: center;
    justify-content: center;
  }
  .blog-list-img-placeholder {
    aspect-ratio: 16 / 9;
    width: 100%;
    background: linear-gradient(135deg,rgba(60,174,224,.12),rgba(242,103,124,.08));
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2.5rem;
    color: var(--cami-border);
  }
  .blog-list-body {
    padding: 1.5rem;
  }
  .blog-list-title {
    font-family: var(--font-kranky);
    font-size: 1.1rem;
    color: var(--cami-azul);
    margin-bottom: .5rem;
    line-height: 1.3;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
  }
  .blog-list-excerpt {
    font-size: .84rem;
    line-height: 1.7;
    color: var(--cami-azul);
    opacity: .65;
    margin-bottom: .8rem;
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
  }
  .blog-list-meta {
    font-size: .74rem;
    opacity: .45;
    display: flex;
    align-items: center;
    gap: .8rem;
  }

  .search-input {
    border-radius: 50px !important;
    border: 2px solid var(--cami-border) !important;
    font-family: var(--font-playpen) !important;
    background: white !important;
    padding: .7rem 1.4rem !important;
    font-size: .92rem !important;
    max-width: 400px;
    width: 100%;
  }
  .search-input:focus {
    border-color: var(--cami-turq) !important;
    box-shadow: 0 0 0 3px rgba(60,174,224,.2) !important;
    outline: none;
  }

  .pagination .page-link {
    border-radius: 50px !important;
    margin: 0 .15rem;
    border: 2px solid var(--cami-border);
    color: var(--cami-azul);
    font-weight: 600;
    font-family: var(--font-playpen);
    font-size: .85rem;
    padding: .45rem 1rem;
    transition: all .2s;
  }
  .pagination .page-link:hover {
    background: var(--cami-turq);
    border-color: var(--cami-turq);
    color: var(--cami-azul);
  }
  .pagination .page-item.active .page-link {
    background: var(--cami-turq);
    border-color: var(--cami-turq);
    color: var(--cami-azul);
  }
  .pagination .page-item.disabled .page-link {
    opacity: .35;
    pointer-events: none;
  }

  .empty-state {
    text-align: center;
    padding: 4rem 2rem;
  }
  .empty-state i {
    font-size: 3.5rem;
    opacity: .15;
    display: block;
    margin-bottom: 1rem;
  }

  @media (max-width:767px) {
    .page-header { padding: 3rem 0 2rem; }
    .blog-list-body { padding: 1.2rem; }
    .blog-list-title { font-size: 1rem; }
  }
</style>

<section class="page-header">
  <div class="container position-relative" style="z-index:1;">
    <div class="breadcrumb-cami">
      <a href="index.php">Inicio</a><span>/</span><span>Blog</span>
    </div>
    <h1>Día a día con Cami<span style="color:var(--cami-turq);">.</span></h1>
    <p>Testimonios, experiencias y artículos desde una historia de vida real.</p>
  </div>
</section>

<section style="background:var(--cami-bg);padding:3rem 0 5rem;">
  <div class="container">
    <form method="get" action="blog.php" class="d-flex justify-content-center mb-5">
      <div class="input-group" style="max-width:450px;width:100%;">
        <input type="search" name="busqueda" class="form-control search-input" placeholder="Buscar artículos..." value="<?= htmlspecialchars($search) ?>">
        <button class="btn-p1" type="submit" style="border-radius:0 50px 50px 0;padding:.7rem 1.5rem;"><i class="bi bi-search"></i></button>
      </div>
    </form>

    <?php if (empty($blogs)): ?>
      <div class="empty-state">
        <i class="bi bi-journal-x"></i>
        <p style="font-family:var(--font-kranky);font-size:1.3rem;opacity:.5;">No se encontraron artículos</p>
        <?php if ($search): ?>
          <p style="opacity:.4;font-size:.88rem;">Intenta con otra palabra clave.</p>
          <a href="blog.php" class="btn-p2 mt-3" style="font-size:.82rem;">Ver todos los artículos</a>
        <?php else: ?>
          <p style="opacity:.4;font-size:.88rem;">Próximamente publicaremos contenido.</p>
          <a href="index.php" class="btn-p2 mt-3" style="font-size:.82rem;">Volver al inicio</a>
        <?php endif; ?>
      </div>
    <?php else: ?>
      <div class="row g-4">
        <?php foreach ($blogs as $blog):
          $imgSrc = !empty($blog['featured_image']) ? htmlspecialchars($blog['featured_image']) : '';
          $blogUrl = 'blog.php?slug=' . urlencode($blog['slug']);
        ?>
        <div class="col-md-6 col-lg-4">
          <a href="<?= $blogUrl ?>" class="blog-list-card">
            <?php if ($imgSrc): ?>
            <div class="blog-list-img" style="background-image:url('<?= $imgSrc ?>');"></div>
            <?php else: ?>
            <div class="blog-list-img-placeholder"><i class="bi bi-journal-richtext"></i></div>
            <?php endif; ?>
            <div class="blog-list-body">
              <p class="blog-list-title"><?= htmlspecialchars($blog['title']) ?></p>
              <p class="blog-list-excerpt"><?= htmlspecialchars($blog['excerpt'] ?? '') ?></p>
              <div class="blog-list-meta">
                <span><i class="bi bi-person-circle me-1"></i><?= htmlspecialchars(mb_convert_case($blog['author'], MB_CASE_TITLE, 'UTF-8')) ?></span>
                <span><i class="bi bi-calendar3 me-1"></i><?= htmlspecialchars(date('d/m/Y', strtotime($blog['created_at']))) ?></span>
              </div>
            </div>
          </a>
        </div>
        <?php endforeach; ?>
      </div>

      <?php if ($totalPages > 1): ?>
      <nav class="mt-5">
        <ul class="pagination justify-content-center flex-wrap">
          <li class="page-item <?= $page <= 1 ? 'disabled' : '' ?>">
            <a class="page-link" href="blog.php?page=<?= $page - 1 ?><?= $search ? '&busqueda=' . urlencode($search) : '' ?>"><i class="bi bi-chevron-left"></i></a>
          </li>
          <?php for ($i = 1; $i <= $totalPages; $i++): ?>
          <li class="page-item <?= $i === $page ? 'active' : '' ?>">
            <a class="page-link" href="blog.php?page=<?= $i ?><?= $search ? '&busqueda=' . urlencode($search) : '' ?>"><?= $i ?></a>
          </li>
          <?php endfor; ?>
          <li class="page-item <?= $page >= $totalPages ? 'disabled' : '' ?>">
            <a class="page-link" href="blog.php?page=<?= $page + 1 ?><?= $search ? '&busqueda=' . urlencode($search) : '' ?>"><i class="bi bi-chevron-right"></i></a>
          </li>
        </ul>
      </nav>
      <?php endif; ?>
    <?php endif; ?>
  </div>
</section>

<?php require_once __DIR__ . '/Footer.php'; ?>

<script src="node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

