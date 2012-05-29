<?php
// index.php

// load and initialize any global libraries
require_once '_php/controllers.php';

// route the request internally
$uri = $_SERVER['REQUEST_URI'];

if ($uri == '/acmuniandes_hor/index.php' || $uri == '/acmuniandes_hor/') {
	echo "$uri";
    //list_action();
} elseif ($uri == '/acmuniandes_hor/index.php/show') {
	echo "hurray!";
    //show_action($_GET['id']);
} else {
    header('Status: 404 Not Found');
    echo '<html><body><h1>Page Not Found</h1></body></html>';
}

?>