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
	* Representa la hora de inicio del curso
	*/	
	private $horaFin;
	
	/**
	* Representa el salon del curso
	*/	
	private $salon;
	
	/**
	* Representa la duración del curso
	*/	
	private $unidades_Duracion;
	
	
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
		if ($json) $this -> set(json_decode($json, true));
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
		$this -> horaFino = $nhoraFin;
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
}

?>