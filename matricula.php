<?php
	require 'server/conn.php';
	session_start();
	// var_dump($_SESSION['usuario']);
	if (!isset($_SESSION['logueado'])) {
		header('Location: login.php');
	}

if (isset($_POST['codigo'])) {
	if ($_POST['codigo']>0) {
	//	echo "<script>window.location('pdf.php?id='".$_POST['codigo'].")</script>";
		header('Location: pdf.php?id='.$_POST['codigo']);
	}
}

	if($_SERVER['REQUEST_METHOD'] == "POST") {
		if (isset($_POST['nuevo'])){
			//var_dump($_POST);
			$fechainicio = $_POST['fechainicio'];
			$codgrupo = $_POST['grupo'];
			$alumno = $_POST['alumno'];
			$matricula = str_replace(".", "", $_POST['valmatricula']);
			$cuota = str_replace(".", "", $_POST['valcuota']);
			// $estado = $_POST['estado'];
			$mysqldata = substr($fechainicio, 6,4)."-".substr($fechainicio, 3,2)."-".substr($fechainicio, 0,2); //convierte de dd/mm/yyyy para yyyy-mm-dd

			$sql = "INSERT INTO matricula (id_alumnos, fecha_inicio, valor_cuota, valor_matricula, grupo_id, fecha_add, fecha_update) VALUES ('$alumno', '$mysqldata', '$cuota','$matricula', '$codgrupo', NOW(), NOW())";
			$query = $connection->prepare($sql);
			$query->execute();
			//var_dump($last_id);

			//$result= $query->fetchAll();
		} else if (isset($_POST['guardar'])){
			//var_dump($_POST);
			$id =  $_POST['codigo'];
			$fechainicio = $_POST['fechainicio'];
			$codgrupo = $_POST['grupo'];
			$alumno = $_POST['alumno'];
			$matricula = str_replace(".", "", $_POST['valmatricula']);
			$cuota = str_replace(".", "", $_POST['valcuota']);
			// $estado = $_POST['estado'];
			$mysqldata = substr($fechainicio, 6,4)."-".substr($fechainicio, 3,2)."-".substr($fechainicio, 0,2); //convierte de dd/mm/yyyy para yyyy-mm-dd

			// Update do grupo
			$sql = "UPDATE matricula SET id_alumnos = '$alumno', fecha_inicio = '$mysqldata', valor_cuota = '$cuota', valor_matricula = '$matricula', grupo_id = '$codgrupo', fecha_update = NOW()
			WHERE id = $id";
			$query = $connection->prepare($sql);
			$query->execute();

			//$result= $query->fetchAll();
		} else if (isset($_POST['excluir'])){
			// var_dump($_POST);
			$id =  $_POST['codigo'];
			// Delete Grupos
			$sql = "DELETE FROM matricula WHERE id = $id";
			$query = $connection->prepare($sql);
			$query->execute();
			//$result= $query->fetchAll();
		}
	}

