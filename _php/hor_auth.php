<?php
/**
 * Copyright Capítulo Estudiantil ACM Universidad de los Andes
 * Creado y desarrollado por Capitulo Estudiantil ACM Universidad de los Andes. Liderado por Juan Tejada y Jorge Lopez.
 */

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
	global $dao;
	//Se inicia la sesión
	session_start();

	$ldapconn = ldap_connect("ldap.uniandes.edu.co", "389") or die("Could not connect to LDAP server.");

	if (ldap_bind($ldapconn)) {

		$busqueda = "(uid=" . trim($usuario) . ")";

		$sr = ldap_search($ldapconn, "ou=people, dc=uniandes,dc=edu,dc=co", $busqueda);
		$info = ldap_get_entries($ldapconn, $sr);
		$dist_name = $info[0]["dn"];

		if (strlen($dist_name) > 0) {
			if (ldap_bind($ldapconn, $dist_name, $contrasenia)) {
				//Guarda el nombre de usuario en la variable de sesión
				$_SESSION['usuario'] = $usuario;
				$dao -> persistirUsuario($usuario);
				//Redirige a la pagina correspondiente en caso exitoso
				header("Location: /acmuniandes_hor/hor_admin.html");

				ldap_close($ds);
			} else {
				//Redirigue a la pagina de error en caso contrario
				header("Location: /acmuniandes_hor/index2.html");
			}

		} else {
			//Redirigue a la pagina de error en caso contrario
			header("Location: /acmuniandes_hor/index2.html");
		}

	}
}

/**
 * Hace logout del usuario actual y redirecciona a la pagina de login
 */
function logout() {
	//TODO
	destroySession();
	header("Location: /acmuniandes_hor/");
	//redirigirLoginPage();
	//Redirigir a la página de login
}

$tipo_solicitud = $dao -> sanitizeString($_POST['tipsol']);
if (!isset($tipo_solicitud)) {
	//Condicion que implica que el parametro no fue recibio del cliente web a traves del metodo de HTTP
	throw new Exception("No se indico el tipo de solicitud");
}

//Determina el tipo de solicitud hecha por el usuario
switch ($tipo_solicitud) {

	case TiposSolicitud::TipoAutenticar :
		$usuario = $dao -> sanitizeString($_POST['usuario']);
		if (!isset($usuario)) {
			//Condicion que implica que el parametro no fue recibio del cliente web a traves del metodo de HTTP
			throw new Exception("No se indico el nombre de usuario");
		}
		$contrasenia = $dao -> sanitizeString($_POST['contrasenia']);
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