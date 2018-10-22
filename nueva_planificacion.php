<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
?>
<?php

require 'config.php';
require 'inc/session.php';
require 'inc/plan_core.php';
require 'inc/categories_core.php';
require 'inc/compradors_core.php';
if($_session->isLogged() == false)
	header('Location: index.php');

$_page = 2;

$role = $_session->get_user_role();
$headuser =$_session->get_user_id();
$usuario =$headuser;

if(isset($_POST['descripcion'])) {
if(!$_POST['descripcion'] == "") {

$descripcion = $_POST['descripcion'];
$categoria = $_POST['categoria'];
$cant_planificada = $_POST['cant_planificada'];
$cant_comprada = $_POST['cant_comprada'];
$valor_planificado = $_POST['valor_planificado'];
$valor_comprado = $_POST['valor_comprado'];
if ($_POST['comprador']== ""){
	$comprador= "";
}else{
$comprador = implode("/",$_POST['comprador']);
}

$date = date_default_timezone_set('America/Bogota'); 
$date= date('Y-m-d H:i:s');
}}

if(isset($_FILES['archivo']))
{
	$archivo1 = $_FILES['archivo']['name'];
}else{
	$archivo1= "";
}

	if(isset($_FILES['archivo'])){
	if($_FILES["archivo"]["error"]>0){
		if($_plans->new_plan($descripcion, $categoria, $cant_planificada, $cant_comprada, $valor_planificado, $valor_comprado, $comprador, "", $date)==false);
		} else {
		
		$permitidos = array("image/png","application/vnd.openxmlformats-officedocument.wordprocessingml.document","application/x-rar-compressed","application/zip","application/pdf","application/vnd.ms-excel", "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet", "application/msword");
		$limite_kb = 2000;
		
		if(in_array($_FILES["archivo"]["type"], $permitidos) && $_FILES["archivo"]["size"] <= $limite_kb * 1024){
			
			$ruta = 'files/'.$categoria.'/';
			$archivo = $ruta.$_FILES["archivo"]["name"];
			
			if(!file_exists($ruta)){
				mkdir($ruta);
			}
			
			if(!file_exists($archivo)){
				
				$resultado = @move_uploaded_file($_FILES["archivo"]["tmp_name"], $archivo);
				
				if($resultado){
		if($_plans->new_plan($descripcion, $categoria, $cant_planificada, $cant_comprada, $valor_planificado, $valor_comprado, $comprador, "files/".$categoria."/".$archivo1, $date)==false);

					}else {
					echo'<script type="text/javascript">
        alert("Error al guardar archivo");
        </script>';
				}
				
				} else {

				echo "Archivo ya existente, cambie el nombre del archivo e intentelo de nuevo    $usuario";
				echo'<script type="text/javascript">
        alert("Archivo ya existente, cambie el nombre del archivo e intentelo de nuevo");
        </script>';
			}
			
			} else {

			echo "Archivo no permitido o excede el tamaño";
			echo'<script type="text/javascript">
        alert("Archivo no permitido o excede el tamaño");
        </script>';
		}
		
	}
}
// 

