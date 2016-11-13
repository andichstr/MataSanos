function logout()
{
 $.ajax({
	type: 'post',
	url: 'app/logout.php',
	data:'',
	success: function(data){
		dat = jQuery.parseJSON(data)
		console.log(dat);
		if (dat=='Deslogeado'){
		window.location.href = './index.php'
		}
	}
});
}
