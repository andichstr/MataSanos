$(document).ready(function () {
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
                "numAfi": $("#numAfiliado").val(),
                "password": $("#txtPass").val(),
            };
            $.ajax({
                data: parametros,
                url: this.action,
                type: this.method,
                success: function (response) {
                    var respuesta = Number(response);
                    if (!(isNaN(respuesta)) && respuesta > 0) {
                        console.log("Usuario Registrado con id:" + respuesta);

                    } else {
                        console.log(respuesta);
                    }
                }
            });

        } else {
            console.log("Formulario No validado");
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
            numTelefono: { number: true },
            numCelular: { number: true , required: true},
            txtPass: { minlength: 6, required: true },
            txtPass2: { minlength: 6, required: true },
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

