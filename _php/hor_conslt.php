<?php
require_once 'utils.php';
foreach (glob("_classes/*.php") as $filename) {
	require_once $filename;
}

//NOTA IMPORTANTE: echo es la manera de imprimir información al cliente web

session_start();
if (!isset($_SESSION['usuario'])) {
	redirigirLoginPage(); //Redirigir a la página de login
}
$dao = new Hor_Dao(); //instanciación del dao

/**
 * Consulta cursos dado el nombre de un profesor
 * @param $profesor string indicando el nombre del profesor
 * @param $cbuflag boolean indicando si se busca un cbu
 * @return echo arreglo de objetos de la clase Curso, json encoded
 */
function consultarCursosPorNombreProfesor($profesor, $cbuflag) {
	//TODO
	global $dao; //Permite utilizar esta variable declarada fuera de la funcion

	try {
		echo $dao -> consultarCursosPorNombreProfesor($profesor, $cbuflag);
	} catch(Exception $e) {
		echo $e -> getMessage();
	}
}

/**
 * Consulta cursos dado el nombre del curso
 * @param $curso string indicando el nombre del curso
 * @param $cbuflag boolean indicando si se busca un cbu
 * @return echo arreglo de objetos de la clase Curso, json encoded
 */
function consultarCursosPorNombreCurso($curso, $cbuflag) {
	//TODO
	global $dao; //Permite utilizar esta variable declarada fuera de la funcion

	try {
		echo $dao -> consultarCursosPorNombreCurso($curso, $cbuflag);
	} catch(Exception $e) {
		echo $e -> getMessage();
	}
}

/**
 * Consulta cursos dado el nombre del departamento
 * @param $depto string indicando el nombre del departamento
 * @param $cbuflag boolean indicando si se busca un cbu
 * @return echo arreglo de objetos de la clase Curso, json encoded
 */
function consultarCursosPorNombreDepartamento($depto, $cbuflag) {
	//TODO
	global $dao; //Permite utilizar esta variable declarada fuera de la funcion

	try {
		echo $dao -> consultarCursosPorNombreDepartamento($depto, $cbuflag);
	} catch(Exception $e) {
		echo $e -> getMessage();
	}
	//echo del arreglo con objetos Curso, json encoded
}

/**
 * Consulta cursos dado el crn del curso
 * @param $crn string indicando el crn del curso
 * @return echo arreglo de objetos de la clase Curso, json encoded
 */
function consultarCursosPorCRN($crn) {
	//TODO
	global $dao; //Permite utilizar esta variable declarada fuera de la funcion

	//echo del arreglo con objetos Curso, json encoded
}

/**
 * Consulta cursos dado el código del curso
 * @param $cod string indicando el codigo del curso
 * @return echo arreglo de objetos de la clase Curso, json encoded
 */
function consultarCursosPorCodigoCurso($cod) {
	//TODO
	global $dao; //Permite utilizar esta variable declarada fuera de la funcion

	//echo del arreglo con objetos Curso, json encoded
}

/**
 * Consulta cursos dados un conjunto de días y un conjunto de horas específicas.
 * @param $cbuflag boolean indicando si se busca un cbu
 * @param $dias arreglo de caracteres indicando los días buscados
 * @param $horas arreglo de caracteres indicando las horas buscadas
 * @return echo arreglo de objetos de la clase Curso, json encoded
 */
function consultarCursosPorDiasHoras($dias, $horas, $cbuflag) {
	//TODO
	global $dao; //Permite utilizar esta variable declarada fuera de la funcion

	//echo del arreglo con objetos Curso, json encoded
}

/**
 * Consulta cursos dado el nombre del curso
 * @param $tipo string indicando el tipo del CBU (tipo A o tipo B)
 * @return echo arreglo de objetos de la clase Curso, json encoded
 */
function consultarCursosPorCBU($tipo) {
	//TODO
	global $dao; //Permite utilizar esta variable declarada fuera de la funcion

	try {
		echo $dao -> consultarCursosPorCBU($tipo);
	} catch(Exception $e) {
		echo $e -> getMessage();
	}
	//echo del arreglo con objetos Curso, json encoded
}

/**
 * Procesa la entrada del usuario y hace una búsqueda sobre todos los criterios de búsqueda posibles.
 * Retorna el conjunto de cursos encontrados bajo cualquier criterio de búsqueda utilizando la entrada del usuario
 * (i.e.) Si la entrada del usuario es 'ingenieria' debe retornar todos los cursos que tengan 'ingenieria' en el nombre del curso,
 * en el nombre del profesor, en el nombre del departamento, en el crn o en el código del curso.
 * @param $valor_consulta string indicando la entrada del usuario en la GUI
 * @param $cbuflag boolean indicando si se busca un cbu
 * @return echo 1(UN) arreglo de objetos de la clase Curso, json encoded
 */
function procesarConsulta($valor_consulta, $cbuflag) {
	//TODO
	global $dao; //Permite utilizar esta variable declarada fuera de la funcion

	//echo del arreglo con objetos Curso, json encoded
}

$valor_consulta = sanitizeString($_GET['valcon']);
if (!isset($valor_consulta)) {
	//Condicion que implica que el parametro no fue recibio del cliente web a traves del metodo de HTTP
	throw new Exception("No existe entrada de usuario");
}
$cbuflag = sanitizeString($_GET['cbuflag']);
if (!isset($cbuflag)) {
	//Condicion que implica que el parametro no fue recibio del cliente web a traves del metodo de HTTP
	throw new Exception("No existe indicador de cbu");
}

if (isset($_GET['tipcon'])) {
	//Esta condición implica que el usuario eligió un tipo específico de consulta
	//(Varios campos de busqueda)

	$tipo_consulta = sanitizeString($_GET['tipcon']);

	//Determina el tipo de consulta elegido por el usuario
	switch ($tipo_consulta) {
		case TiposConsulta::PorCBU :
			consultarCursosPorCBU($valor_consulta);
			break;
		case TiposConsulta::PorCRN :
			consultarCursosPorCRN($valor_consulta);
			break;
		case TiposConsulta::PorCod :
			consultarCursosPorCodigoCurso($valor_consulta);
			break;
		case TiposConsulta::PorCurso :
			consultarCursosPorNombreCurso($valor_consulta, $cbuflag);
			break;
		case TiposConsulta::PorDepto :
			consultarCursosPorNombreDepartamento($valor_consulta, $cbuflag);
			break;
		case TiposConsulta::PorDiasHor :
			$diasyhoras = explode(';', $valor_consulta);
			$dias = explode(',', $diasyhoras[0]);
			$horas = explode(',', $diasyhoras[1]);
			consultarCursosPorDiasHoras($dias, $horas, $cbuflag);
			break;
		case TiposConsulta::PorProfesor :
			consultarCursosPorNombreProfesor($valor_consulta, $cbuflag);
			break;
		case TiposConsulta::PorUsuario :
			consultarHorariosPorUsuario();
			break;
		default :
			throw new Exception("El tipo de consulta no es valido");
			break;
	}
} else {
	//De lo contrario implica que el usuario quiere hacer una consulta bajo cualquier criterio de búsqueda
	//(Un solo campo de búsqueda en la interfaz)
	procesarConsulta($valor_consulta, $cbuflag);
}
?>