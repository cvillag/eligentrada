<?php

/*
*	Gestión de la tabla de intentosLogin
*
*	public static function logIntento():
*		--Inserta en la base de datos la ip y la fecha del intento de login
*
*	public static function checkIntentos():
*		--Devuelve el número de intentos de inicio de sesión desde la misma ip dónde la marca de tiempo sea superior a la actual menos 5 minutos
*
*	public static function borraIntentos():
*		--Elimina de la base de datos todos los intentos asociados a la ip actual
*
*/
include_once 'class/conexion.php';

class loginDAO{
	
	public static function logIntento(){
		$mysql = Conexion::init_conn();
		$sentencia = $mysql->prepare("INSERT INTO intentosLogin(ip, cuando) VALUES ( ? , CURRENT_TIMESTAMP)");
		$sentencia->bind_param("s",$_SERVER['REMOTE_ADDR']);
		$sentencia->execute();
		$sentencia->close();
		$mysql->close();
	}

	public static function checkIntentos(){
		$mysql = Conexion::init_conn();
		$sentencia = $mysql->prepare("SELECT count(*) FROM intentosLogin WHERE ( cuando > now() - INTERVAL 5 MINUTE) AND ip = ? ");
		$sentencia->bind_param("s",$_SERVER['REMOTE_ADDR']);
		$sentencia->execute();
		$sentencia->bind_result($cuenta);
		$sentencia->fetch();
		$sentencia->close();
		$mysql->close();
		return $cuenta;
	}

	public static function borraIntentos(){
		$mysql = Conexion::init_conn();
		$sentencia = $mysql->prepare("DELETE FROM intentosLogin WHERE ip = ?");
		$sentencia->bind_param("s",$_SERVER['REMOTE_ADDR']);
		$sentencia->execute();
		$sentencia->close();
		$mysql->close();
	}	
}
?>