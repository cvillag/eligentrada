<?php
class Conexion{
	static $ip ="local";
	static $local  = "127.0.0.1";
	static $user = "sw";
	static $passBD = "swmola";
	static $dbName = "sw";
	
	public static function init_conn(){
		$mysql = new mysqli(Conexion::$ip,Conexion::$user,Conexion::$passBD,Conexion::$dbName);
		if($mysql->connect_errno){
			echo "fallo de conexi�n. (". $mysql->connect_errno . "): " . $mysql->connect_error;
		}
		$mysql->set_charset("utf8");
		return $mysql;
	}
}
