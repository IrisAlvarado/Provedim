CREATE  PROCEDURE SP_REGISTRO_USUARIO(
                    IN ppNombre VARCHAR(50),
                    IN ppApellido VARCHAR(50),
                    IN psApellido VARCHAR(50),
                    IN pcorreo VARCHAR(50),
                    IN pcontrasenia VARCHAR(50),
                    IN pdireccion VARCHAR(10),
                    IN ptipoUsuario INT,
                    IN codigoIN VARCHAR(250),
                    OUT mensaje VARCHAR(100),
                    OUT codigo VARCHAR(2),
                    OUT idUsuario INT) 
SP:BEGIN
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
        SET tempMensaje='direccion,';
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
        insert into `persona` (`idPersona`, `primerNombre`, `segundoNombre`, `primerApellido`, `segundoApellido`, `correo`, `direccion`, `contrasenia`, `idTipoUsuario`,`idMunicipio`, `estado`, `codigo`) 
        values(pid, ppNombre, "Null", ppApellido, psApellido, pcorreo, pdireccion, pcontrasenia, ptipoUsuario, "NULL", "I", codigoIN);


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