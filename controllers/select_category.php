<?php
    include ('../config/conexion.php');
    include ('../config/variables.php');
    
    if($_GET['action'] == 'listar'){
        $sqlGetCateories = "SELECT id, nombre, created, (SELECT CONCAT(nombre,' ',ap,' ',am) FROM $tUser WHERE id=$tCategory.created_by_user_id ) as created_by, (SELECT nombre FROM $tEst WHERE id=$tCategory.activo ) activoN, activo, img FROM $tCategory ";
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
            $datos .= '<td><img src="./'.$rutaImgCat.$rowGetCategories['img'].'" width="20%"></td>';
            $datos .= '<td>'.$rowGetCategories['created'].'</td>';
            $datos .= '<td>'.$rowGetCategories['created_by'].'</td>';
            $datos .= '<td>'.$rowGetCategories['activoN'].'</td>';
            $datos .= '<td><a href="form_update_category.php?id='.$rowGetCategories['id'].'" >Modificar</a></td>';
            if($rowGetCategories['activo']==0)
                $datos .= '<td><a class="activate" data-id="'.$rowGetCategories['id'].'" >Dar de alta</a></td>';
            else
                $datos .= '<td><a class="delete" data-id="'.$rowGetCategories['id'].'" >Dar de baja</a></td>';
            //$datos .= '<td style="cursor: pointer"><elim><h2><button type="button" class="elim">Dar de baja</button></h2></elim></td>';
            $datos .= '</tr>';
            /*$datos[] = array(
                'id' => $rowGetCategories['id'],
                'name' => $rowGetCategories['nombre'],
                'created' => $rowGetCategories['created'],
                'created_by' => $rowGetCategories['created_by_user_id'],
                'status' => $rowGetCategories['activo'],
                'mod' => '<a href="form_update_category.php?id='.$rowGetCategories['id'].'" >Modificar</a>'
            );*/
        }
        echo $datos;
    }
    
?>
