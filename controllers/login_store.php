<?php
    session_start();
    include ('../config/conexion.php');
    $storeId = $_POST['inputStoreName'];
    $storePass = $_POST['inputStorePass'];
    $storeLat = $_POST['inputLat'];
    $storeLon = $_POST['inputLon'];
    
    $tmpLat = explode(".", $storeLat);
    $tmpLon = explode(".", $storeLon);
    //$lat=$tmpLat[0].".".substr($tmpLat[1], 0, 3);
    //$lon=$tmpLon[0].".".substr($tmpLon[1], 0, 3);
    $lat = $tmpLat[0];
	$lon = $tmpLon[0];
	
    //$sqlGetStore="SELECT * FROM $tStore WHERE id='$storeId' AND password='$storePass' AND latitud LIKE '$lat%' AND longitud LIKE '$lon%' ";
    $sqlGetStore="SELECT * FROM $tStore WHERE id='$storeId' AND password='$storePass' ";
//    $sqlGetStore="SELECT * FROM $tStore WHERE id='$storeId' AND password='$storePass' ";
    $resGetStore=$con->query($sqlGetStore);
    if($resGetStore->num_rows > 0){
        $rowGetStore=$resGetStore->fetch_assoc();
       
        $_SESSION['sess'] = true;
	$_SESSION['storeId'] = $rowGetStore['id'];
	$_SESSION['storeName'] = $rowGetStore['nombre'];
	$_SESSION['storeDir'] = $rowGetStore['direccion'];
	$_SESSION['storeRfc'] = $rowGetStore['rfc'];
	$_SESSION['storeCp'] = $rowGetStore['cp'];
	$_SESSION['storeTel'] = $rowGetStore['tel'];
        $_SESSION['numSess'] = $rowGetStore['num_sess'];
        
        echo "true";
    }
    else{
        $_SESSION['sess']=false;
        //echo "Error en la consulta<br>".$sqlGetStore."<br>";
        echo "Error en la consulta<br>";
        //echo "Acceso denegado";
    }
      
?>