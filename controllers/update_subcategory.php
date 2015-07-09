<?php
    include ('../config/conexion.php');
    include ('../config/variables.php');
    
    $subCategoryId = $_POST['inputSubCategoryId'];
    $userId = $_POST['inputUser'];
    $categoryId = $_POST['inputCategory'];
    $subCategory=$_POST['inputSubCategory'];
    $nameImg=$_FILES['inputImg']['name'];
    $sqlUpdateSubCategory="";
    
    if($nameImg=="" || $nameImg==NULL){
        $sqlUpdateSubCategory="UPDATE $tSubCategory SET nombre='$subCategory', categoria_id='$categoryId', updated='$dateNow', update_by='$userId' WHERE id='$subCategoryId' ";
    }else{
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
            $sqlUpdateSubCategory="UPDATE $tSubCategory SET nombre='$subCategory', categoria_id='$categoryId', updated='$dateNow', update_by='$userId', img='$docName' WHERE id='$subCategoryId' ";
        }else{
            echo $error;
	}
    }
       
    if($con->query($sqlUpdateSubCategory) === TRUE ){
        echo 'true';
    }else{
        //echo 'Error al modificar subcategoría<br>'.$con->error;
        echo 'Error al modificar subcategoría, verifica los datos.<br>';
    }
      
?>