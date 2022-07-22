<?php
session_start();
include('config/conexion.php');
include('header.php');
include ('menu.php');
if (!isset($_SESSION['sessA']))
  echo '<div class="row"><div class="col-sm-12 text-center"><h2>No ha iniciado sesión de Administrador</h2></div></div>';
else if ($_SESSION['perfil'] != "1")
  echo '<div class="row><div class="col-sm-12 text-center"><h2>No tienes permiso para entrar a esta sección</h2></div></div>';
else {
  $orderId = $_GET['id'];
  $sqlGetDetailOrder="SELECT id, nombre_cliente, (SELECT nombre FROM $tUser WHERE id=$tOrderInfo.usuario_id) as user, (SELECT nombre FROM $tStore WHERE id=$tOrderInfo.tienda_id) as store, fecha, hora, total, fecha_entrega, hora_entrega_inicial as hei, hora_entrega_final as hef, (SELECT nombre FROM $tOrderEst WHERE id=$tOrderInfo.est_pedido_id) as estOrder, (SELECT nombre FROM $tOrderEstPay WHERE id=$tOrderInfo.est_pedido_pago_id) as estOrderPay FROM $tOrderInfo WHERE id='$orderId' ";
  $resGetDetailOrder=$con->query($sqlGetDetailOrder);
    $optReport='';
    while($rowGetInfoOrder = $resGetDetailOrder->fetch_assoc()){
        $optReport.='<tr>';
        $optReport.='<td>'.$rowGetInfoOrder['id'].'</td>';
        $optReport.='<td>'.$rowGetInfoOrder['nombre_cliente'].'</td>';
        $optReport.='<td>'.$rowGetInfoOrder['user'].'</td>';
        $optReport.='<td>'.$rowGetInfoOrder['store'].'</td>';
        $optReport.='<td>'.$rowGetInfoOrder['fecha'].'</td>';
        $optReport.='<td>'.$rowGetInfoOrder['hora'].'</td>';
        $optReport.='<td>'.$rowGetInfoOrder['total'].'</td>';
        $optReport.='<td>'.$rowGetInfoOrder['fecha_entrega'].'</td>';
        $optReport.='<td>De '.$rowGetInfoOrder['hei'].' a las '.$rowGetInfoOrder['hef'].'</td>';
        $optReport.='<td>'.$rowGetInfoOrder['estOrder'].'</td>';
        $optReport.='<td>'.$rowGetInfoOrder['estOrderPay'].'</td>';
        $optReport.='</tr>';
    }
  ?>

  <!-- Cambio dinamico -->
  <div class="container">
    <div class="row">
      <div class="titulo-crud text-center">Información de pedido</div>  
      <!--
      <form class="form-horizontal">
        <div class="form-group">
          <label class="col-sm-2 control-label">Seleccione los detalles que desea visualizar</label>
          <div class="col-sm-4">
            <select id="inputOpt" class="form-control">
                <option></option>
                <option value="prod">Productos</option>
                <option value="payment">Pagos</option>
            </select>
          </div>
        </div>
      </form>
      -->
      <div class="msg"></div>
      <div class="col-md-12 report" id="myPrintArea">
            <table class="table table-striped">
              <thead>
                  <tr>
                      <th>#</th>
                      <th>Cliente</th>
                      <th>Vendedor</th>
                      <th>Tienda</th>
                      <th>Fecha</th>
                      <th>Hora</th>
                      <th>Total</th>
                      <th>Fecha de entrega</th>
                      <th>Horario de entrega</th>
                      <th>Estatus pedido</th>
                      <th>Estatus de pago</th>
                  </tr>
              </thead>
              <tbody><?= $optReport; ?> </tbody>
          </table>
          <div class="table table-striped" id="tableReport">
              
          </div>
      </div>
    </div>
  </div><!-- fin container -->
  
  <script type="text/javascript">
    $(document).ready(function () {
      /*$('#inputOpt').focus();
      $('#inputOpt').change(function () {
        var selectOpt = $('#inputOpt').val();
        //alert(selectOpt);
        $.ajax({
          type: 'POST',
          url: 'controllers/select_report_detail_filter_2.php',
          data: {orderId: <?=$orderId;?>, tarea: selectOpt},
          success: function (msg) {
            $('.report #tableReport').html("");
            $('.report #tableReport').html(msg);
          }
        });
        
      }); */  

  
    details();
    function details(){
        $.ajax({
          type: 'POST',
          url: 'controllers/select_report_detail_filter_2.php',
          data: {orderId: <?=$orderId;?>, tarea: "homework"},
          success: function (msg) {
            $('.report #tableReport').html("");
            $('.report #tableReport').html(msg);
          }
        });
    }
 });  
    //$('#imprime').click(function() {
    $(".btnFiltros").on("click", "#imprime", function(){
        $("div#myPrintArea").printArea();
    });
  </script>

  <?php
}//fin else sesión
include ('footer.php');
?>