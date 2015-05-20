<?php
    include ('../config/conexion.php');
    include ('../config/variables.php');
    
    $idUser=$_POST['idUser'];
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
    
    
    $sqlUpdateUser="UPDATE $tUser SET nombre='$nombre', ap='$ap', am='$am', user='$user', password='$pass', perfil_id='$perfil', direccion='$dir', num_int='$numInt', num_ext='$numExt', colonia='$col', municipio='$mun', telefono='$tel', celular='$cel', updated='$dateNow', fec_nac='$nac' WHERE id='$idUser' ";
            
    if($con->query($sqlUpdateUser) === TRUE ){
        echo 'true';
    }else{
        echo 'Error al modificar usuario<br>'.$con->error;
    }
      
?>