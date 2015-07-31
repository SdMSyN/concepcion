<?php
    include ('../config/conexion.php');
    include ('../config/variables.php');
    
    if($_POST['tarea']=="subProduct") $category_id=$_POST['idSubCategory'];
    else if($_POST['tarea']=="catProduct") $category_id=$_POST['idCategory'];
    else $category_id="";
    
    $idStore=$_POST['idStore'];
    
    if($_POST['tarea']=="catProduct") 
        //$sqlGetProducts="SELECT * FROM $tProduct WHERE categoria_id='$category_id' AND activo='1' ";
        $sqlGetProducts="SELECT $tProduct.img, $tProduct.id, $tProduct.nombre FROM $tProduct WHERE $tProduct.categoria_id='$category_id' ORDER BY $tProduct.nombre ";
    else 
        //$sqlGetProducts="SELECT * FROM $tProduct WHERE subcategoria_id='$category_id' AND activo='1' ";
        $sqlGetProducts="SELECT $tProduct.img, $tProduct.id, $tProduct.nombre FROM $tProduct WHERE $tProduct.subcategoria_id='$category_id' ORDER BY $tProduct.nombre ";
    
    $resGetProducts=$con->query($sqlGetProducts);
    $optProducts='';
    if($resGetProducts->num_rows > 0){
        while($rowGetProducts = $resGetProducts->fetch_assoc()){
            $optProducts .= '<div class="col-md-2 div-img-sales"><img src="./uploads/'.$rowGetProducts['img'].'" class="clickProduct img-sales" title="'.$rowGetProducts['id'].'" width="100%">'.$rowGetProducts['nombre'].'</div>';
        }
    }else{
        $optProducts .= '<h3>No existe producto en ésta categoría.</h3>';
    }
    echo $optProducts;
?>
