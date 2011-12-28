<?php
require_once 'utils.php';
foreach (glob("_classes/*.php") as $filename)
{
    require_once $filename;
}

//NOTA IMPORTANTE: echo es la manera de imprimir información al cliente web

session_start();
$usuario = $_SESSION['usuario']; //tomando el valor del login del usuario que se encuentra guardado en la sesión, para ser usado para la consulta.
if (!isset($usuario)) {
	redirigirLoginPage(); 	//Redirigir a la página de login
}
$dao = new Hor_Dao(); //instanciación del dao


/**
 * Consulta los horarios del usuario que se encuentra loggeado para ser mostrados
 * @return echo arreglo de objetos de la clase Horario, json encoded
 */
function consultarHorariosPorUsuario() {
	//TODO
	global $dao,$usuario; //Permite utilizar estas variables declaradas fuera de la funcion
	

	//return echo del arreglo con objetos Horario, json encoded
}

/**
 * Crea un nuevo horario vacio asociado al usuario que lo solicitó
 * @param $nombre string indicando el nombre que el usuario le ha dado a ese horario
 * @return boolean indicando si el nuevo horario fue creado exitosamente
 */
function crearNuevoHorario($nombre) {
	//TODO REVISION
	global $dao,$usuario; //Permite utilizar estas variables declaradas fuera de la funcion
	
	$horario = new Horario();
	$horario -> setUsuario($usuario);
	$horario -> setCreditosTotales(0);
	$horario -> setNumCursos(0);
	$horario -> setNombre($nombre);
	
	try{
		$dao -> persistirHorario($horario);
		echo TRUE;
	} catch(Exception $e){
		echo FALSE;
		echo $e -> getMessage();
	}
	//return echo boolean
}

/**
 * Elimina un horario dado su identificador
 * @param $id_hor string indicando el identificador del horario a eliminar
 * @return boolean indicando si el horario fue eliminado exitosamente
 */
function eliminarHorario($id_hor) {
	//TODO
	global $dao; //Permite utilizar estas variables declaradas fuera de la funcion
	
	try{
		$dao -> eliminarHorario($id_hor);
		echo TRUE;
	} catch(Exception $e){
		echo FALSE;
		echo $e -> getMessage();
	}
	//return echo boolean
}

/**
 * Guarda un horario asociado a un usuario de forma permanente. Se asume que el horario ya existe en la base de datos.
 * @param $horario objeto de tipo Horario, en formato json, que será guardado
 */
function guardarHorario($horario){
	//TODO
	global $dao,$usuario; //Permite utilizar estas variables declaradas fuera de la funcion

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
			throw new Exception("No se indico el nombre del horario");
		} else {
			crearNuevoHorario($nombre);
		}
		break;
	case TiposSolicitud::TipoElimHorario :
		$id_hor = sanitizeString($_GET['id_hor']);
		if (!isset($id_hor)) {
			throw new Exception("No se indico el id del horario a eliminar");
		} else {
			eliminarHorario($id_hor);
		}
		break;
	case TiposSolicitud::TipoGuardarHorario:
		$horario_json = sanitizeString($_POST['horaro']);
		if (!isset($horario_json)) {
			//Condicion que implica que el parametro no fue recibio del cliente web a traves del metodo de HTTP
			throw new Exception("No se recibio el horario");
		} else {
			guardarHorario($horario);
		}		
	default :
		throw new Exception("El tipo de solicitud no es valido");
		break;
}
?>