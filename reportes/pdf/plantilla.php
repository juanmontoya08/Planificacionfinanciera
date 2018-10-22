<?php

require 'fpdf/fpdf.php';

	class PDF extends fpdf
	{


		function Header()
		{

			$this->Image('images/cropped-logo2.png',5,5,50);

			$this->SetFont('Helvetica','B',19);
			$this->Cell(50);
			$this->Cell(120,20,utf8_decode('REPORTE PLANIFICACIÓN FINANCIERA'), 0,0,'C');
			$this->Ln(10);
			$this->SetFont('Helvetica','',15);
	$this->Ln(20);
	$this->SetFont('Helvetica','I',12);

		}

		function Footer()
		{
			$this->SetY(-20);
			$this->SetFont('Arial','I',8);
			$this->Cell(0,10,'Fecha: '.date('d/m/Y'),0,0,'L');
			$this->Cell(0, 10, 'Pagina '.$this->PageNo().'/{nb}',0,0,'C');
		}
	}

?>