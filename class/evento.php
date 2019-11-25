<?php
class Evento{
	private $idEvento;
	private $nombreEvento;
	private $lugar;
	private $fecha;
	private $hora;
	private $descripcion;
	private $tipo;
	private $prioridad;
	private $fechaCreacion;
	private $idPromotor;
	private $rutaImagen;
	private $ubicacionLatLong;
	
	public function __construct($idEvento,$nombreEvento,$lugar,$fecha,$hora,$descripcion,
			$tipo,$prioridad,$fechaCreacion,$idPromotor,$rutaImagen,$ubicacionLatLong){
		$this->idEvento = $idEvento;
		$this->nombreEvento = $nombreEvento;
		$this->lugar = $lugar;
		$this->fecha = $fecha;
		$this->hora = $hora;
		$this->descripcion = $descripcion;
		$this->tipo = $tipo;
		$this->prioridad = $prioridad;
		$this->fechaCreacion = $fechaCreacion;
		$this->idPromotor = $idPromotor;
		$this->rutaImagen = $rutaImagen;
		$this->ubicacionLatLong = $ubicacionLatLong;
		
	}
	
	public function getRutaImagen(){
		return $this->rutaImagen;
	}
	
	public function setRutaImagen($new){
		$this->rutaImagen = $new;
	}
	
	public function getIdPromotor(){
		return $this->idPromotor;
	}
	
	public function setIdPromotor($new){
		$this->idPromotor = $new;
	}
	
	public function getFechaCreacion(){
		return $this->fechaCreacion;
	}
	
	public function setFechaCreacion($new){
		$this->fechaCreacion = $new;
	}
	
	public function getPrioridad(){
		return $this->prioridad;
	}
	
	public function setPrioridad($new){
		$this->prioridad = $new;
	}
	
	public function getTipo(){
		return $this->tipo;
	}
	
	public function setTipo($new){
		$this->tipo = $new;
	}
	
	public function getDescripcion(){
		return $this->descripcion;
	}
	
	public function setDescripcion($new){
		$this->descripcion = $new;
	}
	
	public function getHora(){
		return $this->hora;
	}
	
	public function setHora($new){
		$this->hora = $new;
	}
	
	public function getFecha(){
		return $this->fecha;
	}
	
	public function setFecha($new){
		$this->fecha= $new;
	}
	
	public function getLugar(){
		return $this->lugar;
	}
	
	public function setLugar($new){
		$this->lugar = $new;
	}
	
	public function getUbicacionLatLong(){
		return $this->ubicacionLatLong;
	}
	
	public function setUbicacionLatLong($new){
		$this->ubicacionLatLong = $new;
	}

	public function getNombreEvento(){
		return $this->nombreEvento;
	}
	
	public function setNombreEvento($new){
		$this->nombreEvento = $new;
	}
	
	public function getIdEvento(){
		return $this->idEvento;
	}
	
	public function setIdEvento($new){
		$this->idEvento = $new;
	}
	
}