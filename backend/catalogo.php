<?php

$mysqli = new mysqli( 'localhost:3308', 'root', '', 'mydb' );

switch ($_POST["accion"]) {

	    case "getPublicaciones":

        $nombreProducto;
        $tipoProducto;
        $categoria;
        $descripcion;
        $primerNombre;
        $primerApellido;
        $precio;
        $moneda;
        $fechaPublicacion;
        $fechaVencimiento;
        $estado;
        $idAnuncio;
        $urlFoto;


        $stmt = $mysqli -> prepare(
            'select  pro.nombre,pro.tipoProducto ,ca.descripcion categoria,an.descripcion,per.primerNombre,
            per.primerApellido ,an.precio,mo.descripcion ,an.fecha fechaPublicacion,
            DATE_ADD(an.fecha , INTERVAL tu.tiempoPublicacion DAY) fechaVencimiento, an.estado, an.idAnuncios, fo.urlFoto
            from anuncios an
            inner join producto pro on an.idProducto=pro.idProducto
            inner join categorias ca on pro.idCategorias=ca.idCategorias
            inner join persona per on an.idPersona=per.idPersona
            inner join moneda mo on an.idMoneda=mo.idMoneda
            inner join tipousuario tu on tu.idTipoUsuario = per.idTipoUsuario
            inner join fotosanuncio fo on  fo.idAnuncios = an.idAnuncios
            ORDER BY an.fechaPublicacion DESC');  /*            ORDER BY an.idAnuncios DESC*/

    $stmt -> execute();
    $stmt -> store_result();
    $stmt -> bind_result(
        $nombreProducto,
        $tipoProducto,
        $categoria,
        $descripcion,
        $primerNombre,
        $primerApellido,
        $precio,
        $moneda,
        $fechaPublicacion,
        $fechaVencimiento,
        $estado,
        $idAnuncio,
        $urlFoto
        );


    $respuesta = array();

    $index = 0;

    while($stmt -> fetch()){
        $respuesta[$index] =  array(
            "nombreProducto"=>$nombreProducto,
            "tipoProducto"=>$tipoProducto,
            "categoria"=>$categoria,
            "descripcion"=>$descripcion,
            "primerNombre"=>$primerNombre,
            "primerApellido"=>$primerApellido,
            "precio"=>$precio,
            "moneda"=>$moneda,
            "fechaPublicacion"=>$fechaPublicacion,
            "fechaVencimiento"=>$fechaVencimiento,
            "estado"=>$estado,
            "idAnuncio"=>$idAnuncio,
            "urlFoto"=>$urlFoto
        );
        $index++;
    }

    	echo json_encode($respuesta);

        break;

//***********************************************SELECCIONAR DEPARTAMENTO*****************************************************//
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

//***********************************************SELECCIONAR MUNICIPIO*****************************************************//
        case "seleccionarMunicipio":

            $idMunicipio;
            $nombre;
            $idDepartamentoSelected;

		 if (isset($_POST["idDepartamentoSelected"])) {
            $idDepartamentoSelected = $_POST["idDepartamentoSelected"];
            //$estado1 = 1;
        }

            $stmt = $mysqli -> prepare(
                'SELECT idMunicipio, nombre FROM municipio WHERE idDeptos = ?'
                );
            $stmt->bind_param('i', $idDepartamentoSelected);
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
//***********************************************SELECCIONAR CATEGORIA*****************************************************//
        case "seleccionarCategoria":

            $idCategorias;
            $nombre;

            $stmt = $mysqli -> prepare(
                'SELECT idCategorias, descripcion FROM categorias WHERE estado="A"'
                );

            $stmt -> execute();
            $stmt -> store_result();
            $stmt -> bind_result(
                $idCategorias,
                $nombre);


            $respuesta = array();

            $index = 0;

            while($stmt -> fetch()){

                $respuesta[$index] =  array(
                    "idCategoria"=>$idCategorias,
                    "nombre"=>$nombre,
                );

                $index++;
            }

            echo json_encode($respuesta);
        break;


//***************************************************BUSQUEDA POR NOMBRE DEL PRODUCTO***************************************//
        case "busquedaNombreProducto":

        $palabraClave = $_POST["palabraClave"];
        $palabra="%$palabraClave%";
        $stmt = $mysqli -> prepare(
            'select  pro.nombre,pro.tipoProducto ,ca.descripcion categoria,an.descripcion,per.primerNombre,
            per.primerApellido ,an.precio,mo.descripcion ,an.fecha fechaPublicacion,
            DATE_ADD(an.fecha , INTERVAL tu.tiempoPublicacion DAY) fechaVencimiento, an.estado, an.idAnuncios, fo.urlFoto
            from anuncios an
            inner join producto pro on an.idProducto=pro.idProducto
            inner join categorias ca on pro.idCategorias=ca.idCategorias
            inner join persona per on an.idPersona=per.idPersona
            inner join moneda mo on an.idMoneda=mo.idMoneda
            inner join tipousuario tu on tu.idTipoUsuario = per.idTipoUsuario
            inner join fotosanuncio fo on  fo.idAnuncios = an.idAnuncios
            WHERE pro.nombre LIKE ?
            ORDER BY an.fechaPublicacion DESC');
        $stmt->bind_param('s', $palabra);
        $stmt -> execute();
        $stmt -> store_result();
        $stmt -> bind_result(
        $nombreProducto,
        $tipoProducto,
        $categoria,
        $descripcion,
        $primerNombre,
        $primerApellido,
        $precio,
        $moneda,
        $fechaPublicacion,
        $fechaVencimiento,
        $estado,
        $idAnuncio,
        $urlFoto
            );


        $respuesta = array();

        $index = 0;

        while($stmt -> fetch()){

            $respuesta[$index] =  array(
            "nombreProducto"=>$nombreProducto,
            "tipoProducto"=>$tipoProducto,
            "categoria"=>$categoria,
            "descripcion"=>$descripcion,
            "primerNombre"=>$primerNombre,
            "primerApellido"=>$primerApellido,
            "precio"=>$precio,
            "moneda"=>$moneda,
            "fechaPublicacion"=>$fechaPublicacion,
            "fechaVencimiento"=>$fechaVencimiento,
            "estado"=>$estado,
            "idAnuncio"=>$idAnuncio,
            "urlFoto"=>$urlFoto
            );

            $index++;
        }

        echo json_encode($respuesta);

        break;

//***************************************************BUSQUEDA POR RANGO DE PRECIO***************************************//
        case "busquedaPorPrecio":
        //if (is_float($_POST["desde"]) && is_float($_POST["hasta"]) ) {
        	# code...
        $desde = $_POST["desde"];
        $hasta = $_POST["hasta"];
        $stmt = $mysqli -> prepare(
            'select  pro.nombre,pro.tipoProducto ,ca.descripcion categoria,an.descripcion,per.primerNombre,
            per.primerApellido ,an.precio,mo.descripcion ,an.fecha fechaPublicacion,
            DATE_ADD(an.fecha , INTERVAL tu.tiempoPublicacion DAY) fechaVencimiento, an.estado, an.idAnuncios, fo.urlFoto
            from anuncios an
            inner join producto pro on an.idProducto=pro.idProducto
            inner join categorias ca on pro.idCategorias=ca.idCategorias
            inner join persona per on an.idPersona=per.idPersona
            inner join moneda mo on an.idMoneda=mo.idMoneda
            inner join tipousuario tu on tu.idTipoUsuario = per.idTipoUsuario
            inner join fotosanuncio fo on  fo.idAnuncios = an.idAnuncios
            where an.precio BETWEEN ? and ?
            ORDER BY an.fechaPublicacion DESC');
        $stmt->bind_param('ii', $desde, $hasta);
        $stmt -> execute();
        $stmt -> store_result();
        $stmt -> bind_result(
        $nombreProducto,
        $tipoProducto,
        $categoria,
        $descripcion,
        $primerNombre,
        $primerApellido,
        $precio,
        $moneda,
        $fechaPublicacion,
        $fechaVencimiento,
        $estado,
        $idAnuncio,
        $urlFoto
            );


        $respuesta = array();

        $index = 0;

        while($stmt -> fetch()){

            $respuesta[$index] =  array(
            "nombreProducto"=>$nombreProducto,
            "tipoProducto"=>$tipoProducto,
            "categoria"=>$categoria,
            "descripcion"=>$descripcion,
            "primerNombre"=>$primerNombre,
            "primerApellido"=>$primerApellido,
            "precio"=>$precio,
            "moneda"=>$moneda,
            "fechaPublicacion"=>$fechaPublicacion,
            "fechaVencimiento"=>$fechaVencimiento,
            "estado"=>$estado,
            "idAnuncio"=>$idAnuncio,
            "urlFoto"=>$urlFoto
            );

            $index++;
        }

        echo json_encode($respuesta);
        //break;
	/*}else{
		echo json_encode("false");
	}*/
        break;

//***************************************************CONSULTAS DE FILTRADO DE LA TABLA******************************//
        case "filtrar":
        $estado1 = 0;
        $estado2 = 0;
        $estado3 = 0;

        if (isset($_POST["idCategoria"])) {
            $idCategoria = $_POST["idCategoria"];
            $estado1 = 1;
        }
        if (isset($_POST["idDepto"]) ) {
            $idDepto = $_POST["idDepto"];
            $estado2 = 1;
        }
         if (isset($_POST["idMunicipio"]) ) {
            $idMun = $_POST["idMunicipio"];
            $estado3 = 1;
        }

        if ($estado1 == 1 && $estado2 == 0 && $estado3 == 0 ) {
             $stmt = $mysqli -> prepare(
            'select  pro.nombre,pro.tipoProducto ,ca.descripcion categoria,an.descripcion,per.primerNombre,
            per.primerApellido ,an.precio,mo.descripcion ,an.fecha fechaPublicacion,
            DATE_ADD(an.fecha , INTERVAL tu.tiempoPublicacion DAY) fechaVencimiento, an.estado, an.idAnuncios, fo.urlFoto
            from anuncios an
            inner join producto pro on an.idProducto=pro.idProducto
            inner join categorias ca on pro.idCategorias=ca.idCategorias
            inner join persona per on an.idPersona=per.idPersona
            inner join moneda mo on an.idMoneda=mo.idMoneda
            inner join tipousuario tu on tu.idTipoUsuario = per.idTipoUsuario
            inner join fotosanuncio fo on  fo.idAnuncios = an.idAnuncios WHERE ca.idCategorias = ?
            ORDER BY an.fechaPublicacion DESC');
            $stmt->bind_param('i', $idCategoria);
        } else if ($estado1 == 1 && $estado2 == 1 && $estado3 == 0 ) {
            $stmt = $mysqli -> prepare(
            'select  pro.nombre,pro.tipoProducto ,ca.descripcion categoria,an.descripcion,per.primerNombre,
            per.primerApellido ,an.precio,mo.descripcion ,an.fecha fechaPublicacion,
            DATE_ADD(an.fecha , INTERVAL tu.tiempoPublicacion DAY) fechaVencimiento, an.estado, an.idAnuncios, fo.urlFoto
            from anuncios an
            inner join producto pro on an.idProducto=pro.idProducto
            inner join categorias ca on pro.idCategorias=ca.idCategorias
            inner join persona per on an.idPersona=per.idPersona
            inner join moneda mo on an.idMoneda=mo.idMoneda
            inner join tipousuario tu on tu.idTipoUsuario = per.idTipoUsuario
            inner join fotosanuncio fo on  fo.idAnuncios = an.idAnuncios
            inner join municipio mun on per.idMunicipio=mun.idMunicipio
            inner join deptos dep on mun.idDeptos=dep.idDeptos WHERE ca.idCategorias = ?  and dep.idDeptos = ?
            ORDER BY an.fechaPublicacion DESC');
            $stmt->bind_param('ii', $idCategoria, $idDepto);
        } else if ($estado1 == 1 && $estado2 == 1 && $estado3 == 1 ) {
                  $stmt = $mysqli -> prepare(
            'select  pro.nombre,pro.tipoProducto ,ca.descripcion categoria,an.descripcion,per.primerNombre,
            per.primerApellido ,an.precio,mo.descripcion ,an.fecha fechaPublicacion,
            DATE_ADD(an.fecha , INTERVAL tu.tiempoPublicacion DAY) fechaVencimiento, an.estado, an.idAnuncios, fo.urlFoto
            from anuncios an
            inner join producto pro on an.idProducto=pro.idProducto
            inner join categorias ca on pro.idCategorias=ca.idCategorias
            inner join persona per on an.idPersona=per.idPersona
            inner join moneda mo on an.idMoneda=mo.idMoneda
            inner join tipousuario tu on tu.idTipoUsuario = per.idTipoUsuario
            inner join fotosanuncio fo on  fo.idAnuncios = an.idAnuncios
            inner join municipio mun on per.idMunicipio=mun.idMunicipio
            inner join deptos dep on mun.idDeptos=dep.idDeptos WHERE ca.idCategorias = ?  and dep.idDeptos = ? and mun.idMunicipio = ?
            ORDER BY an.fechaPublicacion DESC' );
            $stmt->bind_param('iii', $idCategoria, $idDepto, $idMun);
        }  else if ($estado1 == 1 && $estado2 == 0 && $estado3 == 1 ) {
                           $stmt = $mysqli -> prepare(
            'select  pro.nombre,pro.tipoProducto ,ca.descripcion categoria,an.descripcion,per.primerNombre,
            per.primerApellido ,an.precio,mo.descripcion ,an.fecha fechaPublicacion,
            DATE_ADD(an.fecha , INTERVAL tu.tiempoPublicacion DAY) fechaVencimiento, an.estado, an.idAnuncios, fo.urlFoto
            from anuncios an
            inner join producto pro on an.idProducto=pro.idProducto
            inner join categorias ca on pro.idCategorias=ca.idCategorias
            inner join persona per on an.idPersona=per.idPersona
            inner join moneda mo on an.idMoneda=mo.idMoneda
            inner join tipousuario tu on tu.idTipoUsuario = per.idTipoUsuario
            inner join fotosanuncio fo on  fo.idAnuncios = an.idAnuncios
            inner join municipio mun on per.idMunicipio=mun.idMunicipio
            inner join deptos dep on mun.idDeptos=dep.idDeptos WHERE ca.idCategorias = ?  and mun.idMunicipio = ?
            ORDER BY an.fechaPublicacion DESC' );
            $stmt->bind_param('ii',  $idCategoria, $idMun);
        } else if ($estado1 == 0 && $estado2 == 1 && $estado3 == 1 ) {
                            $stmt = $mysqli -> prepare(
            'select  pro.nombre,pro.tipoProducto ,ca.descripcion categoria,an.descripcion,per.primerNombre,
            per.primerApellido ,an.precio,mo.descripcion ,an.fecha fechaPublicacion,
            DATE_ADD(an.fecha , INTERVAL tu.tiempoPublicacion DAY) fechaVencimiento, an.estado, an.idAnuncios, fo.urlFoto
            from anuncios an
            inner join producto pro on an.idProducto=pro.idProducto
            inner join categorias ca on pro.idCategorias=ca.idCategorias
            inner join persona per on an.idPersona=per.idPersona
            inner join moneda mo on an.idMoneda=mo.idMoneda
            inner join tipousuario tu on tu.idTipoUsuario = per.idTipoUsuario
            inner join fotosanuncio fo on  fo.idAnuncios = an.idAnuncios
            inner join municipio mun on per.idMunicipio=mun.idMunicipio
            inner join deptos dep on mun.idDeptos=dep.idDeptos WHERE dep.idDeptos = ? and mun.idMunicipio = ?
            ORDER BY an.fechaPublicacion DESC' );
            $stmt->bind_param('ii', $idDepto,$idMun);
        } else if ($estado1 ==0 && $estado2 == 1 && $estado3 == 0) {
                            $stmt = $mysqli -> prepare(
            'select  pro.nombre,pro.tipoProducto ,ca.descripcion categoria,an.descripcion,per.primerNombre,
            per.primerApellido ,an.precio,mo.descripcion ,an.fecha fechaPublicacion,
            DATE_ADD(an.fecha , INTERVAL tu.tiempoPublicacion DAY) fechaVencimiento, an.estado, an.idAnuncios, fo.urlFoto
            from anuncios an
            inner join producto pro on an.idProducto=pro.idProducto
            inner join categorias ca on pro.idCategorias=ca.idCategorias
            inner join persona per on an.idPersona=per.idPersona
            inner join moneda mo on an.idMoneda=mo.idMoneda
            inner join tipousuario tu on tu.idTipoUsuario = per.idTipoUsuario
            inner join fotosanuncio fo on  fo.idAnuncios = an.idAnuncios
            inner join municipio mun on per.idMunicipio=mun.idMunicipio
            inner join deptos dep on mun.idDeptos=dep.idDeptos WHERE dep.idDeptos = ?
            ORDER BY an.fechaPublicacion DESC ');
            $stmt->bind_param('i', $idDepto);
        } else if ($estado1 == 0 && $estado2 == 0 && $estado3 == 1 ) {
                            $stmt = $mysqli -> prepare(
            'select  pro.nombre,pro.tipoProducto ,ca.descripcion categoria,an.descripcion,per.primerNombre,
            per.primerApellido ,an.precio,mo.descripcion ,an.fecha fechaPublicacion,
            DATE_ADD(an.fecha , INTERVAL tu.tiempoPublicacion DAY) fechaVencimiento, an.estado, an.idAnuncios, fo.urlFoto
            from anuncios an
            inner join producto pro on an.idProducto=pro.idProducto
            inner join categorias ca on pro.idCategorias=ca.idCategorias
            inner join persona per on an.idPersona=per.idPersona
            inner join moneda mo on an.idMoneda=mo.idMoneda
            inner join tipousuario tu on tu.idTipoUsuario = per.idTipoUsuario
            inner join fotosanuncio fo on  fo.idAnuncios = an.idAnuncios
            inner join municipio mun on per.idMunicipio=mun.idMunicipio
            inner join deptos dep on mun.idDeptos=dep.idDeptos WHERE mun.idMunicipio = ?
            ORDER BY an.fechaPublicacion DESC ' );
            $stmt->bind_param('i',$idMun);
        }  else if ($estado1 == 0 && $estado2 == 0 && $estado3 == 0 ) {
                         $stmt = $mysqli -> prepare(
            'select  pro.nombre,pro.tipoProducto ,ca.descripcion categoria,an.descripcion,per.primerNombre,
            per.primerApellido ,an.precio,mo.descripcion ,an.fecha fechaPublicacion,
            DATE_ADD(an.fecha , INTERVAL tu.tiempoPublicacion DAY) fechaVencimiento, an.estado, an.idAnuncios, fo.urlFoto
            from anuncios an
            inner join producto pro on an.idProducto=pro.idProducto
            inner join categorias ca on pro.idCategorias=ca.idCategorias
            inner join persona per on an.idPersona=per.idPersona
            inner join moneda mo on an.idMoneda=mo.idMoneda
            inner join tipousuario tu on tu.idTipoUsuario = per.idTipoUsuario
            inner join fotosanuncio fo on  fo.idAnuncios = an.idAnuncios
            inner join municipio mun on per.idMunicipio=mun.idMunicipio
            inner join deptos dep on mun.idDeptos=dep.idDeptos
            ORDER BY an.fechaPublicacion DESC' );
            /*$stmt->bind_param('s', $idEstado);*/
        }
        $stmt -> execute();
        $stmt -> store_result();
        $stmt -> bind_result(
        $nombreProducto,
        $tipoProducto,
        $categoria,
        $descripcion,
        $primerNombre,
        $primerApellido,
        $precio,
        $moneda,
        $fechaPublicacion,
        $fechaVencimiento,
        $estado,
        $idAnuncio,
        $urlFoto
            );
        $respuesta = array();
        $index = 0;
        while($stmt -> fetch()){
            $respuesta[$index] =  array(
            "nombreProducto"=>$nombreProducto,
            "tipoProducto"=>$tipoProducto,
            "categoria"=>$categoria,
            "descripcion"=>$descripcion,
            "primerNombre"=>$primerNombre,
            "primerApellido"=>$primerApellido,
            "precio"=>$precio,
            "moneda"=>$moneda,
            "fechaPublicacion"=>$fechaPublicacion,
            "fechaVencimiento"=>$fechaVencimiento,
            "estado"=>$estado,
            "idAnuncio"=>$idAnuncio,
            "urlFoto"=>$urlFoto
            );
            $index++;
        }
        echo json_encode($respuesta);
        break;


    }
	$mysqli->close();
?>