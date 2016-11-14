$(document).ready(function () {
    $("#divPassword").hide();
    $("#divPassword2").hide();
    $("#divCompletar").hide();

    $("#formRegistro").on("submit", function(event){
        event.preventDefault();
        var usuario_encontrado=enviarDatos();
        
        
        if (usuario_encontrado){
                $("#divPassword").show();
                $("#divPassword2").show();                
                $("#divCompletar").show();

                $("#divComprobar").hide();
                
                $("#btnRegistrar").click(function(){
                    console.log(usuario_encontrado);
                    
                });
        }       
    });
});


function enviarDatos() {
    
    var parametros = {
        "dni": $("#numDNI").val(),
        "mail": $("#txtMail").val()
    };

    $.ajax({
        data: parametros,
        url: 'conexiones/registro_final.php',
        method: "POST",
        success: function (response) {
            if (!isNaN(response)) {
                var id_usuario = response;
                return id_usuario;
            } else {
                $('#divErrores').modal();                      // initialized with defaults
                $('#divErrores').modal({ keyboard: false });   // initialized with no keyboard
                $('#divErrores').modal('show');     
                return false;
            }return id_usuario;
        }
        
    }); 
}

function completarRegistro(id){
    var parametros={
        "pass":$("#txtPass").val(),
        "id_usuario":id
    };
        $.ajax({
        data: parametros,
        url: 'conexiones/registro_completo.php',
        method: "POST",
        success: function (response) {
            if (response) {
//                console.log(response);
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