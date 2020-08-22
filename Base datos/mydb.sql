-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 18-08-2020 a las 00:45:58
-- Versión del servidor: 5.7.31
-- Versión de PHP: 7.3.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
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
DROP PROCEDURE IF EXISTS `SP_AGREGAR_PUB`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_AGREGAR_PUB` (IN `nombreProducto` VARCHAR(200), IN `caracteristicas` VARCHAR(500), IN `idCategoria` INT, IN `ptipo` VARCHAR(50), IN `pprecio` INT, IN `pidPersona` INT, IN `pidMoneda` INT, IN `idAnuncio` INT, IN `url` VARCHAR(500), IN `accion` VARCHAR(100), OUT `mensaje` VARCHAR(100))  SP:BEGIN

  DECLARE idPro INT;
  DECLARE idAnu INT;
  DECLARE idUrl INT;
  DECLARE conteoU INT;
  DECLARE conteoP INT;
  DECLARE conteoA INT;
  DECLARE totalFotos INT;
  DECLARE tempMensaje VARCHAR(100);
  SET autocommit=0;  
  SET tempMensaje='';
  START TRANSACTION;  

  IF accion='' THEN
   SET tempMensaje='Accion ';
  END IF;  
  IF tempMensaje<>'' THEN
   SET mensaje=CONCAT('Campo requerido ',tempMensaje);
   LEAVE SP;
  END IF;

  IF accion="guardar" OR accion="editar" THEN
   IF nombreProducto='' THEN
       SET tempMensaje='Nombre, ';
   END IF;
   IF caracteristicas=''  THEN
       SET tempMensaje='Caracteristicas, ';
   END IF;
   IF idCategoria='' THEN
       SET tempMensaje='Categoria,';
   END IF;
   IF pprecio='' THEN
       SET tempMensaje='Precio ,';
   END IF;
   IF ptipo='' THEN
       SET tempMensaje='Tipo,';
   END IF;
   IF pidPersona='' THEN
       SET tempMensaje='Persona,';
   END IF;
   IF pidMoneda='' THEN
       SET tempMensaje='Moneda,';
   END IF;

   IF tempMensaje<>'' THEN
       SET mensaje=CONCAT('Campos requeridos ',tempMensaje);
       LEAVE SP;
   END IF;
  END IF;

  IF accion="eliminar" OR accion="editar" 
  OR accion="editarFoto" OR
  accion="obtenerFotos" OR accion="eliminarFoto"  THEN
        IF idAnuncio='' OR idAnuncio=0  THEN
          SET tempMensaje='Id Anuncio ';
        END IF; 
        IF tempMensaje<>'' THEN
          SET mensaje=CONCAT('Campo requerido ',tempMensaje);
          LEAVE SP;
        END IF;
  END IF;
  
IF accion="guardarFoto" OR accion="editarFoto"  THEN
        IF url='' THEN
          SET tempMensaje='URL Foto ';
        END IF; 
        IF tempMensaje<>'' THEN
          SET mensaje=CONCAT('Campo requerido ',tempMensaje);
          LEAVE SP;
        END IF;
  END IF;

  IF accion="obtenerAnuncio" THEN
    IF pidPersona='' OR pidPersona=0  THEN
      SET tempMensaje='Id Persona ';
    END IF; 
    IF tempMensaje<>'' THEN
      SET mensaje=CONCAT('Campo requerido ',tempMensaje);
      LEAVE SP;
    END IF;
  END IF;

  IF accion="guardar"  THEN
   SELECT count(*) INTO idPro FROM producto;
   SELECT count(*) INTO idAnu FROM anuncios;

   IF idPro=0 THEN
    SET conteoP=1;
   END IF;
   IF idAnu=0 THEN
    SET conteoA=1;
   END IF;
   IF idPro>0 AND idAnu>0 THEN
    SELECT MAX(idProducto) INTO idPro FROM producto;
    SELECT MAX(idAnuncios) INTO idAnu FROM anuncios;
    SET conteoP=idPro+1;
    SET conteoA=idAnu+1;
   END IF;

   INSERT INTO producto (idProducto, nombre, estado, caracteristicas, idCategorias, tipo) 
   VALUES(conteoP,nombreProducto, "A",caracteristicas, idCategoria, ptipo);

   INSERT INTO anuncios(idAnuncios,titulo,descripcion,precio,idPersona,idMoneda,idProducto,estado, fecha) 
   VALUES(conteoA,nombreProducto, caracteristicas, pprecio, pidPersona, pidMoneda, conteoP , "A",CURDATE());

   SET mensaje='Registro exitoso';
   COMMIT; 
  END IF; 
  
  IF accion="editar" THEN
   SELECT count(*) INTO conteoA FROM anuncios
   WHERE idAnuncios=idAnuncio;
   SELECT idProducto INTO conteoP FROM anuncios
   WHERE idAnuncios=idAnuncio;

   IF conteoA=0 THEN
    SET mensaje='No existe el anuncio';
    LEAVE SP;
   END IF;
   IF conteoA>0 THEN
    UPDATE anuncios SET titulo=nombreProducto,
    descripcion=caracteristicas,
    precio=pprecio,idMoneda=pidMoneda 
    WHERE idAnuncios=idAnuncio;

    UPDATE producto SET nombre=nombreProducto,
    caracteristicas=caracteristicas,
    idCategorias=idCategoria,tipo=ptipo 
    WHERE idProducto=conteoP;
    SET mensaje='Edicion exitosa';
    COMMIT;
   END IF;
  END IF;

  IF accion="eliminar" THEN

  IF caracteristicas='' THEN
    SET tempMensaje='Razon de eliminar Anuncio.';
  END IF; 
  IF tempMensaje<>'' THEN
   SET mensaje=CONCAT('Campo requerido ',tempMensaje);
   LEAVE SP;
  END IF;

   SELECT count(*) INTO conteoA FROM anuncios
   WHERE idAnuncios=idAnuncio;

   IF conteoA=0 THEN
     SET mensaje='No existe el anuncio';
     LEAVE SP;
   END IF;

   SELECT idProducto INTO conteoP FROM anuncios
   WHERE idAnuncios=idAnuncio;
   IF conteoA=1 THEN
    UPDATE anuncios SET estado='I',razones=caracteristicas
    WHERE idAnuncios=idAnuncio;
    UPDATE producto SET estado='I' 
    WHERE idProducto=conteoP;
    SET mensaje='Eliminado exitosamente';
    COMMIT;
   END IF;
  END IF;

  IF accion="obtenerAnuncio" THEN
   SELECT a.idAnuncios, a.titulo, a.descripcion, 
   a.precio, a.idPersona, a.idMoneda, a.idProducto, 
   a.estado, a.fecha , p.idCategorias, p.tipo, 
   c.descripcion 'categoria',m.descripcion 'moneda'
   FROM anuncios a
   INNER JOIN producto p on p.idProducto=a.idProducto
   INNER JOIN categorias c on c.idCategorias=p.idCategorias
   INNER JOIN moneda m on m.idMoneda=a.idMoneda
   WHERE a.idPersona=pidPersona AND LOWER(a.estado)=LOWER('A')
   ORDER by fecha DESC;
   SET mensaje='Consulta exitosamente';
  END IF;

  IF accion="guardarFoto" THEN

   SELECT count(*) INTO conteoA  
   FROM fotosanuncio;
   IF conteoA=0 THEN
    SET idUrl=conteoA+1; 
   END IF;
   IF conteoA>0 THEN
    SELECT MAX(idFotos) INTO conteoP  
    FROM fotosanuncio;
    SET idUrl=conteoP+1;
   END IF;
    SELECT MAX(idAnuncios) INTO conteoA 
    FROM anuncios;

   SELECT count(*) INTO totalFotos  
   FROM fotosanuncio WHERE idAnuncios=conteoA;
   IF totalFotos<9 THEN 
    INSERT INTO fotosanuncio(idFotos, cantidad, 
    urlFoto, idAnuncios) 
    VALUES (idUrl,1,url,conteoA);
    SET mensaje='Foto guardada exitosamente';
    COMMIT;
   END IF; 
   IF totalFotos>8 THEN
     SET mensaje='Solo puede guardar 8 fotos maximo';
     LEAVE SP;
   END IF;
  END IF;

  IF accion="editarFoto" THEN

   SELECT count(*) INTO conteoA  
   FROM fotosanuncio;
   IF conteoA=0 THEN
    SET idUrl=conteoA+1; 
   END IF;
   IF conteoA>0 THEN
    SELECT MAX(idFotos) INTO conteoP  
    FROM fotosanuncio;
    SET idUrl=conteoP+1;
   END IF;

   SELECT count(*) INTO totalFotos  
   FROM fotosanuncio WHERE idAnuncios=idAnuncio;
   IF totalFotos<9 THEN 
    INSERT INTO fotosanuncio(idFotos, cantidad, 
    urlFoto, idAnuncios) 
    VALUES (idUrl,1,url,idAnuncio);
    SET mensaje='Foto guardada exitosamente';
    COMMIT;
   END IF; 
   IF totalFotos>8 THEN
     SET mensaje='Solo puede guardar 8 fotos maximo';
     LEAVE SP;
   END IF;
  END IF;

  IF accion="eliminarFoto" THEN

   SELECT COUNT(*) INTO conteoU FROM fotosanuncio 
   WHERE idFotos=idAnuncio;

   IF conteoU=0 THEN 
     SET mensaje='No existe la foto';
     LEAVE SP;
   END IF;
   IF conteoU=1 THEN

    DELETE FROM fotosanuncio 
    WHERE idFotos = idAnuncio;
    SET mensaje='Eliminada exitosamente';
    COMMIT;
   END IF; 
  END IF;

  IF accion="obtenerFotos" THEN
   SELECT count(*) into conteoU FROM fotosanuncio 
   WHERE idAnuncios=idAnuncio;

   IF conteoU=0 THEN
    SET mensaje='Este anuncio no tiene fotos';
    LEAVE SP;
   END IF;
   IF conteoU>0 THEN
    SELECT idFotos, urlFoto, idAnuncios 
    FROM fotosanuncio WHERE idAnuncios=idAnuncio;
    SET mensaje='Fotos con exito';
   END IF;
  END IF;

  
END$$

DROP PROCEDURE IF EXISTS `SP_CAMBIAR_TIEMPO_USUARIO_ADMINISTRADOR`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_CAMBIAR_TIEMPO_USUARIO_ADMINISTRADOR` (IN `cantidadDiasIN` INT, OUT `mensaje` VARCHAR(100), OUT `codigo` VARCHAR(2), OUT `cantidadDiasOut` INT)  SP:BEGIN
    DECLARE conteo INT;
    DECLARE idTipoUsuarioVar INT;
    DECLARE cantidadDias INT;

    DECLARE tempMensaje VARCHAR(100);
    SET autocommit=0;  
    SET tempMensaje='';
    START TRANSACTION;  


    IF cantidadDiasIN<1 THEN
        SET tempMensaje='Ingrese una cantidad de días mayor';
    END IF;
    
    IF tempMensaje<>'' THEN
        SET mensaje=CONCAT('Campos requeridos ',tempMensaje);
        LEAVE SP;
    END IF;
    
    SELECT count(*) INTO conteo from tipousuario 
    WHERE descripcion LIKE  "%Administrador%";
    
    IF conteo>0 THEN

        select idTipoUsuario INTO  idTipoUsuarioVar 
        FROM tipousuario  WHERE descripcion LIKE  "%Administrador%";

        UPDATE tipousuario SET tiempoPublicacion =  cantidadDiasIN
        WHERE idTipoUsuario = idTipoUsuarioVar;

        select tiempoPublicacion INTO  cantidadDias 
        FROM tipousuario  WHERE descripcion LIKE  "%Administrador%";

        SET mensaje='Actualizacion exitosa';
        SET codigo=1;
        SET  cantidadDiasOut = cantidadDias;

        COMMIT;
    ELSE
        SET mensaje='No existe usuario administrador en la base de datos.';
        SET codigo=0;
        SET  cantidadDiasOut = 0;
        
        ROLLBACK;
    END IF;  
