<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog " role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-weight-bold" id="exampleModalLabel">Registro Administrador</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <div class="container">
                    <div class="row">
                        <div class="col col-lg-12" style="margin-left: auto !important;margin-right: auto !important;">

                            <form id="registro-form">
                                <!--TODO: anadir clases de is valid-->
                                <div style="text-align: center; margin-top: 1em; margin-bottom: 2em;">
                                    <h4>Registrate para poder comprar y vender.</h4>
                                </div>

                                <div class="form-group">
                                    <!-- <label>Email</label> -->
                                    <input type="text" class="form-control" id="nombres" name="nombres"
                                        placeholder="Ingrese sus nombres">
                                    <small style="display: none;" id="avisoNombres" class="form-text text-muted">
                                        Ingresa ambos nombres.</small>
                                </div>
                                <div class="form-group">
                                    <!-- <label>Email</label> -->
                                    <input type="text" class="form-control" id="apellidos" name="apellidos"
                                        placeholder="Ingrese sus apellidos">
                                    <small style="display: none;" id="avisoapellidos" class="form-text text-muted">
                                        Ingresa ambos apellidos.</small>
                                </div>
                                <div class="form-group">
                                    <!-- <label>Email</label> -->
                                    <label for="fechaNacimiento">Ingrese su fecha de nacimiento</label>
                                    <input type="date" class="form-control" id="fechaNacimiento" name="fechaNacimiento">
                                    <small style="display: none;" id="avisoFechaNacimiento"
                                        class="form-text text-muted">
                                        Debes ser mayor de 21 años para registrate.</small>
                                    <small style="display: none;" id="avisoFechaNacimiento2"
                                        class="form-text text-muted">
                                        Ingresa una fecha de nacimiento.</small>
                                </div>

                                <!--TODO: Input de municipios-->
                                <div class="form-group">
                                    <!-- <label>Email</label> -->
                                    <input type="email" class="form-control" id="correo" name="correo"
                                        placeholder="Ingrese su correo electrónico">
                                    <small style="display: none;" id="avisoCorreo" class="form-text text-muted">Ingresa
                                        un correo
                                        válido</small>
                                    <small style="display: none;" id="avisoCorreoExistente"
                                        class="form-text text-muted">
                                        El correo ya existe.</small>
                                </div>
                                <div class="form-group">
                                    <!-- <label for="exampleInputPassword1">Contraseña</label> -->
                                    <input type="password" class="form-control" id="contrasena" name="contrasena"
                                        placeholder="Contraseña">
                                    <small style="display: none;" id="avisoContrasena" class="form-text text-muted">La
                                        contrasena
                                        debe contener más de 8 caracteres.</small>
                                </div>

                                <div class="form-group">
                                    <!-- <label>Email</label> -->
                                    <input type="text" class="form-control" id="telefono" name="telefono"
                                        placeholder="Ingrese su teléfono.">
                                    <small style="display: none;" id="avisoTelefono" class="form-text text-muted">Ingresa
                                        un telefóno
                                        válido</small>
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
                                        <option selected="selected" value="null">Seleccione un departamento arriba
                                        </option>

                                    </select>

                                </div>

                                <div style="margin-left: auto;margin-right: auto;" class="text-center">
                                    <button type="button" class="btn btn-primary" id="registro-button"
                                        style=" width: 15em !important;">Registrase</button>

                                </div>
                                <span style="display: none" id="regAdmin">Registro Exitoso</span>
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

                <script src="../js/registro_administrador.js"></script>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>