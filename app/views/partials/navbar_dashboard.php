<!-- ============================================================
     app/views/partials/navbar_dashboard.php
     Navbar del dashboard — colores del Manual de Marca Cami
     Paleta: #003366 (azul oscuro) + #4ed2ad (turquesa) + #efb810 (amarillo)
     ============================================================ -->

<!-- Google Fonts para el dashboard también -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Kranky&family=Playpen+Sans:wght@400;600;700&display=swap" rel="stylesheet">

<style>
  /* Navbar del dashboard usando la paleta oficial de la marca */
  .navbar-dash {
    background: #003366; /* Azul oscuro del manual */
    border-bottom: 3px solid #4ed2ad; /* Línea turquesa de acento */
  }
  .navbar-dash .navbar-brand {
    font-family: 'Kranky', cursive;
    font-size: 1.35rem;
    color: #ffffff;
    letter-spacing: 1px;
  }
  .navbar-dash .navbar-brand .acento { color: #4ed2ad; }
  .navbar-dash .badge-dash {
    background: #efb810;
    color: #003366;
    font-family: 'Playpen Sans', sans-serif;
    font-size: .6rem;
    font-weight: 700;
    border-radius: 50px;
    padding: .2rem .6rem;
    vertical-align: middle;
    margin-left: .3rem;
  }
  .navbar-dash .nav-link {
    font-family: 'Playpen Sans', sans-serif;
    font-weight: 600;
    color: rgba(255,255,255,.78);
    font-size: .88rem;
    border-radius: 8px;
    padding: .45rem .85rem;
    transition: all .2s;
  }
  .navbar-dash .nav-link:hover,
  .navbar-dash .nav-link.active {
    color: #003366;
    background: #4ed2ad;
  }
  .btn-ver-tienda {
    background: transparent;
    color: #4ed2ad;
    border: 1.5px solid #4ed2ad;
    border-radius: 50px;
    font-family: 'Playpen Sans', sans-serif;
    font-weight: 700;
    font-size: .82rem;
    padding: .4rem 1.1rem;
    transition: all .2s;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: .4rem;
  }
  .btn-ver-tienda:hover {
    background: #4ed2ad;
    color: #003366;
  }
</style>

<nav class="navbar navbar-expand-lg navbar-dash">
    <div class="container-fluid px-4">
        <!-- Marca -->
        <a class="navbar-brand" href="<?= BASE_URL ?>/dashboard/inventario.php">
            Día a Día con Cami<span class="acento">.</span>
            <span class="badge-dash">DASHBOARD</span>
        </a>

        <!-- Toggle móvil -->
        <button class="navbar-toggler border-0" type="button"
                data-bs-toggle="collapse" data-bs-target="#navDashboard">
            <i class="bi bi-list text-white fs-4"></i>
        </button>

        <!-- Links -->
        <div class="collapse navbar-collapse" id="navDashboard">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-2 gap-1">
                <li class="nav-item">
                    <a class="nav-link <?= basename($_SERVER['PHP_SELF']) === 'inventario.php' ? 'active' : '' ?>"
                       href="<?= BASE_URL ?>/dashboard/inventario.php">
                        <i class="bi bi-box-seam me-1"></i>Inventario
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= basename($_SERVER['PHP_SELF']) === 'pedidos.php' ? 'active' : '' ?>"
                       href="<?= BASE_URL ?>/dashboard/pedidos.php">
                        <i class="bi bi-bag-check me-1"></i>Pedidos
                        <span class="badge-dash" id="badgePedidosPendientes" style="display:none;background:#e45b63;color:white;"></span>
                    </a>
                </li>
            </ul>

            <!-- Botón "Ver tienda" -->
            <a class="btn-ver-tienda" href="<?= BASE_URL ?>/public/landing.php" target="_blank">
                <i class="bi bi-shop-window"></i>Ver tienda
            </a>
        </div>
    </div>
</nav>
