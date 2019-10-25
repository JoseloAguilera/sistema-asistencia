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
									<th>Alumno</th>
									<th>Fecha de Inicio</th>
									<th>Valor de Matricula</th>
									<th>Valor de Cuota</th>
									<th>Estado</th>
								</tr>
								<tr data-toggle="modal" data-target="#AltModal" data-codigo="1" data-curso="Ballet" data-dia="Lunes de 18:00 hasta 19:00&Miercoles de 18:00 hasta 19:00" data-fechainicio="29/03/2019" data-valmatricula="25.000" data-valcuota="200.000" data-estado="activo">
									<td>1</td>
									<td>Ballet</td>
									<td>Ana Carolina dos Anjos</td>
									<td>29/03/2019</td>
									<td>25.000</td>
									<td>200.000</td>
									<td>Activo</td>
								</tr>
								<tr data-toggle="modal" data-target="#AltModal" data-codigo="2" data-curso="Ballet" data-dia="lunes&miercoles" data-fechainicio="29/03/2019" data-valmatricula="25.000" data-valcuota="200.000" data-estado="activo">
									<td>2</td>
									<td>Ballet</td>
									<td>Viviana Paola Peixoto</td>
									<td>29/03/2019</td>
									<td>25.000</td>
									<td>200.000</td>
									<td>Activo</td>
								</tr>
								<tr data-toggle="modal" data-target="#AltModal" data-codigo="3" data-curso="Danza Paraguaya" data-dia="martes&jueves" data-fechainicio="04/05/2019" data-valmatricula="35.000" data-valcuota="250.000" data-estado="activo">
									<td>3</td>
									<td>Ballet</td>
									<td>Gladys Palácios</td>
									<td>04/05/2019</td>
									<td>35.000</td>
									<td>250.000</td>
									<td>Activo</td>
								</tr>
								<tr data-toggle="modal" data-target="#AltModal" data-codigo="4" data-curso="Danza Paraguaya" data-dia="sabado" data-fechainicio="29/03/2019" data-valmatricula="25.000" data-valcuota="200.000" data-estado="activo">
									<td>4</td>
									<td>Danza Paraguaya</td>
									<td>Viviana Paola Peixoto</td>
									<td>29/03/2019</td>
									<td>25.000</td>
									<td>200.000</td>
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
									<label for="dia">Alumno</label>
									<select class="form-control" id="curso" name="curso">
										<option value="ballet">Ana Carolina dos Anjos</option>
										<option value="paraguaya">Gladys Palácios</option>
										<option value="vientre">Viviana Paola Peixoto</option>
									</select>
								</div>
							</div>
							<div class="col-md-8">
								<div class="form-group">
									<label for="salida">Horario</label>
									<select multiple class="form-control" id="horario" name="horario">
										<option>Lunes de 18:00 hasta 19:00</option>
										<option>Martes de 08:00 hasta 09:00</option>
										<option>Miercoles de 18:00 hasta 19:00</option>
										<option>Jueves de 08:00 hasta 09:00</option>
										<option>Sabado de 08:00 hasta 11:00</option>
									</select>
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label for="valmatricula">Valor Matrícula</label>
									<input type="text" class="form-control" id="valmatricula" name="valmatricula">
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label for="valcuota">Valor Cuota</label>
									<input type="text" class="form-control" id="valcuota" name="valcuota">
								</div>
							</div>
						</div> <!-- row -->
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
						<button type="submit" class="btn btn-primary" name="guardar">Guardar</button>
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
						<div class="row">
							<div class="col-md-4">
								<div class="form-group">
									<label for="fechainicio">Fecha de Inicio</label>
									<input type="text" class="form-control pull-right datepicker" id="fechainicio" name="fechainicio">
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
									<label for="dia">Alumno</label>
									<select class="form-control" id="curso" name="curso">
										<option value="ana">Ana Carolina dos Anjos</option>
										<option value="gladys">Gladys Palácios</option>
										<option value="viviana">Viviana Paola Peixoto</option>
									</select>
								</div>
							</div>
							<div class="col-md-8">
								<div class="form-group">
									<label for="salida">Horario</label>
									<select multiple class="form-control" id="horario" name="horario">
										<option value="lunes">Lunes de 18:00 hasta 19:00</option>
										<option value="martes">Martes de 08:00 hasta 09:00</option>
										<option value="miercoles">Miercoles de 18:00 hasta 19:00</option>
										<option value="jueves">Jueves de 08:00 hasta 09:00</option>
										<option value="sabado">Sabado de 08:00 hasta 11:00</option>
									</select>
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label for="valmatricula">Valor Matrícula</label>
									<input type="text" class="form-control" id="valmatricula" name="valmatricula" placeholder="000.000" onKeyUp="formatoMoneda(this, event)" required>
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label for="valcuota">Valor Cuota</label>
									<input type="text" class="form-control" id="valcuota" name="valcuota" placeholder="000.000" onKeyUp="formatoMoneda(this, event)" required>
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
			var dia = button.data('dia')
			var dias = dia.split("&")
			var fechainicio = button.data('fechainicio')
			var valmatricula = button.data('valmatricula')
			var valcuota = button.data('valcuota')
			var estado = button.data('estado')
			
			// Actualiza los datos del modal 
			var modal = $(this)
			var selectObj = document.getElementById("horario")
			
			modal.find('.modal-title').text('Horario ' + codigo)
			modal.find('#codigo').val(codigo)

			for (var x = 0; x < dias.length; x++) {
				for(var i = 0; i < selectObj.options.length; i++) {
					// opt = selectObj.options[i];
					// console.log(opt.value)
					if(selectObj.options[i].value === dias[x]) {
						console.log(selectObj.options[i].value + " - " + dias[x])
						selectObj.options[i].selected = true;
					} else {
						selectObj.options[i].selected = false;
					}
				}
			}
			
			// modal.find('#horario').val(dia)
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