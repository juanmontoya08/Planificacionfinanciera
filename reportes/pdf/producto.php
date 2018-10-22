<?php


	include 'plantilla.php';
	require 'conexion.php';


			$query="SELECT `id`, `nombre`, `descripcion` FROM `invento_proyect` WHERE "
	;


	$resultado = $mysqli->query($query);


	$pdf = new PDF();
	$pdf->AliasNbPages();
	$pdf->AddPage();
	$pdf->Line(5,74,205,74);
	$pdf->SetFont('Helvetica','',15);
	$pdf->Cell(200,20,'REGISTRO DE ITEMS', 0,0,'C');

	$pdf->SetFont('Helvetica','I',12);

	$pdf->Ln(15);



	$pdf->SetFillColor(255, 228, 225);
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell(40,8,'Item', 0, 0,'C');
	$pdf->Cell(50,8,'Categoria', 0, 0,'C');
	$pdf->Cell(20,8,'Stock', 0, 0,'C');
	$pdf->Cell(30,8,'Precio', 0,1,'C');
	$pdf->Ln(4);

$totalpre=0;
$totalitem=0;
while($row = $resultado->fetch_assoc())
	{
		$totalitem= $totalitem+1;
		$totalpre = $totalpre + $row['PRECIO'];

	$pdf->SetFont('Arial','I',9);
	$pdf->Cell(40,8,$row['item'], 0, 0,'C');
	$pdf->Cell(50,8,$row['categoria'], 0, 0,'C');
	$pdf->Cell(20,8,$row['Stock'], 0, 0,'C');
	$pdf->Cell(27,8,$row['PRECIO'], 0,1,'R');
	}
	$pdf->SetFont('Arial','B',9);
	$pdf->Cell(0,8,'Total items: '.$totalitem,0,0,'L');
	$pdf->Cell(0,8,'Total: '.$totalpre,0,0,'R');


	$pdf->Output();
?>