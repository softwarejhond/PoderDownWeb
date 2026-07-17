
**GUÍA DE IMPLEMENTACIÓN SEO**

poderdown.com

Documento de trabajo para el equipo de desarrollo y contenido

Incluye: definición de metadatos con campos para diligenciar, requisitos de SEO técnico para implementación, estrategia de contenidos y checklist de entrega.


# **Cómo usar esta guía**
Este documento reúne todo lo necesario para dejar el sitio correctamente optimizado para buscadores. Está dividido en partes según el responsable de cada tarea:

- **Parte 1 — Metadatos que se deben redactar:** explica qué es cada metadato que requiere una decisión de contenido (Title, meta description, H1, palabras clave, textos ALT) y contiene tablas para diligenciar los valores definitivos de cada página. Estas tablas se llenan primero y luego el equipo de desarrollo implementa exactamente lo que quede escrito allí.
- **Parte 2 — SEO técnico:** todo lo que el equipo de desarrollo implementa directamente sin necesidad de decisiones de contenido: canonicals, URLs amigables, Open Graph, sitemap, robots, rendimiento, datos estructurados, etc.
- **Parte 3 — Contenidos y estrategia:** lineamientos para el equipo de contenido y marketing.
- **Parte 4 — Monitoreo:** métricas y proceso de mejora continua.
- **Parte 5 — Checklist de entrega:** lista final de verificación antes de dar por terminada la implementación.

|**Regla de oro:** ningún cambio se considera terminado hasta verificarlo con las herramientas indicadas (Search Console, PageSpeed, validadores). Documentar cada cambio con su fecha.|
| :- |


# **PARTE 1 — Metadatos que se deben redactar**
Los metadatos son información que no siempre se ve en la página, pero que Google, WhatsApp, Instagram y Facebook leen para entender de qué trata cada URL y cómo mostrarla. Son la “portada” del sitio en los resultados de búsqueda. Esta parte cubre únicamente los elementos que requieren una decisión de redacción (Title, meta description, H1 y palabras clave); su implementación en el código, junto con el resto de las etiquetas técnicas (canonical, Open Graph, robots, ALT), está detallada en la Parte 2.
## **1.1 Title (título SEO)**
Es el título azul que aparece en los resultados de Google y en la pestaña del navegador. Es el factor on-page más importante.
### **Condiciones**
- Longitud entre 50 y 60 caracteres (si es más largo, Google lo corta con “...”).
- Palabra clave principal al inicio o lo más cerca posible del inicio.
- Único para cada página: nunca dos páginas con el mismo Title.
- Formato recomendado: Palabra clave | Beneficio | Marca. Ejemplo: “Tienda de arte original | Envíos a toda Colombia | Poder Down”.
- El Title y el H1 son cosas diferentes y no deben ser idénticos.
- Sin mayúsculas sostenidas ni repetición de palabras clave.
## **1.2 Meta description**
Es el texto gris de dos líneas debajo del título en Google. No posiciona directamente, pero decide si la persona hace clic o no.
### **Condiciones**
- Longitud entre 150 y 160 caracteres.
- Única para cada página.
- Incluir la palabra clave principal de forma natural (Google la resalta en negrita).
- Describir claramente el contenido de la página.
- Terminar con un llamado a la acción: “Descubre”, “Conoce”, “Compra”, “Visita”.

**Ejemplo (ficha de producto):** *“Compra el mug Colores del Alma con arte original de Cami. Cerámica de alta calidad y envíos a toda Colombia. Llévalo a tu escritorio hoy.”*
## **1.3 H1 y jerarquía de encabezados**
El H1 es el título visible más grande de la página. Técnicamente no es un metadato, pero Google lo trata con importancia casi igual al Title.
### **Condiciones**
- Un solo H1 por página (ni cero, ni dos), con la palabra clave principal.
- El H1 debe ser diferente al Title: puede ser más creativo o emocional.
- Estructura lógica H1 → H2 → H3, sin saltar niveles por estética.
- Los H2 son subtemas del H1; usar palabras clave secundarias en H2 y H3.


