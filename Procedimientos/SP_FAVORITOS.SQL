CREATE OR REPLACE  PROCEDURE SP_FAVORITOS(
                    IN IN_idPersona INT,
                    IN IN_idAnuncio INT,
                    IN accion VARCHAR(20),
                    OUT codigo INT,
                    OUT mensaje VARCHAR(100)
                    ) 
SP:BEGIN
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
