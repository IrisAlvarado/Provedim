
<?php 

include '../backend/seguridad_admin.php';

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Solicitudes de Administracion</title>

    <link rel="stylesheet" href="../css/FontAwesome.min.css">
    <link rel="stylesheet" href="../css/bootstrap.min.css">

    <script src="../js/jquery-3.4.1.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <script src="../js/FontAwesome.min.js"></script>
</head>

<body>

<?php 
include 'navBarAdmin.php';

?>

<br>
<br>
<br>

    <h1 class="text-center">Solicitudes de Usuario Administrador</h1>

<br><br>
    <div class="container">
        <div class="row">
            <div class="col col-lg-10 table-responsive">
                <table class="table table-bordered table-hover" id="solicitudes">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">
                                Id
                            </th>
                            <th scope="col">
                                Nombre
                            </th>
                            <th scope="col">
                                Correo
                            </th>
                            <th scope="col">
                                Edad
                            </th>
                            <th scope="col">
                                Departamento
                            </th>
                            <th scope="col">
                                Municipio
                            </th>
                            <th scope="col">
                                Opciones
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- <tr>
                            <td scope="row">Yalid Guevara</td>
                            <td>Yalid@gmail.com</td>
                            <td>22</td>
                            <td>Intibuca</td>
                            <td>Jesus de Otoro</td>
                        </tr> -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
<script src="../js/bootstrap.bundle.min.js.descarga"></script>
<script src="../js/solicitudes_administracion.js"></script>
<script type="text/javascript" src="../js/fotoAdmin.js"></script>

</html>