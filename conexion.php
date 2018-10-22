<?php

$mysqli= new mysqli('http://192.168.20.5','planificacion_financiera','xIIAlmlgPPZBzSIZ','cisp_pf_2018');
	if($mysqli->connect_error) {
		die('Error en la conexión' . $mysqli->connect_error);
	}
?>