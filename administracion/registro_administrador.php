<?php 

include '../backend/seguridad_admin.php';

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrate como administrador</title>

    <link rel="stylesheet" href="../css/bootstrap.min.css">

    <script src="../js/jquery-3.4.1.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>

</head>

<body>

    <?php 

    //llamado a nabvar
    include 'navbarAdmin.php';

    ?>
    <br><br>
    <div class="container">
        <div class="row">
            <div class="col col-lg-5" style="margin-left: auto !important;margin-right: auto !important;">

                <form id="registro-form">
                    <!--TODO: anadir clases de is valid-->
                    <div style="text-align: center; margin-top: 1em; margin-bottom: 2em;">
                        <h4>Registrate para poder comprar y vender.</h4>
                    </div>

                    <div class="form-group">
                        <!-- <label>Email</label> -->
                        <input type="text" class="form-control" id="nombres" name="nombres"
                            placeholder="Ingrese sus nombres">
                        <small style="display: none;color:red;" id="avisoNombres" class="form-text ">
                            Ingresa ambos nombres.</small>
                    </div>
                    <div class="form-group">
                        <!-- <label>Email</label> -->
                        <input type="text" class="form-control" id="apellidos" name="apellidos"
                            placeholder="Ingrese sus apellidos">
                        <small style="display: none;color:red;" id="avisoapellidos" class="form-text text-muted">
                            Ingresa ambos apellidos.</small>
                    </div>
                    <div class="form-group">
                        <!-- <label>Email</label> -->
                        <label for="fechaNacimiento">Ingrese su fecha de nacimiento</label>
                        <input type="date" class="form-control" id="fechaNacimiento" name="fechaNacimiento">
                        <small style="display: none;color:red;" id="avisoFechaNacimiento" class="form-text text-muted">
                            Debes ser mayor de 21 años para registrate.</small>
                        <small style="display: none;color:red;" id="avisoFechaNacimiento2" class="form-text text-muted">
                            Ingresa una fecha de nacimiento.</small>
                    </div>

                    <!--TODO: Input de municipios-->
                    <div class="form-group">
                        <!-- <label>Email</label> -->
                        <input type="email" class="form-control" id="correo" name="correo"
                            placeholder="Ingrese su correo electrónico">
                        <small style="display: none;color:red;" id="avisoCorreo" class="form-text text-muted">Ingresa un correo
                            válido</small>
                        <small style="display: none;color:red;" id="avisoCorreoExistente" class="form-text text-muted">
                            El correo ya existe.</small>
                    </div>
                    <div class="form-group">
                        <!-- <label for="exampleInputPassword1">Contraseña</label> -->
                        <input type="password" class="form-control" id="contrasena" name="contrasena"
                            placeholder="Contraseña">
                        <small style="display: none;color:red;" id="avisoContrasena" class="form-text text-muted">La contrasena
                            debe contener más de 8 caracteres.</small>
                    </div>

                    <div class="form-group">

                        <label for="departamentos">Departamento</label>

                        <select id="departamentos" class="form-control">
                            <option selected="selected" value="null">No hay nada que cargar</option>

                        </select>

                    </div>

                    <div class="form-group">

                        <label for="municipios">Municipios</label>

                        <select id="municipios" class="form-control">
                            <option selected="selected" value="null">Seleccione un departamento arriba</option>

                        </select>

                    </div>

                    <div style="margin-left: auto;margin-right: auto;" class="text-center">
                        <button type="button" class="btn btn-primary" id="registro-button"
                            style=" width: 15em !important;">Registrarse</button>

                    </div> <br>
                    <hr>
                    <!-- <br>
                    <div class="text-center">
                        <small>¿No tienes una cuenta? </small><a href="#" class="btn btn-outline-success">
                            Crea una cuenta
                        </a>
                    </div> -->

                </form>
            </div>
        </div>
    </div>
    <script src="../js/bootstrap.bundle.min.js.descarga"></script>
    <script src="../js/registro_administrador.js"></script>
</body>

</html>