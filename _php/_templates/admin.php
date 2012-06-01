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
<html xmlns="http://www.w3.org/1999/xhtml" >
	<head>
		<style>
			/* Crea el estilo de los cuadros que contienen la información relevante de cada horario */
			/*p {
				font-weight: bold;
				background-color: #fcd;
				display: none;
				height: 100px;
				width: 1055px;
				margin: 10px;
			}*/
		</style>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
		<title>HorarioLab</title>
		<link rel="stylesheet" type="text/css" href="/acmuniandes_hor/_css/hor_admin.css" />
		<link rel="stylesheet" type="text/css" href="/acmuniandes_hor/_css/tip-twitter.css" />
		<script type="text/javascript" src="/acmuniandes_hor/_js/_lib/jquery-1.6.2.js"></script>
		<script type="text/javascript" src="/acmuniandes_hor/_js/_lib/jquery.poshytip.min.js"></script>
		<script type="text/javascript" src="/acmuniandes_hor/_js/hor_admin.js"></script>
	</head>
	<body>
		<!-- Tabla que organiza la totalidad de la página -->
		<table border="1px" width="100%"  height="1000">
			<!-- Header-->
			<tr height="150 px">
				<td colspan="2"><!--<img src="_images/gradient.jpg" width="1400 px" height="150 px"/>--></td>
			</tr>
			<!-- tabla con links y contenido, los botones estan sacados de un template por lo tanto tienen clases en el CSS.-->
			<tr height="800" >
				<td class="tabla" width="10%">
				<table width="80%" class="menu" align="center" height="100%">
					<tr>
						<td width="100%">
						<div id="button-container" class="demo">
							<button id="buttonCons">Mostrar mis horarios</button>
							<div id="arrow-container">
								<div id="arrow-rectangle"></div>
								<div id="arrow-triangle" ></div>
							</div>
						</div></td>
					</tr>
					<tr>
						<td width="100%">
						<div id="button-container" class="download">
							<button  id="buttonCreate">Crear Horario</button>
							<div id="arrow-container">
								<div id="arrow-rectangle"></div>
								<div id="arrow-triangle" ></div>
							</div>
						</div></td>
					</tr>
					<tr>
						<td width="100%">
						<div id="button-container" class="download">
							<button  id="buttonLogout">Logout</button>
							<div id="arrow-container">
								<div id="arrow-rectangle"></div>
								<div id="arrow-triangle" ></div>
							</div>
						</div></td>
					</tr>
					<tr>
						<td height="600"></td>
					</tr>
				</table></td>
				<!-- Muestra el contenido principal de la pagina -->
				<td class="contentResult"  valign="top" width="100%">
				<table id="result">
				</table>
				</td>
			</tr>
			<!-- Footer
			<tr height="100" >
				<td colspan="2" > footer </td>
			</tr>-->
		</table>
		<div align="center"><p style="font-size:10px;">Creado y desarrollado por Capitulo Estudiantil ACM Universidad de los Andes. <br /> Liderado por Juan Tejada y Jorge Lopez</p></div>
	</body>
</html>