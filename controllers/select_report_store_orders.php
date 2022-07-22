<?php
    include ('../config/conexion.php');
    include ('../config/variables.php');
    
    $store = $_POST['inputStore'];
    $seller = $_POST['inputSellers'];
    $month = $_POST['inputMonth'];
    $week = $_POST['inputWeek'];
    $est = $_POST['inputEst'];
    $estPay = $_POST['inputEstPay'];
    $action = $_GET['action'];
    //echo $store.'--'.$sellers.'--'.$month.'--'.$week;
    
    $sqlGetInfoOrder = "SELECT id, nombre_cliente, "
            . "(SELECT nombre FROM $tUser WHERE id=$tOrderInfo.usuario_id) as user, "
            . "(SELECT nombre FROM $tStore WHERE id=$tOrderInfo.tienda_id) as store, "
            . "fecha, hora, total, fecha_entrega, hora_entrega_inicial as hei, hora_entrega_final as hef, "
            . "(SELECT nombre FROM $tOrderEst WHERE id=$tOrderInfo.est_pedido_id) as estOrder, "
            . "(SELECT nombre FROM $tOrderEstPay WHERE id=$tOrderInfo.est_pedido_pago_id) as estOrderPay "
            . "FROM $tOrderInfo WHERE tienda_id='$store' ";
    
    if($action=="day"){
        $sqlGetInfoOrder .= "AND fecha='$dateNow' ";
    }else{
        if($seller != "" && $month=="" && $week==""){
            $sqlGetInfoOrder .= "AND usuario_id='$seller' AND fecha='$dateNow' ";
        }else{
            if(isset($_POST['inputSellers']) && $seller != ""){
                $sqlGetInfoOrder .= " AND usuario_id='$seller' ";
            }
            if(isset($_POST['inputMonth']) && $month != ""){
                $mes=($month{5}.$month{6});
                $sqlGetInfoOrder .= " AND month(fecha)='$mes' ";
            }
            if(isset($_POST['inputWeek']) && $week != ""){
                $sema=($week{6}.$week{7})-1;
                $sqlGetInfoOrder .= " AND week(fecha)='$sema' ";
            }
            if(isset($_POST['inputEst']) && $est != ""){
                $sqlGetInfoOrder .= " AND est_pedido_id='$est' ";
            }
            if(isset($_POST['inputEstPay']) && $estPay != ""){
                $sqlGetInfoOrder .= " AND est_pedido_pago_id='$estPay' ";
            }
        }
    }
    
    //echo $sqlGetInfoSale.'<br>';
    $resGetInfoOrder=$con->query($sqlGetInfoOrder);
    $optReport='';
    if($resGetInfoOrder->num_rows > 0){
        while($rowGetInfoOrder = $resGetInfoOrder->fetch_assoc()){
            $optReport.='<tr>';
            $optReport.='<td>'.$rowGetInfoOrder['id'].'</td>';
            $optReport.='<td>'.$rowGetInfoOrder['nombre_cliente'].'</td>';
            $optReport.='<td>'.$rowGetInfoOrder['user'].'</td>';
            $optReport.='<td>'.$rowGetInfoOrder['store'].'</td>';
            $optReport.='<td>'.$rowGetInfoOrder['fecha'].'</td>';
            $optReport.='<td>'.$rowGetInfoOrder['hora'].'</td>';
            $optReport.='<td>'.$rowGetInfoOrder['total'].'</td>';
            $optReport.='<td>'.$rowGetInfoOrder['fecha_entrega'].'</td>';
            $optReport.='<td>De '.$rowGetInfoOrder['hei'].' a las '.$rowGetInfoOrder['hef'].'</td>';
            $optReport.='<td>'.$rowGetInfoOrder['estOrder'].'</td>';
            $optReport.='<td>'.$rowGetInfoOrder['estOrderPay'].'</td>';
            $optReport.='<td><a href="form_select_order_detail.php?id='.$rowGetInfoOrder['id'].'" class="btn btn-success">Detalles</a></td>';
            $optReport.='</tr>';
        }
    }else{
        $optReport = '<tr><td colspan="9">No hay ventas.</td></tr>';
    }
    echo $optReport;
?>