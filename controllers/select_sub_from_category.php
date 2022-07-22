<?php
    include ('../config/conexion.php');
    include ('../config/variables.php');

    $idCategory=$_POST['categoryId'];
    $sqlGetSubCategory = "SELECT id, nombre FROM $tSubCategory WHERE categoria_id='$idCategory' ";

    //Ejecutamos query
    $resGetSubCategory = $con->query($sqlGetSubCategory);
    $datos = '';
    //$datos .= '<tr><td colspan="7">'.$sqlGetCateories.'</td></tr>';
    while ($rowGetSubCategory = $resGetSubCategory->fetch_assoc()) {
        $datos .= '<option value="'.$rowGetSubCategory['id'].'">'.$rowGetSubCategory['nombre'].'</option>';
    }
    echo $datos;
    
?>
