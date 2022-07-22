<?php
    include ('../config/conexion.php');
    include ('../config/variables.php');
    
    $product = $_POST['inputProduct'];
    $store = $_POST['inputCampo'];
    $user = $_POST['inputUser'];
    
    $sqlGetProduc="SELECT id FROM $tStock WHERE producto_id='$product' AND tienda_id='$store' ";
    $resGetProduct=$con->query($sqlGetProduc);
    if($resGetProduct->num_rows > 0){
        echo "Error, el producto ya se encuentra en éste almacén";
    }else{
        //echo '<br>'.$product.'--'.$cant.'--'.$store.'--';
        $sqlCreateStock="INSERT INTO $tStock (created, user_create, updated, user_update, producto_id, cantidad, tienda_id) VALUES ('$dateNow', '$user', '$dateNow', '$user', '$product', '0', '$store') ";
        if($con->query($sqlCreateStock) === TRUE ){
            echo 'true';
        }else{
            echo 'Error al crear producto en almacén<br>'.$con->error;
        }
    }
  
?>