<?php

$mysqli = new mysqli( 'localhost:3308', 'root', '', 'mydb' );

$consulta='SELECT per.primerNombre, per.primerApellido, tip.descripcion tipoUsuario, per.fechaNac fechaNacimiento, tel.telefono, per.correo, dep.nombre departamento, mun.nombre municipio, per.estado, per.idPersona FROM persona per
inner join tipousuario tip on per.idTipoUsuario=tip.idTipoUsuario
inner join municipio mun on per.idMunicipio=mun.idMunicipio
inner join deptos dep on mun.idDeptos=dep.idDeptos
inner join telefono tel on per.idPersona=tel.idPersona';


switch ($_GET["action"]) {

    case "getUsuarios":

    $primerNombr;
    $primerApellido;
    $tipoUsuario;
    $fechaNacimiento;
    $telefono;
    $correo;
    $departamento;
    $municipio;
    $estado;
    $idPersona;


        $stmt = $mysqli -> prepare(
            $consulta);

        $stmt -> execute();
        $stmt -> store_result();
        $stmt -> bind_result(
            $primerNombre,
            $primerApellido,
            $tipoUsuario,
            $fechaNacimiento,
            $telefono,
            $correo,
            $departamento,
            $municipio,
            $estado,
            $idPersona
            );


        $respuesta = array();

        $index = 0;

        while($stmt -> fetch()){

            $respuesta[$index] =  array(
                "primerNombre"=>$primerNombre,
                "primerApellido"=>$primerApellido,
                "tipoUsuario"=>$tipoUsuario,
                "fechaNacimiento"=>$fechaNacimiento,
                "telefono"=>$telefono,
                "correo"=>$correo,
                "departamento"=>$departamento,
                "municipio"=>$municipio,
                "estado"=>$estado,
                "idPersona"=>$idPersona
            );

            $index++;
        }

        echo json_encode($respuesta);
        break;

        case "darDeBaja":
            $idPersona = $_GET["idPersona"];

            $stmt = $mysqli -> prepare('UPDATE persona  SET estado = "I"  WHERE idPersona = ?');
            $stmt->bind_param('i', $idPersona);

            $stmt -> execute();
            echo (json_encode(array("idPersona"=>$_GET["idPersona"])));

        break;

        case "seleccionarTipoUsuarios":

            $idTipoUsuario;
            $descripcion;

            $stmt = $mysqli -> prepare(
                'SELECT idTipoUsuario, descripcion FROM tipousuario'
                );

            $stmt -> execute();
            $stmt -> store_result();
            $stmt -> bind_result(
                $idTipoUsuario,
                $descripcion);


            $respuesta = array();

            $index = 0;

            while($stmt -> fetch()){

                $respuesta[$index] =  array(
                    "idTipoUsuario"=>$idTipoUsuario,
                    "descripcion"=>$descripcion,
                );

                $index++;
            }

            echo json_encode($respuesta);
        break;

        case "seleccionarDepartamento":

            $idDeptos;
            $nombre;

            $stmt = $mysqli -> prepare(
                'SELECT * FROM deptos'
                );

            $stmt -> execute();
            $stmt -> store_result();
            $stmt -> bind_result(
                $idDeptos,
                $nombre);


            $respuesta = array();

            $index = 0;

            while($stmt -> fetch()){

                $respuesta[$index] =  array(
                    "idDeptos"=>$idDeptos,
                    "nombre"=>$nombre
                );

                $index++;
            }

            echo json_encode($respuesta);
        break;

        case "seleccionarMunicipio":

            $idMunicipio;
            $nombre;

            $stmt = $mysqli -> prepare(
                'SELECT idMunicipio, nombre FROM municipio'
                );

            $stmt -> execute();
            $stmt -> store_result();
            $stmt -> bind_result(
                $idMunicipio,
                $nombre);


            $respuesta = array();

            $index = 0;

            while($stmt -> fetch()){

                $respuesta[$index] =  array(
                    "idMunicipio"=>$idMunicipio,
                    "nombre"=>$nombre,
                );

                $index++;
            }

            echo json_encode($respuesta);
        break;

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        case "busquedaNombreUsuario":

        $palabraClave = $_GET["palabraClave"];
        $palabra="%$palabraClave%";
        $stmt = $mysqli -> prepare(
            'SELECT per.primerNombre, per.primerApellido, tip.descripcion tipoUsuario, per.fechaNac fechaNacimiento, tel.telefono, per.correo, dep.nombre departamento, mun.nombre municipio, per.estado, per.idPersona FROM persona per
            inner join tipousuario tip on per.idTipoUsuario=tip.idTipoUsuario
            inner join municipio mun on per.idMunicipio=mun.idMunicipio
            inner join deptos dep on mun.idDeptos=dep.idDeptos
            inner join telefono tel on per.idPersona=tel.idPersona WHERE per.primerNombre LIKE ?');
        $stmt->bind_param('s', $palabra);
        $stmt -> execute();
        $stmt -> store_result();
        $stmt -> bind_result(
            $primerNombre,
            $primerApellido,
            $tipoUsuario,
            $fechaNacimiento,
            $telefono,
            $correo,
            $departamento,
            $municipio,
            $estado,
            $idPersona
            );


        $respuesta = array();

        $index = 0;

        while($stmt -> fetch()){

            $respuesta[$index] =  array(
                "primerNombre"=>$primerNombre,
                "primerApellido"=>$primerApellido,
                "tipoUsuario"=>$tipoUsuario,
                "fechaNacimiento"=>$fechaNacimiento,
                "telefono"=>$telefono,
                "correo"=>$correo,
                "departamento"=>$departamento,
                "municipio"=>$municipio,
                "estado"=>$estado,
                "idPersona"=>$idPersona
            );

            $index++;
        }

        echo json_encode($respuesta);

        break;

//***************************************************CONSULTAS DE FILTRADO DE LA TABLA******************************//
        case "filtrar":
        $estado1 = 0;
        $estado2 = 0;
        $estado3 = 0;
        $estado4 = 0;

        if (isset($_GET["idUsuario"])) {
            $idUsuario = $_GET["idUsuario"];
            $estado1 = 1;
        }
        if (isset($_GET["idDepto"]) ) {
            $idDepto = $_GET["idDepto"];
            $estado2 = 1;
        }
         if (isset($_GET["idMunicipio"]) ) {
            $idMun = $_GET["idMunicipio"];
            $estado3 = 1;
        }
         if (isset($_GET["idEstado"]) ) {
            $idEstado = $_GET["idEstado"];
            $estado4 = 1;
        }

        if ($estado1 == 1 && $estado2 == 0 && $estado3 == 0 && $estado4 == 0) {
             $stmt = $mysqli -> prepare(
            'SELECT per.primerNombre, per.primerApellido, tip.descripcion tipoUsuario, per.fechaNac fechaNacimiento, tel.telefono, per.correo, dep.nombre departamento, mun.nombre municipio, per.estado, per.idPersona FROM persona per
            inner join tipousuario tip on per.idTipoUsuario=tip.idTipoUsuario
            inner join municipio mun on per.idMunicipio=mun.idMunicipio
            inner join deptos dep on mun.idDeptos=dep.idDeptos
            inner join telefono tel on per.idPersona=tel.idPersona WHERE tip.idTipoUsuario = ?');
            $stmt->bind_param('i', $idUsuario);
        } else if ($estado1 == 1 && $estado2 == 1 && $estado3 == 0 && $estado4 == 0) {
            $stmt = $mysqli -> prepare(
            'SELECT per.primerNombre, per.primerApellido, tip.descripcion tipoUsuario, per.fechaNac fechaNacimiento, tel.telefono, per.correo, dep.nombre departamento, mun.nombre municipio, per.estado, per.idPersona FROM persona per
            inner join tipousuario tip on per.idTipoUsuario=tip.idTipoUsuario
            inner join municipio mun on per.idMunicipio=mun.idMunicipio
            inner join deptos dep on mun.idDeptos=dep.idDeptos
            inner join telefono tel on per.idPersona=tel.idPersona WHERE tip.idTipoUsuario = ?  and dep.idDeptos = ?');
            $stmt->bind_param('ii', $idUsuario, $idDepto);
        } else if ($estado1 == 1 && $estado2 == 1 && $estado3 == 1 && $estado4 == 0) {
                  $stmt = $mysqli -> prepare(
            'SELECT per.primerNombre, per.primerApellido, tip.descripcion tipoUsuario, per.fechaNac fechaNacimiento, tel.telefono, per.correo, dep.nombre departamento, mun.nombre municipio, per.estado, per.idPersona FROM persona per
            inner join tipousuario tip on per.idTipoUsuario=tip.idTipoUsuario
            inner join municipio mun on per.idMunicipio=mun.idMunicipio
            inner join deptos dep on mun.idDeptos=dep.idDeptos
            inner join telefono tel on per.idPersona=tel.idPersona WHERE tip.idTipoUsuario = ?  and dep.idDeptos = ? and mun.idMunicipio = ?' );
            $stmt->bind_param('iii', $idUsuario, $idDepto, $idMun);
        } else if ($estado1 == 1 && $estado2 == 1 && $estado3 == 1 && $estado4 == 1) {
                         $stmt = $mysqli -> prepare(
            'SELECT per.primerNombre, per.primerApellido, tip.descripcion tipoUsuario, per.fechaNac fechaNacimiento, tel.telefono, per.correo, dep.nombre departamento, mun.nombre municipio, per.estado, per.idPersona FROM persona per
            inner join tipousuario tip on per.idTipoUsuario=tip.idTipoUsuario
            inner join municipio mun on per.idMunicipio=mun.idMunicipio
            inner join deptos dep on mun.idDeptos=dep.idDeptos
            inner join telefono tel on per.idPersona=tel.idPersona WHERE tip.idTipoUsuario = ?  and dep.idDeptos = ? and mun.idMunicipio = ? and per.estado = ?' );
            $stmt->bind_param('iiis', $idUsuario, $idDepto, $idMun,$idEstado);
        } else if ($estado1 == 1 && $estado2 == 0 && $estado3 == 0 && $estado4 == 1) {
                           $stmt = $mysqli -> prepare(
            'SELECT per.primerNombre, per.primerApellido, tip.descripcion tipoUsuario, per.fechaNac fechaNacimiento, tel.telefono, per.correo, dep.nombre departamento, mun.nombre municipio, per.estado, per.idPersona FROM persona per
            inner join tipousuario tip on per.idTipoUsuario=tip.idTipoUsuario
            inner join municipio mun on per.idMunicipio=mun.idMunicipio
            inner join deptos dep on mun.idDeptos=dep.idDeptos
            inner join telefono tel on per.idPersona=tel.idPersona WHERE tip.idTipoUsuario = ?  and per.estado = ?' );
            $stmt->bind_param('is', $idUsuario,$idEstado);
        } else if ($estado1 == 1 && $estado2 == 0 && $estado3 == 1 && $estado4 == 1) {
                            $stmt = $mysqli -> prepare(
            'SELECT per.primerNombre, per.primerApellido, tip.descripcion tipoUsuario, per.fechaNac fechaNacimiento, tel.telefono, per.correo, dep.nombre departamento, mun.nombre municipio, per.estado, per.idPersona FROM persona per
            inner join tipousuario tip on per.idTipoUsuario=tip.idTipoUsuario
            inner join municipio mun on per.idMunicipio=mun.idMunicipio
            inner join deptos dep on mun.idDeptos=dep.idDeptos
            inner join telefono tel on per.idPersona=tel.idPersona WHERE tip.idTipoUsuario = ?  and mun.idMunicipio = ? and per.estado = ?' );
            $stmt->bind_param('iis', $idUsuario,$idMun,$idEstado);
        } else if ($estado1 == 1 && $estado2 == 1 && $estado3 == 0 && $estado4 == 1) {
                            $stmt = $mysqli -> prepare(
            'SELECT per.primerNombre, per.primerApellido, tip.descripcion tipoUsuario, per.fechaNac fechaNacimiento, tel.telefono, per.correo, dep.nombre departamento, mun.nombre municipio, per.estado, per.idPersona FROM persona per
            inner join tipousuario tip on per.idTipoUsuario=tip.idTipoUsuario
            inner join municipio mun on per.idMunicipio=mun.idMunicipio
            inner join deptos dep on mun.idDeptos=dep.idDeptos
            inner join telefono tel on per.idPersona=tel.idPersona WHERE tip.idTipoUsuario = ?  and dep.idDeptos = ?  and per.estado = ?' );
            $stmt->bind_param('iis', $idUsuario, $idDepto,$idEstado);
        } else if ($estado1 == 1 && $estado2 == 0 && $estado3 == 1 && $estado4 == 0) {
                            $stmt = $mysqli -> prepare(
            'SELECT per.primerNombre, per.primerApellido, tip.descripcion tipoUsuario, per.fechaNac fechaNacimiento, tel.telefono, per.correo, dep.nombre departamento, mun.nombre municipio, per.estado, per.idPersona FROM persona per
            inner join tipousuario tip on per.idTipoUsuario=tip.idTipoUsuario
            inner join municipio mun on per.idMunicipio=mun.idMunicipio
            inner join deptos dep on mun.idDeptos=dep.idDeptos
            inner join telefono tel on per.idPersona=tel.idPersona WHERE tip.idTipoUsuario = ?   and mun.idMunicipio = ? ' );
            $stmt->bind_param('ii', $idUsuario, $idMun);
        } else if ($estado1 == 0 && $estado2 == 1 && $estado3 == 0 && $estado4 == 0) {
                         $stmt = $mysqli -> prepare(
            'SELECT per.primerNombre, per.primerApellido, tip.descripcion tipoUsuario, per.fechaNac fechaNacimiento, tel.telefono, per.correo, dep.nombre departamento, mun.nombre municipio, per.estado, per.idPersona FROM persona per
            inner join tipousuario tip on per.idTipoUsuario=tip.idTipoUsuario
            inner join municipio mun on per.idMunicipio=mun.idMunicipio
            inner join deptos dep on mun.idDeptos=dep.idDeptos
            inner join telefono tel on per.idPersona=tel.idPersona WHERE  dep.idDeptos = ?' );
            $stmt->bind_param('i', $idDepto);
        } else if ($estado1 == 0 && $estado2 == 1 && $estado3 == 1 && $estado4 == 0) {
                         $stmt = $mysqli -> prepare(
            'SELECT per.primerNombre, per.primerApellido, tip.descripcion tipoUsuario, per.fechaNac fechaNacimiento, tel.telefono, per.correo, dep.nombre departamento, mun.nombre municipio, per.estado, per.idPersona FROM persona per
            inner join tipousuario tip on per.idTipoUsuario=tip.idTipoUsuario
            inner join municipio mun on per.idMunicipio=mun.idMunicipio
            inner join deptos dep on mun.idDeptos=dep.idDeptos
            inner join telefono tel on per.idPersona=tel.idPersona WHERE  dep.idDeptos = ? and mun.idMunicipio = ?' );
            $stmt->bind_param('ii', $idDepto, $idMun);
        } else if ($estado1 == 0 && $estado2 == 1 && $estado3 == 1 && $estado4 == 1) {
                         $stmt = $mysqli -> prepare(
            'SELECT per.primerNombre, per.primerApellido, tip.descripcion tipoUsuario, per.fechaNac fechaNacimiento, tel.telefono, per.correo, dep.nombre departamento, mun.nombre municipio, per.estado, per.idPersona FROM persona per
            inner join tipousuario tip on per.idTipoUsuario=tip.idTipoUsuario
            inner join municipio mun on per.idMunicipio=mun.idMunicipio
            inner join deptos dep on mun.idDeptos=dep.idDeptos
            inner join telefono tel on per.idPersona=tel.idPersona WHERE  dep.idDeptos = ? and mun.idMunicipio = ? and per.estado = ?' );
            $stmt->bind_param('iis', $idDepto, $idMun, $idEstado);
        } else if ($estado1 == 0 && $estado2 == 1 && $estado3 == 0 && $estado4 == 1) {
                         $stmt = $mysqli -> prepare(
            'SELECT per.primerNombre, per.primerApellido, tip.descripcion tipoUsuario, per.fechaNac fechaNacimiento, tel.telefono, per.correo, dep.nombre departamento, mun.nombre municipio, per.estado, per.idPersona FROM persona per
            inner join tipousuario tip on per.idTipoUsuario=tip.idTipoUsuario
            inner join municipio mun on per.idMunicipio=mun.idMunicipio
            inner join deptos dep on mun.idDeptos=dep.idDeptos
            inner join telefono tel on per.idPersona=tel.idPersona WHERE  dep.idDeptos = ? and per.estado = ?' );
            $stmt->bind_param('is', $idDepto , $idEstado);
        } else if ($estado1 == 0 && $estado2 == 0 && $estado3 == 1 && $estado4 == 0) {
                         $stmt = $mysqli -> prepare(
            'SELECT per.primerNombre, per.primerApellido, tip.descripcion tipoUsuario, per.fechaNac fechaNacimiento, tel.telefono, per.correo, dep.nombre departamento, mun.nombre municipio, per.estado, per.idPersona FROM persona per
            inner join tipousuario tip on per.idTipoUsuario=tip.idTipoUsuario
            inner join municipio mun on per.idMunicipio=mun.idMunicipio
            inner join deptos dep on mun.idDeptos=dep.idDeptos
            inner join telefono tel on per.idPersona=tel.idPersona WHERE  mun.idMunicipio = ? ' );
            $stmt->bind_param('i',$idMun);
        } else if ($estado1 == 0 && $estado2 == 0 && $estado3 == 1 && $estado4 == 1) {
                         $stmt = $mysqli -> prepare(
            'SELECT per.primerNombre, per.primerApellido, tip.descripcion tipoUsuario, per.fechaNac fechaNacimiento, tel.telefono, per.correo, dep.nombre departamento, mun.nombre municipio, per.estado, per.idPersona FROM persona per
            inner join tipousuario tip on per.idTipoUsuario=tip.idTipoUsuario
            inner join municipio mun on per.idMunicipio=mun.idMunicipio
            inner join deptos dep on mun.idDeptos=dep.idDeptos
            inner join telefono tel on per.idPersona=tel.idPersona WHERE  mun.idMunicipio = ? and per.estado = ?' );
            $stmt->bind_param('is',$idMun, $idEstado);
        } else if ($estado1 == 0 && $estado2 == 0 && $estado3 == 0 && $estado4 == 1) {
                         $stmt = $mysqli -> prepare(
            'SELECT per.primerNombre, per.primerApellido, tip.descripcion tipoUsuario, per.fechaNac fechaNacimiento, tel.telefono, per.correo, dep.nombre departamento, mun.nombre municipio, per.estado, per.idPersona FROM persona per
            inner join tipousuario tip on per.idTipoUsuario=tip.idTipoUsuario
            inner join municipio mun on per.idMunicipio=mun.idMunicipio
            inner join deptos dep on mun.idDeptos=dep.idDeptos
            inner join telefono tel on per.idPersona=tel.idPersona WHERE  per.estado = ?' );
            $stmt->bind_param('s', $idEstado);
        }
        $stmt -> execute();
        $stmt -> store_result();
        $stmt -> bind_result(
            $primerNombre,
            $primerApellido,
            $tipoUsuario,
            $fechaNacimiento,
            $telefono,
            $correo,
            $departamento,
            $municipio,
            $estado,
            $idPersona
            );
        $respuesta = array();
        $index = 0;
        while($stmt -> fetch()){
            $respuesta[$index] =  array(
                "primerNombre"=>$primerNombre,
                "primerApellido"=>$primerApellido,
                "tipoUsuario"=>$tipoUsuario,
                "fechaNacimiento"=>$fechaNacimiento,
                "telefono"=>$telefono,
                "correo"=>$correo,
                "departamento"=>$departamento,
                "municipio"=>$municipio,
                "estado"=>$estado,
                "idPersona"=>$idPersona
            );
            $index++;
        }
        echo json_encode($respuesta);
        break;
}
$mysqli->close();
?>
