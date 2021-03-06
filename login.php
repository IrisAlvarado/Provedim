<?php
    
    session_start();
    $msg = '';
    if(!empty($_SESSION['active'])){  //Si la sesión esta activada se direcciona a la pagina principal
        header('location: principal.php');

    }else{ //sino lo direcciona a la validación
    
        if (!empty($_POST)) {

            if (empty($_POST['correo']) || empty($_POST['contrasenia'])) {
                $msg ="Ingrese su correo y contraseña";
            } else {
                require_once "conexion.php";
                $correo = $_POST['correo'];
                $contrasenia = $_POST['contrasenia'];


                $query = mysqli_query($mysqli, "SELECT * FROM persona WHERE correo='$correo'");
                $result = mysqli_num_rows($query);

                if($result>0){
                    $data = mysqli_fetch_array($query);
                    $password_db = $data['contrasenia'];
                    if($password_db==$contrasenia){
                        $_SESSION['active'] = true;
                        $_SESSION['idUser'] =$data['idPersona'];
                        $_SESSION['nombre'] = $data['primerNombre'];
                        $_SESSION['email'] = $data['correo'];
                        $_SESSION['nombre'] = $data['primerNombre'];
                        $_SESSION['user'] = $data['segundoNombre'];
                        $_SESSION['rol'] = $data['idTipoUsuario'];
    
                        header('location: principal.php');
                    }else{
                        $msg = "Contraseña incorrecta";
                    }
                    
                }else{
                    $msg = "El usuario no existe";
                    session_destroy();
                }
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Iniciar Sesión en Provedim</title>
        <link href="css/bootstrap.min.css" rel="stylesheet" />
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/js/all.min.js" crossorigin="anonymous"></script>
    </head>
    <body background="img/portada4.jpeg">
        <div id="layoutAuthentication">
            <div id="layoutAuthentication_content">
                <main>
                    <div class="container">
                        <div class="row justify-content-center my-5">
                            <div class="col-lg-5">
                                <div class="card shadow-lg border-0 rounded-lg mt-5">
                                    <div class="card-header"><h3 class="text-center font-weight-dark my-4">Iniciar Sesión</h3>
                                    <div class="form-group" id="alertaMsj" style="color:red; text-align:center;font-weight:700;"><?php echo isset($msg) ? $msg: ''; ?></div>

                                </div>
                                    <div class="card-body">

                                        <form method="post" action="login.php">
                                            <div class="form-group">
                                                <label class="small mb-1" for="inputEmailAddress">
                                                    <i class="fas fa-envelope fa-2x" style="color: #000; height: 16px;"></i> Correo Electrónico:
                                                </label>
                                                <input class="form-control py-4" name="correo" id="inputEmailAddress" type="text" placeholder="Ingresa el correo electrónico" required>
                                            </div>
                                            <div class="form-group">
                                                <label class="small mb-1" for="inputPassword">
                                                    <i class="fas fa-lock fa-2x" style="height: 15px; color: #000;"></i> Contraseña:
                                                </label>
                                                <input class="form-control py-4" name="contrasenia" id="inputPassword" type="password" placeholder="Ingresa la contraseña" required>
                                            </div>
                                            
                                            <div class="form-group d-flex align-items-center justify-content-between mt-4 mb-0"><a class="small ml-auto" href="password.html">¿Olvidaste la contraseña?</a></div>
                                            <div class="form-group d-flex align-items-center justify-content-between mt-4 mb-0">
                                                <button class="btn btn-primary form-control" type="submit">Ingresar</button>
                                            </div>

                                        </form>

                                    </div>
                                    <div class="card-footer text-center">
                                        <div class="small"><a href="reg.php">¿Necesitas una cuenta? ¡Registrate!</a></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>

            
            
        </div>
        <script src="https://code.jquery.com/jquery-3.4.1.min.js" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/login.js"></script>
    </body>
</html>
