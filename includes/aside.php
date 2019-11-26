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
			$subalumno = "";
			$submatricula = "";
			$subcurso = "";
			$subgrupo = "";
			$config = "";

			if (strpos($_SERVER['REQUEST_URI'], 'alumno.php') !== false){
				$catastro = "active";
				$subalumno = "text-aqua";
			} 
			else if (strpos($_SERVER['REQUEST_URI'], 'matricula.php') !== false) {
				$catastro = "active";
				$submatricula = "text-aqua";
			} 
			else if (strpos($_SERVER['REQUEST_URI'], 'curso.php') !== false) {
				$catastro = "active";
				$subcurso = "text-aqua";
			}  
			else if (strpos($_SERVER['REQUEST_URI'], 'grupo.php') !== false){
				$catastro = "active";
				$subgrupo = "text-aqua";
			} else if (strpos($_SERVER['REQUEST_URI'], 'asistencia.php') !== false) {
				$asistencia = "active";
			} 
			else if (strpos($_SERVER['REQUEST_URI'], 'configuraciones.php') !== false) {
				$config = "active";
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
			<li class="<?php echo $asistencia;?> treeview">
				<a href="#">
					<i class="fa fa-group"></i> <span>Asistencias</span>
					<span class="pull-right-container">
						<i class="fa fa-angle-left pull-right"></i>
					</span>
				</a>
				<ul class="treeview-menu">
					<li class="treeview">
						<a href="#"><i class="fa fa-circle-o"></i> Ballet Clasico
							<span class="pull-right-container">
							<i class="fa fa-angle-left pull-right"></i>
							</span>
						</a>
						<ul class="treeview-menu">
							<li><a href="#"><i class="fa fa-circle-o"></i> L/M/V</a></li>
							<li><a href="#"><i class="fa fa-circle-o"></i> Martes y Jueves Tarde 4</a></li>
							<!-- <li class="treeview">
								<a href="#"><i class="fa fa-circle-o"></i> Level Two
									<span class="pull-right-container">
										<i class="fa fa-angle-left pull-right"></i>
									</span>
								</a>
								<ul class="treeview-menu">
									<li><a href="#"><i class="fa fa-circle-o"></i> Level Three</a></li>
									<li><a href="#"><i class="fa fa-circle-o"></i> Level Three</a></li>
								</ul>
							</li> -->
						</ul>
					</li>
					<li><a href="#"><i class="fa fa-circle-o"></i> Danza del Vientre</a></li>
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
					<li><a href="alumno.php"><i class="fa fa-circle-o <?php echo $subalumno;?>"></i> Alumnos</a></li>
					<li><a href="matricula.php"><i class="fa fa-circle-o <?php echo $submatricula;?>"></i> Matriculas</a></li>
					<li><a href="curso.php"><i class="fa fa-circle-o <?php echo $subcurso;?>"></i> Cursos</a></li>
					<li><a href="grupo.php"><i class="fa fa-circle-o <?php echo $subgrupo;?>"></i> Grupos</a></li>
				</ul>
			</li>
			<li class="<?php echo $config;?>">
				<a href="configuraciones.php">
					<i class="fa fa-gear"></i> <span>Configuraciones</span>
				</a>
			</li>
		</ul>
	</section>
<!-- /.sidebar -->
</aside>