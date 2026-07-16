# Diseño: SEO on-page sin backend — poderdown.com

Fecha: 2026-07-16
Fuente de requisitos: `seo_guia.md` (Partes 1 y 2). Alcance aprobado por el usuario: todo lo aplicable sin tocar imágenes ni lógica backend/PHP.

## Decisiones

- Dominio canónico: `https://poderdown.com` (sin www).
- og:image por defecto: `img/logos/logo_pd_horizontal.png` (se reemplazará cuando diseño entregue la imagen 1200×630 definitiva).
- Sin minificación de CSS/JS propios (fuera de alcance).

## 1. Infraestructura de metas (`components/header.php` y `components/header_simple.php`)

- Constante base `https://poderdown.com` para URLs absolutas.
- Variables por página con defaults: `$canonicalUrl`, `$ogType` (website), `$ogImage`, `$metaRobots`.
- Etiquetas nuevas: canonical, og:url, og:image, og:type dinámico, twitter:card = summary_large_image, meta robots condicional.
- URLs canónicas limpias sin `.php` (el `.htaccess` ya reescribe).

## 2. Metadatos por página (tablas Parte 1)

- `productos.php`: "Tienda Creativa de Cami | Poder Down" + description de la tabla.
- `galeria.php`: "Galería de Cami: un recorrido por su arte | Poder Down" + description.
- `blog.php` (listado): "El diario de Cami: historias, tips y novedades | Poder Down" + description.
- `index.php`: valores de la tabla ya presentes; verificar.
- `noindex, follow` en `login.php`, `registro.php`, `checkout.php`, `perfil.php`.

## 3. Archivos estáticos nuevos

- `robots.txt`: permite contenido público; bloquea `controller/`, `logs/`, `node_modules/`, `components/`; referencia al sitemap.
- `sitemap.xml` estático: `/`, `/productos`, `/galeria`, `/blog`, políticas.
- `site.webmanifest`: nombre y colores de marca, icono `pd_icono.png`.
- `404.php` personalizada con nav y CTA, devuelve HTTP 404 real; `ErrorDocument 404` en `.htaccess`.

## 4. .htaccess

- 301 HTTP→HTTPS y www→no-www (solo en producción; condicionado para no romper localhost).

## 5. JSON-LD estático

- `Organization` + `WebSite` en la home.

## 6. HTML semántico y enlaces

- Nav envuelto en `<header>`; contenido principal en `<main>`.
- Tarjetas de producto: `div onclick` → `<a href>` en templates JS de `index.php` y `productos.php`.

## Fuera de alcance

Imágenes (WebP, ALT, srcset, OG definitiva), slugs, sitemap dinámico, OG dinámico por producto/artículo, SSR, minificación, schema Product/Article dinámico.

## Verificación

- `php -l` en archivos modificados (si PHP disponible).
- Revisión manual del HTML generado.
- Post-deploy: Meta Sharing Debugger, Rich Results Test, httpstatus.io (404), Search Console (sitemap).
