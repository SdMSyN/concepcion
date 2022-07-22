<?php
    include ('../config/conexion.php');
    include ('../config/variables.php');
    $category = $_POST['inputCategory'];
    $subCategory = $_POST['inputSubCategory'];
    $userId=$_POST['inputUser'];
    
    $ext=explode(".", $_FILES['inputImg']['name']);
    $ban=false;
    $error="";
    $docName=$subCategory.".".$ext[1];
    //echo "--".$docName."--";
    if ($_FILES["inputImg"]["error"] > 0){
        $error.= "Ha ocurrido un error";
    } else {
        $limite_kb = 1000;
        if ($_FILES['inputImg']['size'] <= $limite_kb * 1024){
            //$ruta = "doc_user/" . $_FILES['inputDoc']['name'];
            $ruta = "../".$rutaImgSubCat.$docName;
            $resultado = @move_uploaded_file($_FILES["inputImg"]["tmp_name"], $ruta);
            //echo "--".$ruta."--";
            if ($resultado){
                //echo "el archivo ha sido movido exitosamente";
                $ban=true;
            } else {
                $error .= "ocurrio un error al mover el archivo.";
            }
        } else {
            $error .= "Excede el tamaño de $limite_kb Kilobytes";
        }
    }
    if($ban){
        $sqlCreateSubCategory="INSERT INTO $tSubCategory (nombre, activo, categoria_id, created, create_by, updated, update_by, img) VALUES ('$subCategory', '1', '$category', '$dateNow', '$userId', '$dateNow', '$userId', '$docName') ";
        if($con->query($sqlCreateSubCategory) === TRUE ){
            echo 'true';
        }else{
            if($con->errno == "1062") echo "Error: Ya existe una subcategoría con éste nombre";
            else echo 'Error al crear subcategoría<br>'.$con->error;
        }
    }else{
        echo $error;
    }
      
?>