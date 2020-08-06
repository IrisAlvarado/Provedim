CREATE OR REPLACE PROCEDURE SP_PRODUCTOS_Y_SERVICIOS(
                  IN nombrePS VARCHAR(50),
                  IN descripcion VARCHAR(1000),
                  IN ptipo VARCHAR(10),
                  IN pidcategoria INT,
                  IN pidProducto INT,
                  IN accion VARCHAR(45),
                  IN pestado VARCHAR(2),
                  OUT mensaje VARCHAR(100)) 
SP:BEGIN
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
      where p.estado="A";
      -- where p.estado="A" and p.tipoProducto=ptipo;
      SET mensaje='Exitoso';
  END IF;

  IF accion="obtenerInactivos" THEN
      SELECT * FROM producto where estado="I" and p.tipo=ptipo;
      SET mensaje='Exitoso';
  END IF;

  IF accion="obtenerCategorias" THEN
      SELECT c.idCategorias, c.descripcion 'categoria', p.tipoProducto
      FROM producto p 
      INNER join categorias c on c.idCategorias=p.idcategorias 
      WHERE c.estado="A";
      -- and p.tipo=ptipo
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
      SET mensaje='No existe la categoria';
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
