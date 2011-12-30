<?php

/**
 * Representa un Usuario
 */
class Usuario {
	
	//TODO Implementar clase
	
	//------------------------------------------------------------------------------------------------------//
	//-----------------------------------------ATRIBUTOS----------------------------------------------------//
	//------------------------------------------------------------------------------------------------------//
	
	/*
	* Representa el login del usuario
	*/
	
	private $login;
	
	/*
	* Representa los horarios del usuario
	*/
	
	private $horarios;
	
	function __construct($nlogin) {
	$login=$nlogin;
	}
	
	function getlogin(){
		return $login;
	}
	
	function setlogin($nlogin){
		$login=$nlogin;
	}
}

?>