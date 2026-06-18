<?php
$pageTitle = 'Política de Calidad — Poder Down';
$pageDescription = 'Política de Calidad, Garantías y Cumplimiento de Poder Down por María Camila González Torres.';
$activePage = 'legal';
$showNavSearch = false;
require 'components/header.php';
?>

<style>
  .legal-wrapper {
    max-width: 860px;
    margin: 0 auto;
    padding: 3rem 1.5rem 6rem;
  }
  .legal-hero {
    text-align: center;
    margin-bottom: 3rem;
    padding-bottom: 2rem;
    border-bottom: 2px solid var(--cami-border);
  }
  .legal-hero h1 {
    font-family: var(--font-kranky);
    font-size: clamp(1.6rem, 4vw, 2.4rem);
    color: var(--cami-azul);
    line-height: 1.2;
    margin-bottom: .5rem;
  }
  .legal-hero .legal-subtitle {
    font-size: .88rem;
    color: rgba(0,51,102,.55);
    margin: 0;
  }
  .legal-hero .legal-date {
    display: inline-block;
    background: rgba(60,174,224,.12);
    color: var(--cami-azul);
    border-radius: 50px;
    padding: .3rem 1rem;
    font-size: .75rem;
    font-weight: 600;
    margin-top: .8rem;
  }
  .legal-info-card {
    background: white;
    border: 2px solid var(--cami-border);
    border-radius: 16px;
    padding: 1.5rem 2rem;
    margin-bottom: 2.5rem;
  }
  .legal-info-card .info-row {
    display: flex;
    flex-wrap: wrap;
    gap: .4rem 2rem;
    font-size: .86rem;
    color: rgba(0,51,102,.7);
  }
  .legal-info-card .info-row strong {
    color: var(--cami-azul);
    font-weight: 700;
  }
  .legal-section {
    margin-bottom: 2.5rem;
  }
  .legal-section h2 {
    font-family: var(--font-kranky);
    font-size: 1.25rem;
    color: var(--cami-azul);
    margin-bottom: 1rem;
    padding-bottom: .6rem;
    border-bottom: 1px solid var(--cami-border);
  }
  .legal-section h3 {
    font-family: var(--font-kranky);
    font-size: 1.05rem;
    color: var(--cami-azul);
    margin: 1.5rem 0 .7rem;
  }
  .legal-section p {
    font-size: .9rem;
    line-height: 1.85;
    color: rgba(0,51,102,.72);
    margin: 0 0 .8rem;
  }
  .legal-index {
    background: white;
    border: 2px solid var(--cami-border);
    border-radius: 16px;
    padding: 1.5rem 2rem;
    margin-bottom: 2.5rem;
  }
  .legal-index h2 {
    font-family: var(--font-kranky);
    font-size: 1.1rem;
    color: var(--cami-azul);
    margin-bottom: .8rem;
  }
  .legal-index ol {
    margin: 0;
    padding-left: 1.3rem;
    font-size: .88rem;
    line-height: 2;
    color: rgba(0,51,102,.7);
  }
  .legal-index ol li::marker {
    color: var(--cami-turq);
    font-weight: 700;
  }
  .legal-index a {
    color: rgba(0,51,102,.7);
    text-decoration: none;
    transition: color .2s;
  }
  .legal-index a:hover {
    color: var(--cami-turq);
  }
  html {
    scroll-behavior: smooth;
    scroll-padding-top: 100px;
  }
  .legal-bullet {
    padding-left: 1.2rem;
    font-size: .88rem;
    line-height: 1.8;
    color: rgba(0,51,102,.7);
    list-style: none;
    margin: .6rem 0 1rem;
  }
  .legal-bullet li {
    position: relative;
    padding-left: .8rem;
    margin-bottom: .3rem;
  }
  .legal-bullet li::before {
    content: '';
    position: absolute;
    left: 0;
    top: .55em;
    width: 6px;
    height: 6px;
    border-radius: 50%;
    background: var(--cami-turq);
  }
  .legal-signature {
    text-align: center;
    margin-top: 3rem;
    padding-top: 2rem;
    border-top: 2px solid var(--cami-border);
  }
  .legal-signature .sig-name {
    font-family: var(--font-kranky);
    font-size: 1.1rem;
    color: var(--cami-azul);
    margin: .6rem 0 .2rem;
  }
  .legal-signature .sig-doc {
    font-size: .82rem;
    color: rgba(0,51,102,.55);
  }
  .legal-signature .sig-role {
    font-size: .85rem;
    color: rgba(0,51,102,.6);
    margin: .3rem 0 0;
  }
  .legal-signature .sig-location {
    font-size: .8rem;
    color: rgba(0,51,102,.45);
    margin-top: .3rem;
  }
  @media (max-width:767px) {
    .legal-wrapper { padding: 2rem 1rem 5rem; }
    .legal-info-card { padding: 1.2rem 1.3rem; }
    .legal-index { padding: 1.2rem 1.3rem; }
    .legal-section h2 { font-size: 1.1rem; }
    .legal-section p { font-size: .85rem; }
  }
  @media (max-width:575px) {
    .legal-wrapper { padding: 1.5rem .8rem 4.5rem; }
  }
</style>

