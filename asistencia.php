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
	<title>SSD - Asistencia</title>
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
					Asistencia Ballet Noche 1
					<small>Registro de presencia de los alumnos en las clases.</small>
				</h1>
			</section>

			<!-- Contenido Principal -->
			<section class="content">
				<!-- Caja de Texto de color gris (Default) -->
				<div class="box">
					<div class="box-header with-border">
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
									<th>Fecha</th>
									<th>Horario</th>
									<th>Alumno</th>
									<th>Faltas</th>
									<!-- <th>Estado</th> -->
								</tr>
								<tr data-toggle="modal" data-target="#AltModal" data-codigo="1" data-curso="ballet" data-dia="Lunes" data-fecha="30/09/2019 18:42" data-alumno="ana">
									<td>1</td>
									<td>07/10/2019</td>
									<td>18:49</td>
									<td>Ana Carolina</td>
									<td>0</td>
								</tr>
								<tr data-toggle="modal" data-target="#AltModal" data-codigo="2" data-curso="ballet" data-dia="Lunes" data-fecha="30/09/2019 18:52" data-alumno="viviana">
									<td>2</td>
									<td>07/10/2019</td>
									<td>18:52</td>
									<td>Viviana Paola</td>
									<td>1</td>
								</tr>
								<tr data-toggle="modal" data-target="#AltModal" data-codigo="3" data-curso="ballet" data-dia="Lunes" data-fecha="30/09/2019 18:59" data-alumno="gladys">
									<td>3</td>
									<td>07/10/2019</td>
									<td>Ausente</td>
									<td>Gladys Palacios</td>
									<td>1</td>
								</tr>
								<tr data-toggle="modal" data-target="#AltModal" data-codigo="1" data-curso="ballet" data-dia="Lunes" data-fecha="30/09/2019 18:42" data-alumno="ana">
									<td>1</td>
									<td>30/09/2019</td>
									<td>18:45</td>
									<td>Ana Carolina</td>
									<td>0</td>
								</tr>
								<tr data-toggle="modal" data-target="#AltModal" data-codigo="2" data-curso="ballet" data-dia="Lunes" data-fecha="30/09/2019 18:52" data-alumno="viviana">
									<td>2</td>
									<td>30/09/2019</td>
									<td>Ausente</td>
									<td>Viviana Paola</td>
									<td>1</td>
								</tr>
								<tr data-toggle="modal" data-target="#AltModal" data-codigo="3" data-curso="ballet" data-dia="Lunes" data-fecha="30/09/2019 18:59" data-alumno="gladys">
									<td>3</td>
									<td>30/09/2019</td>
									<td>18:59</td>
									<td>Gladys Palacios</td>
									<td>0</td>
								</tr>
							</table>
						</div>
					</div>
					<!-- /.box-body -->
				</div> <!-- box -->
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
	<div class="modal fade" tabindex="-1" role="dialog" id="AltModal">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title">Asistencia</h4>
				</div>
				<form action="" method="POST">
					<div class="modal-body">
						<div class="row">
							<input type="hidden" class="form-control" id="codigo" name="codigo">
							<div class="col-md-4">
								<div class="form-group">
									<label for="fecha">Fecha de Registro</label>
									<input type="text" class="form-control pull-right datepicker" id="fecha" name="fecha">
								</div>
							</div>
							<div class="col-md-8">
								<div class="form-group">
									<label for="dia">Curso</label>
									<select class="form-control" id="curso" name="curso">
										<option value="ballet">Ballet</option>
										<option value="paraguaya">Danza Paraguaya</option>
										<option value="vientre">Danza del Vientre</option>
									</select>
								</div>
							</div>
							<div class="col-md-12">
								<div class="form-group">
									<label for="alumno">Alumno</label>
									<select class="form-control" id="alumno" name="alumno">
										<option value="ana">Ana Carolina dos Anjos</option>
										<option value="gladys">Gladys Palácios</option>
										<option value="viviana">Viviana Paola Peixoto</option>
									</select>
								</div>
							</div>
							<div class="col-md-12">
								<div class="form-group">
									<label for="horario">Horario</label>
									<select class="form-control" id="horario" name="horario">
										<option>Lunes de 18:00 hasta 19:00</option>
										<option>Martes de 08:00 hasta 09:00</option>
										<option>Miercoles de 18:00 hasta 19:00</option>
										<option>Jueves de 08:00 hasta 09:00</option>
										<option>Sabado de 08:00 hasta 11:00</option>
									</select>
								</div>
							</div>							
						</div> <!-- row -->
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
	<!-- ./AddModal -->

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
			var curso = button.data('curso')
			var dia = button.data('dia')
			var fecha = button.data('fecha')
			var alumno = button.data('alumno')
			
			// Actualiza los datos del modal 
			var modal = $(this)
			modal.find('.modal-title').text('Horario ' + codigo)
			modal.find('#codigo').val(codigo)
			modal.find('#curso').val(curso)
			modal.find('#dia').val(dia)
			modal.find('#fecha').val(fecha)
			modal.find('#alumno').val(alumno)
		})

		$('#fecha').daterangepicker({ timePicker: true, timePickerIncrement: 30, singleDatePicker: true, locale: { format: 'DD/MM/YYYY hh:mm A' }})

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