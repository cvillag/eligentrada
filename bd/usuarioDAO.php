<?php

/*
*	Gestión de la tabla usuario
*
*	public function getUserList():
* 		--Devuelve un array de objetos Usuario, vacío o no.
*
*	public function getUserById($id):
* 		--Devuelve un objeto Usuario, con identificador $id, o nulo.
*
*	public function getUserByName($nom):
* 		--Devuelve un objeto Usuario, con nombre $nom, o nulo.
*
*	public function getUserByCorreo($c):
* 		--Devuelve un objeto Usuario, con dirección de correo $c, o nulo.
*
*	public function insertUser($user):
* 		--Devuelve 1 si inserta un nuevo Usuario a partir de un objeto Usuario o 0 en caso contrario.
*
*	public static function updateUser($user)
*		--Actualiza la información de la base de datos con el objeto $user
*
*	public static function getUsersByRol($rol,$off,$pag)
*		--Devuelve un array de usuarios con permisos $rol limitado a $off
*
*	public static function getNumUsersByRol($rol)
*		--Devuelve el número de usuarios con el rol $rol
*
*	public  static function findUsers($nom,$ape,$dni,$cif,$tel,$cor,$tipo,$off,$pag)
*		--Devuelve un array con todos los usuarios cuyos datos coincidan con todos los campos que hayan sido especificados
*
*	public  static function tamBusqueda($nom,$ape,$dni,$cif,$tel,$cor,$tipo,$off,$pag)
*		--Devuelve el número de usuarios que resultan de realizar la búsqueda
*
 */

include_once  'class/usuario.php';
include_once 'class/conexion.php';

class UsuarioDAO{
	
	private static function recogerArrayUsuarios($result){
		$usuarios = array();
		foreach ($result as $row){
			$us = new Usuario($row["idUsuario"],$row["nombre"],$row["apellidos"],$row["correo"],
					$row["pass"],$row["DNI"],$row["CIF"],$row["direccion"],
					$row["telefono"],$row["rol"]);
			$usuarios[] = $us;
		}
		return $usuarios;
	}
	
