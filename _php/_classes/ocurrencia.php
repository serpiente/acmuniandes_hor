<?php
/**
 * Copyright Capítulo Estudiantil ACM Universidad de los Andes
 * Creado y desarrollado por Capitulo Estudiantil ACM Universidad de los Andes. Liderado por Juan Tejada y Jorge Lopez.
 */

/**
 * Representa una ocurrencia
 */
class Ocurrencia {
	
	//------------------------------------------------------------------------------------------------------//
	//------------------------------------------ATRIBUTOS---------------------------------------------------//
	//------------------------------------------------------------------------------------------------------//
	
	/**
	* Representa el dia de la ocurrencia del curso char perteneciente a {L,M,I,J,V,S}
	*/	
	public $dia;
	
	/**
	* Representa la hora de inicio del curso. Formato HH:MM 24 horas ej. 13:00
	*/	
	public $horaInicio;
	
	/**
	* Representa la hora de inicio del curso. Formato HH:MM 24 horas ej. 13:00
	*/	
	public $horaFin;
	
	/**
	* Representa el salon del curso. Puede ser null.
	*/	
	public $salon;
	
	/**
	* Representa la duración del curso en unidades de media hora. Ej. 3 unidades = 1.5 horas. Mínimo valor: 2.
	*/	
	public $unidades_Duracion;
	
	/**
	 * Representa la fecha de inicio de la ocurrencia.
	 */
	public $fechaini;
	
	/**
	 * Representa la fecha de fin de la ocurrencia.
	 */
	public $fechafin;
	
	
	//---------------------------------------------------------------------------------------------------//
	//-----------------------------------------METODOS---------------------------------------------------//
	//---------------------------------------------------------------------------------------------------//	
	
	/**
	 * Constructor de la clase
	 * Puede recibir un string en formato json con la representación del objeto. Si recibe el objeto en representación json se encarga 
	 * de poblar el valor de sus atributos con la informacion contenida en el objeto json
	 * @param $json representacion del objeto en formato json (string). Puede ser o no pasado como parametro.
	 */
	function __construct($json = false) {
		if ($json) $this -> set($json);
	}
	
	/**
	 * Dado un arreglo asociativo que contiene los nombres de los atributos (como llaves del arreglo) y sus respectivos valores,
	 * la funcion pobla todos los atributos del objeto
	 * @param $data arreglo asociativo que contiene los nombres de los atrbutos del objeto como llaves y sus respectivos valores
	 */
	function set($data) {
		foreach ($data as $llave => $valor) {
			$this -> ${llave} = $valor;
		}
	}
	
	function getDia(){
		return $this -> dia;
	}
	
	function setDia($ndia){
		$this -> dia = $ndia;
	}
	
	function getHoraInicio(){
		return $this -> horaInicio;
	}
	
	function setHoraInicio($nhoraInicio){
		$this -> horaInicio = $nhoraInicio;
	}
	
	function getHoraFin(){
		return $this -> horaFin;
	}
	
	function setHoraFin($nhoraFin){
		$this -> horaFin = $nhoraFin;
	}
	
	function getSalon(){
		return $this -> salon;
	}
	
	function setSalon($nsalon){
		$this -> salon = $nsalon;
	}
	
	function getUnidadesDuracion(){
		return $this -> unidades_Duracion;
	}
	
	function setUnidadesDuracion($nunidades_Duracion){
		$this -> unidades_Duracion = $nunidades_Duracion;
	}
	
	function getFechaIni(){
		return $this -> fechaini;
	}
	
	function setFechaIni($fechaini){
		$this -> fechaini = $fechaini;
	}
	
	function getFechaFin(){
		return $this -> fechafin;
	}
	
	function setFechaFin($fechafin){
		$this -> fechafin = $fechafin;
	}
}

?>