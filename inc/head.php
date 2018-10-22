<?php
$_titles = array('','Inicio','Nueva facturacion','Editar facturacion','Planificacion','Nueva Categoria','Categoria',' Nuevo Comprador', 'Compradores', 'Usuarios','Nuevo usuario','Editar usuario','Configuración','Editar categoria', 'Editar comprador', 'Editar 2');
$_title = $_titles[$_page];
?>
	<meta charset="utf-8" />
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1, user-scalable=no" />
	<title>APPS CISP - PLANIFICACIÓN FINANCIERA - <?php echo $_title; ?></title>
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="media/adminlte/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="media/adminlte/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="media/adminlte/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="media/adminlte/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
 

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

<?php if($_page == 1) { ?>
	<link type="text/css" rel="stylesheet" href="media/css/home.css" media="all" />
<?php }else{ ?>
	<link type="text/css" rel="stylesheet" href="media/css/site.css" media="all" />
	<link type="text/css" rel="stylesheet" href="media/css/site-forms.css" media="all" />
	<link type="text/css" rel="stylesheet" href="media/css/site-responsive.css" media="all" />
<?php } ?>
	<link href="http://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
	<link href="http://fonts.googleapis.com/css?family=Open+Sans:300,300italic,400,600" rel="stylesheet" type="text/css">
	<link rel="icon" href="media/img/cropped-logo2.png" type="image/x-icon" />
	
	<script type="text/javascript" src="media/js/jquery.min.js"></script>
	
