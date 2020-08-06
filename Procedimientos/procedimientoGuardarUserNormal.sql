CREATE OR REPLACE PROCEDURE SP_REGISTRO_USUARIO(
                    IN ppNombre VARCHAR(50),
                    IN psNombre VARCHAR(50),
                    IN ppApellido VARCHAR(50),
                    IN psApellido VARCHAR(50),
                    IN pcorreo VARCHAR(50),
                    IN ptelefono VARCHAR(50),
                    IN pcontrasenia VARCHAR(50),
                    IN pfechaNac VARCHAR(10),
                    IN pmunicipio INT,
                    IN ptipoUsuario INT,
                    OUT mensaje VARCHAR(100),
                    OUT codigo VARCHAR(2),
                    OUT idUsuario INT) 
SP:BEGIN
    DECLARE conteo INT;
    DECLARE id INT;
    DECLARE idTel INT;
    DECLARE pid INT;
    DECLARE pidTel INT;

    DECLARE tempMensaje VARCHAR(100);
    SET autocommit=0;  
    SET tempMensaje='';
    START TRANSACTION;  


    IF ppNombre=''THEN
        SET tempMensaje='Primer Nombre ,';
    END IF;
    IF  psNombre='' THEN
        SET tempMensaje='SegundoNombre ,';
    END IF;
    IF ppApellido=''  THEN
        SET tempMensaje='Primer Apellido ,';
    END IF;
    IF psApellido THEN
        SET tempMensaje='Segundo Apellido ,';
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
    IF ptelefono='' THEN
        SET tempMensaje='Telefono ,';
    END IF;
    IF pmunicipio<1 THEN
        SET tempMensaje='Municipio ,';
    END IF;
    IF ptipoUsuario<1 THEN
        SET tempMensaje='Tipo usuario ';
    END IF;
    
    IF tempMensaje<>'' THEN
        SET mensaje=CONCAT('Campos requeridos ',tempMensaje);
        LEAVE SP;
    END IF;
    
    SELECT count(*) INTO conteo FROM persona
    WHERE correo=pcorreo;
    
    IF conteo=0 THEN
        SELECT MAX(idPersona) into id FROM persona;



        SET pid=id+1; 
        insert into persona (idPersona, primerNombre, segundoNombre, primerApellido, segundoApellido, correo, fechaNac, contrasenia, idTipoUsuario, idMunicipio, estado) 
        values(pid, ppNombre, psNombre, ppApellido, psApellido, pcorreo, pfechaNac, pcontrasenia, ptipoUsuario, pMunicipio, "A");

        SELECT MAX(idTelefono) into idTel FROM telefono;
        SET pidTel=idTel+1;
        
        INSERT INTO telefono(idTelefono, telefono, idPersona) 
        VALUES (pidTel,ptelefono,pid);
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

SET @p0='Pablo'; SET @p1='Pedro'; 
SET @p2='Perez'; SET @p3='ramirez'; 
SET @p4='pablo@gmail.com'; SET @p5='23456789'; 
SET @p6='12345678'; SET @p7='12-12-1990'; 
SET @p8='1'; 
CALL `SP_REGISTRO_USUARIO`(@p0, @p1, @p2, @p3, 
    @p4, @p5, @p6, @p7, @p8, @p9, @p10, @p11); 
SELECT @p9 
AS `mensaje`, @p10 AS `codigo`, @p11 AS `idUsuario`;