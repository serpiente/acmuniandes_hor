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
function autenticar($usuario, $contrasenia){
	//TODO
	
	//iniciar sesion $_SESSION['usuario'] = $usuario
}

/**
 * Hace logout del usuario actual y redirecciona a la pagina de login
 */
function logout(){
	destroySession();
	//Redirigir a la página de login
	redirigirLoginPage();
}


$tipo_solicitud = sanitizeString($_GET['tipsol']);
if (!isset($tipo_solicitud)) {
	//Condicion que implica que el parametro no fue recibio del cliente web a traves del metodo de HTTP
	throw new Exception("No se indico el tipo de solicitud", 1);
}

//Determina el tipo de solicitud hecha por el usuario
switch ($tipo_solicitud) {
		
	case TiposSolicitud::TipoAutenticar:
		$usuario = sanitizeString($_POST['usuario']);
		if(!isset($usuario)){
			//Condicion que implica que el parametro no fue recibio del cliente web a traves del metodo de HTTP
			throw new Exception("No se indico el nombre de usuario", 1);	
		}
		$contrasenia = sanitizeString($_POST['contrasenia']);
		if(!isset($contrasenia)){
			//Condicion que implica que el parametro no fue recibio del cliente web a traves del metodo de HTTP
			throw new Exception("No se indico la contrasenia", 1);	
		}
		autenticar($usuario, $contrasenia);
		break;
	case TiposSolicitud::TipoLogout:
		logout();	
	default:
		throw new Exception("El tipo de solicitud no es valido", 1);
		break;
}


?>