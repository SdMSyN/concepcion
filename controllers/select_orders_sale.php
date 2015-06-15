<?php
    include ('../config/conexion.php');
    include ('../config/variables.php');
    
    if($_GET['action'] == 'listar'){
        $nameClient= $_POST['inputNombreCliente'];
        $sqlGetOrders = "SELECT id, nombre_cliente, fecha, total, (SELECT SUM(pago) FROM $tOrderPay WHERE pedido_info_id=$tOrderInfo.id ) as pago FROM $tOrderInfo WHERE est_pedido_id='1' ";

        // Ordenar por
        $sqlGetOrders .= ($nameClient != '') ? "AND nombre_cliente LIKE '%$nameClient%' " : "";
        
        //Ejecutamos query
        $resGetOrders = $con->query($sqlGetOrders);
        $datos = '';
        while($rowGetOrders = $resGetOrders->fetch_assoc()){
            $pend = $rowGetOrders['total'] - $rowGetOrders['pago'];
            $datos .= '<tr>';
            $datos .= '<td>'.$rowGetOrders['nombre_cliente'].'</td>';
            $datos .= '<td>'.$rowGetOrders['fecha'].'</td>';
            $datos .= '<td>'.$rowGetOrders['total'].'</td>';
            $datos .= '<td>'.$rowGetOrders['pago'].'</td>';
            $datos .= '<td>'.$pend.'</td>';
            $datos .= '<td><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal" data-whatever="'.$rowGetOrders['id'].'">Pagar</button></td>';
            $datos .= '</tr>';
        }
        echo $datos;
    }
    
?>