END$$

DROP PROCEDURE IF EXISTS `SP_CAMBIAR_TIEMPO_USUARIO_NORMAL`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_CAMBIAR_TIEMPO_USUARIO_NORMAL` (IN `cantidadDiasIN` INT, OUT `mensaje` VARCHAR(100), OUT `codigo` VARCHAR(2), OUT `cantidadDiasOut` INT)  SP:BEGIN
    DECLARE conteo INT;
    DECLARE idTipoUsuarioVar INT;
    DECLARE cantidadDias INT;

    DECLARE tempMensaje VARCHAR(100);
    SET autocommit=0;  
    SET tempMensaje='';
    START TRANSACTION;  


    IF cantidadDiasIN<1 THEN
        SET tempMensaje='Ingrese una cantidad de días mayor';
    END IF;
    
    IF tempMensaje<>'' THEN
        SET mensaje=CONCAT('Campos requeridos ',tempMensaje);
        LEAVE SP;
    END IF;
    
    SELECT count(*) INTO conteo from tipousuario 
    WHERE descripcion LIKE  "%normal%";
    
    IF conteo>0 THEN

        select idTipoUsuario INTO  idTipoUsuarioVar 
        FROM tipousuario  WHERE descripcion LIKE  "%normal%";

        UPDATE tipousuario SET tiempoPublicacion =  cantidadDiasIN
        WHERE idTipoUsuario = idTipoUsuarioVar;

        select tiempoPublicacion INTO  cantidadDias 
        FROM tipousuario  WHERE descripcion LIKE  "%normal%";

        SET mensaje='Actualizacion exitosa';
        SET codigo=1;
        SET  cantidadDiasOut = cantidadDias;

        COMMIT;
    ELSE
        SET mensaje='No existe usuario normal en la base de datos.';
        SET codigo=0;
        SET  cantidadDiasOut = 0;
        
        ROLLBACK;
    END IF;  
END$$

DROP PROCEDURE IF EXISTS `SP_CANTIDAD_ADMIN`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_CANTIDAD_ADMIN` (IN `accion` VARCHAR(45), OUT `mensaje` VARCHAR(100))  SP:BEGIN
  DECLARE conteo INT;
  DECLARE id INT;
  DECLARE tempMensaje VARCHAR(100);
  SET autocommit=0;  
  SET tempMensaje='';
  START TRANSACTION;
  IF accion='' THEN
    SET tempMensaje='Accion ';
  END IF;  
  IF tempMensaje<>'' THEN
    SET mensaje=CONCAT('Campo requerido ',tempMensaje);
    LEAVE SP;
  END IF;
 

  IF accion="obtenerUsuarios" THEN
      SELECT COUNT(*) 'total' FROM `persona` 
      WHERE lOWER(estado)=LOWER('A');
      SET mensaje='Exitoso';
  END IF;

  IF accion="obtenerPublicaciones" THEN
      SELECT COUNT(*) 'total' FROM `anuncios` 
      WHERE LOWER(estado)=LOWER('A');
      SET mensaje='Exitoso';
  END IF;

  IF accion="obtenerProductos" THEN
      SELECT COUNT(*) 'total' FROM `producto` 
      WHERE LOWER(estado)=LOWER('A') 
      AND LOWER(tipo)=LOWER('PRODUCTO');
      SET mensaje='Exitoso';
  END IF;

  IF accion="obtenerServicios" THEN
      SELECT COUNT(*) 'total' FROM `producto` 
      WHERE LOWER(estado)=LOWER('A') 
      AND LOWER(tipo)=LOWER('SERVICIOS');
      SET mensaje='Exitoso';
  END IF;

  
END$$

DROP PROCEDURE IF EXISTS `SP_CATEGORIAS`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_CATEGORIAS` (IN `nombreCategoria` VARCHAR(50), IN `idcategoria` INT, IN `accion` VARCHAR(45), IN `pestado` VARCHAR(2), OUT `mensaje` VARCHAR(100))  SP:BEGIN
  DECLARE conteo INT;
  DECLARE id INT;
  DECLARE tempMensaje VARCHAR(100);
  SET autocommit=0;  
  SET tempMensaje='';
  START TRANSACTION;
  IF accion='' THEN
    SET tempMensaje='Accion ';
  END IF;  
  IF tempMensaje<>'' THEN
    SET mensaje=CONCAT('Campo requerido ',tempMensaje);
    LEAVE SP;
  END IF;
  

  IF accion="guardar" OR accion="editar" THEN
      IF nombreCategoria=''THEN
        SET tempMensaje='Nombre Categoria ,';
      END IF;
      IF tempMensaje<>'' THEN
        SET mensaje=CONCAT('Campos requeridos ',tempMensaje);
        LEAVE SP;
      END IF;
  END IF;

  IF accion="eliminar" THEN
      IF idcategoria='' OR idcategoria=0  THEN
        SET tempMensaje='Id Categoria ,';
      END IF; 
      IF tempMensaje<>'' THEN
        SET mensaje=CONCAT('Campo requerido ',tempMensaje);
        LEAVE SP;
      END IF;
  END IF;  

  IF accion="obtenerTodos" THEN
      SELECT * FROM categorias where estado="A";
      SET mensaje='Exitoso';
  END IF;

  IF accion="obtenerPorPalabra" THEN
    SELECT count(*) INTO conteo FROM categorias
    WHERE descripcion=nombreCategoria;
    IF conteo=0 THEN
      SET mensaje='No Existe';
      LEAVE SP;
    END IF;
    SELECT * FROM categorias where descripcion=nombreCategoria;
    SET mensaje='Exitoso';
  END IF;

  IF accion="obtenerInactivos" THEN
      SELECT * FROM categorias where estado="I";
      SET mensaje='Exitoso';
  END IF;

  IF accion="guardar" THEN
    SELECT count(*) INTO conteo FROM categorias
    WHERE descripcion=nombreCategoria;
    IF conteo=1 THEN
      SET mensaje='Ya existe la categoria';
      LEAVE SP;
    END IF;
    IF conteo=0 THEN
      SELECT count(*) INTO conteo FROM categorias;
      IF conteo=0 THEN
        SET id=1;
      ELSE
        SET id=conteo+1;
      END IF;

      INSERT INTO categorias(idCategorias, descripcion,estado) VALUES (id,nombreCategoria,"A");
      SET mensaje='Registro exitoso';
      COMMIT;
    END IF;
  END IF;

  IF accion="editar" THEN
    IF pestado=''THEN
        SET tempMensaje='Estado ,';
      END IF;
      IF tempMensaje<>'' THEN
        SET mensaje=CONCAT('Campo requerido ',tempMensaje);
        LEAVE SP;
      END IF;
    SELECT count(*) INTO conteo FROM categorias
    WHERE idCategorias=idcategoria;
    IF conteo=0 THEN
      SET mensaje='No existe la categoria';
      LEAVE SP;
    END IF;
    IF conteo=1 THEN
      UPDATE categorias SET descripcion=nombreCategoria ,estado=pestado WHERE idCategorias=idcategoria;
      SET mensaje='Edicion exitosa';
      COMMIT;
    END IF;
  END IF;

  IF accion="eliminar" THEN
    SELECT count(*) INTO conteo FROM categorias
    WHERE idCategorias=idcategoria;
    IF conteo=0 THEN
      SET mensaje='No existe la categoria';
      LEAVE SP;
    END IF;
    IF conteo=1 THEN
      UPDATE categorias SET estado="I" WHERE idCategorias=idcategoria;
      SET mensaje='Eliminado exitosamente';
      COMMIT;
    END IF;
  END IF;

  IF accion="buscarId" THEN
    SELECT count(*) INTO conteo FROM categorias
    WHERE idCategorias=idcategoria;
    IF conteo=0 THEN
      SET mensaje='No existe la categoria';
      LEAVE SP;
    END IF;
    IF conteo=1 THEN
      SELECT idCategorias, descripcion, estado FROM categorias WHERE idCategorias=idcategoria;
      SET mensaje='encontado exitosamente';
      COMMIT;
    END IF;
  END IF;
  
END$$

DROP PROCEDURE IF EXISTS `SP_DENUNCIAS`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_DENUNCIAS` (IN `accion` VARCHAR(45), IN `idAnuncio` INT, IN `idDenuncia` INT, IN `idDenunciante` INT, IN `razon` VARCHAR(100), IN `estado` VARCHAR(2), OUT `mensaje` VARCHAR(100))  SP:BEGIN
  DECLARE conteo INT;
  DECLARE idD INT;
  DECLARE tempMensaje VARCHAR(100);
  SET autocommit=0;  
  SET tempMensaje='';
  START TRANSACTION;
  IF accion='' THEN
    SET tempMensaje='Accion ';
  END IF;  
  IF tempMensaje<>'' THEN
    SET mensaje=CONCAT('Campo requerido ',tempMensaje);
    LEAVE SP;
  END IF;
  

  IF accion="eliminar" THEN
      IF idDenuncia='' OR idDenuncia=0  THEN
        SET tempMensaje='Id denuncia ,';
      END IF; 
      IF tempMensaje<>'' THEN
        SET mensaje=CONCAT('Campo requerido ',tempMensaje);
        LEAVE SP;
      END IF;
  END IF; 
  IF accion='solicitudDenuncia' THEN
      IF idAnuncio=''THEN
        SET tempMensaje='Id Anuncio ,';
      END IF;
      IF idDenunciante=''THEN
        SET tempMensaje='Id Denunciante ,';
      END IF; 
      IF razon=''  THEN
        SET tempMensaje='Razon denuncia ,';
      END IF; 
      IF tempMensaje<>'' THEN
        SET mensaje=CONCAT('Campo requerido ',tempMensaje);
        LEAVE SP;
      END IF;
  END IF; 

  IF accion="obtenerTodos" THEN
    SELECT d.idDenuncias, d.fecha,d.razones, a.titulo, d.estado,p.primerNombre,p.segundoApellido 
    ,a.idAnuncios, a.idPersona 'denunciado', d.denunciante
    FROM denuncias d
    INNER JOIN anuncios a on a.idAnuncios=d.idAnuncios
    INNER JOIN persona p on p.idPersona=d.denunciante WHERE a.estado="A";
      SET mensaje='Exitoso';
      COMMIT;
  END IF;

  IF accion="solicitudDenuncia" THEN
    SELECT COUNT(*) INTO conteo FROM denuncias;

    IF conteo=0 THEN
      SET idD=1;
    END IF;
    IF conteo>0 THEN
      SELECT MAX(idDenuncias) INTO conteo FROM denuncias;
      SET idD=conteo+1;
    END IF;
      INSERT INTO denuncias(idDenuncias, fecha, 
        cantidad, razones, idAnuncios, 
        estado, denunciante) 
      VALUES (idD,CURDATE(),
        1,razon,idAnuncio,
        'A',idDenunciante);
      SET mensaje='Denuncia realizada exitosamente';
      COMMIT;
  END IF;

  IF accion="eliminar" THEN
    SELECT COUNT(*) INTO conteo FROM denuncias WHERE idDenuncias=idDenuncia;
    IF conteo=0 THEN
      SET mensaje='No existe la denuncia';
      LEAVE SP;
    END IF;
    IF conteo=1 THEN
      UPDATE anuncios a
      INNER JOIN denuncias d ON d.idAnuncios = a.idAnuncios
      SET a.estado = "I", d.estado = "I", a.razones ="Por denuncia"
      WHERE d.idDenuncias = idDenuncia;
      SET mensaje='Dado de baja';
      COMMIT;
    END IF;
  END IF;
