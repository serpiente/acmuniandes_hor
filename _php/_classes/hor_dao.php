<?php
/**
 * Copyright Capítulo Estudiantil ACM Universidad de los Andes
 * Creado y desarrollado por Capitulo Estudiantil ACM Universidad de los Andes. Liderado por Juan Tejada y Jorge Lopez.
 */
require_once 'utils.php';
foreach (glob("_classes/*.php") as $filename) {
	require_once $filename;
}
// error_reporting(E_ALL);
// ini_set('display_errors', 1);


/**
 * Clase que encapsula la funcionalidad para manejar las bases de datos
 */
class Hor_Dao {

	//Datos de la conexion a base de datos propia Wayu
	private $dbhost_mysql;
	private $dbname_mysql;
	private $dbuser_mysql;
	private $dbpass_mysql;
	private $dbport_mysql;

	//Datos de la conexión a base de datos de DTI, NIFE
	//TODO Se asume que es conexion directa, pero puede no serlo.
	private $dbhost_ora;
	private $dbuser_ora;
	private $dbpass_ora;
	private $dbport_ora;
	private $dbsid_ora;
	
	private $conn;
	
	/**
	 * Constructor de la clase
	 */
	function __construct() {
		$this -> initConections();
		mysql_connect($this -> dbhost_mysql, $this -> dbuser_mysql, $this -> dbpass_mysql);
		mysql_select_db($this -> dbname_mysql);


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

		$this -> conn = oci_connect($this -> dbuser_ora, $this -> dbpass_ora, $this -> dbhost_ora . "/" . $this -> dbsid_ora);

		if (!$this -> conn) {
			$e = oci_error();
			trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
		}
		$stid = oci_parse($this -> conn, $query);
		
		oci_execute($stid);
		return $stid;
	}
	
