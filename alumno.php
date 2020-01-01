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
	  //Validar si existe un post


//VALIDAR EXISTENCIA DE UN POST
	if(isset($_POST['accion'])){
	switch ($_POST['accion']){
	       case ('guardar' ):
				 if($_POST['estado']!="activo")
				 {
					 $activo=0;
				 }
				 else
				 {
					 $activo=1;
				 }
				 if ($_POST['contrasena']!='') {
				 	$pass= $_POST['contrasena'];
				 }
				 else {
				 	$pass= $_POST['cedula'];
				 }

				 //VALIDAR CAMPOS
	      /*== 'guardar'
	        && $_POST['nombre'] != ''
	        && $_POST['apellido'] != ''
	        && $_POST['cedula'] != ''
	        && $_POST['telefono'] != ''*/
	      //INICIAMOS LA TRANSACCION
	          $sql = 'INSERT INTO alumnos(nombre, apellido, cedula, telefono_alumno, fecha_nac, email, ruc, razon_social, ciudad, direccion,
	            nombre_ref, telefono_ref, mama, telefono_mama, papa, telefono_papa, estado, password, foto, activo, fecha_add ) VALUES (:nombre, :apellido, :cedula, :telefono_alumno, :fecha_nac, :email, :ruc,
	            :razonsocial, :ciudad, :direccion, :nombreref, :telefonoref, :mama, :telefono_mama, :papa, :telefono_papa, :estado, :password, :foto, :activo,  NOW() )';
	          $data = array(
	              'nombre' => $_POST['nombre'],
	              'apellido' => $_POST['apellido'],
	              'cedula' => $_POST['cedula'],
	              'telefono_alumno' => $_POST['telefono_alumno'],
	              'fecha_nac' => $_POST['nascimiento'],
	              'email' => $_POST['email'],
	              'direccion' => $_POST['direcion'],
	              'ciudad' => $_POST['ciudad'],
	              'ruc' => $_POST['ruc'],
	              'razonsocial' => $_POST['razonsocial'],
	              'nombreref' => $_POST['nombreref'],
	              'telefonoref' => $_POST['telefonoref'],
								'mama' => $_POST['nombremama'],
								'telefono_mama' => $_POST['telefono_mama'],
								'papa' => $_POST['nombrepapa'],
								'telefono_papa' => $_POST['telefono_papa'],
	              'password' => md5($pass),
	              'estado' => $_POST['estado'],
	              'foto' => $_POST['foto'],
								'activo' => $activo
	          );
	         $query = $connection->prepare($sql);
	          try {
	              $query->execute($data);
					$mensaje = '<p class="alert alert-success"> Registro Actualizado correctamente</p>';
	            	//echo '<script> window.location = "alumno.php?guardar=true"; </script>';
	          } catch (PDOException $e) {
	              //print_r($e);
	               //$connection->rollback();
	              $mensaje= '<p class="alert alert-danger">'. $e .'</p>';
	          }
	          break;
	      case('actualizar'):
	                    if($_POST['codigo'] > 0){
												if($_POST['estado']!="activo")
												{
													$activo=0;
												}
												else
												{
													$activo=1;
												}
												if($_POST['contrasena']!="")
							 				 {
												     $sql = 'UPDATE alumnos set nombre=:nombre, apellido=:apellido, cedula=:cedula, telefono_alumno=:telefono_alumno, fecha_nac=:fecha_nac, email=:email,
		                         						ruc=:ruc, razon_social=:razonsocial, ciudad=:ciudad, direccion=:direccion, nombre_ref=:nombreref, telefono_ref=:telefonoref,
														 mama=:mama, telefono_mama=:telefono_mama, papa=:papa, telefono_papa=:telefono_papa, estado=:estado, password=:password, foto=:foto, activo=:activo, fecha_update=NOW() WHERE id = ' . $_POST['codigo'];
		                         					$data = array(
		                             								'nombre' => $_POST['nombre'],
		                             								'apellido' => $_POST['apellido'],
		                             								'cedula' => $_POST['cedula'],
		                             								'telefono_alumno' => $_POST['telefono_alumno'],
		                             								'fecha_nac' => $_POST['nascimiento'],
		                             								'email' => $_POST['email'],
		                             								'direccion' => $_POST['direcion'],
		                             								'ciudad' => $_POST['ciudad'],
		                             								'ruc' => $_POST['ruc'],
		                             								'razonsocial' => $_POST['razonsocial'],
		                             								'nombreref' => $_POST['nombreref'],
		                             								'telefonoref' => $_POST['telefonoref'],
									 						 	 	'mama' => $_POST['nombremama'],
									 							 	'telefono_mama' => $_POST['telefono_mama'],
									 						 	 	'papa' => $_POST['nombrepapa'],
									 						 	 	'telefono_papa' => $_POST['telefono_papa'],
																	'password' => md5($_POST['contrasena']),
																	'estado' => $_POST['estado'],
																	'foto' => $_POST['foto'],
																 	'activo'=> $activo
		                         									);
							 				 }
							 				 else
											 {

		                         $sql = 'UPDATE alumnos set nombre=:nombre, apellido=:apellido, cedula=:cedula, telefono_alumno=:telefono_alumno, fecha_nac=:fecha_nac, email=:email,
		                         ruc=:ruc, razon_social=:razonsocial, ciudad=:ciudad, direccion=:direccion, nombre_ref=:nombreref, telefono_ref=:telefonoref,
								mama=:mama, telefono_mama=:telefono_mama, papa=:papa, telefono_papa=:telefono_papa, estado=:estado, foto=:foto, activo=:activo, fecha_update=NOW() WHERE id = ' . $_POST['codigo'];
		                         $data = array(
		                             'nombre' => $_POST['nombre'],
		                             'apellido' => $_POST['apellido'],
		                             'cedula' => $_POST['cedula'],
		                             'telefono_alumno' => $_POST['telefono_alumno'],
		                             'fecha_nac' => $_POST['nascimiento'],
		                             'email' => $_POST['email'],
		                             'direccion' => $_POST['direcion'],
		                             'ciudad' => $_POST['ciudad'],
		                             'ruc' => $_POST['ruc'],
		                             'razonsocial' => $_POST['razonsocial'],
		                             'nombreref' => $_POST['nombreref'],
		                             'telefonoref' => $_POST['telefonoref'],
									 'mama' => $_POST['nombremama'],
									 'telefono_mama' => $_POST['telefono_mama'],
									 'papa' => $_POST['nombrepapa'],
									 'telefono_papa' => $_POST['telefono_papa'],
		                             'estado' => $_POST['estado'],
		                             'foto' => $_POST['foto'],
									 'activo'=> $activo
		                         );
							 				 }
	                         $query = $connection->prepare($sql);
	                        try{
	                          $query->execute($data);
	                          $mensaje = '<p class="alert alert-success">Registro actualizado correctamente :)</p>';
	                         //echo '<script> window.location="alumno.php?actualizar=true"; </script>';
	                          }catch(Exception $e){
	                             echo '<p class="alert alert-danger">'. $e .'</p>';
	                       }
	                       }
	                      break;
			case('excluir'):
					$id =  $_POST['codigo'];
					try {
							$sql = 'DELETE FROM alumnos WHERE id = '.$id;
							$query = $connection->prepare($sql);
							$query->execute();
							$mensaje= '<div class="alert alert-success">REGISTRO ELIMINADO CORRECTAMENTE</div>';
			} catch (\Exception $e) {
							$mensaje = '<div class="alert alert-danger">HA OCURRIDO UN ERROR - Consulte al administrador de sistemas. Error->"'.$e.'<br></div>';
			}
			break;
	}
	}
