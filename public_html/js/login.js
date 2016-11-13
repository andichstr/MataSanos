$(document).ready(function() {
	login();
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
					if (dat=='OK'){
						window.location.href = './turnos.php'
					}else{
						$('#divErrores').modal()                      // initialized with defaults
						$('#divErrores').modal({ keyboard: false })   // initialized with no keyboard
						$('#divErrores').modal('show')                // initializes and invokes show immediately
						}
					}
				});
		}
	});
});

$("#fMain").submit(function(e){
    e.preventDefault();
});

function login()
{
 $.ajax({
	type: 'post',
	url: 'app/login.php',
	data:'',
	success: function(data){
		dat = jQuery.parseJSON(data)
		console.log(dat);
		if (dat=='OK'){
			window.location.href = './turnos.php'
		}
		}
	});
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

