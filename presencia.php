<?php require __DIR__.'/server/presence-controller.php'; ?>
<!DOCTYPE html>
<html>
<head>
	<title>SSD - Presencia</title>
	<?php include 'includes/head.php'; ?>
</head>

<?php 
	
	
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

   
   $resultQuery = array("Miércoles","Sábado");



	
?>
<body class="hold-transition login-page">


	<div class="login-box" style="width: 80%;">
	<?php 
	if (isset( $mensaje)) {
		echo $mensaje; 
	}	
	
	?>
		<div class="login-logo">
		
	    
			<a href="#"><b>Bienvenido,  <?php echo e($_SESSION['nome_usuario']);?></b>!</a>
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
								
			
						$sql = 'SELECT * FROM horarios WHERE grupos_id = :auto1'; $sql_params = ['auto1' => $matricula['grupo_id']];
						$query = $connection->prepare($sql);
						$query->execute($sql_params);
						$grupos= $query->fetchAll();
				
						foreach ($grupos as $grupo) {					
									        
						
						$row = str_replace(['Miercoles','Sabado'],['Miércoles','Sábado'],$grupo['dia']);
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
								data-idhorario="<?php echo e($grupo['id']);?>" data-dia="<?php echo e($grupo['dia']);?> " 
								data-idmatricula="<?php echo $idmatricula;?>" data-idgrupo="<?php echo $idgrupo;?>"
								> 
									
									<div class="small-box bg-<?php echo $color;?> ">
										<input type="hidden" name="cod_horario" value="<?php echo $grupo['id']?>">
										<div class="inner">
											<h3 <?php echo $innerColor;?>><?php echo $grupo['grupos_cursos_id']."-".getCurso($grupo['grupos_cursos_id'])['nombre'] ?></h3>
											<p <?php echo $innerColor;?>>De  <?php echo e($grupo['hora_inicio']. " Hasta ". $grupo['hora_fin']);?></p>
										</div> <!-- inner -->
										<div class="icon" style="font-size: 5em;">
											<span style="line-height: 160px;"><b><?php echo e($grupo['dia']);	?></b></span>
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
	 			<a href="salir.php?asistencia=true" class="btn btn-lg btn-danger">Salir</a>
	 		</div>
	 		
			<!-- <p class="login-box-msg">29/09/2019</p> -->
			<br>
		</div> <!-- /.login-box-body -->
	</div><!-- /.login-box -->

	<!-- Modal para Otras Asistencias -->
	<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" id="mi-modal">
		<div class="modal-dialog modal-sm">
			<div class="modal-content">

			<form action="" method="POST"><?php echo csrf_field(); ?>

				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="myspan">¿Deseas registrar presencia?</h4>					
					<input type="text" id="txthorario" name="txthorario" class="hidden">	
					<input type="text" id="txtdia" name="txtdia" class="hidden">	
					<input type="text" id="txtidmatricula" name="txtidmatricula" class="hidden"> 	
					<input type="text" id="txtidgrupo" name="txtidgrupo" class="hidden">					
					
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