# Día a Día con Cami — Ecommerce + Dashboard
> Manual de Marca 2025 · Bootstrap 5.3.3 · SweetAlert2 · Bootstrap Icons · PHP MVC · MySQL · API REST

---

## 🎨 Manual de Marca aplicado

| Elemento | Valor |
|----------|-------|
| Color fondo | `#ebeae4` Beige |
| Color principal | `#4ed2ad` Turquesa |
| Color secundario | `#e45b63` Coral |
| Color terciario | `#efb810` Amarillo dorado |
| Tipografía complementaria | `#003366` Azul oscuro |
| Tipografía display | **Kranky** (Google Fonts) |
| Tipografía cuerpo | **Playpen Sans** (Google Fonts) |
| Tagline | *"Coloreando mi vida"* |

El archivo `public/css/marca.css` centraliza **todos** los colores, fuentes y componentes.
Cualquier cambio de identidad visual se hace en ese único archivo.

---

## 📁 Estructura del proyecto

```
ecommerce/
├── index.php                              <- Redirige a la landing
├── .htaccess                              <- Configuración Apache
├── README.md                              <- Este archivo
│
├── config/
│   ├── config.php                         <- EDITAR AQUI: credenciales BD y URLs
│   └── Database.php                       <- Singleton PDO MySQL
│
├── database/
│   └── ecommerce.sql                      <- Importar en phpMyAdmin
│
├── app/
│   ├── controllers/
│   │   └── ProductoController.php         <- Lógica MVC intermediaria
│   ├── models/
│   │   └── ProductoModel.php              <- Todas las consultas SQL
│   ├── views/
│   │   ├── dashboard/
│   │   │   └── inventario.php             <- Vista del dashboard
│   │   └── partials/
│   │       └── navbar_dashboard.php       <- Navbar reutilizable
│   └── helpers/
│       └── ApiHelper.php                  <- Respuestas JSON estandarizadas
│
├── api/
│   └── productos.php                      <- Endpoint REST de productos
│
├── dashboard/
│   └── inventario.php                     <- Punto de entrada del dashboard
│
└── public/
    ├── landing.php                        <- Landing page publica
    └── css/
        └── marca.css                      <- Design system de la marca
```

---

## INSTALACION EN MAMP — Paso a paso

### PASO 1: Instalar MAMP

1. Ve a https://www.mamp.info y descarga MAMP gratis.
2. Instalalo normalmente (siguiente, siguiente, instalar).
3. Abre la aplicacion MAMP.
4. Haz clic en el boton START.
5. Verifica que los dos semaforos queden en VERDE (Apache y MySQL encendidos).

---

### PASO 2: Copiar el proyecto

1. Localiza la carpeta htdocs de MAMP:
   - Mac: /Applications/MAMP/htdocs/
   - Windows: C:\MAMP\htdocs\
2. Copia la carpeta ecommerce/ dentro de htdocs/.
3. El resultado debe quedar: htdocs/ecommerce/

---

### PASO 3: Importar la base de datos

1. Abre tu navegador.
2. Entra a phpMyAdmin segun tu sistema:
   - Mac MAMP: http://localhost:8888/phpmyadmin
   - Windows MAMP: http://localhost/phpmyadmin
3. En la barra izquierda haz clic en "Nueva" (para crear base de datos).
   O simplemente usa la pestaña "Importar" en la pantalla principal.
4. Haz clic en la pestana "Importar" (arriba en el menu).
5. Haz clic en "Seleccionar archivo".
6. Navega hasta: ecommerce/database/ecommerce.sql
7. Haz clic en "Continuar" o "Go".
8. Espera el mensaje verde: "Importacion correcta".

Esto crea automaticamente:
- La base de datos llamada "ecommerce"
- La tabla "productos" con 12 productos de prueba
- La tabla "categorias" con 5 categorias
- La tabla "clientes" lista para usar

---

### PASO 4: Configurar las credenciales

Abre el archivo config/config.php con tu editor (VS Code, Sublime, Notepad++).

Busca estas lineas y ajustalas segun tu entorno:

