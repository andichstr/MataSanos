$(document).ready(function(){
	$("#fBuscar").submit(function(event){
		event.preventDefault();
		var data = {
			'dni': $('#numDni').val(),
			'apellido': $('#txtApellido').val(),
			'numafiliado': $('#numNAfiliado').val(),
			'mail': $('#txtMail').val(),
		};
		$.ajax({
                type: 'post',
                url: 'conexiones/buscar_afiliado.php',
                data: data,
                success: function(data){
					dat = jQuery.parseJSON(data);
					console.log(dat);
					}
				});
	});
	
});
