$(document).ready(function(){
    console.log(localStorage.getItem('id_medico'));
    id_medico = localStorage.getItem('id_medico');
    parametros = {
        "id_medico": id_medico
    }
    $.ajax({
        data: parametros,
        url: './conexiones/cargar_datos_medico.php',
        type: 'POST',
        success: function(response){
            if (response!='0'){
                console.log(response);
                var datos = JSON.parse(response);
                $("#txtNombre").val(datos.nombre);
                $("#txtApellido").val(datos.apellido);
                $("#numDNI").val(datos.dni);
                $("#selGenero option[value="+datos.genero+"]").attr('selected','selected');
                $("#dateNac").val(datos.fecha_nacimiento);
                $("#txtMail").val(datos.mail);
                $("#txtLocalidad").val(datos.localidad);
                $("#txtDireccion").val(datos.direccion);
                $("#numTel").val(datos.telefono);
                $("#numMatric").val(datos.numero_matricula);
            } else {
                console.log("No se logró la carga de los datos del medico, intente nuevamente.");
            }
        }
    });
    $("#actualizarForm").on('submit', function(event){
        event.preventDefault();
        info = {
            "id_medico": localStorage.getItem('id_medico'),
            "nombre": $("#txtNombre").val(),
            "apellido": $("#txtApellido").val(),
            "dni": $("#numDNI").val(),
            "genero": $("#selGenero option:selected"),
            "fecha_nacimiento": $("#dateNac").val(),
            "mail": $("#txtMail").val(),
            "localidad": $("#txtLocalidad").val(),
            "direccion": $("#txtDireccion").val(),
            "telefono": $("#numTel").val(),
            "matricula": $("#numMatric").val()
        };
        $.ajax({
            data: info,
            url: this.action,
            type: this.method,
            success: function(response){
                if (response!='0'){
                    //mostrar modal de success
                    localStorage.removeItem('id_medico');
                } else {
                    //mostrar modal de error
                    console.log("Error en la actualizacion");
                };
            }
        });
    });
});