END$$

DROP PROCEDURE IF EXISTS `SP_DETALLE_PUBLICACION`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_DETALLE_PUBLICACION` (IN `idUsuarioDaLike` INT, IN `pidCalificacion` INT, IN `idPublicacion` INT, IN `idUsuarioRecibeLike` INT, IN `cantidad` INT, IN `prazones` VARCHAR(200), IN `accion` VARCHAR(45), IN `pestado` VARCHAR(2), OUT `mensaje` VARCHAR(100))  SP:BEGIN
  DECLARE conteo INT;
  DECLARE conteo2 INT;
  DECLARE id INT;
  DECLARE idCal INT;
  DECLARE tempMensaje VARCHAR(100);
  SET autocommit=0;  
  SET tempMensaje='';
  START TRANSACTION;
  IF accion='' THEN
    SET tempMensaje='Accion ';
  END IF;  
  IF tempMensaje<>'' THEN
    SET mensaje=CONCAT('Campo requerido ',tempMensaje);
    LEAVE SP;
  END IF;
  

  IF accion="guardarCalificacion" THEN
     IF idUsuarioDaLike='' THEN
        SET tempMensaje='Usuario da Like, ';
     END IF; 
     IF idPublicacion='' THEN
      SET tempMensaje='Publicacion, ';
     END IF;  
     IF cantidad='' THEN
      SET tempMensaje='Puntuacion, ';
     END IF;
     IF tempMensaje<>'' THEN
      SET mensaje=CONCAT('Campos requeridos ',tempMensaje);
      LEAVE SP;
     END IF; 
  END IF;

  IF accion="eliminar" OR accion="editarCalificacion" THEN
      IF idPublicacion='' OR idPublicacion=0  THEN
        SET tempMensaje='Id Anuncio ,';
      END IF; 
      IF idUsuarioDaLike='' OR idUsuarioDaLike=0  THEN
        SET tempMensaje='Id Anuncio ,';
      END IF;
      IF tempMensaje<>'' THEN
        SET mensaje=CONCAT('Campo requerido ',tempMensaje);
        LEAVE SP;
      END IF;
  END IF;  

  IF accion="obtenerPublicacion" THEN
      SELECT a.idAnuncios, a.titulo, a.descripcion, a.precio, a.idPersona, 
      a.idMoneda, a.idProducto, a.estado, 
      a.fecha , p.primerNombre , 
      p.segundoNombre, p.primerApellido, 
      p.segundoApellido, p.correo, p.fechaNac,
      p.idTipoUsuario,p.idMunicipio,p.estado, m.descripcion 'moneda',
      mun.nombre 'municipio',d.nombre 'depto',t.telefono,cate.descripcion 
      'categoria',pro.tipo 'tipoProducto' 
      FROM anuncios a
      INNER JOIN persona p on a.idPersona=p.idPersona 
      INNER JOIN moneda m on m.idMoneda=a.idMoneda
      INNER join municipio mun on mun.idMunicipio=p.idMunicipio
      INNER JOIN deptos d on d.idDeptos=mun.idDeptos
      INNER JOIN telefono t on t.idPersona=p.idPersona
      INNER JOIN producto pro on pro.idProducto=a.idProducto
      INNER JOIN categorias cate on cate.idCategorias=pro.idCategorias
      WHERE a.idAnuncios=idPublicacion;
      SET mensaje='Exitoso';
  END IF;

  IF accion="obtenerPuntuacion" THEN
    
    SELECT count(*) INTO conteo FROM calificacion 
    WHERE idAnuncios=idPublicacion;
    IF conteo=0 THEN
      SET mensaje='No tiene puntuacion';
      LEAVE SP;
    END IF;
      SELECT c.idCalificacion, c.pubCalificada, 
      c.puntuacion, c.razones, c.idAnuncios, 
      c.estado, p.idPersona,p.primerNombre,p.primerApellido,
      (SELECT SUM(puntuacion) FROM calificacion cal WHERE cal.idAnuncios=idPublicacion) Total
      FROM calificacion c
      INNER JOIN persona p on p.idPersona=c.nombre
      WHERE idAnuncios=idPublicacion;
      SET mensaje='Exitoso';
  END IF;

  IF accion="obtenerCantidadUsuario" THEN
    
    SELECT count(*) INTO conteo FROM calificacion 
    WHERE nombre=idUsuarioDaLike;
    IF conteo=0 THEN
      SET mensaje='No hay puntuacion';
      LEAVE SP;
    END IF;
      SELECT idCalificacion,puntuacion, razones FROM calificacion 
      WHERE idAnuncios=idPublicacion 
      and nombre=idUsuarioDaLike;
      SET mensaje='Exitoso';
  END IF;

  IF accion="guardarCalificacion" THEN
      SELECT count(*) INTO conteo FROM calificacion 
      WHERE nombre=idUsuarioDaLike and idAnuncios=idPublicacion;

      IF conteo=0 THEN
        SELECT MAX(idCalificacion) INTO conteo2 FROM calificacion;
        IF conteo2=0 THEN
          SET id=1;
        ELSE
          SET id=conteo2+1;
        END IF;
        INSERT INTO calificacion(idCalificacion, pubCalificada, puntuacion, razones,
         idAnuncios, estado, nombre) 
        VALUES (id,null,cantidad,
          prazones,idPublicacion,'A',idUsuarioDaLike);
        SET mensaje='Registro exitoso';
        COMMIT;
      END IF;

      IF conteo=1 THEN
        SELECT idCalificacion INTO idCal 
        FROM calificacion 
        WHERE nombre=idUsuarioDaLike 
        and idAnuncios=idPublicacion;
        

        UPDATE calificacion 
        SET puntuacion=cantidad,razones=prazones
        WHERE idCalificacion=idCal;
        SET mensaje='Edicion exitosa';
        COMMIT;
      END IF;
  END IF;

  IF accion="editarCalificacion" THEN
    SELECT COUNT(*) INTO conteo FROM calificacion 
    WHERE idAnuncios=idPublicacion and
    nombre=idUsuarioDaLike;

    IF conteo=0 THEN
      SET mensaje='No Hay Calificacion';
      LEAVE SP;
    END IF;
    IF conteo=1 THEN
      SELECT idCalificacion, puntuacion, razones
      FROM calificacion 
      WHERE idAnuncios=idPublicacion and 
      nombre=idUsuarioDaLike;
      SET mensaje='Tiene Calificacion';
      COMMIT;
    END IF;
  END IF;

  IF accion="eliminar" THEN
    SELECT COUNT(*) FROM calificacion 
    WHERE idCalificacion=pidCalificacion;
    IF conteo=0 THEN
      SET mensaje='No hay calificacion';
      LEAVE SP;
    END IF;
    IF conteo=1 THEN
      UPDATE calificacion 
      SET estado='I'
      WHERE idCalificacion=pidCalificacion;
      SET mensaje='Eliminado exitosamente';
      COMMIT;
    END IF;
  END IF;


  IF accion="obtenerCantidad" THEN
    SELECT COUNT(*) FROM calificacion 
    WHERE idCalificacion=pidCalificacion;
    IF conteo=0 THEN
      SET mensaje='No hay calificacion';
      LEAVE SP;
    END IF;
    IF conteo=1 THEN
      SELECT COUNT(*) 'Uno',
      (SELECT COUNT(*) FROM calificacion WHERE puntuacion=2)  'Dos',
      (SELECT COUNT(*) FROM calificacion WHERE puntuacion=3) 'Tres', 
      (SELECT COUNT(*) FROM calificacion WHERE puntuacion=4) 'Cuatro', (SELECT COUNT(*) FROM calificacion WHERE puntuacion=5) 'Cinco'
      FROM calificacion WHERE puntuacion=1;
      SET mensaje='Exitosamente';
      COMMIT;
    END IF;
  END IF;
  
  IF accion="obtenerFotos" THEN
    SELECT count(*) INTO conteo FROM fotosanuncio 
    WHERE idAnuncios=idPublicacion;
    IF conteo=0 THEN
      SET mensaje='No Hay Fotos';
      LEAVE SP;
    END IF;
    SELECT * FROM fotosanuncio 
    WHERE idAnuncios=idPublicacion;
    SET mensaje='Hay Fotos';
  END IF;
END$$

DROP PROCEDURE IF EXISTS `SP_FAVORITOS`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_FAVORITOS` (IN `IN_idPersona` INT, IN `IN_idAnuncio` INT, IN `accion` VARCHAR(20), OUT `codigo` INT, OUT `mensaje` VARCHAR(100))  SP:BEGIN
    DECLARE conteo INT;
    DECLARE id INT;
    DECLARE p_idPersona  INT;

    DECLARE tempMensaje VARCHAR(100);
    SET autocommit=0;  
    SET tempMensaje='';


    START TRANSACTION;  

    IF IN_idPersona = '' THEN
        SET tempMensaje = 'idPersona ,';
    END IF;
    IF IN_idAnuncio = '' THEN
        SET tempMensaje = 'idAnuncio ,';
    END IF;
    IF accion = '' THEN
        SET tempMensaje='accion ,';
    END IF;
    
    IF tempMensaje<>'' THEN
        SET mensaje=CONCAT('Campos requeridos ',tempMensaje);
        LEAVE SP;
    END IF;

    
    IF accion = 'nuevo' THEN 
    
        select idPersona into p_idPersona from anuncios 
        where idAnuncios = IN_idAnuncio;

        select COUNT(*) into conteo from favoritos 
        where idPersona = IN_idPersona and favorito = p_idPersona ;

        IF conteo > 0 THEN
            
            SET mensaje = 'Ya se ha registrado como favorito.';
            SET codigo = 2;
        
        ELSE 
            select MAX(idFavoritos) into conteo from favoritos;
            
            SET id = conteo + 1;
            INSERT INTO favoritos
            (idFavoritos, estado, idPersona, favorito)
            VALUES(id, 'A', IN_idPersona, p_idPersona);

            SET mensaje='Registrado exitosamente.';
            SET codigo=1;

            COMMIT;

        END IF;
    END IF;
    
