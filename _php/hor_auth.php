<?php
require_once 'utils.php';
/**
 * Autentica a un usuario dados su login y su contraseña
 * Utiliza el LDAP
 * Una vez autenticado debe iniciar la sesión del usuario con $_SESSION['usuario']
 * Se debe encargar ademas de redirigir a la página principal de horarios una vez autenticado el usuario
 * @param $usuario string indicando nombre de usuario o login
 * @param $contrasenia string indicando la contraseña del usuario
 */
function autenticar($usuario, $contrasenia) {
	
	//Se inicia la sesión
	session_start();

	// conexión al servidor LDAP
	$ldapconn = ldap_connect("ldap.example.com") or die("Could not connect to LDAP server.");

	if ($ldapconn) {

		// realizando la autenticación
		//TODO
		$ldapbind = ldap_bind($ldapconn, $usuario, $contrasenia);

		// verificación del enlace
		if ($ldapbind) {
			//Guarda el nombre de usuario en la variable de sesión
			$_SESSION['usuario'] = $usuario;
			//redirigue a la página principal
			header("Location: /hor_cordisp.html");
		} else {
			//en caso de que la autenticación falle se devuelve a la página inicial
			header("Location: /index.html");
		}
	}
}

/**
 * Hace logout del usuario actual y redirecciona a la pagina de login
 */
function logout() {
	//TODO
	destroySession();
	redirigirLoginPage(); //Redirigir a la página de login
}

$tipo_solicitud = sanitizeString($_GET['tipsol']);
if (!isset($tipo_solicitud)) {
	//Condicion que implica que el parametro no fue recibio del cliente web a traves del metodo de HTTP
	throw new Exception("No se indico el tipo de solicitud");
}

//Determina el tipo de solicitud hecha por el usuario
switch ($tipo_solicitud) {

	case TiposSolicitud::TipoAutenticar :
		$usuario = sanitizeString($_POST['usuario']);
		if (!isset($usuario)) {
			//Condicion que implica que el parametro no fue recibio del cliente web a traves del metodo de HTTP
			throw new Exception("No se indico el nombre de usuario");
		}
		$contrasenia = sanitizeString($_POST['contrasenia']);
		if (!isset($contrasenia)) {
			//Condicion que implica que el parametro no fue recibio del cliente web a traves del metodo de HTTP
			throw new Exception("No se indico la contrasenia");
		}
		autenticar($usuario, $contrasenia);
		break;
	case TiposSolicitud::TipoLogout :
		logout();
	default :
		throw new Exception("El tipo de solicitud no es valido");
		break;
}
?>