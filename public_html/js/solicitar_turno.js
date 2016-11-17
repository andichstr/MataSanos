$(document).ready(function () {
    $.ajax({
        url: './conexiones/cargar_especialidades.php',
        type: "POST",
        success: function (response) {
            $("#selEsp").html(response);
            $("#selEsp").val($("#selEsp option:first").val());
        }
    });
    cargarMedicos();
    cargarDias();
    cargarHorarios();
    $("#selEsp").change(function () {
        cargarMedicos();
    });
    $("#selMedico").change(function () {
        cargarDias();
    });
    $("#selDias").change(function() {
        cargarHorarios()
    });
});

function cargarMedicos() {
    var especialidad = $("#selEsp option:selected").val();
    var datos = {
        "especialidad": especialidad
    };
    $.ajax({
        data: datos,
        url: './conexiones/cargar_medicos.php',
        type: 'POST',
        success: function (response) {
            if (response != '0') {
                $("#selMedico").html(response);
                $("#selMedico").val($("#selMedico option:first").val());
            } else {
                $("#modalTitle").html("No se encontro ningún médico con la especialidad seleccionada");
                $("#modalDesc").html("Presione el botón cerrar, o haga click fuera de esta ventana para salir.");
                $("#divModal").modal('show');
            }
        }
    });
};

function cargarDias() {
    var id_medico = $("#selMedico option:selected").val();
    var params = {
        "id_medico": id_medico
    };
    $.ajax({
        data: params,
        url: "./conexiones/cargar_dias.php",
        type: "POST",
        success: function (respuesta) {
            $("#selDias").html(respuesta);
            $("#selDias").val($("#selDias option:first").val());
        }
    });
};

function cargarHorarios() {
    var dia = $("#selDias option:selected").val();
    var info = {
        "dia": dia
    };
    $.ajax({
        data: info,
        url: './conexiones/cargar_horarios.php',
        type: 'POST',
        success: function(response){
            console.log(response);
            $("#selHora").html(response);
        }
    });
}

function reservarTurno(){
    var especialidad = $("#selEsp option:selected").val();
    var id_medico = $("#selMedico option:selected").val();
    var dia = $("#selDias option:selected").val();
    var horario = $("#selHora option:selected").val();
    var parametros = {
        "especialidad": especialidad,
        "id_medico": id_medico,
        "dia": dia,
        "horario": horario
    };
    $.ajax({
        data: parametros,
        url: './conexiones/reservar_turno.php',
        type: 'POST',
        success: function(response) {
            if (response!=0){
                //mostrar modal success
            } else {
                //mostrar modal error
            }
        }
    })
}