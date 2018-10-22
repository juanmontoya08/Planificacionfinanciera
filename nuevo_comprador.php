<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
?>
<?php
require 'config.php';
require 'inc/session.php';
require 'inc/compradors_core.php';
if($_session->isLogged() == false)
	header('location: index.php');

$_page = 7;

$role = $_session->get_user_role();
if($role != 1 && $role != 2)
	header('location: comprador.php');

if(isset($_POST['act'])) {
	if($_POST['act'] == '1') {
		if(!isset($_POST['name']) || $_POST['name'] == '')
			die('wrong');
		if($_compradors->new_comprador($_POST['name'], $_POST['desc']) == true)
			die('1');
		die('wrong');
	}
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
			<h2>Nueva comprador</h2>
			<div class="center">
				<div class="new-comprador form">
					<form method="post" action="" name="new-comprador">
						Nombre de comprador:<br />
						<div class="ni-cont">
							<input type="text" name="ncomprador-name" class="ni" />
						</div>
						<span class="ncomprador-desc-left">Descripción de comprador  (400 caracteres):</span><br />
						<div class="ni-cont">
							<textarea name="ncomprador-descrp" class="ni"></textarea>
						</div>
						<input type="submit" name="nproy-submit" class="ni btn blue" value="Guardar datos" />
					</form>
				</div>
			</div>
		</div>
		<div class="clear" style="margin-bottom:40px;"></div>
		<div class="border" style="margin-bottom:30px;"></div>
	</div>
</body>
</html>