<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
		<title>HorarioLab</title>
		<link href="_css/login-box.css" rel="stylesheet" type="text/css" />
	</head>
	<body>
		<div style="padding: 100px 0 0 250px;">
			<div class="login-box-options" id="login-box">
				<H2>HorarioLab</H2>
				Bienvenido a la página de HorarioLab.
				<br />
				<br />
				<form id="loginForm" method="post" action="_php/hor_auth.php">
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
					</p>
					<p>
						<input name="LoginBtn" type="submit" class="login-box-options" id="login" value="Login" />
						<br />
					</p>
				</form>
				<a href="#"></a>
			</div>
		</div>
	</body>
</html>