?>
<!DOCTYPE html>
<html>
<head>
	<title>SSD - Matriculas</title>
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

		<?php
			if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['search'])){
				// var_dump($_POST['busca']);
				// $busca = $_POST['busca'];
				// $sql = "SELECT * from cursos WHERE nombre LIKE '%$busca%' OR desc_corta LIKE '%$busca%' OR duracion_meses LIKE '%$busca%' OR estado LIKE '%$busca%' OR valor_cuota LIKE '%$busca%' OR valor_matrícula LIKE '%$busca%' ORDER by nombre";
				// $query = $connection->prepare($sql);
				// $query->execute();
				// $result= $query->fetchAll();
			} else {
				$busca = "";
				$sql = "SELECT matricula.*, alumnos.nombre, alumnos.apellido, cursos.nombre AS curso, grupos.descripcion AS grupo FROM `matricula` INNER JOIN alumnos ON `id_alumnos` = alumnos.id INNER JOIN grupos ON grupo_id = grupos.id INNER JOIN cursos ON grupos.cursos_id = cursos.id ORDER BY alumnos.nombre";
				$query = $connection->prepare($sql);
				$query->execute();
				$result= $query->fetchAll();
			}
		?>
		<!-- Content Wrapper. Contains page content -->
		<div class="content-wrapper">
			<!-- Cabicera de Contenido (Título) -->
			<section class="content-header">
				<h1>
					Matricula
					<small>Matricula de los alumnos en los cursos.</small>
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
							<button id="btnAdd" type="button" class="btn btn-primary" data-toggle="modal" data-target="#AddModal" style="margin-bottom: 5px;">+ Nueva</button>
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
									<th>Curso</th>
									<th>Grupo</th>
									<th>Alumno</th>
									<th>Fecha de Inicio</th>
									<th>Valor de Matricula</th>
									<th>Valor de Cuota</th>
									<th>Estado</th>
									<th>Acción</th>

								</tr>
								<?php foreach ($result as $row) {
									$fechainicio = substr($row['fecha_inicio'], 8,2)."/".substr($row['fecha_inicio'], 5,2)."/".substr($row['fecha_inicio'], 0,4);;
									$valmatricula = number_format($row['valor_matricula'], 0, ",", ".");
									$valcuota = number_format($row['valor_cuota'], 0, ",", ".");
								?>
								<tr data-toggle="modal" data-target="#AltModal" data-codigo="<?php echo $row['id'];?>" data-alumno="<?php echo $row['id_alumnos'];?>"  data-grupo="<?php echo $row['grupo_id'];?>" data-fechainicio="<?php echo $fechainicio;?>"
									data-valmatricula="<?php echo $valmatricula;?>" data-valcuota="<?php echo $valcuota;?>" data-estado="activo">
									<td><?php echo $row['id'];?></td>
									<td><?php echo $row['curso'];?></td>
									<td><?php echo $row['grupo'];?></td>
									<td><?php echo $row['nombre']." ".$row['apellido'];?></td>
									<td><?php echo $fechainicio;?></td>
									<td><?php echo $valmatricula;?></td>
									<td><?php echo $valcuota;?></td>
									<td>Activo</td>
								</tr>
								<?php }?>
							</table>
						</div>
					</div>
					<!-- /.box-body -->
				</div>
				<!-- ./ Caja de Texto de color gris (Default) -->
			</section>
			<!-- ./ content -->
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

	<!-- AddModal -->
	<div class="modal fade" tabindex="-1" role="dialog" id="AddModal">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title">Nueva Matricula</h4>
				</div>
				<form action="" method="POST">
					<div class="modal-body">
						<div class="row">
							<div class="col-md-4">
								<div class="form-group">
									<label for="fechainicio">Fecha de Inicio</label>
									<input type="text" class="form-control pull-right datepicker" id="fechainicio" name="fechainicio">
								</div>
							</div>
							<div class="col-md-8">
								<div class="form-group">
									<label for="dia">Alumno</label>
									<select class="form-control" id="alumno" name="alumno">
									<?php
										$sql = "SELECT * from alumnos ORDER by nombre";
										$query = $connection->prepare($sql);
										$query->execute();
										$result= $query->fetchAll();

										foreach ($result as $row) {
									?>
										<option value="<?php echo $row['id'];?>"><?php echo $row['nombre']." ".$row['apellido'];?></option>
									<?php }?>
									</select>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label for="grupo">Grupo</label>
									<select class="form-control" id="grupo" name="grupo">
									<?php
										$sql = "SELECT * from cursos ORDER by nombre";
										$query = $connection->prepare($sql);
										$query->execute();
										$result= $query->fetchAll();

										foreach ($result as $row) {
									?>
										<optgroup label="<?php echo 'Curso de '.$row['nombre'];?>">
											<?php
												$codcurso = $row['id'];
												$sql = "SELECT * from grupos WHERE cursos_id = $codcurso ORDER by descripcion";
												$query = $connection->prepare($sql);
												$query->execute();
												$result2= $query->fetchAll();

												foreach ($result2 as $grupo) {
											?>
											<option value="<?php echo $grupo['id'];?>"><?php echo $grupo['descripcion'];?></option>
											<?php }?>
										</optgroup>
									<?php }?>
									</select>
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
									<label for="valmatricula">Valor Matrícula</label>
									<input type="text" class="form-control" id="valmatricula" name="valmatricula" placeholder="000.000" onKeyUp="formatoMoneda(this, event)" required>
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
									<label for="valcuota">Valor Cuota</label>
									<input type="text" class="form-control" id="valcuota" name="valcuota" placeholder="000.000" onKeyUp="formatoMoneda(this, event)" required>
								</div>
							</div>
						</div> <!-- row -->
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
						<button type="submit" class="btn btn-primary" name="nuevo">Guardar</button>
					</div>
				</form>
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
					<h4 class="modal-title">Matricula ID</h4>
				</div>
				<form action="" method="POST">
					<div class="modal-body">
						<input type="hidden" class="form-control" id="codigo" name="codigo">
						<div class="row">
							<div class="col-md-4">
								<div class="form-group">
									<label for="fechainicio">Fecha de Inicio</label>
									<input type="text" class="form-control pull-right datepicker" id="fechainicio" name="fechainicio">
								</div>
							</div>
							<div class="col-md-8">
								<div class="form-group">
									<label for="dia">Alumno</label>
									<select class="form-control" id="alumno" name="alumno">
									<?php
										$sql = "SELECT * from alumnos ORDER by nombre";
										$query = $connection->prepare($sql);
										$query->execute();
										$result= $query->fetchAll();

										foreach ($result as $row) {
									?>
										<option value="<?php echo $row['id'];?>"><?php echo $row['nombre']." ".$row['apellido'];?></option>
									<?php }?>
									</select>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label for="grupo">Grupo</label>
									<select class="form-control" id="grupo" name="grupo">
									<?php
										$sql = "SELECT * from cursos ORDER by nombre";
										$query = $connection->prepare($sql);
										$query->execute();
										$result= $query->fetchAll();

										foreach ($result as $row) {
									?>
										<optgroup label="<?php echo 'Curso de '.$row['nombre'];?>">
											<?php
												$codcurso = $row['id'];
												$sql = "SELECT * from grupos WHERE cursos_id = $codcurso ORDER by descripcion";
												$query = $connection->prepare($sql);
												$query->execute();
												$result2= $query->fetchAll();

												foreach ($result2 as $grupo) {
											?>
											<option value="<?php echo $grupo['id'];?>"><?php echo $grupo['descripcion'];?></option>
											<?php }?>
										</optgroup>
									<?php }?>
									</select>
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
									<label for="valmatricula">Valor Matrícula</label>
									<input type="text" class="form-control" id="valmatricula" name="valmatricula" placeholder="000.000" onKeyUp="formatoMoneda(this, event)" required>
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
									<label for="valcuota">Valor Cuota</label>
									<input type="text" class="form-control" id="valcuota" name="valcuota" placeholder="000.000" onKeyUp="formatoMoneda(this, event)" required>
									<input type="hidden" name="pdf" id="pdf">
								</div>
							</div>
						</div> <!-- row -->
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-danger pull-left" name="excluir" id="btn-confirmar">Excluir</button>
						<button type="submit" class="btn" name="excluir" id="btn-excluir" style="display: none;">Submit Excluir</button>
						<button type= "submit" class="btn btn-default pull-left">Generar Pdf <i class="fa fa-file-pdf-o"></i></button>
						<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
						<button type="submit" class="btn btn-primary" name="guardar">Guardar</button>
					</div>
				</form>
			</div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
	</div><!-- /.modal -->
	<!-- ./AltModal -->

	<!-- Confirmación Modal (para excluisiones) -->
	<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" id="mi-modal">
		<div class="modal-dialog modal-sm">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="myModalLabel">¿Deseas eliminar este registro?</h4>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" id="modal-btn-si">Sí</button>
					<button type="button" class="btn btn-primary" id="modal-btn-no">No</button>
				</div>
			</div>
		</div>
	</div>
	<!-- Confirmación Modal (para excluisiones) -->

	<!-- SCRIPTS (js) -->
	<?php include "includes/scripts.php"; ?>
	<!-- ./SCRIPTS (js) -->

	<script type="text/javascript">
		$('#AltModal').on('show.bs.modal', function (event) {
			var button = $(event.relatedTarget) // objeto que disparó el modal
			var codigo = button.data('codigo')
			var fechainicio = button.data('fechainicio')
			var alumno = button.data('alumno')
			var grupo = button.data('grupo')
			var valmatricula = button.data('valmatricula')
			var valcuota = button.data('valcuota')
			var estado = button.data('estado')

			// console.log(grupo + " -- ");
			// Actualiza los datos del modal
			var modal = $(this)
			modal.find('.modal-title').text('Matricula ' + codigo)
			modal.find('#codigo').val(codigo)
			modal.find('#alumno').val(alumno)
			//modal.find('#grupo').val(grupo)
			$('select[name=grupo]').val(grupo)
			$('.selectpicker').selectpicker('render')

			modal.find('#fechainicio').val(fechainicio)
			modal.find('#valmatricula').val(valmatricula)
			modal.find('#valcuota').val(valcuota)
			modal.find('#estado').val(estado)
		})

		// formato para moneda
		String.prototype.reverse = function(){
			return this.split('').reverse().join('');
		};
		function formatoMoneda(campo, evento){
			var tecla = (!evento) ? window.event.keyCode : evento.which;
			var valor  =  campo.value.replace(/[^\d]+/gi,'').reverse();
			var resultado  = "";
			var mascara = "###.###.###";
			mascara = mascara.reverse();
			for (var x=0, y=0; x<mascara.length && y<valor.length;) {
				if (mascara.charAt(x) != '#') {
					resultado += mascara.charAt(x);
					x++;
				} else {
					resultado += valor.charAt(y);
					y++;
					x++;
				}
			}
			campo.value = resultado.reverse();
		}

		// modal para confirmar si quiere remover el registro
		var modalConfirm = function(callback){
			//botón que llama el modal
			$("#btn-confirmar").on("click", function(){
				$("#mi-modal").modal('show');
			});

			//si quiere remover el registro
			$("#modal-btn-si").on("click", function(){
				callback(true);
				$("#mi-modal").modal('hide');
			});

			//si no quiere remover el registro
			$("#modal-btn-no").on("click", function(){
				callback(false);
				$("#mi-modal").modal('hide');
			});
		};
		//función que trabaja con la respuesta del modal (sí o no)
		modalConfirm(function(confirm){
			if(confirm){
				//Acciones si el usuario confirma
				$("#btn-excluir").click();
			}else{
				//Acciones si el usuario no confirma
			}
		});
	</script>
</body>
</html>
