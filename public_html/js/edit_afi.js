function editar_datos(id){
	params = {
        "id": id
    };
    $.ajax({
        data: params,
        url: './app/iniciar_consulta_afi.php',
        type: "POST",
        success: function (dat) {
			dat = jQuery.parseJSON(dat);
			if (dat==true){
				window.location.href = "editar_datos.php";
				}
			else{
				showmodal("Denegado",id);
				}
			
		}
    });
}
