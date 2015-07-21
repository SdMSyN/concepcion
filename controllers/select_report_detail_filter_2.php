<?php
    include ('../config/conexion.php');
    include ('../config/variables.php');

    $orderId = $_POST['orderId'];
    $tarea = $_POST['tarea'];

    $sqlGetDetailOrder="SELECT (SELECT nombre FROM $tProduct WHERE id=$tOrderProd.producto_id) as product, costo_unitario, cantidad, costo_total FROM $tOrderProd WHERE pedido_info_id='$orderId' ";
    $sqlGetDetailOrder2="SELECT (SELECT nombre FROM $tUser WHERE id=$tOrderPay.usuario_id) as user, recibido, pago, cambio, fecha FROM $tOrderPay WHERE pedido_info_id='$orderId' ";

    //echo $sqlGetInfoSale.'<br>';
    $resGetDetailOrder=$con->query($sqlGetDetailOrder);
    $resGetDetailOrder2=$con->query($sqlGetDetailOrder2);
    $optReport='<table class="table table-striped" id="tableReport"><caption><h4>Detalles de productos</h4></caption><thead><tr><th>Producto</th><th>Costo Unitario</th><th>Cantidad</th><th>Total</th></tr></thead>';
    $optReport2='<table class="table table-striped" id="tableReport"><caption><h4>Detalles de pagos</h4></caption><thead><tr><th>Usuario</th><th>Recibido</th><th>Pago</th><th>Cambio</th><th>Fecha</th></tr></thead>';
    
    if($resGetDetailOrder->num_rows > 0){
        while($rowGetDetailOrder = $resGetDetailOrder->fetch_assoc()){
            $optReport.='<tr>';
            //if($tarea=="prod"){
                $optReport .= '<td>'.$rowGetDetailOrder['product'].'</td>';
                $optReport .= '<td>'.$rowGetDetailOrder['costo_unitario'].'</td>';
                $optReport .= '<td>'.$rowGetDetailOrder['cantidad'].'</td>';
                $optReport .= '<td>'.$rowGetDetailOrder['costo_total'].'</td>';
            //}else if($tarea == "payment"){
            $optReport.='</tr>';
        }
    }else{
        $optReport = '<tr><td colspan="5">No hay detalles del pedido.</td></tr>';
    }
    if($resGetDetailOrder2->num_rows > 0){
        while($rowGetDetailOrder2 = $resGetDetailOrder2->fetch_assoc()){
            $optReport2.='<tr>';
                $optReport2 .= '<td>'.$rowGetDetailOrder2['user'].'</td>';
                $optReport2 .= '<td>'.$rowGetDetailOrder2['recibido'].'</td>';
                $optReport2 .= '<td>'.$rowGetDetailOrder2['pago'].'</td>';
                $optReport2 .= '<td>'.$rowGetDetailOrder2['cambio'].'</td>';
                $optReport2 .= '<td>'.$rowGetDetailOrder2['fecha'].'</td>';
            $optReport2.='</tr>';
        }
    }else{
        $optReport2 = '<tr><td colspan="5">No hay detalles del pedido.</td></tr>';
    }
    echo $optReport.'</table>'.$optReport2.'</table>';
?>