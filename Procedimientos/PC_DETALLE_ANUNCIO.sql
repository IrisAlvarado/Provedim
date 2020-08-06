/*Cambio de tipo dato*/
ALTER TABLE calificacion 
CHANGE puntuacion puntuacion 
INT(45) NULL DEFAULT NULL;

/*procedimiento de detalle de publicacion*/
DELIMITER $$
CREATE OR REPLACE PROCEDURE SP_DETALLE_PUBLICACION(
                  IN idUsuarioDaLike INT,
                  IN pidCalificacion INT,
                  IN idPublicacion INT,
                  IN idUsuarioRecibeLike INT,
                  IN cantidad INT,
                  IN prazones VARCHAR(200),
                  IN accion VARCHAR(45),
                  IN pestado VARCHAR(2),
                  OUT mensaje VARCHAR(100)) 
SP:BEGIN
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
