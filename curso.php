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
	<title>SSD - Cursos</title>
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
									<th>Duración</th>
									<th>Matricula</th>
									<th>Cuota</th>
									<th>Estado</th>
								</tr>
								<tr data-toggle="modal" data-target="#AltModal" data-codigo="1" data-nombre="Ballet Iniciante" data-descripcion="Ballet clásico para todas las edades." data-detallada="" data-duracion="12" data-matricula="50.000" data-cuota="250.000" data-estado="activo">
									<td>1</td>
									<td>Ballet Iniciante</td>
									<td>Ballet clásico para todas las edades.</td>
									<td>12 meses</td>
									<td>50.000 gs</td>
									<td>250.000 gs</td>
									<td>Activo</td>
								</tr>
								<tr data-toggle="modal" data-target="#AltModal" data-codigo="2" data-nombre="Danza Paraguaya" data-descripcion="Danza clásica paraguaya para niñas." data-detallada="Danza tradicional paraguaya con foco en las niñas." data-duracion="12" data-matricula="50.000" data-cuota="250.000" data-estado="vacaciones">
									<td>2</td>
									<td>Danza Paraguaya</td>
									<td>Danza clásica paraguaya para niñas.</td>
									<td>12 meses</td>
									<td>50.000 gs</td>
									<td>250.000 gs</td>
									<td>Vacaciones</td>
								</tr>
								<tr data-toggle="modal" data-target="#AltModal" data-codigo="3" data-nombre="Danza del Vientre" data-descripcion="Danza oriental muy elemental, prácticamente sin desplazamientos." data-detallada="Danza oriental muy elemental, prácticamente sin desplazamientos y con movimientos de cuadril." data-duracion="12" data-matricula="50.000" data-cuota="300.000" data-estado="inactivo">
									<td>3</td>
									<td>Danza del Vientre</td>
									<td>Danza oriental muy elemental, prácticamente sin desplazamientos.</td>
									<td>12 meses</td>
									<td>50.000 gs</td>
									<td>300.000 gs</td>
									<td>Inactivo</td>
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

	<!-- AddModal -->
	<div class="modal fade" tabindex="-1" role="dialog" id="AddModal">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title">Nuevo Curso</h4>
				</div>
				<div class="modal-body">
					<div class="row">
						<form action="" method="POST">
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
										<option value="activo">Activo</option>
										<option value="inactivo">Inactivo</option>
										<option value="vacaciones">Vacaciones</option>
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
						</form>
					</div> <!-- row -->
				</div> <!-- modal-body -->
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
					<h4 class="modal-title">Alterar Curso</h4>
				</div>
				<form action="" method="POST">
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
									<option value="activo">Activo</option>
									<option value="inactivo">Inactivo</option>
									<option value="vacaciones">Vacaciones</option>
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
	</script>
</body>
</html>