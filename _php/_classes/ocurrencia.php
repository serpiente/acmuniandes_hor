<?php

/**
 * Representa una ocurrencia
 */
class Ocurrencia {
	
	//------------------------------------------------------------------------------------------------------//
	//------------------------------------------ATRIBUTOS---------------------------------------------------//
	//------------------------------------------------------------------------------------------------------//
	
	/**
	* Representa el dia de la ocurrencia del curso
	*/
	
	private $dia;
	
	/**
	* Representa la hora de inicio del curso
	*/
	
	private $horaInicio;
	
	/**
	* Representa el salon del curso
	*/
	
	private $salon;
	
	/**
	* Representa la duración del curso
	*/
	
	private $unidades_Duracion;
	
	//------------------------------------------------------------------------------------------------------//
	//------------------------------------------METODOS---------------------------------------------------//
	//------------------------------------------------------------------------------------------------------//
	
	function __construct($ndia, $nhoraInicio, $nsalon, $nunidades_Duracion) {
	$dia=$ndia;
	$horaInicio=$_nhoraInicio;
	$salon=$nsalon;
	$unidades_Duracion=$nunidades_Duracion;
	}
	
	function getdia(){
		return $dia;
	}
}

?>