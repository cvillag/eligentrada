<?php

/*
*	Gestión de la tabla evento
*
*	public static function getEventoById($id):
*		--Devuelve un objeto tipo Evento cuyo identificador coincida con $id
*
*	public static function getEventoByName($name):
*		--Devuelve un objeto Evento cuyo nombre corresponde a $name
*
*	public static function getEventosPrioritarios($num):
*		--Devuelve un array de los $num elementos más prioritarios (corresponde a los de prioridad de menor valor)
*
*	public static function getEventosPrioritariosPorTipo($num,$tipo):
*		--Devuelve un array de los $num elementos más prioritarios del tipo $tipo(corresponde a los de prioridad de menor valor)
*
*	public static function getEventosByTipo($tipo):
*		--Devuelve un array con todos los eventos de tipo $tipo
*
*	public static function insertEvento($evento):
*		--Inserta en la base de datos el objeto Evento $evento
*		--Devuelve 1 en caso de éxito
*
*	public static function editEvento($evento):
*		--Actualiza la base de datos con la información de $evento
*		--Devuelve 1 en caso de éxito
*
*	public static function getEventosByPromotor($idPromo):
*		--Devuelve un array con todos los eventos del promotor con identificador $idPromo
*
*	public static function searchByName($query):
*		--Devuelve un array con todos los eventos cuyo nombre sea similar a $query
*
*	public static function searchByLocation($query):
*		--Devuelve un array con todos los eventos cuya localización sea similar a $query
*
*	public static function searchByType($query):
*		--Devuelve un array con todos los eventos de tipo $query
*
*/

include_once  'class/evento.php';
include_once 'class/conexion.php';

class EventoDAO{
	
	private static function recogerArrayEventos($result){
		$eventos = array();
		foreach ($result as $row){
			$ev = new Evento($row["idEvento"],$row["nombreEvento"],$row["lugar"],$row["fecha"],
					$row["hora"],$row["descripcion"],$row["tipo"],$row["prioridad"],
					$row["fechaCreacion"],$row["idPromotor"],$row["rutaImagen"],$row["ubicacionLatLong"]);
			$eventos[] = $ev;
		}
		return $eventos;
	}
	
