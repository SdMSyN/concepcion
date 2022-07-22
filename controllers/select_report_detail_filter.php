<?php
    include ('../config/conexion.php');
    include ('../config/variables.php');

    $orderId = $_POST['orderId'];
    $tarea = $_POST['tarea'];

    if($tarea=="prod") $sqlGetDetailOrder="SELECT (SELECT nombre FROM $tProduct WHERE id=$tOrderProd.producto_id) as product, costo_unitario, cantidad, costo_total FROM $tOrderProd WHERE pedido_info_id='$orderId' ";
    else if($tarea=="payment") $sqlGetDetailOrder="SELECT (SELECT nombre FROM $tUser WHERE id=$tOrderPay.usuario_id) as user, recibido, pago, cambio, fecha FROM $tOrderPay WHERE pedido_info_id='$orderId' ";
    else $sqlGetDetailOrder="";

    //echo $sqlGetInfoSale.'<br>';
    $resGetDetailOrder=$con->query($sqlGetDetailOrder);
    if($tarea=="prod") $optReport='<thead><tr><th>Producto</th><th>Costo Unitario</th><th>Cantidad</th><th>Total</th></tr></thead>';
    else if($tarea=="payment") $optReport='<thead><tr><th>Usuario</th><th>Recibido</th><th>Pago</th><th>Cambio</th><th>Fecha</th></tr></thead>';
    else $optReport='<thead><tr><th></th><th></th><th></th><th></th></tr></thead>';
    
    if($resGetDetailOrder->num_rows > 0){
        while($rowGetDetailOrder = $resGetDetailOrder->fetch_assoc()){
            $optReport.='<tr>';
            if($tarea=="prod"){
                $optReport .= '<td>'.$rowGetDetailOrder['product'].'</td>';
                $optReport .= '<td>'.$rowGetDetailOrder['costo_unitario'].'</td>';
                $optReport .= '<td>'.$rowGetDetailOrder['cantidad'].'</td>';
                $optReport .= '<td>'.$rowGetDetailOrder['costo_total'].'</td>';
            }else if($tarea == "payment"){
                $optReport .= '<td>'.$rowGetDetailOrder['user'].'</td>';
                $optReport .= '<td>'.$rowGetDetailOrder['recibido'].'</td>';
                $optReport .= '<td>'.$rowGetDetailOrder['pago'].'</td>';
                $optReport .= '<td>'.$rowGetDetailOrder['cambio'].'</td>';
                $optReport .= '<td>'.$rowGetDetailOrder['fecha'].'</td>';
            }else{
                $optReport .= '<td>No hay detalles.</td>';
            }
            $optReport.='</tr>';
        }
    }else{
        $optReport = '<tr><td colspan="5">No hay detalles del pedido.</td></tr>';
    }
    echo $optReport;
?>