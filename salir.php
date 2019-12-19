<?php 
	//Cerrar Session
	session_start();
	session_destroy();
	if (isset($_GET['asistencia'])) {
		header('location: login-alumno.php');
	}else{
	header('location: login.php');
}
?>