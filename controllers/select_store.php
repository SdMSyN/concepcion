<?php
    include ('../config/conexion.php');
    include ('../config/variables.php');
    
    if($_GET['action'] == 'listar'){
        $sqlGetStore = "SELECT *, (SELECT nombre FROM $tEst WHERE id=$tStore.activo) as activoN, activo FROM $tStore ";
        
        // Ordenar por
	$est = $_POST['estatus'] - 1;
        if($est >= 0) $sqlGetStore .= " WHERE activo='$est' ";
        
        //Ordenar ASC y DESC
	$vorder = (isset($_POST['orderby'])) ? $_POST['orderby'] : "";
	if($vorder != ''){
		$sqlGetStore .= " ORDER BY ".$vorder;
	}
        
        //Ejecutamos query
        $resGetStore = $con->query($sqlGetStore);
        $datos = '';
        //$datos .= '<tr><td colspan="7">'.$sqlGetCateories.'</td></tr>';
        while ($rowGetStore = $resGetStore->fetch_assoc()) {
            $datos .= '<tr>';
            //$datos .= '<td>'.$rowGetStore['id'].'</td>';
            $datos .= '<td>'.$rowGetStore['nombre'].'</td>';
            $datos .= '<td>'.$rowGetStore['direccion'].'</td>';
            $datos .= '<td>'.$rowGetStore['created'].'</td>';
            $datos .= '<td>'.$rowGetStore['activoN'].'</td>';
            $datos .= '<td><a href="https://www.google.com.mx/maps/@' . $rowGetStore['latitud'] . ',' . $rowGetStore['longitud'] . ',16z" target="_about">Ver</a></td>';
            $datos .= '<td><a href="form_update_store.php?id=' . $rowGetStore['id'] . '" >Modificar</a></td>';
            if($rowGetStore['activo']==0)
                $datos .= '<td><a class="activate" data-id="' . $rowGetStore['id'] . '" >Dar de alta</a></td>';
            else
                $datos .= '<td><a class="delete" data-id="' . $rowGetStore['id'] . '" >Dar de baja</a></td>';
            $datos .= '</tr>';
        }
        echo $datos;
    }
    
?>
