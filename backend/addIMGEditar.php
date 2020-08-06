<?php

$host = "localhost";
$usuario = "root";
$password = "";
$baseDatos = "mydb";
$puerto = 3306;
$link;

$mysqli = new mysqli(   
        $host,
        $usuario,
        $password,
        $baseDatos,
        $puerto
);
        //echo "<p style ='color:red'>Nada</p>";
 if (isset($_FILES["file"])){
    $reporte=null;
        //echo ("s entro: ".$_FILES["file"]);
        $total=count($_FILES["file"]["name"]);
        $reporte .="<p style='color:red'>Total imagenes subidas: ".$total." </p>"; 

        //$reporte .="<p style='color:red'>Total imagenes subidas: ".$total." </p>";
        for ($i=0; $i <count($_FILES["file"]["name"]) ; $i++) { 
            # <code class=""></code>
            $file=$_FILES["file"];
            $nombre=$file["name"][$i];
            $tipo=$file["type"][$i];
            $ruta_provisional=$file["tmp_name"][$i];
            $size=$file["size"][$i];
            $dimensiones=getimagesize($ruta_provisional);
            $width=$dimensiones[0];
            $heigth=$dimensiones[1];
            $carpeta="../images/";
        /*
        $resTipo='';
        $resSize='';
                $resWidthMayor='';
                $resWidthMenor='';
                $resExito='';*/
        if ($tipo!='image/jpeg' && $tipo!='image/jpg' && $tipo!='image/png' && $tipo!='image/gif') {
            # code...
            //$resTipo='Error '.$nombre.' el archivo no es una imagen';
                $reporte .="<p style='color:red'>Error ".$nombre." el archivo no es una imagen</p>";
        }else if ($size > 2048*2048) {
            # code...
            //$resSize='Error '.$nombre.' el tamaño maximo permitido es una 1MG';
            $reporte ="<p style='color:red'>Error ".$nombre." el tamaño maximo permitido es una 1MG</p>";
        }else if ($width>2000 || $heigth>2000) {
            # code...
            //$resWidthMayor="Error: ".$nombre." la anchura y altura maxima permitida es de 500 pixels";
            $reporte .="<p style='color:red'>Error: ".$nombre." la anchura y altura maxima permitida es de 500 pixels</p>";
        }else if ($width<60 || $heigth<60) {
            # code...
            //$resWidthMenor="Error: ".$nombre." la anchura y altura minima permitida es de 60 pixels";
            $reporte .="<p style='color:red'>Error: ".$nombre." la anchura y altura minima permitida es de 60 pixels</p>";
     }else{
            $idAnuncio=$_GET["idAnuncio"];
           // $idAnuncio =1;
                    $accion="editarFoto";
                    $prueba=" ";
                    $urlFoto='images/'.$nombre;
                    $id=0;
        $call = $mysqli->prepare('CALL SP_AGREGAR_PUB(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, @mensaje)');

        $call->bind_param('ssisiiiiss',
            $prueba ,
            $prueba,
            $id,
            $prueba,
            $id,
            $id,
            $id, 
            $idAnuncio,
            $urlFoto, 
            $accion 
        );
        $call->execute();

        $select = $mysqli->query('SELECT @mensaje');

        $result = $select->fetch_assoc();
        $mensaje = $result['@mensaje'];

        if ($mensaje =='Foto guardada exitosamente') {
            # code...
            $src=$carpeta.$nombre;
            move_uploaded_file($ruta_provisional, $src);
            //$resExito="La imagen: ".$nombre." ha sido subida con exito";
            echo "<p style='color:blue'>La imagen: ".$nombre." ".$mensaje."</p>";
        } else {
            # code...
            echo "<p style='color:blue'>Ocurrio un ERROR la imagen  ".$nombre."  ".$mensaje." </p>";
            //$resExito="Ocurrio un ERROR la imagen  ".$nombre."no se ha guardado";
        }
        
            

            
        }
    }
            echo $reporte;
 
 }

?>