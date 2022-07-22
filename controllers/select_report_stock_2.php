<?php
    include ('../config/conexion.php');
    include ('../config/variables.php');
    
    $store = $_POST['inputStore'];
    $category = $_POST['inputCategory'];
    //echo $store.'--'.$sellers.'--'.$month.'--'.$week;
    
    $sqlGetInfoStock = "SELECT producto_id as id, updated, cantidad, "
            . "(SELECT nombre FROM $tStore WHERE id=$tStock.tienda_id) as store,"
            . "(SELECT categoria_id FROM $tProduct WHERE id=$tStock.producto_id) as category2 "
            . "FROM $tStock WHERE tienda_id='$store' ORDER BY category2 ";
    
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
            if($category!="") $sqlGetProductSale.=" AND categoria_id='$category' ";
            $resGetProductSale=$con->query($sqlGetProductSale);
            while($rowGetProductSale = $resGetProductSale->fetch_assoc()){
                $costoF=$rowGetInfoStock['cantidad']*$rowGetProductSale['precio'];
                $optReport.='<tr>';
                $optReport.='<td>'.$i.'</td>';
                $optReport.='<td>'.$rowGetProductSale['nombre'].'</td>';
                $optReport.='<td>'.$rowGetProductSale['categoria'].'</td>';
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
        $optReport.='<tr><td></td><td></td><td><b>Totales</b></td><td></td><td><b>'.$cantT.'</b></td><td colspan=5><b>'.$costoFT.'</b></td><td colspan=4></td></tr>';
    }else{
        $optReport = '<tr><td colspan="8">No hay ventas.</td></tr>';
    }
    echo $optReport;
?>