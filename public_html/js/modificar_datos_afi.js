$(document).ready(function () {
	$("div.comentarios").hide();
	$("p.nota").text('NOTA: Al modificar sus datos deberá introducir una nueva contraseña.');
    cargar_obras();
    cargar_datos();
    $("#form_afiliado").on('submit', function (event) {
        event.preventDefault();

        if (validar()) {
            var parametros = {
                "nombre": $("#txtNombre").val(),
                "apellido": $("#txtApellido").val(),
                "genero": $("#selGenero").val(),
                "fecha_nacimiento": $("#dateNac").val(),
                "mail": $("#txtMail").val(),
                "password": $("#txtPass").val(),
                "password2": $("#txtPass2").val(),
            };
            $.ajax({
                data: parametros,
                url: this.action,
                type: this.method,
                success: function (response) {
					console.log(response);
                    if (response==true) {
                        $('p#pmsj1').text('Tus datos han sido modificados correctamente');
						$('p#pmsj2').text('');
						$('#divInforme').modal()       
						$('#divInforme').modal({ keyboard: false })
						$('#divInforme').modal('show') 
                    } else {
                        $('p#pmsj1').text(response);
						$('p#pmsj2').text('');
						$('#divInforme').modal()       
						$('#divInforme').modal({ keyboard: false })
						$('#divInforme').modal('show') 
                    }
                }
            });

        } else {
			$('p#pmsj1').text('Datos no validos. Revisa el formulario');
			$('p#pmsj2').text('');
			$('#divInforme').modal()       
			$('#divInforme').modal({ keyboard: false })
			$('#divInforme').modal('show') 
        }
    });


});



function cargar_datos() { //Carga datos que actualmente estan guardados del cliente

    $.ajax({
        url: 'conexiones/datos_afi.php',
        method: "POST",
        success: function (response) {
            var datos = JSON.parse(response); // la respuesta del servidor es un JSON
			
            $("#txtNombre").val(datos.nombre);
            $("#txtApellido").val(datos.apellido);
            $("#numDNI").val(datos.dni);
            $("#selGenero").val(datos.genero);
            $("#dateNac").val(datos.fecha_nacimiento);
            $("#txtMail").val(datos.mail);
            $("#selObraSocial").val(datos.id_obra_social),
            $("#numAfiliado").val(datos.numero_afiliado);
            $("#txtLocalidad").val(datos.localidad);
            $("#txtDireccion").val(datos.direccion);
            $("#numTelefono").val(datos.telefono);
            $("#numCelular").val(datos.celular);
        }
    });
}
function cargar_obras() { //cargar Obras Sociales en el select correspondiente
    $.ajax({
        url: 'conexiones/obras_sociales.php',
        success: function (response) {
            //console.log(response);
            $('#selObraSocial').html(response);
        }
    });
}


function validar() {
    jQuery.validator.setDefaults({
	debug: true,
	success: "valid"
	});
	var validator = $("#form_afiliado").validate({
        rules: {
            numAfiliado: { required: true, minlength: 1 },
            numDNI: { required: true, minlength: 8, number: true },
            txtNombre: { required: true, lettersonly: true, minlength: 3 },
            txtApellido: { required: true, lettersonly: true, minlength: 3 },
            selGenero: { required:true },
            dateNac: { required:true },
            txtMail: { required: true, email: true },
            selObraSocial: { required: true },
            txtLocalidad: { required: true },
            txtDireccion: { required: true },
            numTelefono: { number: true, required: true, minlength: 8 },
            numCelular: { number: true, minlength: 10 },
            txtPass: { minlength: 6, required: true },
            txtPass2: { minlength: 6, required: true, equalTo:".txtPass" },
        },
        messages: {
            numAfiliado: "No puedes modificar este campo",
            numDNI: "No puedes modificar este campo",
            txtNombre: "Ingresa un nombre válido",
            txtApellido: "Ingresa un apellido válido",
            selGenero: "Seleccione su genero",
            dateNac: "Seleccione su fecha de nacimiento",
            txtMail: "Debe ingresar un email",
            selObraSocial: "No puedes modificar este campo",
            txtLocalidad: "No puedes modificar este campo",
            txtDireccion: "No puedes modificar este campo",
            numTelefono: "No puedes modificar este campo",
            numCelular: "No puedes modificar este campo",
            txtPass: "Ingresa una contraseña mas larga. Min 6 caracteres.",
            txtPass2: "Has ingresado una contraseña no válida.",
        },
     });
     return validator.form();
}

