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
                    if ((response.indexOf("Enviado")) != -1) {
                        $('#divNotif div.modal-body').html("<p>Afiliado Dado de Alta Satisfactoriamente! </p><p>Se ha enviado mail de invitación.");
                        $('#divNotif').modal({
                            backdrop: "static"
                        });

                        document.getElementById('form_afiliado').reset();

                    } else {
                        if ((response.indexOf("Error al enviar")) != -1) {
                            $('#divNotif div.modal-body').html("<p>Alta de Afiliado Correcta.</p><p>Sin embargo no se ha podido enviar mail</p>");
                            $('#divNotif').modal({
                                backdrop: "static"
                            });
//                            console.log(respuesta);
                        }

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
        if ($('#numCelular').val() == '') {
            $('#numCelular').val(null);
            console.log('el cel es un null');
        }
        
        return true;
    }
}