$(document).ready(function () {
    $.ajax({
        url: './conexiones/turnos_disponibles.php',
        type: "POST",
        success: function (response) {
            console.log(response);
            if (response != 'No' || response != "") {
                $("#descTabla").html(response);
            } else {
                $("#modalTitle").html("No tiene ningún turno reservado actualmente");
                $("#modalDesc").html("Presione el botón cerrar, o haga click fuera de esta ventana para salir.");
                $("#divModal").modal('show');
            }
        }
    });
});

function cancelarTurno(id_turno){
    params = {
        "id_turno": id_turno
    };
    $.ajax({
        data: params,
        url: './conexiones/cancelar_turno.php',
        type: "POST",
        success: function (response) {
            if (response != '0' || response != "") {
                $("#modalTitle").html("El turno fue cancelado exitosamente!");
                $("#modalDesc").html("Presione el botón cerrar, o haga click fuera de esta ventana para salir.");
                $("#divModal").modal('show');
            } else {
                $("#modalTitle").html("El turno no pudo ser cancelado.");
                $("#modalDesc").html("Por favor, intente nuevamente, o llame al número 011-4545-4545.");
                $("#divModal").modal('show');
            }
        }
    });
};
