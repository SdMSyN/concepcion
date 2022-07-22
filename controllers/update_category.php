<?php
    include ('../config/conexion.php');
    include ('../config/variables.php');
    
    $categoryId = $_POST['inputCategoryId'];
    $category=$_POST['inputCategory'];
    $nameImg=$_FILES['inputImg']['name'];
    $sqlUpdateCategory="";
    //echo $nameImg;
    if($nameImg=="" || $nameImg==NULL){
        $sqlUpdateCategory="UPDATE $tCategory SET nombre='$category' WHERE id='$categoryId' ";
    }else{
        $ext=explode(".", $_FILES['inputImg']['name']);
        $ban=false;
	$error="";
	$docName=$category.".".$ext[1];
	//echo "--".$docName."--";
	if ($_FILES["inputImg"]["error"] > 0){
            $error.= "Ha ocurrido un error";
	} else {
            $limite_kb = 1000;
            if ($_FILES['inputImg']['size'] <= $limite_kb * 1024){
                //$ruta = "doc_user/" . $_FILES['inputDoc']['name'];
                $ruta = "../".$rutaImgCat.$docName;
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
            $sqlUpdateCategory="UPDATE $tCategory SET nombre='$category', img='$docName' WHERE id='$categoryId' ";
        }else{
            echo $error;
	}
    }
       
    if($con->query($sqlUpdateCategory) === TRUE ){
        echo 'true';
    }else{
        echo 'Error al modificar categoría<br>';
    }
      
?>