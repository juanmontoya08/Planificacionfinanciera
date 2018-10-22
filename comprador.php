<?php
require 'config.php';
require 'inc/session.php';
require 'inc/compradors_core.php';

if($_session->isLogged() == false)
	header('Location: index.php');

$_page = 8;

$role = $_session->get_user_role();

if($role==4)
	header('Location: index.php');
if(isset($_POST['act'])) {
	// Search count
	if($_POST['act'] == '1') {
		if(!isset($_POST['val']) || $_POST['val'] == '')
			die('wrong');
		$search_string = $_POST['val'];
		if($_compradors->count_compradors_search($search_string) == 0)
			die('2');
		die('3');
	}
	
	// Delete compradoregory
	if($_POST['act'] == '2') {
		if(!isset($_POST['id']) || $_POST['id'] == '')
			die('wrong');
		if($_compradors->delete_comprador($_POST['id']) == true)
			die('1');
		die('wrong');
	}
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
	$compradors = $_compradors->search($s, $page, $pp);
	$c_compradors = $_compradors->count_compradors_search($s);
}else{
	$s = false;
	$compradors = $_compradors->get_compradors($page, $pp);
	$c_compradors = $_compradors->count_compradors();
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
			<h2>Compradores</h2>
 			<div id="table-head">

				<div class="fright" style="height:5px; margin-right:55px;"></div>
				<?php
				if($role == 1 || $role == 2)
					echo '<a href="nuevo_comprador.php" name="new-comprador" class="btn green fright"><i class="fa fa-plus"></i>Nuevo comprador</a>';
				?>
			</div>
			 
			<?php
			if($c_compradors == 0)
				echo '<br /><br />No se encontró datos';
			else{
			?>
			
			<table border="1" rules="rows" id="compradors" class="table table-hover" >
				<thead>
					<tr>
						<td width="6%">ID</td>
						<td width="28%">Nombre del comprador</td>
						<td width="14%">Plans vinculados</td>
						<td width="11%">Acciones</td>
					</tr>
				</thead>
				<tbody>
<?php
					while($comprador = $compradors->fetch_object()) {
?>
					<tr data-type="element" data-id="<?php echo $comprador->id;?>">
						<td class="hover" data-type="id"><?php echo $comprador->id; ?></td>
						<td class="hover" data-type="name"><?php echo $comprador->nombre; ?></td>
						<td><?php echo $_compradors->get_comprador_reg_plans($comprador->nombre); ?></td>
						<td>
							<?php
							if($role == 1 || $role == 2)
								echo '<a href="edit-comprador.php?id='.$comprador->id.'" name="c3" title="Editar comprador"><i class="fa fa-pencil" style="color:rgb(222, 224, 105);" ></i></a>';
							if($role == 1 || $role == 2 || $role == 3)
							// if($role == 1 || $role == 2)
							// 	echo '<a href="" name="c5" title="Delete plan"><i class="fa fa-close"></i></a>';
							?>
								<a href="reportes/pdf/reporte_comprador.php?comprador=<?php echo $comprador->nombre?>" name="c4" ><i class="fa fa-file-text-o" title="Reporte pdf" style="color:blue;"></i></a>
						</td>
					</tr>
<?php
}
?>
				</tbody>
			</table>
			<?php } ?>
		</div>
		
		<div class="clear" style="margin-bottom:40px;"></div>
		<div class="border" style="margin-bottom:30px;"></div>
<!-- 	</div> -->
</body>
</html>

<script type="text/javascript">
	 $ (document).ready(function (){
	 		$('#compradors').DataTable({
	 			 responsive: true,
				"language": {
            	"url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
				}
	 		});
	 }); 
</script>
