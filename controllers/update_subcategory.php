<?php
    include ('../config/conexion.php');
    include ('../config/variables.php');
    
    $subCategoryId = $_POST['inputSubCategoryId'];
    $userId = $_POST['inputUser'];
    $categoryId = $_POST['inputCategory'];
    $subCategory=$_POST['inputSubCategory'];
    
    $sqlUpdateSubCategory="UPDATE $tSubCategory SET nombre='$subCategory', categoria_id='$categoryId', updated='$dateNow', update_by='$userId' WHERE id='$subCategoryId' ";
            
    if($con->query($sqlUpdateSubCategory) === TRUE ){
        echo 'true';
    }else{
        echo 'Error al modificar subcategoría<br>'.$con->error;
    }
      
?>