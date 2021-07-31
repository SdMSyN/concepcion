<?php

    include ('../config/conexion.php');
    include ('../config/variables.php');

    $productos = array();
    $msgErr = '';
    $ban = true;

    $sqlGetProductos = "SELECT 
                            productos.id AS idProducto, 
                            productos.img AS imgProducto, 
                            productos.nombre as nameProducto
                        FROM almacenes
                        INNER JOIN productos ON almacenes.producto_id = productos.id 
                        WHERE productos.activo = 1
                        ORDER BY productos.nombre ASC ";
    $resGetProductos = $con->query( $sqlGetProductos );
    if( $resGetProductos->num_rows > 0 ){
        while( $rowGetProducto = $resGetProductos->fetch_assoc() ){
            $idP         = $rowGetProducto["idProducto"];
            $nameP       = $rowGetProducto["nameProducto"];
            $imgP        = $rowGetProducto["imgProducto"];
            $productos[] = array( 'idProducto' => $idP, 'nameProducto' => $nameP, 'imgProducto' => $imgP );
        }
    }else{
        $ban = false;
        $msgErr = 'No existen productos en éste almacén.'.$con->error;
    }

    if( $ban )
        echo json_encode( array( "error" => 0, "dataRes" => $productos ) );
    else
        echo json_encode( array( "error" => 1, "msgErr" => $msgErr, "sql" => $sqlGetProductos ) );

?>