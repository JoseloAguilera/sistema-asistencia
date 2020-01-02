<?php
	require 'server/conn.php';
	session_start();
	// var_dump($_SESSION['usuario']);
	if (!isset($_SESSION['logueado'])) {
		header('Location: login.php');
	}
	if (isset($_SESSION['logueado']) && $_SESSION['tipo_login'] == 'alumno' ) {
		header('Location: presencia.php');
	}

	if($_SERVER['REQUEST_METHOD'] == "POST") {
		if (isset($_POST['nuevo'])){
			//var_dump($_POST);
			$codcurso = $_POST['curso'];
			$estado = $_POST['estado'];
			$descripcion = $_POST['descripcion'];
			$dia = $_POST['dia'];
			$entrada = $_POST['entrada'];
			$salida = $_POST['salida'];

			$sql = "INSERT INTO grupos (descripcion, cursos_id, activo) VALUES ('$descripcion', '$codcurso', '$estado')";
			$query = $connection->prepare($sql);
			$query->execute();
			$last_id = $connection->lastInsertId(); //id del grupo
			//var_dump($last_id);

			foreach ($dia as $diasemana) {
				//var_dump($diasemana);
				$sql = "INSERT INTO horarios (hora_inicio, hora_fin, dia, grupos_id, grupos_cursos_id) VALUES ('$entrada', '$salida', '$diasemana', '$last_id', '$codcurso')";
				$query = $connection->prepare($sql);
				$query->execute();
			}
			//$result= $query->fetchAll();
		} else if (isset($_POST['guardar'])){
			//var_dump($_POST);

			$id =  $_POST['codigo'];
			$codcurso = $_POST['curso'];
			$estado = $_POST['estado'];
			$descripcion = $_POST['descripcion'];
			$dia = $_POST['dia'];
			$entrada = $_POST['entrada'];
			$salida = $_POST['salida'];

			//Alteração de Horários (Deletar os horários antigos e criar novos)
			//Delete horarios
			$sql = "DELETE FROM horarios WHERE grupos_id = $id";
			$query = $connection->prepare($sql);
			$query->execute();

			foreach ($dia as $diasemana) {
				//var_dump($diasemana);
				$sql = "INSERT INTO horarios (hora_inicio, hora_fin, dia, grupos_id, grupos_cursos_id) VALUES ('$entrada', '$salida', '$diasemana', '$id', '$codcurso')";
				$query = $connection->prepare($sql);
				$query->execute();
			}

			// Update do grupo
			$sql = "UPDATE grupos SET descripcion = '$descripcion', cursos_id = '$codcurso', activo = '$estado'
			WHERE id = $id";
			$query = $connection->prepare($sql);
			$query->execute();

			//$result= $query->fetchAll();
		} else if (isset($_POST['excluir'])){
			// var_dump($_POST);
			$id =  $_POST['codigo'];
			try {
				//Delete horarios
				$sql = "DELETE FROM horarios WHERE grupos_id = $id";
				$query = $connection->prepare($sql);
				$query->execute();
				$mensaje= '<div class="alert alert-success">REGISTRO ELIMINADO CORRECTAMENTE</div>';

			} catch (\Exception $e) {
				$mensaje = '<div class="alert alert-danger">HA OCURRIDO UN ERROR - Consulte al administrador de sistemas. Error->"'.$e.'<br></div>';

			}


			try {
				//Delete Grupos
				$sql = "DELETE FROM grupos WHERE id = $id";
				$query = $connection->prepare($sql);
				$query->execute();
				//$result= $query->fetchAll();
				$mensaje= '<div class="alert alert-success">REGISTRO ELIMINADO CORRECTAMENTE</div>';

			} catch (\Exception $e) {
				$mensaje = '<div class="alert alert-danger">HA OCURRIDO UN ERROR - Consulte al administrador de sistemas. Error->"'.$e.'<br></div>';

			}


		}
	}
