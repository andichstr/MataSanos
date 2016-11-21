<?php
require_once('Validate.php');

function validar_dat_afi(){
	if (isset($_POST['os']) || isset($_POST['direccion']) || isset($_POST['localidad']) || isset($_POST['telefono']) || isset($_POST['celular']) || isset($_POST['comentarios'])){
		return False;
	}
	else if(isset($_POST['nombre']) and isset($_POST['apellido']) and isset($_POST['mail']) and isset($_POST['password']) and isset($_POST['password2']) and isset($_POST['genero']) and isset($_POST['fecha_nacimiento'])){
		if (validar_string($_POST['nombre'].$_POST['apellido']) and validar_mail($_POST['mail']) and validar_password($_POST['password'],$_POST['password2'])){
			return True;
		}else{return False;}
	}
}

function validar_dat_ope(){
	if (isset($_POST['password'])){
		return False;
		}
	else{
		if (isset($_POST['nombre']) and isset($_POST['apellido']) and isset($_POST['mail']) and isset($_POST['dni']) and isset($_POST['genero']) and isset($_POST['fecha_nacimiento']) and isset($_POST['os']) and isset($_POST['numAfi']) and isset($_POST['direccion']) and isset($_POST['localidad']) and isset($_POST['telefono']) and isset($_POST['celular']) and isset($_POST['comentarios'])){
			if(validar_string($_POST['nombre'].$_POST['apellido']) and validar_mail($_POST['mail']) and validar_dni($_POST['dni']) and validar_alfanumerico($_POST['numAfi']) and validar_texto($_POST['direccion']) and validar_string($_POST['localidad']) and validar_numero($_POST['telefono'])){
				if ($_POST['celular'] != ''){
				}
					if (validar_numero($_POST['celular'])){
					}
						if ($_POST['comentarios'] != ''){
							if (validar_texto($_POST['comentarios'])){
								return True;
								}else{return False;}
							}else{return False;}
			}else{return False;}
		}else{return False;}
	}
}
function validar_password($pass1,$pass2){
	if ($pass1 == $pass2){return true;}else{return false;}
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
	if (Validate::email($mail, array('use_rfc822' => true))) {return true;} 
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

//Validar DNI
function validar_dni($dni){
if (Validate::number($dni,array('decimal' => '', 'min' => 1000000, 'max' => 99999999 ))) {return true;}
	else {return false;}
}

//Validar campos alfanumericos
//Solo se admiten numeros y letras. No espacios, No simbolos. No tildes.
function validar_alfanumerico($alfanumerico){
	if (Validate::string($alfanumerico, array('format' => VALIDATE_NUM . VALIDATE_ALPHA_UPPER . VALIDATE_ALPHA_LOWER))) {return True;}
	else {return False;}
}

?>
