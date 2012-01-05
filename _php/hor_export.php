<?php
require_once 'utils.php';
foreach (glob("_classes/*.php") as $filename){
    require_once $filename;
}

//NOTA IMPORTANTE: echo es la manera de imprimir información al cliente web
//NOTA IMPORTANTE: json_decode(): funcion para transformar un objeto json a un arreglo asociativo de PHP

session_start();
$usuario = $_SESSION['usuario']; //tomando el valor del login del usuario que se encuentra guardado en la sesión, para ser usado para la consulta.
if (!isset($usuario)) {
	//Redirigir a la página de login
	redirigirLoginPage();
}
$dao = new Hor_Dao(); //instanciación del dao

/**
 * Exporta los horarios a formato de texto dado un objeto de tipo Horario en formato json
 * @param $horario objeto de tipo horario en formato json que contiene la informacion del horario a exportar
 */
function exportarCRNSHorario($horario){
	//TODO
	//Aca se debe investigar sobre la forma de enviar el archivo generado al usuario en el cliente web
	global $dao,$usuario; //Permite utilizar estas variables declaradas fuera de la funcion
}

/**
 * Exporta un horario, dado un objeto de tipo Horario en formato json, a formato Goodle Calendar
 * @param $horario objeto de tipo horario en formato json que contiene la informacion del horario a exportar
 */
function exportarHorarioAFormatoGoogleCal($horario){
	//TODO
	//Aca se debe investigar sobre la forma de enviar el archivo generado al usuario en el cliente web
	global $dao,$usuario; //Permite utilizar estas variables declaradas fuera de la funcion
	
}

/**
 * Exporta un horario, dado un objeto de tipo Horario en formato json, a formato iCal
 * @param $horario objeto de tipo horario en formato json que contiene la informacion del horario a exportar
 */
function exportarHorarioAFormatoICal($horario){
	//TODO
	//Aca se debe investigar sobre la forma de enviar el archivo generado al usuario en el cliente web
	global $dao,$usuario; //Permite utilizar estas variables declaradas fuera de la funcion
	
}

/**
 * Exporta un horario, dado un objeto de tipo Horario en formato json, a formato PDF
 * @param $horario objeto de tipo horario en formato json que contiene la informacion del horario a exportar
 */
function exportarHorarioAFormatoPDF($horario){
	//TODO
	//Aca se debe investigar sobre la forma de enviar el archivo generado al usuario en el cliente web
	global $dao,$usuario; //Permite utilizar estas variables declaradas fuera de la funcion
	
}


$horario_json = sanitizeString($_POST['horaro']);
if (!isset($horario_json)) {
	//Condicion que implica que el parametro no fue recibio del cliente web a traves del metodo de HTTP
	throw new Exception("No se recibio el horario");
}

$tipo_exportacion = sanitizeString($_POST['tipexp']);
if (!isset($tipo_exportacion)) {
	//Condicion que implica que el parametro no fue recibio del cliente web a traves del metodo de HTTP
	throw new Exception("No se indico el tipo de exportacion");
}

//Determina el tipo de exportacion elegida por el usuario
switch ($tipo_exportacion) {
	case TiposExportacion::TipoGoogleCal:
		exportarHorarioAFormatoGoogleCal($horario_json);
		break;
	case TiposExportacion::TipoICal:
		exportarHorarioAFormatoICal($horario_json);
		break;
	case TiposExportacion::TipoPDF:
		exportarHorarioAFormatoPDF($horario_json);
		break;	
	case TiposExportacion::TipoCRNS:
		eexportarCRNSHorario($horario_json);
		break;
	default:
		throw new Exception("El tipo de exportacion no es valido");
		break;
}

?>