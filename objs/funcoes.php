<?php
	function putMySQlToData($mysqldata) {
		$data = "";
		$data = substr($mysqldata, 8,2)."/".substr($mysqldata, 5,2)."/".substr($mysqldata, 0,4);
		return $data;
	}

	function putDataToMySQl($data) {
		$mysqldata = "";
		$mysqldata = substr($data, 6,4)."-".substr($data, 3,2)."-".substr($data, 0,2);
		return $mysqldata;
	}

	function getMesporEscrito($data) {
		$mes = "";
		$data = substr($data, 5,2);//mês de uma data de visualização
		if ($data == "01") {
			$mes = "Janeiro";
		} else if ($data == "02") {
			$mes = "Fevereiro";
		} else if ($data == "03") {
			$mes = "Março";
		} else if ($data == "04") {
			$mes = "Abril";
		} else if ($data == "05") {
			$mes = "Maio";
		} else if ($data == "06") {
			$mes = "Junho";
		} else if ($data == "07") {
			$mes = "Julho";
		} else if ($data == "08") {
			$mes = "Agosto";
		} else if ($data == "09") {
			$mes = "Setembro";
		} else if ($data == "10") {
			$mes = "Outubro";
		} else if ($data == "11") {
			$mes = "Novembro";
		} else if ($data == "12") {
			$mes = "Dezembro";
		}
		return $mes;
	}
?>
