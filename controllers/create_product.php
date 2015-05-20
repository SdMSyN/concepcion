<?php
    include ('../config/conexion.php');
    include ('../config/variables.php');
    
    $userId = $_POST['userId'];
    $nombre = $_POST['inputNombre'];
    $precio=$_POST['inputPrecio'];
    $descrip=$_POST['inputDesc'];
    $categoria=$_POST['inputCategoria'];
    (isset($_REQUEST['inputPanFrio'])) ? $panFrio = 1 : $panFrio = 0;
    $nameImg=$_FILES['inputImg']['name'];
    
    //echo $nombre.'--'.$precio.'--'.$descrip.'--'.$categoria.'--'.$panFrio.'--'.$nameImg;
    
        $sqlGetNumProdcuts="SELECT * FROM $tProduct ";
	$resGetNumProducts=$con->query($sqlGetNumProdcuts);
	$countNumProducts=$resGetNumProducts->num_rows;
	//echo $cadIdUser;
	$ext=explode(".", $_FILES['inputImg']['name']);
	$ban=false;
	$error="";
	$docName=$countNumProducts.".".$ext[1];
	//echo "--".$docName."--";
	if ($_FILES["inputImg"]["error"] > 0){
		$error.= "Ha ocurrido un error";
	} else {
		$limite_kb = 1000;
		if ($_FILES['inputImg']['size'] <= $limite_kb * 1024){
			//$ruta = "doc_user/" . $_FILES['inputDoc']['name'];
			$ruta = "../".$rutaImgProd . $docName;
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
		$sqlInsertProduct="INSERT INTO $tProduct (nombre, precio, img, descripcion, activo, codigo_barras, pan_frio, categoria_id, created, updated, created_by_user_id, updated_by_user_id) VALUES ('$nombre', '$precio', '$docName', '$descrip', '1', '', '$panFrio', '$categoria', '$dateNow', '$dateNow', '$userId', '$userId' ) ";
		if($con->query($sqlInsertProduct) === TRUE){
			echo "true";
		}else{
                    echo "Error al crear producto<br>".$con->error;
                }
		
	}else{
		echo $error;
	}
      
?>