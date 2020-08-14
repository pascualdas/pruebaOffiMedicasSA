-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 14, 2020 at 06:48 AM
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
(1, 1, 'Otro', '2020-08-13 21:08:32'),
(2, 1, 'Hijo', '2020-08-13 21:08:07'),
(3, 3, 'Hijo', '2020-08-13 22:08:39');

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
(1, 1102714782, 'Dany Pascual', 'Gomez Sanchez', 'Real De Minas', '3012788000', 'pascualdas@gmail.com', '2020-08-13 21:08:52', 'Usuario', 1),
(2, 123, 'Jhon', 'Doe', 'Bucarmanga', '573012788001', 'jhondoe@gmail.com', '2020-08-13 21:08:32', 'Familiar', 1),
(3, 321, 'Mark', 'zuckerberg', 'EEUU', '573157854561', 'mz@facebook.com', '2020-08-13 21:08:07', 'Familiar', 2),
(4, 321, 'Mark', 'zuckerberg', 'EEUU', '573157854561', 'mz@facebook.com', '2020-08-13 21:08:34', 'Usuario', 2),
(5, 13579, 'Steve', 'Wozniak', 'Luna', '57313245552', 'sw@gnu.lx', '2020-08-13 22:08:16', 'Usuario', 3),
(6, 24682, 'Laura Gimena', 'Peralta Rubio', 'Carrera 32W No. 71-139', '0376973918 ', 'laura.peralta@offimedicas.com', '2020-08-13 22:08:39', 'Familiar', 3),
(7, 24682, 'Laura Gimena', 'Peralta Rubio', 'Carrera 32W No. 71-139', '0376973918 ', 'laura.peralta@offimedicas.com', '2020-08-13 22:08:15', 'Usuario', 4);

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
(1, 'Qwerty0713', '1', '2020-08-13 21:08:52', '2020-08-13 23:08:24'),
(2, 'Facebook123', '1', '2020-08-13 21:08:34', '2020-08-13 22:08:06'),
(3, 'Linux123', '1', '2020-08-13 22:08:16', '2020-08-13 22:08:32'),
(4, 'Gestion12345', '1', '2020-08-13 22:08:15', '2020-08-13 22:08:18');

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
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `personas`
--
ALTER TABLE `personas`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

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
