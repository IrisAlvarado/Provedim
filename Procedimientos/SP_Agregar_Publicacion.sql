/*agregue este campo*/
ALTER TABLE `anuncios` ADD `razones` 
VARCHAR(500) NULL AFTER `fecha`;

DELIMITER $$
CREATE OR REPLACE PROCEDURE SP_AGREGAR_PUB(
              IN nombreProducto VARCHAR(200), 
              IN caracteristicas VARCHAR(500), 
              IN idCategoria INT, 
              IN ptipo VARCHAR(50), 
              IN pprecio INT,
              IN pidPersona INT, 
              IN pidMoneda INT, 
              IN idAnuncio INT, 
              IN url VARCHAR(500), 
              IN accion VARCHAR(100), 
              OUT mensaje VARCHAR(100))
SP:BEGIN

  DECLARE idPro INT;
  DECLARE idAnu INT;
  DECLARE idUrl INT;
  DECLARE conteoU INT;
  DECLARE conteoP INT;
  DECLARE conteoA INT;
  DECLARE totalFotos INT;
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
   IF nombreProducto='' THEN
       SET tempMensaje='Nombre, ';
   END IF;
   IF caracteristicas=''  THEN
       SET tempMensaje='Caracteristicas, ';
   END IF;
   IF idCategoria='' THEN
       SET tempMensaje='Categoria,';
   END IF;
   IF pprecio='' THEN
       SET tempMensaje='Precio ,';
   END IF;
   IF ptipo='' THEN
       SET tempMensaje='Tipo,';
   END IF;
   IF pidPersona='' THEN
       SET tempMensaje='Persona,';
   END IF;
   IF pidMoneda='' THEN
       SET tempMensaje='Moneda,';
   END IF;

   IF tempMensaje<>'' THEN
       SET mensaje=CONCAT('Campos requeridos ',tempMensaje);
       LEAVE SP;
   END IF;
  END IF;

  IF accion="eliminar" OR accion="editar" 
  OR accion="editarFoto" OR
  accion="obtenerFotos" OR accion="eliminarFoto"  THEN
        IF idAnuncio='' OR idAnuncio=0  THEN
          SET tempMensaje='Id Anuncio ';
        END IF; 
        IF tempMensaje<>'' THEN
          SET mensaje=CONCAT('Campo requerido ',tempMensaje);
          LEAVE SP;
        END IF;
  END IF;
  
