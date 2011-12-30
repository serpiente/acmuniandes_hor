<?php

/**
 * Representa un curso
 */
class Curso {
	
	//-------------------------------------------------------------------------------------------------//
	//-----------------------------------ATRIBUTOS-----------------------------------------------------//
	//-------------------------------------------------------------------------------------------------//
	
	//TODO Implementar clase
	
	/*
	* Representa la capacidad total del curso medida como el numero máximo de personas que pueden tomar el curso
	*/
	private $capacidad_Total;
	
	/*
	* Representa el código único para cada curso, es una cadena de caracteres (e.g. ISIS-4001) donde las iniciales
	* del principio indican el departamento responsable, el primer número indica si es de pregrado o maestría, y el
	* resto del código identifica al curso.
	*/
	private $codigo_Curso;
	
	/*
	* Representa la cantidad de créditos del curso.
	*/
	private $creditos;
	
	/*
	* Representa el código CRN del curso, este código brinda la información necesaria para registrar un curso.
	*/
	private $crn;
	
	/*
	* Representa la cantidad de cupos disponibles en cada curso.
	*/
	private $cupos_Disponibles;
	
	/*
	* Representa el departamento o facultad dentro de la universidad responsable de la administración del curso
	*/
	private $departamento;
	
	/*
	* Representa el nombre completo del curso
	*/
	private $nombre;
	
	/*
	* Representa la sección del curso, esto se hace generalmente con el objetivo de distinguir cursos 
	*iguales pero con diferente profesor. 
	*/
	private $seccion;
	
	/*
	* Representa el tipo del curso, CBU Tipo A, CBU Tipo B, ... etc
	*/
	private $tipo;
	
	/*
	* Representa las complementarias del curso
	*/
	
	private $complementarias;
	
	/*
	* Construye un nuevo curso
	*/
	
	function __construct($ncapacidad_Total, $ncodigo_Curso, $ncreditos,$ncrn, $ncupos_Disponibles, $ndepartamento, $nnombre, $nseccion, $ntipo) {
	$capacidad_Total=$ncapacidad_Total;
	$codigo_Curso=$ncodigo_Curso;
	$creditos=$ncreditos;
	$crn=$ncrn;
	$cupos_Disponibles=$ncuposDisponibles;
	$departamento=$ndepartamento;
	$nombre=$nnombre;
	$seccion=$nseccion;
	$tipo=$ntipo;
	$complementarias=new array();	
	}
}

?>