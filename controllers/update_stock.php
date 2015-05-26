<?php
    include ('../config/conexion.php');
    include ('../config/variables.php');
    
    $idStock=$_POST['inputIdStock'];
    $idProduct=$_POST['inputProducto'];
    $cant=$_POST['inputCant'];
    $idStore=$_POST['inputTienda'];
    
    $sqlUpdateStock="UPDATE $tStock SET producto_id='$idProduct', cantidad='$cant', tienda_id='$idStore' WHERE id='$idStock' ";
            
    if($con->query($sqlUpdateStock) === TRUE ){
        echo 'true';
    }else{
        echo 'Error al modificar producto de almacén<br>'.$con->error;
    }
      
?>