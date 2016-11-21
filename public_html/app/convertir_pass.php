<?php
function convert_pass($pass){
	$key =  'dIifPmNOzV6pIYl8684fjfqckAwjxk9a';
	$key2 = '8HjPYTImY96oO3l65TPz7F7TQJHUSR9y';
	$passhashed = md5($key.$pass.$key2);
	return $passhashed;
};
?>
