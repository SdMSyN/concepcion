<?php
    include ('../config/conexion.php');
    include ('../config/variables.php');
    
    $idSubCategory=$_POST['categoryDel'];
    
    //$sqlDeleteStore="DELETE FROM $tStore WHERE id='$idStore' ";
    $sqlDeleteSCategory="UPDATE $tSubCategory SET activo='0' WHERE id='$idSubCategory' ";
    if ($con->query($sqlDeleteSCategory) === TRUE) {
        echo "true";
    } else {
        echo "Error al borrar subcategoría: " . $con->error;
    }
?>
