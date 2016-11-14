/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$(document).ready(function () {
    cargar_obras();
    cargar_datos();

//
    $("#form_afiliado").on('submit', function (event) {
        event.preventDefault();

        if (validar() && validar_pass()) {
            var parametros = {
                "nombre": $("#txtNombre").val(),
                "apellido": $("#txtApellido").val(),
                "dni": $("#numDNI").val(),
                "genero": $("#selGenero").val(),
                "fecha_nacimiento": $("#dateNac").val(),
                "mail": $("#txtMail").val(),
                "os": $("#selObraSocial").val(),
                "numAfi": $("#numAfiliado").val(),
                "localidad": $("#txtLocalidad").val(),
                "direccion": $("#txtDireccion").val(),
                "telefono": $("#numTelefono").val(),
                "celular": $("#numCelular").val(),
                "id_usuario": 21,
                "password": $("#txtPass").val()
//                "comentarios": $("#txtComentarios").val()
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
        data: {"id_afiliado": 21},
        url: 'conexiones/datos_afi.php',
        method: "GET",
        success: function (response) {
            var datos = JSON.parse(response); // la respuesta del servidor es un JSON

            $("#txtNombre").val(datos.nombre);
            $("#txtApellido").val(datos.apellido);
            $("#numDNI").val(datos.dni);
            $("#selGenero").val(datos.genero),
                    $("#dateNac").val(datos.fecha_nacimiento);
            $("#txtMail").val(datos.mail);
            $("#selObraSocial").val(datos.id_obra_social),
                    $("#numAfiliado").val(datos.numero_afiliado);
            $("#txtLocalidad").val(datos.localidad);
            $("#txtDireccion").val(datos.direccion);
            $("#numTelefono").val(datos.telefono);
            $("#numCelular").val(datos.celular);
//            $("#txtComentarios").val()


//            $('#selObraSocial').append("<option value='default' selected='' style='color: red'>SELECCIONA OBRA SOCIAL</option>");

        }
    });
}
function cargar_obras() { //cargar Obras Sociales en el select correspondiente
    $.ajax({
        url: 'conexiones/obras_sociales.php',
        success: function (response) {
            //console.log(response);
            $('#selObraSocial').html(response);
            // $('#selObraSocial').append("<option value='default' selected='' style='color: red'>SELECCIONA OBRA SOCIAL</option>");

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

function validar_pass() {
    if ($("#txtPass") === $("#txtPass2")) {
        return true;
    } else {
        return false;
    }

}