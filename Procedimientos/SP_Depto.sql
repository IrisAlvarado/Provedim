

CREATE PROCEDURE SP_DEPARTAMENTO(
								IN nombredepto 		VARCHAR(45),
								IN idDepto 		VARCHAR(45), 
								IN accion				VARCHAR(30),
								OUT codeMessage 		INT,
								OUT message 			VARCHAR(100)) 
SP:BEGIN
	DECLARE conteo INT;
	DECLARE tempMensaje	VARCHAR(100);
	SET autocommit=0;  
	SET tempMensaje='';
	START TRANSACTION;	
	IF nombredepto='' THEN
		SET tempMensaje='Departamento ,';
	END IF;
	IF tempMensaje<>'' THEN
		SET message=CONCAT('Campos requeridos',tempMensaje);
		SET codeMessage=1;
		LEAVE SP;
	END IF;
	SELECT count(*) INTO conteo FROM deptos
	WHERE nombre=nombredepto;

	IF accion="Agregar" THEN
		IF conteo=1 THEN
			SET message=CONCAT('El departamento ya existe, depto enviado:',nombredepto);
			SET codeMessage=1;
			LEAVE SP;
		END IF;

		INSERT INTO `deptos`(`nombre`) VALUES (nombredepto);
		SET message='Depto agregado correctamente';
		SET codeMessage=0;
		COMMIT;
	END IF;

	IF accion="Eliminar" THEN
		IF idDepto='' THEN
		SET tempMensaje='id departamento ,';
		END IF;
		IF tempMensaje<>'' THEN
			SET message=CONCAT('Campos requeridos',tempMensaje);
			SET codeMessage=1;
			LEAVE SP;
		END IF;

		SELECT count(*) INTO conteo FROM deptos
		WHERE idDeptos=idDepto;
		IF conteo=0 THEN
			SET message=CONCAT('El departamento no existe, depto enviado:',nombredepto);
			SET codeMessage=1;
			LEAVE SP;
		END IF;

		DELETE FROM `deptos` WHERE nombre=nombredepto;
		SET message='Depto eliminado correctamente';
		SET codeMessage=0;
		COMMIT;
	END IF;

	IF accion="Editar" THEN
		IF idDepto='' THEN
		SET tempMensaje='id departamento ,';
		END IF;
		IF tempMensaje<>'' THEN
			SET message=CONCAT('Campos requeridos',tempMensaje);
			SET codeMessage=1;
			LEAVE SP;
		END IF;

		SELECT count(*) INTO conteo FROM deptos
		WHERE idDeptos=idDepto;
		IF conteo=0 THEN
			SET message=CONCAT('El departamento no existe, depto enviado:',nombredepto);
			SET codeMessage=1;
			LEAVE SP;
		END IF;

		UPDATE `deptos` SET `nombre`=nombredepto WHERE idDeptos=idDepto;
		SET message='Depto actualizado correctamente';
		SET codeMessage=0;
		COMMIT;
	END IF;

	IF accion="Buscar" THEN
		IF conteo=0 THEN
			SET message=CONCAT('El departamento no existe, depto enviado:',nombredepto);
			SET codeMessage=1;
			LEAVE SP;
		END IF;

		SET message='Depto encontrado correctamente';
		SET codeMessage=0;
		COMMIT;
	END IF;
		

END$$


/*como llamarlo*/
SET @p0='Olancho'; SET @p1=''; SET @p2='Agregar'; 
CALL `SP_DEPARTAMENTO`(@p0, @p1, @p2, @p3, @p4); SELECT @p3 AS `codeMessage`, @p4 AS `message`;


/*vista deptos*/

CREATE OR REPLACE VIEW vistaDeptos AS SELECT * FROM deptos;


/* ver vista deptos*/
SELECT *FROM vistadeptos;

/* crear vista municipios*/
CREATE or REPLACE VIEW vistaMunicipios AS SELECT *FROM municipio;

/* ver vista municipios*/
SELECT *FROM vistaMunicipios;