?>
<!DOCTYPE html>
<html>
<head>
	<title>SSD - Alumnos</title>
	<?php include 'includes/head.php'; ?>

	<script type="text/javascript">
	function subir_imagen(input, carpeta, evento)
				{
					self.name = 'opener';
					var name = document.getElementsByName("nombre")[0].value;
					remote = open('subir_imagen.php?name='+name+'&input='+input+'&carpeta='+carpeta+'&evento='+evento ,'remote', 'align=center,width=600,height=300,resizable=yes,status=yes');
					remote.focus();
				}

	</script>
</head>
<body class="hold-transition skin-yellow sidebar-mini">
	<div class="wrapper">
		<!-- MAIN HEADER -->
		<?php include 'includes/header.php';
		require 'server/conn.php'?>
		<!-- MAIN HEADER END -->
		<?php
				/*if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['search'])){
				$busca = $_POST['busca'];
				$sql = "SELECT * from alumnos WHERE nombre LIKE '%$busca%' OR apellido LIKE '%$busca%' OR cedula LIKE '%$busca%' ORDER by id";
				$query = $connection->prepare($sql);
				$query->execute();
				$result= $query->fetchAll();
			} else {
				$busca = "";*/
				$sql = "SELECT * from alumnos ORDER by id";
				$query = $connection->prepare($sql);
				$query->execute();
				$result= $query->fetchAll();
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
						<a type="button" class="btn btn-warning" href="index.php"> ← Atrás </a>
						<!--<form method="POST">
							<div class="input-group">
								<input type="text" class="form-control" placeholder="Buscar " name="busca" value="<?php echo $busca;?>">
								<span class="input-group-btn">
									<button class="btn btn-default" type="submit" name="search"><i class="fa fa-search"></i></button>
								</span>
							</div>
						</form>-->
					</div>
				</div>
