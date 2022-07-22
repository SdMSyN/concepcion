<?php
    include ('../config/conexion.php');
    include ('../config/variables.php');
    $category = $_POST['inputCategory'];
    $userId=$_POST['inputUser'];
    $img=$_FILES['inputImg']['name'];
    
    //echo $category.'--'.$userId.'--'.$img;
    
    /*
    $sqlCreateCategory="INSERT INTO $tCategory (nombre, created, created_by_user_id, activo) VALUES ('$category', '$dateNow', '$userId', '1') ";
    if($con->query($sqlCreateCategory) === TRUE ){
        echo 'true';
    }else{
        //echo 'Error al crear categoría<br>'.$con->errno;
        if($con->errno == "1062") echo "Error: Ya existe una categoría con éste nombre";
        else echo 'Error al crear categoría<br>'.$con->error;
    }*/
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
            $sqlCreateCategory="INSERT INTO $tCategory (nombre, created, created_by_user_id, activo, img) VALUES ('$category', '$dateNow', '$userId', '1', '$docName') ";
            if($con->query($sqlCreateCategory) === TRUE ){
                echo 'true';
            }else{
                //echo 'Error al crear categoría<br>'.$con->errno;
                if($con->errno == "1062") echo "Error: Ya existe una categoría con éste nombre";
                else echo 'Error al crear categoría<br>'.$con->error;
            }
	}else{
		echo $error;
	}
      
?>