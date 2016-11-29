function verturnos(id){
	name = $( 'td:contains('+id+')' ).parent().children('td')[1].innerHTML;
	console.log(name);
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
				window.location.href = "turnos.php";
				}
			else{
				showmodal("Denegado",id);
				}
			
		}
    });
}
