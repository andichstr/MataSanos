$(document).ready(function () {
	showturnos();
});

function showturnos(){
	$.ajax({
        url: './conexiones/turnos_disponibles.php',
        type: "POST",
        success: function (response) {
            console.log(response);
            if (response != false) {
                $("#descTabla").html(response);
            }else {
				$("#descTabla").empty();
                $("#modalTitle").html("Información:");
                $("#modalDesc").html("<p class='text-center'>No tiene ningún turno reservado actualmente.</p><p class='text-center'>A continuación podras solicitar un turno.</p>");
                $("#divModal").modal('show');
                $("#divModal").on("hidden.bs.modal", function () {
					document.location.href = 'solicitar_turno.php';
                });
            }
        }
    });
} 
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
                $("#modalTitle").html("Información:");
                $("#modalDesc").html("El turno fue cancelado exitosamente!");
                $("#divModal").modal('show');
                $("#divModal").on("hidden.bs.modal", function () {
                showturnos();
                });
            } else {
				modal = 'usando';
                $("#modalTitle").html("Atención!");
                $("#modalDesc").html("El turno no pudo ser cancelado. Por favor, intente nuevamente, o llame al número 011-4545-4545.");
                $("#divModal").modal('show');
            }
        }
    });
};
