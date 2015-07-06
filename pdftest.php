<?php
require('fpdf/fpdf.php');

class PDF extends FPDF
{
// Cabecera de página
function Header()
{
    // Arial bold 15
    $this->SetFont('Arial','B',8);
    // Movernos a la derecha
    $this->Cell(1,1);
    // Título
    $this->Cell(37,7,'Producto',1,0,'C');
    $this->Cell(12,7,'C.U.',1,0,'C');
    $this->Cell(12,7,'Cant.',1,0,'C');
    $this->Cell(12,7,'C.F.',1,0,'C');
    $this->Cell(30,7,'Donación',1,0,'C');
    $this->Cell(30,7,'Vendedor',1,0,'C');
    $this->Cell(30,7,'Tienda',1,0,'C');
    $this->Cell(15,7,'Fecha',1,0,'C');
    $this->Cell(15,7,'Hora',1,0,'C');    								
    // Salto de línea
    $this->Ln(8);
}

// Pie de página
function Footer()
{
    // Posición: a 1,5 cm del final
    $this->SetY(-15);
    // Arial italic 8
    $this->SetFont('Arial','I',8);
    // Número de página
    $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
}
}

// Creación del objeto de la clase heredada
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Times','',9);
for ($i = 1; $i <= 60; $i++) {
//    $pdf->Cell(0,7,'producto número '.$i,0,1);
  $pdf->Cell(38, 7, 'Producto número ' . $i,'B', 0);
  $pdf->Cell(12, 7, 'C.U.', 'B', 0,'C');
  $pdf->Cell(12, 7, 'Cant.', 'B', 0,'C');
  $pdf->Cell(12, 7, 'C.F.', 'B', 0,'C');
  $pdf->Cell(30, 7, 'Donación', 'B', 0,'C');
  $pdf->Cell(30, 7, 'Vendedor', 'B', 0);
  $pdf->Cell(30, 7, 'Tienda', 'B', 0);
  $pdf->Cell(15, 7, 'Fecha', 'B', 0);
  $pdf->Cell(15, 7, 'Hora', 'B', 1);
}
$pdf->Output();
?>