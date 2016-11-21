<?php
require_once('Validate.php');

function validar_dat_afi(){
	if (isset($_POST['os']) || isset($_POST['direccion']) || isset($_POST['localidad']) || isset($_POST['telefono']) || isset($_POST['celular']) || isset($_POST['comentarios'])){
		return False;
	}
	else if(isset($_POST['nombre']) or isset($_POST['apellido']) or isset($_POST['mail']) or isset($_POST['password']) or isset($_POST['dni']) or isset($_POST['genero']) or isset($_POST['fecha_nacimiento'])){
		return True;
	}else{return False;}
}

function validar_dat_ope(){
	if (isset($_POST['password'])){
		return False;
		}
	else{
		if (isset($_POST['nombre']) and isset($_POST['apellido']) and isset($_POST['mail']) and isset($_POST['dni']) and isset($_POST['genero']) and isset($_POST['fecha_nacimiento']) and isset($_POST['os']) and isset($_POST['numAfi']) and isset($_POST['direccion']) and isset($_POST['localidad']) and isset($_POST['telefono']) and isset($_POST['celular']) and isset($_POST['comentarios'])){  
		return True;
		}else{return False;}
	}

}

//Nombres, apellidos, localidades
//Aceptados: Letras mayusculas y minusculas, con tildes, espacios.
//Rechazados: todo tipo de simbolos especiales y numeros
function validar_string($string){
	if (Validate::string($string, array('format' => VALIDATE_SPACE . VALIDATE_EALPHA_UPPER . VALIDATE_EALPHA_LOWER))){return true;}
	else {return false;}
}

//Valida el mail. Ja.
function validar_mail($mail){
	if (Validate::email($email, array('use_rfc822' => true))) {return true;} 
	else {return false;}
}

//Para comentarios o texto que incluya numeros, tildes, puntos y comas. (Direcciones).
//No se admiten caracteres especiales que no sean de puntuación/exclamación ( . , : ; ´ ? ! " )
function validar_texto($texto){
	if (Validate::string($texto, array('format' => VALIDATE_NUM . VALIDATE_SPACE . VALIDATE_EALPHA_UPPER . VALIDATE_EALPHA_LOWER . VALIDATE_PUNCTUATION))) {return true;} else {return false;}
}

//Validar cualquier campo que contenga numeros. SOLO NUMEROS! NO FLOAT, NO DECIMALES, NO NEGATIVOS!!!
function validar_numero($numero){
if (Validate::number($numero,array('decimal' => '', 'min' => 0, 'max' => 99999999999999 ))) {return true;}
	else {return false;}
}

//Validar campos alfanumericos
//Solo se admiten numeros y letras. No espacios, No simbolos. No tildes.
function validar_alfanumerico($alfanumerico){
	if (Validate::string($alfanumerico, array('format' => VALIDATE_NUM . VALIDATE_ALPHA_UPPER . VALIDATE_ALPHA_LOWER))) {echo 'Valid!';}
	else {echo 'Invalid!';}
}

?>
