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
                } else {
                    $("#listaresponse").hide();
                    $("#modalTitle").html("No se encontro ningún médico con la especialidad seleccionada");
                    $("#modalDesc").html("Presione el botón cerrar, o haga click fuera de esta ventana para salir.");
                    $("#divModal").modal('show');
                }
            }
        });
    });
});

function confirmarEliminarMedico(id){
    $("#modalTitleConf").html("Confirme su acción");
    $("#modalDescConf").html("¿Está seguro que desea eliminar al médico?");
    $("#divModalConf").modal('show');
    $("#modalFooterConf").html('<button type="button" class="btn btn-default" data-dismiss="modal" onclick="eliminarMedico(' + id + ');">Confirmar</button><button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>');
};

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
};

function modificarMedico(id) {
    localStorage.setItem('id_medico', id);
    document.location.href = './modificar_medico.php';
};
