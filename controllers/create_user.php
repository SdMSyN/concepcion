<?php
    include ('../config/conexion.php');
    include ('../config/variables.php');
    
    $nombre=$_POST['inputNombre'];
    $ap=$_POST['inputAP'];
    $am=$_POST['inputAM'];
    (isset($_POST['inputUser'])) ? $user=$_POST['inputUser'] : $user="";
    $pass=$_POST['inputPass'];
    $perfil=$_POST['inputPerfil'];
    (isset($_POST['inputDir'])) ? $dir=$_POST['inputDir'] : $dir="";
    (isset($_POST['inputNumInt'])) ? $numInt=$_POST['inputNumInt'] : $numInt="";
    (isset($_POST['inputNumExt'])) ? $numExt=$_POST['inputNumExt'] : $numExt="";
    (isset($_POST['inputCol'])) ? $col=$_POST['inputCol'] : $col="";
    (isset($_POST['inputMun'])) ? $mun=$_POST['inputMun'] : $mun="";
    (isset($_POST['inputTel'])) ? $tel=$_POST['inputTel'] : $tel="";
    (isset($_POST['inputCel'])) ? $cel=$_POST['inputCel'] : $cel="";
    (isset($_POST['inputNacimiento'])) ? $nac=$_POST['inputNacimiento'] : $nac="";
    
    
    $sqlCreateUser="INSERT INTO $tUser (nombre, ap, am, user, password, perfil_id, direccion, num_int, num_ext, colonia, municipio, telefono, celular, created, updated, fec_nac, activo) VALUES ('$nombre', '$ap', '$am', '$user', '$pass', '$perfil', '$dir', '$numInt', '$numExt', '$col', '$mun', '$tel', '$cel', '$dateNow', '$dateNow', '$nac', '1') ";
    if($con->query($sqlCreateUser) === TRUE ){
        echo 'true';
    }else{
        echo 'Error al crear usuario<br>'.$con->error;
    }
      
?>