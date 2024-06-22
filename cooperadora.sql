-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 22-06-2024 a las 19:19:07
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
-- Base de datos: `cooperadora`
--

DELIMITER $$
--
-- Procedimientos
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_InsertarUsuario` (IN `p_usuario` VARCHAR(50), IN `p_contrasenia` VARCHAR(50), IN `p_dni` INT, IN `p_tipoUsuario` INT)   BEGIN
    INSERT INTO usuario (Usuario, Contrasenia, Dni_usuario, id_tipodeusuario, Usuario_activo)
    VALUES (p_usuario, p_contrasenia, p_dni, p_tipoUsuario, 1);
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `administracion`
--

CREATE TABLE `administracion` (
  `Id_administracion` int(11) NOT NULL,
  `Valor_concepto` int(11) NOT NULL,
  `Fecha_inicio` date NOT NULL,
  `Fecha_fin` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `administracion`
--

INSERT INTO `administracion` (`Id_administracion`, `Valor_concepto`, `Fecha_inicio`, `Fecha_fin`) VALUES
(1, 1500, '2024-01-01', '2024-12-31'),
(2, 5000, '2024-01-01', '2024-12-31'),
(3, 15000, '2024-01-01', '2024-12-31'),
(4, 100, '2024-01-01', '2024-12-31');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `alumno`
--

CREATE TABLE `alumno` (
  `id_alumno` int(11) NOT NULL,
  `nombre` varchar(32) NOT NULL,
  `apellido` varchar(32) NOT NULL,
  `dni` int(11) NOT NULL,
  `deuda` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `alumno`
--

INSERT INTO `alumno` (`id_alumno`, `nombre`, `apellido`, `dni`, `deuda`) VALUES
(1, 'Martin', 'Millan', 40333222, 16000),
(2, 'Patricia', 'Silva', 30953341, 15000),
(3, 'Julio', 'Aguilar', 32472142, 30000),
(4, 'Belen', 'Gomez', 34438146, 20000),
(5, 'Fernando', 'Guinazu', 42297919, 19000),
(6, 'Soledad', 'Carballo', 38072126, 24000),
(7, 'Esteban', 'Quito', 38456746, 50000),
(8, 'Susana', 'Oria', 33789002, 45000),
(9, 'Monica', 'Galindo', 30432765, 30000);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `carga_pago`
--

CREATE TABLE `carga_pago` (
  `id_cargaPago` int(11) NOT NULL,
  `valorAbonado` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `id_metodoDePago` int(11) NOT NULL,
  `id_alumno` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `carga_pago`
--

INSERT INTO `carga_pago` (`id_cargaPago`, `valorAbonado`, `fecha`, `id_usuario`, `id_metodoDePago`, `id_alumno`) VALUES
(1, 2000, '2024-05-14', 2, 1, 4),
(2, 3500, '2024-05-10', 2, 1, 2),
(3, 1700, '2024-05-01', 2, 2, 8),
(4, 4000, '2024-05-20', 2, 1, 9),
(5, 2300, '2024-04-03', 2, 1, 3),
(6, 1500, '2024-05-21', 2, 2, 5),
(7, 4300, '2024-05-24', 2, 1, 6);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `carrera`
--

CREATE TABLE `carrera` (
  `id_carrera` int(11) NOT NULL,
  `carrera` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `carrera`
--

INSERT INTO `carrera` (`id_carrera`, `carrera`) VALUES
(1, 'Enfermeria A 1er año'),
(2, 'Enfermeria B 1er año'),
(3, 'Enfermeria A 2do año'),
(4, 'Enfermeria B 2do año'),
(5, 'Enfermeria A y B 3er año'),
(6, 'Higiene y Seguridad'),
(7, 'Sistemas'),
(8, 'RRHH'),
(9, 'Instrumentación Quirurgica');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `concepto`
--

CREATE TABLE `concepto` (
  `Id_Concepto` int(11) NOT NULL,
  `Nombre_Concepto` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `concepto`
--

INSERT INTO `concepto` (`Id_Concepto`, `Nombre_Concepto`) VALUES
(1, 'Libreta'),
(3, 'Cuota'),
(4, 'Formulario');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inscripcion`
--