	/**
	 * Método que cierre la conexión actual de Oracle.
	 */
	private function closeConnection()
	{
		oci_close($this->conn);
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
	private function selectFromWhereMysql($selects, $froms, $where) {

		$sql = "SELECT ";
		$bool = FALSE;
		foreach ($selects as $column) {

			if (!$bool) {
				$sql .= "$column";
				$bool = TRUE;
			} else
				$sql .= ", $column";
		}

		$sql .= " FROM ";

		$bool = FALSE;
		foreach ($froms as $tabla => $alias) {

			if (!$bool) {
				$sql .= "$tabla as $alias";
				$bool = TRUE;
			} else
				$sql .= ", $tabla as $alias";
		}

		$sql .= " WHERE $where";

		return $sql;
	}

	/**
	 * Retorna un string con el query de oracle dado un arreglo de selects, unarreglos de froms, un arreglo de as y un string indicando la condición del update.
	 * @param $selects arreglo que contiene los selects
	 * @param $froms arreglo asociativo de key-value pairs donde cada llave del arreglo (o posicion del arreglo) es el nombre de cada tabla del from, y el valor asociado a cada tabla es el alias dentro de la sentencia.
	 * @param $where string que indica las condiciones de la sentencia
	 * @return string que contiene la sentencia para ser ejecutada siguiendo una estructura basica de select from where
	 */
	private function selectFromWhereOracle($selects, $froms, $where) {
		//TODO

	}

	/**
	 * Retorna un string con la sentencia sql tanto para mysql como para oracle para hacer un update en una tabala dado el nombre de la tabla, un arregla associativa de las columnas
	 * a actualizar con sus respectivos valores y un string indicando la condición del update.
	 * @param $nombre_tabla string indicando el nombre de la tabla a actualizar
	 * @param $colums_valores arreglo asociativo de key-value pairs donde cada llave del arreglo (o posicion del arreglo) es el nombre de cada columnda de la tabla a actualizar, y el valor asociado a cada columna es el valor a actualizar.
	 * @param $where string que indica las condiciones de la sentencia
	 * @return string que contiene la sentencia para ser ejecutada siguiendo una estructura del update
	 */
	private function updateSetWhere($nombre_tabla, $colums_valores, $where) {
		$query = "UPDATE $nombre_tabla SET ";
		$flag = TRUE;
		foreach ($colums_valores as $colum => $valor) {
			if ($flag) {
				$query .= "$colum=$valor";
				$flag = FALSE;
			}
			$query .= ", $colum=$valor";
		}
		$query .= " WHERE $where;";
	}

	/**
	 * Retorna un string con la sentencia sql de mysql para hacer un delete en una table dado el nombre de la tabla y un string indicando la condicion del where
	 * @param $nombre_tabla string indicando el nombre de la tabla a actualizar
	 * @param $where string que indica las condiciones de la sentencia
	 * @return string que contiene la sentencia para ser ejecutada siguiendo una estructura basica de delete para mysql
	 */
	private function deleteFromWhereMysql($nombre_tabla, $where) {
		return "DELETE FROM $nombre_tabla WHERE $where;";
	}

	/**
	 * Retorna un string con la sentencia sql de oracle para hacer un delete en una tabla dado el nombre de la tabla y un string indicando la condicion del where
	 * @param $nombre_tabla string indicando el nombre de la tabla a actualizar
	 * @param $where string que indica las condiciones de la sentencia
	 * @return string que contiene la sentencia para ser ejecutada siguiendo una estructura basica de delete para oracle
	 */
	private function deleteFromWhereOracle($nombre_tabla, $where) {
		return "DELETE FROM $nombre_tabla WHERE $where;";
	}

	/**
	 * Retorna un string con la sentencia sql para hacer un insert en una tabla dado el nombre de la tabal y los valores a insertar
	 * @param $nombre_tabla string indicando el nombre de la tabla a actualizar
	 * @param $valores arreglo con los valores a insertar en la tabla. Debens eguri el mismo orden de las columnas en la tabla
	 * @return string que contiene la sentencia para ser ejecutada siguiendo una estructura basica de insert
	 */
	private function insertInto($nombre_tabla, $valores) {
		//TODO
		$vals = "";
		$flag = TRUE;
		foreach ($valores as $valor) {
			if ($flag) {
				$vals .= "$valor";
				$flag = FALSE;
			}
			$vals .= ", $valor";
		}
		$query = "INSERT INTO $nombre_tabla VALUES ($vals)";

	}
	
	//METODOS DE CONSULTA

	/**
	 * Consulta cursos dado el nombre de un profesor
	 * @param $profesor string indicando el nombre del profesor
	 * @param $cbuflag boolean indicando si se busca un cbu
	 * @return arreglo de objetos de la clase Curso
	 */
	function consultarCursosPorNombreProfesor($profesor, $cbuflag) {
		//TODO

		$array;

		return json_encode($array);
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

		$array;

		return json_encode($array);
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

		$array;

		return json_encode($array);
		//return del arreglo con objetos Curso, json encoded
	}

	/**
	 * Consulta un dado el crn del curso
	 * @param $crn string indicando el crn del curso
	 * @return objeto de la Clase Curso (NOT JSON ENCODED)
	 */
	private function consultarCursoPorCRNInterno($crn) {
		//TODO Falta nombre de la tabla.
		$query = "SELECT * FROM UA_PROYECTO_HORARIOS c WHERE c.CRN_KEY=$crn";
		$result = $this -> queryOracle($query);
		$this -> closeConnection();
		return $this ->construirCursoDeArrAsoc($this -> darSiguienteRegistroOracle($result));
		//return Objeto de la clase Curso, sin hacer el json_encode
	}
	
		/**
	 * Consulta un dado el crn del curso
	 * @param $crn string indicando el crn del curso
	 * @return objeto de la Clase Curso
	 */
	function consultarCursoPorCRN($crn) {
		//TODO
		return json_encode(array($this -> consultarCursoPorCRNInterno($crn)));
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

		$array;

		return json_encode($array);
		//return del arreglo con objetos Curso, json encoded
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
		$query = "SELECT *
		FROM UA_PROYECTO_HORARIOS PH
		WHERE (PH.DESC_DEPTO LIKE '%$valor_consulta%' 
		OR	 PH.DEPARTAMENTO LIKE '%$valor_consulta%'
		OR	 PH.TITLE LIKE '%$valor_consulta%'
		OR PH.PRIMARY_INSTRUCTOR_LAST_NAME LIKE '%$valor_consulta%'
		OR PH.PRIMARY_INSTRUCTOR_FIRST_NAME LIKE '%$valor_consulta%'
		OR PH.PRIMARY_INSTRUCTOR_LAST_NAME2 LIKE '%$valor_consulta%'
		OR	 PH.PRIMARY_INSTRUCTOR_FIRST_NAME2 LIKE '%$valor_consulta%'
		OR	 PH.PRIMARY_INSTRUCTOR_LAST_NAME3 LIKE '%$valor_consulta%'
		OR	 PH.PRIMARY_INSTRUCTOR_FIRST_NAME3 LIKE '%$valor_consulta%'
		OR PH.CRN_KEY LIKE '%$valor_consulta%'
		OR PH.SUBJ_CODE LIKE '%$valor_consulta%'
		OR PH.CRSE_NUMBER LIKE '%$valor_consulta%'
		)
		";
		
		$result = $this -> queryOracle($query);
		//TODO
		if($this -> darNumeroResultadosOracle($result) > 100){
			return json_encode(array('message' => 'Esta busqueda retorna demasiados resultados. Refine su busqueda e intente de nuevo.'));
		} else {
			$array = $this -> crearArregloCursos($result);
			$this -> closeConnection();
			return json_encode($array);
		}
		
		//return del arreglo con objetos Curso, json encoded
	}
	
	/**
	 * Retorna un horario, dado su id
	 * @param $id_hor string indicando el identificador unico de un horario
	 * @return objeto de la clase Horario, json encoded
	 */
	function consultarHorarioPorId($id_hor) {
		$query = "SELECT * FROM HORARIOS WHERE HORARIOS.ID_HORARIO = $id_hor";
		$result = $this -> queryMysql($query);
				
		$hor = new Horario();
		if($row = $this -> darSiguienteRegistroMySql($result)){
			$hor -> setCreditosTotales($row['CREDITOS_TOTALES']);
			$hor -> setFechaCreacion($row['FECHA_CREACION']);
			$hor -> setGuardado(false);
			$hor -> setIdHorario($row['ID_HORARIO']);
			$hor -> setNombre($row['NOMBRE']);
			$hor -> setNumCursos($row['NUM_CURSOS']);
			$hor -> setUsuario($row['LOGIN_USUARIO']);	
		}
		
		
		$query = "SELECT CRN_CURSO FROM CURSOS_HORARIOS WHERE ID_HORARIO=$id_hor";
		$result = $this -> queryMysql($query);
		$crns = array();

		while($row = $this -> darSiguienteRegistroMySql($result)){
			$crns[] = $row['CRN_CURSO'];
		}
		
		$cursos = array();
		foreach ($crns as $crn) {
			$cursos[] = $this -> consultarCursoPorCRNInterno($crn);
		}
		$hor -> setCursos($cursos);
		return json_encode($hor);
	}

	/**
	 * Consulta los horarios del usuario que se encuentra loggeado para ser mostrados
	 * @return arreglo de objetos de la clase Horario, json encoded
	 */
	function consultarHorariosPorUsuario($usuario) {
		//TODO
		$query = 'SELECT h.ID_HORARIO, h.CREDITOS_TOTALES, h.NUM_CURSOS, h.FECHA_CREACION, h.NOMBRE FROM HORARIOS as h WHERE h.LOGIN_USUARIO = "'.$usuario.'"';
		$result = $this -> queryMysql($query);
		
		$horarios = array();
		
		while($row = $this -> darSiguienteRegistroMySql($result)){
			$hor = new Horario();
			$hor -> setCreditosTotales($row['CREDITOS_TOTALES']);
			$hor -> setFechaCreacion($row['FECHA_CREACION']);
			$hor -> setGuardado(false);
			$hor -> setIdHorario($row['ID_HORARIO']);
			$hor -> setNombre($row['NOMBRE']);
			$hor -> setNumCursos($row['NUM_CURSOS']);
			$hor -> setUsuario($usuario);
			$horarios[] = $hor;
		}
		
		//return del arreglo con objetos Horario, json encoded
		return json_encode($horarios);
	}

	/**
	 * Persiste un nuevo horario dentro de la(s) base(s) de datos
	 * @param $horario objeto de tipo Horario
	 */
	function persistirHorario($horario) {
		//TODO REVISION
		$query = 'INSERT INTO HORARIOS (LOGIN_USUARIO, CREDITOS_TOTALES, NUM_CURSOS, FECHA_CREACION, NOMBRE) VALUES ("' . $horario -> getUsuario() . '",' . $horario -> getCreditosTotales() . ',' . $horario -> getNumCursos() . ',NOW(),"' . $horario -> getNombre() . '")';
		$this -> queryMysql($query);
	}

	/**
	 * Persiste un nuevo curso dentro de la(s) base(s) de datos
	 * Funcion inutil, nunca sera utilizada
	 * @param $curso objeto de tipo Curso
	 */
	function persistirCurso($curso) {
		//TODO
	}

	/**
	 * Actualiza un horario dentro de la(s) base(s) de datos
	 * @param $horario objeto de tipo Horario
	 */
	function actualizarHorario($horario) {
		//TODO REVISION
		if ($horario instanceof Horario) {
			$query = 'UPDATE HORARIOS SET CREDITOS_TOTALES='.$horario -> getCreditosTotales().', NUM_CURSOS='.$horario -> getNumCursos().', NOMBRE="'.$horario -> getNombre().'" WHERE ID_HORARIO='.$horario -> getIdHorario().';';
			$this -> queryMysql($query);
			$query = 'DELETE FROM CURSOS_HORARIOS WHERE ID_HORARIO='.$horario -> getIdHorario().';';
			$this -> queryMysql($query);

			$cursos = $horario -> getCursos();
			foreach ($cursos as $curso) {
				if ($curso instanceof Curso) {
					$query = "INSERT INTO CURSOS_HORARIOS (ID_HORARIO, CRN_CURSO) VALUES (" . $horario -> getIdHorario() . "," . $curso -> getCrn() . ");";
					$this -> queryMysql($query);
				} else if($curso != 'null') {
					throw new Exception("El objeto no es una instancia de Curso", 1);
				}
			}
		} else {
			throw new Exception("El objeto recibido por parametro no es una instancia de Horario y no se puede actualizar");
		}
	}

	/**
	 * Actualiza un curso dentro de la(s) base(s) de datos
	 * Funcion inutil, nunca sera utilizada
	 * @param $curso objeto de tipo Curso
	 */
	function actualizarCurso($curso) {
		//TODO
	}

	/**
	 * Elimina un horario y todos sus cursos dentro de la(s) base(s) de datos
	 * @param $id_hor el id del horario a eliminar
	 */
	function eliminarHorario($id_hor) {
		//TODO REVISION
		$this -> queryMysql($this -> deleteFromWhereMysql("HORARIOS", 'ID_HORARIO='.$id_hor));
	}

	/**
	 * Elimina un curso dentro de la(s) base(s) de datos
	 * Funcion inutil, nunca sera utilizada
	 * @param $id_curso el id del curso a eliminar
	 */
	function eliminarCurso($id_curso) {
		//TODO
	}
	
	/**
	 * Persiste el login de un usuario
	 */
	function persistirUsuario($usuario){
		$query = 'INSERT INTO USUARIOS (LOGIN) VALUES ("'.$usuario.'") ON DUPLICATE KEY UPDATE LOGIN="'.$usuario.'"';
		$this -> queryMysql($query);
	}

	/**
	 * Función que construye un objeto curso a partir
	 * de un arreglo asociativo como resultado.
	 * Asigna sus complementarias y lo retorna con sus atributos asignados
	 * @param $arr_asoc arreglo asociativo con la información de un curso
	 * @return objeto de tipo Curso
	 */
	function construirCursoDeArrAsoc($arr_asoc) {
		
		$curso = new Curso();
		$curso -> setCapacidad_Total($arr_asoc["CUPO"]);
		$curso -> setCodigo_Curso($arr_asoc["SUBJ_CODE"].$arr_asoc["CRSE_NUMBER"]);
		$curso -> setCreditos($arr_asoc["CREDITOS"]);
		$curso -> setCrn($arr_asoc["CRN_KEY"]);
		$curso -> setCupos_Disponibles($curso ->getcapacidad_Total() - $arr_asoc["INSCRITOS"]);
		$curso -> setDepartamento(ucwords(strtolower($arr_asoc["DESC_DEPTO"])));
		$curso -> setNombre(ucwords(strtolower($arr_asoc["TITLE"])));
		$curso -> setSeccion($arr_asoc["SEQ_NUMBER_KEY"]);
		
		$curso -> setTipo($arr_asoc["ATRIBUTO_SECCION"]);
		
		$profesores = array();
		
		for ($i=1; $i < 4; $i++) {
			$prof = "";
			if($i == 1) {
				$prof.= $arr_asoc["PRIMARY_INSTRUCTOR_FIRST_NAME"]." ";
				$prof.= $arr_asoc["PRIMARY_INSTRUCTOR_LAST_NAME"];
			}
			else{
				$prof.= $arr_asoc["PRIMARY_INSTRUCTOR_FIRST_NAME$i"]." ";
				$prof.= $arr_asoc["PRIMARY_INSTRUCTOR_LAST_NAME$i"];
			}
			$profesores[] = ucwords(strtolower($prof));
		}
		
		$curso -> setProfesores($profesores);
		
		$array_compl = array();
	/*
		$arr_Strings = $arr_asoc["COMPLEMENTARIAS"];
			$num = 0;
			if (!empty($arr_Strings)) {
				$crn_comps = explode(":", $arr_Strings);
				foreach ($crn_comps as $compActual) {
					$ret = $this -> consultarCursoPorCRNInterno($compActual);
					array_push($array_compl, $ret);
					$num++;
				}
			}
			$curso -> setNumCompl($num);*/
	
		$curso -> setComplementarias($array_compl);
		
		
		$mag = null;
		// if($arr_asoc["MAGISTRAL"]){
			// $mag = $this -> consultarCursoPorCRNInterno($arr_asoc["MAGISTRAL"]);
		// }
		$curso -> setMagistral($mag);

		$ocurrencias = array();

		for ($i = 1; $i <= 11; $i++) {
			
			$beginTime = $arr_asoc["BEGIN_TIME" . $i];
			$endTime = $arr_asoc["END_TIME" . $i];
			$fecha_ini = $arr_asoc["FFECHA_INI" . $i];
			$fecha_fin = $arr_asoc["FFECHA_FIN" . $i];
			
			$mon = $arr_asoc["MONDAY_IND" . $i];
			$tue = $arr_asoc["TUESDAY_IND" . $i];
			$wed = $arr_asoc["WEDNESDAY_IND" . $i];
			$thu = $arr_asoc["THURSDAY_IND" . $i];
			$fri = $arr_asoc["FRIDAY_IND" . $i];
			$sat = $arr_asoc["SATURDAY_IND" . $i];
			$sun = $arr_asoc["SUNDAY_IND" . $i];

			$dias = "";
			if ($mon == "L") {
				$ocurrencias[] = $this -> crearOcurrencia($beginTime, $endTime, $mon, $fecha_ini, $fecha_fin);
				$dias += $mon;
			}
			if ($tue == "M") {
				$ocurrencias[] = $this -> crearOcurrencia($beginTime, $endTime, $tue, $fecha_ini, $fecha_fin);
				$dias += $tue;
			}
			if ($wed == "I") {
				$ocurrencias[] = $this -> crearOcurrencia($beginTime, $endTime, $wed, $fecha_ini, $fecha_fin);
				$dias += $wed;
			}
			if ($thu == "J") {
				$ocurrencias[] = $this -> crearOcurrencia($beginTime, $endTime, $thu, $fecha_ini, $fecha_fin);
				$dias += $thu;
			}
			if ($fri == "V") {
				$ocurrencias[] = $this -> crearOcurrencia($beginTime, $endTime, $fri, $fecha_ini, $fecha_fin);
				$dias += $fri;
			}
			if ($sat == "S") {
				$ocurrencias[] = $this -> crearOcurrencia($beginTime, $endTime, $sat, $fecha_ini, $fecha_fin);
				$dias += $sat;
			}
			if ($sun == "D") {
				$ocurrencias[] = $this -> crearOcurrencia($beginTime, $endTime, $sun, $fecha_ini, $fecha_fin);
				$dias += $sun;
			}
		}
		$curso -> setOcurrencias($ocurrencias);
		
		return $curso;
		
	}
	
	
	// /**
	 // * Funcion privada que retorna un arreglo unidimensional de objetos tipo Curso dado el resultado de un query a la base de datos Oracle
	 // * El arreglo está organizado de tal forma que las magistrales van seguidas de sus complementarias
	 // * Se asume que las complementarias de los cursos no se encuentran en el resultado de las base de datos por lo que se espera que no haya redundancia en el arreglo
	 // * @param $tabla_resultado el resultado obtenido de realizar un query sobre la base de datos Oracle
	 // * @return arreglo unidimensional de objetos tipo Curso donde las magistrales van seguidas de sus complementarias.
	 // */
	// private function crearArregloResultadosUnidim($tabla_resultado){
		// $resultados = array();
		// $i = 0;
		// while($asoc = $this -> darSiguienteRegistroOracle($tabla_resultado)){
			// $curso = $this -> construirCursoDeArrAsoc($asoc);
// 			
			// if($curso -> getMagistral() != null){
				// $mag = $curso -> getMagistral();
				// $complmag = $mag -> getComplementarias();
				// $mag -> setComplementarias(array());
				// $mag -> setIndiceEnResultados($i);
				// $mag -> setInPadre(null);
				// $resultados[] = $mag;
				// $i++;
// 				
				// foreach ($complmag as $comp) {
					// $comp -> setIndiceEnResultados($i);
					// $comp -> setInPadre($mag -> getIndiceEnResultados());
					// $resultados[] = $comp;
					// $i++;
				// }				
				// //$resultados = array_merge($resultados,$complmag);
			// }
			// else{
				// if(!empty($curso -> getComplementarias())){
					// $compl = $curso -> getComplementarias();
					// $curso -> setComplementarias(array());
					// $curso -> setIndiceEnResultados($i);
					// $curso -> setInPadre(null);
					// $resultados[] = $curso;
					// $i++;
// 					
					// foreach ($compl as $comp) {
						// $comp -> setIndiceEnResultados($i);
						// $comp -> setInPadre($curso -> getIndiceEnResultados());
						// $resultados[] = $comp;
						// $i++;
					// }
					// //$resultados = array_merge($resultados,$compl);
				// }
				// else{
					// $curso -> setIndiceEnResultados($i);
					// $curso -> setInPadre(null);
					// $resultados[] = $curso;
					// $i++;
				// }
			// }
		// }
		// return $resultados;
	// }
	
	/**
	 * Método que crea un arreglo de cursos sin ninguna particularidad a partir del resultado de una consulta
	 * hecha en oracle.
	 * @param $result -> resultado de la ejecución de la consulta.
	 * @return array() -> Arreglo de cursos. No es JSON ENCODE.
	 */
	private function crearArregloCursos($result)
	{
		$array = array();
		$i = 0;
		while($row = $this -> darSiguienteRegistroOracle(($result))){
			$curso = $this ->construirCursoDeArrAsoc($row);
			$curso -> setIndiceEnResultados($i);
			array_push($array,$curso);
			$i++;
		}
		
		return $array;
	}
	
	/**
	 * Crea un objeto de tipo ocurrencia dadas las horas de inicio y fin y el día de la semana
	 * El salon se asigna como pendiente debido a que no se puede acceder en la base de datos
	 * @param $begin_time hora de inicio
	 * @param $end_time hora de fin
	 * @param $dia de la semana perteneciente a {L,M,I,J,V,S,D}
	 * @return objeto de tipo ocurrencia
	 */
	private function crearOcurrencia($beginTime, $endTime, $dia, $fecha_ini, $fecha_fin){
		$ocur = new Ocurrencia();
		$ocur -> setHoraInicio($beginTime);
		$ocur -> setHoraFin($endTime);
		$ocur -> setDia($dia);
		$ocur -> setSalon("Pendiente");
		$ocur -> setFechaIni($fecha_ini);
		$ocur -> setFechaFin($fecha_fin);
		
		return $ocur;
	}
	
	/**
 	 * Función para limpiar una cadena de caracteres de código malicioso. Utilizada para limpiar user input.
 	 */
	function sanitizeString($var)
	{
		$var = strip_tags($var);
		$var = htmlentities($var);
		$var = stripslashes($var);
		return mysql_real_escape_string($var);
	}
	
	/**
	 * Inicializa la información de conexiones desde disco
	 */
	function initConections() {
		$file = fopen("../_data/infobd.csv", "r") or exit("No se pudo establecer la conexion");
		$info = array();
		if(!feof($file)) {
			 $info = explode(",", fgets($file));
		}
		fclose($file);
		
		$this -> dbhost_mysql = $info[0];
		$this -> dbname_mysql = $info[1];
		$this -> dbuser_mysql = $info[2];
		$this -> dbpass_mysql = $info[3];
		$this -> dbport_mysql = $info[4];
		
		$this -> dbhost_ora = $info[5];
		$this -> dbuser_ora = $info[6];
		$this -> dbpass_ora = $info[7];
		$this -> dbport_ora = $info[8];
		$this -> dbsid_ora = $info[9];				

	}

}
?>