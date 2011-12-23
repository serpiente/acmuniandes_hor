<?php
require_once 'utils.php';
foreach (glob("_classes/*.php") as $filename)
{
    require_once $filename;
}

//NOTA IMPORTANTE: echo es la manera de imprimir información al cliente web

session_start();
$dao = new Hor_Dao(); //instanciación del dao
$usuario = $_SESSION['usuario']; //tomando el valor del login del usuario que se encuentra guardado en la sesión, para ser usado para la consulta.
if (!isset($usuario)) {
	//Redirigir a la página de login
	redirigirLoginPage();
}


/**
 * Consulta los horarios del usuario que se encuentra loggeado para ser mostrados
 * @return echo arreglo de objetos de la clase Horario, json encoded
 */
function consultarHorariosPorUsuario() {
	//TODO

	//return echo del arreglo con objetos Horario, json encoded
}

/**
 * Crea un nuevo horario vacio asociado al usuario que lo solicitó
 * @param $nombre string indicando el nombre que el usuario le ha dado a ese horario
 * @return boolean indicando si el nueov horario fue creado exitosamente
 */
function crearNuevoHorario($nombre) {
	//TODO

	//return echo boolean
}

/**
 * Elimina un horario dado su identificador
 * @param $id_hor string indicando el identificador del horario a eliminar
 * @return boolean indicando si el horario fue eliminado exitosamente
 */
function eliminarHorario($id_hor) {
	//TODO

	//return echo boolean
}

/**
 * Guarda un horario asociado a un usuario de forma permanente
 * @param $horario objeto de tipo Horario, en formato json, que será guardado
 */
function guardarHorario($horario){
	//TODO
}


$tipo_solicitud = sanitizeString($_GET['tipsol']);
if (!isset($tipo_solicitud)) {
	//Condicion que implica que el parametro no fue recibio del cliente web a traves del metodo de HTTP
	throw new Exception("No se indico el tipo de solicitud", 1);
}


//Determina el tipo de solicitud hecha por el usuario
switch ($tipo_solicitud) {
	case TiposSolicitud::TipoHorarios :
		consultarHorariosPorUsuario();
		break;
	case TiposSolicitud::TipoCrearHorario :
		$nombre = sanitizeString($_GET['nomhor']);
		if (!isset($nombre)) {
			throw new Exception("No se indico el nombre del horario", 1);
		} else {
			crearNuevoHorario($nombre);
		}
		break;
	case TiposSolicitud::TipoElimHorario :
		$id_hor = sanitizeString($_GET['id_hor']);
		if (!isset($id_hor)) {
			throw new Exception("No se indico el id del horario a eliminar", 1);
		} else {
			eliminarHorario($id_hor);
		}
		break;
	case TiposSolicitud::TipoGuardarHorario:
		$horario_json = sanitizeString($_POST['horaro']);
		if (!isset($horario_json)) {
			//Condicion que implica que el parametro no fue recibio del cliente web a traves del metodo de HTTP
			throw new Exception("No se recibio el horario", 1);
		} else {
			guardarHorario($horario);
		}		
	default :
		throw new Exception("El tipo de solicitud no es valido", 1);
		break;
}
?>