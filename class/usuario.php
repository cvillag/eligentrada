<?php
class Usuario{
	
	private $idUsuario;
	private $nombre;
	private $apellidos;
	private $correo;
	private $pass;
	private $dni;
	private $cif;
	private $direccion;
	private $telefono;
	private $rol;
	
	function __construct($id,$nombre,$ap,$cor,$pas,$dni,$cif,$dir,$tel,$rol){
		$this->idUsuario = $id;
		$this->nombre = $nombre;
		$this->setApellidos($ap);
		$this->setCorreo($cor);
		$this->setPass($pas);
		$this->setDni($dni);
		$this->setCif($cif);
		$this->setDireccion($dir);
		$this->setTelefono($tel);
		$this->setRol($rol);
	}
	
	public function setId($new){
		$this->idUsuario = $new;
	}
	
	public function getRol(){
		return $this->rol;
	}
	
	public function setRol($newR){
		$this->rol = $newR;
	}
	
	public function getTelefono(){
		return $this->telefono;
	}
	
	public function setTelefono($newT){
		$this->telefono = $newT;
	}
	
	public function getDireccion(){
		return $this->direccion;
	}
	
	public function setDireccion($newD){
		$this->direccion = $newD;
	}
	
	public function getCif(){
		return $this->cif;
	}
	
	public function setCif($newCif){
		$this->cif = $newCif;
	}
	
	public function getDni(){
		return $this->dni;
	}
	
	public function setDni($newDni){
		$this->dni = $newDni;
	}
	
	public function getPass(){
		return $this->pass;
	}
	
	public function setPass($newPass){
		$this->pass = $newPass;
	}
	
	public function getCorreo(){
		return $this->correo;
	}
	
	public function setCorreo($newC){
		$this->correo = $newC;
	}
	
	public function getApellidos(){
		return $this->apellidos;
	}
	
	public function setApellidos($newA){
		$this->apellidos = $newA;
	}
	
	public function getNombre(){
		return $this->nombre;
	}
	
	public function setNombre($newNombre){
		$this->nombre = $newNombre;
	}
	
	public function getIdUsuario(){
		return $this->idUsuario;
	}
	
	public function setIdUsuario($newId){
		$this->idUsuario = $newId;
	}

	public function toJSON(){
		$json = array(
			'id' => $this->idUsuario,
			'nombre' => $this->nombre,
			'apellidos' => $this->apellidos,
			'correo' => $this->correo,
			'dni' => $this->dni,
			'cif' => $this->cif,
			'direccion' => $this->direccion,
			'telefono' => $this->telefono,
			'rol' => $this->rol
			);
		return json_encode($json);
	}
}