END$$

DROP PROCEDURE IF EXISTS `SP_LOGIN`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_LOGIN` (IN `pcorreo` VARCHAR(50), IN `pcontrasenia` VARCHAR(50), OUT `pid` INT, OUT `mensaje` VARCHAR(100), OUT `existe` INT, OUT `contrasenaCorrecta` INT, OUT `estadoRegistro` INT, OUT `esUsuarioAdmin` INT)  SP:BEGIN
  DECLARE conteo INT;
  DECLARE contra INT;
  DECLARE conteoAdmin INT;
  DECLARE id INT;
  DECLARE estadoPersona  VARCHAR(2);
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
    SET esUsuarioAdmin = 0;
    LEAVE SP;
  END IF;  

  IF conteo=1 THEN

    SELECT estado INTO estadoPersona FROM `persona` WHERE  correo=pcorreo;

    IF estadoPersona LIKE "%I" THEN
        SET mensaje='Estás dado de baja actualmente';
        SET existe=1;
        SET contrasenaCorrecta = 1;
        SET estadoRegistro = 0;
        SET esUsuarioAdmin = 0;
        LEAVE SP;
    ELSE     
        SELECT idPersona INTO id FROM `persona` WHERE correo=pcorreo;

        SELECT COUNT(*) INTO conteoAdmin  FROM persona pe
        INNER JOIN tipousuario tu ON tu.idTipoUsuario = pe.idTipoUsuario 
        WHERE idPersona = id AND tu.descripcion LIKE "%Administrador%";


        IF conteoAdmin = 1 THEN
            SET mensaje='Usuario registrado';
            SET existe=1;
            SET pid=id;
            SET contrasenaCorrecta = 1; 
            SET estadoRegistro = 1;
            SET esUsuarioAdmin = 1;
            COMMIT;
        ELSE
            SET mensaje='Usuario registrado';
            SET existe=1;
            SET pid=id;
            SET contrasenaCorrecta = 1; 
            SET estadoRegistro = 1;
            SET esUsuarioAdmin = 0;
            COMMIT;
        END IF;
    END IF;    
  END IF;
END$$

DROP PROCEDURE IF EXISTS `SP_PERFIL_ADMIN`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_PERFIL_ADMIN` (IN `ppNombre` VARCHAR(50), IN `psNombre` VARCHAR(50), IN `ppApellido` VARCHAR(50), IN `psApellido` VARCHAR(50), IN `pcorreo` VARCHAR(50), IN `pfechaNac` VARCHAR(10), IN `telefono` VARCHAR(10), IN `pmunicipio` INT, IN `idUsuario` INT, IN `pDeptos` INT, IN `urlImg` VARCHAR(50), IN `accion` VARCHAR(50), OUT `mensaje` VARCHAR(100))  SP:BEGIN
  DECLARE conteo INT;
  DECLARE id INT;
  DECLARE idIM INT;
  DECLARE tempMensaje VARCHAR(100);
  SET autocommit=0;  
  SET tempMensaje='';
  START TRANSACTION;

  IF accion='' THEN
      SET tempMensaje='Accion ,';
  END IF;

  IF tempMensaje<>'' THEN
    SET mensaje=CONCAT('Campo requerido ',tempMensaje);
    LEAVE SP;
  END IF;
  

  IF accion="editar" THEN
    IF ppNombre=''  THEN
    SET tempMensaje='Primer Nombre ,';
    END IF;
    IF psNombre='' THEN
    SET tempMensaje='Segundo Nombre ,';
    END IF;
    IF ppApellido='' THEN
        SET tempMensaje='Primer Apellido ,';
    END IF;
    IF psApellido='' THEN
        SET tempMensaje='Segundo Apellido ,';
    END IF;
    IF pcorreo='' THEN
        SET tempMensaje='Correo ,';
    END IF;
    IF pmunicipio<1 THEN
        SET tempMensaje='Municipio ,';
    END IF;
    IF idUsuario='' or idUsuario=0 THEN
        SET tempMensaje='Id Usuario ,';
    END IF;
     
    IF tempMensaje<>'' THEN
      SET mensaje=CONCAT('Campo requerido ',tempMensaje);
      LEAVE SP;
    END IF;                     
      
  END IF;

  IF accion="eliminar" THEN
      IF idUsuario='' or idUsuario=0 THEN
        SET tempMensaje='Id Usuario ,';
      END IF;
       
      IF tempMensaje<>'' THEN
        SET mensaje=CONCAT('Campo requerido ',tempMensaje);
        LEAVE SP;
      END IF; 
  END IF;  

  IF accion="editarFoto" THEN
    IF urlImg='' THEN
        SET tempMensaje='foto ,';
    END IF; 
    IF idUsuario='' or idUsuario=0 THEN
        SET tempMensaje='id usuario ,';
      END IF; 
    IF tempMensaje<>'' THEN
        SET mensaje=CONCAT('Campo requerido ',tempMensaje);
        LEAVE SP;
    END IF;
  END IF;

  IF accion="obtenerFotos" or accion="obtenerTelefono" THEN
    IF idUsuario='' or idUsuario=0 THEN
      SET tempMensaje='id usuario ,';
    END IF; 
    IF tempMensaje<>'' THEN
        SET mensaje=CONCAT('Campo requerido ',tempMensaje);
        LEAVE SP;
    END IF;
    SET mensaje='Exitoso';
  END IF;

  IF accion="obtenerActivos" THEN
      SELECT idPersona, primerNombre, segundoNombre, primerApellido, segundoApellido, 
      correo, fechaNac, contrasenia, idTipoUsuario, idMunicipio, estado 
      FROM persona WHERE estado='a';
      SET mensaje='Exitoso';
  END IF;

  IF accion="obtenerInactivos" THEN
      SELECT idPersona, primerNombre, segundoNombre, primerApellido, segundoApellido, 
      correo, fechaNac, contrasenia, idTipoUsuario, idMunicipio, estado 
      FROM persona WHERE estado='I';
      SET mensaje='Exitoso';
  END IF;

  IF accion="obtenerMunicipios" THEN
      SELECT idMunicipio, nombre, idDeptos FROM municipio;
      SET mensaje='Exitoso';
  END IF;

  IF accion="obtenerPorDepto" THEN
      SELECT idMunicipio, nombre, idDeptos FROM municipio 
      where idDeptos=pDeptos;
      SET mensaje='Exitoso';
  END IF;

  IF accion="obtenerDeptos" THEN
      SELECT idDeptos, nombre FROM deptos;
      SET mensaje='Exitoso';
  END IF;

  IF accion="obtenerFotos" THEN
      SELECT count(*) INTO conteo FROM fotosusuario WHERE idPersona=idUsuario;
      IF conteo=0 THEN
        SET mensaje='No tiene Foto';
        LEAVE SP;
      END IF;
      IF conteo=1 THEN
        SELECT * FROM fotosusuario WHERE idPersona=idUsuario;
        SET mensaje='Exitoso';
      END IF;
  END IF;

  IF accion="obtenerTelefono" THEN
      SELECT * FROM telefono WHERE idPersona=idUsuario;
      SET mensaje='Exitoso';
  END IF;

  IF accion="editar" THEN
    
    SELECT COUNT(*) INTO conteo FROM persona p WHERE idPersona=idUsuario;

    IF conteo=0 THEN
      SET mensaje='No existe el usuario';
      LEAVE SP;
    END IF;

    IF conteo=1 THEN
      UPDATE persona p 
      SET primerNombre=ppNombre,segundoNombre=psNombre,
      primerApellido=ppApellido,segundoApellido=psApellido,correo=pcorreo,
      idMunicipio=pmunicipio WHERE idPersona=idUsuario;
      UPDATE telefono  
      SET telefono=telefono
      WHERE idPersona=idUsuario;
      SET mensaje='Edicion exitosa';
      COMMIT;
    END IF;    

  END IF;

  IF accion="editarFoto" THEN

    SELECT COUNT(*) INTO conteo FROM fotosusuario WHERE idPersona=idUsuario;
    SELECT COUNT(*) INTO id FROM fotosusuario;

    SET idIM=id+1;

    IF conteo=0 THEN
      INSERT INTO fotosusuario(idFotos, urlFoto, idPersona) 
      VALUES (idIM,urlImg,idUsuario);
      SET mensaje='Foto guardada';
      COMMIT;
    END IF;

    IF conteo=1 THEN
      UPDATE fotosusuario SET urlFoto=urlImg 
      WHERE idPersona=idUsuario;
      SET mensaje='Foto editada';
      COMMIT;
    END IF;
  
  END IF;

  IF accion="eliminar" THEN
    SELECT COUNT(*) INTO conteo FROM persona WHERE idPersona=idUsuario;
    IF conteo=0 THEN
      SET mensaje='No existe el usuario';
      LEAVE SP;
    END IF;
    IF conteo=1 THEN
      UPDATE persona SET estado='I' WHERE idPersona=idUsuario;
      SET mensaje='Eliminado exitosamente';
      COMMIT;
    END IF;
  END IF;
  
