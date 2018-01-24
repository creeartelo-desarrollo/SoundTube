-- phpMyAdmin SQL Dump
-- version 4.7.3
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 25-09-2017 a las 15:58:31
-- Versión del servidor: 5.5.56-cll-lve
-- Versión de PHP: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `soundtub_sitio`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Cat_Roles`
--

CREATE TABLE `Cat_Roles` (
  `Id_Rol` int(11) NOT NULL,
  `Nombre` varchar(50) NOT NULL,
  `Descripcion` varchar(200) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `Cat_Roles`
--

INSERT INTO `Cat_Roles` (`Id_Rol`, `Nombre`, `Descripcion`) VALUES
(1, 'Administrador', 'Administrador');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Cat_Salas`
--

CREATE TABLE `Cat_Salas` (
  `Id_Cat_Sala` int(11) NOT NULL,
  `Nombre` varchar(100) DEFAULT NULL,
  `Abreviatura` varchar(10) DEFAULT NULL,
  `Descripcion` tinytext
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Estructura de tabla para la tabla `Cat_Secciones`
--

CREATE TABLE `Cat_Secciones` (
  `Id_Seccion` int(11) NOT NULL,
  `Nombre` varchar(50) NOT NULL,
  `Abreviatura` varchar(10) NOT NULL,
  `Descripcion` varchar(200) DEFAULT NULL,
  `Nivel` int(11) NOT NULL,
  `Id_Padre` int(11) NOT NULL,
  `Orden` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;


--
-- Estructura de tabla para la tabla `Cat_Tipo_Evento`
--

CREATE TABLE `Cat_Tipo_Evento` (
  `Id_Cat_Tipo_Evento` int(11) NOT NULL,
  `Nombre` varchar(100) DEFAULT NULL,
  `Abreviatura` varchar(10) DEFAULT NULL,
  `Descripcion` tinytext,
  `Color` varchar(20) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Configuracion`
--

CREATE TABLE `Configuracion` (
  `Id_Configuracion` int(11) NOT NULL,
  `Abreviatura` varchar(10) NOT NULL,
  `Nombre` varchar(45) NOT NULL,
  `Valor` longtext,
  `Descripcion` longtext
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Contactos`
--

CREATE TABLE `Contactos` (
  `Id_Contacto` int(11) NOT NULL,
  `Correo_Electronico` varchar(150) NOT NULL,
  `Apellidos` varchar(150) NOT NULL,
  `Nombres` varchar(150) NOT NULL,
  `Fecha_Nacimiento` date DEFAULT NULL,
  `Genero` varchar(1) DEFAULT 'O',
  `Ruta_Imagen` varchar(300) DEFAULT NULL,
  `Contrasena` varchar(50) NOT NULL,
  `Estatus` tinyint(4) NOT NULL DEFAULT '0',
  `Origen` varchar(5) NOT NULL DEFAULT 'F',
  `Fecha_Registro` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Cotizaciones`
--

CREATE TABLE `Cotizaciones` (
  `Id_Cotizacion` int(11) NOT NULL,
  `Id_Contacto` int(11) NOT NULL,
  `Fecha` datetime NOT NULL,
  `Folio` varchar(15) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Cotizacion_Detalle`
--

CREATE TABLE `Cotizacion_Detalle` (
  `Id_Cotizacion_Detalle` int(11) NOT NULL,
  `Id_Cotizacion` int(11) NOT NULL,
  `Pregunta` longtext NOT NULL,
  `Remitente` char(1) NOT NULL,
  `Operacion` varchar(5) NOT NULL,
  `Tipo` varchar(45) NOT NULL,
  `Valor` varchar(200) NOT NULL,
  `Valor_2` varchar(200) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Datos_Promo`
--

CREATE TABLE `Datos_Promo` (
  `Id_Datos_Promo` int(11) NOT NULL,
  `Nombre` varchar(100) NOT NULL,
  `Correo_Electronico` varchar(100) NOT NULL,
  `No_Personas` int(11) NOT NULL DEFAULT '1',
  `Observaciones` varchar(5000) NOT NULL,
  `Formulario` tinyint(1) NOT NULL,
  `Fecha` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Empleados`
--

CREATE TABLE `Empleados` (
  `Id_Empleado` int(11) NOT NULL,
  `Id_Rol` int(11) NOT NULL,
  `Status` int(11) NOT NULL,
  `Ap_Paterno` varchar(45) NOT NULL,
  `Ap_Materno` varchar(45) DEFAULT NULL,
  `Nombres` varchar(50) NOT NULL,
  `Correo_Electronico` varchar(50) NOT NULL,
  `Contrasena` varchar(50) NOT NULL,
  `Ruta_Imagen` varchar(150) DEFAULT NULL,
  `Fecha_Alta` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Eventos`
--

CREATE TABLE `Eventos` (
  `Id_Evento` int(11) NOT NULL,
  `Id_Contacto` int(11) NOT NULL DEFAULT '0',
  `Nombre` varchar(300) NOT NULL,
  `Correo_Electronico` varchar(200) NOT NULL,
  `Telefono` varchar(45) NOT NULL,
  `Id_Cat_Sala` int(11) DEFAULT '0',
  `Id_Cat_Tipo_Evento` int(11) NOT NULL,
  `Fecha_Inicio` datetime NOT NULL,
  `Fecha_Fin` datetime NOT NULL,
  `Observaciones` mediumtext,
  `Fecha_Alta` datetime NOT NULL,
  `Status` tinyint(4) NOT NULL,
  `Confirmado` tinyint(4) NOT NULL DEFAULT '0',
  `Key` varchar(40) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Log`
--

CREATE TABLE `Log` (
  `Id_Log` int(11) NOT NULL,
  `Tabla` varchar(45) NOT NULL,
  `Id_Tipo_Rol` tinyint(4) NOT NULL,
  `Id_Usuario` int(11) NOT NULL,
  `Tipo_Ejecucion` varchar(45) NOT NULL,
  `Id_Referencia` int(11) NOT NULL,
  `Id_Referencia2` int(11) DEFAULT NULL,
  `Fecha_Ejecucion` datetime NOT NULL,
  `IP` varchar(20) DEFAULT NULL,
  `Navegador` varchar(20) DEFAULT NULL,
  `Version_Navegador` varchar(20) DEFAULT NULL,
  `Sistema_Operativo` varchar(20) DEFAULT NULL,
  `Descripcion` mediumtext
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Notificaciones`
--

CREATE TABLE `Notificaciones` (
  `Id_Notificacion` int(11) NOT NULL,
  `Id_Usuario` int(11) NOT NULL,
  `Id_Tipo_Usuario` char(1) NOT NULL,
  `Mensaje` mediumtext NOT NULL,
  `Fecha_Envio` datetime NOT NULL,
  `Leido` bit(1) NOT NULL DEFAULT b'0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Preguntas_Cotizador`
--

CREATE TABLE `Preguntas_Cotizador` (
  `Id_Pregunta_Cotizador` int(11) NOT NULL,
  `Pregunta` longtext NOT NULL,
  `Id_Pregunta_Hijo` int(11) NOT NULL DEFAULT '0',
  `Remitente` char(1) NOT NULL,
  `Valor` varchar(200) NOT NULL,
  `Minval` varchar(45) DEFAULT NULL,
  `Tipo` varchar(45) NOT NULL,
  `Grupo` int(11) NOT NULL,
  `Operacion` varchar(5) NOT NULL,
  `Notas` varchar(100) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Rel_Rol_Secciones`
--

CREATE TABLE `Rel_Rol_Secciones` (
  `Id_Rel_Rol_Secciones` int(11) NOT NULL,
  `Id_Rol` int(11) NOT NULL,
  `Id_Seccion` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Showroom`
--

CREATE TABLE `Showroom` (
  `Id_Showroom` int(11) NOT NULL,
  `Id_Video` varchar(45) NOT NULL,
  `Titulo` varchar(300) NOT NULL,
  `Ruta_Imagen` varchar(300) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Visitas`
--

CREATE TABLE `Visitas` (
  `Id_Visita` int(11) NOT NULL,
  `Visitante` varchar(45) DEFAULT NULL,
  `Fecha_Ejecucion` datetime NOT NULL,
  `IP` varchar(20) DEFAULT NULL,
  `Pais` varchar(150) DEFAULT NULL,
  `Codigo_Pais` varchar(10) DEFAULT NULL,
  `Region` varchar(150) DEFAULT NULL,
  `Ciudad` varchar(150) DEFAULT NULL,
  `Codigo_Postal` varchar(10) DEFAULT NULL,
  `Latitud` varchar(60) DEFAULT NULL,
  `Longitud` varchar(60) DEFAULT NULL,
  `Sistema_Operativo` varchar(20) DEFAULT NULL,
  `Navegador` varchar(20) DEFAULT NULL,
  `Version_Navegador` varchar(20) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;



--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `Cat_Roles`
--
ALTER TABLE `Cat_Roles`
  ADD PRIMARY KEY (`Id_Rol`),
  ADD UNIQUE KEY `Id_Rol_UNIQUE` (`Id_Rol`),
  ADD UNIQUE KEY `Nombre_UNIQUE` (`Nombre`);

--
-- Indices de la tabla `Cat_Salas`
--
ALTER TABLE `Cat_Salas`
  ADD PRIMARY KEY (`Id_Cat_Sala`),
  ADD UNIQUE KEY `Id_Cat_Salas_UNIQUE` (`Id_Cat_Sala`),
  ADD UNIQUE KEY `Abreviatura_UNIQUE` (`Abreviatura`),
  ADD UNIQUE KEY `Nombre_UNIQUE` (`Nombre`);

--
-- Indices de la tabla `Cat_Secciones`
--
ALTER TABLE `Cat_Secciones`
  ADD PRIMARY KEY (`Id_Seccion`),
  ADD UNIQUE KEY `Nombre_UNIQUE` (`Nombre`),
  ADD UNIQUE KEY `Abreviatura_UNIQUE` (`Abreviatura`);

--
-- Indices de la tabla `Cat_Tipo_Evento`
--
ALTER TABLE `Cat_Tipo_Evento`
  ADD PRIMARY KEY (`Id_Cat_Tipo_Evento`),
  ADD UNIQUE KEY `Id_Cat_Tipo_Evento_UNIQUE` (`Id_Cat_Tipo_Evento`),
  ADD UNIQUE KEY `Abreviatura_UNIQUE` (`Abreviatura`),
  ADD UNIQUE KEY `Nombre_UNIQUE` (`Nombre`);

--
-- Indices de la tabla `Configuracion`
--
ALTER TABLE `Configuracion`
  ADD PRIMARY KEY (`Id_Configuracion`),
  ADD UNIQUE KEY `Id_Configuracion_UNIQUE` (`Id_Configuracion`);

--
-- Indices de la tabla `Contactos`
--
ALTER TABLE `Contactos`
  ADD PRIMARY KEY (`Id_Contacto`),
  ADD UNIQUE KEY `Id_Contactos_UNIQUE` (`Id_Contacto`),
  ADD UNIQUE KEY `Correo_Electronico_UNIQUE` (`Correo_Electronico`);

--
-- Indices de la tabla `Cotizaciones`
--
ALTER TABLE `Cotizaciones`
  ADD PRIMARY KEY (`Id_Cotizacion`),
  ADD UNIQUE KEY `Id_Cotizacion_UNIQUE` (`Id_Cotizacion`);

--
-- Indices de la tabla `Cotizacion_Detalle`
--
ALTER TABLE `Cotizacion_Detalle`
  ADD PRIMARY KEY (`Id_Cotizacion_Detalle`),
  ADD UNIQUE KEY `Id_Cotizacion_Detalle_UNIQUE` (`Id_Cotizacion_Detalle`);

--
-- Indices de la tabla `Datos_Promo`
--
ALTER TABLE `Datos_Promo`
  ADD PRIMARY KEY (`Id_Datos_Promo`);

--
-- Indices de la tabla `Empleados`
--
ALTER TABLE `Empleados`
  ADD PRIMARY KEY (`Id_Empleado`),
  ADD UNIQUE KEY `Id_Usuario_UNIQUE` (`Id_Empleado`);

--
-- Indices de la tabla `Eventos`
--
ALTER TABLE `Eventos`
  ADD PRIMARY KEY (`Id_Evento`),
  ADD UNIQUE KEY `Id_Evento_UNIQUE` (`Id_Evento`);

--
-- Indices de la tabla `Log`
--
ALTER TABLE `Log`
  ADD PRIMARY KEY (`Id_Log`),
  ADD UNIQUE KEY `Id_Log_UNIQUE` (`Id_Log`);

--
-- Indices de la tabla `Notificaciones`
--
ALTER TABLE `Notificaciones`
  ADD PRIMARY KEY (`Id_Notificacion`),
  ADD UNIQUE KEY `Notificaciones_UNIQUE` (`Id_Notificacion`);

--
-- Indices de la tabla `Preguntas_Cotizador`
--
ALTER TABLE `Preguntas_Cotizador`
  ADD PRIMARY KEY (`Id_Pregunta_Cotizador`),
  ADD UNIQUE KEY `Id_Pregunta_Cotizador_UNIQUE` (`Id_Pregunta_Cotizador`);

--
-- Indices de la tabla `Rel_Rol_Secciones`
--
ALTER TABLE `Rel_Rol_Secciones`
  ADD PRIMARY KEY (`Id_Rel_Rol_Secciones`),
  ADD UNIQUE KEY `Id_Rel_Rol_Secciones_UNIQUE` (`Id_Rel_Rol_Secciones`);

--
-- Indices de la tabla `Showroom`
--
ALTER TABLE `Showroom`
  ADD PRIMARY KEY (`Id_Showroom`),
  ADD UNIQUE KEY `Id_Video_UNIQUE` (`Id_Video`);

--
-- Indices de la tabla `Visitas`
--
ALTER TABLE `Visitas`
  ADD PRIMARY KEY (`Id_Visita`),
  ADD UNIQUE KEY `Id_Visita_UNIQUE` (`Id_Visita`);
