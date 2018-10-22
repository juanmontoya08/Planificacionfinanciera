<?php
require 'config.php';
require 'inc/session.php';
require 'inc/home_core.php';
if($_session->isLogged() == false)
	header('Location: index.php');

$_page = 1;

$role = $_session->get_user_role();

if(isset($_POST['act']) && $_POST['act'] == 'reqinfo') {
	$interval = $_POST['int'];
	
	$res = array(
		$_home->get_new_items($interval),
		$_home->get_checked_in($interval),
		$_home->get_checked_out($interval),
	);
	
	$res = implode('|', $res);
	
	echo $res;
	die();
}

?>

<!DOCTYPE HTML>
<html>
<?php require 'inc/head.php'; ?>
<body>
	<script type="text/javascript">
	function muestra_oculta(id, id2){
if (document.getElementById){ //se obtiene el id
var el = document.getElementById(id); //se define la variable "el" igual a nuestro div
el.style.display = (el.style.display == 'none') ? 'block' : 'none';

var ele = document.getElementById(id2); //se define la variable "el" igual a nuestro div
ele.style.display = (ele.style.display == 'none') ? 'block' : 'none';

 //damos un atributo display:none que oculta el div
}
}
window.onload = function(){/*hace que se cargue la función lo que predetermina que div estará oculto hasta llamar a la función nuevamente*/
muestra_oculta('ocult');
muestra_oculta('ocult2');
/* "contenido_a_mostrar" es el nombre que le dimos al DIV */
}
</script>


	<div id="main-wrapper">
		<?php require 'inc/header.php'; ?>
		
		<div class="wrapper-pad">
			<h2>Inicio</h2>
			<ul id="selectors" class="menu bg-gray">
				REPORTES:  
				<li class="selected" value="hoy" id="hoy">HOY</li>
				<!-- <li value="Esta Semana" id="Esta Semana"  >ESTA SEMANA</li>
				<li value="Este Mes" id="Este Mes">ESTE MES</li>
				<li value="Este Año" id="Este Año">ESTE AÑO</li> -->
				<li value="Todo" id="Todo">TODOS</li>
				<li value="enero" id="enero">Ene</li>
				<li value="febrero" id="febrero">Feb</li>
				<li value="marzo" id="marzo">Mar</li>
				<li value="abril" id="abril">Abr</li>
				<li value="mayo" id="mayo">May</li>
				<li value="junio" id="junio">Jun</li>
				<li value="julio" id="julio">Jul</li>
				<li value="agosto" id="agosto">Ago</li>
				<li value="septiembre" id="septiembre">Sep</li>
				<li value="octubre" id="octubre">Oct</li>
				<li value="noviembre" id="noviembre">Nov</li>
				<li value="diciembre" id="diciembre">Dic</li>
				<li value="mas" id="mas" onClick="muestra_oculta('ocult', 'ocult2')">RANGO DE REPORTES</li>

<div id="ocult">
RANGO 
<form action="" method="post">
	DESDE: 
		<select id="mes1" name="mes1" onchange="buscar();">
			<option value="0" id="0">Seleccione una opcion</option>
            <option value="01" id="01" >Enero</option>
            <option value="02" id="02">Febrero</option>
            <option value="03" id="03">Marzo</option>
            <option value="04" id="04">Abril</option>
            <option value="05" id="05">Mayo</option>
            <option value="06" id="06">Junio</option>
            <option value="07" id="07">Julio</option>
            <option value="08" id="08">Agosto</option>
            <option value="09" id="09">Septiembre</option>
            <option value="10" id="10">Octubre</option>
            <option value="11" id="11">Noviembre</option>
            <option value="12" id="12">Diciembre</option>
        </select> Hasta 

       <select id="mes2" name="mes2">
	<option value="0">Seleccione una opcion</option>
            <option value="01">Enero</option>
            <option value="02">Febrero</option>
            <option value="03">Marzo</option>
            <option value="04">Abril</option>
            <option value="05">Mayo</option>
            <option value="06">Junio</option>
            <option value="07">Julio</option>
            <option value="08">Agosto</option>
            <option value="09">Septiembre</option>
            <option value="10">Octubre</option>
            <option value="11">Noviembre</option>
            <option value="12">Diciembre</option>
        </select>
        <input type="submit" name="asas" value="PDF" class="btn btn-danger" onclick=this.form.action="reportes/pdf/reporte.php">
        <input type="submit" name="excel" value="EXCEL" class="btn btn-success" onclick=this.form.action="reportes/phpExcel/PHPExcel-1.8/reporteproyecto.php">
        </form>
        </div>
	 
				<br>
			</ul>
			
			<div id="fdetails">

				<div id="ocult2" class="element">

          <!-- /.info-box -->
        <br />
					<span id="numeross"><?php echo $_home->get_new_items('hoy'); ?></span>



					<br />
					CORRESPONDENCIA <br />

					<h3 id="box"></h3>
					<form action="excelproducto.php" method="post">
					<input type="hidden" name="box1" id="box1" value="hoy">

					<link href="bootstrap/css/bootstrap.min.css" rel ="stylesheet"/>

			<input type="submit" name="asas" value="PDF" class="btn btn-danger" onclick=this.form.action="reportes/pdf/reporte.php">
       		<input type="submit" name="excel" value="EXCEL" class="btn btn-success" onclick=this.form.action="reportes/phpExcel/PHPExcel-1.8/reporteproyecto.php">
					</form>
				</div>
			</div>
		</div>
		
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box bg-gray">
            <span class="info-box-icon"><i class="fa fa-archive"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">TOTAL DE ITEMS REGISTRADOS</span>
              <span class="info-box-number"><?php echo $_home->general_registered_items(); ?></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>

                <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box bg-gray">
            <span class="info-box-icon"><i class="fa fa-usd"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">VALOR TOTAL PLANIFICADO.</span>
              <span class="info-box-number"><?php echo $_home->general_warehouse_value(); ?></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>

                <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box bg-gray">
            <span class="info-box-icon"><i class="fa fa-usd"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">VALOR TOTAL COMPRADO.</span>
              <span class="info-box-number"><?php echo $_home->general_warehouse_values(); ?></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>


		<div class="clear" style="margin-bottom:40px;height:1px;"></div>
		<div class="border" style="margin-bottom:30px;"></div>
	
		</div>
</body>
</html>