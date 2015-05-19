<?php
    include ('../config/conexion.php');
    include ('../config/variables.php');
    $category = $_POST['inputCategory'];
    $userId=$_POST['inputUser'];
    
    $sqlCreateCategory="INSERT INTO $tCategory (nombre, created, created_by_user_id) VALUES ('$category', '$dateNow', '$userId') ";
    if($con->query($sqlCreateCategory) === TRUE ){
        echo 'true';
    }else{
        echo 'Error al crear categoría<br>'.$con->error;
    }
      
?>