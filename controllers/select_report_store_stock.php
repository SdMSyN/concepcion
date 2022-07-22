<?php
    include ('../config/conexion.php');
    include ('../config/variables.php');
    
    $store = $_GET['idStore'];
    $category = $_GET['inputCategory'];
    //echo $store.'--'.$sellers.'--'.$month.'--'.$week;
    
    $sqlGetInfoStock = "SELECT producto_id as id, updated, cantidad, "
            . "(SELECT nombre FROM $tStore WHERE id=$tStock.tienda_id) as store, "
            . "(SELECT categoria_id FROM $tProduct WHERE id=$tStock.producto_id) as category2 "
            . "FROM $tStock WHERE tienda_id='$store' ORDER BY category2 ";
    
          //fpdf
    require('../fpdf/fpdf.php');
    class PDF extends FPDF{
    // Cabecera de página
      function Header(){
          // Arial bold 15
        $this->SetFont('Arial','B',8);
        // Movernos a la derecha
        $this->Cell(1,1);
        // Título
        $this->Cell(6,7,'#',1,0,'C');
        $this->Cell(68,7,'Producto',1,0,'C');
        $this->Cell(24,7,utf8_decode('Categoría'),1,0,'C');
        $this->Cell(10,7,'C.U.',1,0,'C');
        $this->Cell(10,7,'Cant.',1,0,'C');
        $this->Cell(10,7,'C.F.',1,0,'C');
        $this->Cell(30,7,'Tienda',1,0,'C');
        $this->Cell(36,7,utf8_decode('Fecha de modificación'),1,0,'C');  								
        // Salto de línea
        $this->Ln(9);
      }
      // Pie de página
      function Footer(){
        // Posición: a 1,5 cm del final
        $this->SetY(-15);
        // Arial italic 8
        $this->SetFont('Arial','I',8);
        // Número de página
        $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
      }
    }//Fin class PDF
    // Creación del objeto de la clase heredada
    $pdf = new PDF();
    $pdf->AliasNbPages();
    $pdf->AddPage();
    $pdf->SetFont('Times','',8);
    
    //echo $sqlGetInfoSale.'<br>';
    $resGetInfoStock=$con->query($sqlGetInfoStock);
    $optReport='';
    if($resGetInfoStock->num_rows > 0){
        $i=1;
        $cantT=0;
        $costoFT=0;
        while($rowGetInfoStock = $resGetInfoStock->fetch_assoc()){
            $idInfoSale=$rowGetInfoStock['id'];
            $sqlGetProductSale="SELECT nombre, precio, (SELECT nombre FROM $tCategory WHERE id=$tProduct.categoria_id) as categoria FROM $tProduct WHERE id='$idInfoSale' ";
            if($category!="0") $sqlGetProductSale.=" AND categoria_id='$category' ";
            $resGetProductSale=$con->query($sqlGetProductSale);
            while($rowGetProductSale = $resGetProductSale->fetch_assoc()){
                $costoF=$rowGetInfoStock['cantidad']*$rowGetProductSale['precio'];
                $pdf->Cell(6,7,$i,'B',0,'C');
                $pdf->Cell(68,7,utf8_decode($rowGetProductSale['nombre']),'B',0,'C');
                $pdf->Cell(24,7,utf8_decode($rowGetProductSale['categoria']),'B',0,'C');
                $pdf->Cell(10,7,$rowGetProductSale['precio'],'B',0,'C');
                $pdf->Cell(10,7,$rowGetInfoStock['cantidad'],'B',0,'C');
                $pdf->Cell(10,7,$costoF,'B',0,'C');
                $pdf->Cell(30,7,utf8_decode($rowGetInfoStock['store']),'B',0,'C');
                $pdf->Cell(36,7,$rowGetInfoStock['updated'],'B',1,'C');
                $i++;
                $cantT+=$rowGetInfoStock['cantidad'];
                $costoFT+=$costoF;
            }
        }
        $pdf->Cell(94,7,'','B',0,'C');
        $pdf->Cell(100,7,'Cantidad: '.$cantT.utf8_decode('   Dinero en almacén: ').$costoFT,'B',1);
 
    }else{
        $pdf->Cell(194, 7, 'No hay ventas.', 'B', 0, 'C');
    }

    $pdf->Output();
?>
