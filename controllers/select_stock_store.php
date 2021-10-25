<?php
    include ('../config/conexion.php');
    include ('../config/variables.php');
    
    $store = $_POST['storeId'];
    
    //$sqlGetStockStore="SELECT id, cantidad, tienda_id, (SELECT nombre FROM $tProduct WHERE id=$tStock.producto_id ORDER BY categoria_id DESC) as producto, producto_id FROM $tStock WHERE tienda_id='$store' ORDER BY producto_id ASC";
    $sqlGetStockStore = "SELECT almacenes.id AS stockId, 
                            almacenes.cantidad AS stockCant, 
                            almacenes.tienda_id AS stockStore, 
                            almacenes.producto_id AS stockProductId, 
                            productos.categoria_id AS productCategory, 
                            productos.nombre AS productName, 
                            categorias.nombre AS categoryName, 
                            categorias.id AS categoryId 
                        FROM almacenes 
                        INNER JOIN productos ON productos.id=almacenes.producto_id 
                        INNER JOIN categorias ON categorias.id=productos.categoria_id 
                        WHERE almacenes.tienda_id = '$store' 
                        AND productos.activo = '1' 
                        AND categorias.activo = '1' 
                        ORDER BY categoryId, productName ";
    $resGetStockStore=$con->query($sqlGetStockStore);
    $optStockStore='';
    // echo $sqlGetStockStore;
    if($resGetStockStore->num_rows > 0){
        while($rowGetStockStore = $resGetStockStore->fetch_assoc()){
            /*$productId=$rowGetStockStore['producto_id'];
            $sqlGetCategory="SELECT (SELECT nombre FROM $tCategory WHERE id=$tProduct.categoria_id) as category FROM $tProduct WHERE id='$productId' ";
            $resGetCategory=$con->query($sqlGetCategory);
            $rowGetCategory=$resGetCategory->fetch_assoc();*/
            
            $optStockStore.='<tr>';
            //$optStockStore.='<td><input type="hidden" value="'.$rowGetStockStore['stockId'].'" name="stockId[]" >'.$rowGetStockStore['stockId'].'</td>';
            $optStockStore.='<input type="hidden" value="'.$rowGetStockStore['stockId'].'" name="stockId[]" >';
            $optStockStore.='<td>'.$rowGetStockStore['productName'].'</td>';
            $optStockStore.='<td>'.$rowGetStockStore['categoryName'].'</td>';
            $optStockStore.='<td>'.$rowGetStockStore['stockCant'].'</td>';
            $optStockStore.='<td class="col-sm-2"><input type="number" name="inputAlm[]" id="inputAlm[]" value="0" class="form-control"></td>';
            $optStockStore.='<input type="hidden" value="'.$rowGetStockStore['stockStore'].'" name="tienda" id="tienda" ';
            $optStockStore.='</tr>';
        }
        //$optStockStore.='<tr><td colspan="2"><button type="button" class="btn btn-primary" data-id="'.$store.'">Añadir producto a almacén</button></td> ';
            //$optStockStore.='<td><input type="submit" class="btn btn-primary" value="Guardar"></td></tr>';
            //$optStockStore.='</form>';
    }else{
        $optStockStore='false';
    }
    echo $optStockStore;
?>