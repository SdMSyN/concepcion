<?php
    include ('../config/conexion.php');
    include ('../config/variables.php');
  
    $idStore=$_POST['idStore'];
    $idUser=$_POST['idUser'];
    
    $recibido=$_POST['inputRecibido'];
    $total=$_POST['inputTotal'];
    $cambio=$_POST['inputCambio'];
    $cad='';
    //Obtenemos datos de la tienda
    $sqlGetStore="SELECT * FROM $tStore WHERE id='$idStore' ";
    $resGetStore=$con->query($sqlGetStore);
    $rowGetStore=$resGetStore->fetch_assoc();
    $cad.='<p>'.$rowGetStore['nombre'].'<br>'.$rowGetStore['direccion'].'<br>'.$rowGetStore['cp'].'<br>RFC: '.$rowGetStore['rfc'].'<br>Tel: '.$rowGetStore['tel'].'</p>';
    
    //Obtenemos datos del vendedor y fecha de venta
    $sqlGetUser="SELECT CONCAT(ap,' ',am,' ',nombre) as nombre FROM $tUser WHERE id='$idUser' ";
    $resGetUser=$con->query($sqlGetUser);
    $rowGetUser=$resGetUser->fetch_assoc();
    $cad.='<p>Le atendio: '.$rowGetUser['nombre'].'</br>Fecha: '.$dateNow.'<br>Hora: '.$timeNow.'</p>';
    
    
    $sqlCreateInfoSale="INSERT INTO $tSaleInfo (usuario_id, tienda_id, fecha, hora) VALUES ('$idUser', '$idStore', '$dateNow', '$timeNow')";
    if($con->query($sqlCreateInfoSale) === TRUE){
        $idInfoSale=$con->insert_id;
        $cad.='<table><thead><tr><th>Producto</th><th>C.U.</th><th>Cant.</th><th>C.T.</th></tr></thead><tbody>';
        for($i=0; $i<count($_POST['id']); $i++){
            $idProduct=$_POST['id'][$i];
            $cant=$_POST['inputCant'][$i];
            $costoU=$_POST['inputPrecioU'][$i];
            $costoF=$_POST['inputPrecioF'][$i];
            
            $sqlInsertProductSale="INSERT INTO $tSaleProd (producto_id, venta_info_id, cantidad, costo_unitario, costo_total) VALUES ('$idProduct', '$idInfoSale', '$cant', '$costoU', '$costoF') ";
            if($con->query($sqlInsertProductSale) === TRUE){
                $sqlGetCantStock="SELECT cantidad FROM $tStock WHERE producto_id='$idProduct' AND tienda_id='$idStore'";
                $resGetCantStock=$con->query($sqlGetCantStock);
                if($resGetCantStock->num_rows > 0){
                    $rowGetCantStock=$resGetCantStock->fetch_assoc();
                    $cantStock = $rowGetCantStock['cantidad'] - $cant;
                    $sqlUpdStock="UPDATE $tStock SET cantidad='$cantStock' WHERE producto_id='$idProduct' AND tienda_id='$idStore'  ";
                    if($con->query($sqlUpdStock) === TRUE){
                        $sqlGetProduct="SELECT nombre FROM $tProduct WHERE id='$idProduct' ";
                        $resGetProduct=$con->query($sqlGetProduct);
                        $rowGetProduct=$resGetProduct->fetch_assoc();
                        $productName=$rowGetProduct['nombre'];
                        $cad.='<tr>';
                        $cad.='<td>'.$productName.'</td>';
                        $cad.='<td>'.$costoU.'</td>';
                        $cad.='<td>'.$cant.'</td>';
                        $cad.='<td>'.$costoF.'</td>';
                        $cad.='</tr>';
                        //header("Location: ../form_sales.php");
                        //echo "true";
                    }else{
                        echo "Error al modificar cantidades de almacén.<br>".$con->error;
                    }
                }else{
                    echo "Error al buscar producto en almacén.<br>".$con->error;
                }
            }else{
                echo "Error al crear la lista de productos vendidos.<br>".$con->error;
            }
        }//end for
    }else{
        echo "Error al crear información de la venta.<br>".$con->error;
    }
    
    $cad.='</tbody></table>';
    $cad.='<p>Total: '.$total.'<br>Efectivo: '.$recibido.'<br>Cambio: '.$cambio.'</p>';
    $cad.='Gracias por su preferencia.';
    
    echo $cad;
    
    /*$i=0; $cad ='<table border="2"><tr><td>Id</td><td>Precio U.</td><td>Cantidad</td><td>Precio F.</td></tr>';
    for($i=0; $i<count($_POST['id']); $i++){
        $cad.='<td>'.$_POST['id'][$i].'</td>';
        $cad.='<td>'.$_POST['inputPrecioU'][$i].'</td>';
        $cad.='<td>'.$_POST['inputCant'][$i].'</td>';
        $cad.='<td>'.$_POST['inputPrecioF'][$i].'</td></tr>';
    }
    $cad.='<tr><td colspan="3">Pago cliente</td><td>'.$_POST['inputRecibido'].'</td></tr>';
    $cad.='<tr><td colspan="3">Total</td><td>'.$_POST['inputTotal'].'</td></tr>';
    $cad.='<tr><td colspan="3">Cambio</td><td>'.$_POST['inputCambio'].'</td></tr>';
    $cad.='<tr><td>Tienda</td><td>'.$idStore.'</td><td>Usuario</td><td>'.$idUser.'</td></tr>';
    $cad.='</table>';
    echo $cad;*/
    
    /*var_dump($_POST['id']).'<br>';
    var_dump($_POST['inputPrecioU']).'<br>';
    var_dump($_POST['inputCant']).'<br>';
    var_dump($_POST['inputPrecioF']).'<br>';
    echo $_POST['inputTotal'].'<br>';*/
    
?>