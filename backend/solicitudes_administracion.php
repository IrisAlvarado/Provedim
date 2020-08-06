<?php

$mysqli = new mysqli( 'localhost:3306', 'root', '', 'mydb' );

switch($_POST["accion"]){
    case "cargarSolicitudes":
    
        $idPersona;    
        $primerNombre;
        $primerApellido;
        $correo;
        $edad;
        $municipio;
        $departamento;
    
    
        //TODO: hacer subconsulta para traer id tipo usuario
        $stmt = $mysqli -> prepare('
                select  p.idPersona ,primerNombre, primerApellido , correo , DATEDIFF(NOW(), p.fechaNac )/365 edad , 
                mu.nombre municipio , de.nombre departamento from persona p 
                inner join municipio mu on mu.idMunicipio = p.idMunicipio 
                inner join deptos de on de.idDeptos = mu.idDeptos
                where p.idTipoUsuario = 
                (select t2.idTipoUsuario from tipousuario t2 where t2.descripcion like "%Administrador%")
                and p.estado like "%I"
                ');
        
        // $stmt -> bind_param('i', $userId);
        $stmt -> execute();
        $stmt -> store_result();
        $stmt -> bind_result( 
            $idPersona,
            $primerNombre,
            $primerApellido,
            $correo,
            $edad,
            $municipio,
            $departamento
        );
    
    
        $respuesta = array();
    
        $index = 0;
        
        while($stmt -> fetch()){
    
            $respuesta[$index] =  array(
                "idPersona"=>$idPersona,   
                "primerNombre"=>$primerNombre,
                "primerApellido"=>$primerApellido,
                "correo"=>$correo,
                "edad"=>$edad,
                "municipio"=>$municipio,
                "departamento"=>$departamento
            );
    
            $index++;
        }
        
        echo json_encode($respuesta);
    break;

    case "darDeBaja":

        echo json_encode(array("idPersona"=>$_POST["idPersona"]));

    break;

    case "aceptarSolicitud":
        
        $idPersona = $_POST["idPersona"];

        $stmt = $mysqli -> prepare('UPDATE persona  SET estado = "A"  WHERE idPersona = ?');
        $stmt->bind_param('i', $idPersona);

        $stmt -> execute();
        // $stmt -> store_result();
        // $stmt -> bind_result( );
        // $stmt -> fetch();


        echo (json_encode(array("idPersona"=>$_POST["idPersona"])));
    break;
}

?>