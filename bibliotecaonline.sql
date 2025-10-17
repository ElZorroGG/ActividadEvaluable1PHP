-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 17-10-2025 a las 16:40:32
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
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `visualizaciones` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `bibliotecajuegos`
--

INSERT INTO `bibliotecajuegos` (`id`, `user_id`, `titulo`, `descripcion`, `autor`, `caratula`, `categoria`, `url`, `anio`, `created_at`, `visualizaciones`) VALUES
(12, 4, 'GTA 5', 'Esto es gta5 baybe', 'Rockstar Studios', '/ActividadEvaluable1PHP/CaratulaPorDefecto/fc10656866244f57fe4aec109c76c84474539fef6ef3e066cf177edea6185202_749a89.png', 'Accion', 'https://www.rockstargames.com/es/gta-v?info=order', 2013, '2025-10-07 11:49:21', 0),
(13, 3, 'Counter Strike global Offensive', 'Csgo terroristas y antiterroristas', 'Valve', '/ActividadEvaluable1PHP/caratulas/e82739cb29b3832e4d566ab337abb0f1fe3e18db3b0339361739dadc13b431ac.webp', 'Accion', 'https://www.counter-strike.net', 2012, '2025-10-07 11:54:46', 0),
(14, 8, 'The Witcher 3', 'Juego de rol de mundo abierto donde encarnas a Geralt de Rivia, un cazador de monstruos profesional en busca de su hija adoptiva.', 'CD Projekt Red', 'caratulas/4daa8e38c4611dda60b4dd48382f1e58f39f9e00101bd363e7390fec3aa9f3a6.jpg', 'RPG', 'https://www.thewitcher.com/es', 2015, '2025-10-14 11:23:07', 0),
(15, 5, 'Red Dead Redemption 2', 'Epopeya de acción y aventuras ambientada en los albores de la era moderna. Sigue la historia de Arthur Morgan y la banda de Dutch van der Linde.', 'Rockstar Games', 'caratulas/27aa89c336b381083a1b3e8de84ffbcb842219dabca97aabfcf707b1dd8c135c.jpg', 'Accion', 'https://www.rockstargames.com/reddeadredemption2', 2018, '2025-10-14 11:23:07', 0),
(16, 4, 'Cyberpunk 2077', 'RPG de acción y aventura de mundo abierto que se desarrolla en Night City, una megalópolis obsesionada con el poder, el glamur y las modificaciones corporales.', 'CD Projekt Red', 'caratulas/068fb873c89d18b5b1bffa148722957f6446a8b6d080335e4595c08ec0685988.jpg', 'RPG', 'https://www.cyberpunk.net', 2020, '2025-10-14 11:23:07', 0),
(17, 3, 'Elden Ring', 'Nuevo juego de rol de acción y fantasía desarrollado por FromSoftware y producido por Hidetaka Miyazaki en colaboración con George R.R. Martin.', 'FromSoftware', 'caratulas/d46402528e357350bdb31a00be57a7896238515e6dc8afc0669aa54573307c02.jpg', 'RPG', 'https://en.bandainamcoent.eu/elden-ring', 2022, '2025-10-14 11:23:07', 0),
(18, 8, 'Minecraft', 'Juego de construcción y aventuras en un mundo generado proceduralmente hecho de bloques. Explora, construye y sobrevive.', 'Mojang Studios', 'caratulas/eef2ffddfc162863590e67ec1dcec85d3da30dc5ee02fb3fc9b476088bcd9649.jpg', 'Sandbox', 'https://www.minecraft.net', 2011, '2025-10-14 11:23:07', 1),
(19, 4, 'God of War', 'Kratos y su hijo Atreus se embarcan en un viaje épico por los reinos nórdicos. Una historia profunda de padre e hijo en un mundo mitológico brutal.', 'Santa Monica Studio', 'caratulas/cef450471bbaf6058991c841c30539069f436a92ba5e91994bf12d12657e3b80.jpg', 'Accion', 'https://www.playstation.com/games/god-of-war', 2018, '2025-10-14 11:23:07', 0),
(20, 8, 'Horizon Zero Dawn', 'Aventura de acción en un mundo post-apocalíptico dominado por máquinas. Sigue a Aloy en su búsqueda de respuestas sobre su pasado.', 'Guerrilla Games', 'caratulas/95971139817f59677278b82584523cf15d0ce57e1d3382e8753dd889e2d31334.jpg', 'Aventura', 'https://www.playstation.com/games/horizon-zero-dawn', 2017, '2025-10-14 11:23:07', 0),
(21, 5, 'Dark Souls III', 'El aclamado juego de rol de acción conocido por su dificultad implacable. Explora un mundo oscuro lleno de enemigos mortales y jefes épicos.', 'FromSoftware', 'caratulas/27220371fbd76f7d1012b3ac91757435b0e532ae6fdf983d22a59586581fdbc3.jpg', 'RPG', 'https://www.darksouls3.com', 2016, '2025-10-14 11:23:07', 23),
(22, 8, 'Sekiro: Shadows Die Twice', 'Juego de acción y aventura en el Japón del período Sengoku. Combate preciso y desafiante con un sistema de combate único.', 'FromSoftware', 'caratulas/1a7309b8cef162b7bd4ed33ebddbc70b15734ac0250492110535a4d22eb88b5b.jpg', 'Accion', 'https://www.sekirothegame.com', 2019, '2025-10-14 11:23:07', 0),
(23, 6, 'The Last of Us Part II', 'Continuación de la historia de Ellie en un mundo post-apocalíptico. Una narrativa intensa y emotiva sobre venganza y redención.', 'Naughty Dog', 'caratulas/9a1955f3b297a29082f6b7a602f505c0f2eed1e2b9c9216356623595982f3c44.jpg', 'Accion', 'https://www.playstation.com/games/the-last-of-us-part-ii', 2020, '2025-10-14 11:23:07', 0),
(24, 5, 'Spider-Man', 'Juego de acción en mundo abierto protagonizado por Spider-Man. Balancea por Nueva York mientras combates el crimen y resuelves una conspiración.', 'Insomniac Games', 'caratulas/84417fb73690f07c8f24852f63f220fcc0d422a580cd8fdfd0e62d554bfaff78.jpg', 'Accion', 'https://www.playstation.com/games/marvels-spider-man', 2018, '2025-10-14 11:23:07', 0),
(25, 8, 'Hollow Knight', 'Aventura de acción en 2D ambientada en Hallownest, un vasto reino subterráneo en ruinas. Exploración metroidvania con combates desafiantes.', 'Team Cherry', 'caratulas/d84620f1002e65ad386f098cf62cb1231f3c90c60d527cb2782256ac7e65432b.jpg', 'Aventura', 'https://www.hollowknight.com', 2017, '2025-10-14 11:23:07', 0),
(26, 6, 'Hades', 'Roguelike de acción con elementos de dungeon crawler. Escapa del inframundo griego con la ayuda de los dioses del Olimpo.', 'Supergiant Games', 'caratulas/5014ec1d84ae967cf4226826824628d44963655fa8ac5f6575ca53a759b5cb3f.jpg', 'Roguelike', 'https://www.supergiantgames.com/games/hades', 2020, '2025-10-14 11:23:07', 0),
(27, 7, 'Stardew Valley', 'Juego de simulación de granja con elementos de RPG. Cultiva tu tierra, cría animales, explora cavernas y construye relaciones con los habitantes.', 'ConcernedApe', 'caratulas/6f173dfb051a350dffdc1668b466b30b884ee2d080725c995fdbc89bcfd4565b.jpg', 'Simulacion', 'https://www.stardewvalley.net', 2016, '2025-10-14 11:23:07', 0),
(28, 4, 'Celeste', 'Plataformas desafiante sobre escalar una montaña. Una historia conmovedora sobre superar obstáculos internos y externos.', 'Maddy Makes Games', 'caratulas/a0469dca08cbdc24fc10bd27ce6fe95350cde85b8441e37175356e6021365a64.jpg', 'Plataformas', 'http://www.celestegame.com', 2018, '2025-10-14 11:23:07', 0),
(29, 3, 'Death Stranding', 'Experiencia única de exploración y conexión. Reconecta una América fragmentada entregando paquetes a través de terrenos hostiles.', 'Kojima Productions', 'caratulas/28209cbe9a68cc8d79d87c474d84fb314b8de3543bfca14ec14607b4bfd70987.jpg', 'Aventura', 'https://www.kojimaproductions.jp/en/death-stranding.html', 2019, '2025-10-14 11:23:07', 0),
(30, 4, 'Bloodborne', 'RPG de acción ambientado en la ciudad gótica de Yharnam. Combate rápido y agresivo contra horrores cósmicos.', 'FromSoftware', 'caratulas/c9c3ca6ab22532d55788eb91eececc06515ed12508f7f8d84209c0b488cae352.jpg', 'RPG', 'https://www.playstation.com/games/bloodborne', 2015, '2025-10-14 11:23:07', 1),
(31, 8, 'Ghost of Tsushima', 'Aventura de acción en mundo abierto ambientada en el Japón feudal. Conviértete en el Fantasma y libera la isla de Tsushima de los invasores mongoles.', 'Sucker Punch Productions', 'caratulas/fe1bf015452d5e52a6a9fb9b7e535996a5b8f950fd5b4fd958636095ac02f39a.jpg', 'Accion', 'https://www.playstation.com/games/ghost-of-tsushima', 2020, '2025-10-14 11:23:07', 0),
(32, 7, 'It Takes Two', 'Aventura cooperativa exclusiva que narra la historia de Cody y May, una pareja transformada en muñecos por un hechizo mágico.', 'Hazelight Studios', 'caratulas/67d0018628094dcbb3525a0c7c5a72629aa5952564d99ebf90a7f829bed5fa51.jpg', 'Aventura', 'https://www.ea.com/games/it-takes-two', 2021, '2025-10-14 11:23:07', 0),
(33, 4, 'Resident Evil Village', 'Survival horror en primera persona. Ethan Winters busca a su hija en un misterioso pueblo europeo lleno de horrores.', 'Capcom', 'caratulas/fce8cdc343c3c5caeb23da84bf590213a231dd07e2736ca97ed1af6a318da995.jpg', 'Terror', 'https://www.residentevil.com/village', 2021, '2025-10-14 11:23:07', 0),
(34, 5, 'Doom Eternal', 'Shooter frenético en primera persona. Como el Doom Slayer, lucha contra demonios en la Tierra y más allá con un arsenal devastador.', 'id Software', 'caratulas/4b3de8b47d18a9af153f36eaf4ec31bc57f16a78f2baacdeb5b9afec97b84d77.jpg', 'Shooter', 'https://bethesda.net/game/doom', 2020, '2025-10-14 11:23:07', 0),
(35, 7, 'Control', 'Aventura de acción sobrenatural en tercera persona. Investiga fenómenos paranormales en el misterioso Oldest House.', 'Remedy Entertainment', 'caratulas/b8581e2ab833e5a3d41e872d9f92cc3f4bacd8d228612c602db3a9d81e0e0cb9.jpg', 'Accion', 'https://www.remedygames.com/games/control', 2019, '2025-10-14 11:23:07', 0),
(36, 7, 'Portal 2', 'Juego de puzzles en primera persona. Usa el dispositivo de portales para resolver acertijos imposibles en Aperture Science.', 'Valve', 'caratulas/41d535fcc9663ba118cd808a9637547c3458869a52f0b541a211b60113c86faa.jpg', 'Puzzle', 'https://www.thinkwithportals.com', 2011, '2025-10-14 11:23:07', 0),
(37, 7, 'Bioshock Infinite', 'Shooter en primera persona ambientado en la ciudad flotante de Columbia en 1912. Una historia profunda sobre dimensiones alternas y elecciones.', '2K Games', 'caratulas/3c0987e3165dba6f8a7be89e863b651a77b0335613c24ef0c0cdaa44f1c1842d.jpg', 'Shooter', 'https://2k.com/bioshock', 2013, '2025-10-14 11:23:07', 0),
(38, 7, 'Fall Guys', 'Battle royale multijugador con mini-juegos caóticos. Compite con hasta 60 jugadores en divertidos obstáculos hasta ser el último en pie.', 'Mediatonic', 'caratulas/c413601546e208cb737e77f0667ca86f2d20dc6730a5c9361668c7e7a0ed4a10.jpg', 'Multijugador', 'https://www.fallguys.com', 2020, '2025-10-14 11:23:07', 1),
(39, 5, 'Among Us', 'Juego social multijugador de deducción. Trabaja en equipo para completar tareas o elimina a la tripulación como impostor.', 'InnerSloth', 'caratulas/e20a84539d119c404548bcb93a0613982df23133c1b3c0ea69aba433a4608825.jpg', 'Multijugador', 'https://www.innersloth.com/games/among-us', 2018, '2025-10-14 11:23:07', 0),
(40, 7, 'Undertale', 'RPG indie donde la amabilidad importa tanto como la fuerza. Cada decisión afecta el destino de los monstruos subterráneos.', 'Toby Fox', 'caratulas/924469d6bce07a5faa3ab8461b320def4029fd320ecad9400854c75e3f36a872.jpg', 'RPG', 'https://undertale.com', 2015, '2025-10-14 11:23:07', 0),
(41, 6, 'Ori and the Will of the Wisps', 'Plataformas metroidvania con arte visual impresionante. Una historia emotiva sobre familia, sacrificio y esperanza.', 'Moon Studios', 'caratulas/ff5ec1a41fc83352d7383a49502444f20a6e8bb7b5b7e6b4c5daf8f0d51f05ef.jpg', 'Plataformas', 'https://www.orithegame.com', 2020, '2025-10-14 11:23:07', 0),
(42, 4, 'Disco Elysium', 'RPG revolucionario centrado en la narrativa. Investiga un asesinato en un mundo único mientras descubres quién eres.', 'ZA/UM', 'caratulas/fee6aa0d9d4398bac3883766344784b0ae93062d22a9fa20de1507e4eea064e7.jpg', 'RPG', 'https://discoelysium.com', 2019, '2025-10-14 11:23:07', 1),
(43, 8, 'Valheim', 'Juego de supervivencia y exploración inspirado en la mitología nórdica. Construye, explora y conquista el décimo mundo.', 'Iron Gate Studio', 'caratulas/aa1f6557f0ea8663232dd21dcac4cf090de1ec5c8a0c67b17a323df02032c22d.jpg', 'Supervivencia', 'https://www.valheimgame.com', 2021, '2025-10-14 11:23:07', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `Nombre` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `mail` varchar(255) NOT NULL,
  `foto_perfil` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `Nombre`, `password`, `mail`, `foto_perfil`, `created_at`) VALUES
