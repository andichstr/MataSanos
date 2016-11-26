$(document).ready(function() {
	$("#fLogin").submit(function(event){
		if(!validarForm())
		{
			//Detengo el submit
			event.preventDefault();
			//Mostrar divErrores
			showmodal('Has ingresado un mail o contraseña inválidos. Revisa el formulario.');
		}else{
			event.preventDefault();
			//Enviar formulario
            var data = {
				 'email' : $('#txtMail').val(),
				 'pass' : $('#txtPass').val(),
			 };
			 $.ajax({
                type: 'post',
                url: 'app/login.php',
                data: data,
                success: function(data){
					dat = jQuery.parseJSON(data);
					redirect(dat);
					}
				});
		}
	});
});

function redirect(dat){
	if (dat==1){
		window.location.href = './turnos.php'
		}
	else if(dat==2){
		window.location.href = './alta_afiliado.php'
		}
	else if(dat==3){
		window.location.href = './buscar_medico.php'
		}
	else{
		showmodal(dat);
	}
}

function showmodal(dat){
	$('p.pmsj').text(dat);
	$('#divInforme').modal()       
	$('#divInforme').modal({ keyboard: false })
	$('#divInforme').modal('show')  
}

function validarForm()
{
	jQuery.validator.setDefaults({
	debug: true,
	success: "valid"
	});
	var validator = $("#fLogin").validate({
        rules: {
            txtMail: { required:true, email: true},
            txtPass: { required:true },
        },
        messages: {
            txtMail: "Debe ingresar un email válido",
            txtPass: "Debe ingresar la contraseña",
        },
     });
     return validator.form();

}
