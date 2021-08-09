<?php
session_start();
include('config/conexion.php');
include('header.php');
include ('menu.php');
if (!isset($_SESSION['storeId']))
  echo '<div class="row"><div class="col-sm-12 text-center"><h2>No ha iniciado sesión en tienda</h2></div></div>';
else if (!isset($_SESSION['sessU']))
  echo '<div class="row"><div class="col-sm-12 text-center"><h2>No ha iniciado sesión de usuario</h2></div></div>';
else {
  $idStore = $_SESSION['storeId'];
  $idUser = $_SESSION['userId'];
	include('config/variables.php');
  
  ?>

    <div class="row">
        <div id="loading">
            <img src="../assets/img/loading.gif" height="300" width="400">
        </div>
    </div>

  <!-- Cambio dinamico -->
  <div class="row">
    <div class="col-xs-5 sales sales-izquierda">
      <div class="ticket text-center">
        <form id="formTicket" method="POST" action="controllers/set_sale.php">
          <input type="hidden" name="idStore" value="<?= $idStore; ?>">
          <input type="hidden" name="idUser" value="<?= $idUser; ?>">
          <div class="cobrar row">
            <div class="form-group col-xs-3">
              <label>Total:</label></br>
              <input type="text" id="inputTotal" name="inputTotal" readonly step=0.01 class="form-control col-xs-12">
            </div>
            <div class="form-group col-xs-3">
              <label>Recibido:</label></br>
              <input type="text" id="inputRecibido" name="inputRecibido" step=0.01 class="form-control calcChange"
                required title="Pago del cliente, obligatorio">
            </div>
            <div class="form-group col-xs-3">
              <label>Cambio:</label></br>
              <input type="text" id="inputCambio" name="inputCambio" readonly step=0.01 class="form-control">
            </div>
            <div class="form-group col-xs-3">
              <label>Cobrar:</label></br>
              <button type="submit" class="enviarTicket btn btn-success"><i class="fa fa-money"
                  style="font-size: 2.2rem;"></i></button>
            </div>
          </div>
          <div class="cobrar row form-inline">
            <div class="form-group col-xs-3">
              <label>¿Donar?</label>
              <input type="checkbox" id="inputDonacion" name="inputDonacion" class="checkbox form-control">
            </div>
            <div class="form-group col-xs-9">
              <label>Administrador</label>
              <input type="password" id="inputAdmin" name="inputAdmin" class="form-control" readonly>
            </div>
          </div>
          <div class="efectivo row form-inline">
            <div class="form-group col-xs-3">
              <label>Efectivo</label>
              <input type="checkbox" id="inputEfectivo" name="inputEfectivo" class="checkbox from-control">
            </div>
            <div class="form-group col-xs-6">
              <label>Cantidad</label>
              <input type="text" id="inpCantEfectivo" name="inpCantEfectivo" class="form-control" readonly >
            </div>
            <div class="form-group col-xs-3">
              <label>Pagar</label><br>
              <button class="enviarEfectivo btn btn-success"><i class="fa fa-money"
                  style="font-size: 2.2rem;" ></i></button>
            </div>
          </div>
          <div class="line"></div>
          <div class="mygrid-wrapper-div">
            <table id="dataTicket" class="table table-striped">
              <thead>
                <tr>
                  <th>Nombre</th>
                  <th>Precio U.</th>
                  <th>Cantidad</th>
                  <th>Precio F.</th>
                  <th></th>
                </tr>
              </thead>
              <tbody></tbody>
            </table>
          </div>
        </form>
      </div>
    </div> <!--  fin IZQUIERDA-->
    <div class="col-sm-7 sales sales-derecha text-center">
      <div class="titulo-crud2">
        Ventas
      </div>
      <div class="row productCategory div-sales">
        <!-- datatable -->
        <table id="ventas" class="display cell-border " style="width:100%">
          <thead>
            <tr>
              <th>ID</th>
              <th>Categoría</th>
              <th>Subcategoría</th>
              <th>Producto</th>
              <th>Precio</th>
            </tr>
          </thead>
        </table>
      </div>

      <div class="line"></div>
      <div class="row productSubCategory div-sales"></div>
      <div class="line"></div>
      <div class="row productInfo div-sales"></div>
    </div><!--  fin DERECHA-->
  </div>



<script type="text/javascript">
$(document).ready(function (){

    $('#loading').hide();
    //Funcion para llenar la DataTable haciendo solo una peticion a la base de datos
    var dataTable = $('#ventas').DataTable({
        "language":	{
            "sProcessing":     "Procesando...",
            "sZeroRecords":    "No se encontraron resultados",
            "sEmptyTable":     "Ningún dato disponible en esta tabla",
            "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
            "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
            "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
            "sInfoPostFix":    "",
            "sSearch":         "Buscar:",
            "sUrl":            "",
            "sInfoThousands":  ",",
            "sLoadingRecords": "Cargando...",
            "oPaginate": {
                "sFirst":    "Primero",
                "sLast":     "Último",
                "sNext":     "Siguiente",
                "sPrevious": "Anterior"
            },
				},
        "responsive" : true,
        "processing" : true,
        "serverSide" : true,
        "ajax"       : {
            url  : "controllers/select_sales_products_json.php",
            type : "post",
        },
        error : function() {
            $("#ventas-error").html("");
            $("#ventas").append('<tbody class="employee-grid-error"><tr><th colspan="3">No hay información en la baser</th></tr></tbody>');
            $("#ventas_processing").css("display", "none");
        }
    });

    // Callbacks
    $('#ventas tbody').on( 'click', 'tr', function () {
        if ( $(this).hasClass('selected') ) {
            $(this).removeClass('selected');
        }
        else {
            dataTable.$('tr.selected').removeClass('selected');
            $(this).addClass('selected');
        }
    } );

    $('#ventas tbody').on( 'dblclick', 'tr', function () {
        let data = dataTable.row( this ).data();
        $.ajax({
            type : "POST",
            url  : "controllers/select_sales_product.php",
            data : { idProduct: data[0], idStore: <?= $idStore; ?>},
            success: function (msg) {
                $(".ticket #dataTicket tbody").append(msg);
                $(".ticket #dataTicket tbody #inputCant").focus();
                $(".ticket #dataTicket tbody #inputCant").select();
                calcTotal();
            }
        });
    } );

    // Función para añadir bolsa por defecto
    addBolsa();
    function addBolsa(){
        $.ajax({
            type : "POST",
            url  : "controllers/select_sales_product.php",
            data : { idProduct: 65, idStore: <?= $idStore; ?>}, // FIXME: Cambiar id del producto bolsa si cambia la base
            success: function (msg) {
                $(".ticket #dataTicket tbody").append(msg);
                $(".ticket #dataTicket tbody #inputCant").focus();
                $(".ticket #dataTicket tbody #inputCant").select();
                calcTotal();
            }
        });
        $('.enviarEfectivo').attr("disabled", true);
    }

      $(".ticket #dataTicket tbody").on("click", ".deleteItem", function (e) {
        e.preventDefault();
        $(this).parent().parent().remove();
        calcTotal();
      })

      $(".ticket #dataTicket tbody").on("focus", "#inputCant", function () {
        //alert("focus Cantidad");
        input = $(this);
        //banFocusInput = true;
        actTodo();
      });

      $(".ticket #dataTicket tbody").on("focusout blur change", "#inputCant", function () {
        actTodo();
      });

      //$(".ticket #dataTicket tbody").on("keyup change blur keypress keydown", ".cant", actCant);
      $(".ticket #dataTicket tbody").on("keyup change blur keypress keydown click mouseup", ".cant", actCant);

      $("#formTicket").on("change blur click", ".calcChange", calcChange);
      function calcChange(){
          let total  = parseFloat( $(this).parent().parent().find("#inputTotal").val() );
          let dinero = parseFloat( $(this).parent().parent().find("#inputRecibido").val() ) || 0;
          dinero = dinero.toFixed(2);
        if( dinero < total || isNaN(dinero) || dinero == 0 ){
            $(this).parent().parent().find(".enviarTicket").attr("disabled", true);
        }else
            $(this).parent().parent().find(".enviarTicket").removeAttr("disabled");
        let cambio = (dinero != 0 ) ? dinero - total : 0;
        cambio = cambio.toFixed(2);
        $(this).parent().parent().find("#inputCambio").val(cambio);
      }
      
      $("#inputDonacion").click(function(){
          if($('#inputDonacion').is(':checked')){
              $("#inputRecibido").attr("disabled", true);
              $("#inputAdmin").attr("readonly", false);
          }
          else{
              $("#inputRecibido").removeAttr("disabled");
              $("#inputAdmin").attr("readonly", true);
          }
      });

      $("#inputEfectivo").click(function(){
          if($('#inputEfectivo').is(':checked')){
              $('#inpCantEfectivo').attr("readonly", false);
              $(".enviarEfectivo").removeAttr("disabled");
              $('.enviarTicket').attr("disabled", true);
          }
          else{
              $("#inpCantEfectivo").attr("readonly", true);
              $('.enviarEfectivo').attr("disabled", true);
              $(".enviarTicket").removeAttr("disabled");
          }
      })

      $(".enviarEfectivo").click( function() {
          console.log("efectivo");
          let cantEfectivo = $("#inpCantEfectivo").val();
          console.log( cantEfectivo );
          $.ajax({
              type : "POST",
              url  : "controllers/create_efectivo.php",
              data : { cant: cantEfectivo, idStore: <?= $idStore; ?>, idUser: <?= $idUser; ?> }, // FIXME: Cambiar id del producto bolsa si cambia la base
              success: function (msg) {
                  var msg = jQuery.parseJSON(msg);
                  if( msg.error == 0 ){
                      $('#loading').empty();
                      $('#loading').append('<h2>Se dio efectivo con éxito.</h2>');
                      setTimeout(function () {
                          location.href = 'form_sales.php';
                      }, 1500);
                  }else{
                      $('#loading').empty();
                      $('#loading').append('<img src="../assets/img/error.png" height="300" width="400" ><p>'+msg.msgErr+'</p>');
                      setTimeout(function (){
                          $('#loading').hide();
                      }, 2000 );
                  }
              }
          })
      } );
      
      function actCant() {
        var precioU = parseFloat($(this).parent().parent().find("#inputPrecioU").val());
        var cantidad = parseInt($(this).parent().parent().find("#inputCant").val());
        var cantidadMax = parseInt($(this).parent().parent().find("#inputCantMax").val());
        //alert(cantidadMax);
        if (cantidad < 0) {
          //cantidad = 0;
          $(this).parent().parent().find("#inputCant").val("0");
        }
        if (cantidad > cantidadMax) {
          //cantidad = cantidadMax;
          $(this).parent().parent().find("#inputCant").val(cantidadMax);
        }
        var precioF = precioU * cantidad;
        precioF = parseFloat(precioF);
        precioF = precioF.toFixed(2);
        $(this).parent().parent().find("#inputPrecioF").val(precioF);
        calcTotal();
      }

      function calcTotal() {
        let total = 0;
        $(".ticket #dataTicket tbody #inputPrecioF").each(function () {
          total += parseFloat($(this).val());
        });
        total = total.toFixed(2);
        $("#inputTotal").val(total);
        
        //calculamos cambio
        // let total = parseFloat($("#inputTotal").val());
        let dinero = parseFloat($("#inputRecibido").val()) || 0;
        dinero = dinero.toFixed(2);
        
        if( dinero < total || isNaN(dinero) || dinero == 0 ){
            $(this).parent().parent().find(".enviarTicket").attr("disabled", true);
        }else
            $(this).parent().parent().find(".enviarTicket").removeAttr("disabled");

        let cambio = ( dinero != 0 ) ? dinero - total : 0;
        cambio = cambio.toFixed(2);
        //console.log(total);
        $("#inputCambio").val(cambio);
      }

      function actTodo() {
        $(".ticket #dataTicket tbody #inputCant").each(function () {
          var precioU = parseFloat($(this).parent().parent().find("#inputPrecioU").val());
          var cantidad = parseInt($(this).parent().parent().find("#inputCant").val());
          var cantidadMax = parseInt($(this).parent().parent().find("#inputCantMax").val());
          //alert(cantidadMax);
          if (cantidad < 0) {
            //cantidad = 0;
            $(this).parent().parent().find("#inputCant").val("0");
          }
          if (cantidad > cantidadMax) {
            //cantidad = cantidadMax;
            $(this).parent().parent().find("#inputCant").val(cantidadMax);
          }
          var precioF = precioU * cantidad;
          precioF = parseFloat(precioF);
          precioF = precioF.toFixed(2);
          $(this).parent().parent().find("#inputPrecioF").val(precioF);
          calcTotal();
        })
      }


    });
  </script>

  <?php
}//fin else sesión
include ('footer.php');
?>
