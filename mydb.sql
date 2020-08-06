-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 10-03-2020 a las 20:19:23
-- Versión del servidor: 10.4.11-MariaDB
-- Versión de PHP: 7.4.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `mydb`
--

DELIMITER $$
--
-- Procedimientos
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_DEPARTAMENTO` (IN `nombredepto` VARCHAR(45), IN `idDepto` VARCHAR(45), IN `accion` VARCHAR(30), OUT `codeMessage` INT, OUT `message` VARCHAR(100))  SP:BEGIN
	DECLARE conteo INT;
	DECLARE tempMensaje	VARCHAR(100);
	SET autocommit=0;  
	SET tempMensaje='';
	START TRANSACTION;	
	IF nombredepto='' THEN
		SET tempMensaje='Departamento ,';
	END IF;
	IF tempMensaje<>'' THEN
		SET message=CONCAT('Campos requeridos',tempMensaje);
		SET codeMessage=1;
		LEAVE SP;
	END IF;
	SELECT count(*) INTO conteo FROM deptos
	WHERE nombre=nombredepto;

	IF accion="Agregar" THEN
		IF conteo=1 THEN
			SET message=CONCAT('El departamento ya existe, depto enviado:',nombredepto);
			SET codeMessage=1;
			LEAVE SP;
		END IF;

		INSERT INTO `deptos`(`nombre`) VALUES (nombredepto);
		SET message='Depto agregado correctamente';
		SET codeMessage=0;
		COMMIT;
	END IF;

	IF accion="Eliminar" THEN
		IF idDepto='' THEN
		SET tempMensaje='id departamento ,';
		END IF;
		IF tempMensaje<>'' THEN
			SET message=CONCAT('Campos requeridos',tempMensaje);
			SET codeMessage=1;
			LEAVE SP;
		END IF;

		SELECT count(*) INTO conteo FROM deptos
		WHERE idDeptos=idDepto;
		IF conteo=0 THEN
			SET message=CONCAT('El departamento no existe, depto enviado:',nombredepto);
			SET codeMessage=1;
			LEAVE SP;
		END IF;

		DELETE FROM `deptos` WHERE nombre=nombredepto;
		SET message='Depto eliminado correctamente';
		SET codeMessage=0;
		COMMIT;
	END IF;

	IF accion="Editar" THEN
		IF idDepto='' THEN
		SET tempMensaje='id departamento ,';
		END IF;
		IF tempMensaje<>'' THEN
			SET message=CONCAT('Campos requeridos',tempMensaje);
			SET codeMessage=1;
			LEAVE SP;
		END IF;

		SELECT count(*) INTO conteo FROM deptos
		WHERE idDeptos=idDepto;
		IF conteo=0 THEN
			SET message=CONCAT('El departamento no existe, depto enviado:',nombredepto);
			SET codeMessage=1;
			LEAVE SP;
		END IF;

		UPDATE `deptos` SET `nombre`=nombredepto WHERE idDeptos=idDepto;
		SET message='Depto actualizado correctamente';
		SET codeMessage=0;
		COMMIT;
	END IF;

	IF accion="Buscar" THEN
		IF conteo=0 THEN
			SET message=CONCAT('El departamento no existe, depto enviado:',nombredepto);
			SET codeMessage=1;
			LEAVE SP;
		END IF;

		SET message='Depto encontrado correctamente';
		SET codeMessage=0;
		COMMIT;
	END IF;
		

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_LOGIN` (IN `pcorreo` VARCHAR(50), IN `pcontrasenia` VARCHAR(50), OUT `pid` INT, OUT `mensaje` VARCHAR(100), OUT `existe` INT, OUT `contrasenaCorrecta` INT)  SP:BEGIN
  DECLARE conteo INT;
  DECLARE contra INT;
  DECLARE id INT;
  DECLARE tempMensaje VARCHAR(100);
  SET id=0;  
  SET tempMensaje = '';


  START TRANSACTION;  
  IF pcorreo=''  THEN
    SET tempMensaje='Correo ,';
  END IF;
  IF pcontrasenia='' THEN
    SET tempMensaje='Contrasenia ,';
  END IF;
  IF tempMensaje<>'' THEN
    SET mensaje=CONCAT('Campos requeridos ',tempMensaje);
    LEAVE SP;
  END IF;
  
  SELECT count(*) INTO conteo FROM persona
  WHERE correo=pcorreo;

  IF conteo=0 THEN
    SET mensaje='No existe usuario registrado con ese correo';
    SET existe=0;
    SET contrasenaCorrecta =0;
    LEAVE SP;
  END IF; 

  SELECT COUNT(*) INTO conteo FROM `persona`
  WHERE correo=pcorreo and contrasenia=pcontrasenia;

  IF conteo=0 THEN
    SET mensaje='Contrasena invalida';
    SET existe=1;
    SET contrasenaCorrecta = 0;
    LEAVE SP;
  END IF;  
  IF conteo=1 THEN
    SELECT idPersona INTO id FROM `persona` WHERE correo=pcorreo;
    SET mensaje='Usuario registrado';
    SET existe=1;
    SET pid=id;
    SET contrasenaCorrecta = 1;

    COMMIT;
  END IF;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_REGISTRO_USUARIO` (IN `ppNombre` VARCHAR(50), IN `psNombre` VARCHAR(50), IN `ppApellido` VARCHAR(50), IN `psApellido` VARCHAR(50), IN `pid` INT, IN `pcorreo` VARCHAR(50), IN `pcontrasenia` VARCHAR(50), IN `pfechaNac` DATETIME, IN `pfoto` VARCHAR(100), IN `ptipoUsuario` INT, IN `ptelefono` VARCHAR(50), IN `pmunicipio` INT, IN `pdepto` INT, IN `pestado` VARCHAR(50), OUT `mensaje` VARCHAR(100))  SP:BEGIN
  DECLARE conteo INT;
  DECLARE id INT;
  DECLARE tempMensaje VARCHAR(100);
  SET autocommit=0;  
  SET tempMensaje='';
  START TRANSACTION;  
  IF ppNombre='' or psNombre='' THEN
    SET tempMensaje='Nombre ,';
  END IF;
  IF ppApellido='' or psApellido THEN
    SET tempMensaje='Apellidos ,';
  END IF;
  IF pcorreo='' THEN
    SET tempMensaje='Correo ,';
  END IF;
  IF pcontrasenia='' THEN
    SET tempMensaje='Contrasenia ,';
  END IF;
  IF pfechaNac='' THEN
    SET tempMensaje='Fecha nacimiento ,';
  END IF;
  IF ptipoUsuario='' THEN
    SET tempMensaje='Tipo usuario ,';
  END IF;
  IF ptelefono='' THEN
    SET tempMensaje='Telefono ,';
  END IF;
  IF pmunicipio='' THEN
    SET tempMensaje='Municipio ,';
  END IF;
  IF pdepto='' THEN
    SET tempMensaje='Departamento ,';
  END IF;
  IF pestado='' THEN
    SET tempMensaje='Estado ,';
  END IF;

  IF tempMensaje<>'' THEN
    SET mensaje=CONCAT('Campos requeridos ',tempMensaje);
    LEAVE SP;
  END IF;
  
  SELECT count(*) INTO conteo FROM persona
  WHERE correo=pcorreo;

  IF conteo=0 THEN
    SELECT COUNT(idPersona) into id FROM `persona`;

    SET pid=id+1; 
    insert into `persona` (`idPersona`, `primerNombre`, `segundoNombre`, `primerApellido`, `segundoApellido`, `correo`, `fechaNac`, `contrasenia`, `idTipoUsuario`, `idMunicipio`, `estado`) 
    values(pid, ppNombre, psNombre, ppApellido, psApellido, pcorreo, pfechaNac, pcontrasenia, PtipoUsuario, pMunicipio, pestado);
    SET mensaje='Registro exitoso';
    COMMIT;
  ELSE
    SET mensaje='Ya existe usuario registrado con ese correo';
  END IF;  
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `anuncios`
--

CREATE TABLE `anuncios` (
  `idAnuncios` int(11) NOT NULL,
  `titulo` varchar(45) DEFAULT NULL,
  `descripcion` varchar(45) DEFAULT NULL,
  `precio` double DEFAULT NULL,
  `idPersona` int(11) NOT NULL,
  `idMoneda` int(11) NOT NULL,
  `idProducto` int(11) NOT NULL,
  `estado` varchar(2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `anuncios`
--

INSERT INTO `anuncios` (`idAnuncios`, `titulo`, `descripcion`, `precio`, `idPersona`, `idMoneda`, `idProducto`, `estado`) VALUES
(1, 'Motor xxx20', 'Venta de motor xxx20 para modelos xxx30', 2000, 1, 1, 1, 'a');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `calificacion`
--

CREATE TABLE `calificacion` (
  `idCalificacion` int(11) NOT NULL,
  `pubCalificada` int(11) DEFAULT NULL,
  `puntuacion` varchar(45) DEFAULT NULL,
  `razones` varchar(45) DEFAULT NULL,
  `idAnuncios` int(11) NOT NULL,
  `estado` varchar(2) DEFAULT NULL,
  `nombre` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE `categorias` (
  `idCategorias` int(11) NOT NULL,
  `descripcion` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`idCategorias`, `descripcion`) VALUES
(1, 'Automoviles'),
(2, 'Mobiliario de casa'),
(3, 'Jardineria'),
(4, 'Jardineria');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `denuncias`
--

CREATE TABLE `denuncias` (
  `idDenuncias` int(11) NOT NULL,
  `fecha` datetime DEFAULT NULL,
  `pubDenunciada` int(11) DEFAULT NULL,
  `razones` varchar(45) DEFAULT NULL,
  `idAnuncios` int(11) NOT NULL,
  `estado` varchar(2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `denuncias`
--

INSERT INTO `denuncias` (`idDenuncias`, `fecha`, `pubDenunciada`, `razones`, `idAnuncios`, `estado`) VALUES
(1, '2020-03-10 08:18:46', NULL, 'Producto en mal estado', 1, 'a');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `deptos`
--

CREATE TABLE `deptos` (
  `idDeptos` int(11) NOT NULL,
  `nombre` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `deptos`
--

INSERT INTO `deptos` (`idDeptos`, `nombre`) VALUES
(1, 'Francisco Morazan');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `enlaces_compartidos`
--

CREATE TABLE `enlaces_compartidos` (
  `idEnlace` int(11) NOT NULL,
  `descripcion` varchar(45) DEFAULT NULL,
  `redSocial` varchar(45) DEFAULT NULL,
  `cantidadEnlaces` int(11) DEFAULT NULL,
  `idAnuncios` int(11) NOT NULL,
  `estado` varchar(2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `favoritos`
--

CREATE TABLE `favoritos` (
  `idFavoritos` int(11) NOT NULL,
  `idAnuncios` int(11) NOT NULL,
  `estado` varchar(2) DEFAULT NULL,
  `idPersona` int(11) NOT NULL,
  `cantidad` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fotosanuncio`