<div class="modal fade" id="modal-mensaje" tabindex="-1" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Atencion</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <p>  <?php echo $mensaje; ?></p>
      </div>
      <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
				<!-- Corpo de Caja -->
				<div class="box-body">
					<div class="box-body table-responsive">
						<table class="table table-striped table-bordered display nowra" id="tabladatos">
						<thead>
							<tr>
								<th>#</th>
								<th>Nombre</th>
								<th>Apellido</th>
								<th>Razón Social</th>
								<th>RUC</th>
								<th>Teléfono</th>
								<th>Estado</th>
							</tr>
						</thead>
							<?php
								$activo=0;
								$inactivo=0;
								$interesado=0; ?>
						<tbody>
							<?php foreach ($result as $row) { ?>
                  <tr data-toggle="modal" data-target="#AltModal" data-codigo="<?php echo $row['id']; ?>" data-nombre="<?php echo $row['nombre']; ?>" data-apellido="<?php echo $row['apellido']; ?>"
										data-cedula="<?php echo $row['cedula']; ?>" data-telefono_alumno="<?php echo $row['telefono_alumno']; ?>" data-email="<?php echo $row['email']; ?>"
										data-ciudad="<?php echo $row['ciudad']; ?>" data-direcion="<?php echo $row['direccion']; ?>" data-nascimiento="<?php echo $row['fecha_nac']; ?>"
										data-razonsocial="<?php echo $row['razon_social']; ?>" data-ruc="<?php echo $row['ruc']; ?>" data-nombreref="<?php echo $row['nombre_ref']; ?>"
										data-telefonoref="<?php echo $row['telefono_ref']; ?>" data-nombremama="<?php echo $row['mama']; ?>" data-telefono_mama="<?php echo $row['telefono_mama']; ?>"
										data-nombrepapa="<?php echo $row['papa']; ?>" data-telefono_papa="<?php echo $row['telefono_papa']; ?>" data-estado="<?php echo $row['estado'];?>" data-password="<?php echo $row['password'];?>" data-foto="<?php echo $row['foto'];?>">
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo $row['nombre']; ?></td>
                    <td><?php echo $row['apellido']; ?></td>
										<td><?php echo $row['razon_social']; ?></td>
                    <td><?php echo $row['cedula']; ?></td>
										<td><?php echo $row['telefono_alumno']; ?></td>
                    <td><?php echo $row['estado']; ?></td>

									</tr>
									
									<?php
									if($row['estado']=="activo"){
										$activo++;
									}
									elseif($row['estado']=="inactivo"){
										$inactivo++;
									}
									elseif($row['estado']=="interesado"){
										$interesado++;
									}
                  } ?>
				  </tbody>
						</table>
					</div>
				</div>
				<!-- /.box-body -->
				<div class="box-footer text-center">
					<div class="col-md-4"><small><?php echo $activo ?> Alumnos Activo/s</small></div>
					<div class="col-md-4"><small><?php echo $inactivo ?> Alumnos Inactivo/s</small></div>
					<div class="col-md-4"><small><?php echo $interesado ?> Interesado/s</small></div>
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
				<form action="" method="POST" name="form1">
					<input type="hidden" class="form-control" id="codigo" name="codigo">
					<div class="modal-body">
						<div class="col-md-6">
							<div class="form-group">
								<label for="nombre">Nombre</label>
								<input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre del Alumno" maxlength="50" required>
							</div>
						</div>
						<div class="col-md-6">
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
								<input type="text" class="form-control" id="telefono_alumno" name="telefono_alumno" placeholder="Numero de Teléfono" maxlength="15">
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
								<input type="text" class="form-control" id="ruc" name="ruc" placeholder="RUC para factura" maxlength="15">
							</div>
						</div>
						<div class="col-md-8">
							<div class="form-group">
								<label for="nombreref">Nombre Referencia</label>
								<input type="text" class="form-control" id="nombreref" name="nombreref" placeholder="Nombre de la referencia personal" maxlength="100">
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label for="telefonoref">Teléfono Referencia</label>
								<input type="text" class="form-control" id="telefonoref" name="telefonoref" placeholder="Teléfono de la referencia" maxlength="15">
							</div>
						</div>
						<div class="col-md-8">
							<div class="form-group">
								<label for="nombreref">Nombre Madre</label>
								<input type="text" class="form-control" id="nombremama" name="nombremama" placeholder="Nombre de la madre" maxlength="100">
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label for="telefonoref">Teléfono Madre</label>
								<input type="text" class="form-control" id="telefono_mama" name="telefono_mama" placeholder="Teléfono de la madre" maxlength="15">
							</div>
						</div>
						<div class="col-md-8">
							<div class="form-group">
								<label for="nombreref">Nombre Padre</label>
								<input type="text" class="form-control" id="nombrepapa" name="nombrepapa" placeholder="Nombre del padre" maxlength="100">
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label for="telefonoref">Teléfono Padre</label>
								<input type="text" class="form-control" id="telefono_papa" name="telefono_papa" placeholder="Teléfono del padre" maxlength="15">
							</div>
						</div>
						<div class="col-md-8">
							<div class="form-group">
								<label for="foto">Foto</label>
								<input type="text" id="foto" name="foto" onclick="subir_imagen('foto','img_alumnos', 'add')">
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
						<button type="submit" class="btn btn-primary" name="accion" value="guardar">Guardar</button>
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
					<h4 class="modal-title">Actualizacion</h4>
				</div>
				<form action="" method="POST" name="form">
					<input type="hidden" class="form-control" id="codigo" name="codigo">
					<div class="modal-body">
						<div class="col-md-6">
							<div class="form-group">
								<label for="nombre">Nombre</label>
								<input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre del Alumno" maxlength="50" required>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="apellido">Apellido</label>
								<input type="text" class="form-control" id="apellido" name="apellido" placeholder="Apellido del Alumno" maxlength="50" required>
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label for="cedula">Fecha Nacimiento</label>
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
								<input type="text" class="form-control" id="telefono_alumno" name="telefono_alumno" placeholder="Numero de Teléfono" maxlength="10">
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
								<label for="nombreref">Nombre Madre</label>
								<input type="text" class="form-control" id="nombremama" name="nombremama" placeholder="Nombre de la madre" maxlength="100">
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label for="telefonoref">Teléfono Madre</label>
								<input type="text" class="form-control" id="telefono_mama" name="telefono_mama" placeholder="Teléfono de la madre" maxlength="10">
							</div>
						</div>
						<div class="col-md-8">
							<div class="form-group">
								<label for="nombreref">Nombre Padre</label>
								<input type="text" class="form-control" id="nombrepapa" name="nombrepapa" placeholder="Nombre del padre" maxlength="100">
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label for="telefonoref">Teléfono Padre</label>
								<input type="text" class="form-control" id="telefono_papa" name="telefono_papa" placeholder="Teléfono del padre" maxlength="10">
							</div>
						</div>
						<div class="col-md-8">
							<div class="form-group">
								<label for="foto">Foto</label>
								<input type="text" id="foto" name="foto" onclick="subir_imagen('foto','img_alumnos','alt')">
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
						<button type="button" class="btn btn-danger pull-left" name="accion" value="excluir"  id="btn-confirmar">Excluir</button>
						<button type="submit" class="btn" name="accion" value="excluir" id="btn-excluir" style="display: none;">Submit Excluir</button>
						<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
						<button type="submit" class="btn btn-primary" name="accion" value="actualizar">Actualizar</button>
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
			var telefono_alumno = button.data('telefono_alumno')
			var email = button.data('email')
			var ciudad = button.data('ciudad')
			var direcion = button.data('direcion')
			var razonsocial = button.data('razonsocial')
			var ruc = button.data('ruc')
			var nombreref = button.data('nombreref')
			var telefonoref = button.data('telefonoref')
			var nascimiento = button.data('nascimiento')
			var password = button.data('password')
			var foto = button.data('foto')
			var nombremama = button.data('nombremama')
			var telefono_mama = button.data('telefono_mama')
			var nombrepapa = button.data('nombrepapa')
			var telefono_papa = button.data('telefono_papa')


			// Actualiza los datos del modal
		var modal = $(this)
			modal.find('.modal-title').text('Curso ' + nombre)
			modal.find('#codigo').val(codigo)
			modal.find('#nombre').val(nombre)
			modal.find('#apellido').val(apellido)
			modal.find('#estado').val(estado)
			modal.find('#cedula').val(cedula)
			modal.find('#telefono_alumno').val(telefono_alumno)
			modal.find('#email').val(email)
			modal.find('#ciudad').val(ciudad)
			modal.find('#direcion').val(direcion)
			modal.find('#razonsocial').val(razonsocial)
			modal.find('#ruc').val(ruc)
			modal.find('#nombreref').val(nombreref)
			modal.find('#telefonoref').val(telefonoref)
			modal.find('#nascimiento').val(nascimiento)
			//modal.find('#contrasena').val(password)
			modal.find('#foto').val(foto)
			modal.find('#nombremama').val(nombremama)
			modal.find('#telefono_mama').val(telefono_mama)
			modal.find('#nombrepapa').val(nombrepapa)
			modal.find('#telefono_papa').val(telefono_papa)
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
				var codigo=
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
