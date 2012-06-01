<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once '_php/controllers.php';


// route the request internally
$uri = $_SERVER['REQUEST_URI'];
if ($uri == '/acmuniandes_hor/index.php' || $uri == '/acmuniandes_hor/') {
	showLogin(false);
} elseif ($uri == '/acmuniandes_hor/index.php/invalid') {
	showLogin(true);
} elseif ($uri == '/acmuniandes_hor/index.php/admin') {
	showAdmin();
} elseif ($uri == '/acmuniandes_hor/index.php/horario') {
	showHorario();
} else {
    header('Status: 404 Not Found');
    echo '<html><body><h1>Page Not Found</h1></body></html>';
}

?>