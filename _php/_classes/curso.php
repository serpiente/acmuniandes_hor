<?php
require_once 'utils.php';
/**
 * Representa un curso
 */
class Curso {

	//-------------------------------------------------------------------------------------------------//
	//-----------------------------------ATRIBUTOS-----------------------------------------------------//
	//-------------------------------------------------------------------------------------------------//
		
	/**
	* Representa la capacidad total del curso medida como el numero máximo de personas que pueden tomar el curso
	*/
	public $capacidad_Total;
	
	/**
	* Representa el código único para cada curso, es una cadena de caracteres (e.g. ISIS-4001) donde las iniciales
	* del principio indican el departamento responsable, el primer número indica si es de pregrado o maestría, y el
	* resto del código identifica al curso.
	*/
	public $codigo_Curso;
	
	/**
	* Representa la cantidad de créditos del curso.
	*/
	public $creditos;
	
	/**
	* Representa el código CRN del curso, este código brinda la información necesaria para registrar un curso.
	*/
	public $crn;
	
	/**
	* Representa la cantidad de cupos disponibles en cada curso.
	*/
	public $cupos_Disponibles;
	
	/**
	* Representa el departamento o facultad dentro de la universidad responsable de la administración del curso
	*/
	public $departamento;
	
	/**
	* Representa el nombre completo del curso
	*/
	public $nombre;
	
	/**
	* Representa la sección del curso, esto se hace generalmente con el objetivo de distinguir cursos 
	* iguales pero con diferente profesor. 
	*/
	public $seccion;
	
	/**
	* Representa el tipo del curso, CBU Tipo A, CBU Tipo B, ... etc
	*/
	public $tipo;
	
	/**
	* Representa las complementarias del curso
	*/	
	public $complementarias;
	
	/**
	* Representa las ocurrencias del curso
	*/	
	public $ocurrencias;
	
	/**
	 * Representa los profesores que participan en el curso
	 */
	public $profesores;
	
	/**
	 * String representando los días que ocurre éste curso ej:(LMIJVS)
	 */
	public $dias;
	
	/**
	 * Numero de complementarias que tiene el curso
	 */
	public $numcompl;
	
	/**
	 * Representa el índice del curso padre de la clase dentro de un arreglo de cursos a ser retornado al cliente.
	 * Se maneja dentro del conexto de servicios al cliente.
	 */
	public $inpadre;
	
	
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
		else{
			$this -> complementarias = array();
			$this -> ocurrencias = array();
			$this -> profesores = array();
		}
	}
	
	/**
	 * Dado un arreglo asociativo que contiene los nombres de los atributos (como llaves del arreglo) y sus respectivos valores,
	 * la funcion pobla todos los atributos del objeto
	 * @param $data arreglo asociativo que contiene los nombres de los atrbutos del objeto como llaves y sus respectivos valores
	 */
	function set($data) {
		foreach ($data as $llave => $valor) {
			if (is_array($valor)) {
				if ($llave == 'ocurrencias') {
					poblarArregloObjetos($valor, 'Ocurrencia');
				}
				if($llave == 'complementarias'){
					poblarArregloObjetos($valor, 'Curso');
				}
				if($llave == 'profesores'){
					poblarArregloObjetos($valor, 'Profesor');
				}
			}
			$this -> ${llave} = $valor;
		}
	}
	
	function getcapacidad_Total(){
		return $this -> capacidad_Total;
	}
	
	function getCodigo_Curso(){
		return $this -> codigo_Curso;
	}
	
	function getCreditos(){
		return $this -> creditos;
	}
	
	function getCrn(){
		return $this -> crn;
	}
	
	function getCupos_Disponibles(){
		return $this -> cupos_Disponibles;
	}
	
	function getDepartamento(){
		return $this -> departamento;
	}
	
	function getNombre(){
		return $this -> nombre;
	}
	
	function getSeccion(){
		return $this -> seccion;
	}
	
	function getTipo(){
		return $this -> tipo;
	}
	
	function getComplementarias(){
		return $this -> complementarias;
	}
	
	function getOcurrencias(){
		return $this -> ocurrencias;
	}
		
	function getProfesores(){
		return $this -> profesores;
	}
	
	function getDias(){
		return $this -> dias;
	}
		
	function setCapacidad_Total($ncapacidad_Total){
		 $this -> capacidad_Total = $ncapacidad_Total;
	}
	
	function setCodigo_Curso($ncodigo_Curso){
		$this -> codigo_Curso = $ncodigo_Curso;
	}
	
	function setCreditos($ncreditos){
		$this -> creditos = $ncreditos;
	}
	
	function setCrn($ncrn){
		$this -> crn = $ncrn;
	}
	
	function setCupos_Disponibles($ncupos_Disponibles){
		$this -> cupos_Disponibles = $ncupos_Disponibles;
	}
	
	function setDepartamento($ndepartamento){
		$this -> departamento = $ndepartamento;
	}
	
	function setNombre($nnombre){
		$this -> nombre = $nnombre;
	}
	
	function setSeccion($nseccion){
		$this -> seccion = $nseccion;
	}
	
	function setTipo($ntipo){
		$this -> tipo = $ntipo;
	}
	
	function setComplementarias($ncomplementarias){
		$this -> complementarias = $ncomplementarias;
	}
	
	function setOcurrencias($nocurrencias){
		$this -> ocurrencias = $nocurrencias;
	}

	function setProfesores($nprofesores){
		$this -> profesores = $nprofesores;
	}
	
	function setDias($ndias){
		$this -> dias = $ndias; 
	}

}
?>