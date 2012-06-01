<?php
session_start();
if (!isset($_SESSION['usuario'])) {
	header("Location: /acmuniandes_hor/");
}
?>
<!--
Copyright Capítulo Estudiantil ACM Universidad de los Andes
Creado y desarrollado por Capitulo Estudiantil ACM Universidad de los Andes. Juan Tejada y Jorge Lopez.
-->
<!DOCTYPE html>
<html>
	<head>
		<title>HorarioLab</title>
		<link rel="icon" type="image/png" href="/acmuniandes_hor/_images/acm_sym.png">
		<link rel='stylesheet' type='text/css' href='/acmuniandes_hor/_css/jquery-ui-1.8.11.custom.css' />
		<link rel="stylesheet" type="text/css" href="/acmuniandes_hor/_css/hor_admin.css" />
		<script type="text/javascript" src="/acmuniandes_hor/_js/_lib/jquery-1.6.2.js"></script>
		<script type="text/javascript" src="/acmuniandes_hor/_js/_lib/jquery-ui-1.8.14.custom.min.js" ></script>
		<script type="text/javascript" src="/acmuniandes_hor/_js/hor_admin.js"></script>
	</head>
	<body>
		<div id="dialogConf" ></div>
		<div id="container">
			<div id="header">
				<h1> HorarioLab </h1>
			</div>
			<div id="content">
				<h2> Mis Horarios </h2>
				<div id="horcontent">
					<div id="horarios1" align="center" class="content">
						
					</div>
				</div>
				<div id="agregar" class="content">
					<input type="text" id="inputText" value="nombre su nuevo horario"/>
					<button id="saveButton" class="boton">Guardar Nuevo Horario</button>
					<span id="msgError">El nombre debe ser menor a 8 caracteres</span>
					<button id="addButton" class="boton" style="font-size: 20px">+</button>
				</div>
				<div id="logout" class="content">
					<button id="buttonLogout" class="boton">Logout</button>
				</div>
			</div>
			<div id="footer">
				<p style="font-size:10px;">
					Creado y desarrollado por Capitulo Estudiantil ACM Universidad de los Andes.
					<br />
					Liderado por Juan Tejada y Jorge Lopez
				</p>
			</div>
		</div>
		
	</body>
</html>