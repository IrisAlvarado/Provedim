CREATE OR REPLACE PROCEDURE SP_CANTIDAD_ADMIN(
                  IN accion VARCHAR(45),
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
