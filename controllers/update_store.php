<?php
    include ('../config/conexion.php');
    include ('../config/variables.php');
    
    $idStore=$_POST['idStore'];
    $nombre=$_POST['inputNombre'];
    $dir=$_POST['inputDir'];
    $rfc=$_POST['inputRfc'];
    $cp=$_POST['inputCp'];
    $tel=$_POST['inputTel'];
    $pass=$_POST['inputPass'];
    
    $sqlUpdateStore="UPDATE $tStore SET nombre='$nombre', direccion='$dir', rfc='$rfc', cp='$cp', tel='$tel', password='$pass', updated='$dateNow' WHERE id='$idStore' ";
            
    if($con->query($sqlUpdateStore) === TRUE ){
        echo 'true';
    }else{
        echo 'Error al modificar tienda<br>'.$con->error;
    }
      
?>