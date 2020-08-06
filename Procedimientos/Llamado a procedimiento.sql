SET @p0='Yalid'; SET @p1='Anthony'; SET @p2='Guevara';  SET @p3='Castro';  SET @p4='yalid@gmail.es'; SET @p5='asd.456';  SET @p6='2001-08-26'; SET @p7=1; 


CALL `SP_REGISTRO_USUARIO_ADMINISTRADOR`(@p0, @p1, @p2, @p3, @p4, @p5, @p6, @p7, @p8, @p9, @p10); SELECT @p8 AS `mensaje`, @p9 AS `codigo`, @p10 AS `idUsuario`;