(3, 'Paco', '$2y$10$Vxc/Mu7zpZujEvBrU6p.u.JYKBH71J.9Dop2tM/I2suR9OCOVVvX6', 'Paco@gmail.com', 'PerfilPorDefecto/Perfil.webp', '2025-10-07 11:44:53'),
(4, 'PAQUITO', '$2y$10$EQ0F4s6oqI8CSfRcyVRVw.L.QDFB8R07RiETEZuM5hx7Nx53on1jO', 'Jimenez@gmail.com', 'FotoPerfil/14b1304c9a76ecf89ba0d0474615d82fb98b11f2eb125b6405c2b75fcc7310f4.png', '2025-10-07 11:46:26'),
(5, 'Carlos', '$2y$10$UG7C.O5s/XO96.gFIROrnOIGSOuCCmK7vO7v20YgpTRtfb1MJCSz6', 'carlos@example.com', 'PerfilPorDefecto/Perfil.webp', '2025-10-14 11:23:07'),
(6, 'Maria', '$2y$10$ty6PktUym.Ntts07TWxNGOWpKoiHzOu/q1OpwkKmVv5TirHee68cW', 'maria@example.com', 'PerfilPorDefecto/Perfil.webp', '2025-10-14 11:23:07'),
(7, 'Pedro', '$2y$10$zNXxAKBxBkcw5wyTwtIJ0u1qIHnJG1aTSjvcEUBLlZyAH/nTSnkiK', 'pedro@example.com', 'PerfilPorDefecto/Perfil.webp', '2025-10-14 11:23:07'),
(8, 'Ana', '$2y$10$fH.CLbyf37EQLUOr01KDC.l8IfVeof0NipvES9B2oXtsuQh2REQ7q', 'ana@example.com', 'PerfilPorDefecto/Perfil.webp', '2025-10-14 11:23:07');

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
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

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
