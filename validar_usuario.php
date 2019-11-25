<?php
	include 'bd/usuarioDAO.php';
	include 'bd/loginDAO.php';
	include 'bd/retailDAO.php';

	header('Content-type: application/json');

	session_start();
	$usuario = mysql_escape_string($_REQUEST["correo"]);
	$user = usuarioDAO::getUserByCorreo($usuario);

	$intentos = loginDAO::checkIntentos();

	if($intentos < 3){
		if(!is_null($user)){
			$retail = retailDAO::getRetailById($user->getIdUsuario());
			$salt = $retail->getSalt();
			$password = sha1(htmlspecialchars(trim(strip_tags($_REQUEST["pass"]))).$salt);
			if($user->getPass() == $password){
				echo json_encode(array('login'=> true, 'intentos'=>0));
				$_SESSION["nombre"] = $user->getNombre();
				$_SESSION["apellidos"] = $user->getApellidos();
				$_SESSION["correo"] = $user->getCorreo();
				$_SESSION["rol"] = $user->getRol();
				$_SESSION["id"] = $user->getIdUsuario();
				loginDAO::borraIntentos();
			}
			else{
				echo json_encode(array('login'=> false, 'intentos'=>$intentos+1));
				loginDAO::logIntento();
			}
		}
		else{
			echo json_encode(array('login'=> false, 'intentos'=>$intentos+1));
			loginDAO::logIntento();
		}
	} else echo json_encode(array('login'=> false, 'intentos'=>$intentos));
?>