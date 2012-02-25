<?php
require_once 'utils.php';
/**
 * Representa un Usuario
 */
class Usuario {	
	
	//------------------------------------------------------------------------------------------------------//
	//-----------------------------------------ATRIBUTOS----------------------------------------------------//
	//------------------------------------------------------------------------------------------------------//
	
	/*
	* Representa el login del usuario
	*/	
	public $login;
	
	/*
	* Representa los horarios del usuario
	*/	
	public $horarios;
	
	
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
		else $this -> horarios = array();
	}
	
	/**
	 * Dado un arreglo asociativo que contiene los nombres de los atributos (como llaves del arreglo) y sus respectivos valores,
	 * la funcion pobla todos los atributos del objeto
	 * @param $data arreglo asociativo que contiene los nombres de los atrbutos del objeto como llaves y sus respectivos valores
	 */
	function set($data) {
		foreach ($data as $llave => $valor) {
			if (is_array($valor)) {
				if($llave == 'horarios'){
					poblarArregloObjetos($valor, 'Horario');
				}
			}
			$this -> ${llave} = $valor;
		}
	}
	
	function getLogin(){
		return $this -> login;
	}
	
	function setLogin($nlogin){
		$this -> login = $nlogin;
	}
	
	function getHorarios(){
		return $this -> $horarios;
	}
	
	function setHorarios($nhorarios){
		$this -> horarios = $nhorarios;
	}
}

?>