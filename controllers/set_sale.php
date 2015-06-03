<?php
    include ('../config/conexion.php');
    include ('../config/variables.php');
  
    $i=0; $cad ='<table border="2"><tr><td>Id</td><td>Precio U.</td><td>Cantidad</td><td>Precio F.</td></tr>';
    for($i=0; $i<count($_POST['id']); $i++){
        $cad.='<td>'.$_POST['id'][$i].'</td>';
        $cad.='<td>'.$_POST['inputPrecioU'][$i].'</td>';
        $cad.='<td>'.$_POST['inputCant'][$i].'</td>';
        $cad.='<td>'.$_POST['inputPrecioF'][$i].'</td></tr>';
    }
    echo $cad.'<tr><td colspan="3">Total</td><td>'.$_POST['inputTotal'].'</td></tr></table>';
    /*var_dump($_POST['id']).'<br>';
    var_dump($_POST['inputPrecioU']).'<br>';
    var_dump($_POST['inputCant']).'<br>';
    var_dump($_POST['inputPrecioF']).'<br>';
    echo $_POST['inputTotal'].'<br>';*/
    
?>