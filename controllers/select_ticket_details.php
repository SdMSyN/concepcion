<?php

include('../config/conexion.php');
include('../config/variables.php');
$prods = array();
$msgErr = '';
$ban = false;

$idTicket = $_POST['idTicket'];

$sqlGetProdTicket = "SELECT $tSaleProd.cantidad as cant, $tSaleProd.costo_unitario as cu, "
        . "$tSaleProd.costo_total as ct, $tProduct.nombre as name "
        . " FROM $tSaleProd "
        . " INNER JOIN $tProduct ON $tProduct.id = $tSaleProd.producto_id "
        . " WHERE $tSaleProd.venta_info_id = '$idTicket' ";

$resGetProdTicket = $con->query($sqlGetProdTicket);
if ($resGetProdTicket->num_rows > 0) {
    while ($rowGetProdTicket = $resGetProdTicket->fetch_assoc()) {
        $name = $rowGetProdTicket['name'];
        $cant = $rowGetProdTicket['cant'];
        $cu = $rowGetProdTicket['cu'];
        $ct = $rowGetProdTicket['ct'];
        $prods[] = array('nombre' => $name, 'cant' => $cant, 'cu' => $cu, 'ct' => $ct );
        $ban = true;
    }
} else {
    $ban = false;
    $msgErr = 'No existen productos en éste Ticket.<br>' . $con->error;
}

if ($ban) {
    echo json_encode(array("error" => 0, "dataRes" => $prods, "sql" => $sqlGetProdTicket));
} else {
    echo json_encode(array("error" => 1, "msgErr" => $msgErr));
}
?>