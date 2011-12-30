<?php

/**
 * Representa un profesor
 */
class Profesor {
	
	//---------------------------------------------------------------------------------------------------//
	//-----------------------------------------ATRIBUTOS-------------------------------------------------//
	//---------------------------------------------------------------------------------------------------//
	
	/*
	* Representa el apellido del profesor
	*/
	
	private $apellido;
	
	/*
	* Representa el nombre del profesor
	*/
	
	private $nombre;
	
	/*
	*Construye un nuevo profesor
	*/
	
	function __construct($napellido, $nnombre) {
	$apellido=$napellido;
	$nombre=$nnombre;
	}
}

?>