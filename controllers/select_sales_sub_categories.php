<?php
    include ('../config/conexion.php');
    include ('../config/variables.php');
    
    $category_id=$_POST['idCategory'];
    
    $sqlGetSubCategories="SELECT * FROM $tSubCategory WHERE categoria_id='$category_id' AND activo='1'  ";
    $resGetSubCategories=$con->query($sqlGetSubCategories);
    $optSubCategories='';
    if($resGetSubCategories->num_rows > 0){
        while($rowGetSubCategories = $resGetSubCategories->fetch_assoc()){
            $optSubCategories .= '<div class="col-md-2 div-img-sales"><img src="uploads/'.$rowGetSubCategories['img'].'" class="clickSubCategory img-sales" title="'.$rowGetSubCategories['id'].'">'.$rowGetSubCategories['nombre'].'</div>';
        }
    }else{
        $optSubCategories = "false";
    }
    
    echo $optSubCategories; 
    
?>
