<?php
$pageTitle = 'Política de Datos Personales — Poder Down';
$pageDescription = 'Política de Tratamiento de Datos Personales (Habeas Data) de Poder Down por María Camila González Torres.';
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
  .legal-table-wrap {
    overflow-x: auto;
    margin: 1rem 0 1.5rem;
  }
  .legal-table {
    width: 100%;
    border-collapse: collapse;
    font-size: .84rem;
    line-height: 1.7;
    color: rgba(0,51,102,.7);
    background: white;
    border-radius: 12px;
    overflow: hidden;
    border: 2px solid var(--cami-border);
  }
  .legal-table thead th {
    background: var(--cami-azul);
    color: white;
    font-family: var(--font-kranky);
    font-weight: 700;
    font-size: .78rem;
    padding: .75rem 1rem;
    text-align: left;
  }
  .legal-table tbody td {
    padding: .65rem 1rem;
    border-bottom: 1px solid var(--cami-border);
    vertical-align: top;
  }
  .legal-table tbody tr:last-child td {
    border-bottom: none;
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
    .legal-table { font-size: .76rem; }
    .legal-table thead th,
    .legal-table tbody td { padding: .5rem .6rem; }
  }
</style>

<div class="legal-wrapper">

  <div class="legal-hero">
    <h1>Política de Tratamiento de Datos Personales (Habeas Data)</h1>
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
      <li><a href="#sec-1">Marco jurídico y objeto</a></li>
      <li><a href="#sec-2">Definiciones legales</a></li>
      <li><a href="#sec-3">Principios rectores del tratamiento</a></li>
      <li><a href="#sec-4">Categorías de datos objeto de tratamiento</a></li>
      <li><a href="#sec-5">Finalidades específicas del tratamiento</a></li>
      <li><a href="#sec-6">Derechos de los titulares de la información</a></li>
      <li><a href="#sec-7">Deberes del responsable del tratamiento</a></li>
      <li><a href="#sec-8">Canales y procedimientos para el ejercicio del derecho de Habeas Data</a></li>
      <li><a href="#sec-9">Transferencia y transmisión internacional de datos</a></li>
      <li><a href="#sec-10">Seguridad de la información y vigencia</a></li>
    </ol>
  </div>

  <div class="legal-section">
    <h2 id="sec-1">1. Marco Jurídico y Objeto</h2>
    <p>La presente Política de Tratamiento de Datos Personales se dicta en estricto cumplimiento de lo dispuesto en el Artículo 15 de la Constitución Política de Colombia, la Ley 1581 de 2012, el Decreto Reglamentario 1377 de 2013 (hoy incorporado en el Decreto Único Reglamentario 1074 de 2015 del Sector Comercio, Industria y Turismo) y demás normas concordantes.</p>
    <p>El objeto del presente documento es regular la recolección, almacenamiento, uso, circulación y supresión de los datos personales tratados por Poder Down, garantizando de manera efectiva los derechos fundamentales de los titulares de la información.</p>
  </div>

  <div class="legal-section">
    <h2 id="sec-2">2. Definiciones Legales</h2>
    <p>Para efectos de la interpretación de la presente política, de conformidad con la normativa vigente, se establecen las siguientes definiciones:</p>
    <ul class="legal-bullet">
      <li><strong>Autorización:</strong> Consentimiento previo, expreso e informado del Titular para llevar a cabo el Tratamiento de sus datos personales.</li>
      <li><strong>Base de Datos:</strong> Conjunto organizado de datos personales que sea objeto de Tratamiento.</li>
      <li><strong>Dato Personal:</strong> Cualquier información vinculada o que pueda asociarse a una o varias personas naturales determinadas o determinables.</li>
      <li><strong>Encargado del Tratamiento:</strong> Persona natural o jurídica, pública o privada, que por sí misma o en asocio con otros, realice el Tratamiento de datos personales por cuenta del responsable del Tratamiento.</li>
      <li><strong>Responsable del Tratamiento:</strong> Persona natural o jurídica, pública o privada, que por sí misma o en asocio con otros, decida sobre la base de datos y/o el Tratamiento de los datos. Para todos los efectos legales, el responsable es María Camila González Torres.</li>
      <li><strong>Titular:</strong> Persona natural cuyos datos personales sean objeto de Tratamiento (usuarios, clientes, cotizantes).</li>
      <li><strong>Tratamiento:</strong> Cualquier operación o conjunto de operaciones sobre datos personales, tales como la recolección, almacenamiento, uso, circulación o supresión.</li>
    </ul>
  </div>

  <div class="legal-section">
    <h2 id="sec-3">3. Principios Rectores del Tratamiento</h2>
    <p>Poder Down aplicará de manera integral los principios de Legalidad, Finalidad, Libertad, Veracidad o Calidad, Transparencia, Acceso y Circulación Restringida, Seguridad y Confidencialidad, los cuales constituyen el núcleo de las garantías procesales del Habeas Data en Colombia.</p>
  </div>

  <div class="legal-section">
    <h2 id="sec-4">4. Categorías de Datos Objeto de Tratamiento</h2>
    <p>El portal web operará bajo el principio de minimización de datos. La recolección de información se limitará a datos de naturaleza pública y semiprivada, omitiendo de manera activa la solicitud de datos sensibles. Los datos recolectados corresponden a:</p>
    <ul class="legal-bullet">
      <li><strong>Módulo de Comercio Electrónico:</strong> Nombre y apellidos, dirección de correspondencia/envío, abonamiento telefónico y correo electrónico.</li>
      <li><strong>Módulo de Cotización de Servicios:</strong> Dirección de correo electrónico y número de contacto telefónico.</li>
      <li><strong>Módulo de Interacción en Blog:</strong> Nombre o seudónimo del usuario, dirección de correo electrónico y dirección IP de registro (capturada automáticamente por el servidor).</li>
    </ul>
  </div>

  <div class="legal-section">
    <h2 id="sec-5">5. Finalidades Específicas del Tratamiento</h2>
    <p>El tratamiento de los datos personales por parte de Poder Down se adscribirá taxativamente a las siguientes finalidades:</p>
    <div class="legal-table-wrap">
      <table class="legal-table">
        <thead>
          <tr>
            <th>Módulo de Captura</th>
            <th>Datos Recolectados</th>
            <th>Finalidad Legal y Comercial</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>Tienda Online</td>
            <td>Nombre, Dirección, Teléfono, Correo electrónico</td>
            <td>Procesamiento de transacciones comerciales, gestión logística de despachos a domicilio, emisión de soportes de venta y atención de requerimientos de postventa.</td>
          </tr>
          <tr>
            <td>Cotizaciones</td>
            <td>Correo electrónico, Teléfono</td>
            <td>Gestión precontractual, remisión de propuestas económicas y contacto comercial directo para charlas y talleres.</td>
          </tr>
          <tr>
            <td>Blog de Opinión</td>
            <td>Nombre/Alias, Correo electrónico, IP</td>
            <td>Control de seguridad informática (mitigación de spam), moderación de comentarios y gestión de la comunidad digital.</td>
          </tr>
        </tbody>
      </table>
    </div>
    <p><strong>Parágrafo:</strong> Los datos de contacto de correo electrónico podrán ser indexados en listas de distribución informativa sobre la marca, otorgando siempre al Titular la facultad técnica de revocar dicha suscripción de forma inmediata en cada comunicación.</p>
  </div>

  <div class="legal-section">
    <h2 id="sec-6">6. Derechos de los Titulares de la Información</h2>
    <p>De conformidad con el Artículo 8 de la Ley 1581 de 2012, el Titular de los datos personales posee los siguientes derechos irrenunciables:</p>
    <ul class="legal-bullet">
      <li>Conocer, actualizar y rectificar sus datos personales frente a los responsables del tratamiento o encargados del tratamiento.</li>
      <li>Solicitar prueba de la autorización otorgada al responsable del tratamiento.</li>
      <li>Ser informado por el responsable del tratamiento o el encargado del tratamiento, previa solicitud, respecto del uso que le ha dado a sus datos personales.</li>
      <li>Presentar ante la Superintendencia de Industria y Comercio quejas por infracciones a lo dispuesto en la ley.</li>
      <li>Revocar la autorización y/o solicitar la supresión del dato cuando en el tratamiento no se respeten los principios, derechos y garantías constitucionales y legales.</li>
    </ul>
  </div>

  <div class="legal-section">
    <h2 id="sec-7">7. Deberes del Responsable del Tratamiento</h2>
    <p>Poder Down, en calidad de Responsable, se obliga a: garantizar al Titular el pleno y efectivo ejercicio del derecho de Habeas Data; conservar la información bajo las condiciones de seguridad necesarias para impedir su adulteración, pérdida, consulta o uso no autorizado; y realizar oportunamente la actualización, rectificación o supresión de los datos en los términos de la ley.</p>
  </div>

  <div class="legal-section">
    <h2 id="sec-8">8. Canales y Procedimientos para el Ejercicio del Derecho de Habeas Data</h2>
    <p>Para la atención de consultas, peticiones y reclamos relacionados con datos personales, se dispone del canal institucional: <strong>info@poderdown.com</strong></p>
    <ul class="legal-bullet">
      <li><strong>Procedimiento de consulta:</strong> Las solicitudes dirigidas a conocer el estado de los datos del Titular serán resueltas en un término máximo de diez (10) días hábiles. Cuando no fuere posible atender la consulta dentro de dicho término, se informará al interesado y se prorrogará hasta por cinco (5) días hábiles adicionales.</li>
      <li><strong>Procedimiento de reclamo (Actualización, Rectificación o Supresión):</strong> Los reclamos se tramitarán en un término máximo de quince (15) días hábiles. Si el reclamo resulta incompleto, se requerirá al interesado dentro de los cinco (5) días siguientes a la recepción para que subsane las fallas.</li>
    </ul>
  </div>

  <div class="legal-section">
    <h2 id="sec-9">9. Transferencia y Transmisión Internacional de Datos</h2>
    <p>Poder Down no realizará la transferencia comercial de sus bases de datos a terceros. No obstante, para el correcto funcionamiento del ecosistema digital y la ejecución de las transacciones, se ejecutarán transmisiones de datos a los Encargados del Tratamiento (proveedores tecnológicos de servicios de procesamiento de pagos, pasarelas de pago aliadas y operadores logísticos de transporte terrestre como Servientrega u homólogos), quienes se adhieren a las directrices de seguridad de la presente política y a la normativa nacional vigente.</p>
  </div>

  <div class="legal-section">
    <h2 id="sec-10">10. Seguridad de la Información y Vigencia</h2>
    <p>El portal web implementará las medidas técnicas, humanas y administrativas estándar para salvaguardar los registros. La Base de Datos asociada a este sitio web mantendrá su vigencia de forma indefinida, en consonancia con el desarrollo del objeto comercial de la marca y hasta que medie solicitud expresa de supresión por parte del Titular.</p>
  </div>

  <div class="legal-signature">
    <h3 style="font-family:var(--font-kranky);font-size:1.05rem;color:var(--cami-azul);margin-bottom:1.2rem;">Conformidad y Adopción</h3>
    <p style="font-size:.88rem;color:rgba(0,51,102,.6);max-width:560px;margin:0 auto 1.5rem;">En señal de transparencia y estricto cumplimiento de la Ley 1581 de 2012, la presente Política de Tratamiento de Datos Personales es adoptada y respaldada por el Responsable del Tratamiento:</p>
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
