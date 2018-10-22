<!DOCTYPE html>
<html>
<head>
	<title></title>

	<link rel="stylesheet" type="text/css" href="css/select2.css">
	<script src="jquery-3.1.1.min.js"></script>
	<script src="js/select2.js"></script>
</head>
<body>

<div>
	<h2>ESTE ES MI BUSCADOR</h2>
		<form action="" method="GET">
			<?php
				require ('../../conexion.php');
				$query = "SELECT id, name from invento_categories";
				$resultado=$mysqli->query($query);
				if ($resultado->num_rows > 0) //si la variable tiene al menos 1 fila entonces seguimos con el codigo
				{$combobit="";
    				while ($row = $resultado->fetch_array(MYSQLI_ASSOC)) 
    					{
        				$combobit .=" <option value='".$row['id']."'>".$row['name']."</option>"; //concatenamos el los options para luego ser insertado en el HTML
    					}
				}
						else
						{
    					echo "No hubo resultados";
						}
							$mysqli->close(); ?>

		<select  name="mibuscador[]" id="mibuscador" multiple="multiple">
								<option value="0">
									<-- TODOS -->
								</option>
								<?php echo $combobit;?>
							</select>
			<!-- <select  name="selections[]" class="selections" id="mibuscador" multiple="multiple">
			<option>Mexico</option>
			<option>Colombia</option>
			<option>Peru</option>
			<option>España</option>
			<option>Canada</option>
			<option>Estados unidos</option>
			<option>Brasil</option>
			<option>Argentina</option>
		</select>
 --><input name="categoria" type="submit" class="button"  id="categoria " onclick=this.form.action="save.php" /> 
		</form>
</div>
</body>
</html>

<script type="text/javascript">
	 $ (document).ready(function (){
	 		$('#mibuscador').select2();
	 }); 
	 </script>