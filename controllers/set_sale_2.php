 <?php
    include ('../config/conexion.php');
    include ('../config/variables.php');

    $idStore = $_POST['idStore'];
    $idUser = $_POST['idUser'];
    $ban = false;
    $error = '';

    (isset($_POST['inputDonacion'])) ? $dona = $_POST['inputDonacion'] : $dona = "false";
    ($dona != "on") ? $recibido = $_POST['inputRecibido'].".00" : $recibido = "0.00";
    $total = $_POST['inputTotal'];
    ($dona != "on") ? $cambio = $_POST['inputCambio'] : $cambio = "0.00";
    ($dona == "on") ? $idAdmin = $_POST['inputAdmin'] : $idAdmin = "";
    $cad = '';
    //Obtenemos datos de la tienda

    $donarAct = true;
    if ($dona == "on") {
        $sqlGetUserDon = "SELECT id FROM usuarios WHERE password = '$idAdmin' AND perfil_id = '1' ";
        $resGetUserDon = $con->query($sqlGetUserDon);
        if ($resGetUserDon->num_rows > 0) {
            $rowGetUserDon = $resGetUserDon->fetch_assoc();
            $idUser = $rowGetUserDon['id'];
        } else {
            $donarAct = false;
        }
    }
    if ($donarAct == true) {
        $sqlCreateInfoSale = "INSERT INTO ventas_info (usuario_id, tienda_id, fecha, hora, pago, total, cambio, total_desc) 
                                VALUES ('$idUser', '$idStore', '$dateNow', '$timeNow', '$recibido', '$total', '$cambio', '$total' )";
        if ($con->query($sqlCreateInfoSale) === TRUE) {
            $idInfoSale = $con->insert_id;
            for ($i = 0; $i < count($_POST['id']); $i++) {
                $idProduct = $_POST['id'][$i];
                $cant = $_POST['inputCant'][$i];
                $costoU = $_POST['inputPrecioU'][$i];
                $costoF = $_POST['inputPrecioF'][$i];

                $sqlInsertProductSale = "INSERT INTO ventas_prod (producto_id, venta_info_id, cantidad, costo_unitario, costo_total) 
                                            VALUES ('$idProduct', '$idInfoSale', '$cant', '$costoU', '$costoF') ";
                if ($con->query($sqlInsertProductSale) === TRUE) {
                    $sqlGetCantStock = "SELECT cantidad FROM almacenes WHERE producto_id = '$idProduct' AND tienda_id = '$idStore'";
                    $resGetCantStock = $con->query($sqlGetCantStock);
                    if ($resGetCantStock->num_rows > 0) {
                        $rowGetCantStock = $resGetCantStock->fetch_assoc();
                        $cantStock = $rowGetCantStock['cantidad'] - $cant;
                        $sqlUpdStock = "UPDATE almacenes SET cantidad='$cantStock' WHERE producto_id = '$idProduct' AND tienda_id = '$idStore'  ";
                        if ($con->query($sqlUpdStock) === TRUE) {
                            $ban = true;
                        } else {
                            $ban = false;
                            $error .= "Error al modificar cantidades de almacén.<br>" . $con->error;
                        }
                    } else {
                        $ban = false;
                        $error .= "Error al buscar producto en almacén.<br>" . $con->error;
                    }
                } else {
                    $ban = false;
                    $error .= "Error al crear la lista de productos vendidos.<br>" . $con->error;
                }
            }//end for
        } else {
            $ban = false;
            $error .= "Error al crear información de la venta.<br>" . $con->error;
        }

    }
    if( $ban )
        echo json_encode( array( "error" => 0, "msgErr" => $error ) );
    else
        echo json_encode( array( "error" => 1, "msgErr" => $error ) );
?>