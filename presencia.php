<?php 
	session_start();
	// var_dump($_SESSION['usuario']);
	if (!isset($_SESSION['logueado'])) {
		header('Location: login.php');
	}

	require 'server/conn.php';


	$idalumno = $_SESSION['id']	; //OBTENER DE SESION DE LOGUIN
	
	function getCurso($idcurso){
		require 'server/conn.php';
		$sql = "SELECT * FROM cursos WHERE id = $idcurso";
		$query = $connection->prepare($sql);
		$query->execute();
		return $query->fetch();	
	}

	
	
	$sql = "SELECT * FROM matricula WHERE id_alumnos = $idalumno";
	$query = $connection->prepare($sql);
	$query->execute();
	$matriculas= $query->fetchAll();
	



	/*
	foreach ($matriculas as $row) {
		echo "ID Matricula ".$row['id'];
		echo "<br> --------------------------";

		$sql = "SELECT * FROM horarios WHERE grupos_id = ".$row['grupo_id'];
		$query = $connection->prepare($sql);
		$query->execute();
		$grupos= $query->fetchAll();

		foreach ($grupos as $grupo) {
			echo "<br>CURSO ID::".$grupo['grupos_cursos_id'].getCurso($grupo['grupos_cursos_id'])['nombre'];
			echo "<br>DIAS::".$grupo['dia'];
			echo "<br>HORA INICIO::".$grupo['hora_inicio'];
			echo "<br> HORA FIN::".$grupo['hora_fin'];
		}
	}

	*/


	
?>
<!DOCTYPE html>
<html>
<head>
	<title>SSD - Presencia</title>
	<?php include 'includes/head.php'; ?>
</head>

<?php 
	// setlocale(LC_ALL, "es_ES", 'Spanish_Spain', 'Spanish');
	// echo iconv('ISO-8859-2', 'UTF-8', strftime("%A, %d de %B de %Y", strtotime($row['date'])));
   date_default_timezone_set('America/Asuncion');
   $ano = date('Y');
   $mes = date('n');
   $dia = date('d');
   $diasemana = date('w');
   $diassemanaN= array("Domingo","Lunes","Martes","Miércoles",
				  "Jueves","Viernes","Sábado");
				  
   $mesesN=array(1=>"Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio",
			 "Agosto","Septiembre","Octubre","Noviembre","Diciembre");
			 
   $data = $diassemanaN[$diasemana].", $dia de ". $mesesN[$mes] ." de $ano";

   //$resultQuery = array("Miércoles","Sábado");
   $resultQuery = array("Miércoles","Sábado");



	//INSERT PRESENCIA
   if($_SERVER['REQUEST_METHOD'] == "POST") {
	
	if (isset($_POST['presencia'])){
		$idhorariopresencia=$_POST['txthorario'];
		$dia=$_POST['txtdia'];
		$idmatricula=$_POST['txtidmatricula'];
		$idgrupo=$_POST['txtidgrupo'];
			
		try {
			$sql = "INSERT INTO asistenciaS (matricula_id, matricula_id_alumnos, matricula_grupo_id, horarios_id, dia,  horario, fecha_add)
			VALUES ('$idmatricula', '$idalumno', '$idgrupo',  '$idhorariopresencia', '$dia',  NOW(), NOW())";
			$query = $connection->prepare($sql);
			$query->execute();
			$mensaje = '<div class="alert alert-success">PRESENCIA REGISTRADA CORRECTAMENTE</div>';
		} catch (Exception $e) {
			$mensaje= '<div class="alert alert-danger">Presencia NO registrada - Consulte al administrador de sistemas. Error->"'.$e.'</div>'; 

			
		}	
		
	}
}



