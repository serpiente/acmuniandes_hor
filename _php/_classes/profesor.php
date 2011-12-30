<?php

/**
 * Representa un profesor
 */
class Profesor {
	
	//---------------------------------------------------------------------------------------------------//
	//-----------------------------------------ATRIBUTOS-------------------------------------------------//
	//---------------------------------------------------------------------------------------------------//
	
	/**
	* Representa el apellido del profesor
	*/
	
	private $apellido;
	
	/**
	* Representa el nombre del profesor
	*/
	
	private $nombre;
	
	/**
	* Representa los cursos de los que es responsable un profesor
	*/
	
         private $cursos;
	//---------------------------------------------------------------------------------------------------//
	//-----------------------------------------METODOS-------------------------------------------------//
	//---------------------------------------------------------------------------------------------------//
	
	
	function __construct($napellido, $nnombre) {
	$apellido=$napellido;
	$nombre=$nnombre;
	$cursos=new array();
	}
	
	function getapellido(){
		return $apellido;
	}
	
	function setapellido($napellido){
		$apellido=$napellido;
	}
	
	function getnombre(){
		return $nombre;
	}
	
	function setnombre($nnombre){
		$nombre=$nnombre;
	}
}

?>