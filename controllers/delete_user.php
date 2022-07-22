<?php
    include ('../config/conexion.php');
    include ('../config/variables.php');
    
    $idUser=$_POST['userDel'];
    
    //$sqlDeleteUser="DELETE FROM $tUser WHERE id='$idUser' ";
    if($_POST['est']==1)
        $sqlDeleteUser="UPDATE $tUser SET activo='0' WHERE id='$idUser' ";
    else
        $sqlDeleteUser="UPDATE $tUser SET activo='1' WHERE id='$idUser' ";
    if ($con->query($sqlDeleteUser) === TRUE) {
        echo "true";
    } else {
        if($_POST['est']==1)
            echo "Error al borrar usuario: " . $con->error;
        else
            echo "Error al activar usuario: " . $con->error;
    }
?>