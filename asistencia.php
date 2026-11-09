<?php require_once __DIR__.'/server/bootstrap.php'; auth('admin'); 
 $fechaInicio = $fechaFin = 0;
	


	
	
	
	require 'server/conn.php';
	$idgrupo=-1;
	if (isset($_GET['id'])) {
		$idgrupo=$_GET['id'];
	}	
	

	function saber_dia($nombredia) {
		$dias = array('Domingo','Lunes','Martes','Miercoles','Jueves','Viernes','Sabado');
		$fecha = $dias[date('w', strtotime($nombredia))];
		
		if (isset($fecha)) {
			return $fecha;
		}
		
	}
	
	function gethorarios($id){
		require 'server/conn.php';
		$sql = 'SELECT * FROM horarios WHERE grupos_id = :auto1'; $sql_params = ['auto1' => $id];
		$query = $connection->prepare($sql);
		$query->execute($sql_params);
		return $query->fetchAll();

	}

	function getAlumno($id){
		require 'server/conn.php';
		$sql = 'SELECT * FROM alumnos WHERE id = :auto1'; $sql_params = ['auto1' => $id];
		$query = $connection->prepare($sql);
		$query->execute($sql_params);
		return $query->fetch();

	}
		
		
	

	



		
		

	

?>
<!DOCTYPE html>
<html>
<head>
	<title>SSD - Asistencia</title>
	<?php include 'includes/head.php'; ?>
