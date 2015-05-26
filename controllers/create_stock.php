<?php
    include ('../config/conexion.php');
    include ('../config/variables.php');
    
    $product = $_POST['inputProduct'];
    $store = $_POST['inputCampo'];
    
    //echo '<br>'.$product.'--'.$cant.'--'.$store.'--';
    $sqlCreateStock="INSERT INTO $tStock (producto_id, cantidad, tienda_id) VALUES ('$product', '0', '$store') ";
    if($con->query($sqlCreateStock) === TRUE ){
        echo 'true';
    }else{
        echo 'Error al crear producto en almacén<br>'.$con->error;
    }
      
?>