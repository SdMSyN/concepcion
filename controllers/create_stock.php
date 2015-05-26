<?php
    include ('../config/conexion.php');
    include ('../config/variables.php');
    
    $product = $_POST['inputProducto'];
    $cant = $_POST['inputCant'];
    $store = $_POST['inputTienda'];
    
    //echo '<br>'.$product.'--'.$cant.'--'.$store.'--';
    $sqlCreateStock="INSERT INTO $tStock (producto_id, cantidad, tienda_id) VALUES ('$product', '$cant', '$store') ";
    if($con->query($sqlCreateStock) === TRUE ){
        echo 'true';
    }else{
        echo 'Error al crear producto en almacén<br>'.$con->error;
    }
      
?>