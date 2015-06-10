<?php
    include ('../config/conexion.php');
    include ('../config/variables.php');
    
    $store = $_POST['inputStore'];
    $seller = $_POST['inputSellers'];
    $month = $_POST['inputMonth'];
    $week = $_POST['inputWeek'];
    $action = $_GET['action'];
    //echo $store.'--'.$sellers.'--'.$month.'--'.$week;
    
    //$sqlGetReport = "SELECT (SELECT nombre FROM $tProduct WHERe id=$tSaleProd.producto_id) as producto, $tSaleProd.costo_unitario as cu, $tSaleProd.cantidad as cant, $tSaleProd.costo_total as ct, (SELECT usuario_id FROM $tSaleInfo WHERE id=$tSaleProd.venta_info_id) as user FROM $tProduct, $tSaleProd, $tSaleInfo WHERE $tSaleProd.venta_info_id=$tSaleInfo.id AND $tSaleInfo.tienda_id='$store' ";
    //$sqlGetReport = "SELECT $tSaleProd.costo_unitario as cu, $tSaleProd.cantidad as cant, $tSaleProd.costo_total as ct, (SELECT nombre FROM $tProduct WHERE id=$tSaleProd.producto_id) as producto FROM $tSaleProd, $tSaleInfo, $tProduct WHERE $tSaleProd.venta_info_id=$tSaleInfo.id AND $tSaleProd.producto_id=$tProduct.id  ";
    $sqlGetInfoSale = "SELECT id, (SELECT nombre FROM $tUser WHERE id=$tSaleInfo.usuario_id) as user, (SELECT nombre FROM $tStore WHERE id=$tSaleInfo.tienda_id) as store, fecha, hora FROM $tSaleInfo WHERE tienda_id='$store' ";
    
    if($action=="day"){
        $sqlGetInfoSale .= "AND fecha='$dateNow' ";
    }else{
        if(isset($_POST['inputSellers']) && $seller != ""){
            $sqlGetInfoSale .= " AND usuario_id='$seller' ";
        }
        if(isset($_POST['inputMonth']) && $month != ""){
            $mes=($month{5}.$month{6});
            $sqlGetInfoSale .= " AND month(fecha)='$mes' ";
        }
        if(isset($_POST['inputWeek']) && $week != ""){
            $sema=($week{6}.$week{7})-1;
            $sqlGetInfoSale .= " AND week(fecha)='$sema' ";
        }
    }
    
    //echo $sqlGetInfoSale.'<br>';
    $resGetInfoSale=$con->query($sqlGetInfoSale);
    $optReport='';
    if($resGetInfoSale->num_rows > 0){
        while($rowGetInfoSale = $resGetInfoSale->fetch_assoc()){
            $i=1;
            $idInfoSale=$rowGetInfoSale['id'];
            $sqlGetProductSale="SELECT (SELECT nombre FROM $tProduct WHERE id=$tSaleProd.producto_id) as producto, cantidad as cant, costo_unitario as cu, costo_total as ct FROM $tSaleProd WHERE venta_info_id='$idInfoSale' ";
            $resGetProductSale=$con->query($sqlGetProductSale);
            while($rowGetProductSale = $resGetProductSale->fetch_assoc()){
                $optReport.='<tr>';
                $optReport.='<td>'.$i.'</td>';
                $optReport.='<td>'.$rowGetProductSale['producto'].'</td>';
                $optReport.='<td>'.$rowGetProductSale['cu'].'</td>';
                $optReport.='<td>'.$rowGetProductSale['cant'].'</td>';
                $optReport.='<td>'.$rowGetProductSale['ct'].'</td>';
                $optReport.='<td>'.$rowGetInfoSale['user'].'</td>';
                $optReport.='<td>'.$rowGetInfoSale['store'].'</td>';
                $optReport.='<td>'.$rowGetInfoSale['fecha'].'</td>';
                $optReport.='<td>'.$rowGetInfoSale['hora'].'</td>';
                $optReport.='</tr>';
                $i++;
            }
        }
    }else{
        $optReport = '<tr><td colspan="9">No hay ventas.</td></tr>';
    }
    echo $optReport;
?>