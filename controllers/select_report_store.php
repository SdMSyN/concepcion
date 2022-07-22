<?php
    include ('../config/conexion.php');
    include ('../config/variables.php');
    
    $store = $_POST['inputStore'];
    $seller = $_POST['inputSellers'];
    $month = $_POST['inputMonth'];
    $week = $_POST['inputWeek'];
    $day = $_POST['inputDay'];
    $category = $_POST['inputCategory'];
    $action = $_GET['action'];
    //echo $store.'--'.$sellers.'--'.$month.'--'.$week;
    
    //$sqlGetReport = "SELECT (SELECT nombre FROM $tProduct WHERe id=$tSaleProd.producto_id) as producto, $tSaleProd.costo_unitario as cu, $tSaleProd.cantidad as cant, $tSaleProd.costo_total as ct, (SELECT usuario_id FROM $tSaleInfo WHERE id=$tSaleProd.venta_info_id) as user FROM $tProduct, $tSaleProd, $tSaleInfo WHERE $tSaleProd.venta_info_id=$tSaleInfo.id AND $tSaleInfo.tienda_id='$store' ";
    //$sqlGetReport = "SELECT $tSaleProd.costo_unitario as cu, $tSaleProd.cantidad as cant, $tSaleProd.costo_total as ct, (SELECT nombre FROM $tProduct WHERE id=$tSaleProd.producto_id) as producto FROM $tSaleProd, $tSaleInfo, $tProduct WHERE $tSaleProd.venta_info_id=$tSaleInfo.id AND $tSaleProd.producto_id=$tProduct.id  ";
    $sqlGetInfoSale = "SELECT id, (SELECT nombre FROM $tUser WHERE id=$tSaleInfo.usuario_id) as user, (SELECT nombre FROM $tStore WHERE id=$tSaleInfo.tienda_id) as store, fecha, hora, pago, cambio FROM $tSaleInfo WHERE tienda_id='$store' ";
    
    if($action=="day"){
        $sqlGetInfoSale .= " AND fecha='$dateNow' ";
    }else{//reporte con filtro
        if($seller == "" && $month=="" && $week=="" && $day=="" && $category==""){
            $sqlGetInfoSale .= " AND fecha='$dateNow' ";
        }else if($seller != "" && $month=="" && $week=="" && $day==""){
            $sqlGetInfoSale .= " AND usuario_id='$seller' AND fecha='$dateNow' ";
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
            if(isset($_POST['inputDay']) && $day != ""){
                $sqlGetInfoSale .= " AND fecha='$day' ";
            }
        }
    }
    
    //echo $sqlGetInfoSale.'<br>';
    $resGetInfoSale=$con->query($sqlGetInfoSale);
    $optReport='';
    if($resGetInfoSale->num_rows > 0){
        $i=1;
        $cantT=0;
        $costoFT=0;
        while($rowGetInfoSale = $resGetInfoSale->fetch_assoc()){
            $idInfoSale=$rowGetInfoSale['id'];
            //$sqlGetProductSale="SELECT (SELECT nombre FROM $tProduct WHERE id=$tSaleProd.producto_id) as producto, cantidad as cant, costo_unitario as cu, costo_total as ct";
            $sqlGetProductSale="SELECT $tProduct.nombre as producto, $tSaleProd.cantidad as cant, $tSaleProd.costo_unitario as cu, $tSaleProd.costo_total as ct, $tCategory.nombre as category FROM $tSaleProd INNER JOIN $tProduct ON $tProduct.id=$tSaleProd.producto_id INNER JOIN $tCategory ON $tCategory.id=$tProduct.categoria_id  ";
            //$sqlGetProductSale.=" FROM $tSaleProd WHERE venta_info_id='$idInfoSale' ";
            $sqlGetProductSale.=" WHERE $tSaleProd.venta_info_id='$idInfoSale' ";
//si el filtro categoría esta activo
            if($category!=""){
               //$sqlGetProductSale.=', (SELECT categoria_id FROM $tProduct WHERE id=$tSaleProd.producto_id) as category';
               $sqlGetProductSale.="AND $tProduct.categoria_id='$category' ";
            }
            
            $resGetProductSale=$con->query($sqlGetProductSale);
            while($rowGetProductSale = $resGetProductSale->fetch_assoc()){
                //obtenemos el nombre de la categoría
                /*if($category!=""){
                    $idCategory=$rowGetProductSale['category'];
                    $sqlGetCategory="SELECT nombre FROM $tCategory WHERE id='$idCategory' ";
                    $resGetCategory=$con->query($sqlGetCategory);
                    $rowGetCategory=$resGetCategory->fetch_assoc();
                }*/
                $optReport.='<tr>';
                $optReport.='<td>'.$i.'</td>';
                $optReport.='<td>'.$rowGetProductSale['producto'].'</td>';
                //$optReport .= ($category!="") ? '<td>'.$rowGetProductSale['category'].'</td>' : '<td></td>';
                $optReport .= '<td>'.$rowGetProductSale['category'].'</td>';
                $optReport.='<td>'.$rowGetProductSale['cu'].'</td>';
                $optReport.='<td>'.$rowGetProductSale['cant'].'</td>';
                //$optReport.='<td>'.$rowGetProductSale['ct'].'</td>';
                if($rowGetInfoSale['pago']=="0.00" && $rowGetInfoSale['cambio']=="0.00") 
                    $optReport.='<td>0.00</td>';
                else 
                    $optReport.='<td>'.$rowGetProductSale['ct'].'</td>';
                if($rowGetInfoSale['pago']=="0.00" && $rowGetInfoSale['cambio']=="0.00") 
                    $optReport.='<td>Si</td>';
                else 
                    $optReport.='<td>No</td>';    
                $optReport.='<td>'.$rowGetInfoSale['user'].'</td>';
                $optReport.='<td>'.$rowGetInfoSale['store'].'</td>';
                $optReport.='<td>'.$rowGetInfoSale['fecha'].'</td>';
                $optReport.='<td>'.$rowGetInfoSale['hora'].'</td>';
                $optReport.='</tr>';
                $i++;
                $cantT+=$rowGetProductSale['cant'];
                if($rowGetInfoSale['pago']=="0.00" && $rowGetInfoSale['cambio']=="0.00") 
                    $rowGetProductSale['ct']=0;
                $costoFT+=$rowGetProductSale['ct'];
            }
        }
        $optReport.='<tr><td></td><td><b>Totales</b></td><td></td><td><b>'.$cantT.'</b></td><td colspan=5><b>'.$costoFT.'</b></td><td colspan=4></td></tr>';
    }else{
        $optReport = '<tr><td colspan="9">No hay ventas.</td></tr>';
    }
    echo $optReport;
?>