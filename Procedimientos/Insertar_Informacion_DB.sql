INSERT INTO mydb.persona
(idPersona, primerNombre, segundoNombre, primerApellido, segundoApellido, correo, fechaNac, contrasenia, idTipoUsuario, idMunicipio, estado)
VALUES(0, '', '', '', '', '', '', '', 0, 0, '');


--usuarios

INSERT INTO mydb.tipousuario
(idTipoUsuario, descripcion)
VALUES(2, 'Comerciante');

INSERT INTO mydb.tipousuario
(idTipoUsuario, descripcion)
VALUES(3, 'Administrador');


--deptos
INSERT INTO mydb.deptos
(idDeptos, nombre)
VALUES(2, 'Cortés');

INSERT INTO mydb.deptos
(idDeptos, nombre)
VALUES(3, 'Atlántida');


--municipios

INSERT INTO mydb.municipio
(idMunicipio, nombre, idDeptos)
VALUES(2, 'Valle de Ángeles', 1);

INSERT INTO mydb.municipio
(idMunicipio, nombre, idDeptos)
VALUES(3, 'Santa Lucía', 1);