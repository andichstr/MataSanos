/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$(document).ready(function () {
    cargar_obras();

    $("#form_afiliado").on('submit', function (event) {
        event.preventDefault();

        if (validar()) {
            var parametros = {
                "nombre": $("#txtNombre").val(),
                "apellido": $("#txtApellido").val(),
                "dni": $("#numDNI").val(),
                "genero": $("#selGenero").val(),
                "fecha_nacimiento": $("#dateNac").val(),
                "mail": $("#txtMail").val(),
                "os": $("#selObraSocial").val(),
                "numAfi": $("#txtAfiliado").val(),
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
                    var respuesta = Number(response);
                    if (!(isNaN(respuesta)) && respuesta > 0) {
                        $('#divNotif div.modal-body').html("<p>Afiliado Dado de Alta Satisfactoriamente! </p>");
                        $('#divNotif').modal({
                            backdrop: "static"
                        });
                        console.log("Usuario Registrado con id:" + respuesta);
                        document.getElementById('form_afiliado').reset();

                    } else {
                        $('#divNotif div.modal-body').html("<p>ERROR al dar de alta cliente.</p>");
                        $('#divNotif').modal({
                            backdrop: "static"
                        });
                        console.log(respuesta);
                    }
                }
            });

        } else {
            console.log("Formulario No validado");
        }


    });


});

function cargar_obras() { //cargar Obras Sociales en el select correspondiente
    $.ajax({
        url: 'conexiones/obras_sociales.php',
        success: function (response) {
            //console.log(response);
            $('#selObraSocial').html(response);
            $('#selObraSocial').append("<option value='default' selected='' style='color: red'>SELECCIONA OBRA SOCIAL</option>");

        }
    });
}

function validar() {
    if ($("#selObraSocial").val() === "default") {
        console.log("Seleccionar una Obra social");
        return false;

    } else {
        return true;
    }
}