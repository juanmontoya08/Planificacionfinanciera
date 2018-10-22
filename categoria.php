<?php
require 'config.php';
require 'inc/session.php';
require 'inc/categories_core.php';

if($_session->isLogged() == false)
	header('Location: index.php');

$_page = 6;

$role = $_session->get_user_role();

if($role==4)
	header('Location: index.php');
if(isset($_POST['act'])) {
	// Search count
	if($_POST['act'] == '1') {
		if(!isset($_POST['val']) || $_POST['val'] == '')
			die('wrong');
		$search_string = $_POST['val'];
		if($_cats->count_cats_search($search_string) == 0)
			die('2');
		die('3');
	}
	
	// Delete Category
	if($_POST['act'] == '2') {
		if(!isset($_POST['id']) || $_POST['id'] == '')
			die('wrong');
		if($_cats->delete_cat($_POST['id']) == true)
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
	$cats = $_cats->search($s, $page, $pp);
	$c_cats = $_cats->count_cats_search($s);
}else{
	$s = false;
	$cats = $_cats->get_cats($page, $pp);
	$c_cats = $_cats->count_cats();
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
			<h2>Categorías</h2>
 			<div id="table-head">

				<div class="fright" style="height:5px; margin-right:55px;"></div>
				<?php
				if($role == 1 || $role == 2)
					echo '<a href="nueva_categoria.php" name="new-cat" class="btn green fright"><i class="fa fa-plus"></i>Nueva categoría</a>';
				?>
			</div>
			 
			<?php
			if($c_cats == 0)
				echo '<br /><br />No se encontró datos';
			else{
			?>
			
			<table style="boder 1px" rules="rows" id="categories" class="table table-hover">
				<thead>
					<tr>
						<td width="6%">ID</td>
						<td width="28%">Nombre de la categoría</td>
						<td width="10%">Descripcion</td>
						<td width="14%">Items vinculados</td>
						<td width="11%">Acciones</td>
					</tr>
				</thead>
				<tbody>
<?php
					while($cat = $cats->fetch_object()) {
?>
					<tr data-type="element" data-id="<?php echo $cat->id;?>">
						<td class="hover" data-type="id"><?php echo $cat->id; ?></td>

						<td class="hover" data-type="name"><?php echo $cat->nombre; ?></td>
						<td class="hover" data-type="descripcion"><?php echo $cat->descripcion; ?></td>
						<td><?php echo $_cats->get_cat_reg_plans($cat->id); ?></td>
						<td>
							<?php
							if($role == 1 || $role == 2)
								echo '<a href="edit-category.php?id='.$cat->id.'" name="c3" title="Edit plan"><i class="fa fa-pencil" style="color:rgb(222, 224, 105);"></i></a>';
							if($role == 1 || $role == 2 || $role == 3)
								echo '';
?>
		<a href="reportes/pdf/reporte_categoria.php?categoria=<?php echo $cat->id?>" name="c4" title="Log of this category"><i class="fa fa-file-text-o" style="color:blue;"></i></a>
<?php
							// if($role == 1 || $role == 2)
							// 	echo '<a href="" name="c5" title="Delete plan"><i class="fa fa-close"></i></a>';
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
		
		<div class="clear" style="margin-bottom:40px;"></div>
		<div class="border" style="margin-bottom:30px;"></div>
<!-- 	</div> -->
</body>
</html>

<script type="text/javascript">
	 $ (document).ready(function (){
	 		$('#categories').DataTable({
	 			 responsive: true,
				"language": {
            	"url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
				}
	 		});
	 }); 
</script>
