CREATE  PROCEDURE SP_REGISTRO_USUARIO_ADMINISTRADOR(
                    IN ppNombre VARCHAR(50),
                    IN psNombre VARCHAR(50),
                    IN ppApellido VARCHAR(50),
                    IN psApellido VARCHAR(50),
                    IN pcorreo VARCHAR(50),
                    IN pcontrasenia VARCHAR(50),
                    IN pfechaNac VARCHAR(10),
                    IN pmunicipio INT,
                    IN INtelefono INT,
                    OUT mensaje VARCHAR(100),
                    OUT codigo VARCHAR(2),
                    OUT idUsuario INT) 
SP:BEGIN
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
