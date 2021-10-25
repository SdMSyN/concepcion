<?php
    include ('../config/conexion.php');
    include ('../config/variables.php');
    
    $product = $_POST['inputProduct'];
    $store = $_POST['inputCampo'];
    $user = $_POST['inputUser'];
    $ban = false;
    $error = "";
    
    $sqlGetProduc="SELECT id FROM almacenes WHERE producto_id = '$product' AND tienda_id = '$store' ";
    $resGetProduct=$con->query($sqlGetProduc);
    if($resGetProduct->num_rows > 0){
        $error = "Error, el producto ya se encuentra en éste almacén";
    }else{
        //echo '<br>'.$product.'--'.$cant.'--'.$store.'--';
        $sqlCreateStock = "INSERT INTO almacenes (created, user_create, updated, user_update, producto_id, cantidad, tienda_id) 
                            VALUES ( '$dateNow', '$user', '$dateNow', '$user', '$product', '0', '$store' ) ";
        if($con->query($sqlCreateStock) === TRUE ){
            $ban = true;
        }else{
            $error = 'Error al crear producto en almacén<br>'.$con->error;
        }
    }

    if( $ban )
		echo json_encode( array( "error" => 0 ) );
	else
		echo json_encode( array( "error" => 1, "dataRes" => $error ) );
  
?>