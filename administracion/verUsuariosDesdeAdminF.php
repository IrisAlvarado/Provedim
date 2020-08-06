<?php

include '../backend/seguridad_admin.php';

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PUBLITODO</title>
    <link rel="stylesheet" href="../css/inicio.styles.css">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/FontAwesome.min.css">

    <script src="../js/jquery-3.4.1.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <script src="../js/FontAwesome.min.js"></script>
    <script type="text/javascript" src="../js/all.js"></script>


</head>

<body>

	<?php
      include 'navbarAdmin.php';
    ?>

    <br>
    <div style="padding-left:65em; padding-right:0px; margin-top:70px">
        <form class="form-inline my-2 my-lg-0">
            <input class="form-control mr-sm-2" type="search" id="inputBusqueda" name="inputBusqueda" placeholder="Buscar por nombre de Usuario"
                aria-label="Search" ><!--onkeypress="myFunction(event)"-->
            <!--<button class="btn btn-outline-success my-2 my-sm-0" type="submit">Buscar</button>-->
            <button type="button" id="inputBusquedaBtn" name="inputBusquedaBtn" style="border-color:white; background-color:white;" class="btn btn-link"><img src="../ico/search.svg"
                    style="width:25px "></button>
        </form>
    </div>

    <br>
    <br>
    <div class="row " style="margin-left:53%;">
        <div style="padding-top:2.5%;">Filtrar por: </div>

        <div style="margin-left:5%;">
            <label for="slc-tipoUsuario">Tipo de Usuario: </label><br>
            <select name="slc-tipoUsuario" id="slc-tipoUsuario">
                <option value="null">Seleccionar</option>
            </select>
        </div>

        <div style="margin-left:5%;">
            <label for="slc-departamento">Departamento: </label><br>
            <select name="slc-departamento" id="slc-departamento">
                <option value="null">Seleccionar</option>

            </select>
        </div>

        <div style="margin-left:5%;">
            <label for="slc-municipio">Municipio: </label><br>
            <select name="slc-municipio" id="slc-municipio">
                <option value="null">Seleccionar</option>

            </select>
        </div>

        <div style="margin-left:5%;">
            <label>Estado: </label><br>
            <select name="slc-estados" id="slc-estados" >
                <option value="null">Seleccionar</option>
                <option value="A">Activo</option>
                <option value="I">Inactivo</option>
            </select>
        </div>

    </div>

    <br>
    <br>
    <center>
        <h2 style="color: darkblue;">Lista de Usuarios</h2>
    </center>

<div class="row " style="margin-left:80%; margin-top: 0px;">
    <div  style="margin-left:5%; padding-top: 0px;">
        <button type="button" class="btn btn-link"><a href="verUsuariosDesdeAdminF.php">Mostrar todos los Usuarios</a></button>
    </div>
</div>

    <table border="0" cellspacing="0" cellpadding="10" class=" table table-striped table-hover" id="tablaUsuarios"
        style="width: 85%; margin-left:auto; margin-right:auto">
        <thead class="thead-dark">
            <tr>
                <td><strong>Nombre </strong></td>
                <td><strong>Apellido </strong></td>
                <td><strong>Tipo Usuario </strong></td>
                <td><strong>Fecha Nacimiento </strong></td>
                <td><strong>Telefono </strong></td>
                <td><strong>Correo Electronico </strong></td>
                <td><strong>Departamento </strong></td>
                <td><strong>Ciudad o Municipio </strong></td>
                <td><center><strong>Estado </strong></center></td>
                <td><center><strong>Dar de Baja </strong></center></td>
                <!--<td><strong>Modificar </strong></td>  -->
            </tr>
        </thead>
        <tr>

        </tr>
    </table>


    <script src="../js/verUsuariosDesdeAdmin.js"></script>
    <script src="../js/bootstrap.bundle.min.js.descarga"></script>
    <script type="text/javascript" src="../js/fotoAdmin.js"></script>
</body>

</html>