IF accion="guardarFoto" OR accion="editarFoto"  THEN
        IF url='' THEN
          SET tempMensaje='URL Foto ';
        END IF; 
        IF tempMensaje<>'' THEN
          SET mensaje=CONCAT('Campo requerido ',tempMensaje);
          LEAVE SP;
        END IF;
  END IF;

  IF accion="obtenerAnuncio" THEN
    IF pidPersona='' OR pidPersona=0  THEN
      SET tempMensaje='Id Persona ';
    END IF; 
    IF tempMensaje<>'' THEN
      SET mensaje=CONCAT('Campo requerido ',tempMensaje);
      LEAVE SP;
    END IF;
  END IF;

  IF accion="guardar"  THEN
   SELECT count(*) INTO idPro FROM producto;
   SELECT count(*) INTO idAnu FROM anuncios;

   IF idPro=0 THEN
    SET conteoP=1;
   END IF;
   IF idAnu=0 THEN
    SET conteoA=1;
   END IF;
   IF idPro>0 AND idAnu>0 THEN
    SELECT MAX(idProducto) INTO idPro FROM producto;
    SELECT MAX(idAnuncios) INTO idAnu FROM anuncios;
    SET conteoP=idPro+1;
    SET conteoA=idAnu+1;
   END IF;

   INSERT INTO producto (idProducto, nombre, estado, caracteristicas, idCategorias, tipo) 
   VALUES(conteoP,nombreProducto, "A",caracteristicas, idCategoria, ptipo);

   INSERT INTO anuncios(idAnuncios,titulo,descripcion,precio,idPersona,idMoneda,idProducto,estado, fecha) 
   VALUES(conteoA,nombreProducto, caracteristicas, pprecio, pidPersona, pidMoneda, conteoP , "A",CURDATE());

   SET mensaje='Registro exitoso';
   COMMIT; 
  END IF; 
  
  IF accion="editar" THEN
   SELECT count(*) INTO conteoA FROM anuncios
   WHERE idAnuncios=idAnuncio;
   SELECT idProducto INTO conteoP FROM anuncios
   WHERE idAnuncios=idAnuncio;

   IF conteoA=0 THEN
    SET mensaje='No existe el anuncio';
    LEAVE SP;
   END IF;
   IF conteoA>0 THEN
    UPDATE anuncios SET titulo=nombreProducto,
    descripcion=caracteristicas,
    precio=pprecio,idMoneda=pidMoneda 
    WHERE idAnuncios=idAnuncio;

    UPDATE producto SET nombre=nombreProducto,
    caracteristicas=caracteristicas,
    idCategorias=idCategoria,tipo=ptipo 
    WHERE idProducto=conteoP;
    SET mensaje='Edicion exitosa';
    COMMIT;
   END IF;
  END IF;

  IF accion="eliminar" THEN

  IF caracteristicas='' THEN
    SET tempMensaje='Razon de eliminar Anuncio.';
  END IF; 
  IF tempMensaje<>'' THEN
   SET mensaje=CONCAT('Campo requerido ',tempMensaje);
   LEAVE SP;
  END IF;

   SELECT count(*) INTO conteoA FROM anuncios
   WHERE idAnuncios=idAnuncio;

   IF conteoA=0 THEN
     SET mensaje='No existe el anuncio';
     LEAVE SP;
   END IF;

   SELECT idProducto INTO conteoP FROM anuncios
   WHERE idAnuncios=idAnuncio;
   IF conteoA=1 THEN
    UPDATE anuncios SET estado='I',razones=caracteristicas
    WHERE idAnuncios=idAnuncio;
    UPDATE producto SET estado='I' 
    WHERE idProducto=conteoP;
    SET mensaje='Eliminado exitosamente';
    COMMIT;
   END IF;
  END IF;

  IF accion="obtenerAnuncio" THEN
   SELECT a.idAnuncios, a.titulo, a.descripcion, 
   a.precio, a.idPersona, a.idMoneda, a.idProducto, 
   a.estado, a.fecha , p.idCategorias, p.tipo, 
   c.descripcion 'categoria',m.descripcion 'moneda'
   FROM anuncios a
   INNER JOIN producto p on p.idProducto=a.idProducto
   INNER JOIN categorias c on c.idCategorias=p.idCategorias
   INNER JOIN moneda m on m.idMoneda=a.idMoneda
   WHERE a.idPersona=pidPersona AND LOWER(a.estado)=LOWER('A')
   ORDER by fecha DESC;
   SET mensaje='Consulta exitosamente';
  END IF;

  IF accion="guardarFoto" THEN

   SELECT count(*) INTO conteoA  
   FROM fotosanuncio;
   IF conteoA=0 THEN
    SET idUrl=conteoA+1; 
   END IF;
   IF conteoA>0 THEN
    SELECT MAX(idFotos) INTO conteoP  
    FROM fotosanuncio;
    SET idUrl=conteoP+1;
   END IF;
    SELECT MAX(idAnuncios) INTO conteoA 
    FROM anuncios;

   SELECT count(*) INTO totalFotos  
   FROM fotosanuncio WHERE idAnuncios=conteoA;
   IF totalFotos<9 THEN 
    INSERT INTO fotosanuncio(idFotos, cantidad, 
    urlFoto, idAnuncios) 
    VALUES (idUrl,1,url,conteoA);
    SET mensaje='Foto guardada exitosamente';
    COMMIT;
   END IF; 
   IF totalFotos>8 THEN
     SET mensaje='Solo puede guardar 8 fotos maximo';
     LEAVE SP;
   END IF;
  END IF;

  IF accion="editarFoto" THEN

   SELECT count(*) INTO conteoA  
   FROM fotosanuncio;
   IF conteoA=0 THEN
    SET idUrl=conteoA+1; 
   END IF;
   IF conteoA>0 THEN
    SELECT MAX(idFotos) INTO conteoP  
    FROM fotosanuncio;
    SET idUrl=conteoP+1;
   END IF;

   SELECT count(*) INTO totalFotos  
   FROM fotosanuncio WHERE idAnuncios=idAnuncio;
   IF totalFotos<9 THEN 
    INSERT INTO fotosanuncio(idFotos, cantidad, 
    urlFoto, idAnuncios) 
    VALUES (idUrl,1,url,idAnuncio);
    SET mensaje='Foto guardada exitosamente';
    COMMIT;
   END IF; 
   IF totalFotos>8 THEN
     SET mensaje='Solo puede guardar 8 fotos maximo';
     LEAVE SP;
   END IF;
  END IF;

  IF accion="eliminarFoto" THEN

   SELECT COUNT(*) INTO conteoU FROM fotosanuncio 
   WHERE idFotos=idAnuncio;

   IF conteoU=0 THEN 
     SET mensaje='No existe la foto';
     LEAVE SP;
   END IF;
   IF conteoU=1 THEN

    DELETE FROM fotosanuncio 
    WHERE idFotos = idAnuncio;
    SET mensaje='Eliminada exitosamente';
    COMMIT;
   END IF; 
  END IF;

  IF accion="obtenerFotos" THEN
   SELECT count(*) into conteoU FROM fotosanuncio 
   WHERE idAnuncios=idAnuncio;

   IF conteoU=0 THEN
    SET mensaje='Este anuncio no tiene fotos';
    LEAVE SP;
   END IF;
   IF conteoU>0 THEN
    SELECT idFotos, urlFoto, idAnuncios 
    FROM fotosanuncio WHERE idAnuncios=idAnuncio;
    SET mensaje='Fotos con exito';
   END IF;
  END IF;

  
END$$
DELIMITER ;

