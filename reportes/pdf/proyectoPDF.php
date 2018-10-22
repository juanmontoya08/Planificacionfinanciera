<?php


	include 'plantilla.php';
	include '../../config.php';
	include '../../inc/plan_core.php';
	
header("Content-Type: text/html; charset=iso-8859-1 ");


	if($_GET){
	$id= $_GET['id'];
	$hoy = date("Y-m-d");
	}

$query="SELECT id, archivo, usuario, date_added, estado FROM invento_items WHERE id_proyect=$id" ;


	$resultado = $mysqli->query($query);

	$pdf = new PDF();
	$pdf->AliasNbPages();
	$pdf->AddPage();
	$pdf->Line(5,58,205,58);
	$pdf->SetFillColor(255, 228, 225);
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell(10,8,'ID', 0, 0,'C');
	$pdf->Cell(30,8,'USUARIO', 0, 0,'C');
	$pdf->Cell(86,8,'NOMBRE ARCHIVO', 0, 0,'C');
	$pdf->Cell(34,8,'FECHA', 0, 0,'C');
	$pdf->Cell(40,8,'ESTADO', 0, 1,'C');


$totalpre=0;
$totalpend=0;
$totaltermin=0;

	while($row = $resultado->fetch_assoc())
	{
	$totalpre = $totalpre+1;
	if (
	$row['estado']==0)
	{
		$totalpend= $totalpend+1;
		$row['estado']="PENDIENTE";
	}
	else {
		$totaltermin= $totaltermin+1;
		$row['estado']="TERMINADO";
	}
	$pdf->SetFont('Arial','I',9);
	
	$pdf->Cell(10,8,$totalpre, 0, 0,'C');
	$pdf->Cell(30,8,$_items->get_users_name($row['usuario']), 0, 0,'C');
	$pdf->Cell(86,8,utf8_decode($row['archivo']), 0, 0,'C');
	$pdf->Cell(34,8,$row['date_added'], 0, 0,'C');
	$pdf->Cell(40,8,$row['estado'], 0, 1,'C');
	}
$pdf->SetFont('Arial','I',9);


	$pdf->Cell(0,8,'Total pendientes: '.$totalpend,0,1,'L');
	$pdf->Cell(0,8,'Total terminados: '.$totaltermin,0,1,'L');
	$pdf->Cell(0,8,'Total : '.$totalpre,0,1,'L');

	$pdf->Output();
?>