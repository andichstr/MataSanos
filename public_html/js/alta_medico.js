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
        }
        $.ajax({
            data: parametros,
            url: this.action,
            type: this.method,
            success: function (response) {
                console.log(response);
                var especialidades = [];
                $("#selEspecial option:selected").each(function () {
                    especialidades.push($(this).val());
                });
                var datos = {
                    "id_medico": response,
                    "especialidades": especialidades
                };
                $.ajax({
                    data: datos,
                    url: "./conexiones/persistir_medico_especialidad.php",
                    type: "POST",
                    success: function (respuesta) {
                        console.log(respuesta);
                        if (respuesta = 'Si') {
                            var turnos = [];
                            turnos = llenarTurnos(turnos, especialidades);
                            var horarios_turnos = {
                                "id_medico": response,
                                "especialidades": especialidades,
                                "horarios": turnos
                            };
                            $.ajax({
                                data: horarios_turnos,
                                url: "./conexiones/persistir_horarios_turnos_medicos.php",
                                type: "POST",
                                success: function (valor){
                                    console.log(valor);
                                    $("#modalTitle").html("El médico fue dado de alta satisfactoriamente!");
                                    $("#modalDesc").html("Presione el botón cerrar, o haga click fuera de esta ventana para salir.");
                                    $("#divModal").modal('show');
                                }
                            });
                        }

                    }
                });
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
            str += '<div class="row" style="padding-bottom: 4px"><div class="form-group col-lg-12"><h3>' + textocrudo + '</h3></div></div>';
            str += '<div class="container-fluid" id="' + texto + '"><div class="row" style="padding-bottom: 4px">';
            str += '<div class="form-group col-lg-3 col-md-3 col-sm-3 col-xs-3"><label>Día del turno</label></div>';
            str += '<div class="form-group col-lg-3 col-md-3 col-sm-3 col-xs-3"><label>Horario de Inicio:</label></div>';
            str += '<div class="form-group col-lg-3 col-md-3 col-sm-3 col-xs-3"><label>Horario de Fin:</label></div>';
            str += '<div class="form-group col-lg-3 col-md-3 col-sm-3 col-xs-3"><label>Duracion del turno en minutos:</label></div></div>';
            str += '<div class="row" style="padding-bottom: 4px"><div class="form-group col-lg-3 col-md-3 col-sm-3 col-xs-3"><select class="form-control" name="selDias' + texto + '0" id="selDias' + texto + '0"><option value="Lunes">Lunes</option><option value="Martes">Martes</option><option value="Miercoles">Miercoles</option><option value="Jueves">Jueves</option><option value="Viernes">Viernes</option><option value="Sabado">Sábado</option><option value="Domingo">Domingo</option></select></div>';
            str += '<div class="form-group col-lg-3 col-md-3 col-sm-3 col-xs-3"><input type="time" class="form-control" placeholder="hhmmss" name="HoraInicio' + texto + '0" id="HoraInicio' + texto + '0"/></div>';
            str += '<div class="form-group col-lg-3 col-md-3 col-sm-3 col-xs-3"><input type="time" class="form-control" placeholder="hhmmss" name="HoraFin' + texto + '0" id="HoraFin' + texto + '0"/></div>';
            str += '<div class="form-group col-lg-3 col-md-3 col-sm-3 col-xs-3"><input type="number" class="form-control" placeholder="Duracion en minutos" id="duracionTurno' + texto + '0" name="duracionTurno' + texto + '"/></div></div></div>';
            str += '<div class="row"><div class="col-lg-12 col-md-12 col-sm-12" style="padding-bottom: 4px"><input id="btnAgregarDia' + texto + '" type="button" value="Agregar otro día" class="btn btn-success btn-sm" onclick="agregarDia(' + texto + ');"></div></div>';
        });
        $("#turnosEspecialidades").html(str);
    });
});

var i = 0;

function agregarDia(txt) {
    if (i < 6) {
        i++;
        var texto = $(this).text().replace(/\s/g, "_");
        str = "";
        str += '<div class="row" style="padding-bottom: 4px"><div class="form-group col-lg-3 col-md-3 col-sm-3 col-xs-3"><label>Día del turno</label></div>';
        str += '<div class="form-group col-lg-3 col-md-3 col-sm-3 col-xs-3"><label>Horario de Inicio:</label></div>';
        str += '<div class="form-group col-lg-3 col-md-3 col-sm-3 col-xs-3"><label>Horario de Fin:</label></div>';
        str += '<div class="form-group col-lg-3 col-md-3 col-sm-3 col-xs-3"><label>Duracion del turno en minutos:</label></div></div>';
        str += '<div class="row" style="padding-bottom: 4px"><div class="form-group col-lg-3 col-md-3 col-sm-3 col-xs-3"><select class="form-control" name="selDias' + texto + i + '0" id="selDias' + texto + i + '0"><option value="Lunes">Lunes</option><option value="Martes">Martes</option><option value="Miercoles">Miercoles</option><option value="Jueves">Jueves</option><option value="Viernes">Viernes</option><option value="Sabado">Sábado</option><option value="Domingo">Domingo</option></select></div>';
        str += '<div class="form-group col-lg-3 col-md-3 col-sm-3 col-xs-3"><input type="time" class="form-control" name="HoraInicio' + texto + i + '0" id="HoraInicio' + texto + i + '0"/></div>';
        str += '<div class="form-group col-lg-3 col-md-3 col-sm-3 col-xs-3"><input type="time" class="form-control" name="HoraFin' + texto + i + '0" id="HoraFin' + texto + i + '0"/></div>';
        str += '<div class="form-group col-lg-3 col-md-3 col-sm-3 col-xs-3"><input type="number" class="form-control" placeholder="Duracion en minutos" id="duracionTurno' + texto + i + '0" name="duracionTurno' + texto + i + '"/></div></div></div>';
        $(txt).append(str);
    };
};

function llenarTurnos(arrTurnos, arrEspecialidades) {
    var a, b = 0;
    var fin = false;
    while (!fin) {
        var dia = $("#selDias" + arrEspecialidades[b] + a + "option:selected").val();
        var horarioInicio = $("#HoraInicio" + arrEspecialidades[b] + a).val();
        var horarioFin = $("#HoraFin" + arrEspecialidades[b] + a).val();
        var duracion = $("#duracionTurno" + arrEspecialidades[b] + a).val();
        arrTurnos.push({'dia': dia, 'horarioInicio': horarioInicio, 'horarioFin': horarioFin, 'duracion': duracion});
        a++;
        console.log($("#HoraInicio" + arrEspecialidades[b] + a).val());
        if ($("#HoraInicio" + arrEspecialidades[b] + a).val() == undefined || $("#HoraInicio" + arrEspecialidades[b] + a).val() == null){
            if (b >= arrEspecialidades.length){
                fin = true;
            } else {
                b++
            }
        }
    }
    return arrTurnos;
};