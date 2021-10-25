<?php

    include ('../config/conexion.php');
    include ('../config/variables.php');

    $requestData = $_REQUEST;
    $idSubCat = $_GET['idSucCat'];
    $columns = array(
        0 => 'idProducto',
        1 => 'idCategoria',
        2 => 'idSubcategoria',
        3 => 'idProducto',
        4 => 'precio'
    );

    $productos = array();
    $msgErr = '';
    $ban = true;

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
    $totalData       = $resGetProductos->num_rows;
    $totalFiltered   = $totalData;

    if( !empty( $requestData['search']['value'] ) ){
        $sqlGetProductos .= "   AND ( categorias.nombre LIKE '" . $requestData['search']['value'] . "%' ";
        $sqlGetProductos .= "   OR subcategorias.nombre LIKE '" . $requestData['search']['value'] . "%' ";
        $sqlGetProductos .= "   OR productos.nombre LIKE '%" . $requestData['search']['value'] . "%' ";
        $sqlGetProductos .= "   OR productos.precio LIKE '%" . $requestData['search']['value'] . "%' ";
        $sqlGetProductos .= "   OR productos.codigo_barras LIKE '%" . $requestData['search']['value'] . "%' ) ";
    }
    
    $resGetProductos = $con->query( $sqlGetProductos );
    $totalFiltered   = $resGetProductos->num_rows;
    $sqlGetProductos .= " ORDER BY " . $columns[$requestData['order'][0]['column']] . "   " . $requestData['order'][0]['dir'] . "   LIMIT " . $requestData['start'] . " ," . $requestData['length'] . "   ";
    
    $resGetProductos = $con->query( $sqlGetProductos );
    $data            = array();

    if( $resGetProductos->num_rows > 0 ){
        while( $rowGetProducto = $resGetProductos->fetch_assoc() ){
            $nestedData     = array();
            $nestedData[]   = $rowGetProducto["idProducto"];
            $nestedData[]   = $rowGetProducto["nameCategoria"] ;
            $nestedData[]   = $rowGetProducto["nameSubcategoria"] ;
            $nestedData[]   = $rowGetProducto["nameProducto"] ;
            $nestedData[]   = $rowGetProducto["precio"];
            $data[]         = $nestedData;
        }
    }else{
        $ban = false;
        $msgErr = 'No existen productos en éste almacén.'.$con->error;
    }

    $json_data = array(
        "draw"              => intval( $requestData['draw'] ),
        "recordsTotal"      => intval( $totalData ),
        "recordsFiltered"   => intval( $totalFiltered ),
        "data"              => $data
    );

    echo json_encode( $json_data );

?>