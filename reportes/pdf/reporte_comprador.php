<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
?>

<?php
	require '../../config.php';
	require '../../inc/session.php';
	include 'plantilla.php';
	require 'conexion.php';
	include '../../inc/home_core.php';
	include '../../inc/categories_core.php';

if($_session->isLogged() == false)
	header('Location: ../../index.php');

if($_GET){
		if(!empty($_GET["comprador"])){
		$comprador= $_GET["comprador"];
			$query= "SELECT * FROM pf_factura WHERE comprador like '%$comprador%'"; 

		}

}

else $query="SELECT * FROM pf_factura";



	$resultado = $mysqli->query($query);

$pdf = new PDF();
	$pdf->AliasNbPages();
	$pdf->AddPage('L');

	$pdf->SetFillColor(255, 228, 225);
	$pdf->SetFont('Arial','B',8);
	$pdf->Cell(95,8,'DESCRIPCION', 'B', 0,'L');
	$pdf->SetFont('Arial','B',7);
	$pdf->Cell(20,8,'C. planificada', 'B', 0,'C');
	$pdf->Cell(20,8,'C. comprada',  'B', 0,'C');
	$pdf->Cell(20,8,'Val. planificado',  'B', 0,'C');
	$pdf->Cell(20,8,'Val. comprado',  'B', 0,'C');
	$pdf->SetFont('Arial','B',9);
	$pdf->Cell(20,8,'Pendiente',  'B', 0,'C');
	$pdf->Cell(44,8,'Compradores',  'B', 0,'C');
	$pdf->Cell(25,8,'Categoria',  'B', 1,'C');

$totalpre=0;
$totalpend=0;
$totaltermin=0;

	while($row = $resultado->fetch_assoc())
	{
	$pdf->SetFont('Arial','I',6);

	$pdf->Cell(95,8,utf8_decode($row['descripcion']), 'B', 0,'L');

	$pdf->Cell(20,8,utf8_decode($row['cant_planificada']), 'B', 0,'C');
	$pdf->Cell(20,8,utf8_decode($row['cant_comprada']), 'B', 0,'C');
	$pdf->Cell(20,8,utf8_decode($row['valor_planificado']), 'B', 0,'C');
	$pdf->Cell(20,8,utf8_decode($row['valor_comprado']), 'B', 0,'C');
	$pdf->Cell(20,8,($row['cant_planificada'])*($row['valor_planificado'])-($row['valor_comprado']), 'B', 0,'C');
	$pdf->SetFont('Arial','I',5);
	$pdf->Cell(44,8,utf8_decode($row['comprador']), 'B', 0,'C');
	$pdf->SetFont('Arial','I',6);
	$pdf->Cell(25,8,utf8_decode($_cats->get_category_name($row['categoria'])), 'B', 1,'C');
	}
$pdf->SetFont('Arial','I',8);
	$pdf->Cell(95,8,'Total : '.$totalpre, 'B', 0,'L');
	$pdf->SetFont('Arial','B',7);
	$pdf->Cell(20,8,'C. planificada: ', 'B', 0,'C');
	$pdf->Cell(20,8,'C. comprada',  'B', 0,'C');
	$pdf->Cell(20,8,'Val. planificado',  'B', 0,'C');
	$pdf->Cell(20,8,'Val. comprado',  'B', 0,'C');
	$pdf->SetFont('Arial','B',9);
	$pdf->Cell(20,8,'Pendiente',  'B', 0,'C');
	$pdf->Cell(44,8,'Promedio Mensual',  'B', 1,'C');




	

	$pdf->Output();
?>