END$$

DROP PROCEDURE IF EXISTS `SP_PRODUCTOS_Y_SERVICIOS`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_PRODUCTOS_Y_SERVICIOS` (IN `nombrePS` VARCHAR(50), IN `descripcion` VARCHAR(1000), IN `ptipo` VARCHAR(10), IN `pidcategoria` INT, IN `pidProducto` INT, IN `accion` VARCHAR(45), IN `pestado` VARCHAR(2), OUT `mensaje` VARCHAR(100))  SP:BEGIN
  DECLARE conteo INT;
  DECLARE id INT;
  DECLARE tempMensaje VARCHAR(100);
  SET autocommit=0;  
  SET tempMensaje='';
  START TRANSACTION;
  IF accion='' THEN
    SET tempMensaje='Accion ';
  END IF;  
  IF tempMensaje<>'' THEN
    SET mensaje=CONCAT('Campo requerido ',tempMensaje);
    LEAVE SP;
  END IF;
  

  IF accion="guardar" OR accion="editar" THEN
      IF nombrePS=''THEN
        SET tempMensaje='Nombre Producto ,';
      END IF;
      IF descripcion=''THEN
        SET tempMensaje='Descripcion Producto ,';
      END IF;
      IF ptipo=''THEN
        SET tempMensaje='Tipo ,';
      END IF;
      IF pidcategoria=''THEN
        SET tempMensaje='Categoria Producto ,';
      END IF;
      IF tempMensaje<>'' THEN
        SET mensaje=CONCAT('Campos requeridos ',tempMensaje);
        LEAVE SP;
      END IF;
  END IF;

  IF accion="eliminar" or accion="editar" THEN
      IF pidProducto='' or pidProducto=0  THEN
        SET tempMensaje='Id Producto ,';
      END IF; 
      IF tempMensaje<>'' THEN
        SET mensaje=CONCAT('Campo requerido ',tempMensaje);
        LEAVE SP;
      END IF;
  END IF;  

  IF accion="obtenerTodos" THEN
      SELECT p.idProducto,p.nombre,p.caracteristicas,p.tipo,c.descripcion 
      'categoria',p.idCategorias FROM producto p 
      inner JOIN categorias c on c.idCategorias=p.idCategorias 
      where p.estado="A" /*and p.tipo=ptipo*/;
      SET mensaje='Exitoso';
  END IF;

  IF accion="obtenerInactivos" THEN
      SELECT * FROM producto where estado="I" and p.tipo=ptipo;
      SET mensaje='Exitoso';
  END IF;

  IF accion="obtenerCategorias" THEN
      SELECT * from categorias WHERE estado="A" /*and p.tipo=ptipo*/;
      SET mensaje='Exitoso';
  END IF;

  IF accion="guardar" THEN
    SELECT count(*) INTO conteo FROM producto
    WHERE nombre=nombrePS;
    IF conteo=1 THEN
      SET mensaje='Ya existe';
      LEAVE SP;
    END IF;
    IF conteo=0 THEN
      SELECT count(*) INTO conteo FROM producto;
      IF conteo=0 THEN
        SET id=1;
      ELSE
        SET id=conteo+1;
      END IF;
      INSERT INTO producto(idProducto, nombre, estado, caracteristicas, idCategorias, tipo) 
      VALUES (id,nombrePS,"A",descripcion,pidCategoria,ptipo);
      SET mensaje='Registro exitoso';
      COMMIT;
    END IF;
  END IF;

  IF accion="editar" THEN

    SELECT count(*) INTO conteo FROM producto
    WHERE idProducto=pidProducto;
    IF conteo=0 THEN
      SET mensaje='No existe el producto';
      LEAVE SP;
    END IF;
    IF conteo=1 THEN
      UPDATE producto SET nombre=nombrePS,caracteristicas
      =descripcion,idCategorias=pidcategoria,tipo=ptipo 
      WHERE idProducto=pidProducto;
      SET mensaje='Edicion exitosa';
      COMMIT;
    END IF;
  END IF;

  IF accion="eliminar" THEN
    SELECT count(*) INTO conteo FROM producto
    WHERE idProducto=pidProducto;
    IF conteo=0 THEN
      SET mensaje='No existe el Producto';
      LEAVE SP;
    END IF;
    IF conteo=1 THEN
      UPDATE producto SET estado="I" WHERE idProducto=pidProducto;
      SET mensaje='Eliminado exitosamente';
      COMMIT;
    END IF;
  END IF;
  
END$$

DROP PROCEDURE IF EXISTS `SP_REGISTRO_USUARIO`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_REGISTRO_USUARIO` (IN `ppNombre` VARCHAR(50), IN `psNombre` VARCHAR(50), IN `ppApellido` VARCHAR(50), IN `psApellido` VARCHAR(50), IN `pcorreo` VARCHAR(50), IN `pcontrasenia` VARCHAR(50), IN `pfechaNac` VARCHAR(10), IN `ptipoUsuario` INT, IN `pmunicipio` INT, IN `INtelefono` INT, IN `codigoIN` VARCHAR(250), OUT `mensaje` VARCHAR(100), OUT `codigo` VARCHAR(2), OUT `idUsuario` INT)  SP:BEGIN
    DECLARE conteo INT;
    DECLARE id INT;
    DECLARE pid INT;

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
    IF INtelefono='' THEN
        SET tempMensaje='telefono ,';
    END IF;
    IF pfechaNac='' THEN
        SET tempMensaje='Fecha nacimiento ,';
    END IF;
    IF pmunicipio<1 THEN
        SET tempMensaje='Municipio ,';
    END IF;
    IF codigoIN='' THEN
        SET tempMensaje='Codigo ,';
    END IF;
    
    IF tempMensaje<>'' THEN
        SET mensaje=CONCAT('Campos requeridos ',tempMensaje);
        LEAVE SP;
    END IF;
    
    SELECT count(*) INTO conteo FROM persona
    WHERE correo=pcorreo;
    
    IF conteo=0 THEN
        SELECT MAX(idPersona) into id FROM `persona`;
    
        SET pid=id+1; 
        insert into `persona` (`idPersona`, `primerNombre`, `segundoNombre`, `primerApellido`, `segundoApellido`, `correo`, `fechaNac`, `contrasenia`, `idTipoUsuario`, `idMunicipio`, `estado`, `codigo`) 
        values(pid, ppNombre, psNombre, ppApellido, psApellido, pcorreo, pfechaNac, pcontrasenia, ptipoUsuario, pMunicipio, "I", codigoIN);

        SELECT MAX(idTelefono) into id FROM `telefono`;
        

        INSERT INTO `telefono`
        (idTelefono, telefono, idPersona)
        VALUES(id+1, INtelefono, pid);


        SET mensaje='Registro exitoso';
        SET codigo=1;
        SET idUsuario = pid;

        COMMIT;
    ELSE
        SET mensaje='Ya existe usuario registrado con ese correo';
        SET codigo=0;
        SET idUsuario = 0;
    END IF;  
END$$

DROP PROCEDURE IF EXISTS `SP_REGISTRO_USUARIO_ADMINISTRADOR`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_REGISTRO_USUARIO_ADMINISTRADOR` (IN `ppNombre` VARCHAR(50), IN `psNombre` VARCHAR(50), IN `ppApellido` VARCHAR(50), IN `psApellido` VARCHAR(50), IN `pcorreo` VARCHAR(50), IN `pcontrasenia` VARCHAR(50), IN `pfechaNac` VARCHAR(10), IN `pmunicipio` INT, IN `INtelefono` INT, OUT `mensaje` VARCHAR(100), OUT `codigo` VARCHAR(2), OUT `idUsuario` INT)  SP:BEGIN
    DECLARE conteo INT;
    DECLARE id INT;
    DECLARE pid INT;
    DECLARE idTipoUsuario INT;

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
    IF INtelefono='' THEN
        SET tempMensaje='telefono ,';
    END IF;
    IF pfechaNac='' THEN
        SET tempMensaje='Fecha nacimiento ,';
    END IF;
    IF pmunicipio<1 THEN
        SET tempMensaje='Municipio ,';
    END IF;
    
    IF tempMensaje<>'' THEN
        SET mensaje=CONCAT('Campos requeridos ',tempMensaje);
        LEAVE SP;
    END IF;
    
    SELECT count(*) INTO conteo FROM persona
    WHERE correo=pcorreo;
    
    IF conteo=0 THEN
        SELECT MAX(idPersona) into id FROM `persona`;

        SELECT t.idTipoUsuario INTO idTipoUsuario FROM tipousuario t WHERE t.descripcion LIKE "%admin%";


        SET pid=id+1; 

        INSERT INTO `persona`
        (`idPersona`, `primerNombre`, `segundoNombre`, `primerApellido`, `segundoApellido`, `correo`, `fechaNac`, `contrasenia`, `idTipoUsuario`,  `idMunicipio`, `estado`, `codigo`)
        VALUES(pid, ppNombre, psNombre, ppApellido, psApellido, pcorreo, pfechaNac, pcontrasenia, idTipoUsuario, pMunicipio, "i", '');



        SELECT MAX(idTelefono) into id FROM `telefono`;
        

        INSERT INTO `telefono`
        (idTelefono, telefono, idPersona)
        VALUES(id+1, INtelefono, pid);

        SET mensaje='Registro exitoso';
        SET codigo=1;
        SET idUsuario = pid;

        COMMIT;
    ELSE
        SET mensaje='Ya existe usuario registrado con ese correo';
        SET codigo=0;
        SET idUsuario = 0;
    END IF;  
END$$

DROP PROCEDURE IF EXISTS `SP_REPORTES`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_REPORTES` (IN `accion` VARCHAR(45), OUT `mensaje` VARCHAR(100))  SP:BEGIN
  DECLARE conteo INT;
  DECLARE tempMensaje VARCHAR(100);
  SET autocommit=0;  
  SET tempMensaje='';
  START TRANSACTION;
  IF accion='' THEN
    SET tempMensaje='Accion';
  END IF;  
  IF tempMensaje<>'' THEN
    SET mensaje=CONCAT('Campo requerido ',tempMensaje);
    LEAVE SP;
  END IF;
  

  IF accion="obtenerDenuncias" THEN
      SELECT d.idDenuncias, CONCAT(p.primerNombre, ' ',p.primerApellido) as idPersona,(SELECT CONCAT(primerNombre, ' ',primerApellido) from persona where idPersona=d.denunciante)  'denunciante',a.idAnuncios,pro.tipo, d.cantidad, d.razones FROM denuncias d
	  INNER JOIN anuncios a on a.idAnuncios=d.idAnuncios
	  INNER JOIN persona p on p.idPersona=a.idPersona
	  INNER JOIN producto pro on pro.idProducto=a.idPersona
	  WHERE d.estado="A" OR "a";
      SET mensaje='Exitoso';
      COMMIT;
  END IF;  

  IF accion="obtenerUsuarios" THEN
      SELECT  p.idPersona,CONCAT(p.primerNombre,' ', p.primerApellido) as concatenacion,dep.nombre 'nombreDepto', mun.nombre, (SELECT COUNT(idAnuncios) FROM anuncios  WHERE a.idPersona=p.idPersona) as conteo, d.cantidad, p.estado  FROM persona p
	  INNER JOIN municipio mun on mun.idMunicipio=p.idMunicipio
	  INNER JOIN deptos dep on dep.idDeptos = mun.idDeptos
	  INNER JOIN anuncios a on a.idPersona = p.idPersona
	  INNER JOIN denuncias d on d.idAnuncios = a.idAnuncios;
    
      SET mensaje='Exitoso';
      COMMIT;
  END IF; 

   
