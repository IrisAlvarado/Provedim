
//Cambio en la tabla Denuncias//
ALTER TABLE denuncias CHANGE pubDenunciada cantidad INT(11) NULL DEFAULT NULL;


//Agregar campo en la tabla denuncias
ALTER TABLE denunciasadd denunciante INTEGER;
ALTER TABLE denuncias ADD FOREIGN KEY (denunciante) REFERENCES persona (idPersona) ;


//Agregar campo en la tabla anuncios
ALTER TABLE anunciosadd fecha DATETIME;

//SP Reportes

DELIMITER $$
CREATE OR REPLACE PROCEDURE SP_REPORTES(
                  IN accion VARCHAR(45), 
                  OUT mensaje VARCHAR(100))
SP:BEGIN
  DECLARE conteo INT;
  DECLARE tempMensaje VARCHAR(100);
  SET autocommit=0;  
  SET tempMensaje='';
  START TRANSACTION;
  IF accion='' THEN
    SET tempMensaje='Accion';
  END IF;  
  IF tempMensaje<>'' THEN
    SET mensaje=CONCAT('Campo requerido ',tempMensaje);
    LEAVE SP;
  END IF;
  

  IF accion="obtenerDenuncias" THEN
      SELECT d.idDenuncias, CONCAT(p.primerNombre, ' ',p.primerApellido) as idPersona,(SELECT CONCAT(primerNombre, ' ',primerApellido) from persona where idPersona=d.denunciante)  'denunciante',a.idAnuncios,pro.tipo, d.cantidad, d.razones FROM denuncias d
    INNER JOIN anuncios a on a.idAnuncios=d.idAnuncios
    INNER JOIN persona p on p.idPersona=a.idPersona
    INNER JOIN producto pro on pro.idProducto=a.idPersona
    WHERE d.estado="A" OR "a";
      SET mensaje='Exitoso';
      COMMIT;
  END IF;  

  IF accion="obtenerUsuarios" THEN
      SELECT  p.idPersona,CONCAT(p.primerNombre,' ', p.primerApellido) as concatenacion,dep.nombre 'nombreDepto', mun.nombre, (SELECT COUNT(idAnuncios) FROM anuncios  WHERE a.idPersona=p.idPersona) as conteo, d.cantidad, p.estado  FROM persona p
    INNER JOIN municipio mun on mun.idMunicipio=p.idMunicipio
    INNER JOIN deptos dep on dep.idDeptos = mun.idDeptos
    INNER JOIN anuncios a on a.idPersona = p.idPersona
    INNER JOIN denuncias d on d.idAnuncios = a.idAnuncios;
    
      SET mensaje='Exitoso';
      COMMIT;
  END IF; 

   
END$$
DELIMITER ;






