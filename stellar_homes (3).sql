-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 10-12-2024 a las 09:17:43
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `stellar_homes`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

CREATE TABLE `clientes` (
  `idCliente` int(5) NOT NULL,
  `Nombre` varchar(25) NOT NULL,
  `Apellido` varchar(25) NOT NULL,
  `FechaNaci` date NOT NULL,
  `Email` varchar(50) NOT NULL,
  `ContrasenaCliente` varchar(60) NOT NULL,
  `tipo_doc_id_tipoDoc` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `clientes`
--

INSERT INTO `clientes` (`idCliente`, `Nombre`, `Apellido`, `FechaNaci`, `Email`, `ContrasenaCliente`, `tipo_doc_id_tipoDoc`) VALUES
(28, 'Juan', 'Garcia', '2004-04-24', 'juan.huerfano9@soy.sena.edu.co', '$2y$10$LFlizyrCxQ81dQIvpG35q.Fq.o/C1S6Gm5opkIvlyKt8j0kz/UZKS', 'C.C'),
(31, 'AMPARO', 'RODRIGUEZ', '1976-08-22', 'amparo.rodriguez@merquellantas.com', '$2y$10$zPGsSoHouBxET7azIU.vUuv0ZxIGDkHmSMDA79GN9qtamftTZgoDa', 'C.C'),
(32, 'Adrian', 'regay', '2007-07-01', 'ANDREINA@GMAIL.COM', '$2y$10$CAZRkHG4bEFO83BpZjtmOOPs4O0UzySjB/ZfGc4ImcCx4qgiseWeq', 'C.E');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `contacto`
--

CREATE TABLE `contacto` (
  `id_Contacto` int(5) NOT NULL,
  `EmailCliente` varchar(50) NOT NULL,
  `TelefonoCliente` int(10) NOT NULL,
  `FechaContacto` datetime NOT NULL,
  `clientes_idCliente` int(5) NOT NULL,
  `id_inmueble` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `documentos`
--

CREATE TABLE `documentos` (
  `idDocumentos` int(5) NOT NULL,
  `doc` longblob NOT NULL,
  `id_estado` tinyint(1) NOT NULL,
  `FechaCarga` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `doc_cliente`
--

CREATE TABLE `doc_cliente` (
  `clientes_idCliente` int(5) NOT NULL,
  `documentos_idDocumentos` int(5) NOT NULL,
  `Fecha` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estado`
--

CREATE TABLE `estado` (
  `id_estado` tinyint(10) NOT NULL,
  `Descripcion` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `estado`
--

INSERT INTO `estado` (`id_estado`, `Descripcion`) VALUES
(1, 'DISPONIBLE'),
(2, 'NO DISPONIBLE');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inmobiliaria`
--

CREATE TABLE `inmobiliaria` (
  `idInmobiliaria` int(5) NOT NULL,
  `NombreInmobiliaria` varchar(40) NOT NULL,
  `EmailInmobiliaria` varchar(50) NOT NULL,
  `Telefono` int(10) NOT NULL,
  `Direccion` varchar(10) NOT NULL,
  `ContrasenaInmobiliaria` varchar(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `inmobiliaria`
--

INSERT INTO `inmobiliaria` (`idInmobiliaria`, `NombreInmobiliaria`, `EmailInmobiliaria`, `Telefono`, `Direccion`, `ContrasenaInmobiliaria`) VALUES
(4, 'Amarillo', 'hdsuadu@gmail.com', 31232, 'ckckl', '1234'),
(5, 'bogota', 'amdirs@hotmail.com', 2147483647, 'cl 9 No98', '1234'),
(6, 'Castilla', 'CastillaInm@gmail.com', 2147483647, 'CRA 74 163', '1234'),
(7, 'AMARILO', 'AMARILOInm@gmail.com', 2147483647, 'CRA 74 163', '1234'),
(8, 'AMARILO', 'CastillaInm@gmail.com', 2147483647, 'CRA 74 163', '1234'),
(9, 'CAASASSS', 'CASITASInm@gmail.com', 2147483647, 'CRA 74 163', '$2y$'),
(10, 'CAASASSS', 'CASITASInm@gmail.com', 2147483647, 'CRA 74 163', '$2y$'),
(11, 'CAASASSS', 'CASITASInm@gmail.com', 2147483647, 'CRA 74 163', '$2y$'),
(12, 'TINTAL', 'tintalitoInm@gmail.com', 300000, 'CRA 74 163', '$2y$'),
(13, 'TINTAL', 'tintalitoInm@gmail.com', 2147483647, 'CRA 74 163', '$2y$'),
(14, 'TINTAL', 'tintalitoInm@gmail.com', 2147483647, 'CRA 74 163', '$2y$');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inmueble`
--

CREATE TABLE `inmueble` (
  `idInmueble` int(5) NOT NULL,
  `Nombre` varchar(100) NOT NULL,
  `imagen` longblob NOT NULL,
  `Descripcion` varchar(50) NOT NULL,
  `localidad` varchar(50) NOT NULL,
  `Direccion` varchar(10) NOT NULL,
  `NumCont` int(10) NOT NULL,
  `precio` int(20) NOT NULL,
  `FechaPubli` date NOT NULL,
  `transaccion_idtransaccion` tinyint(4) NOT NULL,
  `estado_id_estado` tinyint(1) NOT NULL,
  `inmobiliaria_idInmobiliaria` int(5) NOT NULL,
  `tipo_idtipo` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `password_resets`
--

CREATE TABLE `password_resets` (
  `id_password` int(5) NOT NULL,
  `CorreoElectronico` varchar(25) NOT NULL,
  `codigo` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `clientes_idCliente` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo`
--

CREATE TABLE `tipo` (
  `idtipo` tinyint(4) NOT NULL,
  `Descripcion` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `tipo`
--

INSERT INTO `tipo` (`idtipo`, `Descripcion`) VALUES
(1, 'CASA'),
(2, 'APARTAMENTO');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_doc`
--

CREATE TABLE `tipo_doc` (
  `id_tipoDoc` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tipo_doc`
--

INSERT INTO `tipo_doc` (`id_tipoDoc`) VALUES
('C.C'),
('C.E');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `transaccion`
--

CREATE TABLE `transaccion` (
  `idtransaccion` tinyint(4) NOT NULL,
  `Descripcion` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `transaccion`
--

INSERT INTO `transaccion` (`idtransaccion`, `Descripcion`) VALUES
(1, 'VENTA'),
(2, 'RENTA');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`idCliente`),
  ADD KEY `fk_clientes_tipo_doc1_idx` (`tipo_doc_id_tipoDoc`);

--
-- Indices de la tabla `contacto`
--
ALTER TABLE `contacto`
  ADD PRIMARY KEY (`id_Contacto`,`clientes_idCliente`),
  ADD KEY `fk_contacto_clientes1_idx` (`clientes_idCliente`),
  ADD KEY `id_inmueble` (`id_inmueble`);

--
-- Indices de la tabla `documentos`
--
ALTER TABLE `documentos`
  ADD PRIMARY KEY (`idDocumentos`),
  ADD UNIQUE KEY `id_estado` (`id_estado`);

--
-- Indices de la tabla `doc_cliente`
--
ALTER TABLE `doc_cliente`
  ADD PRIMARY KEY (`clientes_idCliente`,`documentos_idDocumentos`),
  ADD KEY `fk_Doc_Cliente_documentos1_idx` (`documentos_idDocumentos`);

--
-- Indices de la tabla `estado`
--
ALTER TABLE `estado`
  ADD PRIMARY KEY (`id_estado`);

--
-- Indices de la tabla `inmobiliaria`
--
ALTER TABLE `inmobiliaria`
  ADD PRIMARY KEY (`idInmobiliaria`);

--
-- Indices de la tabla `inmueble`
--
ALTER TABLE `inmueble`
  ADD PRIMARY KEY (`idInmueble`,`estado_id_estado`,`tipo_idtipo`),
  ADD KEY `fk_inmueble_transaccion1_idx` (`transaccion_idtransaccion`),
  ADD KEY `fk_inmueble_estado1_idx` (`estado_id_estado`),
  ADD KEY `fk_inmueble_inmobiliaria1_idx` (`inmobiliaria_idInmobiliaria`),
  ADD KEY `fk_inmueble_tipo1_idx` (`tipo_idtipo`);

--
-- Indices de la tabla `password_resets`
--
ALTER TABLE `password_resets`
  ADD PRIMARY KEY (`id_password`),
  ADD KEY `fk_password_resets_clientes1_idx` (`clientes_idCliente`);

--
-- Indices de la tabla `tipo`
--
ALTER TABLE `tipo`
  ADD PRIMARY KEY (`idtipo`);

--
-- Indices de la tabla `tipo_doc`
--
ALTER TABLE `tipo_doc`
  ADD PRIMARY KEY (`id_tipoDoc`);

--
-- Indices de la tabla `transaccion`
--
ALTER TABLE `transaccion`
  ADD PRIMARY KEY (`idtransaccion`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `clientes`
--
ALTER TABLE `clientes`
  MODIFY `idCliente` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT de la tabla `inmobiliaria`
--
ALTER TABLE `inmobiliaria`
  MODIFY `idInmobiliaria` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de la tabla `inmueble`
--
ALTER TABLE `inmueble`
  MODIFY `idInmueble` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD CONSTRAINT `fk_clientes_tipo_doc1` FOREIGN KEY (`tipo_doc_id_tipoDoc`) REFERENCES `tipo_doc` (`id_tipoDoc`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `contacto`
--
ALTER TABLE `contacto`
  ADD CONSTRAINT `contacto_ibfk_1` FOREIGN KEY (`id_inmueble`) REFERENCES `inmueble` (`idInmueble`),
  ADD CONSTRAINT `fk_contacto_clientes1` FOREIGN KEY (`clientes_idCliente`) REFERENCES `clientes` (`idCliente`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Filtros para la tabla `documentos`
--
ALTER TABLE `documentos`
  ADD CONSTRAINT `documentos_ibfk_1` FOREIGN KEY (`id_estado`) REFERENCES `estado` (`id_estado`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `doc_cliente`
--
ALTER TABLE `doc_cliente`
  ADD CONSTRAINT `fk_Doc_Cliente_clientes1` FOREIGN KEY (`clientes_idCliente`) REFERENCES `clientes` (`idCliente`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_Doc_Cliente_documentos1` FOREIGN KEY (`documentos_idDocumentos`) REFERENCES `documentos` (`idDocumentos`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `inmueble`
--
ALTER TABLE `inmueble`
  ADD CONSTRAINT `fk_inmueble_estado1` FOREIGN KEY (`estado_id_estado`) REFERENCES `estado` (`id_estado`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_inmueble_inmobiliaria1` FOREIGN KEY (`inmobiliaria_idInmobiliaria`) REFERENCES `inmobiliaria` (`idInmobiliaria`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_inmueble_tipo1` FOREIGN KEY (`tipo_idtipo`) REFERENCES `tipo` (`idtipo`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_inmueble_transaccion1` FOREIGN KEY (`transaccion_idtransaccion`) REFERENCES `transaccion` (`idtransaccion`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `password_resets`
--
ALTER TABLE `password_resets`
  ADD CONSTRAINT `fk_password_resets_clientes1` FOREIGN KEY (`clientes_idCliente`) REFERENCES `clientes` (`idCliente`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
