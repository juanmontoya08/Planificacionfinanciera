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
$_plans->set_session_obj($_session);

$_page = 3;

$role = $_session->get_user_role();
if($role != 1 && $role != 2)
	header('Location: planificaciones.php');

if(isset($_POST['act'])) {
	if($_POST['act'] == '1') {
$planid = $_POST['planid'];
$descripcion = $_POST['descripcion'];
$categoria = $_POST['categoria'];
$cant_planificada = $_POST['cant_planificada'];
$cant_comprada = $_POST['cant_comprada'];
$valor_planificado = $_POST['valor_planificado'];
$valor_comprado = $_POST['valor_comprado'];
$comprador = implode(" / ",$_POST['comprador']);
		if($_plans->update_plan($planid, $descripcion, $categoria, $cant_planificada, $cant_comprada, $valor_planificado, $valor_comprado, $comprador) == false);
		die('1');
		die('wrong');
	}
}

if(!isset($_GET['id']))
	header('Location: planificaciones.php');
$planid = $_GET['id'];

$plan = $_plans->get_plan($planid);

if(isset($_FILES['archivo']))
{
	$archivo1 = $_FILES['archivo']['name'];
}else{
	$archivo1= "";
}

?>	
<!DOCTYPE HTML>
<html>
<head>
<?php require 'inc/head.php'; ?>
</head>
<body>
	<div id="main-wrapper">
		<?php require 'inc/header.php'; ?>
		
		<div class="wrapper-pad">
			<h2>Editar Planificación</h2>
			<!--Script separar lista compradores del slash '/' -->
			<?php
				//$compradores = $plan->comprador; 
				//$valor_array = explode('/',$compradores); 
				//foreach($valor_array as $llave => $valores) 
					//{ 
						//echo '<h1>'. $valores .'</h1>';
					//}
			?>

			<div class="center">
				<div class="new-plan form">
					<form method="post" action="" name="edit-plan" data-id="<?php echo $planid; ?>">
						<input type="hidden" id="planid" name="id" class="ni" value="<?php echo $plan->id; ?>" />
						Descripcion:<br />
						<div class="ni-cont">
							<input  type="text" id="descripcion" name="plan-descripcion" class="ni" value="<?php echo $plan->descripcion; ?>" />
						</div>
						Categoría:<br />
						<div class="select-holder">
							<i class="fa fa-caret-down"></i>
							<?php
							$cats = $_cats->get_cats_dropdown();
							if($_cats->count_cats() == 0)
								echo '<select id="categoria" name="plan-category" disabled><option val="no">You need to create a category first</option></select>';
							else{
								echo '<select id="categoria" name="plan-category">';
								if ($plan->categoria != null) {
									echo "<option selected='selected' value=\"{$plan->categoria}\">".$_cats->get_category_name($plan->categoria)."</option>";
								}
								?>
								<?php
								while($catt = $cats->fetch_object()) {
									echo "<option value=\"{$catt->id}\">{$catt->nombre}</option>";
								}
								echo '</select>';
							}
							?>
						</div>
						Cant_planificada:<br />
						<div class="ni-cont">
							<input type="text" id="cant_planificada" name="plan-cant_planificada" class="ni" onkeyup="buscar();" value="<?php echo $plan->cant_planificada; ?>" />
						</div>

						Cant_comprada:<br />
						<div class="ni-cont">
							<input type="text" id="cant_comprada" name="plan-cant_comprada" class="ni" onkeyup="buscar();" value="<?php echo $plan->cant_comprada; ?>" />
						</div>

						valor_planificado:<br />
						<div class="ni-cont">
							<input type="text" id="valor_planificado" name="plan-valor_planificado" class="ni" onkeyup="buscar();" value="<?php echo $plan->valor_planificado; ?>" />
						</div>

						VALOR COMPRADO:
						<input readonly style="background-color:transparent; "type="text" id="valor_comprado" name="valor_comprado" size="6" style="color: gray;" required value="<?php echo $plan->valor_comprado; ?>">
						<br />
						<br />  
						
												comprador:<br />
						<div class="select-holder">
							<i class="fa fa-caret-down"></i>
							<?php
							//Traer compradores
							$compradors = $_compradors->get_compradors_dropdown();
							if($_compradors->count_compradors() == 0)
								echo '<select id="comprador" disabled name="comprador[]"  multiple="multiple"><option val="no">You need to create a c first</option></select>';
							else{
								echo '<select id="comprador" name="comprador[]"  multiple="multiple">';
								//Si tiene compradores
								if ($plan->comprador != null) {
								$compradores = $plan->comprador;
								//Separar compradores 
								$arreglo = explode('/', $compradores); 
								//Recorrer lista de compradores y ponerlos en dropdown
								while($comp = $compradors->fetch_object()) {
									echo "<option value=\"{$comp->nombre}\">".$comp->nombre."</option>";
								}	
								foreach($arreglo as $llave => $valores) 
									{
										//Imprimir comprador seleccionados
										echo "<option  selected='selected' value=\"{$valores}\">".$valores."</option>";
									}
							}
							?>
							<option value="0" disabled>SELECCIONE UNA OPCION</option>
								<?php
								echo '</select>';
							}
							?>
						</div>
						<script>

						</script>
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
						<br>
						<input type="submit"  name="plan-submit" class="ni btn blue" value="Guardar datos" />
						


					</form>
				</div>
			</div>
		</div>
		<div class="clear" style="margin-bottom:40px;"></div>
		<div class="border" style="margin-bottom:30px;"></div>
							
	</div>
</body>
</html>

<script type="text/javascript">
	 $ (document).ready(function (){
	 		$('#comprador').select2();
	 		$('#comprador2').select2();
	 		$('#categoria').select2();
			 var iframeSrc = $('#iframe').attr('src');
			 if (iframeSrc != "") {
				$("#previsual").attr("style", "display:block");
				$("#cancelImg").attr("style", "display:block");
			 }else{
				$("#previsual").attr("style", "display:none");
				$("#cancelArch").attr("style", "display:none");
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
</script>

