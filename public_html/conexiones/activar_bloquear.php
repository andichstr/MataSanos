<?php
require_once('configure.php');
require_once('conexion.php');

session_start();

function main(){
	if ((isset($_SESSION['ssid']) && $_SESSION['roleuser'] == 2) or (isset($_SESSION['ssid']) && $_SESSION['roleuser'] == 3)){
		if (isset($_POST['id'])){
			$id = $_POST['id'];
			$estado = consultar_estado($id);
			
			if ($estado == 0){
				$activo = 1;
			}else{
				$activo = 0;
			}
			
			$cn = new Conexion();
			$query = $cn->prepare("UPDATE afiliados SET activo = ? WHERE (id_usuario=?)");
			$query->execute(array($activo,$id));
			$datos = $query->rowCount();
			$cn = NULL;
			
			echo json_encode($activo);
		}
	}
	else{
		echo json_encode("Denegado");
		}
}

function consultar_estado($id){
	$con = new Conexion();
	$query = $con->prepare("Select activo from afiliados WHERE (id_usuario=?)");
	$query->execute(array($id));
	$datos = $query->fetch();
	$con = NULL;
	return $datos['activo'];
	}

main();

?>
