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
	public $apellido;
	
	/**
	* Representa el nombre del profesor
	*/	
	public $nombre;
	
	
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
	
	function getApellido(){
		return $this -> apellido;
	}
	
	function setApellido($napellido){
		$this -> apellido = $napellido;
	}
	
	function getNombre(){
		return $this -> nombre;
	}
	
	function setNombre($nnombre){
		$this -> nombre = $nnombre;
	}
}

?>