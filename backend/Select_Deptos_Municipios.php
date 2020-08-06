
<?php 

$mysqli = new mysqli( 'localhost:3306', 'root', '', 'mydb' );

if($_POST["data"]=="departamentos"){

    $idDepartamento;
    $nombre;

    $stmt = $mysqli -> prepare('SELECT idDeptos, nombre  FROM deptos');
    
    // $stmt -> bind_param('i', $userId);
    $stmt -> execute();
    $stmt -> store_result();
    $stmt -> bind_result( 
    $idDepartamento,
    $nombre);


    $respuesta = array();

    $index = 0;
    
    while($stmt -> fetch()){

        $respuesta[$index] =  array(
            "nombre"=> $nombre,
            "idDepartamento"=>$idDepartamento
        );

        $index++;
    }
    
    echo json_encode($respuesta);

}

else if($_POST["data"]=="municipios"){

    $idDepartamento = $_POST["idDepartamento"] ;

    $idMunicipio;
    $nombre;

    $stmt = $mysqli -> prepare('SELECT idMunicipio, nombre  FROM municipio WHERE idDeptos = ?');
    
    $stmt -> bind_param('i', $idDepartamento);
    $stmt -> execute();
    $stmt -> store_result();
    $stmt -> bind_result( 
    $idMunicipio,
    $nombre);


    $respuesta = array();

    $index = 0;
    
    while($stmt -> fetch()){

        $respuesta[$index] =  array(
            "nombre"=> $nombre,
            "idMunicipio"=>$idMunicipio
        );

        $index++;
    }
    
    echo json_encode($respuesta);

}

else{
    echo(json_encode(
                    array(
                        "valor"=>  $_POST["data"]
                        )
                    )
        );


}

    $mysqli->close();

?>