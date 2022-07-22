<?php

/* No ejecutar peligro, no ejecutar, en verdad no ejecutes. */

    include ('../config/conexion.php');
    
    $sqlGetProd0="SELECT id FROM $tProduct WHERE activo='0' ";
    $resGetProd0=$con->query($sqlGetProd0);
    while($rowGetProd0 = $resGetProd0->fetch_assoc()){
        $idProduct=$rowGetProd0['id'];
        $sqlDelProductStock="DELETE FROM $tStock WHERE producto_id='$idProduct' ";
        if($con->query($sqlDelProductStock) === TRUE){
            $sqlDelProductSale="DELETE FROM $tSaleProd WHERE producto_id='$idProduct' ";
            if($con->query($sqlDelProductSale) === TRUE){
                $sqlDelProductProduct="DELETE FROM $tProduct WHERE id='$idProduct' ";
                if($con->query($sqlDelProductProduct) === TRUE){
                    echo "<br>Producto ".$idProduct." eliminado con éxito de almacén y ventas.<br>";
                }else{
                    echo "Error al eliminar el producto de productos.<br>";
                    echo "Producto: ".$idProduct."<br>";
                    echo $con->error."<br>";
                }
            }else{
                echo "Error al eliminar el producto de ventas.<br>";
                echo "Producto: ".$idProduct."<br>";
                echo $con->error."<br>";
            }
        }else{
            echo "Error al eliminar el producto de almacén.<br>";
            echo "Producto: ".$idProduct."<br>";
            echo $con->error."<br>";
        }
    }

?>