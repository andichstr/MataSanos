$(document).ready(function () {
    $("#selEspecialidad").change(function(){
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
                console.log(response);
                $("#listado").html(response);
                $("#listaresponse").show();
            }
        });
    });
});

function eliminarMedico(id){
    console.log(id)
};

function modificarMedico(id){
    console.log(id)
};