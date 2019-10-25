<?php 
	session_start();
	// var_dump($_SESSION['usuario']);
	if (!isset($_SESSION['logueado'])) {
		header('Location: login.php');
	}

	$titulo = "";
	if (isset($_GET['id'])) {
		$titulo = "Detalle del Grupo ".$_GET['id'];
		$display = " block";
	} else {
		$titulo = "Nuevo Curso";
		$display = " none";
	}

	$text = "";

	if($_SERVER['REQUEST_METHOD'] == "POST") {
		if (isset($_POST['guardar'])){
			// exec('php curso-detalle.php?id=0');
			echo "<script>window.open('curso-detalle.php?id=0','_self') </script>"; //recarrega a página
		}
	}
?>
<!DOCTYPE html>
<html>
<head>
	<title>SSD - <?php echo $titulo;?></title>
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
					<?php echo $titulo;?>
					<small>Subtitulo</small>
				</h1>
				<!-- Menu de navegación -->
				<ol class="breadcrumb">
					<li><a href="grupo.php"><i class="fa fa-pencil"></i> Grupos</a></li>
					<li class="active"><a href="#">Detalle</a></li>
				</ol>
			</section>

			<!-- Contenido Principal -->
			<section class="content">
				<!-- Caja de Texto de color gris (Default) -->
				<div class="box">
					<form action="" method="POST">
						<!-- Corpo de Caja -->
						<div class="box-body">
							<div class="col-md-6">
								<div class="form-group">
									<label for="nombre">Nombre</label>
									<input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre del Grupo" maxlength="50" required>
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label for="activo">Curso</label>
									<select class="form-control" id="curso" name="curso">
										<option value="ballet">Ballet</option>
										<option value="paraguaya">Danza Paraguaya</option>
										<option value="vientre">Danza del Vientre</option>
									</select>
								</div>
							</div>
							<div class="col-md-2">
								<div class="form-group">
									<label for="activo">Estado</label>
									<select class="form-control" id="estado" name="estado">
										<option value="activo">Activo</option>
										<option value="inactivo">Inactivo</option>
										<option value="vacaciones">Vacaciones</option>
									</select>
								</div>
							</div>
							<div class="col-md-12">
								<div class="form-group">
									<label for="descripcion">Descripción</label>
									<textarea class="form-control" rows="2" id="descripcion" name="descripcion" placeholder="Descripción del Grupo" ></textarea>
								</div>
							</div>
						</div>
						<!-- /.box-body -->
						<div class="box-footer">
							<div class="pull-right">
								<a href="grupo.php" class="btn btn-default">Cerrar</a>
								<button type="submit" class="btn btn-primary" name="guardar" id="guardar">Guardar</button>
							</div>
						</div><!-- /.box-footer-->
					</form>
				</div>
				<!-- /.Caja de Texto de color gris (Default) -->
			</section>
			<!-- /.content -->
			<input type="hidden" name="id" id="id" value="<?php echo $text;?>">

			<!-- HORARIOS -->
			<!-- Cabicera de Contenido (Título) -->
			<section class="content-header">
				<h1>
					Horarios
					<small>Horarios del grupo</small>
				</h1>
				<!-- Menu de navegación -->
				<!-- <ol class="breadcrumb">
					<li><a href="curso2.php"><i class="fa fa-pencil"></i> Cursos</a></li>
					<li class="active"><a href="#">Detalle</a></li>
				</ol> -->
			</section>

			<!-- Contenido Principal -->
			<section class="content">
				<!-- Caja de Texto de color gris (Default) -->
				<div class="box">
					<!-- Corpo de Caja -->
					<div class="box-header with-border">
						<!-- Botón para crear más cursos -->
						<div class="col-md-3 pull-left">
							<button id="btnAdd" type="button" class="btn btn-primary" data-toggle="modal" data-target="#AddModal" style="margin-bottom: 5px;">+ Nuevo</button>
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
									<th>Día de la semana</th>
									<th>Entrada</th>
									<th>Salida</th>
									<th>Estado</th>
								</tr>
								<tr data-toggle="modal" data-target="#AltModal" data-codigo="1" data-dia="Lunes" data-entrada="19:00" data-salida="20:00" data-estado="activo">
									<td>1</td>
									<td>Lunes</td>
									<td>19:00</td>
									<td>20:00</td>
									<td>Activo</td>
								</tr>
								<tr data-toggle="modal" data-target="#AltModal" data-codigo="2" data-dia="Miércoles" data-entrada="19:00" data-salida="20:00" data-estado="activo">
									<td>2</td>
									<td>Miércoles</td>
									<td>19:00</td>
									<td>20:00</td>
									<td>Activo</td>
								</tr>
								<tr data-toggle="modal" data-target="#AltModal" data-codigo="3" data-dia="Viernes" data-entrada="19:00" data-salida="20:00" data-estado="inactivo">
									<td>3</td>
									<td>Viernes</td>
									<td>19:00</td>
									<td>20:00</td>
									<td>Inactivo</td>
								</tr>
							</table>
						</div>
					</div>
					<!-- /.box-body -->
				</div>
				<!-- ./ Caja de Texto de color gris (Default) -->
			</section>
			<!-- ./ content -->
		</div>
		<!-- ./ content-wrapper -->
		<!-- ./ HORARIOS -->


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

	<!-- AddModal -->
	<div class="modal fade" tabindex="-1" role="dialog" id="AddModal">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title">Nuevo Horario</h4>
				</div>
				<div class="modal-body">
					<div class="row bootstrap-timepicker">
						<form action="" method="POST">
							<div class="col-md-4">
								<div class="form-group">
									<label for="dia">Día de la Semana</label>
									<select class="form-control" id="dia" name="dia">
										<option value="Lunes">Lunes</option>
										<option value="Martes">Martes</option>
										<option value="Miércoles">Miércoles</option>
										<option value="Jueves">Jueves</option>
										<option value="Viernes">Viernes</option>
										<option value="Sábado">Sábado</option>
									</select>
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label for="entrada">Horario Entrada</label>
									<div class="input-group">
										<input type="text" class="form-control timepicker" id="entrada" name="entrada">
										<div class="input-group-addon">
											<i class="fa fa-clock-o"></i>
										</div>
									</div>
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label for="salida">Horario Salida</label>
									<div class="input-group">
										<input type="text" class="form-control timepicker" id="salida" name="salida">
										<div class="input-group-addon">
											<i class="fa fa-clock-o"></i>
										</div>
									</div>
								</div>
							</div>
						</form>
					</div> <!-- row -->
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
					<button type="submit" class="btn btn-primary" name="guardar">Guardar</button>
				</div>
			</div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
	</div><!-- /.modal -->
	<!-- ./AddModal -->

	<!-- AltModal -->
	<div class="modal fade" tabindex="-1" role="dialog" id="AltModal">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title">Horario ID</h4>
				</div>
				<div class="modal-body">
					<div class="row bootstrap-timepicker">
						<form action="" method="POST">
							<input type="hidden" class="form-control" id="codigo" name="codigo">
							<div class="col-md-4">
								<div class="form-group">
									<label for="dia">Día de la Semana</label>
									<select class="form-control" id="dia" name="dia">
										<option value="Lunes">Lunes</option>
										<option value="Martes">Martes</option>
										<option value="Miércoles">Miércoles</option>
										<option value="Jueves">Jueves</option>
										<option value="Viernes">Viernes</option>
										<option value="Sábado">Sábado</option>
									</select>
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label for="entrada">Horario Entrada</label>
									<div class="input-group">
										<input type="text" class="form-control timepicker" id="entrada" name="entrada">
										<div class="input-group-addon">
											<i class="fa fa-clock-o"></i>
										</div>
									</div>
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label for="salida">Horario Salida</label>
									<div class="input-group">
										<input type="text" class="form-control timepicker" id="salida" name="salida">
										<div class="input-group-addon">
											<i class="fa fa-clock-o"></i>
										</div>
									</div>
								</div>
							</div>
						</form>
					</div> <!-- row -->
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-danger pull-left" name="excluir">Excluir</button>
					<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
					<button type="submit" class="btn btn-primary" name="guardar">Guardar</button>
				</div>
			</div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
	</div><!-- /.modal -->
	<!-- ./AltModal -->

	<!-- SCRIPTS (js) -->
	<?php include "includes/scripts.php"; ?>
	<!-- ./SCRIPTS (js) -->

	<script type="text/javascript">
		$('#AltModal').on('show.bs.modal', function (event) {
			var button = $(event.relatedTarget) // objeto que disparó el modal
			var codigo = button.data('codigo') 
			var dia = button.data('dia')
			var entrada = button.data('entrada')
			var salida = button.data('salida')
			var estado = button.data('estado')
			
			// Actualiza los datos del modal 
			var modal = $(this)
			modal.find('.modal-title').text('Horario ' + codigo)
			modal.find('#codigo').val(codigo)
			modal.find('#dia').val(dia)
			modal.find('#entrada').val(entrada)
			modal.find('#salida').val(salida)
			modal.find('#estado').val(estado)
		})

	</script>
</body>
</html>