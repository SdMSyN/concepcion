<?php
    include ('../config/conexion.php');
    include ('../config/variables.php');
    
    $store = $_POST['storeId'];
    
    $sqlGetStockName="SELECT nombre FROM $tStore WHERE id='$store' ";
    $resGetStockName=$con->query($sqlGetStockName);
    if($resGetStockName->num_rows > 0){
        $rowGetStockName=$resGetStockName->fetch_assoc();
        echo $rowGetStockName['nombre'];
    }else{
        echo 'false';
    }
?>