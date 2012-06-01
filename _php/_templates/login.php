<!--
Copyright Capítulo Estudiantil ACM Universidad de los Andes
Creado y desarrollado por Capitulo Estudiantil ACM Universidad de los Andes. Juan Tejada y Jorge Lopez.
-->
<!DOCTYPE html>
<html>
	<head>
		<link rel="icon" type="image/png" href="/acmuniandes_hor/_images/acm_sym.png">
		<title>HorarioLab</title>
		<?php echo $css ?>
	</head>
	<body>
		<div style="padding: 100px 0 0 250px;">
			<div class="login-box-options" id="login-box">
				<H2>HorarioLab</H2>
				Bienvenido a la pagina de HorarioLab.
				<br />
				Por favor ingrese el usuario y clave de su correo Uniandes.
				<br />
				<br />
				<form id="loginForm" method="post" action="/acmuniandes_hor/_php/hor_auth.php">
					<div id="login-box-name" style="margin-top:20px;">
						Cuenta:
					</div>
					<div id="login-box-field" style="margin-top:20px;">
						<input name="usuario" class="form-login"  value="" size="30" maxlength="2048" />
					</div>
					<div id="login-box-name">
						Clave:
					</div>
					<div id="login-box-field">
						<input name="contrasenia" type="password" class="form-login" title="Password" value="" size="30" maxlength="2048" />
					</div>
					<p>
						<input type="hidden" name="tipsol" value="3">
						<br />
						<a href="#" style="margin-left:30px;">Olvido su clave?</a>
						<?php echo $autenticacion ?>
					</p>
					<p>
						<input name="LoginBtn" type="submit" class="boton" id="login" value="Login" />
						<br />
					</p>
				</form>
				<a href="#"></a>
			</div>
		</div>
		<div align="center"><p style="font-size:10px;">Creado y desarrollado por Capitulo Estudiantil ACM Universidad de los Andes. <br /> Liderado por Juan Tejada y Jorge Lopez</p></div>
	</body>
</html>