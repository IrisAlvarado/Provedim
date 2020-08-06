CREATE PROCEDURE SP_CAMBIAR_TIEMPO_USUARIO_NORMAL(
                    IN cantidadDiasIN INT,
                    OUT mensaje VARCHAR(100),
                    OUT codigo VARCHAR(2),
                    OUT cantidadDiasOut INT) 
SP:BEGIN
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
