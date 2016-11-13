$(document).ready(function () {
    $("#formAltaOperador").on('submit', function (event) {
        event.preventDefault();
        var parametros = {
            "nombre": $("#txtNombre").val(),
            "apellido": $("#txtApellido").val(),
            "mail": $("#txtMail").val(),
            "password": $("#txtPassword").val()
        }
        $.ajax({
            data: parametros,
            url: this.action,
            type: this.method,
            success: function (response) {
                console.log(response);
                $("#modalTitle").html("Exito!");
                $("#modalDesc").html(response);
                $("#divModal").modal('show');
            }
        });
    });
});