<?php

	require 'Classes/PHPExcel.php';
	require '../../../config.php';
	require '../../../inc/session.php';
	require 'conexion.php';
	include '../../../inc/home_core.php';
	include '../../../inc/categories_core.php';
	

if($_session->isLogged() == false)
	header('Location: ../../../index.php');


	if($_POST){

		if(!empty($_POST['mes1']) and !empty($_POST['mes2'])){
		$fecha1= $_POST['mes1'];
		$fecha2= $_POST['mes2'];
			$query=$_home->fechar($fecha1, $fecha2);
		}
		else if (empty($_POST['mes1']) and empty($_POST['mes2']) and !empty($_POST['box1'])){
	$fecha= $_POST['box1'];
	$query=$_home->get_report($fecha);
	}
	else if(empty($_POST['mes1']) or empty($_POST['mes2']) and empty($_POST['box1'])){ $query="SELECT * FROM pf_factura";}

	}


else $query="SELECT * FROM pf_factura";


	$resultado = $mysqli->query($query);


	$fila= 2;

	$objPHPExcel = new PHPExcel();
	$objPHPExcel-> getProperties()->setCreator("Juan Montoya")->setDescription("REPORTE DE PROYECTOS");

	$objPHPExcel->getDefaultStyle()->getFont()->setName('Verdana');
	$objPHPExcel->getDefaultStyle()->getFont()->setSize(10);
	$objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(20);
	$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(71);
	$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(27);
	$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(18);
	$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(18);
	$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(18);
	$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(18);
	$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(18);
	$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(40);



	$objPHPExcel->setActiveSheetIndex(0);
	$objPHPExcel->getActiveSheet()->setTitle("PRODUCTOS");

	$objPHPExcel->getActiveSheet()->setCellValue('A1','Descripcion');
	$objPHPExcel->getActiveSheet()->setCellValue('B1','Categoria');
	$objPHPExcel->getActiveSheet()->setCellValue('C1','Cantidad planificada');
	$objPHPExcel->getActiveSheet()->setCellValue('D1','Cantidad comprada');
	$objPHPExcel->getActiveSheet()->setCellValue('E1','Valor Planificado');
	$objPHPExcel->getActiveSheet()->setCellValue('F1','Valor Comprado');
	$objPHPExcel->getActiveSheet()->setCellValue('G1','Pendiente');
	$objPHPExcel->getActiveSheet()->setCellValue('H1','Comprador');

	$objPHPExcel->getActiveSheet()
				->getStyle('A1:H1')
				->getFill()
				->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
				->getStartColor()->setARGB('C1C1C1');

	$borders = array(
		'borders' => array(
			'allborders' => array(
				'style' => PHPExcel_Style_Border::BORDER_THIN,
				'color' => array ('argb' => 'FF000000'),
			)
		),
	);

	$objPHPExcel->getActiveSheet()
				->getStyle('A1:H1')
				->applyFromArray($borders);

$totalpre=0;
	while($row = $resultado->fetch_assoc())
	{
		$totalpre = $totalpre+1;
	$totalcant= $row['cant_planificada']+$totalcant;
	$totalcompr= $row['cant_comprada']+$totalcompr;
	$totalvalplani= $row['valor_planificado']+$totalvalplani;
	$totalvalcomp= $row['valor_comprado']+$totalvalcomp;
	$totalpend= ($row['cant_planificada'])*($row['valor_planificado'])-($row['valor_comprado'])+$totalpend;

		$objPHPExcel->getActiveSheet()->setCellValue('A'.$fila, $row['descripcion']);
		$objPHPExcel->getActiveSheet()->setCellValue('B'.$fila,$_cats->get_category_name($row['categoria']));
		$objPHPExcel->getActiveSheet()->setCellValue('C'.$fila, $row['cant_planificada']);
		$objPHPExcel->getActiveSheet()->setCellValue('D'.$fila, $row['cant_comprada']);
		$objPHPExcel->getActiveSheet()->setCellValue('E'.$fila, $row['valor_planificado']);
		$objPHPExcel->getActiveSheet()->setCellValue('F'.$fila, $row['valor_comprado']);
		$objPHPExcel->getActiveSheet()->setCellValue('G'.$fila,($row['cant_planificada'])*($row['valor_planificado'])-($row['valor_comprado']), 'B', 0,'C');
		$objPHPExcel->getActiveSheet()->setCellValue('H'.$fila, $row['comprador']);

	$objPHPExcel->getActiveSheet()
				->getStyle('A'.$fila.':H'.$fila)
				->applyFromArray($borders)
				;
		$fila++;
	}

	
$objPHPExcel->getActiveSheet()
				->getStyle('A'.$fila.':H'.$fila)
				->applyFromArray($borders);
$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A'.$fila.':B'.$fila);
	$objPHPExcel->getActiveSheet()->setCellValue('A'.$fila,'Total: '.$totalpre);
	$objPHPExcel->getActiveSheet()->setCellValue('C'.$fila,'Cantidad planificada');
	$objPHPExcel->getActiveSheet()->setCellValue('D'.$fila,'Cantidad comprada');
	$objPHPExcel->getActiveSheet()->setCellValue('E'.$fila,'Valor Planificado');
	$objPHPExcel->getActiveSheet()->setCellValue('F'.$fila,'Valor Comprado');
	$objPHPExcel->getActiveSheet()->setCellValue('G'.$fila,'Pendiente');
	$objPHPExcel->getActiveSheet()->setCellValue('H'.$fila,'Promedio Mensual');


		$objPHPExcel->getActiveSheet()
				->getStyle('A'.$fila.':H'.$fila)
				->getFill()
				->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
				->getStartColor()->setARGB('C1C1C1');

$fila++;

$objPHPExcel->getActiveSheet()
				->getStyle('C'.$fila.':H'.$fila)
				->applyFromArray($borders);

	$objPHPExcel->getActiveSheet()->setCellValue('C'.$fila,$totalcant);
	$objPHPExcel->getActiveSheet()->setCellValue('D'.$fila,$totalcompr);
	$objPHPExcel->getActiveSheet()->setCellValue('E'.$fila,$totalvalplani);
	$objPHPExcel->getActiveSheet()->setCellValue('F'.$fila,$totalvalcomp);
	$objPHPExcel->getActiveSheet()->setCellValue('G'.$fila,$totalpend);
	$objPHPExcel->getActiveSheet()->setCellValue('H'.$fila,$totalvalplani/12);



	// header('Content-Type: application/vnd.ms-excel');
	// header('Content-Disposition: attachment;filename="reporteproducto.xls"');
	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	header('Content-Disposition: attachment;filename="reporte_planificacion.xlsx"');

	header('Cache-Control: max-age=0');
	$objWriter=PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel2007');
	$objWriter->save('php://output');
?>