<?php



	require '../../conexion.php';

$categoria=0;

	if ($_GET['mibuscador']){  
//Mostramos las categorias seleccionadas 
          $categoria=$_GET['mibuscador']; 
echo "<br>Profesiónes seleccionadas:"; 
for ($i=0;$i<count($categoria);$i++)  
{ 
echo "<br> Profesión " . $i . ": " . $categoria[$i]; 
}} else{
	echo "<br>error al obtener los datos";
}


?>