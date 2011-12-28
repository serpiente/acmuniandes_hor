<?php
foreach (glob("../_classes/*.php") as $filename)
{
    require_once $filename;
}

/**
 * Clase que encapsula la funcionalidad para manejar las bases de datos
 */
class Hor_Dao {
		
	//Datos de la conexion a base de datos propia Wayu
	private $dbhost_mysql = 'mysqlhostingdti.uniandes.edu.co:3308';
	private $dbname_mysql = 'dbcrearhorario';
	private $dbuser_mysql = 'usdbcrearhorario';
	private $dbpass_mysql = 'Iegiy3';
	private $dbport_mysql = 3308;

	//Datos de la conexión a base de datos de DTI, NIFE
	//TODO Se asume que es conexion directa, pero puede no serlo.
	private $dbhost_ora;
	private $dbname_ora;
	private $dbuser_ora;
	private $dbpass_ora;
	private $dbport_ora;

	/**
	 * Constructor de la clase
	 */
	function __construct() {
		mysql_connect($dbhost_mysql, $dbuser_mysql, $dbpass_mysql) or die(mysql_error());
		mysql_select_db($dbname_mysql) or die(mysql_error());

		//TODO
		//Establecer conexion con NIFE
		//oci_connect()
	}

	//METODOS
	//Metodos privados son funciones de utilidad para realizar las consultas

	/**
	 * Ejecuta un query sobre la base de datos mySql y retorna un objeto con los resultados
	 * Este objeto sirve para iterar sobre cada registro de la tabla de resultados
	 * @param $query string indicando la sentencia a ejecutar
	 * @return $result tabla u objeto de resultados obtenida al ejecutar una sentencia, y sobre el cual se puede iterar
	 */
	private function queryMysql($query) {
		$result = mysql_query($query) or die(mysql_error());
		return $result;
	}

	/**
	 * Ejecuta un query sobre la base de datos Oracle (NIFE) y retorna un objeto con los resultados
	 * Este objeto sirve para iterar sobre cada registro de la tabla de resultados
	 * @param $query string indicando la sentencia a ejecutar
	 * @return $result tabla u objeto de resultados obtenida al ejecutar una sentencia, y sobre el cual se puede iterar
	 */
	private function queryOracle($query) {
		$result = oci_execute($query) or die(oci_error());
		return $result;
	}

	/**
	 * Retorna el siguiente registro o fila dada una tabla u objeto resultado de la ejecucion de una sentencia
	 * @param $tabla_resultado tabla u objeto de resultados obtenida al ejecutar una sentencia
	 * @return arreglo asociativo que contiene los valores de un registro o fila de una tabla. Los valores se acceden con los nombres de las columnas del modelo relacional.
	 */
	private function darSiguienteRegistroMySql($tabla_resultado) {
		return mysql_fetch_assoc($tabla_resultado);
	}

	/**
	 * Retorna el siguiente registro o fila dada una tabla u objeto resultado de la ejecucion de una sentencia
	 * @param $tabla_resultado tabla u objeto de resultados obtenida al ejecutar una sentencia
	 * @return arreglo asociativo que contiene los valores de un registro o fila de una tabla. Los valores se acceden con los nombres de las columnas del modelo relacional.
	 */
	private function darSiguienteRegistroOracle($tabla_resultado) {
		return oci_fetch_assoc($tabla_resultado);
	}

	/**
	 * Retorna el numero de registros o filas dentro de una tabla u objeto de resultados
	 * @param $tabla_resultado tabla u objeto de resultados obtenida al ejecutar una sentencia
	 * @return numero de resultados dentro de la tabla u objeto de resultados
	 */
	private function darNumeroResultadosMySql($tabla_resultado) {
		return mysql_num_rows($tabla_resultado);
	}

	/**
	 * Retorna el numero de registros o filas dentro de una tabla u objeto de resultados
	 * @param $tabla_resultado tabla u objeto de resultados obtenida al ejecutar una sentencia
	 * @return numero de resultados dentro de la tabla u objeto de resultados
	 */
	private function darNumeroResultadosOracle($tabla_resultado) {
		return oci_num_rows($tabla_resultado);
	}
	
	/**
	 * Retorna un string con el query de mysql dado un arreglo de selects, unarreglos de froms, un arreglo de as y un string indicando la condición del update.
	 * @param $selects arreglo que contiene los selects
	 * @param $froms arreglo asociativo de key-value pairs donde cada llave del arreglo es el nombre de cada tabla del from, y el valor asociado a cada tabla es el alias dentro de la sentencia.
	 * @param $where string que indica las condiciones de la sentencia
	 * @return string que contiene la sentencia para ser ejecutada siguiendo una estructura basica de select from where
	 */
	private function selectFromWhereMysql($selects,$froms,$where){
		//TODO
		
	}
	
