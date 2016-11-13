<?php
session_start();

function eliminar_sesion()
{
	if (isset($_SESSION['ssid']))
	{
		unset($_SESSION['ssid']);
		unset($_SESSION['userid']);
		unset($_SESSION['mail']);
		unset($_SESSION['nombre']);
		unset($_SESSION['roleuser']);
		session_destroy();
		echo json_encode('Deslogeado');
	}
	else{
		echo json_decode('Que onda? No estas logeado!');
	}
}
eliminar_sesion();
?>
