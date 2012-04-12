<?php

/**
 * Listado de constantes de tipo de consultas
 */
class TiposConsulta {	
	const PorUsuario = '0';
	const PorProfesor = '1';
	const PorCurso = '2';
	const PorDepto = '3';
	const PorCRN = '4';
	const PorCod = '5';
	const PorDiasHor = '6';
	const PorCBU = '7';
}
 /**
  * Listado de constantes de tipo de exporatcion
  */
class TiposExportacion {
	const TipoGoogleCal = '0';
	const TipoICal = '1';
	const TipoPDF = '2';
	const TipoCRNS = '3';
}
/**
 * Listado de constantes de tipo de solicitud de usuario
 */
class TiposSolicitud {
	const TipoHorarios = '0';
	const TipoCrearHorario = '1';
	const TipoElimHorario = '2';
	const TipoAutenticar = '3';
	const TipoLogout = '4';
	const TipoGuardarHorario = '5';
	const TipoAsignarHorarioAbrir = '6;';
	const TipoAbrirHorario = '7';
}

/**
 * Función utlizada para destruir la session de un usuario
 */
function destroySession()
{
	session_start();
	session_unset(); 
	session_destroy();
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
 * Dado un arreglo que contiene arreglos asociativos los cuales contienen los valores de atributos para un objeto,
 * y dado el nombre del objeto a construir, la funcion pobla el arreglo original con objetos del tipo especificado reemplazandolos
 * por los arreglos asociativos que se encontraban ahi inicialmente.
 * @param $arr arreglo que contiene arreglos asociativos a ser reemplazados por objetos del tipo especificado con los valores de los arreglos asoicativos
 * @param $nombreobj string que indica el nombre de la clase de los objetos a crear
 */
function poblarArregloObjetos($arr, $nombreobj) {
		for ($i = 0; $i < sizeof($arr); $i++) {
			$obj = $arr[$i];
			$sub = new ${nombreobj};
			$sub -> set($obj);
			$arr[$i] = $sub;
		}
	}

/**
 * Redirige al usuario a la página de login
 */
function redirigirLoginPage(){
	echo json_encode(array('redirect' => '/acmuniandes_hor/'));
	//header("Location: /acmuniandes_hor/index.html");
	exit;
}
?>