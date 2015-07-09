<?php
    include ('../config/conexion.php');
    include ('../config/variables.php');
    
    $store = $_POST['inputStore'];
    //echo $store.'--'.$sellers.'--'.$month.'--'.$week;
    
    $sqlGetInfoStock = "SELECT producto_id as id, updated, cantidad, (SELECT nombre FROM $tStore WHERE id=$tStock.tienda_id) as store FROM $tStock WHERE tienda_id='$store' ";
    
    //echo $sqlGetInfoSale.'<br>';
    $resGetInfoStock=$con->query($sqlGetInfoStock);
    $optReport='';
    if($resGetInfoStock->num_rows > 0){
        $i=1;
        $cantT=0;
        $costoFT=0;
        while($rowGetInfoStock = $resGetInfoStock->fetch_assoc()){
            $idInfoSale=$rowGetInfoStock['id'];
            $sqlGetProductSale="SELECT nombre, precio FROM $tProduct WHERE id='$idInfoSale' ";
            $resGetProductSale=$con->query($sqlGetProductSale);
            while($rowGetProductSale = $resGetProductSale->fetch_assoc()){
                $costoF=$rowGetInfoStock['cantidad']*$rowGetProductSale['precio'];
                $optReport.='<tr>';
                $optReport.='<td>'.$i.'</td>';
                $optReport.='<td>'.$rowGetProductSale['nombre'].'</td>';
                $optReport.='<td>'.$rowGetProductSale['precio'].'</td>';
                $optReport.='<td>'.$rowGetInfoStock['cantidad'].'</td>';
                $optReport.='<td>'.$costoF.'</td>';
                $optReport.='<td>'.$rowGetInfoStock['store'].'</td>';
                $optReport.='<td>'.$rowGetInfoStock['updated'].'</td>';
                $optReport.='</tr>';
                $i++;
                $cantT+=$rowGetInfoStock['cantidad'];
                $costoFT+=$costoF;
            }
        }
        $optReport.='<tr><td></td><td><b>Totales</b></td><td></td><td><b>'.$cantT.'</b></td><td colspan=5><b>'.$costoFT.'</b></td><td colspan=4></td></tr>';
    }else{
        $optReport = '<tr><td colspan="9">No hay ventas.</td></tr>';
    }
    echo $optReport;
?>