END$$

DROP PROCEDURE IF EXISTS `SP_UBICACION`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_UBICACION` (IN `nombredepto` VARCHAR(45), IN `idDepto` VARCHAR(45), IN `accion` VARCHAR(30), OUT `codeMessage` INT, OUT `message` VARCHAR(100))  SP:BEGIN
  DECLARE conteo INT;
  DECLARE tempMensaje VARCHAR(100);
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

DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `anuncios`
--

DROP TABLE IF EXISTS `anuncios`;
CREATE TABLE IF NOT EXISTS `anuncios` (
  `idAnuncios` int(11) NOT NULL,
  `titulo` varchar(45) DEFAULT NULL,
  `descripcion` varchar(45) DEFAULT NULL,
  `precio` double DEFAULT NULL,
  `idPersona` int(11) NOT NULL,
  `idMoneda` int(11) NOT NULL,
  `idProducto` int(11) NOT NULL,
  `estado` varchar(2) DEFAULT NULL,
  `fecha` date NOT NULL,
  `razones` varchar(500) DEFAULT NULL,
  PRIMARY KEY (`idAnuncios`),
  KEY `fk_Anuncios_Persona1_idx` (`idPersona`),
  KEY `fk_Anuncios_Moneda1_idx` (`idMoneda`),
  KEY `fk_Anuncios_Producto1_idx` (`idProducto`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `anuncios`
--

INSERT INTO `anuncios` (`idAnuncios`, `titulo`, `descripcion`, `precio`, `idPersona`, `idMoneda`, `idProducto`, `estado`, `fecha`, `razones`) VALUES
(1, 'Prueba DE MELI', 'NO TIene', 1, 1, 1, 1, 'I', '2020-05-14', 'Por denuncia'),
(2, 'Puerta', 'Esta en buen estado,De estas medidas MO SIRVE', 10000, 1, 2, 2, 'A', '2020-08-02', NULL),
(3, 'Cama King sise', 'Buen estado', 10000, 1, 1, 3, 'A', '2020-05-14', NULL),
(4, 'Cama King sise', 'Prueba no funciona', 10000, 1, 2, 4, 'A', '2020-04-08', NULL),
(5, 'Cama King sise', 'Buen estado', 10000, 1, 1, 5, 'A', '2020-04-08', NULL),
(6, 'Cama King sise', 'Buen estado', 10000, 1, 1, 6, 'A', '2020-04-08', NULL),
(7, 'Cama King sise', 'Buen estado', 10000, 1, 1, 7, 'A', '2020-04-08', NULL),
(8, 'Microondas', 'Color:Blanco, usado, en buenas condiciones', 600, 1, 1, 8, 'A', '2020-05-14', NULL),
(9, 'Refrigeradora', 'Color gris, semi usada en buenas condiciones', 5000, 1, 1, 9, 'I', '2020-04-23', 'Ya lo vendi'),
(10, 'Camioneta', 'Color roja, anio 2000, en buen estado,precio ', 50000, 1, 1, 10, 'I', '2020-04-23', 'Vendido'),
(11, 'Camioneta', 'Color roja, anio 2000, en buen estado,precio ', 50000, 1, 1, 11, 'I', '2020-04-23', 'ya '),
(12, 'Computadora DELL', 'Procesador dual core, 3GB RAM, Almacenamiento', 2500, 1, 1, 12, 'I', '2020-07-24', ''),
(13, 'Cama Motagua', 'Cama King size', 1500, 1, 1, 13, 'A', '2020-05-13', NULL),
(14, 'Toyota 4*4', 'Color Rojo, doble cabina, anio 2019', 70000, 1, 1, 14, 'A', '2020-04-23', NULL),
(15, 'Computadora LENOVO', '12 pulgadas, pantalla tactil, color negro...', 40000, 1, 2, 15, 'A', '2020-04-24', NULL),
(16, 'Puerta Azul', 'hola', 1, 1, 1, 16, 'I', '2020-04-24', 'Ya vendiste'),
(17, 'Computadora DELL', 'prueba', 10000, 1, 2, 17, 'I', '2020-04-24', 'NO me gusta'),
(18, 'Puerta Azul', 'Esta es una prueba', 10000, 1, 1, 18, 'I', '2020-04-28', 'Ya lo vendi'),
(19, 'Puerta Azul', 'prueba', 10000, 1, 1, 19, 'I', '2020-05-14', 'No me gusta'),
(20, 'PRUEBA 2', 'JJ', 234, 1, 2, 20, 'A', '2020-04-15', NULL),
(21, 'PRUEBA 2', 'JJ', 234, 1, 2, 21, 'A', '2020-04-15', NULL),
(22, 'PRUEBA 2', 'JJ', 234, 1, 2, 22, 'A', '2020-04-15', NULL),
(23, 'PRUEBA 2', 'JJ', 234, 1, 2, 23, 'A', '2020-04-15', NULL),
(24, 'Plancha para cabello', 'Marca CONAIR, en buen estado, con estuche gra', 1670, 7, 1, 24, 'A', '2020-08-03', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `calificacion`
--

DROP TABLE IF EXISTS `calificacion`;
CREATE TABLE IF NOT EXISTS `calificacion` (
  `idCalificacion` int(11) NOT NULL,
  `pubCalificada` int(11) DEFAULT NULL,
  `puntuacion` int(45) DEFAULT NULL,
  `razones` varchar(45) DEFAULT NULL,
  `idAnuncios` int(11) NOT NULL,
  `estado` varchar(2) DEFAULT NULL,
  `nombre` int(11) NOT NULL,
  PRIMARY KEY (`idCalificacion`),
  KEY `fk_Calificacion_Anuncios1_idx` (`idAnuncios`),
  KEY `fk_Calificacion_Persona1_idx` (`nombre`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `calificacion`
--

INSERT INTO `calificacion` (`idCalificacion`, `pubCalificada`, `puntuacion`, `razones`, `idAnuncios`, `estado`, `nombre`) VALUES
(1, NULL, 2, 'esta mal preueba', 1, 'A', 1),
(2, NULL, 4, 'Muy buen producto', 1, 'A', 2),
(3, NULL, 5, 'Excelente', 1, 'A', 3),
(4, NULL, 3, 'Muy buen vendedor', 3, 'A', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

DROP TABLE IF EXISTS `categorias`;
CREATE TABLE IF NOT EXISTS `categorias` (
  `idCategorias` int(11) NOT NULL,
  `descripcion` varchar(45) DEFAULT NULL,
  `estado` varchar(2) DEFAULT NULL,
  PRIMARY KEY (`idCategorias`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`idCategorias`, `descripcion`, `estado`) VALUES
(1, 'Construccion', 'a'),
(2, 'Puerta', 'I'),
(3, 'Electronicos', 'A'),
(4, 'Autos', 'I'),
(5, 'Laptops', 'A');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `denuncias`
--

DROP TABLE IF EXISTS `denuncias`;
CREATE TABLE IF NOT EXISTS `denuncias` (
  `idDenuncias` int(11) NOT NULL,
  `fecha` datetime DEFAULT NULL,
  `cantidad` int(11) DEFAULT NULL,
  `razones` varchar(45) DEFAULT NULL,
  `idAnuncios` int(11) NOT NULL,
  `estado` varchar(2) DEFAULT NULL,
  `denunciante` int(11) DEFAULT NULL,
  PRIMARY KEY (`idDenuncias`),
  KEY `fk_Denuncias_Anuncios1_idx` (`idAnuncios`),
  KEY `denunciante` (`denunciante`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `denuncias`
--

INSERT INTO `denuncias` (`idDenuncias`, `fecha`, `cantidad`, `razones`, `idAnuncios`, `estado`, `denunciante`) VALUES
(1, '2020-05-10 08:18:46', 2, 'Producto en mal estado', 1, 'A', 1),
(2, '2020-05-15 00:00:00', 2, 'Mal producto', 1, 'I', 1),
(3, '2012-12-12 00:00:00', 3, 'Mal producto pesimo', 1, 'I', 1),
(4, '2020-05-17 00:00:00', 1, 'Prueba -......', 1, 'A', 7);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `deptos`
--

DROP TABLE IF EXISTS `deptos`;
CREATE TABLE IF NOT EXISTS `deptos` (
  `idDeptos` int(11) NOT NULL,
  `nombre` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`idDeptos`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `deptos`
--

INSERT INTO `deptos` (`idDeptos`, `nombre`) VALUES
(1, 'El Paraiso'),
(2, 'Olancho'),
(3, 'Francisco Morazán'),
(4, 'Valle'),
(5, 'Comayagua'),
(6, 'Choluteca'),
(7, 'Atlántida'),
(8, 'Santa Bárbara'),
(9, 'Lempira'),
(10, 'Copán'),
(11, 'Cortés');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `enlaces_compartidos`
--

DROP TABLE IF EXISTS `enlaces_compartidos`;
CREATE TABLE IF NOT EXISTS `enlaces_compartidos` (
  `idEnlace` int(11) NOT NULL,
  `descripcion` varchar(45) DEFAULT NULL,
  `redSocial` varchar(45) DEFAULT NULL,
  `cantidadEnlaces` int(11) DEFAULT NULL,
  `idAnuncios` int(11) NOT NULL,
  `estado` varchar(2) DEFAULT NULL,
  PRIMARY KEY (`idEnlace`),
  KEY `fk_Enlaces_Compartidos_Anuncios1_idx` (`idAnuncios`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `favoritos`
--

DROP TABLE IF EXISTS `favoritos`;
CREATE TABLE IF NOT EXISTS `favoritos` (
  `idFavoritos` int(11) NOT NULL,
  `estado` varchar(2) DEFAULT NULL,
  `idPersona` int(11) NOT NULL,
  `favorito` int(11) NOT NULL,
  PRIMARY KEY (`idFavoritos`),
  KEY `fk_Favoritos_Persona1_idx` (`idPersona`),
  KEY `fk_Favoritos_Persona2` (`favorito`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `favoritos`
--

INSERT INTO `favoritos` (`idFavoritos`, `estado`, `idPersona`, `favorito`) VALUES
(1, 'A', 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fotosanuncio`
--

