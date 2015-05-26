<?php
    include ('../config/conexion.php');
    include ('../config/variables.php');
    
    $idCategory=$_POST['categoryDel'];
    
    //$sqlDeleteStore="DELETE FROM $tStore WHERE id='$idStore' ";
    $sqlDeleteSCategory="UPDATE $tCategory SET activo='0' WHERE id='$idCategory' ";
    if ($con->query($sqlDeleteSCategory) === TRUE) {
        echo "true";
    } else {
        echo "Error al borrar categoría: " . $con->error;
    }
?>