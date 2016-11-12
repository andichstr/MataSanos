$(document).ready(function () {
    $("#formMedico").on('submit', function (event) {
        event.preventDefault();
        var parametros = {
            "nombre": $("#txtNombre").val(),
            "apellido": $("#txtApellido").val(),
            "dni": $("#numDNI").val(),
            "genero": $("#selGenero").val(),
            "fecha_nacimiento": $("#dateNac").val(),
            "mail": $("#txtMail").val(),
            "localidad": $("#txtLocalidad").val(),
            "direccion": $("#txtDireccion").val(),
            "telefono": $("#numTel").val(),
            "matricula": $("#numMatric").val(),
//            "especialidades": $("#selEspecial").val(),
        }
        $.ajax({
            data: parametros,
            url: this.action,
            type: this.method,
            success: function (response) {
                $("#modalTitle").html("El mèdico fue dado de alta satisfactoriamente!");
                $("#modalDesc").html("Presione el botón cerrar, o haga click fuera de esta ventana para salir.");
                $("#divModal").modal('show');
            }
        });
    });
    $.ajax({
        url: './conexiones/cargar_especialidades.php',
        type: "POST",
        success: function(response) {
            $("#selEspecial").html(response);
        }
    });
    $("#selEspecial").change(function(){
        var str = "";
        $("#selEspecial option:selected").each(function() {
            str += '<div class="row"><div class="form-group col-lg-12"><h3>' + $(this).text() + '</h3></div></div>';
            str += '<div class="row"><div class="form-group col-lg-2 col-md-2 col-sm-2"><label for="selDias"' + $(this).text() + '>Días de turnos</label></div><div class="form-group col-lg-3 col-md-3 col-sm-3">';
            str += '<select class="form-control" name="selDias1" id="selDias1"><option value="Lunes">Lunes</option><option value="Martes">Martes</option><option value="Miercoles">Miercoles</option><option value="Jueves">Jueves</option><option value="Viernes">Viernes</option><option value="Sabado">Sábado</option></select></div>';
            str += '<div class="form-group col-lg-2 col-md-2 col-sm-2"><label for="selHora1' + $(this).text() + '">Horario de Inicio:</label></div>';
            str += '<div class="form-group col-lg-3 col-md-3 col-sm-3"><select class="form-control" name="selHoraInicio' + $(this).text() +'" id="selHoraInicio' + $(this).text() +'">';
            str += '<option value="0">00:00hs</option>';
            str += '<option value="1">01:00hs</option>';
            str += '<option value="2">02:00hs</option>';
            str += '<option value="3">03:00hs</option>';
            str += '<option value="4">04:00hs</option>';
            str += '<option value="5">05:00hs</option>';
            str += '<option value="6">06:00hs</option>';
            str += '<option value="7">07:00hs</option>';
            str += '<option value="8">08:00hs</option>';
            str += '<option value="9">19:00hs</option>';
            str += '<option value="10">10:00hs</option>';
            str += '<option value="11">11:00hs</option>';
            str += '<option value="12">12:00hs</option>';
            str += '<option value="13">13:00hs</option>';
            str += '<option value="14">14:00hs</option>';
            str += '<option value="15">15:00hs</option>';
            str += '<option value="16">16:00hs</option>';
            str += '<option value="17">17:00hs</option>';
            str += '<option value="18">18:00hs</option>';
            str += '<option value="19">19:00hs</option>';
            str += '<option value="20">20:00hs</option>';
            str += '<option value="21">21:00hs</option>';
            str += '<option value="22">22:00hs</option>';
            str += '<option value="23">23:00hs</option>';
            str += '</select></div>';
            str += '<div class="form-group col-lg-2 col-md-2 col-sm-2"><label for="selHora1' + $(this).text() + '">Horario de Fin:</label></div>';
            str += '<div class="form-group col-lg-3 col-md-3 col-sm-3"><select class="form-control" name="selHoraFin' + $(this).text() +'" id="selHoraFin' + $(this).text() +'">';
            str += '<option value="0">00:00hs</option>';
            str += '<option value="1">01:00hs</option>';
            str += '<option value="2">02:00hs</option>';
            str += '<option value="3">03:00hs</option>';
            str += '<option value="4">04:00hs</option>';
            str += '<option value="5">05:00hs</option>';
            str += '<option value="6">06:00hs</option>';
            str += '<option value="7">07:00hs</option>';
            str += '<option value="8">08:00hs</option>';
            str += '<option value="9">19:00hs</option>';
            str += '<option value="10">10:00hs</option>';
            str += '<option value="11">11:00hs</option>';
            str += '<option value="12">12:00hs</option>';
            str += '<option value="13">13:00hs</option>';
            str += '<option value="14">14:00hs</option>';
            str += '<option value="15">15:00hs</option>';
            str += '<option value="16">16:00hs</option>';
            str += '<option value="17">17:00hs</option>';
            str += '<option value="18">18:00hs</option>';
            str += '<option value="19">19:00hs</option>';
            str += '<option value="20">20:00hs</option>';
            str += '<option value="21">21:00hs</option>';
            str += '<option value="22">22:00hs</option>';
            str += '<option value="23">23:00hs</option>';
            str += '</select></div>';
            str += '<div class="col-lg-2 col-md-2 col-sm-2"><button class="btn btn-success btn-sm"><span class="glyphicon glyphicon-plus"></span></button></div></div>';
        });
        $("#turnosEspecialidades").html(str);
    });
});