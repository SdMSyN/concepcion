<?php
    include ('../config/conexion.php');
    include ('../config/variables.php');
  
    $i=0; $cad ='';
    for($i=0; $i<count($_POST['id']); $i++){
        $cad.=$_POST['id'][$i].'--';
        $cad.=$_POST['inputPrecioU'][$i].'--';
        $cad.=$_POST['inputCant'][$i].'--';
        $cad.=$_POST['inputPrecioF'][$i].'--';
        $cad.=$_POST['inputTotal'][$i].'--';
        $cad.='<br>';
    }
    echo $cad.'=='.$_POST['inputTotal'];
    /*var_dump($_POST['id']).'<br>';
    var_dump($_POST['inputPrecioU']).'<br>';
    var_dump($_POST['inputCant']).'<br>';
    var_dump($_POST['inputPrecioF']).'<br>';
    echo $_POST['inputTotal'].'<br>';*/
    
?>