<?php
    include ('../config/conexion.php');
    include ('../config/variables.php');
    $category = $_POST['inputCategory'];
    $subCategory = $_POST['inputSubCategory'];
    $userId=$_POST['inputUser'];
    
    $sqlCreateSubCategory="INSERT INTO $tSubCategory (nombre, activo, categoria_id, created, create_by, updated, update_by, img) VALUES ('$subCategory', '1', '$category', '$dateNow', '$userId', '$dateNow', '$userId', '') ";
    if($con->query($sqlCreateSubCategory) === TRUE ){
        echo 'true';
    }else{
        if($con->errno == "1062") echo "Error: Ya existe una categoría con éste nombre";
        else echo 'Error al crear subcategoría<br>'.$con->error;
    }
      
?>