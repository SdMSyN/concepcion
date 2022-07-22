<?php
    include ('../config/conexion.php');
    include ('../config/variables.php');
    
    $idSubCategory=$_POST['categoryDel'];
    
    //$sqlDeleteStore="DELETE FROM $tStore WHERE id='$idStore' ";
    if($_POST['est']==1)
        $sqlDeleteSCategory="UPDATE $tSubCategory SET activo='0' WHERE id='$idSubCategory' ";
    else
        $sqlDeleteSCategory="UPDATE $tSubCategory SET activo='1' WHERE id='$idSubCategory' ";
    if ($con->query($sqlDeleteSCategory) === TRUE) {
        echo "true";
    } else {
        if($_POST['est']==1)
            echo "Error al borrar subcategoría: " . $con->error;
        else
            echo "Error al activar subcategoría: " . $con->error;
    }
?>
