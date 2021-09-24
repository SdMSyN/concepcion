<?php
    // include ('../config/conexion.php');
    // include ('../config/variables.php');
    
    // if($_GET['action'] == 'listar'){
    //     $sqlGetProducts = "SELECT $tProduct.id as id, "
    //             . "$tProduct.nombre as nombre, "
    //             . "$tCategory.nombre as categoria, "
    //             . "$tSubCategory.nombre as subcategoria, "
    //             . "$tProduct.precio as precio, "
    //             . "$tProduct.img as img, "
    //             . "$tEst.nombre as activoN, "
    //             . "$tProduct.activo as activo, "
    //             . "$tCategory.id as categoryId "
    //             . "FROM $tProduct "
    //             . "INNER JOIN $tCategory ON $tProduct.categoria_id=$tCategory.id "
    //             . "INNER JOIN $tSubCategory ON $tProduct.subcategoria_id=$tSubCategory.id "
    //             . "INNER JOIN $tEst ON $tProduct.activo=$tEst.id  ";
        
    //     // Ordenar por
	// $est = $_POST['estatus'] - 1;
    //     if($est >= 0) $sqlGetProducts .= " WHERE $tProduct.activo='$est' ";
        
    //     //Ordenar ASC y DESC
	// $vorder = (isset($_POST['orderby'])) ? $_POST['orderby'] : "";
	// if($vorder != ''){
    //         $sqlGetProducts .= " ORDER BY ".$vorder;
	// }else{
    //         $sqlGetProducts .= " ORDER BY categoryId, nombre ";
    //     }
        
    //     //Ejecutamos query
    //     $resGetProducts = $con->query($sqlGetProducts);
    //     $datos = '';
    //     while ($rowGetProducts = $resGetProducts->fetch_assoc()) {
    //         $datos .= '<tr>';
    //         $datos .= '<td>'.$rowGetProducts['id'].'</td>';
    //         $datos .= '<td><img src="' . $rutaImgProd . $rowGetProducts['img'] . '" class="img-product-list"></td>';
    //         $datos .= '<td>'.$rowGetProducts['nombre'].'</td>';
    //         $datos .= '<td>'.$rowGetProducts['categoria'].'</td>';
    //         $datos .= '<td>'.$rowGetProducts['subcategoria'].'</td>';
    //         $datos .= '<td>'.$rowGetProducts['precio'].'</td>';
    //         $datos .= '<td>'.$rowGetProducts['activoN'].'</td>';
    //         $datos .= '<td><a href="form_update_product.php?id=' . $rowGetProducts['id'] . '" target="_blanck">Modificar</a></td>';
    //         if($rowGetProducts['activo']==0)
    //             $datos .= '<td><a class="activate" data-id="' . $rowGetProducts['id'] . '" >Dar de alta</a></td>';
    //         else
    //             $datos .= '<td><a class="delete" data-id="' . $rowGetProducts['id'] . '" >Dar de baja</a></td>';
    //         $datos .= '</tr>';
    //     }
    //     echo $datos;
    // }
    
    include ('../config/conexion.php');
    include ('../config/variables.php');

    $requestData = $_REQUEST;
    $columns = array(
        0 => 'idProducto',
        1 => 'idCategoria',
        2 => 'idSubcategoria',
        3 => 'idProducto',
        4 => 'precio',
        5 => 'modificar',
        6 => 'alta'
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
                            productos.activo AS actProd,
                            productos.precio,
                            productos.codigo_barras
                        FROM almacenes
                        INNER JOIN productos ON almacenes.producto_id = productos.id 
                        INNER JOIN categorias ON productos.categoria_id = categorias.id
                            AND categorias.activo = 1
                        INNER JOIN subcategorias ON productos.subcategoria_id = subcategorias.id
                            AND subcategorias.activo = 1 ";
                        
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
            $nestedData[]   = '<a href="form_update_product.php?id=' . $rowGetProducto['idProducto'] . '" target="_blanck">Modificar</a>';
            $nestedData[]   = ( $rowGetProducto['actProd'] == 0 ) ? '<a class="activate" data-id="' . $rowGetProducto['idProducto'] . '" >Dar de alta</a>' : '<a class="delete" data-id="' . $rowGetProducto['idProducto'] . '" >Dar de baja</a>';
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