--

CREATE TABLE `fotosanuncio` (
  `idFotos` int(11) NOT NULL,
  `cantidad` int(11) DEFAULT NULL,
  `urlFoto` varchar(45) DEFAULT NULL,
  `idAnuncios` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fotosusuario`
--

CREATE TABLE `fotosusuario` (
  `idFotos` int(11) NOT NULL,
  `urlFoto` varchar(45) DEFAULT NULL,
  `idPersona` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mensajes`
--

CREATE TABLE `mensajes` (
  `idMensajes` int(11) NOT NULL,
  `correo` varchar(45) DEFAULT NULL,
  `telefono` varchar(45) DEFAULT NULL,
  `descripcion` varchar(45) DEFAULT NULL,
  `nombre` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `moneda`
--

CREATE TABLE `moneda` (
  `idMoneda` int(11) NOT NULL,
  `descripcion` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `moneda`
--

INSERT INTO `moneda` (`idMoneda`, `descripcion`) VALUES
(1, 'Lempiras'),
(2, 'Dolares');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `municipio`
--

CREATE TABLE `municipio` (
  `idMunicipio` int(11) NOT NULL,
  `nombre` varchar(45) DEFAULT NULL,
  `idDeptos` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `municipio`
--

INSERT INTO `municipio` (`idMunicipio`, `nombre`, `idDeptos`) VALUES
(1, 'Guaimaca', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `notificaciones`
--

CREATE TABLE `notificaciones` (
  `idNotificaciones` int(11) NOT NULL,
  `cantidad` int(11) DEFAULT NULL,
  `descripcion` varchar(45) DEFAULT NULL,
  `idMensajes` int(11) NOT NULL,
  `idAnuncios` int(11) NOT NULL,
  `estado` varchar(2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `persona`
--

CREATE TABLE `persona` (
  `idPersona` int(11) NOT NULL,
  `primerNombre` varchar(45) DEFAULT NULL,
  `segundoNombre` varchar(45) DEFAULT NULL,
  `primerApellido` varchar(45) DEFAULT NULL,
  `segundoApellido` varchar(45) DEFAULT NULL,
  `correo` varchar(45) DEFAULT NULL,
  `fechaNac` datetime DEFAULT NULL,
  `contrasenia` varchar(45) DEFAULT NULL,
  `idTipoUsuario` int(11) NOT NULL,
  `idMunicipio` int(11) NOT NULL,
  `estado` varchar(2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `persona`
--

INSERT INTO `persona` (`idPersona`, `primerNombre`, `segundoNombre`, `primerApellido`, `segundoApellido`, `correo`, `fechaNac`, `contrasenia`, `idTipoUsuario`, `idMunicipio`, `estado`) VALUES
(1, 'Diego', 'Jose', 'Cardona', 'Sevilla', 'sevilla@gmail.com', '2020-02-13 21:29:27', '12345', 1, 1, 'a');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto`
--

CREATE TABLE `producto` (
  `idProducto` int(11) NOT NULL,
  `nombre` varchar(45) DEFAULT NULL,
  `estado` varchar(2) DEFAULT NULL,
  `caracteristicas` varchar(45) DEFAULT NULL,
  `idCategorias` int(11) NOT NULL,
  `tipoProducto` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `producto`
--

INSERT INTO `producto` (`idProducto`, `nombre`, `estado`, `caracteristicas`, `idCategorias`, `tipoProducto`) VALUES
(1, 'Motor', 'a', 'Modelo xxx20', 1, 'xxxx');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reportes`
--

CREATE TABLE `reportes` (
  `idReporte` int(11) NOT NULL,
  `descripcion` varchar(300) DEFAULT NULL,
  `idDenuncia` int(11) NOT NULL,
  `idUsuarios` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `telefono`
--

CREATE TABLE `telefono` (
  `idTelefono` int(11) NOT NULL,
  `telefono` int(11) DEFAULT NULL,
  `idPersona` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipousuario`
--

CREATE TABLE `tipousuario` (
  `idTipoUsuario` int(11) NOT NULL,
  `descripcion` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `tipousuario`
--

INSERT INTO `tipousuario` (`idTipoUsuario`, `descripcion`) VALUES
(1, 'Empresa');

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vistadeptos`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `vistadeptos` (
`idDeptos` int(11)
,`nombre` varchar(45)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vistamunicipios`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `vistamunicipios` (
`idMunicipio` int(11)
,`nombre` varchar(45)
,`idDeptos` int(11)
);

-- --------------------------------------------------------

--
-- Estructura para la vista `vistadeptos`
--
DROP TABLE IF EXISTS `vistadeptos`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vistadeptos`  AS  select `deptos`.`idDeptos` AS `idDeptos`,`deptos`.`nombre` AS `nombre` from `deptos` ;

-- --------------------------------------------------------

--
-- Estructura para la vista `vistamunicipios`
--
DROP TABLE IF EXISTS `vistamunicipios`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vistamunicipios`  AS  select `municipio`.`idMunicipio` AS `idMunicipio`,`municipio`.`nombre` AS `nombre`,`municipio`.`idDeptos` AS `idDeptos` from `municipio` ;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `anuncios`
--
ALTER TABLE `anuncios`
  ADD PRIMARY KEY (`idAnuncios`),
  ADD KEY `fk_Anuncios_Persona1_idx` (`idPersona`),
  ADD KEY `fk_Anuncios_Moneda1_idx` (`idMoneda`),
  ADD KEY `fk_Anuncios_Producto1_idx` (`idProducto`);

--
-- Indices de la tabla `calificacion`
--
ALTER TABLE `calificacion`
  ADD PRIMARY KEY (`idCalificacion`),
  ADD KEY `fk_Calificacion_Anuncios1_idx` (`idAnuncios`),
  ADD KEY `fk_Calificacion_Persona1_idx` (`nombre`);

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`idCategorias`);

--
-- Indices de la tabla `denuncias`
--
ALTER TABLE `denuncias`
  ADD PRIMARY KEY (`idDenuncias`),
  ADD KEY `fk_Denuncias_Anuncios1_idx` (`idAnuncios`);

--
-- Indices de la tabla `deptos`
--
ALTER TABLE `deptos`
  ADD PRIMARY KEY (`idDeptos`);

--
-- Indices de la tabla `enlaces_compartidos`
--
ALTER TABLE `enlaces_compartidos`
  ADD PRIMARY KEY (`idEnlace`),
  ADD KEY `fk_Enlaces_Compartidos_Anuncios1_idx` (`idAnuncios`);

--
-- Indices de la tabla `favoritos`
--
ALTER TABLE `favoritos`
  ADD PRIMARY KEY (`idFavoritos`),
  ADD KEY `fk_Favoritos_Anuncios1_idx` (`idAnuncios`),
  ADD KEY `fk_Favoritos_Persona1_idx` (`idPersona`);

--
-- Indices de la tabla `fotosanuncio`
--
ALTER TABLE `fotosanuncio`
  ADD PRIMARY KEY (`idFotos`),
  ADD KEY `fk_Fotos_Anuncios1_idx` (`idAnuncios`);

--
-- Indices de la tabla `fotosusuario`
--
ALTER TABLE `fotosusuario`
  ADD PRIMARY KEY (`idFotos`),
  ADD KEY `fk_FotosUsuario_Persona1_idx` (`idPersona`);

--
-- Indices de la tabla `mensajes`
--
ALTER TABLE `mensajes`
  ADD PRIMARY KEY (`idMensajes`),
  ADD KEY `fk_Mensajes_Persona1_idx` (`nombre`);

--
-- Indices de la tabla `moneda`
--
ALTER TABLE `moneda`
  ADD PRIMARY KEY (`idMoneda`);

--
-- Indices de la tabla `municipio`
--
ALTER TABLE `municipio`
  ADD PRIMARY KEY (`idMunicipio`),
  ADD KEY `fk_Municipio_Deptos1_idx` (`idDeptos`);

--
-- Indices de la tabla `notificaciones`
--
ALTER TABLE `notificaciones`
  ADD PRIMARY KEY (`idNotificaciones`),
  ADD KEY `fk_Notificaciones_Mensajes1_idx` (`idMensajes`),
  ADD KEY `fk_Notificaciones_Anuncios1_idx` (`idAnuncios`);

--
-- Indices de la tabla `persona`
--
ALTER TABLE `persona`
  ADD PRIMARY KEY (`idPersona`),
  ADD KEY `fk_Persona_TipoUsuario1_idx` (`idTipoUsuario`),
  ADD KEY `fk_Persona_Municipio1_idx` (`idMunicipio`);

--
-- Indices de la tabla `producto`
--
ALTER TABLE `producto`
  ADD PRIMARY KEY (`idProducto`),
  ADD KEY `fk_Producto_Categorias1_idx` (`idCategorias`);

--
-- Indices de la tabla `reportes`
--
ALTER TABLE `reportes`
  ADD PRIMARY KEY (`idReporte`),
  ADD KEY `idDenuncia` (`idDenuncia`),
  ADD KEY `idUsuarios` (`idUsuarios`);

--
-- Indices de la tabla `telefono`
--
ALTER TABLE `telefono`
  ADD PRIMARY KEY (`idTelefono`),
  ADD KEY `fk_Telefono_Persona_idx` (`idPersona`);

--
-- Indices de la tabla `tipousuario`
--
ALTER TABLE `tipousuario`
  ADD PRIMARY KEY (`idTipoUsuario`);

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `anuncios`
--
ALTER TABLE `anuncios`
  ADD CONSTRAINT `fk_Anuncios_Moneda1` FOREIGN KEY (`idMoneda`) REFERENCES `moneda` (`idMoneda`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_Anuncios_Persona1` FOREIGN KEY (`idPersona`) REFERENCES `persona` (`idPersona`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_Anuncios_Producto1` FOREIGN KEY (`idProducto`) REFERENCES `producto` (`idProducto`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `calificacion`
--
ALTER TABLE `calificacion`
  ADD CONSTRAINT `fk_Calificacion_Anuncios1` FOREIGN KEY (`idAnuncios`) REFERENCES `anuncios` (`idAnuncios`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_Calificacion_Persona1` FOREIGN KEY (`nombre`) REFERENCES `persona` (`idPersona`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `denuncias`
--
ALTER TABLE `denuncias`
  ADD CONSTRAINT `fk_Denuncias_Anuncios1` FOREIGN KEY (`idAnuncios`) REFERENCES `anuncios` (`idAnuncios`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `enlaces_compartidos`
--
ALTER TABLE `enlaces_compartidos`
  ADD CONSTRAINT `fk_Enlaces_Compartidos_Anuncios1` FOREIGN KEY (`idAnuncios`) REFERENCES `anuncios` (`idAnuncios`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `favoritos`
--
ALTER TABLE `favoritos`
  ADD CONSTRAINT `fk_Favoritos_Anuncios1` FOREIGN KEY (`idAnuncios`) REFERENCES `anuncios` (`idAnuncios`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_Favoritos_Persona1` FOREIGN KEY (`idPersona`) REFERENCES `persona` (`idPersona`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `fotosanuncio`
--
ALTER TABLE `fotosanuncio`
  ADD CONSTRAINT `fk_Fotos_Anuncios1` FOREIGN KEY (`idAnuncios`) REFERENCES `anuncios` (`idAnuncios`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `fotosusuario`
--
ALTER TABLE `fotosusuario`
  ADD CONSTRAINT `fk_FotosUsuario_Persona1` FOREIGN KEY (`idPersona`) REFERENCES `persona` (`idPersona`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `mensajes`
--
ALTER TABLE `mensajes`
  ADD CONSTRAINT `fk_Mensajes_Persona1` FOREIGN KEY (`nombre`) REFERENCES `persona` (`idPersona`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `municipio`
--
ALTER TABLE `municipio`
  ADD CONSTRAINT `fk_Municipio_Deptos1` FOREIGN KEY (`idDeptos`) REFERENCES `deptos` (`idDeptos`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `notificaciones`
--
ALTER TABLE `notificaciones`
  ADD CONSTRAINT `fk_Notificaciones_Anuncios1` FOREIGN KEY (`idAnuncios`) REFERENCES `anuncios` (`idAnuncios`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_Notificaciones_Mensajes1` FOREIGN KEY (`idMensajes`) REFERENCES `mensajes` (`idMensajes`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `persona`
--
ALTER TABLE `persona`
  ADD CONSTRAINT `fk_Persona_Municipio1` FOREIGN KEY (`idMunicipio`) REFERENCES `municipio` (`idMunicipio`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_Persona_TipoUsuario1` FOREIGN KEY (`idTipoUsuario`) REFERENCES `tipousuario` (`idTipoUsuario`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `producto`
--
ALTER TABLE `producto`
  ADD CONSTRAINT `fk_Producto_Categorias1` FOREIGN KEY (`idCategorias`) REFERENCES `categorias` (`idCategorias`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `telefono`
--
ALTER TABLE `telefono`
  ADD CONSTRAINT `fk_Telefono_Persona` FOREIGN KEY (`idPersona`) REFERENCES `persona` (`idPersona`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
