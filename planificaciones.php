<?php
require 'config.php';
require 'inc/session.php';
require 'inc/plan_core.php';
require 'inc/categories_core.php';

if($_session->isLogged() == false)
	header('Location: index.php');
$_plans->set_session_obj($_session);

$_page = 4;


$role = $_session->get_user_role();

if($role==4)
	header('Location: index.php');

if(isset($_POST['act'])) {
	// Search count
	if($_POST['act'] == '1') {
		if(!isset($_POST['val']) || $_POST['val'] == '')
			die('wrong');
		$search_string = $_POST['val'];
		if($_plans->count_plans_search($search_string) == 0)
			die('2');
		die('3');
	}
	
	// Delete plan
	if($_POST['act'] == '2') {
		if(!isset($_POST['id']) || $_POST['id'] == '')
			die('wrong');

		$archivo= $_POST['archivo'];
		if (empty($archivo)){
			$archivo= "";
		}
		
		if($_plans->delete_plan($_POST['id'], $_POST['archivo']) == true)
			die('1');
		die('wrong');
	}
	
	die();
}

if(!isset($_GET['page']) || $_GET['page'] == 0 || !is_numeric($_GET['page']))
	$page = 1;
else
	$page = $_GET['page'];

	
if(!isset($_GET['pp']) || !is_numeric($_GET['pp'])) {
	$pp = 25;
}else{
	$pp = $_GET['pp'];
	if($pp != 25 && $pp != 50 && $pp != 100 && $pp != 150 && $pp != 200 && $pp != 300 && $pp != 500)
		$pp = 25;
}

// Search query
if(isset($_GET['search']) && ($_GET['search'] != '')){
	$s = urldecode($_GET['search']);
	$plans = $_plans->search($s, $page, $pp);
	$c_plans = $_plans->count_plans_search($s);
}else{
	$s = false;
	$plans = $_plans->get_plans($page, $pp);
	$c_plans = $_plans->count_plans();
}
?>
<!DOCTYPE HTML>
<html>
<head>
	<meta http-equiv=”Content-Type” content=”text/html; charset=UTF-8″ />
<link href="bootstrap/css/bootstrap.min.css" rel ="stylesheet"/>

<?php require 'inc/head.php'; ?>
</head>
<body>
	<div id="main-wrapper">
		<?php require 'inc/header.php'; ?>
		
		<div class="wrapper-pad">
			<h2>Planificaciones</h2>
			<div id="table-head">

				<div class="fright" style="height:5px; margin-right:55px;"></div>
<?php
				if($role == 1 || $role == 2)
				echo '<a href="nueva_planificacion.php" name="check-in-all" class="btn green fright"><i class="fa fa-plus"></i>Nueva Planificación</a>';
				?> 
				
			</div>
			
			<?php
			if($c_plans == 0)
				echo '<br />Sin planificaciones';
			else{
			?>
			
			<table  id="plans" class="table table-hover">
				<thead >
					<tr ><div>
						<td width="0%">ID</td>
						<td width="30%">Descripcion</td>
						<td width="19%">Categoria</td>
						<td width="2%">Cant. Planificada</td>
						<td width="2%">Cant. Comprada</td>
						<td width="4%" align="center">Valor Planificado</td>
						<td width="4%">Valor Comprado</td>
						<td width="20%">Comprador</td>
						<td width="10%">Fecha</td>
						<td width="4%">Acciones </td>
						</div>
					</tr>
				</thead>

				
				<tbody>
<?php

					while($plan = $plans->fetch_object()) {
?>


					<tr data-type="element" data-id="<?php echo $plan->id; ?>">

						<td class="hover" data-type="id"><input type="hidden" name="id" value="<?php echo $plan->id; ?>" /><input type="hidden" id="archivo" value="<?php echo $plan->archivo; ?>" /><?php echo $plan->id; ?></td>

						<td class="hover" data-type="descripcion"><input type="hidden" name="descripcion" value="<?php echo $plan->descripcion; ?>" /><?php echo $plan->descripcion; ?></td>

						<td class="hover" data-type="categoria"><input type="hidden" name="categoria" value="<?php echo $plan->categoria; ?>" /><?php echo $_cats->get_category_name($plan->categoria); ?></td>

						<td class="hover" data-type="cant_planificada"><input type="hidden" name="cant_planificada" value="<?php echo $plan->cant_planificada; ?>" /><?php echo number_format($plan->cant_planificada, 0, ",", ".");   ?></td>

						<td class="hover" data-type="cant_comprada"><input type="hidden" name="cant_comprada" value="<?php echo $plan->cant_comprada; ?>" /><?php echo number_format($plan->cant_comprada, 0, ",", "."); ?></td>

						<td class="hover" data-type="valor_planificado"><input type="hidden" name="valor_planificado" value="<?php echo $plan->valor_planificado; ?>" /><?php echo number_format($plan->valor_planificado, 0, ",", "."); ?></td>

						<td class="hover" data-type="valor_comprado"><input type="hidden" name="valor_comprado" value="<?php echo $plan->valor_comprado; ?>" /><?php echo number_format($plan->valor_comprado, 0, ",", "."); ?></td>

						<input type="hidden" id="archivo" value="<?php echo $plan->archivo; ?>" />
						<td class="hover" data-type="comprador"><input type="hidden" name="comprador" value="<?php echo $plan->comprador; ?>" /><?php echo $plan->comprador; ?></td>

						
						<td class="hover" data-type="date_added"><?php echo $plan->date_added; ?></td>
						
<td>
							<?php
							
							if($role == 1 || $role == 2)
								echo '<a href="editar_planificacion.php?id='.$plan->id.'" name="c3" title="Editar"><i class="fa fa-pencil" style="color:rgb(222, 224, 105);"></i>      </a>';
								if($plan->archivo != ""){
								echo '<a href="'.$plan->archivo.'" download><i class="fa fa-download" title="Descargar factura" style="color:rgb(143, 211, 143); aria-hidden="true"></i></a>';
								}
							?>
							<?php
							if($role == 1)
								echo '<a href="" name="c5" title="Eliminar"><i class="fa fa-close" style="color:red;"></i></a>';
							?>
						</td>
					</tr>
<?php
					}
					?>
				</tbody>
			</table>
			<?php } ?>
		</div>
		<div class="clear" style="margin-bottom:10px;"></div>
		<div class="border" style="margin-bottom:0px;"></div>
	</div>
</body>
</html>

<script type="text/javascript">
	 $(document).ready(function (){
	 		$('#plans').DataTable({
	 			  responsive: true,
				"language": {
            	"url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
				}
	 		});
	 }); 
</script>