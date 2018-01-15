/*!
 * Gestión de Bodegas
 * Authors: Jon Vadillo (http://www.jonvadillo.es)
 * Licensed under MIT (https://github.com/jvadillo/php-mvc-crud
 */


/*
 * Al hacer click en el botón de editar, se habilitan los campos
 * para su edición.
 */ 
$('#editarBtn').click(function(){
    $(':disabled').removeAttr('disabled');   
});


$("#actualizarBodegaForm").submit(function(event) {
  event.preventDefault();
  console.log( "Handler for .submit() called." );
  enviarFormulario();
  
});

function enviarFormulario(){
	var formData = $('#actualizarBodegaForm').serialize();
	$.ajax({
	    type        : 'POST', // define the type of HTTP verb we want to use (POST for our form)
	    url         : 'index.php?controller=bodega&action=actualizar', // the url where we want to POST
	    data        : formData, // our data object
	    dataType    : 'json' // what type of data do we expect back from the server
	})
    // using the done promise callback
    .done(function(data) {
        console.log(data);
        $(':input').prop('disabled', true); 
        $('#mensajeActualizacionOK').show().delay(5000).fadeOut();
    })

    // using the fail promise callback
    .fail(function(data) {

        // show any errors
        // best to remove for production
        console.log(data);
        $('#mensajeActualizacionMal').show().delay(5000).fadeOut();
    });
}



