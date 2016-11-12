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
        success: function (response) {
            $("#selEspecial").html(response);
        }
    });
    $("#selEspecial").change(function () {
        var str = "";
        $("#selEspecial option:selected").each(function () {
            var texto = "";
            var textocrudo = $(this).text();
            texto = $(this).text().replace(/\s/g, "_");
            str += '<div class="row"><div class="form-group col-lg-12"><h3>' + textocrudo + '</h3></div></div>';
            str += '<div class="container-fluid" id="' + texto + '"><div class="row"><div class="form-group col-lg-2 col-md-2 col-sm-2"><label for="selDias"' + texto + '>Día del turno</label></div><div class="form-group col-lg-2 col-md-2 col-sm-2">';
            str += '<select class="form-control" name="selDias' + texto + '" id="selDias' + texto + '"><option value="Lunes">Lunes</option><option value="Martes">Martes</option><option value="Miercoles">Miercoles</option><option value="Jueves">Jueves</option><option value="Viernes">Viernes</option><option value="Sabado">Sábado</option></select></div>';
            str += '<div class="form-group col-lg-2 col-md-2 col-sm-2"><label for="selHoraInicio' + texto + '">Horario de Inicio:</label></div>';
            str += '<div class="form-group col-lg-2 col-md-2 col-sm-2"><select class="form-control" name="selHoraInicio' + texto + '" id="selHoraInicio' + texto + '">';
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
            str += '<div class="form-group col-lg-2 col-md-2 col-sm-2"><label for="selHoraFin' + texto + '">Horario de Fin:</label></div>';
            str += '<div class="form-group col-lg-1 col-md-1 col-sm-1"><select class="form-control" name="selHoraFin' + texto + '" id="selHoraFin' + texto + '">';
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
            str += '<div class="col-lg-3 col-md-3 col-sm-3"><label for="duracionTurno' + texto + '">Duracion del turno en minutos:</label></div>';
            str += '<div class="col-lg-4 col-md-4 col-sm-4"><input type="number" class="form-control" placeholder="Duracion en minutos" id="duracionTurno"' + texto + 'name="duracionTurno' + texto + '"/></div></div></div>';
            str += '<div class="col-lg-12 col-md-12 col-sm-12"><input type="button" value="Agregar otro día" class="btn btn-success btn-sm" onclick="agregarDia(' + texto + ');"></div>';
        });
        $("#turnosEspecialidades").html(str);
    });
});

function agregarDia(txt) {
    var texto = $(this).text().replace(/\s/g, "_");
    str = "";
    str += '<div class="row"><div class="form-group col-lg-2 col-md-2 col-sm-2"><label for="selDias"' + texto + '>Día del turno</label></div><div class="form-group col-lg-2 col-md-2 col-sm-2">';
    str += '<select class="form-control" name="selDias' + texto + '" id="selDias' + texto + '"><option value="Lunes">Lunes</option><option value="Martes">Martes</option><option value="Miercoles">Miercoles</option><option value="Jueves">Jueves</option><option value="Viernes">Viernes</option><option value="Sabado">Sábado</option></select></div>';
    str += '<div class="form-group col-lg-2 col-md-2 col-sm-2"><label for="selHoraInicio' + texto + '">Horario de Inicio:</label></div>';
    str += '<div class="form-group col-lg-2 col-md-2 col-sm-2"><select class="form-control" name="selHoraInicio' + texto + '" id="selHoraInicio' + texto + '">';
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
    str += '<div class="form-group col-lg-2 col-md-2 col-sm-2"><label for="selHoraFin' + texto + '">Horario de Fin:</label></div>';
    str += '<div class="form-group col-lg-1 col-md-1 col-sm-1"><select class="form-control" name="selHoraFin' + texto + '" id="selHoraFin' + texto + '">';
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
    str += '<div class="col-lg-3 col-md-3 col-sm-3"><label for="duracionTurno' + texto + '">Duracion del turno en minutos:</label></div>';
    str += '<div class="col-lg-4 col-md-4 col-sm-4"><input type="number" class="form-control" placeholder="Duracion en minutos" id="duracionTurno"' + texto + 'name="duracionTurno' + texto + '"/></div></div>';
    $(txt).append(str);
}