?>
<!DOCTYPE html>
<html>
<head>
	<title>SSD - Grupos</title>
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

		<?php
			/*if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['search'])){
				// var_dump($_POST['busca']);
				$busca = $_POST['busca'];
				$sql = "SELECT grupos.*, nombre FROM grupos INNER JOIN cursos ON grupos.cursos_id=cursos.id WHERE descripcion LIKE '%$busca%' OR nombre LIKE '%$busca%' ORDER by descripcion";
				$query = $connection->prepare($sql);
				$query->execute();
				$result= $query->fetchAll();
			} else {
				$busca = "";*/
				$sql = "SELECT grupos.*, nombre FROM grupos INNER JOIN cursos ON grupos.cursos_id=cursos.id ORDER by descripcion";
				$query = $connection->prepare($sql);
				$query->execute();
				$result= $query->fetchAll();
			//}
		?>
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
						<button id="btnAdd" type="button" class="btn btn-primary" data-toggle="modal" data-target="#AddModal" style="margin-bottom: 5px;">+ Nuevo</button>
					</div>
					<!-- Caja de Busqueda -->
					<div class="col-md-3 pull-right">
						<a type="button" class="btn btn-primary pull-right" href="index.php"> ← Atrás </a>
					</div>
				</div>
				<!-- Corpo de Caja -->
				<div class="box-body">
					<div class="col-md-12">
						<?php
						if (isset( $mensaje)) {
							echo $mensaje; //alert mensaje
						}

						?>

					</div>
					<div class="box-body table-responsive">
						<table class="table table-striped table-bordered display nowra" id="tabladatos">
						<thead>
							<tr>
								<th>#</th>
								<th>Curso</th>
								<th>Descripción</th>
								<th>Horario</th>
								<th>Cuota</th>
								<th>Ctd Inscriptos</th>
								<th>Estado</th>
							</tr>
						</thead>
						<tbody>
							<?php
							foreach ($result as $row) {
								$curso_id = $row['cursos_id'];
								$grupo_id = $row['id'];
								$sql = "SELECT * FROM horarios WHERE grupos_id = $grupo_id AND grupos_cursos_id = $curso_id";
								$query = $connection->prepare($sql);
								$query->execute();
								$result2= $query->fetchAll();
								//Los horarios para poner en el selectpicker
								$dias = "";
								foreach ($result2 as $horario) {
									if ($dias != "") {
										$dias = $dias.",";
									}
									$dias = $dias.$horario['dia'];
									$id = $row['id'];
								}
								//var_dump($dias);
							?>
							<tr data-toggle="modal" data-target="#AltModal" data-codigo="<?php echo $row['id'];?>" data-curso="<?php echo $row['cursos_id'];?>" data-descripcion="<?php echo $row['descripcion'];?>" data-dias="<?php echo $dias;?>"
								data-entrada="<?php echo substr($horario['hora_inicio'],0,5)?>" data-salida="<?php echo substr($horario['hora_fin'],0,5)?>" data-estado="<?php echo $row['activo']?>">
								<td><?php echo $row['id'];?></td>
								<td><?php echo $row['nombre'];?></td>
								<td><?php echo $row['descripcion'];?></td>
								<td>
									<?php foreach ($result2 as $horario) { ?>
										<?php echo $horario['dia']."<br>";?>
									<?php } ?>
								</td>
								<td>De <?php echo substr($horario['hora_inicio'],0,5)."<br>";?>Hasta <?php echo substr($horario['hora_fin'],0,5)."<br>";?></td>
								<?php
								//Quantidade de Alunos Matriculados no Grupo
								$sql = "SELECT COUNT(*) FROM `matricula` INNER JOIN grupos ON matricula.`grupo_id` = grupos.id WHERE matricula.`grupo_id` = $id";
								$query = $connection->prepare($sql);
								$query->execute();
								$result3= $query->fetch();
								?>
								<td><?php echo $result3['COUNT(*)']?> alumnos</td>
								<td>
									<?php
										$estado = "";
										if ($row['activo'] == 1) {
											$estado = "Activo";
										} else {
											$estado = "Inactivo";
										}
										echo $estado;?>
							</td>
							</tr>
						<?php } ?>
						</tbody>
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

	<!-- AddModal -->
	<div class="modal fade" tabindex="-1" role="dialog" id="AddModal">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title">Nuevo Grupo</h4>
				</div>
				<form action="" method="POST">
					<div class="modal-body">
						<div class="row">
							<div class="col-md-9">
								<div class="form-group">
									<label for="nombre">Curso</label>
									<select class="form-control" id="curso" name="curso">
									<?php
										$sql = "SELECT * from cursos ORDER by nombre";
										$query = $connection->prepare($sql);
										$query->execute();
										$result= $query->fetchAll();

										foreach ($result as $row) {
											if ($row['activo']== 1)
											{
									?>
										<option value="<?php echo $row['id'];?>"><?php echo $row['nombre'];?></option>
									<?php }
												}?>
									</select>
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
									<label for="activo">Estado</label>
									<select class="form-control" id="estado" name="estado">
										<option value="1">Activo</option>
										<option value="0">Inactivo</option>
										<!--option value="2">Vacaciones</option-->
									</select>
								</div>
							</div>
							<div class="col-md-12">
								<div class="form-group">
									<label for="descripcion">Descripción</label>
									<textarea class="form-control" rows="2" id="descripcion" name="descripcion" required></textarea>
								</div>
							</div>
						</div>
						<div class="row" id="horarios">
							<div class="col-md-5">
								<div class="form-group">
									<label for="dia">Día de la Semana</label>
									<select class="selectpicker" id="dia" name="dia[]" multiple>
										<option value="Lunes">Lunes</option>
										<option value="Martes">Martes</option>
										<option value="Miercoles">Miércoles</option>
										<option value="Jueves">Jueves</option>
										<option value="Viernes">Viernes</option>
										<option value="Sabado">Sábado</option>
									</select>
								</div>
							</div>
							<div class="col-md-3">
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
							<div class="col-md-3">
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
							<!-- <div class="col-md-2">
								<button type="button" class="btn btn-primary" style="margin-top: 25px;" name="horario">+</button>
							</div> -->
						</div> <!-- row -->
					</div> <!-- modal-body -->
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
					<h4 class="modal-title">Alterar Curso</h4>
				</div>
				<form action="" method="POST">
					<div class="modal-body">
						<input type="hidden" class="form-control" id="codigo" name="codigo">
						<div class="row">
							<div class="col-md-9">
								<div class="form-group">
									<label for="nombre">Curso</label>
									<select class="form-control" id="curso" name="curso">
									<?php
										$sql = "SELECT * from cursos ORDER by nombre";
										$query = $connection->prepare($sql);
										$query->execute();
										$result= $query->fetchAll();

										foreach ($result as $row) {
									?>
										<option value="<?php echo $row['id'];?>"><?php echo $row['nombre'];?></option>
									<?php }?>
									</select>
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
									<label for="activo">Estado</label>
									<select class="form-control" id="estado" name="estado">
										<option value="1">Activo</option>
										<option value="0">Inactivo</option>
										<!--option value="2">Vacaciones</option-->
									</select>
								</div>
							</div>
							<div class="col-md-12">
								<div class="form-group">
									<label for="descripcion">Descripción</label>
									<textarea class="form-control" rows="2" id="descripcion" name="descripcion" required></textarea>
								</div>
							</div>
						</div>
						<div class="row" id="horarios">
							<div class="col-md-5">
								<div class="form-group">
									<label for="dia">Día de la Semana</label>
									<select class="selectpicker" id="dia" name="dia[]" multiple>
										<option value="Lunes">Lunes</option>
										<option value="Martes">Martes</option>
										<option value="Miercoles">Miércoles</option>
										<option value="Jueves">Jueves</option>
										<option value="Viernes">Viernes</option>
										<option value="Sabado">Sábado</option>
									</select>
								</div>
							</div>
							<div class="col-md-3">
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
							<div class="col-md-3">
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
						</div> <!-- row -->
					</div> <!-- modal-body -->
					<div class="modal-footer">
						<button type="button" class="btn btn-danger pull-left" name="excluir" id="btn-confirmar">Excluir</button>
						<button type="submit" class="btn" name="excluir" id="btn-excluir" style="display: none;">Submit Excluir</button>
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
	//Timepicker
	$('.timepicker').timepicker({
		showInputs: false,
		showMeridian: false //24 hrs
	})
	$('#AltModal').on('show.bs.modal', function (event) {
			var button = $(event.relatedTarget) // objeto que disparó el modal
			var codigo = button.data('codigo')
			var curso = button.data('curso')
			var descripcion = button.data('descripcion')
			var entrada = button.data('entrada')
			var salida = button.data('salida')
			var dias = button.data('dias')
			dias = dias.split(",")
			var estado = button.data('estado')

			console.log(dias);

			// Actualiza los datos del modal
			var modal = $(this)
			modal.find('.modal-title').text('Grupo ' + descripcion)
			modal.find('#codigo').val(codigo)
			modal.find('#curso').val(curso)
			modal.find('#descripcion').val(descripcion)
			modal.find('#entrada').val(entrada)
			modal.find('#salida').val(salida)
			//modal.find('#dia').val(dias)

			$('.selectpicker').val(dias)
			$('.selectpicker').selectpicker('render')
			modal.find('#estado').val(estado)
		})

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
