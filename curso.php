<?php require_once __DIR__.'/server/bootstrap.php'; auth('admin');
 $tipomensaje = $mensaje = '';
	require 'server/conn.php';
	
	
	
	

	if($_SERVER['REQUEST_METHOD'] == "POST") {
		if (isset($_POST['nuevo'])){
			
			$nombre = $_POST['nombre'];
			$desc_corta = $_POST['descripcion'];
			$desc_detallada = $_POST['detallada'];
			$duracion_meses = $_POST['duracion'];
			$estado = $_POST['estado'];
			$valor_cuota = $_POST['cuota'];
			$valor_matricula = $_POST['matricula'];
			try {
				$sql = 'INSERT INTO cursos (nombre, desc_corta, desc_detallada, duracion_meses, activo, valor_cuota, valor_matrícula, fecha_add, fecha_update)
				VALUES (:auto1, :auto2, :auto3, :auto4, :auto5, :auto6, :auto7, NOW(), NOW())'; $sql_params = ['auto1' => $nombre, 'auto2' => $desc_corta, 'auto3' => $desc_detallada, 'auto4' => $duracion_meses, 'auto5' => $estado, 'auto6' => $valor_cuota, 'auto7' => $valor_matricula];
				$query = $connection->prepare($sql);
				$query->execute($sql_params);

				$tipomensaje = 'success';
				$mensaje= '<h3>Perfecto!</h3><p>Los datos fueron insertados correctamente.</p>';

			} catch (\Exception $e) {
				$tipomensaje = 'error';
				$mensaje = '<h3>Error!</h3><p>Consulte al administrador de sistemas.<br>Error->"Operación rechazada</p>';
			}
			
			
		} else if (isset($_POST['guardar'])){
			
			$id =  $_POST['codigo'];
			$nombre = $_POST['nombre'];
			$desc_corta = $_POST['descripcion'];
			$desc_detallada = $_POST['detallada'];
			$duracion_meses = $_POST['duracion'];
			$estado = $_POST['estado'];
			$valor_cuota = $_POST['cuota'];
			$valor_matricula = $_POST['matricula'];

			try {
				$sql = 'UPDATE cursos SET nombre = :auto1, desc_corta = :auto2, desc_detallada = :auto3, duracion_meses = :auto4, activo = :auto5, valor_cuota = :auto6, valor_matrícula = :auto7, fecha_update = NOW()
				WHERE id = :auto8'; $sql_params = ['auto1' => $nombre, 'auto2' => $desc_corta, 'auto3' => $desc_detallada, 'auto4' => $duracion_meses, 'auto5' => $estado, 'auto6' => $valor_cuota, 'auto7' => $valor_matricula, 'auto8' => $id];
				$query = $connection->prepare($sql);
				$query->execute($sql_params);
				

				$tipomensaje = 'success';
				$mensaje= '<h3>Perfecto!</h3><p>Los datos fueron actualizados correctamente.</p>';
			} catch (\Exception $e) {
				$tipomensaje = 'error';
				$mensaje = '<h3>Error!</h3><p>Consulte al administrador de sistemas.<br>Error->"Operación rechazada</p>';
			}
				
		} else if (isset($_POST['excluir'])){
			
			$id =  $_POST['codigo'];
			try {
				$sql = 'DELETE FROM cursos WHERE id = :auto1'; $sql_params = ['auto1' => $id];
				$query = $connection->prepare($sql);
				$query->execute($sql_params);
				
				$tipomensaje = 'success';
				$mensaje= '<h3>Perfecto!</h3><p>Los datos fueron eliminados correctamente.</p>';
			} catch (\Exception $e) {
				$tipomensaje = 'error';
				$mensaje = '<h3>Error!</h3><p>Consulte al administrador de sistemas.<br>Error->"Operación rechazada</p>';
			}
		}
	}
