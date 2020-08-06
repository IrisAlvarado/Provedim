/*agregue este campo*/
ALTER TABLE categorias ADD estado VARCHAR(2) NULL ;

CREATE OR REPLACE PROCEDURE SP_CATEGORIAS(
                  IN nombreCategoria VARCHAR(50),
                  IN idcategoria INT,
                  IN accion VARCHAR(45),
                  IN pestado VARCHAR(2),
                  OUT mensaje VARCHAR(100)) 
SP:BEGIN
  DECLARE conteo INT;
  DECLARE conteo2 INT;
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
      SELECT MAX(idCategorias) INTO conteo2 FROM categorias;
      IF conteo2=0 THEN
        SET id=1;
      ELSE
        SET id=conteo2+1;
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
