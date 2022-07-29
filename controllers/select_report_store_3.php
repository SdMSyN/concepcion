<?php

include ('../config/conexion.php');
include ('../config/variables.php');

$store    = $_POST['inputStore'];
$seller   = $_POST['inputSellers'];
$month    = $_POST['inputMonth'];
$week     = $_POST['inputWeek'];
$day      = $_POST['inputDay'];
$category = $_POST['inputCategory'];
$typeUser = $_POST['typeUser'];
$action   = $_GET['action'];
//echo $store.'--'.$sellers.'--'.$month.'--'.$week;

// $sqlGetInfoSale = "SELECT id, (SELECT nombre FROM $tUser WHERE id=$tSaleInfo.usuario_id) as user, "
//         . "(SELECT nombre FROM $tStore WHERE id=$tSaleInfo.tienda_id) as store,"
//         . " fecha, hora, pago, total, cambio, descuento, total_desc, cant_desc, cambio_desc "
//         . " FROM $tSaleInfo WHERE tienda_id='$store' ";

$sqlGetInfoSale = "
    SELECT
        ventas_info.id,
        usuarios.nombre AS user,
        tiendas.nombre AS store,
        ventas_info.fecha, 
        ventas_info.hora, 
        ventas_info.pago, 
        ventas_info.total, 
        ventas_info.cambio, 
        ventas_info.descuento, 
        ventas_info.total_desc, 
        ventas_info.cant_desc, 
        ventas_info.cambio_desc
    FROM ventas_info
        INNER JOIN usuarios ON ventas_info.usuario_id = usuarios.id
        INNER JOIN tiendas  ON ventas_info.tienda_id = tiendas.id
    WHERE ventas_info.tienda_id = $store
";

if ($action == "day") {
    $sqlGetInfoSale .= " AND fecha='$dateNow' ";
} else {//reporte con filtro
    if ($seller == "" && $month == "" && $week == "" && $day == "" && $category == "") {
        $sqlGetInfoSale .= " AND fecha='$dateNow' ";
    } else if ($seller != "" && $month == "" && $week == "" && $day == "") {
        $sqlGetInfoSale .= " AND usuario_id='$seller' AND fecha='$dateNow' ";
    } else {
        if (isset($_POST['inputSellers']) && $seller != "") {
            $sqlGetInfoSale .= " AND usuario_id='$seller' ";
        }
        if (isset($_POST['inputMonth']) && $month != "") {
            $mes = ($month{5} . $month{6});
            $sqlGetInfoSale .= " AND month(fecha)='$mes' ";
        }
        if (isset($_POST['inputWeek']) && $week != "") {
            $sema = ($week{6} . $week{7}) - 1;
            $sqlGetInfoSale .= " AND week(fecha)='$sema' ";
        }
        if (isset($_POST['inputDay']) && $day != "") {
            $sqlGetInfoSale .= " AND fecha='$day' ";
        }
    }
}

//echo $sqlGetInfoSale.'<br>';
$resGetInfoSale = $con->query($sqlGetInfoSale);
$optReport = '';
if ($resGetInfoSale->num_rows > 0) {
    $i = 1;
    $costoFT = 0;
    while ($rowGetInfoSale = $resGetInfoSale->fetch_assoc()) {
        $idInfoSale    = $rowGetInfoSale['id'];
        $totalInfoSale = $rowGetInfoSale['total_desc'];
        $total         = $rowGetInfoSale['total'];
        $descuento     = $rowGetInfoSale['descuento'];
        $tota_desc     = $rowGetInfoSale['total_desc'];

        // $optReport .= '<tr>';
        // $optReport .= '<td>' . $i . '</td>';
        // $optReport .= '<td><button class="btn btn-default" data-whatever="' . $idInfoSale 
        //         . '" data-toggle="modal" data-target="#modalViewTicket">' . $idInfoSale . '</button> '
        //         . '<a href="print_ticket.php?idTicket='.$idInfoSale.'" class="btn btn-info"><span class="glyphicon glyphicon-print"></span></a></td>';
        // $optReport .= '<td>' . $rowGetInfoSale['total'] . '</td>';
        // $optReport .= '<td>' . $rowGetInfoSale['descuento'] . '</td>';
        // $optReport .= '<td>' . $rowGetInfoSale['total_desc'] . '</td>';
        $optReport .= "<tr>
            <td>$i</td>
            <td>
                <button class='btn btn-default' data-whatever='$idInfoSale' data-toggle='modal' data-target='#modalViewTicket'>
                    $idInfoSale
                </button>
                <a href='print_ticket.php?idTicket=$idInfoSale' class='btn btn-info'>
                    <span class='glyphicon glyphicon-print'></span>
                </a>
            </td>
            <td>$total</td>
            <td>$descuento</td>
            <td>$total_desc</td>
        ";
        //Si no hay pago ni cambio hubo donación
        if ($rowGetInfoSale['pago'] == "0.00" && $rowGetInfoSale['cambio'] == "0.00"){
            $optReport .= '<td>Si</td>';
            $totalInfoSale = 0;
        }else{
            $optReport .= '<td>No</td>';
        }
        $optReport .= '<td>' . $rowGetInfoSale['user'] . '</td>';
        $optReport .= '<td>' . $rowGetInfoSale['store'] . '</td>';
        $optReport .= '<td>' . $rowGetInfoSale['fecha'] . '</td>';
        $optReport .= '<td>' . $rowGetInfoSale['hora'] . '</td>';
        $optReport .= '</tr>';
        $i++;
            
        $costoFT += $totalInfoSale;
    }
    if( $typeUser != 3 )
        $optReport .= '<tr>
            <td></td><td><b>Totales</b></td><td></td><td></td><td><b>'.$costoFT.'</b></td><td colspan="5"></td>
        </tr>';
}else {
    $optReport = '<tr><td colspan="9">No hay ventas.</td></tr>';
}
echo $optReport;
?>