	/**
	 * Retorna un string con el query de oracle dado un arreglo de selects, unarreglos de froms, un arreglo de as y un string indicando la condición del update.
	 * @param $selects arreglo que contiene los selects
	 * @param $froms arreglo asociativo de key-value pairs donde cada llave del arreglo (o posicion del arreglo) es el nombre de cada tabla del from, y el valor asociado a cada tabla es el alias dentro de la sentencia.
	 * @param $where string que indica las condiciones de la sentencia
	 * @return string que contiene la sentencia para ser ejecutada siguiendo una estructura basica de select from where
	 */
	private function selectFromWhereOracle($selects,$froms,$where){
		//TODO
		
	}
	
	/**
	 * Retorna un string con la sentencia sql tanto para mysql como para oracle para hacer un update en una tabala dado el nombre de la tabla, un arregla associativa de las columnas 
	 * a actualizar con sus respectivos valores y un string indicando la condición del update.
	 * @param $nombre_tabla string indicando el nombre de la tabla a actualizar
	 * @param $colums_valores arreglo asociativo de key-value pairs donde cada llave del arreglo (o posicion del arreglo) es el nombre de cada columnda de la tabla a actualizar, y el valor asociado a cada columna es el valor a actualizar.
	 * @param $where string que indica las condiciones de la sentencia
	 */
	private function updateSetWhere($nombre_tabla, $colums_valores, $where){
		$query = "UPDATE $nombre_tabla SET ";	
		$flag = TRUE;	
		foreach ($colums_valores as $colum => $valor) {
			if($flag){
				$query.="$colum=$valor";
				$flag = FALSE;
			}
			$query.=", $colum=$valor";
		}
		$query.= " WHERE $where;";
	}
	
	/**
	 * Retorna un string con la sentencia sql de mysql para hacer un delete en una table dado el nombre de la tabla y un string indicando la condicion del where
	 * @param $nombre_tabla string indicando el nombre de la tabla a actualizar
	 * @param $where string que indica las condiciones de la sentencia
	 */
	private function deleteFromWhereMysql($nombre_tabla, $where){
		return "DELETE FROM $nombre_tabla WHERE $where;";
	}
	
	/**
	 * Retorna un string con la sentencia sql de oracle para hacer un delete en una tabla dado el nombre de la tabla y un string indicando la condicion del where
	 * @param $nombre_tabla string indicando el nombre de la tabla a actualizar
	 * @param $where string que indica las condiciones de la sentencia
	 */
	private function deleteFromWhereOracle($nombre_tabla, $where){
		return "DELETE FROM $nombre_tabla WHERE $where;";
	}
	
	private function insertInto($nombre_tabla, $valores){
		
		$vals = "";
		$flag = TRUE;	
		foreach ($valores as $valor) {
			if($flag){
				$vals.="$valor";
				$flag = FALSE;
			}
			$vals .= ", $valor";
		}
		$query = "INSERT INTO $nombre_tabla VALUES ($vals)";
		
	}

	/**
	 * Consulta cursos dado el nombre de un profesor
	 * @param $profesor string indicando el nombre del profesor
	 * @param $cbuflag boolean indicando si se busca un cbu
	 * @return arreglo de objetos de la clase Curso
	 */
	function consultarCursosPorNombreProfesor($profesor, $cbuflag) {
		//TODO

		//return del arreglo con objetos Curso, json encoded
	}

	/**
	 * Consulta cursos dado el nombre del curso
	 * @param $curso string indicando el nombre del curso
	 * @param $cbuflag boolean indicando si se busca un cbu
	 * @return arreglo de objetos de la clase Curso
	 */
	function consultarCursosPorNombreCurso($curso, $cbuflag) {
		//TODO

		//return del arreglo con objetos Curso, json encoded
	}

	/**
	 * Consulta cursos dado el nombre del departamento
	 * @param $depto string indicando el nombre del departamento
	 * @param $cbuflag boolean indicando si se busca un cbu
	 * @return arreglo de objetos de la clase Curso
	 */
	function consultarCursosPorNombreDepartamento($depto, $cbuflag) {
		//TODO

		//return del arreglo con objetos Curso, json encoded
	}

	/**
	 * Consulta cursos dado el crn del curso
	 * @param $crn string indicando el crn del curso
	 * @return arreglo de objetos de la clase Curso
	 */
	function consultarCursosPorCRN($crn) {
		//TODO

		//return del arreglo con objetos Curso, json encoded
	}

	/**
	 * Consulta cursos dado el código del curso
	 * @param $cod string indicando el codigo del curso
	 * @return arreglo de objetos de la clase Curso
	 */
	function consultarCursosPorCodigoCurso($cod) {
		//TODO

		//return del arreglo con objetos Curso, json encoded
	}

	/**
	 * Consulta cursos dados un conjunto de días y un conjunto de horas específicas.
	 * @param $cbuflag boolean indicando si se busca un cbu
	 * @param $dias arreglo de caracteres indicando los días buscados
	 * @param $horas arreglo de caracteres indicando las horas buscadas
	 * @return arreglo de objetos de la clase Curso
	 */
	function consultarCursosPorDiasHoras($dias, $horas, $cbuflag) {
		//TODO

		//return del arreglo con objetos Curso, json encoded
	}

