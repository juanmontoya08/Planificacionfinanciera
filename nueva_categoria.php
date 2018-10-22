<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
?>
<?php
require 'config.php';
require 'inc/session.php';
require 'inc/categories_core.php';
if($_session->isLogged() == false)
	header('Location: index.php');

$_page = 5;

$role = $_session->get_user_role();
if($role != 1 && $role != 2)
	header('Location: categoria.php');

if(isset($_POST['act'])) {
	if($_POST['act'] == '1') {
		if(!isset($_POST['name']) || $_POST['name'] == '')
			die('wrong');
		if($_cats->new_cat($_POST['name'], $_POST['desc']) == true)
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
			<h2>Nueva categoría</h2>
			<div class="center">
				<div class="new-cat form">
					<form method="post" action="" name="new-cat">
						Nombre de categoría:<br />
						<div class="ni-cont">
							<input type="text" name="ncat-name" class="ni" />
						</div>
						<span class="ncat-desc-left">Descripción de categoría  (400 caracteres):</span><br />
						<div class="ni-cont">
							<textarea name="ncat-descrp" class="ni"></textarea>
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