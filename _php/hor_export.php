<?php
require_once 'utils.php';
require_once "_lib/src/apiClient.php";
require_once "_lib/src/contrib/apiCalendarService.php";
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


/////////////UTILS FORMATOS DE FECHA GOOGLECAL Y ICAL///////////////

/**
 * Retorna un arreglo asociativo con dos(2) strings que representan las fechas de inicio y fin de una ocurrencia en formato Google Calendar
 * @param ocur objeto de tipo Ocurrencia
 * @return arreglo asociativo conteniendo las fechas de inicio y fin en formato Google Calendar. Las posiciones del arreglo son 'ini' y 'fin'
 */
function darFechasGoogleCal($ocur){
	if($ocur instanceof Ocurrencia){
		$dia = $ocur -> getDia();
		$ini = $ocur -> getHoraInicio();
		$fin = $ocur -> getHoraFin();
		//Hardcoded for now
		$semana = array('L' =>"2012-07-30", 'M' =>"2012-07-31",'I' =>"2012-08-01",'J' =>"2012-08-02",'V' =>"2012-08-03",'S' =>"2012-08-04");
		$fechas = array();
		$fechas['ini']=${semana}[$dia].'T'.${ini}.'.000';
		$fechas['fin']=${semana}[$dia].'T'.${fin}.'.000';
		
		return $fechas;
		
	}else{
		throw new Exception("El parametro no es una ocurrencia");
	}
}

/**
 * Retorna un arreglo asociativo con dos(2) strings que representan las fechas de inicio y fin de una ocurrencia en formato Google Calendar
 * @param ocur objeto de tipo Ocurrencia
 * @return arreglo asociativo conteniendo las fechas de inicio y fin en formato Google Calendar. Las posiciones del arreglo son 'ini' y 'fin'
 */
function darFechasICal($ocur){
	if($ocur instanceof Ocurrencia){
		$dia = $ocur -> getDia();
		$ini = $ocur -> getHoraInicio();
		$fin = $ocur -> getHoraFin();
		//Hardcoded for now
		$semana = array('L' =>"20120730", 'M' =>"20120731",'I' =>"20120801",'J' =>"20120802",'V' =>"20120803",'S' =>"20120804");
		$fechas = array();
		$ini = str_replace(':', "");
		$fin = str_replace(':', "");
		$fechas['ini']=${semana}[$dia].'T'.${ini}.'00';
		$fechas['fin']=${semana}[$dia].'T'.${fin}.'00';
		
		return $fechas;
		
	}else{
		throw new Exception("El parametro no es una ocurrencia");
	}
}

//////////////////////////////////////



/**
 * Exporta los horarios a formato de texto dado un objeto de tipo Horario en formato json
 * @param $horario objeto de tipo horario en formato json que contiene la informacion del horario a exportar
 */
function exportarCRNSHorario($horario){
	//TODO
	//Aca se debe investigar sobre la forma de enviar el archivo generado al usuario en el cliente web
	
}

/**
 * Exporta un horario, dado un objeto de tipo Horario en formato json, a formato Goodle Calendar
 * @param $horario objeto de tipo horario en formato json que contiene la informacion del horario a exportar
 */
function exportarHorarioAFormatoGoogleCal($horario){
	//TODO
	//Aca se debe investigar sobre la forma de enviar el archivo generado al usuario en el cliente web
	
	$miHorario = new Horario($horario);
	//Mi codigo empieza con session_start() que no se pone aca ;
	$apiClient = new apiClient();
	$apiClient->setUseObjects(true);
	$service=new apiCalendarService($apiClient);
	if(isset($_SESSION['oauth_access_token'])){
		$apiClient->setAccessToken($_SESSION['oauth_access_token']);
	}else{
		$token =  $apiClient->authenticate();
		$_SESSION['oauth_access_token']=$token;
	}

	$cursos = $miHorario->getCursos();
	foreach ($cursos as $curso) {
		$nombreCurso = $curso->getNombre();
		$ocurrencias = $curso->getOcurrencias();
		foreach ($ocurrencias as $ocurrencia) {
			$horaInicio = $ocurrencia->getHoraInicio();
			$horaFin = $ocurrencia->getHoraFin();
			
			$event = new Event();
			$event->setSummary($nombreCurso);
			// $event->setLocation('Somewhere');
			$start = new EventDateTime();
			$start->setDateTime('2012-01-12T10:00:00.000-05:00');
			$event->setStart($start);
			$end = new EventDateTime();
			$end->setDateTime('2012-01-12T10:25:00.000-05:00');
			$event->setEnd($end);
			$createdEvent = $service->events->insert('primary',$event);
		}
	}
}

