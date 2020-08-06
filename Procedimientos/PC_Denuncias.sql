

CREATE OR REPLACE PROCEDURE SP_DENUNCIAS(
                  IN accion VARCHAR(45),
                  IN idAnuncio INT,
                  IN idDenuncia INT,
                  IN idDenunciante INT,
                  IN razon VARCHAR(100),
                  IN estado VARCHAR(2),
                  OUT mensaje VARCHAR(100)) 
SP:BEGIN
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