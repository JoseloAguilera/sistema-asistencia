<?php
	session_start();
	require "server/conn.php";

	if(isset($_POST['usuario']) || isset($_POST['contrasena'])) {
		if(isset($_POST['usuario']) && $_POST['usuario'] != '' && isset($_POST['contrasena']) &&  $_POST['contrasena'] != '' ) {
			$usuario = $_POST['usuario'];
			$contrasena = md5($_POST['contrasena']); //md5 para encriptar

			$sql= "SELECT * from alumnos WHERE cedula = '$usuario' AND password = '$contrasena'";
			$query= $connection->prepare($sql);
			$query->execute();
			if ($query->rowCount() > 0) {
				
				foreach ($query->fetchAll() as $row) {
					$_SESSION['logueado'] = 'logueado';
					$_SESSION['tipo_login'] = 'alumno';
					$_SESSION['nome_usuario'] = $row['nombre'];
					$_SESSION['nome_compl'] = $row['nombre'];
					$_SESSION['id'] = $row['id'];
					$_SESSION['cedula'] = $row['cedula'];
					header('Location: presencia.php');
				}
			}
			else { //Si no encontró apresenta error
				$mensaje = '<p class="alert alert-danger">Por favor, Ingrese Todos los Datos!</p>';
			}
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
			<p class="login-box-msg">AREA DE ALUMNOS<br>Ingrese su Usuario y Contraseña</p>
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
			<a href="login.php">No soy alumno</a><br>
		</div> <!-- /.login-box-body -->
	</div><!-- /.login-box -->

	<!-- SCRIPTS (js) -->
	<?php include "includes/scripts.php"; ?>
	<!-- ./SCRIPTS (js) -->
</body>
</html>
