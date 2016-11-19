function verturnos(id){
	params = {
        "id": id
    };
    $.ajax({
        data: params,
        url: './app/consulta_turno_afi.php',
        type: "POST",
        success: function (dat) {
			dat = jQuery.parseJSON(data);
			if (dat==True){
				
				}
			
		}
    });
}
