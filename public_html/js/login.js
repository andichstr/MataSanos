$(document).ready(function() {
	chklogin('login');
	$("#fLogin").submit(function(event){
		if(!validarForm())
		{
			//Detengo el submit
			event.preventDefault();
			//Mostrar divErrores
			$('#divErrores').modal()                      // initialized with defaults
			$('#divErrores').modal({ keyboard: false })   // initialized with no keyboard
			$('#divErrores').modal('show')                // initializes and invokes show immediately
		}else{
			event.preventDefault();
			//Enviar formulario
            var data = {
				 'email' : $('#txtMail').val(),
				 'pass' : $('#txtPass').val(),
			 };
			 console.log(data);
			 $.ajax({
                type: 'post',
                url: 'app/login.php',
                data: data,
                success: function(data){
					dat = jQuery.parseJSON(data)
					console.log(dat);
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
		$('#divErrores').modal()                      // initialized with defaults
		$('#divErrores').modal({ keyboard: false })   // initialized with no keyboard
		$('#divErrores').modal('show')                // initializes and invokes show immediately
		}
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