<?php
switch($_page) {
	case 1: echo '	<script type="text/javascript" src="media/js/home.js"></script>'; break;
	case 2: echo '	<script type="text/javascript" src="media/js/new-plan.js"></script>'; 
	echo ' <link rel="stylesheet" type="text/css" href=" media/Nueva_carpeta/css/select2.css">';
	echo ' <script src="media/Nueva_carpeta/jquery-3.1.1.min.js"></script>';
	echo ' <script src="media/Nueva_carpeta/js/select2.js"></script>';
	echo '<link rel="stylesheet" type="text/css" href="media/jqueryiu/jquery-ui.css">';
	echo '<script type="text/javascript" src="media/jqueryiu/jquery-ui.js" ></script>';
	echo '<link rel="stylesheet" type="text/css" href="media/overhang/overhang.min.css"/>';
	echo '<script type="text/javascript" src="media/overhang/overhang.min.js"></script>';
	echo ' <script type="text/javascript" src="media/DataTables/DataTables-1.10.18/js/jquery.dataTables.js"></script>'; 
	echo ' <link rel="stylesheet" type="text/css" href="media/DataTables/DataTables-1.10.18/css/jquery.dataTables.css">';break;
	case 3: 
	echo '	<script type="text/javascript" src="media/js/edit_plan.js"></script>'; 
	echo ' <link rel="stylesheet" type="text/css" href=" media/Nueva_carpeta/css/select2.css">';
	echo ' <script src="media/Nueva_carpeta/js/select2.js"></script>';
	echo '<link rel="stylesheet" type="text/css" href="media/jqueryiu/jquery-ui.css">';
	echo '<script type="text/javascript" src="media/jqueryiu/jquery-ui.js" ></script>';
	echo '<link rel="stylesheet" type="text/css" href="media/overhang/overhang.min.css"/>';
	echo '<script type="text/javascript" src="media/overhang/overhang.min.js"></script>';
	echo ' <script type="text/javascript" src="media/DataTables/DataTables-1.10.18/js/jquery.dataTables.js"></script>'; 
	echo ' <link rel="stylesheet" type="text/css" href="media/DataTables/DataTables-1.10.18/css/jquery.dataTables.css">';
	break;

	case 4: 	echo '<script type="text/javascript" src="media/js/items.js"></script>'; 
	echo ' <link rel="stylesheet" type="text/css" href=" media/Nueva_carpeta/css/select2.css">';
	echo ' <script src="media/Nueva_carpeta/js/select2.js"></script>';
	echo '<link rel="stylesheet" type="text/css" href="media/jqueryiu/jquery-ui.css">';
	echo '<script type="text/javascript" src="media/jqueryiu/jquery-ui.js" ></script>';
	echo '<link rel="stylesheet" type="text/css" href="media/overhang/overhang.min.css"/>';
	echo '<script type="text/javascript" src="media/overhang/overhang.min.js"></script>';
	echo ' <script type="text/javascript" src="media/DataTables/DataTables-1.10.18/js/jquery.dataTables.js"></script>'; 
	echo ' <link rel="stylesheet" type="text/css" href="media/DataTables/DataTables-1.10.18/css/jquery.dataTables.css">';
	break;


	case 5:
		echo ' <script type="text/javascript" src="media/DataTables/DataTables-1.10.18/js/jquery.dataTables.js"></script>'; 
		echo ' <link rel="stylesheet" type="text/css" href="media/DataTables/DataTables-1.10.18/css/jquery.dataTables.css">';
		echo '	<script type="text/javascript" src="media/js/new-cat.js"></script>'; break;


	case 6:

		echo ' <script type="text/javascript" src="media/DataTables/DataTables-1.10.18/js/jquery.dataTables.js"></script>'; 
		echo ' <link rel="stylesheet" type="text/css" href="media/DataTables/DataTables-1.10.18/css/jquery.dataTables.css">';
		break;
	case 7: echo '	<script type="text/javascript" src="media/js/new-comprador.js"></script>'; 
	echo ' <link rel="stylesheet" type="text/css" href=" media/Nueva_carpeta/css/select2.css">';
	echo ' <script src="media/Nueva_carpeta/jquery-3.1.1.min.js"></script>';
	echo ' <script src="media/Nueva_carpeta/js/select2.js"></script>';
	echo ' <script type="text/javascript" src="media/DataTables/DataTables-1.10.18/js/jquery.dataTables.js"></script>'; 
	echo ' <link rel="stylesheet" type="text/css" href="media/DataTables/DataTables-1.10.18/css/jquery.dataTables.css">';
	break;
	case 8:
	echo ' <script type="text/javascript" src="media/DataTables/DataTables-1.10.18/js/jquery.dataTables.js"></script>'; 
	echo ' <link rel="stylesheet" type="text/css" href="media/DataTables/DataTables-1.10.18/css/jquery.dataTables.css">';
	break;
	case 9: echo '	<script type="text/javascript" src="media/js/users.js"></script>';
	echo ' <script type="text/javascript" src="media/DataTables/DataTables-1.10.18/js/jquery.dataTables.js"></script>';
	echo ' <link rel="stylesheet" type="text/css" href="media/DataTables/DataTables-1.10.18/css/jquery.dataTables.css">';
	 break;
	
	case 10: echo '<script type="text/javascript" src="media/js/new-user.js"></script>';
		echo ' <link rel="stylesheet" type="text/css" href=" media/Nueva_carpeta/css/select2.css">';
	echo ' <script src="media/Nueva_carpeta/jquery-3.1.1.min.js"></script>';
	echo ' <script src="media/Nueva_carpeta/js/select2.js"></script>';

	case 11:  echo '<script type="text/javascript" src="media/js/edit-user.js"></script>'; break;
	 break;
	case 12: echo '	<script type="text/javascript" src="media/js/settings.js"></script>'; break;


	case 13: echo '	<script type="text/javascript" src="media/js/edit-cat.js"></script>'; break;

	case 14: echo '	<script type="text/javascript" src="media/js/edit-comprador.js"></script>'; break;

	case 15:echo '	<script type="text/javascript" src="media/js/edit_plan2.js"></script>'; 
	echo ' <link rel="stylesheet" type="text/css" href=" media/Nueva_carpeta/css/select2.css">';
	echo ' <script src="media/Nueva_carpeta/js/select2.js"></script>';
	echo '<link rel="stylesheet" type="text/css" href="media/jqueryiu/jquery-ui.css">';
	echo '<script type="text/javascript" src="media/jqueryiu/jquery-ui.js" ></script>';
	echo '<link rel="stylesheet" type="text/css" href="media/overhang/overhang.min.css"/>';
	echo '<script type="text/javascript" src="media/overhang/overhang.min.js"></script>';
	echo ' <script type="text/javascript" src="media/DataTables/DataTables-1.10.18/js/jquery.dataTables.js"></script>'; 
	echo ' <link rel="stylesheet" type="text/css" href="media/DataTables/DataTables-1.10.18/css/jquery.dataTables.css">';
	break;
	// case 16: echo '	<script type="text/javascript" src="media/js/proyects.js"></script>'; echo ' <script type="text/javascript" src="media/DataTables/DataTables-1.10.18/js/jquery.dataTables.js"></script>'; 
	// echo ' <link rel="stylesheet" type="text/css" href="media/DataTables/DataTables-1.10.18/css/jquery.dataTables.css">';
	// break;
	// case 17: echo '	<script type="text/javascript" src="media/js/new-proyect.js"></script>'; break;


} ?>