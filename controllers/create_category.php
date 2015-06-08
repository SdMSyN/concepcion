<?php
    include ('../config/conexion.php');
    include ('../config/variables.php');
    $category = $_POST['inputCategory'];
    $userId=$_POST['inputUser'];
    $img=$_FILES['inputImg']['name'];
    
    echo $category.'--'.$userId.'--'.$img;
    
    /*
    $sqlCreateCategory="INSERT INTO $tCategory (nombre, created, created_by_user_id, activo) VALUES ('$category', '$dateNow', '$userId', '1') ";
    if($con->query($sqlCreateCategory) === TRUE ){
        echo 'true';
    }else{
        //echo 'Error al crear categoría<br>'.$con->errno;
        if($con->errno == "1062") echo "Error: Ya existe una categoría con éste nombre";
        else echo 'Error al crear categoría<br>'.$con->error;
    }*/
      
?>