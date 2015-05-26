<?php
    include ('../config/conexion.php');
    include ('../config/variables.php');
    
    $categoryId = $_POST['inputCategoryId'];
    $category=$_POST['inputCategory'];
    
    $sqlUpdateCategory="UPDATE $tCategory SET nombre='$category' WHERE id='$categoryId' ";
            
    if($con->query($sqlUpdateCategory) === TRUE ){
        echo 'true';
    }else{
        echo 'Error al modificar categoría<br>'.$con->error;
    }
      
?>