</head>
<body class="hold-transition skin-yellow sidebar-mini">
	<div class="wrapper">
		<!-- MAIN HEADER -->
		<?php include 'includes/header.php'; ?>
		<!-- MAIN HEADER END -->
		<?php

			$sql = 'SELECT *	FROM vista_alumnos where idgrupo= :auto1'; $sql_params = ['auto1' => $idgrupo];
			$query = $connection->prepare($sql);
			$query->execute($sql_params);
			$alumnos= $query->fetchAll();

			if (isset($_POST['fecha_inicio']) && isset($_POST['fecha_fin'])) {
				$f1= str_replace('/', '-', $_POST['fecha_inicio']);
				$f2=str_replace('/', '-', $_POST['fecha_fin']);
				$fechaInicio=date('Y-m-d',strtotime($f1));
				$fechaFin=date('Y-m-d',strtotime($f2));
				$fechaInicio = strtotime($fechaInicio);
				$fechaFin = strtotime($fechaFin);
			}

 


 
 
 
 

 
 
	 
	 
	  
 
		?>
		<!-- ASIDE BAR -->
		<?php include 'includes/aside.php'; ?>
		<!-- ASIDE BAR END -->

		<!-- Content Wrapper. Contains page content -->
		<div class="content-wrapper">
			<!-- Cabicera de Contenido (Título) -->
			<section class="content-header">
				<h1>
					<small>Filtrando Desde <?php echo e(($_POST['fecha_inicio'] ?? '')." hasta ".($_POST['fecha_fin'] ?? ''));?></small>
				</h1>
			</section>

			<!-- Contenido Principal -->
			<section class="content">
				<!-- Caja de Texto de color gris (Default) -->
				<div class="box">
					<div class="box-header with-border">
						<!-- Caja de Busqueda -->
						<form action="" method="post"><?php echo csrf_field(); ?>
							<div class="col-md-2">
								<div class="form-group">
									<label for="fecha_fin">Fecha Desde</label>
									<input type="text" class="form-control pull-right datepicker" id="fecha_inicio" name="fecha_inicio">
								</div>
							</div>
							<div class="col-md-2">
								<div class="form-group">
									<label for="fecha_fin">Fecha Hasta</label>
									<input type="text" class="form-control pull-right datepicker" id="fecha_fin" name="fecha_fin">
								</div>
							</div>
							<div class="col-md-2">
							<br>
								<input type="submit" class="btn btn-primary" value="Buscar">
							</div>
						</form>
						
					</div>
					<!-- Corpo de Caja -->
					<div class="box-body">
						<div class="box-body table-responsive">

			<table class="table table-striped table-bordered display nowra" id="tabladatos">
				<thead>

				
			<tr>
			   <th>Fecha</th>
				<th>Cod-Alumno</th>
				<th>Alumno</th>
				<th>Dia Marcado</th>
				<th>Fecha Maracada</th>
				<th>Hora</th>
				<th>Presencia</th>
			</tr>
			</thead>
			<tbody>			
			<?php
			$horarios = gethorarios($idgrupo);
			foreach ($horarios as $horario) {
				if ($horario['dia'] == "Lunes") {
					$lunes = $horario['dia'];
				} 
				if ($horario['dia'] == "Martes") {
					$martes = $horario['dia'];
				} 
				if ($horario['dia'] == "Miercoles") {
					$miercoles = $horario['dia'];
				} 
				if ($horario['dia'] == "Jueves") {
					$jueves = $horario['dia'];
				} 
				if ($horario['dia'] == "Viernes") {
					$viernes = $horario['dia'];
				} 
				if ($horario['dia'] == "Sabado") {
					$sabado = $horario['dia'];
				} 
				if ($horario['dia'] == "Domingo") {
					$domingo = $horario['dia'];
				} 

			}
			
			for($i=$fechaInicio; $i<=$fechaFin; $i+=86400){
				$fechai = date("Y-m-d", $i);
				$dia = saber_dia(date("Y-m-d", $i));		

				if ((isset($lunes) && $lunes == $dia) || (isset($martes) && $martes == $dia) 
				|| (isset($miercoles) && $miercoles == $dia) || isset($jueves) && $jueves == $dia 
				|| isset($viernes) && $viernes == $dia || isset($sabado) && $sabado == $dia 
				|| isset($domingo) && $domingo == $dia) {
					
				
				foreach ($alumnos as $alumno) {
					$idalumno = $alumno['idalumno'];
					$fechaInicio = $alumno['fecha_inicio'];
		
					$sql = 'SELECT *	FROM informe_presencia where idalumno= :auto1 AND fecha_marcacion=:auto2 AND idgrupo=:auto3'; $sql_params = ['auto1' => $idalumno, 'auto2' => $fechai, 'auto3' => $idgrupo];
					$query = $connection->prepare($sql);
					$query->execute($sql_params);
					$asistencia= $query->fetch();
					if ($fechai >= $fechaInicio) {
								
					
					if ($asistencia) { ?>
					<!--tr class="bg-success" data-toggle="modal" data-target="#AltModal" data-codigo="1" data-curso="ballet" data-dia="Lunes" data-fecha="30/09/2019 18:42" data-alumno="ana"-->
				    <tr>

					 	<td><?php echo $fechai?><!-- -<?php ?> --></td>
					    <td><?php echo e($asistencia['idalumno']); ?></td>
						<td><?php echo e($asistencia['nombrealumno']." ".$asistencia['apellidoalumno']); ?></td>
						<td><?php echo e($asistencia['diamarcado']); ?></td>
						<td><?php echo e($asistencia['fecha_marcacion']); ?></td>
						<td><?php echo e($asistencia['hora_de_marcacion']); ?></td>
						<td><?php echo e($asistencia['asistencia']); ?></td>
				   </tr>
					<?php } else { ?>
						<!--tr class ="bg-danger" data-toggle="modal" data-target="#AltModal" data-codigo="1" data-curso="ballet" data-dia="Lunes" data-fecha="30/09/2019 18:42" data-alumno="ana"-->
					<tr>
						<td><?php echo $fechai?></td>
						<td><?php echo $idalumno ?></td>
						<td><?php echo getAlumno($idalumno)['nombre']." ".getAlumno($idalumno)['apellido'] ?></td>
						
						<td><?php echo "-"?></td>
						<td><?php echo "-"?></td>
						<td><?php echo "-"?></td>
						<td><?php echo "A"?></td>

					</tr>
					
					<?php } 

					}
					
					
				}
			}
			}

				?>
			</tbody>
			</table>


			</div>
			</div>
			</div>
				<!-- Caja de Texto de color gris (Default) -->
				
				
			</section>
			<!-- ./ content -->
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
	<div class="modal fade" tabindex="-1" role="dialog" id="AltModal">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title">Asistencia</h4>
				</div>
				<form action="" method="POST"><?php echo csrf_field(); ?>
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

		//$('#fecha').daterangepicker({ timePicker: true, timePickerIncrement: 30, singleDatePicker: true, locale: { format: 'DD/MM/YYYY hh:mm A' }})
		//$('#fecha_fin').datepicker('setEndDate', new Date());
		
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