MAMP en Mac (configuracion mas comun):
```
define('DB_HOST',  '127.0.0.1');
define('DB_PORT',  '8889');        <- Puerto MySQL de MAMP en Mac
define('DB_USER',  'root');
define('DB_PASS',  'root');        <- MAMP usa root por defecto
define('BASE_URL', 'http://localhost:8888/ecommerce');
```

MAMP en Windows:
```
define('DB_HOST',  '127.0.0.1');
define('DB_PORT',  '3306');        <- Puerto por defecto en Windows
define('DB_USER',  'root');
define('DB_PASS',  'root');
define('BASE_URL', 'http://localhost/ecommerce');
```

COMO SABER TU PUERTO EN MAMP:
Abre MAMP -> haz clic en "Preferences" -> pestana "Ports".
El numero que aparece en "MySQL Port" es el que debes poner en DB_PORT.
El numero en "Apache Port" es el que va en BASE_URL despues de localhost.

---

### PASO 5: Probar el proyecto

Abre tu navegador y visita estas URLs (ajusta el puerto si es diferente):

| Pagina | URL |
|--------|-----|
| Landing (tienda publica) | http://localhost:8888/ecommerce/ |
| Dashboard inventario | http://localhost:8888/ecommerce/dashboard/inventario.php |
| API de productos | http://localhost:8888/ecommerce/api/productos.php |
| API estadisticas | http://localhost:8888/ecommerce/api/productos.php?stats=1 |
| API busqueda | http://localhost:8888/ecommerce/api/productos.php?busqueda=lamp |

Si ves los productos cargando en la landing y el dashboard: todo funciona correctamente.

---

## API Reference

### GET /api/productos.php

Estructura de respuesta:
```json
{
  "exito": true,
  "mensaje": "Productos obtenidos correctamente",
  "total": 12,
  "cantidad": 8,
  "datos": [ ... ]
}
```

| Parametro | Tipo | Ejemplo | Descripcion |
|-----------|------|---------|-------------|
| (ninguno) |  | /api/productos.php | Lista todos |
| id | int | ?id=3 | Un producto por ID |
| busqueda | string | ?busqueda=laptop | Busca por nombre o descripcion |
| categoria_id | int | ?categoria_id=1 | Filtra por categoria |
| orden | string | ?orden=p.precio ASC | Ordenamiento |
| limite | int | ?limite=6 | Cantidad de resultados |
| offset | int | ?offset=6 | Desde que posicion |
| stats |  | ?stats=1 | Resumen estadistico del inventario |

---

## Como modificar el diseño de la marca

Todo el sistema de diseño esta en un solo archivo: public/css/marca.css

Para cambiar colores edita las variables CSS al inicio del archivo:
```css
:root {
  --cami-bg:       #ebeae4;  /* Fondo beige */
  --cami-turquesa: #4ed2ad;  /* Color principal */
  --cami-coral:    #e45b63;  /* Color secundario */
  --cami-amarillo: #efb810;  /* Color terciario */
  --cami-azul:     #003366;  /* Tipografia */
}
```
Cambiar un valor aqui lo actualiza en toda la landing y el dashboard automaticamente.

---

## Solucion de problemas en MAMP

"No se pudo conectar a la base de datos"
- Verificar que MySQL este corriendo (semaforo verde en MAMP)
- Revisar DB_PORT en config.php (Mac MAMP = 8889, Windows = 3306)
- Verificar que el usuario y password sean correctos (root/root por defecto)

"404 Not Found" en la API o el dashboard
- Verificar que Apache este corriendo (semaforo verde)
- Revisar que BASE_URL en config.php tenga el puerto correcto
- Asegurarte de que la carpeta se llame exactamente "ecommerce"

Los productos no cargan en la landing
- Abrir la consola del navegador (F12 → Consola) y revisar errores
- Probar la API directamente: http://localhost:8888/ecommerce/api/productos.php
- Verificar que API_URL en config.php sea correcto

Las fuentes (Kranky, Playpen Sans) no cargan
- Estas fuentes vienen de Google Fonts y requieren internet
- En desarrollo local necesitas conexion a internet para que carguen

---

Proyecto desarrollado para MAMP / XAMPP — PHP 8.0+ — MySQL 5.7+
Manual de Marca Dia a Dia con Cami 2025
