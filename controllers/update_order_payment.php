<?php
    include ('../config/conexion.php');
    include ('../config/variables.php');
    
    $idUser=$_POST['inputUser'];
    $idPay=$_POST['inputCampo'];
    $payment=$_POST['inputPago'];
    $recibido=$_POST['inputRecibido'];
    $cambio=$_POST['inputCambio'];
    
    //echo $idUser.'--'.$idPay.'--'.$payment.'--'.$recibido.'--'.$cambio;
    
    $sqlInsertPayment="INSERT INTO $tOrderPay (pedido_info_id, pago, recibido, cambio, usuario_id) VALUES ('$idPay', '$payment', '$recibido', '$cambio', '$idUser') ";
    if($con->query($sqlInsertPayment) === TRUE){
        $sqlGetSumPay="SELECT SUM(pago) as pagoPed FROM $tOrderPay WHERE pedido_info_id='$idPay' ";
        $resGetSumPay=$con->query($sqlGetSumPay);
        $rowGetSumPay=$resGetSumPay->fetch_assoc();
        $pagoPedido=$rowGetSumPay['pagoPed'];
        
        $sqlGetTotal="SELECT total FROM $tOrderInfo WHERE id='$idPay' ";
        $resGetTotal=$con->query($sqlGetTotal);
        $rowGetTotal=$resGetTotal->fetch_assoc();
        $total=$rowGetTotal['total'];
        
        if($pagoPedido >= $total){
            //$sqlUpdEstPayInfo="UPDATE $tOrderInfo SET est_pedido_id='2', est_pedido_pago_id='2' WHERE id='$idPay' ";
            $sqlUpdEstPayInfo="UPDATE $tOrderInfo SET est_pedido_pago_id='2' WHERE id='$idPay' ";
            if($con->query($sqlUpdEstPayInfo) === TRUE){
                echo "true";
            }else{
                echo "Error al actualizar estatus de pedido información.";
            }
        }else{
            echo "true";
        }
    }else{
        echo "Error al insertar pedido.";
    }
    
    /*$sqlUpdateUser="UPDATE $tUser SET nombre='$nombre', ap='$ap', am='$am', user='$user', password='$pass', perfil_id='$perfil', direccion='$dir', num_int='$numInt', num_ext='$numExt', colonia='$col', municipio='$mun', telefono='$tel', celular='$cel', updated='$dateNow', fec_nac='$nac' WHERE id='$idUser' ";
            
    if($con->query($sqlUpdateUser) === TRUE ){
        echo 'true';
    }else{
        echo 'Error al modificar usuario<br>'.$con->error;
    }*/
      
?>