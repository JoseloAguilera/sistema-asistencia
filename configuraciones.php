<?php 
	session_start();
	require "server/conn.php";
	
	if (!isset($_SESSION['logueado'])) {
		header('Location: login.php');
	}

	$usuario = $_SESSION['nome_usuario'];

	$sql = "SELECT * FROM usuarios WHERE usuario = '$usuario'";
	$query = $connection->prepare($sql);
	$query->execute();
	$user= $query->fetch();

	if($_SERVER['REQUEST_METHOD'] == "POST") {
		if (isset($_POST['guardar'])){
			//var_dump($_POST);
			
			if($_POST['senha'] != "" && $_POST['senha'] != $_POST['senha2']) {
				$mensaje = '<p class="alert alert-danger">Las Contraseñas NO están Iguales!</p>';
			} else {
				$nombre = $_POST['nombre'];
				$email = $_POST['email'];
				$usu = $_POST['usuario'];

				// Update do grupo
				if ($_POST['senha'] != "") {
					$password = md5($_POST['senha']);
					$sql = "UPDATE usuarios SET nombre = '$nombre', usuario = '$usu', email = '$email', password = '$password'
					WHERE usuario = '$usuario'";
				} else {
					$sql = "UPDATE usuarios SET nombre = '$nombre', usuario = '$usu', email = '$email'
					WHERE usuario = '$usuario'";
				}
				$query = $connection->prepare($sql);
				$query->execute();

				$sql = "SELECT * FROM usuarios WHERE usuario = '$usu'";
				$query = $connection->prepare($sql);
				$query->execute();
				$user= $query->fetch();

				$_SESSION['nome_usuario'] = $usu;
				$_SESSION['nome_compl'] = $nombre;

				$mensaje = '<p class="alert alert-success">Datos Actualizados!</p>';
			}
		} else {
			//ERROR
		}
	}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Empresa X - Página de inicio</title>
	<?php include 'includes/head.php'; ?>
</head>
<body class="hold-transition skin-blue sidebar-mini">
	<div class="wrapper">
		<!-- MAIN HEADER -->
		<?php include 'includes/header.php'; ?>
		<!-- MAIN HEADER END -->

		<!-- ASIDE BAR -->
		<?php include 'includes/aside.php'; ?>
		<!-- ASIDE BAR END -->

		<!-- Content Wrapper. Contains page content -->
		<div class="content-wrapper">
			<!-- Cabicera de Contenido (Título) -->
			<section class="content-header">
				<h1>
					Configuraciones
					<small>Configuraciones de la cuenta del administrador.</small>
				</h1>
				<!-- Menu de navegación -->
				<!-- <ol class="breadcrumb">
					<li><a href="#"><i class="fa fa-dashboard"></i> Página de inicio</a></li>
					<li><a href="#">Level 1</a></li>
					<li class="active">Level 2</li>
				</ol> -->
			</section>

		<!-- Contenido Principal -->
		<section class="content">
			<?php
				if (isset($mensaje)) {
					echo $mensaje; //mensaje de error
				}
			?>
			<!-- Caja de Texto de color gris (Default) -->
			<div class="box">
				<form action="" method="POST">
					<!-- Corpo de Caja -->
					<div class="box-body">
						<div class="text-center">
							<div class="col-lg-4 col-xs-6">
								<img src="img/user2-160x160.jpg" class="img-responsive img-circle" alt="Responsive image" style="width: 270px;">
							</div>
						</div>
						
						<div class="col-lg-8 col-xs-12">
							<br>
							<div class="form-group">
								<label for="descricao">Logo Empresa</label>
								<input type="file" id="logo" name="logo">
							</div>
						</div>
						<div class="col-lg-8 col-xs-12">
							<div class="form-group">
								<label for="nombre">Nombre Completo</label>
								<input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre Completo del Usuario" maxlength="80" value="<?php echo $user['nombre'];?>" required>
							</div>
						</div>
						<div class="col-lg-3 col-xs-12">
							<div class="form-group">
								<label for="usuario">Usuario</label>
								<input type="text" class="form-control" id="usuario" name="usuario" placeholder="Usuario para Login" maxlength="50" value="<?php echo $user['usuario'];?>" required>
							</div>
						</div>
						<div class="col-lg-5 col-xs-12">
							<div class="form-group">
								<label for="email">E-mail</label>
								<input type="email" class="form-control" id="email" name="email" placeholder="Dirección de e-mail para avisos y recuperación" maxlength="50" value="<?php echo $user['email'];?>" required>
							</div>
						</div>
						<div class="col-lg-4 col-xs-12">
							<div class="form-group">
								<label for="senha">Nueva Contraseña</label>
								<input type="password" class="form-control" id="senha" name="senha" placeholder="Nueva Contraseña" maxlength="50">
							</div>
						</div>
						<div class="col-lg-4 col-xs-12">
							<div class="form-group">
								<label for="senha2">Reingresse la Contraseña</label>
								<input type="password" class="form-control" id="senha2" name="senha2" placeholder="Reingresse la Contraseña" maxlength="50">
							</div>
						</div>
						<div class="col-lg-12 col-xs-2">
							<button type="submit" class="btn btn-primary pull-right" name="guardar">Guardar</button>
						</div>
					</div>
					<!-- /.box-body -->
				</form>
			</div>
			<!-- /.Caja de Texto de color gris (Default) -->

			</section>
			<!-- /.content -->
		</div>
		<!-- /.content-wrapper -->

		<!-- FOOTER -->
		<?php include "includes/footer.php"; ?>
		<!-- ./FOOTER -->

		<!-- Menu retractil de la derecha -->
		<?php //include "includes/aside-control.php"; ?>
		<!-- ./ Menu retractil de la derecha -->

		<!-- Color de Fondo de del menu derecho -->
		<!-- <div class="control-sidebar-bg"></div> -->
		<!-- ./Color de Fondo de del menu derecho -->
	</div>
	<!-- ./Contenido -->

	<!-- SCRIPTS (js) -->
	<?php include "includes/scripts.php"; ?>
	<!-- ./SCRIPTS (js) -->
</body>
</html>