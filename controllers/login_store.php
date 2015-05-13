<?php

    include ('config/conexion.php');
    $storeId=$_POST['storeName'];
    $storePass=$_POST['storePass'];
    $storeLal=$_POST['storeLal'];
    $storeLon=$_POST['storeLon'];
    
    $sqlGetStore="SELECT * FROM $tStore ";

?>