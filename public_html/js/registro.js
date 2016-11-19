$(document).ready(function () {

    $("#btnRegistrar").click(function () {
        if (validar_pass()){
            completarRegistro();
        }else{
            console.log("contraseña incompleta.")
        }
        
    }); 
      
});


function completarRegistro() {
    var parametros = {
        "pass": $("#txtPass").val(),
        "token": gup('token'),
        "dni":$('#numDNI').val()
    };
    
    $.ajax({
        data: parametros,
        url: 'conexiones/registro_completo.php',
        method: "POST",
        success: function (response) {
            if (response.localeCompare("Registro Completo")==0) {

                $('#divNotif div.modal-body').html("<p>Se ha registrado exitosamente!</p><p>Bienvenido a MataSanos!</p>");
                $('#divNotif').modal({
                    backdrop:"static"
                });
                
                document.getElementById('formRegistro').reset();
                //setTimeout(redirigir(),10000);
            }else{
                
                
                $('#divNotif div.modal-body').html("<p>"+response+"</p>");
                $('#divNotif').modal({
                    backdrop:"static"
                });
            }
        }
    });

}
function gup( name ){
	var regexS = "[\\?&]"+name+"=([^&#]*)";
	var regex = new RegExp ( regexS );
	var tmpURL = window.location.href;
	var results = regex.exec( tmpURL );
	if( results == null )
		return"";
	else
		return results[1];
}

function validar_pass() {
    if ($('#txtPass').val() !=='' && $("#txtPass").val() === $("#txtPass2").val()) {
        return true;
    } else {
        return false;
    }

}

function redirigir(){
    window.location.assign("solicitar_turno.php");
}