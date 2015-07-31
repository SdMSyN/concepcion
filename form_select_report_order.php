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
  $userId = $_SESSION['userId'];

  /* Obtenemos las tiendas */
  $sqlGetStores = "SELECT id, nombre FROM $tStore";
  $resGetStores = $con->query($sqlGetStores);
  $optStores = '<option></option>';
  if ($resGetStores->num_rows > 0) {
    while ($rowGetStores = $resGetStores->fetch_assoc()) {
      $optStores.='<option value="' . $rowGetStores['id'] . '">' . $rowGetStores['nombre'] . '</option>';
    }
  } else {
    $optStores = '<option>No existen tiendas aún</option>';
  }
  ?>

  <!-- Cambio dinamico -->
  <div class="container">
    <div class="row">
      <div class="titulo-crud text-center">REPORTES DE PEDIDOS</div>  
      <form class="form-horizontal">
        <div class="form-group">
          <label class="col-sm-2 control-label">Seleccione una tienda</label>
          <div class="col-sm-4">
            <select id="inputStore" class="form-control">
              <?= $optStores; ?>
            </select>
          </div>
        </div>
      </form>
      <div class="row stock-title" >
        <div class="col-md-12 text-center" id="stockName"></div>
      </div>
      <div class="msg"></div>
      <div class="col-md-12 btnFiltros">
        
      </div>
      <div class="col-md-12 report" id="myPrintArea">
          <table class="table table-striped" id="tableReport">
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
                      <th>Detalles</th>
                  </tr>
              </thead>
              <tbody></tbody>
          </table>
      </div>
    </div>
  </div><!-- fin container -->
  
  <script type="text/javascript">
    $(document).ready(function () {
      $('#inputStore').focus();
      $('#inputStore').change(function () {
        var selectStore = $('#inputStore').val();
        $('body').removeClass('loaded');
        //alert(selectStore);
        $.ajax({
          type: 'POST',
          url: 'controllers/select_report_filter.php',
          data: {storeId: selectStore, tarea: "order"},
          success: function (msg) {
            //alert(msg);
            $('.btnFiltros').html(msg);
            $.ajax({
                type: 'POST',
                url: 'controllers/select_report_store_orders.php?action=day',
                data: $('form#formSelectReport').serialize(),
                success: function (msg) {
                  //alert(msg);
                  $('.report #tableReport tbody').html(msg);
                }
              });//end ajax
              $('body').addClass('loaded');
          }
        });//end ajax
        if (selectStore == "") {
          $('.btnFiltros').empty();
        } else {
          //$('.btnFiltros').html('<button onClick="'+selectStore+'">Store</button>');
          //$('#saveButton').html('<button type="submit" class="btn btn-primary" >Guardar</button>');
        }

        $.ajax({
          type: 'POST',
          url: 'controllers/select_stock_name.php',
          data: {storeId: selectStore},
          success: function (msg) {
            //alert(msg);
            if (msg == "false") {
              $('#stockName').empty();
            } else {
              $('#stockName').html(msg);
            }
          }
        });//end ajax
      });   

      $(".btnFiltros").on("click", "#generateReport", function(){
        $('body').removeClass('loaded');
        $.ajax({
          type: 'POST',
          url: 'controllers/select_report_store_orders.php?action=filter',
          data: $('form#formSelectReport').serialize(),
          success: function (msg) {
            //alert(msg);
            $('.report #tableReport tbody').html(msg);
            $('body').addClass('loaded');
          }
        });//end ajax
      });
      
      $(".btnFiltros").on("click", ".reportStock", function(){
        $('body').removeClass('loaded');
        $.ajax({
          type: 'POST',
          url: 'controllers/select_report_stock.php',
          data: $('form#formSelectReport').serialize(),
          success: function (msg) {
            //alert(msg);
            $('.report #tableReport tbody').html(msg);
            $('body').addClass('loaded');
          }
        });//end ajax
      });

      $(".btnFiltros").on("click", ".cleanReport", function(){
         //alert("limpiando");
         $("#inputSellers").val(""); 
         $("#inputMonth").val(""); 
         $("#inputWeek").val(""); 
         $("#inputDay").val(""); 
         $("#inputCategory").val(""); 
         $("#inputEst").val(""); 
         $("#inputEstPay").val(""); 
      });
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