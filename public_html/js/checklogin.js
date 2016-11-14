function chklogin(page){
var data = {
	'page' : page,
};
console.log(page);
$.ajax({
	type: 'post',
	url: 'app/chkuser.php',
	data: data,
	success: function(data){
		dat = jQuery.parseJSON(data);
		//console.log(dat);
		if (dat!='OK'){
			$(location).attr('href',dat);
			window.location=dat;
		}
	}
});	
}