<div class="legal-wrapper">

  <div class="legal-hero">
    <h1>Política de Calidad, Garantías y Cumplimiento</h1>
    <p class="legal-subtitle">Poder Down por María Camila Torres González</p>
    <span class="legal-date">Última actualización: junio de 2026</span>
  </div>

  <div class="legal-info-card">
    <div class="info-row"><strong>Titular / Responsable:</strong> María Camila González Torres</div>
    <div class="info-row"><strong>Identificación:</strong> 1.193.577.967</div>
    <div class="info-row"><strong>Sitio Web:</strong> poderdown.com</div>
    <div class="info-row"><strong>Contacto:</strong> info@poderdown.com — 57 313 7468039</div>
    <div class="info-row"><strong>Domicilio:</strong> Envigado, Colombia</div>
  </div>

  <div class="legal-index">
    <h2>Índice de Contenido</h2>
    <ol>
      <li><a href="#sec-1">Compromiso de Calidad</a></li>
      <li><a href="#sec-2">Régimen de Garantía de Bienes Físicos</a></li>
      <li><a href="#sec-3">Procedimiento para la Efectividad de la Garantía</a></li>
      <li><a href="#sec-4">Calidad y Cumplimiento de Servicios de Formación</a></li>
    </ol>
  </div>

  <div class="legal-section">
    <h2 id="sec-1">1. Compromiso de Calidad</h2>
    <p>Poder Down asume un compromiso de idoneidad y calidad respecto de cada uno de los artículos y servicios ofrecidos en su plataforma web, asegurando que se correspondan fielmente con las características técnicas e iconográficas descritas en el portal.</p>
  </div>

  <div class="legal-section">
    <h2 id="sec-2">2. Régimen de Garantía de Bienes Físicos</h2>
    <p>La garantía legal cubre las fallas de calidad, idoneidad y seguridad del producto, así como los defectos de fabricación o las averías estructurales originadas durante el transporte logístico previo a la entrega. La garantía no aplicará en casos de fuerza mayor, caso fortuito, o por el uso indebido del producto por parte del consumidor.</p>
  </div>

  <div class="legal-section">
    <h2 id="sec-3">3. Procedimiento para la Efectividad de la Garantía</h2>
    <ul class="legal-bullet">
      <li><strong>Término de Notificación:</strong> El cliente dispondrá de un término de tres (3) días hábiles posteriores a la entrega para reportar cualquier anomalía al correo institucional: <strong>info@poderdown.com</strong>, adjuntando la evidencia fotográfica o audiovisual correspondiente.</li>
      <li><strong>Alternativas de Reparación del Consumidor:</strong> Una vez validada la deficiencia técnica por parte de Poder Down, y según las disposiciones de la Ley 1480 de 2011, el cliente podrá optar por:
        <ol style="margin-top:.4rem;padding-left:1.2rem;">
          <li>El reemplazo del artículo por uno idéntico o sustituto de iguales características, sin que ello genere costos de envío para el comprador.</li>
          <li>La rescisión de la compra con la consecuente devolución total de las sumas de dinero pagadas por el producto afectado.</li>
        </ol>
      </li>
    </ul>
  </div>

  <div class="legal-section">
    <h2 id="sec-4">4. Calidad y Cumplimiento de Servicios de Formación</h2>
    <p>Las charlas, talleres y conferencias serán estructurados bajo criterios profesionales rigurosos, garantizando la ejecución de la propuesta de valor y la intervención directa de María Camila González Torres.</p>
    <ul class="legal-bullet">
      <li><strong>Modificaciones en la Agenda:</strong> Si por hechos constitutivos de caso fortuito, fuerza mayor o condiciones de salud de la conferencista, un evento debiera ser aplazado, Poder Down notificará inmediatamente a los usuarios contratantes o inscritos. La fijación de la nueva fecha se determinará de común acuerdo entre las partes.</li>
      <li><strong>Resolución por Cancelación Exclusiva:</strong> En el evento en que una charla o taller con costo económico asociado sea cancelado de manera definitiva por la marca, sin posibilidad de reprogramación consensuada, se reembolsará el 100% de los dineros percibidos en un plazo máximo de quince (15) días hábiles.</li>
    </ul>
  </div>

  <div class="legal-signature">
    <h3 style="font-family:var(--font-kranky);font-size:1.05rem;color:var(--cami-azul);margin-bottom:1.2rem;">Compromiso de Idoneidad y Garantía</h3>
    <p style="font-size:.88rem;color:rgba(0,51,102,.6);max-width:560px;margin:0 auto 1.5rem;">En respaldo al derecho de los consumidores y asegurando la calidad de los bienes y servicios ofrecidos, la presente política de garantías es suscrita y adoptada por</p>
    <p class="sig-name">María Camila González Torres</p>
    <p class="sig-doc">C.C. 1.193.577.967</p>
    <p class="sig-role">Responsable de Poder Down</p>
    <p class="sig-location">Envigado, Colombia</p>
    <p style="font-size:.78rem;color:rgba(0,51,102,.4);margin-top:1rem;">Última Actualización: junio de 2026. Publicado en poderdown.com</p>
  </div>

</div>

<?php require_once __DIR__ . '/Footer.php'; ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

