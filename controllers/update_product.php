<?php
    include ('../config/conexion.php');
    include ('../config/variables.php');
    
    $userId = $_POST['userId'];
    $productId = $_POST['productId'];
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
        if($_FILES['inputImg']['name'] != ""){
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
                $sqlUpdateProduct="UPDATE $tProduct SET nombre='$nombre', precio='$precio', img='$docName', descripcion='$descrip', pan_frio='$panFrio', categoria_id='$categoria', updated='$dateNow', updated_by_user_id='$userId' WHERE id='$productId' ";
                if($con->query($sqlUpdateProduct) === TRUE){
                        echo "true";
                }else{
                    echo "Error al modificar producto<br>".$con->error;
                }
            }else{
                echo $error;
            }
        }
        else{
            $sqlUpdateProduct="UPDATE $tProduct SET nombre='$nombre', precio='$precio', descripcion='$descrip', pan_frio='$panFrio', categoria_id='$categoria', updated='$dateNow', updated_by_user_id='$userId' WHERE id='$productId' ";
            if($con->query($sqlUpdateProduct) === TRUE){
                    echo "true";
            }else{
                echo "Error al modificar producto<br>".$con->error;
            }
        }
      
?>