	/**
	 * Consulta cursos dado el nombre del curso
	 * @param $tipo string indicando el tipo del CBU (tipo A o tipo B)
	 * @return arreglo de objetos de la clase Curso
	 */
	function consultarCursosPorCBU($tipo) {
		//TODO

		//return del arreglo con objetos Curso, json encoded
	}
	
	/**
	 * Retorna un horario, dado su id
	 * @param $id_hor string indicando el identificador unico de un horario
	 * @return objeto de la clase Horario
	 */
	function consultarHorarioPorId($id_hor) {
		//TODO
	}

	/**
	 * Retorna un curso, dado su id
	 * @param $crn_cur string indicando el identificador unico de un curso
	 * @return objeto de la clase Curso
	 */
	function consultarCursoPorCRN($crn_cur) {
		//TODO
	}

	/**
	 * Hace una búsqueda sobre todos los criterios de búsqueda posibles.
	 * Retorna el conjunto de cursos encontrados bajo cualquier criterio de búsqueda utilizando la entrada del usuario
	 * (i.e.) Si la entrada del usuario es 'ingenieria' debe retornar todos los cursos que tengan 'ingenieria' en el nombre del curso,
	 * en el nombre del profesor, en el nombre del departamento, en el crn o en el código del curso.
	 * @param $valor_consulta string indicando la entrada del usuario en la GUI
	 * @param $cbuflag boolean indicando si se busca un cbu
	 * @return 1(UN) arreglo de objetos de la clase Curso
	 */
	function consultarCualquierCriterio($valor_consulta, $cbuflag) {
		//TODO

		//return del arreglo con objetos Curso, json encoded
	}

	/**
	 * Consulta los horarios del usuario que se encuentra loggeado para ser mostrados
	 * @return echo arreglo de objetos de la clase Horario, json encoded
	 */
	function consultarHorariosPorUsuario($usuario) {
		//TODO

		//return del arreglo con objetos Horario, json encoded
	}
	
	/**
	 * Persiste un nuevo horario dentro de la(s) base(s) de datos
	 * @param $horario objeto de tipo Horario
	 */
	function persistirHorario($horario){
		//TODO REVISION
		$query = "INSERT INTO Horarios (Login_Usuario, Creditos_Totales, Num_Cursos, Fecha_Creacion, Nombre) VALUES (".$horario -> getUsuario().", ".$horario -> getCreditosTotales().", ".$horario -> getNumCursos().", NOW(), ".$horario -> getNombre().")";
		$this -> queryMysql($query);
	}
	
	/**
	 * Persiste un nuevo curso dentro de la(s) base(s) de datos
 	 * Funcion inutil, nunca sera utilizada
	 * @param $curso objeto de tipo Curso
	 */
	function persistirCurso($curso){
		//TODO
	}
	
	/**
	 * Actualiza un horario dentro de la(s) base(s) de datos
	 * @param $horario objeto de tipo Horario
	 */
	function actualizarHorario($horario){
		//TODO REVISION
		if(!($horario instanceof Horario)){
			throw new Exception("El objeto recibido por parametro no es una instancia de Horario y no se puede actualizar");			
		}
		else{
			$colums_valores = array('Creditos_Totales' => $horario -> getCreditosTotales(),'Num_Cursos' => $horario -> getNumCursos(), 'Nombre' => $horario -> getNombre());
			$query = $this -> updateSetWhere("Horarios", $colums_valores, "Id_Horario=".$horario -> getIdHorario());
			$query.= $this -> deleteFromWhereMysql('Cursos_Horarios', "Id_Horario=".$horario -> getIdHorario());
			
			$cursos = $horario -> getCursos();
			foreach ($cursos as $curso) {
				if (!($curso instanceof Curso)) {
					throw new Exception("El objeto no es una instancia de Curso", 1);					
				}
				$query.= "INSERT INTO Cursos_Horarios (Id_Horario, CRN_Curso) VALUES (".$horario -> getIdHorario().",".$curso -> getCRN().");";
			}
			$this -> queryMysql($query);
		}
	}
	
	/**
	 * Actualiza un curso dentro de la(s) base(s) de datos
	 * Funcion inutil, nunca sera utilizada
	 * @param $curso objeto de tipo Curso
	 */	
	function actualizarCurso($curso){
		//TODO
	}
	
	/**
	 * Elimina un horario y todos sus cursos dentro de la(s) base(s) de datos
	 * @param $id_hor el id del horario a eliminar
	 */
	function eliminarHorario($id_hor){
		//TODO REVISION
		$this -> queryMysql($this -> deleteFromWhereMysql("Horarios", "Id_Horario=$id_hor"));
	}
	
	/**
	 * Elimina un curso dentro de la(s) base(s) de datos
	 * Funcion inutil, nunca sera utilizada
	 * @param $id_curso el id del curso a eliminar
	 */
	function eliminarCurso($id_curso){
		//TODO
	}

}
?>