<?php 

include '../backend/seguridad_admin.php';

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">


    <link rel="stylesheet" href="../css/bootstrap.min.css">


    <script src="../js/jquery-3.4.1.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>

    <link rel="stylesheet" href="../css/FontAwesome.min.css">
    <script src="../js/FontAwesome.min.js"></script>

    <link rel="stylesheet" href="../css/inicio.styles.css">

</head>

<body>

	<?php
      include 'navbarAdmin.php';
    ?>
    <!-- style="background-color: #2b3f81 !important; color: white !important;" -->



    <br>
    <div style="padding-left:65em; padding-right:0px; margin-top:70px">
        <form class="form-inline my-2 my-lg-0">
            <input class="form-control mr-sm-2" type="search" id="inputBusqueda" name="inputBusqueda" placeholder="¿Que deseas buscar?"
                aria-label="Search">
            <!--<button class="btn btn-outline-success my-2 my-sm-0" type="submit">Buscar</button>-->
            <button type="button" id="inputBusquedaBtn" name="inputBusquedaBtn" style="border-color:white; background-color:white;"><img src="../ico/search.svg"
                    style="width:25px "></button>
        </form>
    </div>

    <br>
    <br>
    <div class="row " style="margin-left:67%;">
        <div style="padding-top:2.5%;">Filtrar por: </div>
        <div style="margin-left:5%;">
            <label for="slc-categorias">Categoria: </label><br>
            <select name="slc-categorias" id="slc-categorias">
                <option value="null">Seleccionar</option>
            </select>
        </div>

        <div style="margin-left:5%;">
            <label for="slc-usuarios">Usuario: </label><br>
            <select name="slc-usuarios" id="slc-usuarios">
                <option value="null">Seleccionar</option>

            </select>
        </div>

        <div style="margin-left:5%;">
            <label>Estado: </label><br>
            <select name="slc-estados" id="slc-estados" >
                <option value="-">Seleccionar</option>
                <option value="A">Activo</option>
                <option value="I">Inactivo</option>
            </select>
        </div>

    </div>




    <br>
    <br>
    <center>
        <h2>Lista de publicaciones</h2>
    </center>
    <br>
    <div class="table-responsive">
    <table class="table table-striped table-hover table-bordered" id="tablaPublicaciones"
        style="width: 100%; margin-left:auto; margin-right:auto">
        <thead class="thead-dark">
            <tr>
                <td><strong> Nombre </strong></td>
                <td><strong>Tipo (Produto o Servicio) </strong></td>
                <td><strong>Categoria </strong></td>
                <td><strong>Descripcion </strong></td>
                <td><strong>Nombre Usuario </strong></td>
                <td><strong>Precio </strong></td>
                <td><strong>Moneda </strong></td>
                <td><strong>Dia Publicación </strong></td>
                <td><strong>Dia Vencimiento </strong></td>
                <td><strong>Estado </strong></td>
                <td><strong>Dar de Baja </strong></td>
                <!--<td><strong>Modificar </strong></td>  -->
            </tr>
        </thead>
        <tr>
           
        </tr>
    </table>
    </div>

    <script src="../js/publicaciones-admin.js"></script>
    <script src="../js/bootstrap.bundle.min.js.descarga"></script>

    <script type="text/javascript" src="../js/fotoAdmin.js"></script>
</body>

</html>
