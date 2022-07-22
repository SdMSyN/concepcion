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
      
      <div class="row">
<?php
    include ('../config/conexion.php');
    include ('../config/variables.php');
    
  
    $idStore=$_POST['idStore'];
    $idUser=$_POST['idUser'];
    
    //(isset($_POST['inputDonacion'])) ? $dona=$_POST['inputDonacion'] : $dona="false";
    $total=$_POST['inputTotal'];
    $recibido=$_POST['inputRecibido'];
    $aPagar=$_POST['inputPago'];
    $cambio=$_POST['inputCambio'];
    $cliente=$_POST['inputNameClient'];
    $fecEntrega=$_POST['inputFecEntrega'];
    // Horarios de entrega
    $hei=$_POST['inputHEI'];
    $hef=$_POST['inputHEF'];
    //($dona=="on") ? $idAdmin=$_POST['inputAdmin'] : $idAdmin="";
    $cad='';
    //Obtenemos datos de la tienda

    $sqlGetStore="SELECT * FROM $tStore WHERE id='$idStore' ";
    $resGetStore=$con->query($sqlGetStore);
    $rowGetStore=$resGetStore->fetch_assoc();
    $cad.='<div id="myPrintArea">';
    $cad.='<div class="col-sm-2 ticket">';
    $cad.='<p class="text-center">"La Concepción Apizaco"<br>Sucursal: '.$rowGetStore['nombre'].'<br>Dirección: '.$rowGetStore['direccion'].'<br>CP: '.$rowGetStore['cp'].'<br>RFC: '.$rowGetStore['rfc'].'<br>Tel: '.$rowGetStore['tel'].'</p>';

    //Obtenemos datos del vendedor y fecha de venta
    $sqlGetUser="SELECT CONCAT(ap,' ',am,' ',nombre) as nombre FROM $tUser WHERE id='$idUser' ";
    $resGetUser=$con->query($sqlGetUser);
    $rowGetUser=$resGetUser->fetch_assoc();
    $cad.='<p class="text-center">Le atendio: '.$rowGetUser['nombre'].'</br>Fecha: '.$dateNow.'<br>Hora: '.$timeNow.'</p>';
    $cad.='<p class="text-center"><br>Fecha de entrega: '.$fecEntrega.'<br>Entregar entre las: '.$hei.' y las '.$hef.'.</p>';
    
    $sqlCreateInfoOrder="INSERT INTO $tOrderInfo (usuario_id, tienda_id, nombre_cliente, fecha, hora, total, est_pedido_id, est_pedido_pago_id, fecha_entrega, hora_entrega_inicial, hora_entrega_final) VALUES ('$idUser', '$idStore', '$cliente', '$dateNow', '$timeNow', '$total', '1', '1', '$fecEntrega', '$hei', '$hef' )";
    if($con->query($sqlCreateInfoOrder) === TRUE){
        $idInfoOrder=$con->insert_id;
        
        $sqlCreatePayOrder="INSERT INTO $tOrderPay (pedido_info_id, pago, recibido, cambio, usuario_id, fecha) VALUES ('$idInfoOrder', '$aPagar', '$recibido', '$cambio', '$idUser', '$dateNow' ) ";
        if($con->query($sqlCreatePayOrder) === TRUE){
            $cad.='<table><thead><tr><th>Producto</th><th>C.U.</th><th>Cant.</th><th>C.T.</th></tr></thead><tbody>';
            for($i=0; $i<count($_POST['id']); $i++){
                $idProduct=$_POST['id'][$i];
                $cant=$_POST['inputCant'][$i];
                $costoU=$_POST['inputPrecioU'][$i];
                $costoF=$_POST['inputPrecioF'][$i];

                $sqlInsertProductOrder="INSERT INTO $tOrderProd (producto_id, pedido_info_id, cantidad, costo_unitario, costo_total) VALUES ('$idProduct', '$idInfoOrder', '$cant', '$costoU', '$costoF') ";
                if($con->query($sqlInsertProductOrder) === TRUE){
                    $sqlGetProduct="SELECT nombre FROM $tProduct WHERE id='$idProduct' ";
                    $resGetProduct=$con->query($sqlGetProduct);
                    $rowGetProduct=$resGetProduct->fetch_assoc();
                    $productName=$rowGetProduct['nombre'];
                    $cad.='<tr>';
                    $cad.='<td>'.$productName.'</td>';
                    $cad.='<td class="text-right">'.$costoU.'</td>';
                    $cad.='<td class="text-right">'.$cant.'</td>';
                    $cad.='<td class="text-right">'.$costoF.'</td>';
                    $cad.='</tr>';
                }else{
                    echo "Error al crear la lista de productos del pedido.<br>".$con->error;
                }
            }//end for
        }else{
            echo "Error al crear datos de pago del pedido.";
        }
    }else{
        echo "Error al crear información del pedido.<br>".$con->error;
    }

    $porPagar=$total - $aPagar;
    $cad.='</tbody></table>';
    $cad.='<p class="text-right">Total: '.$total.'<br>Abonado: '.$aPagar.'<br>Recibido: '.$recibido.'<br>Cambio: '.$cambio.'<br><b>Por pagar: '.$porPagar.'</b></p>';
    $cad.='<p class="text-center">Gracias por su preferencia.</p>';
    $cad.='</div><div class="col-sm-10"></div>';//Fin col-sm-2
    $cad.='</div></div>';//Fin área imprime -- Fin row
    $cad.='<div class="row"><p><a href="javascript:void(0)" id="imprime" class="btn btn-success">Imprime <span class="glyphicon glyphicon-print"></span></a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="../form_orders.php">Cancelar/Atrás</a></p></div>';

    echo $cad;

?>

<script type="text/javascript">
    $(document).ready(function() {
        $('#imprime').click(function() {
            $("div#myPrintArea").printArea();
        });
    });
</script>


  <footer class="footer">
    <p >Desarrollado por <a href="http://softlutions.biz" target="_blank" ><b>SOFTLUTIONS</b></a> 2015</p>
  </footer>
  </body>
</html>