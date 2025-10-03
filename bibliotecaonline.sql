-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 03-10-2025 a las 15:40:18
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `bibliotecaonline`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `bibliotecajuegos`
--

CREATE TABLE `bibliotecajuegos` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `titulo` varchar(255) DEFAULT NULL,
  `descripcion` text DEFAULT NULL,
  `autor` varchar(255) DEFAULT NULL,
  `caratula` varchar(255) DEFAULT NULL,
  `categoria` varchar(100) DEFAULT NULL,
  `url` varchar(2083) DEFAULT NULL,
  `anio` smallint(6) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `bibliotecajuegos`
--

INSERT INTO `bibliotecajuegos` (`id`, `user_id`, `titulo`, `descripcion`, `autor`, `caratula`, `categoria`, `url`, `anio`, `created_at`) VALUES
(1, 1, 'Hola', 'Esto es un test', 'YO mismo', 'uploads/d734caaaf5d90b01.jpg', 'PIPIPI', 'https://uniteapi.dev/es/p/ElZorroGG?type=auto', 2010, '2025-10-03 13:23:57'),
(2, 1, 'a', '', '', 'CaratulaPorDefecto/c0de9331000023ace9828643f2e46467.jpg', '', NULL, NULL, '2025-10-03 13:30:24');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `Nombre` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `mail` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `Nombre`, `password`, `mail`, `created_at`) VALUES
(1, 'a', '$2y$10$5L1t8X3tAS7uxc9cLp7Td.tU8GRuyiHdIvAsagSj.F0ju7DfAke6a', 'adayguillem@gmail.com', '2025-10-03 13:13:48');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `bibliotecajuegos`
--
ALTER TABLE `bibliotecajuegos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_user_id` (`user_id`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uniq_mail` (`mail`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `bibliotecajuegos`
--
ALTER TABLE `bibliotecajuegos`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `bibliotecajuegos`
--
ALTER TABLE `bibliotecajuegos`
  ADD CONSTRAINT `fk_form_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
