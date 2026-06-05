<?php
$pageTitle = $pageTitle ?? 'Poder Down — Checkout';
$pageDescription = $pageDescription ?? 'Finaliza tu compra en Poder Down';
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= htmlspecialchars($pageTitle) ?></title>
  <meta name="description" content="<?= htmlspecialchars($pageDescription) ?>">
  <link rel="icon" type="image/png" href="img/logos/pd_icono.png">
  <link rel="apple-touch-icon" href="img/logos/pd_icono.png">
  <link rel="stylesheet" href="node_modules/bootstrap/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="node_modules/bootstrap-icons/font/bootstrap-icons.css">
  <link href="https://fonts.googleapis.com/css2?family=Archivo:ital,wght@0,400;0,500;0,600;0,700;0,800;0,900;1,400&family=Oregano:ital@0;1&family=Nunito:wght@700;800;900&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="/public/css/marca.css">
  <style>
    :root {
      --cami-bg: #ebeae4; --pd-azul: #3CAEE0; --cami-turq: #3CAEE0;
      --pd-coral: #F2677C; --cami-coral: #F2677C; --cami-amarillo: #F5C518;
      --pd-oscuro: #1A3A5C; --cami-azul: #1A3A5C; --cami-border: #d6d4cc;
      --font-gilroy: 'Nunito','Gilroy',sans-serif;
      --font-archivo: 'Archivo',sans-serif;
      --font-oregano: 'Oregano',cursive;
      --font-kranky: var(--font-gilroy);
      --font-playpen: var(--font-archivo);
    }
    * { box-sizing: border-box; }
    body {
      background: var(--cami-bg);
      color: var(--cami-azul);
      font-family: var(--font-playpen);
      margin: 0;
      min-height: 100vh;
      display: flex;
      flex-direction: column;
    }
    .header-checkout {
      background: white;
      border-bottom: 2px solid var(--cami-border);
      padding: .8rem 0;
    }
    .header-checkout .logo { height: 36px; width: auto; object-fit: contain; }
    .checkout-wrap { flex: 1; padding: 2rem 0 6rem; }
    .checkout-container { max-width: 800px; margin: 0 auto; }
    @media (max-width:575px) {
      .header-checkout .logo { height: 28px; }
      .checkout-wrap { padding: 1rem 0 5rem; }
    }
  </style>
</head>
<body>
  <div class="header-checkout">
    <div class="container d-flex align-items-center justify-content-between">
      <a href="index.php"><img src="img/logos/logo_pd_horizontal.png" alt="Poder Down" class="logo"></a>
      <a href="productos.php" class="btn-p2" style="padding:.35rem .9rem;font-size:.78rem;">← Tienda</a>
    </div>
  </div>
