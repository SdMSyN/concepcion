<?php
    include ('../config/conexion.php');
    include ('../config/variables.php');
    
    $store_id=$_POST['idStore'];
    $product_id=$_POST['idProduct'];
    
    $sqlGetProduct="SELECT id, nombre, precio FROM $tProduct WHERE id='$product_id' ";
    
    $resGetProduct = $con->query($sqlGetProduct);
    $optProduct='';
    if($resGetProduct->num_rows > 0){
        while($rowGetProduct = $resGetProduct->fetch_assoc()){
            $optProduct .= '<tr>';
            $optProduct .= '<td><input type="hidden" name="id[]" value="'.$rowGetProduct['id'].'">'.$rowGetProduct['nombre'].'</td>';
            $optProduct .= '<td><input type="hidden" value="'.$rowGetProduct['precio'].'"  id="inputPrecioU" name="inputPrecioU[]">'.$rowGetProduct['precio'].'</td>';
            $optProduct .= '<td><input type="number" id="inputCant" name="inputCant[]" class="form-control cant" min="1" value="1"></td>';
            $optProduct .= '<td><input type="text" id="inputPrecioF" name="inputPrecioF[]" value="'.$rowGetProduct['precio'].'" readonly class="form-control"></td>';
            $optProduct .= '<td><a class="deleteItem"><i class="fa fa-times"></i></td>';
            $optProduct .= '</tr>';
        }
    }else{
        $optProduct = "Error al introducir producto";
    }
    echo $optProduct;
?>
