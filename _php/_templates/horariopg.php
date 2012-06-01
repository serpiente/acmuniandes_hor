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
		<link rel="icon" type="image/png" href="/acmuniandes_hor/_images/acm_sym.png">
		<link rel='stylesheet' type='text/css' href='/acmuniandes_hor/_css/jquery-ui-1.8.11.custom.css' />
		<link rel='stylesheet' type='text/css' href='/acmuniandes_hor/_css/jquery.weekcalendar.css' />
		<link rel='stylesheet' type='text/css' href='/acmuniandes_hor/_css/ui.jqgrid.css' />
		<link rel='stylesheet' type='text/css' href='/acmuniandes_hor/_css/hor_core.css' />
		<link rel="stylesheet" type="text/css" href="/acmuniandes_hor/_css/tip-twitter.css" />

		<script type="text/javascript" src="/acmuniandes_hor/_js/_lib/jquery-1.6.2.js"></script>
		<script type="text/javascript" src="/acmuniandes_hor/_js/_lib/jquery-ui-1.8.14.custom.min.js" ></script>
		<script type="text/javascript" src="/acmuniandes_hor/_js/_lib/jquery.weekcalendar.js"></script>
		<script type="text/javascript" src="/acmuniandes_hor/_js/_lib/grid.locale-en.js"></script>
		<script type="text/javascript" src="/acmuniandes_hor/_js/_lib/jquery.jqGrid.min.js"></script>
		<script type="text/javascript" src="/acmuniandes_hor/_js/_lib/jquery.poshytip.min.js"></script>
		<script type="text/javascript" src="/acmuniandes_hor/_js/hor_core.js"></script>

		<title>HorarioLab</title>
	</head>
	<body>
		<div id="helper" class="helper"></div>
		<div id="dialogConf" title="Advertencia!"></div>
		<table border="0px" width="1500" cellspacing="10" align="center">
			<!-- Header-->
			<tr height="50">
				<td colspan="2" width="200px"><h1>HorarioLab</h1></td>
				<td><button id="adminButton" class="boton">Panel de Horarios</button>&nbsp;&nbsp;<button id="logoutButton" class="boton">Logout</button></td>
			</tr>
			<!-- tabla con links y contenido-->
			<tr valign="top">
				<td width="25%">
					<table class="tabla">
						<tr height="50">
							<td align="center">
								<div id="searchInput">
									<input type="text" id="searchInputText" value="ingrese cualquier busqueda"/>
									<button id="searchButton" class="boton">Buscar</button>
								</div>
							</td>
						</tr>
						<tr>
							<td>
								<table id="searchResults">
								</table>
							</td>
						</tr>
					</table>
				</td>
				<td width="1%"></td>
				<td valign="top" width="74%">
					<table class="tabla">
						<tr>
							<td>
								<div id="scheduleContainer"></div>
							</td>
						</tr>
						<tr align="right">
							<td colspan="2" >
							<button id="saveButton" class="boton">
								Guardar Horario
							</button>
							<button id="expCRNButton" class="boton">
								Exportar CRNs
							</button>
							<button id="expButton" class="boton">
								Exportar
							</button></td>
						</tr>
					</table>
					
				</td>
			</tr>
			<!-- Footer-->
		</table>
		<div align="center"><p style="font-size:10px;">Creado y desarrollado por Capitulo Estudiantil ACM Universidad de los Andes. <br /> Liderado por Juan Tejada y Jorge Lopez</p></div>
	</body>
</html>