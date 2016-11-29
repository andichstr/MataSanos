function asignarturno(id){
	name = $( 'td:contains('+id+')' ).parent().children('td')[1].innerHTML;
	params = {
        "id": id,
        "nombre_afi" : name
    };
    $.ajax({
        data: params,
        url: './app/iniciar_consulta_afi.php',
        type: "POST",
        success: function (dat) {
			dat = jQuery.parseJSON(dat);
			if (dat==true){
				window.location.href = "solicitar_turno.php";
				}
			else{
				showmodal("Denegado",id);
				}
			
		}
    });
}
