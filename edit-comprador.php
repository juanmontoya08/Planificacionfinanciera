<?php
require 'config.php';
require 'inc/session.php';
require 'inc/compradors_core.php';
if($_session->isLogged() == false)
	header('Location: index.php');

$_page = 14;

$role = $_session->get_user_role();
// Only Admin and General Supervisor can edit compradoregories
if($role != 1 && $role != 2)
	header('Location: comprador.php');

if(isset($_POST['act'])) {
	if($_POST['act'] == '1') {
		if(!isset($_POST['compradorid']) || !isset($_POST['name']) || !isset($_POST['desc']))
			die('wrong');
		if($_POST['compradorid'] == '' || $_POST['name'] == '')
			die('wrong');
		
		$compradorid = $_POST['compradorid'];
		$name = $_POST['name'];
		$desc = $_POST['desc'];
		
		if($_compradors->edit_comprador($compradorid, $name, $desc) == true)
			die('1');
		die('wrong');
	}
}

if(!isset($_GET['id']))
	header('Location: comprador.php');
$comprador = $_compradors->get_comprador($_GET['id']);
if(!$comprador->id)
	header('Location: comprador.php');
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
			<h2>Editar comprador</h2>
			<div class="center">
				<div class="form">
					<form method="post" action="" name="edit-comprador" data-id="<?php echo $comprador->id; ?>">
						Nombre de comprador:<br />
						<div class="ni-cont">
							<input type="text" name="ncomprador-name" class="ni" value="<?php echo $comprador->nombre; ?>" />
						</div>
						<span class="ncomprador-desc-left">Descripción de comprador (<?php echo 400-strlen($comprador->descrp); ?> caracteres restantes):</span><br />
						<div class="ni-cont">
							<textarea name="ncomprador-descrp" class="ni"><?php echo $comprador->descripcion; ?></textarea>
						</div>
						<input type="submit" name="ncomprador-submit" class="ni btn blue" value="Guardar datos" />
					</form>
				</div>
			</div>
		</div>
		
		<div class="clear" style="margin-bottom:40px;"></div>
		<div class="border" style="margin-bottom:30px;"></div>
	</div>
</body>
</html>