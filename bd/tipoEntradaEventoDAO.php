<?php

/*
*	Gestión de la tabla tipoEntradaEvento
*
*	public static function getTipoEntradaEvento():
*		--Devuelve un array con todos los objetos TipoEntradaEvento
*
*	public static function getTiposEntradaEventoByIdEvento($id):
*		--Devuelve un array con todos los tipos de entrada asociados al evento de identificador $id
*
*	public static function getEntradaEventoByIdEvento($idEvento, $idEntrada):
*		--Devuelve el tipo de entrada con $idEntrada asociado al evento $idEvento
*
*	public static function insertTipoEntradaEvento($tee):
*		--Crea una entrada en la base de datos con el objeto tipoEntradaEvento $tee
*		--Devuelve 1 en caso de éxito
*
*	public static function removeTipoEntradaEventoById($idTipo, $idEvento):
*		--Elimina el tipo de entrada $idTipo asoociado al evento $idEvento
*		--Devuelve 1 en caso de éxito
*
*	public static function updateTipoEntradaEvento($tee):
*		--Actualiza la base de datos con la información del tipoEntradaEvento $tee
*		--Devuelve 1 en caso de éxito
*
*/

include_once 'class/tipoEntradaEvento.php';
include_once 'class/conexion.php';

class TipoEntradaEventoDAO{
	
	private static function recogerArrayTipoEntradaEvento($result){
		$tent = array();
		foreach ($result as $row){
			$e = new TipoEntradaEvento($row["idTipo"],$row["idEvento"],$row["nombreParticular"],$row["precio"],$row["cantidad"]);
			$tent[] = $e;
		}
		return $tent;
	}
	
	public static function getTipoEntradaEvento(){
		$mysqli = Conexion::init_conn();
		if(!$sentencia = $mysqli->prepare("select idTipo, idEvento,  nombreParticular, precio, cantidad
				from tipoEntradaEvento")){
						echo "<p>error prepare: " . $mysqli->error ."</p>";
		}
		if(!$sentencia->execute()){
			echo "<p>error bind: " . $mysqli->error ."</p>";
		}
		
		$entrada = TipoEntradaEventoDAO::recogerArrayTipoEntradaEvento($sentencia->get_result());
		
		$sentencia->close();
		$mysqli->close();
		return $entrada;
	}
	
	public static function getTiposEntradaEventoByIdEvento($id){
		$mysqli = Conexion::init_conn();
		if(!$sentencia = $mysqli->prepare("select idTipo, idEvento,  nombreParticular, precio, cantidad
				from tipoEntradaEvento where idEvento = ?")){
						echo "<p>error prepare: " . $mysqli->error ."</p>";
		}
		$sentencia->bind_param("i",$id);
		if(!$sentencia->execute()){
			echo "<p>error bind: " . $mysqli->error ."</p>";
		}
		
		$entrada = TipoEntradaEventoDAO::recogerArrayTipoEntradaEvento($sentencia->get_result());
		
		$sentencia->close();
		$mysqli->close();
		return $entrada;
	}
	
	public static function getEntradaEventoByIdEvento($idEvento, $idEntrada){
		$mysqli = Conexion::init_conn();
		if(!$sentencia = $mysqli->prepare("SELECT idTipo, idEvento, nombreParticular, precio, cantidad
				FROM tipoEntradaEvento WHERE idEvento = ? AND idTipo = ?")){
						echo "<p>error prepare: " . $mysqli->error ."</p>";
		}
		$sentencia->bind_param("ii",$idEvento, $idEntrada);
		if(!$sentencia->execute()){
			echo "<p>error bind: " . $mysqli->error ."</p>";
		}
		$sentencia->bind_result($idTipo, $idEvento, $nombreParticular, $precio, $cantidad);

		if(!is_null($sentencia->fetch())){
			$entrada = new TipoEntradaEvento($idTipo, $idEvento, $nombreParticular, $precio, $cantidad);
		} else $entrada = NULL;

		$sentencia->close();
		$mysqli->close();
		return $entrada;
	}

	public static function insertTipoEntradaEvento($tee){
		$mysqli = Conexion::init_conn();
		if(!$sentencia = $mysqli->prepare("insert into tipoEntradaEvento (idTipo, idEvento,  nombreParticular, precio, cantidad)
				values(?, ?, ?, ?, ?)")){
						echo "<p>error prepare: " . $mysqli->error ."</p>";
		}
		$sentencia->bind_param("iisdi",$tee->getIdTipo(),$tee->getIdEvento(),$tee->getNombreParticular(),$tee->getPrecio(),$tee->getCantidad());
		if(!$sentencia->execute()){
			echo "<p>error bind: " . $mysqli->error ."</p>";
		}
		
		$num = $mysqli->affected_rows;		
		$sentencia->close();
		$mysqli->close();
		return $num;
	}

	public static function removeTipoEntradaEventoById($idTipo, $idEvento){
		$mysqli = Conexion::init_conn();
		if(!$sentencia = $mysqli->prepare("DELETE FROM tipoEntradaEvento WHERE idTipo = ? AND idEvento = ?")){
						echo "<p>error prepare: " . $mysqli->error ."</p>";
		}
		$sentencia->bind_param("ii",$idTipo, $idEvento);
		if(!$sentencia->execute()){
			echo "<p>error bind: " . $mysqli->error ."</p>";
		}
		
		$num = $mysqli->affected_rows;		
		$sentencia->close();
		$mysqli->close();
		return $num;
	}

	public static function updateTipoEntradaEvento($tee){
		$mysqli = Conexion::init_conn();
		if(!$sentencia = $mysqli->prepare("UPDATE tipoEntradaEvento SET nombreParticular = ?, precio = ?, cantidad = ? WHERE idTipo = ? AND idEvento = ? ")){
			echo "<p>error prepare: " . $mysqli->error ."</p>";
			$sentencia->close();
			$mysqli->close();
			return 0;
		}
		$sentencia->bind_param("sdiii",$tee->getNombreParticular(),$tee->getPrecio(),$tee->getCantidad(),$tee->getIdTipo(),$tee->getIdEvento());
		if(!$sentencia->execute()){
			echo "<p>error bind: " . $mysqli->error ."</p>";
			$sentencia->close();
			$mysqli->close();
			return 0;
		}
		
		$num = $mysqli->affected_rows;		
		$sentencia->close();
		$mysqli->close();
		return $num;
	}
}