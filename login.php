<?php
	session_start();
	require "server/conn.php";

	if(isset($_POST['usuario']) || isset($_POST['contrasena'])) {
		if(isset($_POST['usuario']) && $_POST['usuario'] != '' && isset($_POST['contrasena']) &&  $_POST['contrasena'] != '' ) {
			$usuario = $_POST['usuario'];
			$contrasena = md5($_POST['contrasena']); //md5 para encriptar

			//Select usuario y contraseña

			if ($_POST['usuario'] == 'jose') { //Si encontró
				$_SESSION['logueado'] = 'logueado';
				$_SESSION['nome_usuario'] = "jose";
				header('Location: index.php');
			} else if ($_POST['usuario'] == 'alumno') { //Si encontró
				$_SESSION['logueado'] = 'logueado';
				$_SESSION['nome_usuario'] = "Alumno";
				header('Location: presencia.php');
			} else { //Si no encontró apresenta error
				$mensaje = '<p class="alert alert-danger">Los Datos Ingresados están Incorrectos!</p>';
			}
		} else { //Si no encontró apresenta error
			$mensaje = '<p class="alert alert-danger">Por favor, Ingrese Todos los Datos!</p>';
		}
	}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Academia de Danza</title>
	<?php include 'includes/head.php'; ?>
</head>

<body class="hold-transition login-page">
	<div class="login-box">
		<div class="login-logo">
			<a href="index.php"><b>Academia</b> de Danza</a>
		</div> <!-- /.login-logo -->

	 	<div class="login-box-body">
			<p class="login-box-msg">Ingrese su Usuario y Contraseña</p>
			<?php
				if (isset($mensaje)) {
					echo $mensaje; //mensaje de error
				}
			?>
			<form action="" method="post">
				<div class="form-group has-feedback">
					<input type="text" name="usuario" class="form-control" placeholder="Usuário" >
					<span class="glyphicon glyphicon-envelope form-control-feedback"></span>
				</div>
				<div class="form-group has-feedback">
					<input type="password" name="contrasena" class="form-control" placeholder="Contraseña">
					 <span class="glyphicon glyphicon-lock form-control-feedback"></span>
				</div>
				<div class="row">
					<div class="col-xs-6 col-xs-offset-3">
						<button type="submit" class="btn btn-primary btn-block btn-flat">Entrar</button>
					</div>
				</div>
			</form>
			<br>
			<a href="#">Olvidé mi contraseña</a><br>
		</div> <!-- /.login-box-body -->
	</div><!-- /.login-box -->

	<!-- SCRIPTS (js) -->
	<?php include "includes/scripts.php"; ?>
	<!-- ./SCRIPTS (js) -->
</body>
</html>
