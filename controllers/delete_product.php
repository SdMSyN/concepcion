<?php
    include ('../config/conexion.php');
    include ('../config/variables.php');
    
    $idProduct=$_POST['productDel'];
    
    //$sqlDeleteUser="DELETE FROM $tUser WHERE id='$idUser' ";
    if($_POST['est']==1)
        $sqlDeleteProduct="UPDATE $tProduct SET activo='0' WHERE id='$idProduct' ";
    else
        $sqlDeleteProduct="UPDATE $tProduct SET activo='1' WHERE id='$idProduct' ";
    if ($con->query($sqlDeleteProduct) === TRUE) {
        echo "true";
    } else {
        if($_POST['est']==1)
            echo "Error al borrar producto: " . $con->error;
        else
            echo "Error al activar producto: " . $con->error;
    }
?>