<?php
//Este modulo valida que el que accede a una funcionalidad de un afiliado es un operador
//la funcion validar_o() devuelve False si no esta la variable que guarda el id del afiliado ó el que accede no es un operador. 
// de lo contrario devuelte el id del afiliado para usarlo en donde corresponda.
// Si el que ingresa es un afiliado devuelve el id del mismo.

function validar_o(){
	if (isset($_SESSION['id_afiliado']) && ($_SESSION['roleuser'] == 2) {
		//me guardo el id_afiliado
		$id_afi = $_SESSION['id_afiliado'];
		return $id_afi;
	elseif (isset($_SESSION['userid'])) && ($_SESSION['roleuser'] == 1) {
		//me guardo el id_afiliado
		$id_afi = $_SESSION['userid'];
		return $id_afi;	
	}
	}else{return False;}
}
