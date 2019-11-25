<?php
class TipoEvento{
	private $idTipo;
	private $nombreTipo;
	
	public function __construct($id,$nom){
		$this->idTipo = $id;
		$this->nombreTipo = $nom;
	}
	
	public function getIdTipo(){
		return $this->idTipo;
	}
	
	public function setIdTipo($new){
		$this->idTipo = $new;
	}
	
	public function getNombreTipo(){
		return $this->nombreTipo;
	}
	
	public function setNombreTipo($new){
		$this->nombreTipo = $new;
	}
}
?>