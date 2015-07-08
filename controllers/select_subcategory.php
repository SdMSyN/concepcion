<?php
    include ('../config/conexion.php');
    include ('../config/variables.php');
    
    if($_GET['action'] == 'listar'){
        $sqlGetCateories = "SELECT id, nombre, created, activo, (SELECT CONCAT(nombre,' ',ap,' ',am) FROM $tUser WHERE id=$tSubCategory.create_by) as created_by, (SELECT nombre FROM $tEst WHERE id=$tSubCategory.activo ) as activoN, (SELECT nombre FROM $tCategory WHERE id=$tSubCategory.categoria_id) as category, img FROM $tSubCategory ";
        //$datos=array();
        //
        // Ordenar por
	$est = $_POST['estatus'] - 1;
        if($est >= 0) $sqlGetCateories .= " WHERE activo='$est' ";
        
        //Ordenar ASC y DESC
	$vorder = (isset($_POST['orderby'])) ? $_POST['orderby'] : "";
	if($vorder != ''){
		$sqlGetCateories .= " ORDER BY ".$vorder;
	}
        
        //Ejecutamos query
        $resGetCategories = $con->query($sqlGetCateories);
        $datos = '';
        //$datos .= '<tr><td colspan="7">'.$sqlGetCateories.'</td></tr>';
        while($rowGetCategories = $resGetCategories->fetch_assoc()){
            $datos .= '<tr>';
            //$datos .= '<td>'.$rowGetCategories['id'].'</td>';
            $datos .= '<td>'.$rowGetCategories['nombre'].'</td>';
            $datos .= '<td><img src="'.$rutaImgSubCat.$rowGetCategories['img'].'" class="img-product-list"></td>';
            $datos .= '<td>'.$rowGetCategories['category'].'</td>';
            $datos .= '<td>'.$rowGetCategories['created'].'</td>';
            $datos .= '<td>'.$rowGetCategories['created_by'].'</td>';
            $datos .= '<td>'.$rowGetCategories['activoN'].'</td>';
            $datos .= '<td><a href="form_update_subcategory.php?id='.$rowGetCategories['id'].'" >Modificar</a></td>';
            if($rowGetCategories['activo']==0)
                $datos .= '<td><a class="activate" data-id="'.$rowGetCategories['id'].'" >Dar de alta</a></td>';
            else
                $datos .= '<td><a class="delete" data-id="'.$rowGetCategories['id'].'" >Dar de baja</a></td>';
            $datos .= '</tr>';

        }
        echo $datos;
    }
    
?>
