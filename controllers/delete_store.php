<?php
    include ('../config/conexion.php');
    include ('../config/variables.php');
    
    $idStore=$_POST['storeDel'];
    
    $sqlDeleteStore="DELETE FROM $tStore WHERE id='$idStore' ";
    if ($con->query($sqlDeleteStore) === TRUE) {
        echo "true";
    } else {
        echo "Error al borrar tienda: " . $con->error;
    }
?>