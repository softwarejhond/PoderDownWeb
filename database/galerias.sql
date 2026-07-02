-- --------------------------------------------------------
-- Sección Galerías de Fotos (Poder Down)
-- Estructura + datos de ejemplo. Ejecutar en phpMyAdmin sobre la BD del sitio.
-- --------------------------------------------------------

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";
/*!40101 SET NAMES utf8mb4 */;

-- --------------------------------------------------------
-- Estructura de tabla para la tabla `galerias`
-- --------------------------------------------------------

CREATE TABLE IF NOT EXISTS `galerias` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `excerpt` text DEFAULT NULL,
  `featured_image` varchar(500) DEFAULT NULL,
  `author` varchar(150) DEFAULT NULL,
  `status` enum('draft','published') NOT NULL DEFAULT 'published',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`),
  KEY `status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Estructura de tabla para la tabla `galeria_obras`
-- --------------------------------------------------------

CREATE TABLE IF NOT EXISTS `galeria_obras` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `galeria_id` int(11) NOT NULL,
  `img` varchar(500) NOT NULL,
  `title` varchar(255) NOT NULL,
  `meta` varchar(255) DEFAULT NULL,
  `descripcion` text DEFAULT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `galeria_id` (`galeria_id`),
  CONSTRAINT `fk_galeria_obras_galeria` FOREIGN KEY (`galeria_id`) REFERENCES `galerias` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Datos de ejemplo (desde data/galerias.json)
-- --------------------------------------------------------

INSERT INTO `galerias` (`id`, `title`, `slug`, `excerpt`, `featured_image`, `author`, `status`, `created_at`) VALUES
(1, 'Colección Permanente', 'coleccion-permanente', 'Ocho obras maestras que iluminan la diversidad y el arte desde la mirada única de Poder Down.', 'https://upload.wikimedia.org/wikipedia/commons/e/ea/Van_Gogh_-_Starry_Night_-_Google_Art_Project.jpg', 'cami', 'published', '2024-03-15 10:00:00'),
(2, 'Colores del Alma', 'colores-del-alma', 'Seis pinturas originales de Cami que capturan emociones a través del pincel y el color.', '', 'cami', 'published', '2024-06-20 10:00:00');

INSERT INTO `galeria_obras` (`galeria_id`, `img`, `title`, `meta`, `descripcion`, `sort_order`) VALUES
(1, 'https://upload.wikimedia.org/wikipedia/commons/e/ea/Van_Gogh_-_Starry_Night_-_Google_Art_Project.jpg', 'La noche estrellada', 'Vincent van Gogh · 1889 · Óleo sobre lienzo', 'Pintada desde la ventana de su cuarto en el asilo de Saint-Rémy, esta obra transforma el cielo nocturno en un remolino de luz y movimiento sobre un pueblo dormido.', 0),
(1, 'https://upload.wikimedia.org/wikipedia/commons/0/0f/1665_Girl_with_a_Pearl_Earring.jpg', 'La joven de la perla', 'Johannes Vermeer · c. 1665 · Óleo sobre lienzo', 'Conocida como la ''Mona Lisa del Norte'', su mirada directa y el brillo del pendiente convierten un retrato sencillo en un enigma que ha fascinado durante siglos.', 1),
(1, 'https://upload.wikimedia.org/wikipedia/commons/a/a5/Tsunami_by_hokusai_19th_century.jpg', 'La gran ola de Kanagawa', 'Katsushika Hokusai · c. 1831 · Xilografía', 'Una ola gigante amenaza a tres barcos frente al monte Fuji, capturando el instante exacto entre la fuerza de la naturaleza y la fragilidad humana.', 2),
(1, 'https://upload.wikimedia.org/wikipedia/commons/1/1c/Grant_Wood_-_American_Gothic_-_Google_Art_Project.jpg', 'Gótico americano', 'Grant Wood · 1930 · Óleo sobre madera', 'Un granjero y su hija posan rígidos frente a su vivienda, símbolo icónico —y a menudo parodiado— del carácter austero del Medio Oeste estadounidense.', 3),
(1, 'https://upload.wikimedia.org/wikipedia/commons/4/40/The_Kiss_-_Gustav_Klimt_-_Google_Cultural_Institute.jpg', 'El beso', 'Gustav Klimt · 1908 · Óleo y hoja de oro', 'Dos amantes envueltos en mantos dorados de mosaico se funden en un abrazo sobre un campo de flores, cumbre del período dorado del artista vienés.', 4),
(1, 'https://upload.wikimedia.org/wikipedia/commons/e/e0/Claude_Monet_038.jpg', 'Nenúfares', 'Claude Monet · 1906 · Óleo sobre lienzo', 'Parte de la serie pintada en su jardín de Giverny, disuelve las formas en manchas de luz y color que anticipan la abstracción del siglo XX.', 5),
(1, 'https://upload.wikimedia.org/wikipedia/commons/0/0b/Sandro_Botticelli_-_La_nascita_di_Venere_-_Google_Art_Project_-_edited.jpg', 'El nacimiento de Venus', 'Sandro Botticelli · c. 1485 · Temple sobre lienzo', 'La diosa del amor emerge de una concha marina, un ideal de belleza renacentista inspirado en la mitología y el arte clásico grecorromano.', 6),
(1, 'https://upload.wikimedia.org/wikipedia/commons/9/90/Vassily_Kandinsky%2C_1923_-_Composition_8%2C_huile_sur_toile%2C_140_cm_x_201_cm%2C_Mus%C3%A9e_Guggenheim%2C_New_York.jpg', 'Composición VIII', 'Vasili Kandinsky · 1923 · Óleo sobre lienzo', 'Círculos, líneas y triángulos flotan en equilibrio geométrico; una de las obras más rigurosas de su etapa en la Bauhaus, donde la forma se vuelve música.', 7),
(2, 'https://picsum.photos/seed/cami1/800/600', 'Explosión de alegría', 'Cami · 2023 · Acrílico sobre lienzo', 'Una celebración visual donde cada trazo expresa la felicidad pura de crear sin límites ni etiquetas.', 0),
(2, 'https://picsum.photos/seed/cami2/800/600', 'Serenidad', 'Cami · 2023 · Acuarela', 'Tonos azules y verdes que evocan la calma después de la tormenta, un refugio para el espíritu.', 1),
(2, 'https://picsum.photos/seed/cami3/800/600', 'Fuerza interior', 'Cami · 2024 · Técnica mixta', 'Líneas enérgicas y contrastes audaces que representan la determinación de quien enfrenta el mundo con valentía.', 2),
(2, 'https://picsum.photos/seed/cami4/800/600', 'Sueños compartidos', 'Cami · 2024 · Óleo sobre lienzo', 'Dos figuras se entrelazan en un abrazo de color, recordándonos que juntos somos más fuertes.', 3),
(2, 'https://picsum.photos/seed/cami5/800/600', 'Libertad', 'Cami · 2024 · Acrílico', 'Un vuelo de mariposas multicolores que rompen el lienzo, símbolo de la inclusión sin barreras.', 4),
(2, 'https://picsum.photos/seed/cami6/800/600', 'Esperanza', 'Cami · 2024 · Acuarela y tinta', 'La luz al final del túnel pintada con la sensibilidad única de quien ve el mundo desde otra perspectiva.', 5);