CREATE TABLE `inscripcion` (
  `año` int(11) NOT NULL,
  `id_inscripcion` int(11) NOT NULL,
  `id_alumno` int(11) NOT NULL,
  `id_carrera` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `metodo_de_pago`
--

CREATE TABLE `metodo_de_pago` (
  `id_metodoDePago` int(11) NOT NULL,
  `tipo_de_Pago` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `metodo_de_pago`
--

INSERT INTO `metodo_de_pago` (`id_metodoDePago`, `tipo_de_Pago`) VALUES
(1, 'Efectivo'),
(2, 'Mercado Pago');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `registros`
--

CREATE TABLE `registros` (
  `id_cargaPago` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_de_usuario`
--

CREATE TABLE `tipo_de_usuario` (
  `id_tipodeusuario` int(11) NOT NULL,
  `tipoUsuario` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tipo_de_usuario`
--

INSERT INTO `tipo_de_usuario` (`id_tipodeusuario`, `tipoUsuario`) VALUES
(1, 'Administrador'),
(2, 'Operador');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `Id_Usuario` int(11) NOT NULL,
  `Usuario` varchar(32) NOT NULL,
  `Contrasenia` varchar(32) NOT NULL,
  `id_tipodeusuario` int(11) NOT NULL,
  `Usuario_activo` tinyint(4) DEFAULT NULL,
  `Dni_usuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`Id_Usuario`, `Usuario`, `Contrasenia`, `id_tipodeusuario`, `Usuario_activo`, `Dni_usuario`) VALUES
(1, 'mmillan', '12345', 1, 1, 40333222),
(2, 'admin', 'admin', 1, 1, 76543245);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `administracion`
--
ALTER TABLE `administracion`
  ADD PRIMARY KEY (`Id_administracion`);

--
-- Indices de la tabla `alumno`
--
ALTER TABLE `alumno`
  ADD PRIMARY KEY (`id_alumno`),
  ADD UNIQUE KEY `UC_DNI` (`dni`);

--
-- Indices de la tabla `carga_pago`
--
ALTER TABLE `carga_pago`
  ADD PRIMARY KEY (`id_cargaPago`),
  ADD KEY `id_usuario` (`id_usuario`),
  ADD KEY `id_metodoDePago` (`id_metodoDePago`),
  ADD KEY `id_alumno` (`id_alumno`);

--
-- Indices de la tabla `carrera`
--
ALTER TABLE `carrera`
  ADD PRIMARY KEY (`id_carrera`);

--
-- Indices de la tabla `concepto`
--
ALTER TABLE `concepto`
  ADD PRIMARY KEY (`Id_Concepto`);

--
-- Indices de la tabla `inscripcion`
--
ALTER TABLE `inscripcion`
  ADD PRIMARY KEY (`id_inscripcion`),
  ADD KEY `id_alumno` (`id_alumno`),
  ADD KEY `id_carrera` (`id_carrera`);

--
-- Indices de la tabla `metodo_de_pago`
--
ALTER TABLE `metodo_de_pago`
  ADD PRIMARY KEY (`id_metodoDePago`);

--
-- Indices de la tabla `registros`
--
ALTER TABLE `registros`
  ADD KEY `id_cargaPago` (`id_cargaPago`);

--
-- Indices de la tabla `tipo_de_usuario`
--
ALTER TABLE `tipo_de_usuario`
  ADD PRIMARY KEY (`id_tipodeusuario`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`Id_Usuario`),
  ADD UNIQUE KEY `UC_DNI` (`Dni_usuario`),
  ADD KEY `id_tipodeusuario` (`id_tipodeusuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `administracion`
--
ALTER TABLE `administracion`
  MODIFY `Id_administracion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `alumno`
--
ALTER TABLE `alumno`
  MODIFY `id_alumno` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `carga_pago`
--
ALTER TABLE `carga_pago`
  MODIFY `id_cargaPago` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `carrera`
--
ALTER TABLE `carrera`
  MODIFY `id_carrera` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `concepto`
--
ALTER TABLE `concepto`
  MODIFY `Id_Concepto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `inscripcion`
--
ALTER TABLE `inscripcion`
  MODIFY `id_inscripcion` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `metodo_de_pago`
--
ALTER TABLE `metodo_de_pago`
  MODIFY `id_metodoDePago` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `tipo_de_usuario`
--
ALTER TABLE `tipo_de_usuario`
  MODIFY `id_tipodeusuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `Id_Usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `carga_pago`
--
ALTER TABLE `carga_pago`
  ADD CONSTRAINT `carga_pago_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`Id_Usuario`),
  ADD CONSTRAINT `carga_pago_ibfk_2` FOREIGN KEY (`id_metodoDePago`) REFERENCES `metodo_de_pago` (`id_metodoDePago`),
  ADD CONSTRAINT `carga_pago_ibfk_4` FOREIGN KEY (`id_alumno`) REFERENCES `alumno` (`id_alumno`);

--
-- Filtros para la tabla `concepto`
--
ALTER TABLE `concepto`
  ADD CONSTRAINT `fk_administracion_concepto` FOREIGN KEY (`Id_Concepto`) REFERENCES `administracion` (`Id_administracion`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `inscripcion`
--
ALTER TABLE `inscripcion`
  ADD CONSTRAINT `inscripcion_ibfk_1` FOREIGN KEY (`id_alumno`) REFERENCES `alumno` (`id_alumno`),
  ADD CONSTRAINT `inscripcion_ibfk_2` FOREIGN KEY (`id_carrera`) REFERENCES `carrera` (`id_carrera`);

--
-- Filtros para la tabla `registros`
--
ALTER TABLE `registros`
  ADD CONSTRAINT `registros_ibfk_1` FOREIGN KEY (`id_cargaPago`) REFERENCES `carga_pago` (`id_cargaPago`);

--
-- Filtros para la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD CONSTRAINT `usuario_ibfk_1` FOREIGN KEY (`id_tipodeusuario`) REFERENCES `tipo_de_usuario` (`id_tipodeusuario`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
