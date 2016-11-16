$(document).ready(function () {
    $("#divPassword").hide();
    $("#divPassword2").hide();
    $("#divCompletar").hide();

    $("#formRegistro").on("submit", function (event) {
        event.preventDefault();

        var parametros = {
            "dni": $("#numDNI").val(),
            "mail": $("#txtMail").val()
        };
        $.ajax({
            data: parametros,
            url: 'conexiones/registro_final.php',
            method: "POST",
            success: function (response) { 
                if (!isNaN(response)) { // si el servidor devuelve el id del mail...
                    console.log(response);
                  
                        $("#divPassword").show();
                        $("#divPassword2").show();
                        $("#divCompletar").show();
                        $("#divComprobar").hide();//esconder el boton de comprobar los datos

                        $("#btnRegistrar").click(function () {
                            console.log("entró al registro de pass");
                            completarRegistro(response);
                        });  
                } else {
                    $('#divNotif').modal();                      // initialized with defaults
                    $('#divNotif').modal({keyboard: false});   // initialized with no keyboard
                    $('#divNotif').modal('show');
                    id_usuario = false;
                }
            }
        });
    });
});



function completarRegistro(id) {
    var parametros = {
        "pass": $("#txtPass").val(),
        "id_usuario": id
    };
    $.ajax({
        data: parametros,
        url: 'conexiones/registro_completo.php',
        method: "POST",
        success: function (response) {
            if (response==true) {

                $('#divNotif div.modal-body').html("<p>Se ha registrado exitosamente!</p><p>Bienvenido a MataSanos!</p>");
                $('#divNotif').modal({
                    backdrop:"static"
                });
                setTimeout(redirigir(),10000);
            }else{
                
                $('#divNotif div.modal-body').html("<p>Registro NO COMPLETADO!</p><p>Por favor introducir contraseña.</p>");
                $('#divNotif').modal({
                    backdrop:"static"
                });
            }
        }
    });

}

function validar_pass() {
    if ($("#txtPass") === $("#txtPass2")) {
        return true;
    } else {
        return false;
    }

}

function redirigir(){
    window.location.assign("solicitar_turno.php");
}