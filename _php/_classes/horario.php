<?php

/**
 * Representa un horario
 */
class Horario {
	
       //--------------------------------------------------------------------------------------------------------//
       //----------------------------------------------ATRIBUTOS-------------------------------------------------//
       //--------------------------------------------------------------------------------------------------------//
	
	/**
	* Representa los creditos totales del horario
	*/
	private $creditos_Totales;
	
	/**
	* Representa la fecha de creación del horario
	*/
	private $fechaCreacion;
	
	/**
	* Indica si el horario ha sido o no guardado
	*/
	private $guardado;
	
	/**
	* Representa el nombre del Horario
	*/
	private $nombre;
	
	/**
	* Representa el numero de cursos que tiene el horario
	*/
	private $num_Cursos;
	
	/**
	* Representa los cursos que posee el horario
	*/
	
	private $cursos;
	

       //--------------------------------------------------------------------------------------------------------//
       //----------------------------------------------METODOS---------------------------------------------------//
       //--------------------------------------------------------------------------------------------------------//

        function __construct($nfechaCreacion, $nnombre) {
	
	$fechaCreacion=$nfechaCreacion;
	$nombre=$nnombre;
	$cursos=new array();
	}
	
	function getcreditos_Totales(){
		return $creditos_Totales;
	}
	
	function setcreditos_Totales($ncreditos_Totales){
		$creditos_Totales=$ncreditos_Totales;
	}
	
	function getfechaCreacion(){
		return $fechaCreacion;
	}
	
	function setfechaCreacion($nfechaCreacion){
	 $fechaCreacion=$nfechaCreacion;
	}
	
	function getguardado(){
		return $guardado;
	}
	
	function setguardado($nguardado){
		$guardado=$nguardado;
	}
	
	function getnombre(){
		return $nombre;
	}
	
	function setnombre($nnombre){
		$nombre=$nnombre;
	}
	
	function getnum_Cursos(){
		return $num_Cursos;
	}
	
	function setnum_Cursos($nnum_Cursos){
		$num_Cursos=$nnum_Cursos;
	}
	
	function getcursos(){
		return $cursos;
	}
	
	function setcursos($ncursos){
		$cursos=$ncursos;
	}
	
	
	
	
}

?>