$(document).ready(function(){

    // Modal

    $(".modal").on("click", function (e) {
        console.log(e);
        if (($(e.target).hasClass("modal-main") || $(e.target).hasClass("close-modal")) && $("#loading").css("display") == "none") {
            closeModal();
        }
    });

    // -> Modal

    // Abrir el inspector de archivos
    
    $(document).on("click", "#add-photo", function(){
        $("#file").click();
    });
    
    // -> Abrir el inspector de archivos

    // Cachamos el evento change
    
$(document).on("change", "#file", function () {
    
        console.log(this.files);
        var files = this.files;
        var element;
        var supportedImages = ["image/jpeg", "image/png", "image/gif"];
        var seEncontraronElementoNoValidos = false;

        for (var i = 0; i < files.length; i++) {
            element = files[i];
            console.log(element);
            if (supportedImages.indexOf(element.type) != -1) {
                createPreview(element);
            }
            else {
                seEncontraronElementoNoValidos = true;
            }
        }

        if (seEncontraronElementoNoValidos) {
            //showMessage("Se encontraron archivos no validos.");
            console.log('Se encontraron archivos no validos.');
        }
        else {
            //showMessage("Todos los archivos se subieron correctamente.");
            console.log('Todos los archivos se subieron correctamente.');
        }
    
    });
    
    // -> Cachamos el evento change

    // Eliminar previsualizaciones
    
    $(document).on("click", "#Images .image-container", function(e){
        $(this).parent().remove();
    });
    
    // -> Eliminar previsualizaciones

});

//Genera las previsualizaciones
function createPreview(file) {
    var imgCodified = URL.createObjectURL(file);
    //console.log('file '+file);
    var img = $('<div class="col-lg-6 col-md-6 col-sm-6 col-xl-4"><div class="image-container"> <figure> <img src="' + imgCodified + 
        '" alt="Foto del usuario" style="width: 198px;height: 300px;"> <figcaption> <i class="fas fa-times-circle"></i> </figcaption> </figure> </div></div>');
    $(img).insertBefore("#add-photo-container");
}

$("#btnSubirImg").on("click", function(){

  const queryString = window.location.search;
  const urlParams = new URLSearchParams(queryString);
  const idAnuncios = urlParams.get('idAnuncio');

    var formData= new FormData($("#formulario")[0]);
    var ruta ="../backend/addIMGEditar.php?idAnuncio="+idAnuncios+"";
    console.log(formData);

    $.ajax({
        url: ruta,
        type: "POST",
        data:formData,
        contentType:false,
        processData:false,
        
        success: function (respuesta) {
            console.log("entre");
            console.log(respuesta);

            $("#respuesta").html(respuesta);
            $("#respuesta").fadeIn();
            $("#respuesta").fadeOut(6000,function(){
               // window.location.replace("publicaciones.php");
               location.reload();
            });
        }
    });
});