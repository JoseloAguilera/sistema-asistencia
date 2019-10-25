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

   $resultQuery = array("Miércoles","Sábado");
?>
<body class="hold-transition login-page">
	<div class="login-box" style="width: 80%;">
		<div class="login-logo">
			<a href="#"><b>Bienvenido, <?php echo $_SESSION['nome_usuario'];?></b>!</a>
		</div> <!-- /.login-logo -->

		<div class="login-box-body">
			<div class="text-center">
				<h3><?php echo $data." ".date('H:i:s A');;?></h3>	
			</div>
			<br>
			<br>
			<div class="row">
				<?php
					foreach ($resultQuery as $row) {
						//var_dump(substr($data, 0, strpos($data, ',')));
						if (substr($data, 0, strpos($data, ',')) == $row) {
							$color = "green";
							$text = "¿Deseas registrar presencia?";
							$innerColor = '';
						} else {
							$color = "default";
							$text = "¿Estás seguro que desea registrar presencia hoy?";
							$innerColor = ' style="color: #666"';
						}	
				?>
				<div class="col-lg-6 col-xs-12">
					<a href="#" data-toggle="modal" data-target="#mi-modal" data-text="<?php echo $text;?>"> 
						<div class="small-box bg-<?php echo $color;?>">
							<input type="hidden" name="cod_horario" value="1">
							<div class="inner">
								<h3 <?php echo $innerColor;?>>Ballet</h3>
								<p <?php echo $innerColor;?>>De 19:00 hasta 20:00</p>
							</div> <!-- inner -->
							<div class="icon" style="font-size: 5em;">
								<span style="line-height: 160px;"><b><?php echo $row;	?></b></span>
							</div> <!-- icon -->
							<span class="small-box-footer">Registrar Presencia <i class="fa fa-arrow-circle-right"></i></span>
						</div> <!-- small-box -->
					</a>
				</div> <!-- div col-lg-3 col-xs-6 -->	
				<?php
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
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="myspan">¿Deseas registrar presencia?</h4>
				</div>
				<!-- <div class="modal-body">
					<span id="myspan"></span>
				</div> -->
				<div class="modal-footer">
					<button type="button" class="btn btn-default" id="modal-btn-si">Sí</button>
					<button type="button" class="btn btn-primary" id="modal-btn-no" data-dismiss="modal">No</button>
				</div>
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
			var text = button.data('text') 
			
			span = document.getElementById("myspan");
			span.innerText = span.textContent = text;

		})
	</script>
</body>
</html>