DROP TABLE IF EXISTS `fotosanuncio`;
CREATE TABLE IF NOT EXISTS `fotosanuncio` (
  `idFotos` int(11) NOT NULL,
  `cantidad` int(11) DEFAULT NULL,
  `urlFoto` varchar(45) DEFAULT NULL,
  `idAnuncios` int(11) NOT NULL,
  PRIMARY KEY (`idFotos`),
  KEY `fk_Fotos_Anuncios1_idx` (`idAnuncios`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `fotosanuncio`
--

INSERT INTO `fotosanuncio` (`idFotos`, `cantidad`, `urlFoto`, `idAnuncios`) VALUES
(1, 1, 'imgCate/b1.jpg', 1),
(2, 1, 'imgCate/bati1.jpg', 1),
(3, 1, 'imgCate/bati2.jpg', 1),
(4, 1, 'imgCate/batidora.jpg', 1),
(5, 1, 'imgCate/micro2.jpg', 1),
(6, 1, 'images/b1.jpg', 6),
(7, 1, 'images/b1.jpg', 6),
(8, 1, 'images/b1.jpg', 6),
(9, 1, 'images/b1.jpg', 6),
(10, 1, 'images/b1.jpg', 6),
(11, 1, 'images/b1.jpg', 14),
(12, 1, 'images/b1.jpg', 14),
(14, 1, 'images/b1.jpg', 14),
(15, 1, 'images/b1.jpg', 14),
(16, 1, 'images/descarga (9).jpg', 15),
(19, 1, 'images/descarga (12).jpg', 15),
(20, 1, 'images/descarga (13).jpg', 15),
(21, 1, 'images/descarga (1).jpg', 16),
(22, 1, 'images/descarga (2).jpg', 16),
(23, 1, 'images/descarga (1).jpg', 5),
(24, 1, 'images/descarga (2).jpg', 5),
(25, 1, 'images/descarga (5).jpg', 5),
(26, 1, 'images/descarga (6).jpg', 5),
(27, 1, 'images/descarga (7).jpg', 5),
(28, 1, 'images/descarga (8).jpg', 5),
(29, 1, 'images/descarga (1).jpg', 5),
(30, 1, 'images/descarga (2).jpg', 5),
(31, 1, 'images/descarga (2).jpg', 5),
(32, 1, 'images/descarga (6).jpg', 3),
(33, 1, 'images/descarga (7).jpg', 3),
(34, 1, 'images/descarga (8).jpg', 3),
(35, 1, 'images/descarga (10).jpg', 3),
(36, 1, 'images/descarga (8).jpg', 13),
(37, 1, 'images/descarga (9).jpg', 13),
(38, 1, 'images/descarga (5).jpg', 13),
(39, 1, 'images/descarga (6).jpg', 13),
(40, 1, 'images/descarga (7).jpg', 13),
(41, 1, 'images/descarga (8).jpg', 13),
(42, 1, 'images/descarga (9).jpg', 13),
(43, 1, 'images/descarga (10).jpg', 13),
(44, 1, 'images/descarga (1).jpg', 13),
(45, 1, 'images/bati1.jpg', 18),
(46, 1, 'images/bati2.jpg', 18),
(47, 1, 'images/batidora.jpg', 18),
(48, 1, 'images/micro4.jpg', 18),
(49, 1, 'images/microondas.jpg', 18),
(50, 1, 'images/b1.jpg', 19),
(51, 1, 'images/bati1.jpg', 19),
(52, 1, 'images/bati2.jpg', 19),
(53, 1, 'images/batidora.jpg', 19),
(54, 1, 'images/masetera2.jpg', 23),
(55, 1, 'images/plancha2.jpg', 24),
(56, 1, 'images/plancha3.jpg', 24),
(57, 1, 'images/plancha4.jpg', 24);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fotosusuario`
--

DROP TABLE IF EXISTS `fotosusuario`;
CREATE TABLE IF NOT EXISTS `fotosusuario` (
  `idFotos` int(11) NOT NULL,
  `urlFoto` varchar(45) DEFAULT NULL,
  `idPersona` int(11) NOT NULL,
  PRIMARY KEY (`idFotos`),
  KEY `fk_FotosUsuario_Persona1_idx` (`idPersona`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `fotosusuario`
--

INSERT INTO `fotosusuario` (`idFotos`, `urlFoto`, `idPersona`) VALUES
(1, 'archivos/plancha1.jpg', 1),
(2, 'archivos/IMG-20181208-WA0039.jpg', 7),
(3, 'archivos/IMG-20181208-WA0057.jpg', 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mensajes`
--

DROP TABLE IF EXISTS `mensajes`;
CREATE TABLE IF NOT EXISTS `mensajes` (
  `idMensajes` int(11) NOT NULL,
  `correo` varchar(45) DEFAULT NULL,
  `telefono` varchar(45) DEFAULT NULL,
  `descripcion` varchar(45) DEFAULT NULL,
  `nombre` int(11) NOT NULL,
  PRIMARY KEY (`idMensajes`),
  KEY `fk_Mensajes_Persona1_idx` (`nombre`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `moneda`
--

DROP TABLE IF EXISTS `moneda`;
CREATE TABLE IF NOT EXISTS `moneda` (
  `idMoneda` int(11) NOT NULL,
  `descripcion` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`idMoneda`)
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

DROP TABLE IF EXISTS `municipio`;
CREATE TABLE IF NOT EXISTS `municipio` (
  `idMunicipio` int(11) NOT NULL,
  `nombre` varchar(45) DEFAULT NULL,
  `idDeptos` int(11) DEFAULT NULL,
  PRIMARY KEY (`idMunicipio`),
  KEY `fk_Municipio_Deptos1_idx` (`idDeptos`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `municipio`
--

INSERT INTO `municipio` (`idMunicipio`, `nombre`, `idDeptos`) VALUES
(1, 'Danli', 1),
(2, 'Catacamas', 2),
(3, 'Lepaterique', 3),
(4, 'Langue', 4),
(5, 'Villa de San Francisco', 5),
(6, 'Choluteca', 6),
(7, 'Tela', 7),
(8, 'San Luis', 8),
(9, 'Gracias', 9),
(10, 'Cucuyagua', 10),
(11, 'San Pedro Sula', 11);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `notificaciones`
--

DROP TABLE IF EXISTS `notificaciones`;
CREATE TABLE IF NOT EXISTS `notificaciones` (
  `idNotificaciones` int(11) NOT NULL,
  `cantidad` int(11) DEFAULT NULL,
  `descripcion` varchar(45) DEFAULT NULL,
  `idMensajes` int(11) NOT NULL,
  `idAnuncios` int(11) NOT NULL,
  `estado` varchar(2) DEFAULT NULL,
  PRIMARY KEY (`idNotificaciones`),
  KEY `fk_Notificaciones_Mensajes1_idx` (`idMensajes`),
  KEY `fk_Notificaciones_Anuncios1_idx` (`idAnuncios`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `persona`
--

DROP TABLE IF EXISTS `persona`;
CREATE TABLE IF NOT EXISTS `persona` (
  `idPersona` int(11) NOT NULL,
  `primerNombre` varchar(45) DEFAULT NULL,
  `segundoNombre` varchar(45) DEFAULT NULL,
  `primerApellido` varchar(45) DEFAULT NULL,
  `segundoApellido` varchar(45) DEFAULT NULL,
  `correo` varchar(45) DEFAULT NULL,
  `fechaNac` date DEFAULT NULL,
  `contrasenia` varchar(45) DEFAULT NULL,
  `idTipoUsuario` int(11) NOT NULL,
  `idMunicipio` int(11) NOT NULL,
  `estado` varchar(2) DEFAULT NULL,
  `codigo` varchar(250) NOT NULL,
  PRIMARY KEY (`idPersona`),
  KEY `fk_Persona_TipoUsuario1_idx` (`idTipoUsuario`),
  KEY `fk_Persona_Municipio1_idx` (`idMunicipio`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `persona`
--

INSERT INTO `persona` (`idPersona`, `primerNombre`, `segundoNombre`, `primerApellido`, `segundoApellido`, `correo`, `fechaNac`, `contrasenia`, `idTipoUsuario`, `idMunicipio`, `estado`, `codigo`) VALUES
(1, 'Juan', 'JosÃ©', 'Perez', 'Zuniga', 'pedro@gmail.com', '2000-02-09', 'pruebas', 1, 2, 'I', ''),
(2, 'Karen', 'Mariela', 'Pastrana', 'Perez', 'asd@gmail.com', '1992-12-12', 'pruebass', 2, 1, 'I', ''),
(3, 'Karen', 'Melissa', 'Per', 'ASD', 'knuez2013@gmail.com', '1990-12-12', '12345678', 3, 1, 'A', 'bcfe41f5247e6ee660ff606d952a8180'),
(4, 'Mariela', 'JazmÃ­n', 'Nunez', 'Canales', 'mari@gmail.com', '1995-04-23', '12345678', 3, 2, 'A', ''),
(5, 'Mariela', 'Jamin', 'Per', 'ASD', 'knuez@gmail.com', '2000-11-11', '12345678', 1, 2, 'I', '6dc9e4af86d49f061300733211173423'),
(6, 'Karen', 'Melissa', 'Nunez', 'Pastrana', 'kma@gmail.com', '2000-11-11', '12345678', 1, 1, 'I', 'c4a417a0e58ee85dcce82f42aaafce82'),
(7, 'Isis', 'Fabiola', 'Alvarado', 'Cerrato', 'alvaradoisis22@gmail.com', '1990-12-12', 'Fabiola123', 1, 2, 'A', 'ad6bf3efd234fc87c76f3158c2a973df');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto`
--

DROP TABLE IF EXISTS `producto`;
CREATE TABLE IF NOT EXISTS `producto` (
  `idProducto` int(11) NOT NULL,
  `nombre` varchar(45) DEFAULT NULL,
  `estado` varchar(2) DEFAULT NULL,
  `caracteristicas` varchar(1000) DEFAULT NULL,
  `idCategorias` int(11) NOT NULL,
  `tipoProducto` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`idProducto`),
  KEY `fk_Producto_Categorias1_idx` (`idCategorias`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `producto`
--

INSERT INTO `producto` (`idProducto`, `nombre`, `estado`, `caracteristicas`, `idCategorias`, `tipoProducto`) VALUES
(1, 'Prueba DE MELI', 'I', 'NO TIene', 1, '1'),
(2, 'Mesa', 'I', 'Cuatro patas,color cafe, en buen estado', 3, 'Servicios'),
(3, 'Servicios abogado', 'I', 'baratos', 1, 'Servicios'),
(4, 'Motor prueba', 'I', 'Motor buena calidad, tres meses garantia.', 4, 'Producto'),
(5, 'Cama Olimpia', 'A', 'En buen estado, para tres persona', 1, 'Producto'),
(6, 'Prestamos', 'I', 'Se presta dinero a corto plazo', 4, 'Servicios'),
(7, 'Vehiculos', 'I', 'aucto color rojo ', 5, 'Producto'),
(8, 'Microondas', 'A', 'Color:Blanco, usado, en buenas condiciones', 3, 'Producto'),
(9, 'Refrigeradora', 'I', 'Color gris, semi usada en buenas condiciones', 3, 'Producto'),
(10, 'Camioneta', 'I', 'Color roja, anio 2000, en buen estado,precio negociable', 4, 'Producto'),
(11, 'Camioneta', 'I', 'Color roja, anio 2000, en buen estado,precio negociable', 4, 'Producto'),
(12, 'Computadora DELL', 'I', 'Procesador dual core, 3GB RAM, Almacenamiento 500GB', 5, 'Producto'),
(13, 'Cama Motagua', 'I', 'Cama King size', 1, 'Producto'),
(14, 'Toyota 4*4', 'A', 'Color Rojo, doble cabina, anio 2019', 4, 'Producto'),
(15, 'Computadora LENOVO', 'I', '12 pulgadas, pantalla tactil, color negro...', 5, 'Producto'),
(16, 'Puerta Azul', 'I', 'hola', 1, 'Producto'),
(17, 'Computadora DELL', 'I', 'prueba', 5, 'Producto'),
(18, 'Puerta Azul', 'I', 'Esta es una prueba', 2, 'Producto'),
(19, 'Puerta Azul', 'I', 'prueba', 2, 'Producto'),
(20, 'PRUEBA 2', 'I', 'JJ', 3, 'Producto'),
(21, 'PRUEBA 2', 'I', 'JJ', 3, 'Producto'),
(22, 'PRUEBA 2', 'I', 'JJ', 3, 'Producto'),
(23, 'PRUEBA 2', 'I', 'JJ', 3, 'Producto'),
(24, 'Plancha para cabello', 'A', 'Marca CONAIR, en buen estado, con estuche gratis.', 1, 'Producto');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

DROP TABLE IF EXISTS `productos`;
CREATE TABLE IF NOT EXISTS `productos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) NOT NULL,
  `marca` varchar(50) NOT NULL,
  `descripcion` text NOT NULL,
  `categoria` int(11) NOT NULL,
  `precio` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `codigo` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id`, `nombre`, `marca`, `descripcion`, `categoria`, `precio`, `cantidad`, `codigo`) VALUES
(3, 'ProductoA', 'MarcaA', 'DescrpcionA', 2, 12, 2, 12345678),
(4, 'e', 'r', 'r', 1, 5, 6, 6),
(5, 'e', 'r', 'r', 1, 5, 6, 6);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `servicios`
--

DROP TABLE IF EXISTS `servicios`;
CREATE TABLE IF NOT EXISTS `servicios` (
  `idServicios` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`idServicios`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `serviciosporproducto`
--

DROP TABLE IF EXISTS `serviciosporproducto`;
CREATE TABLE IF NOT EXISTS `serviciosporproducto` (
  `Servicios_idServicios` int(11) NOT NULL,
  `Producto_idProducto` int(11) NOT NULL,
  PRIMARY KEY (`Servicios_idServicios`,`Producto_idProducto`),
  KEY `fk_Servicios_has_Producto_Producto1_idx` (`Producto_idProducto`),
  KEY `fk_Servicios_has_Producto_Servicios1_idx` (`Servicios_idServicios`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `telefono`
--

DROP TABLE IF EXISTS `telefono`;
CREATE TABLE IF NOT EXISTS `telefono` (
  `idTelefono` int(11) NOT NULL,
  `telefono` int(11) DEFAULT NULL,
  `idPersona` int(11) NOT NULL,
  PRIMARY KEY (`idTelefono`),
  KEY `fk_Telefono_Persona_idx` (`idPersona`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `telefono`
--

INSERT INTO `telefono` (`idTelefono`, `telefono`, `idPersona`) VALUES
(1, 98674532, 1),
(2, 23456789, 2),
(3, 99009900, 7);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipousuario`
--

DROP TABLE IF EXISTS `tipousuario`;
CREATE TABLE IF NOT EXISTS `tipousuario` (
  `idTipoUsuario` int(11) NOT NULL,
  `descripcion` varchar(45) DEFAULT NULL,
  `tiempoPublicacion` int(11) NOT NULL,
  PRIMARY KEY (`idTipoUsuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `tipousuario`
--

INSERT INTO `tipousuario` (`idTipoUsuario`, `descripcion`, `tiempoPublicacion`) VALUES
(1, 'Normal', 10),
(2, 'Empresa', 0),
(3, 'Administrador', 3);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vistadenuncias`
-- (Véase abajo para la vista actual)
--
DROP VIEW IF EXISTS `vistadenuncias`;
CREATE TABLE IF NOT EXISTS `vistadenuncias` (
`idDenuncias` int(11)
,`fecha` datetime
,`razones` varchar(45)
,`idAnuncios` int(11)
,`estado` varchar(2)
,`primerNombre` varchar(45)
,`segundoApellido` varchar(45)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vistadeptos`
-- (Véase abajo para la vista actual)
--
DROP VIEW IF EXISTS `vistadeptos`;
CREATE TABLE IF NOT EXISTS `vistadeptos` (
`idDeptos` int(11)
,`nombre` varchar(45)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vistamunicipios`
-- (Véase abajo para la vista actual)
--
DROP VIEW IF EXISTS `vistamunicipios`;
CREATE TABLE IF NOT EXISTS `vistamunicipios` (
`idMunicipio` int(11)
,`nombre` varchar(45)
,`idDeptos` int(11)
);

-- --------------------------------------------------------

--
-- Estructura para la vista `vistadenuncias`
--
DROP TABLE IF EXISTS `vistadenuncias`;

DROP VIEW IF EXISTS `vistadenuncias`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vistadenuncias`  AS  select `d`.`idDenuncias` AS `idDenuncias`,`d`.`fecha` AS `fecha`,`d`.`razones` AS `razones`,`d`.`idAnuncios` AS `idAnuncios`,`d`.`estado` AS `estado`,`p`.`primerNombre` AS `primerNombre`,`p`.`segundoApellido` AS `segundoApellido` from ((`denuncias` `d` join `anuncios` `a` on((`a`.`idAnuncios` = `d`.`idAnuncios`))) join `persona` `p` on((`p`.`idPersona` = `a`.`idPersona`))) ;

-- --------------------------------------------------------

--
-- Estructura para la vista `vistadeptos`
--
DROP TABLE IF EXISTS `vistadeptos`;

DROP VIEW IF EXISTS `vistadeptos`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vistadeptos`  AS  select `deptos`.`idDeptos` AS `idDeptos`,`deptos`.`nombre` AS `nombre` from `deptos` ;

-- --------------------------------------------------------

--
-- Estructura para la vista `vistamunicipios`
--
DROP TABLE IF EXISTS `vistamunicipios`;

DROP VIEW IF EXISTS `vistamunicipios`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vistamunicipios`  AS  select `municipio`.`idMunicipio` AS `idMunicipio`,`municipio`.`nombre` AS `nombre`,`municipio`.`idDeptos` AS `idDeptos` from `municipio` ;

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
  ADD CONSTRAINT `fk_Favoritos_Persona1` FOREIGN KEY (`idPersona`) REFERENCES `persona` (`idPersona`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_Favoritos_Persona2` FOREIGN KEY (`favorito`) REFERENCES `persona` (`idPersona`) ON DELETE NO ACTION ON UPDATE NO ACTION;

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
-- Filtros para la tabla `serviciosporproducto`
--
ALTER TABLE `serviciosporproducto`
  ADD CONSTRAINT `fk_Servicios_has_Producto_Producto1` FOREIGN KEY (`Producto_idProducto`) REFERENCES `producto` (`idProducto`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_Servicios_has_Producto_Servicios1` FOREIGN KEY (`Servicios_idServicios`) REFERENCES `servicios` (`idServicios`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `telefono`
--
ALTER TABLE `telefono`
  ADD CONSTRAINT `fk_Telefono_Persona` FOREIGN KEY (`idPersona`) REFERENCES `persona` (`idPersona`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