	public static function getEventoById($id){
		$mysqli = Conexion::init_conn();
		
		if(!$sentencia = $mysqli->prepare("select idEvento, nombreEvento, lugar, fecha,
				hora, descripcion, tipo, prioridad, fechaCreacion, idPromotor, rutaImagen, ubicacionLatLong
				from evento where idEvento = ?")){
			echo "<p>error prepare: " . $mysqli->error ."</p>";
		}
		$sentencia->bind_param("i",$id);
		if(!$sentencia->execute()){
			echo "<p>error execute: " . $mysqli->error ."</p>";
		}
		$sentencia->bind_result($idEvento,$nombreEvento,$lugar,$fecha,$hora,$descripcion,
								$tipo,$prioridad,$fechaCreacion,$idPromotor,$rutaImagen,$ubicacionLatLong);
		if(!is_null($sentencia->fetch())){
			$evento = new Evento($idEvento,$nombreEvento,$lugar,$fecha,$hora,$descripcion,
								$tipo,$prioridad,$fechaCreacion,$idPromotor,$rutaImagen,$ubicacionLatLong);
		} else $evento = NULL;
		
		$sentencia->close();
		$mysqli->close();
		return $evento;
	}

	public static function getEventoByName($name){
		$mysqli = Conexion::init_conn();
		
		if(!$sentencia = $mysqli->prepare("select idEvento, nombreEvento, lugar, fecha,
				hora, descripcion, tipo, prioridad, fechaCreacion, idPromotor, rutaImagen, ubicacionLatLong
				from evento where nombreEvento = ?")){
			echo "<p>error prepare: " . $mysqli->error ."</p>";
		}
		$sentencia->bind_param("s",$name);
		if(!$sentencia->execute()){
			echo "<p>error execute: " . $mysqli->error ."</p>";
		}
		$sentencia->bind_result($idEvento,$nombreEvento,$lugar,$fecha,$hora,$descripcion,
								$tipo,$prioridad,$fechaCreacion,$idPromotor,$rutaImagen,$ubicacionLatLong);
		if(!is_null($sentencia->fetch())){
			$evento = new Evento($idEvento,$nombreEvento,$lugar,$fecha,$hora,$descripcion,
								$tipo,$prioridad,$fechaCreacion,$idPromotor,$rutaImagen,$ubicacionLatLong);
		} else $evento = NULL;
		
		$sentencia->close();
		$mysqli->close();
		return $evento;
	}
	
	public static function getEventosPrioritarios($num){
		$mysqli = Conexion::init_conn();
		
		if(!$sentencia = $mysqli->prepare("select idEvento, nombreEvento, lugar, fecha,
				hora, descripcion, tipo, prioridad, fechaCreacion, idPromotor, rutaImagen, ubicacionLatLong
				from evento where prioridad = (select min(prioridad) from evento)
				order by fechaCreacion desc
				limit ?")){
						echo "<p>error prepare: " . $mysqli->error ."</p>";
		}
		$sentencia->bind_param("i",$num);
		if(!$sentencia->execute()){
			echo "<p>error bind: " . $mysqli->error ."</p>";
		}

		$eventos = EventoDAO::recogerArrayEventos($sentencia->get_result());
		
		$sentencia->close();
		$mysqli->close();
		return $eventos;
	}
	
	public static function getEventosPrioritariosPorTipo($num,$tipo){
		$mysqli = Conexion::init_conn();
	
		if(!$sentencia = $mysqli->prepare("select idEvento, nombreEvento, lugar, fecha,
				hora, descripcion, tipo, prioridad, fechaCreacion, idPromotor, rutaImagen, ubicacionLatLong
				from evento where prioridad = (select min(prioridad) from evento)
				and tipo = ?
				order by fechaCreacion desc
				limit ?")){
					echo "<p>error prepare: " . $mysqli->error ."</p>";
		}
		$sentencia->bind_param("ii",$tipo,$num);
		if(!$sentencia->execute()){
			echo "<p>error bind: " . $mysqli->error ."</p>";
		}
		if(!$sentencia->execute()){
			echo "<p>error execute: " . $mysqli->error ."</p>";
		}
	
		$eventos = EventoDAO::recogerArrayEventos($sentencia->get_result());
	
		$sentencia->close();
		$mysqli->close();
		return $eventos;
	}

	public static function getEventosByTipo($tipo){
		$mysqli = Conexion::init_conn();
	
		if(!$sentencia = $mysqli->prepare("select idEvento, nombreEvento, lugar, fecha,
				hora, descripcion, tipo, prioridad, fechaCreacion, idPromotor, rutaImagen, ubicacionLatLong
				from evento where tipo = ?
				order by fecha asc")){
					echo "<p>error prepare: " . $mysqli->error ."</p>";
		}
		$sentencia->bind_param("i",$tipo);
		if(!$sentencia->execute()){
			echo "<p>error bind: " . $mysqli->error ."</p>";
		}
		if(!$sentencia->execute()){
			echo "<p>error execute: " . $mysqli->error ."</p>";
		}
	
		$eventos = EventoDAO::recogerArrayEventos($sentencia->get_result());
	
		$sentencia->close();
		$mysqli->close();
		return $eventos;
	}
	
	public static function insertEvento($evento){
		$mysqli = Conexion::init_conn();
		
		if(!$sentencia = $mysqli->prepare("insert into evento(nombreEvento, lugar, fecha,
				hora, descripcion, tipo, prioridad, idPromotor, rutaImagen, ubicacionLatLong)
				values(?,?,?,?,?,?,?,?,?,?)")){
			echo "<p>error prepare: " . $mysqli->error ."</p>";
		}
		$sentencia->bind_param("sssssiiiss",$evento->getNombreEvento(),
				$evento->getLugar(),$evento->getFecha(),$evento->getHora(),$evento->getDescripcion(),
				$evento->getTipo(),$evento->getPrioridad(),
				$evento->getIdPromotor(),$evento->getRutaImagen(),$evento->getUbicacionLatLong());
		if(!$sentencia->execute()){
			echo "<p>error execute: " . $mysqli->error ."</p>";
		}
		$num = $mysqli->affected_rows;
		$sentencia->close();
		$mysqli->close();
		return $num;
	}

	public static function editEvento($evento){
		$mysqli = Conexion::init_conn();
		
		if(!$sentencia = $mysqli->prepare("update evento set nombreEvento=?, lugar=?, ubicacionLatLong=?,
				fecha=?, hora=?, descripcion=?, tipo=?, prioridad=?, fechaCreacion=?, idPromotor=?, rutaImagen=?
				where idEvento=?")){
			echo "<p>error prepare: " . $mysqli->error ."</p>";
		}
		$sentencia->bind_param("ssssssiisisi",$evento->getNombreEvento(),
				$evento->getLugar(),$evento->getUbicacionLatLong(),$evento->getFecha(),$evento->getHora(),$evento->getDescripcion(),
				$evento->getTipo(),$evento->getPrioridad(), $evento->getFechaCreacion(), 
				$evento->getIdPromotor(),$evento->getRutaImagen(),$evento->getIdEvento());
		if(!$sentencia->execute()){
			echo "<p>error execute: " . $mysqli->error ."</p>";
		}
		$num = $mysqli->affected_rows;
		$sentencia->close();
		$mysqli->close();
		return $num;
	}
	
	public static function getEventosByPromotor($idPromo){
		$mysqli = Conexion::init_conn();
		
		if(!$sentencia = $mysqli->prepare("select idEvento, nombreEvento, lugar, fecha,
				hora, descripcion, tipo, prioridad, fechaCreacion, idPromotor, rutaImagen, ubicacionLatLong
				from evento where idPromotor = ?")){
						echo "<p>error prepare: " . $mysqli->error ."</p>";
		}
		$sentencia->bind_param("i",$idPromo);
		if(!$sentencia->execute()){
			echo "<p>error execute: " . $mysqli->error ."</p>";
		}
		$eventos = EventoDAO::recogerArrayEventos($sentencia->get_result());
		
		$sentencia->close();
		$mysqli->close();
		return $eventos;
	}

	public static function searchByName($query){
		$mysqli = Conexion::init_conn();
		$param = '%'.$query.'%';

		if(!$sentencia = $mysqli->prepare("SELECT idEvento, nombreEvento, lugar, fecha,
				hora, descripcion, tipo, prioridad, fechaCreacion, idPromotor, rutaImagen, ubicacionLatLong
				FROM evento WHERE nombreEvento LIKE ? ")){
			echo "<p>error prepare: " . $mysqli->error ."</p>";
		}
		$sentencia->bind_param("s",$param);
		if(!$sentencia->execute()){
			echo "<p>error execute: " . $mysqli->error ."</p>";
		}
		$eventos = EventoDAO::recogerArrayEventos($sentencia->get_result());
		
		$sentencia->close();
		$mysqli->close();
		return $eventos;
	}

	public static function searchByLocation($query){
		$mysqli = Conexion::init_conn();
		$param = '%'.$query.'%';

		if(!$sentencia = $mysqli->prepare("SELECT idEvento, nombreEvento, lugar, fecha,
				hora, descripcion, tipo, prioridad, fechaCreacion, idPromotor, rutaImagen, ubicacionLatLong
				FROM evento WHERE lugar LIKE ? ")){
			echo "<p>error prepare: " . $mysqli->error ."</p>";
		}
		$sentencia->bind_param("s",$param);
		if(!$sentencia->execute()){
			echo "<p>error execute: " . $mysqli->error ."</p>";
		}
		$eventos = EventoDAO::recogerArrayEventos($sentencia->get_result());
		
		$sentencia->close();
		$mysqli->close();
		return $eventos;
	}

	public static function searchByType($query){
		$mysqli = Conexion::init_conn();

		if(!$sentencia = $mysqli->prepare("SELECT idEvento, nombreEvento, lugar, fecha,
				hora, descripcion, tipo, prioridad, fechaCreacion, idPromotor, rutaImagen, ubicacionLatLong
				FROM evento WHERE tipo = ? ")){
			echo "<p>error prepare: " . $mysqli->error ."</p>";
		}
		$sentencia->bind_param("i",$query);
		if(!$sentencia->execute()){
			echo "<p>error execute: " . $mysqli->error ."</p>";
		}
		$eventos = EventoDAO::recogerArrayEventos($sentencia->get_result());
		
		$sentencia->close();
		$mysqli->close();
		return $eventos;
	}
}
?>