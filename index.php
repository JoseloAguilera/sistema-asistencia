<?php 
	session_start();
	// var_dump($_SESSION['usuario']);
	if (!isset($_SESSION['logueado'])) {
		header('Location: login.php');
	}

	if (isset($_SESSION['logueado']) && $_SESSION['tipo_login'] == 'alumno' ) {
		header('Location: presencia.php');
	}
?>
<!DOCTYPE html>
<html>
<head>
	<title>SSD - Página de inicio</title>
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
			<!-- Contenido Principal -->
			<section class="content">
				<h3>
					Ballet Noche 1
					<small>Lunes 19:00 hasta 20:00 y Miércoles 19:00 hasta 20:00 </small>
				</h3>
				<div class="col-lg-3 col-xs-6">
					<!-- small box -->
					<div class="small-box bg-green">
						<div class="inner">
							<h3>90<sup style="font-size: 20px">%</sup></h3>
							<p>Asistencias</p>
						</div>
						<div class="icon">
							<i class="fa fa-user"></i>
						</div>
						<a href="#" class="small-box-footer">Mas informaciones <i class="fa fa-arrow-circle-right"></i></a>
					</div> <!-- bg-green -->
				</div>
				<div class="col-lg-3 col-xs-6">
					<!-- small box -->
					<div class="small-box bg-red">
						<div class="inner">
							<h3>10<sup style="font-size: 20px">%</sup></h3>
							<p>Ausencias</p>
						</div>
						<div class="icon">
							<i class="fa fa-user-times"></i>
						</div>
						<a href="#" class="small-box-footer">Mas informaciones <i class="fa fa-arrow-circle-right"></i></a>
					</div> <!-- bg-red -->
				</div>
				<div class="col-lg-3 col-xs-6">
					<!-- small box -->
					<div class="small-box bg-yellow">
						<div class="inner">
							<h3>2<sup style="font-size: 20px"> </sup></h3>
							<p>Interesados</p>
						</div>
						<div class="icon">
							<i class="fa  fa-user-plus"></i>
						</div>
						<a href="#" class="small-box-footer">Mas informaciones <i class="fa fa-arrow-circle-right"></i></a>
					</div> <!-- bg-yellow -->
				</div>
				<div class="col-lg-3 col-xs-6">
					<!-- small box -->
					<div class="small-box bg-aqua">
						<div class="inner">
							<h3>15<sup style="font-size: 20px"></sup></h3>
							<p>Matriculados</p>
						</div>
						<div class="icon">
							<i class="fa fa-users"></i>
						</div>
						<a href="#" class="small-box-footer">Mas informaciones <i class="fa fa-arrow-circle-right"></i></a>
					</div> <!-- bg-aqua -->
				</div>
			</section><!-- /.content -->

			<!-- Contenido Principal -->
			<section class="content">
				<h3>
					Ballet Noche 2
					<small>Martes 19:00 hasta 20:00 y Jueves 19:00 hasta 20:00 </small>
				</h3>
				<div class="col-lg-3 col-xs-6">
					<!-- small box -->
					<div class="small-box bg-green">
						<div class="inner">
							<h3>92<sup style="font-size: 20px">%</sup></h3>
							<p>Asistencias</p>
						</div>
						<div class="icon">
							<i class="fa fa-users"></i>
						</div>
						<a href="#" class="small-box-footer">Mas informaciones <i class="fa fa-arrow-circle-right"></i></a>
					</div> <!-- bg-green -->
				</div>
				<div class="col-lg-3 col-xs-6">
					<!-- small box -->
					<div class="small-box bg-red">
						<div class="inner">
							<h3>8<sup style="font-size: 20px">%</sup></h3>
							<p>Ausencias</p>
						</div>
						<div class="icon">
							<i class="fa fa-user-times"></i>
						</div>
						<a href="#" class="small-box-footer">Mas informaciones <i class="fa fa-arrow-circle-right"></i></a>
					</div> <!-- bg-red -->
				</div>
				<div class="col-lg-3 col-xs-6">
					<!-- small box -->
					<div class="small-box bg-yellow">
						<div class="inner">
							<h3>2<sup style="font-size: 20px"> </sup></h3>
							<p>Interesados</p>
						</div>
						<div class="icon">
							<i class="fa  fa-user-plus"></i>
						</div>
						<a href="#" class="small-box-footer">Mas informaciones <i class="fa fa-arrow-circle-right"></i></a>
					</div>
				</div> <!-- bg-yellow -->
				<div class="col-lg-3 col-xs-6">
					<!-- small box -->
					<div class="small-box bg-aqua">
						<div class="inner">
							<h3>11<sup style="font-size: 20px"></sup></h3>
							<p>Matriculados</p>
						</div>
						<div class="icon">
							<i class="fa fa-users"></i>
						</div>
						<a href="#" class="small-box-footer">Mas informaciones <i class="fa fa-arrow-circle-right"></i></a>
					</div>  <!-- bg-aqua -->
				</div>
			</section><!-- /.content -->

			<!-- Contenido Principal -->
			<section class="content">
				<h3>
					Danza del Vientre
					<small>Sábado 19:00 hasta 20:00</small>
				</h3>
				<div class="col-lg-3 col-xs-6">
					<!-- small box -->
					<div class="small-box bg-green">
						<div class="inner">
							<h3>92<sup style="font-size: 20px">%</sup></h3>
							<p>Asistencias</p>
						</div>
						<div class="icon">
							<i class="fa fa-users"></i>
						</div>
						<a href="#" class="small-box-footer">Mas informaciones <i class="fa fa-arrow-circle-right"></i></a>
					</div> <!-- bg-red -->
				</div>
				<div class="col-lg-3 col-xs-6">
					<!-- small box -->
					<div class="small-box bg-red">
						<div class="inner">
							<h3>8<sup style="font-size: 20px">%</sup></h3>
							<p>Ausencias</p>
						</div>
						<div class="icon">
							<i class="fa fa-user-times"></i>
						</div>
						<a href="#" class="small-box-footer">Mas informaciones <i class="fa fa-arrow-circle-right"></i></a>
					</div>
				</div>
				<div class="col-lg-3 col-xs-6">
					<!-- small box -->
					<div class="small-box bg-yellow">
						<div class="inner">
							<h3>2<sup style="font-size: 20px"> </sup></h3>
							<p>Interesados</p>
						</div>
						<div class="icon">
							<i class="fa  fa-user-plus"></i>
						</div>
						<a href="#" class="small-box-footer">Mas informaciones <i class="fa fa-arrow-circle-right"></i></a>
					</div> <!-- bg-yellow -->
				</div>
				<div class="col-lg-3 col-xs-6">
					<!-- small box -->
					<div class="small-box bg-aqua">
						<div class="inner">
							<h3>11<sup style="font-size: 20px"></sup></h3>
							<p>Matriculados</p>
						</div>
						<div class="icon">
							<i class="fa fa-users"></i>
						</div>
						<a href="#" class="small-box-footer">Mas informaciones <i class="fa fa-arrow-circle-right"></i></a>
					</div> <!-- bg-aqua -->
				</div>
			</section><!-- /.content -->

		</div> <!-- /.content-wrapper -->
		

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