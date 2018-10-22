<?php
$headrole = $_session->get_user_role();
$headuser =$_session->get_user_id();
if($headrole == 1)
	$as = 'Administrador';
elseif($headrole == 2)
	$as = 'General Supervisor';
elseif($headrole == 3)
	$as = 'Supervisor';
elseif($headrole == 4)
	$as = 'Usuario';
?>
<div id="header">
			<div class="left">
				<a href="http://cispcolombia.org/" target='_blank'><img src="media/img/cropped-logo2.png" width="150" height="50" alt="Impresiones App" /></a>
				<div style="font-size:12px; font-style:italic;color:#bbb;"><?php echo $as; echo $headuser; ?></div>
			</div>
			<div class="right">
				<?php
				if($headrole == 1)
					echo '<a href="users.php" title="Users">Usuarios</a>|';
				?>
				<a href="settings.php" title="Settings">Configuración</a>|
				<a href="logout.php" title="Logout">Salir</a>
			</div>
			<div class="clear"></div>
		</div>
		
		<input type="checkbox" class="toggle" id="opmenu" style="display:none"/>
		<label for="opmenu" id="open-menu"><i class="fa fa-align-justify"></i> Menu</label>
		<div id="menu">
			<ul id="menuli">
				<?php
				// Home only for Admin and General Supervisor (Stats)
if($headrole == 1 || $headrole == 2 || $headrole == 3) {
				?>
					<li<?php if($_page == 1) { ?> class="active"<?php } ?>><a href="home.php" title="Home"><i class="fa fa-home"></i> Inicio</a></li>
					<li<?php if($_page == 4) { ?> class="active"<?php } ?>><a href="planificaciones.php" title="Planificaciones"><i class="fa fa-list-ul"></i> Planificaciones</a></li>
					<li<?php if($_page == 6) { ?> class="active"<?php } ?>><a href="categoria.php" title="Categoria"><i class="fa fa-folder"></i>Categoria</a></li>
				<li<?php if($_page == 8) { ?> class="active"<?php } ?>><a href="comprador.php" title="Comprador"><i class="fa fa-user"></i> Comprador</a></li>
				<?php
				}


				?>
				<?php
				// Add Item only for Admin, General Supervisor and Supervisor
				if($headrole == 1 || $headrole == 2 || $headrole == 3 || $headrole == 4){
				?>
					
				<?php
				}
				?>
				
			</ul>
		</div>