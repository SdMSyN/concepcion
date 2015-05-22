<?php
    include ('../config/conexion.php');
    include ('../config/variables.php');
    
    $idProduct=$_POST['productDel'];
    
    //$sqlDeleteUser="DELETE FROM $tUser WHERE id='$idUser' ";
    $sqlDeleteProduct="UPDATE $tProduct SET activo='0' WHERE id='$idProduct' ";
    if ($con->query($sqlDeleteProduct) === TRUE) {
        echo "true";
    } else {
        echo "Error al borrar usuario: " . $con->error;
    }
?>