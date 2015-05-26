<?php
    include ('../config/conexion.php');
    include ('../config/variables.php');
    
    $store = $_POST['storeId'];
    
    $sqlGetStockStore="SELECT id, cantidad, tienda_id, (SELECT nombre FROM $tProduct WHERE id=$tStock.producto_id) as producto FROM $tStock WHERE tienda_id='$store' ";
    $resGetStockStore=$con->query($sqlGetStockStore);
    $optStockStore='';
    if($resGetStockStore->num_rows > 0){
        while($rowGetStockStore = $resGetStockStore->fetch_assoc()){
            $optStockStore.='<tr>';
            $optStockStore.='<td><input type="hidden" value="'.$rowGetStockStore['id'].'" name="stockId[]" >'.$rowGetStockStore['id'].'</td>';
            $optStockStore.='<td>'.$rowGetStockStore['producto'].'</td>';
            $optStockStore.='<td>'.$rowGetStockStore['cantidad'].'</td>';
            $optStockStore.='<td><input type="number" name="inputAlm[]" id="inputAlm[]" value="0"></td>';
            $optStockStore.='<input type="hidden" value="'.$rowGetStockStore['tienda_id'].'" name="tienda" id="tienda" ';
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