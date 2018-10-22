<?php
session_start();

/************	You can edit details starting from here ************/
$dbhost = '192.168.20.5';		// Write your MySQL host here.
$dbuser = 'cisp_pf_2018';	// Write your MySQL User here.
$dbpass = 'xIIAlmlgPPZBzSIZ';	// Write your MySQL Password here.
$dbname = 'cisp_pf_2018';		// Write the MySQL Database where you want to install Invento


/************ DON'T EDIT NOTHING BELOW ************/

if(!isset($noredir) && $dbhost == '192.168.20.5' && $dbuser == 'MYSQL USERNAME' && $dbpass == 'MYSQL PASSWORD')
	header('Location:install.php');
if(!isset($noredir)) {
	$mysqli = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
	if($mysqli->connect_errno)
		die('<h2>Something went wrong while trying to connect to your MySQL Database. Error No. ' . $mysql->connect_errno.'<h2>');
	
	// Check existance of random table to test installed system
	$tables = array('users','factura','categoria','comprador','settings','proyect');
	$rn = rand(0,5);
	$res = $mysqli->query("SHOW TABLES LIKE '%pf_{$tables[$rn]}%'");
	if($res->num_rows == 0)
		header('Location:install.php');
}