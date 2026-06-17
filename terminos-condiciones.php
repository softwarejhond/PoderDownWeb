<?php
$pageTitle = 'Términos y Condiciones — Poder Down';
$pageDescription = 'Términos y Condiciones de Uso y Contratación Comercial de Poder Down por María Camila González Torres.';
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
    <h1>Términos y Condiciones de Uso y Contratación Comercial</h1>
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
      <li><a href="#sec-1">Disposiciones Generales y Aceptación</a></li>
      <li><a href="#sec-2">Capacidad Legal Operativa</a></li>
      <li><a href="#sec-3">Objeto Comercial, Productos y Servicios</a></li>
      <li><a href="#sec-4">Régimen de Precios y Pasarela de Pagos</a></li>
      <li><a href="#sec-5">Condiciones Logísticas y de Despacho</a></li>
      <li><a href="#sec-6">Derecho de Retracto Legal</a></li>
      <li><a href="#sec-7">Propiedad Intelectual e Industrial</a></li>
      <li><a href="#sec-8">Ley Aplicable y Jurisdicción</a></li>
    </ol>
  </div>

  <div class="legal-section">
    <h2 id="sec-1">1. Disposiciones Generales y Aceptación</h2>
    <p>Los presentes Términos y Condiciones regulan el acceso, navegación y uso del sitio web <strong>poderdown.com</strong>, así como las transacciones comerciales ejecutadas dentro de su tienda virtual. Al interactuar con la plataforma, el usuario adquiere la condición de cliente/visitante y acepta de manera expresa y sin reservas la totalidad de las cláusulas aquí descritas. En caso de inconformidad, el usuario deberá abstenerse de utilizar el portal.</p>
  </div>

  <div class="legal-section">
    <h2 id="sec-2">2. Capacidad Legal Operativa</h2>
    <p>En cumplimiento de la legislación civil y comercial vigente en la República de Colombia, se ratifica que la titularidad, la representación comercial y la totalidad de las obligaciones contractuales derivadas de la actividad de esta plataforma son ejercidas plenamente por María Camila González Torres, identificada con Cédula de Ciudadanía No. 1.193.577.967, quien actúa en calidad de persona natural responsable del establecimiento.</p>
    <p>Asimismo, se establece que todas las adquisiciones, transacciones y contratos celebrados a través de este sitio web presuponen, por parte del comprador o usuario, la plena capacidad legal para obligarse según los términos aquí descritos.</p>
  </div>

  <div class="legal-section">
    <h2 id="sec-3">3. Objeto Comercial, Productos y Servicios</h2>
    <p>Poder Down es una plataforma de comercio electrónico orientada a la distribución de:</p>
    <p><strong>Bienes Muebles Tangibles:</strong> Artículos de vestuario (como camisetas), papelería corporativa (cuadernos, lapiceros) y material de merchandising (tales como portavasos, alcancías, entre otros artículos impresos o comerciales).</p>
    <p><strong>Servicios de Formación:</strong> Contratación de charlas, conferencias y talleres presenciales o virtuales, de carácter oneroso (pago) o gratuito.</p>
    <p><strong>Bienes Personalizados:</strong> Obras de arte y proyectos especiales bajo requerimiento del cliente, regulados por cotización previa y condiciones particulares.</p>
  </div>

  <div class="legal-section">
    <h2 id="sec-4">4. Régimen de Precios y Pasarela de Pagos</h2>
    <p>Los valores económicos exhibidos en el portal web se encuentran tasados en Pesos Colombianos (COP). Dado que el Responsable opera bajo la categoría fiscal de persona natural no responsable de IVA (Régimen Simplificado), los precios publicados representan el valor neto total a sufragar por el consumidor.</p>
    <p>Las transacciones monetarias se procesarán de forma segura a través de la pasarela de pagos integrada en el sitio web. Los medios de pago disponibles serán exclusivamente aquellos que el sistema habilite y muestre de forma efectiva al usuario al momento de finalizar la compra (tales como PSE, tarjetas bancarias u otros medios electrónicos), según la configuración técnica vigente de la plataforma.</p>
  </div>

  <div class="legal-section">
    <h2 id="sec-5">5. Condiciones Logísticas y de Despacho</h2>
    <p><strong>Asignación de Costos:</strong> El valor monetario correspondiente al servicio de transporte y envío no se encuentra integrado en el precio del producto y será asumido de manera exclusiva por el consumidor, liquidándose de forma previa en la pasarela o bajo la modalidad de pago contraentrega en el destino.</p>
    <p><strong>Periodicidad de Despacho:</strong> Con el fin de optimizar la cadena logística, Poder Down programará despachos consolidados en días hábiles específicos de la semana posterior a la validación de la transacción financiera.</p>
    <p><strong>Términos de Entrega:</strong> Los tiempos de entrega final dependerán exclusivamente de las empresas de transporte legalmente constituidas en el país (v.g. Servientrega u homólogas). El término estimado para la entrega en el territorio nacional fluctuará entre tres (3) y ocho (8) días hábiles contados a partir del despacho efectivo de la mercancía.</p>
  </div>

  <div class="legal-section">
    <h2 id="sec-6">6. Derecho de Retracto Legal</h2>
    <p>Conforme al Artículo 47 de la Ley 1480 de 2011 (Estatuto del Consumidor), el comprador dispone de un término de cinco (5) días hábiles contados a partir de la recepción material del bien para ejercer su derecho de retracto.</p>
    <p><strong>Condiciones de Restitución:</strong> El producto objeto de devolución deberá ser remitido en perfectas condiciones estéticas y funcionales, sin indicios de uso, conservando intactos sus empaques y etiquetas originales. Los costos logísticos de transporte inverso serán cubiertos en su totalidad por el consumidor.</p>
    <p><strong>Excepciones al Retracto:</strong> De acuerdo con los numerales del artículo citado, el derecho de retracto no operará sobre la contratación de servicios (charlas o talleres) cuya ejecución material haya iniciado con el consentimiento del usuario, ni sobre bienes claramente personalizados u obras de arte confeccionadas bajo especificaciones técnicas particulares dictadas por el comprador.</p>
  </div>

  <div class="legal-section">
    <h2 id="sec-7">7. Propiedad Intelectual e Industrial</h2>
    <p>La totalidad de los elementos contenidos en el portal web <strong>poderdown.com</strong>, incluyendo de forma enunciativa pero no limitativa: ilustraciones, diseños textiles, marcas, logotipos, obras de arte pictóricas, textos analíticos, material fotográfico y código fuente, constituyen propiedad intelectual exclusiva de María Camila González Torres. Queda estrictamente prohibida cualquier modalidad de reproducción, explotación, distribución o comunicación pública no autorizada expresamente por escrito por la titular.</p>
  </div>

  <div class="legal-section">
    <h2 id="sec-8">8. Ley Aplicable y Jurisdicción</h2>
    <p>Los presentes Términos y Condiciones se interpretarán y ejecutarán de conformidad con las leyes de la República de Colombia. Cualquier controversia derivada del uso del sitio web o de las transacciones comerciales que no pueda ser conciliada directamente entre las partes será sometida a la justicia ordinaria colombiana.</p>
  </div>

  <div class="legal-signature">
    <h3 style="font-family:var(--font-kranky);font-size:1.05rem;color:var(--cami-azul);margin-bottom:1.2rem;">Aceptación y Vigencia Contractual</h3>
    <p style="font-size:.88rem;color:rgba(0,51,102,.6);max-width:560px;margin:0 auto 1.5rem;">Los presentes Términos y Condiciones regulan la relación comercial en el entorno digital de conformidad con la Ley 1480 de 2011, siendo avalados y publicados por la titular de la plataforma</p>
    <p class="sig-name">María Camila González Torres</p>
    <p class="sig-doc">C.C. 1.193.577.967</p>
    <p class="sig-role">Responsable de Poder Down</p>
    <p class="sig-location">Envigado, Colombia</p>
    <p style="font-size:.78rem;color:rgba(0,51,102,.4);margin-top:1rem;">Última Actualización: junio de 2026. Publicado en poderdown.com</p>
  </div>

</div>

<?php require_once __DIR__ . '/footer.php'; ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
