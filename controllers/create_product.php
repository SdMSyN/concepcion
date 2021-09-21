<?php
    include ('../config/conexion.php');
    include ('../config/variables.php');
    
    $userId = $_POST['userId'];
    $nombre = $_POST['inputNombre'];
    $precio=$_POST['inputPrecio'];
    $codBar=$_POST['inputCB'];
    // $descrip=$_POST['inputDesc'];
    $categoria=$_POST['inputCategoria'];
    $subCategoria=$_POST['inputSubCategoria'];
    (isset($_REQUEST['inputPanFrio'])) ? $panFrio = 1 : $panFrio = 0;
    
   
    // $sqlGetNumProdcuts="SELECT * FROM $tProduct ";
	// $resGetNumProducts=$con->query($sqlGetNumProdcuts);
	// $countNumProducts=$resGetNumProducts->num_rows;
	// $ext=explode(".", $_FILES['inputImg']['name']);
	// $docName=$countNumProducts.".".$ext[1];
	$ban=false;
	$error="";
	// if ($_FILES["inputImg"]["error"] > 0){
	// 	$error.= "Ha ocurrido un error";
	// } else {
	// 	$limite_kb = 1000;
	// 	if ($_FILES['inputImg']['size'] <= $limite_kb * 1024){
	// 		$ruta = "../".$rutaImgProd . $docName;
	// 			$resultado = @move_uploaded_file($_FILES["inputImg"]["tmp_name"], $ruta);
	// 			if ($resultado){
	// 				$ban=true;
	// 			} else {
	// 				$error .= "ocurrio un error al mover el archivo.";
	// 			}
	// 	} else {
	// 		$error .= "Excede el tamaño de $limite_kb Kilobytes";
	// 	}
	// }
	// if($ban){
		$sqlInsertProduct="INSERT INTO productos 
			( nombre, precio, activo, codigo_barras, pan_frio, categoria_id, subcategoria_id, created, updated, created_by_user_id, updated_by_user_id) 
			VALUES ('$nombre', '$precio', 1, '$codBar', '$panFrio', '$categoria', '$subCategoria', '$dateNow', '$dateNow', '$userId', '$userId' ) ";
		if($con->query($sqlInsertProduct) === TRUE){
			$ban = true;
		}else{
			$ban = false;
			if($con->errno == "1062") 
				$error .= "Error: Ya existe un producto con éste nombre";
			else 
				$error .= "Error al crear producto<br>".$con->error;
		}
	// }else{
	// 	$ban = false;
	// }

	if( $ban )
		echo json_encode( array( "error" => 0 ) );
	else
		echo json_encode( array( "error" => 1, "dataRes" => $error ) );
      
?>