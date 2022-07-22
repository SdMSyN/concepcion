<?php
    include ('../config/conexion.php');
    include ('../config/variables.php');
    
    $idStock=$_POST['stockDel'];
    
    //$sqlDeleteUser="DELETE FROM $tUser WHERE id='$idUser' ";
    $sqlDeleteStock="UPDATE $tStock SET cantidad='0' WHERE id='$idStock' ";
    if ($con->query($sqlDeleteStock) === TRUE) {
        echo "true";
    } else {
        echo "Error al vaciar producto de almacén: " . $con->error;
    }
?>