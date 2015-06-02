<?php
    include ('../config/conexion.php');
    include ('../config/variables.php');
    
    if($_POST['tarea']=="subProduct") $category_id=$_POST['idSubCategory'];
    else if($_POST['tarea']=="catProduct") $category_id=$_POST['idCategory'];
    else $category_id="";
    
    $sqlGetProducts="SELECT * FROM $tProduct WHERE categoria_id='$category_id' AND activo='1' ";
    $resGetProducts=$con->query($sqlGetProducts);
    $optProducts='';
    if($resGetProducts->num_rows > 0){
        while($rowGetProducts = $resGetProducts->fetch_assoc()){
            $optProducts .= '<div class="col-md-2"><img src="uploads/'.$rowGetProducts['img'].'" class="clickProduct" title="'.$rowGetProducts['id'].'" width="100%">Product.-'.$rowGetProducts['nombre'].'</div>';
        }
    }else{
        $optProducts .= '<h3>No existen productos en ésta categoría.</h3>';
    }
    echo $optProducts;
?>
