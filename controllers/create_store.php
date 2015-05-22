<?php
    include ('../config/conexion.php');
    include ('../config/variables.php');
    
    $nombre=$_POST['inputNombre'];
    $dir=$_POST['inputDir'];
    $rfc=$_POST['inputRfc'];
    $cp=$_POST['inputCp'];
    $tel=$_POST['inputTel'];
    $pass=$_POST['inputPass'];
    $lat=$_POST['inputLat'];
    $lon=$_POST['inputLon'];
          
    
    $sqlCreateStore="INSERT INTO $tStore (nombre, direccion, rfc, cp, tel, num_sess, latitud, longitud, password, created, updated, activa) VALUES ('$nombre', '$dir', '$rfc', '$cp', '$tel', '2', '$lat', '$lon', '$pass', '$dateNow', '$dateNow', '1') ";
    if($con->query($sqlCreateStore) === TRUE ){
        echo 'true';
    }else{
        echo 'Error al crear Tienda<br>'.$con->error;
    }
      
?>