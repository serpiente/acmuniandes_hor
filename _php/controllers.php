<?php

function showLogin($aut){
	
	$css = '<link href="/acmuniandes_hor/_css/login-box.css" rel="stylesheet" type="text/css" />';
	$autenticacion = '';
	if($aut){
		$autenticacion = '<br /><p style="margin-left:30px;color: red;">Su usuario o clave son incorrectos. Por favor intente de nuevo.</p>';
	}
	include '_templates/login.php';
}

function showAdmin(){
	include '_templates/admin.php';
}

function showHorario(){
	include '_templates/horariopg.php';
}
?>