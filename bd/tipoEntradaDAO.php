<?php

/*
*	Gestión de la tabla tipoEntrada
*
*	public static function getTiposEntrada():
*		--devuelve un array de objetos TipoEntrada con todos los elementos de la tabla.
*
*	public static function insertTipoEntrada($tentrada):
*		--Crea en la base de datos una fila para el tipo de entrada $tentrada 
*
*	public static function editarTipoEntrada($entrada):
*		--Modifica los datos del tipo entrada  correspondiente a $entrada con los de $entrada
*
*/

include_once 'class/tipoEntrada.php';
include_once 'class/conexion.php';

class TipoEntradaDAO{
	
	private static function recogerArrayTipoEntrada($result){
		$tent = array();
		foreach ($result as $row){
			$e = new TipoEntrada($row["idTipo"],$row["nombre"]);
			$tent[] = $e;
		}
		return $tent;
	}
	
	public static function getTiposEntrada(){
		$mysqli = Conexion::init_conn();
		if(!$sentencia = $mysqli->prepare("select idTipo, nombre
				from tipoEntrada")){
					echo "<p>error prepare: " . $mysqli->error ."</p>";
		}
		if(!$sentencia->execute()){
			echo "<p>error bind: " . $mysqli->error ."</p>";
		}
	
		$entrada = TipoEntradaDAO::recogerArrayTipoEntrada($sentencia->get_result());
	
		$sentencia->close();
		$mysqli->close();
		return $entrada;
	}

	public static function insertTipoEntrada($tentrada){
		$mysqli = Conexion::init_conn();
		
		if(!$sentencia = $mysqli->prepare("insert into tipoEntrada(Nombre)
				values(?)")){
			echo "<p>error prepare: " . $mysqli->error ."</p>";
		}
		$sentencia->bind_param("s",$tentrada->getNombre());
		if(!$sentencia->execute()){
			echo "<p>error execute: " . $mysqli->error ."</p>";
		}
		$num = $mysqli->affected_rows;
		$sentencia->close();
		$mysqli->close();
		return $num;
	}

	public static function editarTipoEntrada($entrada){
		$mysqli = Conexion::init_conn();
		
		if(!$sentencia = $mysqli->prepare("update tipoEntrada set Nombre=?
			where idTipo=?")){
			echo "<p>error prepare: " . $mysqli->error ."</p>";
		}
		$sentencia->bind_param("ss",$entrada->getNombre(),$entrada->getIdTipo());
		if(!$sentencia->execute()){
			echo "<p>error execute: " . $mysqli->error ."</p>";
		}
		$num = $mysqli->affected_rows;
		$sentencia->close();
		$mysqli->close();
		return $num;
	}

		public static function getTipoEntradaById($id){
		$mysqli = Conexion::init_conn();
		if(!$sentencia = $mysqli->prepare("SELECT idTipo, nombre FROM tipoEntrada WHERE idTipo = ?")){
					echo "<p>error prepare: " . $mysqli->error ."</p>";
		}
		$sentencia->bind_param("i",$id);
		if(!$sentencia->execute()){
			echo "<p>error bind: " . $mysqli->error ."</p>";
		}
		$sentencia->bind_result($idTipo, $nombre);

		if(!is_null($sentencia->fetch())){
			$entrada = new tipoEntrada($idTipo, $nombre);
		} else $entrada = NULL;
		
		$sentencia->close();
		$mysqli->close();
		return $entrada;
	}
}