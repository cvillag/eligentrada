<?php

class TipoEntrada{
	private $idTipo;
	private $nombre;
	
	public function __construct($id,$nom){
		$this->idTipo = $id;
		$this->nombre = $nom;
	}
	
	public function getIdTipo(){
		return $this->idTipo;
	}
	
	public function setIdTipo($new){
		$this->idTipo = $new;
	}
	
	public function getNombre(){
		return $this->nombre;
	}
	
	public function setNombre($new){
		$this->nombre = $new;
	}
}