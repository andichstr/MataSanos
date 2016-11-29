$(document).ready(function () {
	$('h1').text('Modificar datos de afiliado');
	form();
    cargar_obras();
    cargar_datos();

    $("#form_afiliado").on('submit', function (event) {
        event.preventDefault();

        if (validar()) {
            var parametros = {
				"numAfi": $("#numAfiliado").val(),
				"dni": $("#numDNI").val(),
                "nombre": $("#txtNombre").val(),
                "apellido": $("#txtApellido").val(),
                "genero": $("#selGenero").val(),
                "fecha_nacimiento": $("#dateNac").val(),
                "mail": $("#txtMail").val(),
                "os": $("#selObraSocial").val(),
                "localidad": $("#txtLocalidad").val(),
                "direccion": $("#txtDireccion").val(),
                "telefono": $("#numTelefono").val(),
                "celular": $("#numCelular").val(),
                "comentarios": $("#txtComentarios").val(),
            };
            $.ajax({
                data: parametros,
                url: this.action,
                type: this.method,
                success: function (response) {
					console.log(response);
                    if (response==true) {
                        $('p#pmsj1').text('Los datos del Afiliado '+$("#txtNombre").val()+' '+$("#txtApellido").val());
						$('p#pmsj2').text('Han sido modificados correctamente');
						$('#divInforme').modal()       
						$('#divInforme').modal({ keyboard: false })
						$('#divInforme').modal('show') 
                    } else {
                        console.log(response);
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
			console.log(datos);
            $("#txtNombre").val(datos[0].nombre);
            $("#txtApellido").val(datos[0].apellido);
            $("#numDNI").val(datos[0].dni);
            $("#selGenero").val(datos[0].genero);
            $("#dateNac").val(datos[0].fecha_nacimiento);
            $("#txtMail").val(datos[0].mail);
            $("#selObraSocial").val(datos[0].id_obra_social),
            $("#numAfiliado").val(datos[0].numero_afiliado);
            $("#txtLocalidad").val(datos[0].localidad);
            $("#txtDireccion").val(datos[0].direccion);
            $("#numTelefono").val(datos[0].telefono);
            $("#numCelular").val(datos[0].celular);
            $("#txtComentarios").text(datos[0].comentarios);
            $("p.nota strong").text('Modificando datos de: '+datos[0].nombre+' '+datos[0].apellido);
            if (datos[1]==false){
				$("input#txtMail").attr('disabled',true);
			}
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
function form(){
	$("div.pass").hide();
	$("input.ope").removeAttr('disabled');
	$("select.ope").removeAttr('disabled');
	$("div#info").removeAttr('hidden');
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
            numTelefono: { number: true, minlength: 8},
            numCelular: { number: true, minlength: 10 },
        },
        messages: {
            numAfiliado: "Ingresa un dato valido.",
            numDNI: "Ingresa un dni válido",
            txtNombre: "Ingresa un nombre válido",
            txtApellido: "Ingresa un apellido válido",
            selGenero: "Seleccione su genero",
            dateNac: "Seleccione la fecha de nacimiento",
            txtMail: "Debe ingresar un email",
            selObraSocial: "Selecciona una obra social.",
            txtLocalidad: "Ingresa una localidad válida.",
            txtDireccion: "Ingresa una direccion válida",
            numTelefono: "Ingresa un telefono válido",
            numCelular: "No puedes modificar este campo",
            
        },
     });
     return validator.form();
}

