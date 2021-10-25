<?php

    include ('../config/conexion.php');
    include ('../config/variables.php');

    $ban = false;
    $msg = "";
    $productos = array();

    $sqlGetProductos = "SELECT 
                            productos.img AS imgProducto, 
                            productos.nombre AS nameProducto,
                            productos.precio AS precio,
                            categorias.nombre AS nameCategoria,
                            subcategorias.nombre AS nameSubcategoria,
                            productos.id AS idProducto, 
                            categorias.id AS idCategoria,
                            subcategorias.id AS idSubcategoria,
                            productos.precio,
                            productos.codigo_barras
                        FROM almacenes
                        INNER JOIN productos ON almacenes.producto_id = productos.id 
                        INNER JOIN categorias ON productos.categoria_id = categorias.id
                            AND categorias.activo = 1
                        INNER JOIN subcategorias ON productos.subcategoria_id = subcategorias.id
                            AND subcategorias.activo = 1
                        WHERE productos.activo = 1 ";
                        
    $resGetProductos = $con->query( $sqlGetProductos );

    if( $resGetProductos->num_rows > 0 ){
        while( $rowGetProducto = $resGetProductos->fetch_assoc() ){
            $productos[]     = [
                $rowGetProducto["idProducto"],
                $rowGetProducto["nameProducto"],
                $rowGetProducto["precio"],
                $rowGetProducto["codigo_barras"]
            ];
            $ban = true;
        }
    }else{
        $ban = false;
        $msgErr = 'No existen productos en éste almacén.'.$con->error;
    }

    if( $ban ){
        echo json_encode( array( "error" => 0, "msg" => $msg, "dataRes" => $productos ) );
    } else{
        echo json_encode( array( "error" => 1, "msg" => $msg ) );
    }

?>