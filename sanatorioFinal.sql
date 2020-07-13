-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 05-01-2020 a las 11:58:32
-- Versión del servidor: 10.4.8-MariaDB
-- Versión de PHP: 7.3.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `sanatorio`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `admin`
--

CREATE TABLE `admin` (
  `id_admin` int(11) NOT NULL,
  `nombre_usuario` varchar(30) NOT NULL,
  `password` varchar(64) NOT NULL,
  `tipo_persona` varchar(8) NOT NULL DEFAULT 'admin',
  `imagen` varchar(50) NOT NULL DEFAULT '000000000.png'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `admin`
--

INSERT INTO `admin` (`id_admin`, `nombre_usuario`, `password`, `tipo_persona`, `imagen`) VALUES
(8, 'admin1', '67daae98ed0c612857a716202f463356ffcf1a018ce140ab4a4bebc8eb274e6d', 'admin', '1577557776.jpg'),
(12, 'admin6', '67daae98ed0c612857a716202f463356ffcf1a018ce140ab4a4bebc8eb274e6d', 'admin', '000000000.png');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cita`
--

CREATE TABLE `cita` (
  `id_cita` int(11) NOT NULL,
  `id_paciente` int(11) NOT NULL,
  `id_medico` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `hora_inicio` time NOT NULL,
  `hora_fin` time NOT NULL,
  `comentarios` text DEFAULT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `cita`
--

INSERT INTO `cita` (`id_cita`, `id_paciente`, `id_medico`, `fecha`, `hora_inicio`, `hora_fin`, `comentarios`, `activo`) VALUES
(33, 3, 5, '2019-03-03', '15:30:00', '16:00:00', 'pruebaF', 1),
(36, 3, 5, '2019-03-03', '15:00:00', '15:30:00', 'pruebaaa', 1),
(37, 6, 5, '2019-03-03', '15:00:00', '15:30:00', 'pruebaa', 1),
(38, 2, 5, '2019-03-03', '15:00:00', '15:30:00', 'ppp', 1),
(40, 3, 5, '2020-02-01', '17:00:00', '17:30:00', 'pruebaaaaa', 1),
(42, 3, 3, '2020-02-02', '15:00:00', '15:30:00', 'prueba', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `consulta_externa`
--

CREATE TABLE `consulta_externa` (
  `id_consulta_externa` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `hora` time NOT NULL,
  `nombre` varchar(60) NOT NULL,
  `edad` int(3) DEFAULT NULL,
  `telefono` varchar(10) DEFAULT NULL,
  `direccion` text DEFAULT NULL,
  `notas` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `consulta_externa`
--

INSERT INTO `consulta_externa` (`id_consulta_externa`, `fecha`, `hora`, `nombre`, `edad`, `telefono`, `direccion`, `notas`) VALUES
(6, '2020-01-16', '15:00:00', 'pacientenoregistrado', 20, '4545566765', '', '{null}{}{}{}{}{}{}{null}{}{}{}{}{}'),
(7, '2020-01-15', '15:03:00', 'askdnsjd', 23, '8383838392', 'asjdasdjn', '{Masculino}{45}{43}{89}{98}{23}{23}{Sí}{jsndmjasdn}{jndjasndf}{jfjanfj}{hsdjasdn}{jandsandjasnjfgnk}'),
(10, '2020-01-07', '14:04:00', 'ujansjas', 23, '2323344556', 'jdnjdnf', '{Masculino}{78}{65}{78}{78}{88}{998}{Sí}{ajsdnjsdn}{jndjnsdfjsfnm}{jndjsdnfj}{jndcjsdnfdjkfjm}{nndjsndfjsd}');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `consulta_interna`
--

CREATE TABLE `consulta_interna` (
  `id_consulta_interna` int(11) NOT NULL,
  `id_medico` int(11) NOT NULL,
  `id_paciente` int(11) NOT NULL,
  `fecha` date DEFAULT NULL,
  `notas_evolucion` text DEFAULT NULL,
  `hospitalizacion` tinyint(1) NOT NULL DEFAULT 0,
  `notas` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `consulta_interna`
--

INSERT INTO `consulta_interna` (`id_consulta_interna`, `id_medico`, `id_paciente`, `fecha`, `notas_evolucion`, `hospitalizacion`, `notas`) VALUES
(12, 1, 7, NULL, NULL, 0, 'hola'),
(14, 1, 7, '2019-03-02', NULL, 0, ''),
(15, 1, 7, '2019-03-02', NULL, 0, ''),
(24, 4, 3, '0000-00-00', NULL, 0, '{}{}{null}{}{}{}{}{}{}{null}{}{}{}{}{}'),
(25, 4, 3, '2020-01-21', NULL, 0, '{34}{4323454}{Masculino}{23}{87}{78}{67}{87}{86}{Sí}{ksddkfmk}{ksdksdfk}{kasmdksamd}{kamdkasmdfk}{kamdkasmdk}');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `egreso`
--

CREATE TABLE `egreso` (
  `id_medico` int(11) NOT NULL,
  `id_paciente` int(11) NOT NULL,
  `hoja_egreso` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historia_clinica`
--

CREATE TABLE `historia_clinica` (
  `id_paciente` int(11) NOT NULL,
  `hoja_historia_clinica` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `medico`
--

CREATE TABLE `medico` (
  `id_medico` int(11) NOT NULL,
  `nombre` varchar(60) NOT NULL,
  `especialidad` varchar(60) NOT NULL,
  `telefono` varchar(10) NOT NULL,
  `correo` varchar(60) NOT NULL,
  `cedula` varchar(11) NOT NULL,
  `hora_entrada` time NOT NULL,
  `hora_salida` time NOT NULL,
  `password` varchar(64) NOT NULL,
  `tipo_persona` varchar(8) NOT NULL DEFAULT 'medico',
  `activo` tinyint(1) NOT NULL DEFAULT 1,
  `imagen` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `medico`
--

INSERT INTO `medico` (`id_medico`, `nombre`, `especialidad`, `telefono`, `correo`, `cedula`, `hora_entrada`, `hora_salida`, `password`, `tipo_persona`, `activo`, `imagen`) VALUES
(1, 'Gustavo Jim', 'Cirugía general', '5555555534', 'gucho35.enp9@gmail.com', '0123456789', '08:00:00', '10:00:00', '67daae98ed0c612857a716202f463356ffcf1a018ce140ab4a4bebc8eb274e6d', 'medico', 1, '1577720157.png'),
(2, 'Gustavo2', 'Cirugía general', '5500000000', 'g@correo.com', '12345678915', '07:00:00', '14:00:00', '67daae98ed0c612857a716202f463356ffcf1a018ce140ab4a4bebc8eb274e6d', 'medico', 1, '1578219254.jpg'),
(3, 'Gus2', 'Cirugía general', '5534033223', 'gg@gmail.com', '1234561234', '09:00:00', '17:00:00', '67daae98ed0c612857a716202f463356ffcf1a018ce140ab4a4bebc8eb274e6d', 'medico', 1, '1577720188.png'),
(4, 'Gus3', 'Cirugía general', '5512121212', 'gnab@gmail.com', '12345672345', '14:00:00', '17:00:00', '70f368c31301d0dd0dc166451ec18b574998f689f240c97b06124e8ba0f35724', 'medico', 1, '1577556431.jpg'),
(5, 'G3', 'Cirugía general', '1234123412', 'ff@gmail.com', '1234123567', '07:00:00', '14:00:00', '67daae98ed0c612857a716202f463356ffcf1a018ce140ab4a4bebc8eb274e6d', 'medico', 1, '1577720202.png'),
(6, 'G4', 'Cirugía general', '1234345667', 'gh@gmail.com', '1231231235', '06:00:00', '14:00:00', '67daae98ed0c612857a716202f463356ffcf1a018ce140ab4a4bebc8eb274e6d', 'medico', 1, '1577720215.png'),
(7, 'jaja', 'Cirugía general', '23432334', 'ajaja@gmail.com', '1234233445', '06:00:00', '10:00:00', '67daae98ed0c612857a716202f463356ffcf1a018ce140ab4a4bebc8eb274e6d', 'medico', 1, '1577720228.png'),
(8, 'CinvitadoO', 'Cirugía general', '0000000000', 'invitado@invitado.com', '00000000000', '00:00:00', '23:59:00', 'f1e31ad749b37da3741d2e2474ead40ca604f45a6c23540a49ab93fa6c70bfea', 'medico', 1, '1577999204.png'),
(9, 'fmasdmfasdkfm', 'Incubadora', '5454545454', 'sadasdhfasdas@kasmsda.com', 'asdfghjklop', '00:00:00', '00:00:00', '99dbb2554851ab537e56ecbe34f8898457492d9eb1dde7bea5736f67e1cdf680', 'medico', 1, '000000000.png'),
(10, 'admin', 'Cirugía general', '0000000000', 'admin@admin.com', '00000000000', '00:00:00', '23:59:00', '8c6976e5b5410415bde908bd4dee15dfb167a9c873fc4bb8a81f6f2ab448a918', 'medico', 1, '000000000.png');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `paciente`
--

CREATE TABLE `paciente` (
  `id_paciente` int(11) NOT NULL,
  `curp` varchar(18) NOT NULL,
  `id_medico` int(11) NOT NULL,
  `nombre` varchar(60) NOT NULL,
  `fecha_nacimiento` date NOT NULL,
  `telefono` varchar(10) NOT NULL,
  `correo` varchar(60) NOT NULL,
  `direccion` text NOT NULL,
  `genero` char(1) NOT NULL,
  `fecha_registro` date NOT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT 1,
  `imagen` varchar(50) DEFAULT NULL,
  `historia_clinica` text DEFAULT NULL,
  `notas_clinicas` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `paciente`
--

INSERT INTO `paciente` (`id_paciente`, `curp`, `id_medico`, `nombre`, `fecha_nacimiento`, `telefono`, `correo`, `direccion`, `genero`, `fecha_registro`, `activo`, `imagen`, `historia_clinica`, `notas_clinicas`) VALUES
(1, 'AAAA0000', 5, 'paciente0', '2019-12-02', '5555555555', 'paciente0@gmail.com', 'hhhhhhhhaahsjdn', 'M', '0000-00-00', 0, '1577720283.png', NULL, NULL),
(2, 'AAAA000000AAAAAA00', 1, 'paciente1', '2019-12-01', '5523232323', 'paciente1@gmail.com', 'hhhhhhh', 'M', '2019-12-19', 1, '1577720289.png', NULL, 'nota 1. hoy se le receto algo\r\n\r\nnota 2. hoy se actualizaron datos\r\n\r\nnota 3. hoy se le hicieron capturas de huellas'),
(3, 'AAAAAAAAAAAAAAAABB', 6, 'paciente3', '2019-12-11', '3493423948', 'paciente@jaja.com', 'insurgentes212', 'M', '2019-12-12', 1, '1577720294.png', '{}{holacomotasdzxszdvd}{23}{Masculino}{aksdfnkadfn}{ksdnfkdf}{kdsfnkasfn}{ksdfnkadfn}{456364564}{ksdfksdfsdkmf}{}{}{}{}{}{}{}{}{}{}{}{}{}{}{}{}{}{}{}{}{}{}{}{}{}{}{}{}{}{}{}{}{}{}{}{}{}{}{}{}{}{}{}{}{}{}{}{}{}{}{}{}{}{}{}{}{}{}{}{}{}{}{}{}{}{}{}{}{}{}{}{}{}{}{}{}{}{}{}{}{}{}{}{}{}{}{}{}{}{}{}{}{}{}{}{}{}{}{}{}{}{}{}{}{}{}{}{}{}{}{}{undefined}', NULL),
(6, 'AAAAAAAAAAAA', 5, 'paciente 4', '2019-12-12', '4444444432', 'paciente4@gmail.com', 'polanco 314', 'M', '2019-12-04', 1, '1577131732.jpg', '{2020-01-16}{holacomotasjzsdnjasdn}{23}{Masculino}{aklsdaslkdm}{ksadknsdkmsadbnm}{KSckznc}{kndkcncd}{kasksnckscn}{kancksncksnc}{zsKDnaskdn}{ksdfnksdnfdk}{kasnfkasdfn}{kanfdkasdn}{aknfkasdbnm}{kasbndkasdn}{kasbndkasnd}{kasndkasndkasd}{}{}{}{}{}{}{}{}{}{}{}{}{}{}{}{}{}{}{}{}{}{}{}{}{}{}{}{}{}{}{}{}{}{}{}{}{}{}{}{}{}{}{}{}{}{}{}{}{}{}{}{}{}{}{}{}{}{}{}{}{}{}{}{}{}{}{}{}{}{}{}{}{}{}{}{}{}{}{}{}{}{}{}{}{}{}{}{}{}{}{}{}{}{}{}{}{}{}{}{}{kjasdnaksdnaskdnm}{askdnkasdnkasndkmad es la edicion de hoyaasjdbnajsda`qwsjkdbkasdbaksbndsandkaskd}{2020-01-21}{qnwdkqwjndqwjkdnqw}', NULL),
(7, 'CCCCCCCCCCCCCCCCCC', 7, 'ggg', '2018-12-19', '3333333333', 'paciente05@gmail.com', 'polanco 543', 'M', '2019-12-10', 1, '1577720298.png', NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permisos`
--

CREATE TABLE `permisos` (
  `id_permiso` int(11) NOT NULL,
  `nombre` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `permisos`
--

INSERT INTO `permisos` (`id_permiso`, `nombre`) VALUES
(1, 'admin'),
(2, 'medico'),
(3, 'paciente'),
(4, 'escritorio');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id_admin`);

--
-- Indices de la tabla `cita`
--
ALTER TABLE `cita`
  ADD PRIMARY KEY (`id_cita`),
  ADD KEY `id_paciente` (`id_paciente`),
  ADD KEY `id_medico` (`id_medico`);

--
-- Indices de la tabla `consulta_externa`
--
ALTER TABLE `consulta_externa`
  ADD PRIMARY KEY (`id_consulta_externa`);

--
-- Indices de la tabla `consulta_interna`
--
ALTER TABLE `consulta_interna`
  ADD PRIMARY KEY (`id_consulta_interna`),
  ADD KEY `id_medico` (`id_medico`),
  ADD KEY `id_paciente` (`id_paciente`);

--
-- Indices de la tabla `egreso`
--
ALTER TABLE `egreso`
  ADD KEY `id_paciente` (`id_paciente`),
  ADD KEY `id_medico` (`id_medico`);

--
-- Indices de la tabla `historia_clinica`
--
ALTER TABLE `historia_clinica`
  ADD KEY `id_paciente` (`id_paciente`);

--
-- Indices de la tabla `medico`
--
ALTER TABLE `medico`
  ADD PRIMARY KEY (`id_medico`);

--
-- Indices de la tabla `paciente`
--
ALTER TABLE `paciente`
  ADD PRIMARY KEY (`id_paciente`,`curp`),
  ADD KEY `id_medico` (`id_medico`);

--
-- Indices de la tabla `permisos`
--
ALTER TABLE `permisos`
  ADD PRIMARY KEY (`id_permiso`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `admin`
--
ALTER TABLE `admin`
  MODIFY `id_admin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `cita`
--
ALTER TABLE `cita`
  MODIFY `id_cita` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT de la tabla `consulta_externa`
--
ALTER TABLE `consulta_externa`
  MODIFY `id_consulta_externa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT de la tabla `consulta_interna`
--
ALTER TABLE `consulta_interna`
  MODIFY `id_consulta_interna` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT de la tabla `medico`
--
ALTER TABLE `medico`
  MODIFY `id_medico` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `paciente`
--
ALTER TABLE `paciente`
  MODIFY `id_paciente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `permisos`
--
ALTER TABLE `permisos`
  MODIFY `id_permiso` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `cita`
--
ALTER TABLE `cita`
  ADD CONSTRAINT `cita_ibfk_1` FOREIGN KEY (`id_paciente`) REFERENCES `paciente` (`id_paciente`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `cita_ibfk_2` FOREIGN KEY (`id_medico`) REFERENCES `medico` (`id_medico`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `consulta_interna`
--
ALTER TABLE `consulta_interna`
  ADD CONSTRAINT `consulta_interna_ibfk_1` FOREIGN KEY (`id_medico`) REFERENCES `medico` (`id_medico`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `consulta_interna_ibfk_2` FOREIGN KEY (`id_paciente`) REFERENCES `paciente` (`id_paciente`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `egreso`
--
ALTER TABLE `egreso`
  ADD CONSTRAINT `egreso_ibfk_1` FOREIGN KEY (`id_paciente`) REFERENCES `paciente` (`id_paciente`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `egreso_ibfk_2` FOREIGN KEY (`id_medico`) REFERENCES `medico` (`id_medico`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `historia_clinica`
--
ALTER TABLE `historia_clinica`
  ADD CONSTRAINT `historia_clinica_ibfk_1` FOREIGN KEY (`id_paciente`) REFERENCES `paciente` (`id_paciente`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `paciente`
--
ALTER TABLE `paciente`
  ADD CONSTRAINT `paciente_ibfk_1` FOREIGN KEY (`id_medico`) REFERENCES `medico` (`id_medico`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
