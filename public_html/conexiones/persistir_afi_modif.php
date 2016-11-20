<?php

include_once 'configure.php';
include_once 'conexion.php';
define('__ROOT__', dirname(dirname(__FILE__)));
include_once(__ROOT__.'.\app\validate_o_actions.php');

function main(){
	$respuesta = validar_o();
	if ($respuesta !=False){
		if (($_SESSION['roleuser']) == 1 and validar_dat_afi() or ($_SESSION['roleuser'] == 2) and validar_dat_ope()){
			$id_usuario = $respuesta; // es el id de usuario en realidad
			$list_presql = pregenerarsql($id_usuario); // genero o no el update de un campo especifico ya que un afiliado no enviará un post de un campo que no puede modificar. Igual para el operador.

			$nombre = $_POST['nombre'];
			$apellido = $_POST['apellido'];
			$mail = $list_presql['mail'];
			$pass = $list_presql['pass'];
			
			$id_afiliado = persistirUsuario($nombre,$apellido,$mail,$pass,$id_usuario);
			
			if ($id_afiliado!=False){
				$dni = $list_presql['dni'];
				$genero = $_POST['genero'];
				$fechanac = $_POST['fecha_nacimiento'];
				$id_obra_social = $list_presql['id_obra_social'];
				$numero_afiliado = $list_presql['numAfi'];
				$direccion = $list_presql['direccion'];
				$localidad = $list_presql['localidad'];
				$telefono = $list_presql['telefono'];
				$celular = $list_presql['celular'];
				$comentarios = $list_presql['comentarios'];
				persistirAfiliado($id_usuario,$dni,$genero,$fechanac,$id_obra_social,$numero_afiliado,$direccion,$localidad,$telefono,$celular,$comentarios);
			}
		}else{echo 'No se puede modificar afiliado';}	
			
	}else{echo 'No se puede modificar afiliado';}
}

function pregenerarsql($id_usuario){
	if (isset($_POST['numAfi'])){$numeroafi = ', numero_afiliado ='.$_POST['numAfi'];}else{$numeroafi = '';}
	if (isset($_POST['dni'])){$dni = ', dni ='.$_POST['dni'];}else{$dni = '';}
	if (isset($_POST['os'])){$os = ', id_obra_social='.$_POST['os'];}else{$os = '';}
	if (isset($_POST['localidad'])){$localidad = ', localidad='.$_POST['localidad'];}else{$localidad = '';}
	if (isset($_POST['direccion'])){$direccion = ', direccion='.$_POST['direccion'];}else{$direccion = '';}
	if (isset($_POST['telefono'])){$telefono = ', telefono='.$_POST['telefono'];}else{$telefono = '';}
	if (isset($_POST['celular'])){$celular = ', celular='.$_POST['celular'];}else{$celular = '';}
	if (isset($_POST['comentarios'])){$comentarios = ', comentarios='.$_POST['comentarios'];}else{$comentarios = '';}
	if (isset($_POST['pass'])){$pass = ', password='.convert_pass($_POST['password']);}else{$pass= '';}
	if (isset($_POST['mail'])){$mail = ', mail='.convert_pass($_POST['mail']);}else{$mail= '';}
	$array = array(
		"numAfi" => $numeroafi,
		"dni" => $dni,
		"id_obra_social" => $os,
		"localidad" => $localidad,
		"direccion" => $direccion,
		"telefono" => $telefono,
		"celular" => $celular,
		"comentarios" => $comentarios,
		"pass" => $pass,
		"mail" => $mail,
	);
	return $array;
}

function persistirUsuario($nombre, $apellido, $mail, $pass, $id) {

    $con = new Conexion();
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $query = $con->prepare("UPDATE " . tabla_usuarios . " SET nombre=:nombre, apellido=:apellido :mail :pass WHERE id_usuario=:id"); //id_tipo_usuario=1 es afiliado
    $query->bindParam(':nombre', $nombre);
    $query->bindParam(':apellido', $apellido);
    $query->bindParam(':mail', $mail);
    $query->bindParam(':pass', $pass);
    $query->bindParam(':id',$id);

    if ($query->execute()) {
        echo "usuario modificado persistido con id:" . $id . "<br>";
        return $id;
    } else {
        echo 'problema al modificar usuario con id: '.$id;
        return false;
    }
}

function persistirAfiliado($id, $dni, $genero, $fecha, $id_obra, $num_afi, $direccion, $localidad, $telefono, $celular, $comentarios) {
    $con = new Conexion();
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $query = $con->prepare("UPDATE " . tabla_afiliados . " SET dni=:dni, genero=:genero, fecha_nacimiento=:fecha_nacimiento :id_obra "
            . ":num_afi :direccion :localidad :telefono :celular :comentarios"
            . "WHERE id_usuario=:id");

    $query->bindParam(':id', $id);
    $query->bindParam(':dni', $dni);
    $query->bindParam(':genero', $genero);
    $query->bindParam(':fecha_nacimiento', $fecha);
    $query->bindParam(':id_obra', $id_obra);
    $query->bindParam(':num_afi', $num_afi);
    $query->bindParam(':direccion', $direccion);
    $query->bindParam(':localidad', $localidad);
    $query->bindParam(':telefono', $telefono);
    $query->bindParam(':celular', $celular);
    $query->bindParam(':comentarios', $comentarios);

    if ($query->execute()) {

        echo '<br><b>Afiliado Modificado Persistido con id: ' . $id . '</b>';
        return $id;
    } else {
        echo 'Afiliado NO persistido con id: '.$id;
        return false;
    }
}

function validar_dat_afi(){
	if (isset($_POST['os']) || isset($_POST['direccion']) || isset($_POST['localidad']) || isset($_POST['telefono']) || isset($_POST['celular']) || isset($_POST['comentarios'])){
		return False;
	}else{return True;}
//$_POST['nombre']$_POST['apellido']$_POST['mail']$_POST['password']$_POST['dni']$_POST['genero']$_POST['fecha_nacimiento']		
}

function validar_dat_ope(){
	if (isset($_POST['password'])){
		return False;
	}else{return True;}
}


function convert_pass($pass){
	$key =  'dIifPmNOzV6pIYl8684fjfqckAwjxk9a';
	$key2 = '8HjPYTImY96oO3l65TPz7F7TQJHUSR9y';
	$passhashed = md5($key.$pass.$key2);
	return $passhashed;
};

main();
?>

