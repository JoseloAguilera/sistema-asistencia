<?php $role='admin'; require __DIR__.'/server/login-controller.php'; ?>
<!DOCTYPE html>
<html>
<head>
	<title>Academia de Danza</title>
	<?php include 'includes/head.php'; ?>
</head>

<body class="hold-transition login-page">
	<div class="login-box">
		<div class="login-logo text-center">
			<a href="index.php"><img src="img/logo.png" class="img-circle" alt="Logo SSD" style="width: 150px;"><br><b>Super Star Dance</b></a>
		</div> <!-- /.login-logo -->

	 	<div class="login-box-body">
			<p class="login-box-msg">Ingrese su Usuario y Contraseña</p>
			<?php
				if (isset($mensaje)) {
					echo $mensaje; 
				}
			?>
			<form action="" method="post"><?php echo csrf_field(); ?>
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
			<a href="login-alumno.php">Area de Alumnos</a><br>
		</div> <!-- /.login-box-body -->
	</div><!-- /.login-box -->

	<!-- SCRIPTS (js) -->
	<?php include "includes/scripts.php"; ?>
	<!-- ./SCRIPTS (js) -->
</body>
</html>