<?php

		// webhost
		// $user = 'id8771345_id8771345_root'; //usuario
		// $password = 'si31tf7ac'; //senha
		// $host = 'localhost'; //hosts
		// $dbname = 'id8771345_ctrldm'; //nombre da base de dados

		// Local Host
		$user = 'root'; //usuario
		$password = ''; //senha
		$host = 'localhost'; //hosts
		//$dbname = 'capacit_2020'; //nombre da base de dados
		$dbname = 'ssdpy_asist'; //nombre da base de dados

		$parametros = array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'UTF8'"); //caso os dados estejam com acentos ou ç
		try {
			//criando conexão usado PDO
			$connection = new PDO("mysql:host=$host;dbname=$dbname;", $user, $password, $parametros);
			//setando atributos
			$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			//return $connection;
			//echo "Conexion ok";
		} catch (PDOException $e) {
			echo $e->getMessage();
		}

/*	function disconn ($connection) {
		if ($connection != null) {
			$connection = null;
		}
	}*/

?>
