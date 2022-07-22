<?php
    include ('../config/conexion.php');
    include ('../config/variables.php');
    
    $idCategory=$_POST['categoryDel'];
    
    //$sqlDeleteStore="DELETE FROM $tStore WHERE id='$idStore' ";
    if($_POST['est']==1)
        $sqlDeleteSCategory="UPDATE $tCategory SET activo='0' WHERE id='$idCategory' ";
    else
        $sqlDeleteSCategory="UPDATE $tCategory SET activo='1' WHERE id='$idCategory' ";
    if ($con->query($sqlDeleteSCategory) === TRUE) {
        echo "true";
    } else {
        if($_POST['est']==1)
            echo "Error al borrar categoría: " . $con->error;
        else
            echo "Error al activar categoría: " . $con->error;
    }
?>