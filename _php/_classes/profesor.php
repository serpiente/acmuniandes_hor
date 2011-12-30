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
	* Representa los cursos de los que es responsable un profesor
	*/
	
         private $cursos;
	/*
	*Construye un nuevo profesor
	*/
	
	function __construct($napellido, $nnombre) {
	$apellido=$napellido;
	$nombre=$nnombre;
	$cursos=new array();
	}
}

?>