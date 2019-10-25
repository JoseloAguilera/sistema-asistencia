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
	<title>SSD - Alumnos</title>
	<?php include 'includes/head.php'; ?>
</head>
<body class="hold-transition skin-blue sidebar-mini">
	<div class="wrapper">
		<!-- MAIN HEADER -->
		<?php include 'includes/header.php';
		require 'server/conn.php'?>
		<!-- MAIN HEADER END -->
		<?php
	  $sql = "SELECT * from alumnos ORDER by id DESC";
	  $query = $connection->prepare($sql);
	  $query->execute();
	  $result= $query->fetchAll();
	  ?>
		<!-- ASIDE BAR -->
		<?php include 'includes/aside.php'; ?>
		<!-- ASIDE BAR END -->

		<!-- Content Wrapper. Contains page content -->
		<div class="content-wrapper">
			<!-- Cabicera de Contenido (Título) -->
			<section class="content-header">
				<h1>
					Alumnos
					<small>Registro de los alumnos de la academia de danza.</small>
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
								<th>Apellido</th>
								<th>Razón Social</th>
								<th>RUC</th>
								<th>Teléfono</th>
								<th>Fecha Nascimiento</th>
								<th>Estado</th>
								<th>Acciones</th>
							</tr>
							<?php foreach ($result as $row) { ?>
                  <tr data-toggle="modal" data-target="#AltModal" data-codigo="<?php echo $row['id']; ?>" data-nombre="gfgfgf" data-apellido="<?php echo $row['apellido']; ?>"
										data-cedula="<?php echo $row['cedula']; ?>" data-telefono="<?php echo $row['telefono']; ?>" data-email="<?php echo $row['email']; ?>"
										data-ciudad="<?php echo $row['ciudad']; ?>" data-direcion="<?php echo $row['direccion']; ?>" data-nascimiento="<?php echo $row['fecha_nac']; ?>"
										data-razonsocial="<?php echo $row['razon_social']; ?>" data-ruc="<?php echo $row['ruc']; ?>" data-nombreref="<?php echo $row['nombre_ref']; ?>"
										data-telefonoref="<?php echo $row['telefono_ref']; ?>" data-estado="<?php echo $row['estado']; ?>">
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo $row['nombre']; ?></td>
                    <td><?php echo $row['apellido']; ?></td>
										<td><?php echo $row['razon_social']; ?></td>
                    <td><?php echo $row['cedula']; ?></td>
                    <td><?php echo $row['fecha_nac']; ?></td>
                    <td><?php echo $row['estado']; ?></td>
										<td>
												<!--button id="btnAdd" type="button" class="btn btn-primary" data-toggle="modal" data-target="#AddModal" style="margin-bottom: 5px;">+ Nuevo</button-->
											  <a class="btn btn-primary btn-xs" data-toggle= "modal" data-target="#AltModal"> <i class="fa fa-eye"></i></a>
										</td>
                  </tr>
                 <?php } ?>
						</table>
					</div>
				</div>
				<!-- /.box-body -->
				<div class="box-footer text-center">
					<div class="col-md-6"><small>2 Alumnos Activos</small></div>
					<div class="col-md-6"><small>1 Alumnos Inactivos</small></div>
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
					<h4 class="modal-title">Nuevo Alumno</h4>
				</div>
				<form action="objs/insert.php" method="POST">
					<div class="modal-body">
						<div class="col-md-12">
							<div class="form-group">
								<label for="nombre">Nombre</label>
								<input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre del Alumno" maxlength="50" required>
							</div>
						</div>
						<div class="col-md-12">
							<div class="form-group">
								<label for="apellido">Apellido</label>
								<input type="text" class="form-control" id="apellido" name="apellido" placeholder="Apellido del Alumno" maxlength="50" required>
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label for="cedula">Fecha de Nacimiento</label>
								<input type="text" class="form-control pull-right datepicker" id="nascimiento" name="nascimiento">
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label for="cedula">Cedula</label>
								<input type="text" class="form-control" id="cedula" name="cedula" placeholder="Numero de Cedula" maxlength="10" required>
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label for="telefono">Teléfono</label>
								<input type="text" class="form-control" id="telefono" name="telefono" placeholder="Numero de Teléfono" maxlength="10" required>
							</div>
						</div>
						<div class="col-md-8">
							<div class="form-group">
								<label for="email">E-mail</label>
								<input type="email" class="form-control" id="email" name="email" placeholder="E-mail de contacto" maxlength="50">
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label for="contrasena">Contraseña</label>
								<input type="password" class="form-control" id="contrasena" name="contrasena" placeholder="Contraseña de usuario" maxlength="50">
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label for="ciudad">Ciudad</label>
								<select class="form-control" id="ciudad" name="ciudad">
									<option value="cde">Ciudad Del Este</option>
									<option value="hernandarias">Hernandarias</option>
									<option value="franco">Presidente Franco</option>
									<option value="minga">Minga Guazu</option>
									<option value="otra">Otra</option>
								</select>
							</div>
						</div>
						<div class="col-md-8">
							<div class="form-group">
								<label for="direcion">Dirección</label>
								<input type="text" class="form-control" id="direcion" name="direcion" placeholder="Direción de Cobranza" maxlength="50">
							</div>
						</div>
						<div class="col-md-8">
							<div class="form-group">
								<label for="razonsocial">Razon Social</label>
								<input type="text" class="form-control" id="razonsocial" name="razonsocial" placeholder="Nombre para emisión de factura" maxlength="50">
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label for="ruc">RUC</label>
								<input type="text" class="form-control" id="ruc" name="ruc" placeholder="RUC para factura" maxlength="10">
							</div>
						</div>
						<div class="col-md-8">
							<div class="form-group">
								<label for="nombreref">Nombre Referencia</label>
								<input type="text" class="form-control" id="nombreref" name="nombreref" placeholder="Nombre de la referencia personal" maxlength="10">
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label for="telefonoref">Teléfono Referencia</label>
								<input type="text" class="form-control" id="telefonoref" name="telefonoref" placeholder="Teléfono de la referencia" maxlength="10">
							</div>
						</div>
						<div class="col-md-8">
							<div class="form-group">
								<label for="foto">Foto</label>
								<input type="file" id="foto" name="foto">
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label for="cedula">Estado</label>
								<select class="form-control" id="estado" name="estado">
									<option value="activo">Activo</option>
									<option value="inactivo">Inactivo</option>
									<option value="interesado">Interesado</option>
								</select>
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
						<button type="submit" class="btn btn-primary" href="objs/insert.php" name="guardar" value="guardar">Guardar</button>
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
					<h4 class="modal-title">Nuevo Alumno</h4>
				</div>
				<form action="" method="POST">
					<input type="hidden" class="form-control" id="codigo" name="codigo">
					<div class="modal-body">
						<div class="col-md-12">
							<div class="form-group">
								<label for="nombre">Nombre</label>
								<input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre del Alumno" maxlength="50" required>
							</div>
						</div>
						<div class="col-md-12">
							<div class="form-group">
								<label for="apellido">Apellido</label>
								<input type="text" class="form-control" id="apellido" name="apellido" placeholder="Apellido del Alumno" maxlength="50" required>
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label for="cedula">Fecha Nascimiento</label>
								<input type="text" class="form-control pull-right datepicker" id="nascimiento" name="nascimiento">
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label for="cedula">Cedula</label>
								<input type="text" class="form-control" id="cedula" name="cedula" placeholder="Numero de Cedula" maxlength="10" required>
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label for="telefono">Teléfono</label>
								<input type="text" class="form-control" id="telefono" name="telefono" placeholder="Numero de Teléfono" maxlength="10" required>
							</div>
						</div>
						<div class="col-md-8">
							<div class="form-group">
								<label for="email">E-mail</label>
								<input type="email" class="form-control" id="email" name="email" placeholder="E-mail de contacto" maxlength="50" required>
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label for="contrasena">Contraseña</label>
								<input type="text" class="form-control" id="contrasena" name="contrasena" placeholder="Contraseña de usuario" maxlength="50">
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label for="ciudad">Ciudad</label>
								<select class="form-control" id="ciudad" name="ciudad">
									<option value="cde">Ciudad Del Este</option>
									<option value="hernandarias">Hernandarias</option>
									<option value="franco">Presidente Franco</option>
									<option value="Minga">Minga Guazu</option>
									<option value="otra">Otra</option>
								</select>
							</div>
						</div>
						<div class="col-md-8">
							<div class="form-group">
								<label for="direcion">Direción</label>
								<input type="text" class="form-control" id="direcion" name="direcion" placeholder="Direción de Cobranza" maxlength="50" required>
							</div>
						</div>
						<div class="col-md-8">
							<div class="form-group">
								<label for="razonsocial">Razon Social</label>
								<input type="text" class="form-control" id="razonsocial" name="razonsocial" placeholder="Nombre para emisión de factura" maxlength="50" required>
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label for="ruc">RUC</label>
								<input type="text" class="form-control" id="ruc" name="ruc" placeholder="RUC para factura" maxlength="10" required>
							</div>
						</div>
						<div class="col-md-8">
							<div class="form-group">
								<label for="nombreref">Nombre Referencia</label>
								<input type="text" class="form-control" id="nombreref" name="nombreref" placeholder="Nombre de la referencia personal" maxlength="10" required>
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label for="telefonoref">Teléfono Referencia</label>
								<input type="text" class="form-control" id="telefonoref" name="telefonoref" placeholder="Teléfono de la referencia" maxlength="10" required>
							</div>
						</div>
						<div class="col-md-8">
							<div class="form-group">
								<label for="foto">Foto</label>
								<input type="file" id="foto" name="foto">
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label for="cedula">Estado</label>
								<select class="form-control" id="estado" name="estado">
									<option value="activo">Activo</option>
									<option value="inactivo">Inactivo</option>
									<option value="interesado">Interesado</option>
								</select>
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

		//Modal de alteración, pone los datos en los inputs
		$('#AltModal').on('show.bs.modal', function (event) {
			var button = $(event.relatedTarget) // objeto que disparó el modal
			var codigo = button.data('codigo')
			var nombre = button.data('nombre')
			var apellido = button.data('apellido')
			var estado = button.data('estado')
			var cedula = button.data('cedula')
			var telefono = button.data('telefono')
			var email = button.data('email')
			var ciudad = button.data('ciudad')
			var direcion = button.data('direcion')
			var razonsocial = button.data('razonsocial')
			var ruc = button.data('ruc')
			var nombreref = button.data('nombreref')
			var telefonoref = button.data('telefonoref')
			var nascimiento = button.data('nascimiento')
}
			// Actualiza los datos del modal
			var modal = $(this)
			modal.find('.modal-title').text('Curso ' + nombre)
			modal.find('#codigo').val(data-codigo)
			modal.find('#nombre').val(data-nombre)
			modal.find('#apellido').val(apellido)
			modal.find('#estado').val(estado)
			modal.find('#cedula').val(cedula)
			modal.find('#telefono').val(telefono)
			modal.find('#email').val(email)
			modal.find('#ciudad').val(ciudad)
			modal.find('#direcion').val(direcion)
			modal.find('#razonsocial').val(razonsocial)
			modal.find('#ruc').val(ruc)
			modal.find('#nombreref').val(nombreref)
			modal.find('#telefonoref').val(telefonoref)
			modal.find('#nascimiento').val(nascimiento)
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