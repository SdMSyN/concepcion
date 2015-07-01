<?php
    include ('../config/conexion.php');
    include ('../config/variables.php');
    
    $orderId=$_POST['orderId'];

    $sqlUpdOrderEst="UPDATE $tOrderInfo SET est_pedido_id='2' WHERE id='$orderId' ";
    if($con->query($sqlUpdOrderEst) === TRUE){
        echo "true";
    }else{
        echo "Error al actualizar entrega del pedido.";
    }

?>