?>
<!DOCTYPE html>
<html>
<head>
	<title>SSD - Cursos</title>
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
			
				$sql = "SELECT * from cursos ORDER by nombre";
				$query = $connection->prepare($sql);
				$query->execute();
				$result= $query->fetchAll();
			
		?>
		<!-- Content Wrapper. Contains page content -->
		<div class="content-wrapper">
			<!-- Cabicera de Contenido (Título) -->
			<section class="content-header">
				<h1>
					Cursos
					<small>Registro de los cursos de danza de la academia.</small>
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
					<div class="modal fade modal-mensaje" id="modal-mensaje" tabindex="-1" role="dialog">
						<div class="modal-dialog">
							<div class="modal-content">
								<div class="modal-header modal-mensaje-<?php echo $tipomensaje;?>" > <!-- modal-mensaje-success or modal-mensaje-error -->
									<button type="button" class="close" data-dismiss="modal" aria-label="Close">
										<span aria-hidden="true">&times;</span>
									</button>
									<h1 class="modal-title text-center">
										<?php if ($tipomensaje == 'success') {?>
											<img src="img/success-icon.png"> 
										<?php } else { ?>
											<img src="img/error-icon.png">
										<?php }?>
									</h1>
								</div>
								<div class="modal-body text-center">
									<p>  <?php echo $mensaje; ?></p>
								</div>
								<!-- <div class="modal-footer">
									<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
								</div> -->
							</div>
						</div>
					</div>
					<!-- Corpo de Caja -->
					<div class="box-body">
					<div class="col-md-12">
							<?php
							if (isset( $mensaje)) {
								echo $mensaje; 
							}

							?>

						</div>
						<div class="box-body table-responsive">
							<table class="table table-striped table-bordered display nowra" id="tabladatos">
							<thead>
								<tr>
									<th>#</th>
									<th>Nombre</th>
									<th>Descripción Corta</th>
									<th>Duración</th>
									<th>Matricula</th>
									<th>Cuota</th>
									<th>Estado</th>
								</tr>
							</thead>
							<tbody>
								<?php foreach ($result as $row) { ?>
								<tr data-toggle="modal" data-target="#AltModal" data-codigo="<?php echo e($row['id']);?>" data-nombre="<?php echo e($row['nombre']);?>" data-descripcion="<?php echo e($row['desc_corta']);?>" data-detallada="<?php echo e($row['desc_detallada']);?>"
									data-duracion="<?php echo e($row['duracion_meses']);?>" data-matricula="<?php echo e($row['valor_matrícula']);?>" data-cuota="<?php echo e($row['valor_cuota']);?>" data-estado="<?php echo e($row['activo']);?>">
									<td><?php echo e($row['id']);?></td>
									<td><?php echo e($row['nombre']);?></td>
									<td><?php echo e($row['desc_corta']);?></td>
									<td><?php echo e($row['duracion_meses']);?></td>
									<td><?php echo e($row['valor_matrícula']);?></td>
									<td><?php echo e($row['valor_cuota']);?></td>
									<td><?php
										$estado = "";
										if ($row['activo'] == 1) {
											$estado = "Activo";
										} else {
											$estado = "Inactivo";
										}
										echo $estado;?>
									</td>
								</tr>
								<?php }?>
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
		<?php ?>
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
					<h4 class="modal-title">Nuevo Curso</h4>
				</div>
				<form action="" method="POST"><?php echo csrf_field(); ?>
					<div class="modal-body">
						<div class="row">
							<div class="col-md-9">
								<div class="form-group">
									<label for="nombre">Nombre</label>
									<input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre del Curso" maxlength="50" required>
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
									<label for="descripcion">Descripción Corta</label>
									<textarea class="form-control" rows="2" id="descripcion" name="descripcion" required></textarea>
								</div>
							</div>
							<div class="col-md-12">
								<div class="form-group">
									<label for="descripcion">Descripción Detallada</label>
									<textarea class="form-control" rows="4" id="detallada" name="detallada"></textarea>
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label for="descripcion">Duración</label>
									<input type="text" class="form-control" id="duracion" name="duracion" placeholder="00 meses" maxlength="2" required>
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label for="descripcion">Matricula</label>
									<input type="text" class="form-control" id="matricula" name="matricula" placeholder="000.000" onKeyUp="formatoMoneda(this, event)" required>
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label for="" r="descripcion">Cuota Mensual</label>
									<input type="text" class="form-control" id="cuota" name="cuota" placeholder="000.000" onKeyUp="formatoMoneda(this, event)" required>
								</div>
							</div>
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
				<form action="" method="POST"><?php echo csrf_field(); ?>
					<div class="modal-body">
						<input type="hidden" class="form-control" id="codigo" name="codigo">
						<div class="col-md-9">
							<div class="form-group">
								<label for="nombre">Nombre</label>
								<input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre del Curso" maxlength="50" required>
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
								<label for="descripcion">Descripción Corta</label>
								<textarea class="form-control" rows="2" id="descripcion" name="descripcion"></textarea>
							</div>
						</div>
						<div class="col-md-12">
							<div class="form-group">
								<label for="descripcion">Descripción Detallada</label>
								<textarea class="form-control" rows="4" id="detallada" name="detallada"></textarea>
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label for="descripcion">Duración</label>
								<input type="text" class="form-control" id="duracion" name="duracion" placeholder="00 meses" maxlength="2" required>
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label for="descripcion">Matricula</label>
								<input type="text" class="form-control" id="matricula" name="matricula" placeholder="000.000" onKeyUp="formatoMoneda(this, event)" required>
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label for="" r="descripcion">Cuota Mensual</label>
								<input type="text" class="form-control" id="cuota" name="cuota" placeholder="000.000" onKeyUp="formatoMoneda(this, event)" required>
							</div>
						</div>
					</div>
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
		$('#AltModal').on('show.bs.modal', function (event) {
			var button = $(event.relatedTarget) // objeto que disparó el modal
			var codigo = button.data('codigo')
			var nombre = button.data('nombre')
			var descripcion = button.data('descripcion')
			var detallada = button.data('detallada')
			var duracion = button.data('duracion')
			var matricula = button.data('matricula')
			var cuota = button.data('cuota')
			var matricula = button.data('matricula')
			var estado = button.data('estado')

			// Actualiza los datos del modal
			var modal = $(this)
			modal.find('.modal-title').text('Curso ' + nombre)
			modal.find('#codigo').val(codigo)
			modal.find('#nombre').val(nombre)
			modal.find('#descripcion').val(descripcion)
			modal.find('#detallada').val(detallada)
			modal.find('#duracion').val(duracion)
			modal.find('#matricula').val(matricula)
			modal.find('#cuota').val(cuota)
			modal.find('#matricula').val(matricula)
			modal.find('#estado').val(estado)
		})

		// formato para campos moneda
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

		<?php if (isset($mensaje)) {?>
			$(document).ready(function(){
			$("#modal-mensaje").modal("show");
			});
		<?php
			unset($mensaje);
		} ?>
	</script>
</body>
</html>
