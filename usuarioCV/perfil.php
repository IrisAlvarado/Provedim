<?php 

include '../backend/seguridad.php';

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PERFIL</title>

    <link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
    <script src="../js/jquery-3.4.1.min.js"></script>

    <script src="../js/bootstrap.min.js"></script>

    <link rel="stylesheet" href="../css/perfil.css">
</head>

<body>

    <?php 

    /*incluir navbar*/
    include 'navbarU.php';
    
    ?>
<div class="container-fluid">
  <div class="row">
    <div class="col-12 col-md-12">
      <!--Editar cuenta---><br>
      <div class="form-row py-5">
        <div class="col-md-8"></div>
        <div class="col-12 col-md-4">
          <p class="text-right">
            <button type="button" id="btnEditarCuenta" class="btn"><i class="fas fa-cog fa-lg  fa-2x" style="color:#212529"></i></button>
          </p>
          <p class="text-right alert alert-danger" id="msjBaja" style="display:none"></p>
          <p class="text-right" id="pEditarCuenta" style="display:none">
            Dar de baja su cuenta <button type="button" class="btn btn-outline-danger" id="bajaCuenta"><i class="fas fa-trash-alt fa-1x" ></i></button>
            <button type="button" class="btn btn-outline-secondary" id="cancelarBaja"><i class="fas fa-times fa-1x" ></i></button>
          </p>
          
        </div>
      </div> 
    </div><!--fin columna-->
    <div class="col-12 col-sm-4 ">
      <span class="text-uppercase text-center"><h4 id="hNombre">Usuario Logueado</h4></span><br>
      <hr style="border:1px; color: red">
      <div class="text-center px-5"  id="imgUsuario"></div>
              <br>
    <!-- Modal imagen perfil--->
          <!-- Button trigger modal -->
    <center>
       <button type="button" class="btn btn btn-light" data-toggle="modal" data-target="#exampleModal">
        Cambiar imagen perfil
      </button>

    </center>


        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title text-uppercase" id="exampleModalLabel">Foto de perfil</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <div class="principal">
                <form action="" id="form_subir">
                  
                  <div class="container">
                    <div class="row">
                      <div class=" col-sm-12">
                        <label>Foto a subir:</label>
                      </div>
                      <div class="col-sm-12">
                        <input class="alert alert-secondary" style="background-color:#f1f3f785" type="file" name="archivo" required>
                      </div>

                      <div id="msj" class="alert alert-danger" role="alert" style="display: none">
                        Imagen editada correctamente
                      </div>
                    </div>
                    
                  </div>
                  <br>
                  <div class="acciones">
                    <input class="btn btn-danger" type="submit" name="" value="Subir Foto perfil">
                  </div>
                </form>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <button onclick="cargarFoto();" type="button" class="btn btn-primary" data-dismiss="modal">Guardar</button>
              </div>
            </div>
          </div>
        </div><!-- Fin modal--->

           
            </div>
            <div class="col-12 col-sm-4  p-xl-5 col-sm-offset-1"><!--campos administrador  -->
                <!--formulario administrador  -->
                <form>
                
                  <div class="form-group">
                    <h4>Datos personales</h4>
                    <hr style="background-color:#e91e63;">
                  </div>
                  <div class="form-row">

                    <label for="Nombre" >Nombre:</label>
                    <input type="text" class="form-control alert alert-secondary" style="background-color:#f1f3f785; display: none" id="codigo" placeholder="cod">
                    <input type="text" class="form-control alert alert-secondary" style="background-color:#f1f3f785" id="txtNombre" placeholder="Nombre usuario Administrador">
                    <span id="msjNombre" style="color:red;display: none">Nombres requeridos</span>
                  </div>
                  <div class="form-group">
                    <label for="Apellido" >Apellidos :</label>
                    <input type="text" class="form-control alert alert-secondary" style="background-color:#f1f3f785" id="txtApellidos" placeholder="Apellidos usuario Administrador" >
                    <span id="msjApellidos" style="color:red;display: none">Apellidos requeridos</span>
                  </div>
                  <div class="form-group">
                    <label for="correo">Correo electrónico:</label>
                    <input type="email" class="form-control alert alert-secondary" style="background-color:#f1f3f785" id="txtCorreo" placeholder="Correo administrador">
                    <span id="msjCorreo" style="color:red;display: none">Correo invalido<br>
                    Ejemplo:nombre@gmail.com</span>
                  </div>
                  <div class="form-group">
                    <label for="Fecha nacimiento">Fecha de nacimiento:</label>
                    <div class="alert alert-secondary" style="background-color:#f1f3f785" role="alert" id="fecha">
                  </div>
                  <div class="form-group">
                    <label for="telefono">Telefono:</label>
                    <input type="number" class="form-control alert alert-secondary" style="background-color:#f1f3f785" id="txtTelefono" placeholder="telefono administrador">
                    <span id="msjTelefono" style="color:red;display: none">Telefono invalido.<br> Ejemplo:96016817</span>
                  </div>
                  </div>
                  
                  <!--button class="btn btn-success" type="button" id="cerrarSesione">Cerrar Sesion </button--><br>
                  
                  
                </form><!--end formulario 
                administrador  -->
                
            </div><!--end campos administrador  -->
  <div class="col-12 col-sm-4 p-xl-5 col-sm-offset-1">
                  <form>
                   
                    <div class="form-group">
                    <h4>Ubicación</h4>
                    <hr >
                    <div class="form-group">
                    <label for="Departamento">Departamento Residencia:</label>
                    <select id="departamentos" class="form-control  alert-secondary" style="background-color:#f1f3f785" >
                        <option selected="selected" value="null">No hay nada que cargar</option>
                    </select>
                    <span id="msjDepto" style="color:red;display: none">Departamento requerido</span>
                  </div>
                  <div class="form-group">
                    <label for="Correo">Municipio:</label>
                    <select id="municipios" class="form-control  alert-secondary" style="background-color:#f1f3f785" disabled="">
                        <option selected="selected" value="null">Seleccione un departamento</option>
                    </select>
                    <span id="msjMunicipio" style="color:red;display: none">Municipio requerido</span>
                  </div>
                  <button type="button" class="btn btn-danger btn-block" onclick="editarPerfil();" >Guardar</button>
                  </div>
                  <div class="form-row"><span class="alert alert-danger" style="display: none" id="msjEditar"></span></div>
                  </form>

            </div>
        </div>
    </div>


    

</body>

 <script src="../js/jquery-3.4.1.min.js"></script>

<script src="../js/bootstrap.min.js"></script>

<script src="../js/bootstrap.bundle.min.js.descarga"></script>
<script src="../js/perfilAdmin.js"></script>

</body>

<!--script src="../js/perfil.js"></script-->

</html>