?>
<!DOCTYPE HTML>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link href="bootstrap/css/bootstrap.min.css" rel ="stylesheet"/>
<?php require 'inc/head.php'; ?>
</head>
<body>
	<div id="main-wrapper">
		<?php require 'inc/header.php'; ?>
		
		<div class="wrapper-pad">
			<h2>Nueva Planificacion</h2>
			<div class="center">
				<div class="new-plan form">
					<form method="post" action="" name="new-plan" 
					enctype="multipart/form-data" autocomplete="off">

						<span class="plan-desc-left" class="ni">Descripción:</span><br />
						<div class="ni-cont">
							<textarea name="descripcion" id="descripcion" class="ni" required></textarea>
						</div>

			<label>CATEGORIA</label>			
						<div class="select-holder">
							<i class="fa fa-caret-down"></i>
							<?php
							if($_cats->count_cats() == 0)
								echo '<select id="categoria" name="categoria" disabled><option value="no">You need to create a category first</option></select>';
							else{
								echo '<select id="categoria" name="categoria">';
								echo "<option value='' disabled selected>Seleccione</option>";
								$cats = $_cats->get_cats_dropdown();
								while($catt = $cats->fetch_object()) {
									echo "<option value=\"{$catt->id}\">{$catt->nombre}</option>";
								}
								echo '</select>';
							}
							?>
						</div>
				
						<!-- <span class="badge"> -->
						CANTIDAD PLANIFICADA:
						<input type="text" id="cant_planificada" name="cant_planificada" size="6" style="color: gray;" onkeyup="buscar();" required>
						CANTIDAD COMPRADA: 
						<input type="text" id="cant_comprada" name="cant_comprada" size="6" style="color: gray;"  onkeyup="buscar();" required>
						<br>
						<br>
						VALOR PLANIFICADO: <input type="text" id="valor_planificado" name="valor_planificado" class="ni"  onkeyup="buscar();" required>
						

						VALOR COMPRADO:
						<input readonly style="background-color:transparent; "type="text" id="valor_comprado" name="valor_comprado" size="6" style="color: gray;" required>
						<!-- </span> -->

						<br>
						<br>
						<label>COMPRADO POR:</label>
						<div class="select-holder">
							<i class="fa fa-caret-down"></i>
							<?php
							if($_cats->count_cats() == 0)
								echo '<select id="comprador" name="comprador[] disabled><option value="no">You need to create a comprador first</option></select>';
							else{
								echo '<select  id="comprador" name="comprador[]"  multiple="multiple">';
								$compradors = $_compradors->get_compradors_dropdown();
								while($comprador = $compradors->fetch_object()) {
									echo "<option value=\"{$comprador->nombre}\">{$comprador->nombre}</option>";
								}
								echo '</select>';
							}
							?>
						</div>
						<!--SECCION FACTURA-->
						<label for="archivo">FACTURA</label>
						<div class="ni-cont">
							<input type="file" name="archivo" id="archivo"/>
						</div>
						<button title="Eliminar" type="button" id="cancelImg" onclick="limpiar()" style="display:none; width: 20px; height: 30px; background-color: #CC1719">
            			<span class="glyphicon glyphicon-remove"></span>
						</button> 
						<br>
						<iframe id="previsual" src="<?php echo $plan->archivo; ?>" width="100%" height="50%" style="display:none;"></iframe> 
						<input type="submit" name="plan-submit" class="ni btn blue" value="Enviar" />
					</form>
					 <div id="resultado"></div>
				</div>
			</div>
		</div>
	</div>
</body>
</html>

<script type="text/javascript">
	 $ (document).ready(function (){
	 		$('#comprador').select2();
	 }); 
	 </script>

<script type="text/javascript">
	function buscar(){
var opcion = document.getElementById('cant_comprada').value;
var opcion2 = document.getElementById('valor_planificado').value;

$("#valor_comprado").val(opcion*opcion2);
}

//admitir Solo pdf
$("#archivo").change(function () {
        var val = $(this).val();
        switch (val.substring(val.lastIndexOf('.') + 1).toLowerCase()) {
            //Permitidos
            case 'pdf':
                break;
            default:
                $(this).val('');
                alert("Seleccione un archivo PDF");
                $("#archivo").val = null;
                break;
        }
});

//Funcion de lectura (recibe un input *file* capturado del Form)
function readFile(input) {
        //Zona de previsualizar capturada en Variable
        var previewZone = document.getElementById('previsual');
        if (input.files && input.files[0]) {
            //Mostrar boton Cancelar Imagen y Previsual
            document.getElementById('cancelImg').style.display = 'block';
            document.getElementById('previsual').style.display = 'block';
            document.getElementById('archivo').style.display = 'none';
            //Instancia lector
            var reader = new FileReader();
            //Funcion al Cargar el archivo
            reader.onload = function (e) {
                previewZone.src = e.target.result;
                var previsual = document.getElementById('previsual');
                previsual.appendChild(previewZone);

            }
            reader.readAsDataURL(input.files[0]);
        }
    }
    //Capturar el archivo y mandarlo a la funcion 'Readfile()'
    var archivo = document.getElementById('archivo');
    archivo.onchange = function (e) {
        readFile(e.srcElement);
    }

	//Quitar zona de previsual y mostrar input file de nuevo
	function limpiar() {
        document.getElementById('archivo').value = null;
        document.getElementById('cancelImg').style.display = 'none';
        document.getElementById('previsual').src = null;
        document.getElementById('previsual').style.display = 'none';
        document.getElementById('archivo').style.display = 'block';
    }
</script> 