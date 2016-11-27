$(document).ready(function () {
    $("#formMedico").on('submit', function (event) {
        event.preventDefault();
        if (validar_form()) {
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
                    var especialidades_txt = [];
                    $("#selEspecial option:selected").each(function () {
                        especialidades.push($(this).val());
                        especialidades_txt.push($(this).html());
                    });


                    var datos = {
                        "id_medico": response,
                        "especialidades": especialidades,
                    };

                    $.ajax({
                        data: datos,
                        url: "./conexiones/persistir_medico_especialidad.php",
                        type: "POST",
                        success: function (respuesta) {
                            if (respuesta.localeCompare("Si") == 0) {
                                console.log("persistido medico con especialidad.")
                                var turnos = [];
                                turnos = llenarTurnos(turnos, especialidades_txt);

                                var horarios_turnos = {
                                    "id_medico": response,
                                    "especialidades": especialidades,
                                    "horarios": turnos
                                };

                                $.ajax({
                                    data: horarios_turnos,
                                    url: "./conexiones/persistir_horarios_turnos_medicos.php",
                                    type: "POST",
                                    success: function (valor) {

                                        $("#modalTitle").html("El médico fue dado de alta satisfactoriamente!");
                                        $("#modalDesc").html("Presione el botón cerrar, o haga click fuera de esta ventana para salir.");
                                        $("#divModal").modal('show');
                                    }
                                });
                            } else {
                                console.log("algo paso con la repuesta de m-e");
                            }
                        }
                    });
                }
            });

        }else{// si no se valida el form..
            
        }
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
            str += '<div class="form-group col-lg-3 col-md-3 col-sm-3 col-xs-3"><label for="selDias' + texto + '0">Día del turno</label></div>';
            str += '<div class="form-group col-lg-3 col-md-3 col-sm-3 col-xs-3"><label>Horario de Inicio:</label></div>';
            str += '<div class="form-group col-lg-3 col-md-3 col-sm-3 col-xs-3"><label>Horario de Fin:</label></div>';
            str += '<div class="form-group col-lg-3 col-md-3 col-sm-3 col-xs-3"><label>Duracion del turno en minutos:</label></div></div>';
            str += '<div class="row" style="padding-bottom: 4px"><div class="form-group col-lg-3 col-md-3 col-sm-3 col-xs-3"><select class="form-control" name="selDias' + texto + '0" id="selDias' + texto + '0"><option value="Lunes">Lunes</option><option value="Martes">Martes</option><option value="Miercoles">Miercoles</option><option value="Jueves">Jueves</option><option value="Viernes">Viernes</option><option value="Sabado">Sábado</option><option value="Domingo">Domingo</option></select></div>';
            str += '<div class="form-group col-lg-3 col-md-3 col-sm-3 col-xs-3"><input type="time" class="form-control" placeholder="hhmmss" name="HoraInicio' + texto + '0" id="HoraInicio' + texto + '0" required/></div>';
            str += '<div class="form-group col-lg-3 col-md-3 col-sm-3 col-xs-3"><input type="time" class="form-control" placeholder="hhmmss" name="HoraFin' + texto + '0" id="HoraFin' + texto + '0" required/></div>';
            str += '<div class="form-group col-lg-3 col-md-3 col-sm-3 col-xs-3"><input type="number" class="form-control" placeholder="Duracion en minutos" id="duracionTurno' + texto + '0" name="duracionTurno' + texto + '" required/></div></div></div>';
            str += '<div class="row"><div class="col-lg-12 col-md-12 col-sm-12" style="padding-bottom: 4px"><input id="btnAgregarDia' + texto + '" type="button" name="btnAgr" value="Agregar otro día" class="btn btn-success btn-sm" onclick="agregarDia(' + texto + ');"></div></div>';
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
        str += '<div class="row" style="padding-bottom: 4px"><div class="form-group col-lg-3 col-md-3 col-sm-3 col-xs-3"><select class="form-control" name="selDias' + texto + i + '0" id="selDias' + texto + i + '"><option value="Lunes">Lunes</option><option value="Martes">Martes</option><option value="Miercoles">Miercoles</option><option value="Jueves">Jueves</option><option value="Viernes">Viernes</option><option value="Sabado">Sábado</option><option value="Domingo">Domingo</option></select></div>';
        str += '<div class="form-group col-lg-3 col-md-3 col-sm-3 col-xs-3"><input type="time" class="form-control" name="HoraInicio' + texto + i + '0" id="HoraInicio' + texto + i + '"/></div>';
        str += '<div class="form-group col-lg-3 col-md-3 col-sm-3 col-xs-3"><input type="time" class="form-control" name="HoraFin' + texto + i + '0" id="HoraFin' + texto + i + '"/></div>';
        str += '<div class="form-group col-lg-3 col-md-3 col-sm-3 col-xs-3"><input type="number" class="form-control" placeholder="Duracion en minutos" id="duracionTurno' + texto + i + '" name="duracionTurno' + texto + i + '"/></div></div></div>';
        $(txt).append(str);
    }
    ;
}
;

function llenarTurnos(arrTurnos, arrEspecialidades) {
    var a = 0, b = 0;
    var fin = false;
    while (!fin) {
        var dia = $("#selDias" + arrEspecialidades[b] + a + " option:selected").val();
        var horarioInicio = $("#HoraInicio" + arrEspecialidades[b] + a).val();
        var horarioFin = $("#HoraFin" + arrEspecialidades[b] + a).val();
        var duracion = $("#duracionTurno" + arrEspecialidades[b] + a).val();
        arrTurnos.push({'dia': dia, 'horarioInicio': horarioInicio, 'horarioFin': horarioFin, 'duracion': duracion});

        a++;
        if ($("#HoraInicio" + arrEspecialidades[b] + a).val() == undefined || $("#HoraInicio" + arrEspecialidades[b] + a).val() == null) {

            if (b >= arrEspecialidades.length - 1) {//preguto si llegue al limite de especialidades
                fin = true;
            } else {
                b++
            }
        } else {

        }
    }
    return arrTurnos;
}


function validar_form() {
    jQuery.validator.setDefaults({
        debug: true,
        success: "valid"
    });
    var validator = $("#formMedico").validate({
        rules: {
            numDNI: {required: true, minlength: 8, number: true},
            txtNombre: {required: true, minlength: 3, maxlength: 50},
            txtApellido: {required: true, minlength: 3, maxlength: 50},
            selGenero: {required: true},
            dateNac: {required: true},
            txtMail: {required: true, email: true},
            numMatric: {required: true, maxlength: 9},
            txtLocalidad: {required: true, minlength: 4, maxlength: 50},
            txtDireccion: {required: true, minlength: 4, maxlength: 50},
            numTel: {number: true, required: true, minlength: 8, maxlength: 20},
        },
        messages: {
            numDNI: "El DNI es requerido. Debe tener un minimo de 8 digitos.",
            txtNombre: "Ingresa un nombre válido. Maximo de 50 caracteres.",
            txtApellido: "Ingresa un apellido válido. Maximo de 50 caracteres.",
            selGenero: "Seleccione su genero",
            dateNac: "Seleccione su fecha de nacimiento.",
            txtMail: "Debe ingresar un email valido.",
            numMatric: "Ingresar una matricula valida.",
            txtLocalidad: "Localidad permite hasta 50 caracteres.",
            txtDireccion: "Direccion permite hasta 50 caracteres.",
            numTel: "El telefono puede tener entre 8 y 20 digitos."
        }
    });
    return validator.form();
}