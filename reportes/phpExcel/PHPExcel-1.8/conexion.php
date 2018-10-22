<?php

$mysqli= new mysqli('192.168.20.5','cisp_pf_2018','xIIAlmlgPPZBzSIZ','cisp_pf_2018');
	if($mysqli->connect_error) {
		die('Error en la conexión' . $mysqli->connect_error);
	}

?>