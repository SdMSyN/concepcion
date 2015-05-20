<?php
    include ('../config/conexion.php');
    include ('../config/variables.php');
    
    $nombre = $_POST['inputNombre'];
    $precio=$_POST['inputPrecio'];
    $descrip=$_POST['inputDesc'];
    $categoria=$_POST['inputCategoria'];
    (isset($_POST['inputPanFrio'])) ? $panFrio = 1 : $panFrio = 0;
    $nameImg=$_FILES['inputImg']['name'];
    
    echo $nombre.'--'.$precio.'--'.$descrip.'--'.$categoria.'--'.$panFrio.'--'.$nameImg;
    
    /*
    $sqlCreateCategory="INSERT INTO $tCategory (nombre, created, created_by_user_id) VALUES ('$category', '$dateNow', '$userId') ";
    if($con->query($sqlCreateCategory) === TRUE ){
        echo 'true';
    }else{
        echo 'Error al crear categoría<br>'.$con->error;
    }*/
      
?>