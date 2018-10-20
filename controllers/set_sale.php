<html lang="en">
    <head>
        <?php
        include ('../config/variables.php');
        ?>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <title>
            <?= $tit; ?>
        </title>

        <!-- Bootstrap -->
        <link href="../assets/css/application.css" rel="stylesheet">

        <!-- jQuery -->
        <script src="../assets/js/jquery.min.js"></script>
        <script src="../assets/js/bootstrap.min.js"></script>
        <script src="../assets/js/jquery.validate.min.js"></script>
        <script src="../assets/js/additional-methods.min.js"></script>
        <script src="../assets/js/jquery-validate.bootstrap-tooltip.min.js"></script>
        <script src="../assets/js/application.js"></script>
        <script src="../assets/js/jquery.PrintArea.js"></script>
        <!--
            <script src="assets/js/typeahead.js"></script>
            <script src="assets/js/typeahead.jquery.js"></script>
            <script src="assets/js/typeahead.bundle.js"></script>
            <script src="assets/js/bloodhound.js"></script>
            <script src="assets/js/typeahead.min.js"></script>
        -->
        <script src="../assets/js/typeahead.min.js"></script>

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
                    <?php
                    if (isset($_SESSION['perfil']) && $_SESSION['perfil'] == "1") {
                        if (isset($_SESSION['sessA'])) {
                            ?>
                            <a class="navbar-brand" href="../index_admin.php">Inicio</a>
                            <?php
                        } else {
                            ?>
                            <a class="navbar-brand" href="../form_sales.php">Inicio</a>
                            <a class="navbar-brand" href="../form_orders.php">Pedidos</a>
                            <?php
                        }
                    } elseif (isset($_SESSION['perfil']) && $_SESSION['perfil'] == "3" && isset($_SESSION['sess'])) {
                        ?>
                        <a class="navbar-brand" href="../form_sales.php">Inicio</a>
                        <a class="navbar-brand" href="../form_orders.php">Pedidos</a>
                        <?php
                    } else {
                        ?>
                        <a class="navbar-brand" href="../form_sales.php">Inicio</a>
                        <a class="navbar-brand" href="../form_orders.php">Pedidos</a>
                        <?php
                    }
                    ?>      
                </div>

                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav">
                        <?php
                        if (isset($_SESSION['perfil']) && $_SESSION['perfil'] == "1" && isset($_SESSION['sessA'])) {
                            ?>
                            <li><a href="../form_select_stock.php">Almacen</a></li>
                            <li><a href="../form_select_product.php">Productos</a></li>
                            <li><a href="../form_select_user.php">Usuarios</a></li>
                            <li><a href="../form_select_store.php">Tiendas</a></li>
                            <li><a href="../form_select_category.php">Categorías</a></li>
                            <li><a href="../form_select_subcategory.php">Subcategorías</a></li>
                            <li><a href="../form_select_report.php">Reportes</a></li>
                            <?php
                        } elseif (isset($_SESSION['perfil']) && $_SESSION['perfil'] == "3" && isset($_SESSION['sess'])) {
                            ?>
                            <!--          <li><a href="form_select_stock_2.php">Hola mundo</a></li>-->
                            <?php
                        }
                        ?>


                    </ul>
                    <ul class="nav navbar-nav navbar-right">
                        <?php
                        if (isset($_SESSION['perfil'])) {
                            echo '<li class="no-a user-name">Bienvenido ' . $_SESSION['userName'] . '</li>';
                            echo '<li><a href="proc_destroy_login_admin.php">Cerrar Sesión</a></li>';
                        }
                        ?>
                    </ul>
                </div><!-- /.navbar-collapse -->
            </div><!-- /.container-fluid -->
        </nav>

        <div class="row" >

            <?php
            include ('../config/conexion.php');
            include ('../config/variables.php');

            $idStore = $_POST['idStore'];
            $idUser = $_POST['idUser'];

            (isset($_POST['inputDonacion'])) ? $dona = $_POST['inputDonacion'] : $dona = "false";
            ($dona != "on") ? $recibido = $_POST['inputRecibido'] : $recibido = "0.00";
            $total = $_POST['inputTotal'];
            ($dona != "on") ? $cambio = $_POST['inputCambio'] : $cambio = "0.00";
            ($dona == "on") ? $idAdmin = $_POST['inputAdmin'] : $idAdmin = "";
            $cad = '';
            //Obtenemos datos de la tienda
            //echo '<h2>'.$dona.'</h2>';

            $donarAct = true;
            if ($dona == "on") {
                $sqlGetUserDon = "SELECT id FROM $tUser WHERE password='$idAdmin' AND perfil_id='1' ";
                $resGetUserDon = $con->query($sqlGetUserDon);
                if ($resGetUserDon->num_rows > 0) {
                    $rowGetUserDon = $resGetUserDon->fetch_assoc();
                    $idUser = $rowGetUserDon['id'];
                } else {
                    $donarAct = false;
                }
            }
            //echo '<div class="row text-center">'.$cad.'<br>User: '.$idUser.'<br>'.$donarAct.'</div>';
            if ($donarAct == true) {
                $sqlGetStore = "SELECT * FROM $tStore WHERE id='$idStore' ";
                $resGetStore = $con->query($sqlGetStore);
                $rowGetStore = $resGetStore->fetch_assoc();
                $cad .= '<div id="myPrintArea">';
                $cad .= '<div class="col-sm-2 ticket">';
                $cad .= '<p class="text-center">"La Concepción FAM Apizaco"<br>'
                        . 'Matriz: ' . $rowGetStore['nombre']
                        . '<br>Dirección: ' . $rowGetStore['direccion']
                        . '<br>CP: ' . $rowGetStore['cp']
                        . '<br>RFC: ' . $rowGetStoreInfo['rfc']
                        . '<br>Regimen de incorporación fiscal'
                        . '<br>Tel: ' . $rowGetStore['tel'] . '</p>';

                //Obtenemos datos del vendedor y fecha de venta
                $sqlGetUser = "SELECT CONCAT(ap,' ',am,' ',nombre) as nombre FROM $tUser WHERE id='$idUser' ";
                $resGetUser = $con->query($sqlGetUser);
                $rowGetUser = $resGetUser->fetch_assoc();
                $cad .= '<p class="text-center">Le atendio: ' . $rowGetUser['nombre'] . '</br>Fecha: ' . $dateNow . '<br>Hora: ' . $timeNow . '</p>';


                $sqlCreateInfoSale = "INSERT INTO $tSaleInfo (usuario_id, tienda_id, fecha, hora, pago, total, cambio, total_desc) "
                        . "VALUES ('$idUser', '$idStore', '$dateNow', '$timeNow', '$recibido', '$total', '$cambio', '$total' )";
                if ($con->query($sqlCreateInfoSale) === TRUE) {
                    $idInfoSale = $con->insert_id;
                    
                    $cad .= '<p>Núm. Ticket: <b>'.$idTicket.'</b></p>';
                    $cad .= '<table><thead><tr><th>Producto</th><th style="padding-left: .5rem;">C.U.</th><th style="padding-left: .5rem;">Cant.</th><th style="padding-left: .5rem;">C.T.</th></tr></thead><tbody>';
                    for ($i = 0; $i < count($_POST['id']); $i++) {
                        $idProduct = $_POST['id'][$i];
                        $cant = $_POST['inputCant'][$i];
                        $costoU = $_POST['inputPrecioU'][$i];
                        $costoF = $_POST['inputPrecioF'][$i];

                        $sqlInsertProductSale = "INSERT INTO $tSaleProd (producto_id, venta_info_id, cantidad, costo_unitario, costo_total) VALUES ('$idProduct', '$idInfoSale', '$cant', '$costoU', '$costoF') ";
                        if ($con->query($sqlInsertProductSale) === TRUE) {
                            $sqlGetCantStock = "SELECT cantidad FROM $tStock WHERE producto_id='$idProduct' AND tienda_id='$idStore'";
                            $resGetCantStock = $con->query($sqlGetCantStock);
                            if ($resGetCantStock->num_rows > 0) {
                                $rowGetCantStock = $resGetCantStock->fetch_assoc();
                                $cantStock = $rowGetCantStock['cantidad'] - $cant;
                                $sqlUpdStock = "UPDATE $tStock SET cantidad='$cantStock' WHERE producto_id='$idProduct' AND tienda_id='$idStore'  ";
                                if ($con->query($sqlUpdStock) === TRUE) {
                                    $sqlGetProduct = "SELECT nombre FROM $tProduct WHERE id='$idProduct' ";
                                    $resGetProduct = $con->query($sqlGetProduct);
                                    $rowGetProduct = $resGetProduct->fetch_assoc();
                                    $productName = $rowGetProduct['nombre'];
                                    $cad .= '<tr>';
                                    $cad .= '<td>' . $productName . '</td>';
                                    $cad .= '<td class="text-right">' . $costoU . '</td>';
                                    $cad .= '<td class="text-right">' . $cant . '</td>';
                                    $cad .= '<td class="text-right">' . $costoF . '</td>';
                                    $cad .= '</tr>';
                                    //header("Location: ../form_sales.php");
                                    //echo "true";
                                } else {
                                    echo "Error al modificar cantidades de almacén.<br>" . $con->error;
                                }
                            } else {
                                echo "Error al buscar producto en almacén.<br>" . $con->error;
                            }
                        } else {
                            echo "Error al crear la lista de productos vendidos.<br>" . $con->error;
                        }
                    }//end for
                } else {
                    echo "Error al crear información de la venta.<br>" . $con->error;
                }

                $cad .= '</tbody></table>';
                $cad .= '<p class="text-right">Total: ' . $total . '<br>Efectivo: ' . $recibido . '<br>Cambio: ' . $cambio . '</p>';
                if ($dona == "on")
                    $cad .= '<p class="text-center"><b>DONACIÓN</b></p>';

                $cad .= '<p class="text-center">Gracias por su preferencia.</p>';
                $cad .= '<p class="text-center" style="font-zie: 10px">Sistema Punto de Venta por <br>www.solucionesynegocios.com.mx</p>';
                $cad .= '</div><div class="col-sm-10"></div>'; //Fin col-sm-2
                $cad .= '</div></div>'; //Fin área imprime -- Fin row
                $cad .= '<div style="padding-left: 1rem;"><p><a href="javascript:void(0)" id="imprime" class="btn btn-success">Imprime <span class="glyphicon glyphicon-print"></span></a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="../form_sales.php" class="btn btn-default">Atrás</a></p></div>';

                echo $cad;
            }//end else $donarAct
            else {
                $cad .= '<div class="col-sm-12 text-center"><h3>No se puede donar ya que el administrador es incorrecto.</h3><br><a href="../form_sales.php">Cancelar/Atrás</a></div></div>';
                echo $cad;
            }
            ?>

            <script type="text/javascript">
                $(document).ready(function () {
                    $('#imprime').click(function () {
                        $("div#myPrintArea").printArea();
                        setTimeout("location.href='../form_sales.php'", 1000);
                    });
                });
            </script>


            <footer class="footer">
                <p>Desarrollado por <a href="http://solucionesynegocios.com.mx" target="_blank" ><b>Software de México: Soluciones y Negocios S.A.S. de C.V.</b></a> 2015</p>
            </footer>
    </body>
</html>