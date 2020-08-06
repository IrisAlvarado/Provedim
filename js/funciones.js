$('#btnRegistro').click(obtenerJSON);
$('#btnGuardar').click(enviarDatos);

async function obtenerJSON()
{
    console.log("DOM cargado");

    document.getElementById("departamentos").innerHTML = " ";

    console.log('data="' + 'departamentos"');

    $.ajax({


        url: "backend/Select_Deptos_Municipios.php",
        data: 'data=' + 'departamentos', //+ "&contrasena=" + contrasena, //data, //"correo=" + $("#txt-correo").val().toLowerCase() + "&password=" + $("#txt-contrasena").val(),
        method: "POST",
        dataType: "json",
        success: function (respuesta) {
            console.log(respuesta);

            document.getElementById("departamentos").innerHTML += `<option selected="selected" value="null">
            Selecciona un departamento</option>`;


            for (let i = 0; i < respuesta.length; i++) {

                document.getElementById("departamentos").innerHTML +=
                    ` <option value="${respuesta[i].idDepartamento}">${respuesta[i].nombre}</option>`
            }
        },

        error: function (error) {
            console.log(error);
        }

    });
    
}

$('#departamentos').on('change', function (e) {
    var optionSelected = $("option:selected", this);
    var valueSelected = this.value;

    console.log(valueSelected);

    console.log('data=' + 'municipios&idMunicipio=' + valueSelected.trim());


    $.ajax({
        url: "backend/Select_Deptos_Municipios.php",
        data: 'data=' + 'municipios&idDepartamento=' + valueSelected.trim(), //+ "&contrasena=" + contrasena, //data, //"correo=" + $("#txt-correo").val().toLowerCase() + "&password=" + $("#txt-contrasena").val(),
        method: "POST",
        dataType: "json",
        success: function (respuesta) {
            console.log(respuesta);

            document.getElementById("municipios").innerHTML = "";

            document.getElementById("municipios").innerHTML += `<option selected="selected" value="null">
            Selecciona un municipio</option>`;


            for (let i = 0; i < respuesta.length; i++) {

                document.getElementById("municipios").innerHTML +=
                    ` <option value="${respuesta[i].idMunicipio}">${respuesta[i].nombre}</option>`
            }
        },

        error: function (error) {
            console.log(error);
        }
    });
});

async function enviarDatos()
{
    var Nombre = $('#pnombre').val();
    var sNombre = $('#snombre').val();
    var Apellido = $('#papellido').val();
    var sApellido = $('#sapellido').val();
    var Correo = $('#correo').val();
    var ID = $('#ID').val();
    var Telefono = $('#telefono').val();
    var Fecha = $('#fechaNacimineto').val();
    var Depto = $('#departamentos').val();
    var Ciudad = $('#municipios').val();
    var Password = $('#contrasenia').val();
    var pass = $('#confContrasenia');
    var Tipo = $('input:radio[name=tipo]:checked').val();
    var ConfPassword = $('#confContrasenia').val();
    var expr = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    console.log(Password);
    console.log(ConfPassword);
    
    if(validarVacio(Nombre) || validarVacio(sNombre))
    {
        alert("Debe ingresar su nombre");
    }
    else
    {
        if (validarVacio(Apellido) || validarVacio(sNombre)) 
        {
            alert("Debe ingresar su apellido");
        } 
        else 
        {
            if (validarVacio(Correo)) 
            {
                alert("Debe ingresar su correo");
            } 
            else 
            {
                if (!expr.test(Correo))
                {
                    alert("Error: La dirección de correo " + Correo + " es incorrecta.");
                }
                else
                {
                    if (validarVacio(ID))
                    {
                        alert("Debe ingresar su numero de identidad");
                    } 
                    else 
                    {
                        if (validarVacio(Telefono)) 
                        {
                            alert("Debe ingresar su telefono");
                        } else 
                        {
                            if (validarVacio(Fecha)) 
                            {
                                alert("Debe ingresar su fecha de nacimiento");
                            } 
                            else 
                            {
                                if (validarVacio(Depto)) 
                                {
                                    alert("Debe elegir un departamento");
                                } 
                                else 
                                {
                                    if (validarVacio(Ciudad)) 
                                    {
                                        alert("Debe elegir un municipio");
                                    } 
                                    else 
                                    {
                                        if (validarVacio(Password)) 
                                        {
                                            alert("Debe ingresar su contraseña");
                                        } 
                                        else 
                                        {
                                            if (validarVacio(ConfPassword))
                                            {
                                                alert("Debe confirmar su contraseña");
                                            }
                                            else
                                            {
                                                if (confirmarClave(Password, ConfPassword))
                                                {
                                                    alert("Las contraseñas no son iguales");
                                                }
                                                else
                                                {
                                                    if (!$("#contrtato").is(":checked"))
                                                    {
                                                        alert("Debe aceptar el contrato");
                                                    }
                                                    else 
                                                    {
                                                        if(validarTelefono(Telefono))
                                                        {
                                                            var cadena1 = `ppNombre=${Nombre}&psNombre=${sNombre}&ppApellido=${Apellido}&psApellido=${sApellido}&pcorreo=${Correo}&pfechaNac=${Fecha}&pmunicipio=${Ciudad}&pcontrasenia=${Password}&ptipoUsuario=${Tipo}`;
                                                        
                                                            console.log(cadena1);
                                                            $.ajax(
                                                                {
                                                                    type: 'POST',
                                                                    url: 'backend/registro_usuario.php',
                                                                    dataType: 'json',
                                                                    data: cadena1,
                                                                    success:function(resp)
                                                                    {   
                                                                        console.log(resp);
                                                                        if(resp.codigo==1)
                                                                        {
                                                                            
                                                                            var res = registrarTelefono(Telefono, resp.idUsuario);
                                                                            alert("Agregado con exito");
                                                                            var url = "http://localhost/Compra-y-venta-de-toda-papada-Back-master/registro.php";
                                                                            window.location = url;
                                                                        
                                                                        }
                                                                        else
                                                                        {
                                                                            alert("No se agrego el usuario");
                                                                        }
                                                                    }
                                                                }    
                                                            );
                                                        }
                                                        else
                                                        {
                                                            alert("Telefono no valido");
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    }
}

function validarVacio(valor)
{
    valor = valor.replace("&nbsp;","");
    valor = valor == undefined ? "" : valor;
    if(!valor || 0 === valor.trim().length)
    {
        return true;
    }
    else
    {
        return false;
    }
}

function confirmarClave(pass, conf)
{
    //console.log(pass);
    //console.log(conf);
    if(pass == conf)
    {
        return false;
    }
    else
    {
        return true;
    }
}

function validarTelefono(tel)
{
    var expr = /^[3]*[1-4]*[0-9]{8}$/;
    if(expr.test(tel))
    {
        return true;
    }
    else
    {
        expr = /^[8]*[7-9]*[0-9]{8}$/;
        if(expr.test(tel))
        {
            return true;
        }
        else
        {
            expr = /^[9]*[4-9]*[0-9]{8}$/;
            if(expr.test(tel))
            {
                return true;
            }
            else
            {
                return false;
            }
        }
    }
}

function registrarTelefono(tel, idUser)
{
    var cadena = `ptelefono=${tel}&pidUsuario=${idUser}`;
    console.log(cadena);
    $.ajax(
        {
            type: 'POST',
            url: 'backend/registro_telefono.php',
            dataType: 'json',
            data:cadena,
            success:function(resp)
            {
                console.log(resp);
                if(resp.cod==1)
                {
                    console.log("Se agreco el telefono");
                }
            }
        }
    );
}