<?php

/**
 * Representa un horario
 */
class Horario {
	
       //--------------------------------------------------------------------------------------------------------//
       //----------------------------------------------ATRIBUTOS-------------------------------------------------//
       //--------------------------------------------------------------------------------------------------------//
	
	/*
	* Representa los creditos totales del horario
	*/
	private $creditos_Totales;
	
	/*
	* Representa la fecha de creación del horario
	*/
	private $fechaCreacion;
	
	/*
	* Indica si el horario ha sido o no guardado
	*/
	private $guardado;
	
	/*
	* Representa el nombre del Horario
	*/
	private $nombre;
	
	/*
	* Representa el numero de cursos que tiene el horario
	*/
	private $num_Cursos;
	
	/*
	* Representa los cursos que posee el horario
	*/
	
	private $cursos;
	
	/*
	* Crea un nuevo horario
	*/
	function __construct($nfechaCreacion, $nnombre) {
	
	$fechaCreacion=$nfechaCreacion;
	$nombre=$nnombre;
	$cursos=new array();
	}
}

?>