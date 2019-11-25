<?php

/*  
*	Gestión de la tabla compra
*
*  public function insertCompra($compra)
*  	--Recoge  un objeto compra y crea una fila en la base de datos con el objeto
*  	--Devuelve 1 si  inserta con éxito
*  
*  public function getCompraByIdV($idV)
*  	--Devuelve un objeto compra según su identificador de venta, o  nulo si no existe
*  
*  public function getComprasByIdUser($idU)
* 		--Devuelve un array con las compras del usuario con identificador $idV
* 
* 	public function getComprasByEvento($idE)
* 		--Devuelve  un array de compras asociadas al evento con identificador $idE
* 
* 	public function getEntradasDisponibles($idE,$idT)
* 		--Devuelve  el  número  de entradas de un tipo de entrada de un evento,  indicados ambos por  su identificador
*		--($idT e $idE respectivamente)
* 		--Devuelve null si no existe el evento, o  el tipo de entrada en ese evento
*
*/

include_once 'class/compra.php';
include_once 'class/conexion.php';

class CompraDAO{

	private static function recogerArrayCompra($result){
		$tent = array();
		foreach ($result as $row){
			$e = new Compra($row["idTipo"],$row["idEvento"],$row["idEvento"],$row["idVenta"],$row["cantidad"]);
			$tent[] = $e;
		}
		return $tent;
	}
	
	public static function insertCompra($compra){
		$mysqli = Conexion::init_conn();
		if(!$sentencia = $mysqli->prepare("insert into compra (idTipo, idEvento, idUsuario, idVenta, cantidad)
				values(?, ?, ?, ?, ?)")){
						echo "<p>error prepare: " . $mysqli->error ."</p>";
		}
		$sentencia->bind_param("iiiii",$compra->getIdTipo(),$compra->getIdEvento(),$compra->getIdUsuario(),$compra->getIdVenta(),$compra->getCantidad());
		if(!$sentencia->execute()){
			echo "<p>error bind: " . $mysqli->error ."</p>";
		}
		
		$num = $mysqli->affected_rows;
		$sentencia->close();
		$mysqli->close();
		return $num;
	}
	
	public static function getCompraByIdV($idV){
		$mysqli = Conexion::init_conn();
		
		if(!$sentencia = $mysqli->prepare("select idTipo, idEvento, idUsuario, idVenta, cantidad
				from compra where idVenta = ?")){
						echo "<p>error prepare: " . $mysqli->error ."</p>";
		}
		$sentencia->bind_param("i",$idV);
		if(!$sentencia->execute()){
			echo "<p>error execute: " . $mysqli->error ."</p>";
		}
		$sentencia->bind_result($idTipo,$idEvento,$idUsuario,$idVenta,$cantidad);
		if(!is_null($sentencia->fetch())){
			$compra = new Compra($idTipo,$idEvento,$idUsuario,$idVenta,$cantidad);
		} else $commpra = NULL;
		
		$sentencia->close();
		$mysqli->close();
		return $compra;
	}
	
	public static function getComprasByIdUser($idU){
		$mysqli = Conexion::init_conn();
		if(!$sentencia = $mysqli->prepare("SELECT idTipo, idEvento, idUsuario, idVenta, cantidad 
				from compra where idUsuario = ?")){
						echo "<p>error prepare: " . $mysqli->error ."</p>";
		}
		$sentencia->bind_param("i",$idU);
		if(!$sentencia->execute()){
			echo "<p>error bind: " . $mysqli->error ."</p>";
		}
		
		$compras = CompraDAO::recogerArrayCompra($sentencia->get_result());
		
		$sentencia->close();
		$mysqli->close();
		return $compras;
	}
	
	public static function getComprasByEvento($idE){
		$mysqli = Conexion::init_conn();
		if(!$sentencia = $mysqli->prepare("SELECT idTipo, idEvento, idUsuario, idVenta, cantidad
				from compra where idEvento = ?")){
						echo "<p>error prepare: " . $mysqli->error ."</p>";
		}
		$sentencia->bind_param("i",$idE);
		if(!$sentencia->execute()){
			echo "<p>error bind: " . $mysqli->error ."</p>";
		}
		
		$compras = CompraDAO::recogerArrayCompra($sentencia->get_result());
		
		$sentencia->close();
		$mysqli->close();
		return $compras;
	}
	
	public static function getEntradasDisponibles($idE,$idT){
	
		$mysqli = Conexion::init_conn();
		if(!$sentencia = $mysqli->prepare("select s1.cantidad, s2.vendidas
				from (select cantidad from tipoEntradaEvento where idTipo =? and idEvento = ?) as s1,
				(select sum(cantidad) as vendidas from  compra  where  idTipo  = ? and idEvento = ?) as s2")){
					echo "<p>error prepare: " . $mysqli->error ."</p>";
		}
		$sentencia->bind_param("iiii",$idT,$idE,$idT,$idE);
		if(!$sentencia->execute()){
			echo "<p>error bind: " . $mysqli->error ."</p>";
		}
		$sentencia->bind_result($cantidad,$vendidas);
		if(!is_null($sentencia->fetch())){
			if($vendidas == null)
				$restantes = $cantidad;
			elseif ($cantidad == null)
				$restantes = null;
			else 
				$restantes = $cantidad - $vendidas;
		}else $restantes = null;
		
		$sentencia->close();
		$mysqli->close();
		return $restantes;
	}

	public static function getEntradasVendidas($idE,$idT){
		$mysqli = Conexion::init_conn();
		if(!$sentencia = $mysqli->prepare("select s1.cantidad, s2.vendidas
				from (select cantidad from tipoEntradaEvento where idTipo =? and idEvento = ?) as s1,
				(select sum(cantidad) as vendidas from  compra  where  idTipo  = ? and idEvento = ?) as s2")){
					echo "<p>error prepare: " . $mysqli->error ."</p>";
		}
		$sentencia->bind_param("iiii",$idT,$idE,$idT,$idE);
		if(!$sentencia->execute()){
			echo "<p>error bind: " . $mysqli->error ."</p>";
		}
		$sentencia->bind_result($cantidad,$vendidas);
		if(!is_null($sentencia->fetch())){
			if($vendidas == null) $vendidas = 0;
		}else $vendidas = null;
		
		$sentencia->close();
		$mysqli->close();
		return $vendidas;
	}
}
?>