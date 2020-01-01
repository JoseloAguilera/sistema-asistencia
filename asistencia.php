<?php 
	session_start();


	// var_dump($_SESSION['usuario']);
	if (!isset($_SESSION['logueado'])) {
		header('Location: login.php');
	}
	if (isset($_SESSION['logueado']) && $_SESSION['tipo_login'] == 'alumno' ) {
		header('Location: presencia.php');
	}
	require 'server/conn.php';
	$idgrupo=-1;
	if (isset($_GET['id'])) {
		$idgrupo=$_GET['id'];
	}	
	/*$sql="SELECT * FROM horarios WHERE grupos_id = $idgrupo" ;
	$query = $connection->prepare($sql);
	$query->execute();
	$horarios= $query->fetchAll();
*/// Desactivar toda notificación de error
error_reporting(0);
	function saber_dia($nombredia) {
		$dias = array('Domingo','Lunes','Martes','Miercoles','Jueves','Viernes','Sabado');
		$fecha = $dias[date('N', strtotime($nombredia))];
		
		if (isset($fecha)) {
			return $fecha;
		}
		
	}
	
	function gethorarios($id){
		require 'server/conn.php';
		$sql="SELECT * FROM horarios WHERE grupos_id = '$id'";
		$query = $connection->prepare($sql);
		$query->execute();
		return $query->fetchAll();

	}

	function getAlumno($id){
		require 'server/conn.php';
		$sql="SELECT * FROM alumnos WHERE id = '$id'";
		$query = $connection->prepare($sql);
		$query->execute();
		return $query->fetch();

	}
		// ejecutamos la función pasándole la fecha que queremos
		//saber_dia('2015-03-13');
	

	/*$sql="SELECT *	FROM informe_presencia WHERE idgrupo = ".$idgrupo ;
	$query = $connection->prepare($sql);
	$query->execute();
	$presencias= $query->fetchAll();*/



		//echo "LA FECHAS ES".saber_dia(date("d-m-Y", $i)).date("d-m-Y", $i)."<br>";
		//

	/* recorrer fechas
     $fechaInicio=strtotime("18-11-2019");
	$fechaFin=strtotime("23-11-2019");
	for($i=$fechaInicio; $i<=$fechaFin; $i+=86400){
	echo "LA FECHAS ES".saber_dia(date("d-m-Y", $i)).date("d-m-Y", $i)."<br>";
	}

	*/
/*
	$sql="SELECT 
	m.id as idalumno,
	p.nombrealumno,
	p.apellidoalumno,
	p.hora_de_marcacion,
	p.diamarcado
	FROM matricula m
	LEFT JOIN informe_presencia p ON m.grupo_id = p.idgrupo
	WHERE m.grupo_id = ".$idgrupo ;
	$query = $connection->prepare($sql);
	$query->execute();
	$result= $query->fetchAll();	
    
	/*foreach ($result as $row) {
		echo $row['nombrealumno']." ".$row['apellidoalumno']." - ".$row['hora_de_marcacion']." - ".$row['diamarcado']."<br>";
		
	
	}*/
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

$sql="SELECT *	FROM vista_alumnos where idgrupo= ".$idgrupo;
 $query = $connection->prepare($sql);
 $query->execute();
 $alumnos= $query->fetchAll();
 
 if (isset($_POST['fecha_inicio']) && isset($_POST['fecha_fin'])) {
	 $f1= str_replace('/', '-', $_POST['fecha_inicio']);
	 $f2=str_replace('/', '-', $_POST['fecha_fin']);
	 $fechaInicio=date('Y-m-d',strtotime($f1));
	 $fechaFin=date('Y-m-d',strtotime($f2));
	 $fechaInicio = strtotime($fechaInicio);
	 $fechaFin = strtotime($fechaFin);


	
 }

 /*
 $fechaInicio=strtotime("2019-11-17"); 
 $fechaFin=strtotime("2019-12-08");
 */


 
 //$count=count($asistencias);
 //echo "total".$count;
 //VERIFICAR SI HAY ASISTENCIAS EN ESE DIA

 //if fecha marcasion es igual a nulo, entonces ausente
 
	 //foreach ($asistencias as $asistencia) {
	 //	echo $asistencia['nombrealumno']." ".$asistencia['apellidoalumno']." - ".$asistencia['hora_de_marcacion']." - ".$asistencia['diamarcado']." - ".$asistencia['fecha_marcacion']."<br>"."<br>";
	  //}
 
	 


