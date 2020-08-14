-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 14, 2020 at 03:33 AM
-- Server version: 10.1.38-MariaDB
-- PHP Version: 7.3.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pruebaoffimedicassa`
--

-- --------------------------------------------------------

--
-- Table structure for table `familiares`
--

DROP TABLE IF EXISTS `familiares`;
CREATE TABLE `familiares` (
  `id` int(10) NOT NULL,
  `id_usuario` int(10) NOT NULL,
  `parentesco` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `creado_en` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci COMMENT='Informacion de familiares';

--
-- Dumping data for table `familiares`
--

INSERT INTO `familiares` (`id`, `id_usuario`, `parentesco`, `creado_en`) VALUES
(1, 1, 'Familiar', '2020-08-12 00:00:00'),
(4, 1, 'Conyugue', '2020-08-13 00:00:00'),
(5, 1, 'Hermano', '2020-08-13 00:00:00'),
(7, 1, 'Familiar', '2020-08-13 16:08:50'),
(11, 1, 'Otro', '2020-08-13 16:08:59'),
(12, 2, 'Hermano', '2020-08-13 17:08:10'),
(13, 2, 'Conyugue', '2020-08-13 17:08:44');

-- --------------------------------------------------------

--
-- Table structure for table `personas`
--

DROP TABLE IF EXISTS `personas`;
CREATE TABLE `personas` (
  `id` int(10) NOT NULL,
  `dni` int(20) NOT NULL,
  `nombres` varchar(150) COLLATE utf8_spanish_ci NOT NULL,
  `apellidos` varchar(150) COLLATE utf8_spanish_ci NOT NULL,
  `direccion` varchar(300) COLLATE utf8_spanish_ci NOT NULL,
  `telefono` varchar(15) COLLATE utf8_spanish_ci NOT NULL,
  `correo` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `creado_en` datetime NOT NULL,
  `tipoEntidad` enum('Usuario','Familiar','','') COLLATE utf8_spanish_ci NOT NULL,
  `id_tipoPersona` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci COMMENT='Informacion base de usuarios y familiares';

--
-- Dumping data for table `personas`
--

INSERT INTO `personas` (`id`, `dni`, `nombres`, `apellidos`, `direccion`, `telefono`, `correo`, `creado_en`, `tipoEntidad`, `id_tipoPersona`) VALUES
(1, 1102714782, 'Dany Pascual', 'Gomez Sanchez', 'Real De Minas', '3012788000', 'pascualdas@gmail.com', '2020-08-12 00:00:00', 'Usuario', 1),
(3, 1098668224, 'Carlos Alberto', 'Barros', 'Centro de bucaramanga', '3112558005', 'betoweb@gmail.com', '2020-08-13 00:00:00', 'Usuario', 2),
(5, 1098668224, 'Carlos Alberto', 'Barros', 'Centro de bucaramanga', '3112558005', 'betoweb@gmail.com', '2020-08-13 00:00:00', 'Familiar', 1),
(8, 1234, 'Lizet', 'Benavides', 'real', '32121321', 'livabe@gmail.com', '2020-08-13 00:00:00', 'Familiar', 4),
(9, 1235, 'Pedro Alonso', 'Gomez Sanchez', 'adasdasd', '341321321', 'petter@gmail.com', '2020-08-13 00:00:00', 'Familiar', 5),
(11, 1234656, 'Daniela', 'Benavides', 'Bogota', '3254654654', 'dany@gmail.com', '2020-08-13 16:08:50', 'Familiar', 7),
(15, 123123123, 'Camilo', 'Nino', 'Canaveral', '123123123', 'cami@gmail.com', '2020-08-13 16:08:59', 'Familiar', 11),
(16, 1102714782, 'Dany Pascual', 'Gomez Sanchez', 'RM', '3012788000', 'pascualdas@gmail.com', '2020-08-13 17:08:10', 'Familiar', 12),
(17, 2147483647, 'Grace', 'Arvilla', 'centro', '65454541561', 'ga@gmail.com', '2020-08-13 17:08:44', 'Familiar', 13),
(23, 1234, 'Lizet', 'Benavides', 'real', '32121321', 'livabe@gmail.com', '2020-08-13 18:08:30', 'Usuario', 6),
(24, 159753, 'Libardo', 'Gomez', 'Real de minas', '321212121', 'ligoro@gmail.com', '2020-08-13 19:08:35', 'Usuario', 7);

-- --------------------------------------------------------

--
-- Table structure for table `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE `usuarios` (
  `id` int(10) NOT NULL,
  `contrasena` varchar(150) COLLATE utf8_spanish_ci NOT NULL,
  `is_active` enum('1','0','','') COLLATE utf8_spanish_ci NOT NULL,
  `creado_en` datetime NOT NULL,
  `ultimo_acceso` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci COMMENT='Informacion de Logins';

--
-- Dumping data for table `usuarios`
--

INSERT INTO `usuarios` (`id`, `contrasena`, `is_active`, `creado_en`, `ultimo_acceso`) VALUES
(1, '123321', '1', '2020-08-12 00:00:00', '2020-08-13 19:08:39'),
(2, '123321', '1', '2020-08-13 00:00:00', '2020-08-13 18:08:40'),
(6, '123', '1', '2020-08-13 18:08:30', '2020-08-13 19:08:17'),
(7, 'Designer1', '1', '2020-08-13 19:08:35', '2020-08-13 19:08:43');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `familiares`
--
ALTER TABLE `familiares`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indexes for table `personas`
--
ALTER TABLE `personas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `familiares`
--
ALTER TABLE `familiares`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `personas`
--
ALTER TABLE `personas`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `familiares`
--
ALTER TABLE `familiares`
  ADD CONSTRAINT `familiares_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
