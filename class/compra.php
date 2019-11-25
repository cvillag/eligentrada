<?php
class Compra{
	private $idTipo;
	private $idEvento;
	private $idUsuario;
	private $idVenta;
	private $cantidad;
	
	public function __construct($idT,$idE,$idU,$idV,$cant){
		$this->idTipo = $idT;
		$this->idEvento = $idE;
		$this->idUsuario = $idU;
		$this->idVenta = $idV;
		$this->cantidad = $cant;
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
	
	public function getIdUsuario(){
		return $this->idUsuario;
	}
	
	public function setIdUsuario($new){
		$this->idUsuario = $new;
	}
	
	public function getIdVenta(){
		return $this->idVenta;
	}
	
	public function setIdVenta($new){
		$this->idVenta= $new;
	}
	
	public function getCantidad(){
		return $this->cantidad;
	}
	
	public function setCantidad($new){
		$this->cantidad = $new;
	}
}