## **1.4 Tablas de metadatos por página (DILIGENCIAR)  Aplicar cambios por parte de desarrollo** 
##
Estas tablas son el entregable central de esta parte. Se llena una tabla por cada página del sitio y el equipo de desarrollo implementa exactamente los valores aquí escritos. Para productos y artículos nuevos se usa la plantilla correspondiente cada vez.
### **Página: Inicio (index.php)**

|**Campo**|**Condición / recordatorio**|**Valor elegido (llenar aquí)**|
| :- | :- | :- |
|**Title (título SEO)**|50–60 caracteres · keyword al inicio · termina en | Poder Down|Poder Down — El poder de creer e incluir|
|**Meta description**|150–160 caracteres · incluye keyword y llamado a la acción|<p>Descubre obras únicas de Cami y lleva el mensaje de Poder Down a tu espacio. Charlas, arte y productos para una inclusión real.</p><p></p><p>Descubre  y explora el mundo de Cami y lleva el mensaje de Poder Down a tu espacio. Charlas, arte y productos para una inclusión real.</p><p></p>|
||||
||||
||||
||||
||||

### **Página: Tienda / Productos (productos.php)**

|**Campo**|**Condición / recordatorio**|**Valor elegido (llenar aquí)**|
| :- | :- | :- |
|**Title (título SEO)**|50–60 caracteres · keyword al inicio · termina en | Poder Down|Tienda Creativa de Cami | Poder Down |
|**Meta description**|150–160 caracteres · incluye keyword y llamado a la acción|Descubre la Tienda Creativa de Cami: Encuentras arte original que enamora a primera vista, piezas únicas que no verás en ningún otro lado. ¡Entra ya!|
||||
||||
||||
||||
### **Plantilla: Ficha de producto individual (Pendiente por definir)** 

|**Campo**|**Condición / recordatorio**|**Valor elegido (llenar aquí)**|
| :- | :- | :- |
|**Palabra clave principal**|El nombre del producto + categoría||
|**Palabras clave secundarias**|2 a 4 términos relacionados||
|**Title (título SEO)**|50–60 caracteres · keyword al inicio · termina en | Poder Down||
|**Meta description**|150–160 caracteres · incluye keyword y llamado a la acción||
|**H1**|Uno solo · distinto al Title · contiene la keyword||
|**URL (slug)**|Corta, minúsculas, guiones, sin tildes, máx. 75 caracteres||
||||
||||

### **Página: Galería**

|**Campo**|**Condición / recordatorio**|**Valor elegido (llenar aquí)**|
| :- | :- | :- |
|**Title (título SEO)**|50–60 caracteres · keyword al inicio · termina en | Poder Down|Galería de Cami: un recorrido por su arte | Poder Down|
|**Meta description**|150–160 caracteres · incluye keyword y llamado a la acción|Recorre la galería de Cami: sus obras más queridas y lo nuevo que trae su pincel. Entra y déjate sorprender.|
||||
||||
||||
||||
###
###
### **Página: Blog (listado, blog.php)**

|**Campo**|**Condición / recordatorio**|**Valor elegido (llenar aquí)**|
| :- | :- | :- |
|**Title (título SEO)**|50–60 caracteres · keyword al inicio · termina en | Poder Down|El diario de Cami: historias, tips y novedades | Poder Down|
|**Meta description**|150–160 caracteres · incluye keyword y llamado a la acción|<p>Cami abre su diario: cuenta su día a día entre pinceles, charlas, turismo y cocina, con tips.  Descúbrelo.</p><p></p>|
||||
||||
||||
||||
### **Plantilla: Artículo de blog ( se definen al crear cada blog)** 

|**Campo**|**Condición / recordatorio**|**Valor elegido (llenar aquí)**|
| :- | :- | :- |
|**Palabra clave principal**|1 keyword principal por artículo (evitar repetir entre artículos)||
|**Palabras clave secundarias**|2 a 4 términos relacionados||
|**Title (título SEO)**|50–60 caracteres · keyword al inicio · termina en | Poder Down||
|**Meta description**|150–160 caracteres · incluye keyword y llamado a la acción||
|**H1**|Uno solo · distinto al Title · contiene la keyword||
|**URL (slug)**|Corta, minúsculas, guiones, sin tildes, máx. 75 caracteres||
||||
||||
||||



