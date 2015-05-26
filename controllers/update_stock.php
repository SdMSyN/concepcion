<?php
    include ('../config/conexion.php');
    include ('../config/variables.php');
    
    $user=$_POST['inputUser'];
    $alm=$_POST['inputAlm'];
    $i=0;
    $ban=false;
    foreach($_POST['stockId'] as $id){
        //echo $id.'--'.$alm[$i].'--';
        $sqlGetCantProductStock="SELECT cantidad FROM $tStock WHERE id='$id' ";
        $resGetCantProductStock=$con->query($sqlGetCantProductStock);
        $rowGetCantProductStock=$resGetCantProductStock->fetch_assoc();
        $cant=$rowGetCantProductStock['cantidad'] + $alm[$i];
        
        $sqlUpdStock="UPDATE $tStock SET cantidad='$cant', updated='$dateNow', user_update='$user' WHERE id='$id' ";
        if($con->query($sqlUpdStock) === TRUE) $ban=true;
        else{
            $ban=false;
            break;
        }
        
        $i++;
    }
    if($ban)
        echo "true";
    else
        echo "Error al insertar nuevas cantidades";
      
?>