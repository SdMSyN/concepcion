<?php
    include ('../config/conexion.php');
    include ('../config/variables.php');
    
    $idUser=$_POST['userDel'];
    
    //$sqlDeleteUser="DELETE FROM $tUser WHERE id='$idUser' ";
    $sqlDeleteUser="UPDATE $tUser SET activo='0' WHERE id='$idUser' ";
    if ($con->query($sqlDeleteUser) === TRUE) {
        echo "true";
    } else {
        echo "Error al borrar usuario: " . $con->error;
    }
?>