# **PARTE 2 — SEO técnico (equipo de desarrollo)**
Requisitos de implementación a nivel de servidor, código y configuración. Todos los puntos son verificables con las herramientas indicadas.
## **2.1 Dominio, HTTPS y redirecciones**
### **Redireccionamientos necesarios**
- Redirecciones 301 de HTTP a HTTPS (todas las versiones).
- Elegir una versión canónica del dominio (www o no-www) y redirigir la otra con 301. Solo debe existir una versión accesible.
### **Certificado SSL**
- Certificado SSL válido y actualizado, con el certificado intermedio correctamente instalado.
- Todos los recursos (imágenes, scripts, CSS) deben cargar por HTTPS (sin contenido mixto).
- Verificación: SSL Labs, GTmetrix, Why No Padlock.
## **2.2 Arquitectura del sitio y URLs amigables**
### **URLs amigables (slugs)**
- Estructura de URLs descriptiva y clara, con la palabra clave. Máximo 75 caracteres.
- Todo en minúsculas, palabras separadas con guiones (-), nunca guion bajo (\_) ni espacios.
- Sin tildes ni eñes: “galeria-de-arte”, no “galería-de-arte”.
- Evitar parámetros innecesarios (?id=123). Librería recomendada para generarlas: Slugify.
- Aplicar a productos y blog. Ejemplo: poderdown.com/blog/como-cuidar-una-pintura-en-acrilico ✅ vs poderdown.com/blog.php?slug=articulo1 ❌.
- Nunca cambiar la URL de una página ya publicada; si es indispensable, aplicar redirección 301 de la URL vieja a la nueva.
### **Estructura de navegación**
- Profundidad de navegación: máximo 3–4 clics desde la home a cualquier página importante; nunca superar 6 niveles.
- Estructura lógica: Home → Categoría → Subcategoría → Producto.
- **Migas de pan (breadcrumbs):** implementar en tienda y blog, con datos estructurados BreadcrumbList. Mejoran la navegación y cómo Google muestra las URLs.
## **2.3 Etiqueta canonical**
Indica a Google cuál es la versión oficial de una página cuando el mismo contenido puede abrirse desde varias URLs (parámetros como ?slug= o ?utm\_source=).

- Cada página debe tener <link rel="canonical" href="URL oficial"> apuntando a sí misma con su URL limpia.
- Usar siempre la versión https y sin parámetros de seguimiento.
- La canonical previene penalizaciones por contenido duplicado.
## **2.4 Open Graph y Twitter Cards (compartir en redes)**
Controlan la tarjeta (imagen + título + texto) que aparece al compartir un enlace del sitio en WhatsApp, Instagram, Facebook o LinkedIn. Para este sitio es clave porque gran parte del tráfico llega por redes y enlaces compartidos. Los textos (og:title, og:description) salen de las tablas diligenciadas en la Parte 1; la implementación de las etiquetas es tarea de desarrollo.

|**Hallazgo actual:** la página de inicio ya tiene og:title, og:description y og:type, pero falta og:image y og:url. Por eso los enlaces compartidos no muestran imagen. Prioridad alta.|
| :- |
### **Etiquetas requeridas en todas las páginas**