/**
 * Exporta un horario, dado un objeto de tipo Horario en formato json, a formato iCal
 * @param $horario objeto de tipo horario en formato json que contiene la informacion del horario a exportar
 */
function exportarHorarioAFormatoICal($horario){
	//TODO
	//Aca se debe investigar sobre la forma de enviar el archivo generado al usuario en el cliente web
	
	header("Content-Type: text/Calendar");
	header("Content-Disposition: inline; filename=filename.ics");//Modificar nombre
	echo "BEGIN:VCALENDAR\n";
	echo "METHOD:PUBLISH\n";
	echo "VERSION:2.0\n";
	echo "PRODID:-//Apple Inc.//iCal 5.0.1\n";
	echo "X-APPLE-CALENDAR-COLOR:#0E61B9\n";
	echo "X-WR-TIMEZONE:America/Bogota\n";
	echo "CALSCALE:GREGORIAN\n";
	echo "BEGIN:VTIMEZONE\n";
	echo "TZID:America/Bogota\n";
	echo "BEGIN:DAYLIGHT\n";
	echo "TZOFFSETFROM:-0500\n";
	echo "DTSTART:19920503T000000\n";
	echo "TZNAME:COT\n";
	echo "TZOFFSETTO:-0400\n";
	echo "RDATE:19920503T000000\n";
	echo "END:DAYLIGHT\n";
	echo "BEGIN:STANDARD\n";
	echo "TZOFFSETFROM:-0400\n";
	echo "DTSTART:19930404T000000\n";
	echo "TZNAME:COT\n";
	echo "TZOFFSETTO:-0500\n";
	echo "RDATE:19930404T000000\n";
	echo "END:STANDARD\n";
	echo "END:VTIMEZONE\n";
	echo "BEGIN:VEVENT\n";
	echo "CLASS:PUBLIC\n";
	//current date echo
	echo "CREATED:20120115T201454Z\n"; //Cambiar por la date del dia o cualquier cosa
	
	$cursos = $miHorario->getCursos();
	foreach ($cursos as $curso) {
		$nombreCurso = $curso->getNombre();
		$ocurrencias = $curso->getOcurrencias();
		foreach ($ocurrencias as $ocurrencia) {
			$horaInicio = $ocurrencia->getHoraInicio();
			$horaFin = $ocurrencia->getHoraFin();
			echo "DESCRIPTION:Evento nuevo\\n\\n\\nbla bla bla\\n\\nbla bla vla\n";
			echo "DTEND;TZID=America/Bogota:20120115T180000\n";//Revisar esta fecha
			echo "RRULE:FREQ=WEEKLY;INTERVAL=1;UNTIL=20121011T000000Z;BYDAY=MO,TU,WE,TH,FR,SA,SU;WKST=MO\n";//Revisar ocurrencias y eso
			echo "TRANSP:OPAQUE\n";
			echo "SUMMARY:Evento\n";
			echo "DTSTART;TZID=America/Bogota:20120115T170000\n";
			echo "DTSTAMP:20120115T201641Z\n";
			echo "SEQUENCE:0\n";
			echo "END:VEVENT\n";
		}
	}
	echo "END:VCALENDAR\n";
}

/**
 * Exporta un horario, dado un objeto de tipo Horario en formato json, a formato PDF
 * @param $horario objeto de tipo horario en formato json que contiene la informacion del horario a exportar
 */
function exportarHorarioAFormatoPDF($horario){
	//TODO
	//Aca se debe investigar sobre la forma de enviar el archivo generado al usuario en el cliente web
		
}


$horario_json = $dao -> sanitizeString($_POST['horario']);
if (!isset($horario_json)) {
	//Condicion que implica que el parametro no fue recibio del cliente web a traves del metodo de HTTP
	throw new Exception("No se recibio el horario");
}

$tipo_exportacion = $dao -> sanitizeString($_POST['tipexp']);
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