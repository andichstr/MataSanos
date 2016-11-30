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
                "comentarios": $("#txtComentarios").val()
            };
            $.ajax({
                data: parametros,
                url: this.action,
                type: this.method,
                success: function (response) {
                    console.log(response);
                    if (response == true) {
                        $('p#pmsj1').text('Los datos del Afiliado ' + $("#txtNombre").val() + ' ' + $("#txtApellido").val());
                        $('p#pmsj2').text('Han sido modificados correctamente');
                        $('#divInforme').modal();
                        $('#divInforme').modal({keyboard: false});
                        $('#divInforme').modal('show');
                    } else {
                        console.log(response);
                        $('p#pmsj1').text(response);
                        $('p#pmsj2').text('');
                        $('#divInforme').modal();
                        $('#divInforme').modal({keyboard: false});
                        $('#divInforme').modal('show');
                    }
                }
            });

        } else {
            $('p#pmsj1').text('Datos no validos. Revisa el formulario');
            $('p#pmsj2').text('');
            $('#divInforme').modal();
            $('#divInforme').modal({keyboard: false});
            $('#divInforme').modal('show');
        };
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
            $("#selObraSocial").val(datos[0].id_obra_social);
            $("#numAfiliado").val(datos[0].numero_afiliado);
            $("#txtLocalidad").val(datos[0].localidad);
            $("#txtDireccion").val(datos[0].direccion);
            $("#numTelefono").val(datos[0].telefono);
            $("#numCelular").val(datos[0].celular);
            $("#txtComentarios").text(datos[0].comentarios);
            $("p.nota strong").text('Modificando datos de: ' + datos[0].nombre + ' ' + datos[0].apellido);
            if (datos[1] == false) {
                $("input#txtMail").attr('disabled', true);
            }
            $("#form_afiliado :input").each(function () {
                $(this).keyup(function (event) {
                    validar();
                });
            });
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
function form() {
    $("div.pass").hide();
    $("input.ope").removeAttr('disabled');
    $("select.ope").removeAttr('disabled');
    $("div#info").removeAttr('hidden');
    $("div.comentarios").removeAttr('style');
}

function validar() {
    jQuery.validator.setDefaults({
        debug: true,
        success: "valid",
        highlight: function (element, errorClass, validClass) {
        if (element.type === "radio") {
				this.findByName(element.name).addClass(errorClass).removeClass(validClass);
			} else {
				$(element).closest('.form-group').removeClass('has-success has-feedback').addClass('has-error has-feedback');
				$(element).closest('.form-group').find('span.glyphicon').remove();
				$(element).closest('.form-group').append('<span class="glyphicon glyphicon-remove form-control-feedback hidden-xs" aria-hidden="true" style="padding-right: 50px;"></span>');
			}
		},
		unhighlight: function (element, errorClass, validClass) {
        if (element.type === "radio") {
				this.findByName(element.name).removeClass(errorClass).addClass(validClass);
			} else {
				$(element).closest('.form-group').removeClass('has-error has-feedback').addClass('has-success has-feedback');
				$(element).closest('.form-group').find('span.glyphicon').remove();
				$(element).closest('.form-group').append('<span class="glyphicon glyphicon-ok form-control-feedback hidden-xs" aria-hidden="true" style="padding-right: 50px;"></span>');
			}
		}
    });
    var validator = $("#form_afiliado").validate({
        rules: {
            numAfiliado: {required: true, maxlength: 8},
            numDNI: {required: true, minlength: 6, maxlength: 10, number: true},
            txtNombre: {required: true, lettersonly: true, minlength: 3, maxlength: 20},
            txtApellido: {required: true, lettersonly: true, minlength: 3, maxlength: 20},
            selGenero: {required: true},
            dateNac: {required: true},
            txtMail: {required: true, email: true, maxlength: 25},
            selObraSocial: {required: true},
            txtLocalidad: {required: true, maxlength: 15},
            txtDireccion: {required: true, maxlength: 30},
            numTelefono: {number: true, minlength: 8, maxlength: 12},
            numCelular: {number: true, minlength: 10, maxlength: 12},
            txtComentarios: {maxlength: 200},
        },
        messages: {
            numAfiliado: {required: "Completa el numero de afiliado.", maxlength: "Ingresa como máximo {0} caracteres"},
            numDNI: {required: "Completa el numero de DNI.", maxlength: "Ingresa como máximo {0} caracteres"},
            txtNombre: {required: "Completa el nombre.", maxlength: "Ingresa como máximo {0} caracteres",  lettersonly: "Solo se admiten letras."},
            txtApellido: {required: "Completa el apellido.", maxlength: "Ingresa como máximo {0} caracteres", lettersonly: "Solo se admiten letras."},
            selGenero: "Seleccione su genero",
            dateNac: "Seleccione la fecha de nacimiento",
            txtMail: {required: "Completa el mail.", maxlength: "Ingresa como máximo {0} caracteres", email: "Ingresa un email válido"},
            selObraSocial: "Selecciona una obra social.",
            txtLocalidad: {required: "Completa la localidad.", maxlength: "Ingresa como máximo {0} caracteres"},
            txtDireccion: {required: "Completa la dirección.", maxlength: "Ingresa como máximo {0} caracteres"},
            numTelefono: {required: "Completa el teléfono.", maxlength: "Ingresa como máximo {0} caracteres", minlength: "Ingresa {0} caracteres como mínimo", number: "Solo se admiten numeros."},
            numCelular: {maxlength: "Ingresa como máximo {0} caracteres", minlength: "Ingresa {0} caracteres como mínimo", number: "Solo se admiten numeros."},
            txtComentarios: {maxlength: "Ingresa como máximo {0} caracteres"}
        },
    });
    return validator.form();
}

