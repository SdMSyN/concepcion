<?php
    include ('../config/conexion.php');
    include ('../config/variables.php');
    
    $idStore=$_POST['storeDel'];
    
    //$sqlDeleteStore="DELETE FROM $tStore WHERE id='$idStore' ";
    if($_POST['est']==1)
        $sqlDeleteStore="UPDATE $tStore SET activo='0' WHERE id='$idStore' ";
    else
        $sqlDeleteStore="UPDATE $tStore SET activo='1' WHERE id='$idStore' ";
    if ($con->query($sqlDeleteStore) === TRUE) {
        echo "true";
    } else {
        if($_POST['est']==1)
            echo "Error al borrar tienda: " . $con->error;
        else
            echo "Error al activar tienda: " . $con->error;
    }
?>