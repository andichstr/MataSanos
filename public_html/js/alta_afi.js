/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$(document).ready(function(){
    cargar_obras();
    
     $("#form_afiliado").on('submit', function (event) {
        event.preventDefault();
        var parametros = {
            "nombre": $("#txtNombre").val(),
            "apellido": $("#txtApellido").val(),
            "dni": $("#numDNI").val(),
            "genero": $("#selGenero").val(),
            "fecha_nacimiento": $("#dateNac").val(),
            "mail": $("#txtMail").val(),
            "os":$("#selObraSocial").val(),
            "numAfi":$("#txtAfiliado").val(),
            "localidad": $("#txtLocalidad").val(),
            "direccion": $("#txtDireccion").val(),
            "telefono": $("#numTelefono").val(),
            "celular": $("#numCelular").val(),
            "comentarios":$("#txtComentarios").val()
        }
        $.ajax({
            data: parametros,
            url: this.action,
            type: this.method,
            success: function (response) {
                var respuesta=Number(response);
                if(!(isNaN(respuesta)) && respuesta>0){
                    console.log("Registrado con id:"+respuesta);
                }else{
                    console.log(respuesta);
                }
            }
        });
    });
    
    
});



function cargar_obras(){ //cargar Obras Sociales en el select correspondiente
    $.ajax({
                url:   'conexiones/obras_sociales.php',
                success:  function (response) {
                    //console.log(response);
                    $('#selObraSocial').html(response);
                    $('#selObraSocial').append("<option selected='' style='color: red'>SELECCIONA OBRA SOCIAL</option>");
                    
                }
        });
}
