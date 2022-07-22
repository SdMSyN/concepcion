<?php
    session_start();
    include ('../config/conexion.php');
    $user = $_POST['inputAdmin'];
    $passAdmin = $_POST['inputPassAdmin'];
    
    $sqlGetAdmin="SELECT * FROM $tUser WHERE BINARY user='$user' AND BINARY password='$passAdmin' ";
    $resGetAdmin=$con->query($sqlGetAdmin);
    if($resGetAdmin->num_rows > 0){
        $rowGetAdmin=$resGetAdmin->fetch_assoc();
       
        $_SESSION['sessA'] = true;
	$_SESSION['userId'] = $rowGetAdmin['id'];
	$_SESSION['userName'] = $rowGetAdmin['ap']." ".$rowGetAdmin['am']." ".$rowGetAdmin['nombre'];
        $_SESSION['perfil'] = $rowGetAdmin['perfil_id'];
        
        echo "true";
        
    }
    else{
        $_SESSION['sessA']=false;
        echo "Datos de acceso incorrectos<br>".$con->error;
    }
      
?>