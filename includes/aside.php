<aside class="main-sidebar">
	<!-- sidebar: style can be found in sidebar.less -->
	<section class="sidebar">
		<!-- Sidebar user panel -->
		<div class="user-panel">
			<div class="pull-left image">
				<img src="img/user2-160x160.jpg" class="img-circle" alt="User Image">
			</div>
			<div class="pull-left info">
				<p><?php echo $_SESSION['nome_usuario'];?></p>
				<a href="#"><i class="fa fa-circle text-success"></i> Online</a>
			</div>
		</div>
		<br>
			<!-- search form -->
		<!-- <form action="#" method="get" class="sidebar-form">
			<div class="input-group">
				<input type="text" name="q" class="form-control" placeholder="Search...">
				<span class="input-group-btn">
					<button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
				</button>
				</span>
			</div>
		</form> -->
		<!-- /.search form -->
		<!-- sidebar menu: : style can be found in sidebar.less -->
		<?php 
			$inicio = "";
			$asistencia = "";
			$catastro = "";
			$catastro2 = "";
			$catastro3 = "";
			if ($_SERVER['REQUEST_URI'] == '/Capacit/curso.php' || $_SERVER['REQUEST_URI'] == '/Capacit/alumno.php' || $_SERVER['REQUEST_URI'] == '/Capacit/matricula.php' || $_SERVER['REQUEST_URI'] == '/Capacit/grupo.php' || $_SERVER['REQUEST_URI'] == '/Capacit/grupo-detalle.php') {
				$catastro = "active";
			} else if (strpos($_SERVER['REQUEST_URI'], 'asistencia.php') !== false) {
				$asistencia = "active";
			} else {
				$inicio = "active";
			}

			// var_dump($_SERVER['REQUEST_URI']);
		?>
		<ul class="sidebar-menu" data-widget="tree">
			<li class="header">Menu de Navegación</li>
			<li class="<?php echo $inicio;?>">
				<a href="index.php">
					<i class="fa fa-home"></i> <span>Inicio</span>
				</a>
			</li>
			<!-- Multilevel -->
			<li class="<?php echo $asistencia;?> treeview">
				<a href="#">
					<i class="fa fa-group"></i> <span>Asistencias</span>
					<span class="pull-right-container">
						<i class="fa fa-angle-left pull-right"></i>
					</span>
				</a>
				<ul class="treeview-menu">
					<li><a href="asistencia.php?id=1"><i class="fa fa-circle-o"></i> Ballet Noche 1</a></li>
					<li><a href="asistencia.php?id=2"><i class="fa fa-circle-o"></i> Ballet Noche 2</a></li>
					<li><a href="asistencia.php?id=3"><i class="fa fa-circle-o"></i> Danza del Vientre Sábado</a></li>
					<li><a href="asistencia.php?id=4"><i class="fa fa-circle-o"></i> Danza Paraguaya Noche 1</a></li>
				</ul>
			</li>	
			<!-- Multilevel -->
			<li class="<?php echo $catastro;?> treeview">
				<a href="#">
					<i class="fa fa-pencil"></i> <span>Catastros</span>
					<span class="pull-right-container">
						<i class="fa fa-angle-left pull-right"></i>
					</span>
				</a>
				<ul class="treeview-menu">
					<li><a href="alumno.php"><i class="fa fa-circle-o"></i> Alumnos</a></li>
					<li><a href="matricula.php"><i class="fa fa-circle-o"></i> Matriculas</a></li>
					<li><a href="curso.php"><i class="fa fa-circle-o"></i> Cursos</a></li>
					<li><a href="grupo.php"><i class="fa fa-circle-o"></i> Grupos</a></li>
				</ul>
			</li>
		</ul>
	</section>
<!-- /.sidebar -->
</aside>