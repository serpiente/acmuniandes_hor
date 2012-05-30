<?php
require_once 'utils.php';
foreach (glob("_classes/*.php") as $filename){
	require_once $filename;
}

//NOTA IMPORTANTE: echo es la manera de imprimir información al cliente web

session_start();
$usuario = $_SESSION['usuario']; //tomando el valor del login del usuario que se encuentra guardado en la sesión, para ser usado para la consulta.
if (!isset($usuario)) {
	redirigirLoginPage(); 	//Redirigir a la página de login
}


/**
 * Consulta los horarios del usuario que se encuentra loggeado para ser listados
 * Estos horarios contienen todos sus atributos básicos, pero su arreglo de cursos se encuentra vacío
 * @return echo arreglo de objetos de la clase Horario, json encoded, sin los objetos Curso
 */
function consultarHorariosPorUsuario() {
	//TODO
	global $dao,$usuario; //Permite utilizar estas variables declaradas fuera de la funcion
	
	$result = $dao -> consultarHorariosPorUsuario($usuario);
	
	if($result==null){
		echo FALSE;
	}
	else{
		echo $result;
	}
	//return echo del arreglo con objetos Horario, json encoded
}

/**
 * Crea un nuevo horario vacio asociado al usuario que lo solicitó
 * @param $nombre string indicando el nombre que el usuario le ha dado a ese horario
 * @return echo boolean indicando si el nuevo horario fue creado exitosamente
 */
function crearNuevoHorario($nombre) {
	//TODO REVISION
	global $dao,$usuario; //Permite utilizar estas variables declaradas fuera de la funcion
	
	$horario = new Horario;
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
 * Asigna en la sesión del usuario el id del horario que desea abrir
 * y redirige a la página de horario
 * @param $id_hor el id del horario que se desea abrir.
 */
function asignarHorarioAbrir($id_hor){
	global $dao;
	$_SESSION['hor_abrir'] = $id_hor;
	header("Location: /acmuniandes_hor/hor_coredisp.html");
}

/**
 * Retorna al cliente el horario que se desea abrir para ser visualizado
 * @return echo de un objeto Horario completo con todos sus cursos, json encoded. Este corresponde al horario que se desea abrir.
 */
function abrirHorario(){
	global $dao; //Permite utilizar estas variables declaradas fuera de la funcion
	$horario = $dao -> consultarHorarioPorId($_SESSION['hor_abrir']);
	
	if($horario != null){
		echo $horario;
	}
	else{
		echo FALSE;
	}
}

/**
 * Elimina un horario dado su identificador
 * @param $id_hor string indicando el identificador del horario a eliminar
 * @return echo boolean indicando si el horario fue eliminado exitosamente
 */
function eliminarHorario($id_hor) {
	//TODO REVISION
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
 * @return echo boolean indicando si el horario fue eliminado exitosamente
 */
function guardarHorario($horario){
	//TODO
	global $dao,$usuario; //Permite utilizar estas variables declaradas fuera de la funcion
	
	try{
		$horobj = new Horario($horario);
		$dao -> actualizarHorario($horobj);
		echo TRUE;
	} catch(Exception $e){
		echo FALSE;
		echo $e -> getMessage();
	}
}


$tipo_solicitud = $dao -> sanitizeString($_POST['tipsol']);
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
		$nombre = $dao -> sanitizeString($_POST['nomhor']);
		if (!isset($nombre)) {
			throw new Exception("No se indico el nombre del horario");
		} else {
			crearNuevoHorario($nombre);
		}
		break;
	case TiposSolicitud::TipoElimHorario :
		$id_hor = $dao -> sanitizeString($_POST['id_hor']);
		if (!isset($id_hor)) {
			throw new Exception("No se indico el id del horario a eliminar");
		} else {
			eliminarHorario($id_hor);
		}
		break;
	case TiposSolicitud::TipoGuardarHorario:
		$horario_json = $_POST['horario'];
		if (!isset($horario_json)) {
			//Condicion que implica que el parametro no fue recibio del cliente web a traves del metodo de HTTP
			throw new Exception("No se recibio el horario");
		} else {
			guardarHorario($horario_json);
		}
		break;
	case TiposSolicitud::TipoAsignarHorarioAbrir:
		$id_hor = $dao -> sanitizeString($_POST['id_hor']);
		if (!isset($id_hor)) {
			//Condicion que implica que el parametro no fue recibio del cliente web a traves del metodo de HTTP
			throw new Exception("No se indico el id del horario a eliminar");
		} else {
			asignarHorarioAbrir($id_hor);
		}
		break;
	case TiposSolicitud::TipoAbrirHorario:
		abrirHorario();
		break;
	default :
		throw new Exception("El tipo de solicitud no es valido");
		break;
}
?>