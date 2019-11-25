<?php
class Retail{
	private $idUsuario;
	private $rand;

	public function __construct($idUsr, $num){
		$this->idUsuario = $idUsr;
		$this->rand = $num;
	}
	
	public function getSalt(){
		return $this->rand;
	}
	
	public function getId(){
		return $this->idUsuario;
	}
	
	public function setSalt($num){
		$this->rand = $num;
	}
}
?>