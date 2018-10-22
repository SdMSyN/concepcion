<html lang="en">
    <head>
        <?php
        include ('config/variables.php');
        ?>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>
            <?= $tit; ?>
        </title>

        <!-- Bootstrap -->
        <link href="assets/css/application.css" rel="stylesheet">

        <!-- jQuery -->
        <script src="assets/js/jquery.min.js"></script>
        <script src="assets/js/bootstrap.min.js"></script>
        <script src="assets/js/jquery.validate.min.js"></script>
        <script src="assets/js/additional-methods.min.js"></script>
        <script src="assets/js/jquery-validate.bootstrap-tooltip.min.js"></script>
        <script src="assets/js/application.js"></script>
        <script src="assets/js/jquery.PrintArea.js"></script>
        <script src="assets/js/typeahead.min.js"></script>

        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
          <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>

    <body>

        <nav class="navbar navbar-default">
            <div class="container-fluid">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                        <span class="sr-only">Menu</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="index_admin.php">Inicio</a>
                </div>
            </div><!-- /.container-fluid -->
        </nav>

        <div class="row" >

            <?php
            include ('config/conexion.php');
            include ('config/variables.php');

            //$idStore = (isset($_GET['idStore'])) ? $_GET['idStore'] : 12;
            //if ($_GET['idStore'] == 0)
                //$idStore = 12;
            //Obtenemos ID Ticket
            $idTicket = $_GET['idTicket'];
            //Obtenemos Información del Ticket para reimprimir
            $sqlGetSaleInfo = "SELECT * FROM $tSaleInfo WHERE id='$idTicket' ";
            $resGetSaleInfo = $con->query($sqlGetSaleInfo);
            $rowGetSaleInfo = $resGetSaleInfo->fetch_assoc();

            $idUser = $rowGetSaleInfo['usuario_id'];
            $total = $rowGetSaleInfo['total'];
            $recibido = $rowGetSaleInfo['pago'];
            $cambio = $rowGetSaleInfo['cambio'];
            $totalDesc = $rowGetSaleInfo['total_desc'];
            $cambioDesc = $rowGetSaleInfo['cambio_desc'];
            $descuentoDesc = $rowGetSaleInfo['descuento'];
            $cantDesc = $rowGetSaleInfo['cant_desc'];
            //$idClient = $rowGetSaleInfo['cliente_id'];
            $idStore = $rowGetSaleInfo['tienda_id'];

            $cad = '';
            //Obtenemos datos de la tienda

            $cad .= '<div id="myPrintArea">';
            $cad .= '<div class="col-sm-2 ticket">';
            //$cad .= '<img class="img-responsive center-block" src="assets/img/logo_3.jpg">';

            //Obtenemos información de la tienda
            $sqlGetStoreInfo = "SELECT nombre, direccion, rfc, cp, tel FROM $tStore WHERE id='$idStore' ";
            $resGetStoreInfo = $con->query($sqlGetStoreInfo);
            $rowGetStoreInfo = $resGetStoreInfo->fetch_assoc();
            $cad.='<p class="text-center">"La Concepción FAM Apizaco"<br>'
                    . 'Matriz: ' . $rowGetStoreInfo['nombre'] 
                    . '<br>Dirección: ' . $rowGetStoreInfo['direccion'] 
                    . '<br>CP: ' . $rowGetStoreInfo['cp'] 
                    . '<br>RFC: ' . $rowGetStoreInfo['rfc']
                    . '<br>Regimen de incorporación fiscal'
                    . '<br>Tel: ' . $rowGetStoreInfo['tel'] . '</p>';

            //Obtenemos datos del vendedor y fecha de venta
            $sqlGetUser = "SELECT CONCAT(ap,' ',am,' ',nombre) as nombre FROM $tUser WHERE id='$idUser' ";
            $resGetUser = $con->query($sqlGetUser);
            $rowGetUser = $resGetUser->fetch_assoc();
            $cad .= '<p class="text-center">Le atendio: ' . $rowGetUser['nombre'] . '</br>Fecha: ' . $dateNow . '<br>Hora: ' . $timeNow . '</p>';
            $cad .= '<p>Núm. Ticket: <b>'.$idTicket.'</b></p>';
            
            $idInfoSale = $idTicket;
            $cad .= '<table><thead><tr><th>Producto</th><th style="padding-left: .5rem;">C.U.</th><th style="padding-left: .5rem;">Cant.</th><th style="padding-left: .5rem;">C.T.</th></tr></thead><tbody style="border: 1px solid black;">';
            //Obtenemos los productos vendidos
            $sqlGetSaleProd = "SELECT * FROM $tSaleProd WHERE venta_info_id = '$idTicket' ";
            $resGetSaleProd = $con->query($sqlGetSaleProd);
            while ($rowGetSaleProd = $resGetSaleProd->fetch_assoc()) {
                $idProduct = $rowGetSaleProd['producto_id'];
                $cant = $rowGetSaleProd['cantidad'];
                $costoU = $rowGetSaleProd['costo_unitario'];
                $costoF = $rowGetSaleProd['costo_total'];

                $sqlGetProduct = "SELECT nombre FROM $tProduct WHERE id='$idProduct' ";
                $resGetProduct = $con->query($sqlGetProduct);
                $rowGetProduct = $resGetProduct->fetch_assoc();
                $productName = $rowGetProduct['nombre'];
                $cad .= '<tr style="border: 1px solid black;">';
                $cad .= '<td style="border: 1px solid black;">' . $productName . '</td>';
                $cad .= '<td class="text-right" style="border: 1px solid black;"> $' . $costoU . ' </td>';
                $cad .= '<td class="text-right" style="border: 1px solid black;"> ' . $cant . ' </td>';
                $cad .= '<td class="text-right" style="border: 1px solid black;"> $' . $costoF . ' </td>';
                $cad .= '</tr>';
                //header("Location: ../form_sales.php");
                //echo "true";
            }

            $cad .= '</tbody></table>';
            if ($descuentoDesc != 0) {
                $cad .= '<p class="text-right">Subtotal: $' . $total
                        . '<br>Descuento del: $' . $descuentoDesc . ' %'
                        . '<br>Total: $' . $totalDesc
                        . '<br>Efectivo: $' . $recibido
                        . '<br>Cambio: $' . $cambioDesc
                        . '</p>';
            } else {
                $cad .= '<p class="text-right">Total: $' . $total 
                        . '<br>Efectivo: $' . $recibido 
                        . '<br>Cambio: $' . $cambio . '</p>';
            }

            $cad .= '<p class="text-center">Gracias por su preferencia.</p>';
            //$cad .= ($idClient != 0) ? '<p>Cliente: ' . $nameClient . ', RFC: ' . $rfcClient . '</p>' : '';
            $cad .= '<p class="text-center" style="font-zie: 10px">Sistema Punto de Venta por <br>www.solucionesynegocios.com.mx</p>';
            $cad .= '</div><div class="col-sm-10"></div>'; //Fin col-sm-2
            $cad .= '</div></div>'; //Fin área imprime -- Fin row
            $cad .= '<div style="padding-left: 1rem;"><p><a href="javascript:void(0)" id="imprime" class="btn btn-success">Imprime <span class="glyphicon glyphicon-print"></span></a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="form_select_report.php" class="btn btn-default">Atrás</a></p></div>';

            echo $cad;
            ?>

            <script type="text/javascript">
                $(document).ready(function () {
                    $('#imprime').click(function () {
                        $("div#myPrintArea").printArea();
                        setTimeout("location.href='form_select_report.php'", 1000);
                    });
                });
            </script>


            <footer class="footer">
                <p>Desarrollado por <a href="http://solucionesynegocios.com.mx" target="_blank" ><b>Software de México: Soluciones y Negocios S.A.S. de C.V.</b></a> 2015</p>
            </footer>
    </body>
</html>