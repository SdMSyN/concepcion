<?php
    include ('../config/conexion.php');
    include ('../config/variables.php');
    
    if($_GET['action'] == 'listar'){
        $sqlGetUsers = "SELECT id, CONCAT(nombre,' ',ap,' ',am) as nombre, (SELECT perfil FROM $tPerfil WHERE id=$tUser.perfil_id) as perfil, created, (SELECT nombre FROM $tEst WHERE id=$tUser.activo) as activoN, activo FROM $tUser ";
        
        // Ordenar por
	$est = $_POST['estatus'] - 1;
        if($est >= 0) $sqlGetUsers .= " WHERE activo='$est' ";
        
        //Ordenar ASC y DESC
	$vorder = (isset($_POST['orderby'])) ? $_POST['orderby'] : "";
	if($vorder != ''){
		$sqlGetUsers .= " ORDER BY ".$vorder;
	}
        
        //Ejecutamos query
        $resGetUsers = $con->query($sqlGetUsers);
        $datos = '';
        //$datos .= '<tr><td colspan="7">'.$sqlGetCateories.'</td></tr>';
        while ($rowGetUsers = $resGetUsers->fetch_assoc()) {
            $datos .= '<tr>';
            //$datos .= '<td>'.$rowGetUsers['id'].'</td>';
            $datos .= '<td>'.$rowGetUsers['nombre'].'</td>';
            $datos .= '<td>'.$rowGetUsers['created'].'</td>';
            $datos .= '<td>'.$rowGetUsers['perfil'].'</td>';
            $datos .= '<td>'.$rowGetUsers['activoN'].'</td>';
            $datos .= '<td><a href="form_update_user.php?id=' . $rowGetUsers['id'] . '" >Modificar</a></td>';
            if($rowGetUsers['activo']==0)
                $datos .= '<td><a class="activate" data-id="' . $rowGetUsers['id'] . '" >Dar de alta</a></td>';
            else
                $datos .= '<td><a class="delete" data-id="' . $rowGetUsers['id'] . '" >Dar de baja</a></td>';
            $datos .= '</tr>';
        }
        echo $datos;
    }
    
?>