?>
		<!-- ASIDE BAR -->
		<?php include 'includes/aside.php'; ?>
		<!-- ASIDE BAR END -->

		<!-- Content Wrapper. Contains page content -->
		<div class="content-wrapper">
			<!-- Cabicera de Contenido (Título) -->
			<section class="content-header">
				<h1>
				
					<small>Filtrando Desde <?php  
					echo $_POST['fecha_inicio']." hasta ".$_POST['fecha_fin'].$di.$df;
				?></small>
				</h1>

				
			</section>

			<!-- Contenido Principal -->
			<section class="content">
	<!-- Caja de Texto de color gris (Default) -->
	<div class="box">
					<div class="box-header with-border">
						<!-- Caja de Busqueda -->
						<form action="" method="post">
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
								<input type="submit" class="btn btn-success">
							</div>
						</form>
						
					</div>
					<!-- Corpo de Caja -->
					<div class="box-body">
						<div class="box-body table-responsive">

			<table class="table table-striped table-bordered display nowra" id="tabladatos">
				<thead>

				
			<tr>
			   <th>FECHA</th>
				<th>COD-ALUMNO</th>
				<th>ALUMNO</th>
				<th>DIA MARCADO</th>
				<th>FECHA MARCADA</th>
				<th>HORA</th>
				<th>PRESENCIA</th>
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
			//recorremos el filtro de fechas
			for($i=$fechaInicio; $i<=$fechaFin; $i+=86400){
				$fechai = date("Y-m-d", $i);
				$dia = saber_dia(date("Y-m-d", $i));		

				if ((isset($lunes) && $lunes == $dia) || (isset($martes) && $martes == $dia) 
				|| (isset($miercoles) && $miercoles == $dia) || isset($jueves) && $jueves == $dia 
				|| isset($viernes) && $viernes == $dia || isset($sabado) && $sabado == $dia 
				|| isset($domingo) && $domingo == $dia) {
					
				//echo $fechai."----------------------------------------------<br>";
				foreach ($alumnos as $alumno) {
					$idalumno = $alumno['idalumno'];
					$fechaInicio = $alumno['fecha_inicio'];
		
					$sql="SELECT *	FROM informe_presencia where idalumno= '$idalumno' AND fecha_marcacion='$fechai' AND idgrupo='$idgrupo'";
					$query = $connection->prepare($sql);
					$query->execute();
					$asistencia= $query->fetch();
					if ($fechai >= $fechaInicio) {
								
					//si encuentra una asistencia marcada y si la fecha de inicio es mayor a la fecha buscada
					if ($asistencia) { ?>
					<!--tr class="bg-success" data-toggle="modal" data-target="#AltModal" data-codigo="1" data-curso="ballet" data-dia="Lunes" data-fecha="30/09/2019 18:42" data-alumno="ana"-->
				    <tr>

					 	<td><?php echo $fechai?>-<?php echo $fechaInicio?></td>
					    <td><?php echo $asistencia['idalumno']?></td>
						<td><?php echo $asistencia['nombrealumno']." ".$asistencia['apellidoalumno']?></td>
						<td><?php echo $asistencia['diamarcado']?></td>
						<td><?php echo $asistencia['fecha_marcacion']?></td>
						<td><?php echo $asistencia['hora_de_marcacion']?></td>
						<td><?php echo $asistencia['asistencia']?></td>
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