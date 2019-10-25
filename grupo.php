<?php 
	session_start();
	// var_dump($_SESSION['usuario']);
	if (!isset($_SESSION['logueado'])) {
		header('Location: login.php');
	}
?>
<!DOCTYPE html>
<html>
<head>
	<title>SSD - Grupos</title>
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
					Grupos
					<small>Registro de los Grupos de danza de la academia.</small>
				</h1>
				<!-- Menu de navegación -->
				<ol class="breadcrumb">
					<li class="active"><a href="#"><i class="fa fa-pencil"></i> Grupos</a></li>
				</ol>
			</section>

		<!-- Contenido Principal -->
		<section class="content">
			<!-- Caja de Texto de color gris (Default) -->
			<div class="box">
				<div class="box-header with-border">
					<!-- Botón para crear más cursos -->
					<div class="col-md-3 pull-left">
						<a href="grupo-detalle.php" class="btn btn-primary" style="margin-bottom: 5px;">+ Nuevo</a>
					</div>
					<!-- Caja de Busqueda -->
					<div class="col-md-3 pull-right">
						<div class="input-group">
							<input type="text" class="form-control" placeholder="Buscar por..." name="busca">
							<span class="input-group-btn">
								<button class="btn btn-default" type="submit"><i class="fa fa-search"></i></button>
							</span>
						</div>
					</div>
				</div>
				<!-- Corpo de Caja -->
				<div class="box-body">
					<div class="box-body table-responsive">
						<table class="table table-hover">
							<tr>
								<th>#</th>
								<th>Nombre</th>
								<th>Descripción Corta</th>
								<th>Horario</th>
								<th>Cuota</th>
								<th>Qtd Inscriptos</th>
								<th>Estado</th>
							</tr>
							<tr onclick="window.location='grupo-detalle.php?id=1';">
								<td>1</td>
								<td>Ballet Iniciante 1</td>
								<td>Ballet clásico para todas las edades.</td>
								<td>Lunes<br>Miércoles</td>
								<td>19:00 hasta 20:00<br>19:00 hasta 20:00</td>
								<td>15 alumnos</td>
								<td>Activo</td>
							</tr>
							<tr onclick="window.location='grupo-detalle.php?id=2';">
								<td>2</td>
								<td>Danza Paraguaya</td>
								<td>Danza clásica paraguaya para niñas.</td>
								<td>Martes<br>Jueves</td>
								<td>19:00 hasta 20:00<br>19:00 hasta 20:00</td>
								<td>12 alumnos</td>
								<td>Vacaciones</td>
							</tr>
							<tr onclick="window.location='grupo-detalle.php?id=3';">
								<td>3</td>
								<td>Danza del Vientre</td>
								<td>Danza oriental muy elemental, prácticamente sin desplazamientos.</td>
								<td>Sábado</td>
								<td>08:00 hasta 10:00</td>
								<td>10 alumnos</td>
								<td>Activo</td>
							</tr>
						</table>
					</div>
				</div>
				<!-- /.box-body -->
				<div class="box-footer text-center">
					<!-- <div class="col-md-6"><small>2 Cursos en Abierto</small></div>
					<div class="col-md-6"><small>1 Cursos Finalizados</small></div> -->
				</div>
				<!-- /.box-footer-->
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