<?php
/**
 * Copyright Capítulo Estudiantil ACM Universidad de los Andes
 * Creado y desarrollado por Capitulo Estudiantil ACM Universidad de los Andes. Liderado por Juan Tejada y Jorge Lopez.
 */
require_once 'utils.php';
/**
 * Representa un horario
 */
class Horario {
	
    //--------------------------------------------------------------------------------------------------------//
    //----------------------------------------------ATRIBUTOS-------------------------------------------------//
    //--------------------------------------------------------------------------------------------------------//
	
	/**
	 * Representa el identificador unico del horario asignado por la base de datos
	 */
	public $id_horario;
	
	/**
	 * Login del usuario que es duenio de este horario
	 */
	public $usuario;
	
	/**
	* Representa los creditos totales del horario
	*/
	public $creditos_Totales;
	
	/**
	* Representa la fecha de creación del horario
	*/
	public $fechaCreacion;
	
	/**
	* Representa el nombre del Horario
	*/
	public $nombre;
	
	/**
	* Representa el numero de cursos que tiene el horario
	*/
	public $num_Cursos;
	
	/**
	* Representa los cursos que posee el horario
	*/
	public $cursos;
	
	/**
	 * Representa los crns de cada curso dentro del horario
	 */
	public $crns;
	
	
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
		else $this -> cursos = array();
	}
	
	/**
	 * Dado un arreglo asociativo que contiene los nombres de los atributos (como llaves del arreglo) y sus respectivos valores,
	 * la funcion pobla todos los atributos del objeto
	 * @param $data arreglo asociativo que contiene los nombres de los atrbutos del objeto como llaves y sus respectivos valores
	 */
	function set($data) {
		foreach ($data as $llave => $valor) {
			if (is_array($valor)) {
				if($llave == 'cursos'){
					poblarArregloObjetos(&$valor, 'Curso');
				}
			}
			$this -> ${llave} = $valor;
		}
	}
	
	function getIdHorario(){
		return $this -> id_horario;
	}
	
	function setIdHorario($nid_horario){
		$this -> id_horario = $nid_horario;
	}

	function getUsuario(){
		return $this -> usuario;
	}
	
	function setUsuario($nusuario){
		$this -> usuario = $nusuario;
	}
	
	function getCreditosTotales(){
		return $this -> creditos_Totales;
	}
	
	function setCreditosTotales($ncreditos_Totales){
		$this -> creditos_Totales = $ncreditos_Totales;
	}
	
	function getFechaCreacion(){
		return $this -> fechaCreacion;
	}
	
	function setFechaCreacion($nfechaCreacion){
		$this -> fechaCreacion = $nfechaCreacion;
	}
	
	function getNombre(){
		return $this -> nombre;
	}
	
	function setNombre($nnombre){
		$this -> nombre = $nnombre;
	}
	
	function getNumCursos(){
		return $this -> num_Cursos;
	}
	
	function setNumCursos($nnum_Cursos){
		$this -> num_Cursos = $nnum_Cursos;
	}
	
	function getCursos(){
		return $this -> cursos;
	}
	
	function setCursos($ncursos){
		$this -> cursos = $ncursos;
	}	
	
	function getCRNs(){
		return $this -> crns;
	}
	
	function setCRNs($ncrns){
		$this -> crns = $ncrns;
	}
}

?>