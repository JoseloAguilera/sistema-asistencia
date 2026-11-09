<?php require_once __DIR__.'/server/bootstrap.php'; auth('admin'); 
	
	require "server/conn.php";
	
	
	

	$usuario = $_SESSION['nome_usuario'];

	$sql = 'SELECT * FROM usuarios WHERE id = :auto1'; $sql_params = ['auto1' => $_SESSION['id']];
	$query = $connection->prepare($sql);
	$query->execute($sql_params);
	$user= $query->fetch();

	if($_SERVER['REQUEST_METHOD'] == "POST") {
		if (isset($_POST['guardar'])){
			
			
			if($_POST['senha'] != "" && $_POST['senha'] != $_POST['senha2']) {
				$mensaje = '<p class="alert alert-danger">Las Contraseñas NO están Iguales!</p>';
			} else {
				$nombre = $_POST['nombre'];
				$email = $_POST['email'];
				$usu = $_POST['usuario'];

				
				if ($_POST['senha'] != "") {
					$password = password_new($_POST['senha']);
					$sql = 'UPDATE usuarios SET nombre = :auto1, usuario = :auto2, email = :auto3, password = :auto4
					WHERE usuario = :auto5'; $sql_params = ['auto1' => $nombre, 'auto2' => $usu, 'auto3' => $email, 'auto4' => $password, 'auto5' => $usuario];
				} else {
					$sql = 'UPDATE usuarios SET nombre = :auto1, usuario = :auto2, email = :auto3
					WHERE usuario = :auto4'; $sql_params = ['auto1' => $nombre, 'auto2' => $usu, 'auto3' => $email, 'auto4' => $usuario];
				}
				$query = $connection->prepare($sql);
				$query->execute($sql_params);

				$sql = 'SELECT * FROM usuarios WHERE usuario = :auto1'; $sql_params = ['auto1' => $usu];
				$query = $connection->prepare($sql);
				$query->execute($sql_params);
				$user= $query->fetch();

				$_SESSION['nome_usuario'] = $usu;
				$_SESSION['nome_compl'] = $nombre;

				$mensaje = '<p class="alert alert-success">Datos Actualizados!</p>';
			}
		} else {
			
		}
	}
?>
<!DOCTYPE html>
<html>
<head>
	<title>SSD - Configuraciones</title>
	<?php include 'includes/head.php'; ?>
</head>
<body class="hold-transition skin-yellow sidebar-mini">
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
					echo $mensaje; 
				}
			?>
			<!-- Caja de Texto de color gris (Default) -->
			<div class="box">
				<form action="" method="POST"><?php echo csrf_field(); ?>
					<!-- Corpo de Caja -->
					<div class="box-body">
						<div class="text-center">
							<div class="col-lg-4 col-xs-6">
								<img src="img/logo.png" class="img-circle" alt="Logo SSD" style="width: 270px;">
								<h5>logo.png</h5>
							</div>
						</div>
						
						<!-- <div class="col-lg-8 col-xs-12">
							<br>
							<div class="form-group">
								<label for="descricao">Logo Empresa</label>
								<input type="file" id="logo" name="logo">
							</div>
						</div> -->
						<div class="col-lg-8 col-xs-12">
							<br>
							<div class="form-group">
								<label for="nombre">Nombre Completo</label>
								<input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre Completo del Usuario" maxlength="80" value="<?php echo e($user['nombre']);?>" required>
							</div>
						</div>
						<div class="col-lg-3 col-xs-12">
							<div class="form-group">
								<label for="usuario">Usuario</label>
								<input type="text" class="form-control" id="usuario" name="usuario" placeholder="Usuario para Login" maxlength="50" value="<?php echo e($user['usuario']);?>" required>
							</div>
						</div>
						<div class="col-lg-5 col-xs-12">
							<div class="form-group">
								<label for="email">E-mail</label>
								<input type="email" class="form-control" id="email" name="email" placeholder="Dirección de e-mail para avisos y recuperación" maxlength="50" value="<?php echo e($user['email']);?>" required>
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
		<?php ?>
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