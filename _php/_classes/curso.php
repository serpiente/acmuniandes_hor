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
	$capacidad_Total;
	
	/*
	* Representa el código único para cada curso, es una cadena de caracteres (e.g. ISIS-4001) donde las iniciales
	* del principio indican el departamento responsable, el primer número indica si es de pregrado o maestría, y el
	* resto del código identifica al curso.
	*/
	$codigo_Curso;
	
	/*
	* Representa la cantidad de créditos del curso.
	*/
	$creditos;
	
	/*
	* Representa el código CRN del curso, este código brinda la información necesaria para registrar un curso.
	*/
	$crn;
	
	/*
	* Representa la cantidad de cupos disponibles en cada curso.
	*/
	$cupos_Disponibles;
	
	/*
	* Representa el departamento o facultad dentro de la universidad responsable de la administración del curso
	*/
	$departamento;
	
	/*
	* Representa el nombre completo del curso
	*/
	$nombre;
	
	/*
	* Representa la sección del curso, esto se hace generalmente con el objetivo de distinguir cursos 
	*iguales pero con diferente profesor. 
	*/
	$seccion;
	
	/*
	* Representa el tipo del curso, CBU Tipo A, CBU Tipo B, ... etc
	*/
	$tipo;
	
	/*
	* Representa las complementarias del curso
	*/
	
	$complementarias;
	
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