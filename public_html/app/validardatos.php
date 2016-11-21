<?php
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
?>
