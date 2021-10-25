<?php
    include ('../config/conexion.php');
    include ('../config/variables.php');
    
    $user = $_POST['inputUser'];
    $alm = $_POST['inputAlm'];
    $i = 0;
    $ban = false;
    $error = '';
    foreach($_POST['stockId'] as $id){
        //echo $id.'--'.$alm[$i].'--';
        $sqlGetCantProductStock="SELECT cantidad FROM almacenes WHERE id='$id' ";
        $resGetCantProductStock=$con->query($sqlGetCantProductStock);
        $rowGetCantProductStock=$resGetCantProductStock->fetch_assoc();
        $cant=$rowGetCantProductStock['cantidad'] + $alm[$i];
        
        $sqlUpdStock="UPDATE almacenes SET cantidad='$cant', updated='$dateNow', user_update='$user' WHERE id='$id' ";
        if($con->query($sqlUpdStock) === TRUE) $ban=true;
        else{
            $ban = false;
            $error = "Error al insertar nuevas cantidades";
            break;
        }
        
        $i++;
    }

    if( $ban )
		echo json_encode( array( "error" => 0 ) );
	else
		echo json_encode( array( "error" => 1, "dataRes" => $error ) );
      
?>