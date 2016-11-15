$(document).ready(function() {
	chklogin('buscar_afiliado');
	
	$("#fLogin").submit(function(event){
		event.preventDefault();
		var data = {
			'dni': $('#numDni').val(),
			'apellido': $('#txtApellido').val(),
			'numafiliado': $('#numNAfiliado').val(),
			'email': $('#txtMail').val(),
		};
		$.ajax({
                type: 'post',
                url: 'buscar_afi.php',
                data: data,
                success: function(data){
					dat = jQuery.parseJSON(data)
					console.log(dat);
					redirect(dat);
					}
				});
	});
	
});