	public static function getUserList(){
		$mysqli = Conexion::init_conn();
		
		if(!$sentencia = $mysqli->prepare("select idUsuario, nombre, apellidos, correo, pass,
					DNI, CIF, direccion, telefono, rol from usuario")){
						echo "<p>error prepare: " . $mysqli->error ."</p>";
		}
		if(!$sentencia->execute()){
			echo "<p>error bind: " . $mysqli->error ."</p>";
		}
		
		$usuarios = UsuarioDAO::recogerArrayUsuarios($sentencia->get_result());
		
		$sentencia->close();
		$mysqli->close();
		return $usuarios;
	}
	
	public static function getUserById($id){
		$mysqli = Conexion::init_conn();
		
		if(!$sentencia = $mysqli->prepare("select idUsuario, nombre, apellidos, correo, pass, DNI, CIF, direccion, telefono, rol from usuario where idUsuario = ?")){
			echo "<p>error prepare: " . $mysqli->error ."</p>";
		}
		$sentencia->bind_param("i",$id);
		if(!$sentencia->execute()){
			echo "<p>error execute: " . $mysqli->error . "</p>";
		}
		$sentencia->bind_result($id,$nom,$ap,$corr,$pas,$dni,$cif,$dir,$tel,$rol);
		if(!is_null($sentencia->fetch())){
			$user = new Usuario($id,$nom,$ap,$corr,$pas,$dni,$cif,$dir,$tel,$rol);
		} else $user = NULL;
		$sentencia->close();
		$mysqli->close();
		return $user;
	}
	
	public static function getUserByName($nom){
		$mysqli = Conexion::init_conn();
	
		if(!$sentencia = $mysqli->prepare("select idUsuario, nombre, apellidos, correo, pass, DNI, CIF, Direccion, Telefono, rol from usuario where nombre = ?")){
			echo "<p>error prepare: " . $mysqli->error ."</p>";
		}
		$sentencia->bind_param("s",$nom);
		if(!$sentencia->execute()){
			echo "<p>error prepare: " . $mysqli->error ."</p>";
		}
		$sentencia->bind_result($id,$nom,$ap,$corr,$pas,$dni,$cif,$dir,$tel,$rol);
		if(!is_null($sentencia->fetch())){
			$user = new Usuario($id,$nom,$ap,$corr,$pas,$dni,$cif,$dir,$tel,$rol);
		} else $user = NULL;
		$sentencia->close();
		$mysqli->close();
		return $user;
	}
	
	public static function getUserByCorreo($c){
		$mysqli = Conexion::init_conn();
	
		if(!$sentencia = $mysqli->prepare("select idUsuario, nombre, apellidos, correo, pass, DNI, CIF, Direccion, Telefono, rol from usuario where correo = ?")){
			echo "<p>error prepare: " . $mysqli->error ."</p>";
		}
		$sentencia->bind_param("s",$c);
		if(!$sentencia->execute()){
			echo "<p>error prepare: " . $mysqli->error ."</p>";
		}
		$sentencia->bind_result($id,$nom,$ap,$corr,$pas,$dni,$cif,$dir,$tel,$rol);
		if(!is_null($sentencia->fetch())){
			$user = new Usuario($id,$nom,$ap,$corr,$pas,$dni,$cif,$dir,$tel,$rol);
		} else $user = NULL;
		$sentencia->close();
		$mysqli->close();
		return $user;
	}
	
	public static function insertUser($user){
		$mysqli = Conexion::init_conn();
		
		if(!$sentencia = $mysqli->prepare("insert into usuario(nombre, apellidos, correo, pass, DNI, CIF, Direccion, Telefono, rol) values(?,?,?,?,?,?,?,?,?)")){
			echo "<p>error prepare: " . $mysqli->error ."</p>";
		}
		$sentencia->bind_param("ssssssssi",$user->getNombre(),$user->getApellidos(),$user->getCorreo(),$user->getPass(),$user->getDni(),$user->getCif(),$user->getDireccion(),$user->getTelefono(),$user->getRol());
		if(!$sentencia->execute()){
			echo "<p>error prepare: " . $mysqli->error ."</p>";
		}
		
		$sentencia->close();
		$num = $mysqli->affected_rows;
		$mysqli->close();
		return $num;
	}

	public static function updateUser($user){
		$mysqli = Conexion::init_conn();
		if(!$sentencia = $mysqli->prepare("UPDATE usuario SET nombre=?, apellidos=?, correo=?, pass=?, DNI=?, CIF=?, Direccion=?, Telefono=?, rol =? WHERE idUsuario =?")){
			echo "<p>error prepare: " . $mysqli->error ."</p>";
		}
		$sentencia->bind_param("ssssssssii",$user->getNombre(),$user->getApellidos(),$user->getCorreo(),$user->getPass(),$user->getDni(),$user->getCif(),$user->getDireccion(),$user->getTelefono(),$user->getRol(),$user->getIdUsuario());
		if(!$sentencia->execute()){
			echo "<p>error prepare: " . $mysqli->error ."</p>";
		}
		
		$sentencia->close();
		$num = $mysqli->affected_rows;
		$mysqli->close();
		return $num;
	}
	
	public static function getUsersByRol($rol,$off,$pag){
		$mysqli = Conexion::init_conn();
		
		if(!$sentencia = $mysqli->prepare("select idUsuario, nombre, apellidos, correo, pass,
					DNI, CIF, direccion, telefono, rol from usuario where rol = ? limit ? , ?")){
							echo "<p>error prepare: " . $mysqli->error ."</p>";
		}
		$sentencia->bind_param("iii",$rol,$off,$pag);
		if(!$sentencia->execute()){
			echo "<p>error bind: " . $mysqli->error ."</p>";
		}
		
		$usuarios = UsuarioDAO::recogerArrayUsuarios($sentencia->get_result());
		
		$sentencia->close();
		$mysqli->close();
		return $usuarios;
	}
	
	public static function getNumUsersByRol($rol){
		$mysqli = Conexion::init_conn();
	
		if(!$sentencia = $mysqli->prepare("select count(*) from usuario where rol = ? ")){
						echo "<p>error prepare: " . $mysqli->error ."</p>";
		}
		$sentencia->bind_param("i",$rol);
		if(!$sentencia->execute()){
			echo "<p>error bind: " . $mysqli->error ."</p>";
		}
		$sentencia->bind_result($num);
		$sentencia->fetch();
		
	
		$sentencia->close();
		$mysqli->close();
		return $num;
	}
	
	
	public  static function findUsers($nom,$ape,$dni,$cif,$tel,$cor,$tipo,$off,$pag){
		$mysqli = Conexion::init_conn();
		
 		$query = "select idUsuario, nombre, apellidos, correo, pass, DNI, CIF, direccion, telefono, rol from usuario where ( ";
 		$or = false;
 		if( $nom !=  null ){
			$query .= "nombre like '%$nom%' ";
			$or = true;
 		}
 		if($ape != null ){
 			if($or){
 				$query .= "or apellidos like '%$ape%' ";
 			}else{
 				$query .= "apellidos like '%$ape%' ";
 				$or = true;
 			}
 		}
		if( $dni != null){
			if($or){
				$query .= "or dni like '%$dni%' ";
			}else{
				$query .= "dni like '%$dni%' ";
				$or = true;
			}
		}
		if( $cif != null){
			if($or){
				$query .= "or cif like '%$cif%' ";
			}else{
				$query .= "cif like '%$cif%' ";
				$or = true;
			}
		}
		if( $tel != null){
			if($or){
				$query .= "or telefono = $tel ";
			}else{
				$query .= "telefono = $tel ";
				$or = true;
			}
		}
		if( $cor != null){
			if($or){
				$query .= "or correo like '%$cor%'";
			}else{
				$query .= "correo like '%$cor%'";
			}
		}
		$query.=") ";
 		if($tipo != 0){ 
				$query.="and rol = $tipo";
 		}
 		$query.= " limit $off , $pag";
 		if(!$sentencia = $mysqli->prepare($query)){
 			echo "<p>error prepare: " . $mysqli->error ."</p>";
 		}
//		$sentencia->bind_param("ssssisi",$par1,$par2,$par3,$par4,$tel,$par6,$tipo);
// 		$result = $mysqli->query($query);
// 		error_log("Result: " . $result);
 		if(!$sentencia->execute()){
 			echo "<p>error bind: " . $mysqli->error ."</p>";
 		}
		$usuarios = UsuarioDAO::recogerArrayUsuarios($sentencia->get_result());
 				
		$sentencia->close();
		$mysqli->close();
		return $usuarios;
	}
		
	public  static function tamBusqueda($nom,$ape,$dni,$cif,$tel,$cor,$tipo,$off,$pag){
		$mysqli = Conexion::init_conn();
			
		$query = "select count(*) from usuario where ( ";
		$or = false;
		if( $nom !=  null ){
			$query .= "nombre like '%$nom%' ";
			$or = true;
		}
		if($ape != null ){
			if($or){
				$query .= "or apellidos like '%$ape%' ";
			}else{
				$query .= "apellidos like '%$ape%' ";
				$or = true;
			}
		}
		if( $dni != null){
			if($or){
				$query .= "or dni like '%$dni%' ";
			}else{
				$query .= "dni like '%$dni%' ";
				$or = true;
			}
		}
		if( $cif != null){
			if($or){
				$query .= "or cif like '%$cif%' ";
			}else{
				$query .= "cif like '%$cif%' ";
				$or = true;
			}
		}
		if( $tel != null){
			if($or){
				$query .= "or telefono = $tel ";
			}else{
				$query .= "telefono = $tel ";
				$or = true;
			}
		}
		if( $cor != null){
			if($or){
				$query .= "or correo like '%$cor%'";
			}else{
				$query .= "correo like '%$cor%'";
			}
		}
		$query.=") ";
		if($tipo != 0){
			$query.="and rol = $tipo";
		}
		if(!$sentencia = $mysqli->prepare($query)){
			echo "<p>error prepare: " . $mysqli->error ."</p>";
		}
		//		$sentencia->bind_param("ssssisi",$par1,$par2,$par3,$par4,$tel,$par6,$tipo);
		// 		$result = $mysqli->query($query);
		// 		error_log("Result: " . $result);
		if(!$sentencia->execute()){
			echo "<p>error bind: " . $mysqli->error ."</p>";
		}
		$sentencia->bind_result($num);
		$sentencia->fetch();
	
		$sentencia->close();
		$mysqli->close();
		return $num;
	}
}

?>