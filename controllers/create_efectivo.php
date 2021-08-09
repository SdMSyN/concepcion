<?php
    include ('../config/conexion.php');
    include ('../config/variables.php');
    $idStore = $_POST['idStore'];
    $idUser  = $_POST['idUser'];
    $cant    = -1 * $_POST['cant'];
    $ban     = true;

    // insertamos la información de la venta
    $sqlCreateInfoSale = "INSERT INTO ventas_info ( usuario_id, tienda_id, fecha, hora, pago, total, cambio, total_desc ) 
                            VALUES ( '$idUser', '$idStore', '$dateNow', '$timeNow', 0, $cant, 0, $cant  ) ";
    if( $con->query( $sqlCreateInfoSale ) === TRUE ) {
        $idInfoSale = $con->insert_id;
        // insertamos el detallado de la venta
        $sqlCreateDtSale = "INSERT INTO ventas_prod ( producto_id, venta_info_id, cantidad, costo_unitario, costo_total ) 
                                VALUES ( 66, '$idInfoSale', 1, $cant, $cant ) "; // FIXME: cambiar id si se actualizá la base
        if( $con->query( $sqlCreateDtSale ) === TRUE ) {
            $ban = true;
        }else{
            $msg = "Error: Al insertar detallado de la venta.";
            $ban = false;
        }
    }else{
        $msg = "Error: al insertar información de la venta.";
        $ban = false;
    }



    if( $ban ){
        $msg = "Se dió efectivo con éxito.";
        echo json_encode( array( "error" => 0, "msgErr" => $msg ) );
    }else{
        $msg = "NO se pudo dar efectivo";
        echo json_encode( array( "error" => 1, "msgErr" => $msg ) );
    }

?>