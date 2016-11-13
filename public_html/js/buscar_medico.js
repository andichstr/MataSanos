$(document).ready(function () {
    $("#selEspecialidad").change(function () {
        console.log($("#selEspecialidad option:selected").val());
    });
    $.ajax({
        url: './conexiones/cargar_especialidades.php',
        type: "POST",
        success: function (response) {
            $("#selEspecialidad").html(response);
        }
    });
    $("#formBuscarMedicos").on('submit', function (event) {
        event.preventDefault();
        var parametros = {
            "especialidad": $("#selEspecialidad option:selected").val()
        };
        $.ajax({
            data: parametros,
            url: this.action,
            type: this.method,
            success: function (response) {
                if(response != '0'){
                    $("#listado").html(response);
                    $("#listaresponse").show();
                }
            }
        });
    });
});

function eliminarMedico(id) {
    $.ajax({
        data: {'id_medico': id},
        url: './conexiones/baja_medico.php',
        type: 'POST',
        success: function (response) {
            $("#modalTitle").html("Exito!");
            $("#modalDesc").html(response);
            $("#divModal").modal('show');
        }
    });
}
;

function modificarMedico(id) {
    console.log(id)
}
;