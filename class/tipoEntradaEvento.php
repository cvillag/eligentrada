<?php
class  TipoEntradaEvento{
	private $idTipo;
	private $idEvento;
	private $nombreParticular;
	private $precio;
	private $cantidad;
	
	function __construct($idT,$idE,$nom,$pre,$can){
		$this->idTipo = $idT;
		$this->idEvento = $idE;
		$this->nombreParticular  = $nom;
		$this->precio  =  $pre;
		$this->cantidad =  $can;
		
	}
	
	public function getCantidad(){
		return $this->cantidad;
	}
	
	public function setCantidad($new){
		$this->cantidad = $new;
	}
	
	public function getPrecio(){
		return $this->precio;
	}
	
	public function setPrecio($new){
		$this->precio = $new;
	}
	
	public function getNombreParticular(){
		return $this->nombreParticular;
	}
	
	public function setIdNombreParticular($new){
		$this->nombreParticular = $new;
	}
	
	public function getIdTipo(){
		return $this->idTipo;
	}
	
	public function setIdTipo($new){
		$this->idTipo = $new;
	}
	
	public function getIdEvento(){
		return $this->idEvento;
	}
	
	public function setIdEvento($new){
		$this->idEvento = $new;
	}
}