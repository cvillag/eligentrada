<?php

/*
*	Gestión de la tabla retail (almacenamiento de la sal)
*
*	public static function getRetailById($id):
*		--Devuelve el objeto retail cuyo identificador sea $id
*
*	public static function insertRetail($retail):
*		--Inserta en la base de datos el objeto $retail
*		--Devuelve 1 en caso de éxito
*
*	public static function updateRetail($retail):
*		--Actualiza la base de datos con la información del objeto $retail
*
*/
include_once 'class/retail.php';
include_once 'class/conexion.php';

class RetailDAO{
	public static function getRetailById($id){
		$mysqli = Conexion::init_conn();
		if(!$sentencia = $mysqli->prepare("select idUsuario, rand from retail where idUsuario = ?")){
			echo "<p>error prepare: " . $mysqli->error ."</p>"; 
		}
		$sentencia->bind_param("i",$id);
		if(!$sentencia->execute()){
			echo "<p>error execute: " . $mysqli->error . "</p>";
		}
		$sentencia->bind_result($id,$num);
		if(!is_null($sentencia->fetch())){
			$retail = new Retail($id,$num);
		} else $retail = NULL;
		$sentencia->close();
		$mysqli->close();
		return $retail;
	}
	
	public static function insertRetail($retail){
		$mysqli = Conexion::init_conn();
		
		if(!$sentencia = $mysqli->prepare("insert into retail(idUsuario, rand) values(?,?)")){
			echo "<p>error prepare: " . $mysqli->error ."</p>";
		}
		$sentencia->bind_param("is",$retail->getId(),$retail->getSalt());
		if(!$sentencia->execute()){
			echo "<p>error prepare: " . $mysqli->error ."</p>";
		}
		
		$sentencia->close();
		$num = $mysqli->affected_rows;
		$mysqli->close();
		return $num;
	}
	
	public static function updateRetail($retail){
		$mysqli = Conexion::init_conn();
		if(!$sentencia = $mysqli->prepare("UPDATE retail SET rand=? WHERE idUsuario =?")){
			echo "<p>error prepare: " . $mysqli->error ."</p>";
		}
		$sentencia->bind_param("si",$retail->getSalt(),$retail-getId());
		if(!$sentencia->execute()){
			echo "<p>error prepare: " . $mysqli->error ."</p>";
		}
		
		$sentencia->close();
		$num = $mysqli->affected_rows;
		$mysqli->close();
		return $num;
	}

}

?>