|**Etiqueta**|**Función**|**Condición**|
| :- | :- | :- |
|**og:title**|Título de la tarjeta|Hasta 60 caracteres. Puede ser igual al Title.|
|**og:description**|Texto de la tarjeta|Hasta 110 caracteres visibles.|
|**og:image**|Imagen de la tarjeta|1200 × 630 px, JPG o PNG, máx. 1 MB, URL absoluta (https://...).|
|**og:url**|URL oficial de la página|URL limpia y completa, igual a la canonical.|
|**og:type**|Tipo de contenido|website (páginas) · article (blog) · product (fichas de producto).|
|**twitter:card**|Formato en X/Twitter|Valor: summary\_large\_image.|

- **Imagen OG por defecto:** implementar una imagen de marca (logo + mensaje principal) en 1200 × 630 px que se use automáticamente cuando una página no tenga imagen propia.
- **Imágenes OG dinámicas:** cada producto y cada artículo del blog debe usar su propia imagen destacada como og:image, generada automáticamente por el sistema.
- **Verificación:** probar con Meta Sharing Debugger (developers.facebook.com/tools/debug); también sirve para refrescar la caché si se cambia la imagen.




## **2.5 Sitemap.xml y robots.txt**
### **Sitemap.xml**
### Archivo que lista todas las URLs importantes del sitio para entregárselas directamente a los buscadores, acelerando la indexación del contenido nuevo. Se envía a Google Search Console y debe actualizarse automáticamente al publicar.
- Generar sitemap dinámico que se actualice automáticamente al publicar productos o artículos.
- Incluir solo páginas indexables y relevantes (excluir login, registro, carrito, etc.).
- Añadir fecha de última modificación (lastmod).
### **Robots.txt**
### Archivo de texto en la raíz del dominio que le indica a los buscadores qué partes del sitio pueden rastrear y cuáles no, y dónde encontrar el sitemap. Es lo primero que Google consulta al visitar el sitio."
- Permitir el rastreo de todo el contenido importante.
- Bloquear áreas administrativas, de prueba y carpetas privadas.
- Incluir la referencia al sitemap: Sitemap: https://poderdown.com/sitemap.xml.
- Verificar que NO bloquee recursos críticos (CSS y JS necesarios para renderizar).
## **2.6 Datos estructurados (Schema.org)**
Implementar en formato JSON-LD. Ayudan a Google a entender el contenido y habilitan resultados enriquecidos (estrellas, precios, FAQs). Tipos requeridos para este sitio:

|**Tipo de schema**|**Dónde**|**Datos mínimos**|
| :- | :- | :- |
|**Organization / Person**|Todo el sitio (home)|Nombre, logo, URL, redes sociales (sameAs), datos de contacto.|
|**WebSite**|Home|Nombre del sitio y URL.|
|**Product**|Cada ficha de producto|Nombre, imagen, descripción, precio, moneda (COP), disponibilidad.|
|**Article / BlogPosting**|Cada artículo del blog|Título, imagen, autor, fecha de publicación y de modificación.|
|**BreadcrumbList**|Tienda y blog|Ruta de navegación de la página.|
|**FAQPage**|Sección de preguntas frecuentes|Cada pregunta con su respuesta.|

- Validar con Google Rich Results Test y Schema Markup Validator.
- Al actualizar un artículo, actualizar también dateModified en el JSON-LD.
## **2.7 Optimización de imágenes y video**
### **Imágenes**
- Formato obligatorio: WebP.
- Peso máximo recomendado: 100–150 KB por imagen.
- Dimensiones exactas según el espacio del diseño (evitar redimensionamiento por navegador) y atributos width/height declarados para prevenir saltos de layout.
- Imágenes responsive con srcset.
### **Texto alternativo (atributo ALT)**
Google no “ve” las imágenes: las lee por su ALT. Además, es fundamental para accesibilidad, coherente con el panel WCAG que el sitio ya implementa. Toda imagen que se suba al sitio (productos, galería, blog) debe cumplir:

- ALT que describa lo que se ve, en máximo 125 caracteres. Ejemplo: alt="Pintura Colores del Alma, acrílico sobre lienzo" ✅ vs alt="imagen1" ❌.
- Incluir la palabra clave solo cuando sea natural.
- Imágenes puramente decorativas: alt vacío (alt="").
- Nombre de archivo descriptivo: “pintura-colores-del-alma.webp”, no “IMG\_2034.jpg”.
- El administrador de contenido (CMS/tienda) debe tener un campo obligatorio de ALT al subir imágenes.
### **Videos**
- Alojar en plataformas externas (YouTube, Vimeo) para reducir carga del servidor.
- Si son propios: MP4 con códec H.264 y lazy loading.
- Añadir transcripciones y subtítulos (accesibilidad y SEO).
## **2.8 Rendimiento y Core Web Vitals**
### **Métricas objetivo (Core Web Vitals de Google)**

|**Métrica**|**Qué mide**|**Objetivo**|
| :- | :- | :- |
|**LCP (Largest Contentful Paint)**|Carga del elemento principal|Menor a 2.5 segundos|
|**INP (Interaction to Next Paint)**|Respuesta a interacciones (reemplazó a FID desde 2024)|Menor a 200 milisegundos|
|**CLS (Cumulative Layout Shift)**|Estabilidad visual (saltos de layout)|Menor a 0.1|


### **Optimización de carga**
- Tiempo de carga objetivo: menor a 3 segundos (TTFB ideal bajo 500 ms).
- Caché del navegador (browser caching) y caché del servidor.
- Minificar CSS, JavaScript y HTML; combinar archivos cuando sea posible.
- CDN para recursos estáticos.
- Precargar (preload) las fuentes tipográficas críticas y usar font-display: swap.

Este es un informe de como esta en el momento la carga del sitio realizado con pagespeed herramienta directa de Google.

https://pagespeed.web.dev/analysis/https-poderdown-com/d2h17z8jbn?form\_factor=mobile
### **Renderizado del contenido (SSR)**
- El contenido principal debe cargar en el HTML sin depender de JavaScript. Fundamental para la indexación.
- Prueba: desactivar JavaScript en el navegador y verificar que el contenido (textos, productos, artículos) siga visible. Hoy el sitio muestra “Esta página requiere JavaScript”: revisar que el contenido clave exista igualmente en el HTML.
### **Herramientas de medición**
- Google PageSpeed Insights · Lighthouse (Chrome DevTools) · GTmetrix · WebPageTest · Pingdom.
## **2.9 Responsive y experiencia móvil**
- Verificar funcionamiento en distintos dispositivos, tamaños de pantalla y navegadores (iOS y Android).
- Botones y elementos táctiles: mínimo 44 × 44 píxeles.
- Texto legible sin zoom: mínimo 16 px.
- Navegación intuitiva; procesos de conversión de máximo 3 pasos; formularios cortos con validación clara.
- Eliminar intersticiales intrusivos o pop-ups agresivos (Google los penaliza en móvil).
- Herramientas: prueba de usabilidad móvil de Lighthouse, BrowserStack.
## **2.10 Etiquetado semántico y enlaces**
- Enlaces: siempre etiqueta <a> con href válido (no divs con onclick).
- Texto de enlace descriptivo: “Ver la colección de acuarelas”, no “Click aquí”.
- Usar HTML semántico: <header>, <nav>, <main>, <article>, <footer>.
## **2.11 Página 404 personalizada**
- Diseño amigable y profesional, con menú de navegación.
- Debe devolver código HTTP 404 real (no 200 ni 302). Verificar con las herramientas de red del navegador o httpstatus.io.
- Incluir llamado a la acción hacia la home, la tienda o el contacto.
## **2.12 Meta robots, auditoría y control de indexación**
La etiqueta meta robots indica a Google si debe mostrar una página en los resultados de búsqueda o no.

- Páginas públicas (inicio, productos, galería, blog): index, follow (o sin etiqueta).
- **Páginas con noindex, follow:** login.php, registro.php, carrito, páginas de agradecimiento post-compra, resultados de búsqueda interna, páginas privadas de usuario y versiones para imprimir.
- Verificar páginas indexadas con el comando site:poderdown.com en Google.
- Detectar páginas indexadas no deseadas y contenido duplicado.
## **2.14 Favicon e identidad en buscadores**
- Favicon en múltiples tamaños (48 × 48 mínimo para Google) y apple-touch-icon.
- Archivo site.webmanifest con nombre y colores de la marca.


# **PARTE 3 — Contenidos y estrategia de autoridad**
Lineamientos para el equipo de contenido y marketing. El equipo de desarrollo participa habilitando las funciones necesarias (campos de metadatos editables, fechas visibles, tabla de contenidos, etc.).
## **3.1 Investigación de palabras clave**
- Identificar palabras clave principales y su intención de búsqueda (informacional, navegacional, transaccional).
- Revisar volumen de búsqueda y dificultad; analizar keywords de competidores.
- Asignar UNA keyword principal por página (evitar canibalización: dos páginas compitiendo por lo mismo).
- Documentar en Excel: Página, Keyword principal, Keywords secundarias, Volumen, Dificultad.
- Herramientas: Semrush, Ahrefs, Ubersuggest, Google Keyword Planner.
## **3.2 Optimización on-page del contenido**
- Incluir la keyword principal en: Title, H1, primeras palabras del texto y URL.
- Usar sinónimos y términos relacionados; densidad natural de 1–2%.
- Contenido mínimo recomendado: 800–1000 palabras para páginas importantes; evitar contenido delgado (menos de 300 palabras).
- Incluir multimedia (imágenes, videos, infografías) y formato de fácil lectura: párrafos cortos, listas, negritas.
- Auditar periódicamente páginas de bajo rendimiento y verificar que respondan a la intención de búsqueda.
## **3.3 Enlazado interno**
- Conectar contenido relacionado temáticamente: mínimo 3–5 enlaces internos por página de contenido.
- Anchor text descriptivo y variado (el texto del enlace debe decir a dónde lleva).
- Priorizar enlaces hacia las páginas de conversión (tienda, contacto) y distribuir autoridad desde la home.
- Los enlaces internos siempre deben ser normales (dofollow); el atributo nofollow se reserva para enlaces externos de afiliados o sitios a los que no se quiere pasar autoridad.
- Verificar periódicamente que no existan enlaces rotos.



## **3.4 Link building (enlaces externos hacia el sitio)**
### **Tácticas recomendadas**
- Artículos invitados en blogs relevantes del sector.
- Menciones en medios digitales y alianzas con organizaciones complementarias.
- Crear contenido que atraiga enlaces naturales (guías, infografías, estudios).
- Solo directorios relevantes y de autoridad.
### **Criterios de calidad**
- Autoridad del dominio alta, relevancia temática, tráfico orgánico real, enlaces dofollow principalmente y diversidad de dominios (mejor 100 dominios distintos que 100 enlaces del mismo).
### **Qué evitar**
- Compra masiva de enlaces, granjas de enlaces, PBNs de baja calidad, intercambios excesivos y directorios spam.
## **3.5 Blog: planificación y optimización**
### **Calendario editorial**
- Mínimo 2 publicaciones mensuales (idealmente 4–8).
- Variedad de formatos: guías, tutoriales, casos, listas, comparativas; responder preguntas frecuentes de los clientes.
- Alineación con la estacionalidad del negocio (fechas de regalos, ferias, temporadas).
- Priorizar contenido por impacto potencial: reforzar keywords que ya tienen tracción en el sitio.
### **Elementos de cada artículo**
- Introducción que enganche (los primeros 100 caracteres son críticos).
- Estructura clara con H2 y H3; párrafos de 3–4 líneas máximo.
- Conclusión con resumen y llamado a la acción.
- Autor con biografía visible y fecha de publicación visible.
- Imagen destacada optimizada con ALT; tabla de contenidos en artículos de más de 1500 palabras.
- URL corta con la keyword: poderdown.com/blog/palabra-clave.
- CTAs (llamados a la acción) contextuales a lo largo del contenido y ofertas relacionadas con el tema.
- Evitar contenido 100% generado por IA sin revisión humana; aportar experiencia y perspectiva propia.

### **Mantenimiento del contenido**
- Actualizar posts antiguos con información nueva y nota visible de “Actualizado en [fecha]”.
- Actualizar dateModified en los datos estructurados al editar.
- Replicar el formato de los posts con mejor rendimiento; consolidar o eliminar contenido duplicado o de bajo rendimiento.
## **3.6 Asesorías y auditorías externas**
- Auditorías periódicas (trimestrales o semestrales) con especialistas SEO para revisión técnica profunda e identificación de oportunidades avanzadas.


# **PARTE 4 — Monitoreo y mejora continua**
## **4.1 Configuración de herramientas** 
- **Google Search Console:** verificar la propiedad, enviar el sitemap, monitorear errores de rastreo e indexación.
- **Google Analytics 4 (GA4):** configurar eventos, conversiones (compras, formularios de contacto) y audiencias.
- **Google Tag Manager:** implementar los tags de forma organizada, sin código suelto.
- **Google Business Profile:** perfil completo y verificado (negocio con presencia local en Colombia).
- **Análisis adicional:** Semrush o Ahrefs (keywords y competencia), Microsoft Clarity u Hotjar (mapas de calor), Screaming Frog (auditorías técnicas, gratis hasta 500 URLs).
- Desarrollo apoya insertando en el sitio los códigos de verificación y scripts que el SEO le entregue.
## **4.2 KPIs esenciales**

|**Grupo**|**Métricas**|
| :- | :- |
|**Tráfico**|Sesiones orgánicas, páginas por sesión, tiempo en sitio, tasa de rebote por tipo de página.|
|**Posicionamiento**|Rankings de keywords objetivo, impresiones, CTR promedio, páginas en top 3 / top 10 / top 50.|
|**Autoridad**|Backlinks totales y nuevos, dominios de referencia, Domain Authority / Domain Rating.|
|**Conversión**|Tasa de conversión, conversiones asistidas por orgánico, valor de conversión.|

## **4.3 Rutina de seguimiento**
- Google Search Console: revisión de errores de rastreo (diaria/semanal).
- Semrush o similar: seguimiento de posiciones (semanal/mensual).
- Screaming Frog: auditoría técnica completa (mensual/trimestral).
## **4.4 Proceso de mejora**
- Ciclo: implementar cambios → medir → analizar → ajustar.
- Documentar todos los cambios con fecha; no hacer múltiples cambios simultáneos (imposible aislar causas).
- Esperar mínimo 2–4 semanas para evaluar el impacto de cada cambio.
- Mantenerse actualizado con los cambios de algoritmo: Google Search Central Blog, Search Engine Journal.

|**Recordatorio:** el SEO es un trabajo continuo e iterativo, no una implementación única. Requiere monitoreo constante, ajustes basados en datos y análisis periódico de la competencia.|
| :- |


# **PARTE 5 — Checklist de entrega para desarrollo**
Lista final de verificación. La implementación se considera terminada cuando todos los puntos estén marcados y verificados.
## **Metadatos y etiquetas (según tablas de la Parte 1 y secciones 2.3, 2.4 y 2.12)**

|☐|Title único implementado en cada página según la tabla diligenciada.|
| :- | :- |
|☐|Meta description única implementada en cada página.|
|☐|Un solo H1 por página, distinto al Title.|
|☐|og:title, og:description, og:image (1200 × 630), og:url y og:type en todas las páginas.|
|☐|twitter:card = summary\_large\_image.|
|☐|Canonical apuntando a la URL limpia en todas las páginas.|
|☐|noindex en login, registro, carrito, agradecimiento y búsqueda interna.|
|☐|Enlace compartido probado en WhatsApp y validado en Meta Sharing Debugger.|

## **Técnico**

|☐|Redirecciones 301 HTTP→HTTPS y versión única del dominio (www o no-www).|
| :- | :- |
|☐|SSL válido, sin contenido mixto (verificado en SSL Labs).|
|☐|Sitemap.xml dinámico generado y enviado a Search Console y Bing.|
|☐|Robots.txt configurado con referencia al sitemap y sin bloquear CSS/JS.|
|☐|Datos estructurados JSON-LD implementados (Organization, WebSite, Product, Article, BreadcrumbList, FAQPage) y validados en Rich Results Test.|
|☐|Imágenes en WebP, con lazy loading, srcset, ALT y peso máximo 150 KB.|
|☐|Core Web Vitals en verde: LCP < 2.5 s, INP < 200 ms, CLS < 0.1.|
|☐|Contenido principal visible sin JavaScript (prueba de renderizado).|
|☐|Página 404 personalizada que devuelve código 404 real.|
|☐|URLs amigables con slug en productos y blog; redirecciones 301 si cambió alguna URL.|
|☐|Breadcrumbs visibles en tienda y blog con schema BreadcrumbList.|
|☐|Favicon multi-tamaño y apple-touch-icon.|
|☐|Entorno de pruebas con noindex, robots bloqueado y autenticación.|
|☐|Códigos de verificación y scripts de medición (Search Console, GA4, Tag Manager) insertados según lo que entregue el SEO.|
|☐|Backups automáticos y monitoreo de uptime activos.|

## **Priorización recomendada**

|**Fase**|**Enfoque**|
| :- | :- |
|**Mes 1**|Fundamentos técnicos: SSL, redirecciones, sitemap, robots, velocidad, herramientas de medición.|
|**Mes 2**|Metadatos completos (tablas de la Parte 1), datos estructurados y optimización on-page del contenido existente.|
|**Mes 3**|Estrategia de contenido y blog: calendario editorial y primeros artículos optimizados.|
|**Mes 4+**|Link building, optimizaciones avanzadas, iteración según datos de Search Console.|

*Documento elaborado como parte de la asesoría SEO de poderdown.com. Ante cualquier duda de implementación, contactar al asesor antes de improvisar una solución.*
