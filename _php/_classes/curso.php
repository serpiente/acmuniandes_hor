<?php

/**
 * Representa un curso
 */
class Curso {
	
	//-------------------------------------------------------------------------------------------------//
	//-----------------------------------ATRIBUTOS-----------------------------------------------------//
	//-------------------------------------------------------------------------------------------------//
	
	//TODO Implementar clase
	
	/**
	* Representa la capacidad total del curso medida como el numero máximo de personas que pueden tomar el curso
	*/
	private $capacidad_Total;
	
	/**
	* Representa el código único para cada curso, es una cadena de caracteres (e.g. ISIS-4001) donde las iniciales
	* del principio indican el departamento responsable, el primer número indica si es de pregrado o maestría, y el
	* resto del código identifica al curso.
	*/
	private $codigo_Curso;
	
	/**
	* Representa la cantidad de créditos del curso.
	*/
	private $creditos;
	
	/**
	* Representa el código CRN del curso, este código brinda la información necesaria para registrar un curso.
	*/
	private $crn;
	
	/**
	* Representa la cantidad de cupos disponibles en cada curso.
	*/
	private $cupos_Disponibles;
	
	/**
	* Representa el departamento o facultad dentro de la universidad responsable de la administración del curso
	*/
	private $departamento;
	
	/**
	* Representa el nombre completo del curso
	*/
	private $nombre;
	
	/**
	* Representa la sección del curso, esto se hace generalmente con el objetivo de distinguir cursos 
	*iguales pero con diferente profesor. 
	*/
	private $seccion;
	
	/**
	* Representa el tipo del curso, CBU Tipo A, CBU Tipo B, ... etc
	*/
	private $tipo;
	
	/**
	* Representa las complementarias del curso
	*/
	
	private $complementarias;
	
	/**
	* Representa las ocurrencias del curso
	*/
	
	private $ocurrencias;
	
	//-------------------------------------------------------------------------------------------------------//
	//------------------------------------------METODOS------------------------------------------------------//
	//-------------------------------------------------------------------------------------------------------//
	
	/**
	 * Construye un nuevo curso
	 * @param $ncapacidad_Total representa la capacidad total de estudiantes del nuevo curso
	 * @param $ncodigo_Curso representa el codigo del nuevo curso
	 * @param $ncreditos representa el número de créditos del nuevo curso
	 * @param $ncrn representa el crn del nuevo curso
	 * @param $ncupos_Disponibles representa los cupos disponible del nuevo curso
	 * @param $ndepartamento representa el departamento o facultad del nuevo curso
	 * @param $nnombre representa el nombre del nuevo curso
	 * @param $nseccion representa la sección del nuevo curso
	 * @param $ntipo representa el tipo del nuevo curso
	 */
	
	function __construct($ncapacidad_Total, $ncodigo_Curso, $ncreditos,$ncrn, $ncupos_Disponibles, $ndepartamento, $nnombre, $nseccion, $ntipo) {
	$capacidad_Total=$ncapacidad_Total;
	$codigo_Curso=$ncodigo_Curso;
	$creditos=$ncreditos;
	$crn=$ncrn;
	$cupos_Disponibles=$ncupos_Disponibles;
	$departamento=$ndepartamento;
	$nombre=$nnombre;
	$seccion=$nseccion;
	$tipo=$ntipo;
	$complementarias=new array();	
	$ocurrencias=new array();
	}
	
	function getcapacidad_Total(){
		return $capacidad_Total;
	}
	
	function getcodigo_Curso(){
		return $codigo_Curso;
	}
	
	function getcreditos(){
		return $creditos;
	}
	
	function getcrn(){
		return $crn;
	}
	
	function getcupos_Disponibles(){
		return $cupos_Disponibles;
	}
	
	function getdepartamento(){
		return $departamento;
	}
	
	function getnombre(){
		return $nombre;
	}
	
	function getseccion(){
		return $seccion;
	}
	
	function gettipo(){
		return $tipo;
	}
	
	
	function setcapacidad_Total($ncapacidad_Total){
		 $capacidad_Total=$ncapacidad_Total;
	}
	
	function setcodigo_Curso($ncodigo_Curso){
	 $codigo_Curso=$ncodigo_Curso;
	}
	
	function setcreditos($ncreditos){
	$creditos=$ncreditos;
	}
	
	function setcrn($ncrn){
	$crn=$ncrn;
	}
	
	function setcupos_Disponibles($ncupos_Disponibles){
	$cupos_Disponibles=$ncupos_Disponibles;
	}
	
	function setdepartamento($ndepartamento){
	 $departamento=$ndepartamento;
	}
	
	function setnombre($nnombre){
	 $nombre=$nnombre;
	}
	
	function setseccion($nseccion){
	 $seccion=$nseccion;
	}
	
	function settipo($ntipo){
	 $tipo=$ntipo;
	}
}

?>