?>
<body class="hold-transition login-page">


	<div class="login-box" style="width: 80%;">
	<?php 
	if (isset( $mensaje)) {
		echo $mensaje; //alert mensaje
	}	
	
	?>
		<div class="login-logo">
		
	    
			<a href="#"><b>Bienvenido,  <?php echo $_SESSION['nome_usuario'];?></b>!</a>
		</div> <!-- /.login-logo -->

		<div class="login-box-body">
			<div class="text-center">
				<h3><?php echo $data." ".date('H:i:s A');?></h3>	
			</div>
			<br>
			<br>
			<div class="row">
				<?php
				foreach ($matriculas as $matricula) {
					   $idmatricula= $matricula['id'];
					   $idgrupo= $matricula['grupo_id'];
								
			
						$sql = "SELECT * FROM horarios WHERE grupos_id = ".$matricula['grupo_id'];
						$query = $connection->prepare($sql);
						$query->execute();
						$grupos= $query->fetchAll();
				
						foreach ($grupos as $grupo) {					
									        //foreach ($resultQuery as $row) {
						//var_dump(substr($data, 0, strpos($data, ',')));
						$row = $grupo['dia'];
						if (substr($data, 0, strpos($data, ',')) == $row) {
							$color = "green";
							$text = "¿Deseas registrar presencia?";
							$innerColor = '';
							$disabled = "";
						} else {
							$color = "default";
							$text = "¿Estás seguro que desea registrar presencia hoy?";
							$innerColor = ' style="color: #666"';
							$disabled = " disabled";
						}	
						?>
					
						   <div class="col-lg-6 col-xs-12">
								<a href="#" data-toggle="modal" <?php if ($disabled == "") { echo 'data-target="#mi-modal"'; }?>  data-text="<?php echo $text;?>" 
								data-idhorario="<?php echo $grupo['id'];?>" data-dia="<?php echo $grupo['dia'];?> " 
								data-idmatricula="<?php echo $idmatricula;?>" data-idgrupo="<?php echo $idgrupo;?>"
								> 
									
									<div class="small-box bg-<?php echo $color;?> ">
										<input type="hidden" name="cod_horario" value="<?php echo $grupo['id']?>">
										<div class="inner">
											<h3 <?php echo $innerColor;?>><?php echo $grupo['grupos_cursos_id']."-".getCurso($grupo['grupos_cursos_id'])['nombre'] ?></h3>
											<p <?php echo $innerColor;?>>De  <?php echo $grupo['hora_inicio']. " Hasta ". $grupo['hora_fin'];?></p>
										</div> <!-- inner -->
										<div class="icon" style="font-size: 5em;">
											<span style="line-height: 160px;"><b><?php echo $grupo['dia'];	?></b></span>
										</div> <!-- icon -->
										<span class="small-box-footer">
										<?php if ($disabled == "") {  ?>
											Registrar Presencia <i class="fa fa-arrow-circle-right"></i></span>
											<?php }else{ ?>
											</span>
											<?php }
										 ?>
									</div> <!-- small-box -->
								</a>
							</div> <!-- div col-lg-3 col-xs-6 -->	

				<?php
				}

			}
				
				?>
	 		</div>
	 		<br>
	 		<div class="row text-center">
	 			<a href="salir.php" class="btn btn-lg btn-danger">Salir</a>
	 		</div>
	 		
			<!-- <p class="login-box-msg">29/09/2019</p> -->
			<br>
		</div> <!-- /.login-box-body -->
	</div><!-- /.login-box -->

	<!-- Modal para Otras Asistencias -->
	<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" id="mi-modal">
		<div class="modal-dialog modal-sm">
			<div class="modal-content">

			<form action="" method="POST">

				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="myspan">¿Deseas registrar presencia?</h4>					
					<input type="text" id="txthorario" name="txthorario">	
					<input type="text" id="txtdia" name="txtdia">	
					<input type="text" id="txtidmatricula" name="txtidmatricula">	
					<input type="text" id="txtidgrupo" name="txtidgrupo">					
					
				</div>
				<!-- <div class="modal-body">
					<span id="myspan"></span>
				</div> -->
				<div class="modal-footer">
					<input type="submit" class="btn btn-default" id="modal-btn-si" name="presencia" value="SI">
					<button type="button" class="btn btn-primary" id="modal-btn-no" data-dismiss="modal">No</button>
				</div>

				</form>
				
			</div>
		</div>
	</div>
	<!-- Confirmación Modal (para excluisiones) -->

	<!-- SCRIPTS (js) -->
	<?php include "includes/scripts.php"; ?>
	<!-- ./SCRIPTS (js) -->
	<script type="text/javascript">
		$('#mi-modal').on('show.bs.modal', function (event) {
			var button = $(event.relatedTarget) // objeto que disparó el modal
			var text = button.data('text') ;			
			span = document.getElementById("myspan");
			span.innerText = span.textContent = text;
			
			
			var codigo = button.data('idhorario');
			var dia = button.data('dia');
			var idgrupo = button.data('idgrupo');
			var idmatricula = button.data('idmatricula');
			
			var modal = $(this)
			modal.find('#txthorario').val(codigo);
			modal.find('#txtdia').val(dia);
			modal.find('#txtidmatricula').val(idmatricula);
			modal.find('#txtidgrupo').val(idgrupo)
			

		})
	</script>

	<script>
	function deshabilitar( link ){
    link.style.pointerEvents = 'none';
    link.style.color = '#bbb';

    setTimeout(function(){
        link.style.pointerEvents = null;
        link.style.color = 'blue';
    }, 3000);
}</script>
</body>
</html>