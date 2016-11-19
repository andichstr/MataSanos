function verturno(id){
	params = {
        "id": id
    };
    $.ajax({
        data: params,
        url: './app/consulta_turno_afi.php',
        type: "POST",
        success: function (dat) {
			if (dat=="Denegado"){
				showmodal();
				}
			}
    });
}
