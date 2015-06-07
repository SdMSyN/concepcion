<?php
    include ('../config/conexion.php');
    include ('../config/variables.php');
    
    if($_GET['action'] == 'listar'){
        $sqlGetProducts = "SELECT id, nombre, (SELECT nombre FROM $tCategory WHERE id=$tProduct.categoria_id) as categoria, (SELECT nombre FROM $tSubCategory WHERE id=$tProduct.subcategoria_id) as subcategoria, precio, img, (SELECT nombre FROM $tEst WHERE id=$tProduct.activo) as activo  FROM $tProduct  ";
        
        // Ordenar por
	$est = $_POST['estatus'] - 1;
        if($est >= 0) $sqlGetProducts .= " WHERE activo='$est' ";
        
        //Ordenar ASC y DESC
	$vorder = (isset($_POST['orderby'])) ? $_POST['orderby'] : "";
	if($vorder != ''){
		$sqlGetProducts .= " ORDER BY ".$vorder;
	}
        
        //Ejecutamos query
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
            $datos .= '<td>'.$rowGetProducts['activo'].'</td>';
            $datos .= '<td><a href="form_update_product.php?id=' . $rowGetProducts['id'] . '" >Modificar</a></td>';
            $datos .= '<td><a class="delete" data-id="' . $rowGetProducts['id'] . '" >Dar de baja</a></td>';
            $datos .= '</tr>';
        }
        echo $datos;
    }
    
?>
