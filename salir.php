<?php 
	//Cerrar Session
	session_start();
	session_destroy();
	header('location: login.php');
?>