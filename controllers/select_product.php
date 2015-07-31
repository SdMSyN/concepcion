<?php
    include ('../config/conexion.php');
    include ('../config/variables.php');
    
    if($_GET['action'] == 'listar'){
        //$sqlGetProducts = "SELECT id, nombre, (SELECT nombre FROM $tCategory WHERE id=$tProduct.categoria_id) as categoria, (SELECT nombre FROM $tSubCategory WHERE id=$tProduct.subcategoria_id) as subcategoria, precio, img, (SELECT nombre FROM $tEst WHERE id=$tProduct.activo) as activoN, activo  FROM $tProduct  ";
        $sqlGetProducts = "SELECT $tProduct.id as id, "
                . "$tProduct.nombre as nombre, "
                . "$tCategory.nombre as categoria, "
                . "$tSubCategory.nombre as subcategoria, "
                . "$tProduct.precio as precio, "
                . "$tProduct.img as img, "
                . "$tEst.nombre as activoN, "
                . "$tProduct.activo as activo, "
                . "$tCategory.id as categoryId "
                . "FROM $tProduct "
                . "INNER JOIN $tCategory ON $tProduct.categoria_id=$tCategory.id "
                . "INNER JOIN $tSubCategory ON $tProduct.subcategoria_id=$tSubCategory.id "
                . "INNER JOIN $tEst ON $tProduct.activo=$tEst.id  ";
        
        // Ordenar por
	$est = $_POST['estatus'] - 1;
        if($est >= 0) $sqlGetProducts .= " WHERE $tProduct.activo='$est' ";
        
        //Ordenar ASC y DESC
	$vorder = (isset($_POST['orderby'])) ? $_POST['orderby'] : "";
	if($vorder != ''){
            $sqlGetProducts .= " ORDER BY ".$vorder;
	}else{
            $sqlGetProducts .= " ORDER BY categoryId, nombre ";
        }
        
        //Ejecutamos query
        //echo '<br>query: '.$sqlGetProducts.'<br>';
        $resGetProducts = $con->query($sqlGetProducts);
        $datos = '';
        //$datos .= '<tr><td colspan="7">'.$sqlGetCateories.'</td></tr>';
        while ($rowGetProducts = $resGetProducts->fetch_assoc()) {
            $datos .= '<tr>';
            $datos .= '<td>'.$rowGetProducts['id'].'</td>';
            $datos .= '<td><img src="' . $rutaImgProd . $rowGetProducts['img'] . '" class="img-product-list"></td>';
            $datos .= '<td>'.$rowGetProducts['nombre'].'</td>';
            $datos .= '<td>'.$rowGetProducts['categoria'].'</td>';
            $datos .= '<td>'.$rowGetProducts['subcategoria'].'</td>';
            $datos .= '<td>'.$rowGetProducts['precio'].'</td>';
            $datos .= '<td>'.$rowGetProducts['activoN'].'</td>';
            $datos .= '<td><a href="form_update_product.php?id=' . $rowGetProducts['id'] . '" target="_blanck">Modificar</a></td>';
            if($rowGetProducts['activo']==0)
                $datos .= '<td><a class="activate" data-id="' . $rowGetProducts['id'] . '" >Dar de alta</a></td>';
            else
                $datos .= '<td><a class="delete" data-id="' . $rowGetProducts['id'] . '" >Dar de baja</a></td>';
            $datos .= '</tr>';
        }
        echo $datos;
    }
    
?>
