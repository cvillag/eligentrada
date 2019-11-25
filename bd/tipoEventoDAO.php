<?php

/*
*	Gestión de la tabla tipoEvento
*
*	public static function getTiposEvento():
*		--Devuelve un array de objetos TipoEvento.
*
*	public static function getTipoEventoStr($idTipoEvento)
*		--Devuelve el nombre del tipo de evento con identifiacor $idTipoEvento
*
*	public static function insertTipoEvento($tevento)
*		--Recoge un objeto tipoEvento para almacenarlo en la base de datos
*		--Devuelve 1 en caso de éxito
*
*	public static function editarTipoEvento($tevento)
*		--Recoge un objeto TipoEvento para actualizar la información de la base de datos
*		--Devuelve 1 en caso de éxito
*
*/

include_once 'class/tipoEvento.php';
include_once 'class/conexion.php';

class TipoEventoDAO{
	
	private static function recogerArrayTipoEventos($result){
		$tevento = array();
		foreach ($result as $row){
			$ev = new TipoEvento($row["idTipo"],$row["nombreTipo"]);
			$tevento[] = $ev;
		}
		return $tevento;
	}
	
	public static function getTiposEvento(){
		$mysqli = Conexion::init_conn();
		if(!$sentencia = $mysqli->prepare("select idTipo, nombreTipo
				from tipoEvento")){
						echo "<p>error prepare: " . $mysqli->error ."</p>";
		}
		if(!$sentencia->execute()){
			echo "<p>error bind: " . $mysqli->error ."</p>";
		}
				
		$teventos = TipoEventoDAO::recogerArrayTipoEventos($sentencia->get_result());
		
		$sentencia->close();
		$mysqli->close();
		return $teventos;
	}

	public static function getTipoEventoStr($idTipoEvento){
		$mysqli = Conexion::init_conn();
		if(!$sentencia = $mysqli->prepare("SELECT nombreTipo FROM tipoEvento WHERE idTipo = ?")){
			echo "<p>error prepare: " . $mysqli->error ."</p>";
			return 0;
		}
		$sentencia->bind_param("i",$idTipoEvento);
		if(!$sentencia->execute()){
			echo "<p>error bind: " . $mysqli->error ."</p>";
			return 0;
		}
		$sentencia->bind_result($teventoStr);
		$sentencia->fetch();
		
		$sentencia->close();
		$mysqli->close();
		return $teventoStr;
	}

	public static function insertTipoEvento($tevento){
		$mysqli = Conexion::init_conn();
		
		if(!$sentencia = $mysqli->prepare("insert into tipoEvento(nombreTipo)
				values(?)")){
			echo "<p>error prepare: " . $mysqli->error ."</p>";
		}
		$sentencia->bind_param("s",$tevento->getNombreTipo());
		if(!$sentencia->execute()){
			echo "<p>error execute: " . $mysqli->error ."</p>";
		}
		$num = $mysqli->affected_rows;
		$sentencia->close();
		$mysqli->close();
		return $num;
	}

	public static function editarTipoEvento($tevento){
		$mysqli = Conexion::init_conn();
		
		if(!$sentencia = $mysqli->prepare("update tipoEvento set nombreTipo=?
			where idTipo=?")){
			echo "<p>error prepare: " . $mysqli->error ."</p>";
		}
		$sentencia->bind_param("ss",$tevento->getNombreTipo(),$tevento->getIdTipo());
		if(!$sentencia->execute()){
			echo "<p>error execute: " . $mysqli->error ."</p>";
		}
		$num = $mysqli->affected_rows;
		$sentencia->close();
		$mysqli->close();
		return $num;
	}
}
?>