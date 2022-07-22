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
  
  $sqlGetCategories = "SELECT * FROM $tCategory WHERE activo='1' ";
  $resGetCategories = $con->query($sqlGetCategories);
  $optCategories = '';
  if ($resGetCategories->num_rows > 0) {
    while ($rowGetCategories = $resGetCategories->fetch_assoc()) {
      //$optCategories .= '<button type="button" class="clickCategory" title="'.$rowGetCategories['id'].'">'.$rowGetCategories['nombre'].'</button> ';
      $optCategories .= '<div class="col-sm-2 div-img-sales"><img src="'.$rutaImgCat . $rowGetCategories['img'] . '" class="clickCategory img-sales" title="' . $rowGetCategories['id'] . '" width="100%">' . $rowGetCategories['nombre'] . '</div>';
    }
  } else {
    $optCategories .= 'No hay categorias disponibles';
  }
  ?>

  <!-- Cambio dinamico -->
  <div class="row">
    <div class="col-xs-5 sales sales-izquierda">
      <div class="ticket text-center">
        <form id="formTicket" method="POST" action="controllers/set_order.php" >
          <input type="hidden" name="idStore" value="<?= $idStore; ?>">
          <input type="hidden" name="idUser" value="<?= $idUser; ?>">
          <div class="cobrar row">
            <div class="form-group col-xs-5">
              <label>Total:</label></br>
              <input type="text" id="inputTotal" name="inputTotal" readonly step=0.01 class="form-control col-xs-12" >
            </div>
            <div class="form-group col-xs-5">
              <label>Nombre cliente:</label></br>
              <input type="text" id="inputNameClient" name="inputNameClient" class="form-control col-xs-12" required title="Nombre del cliente, obligatorio">
            </div>
            <div class="form-group col-xs-2">
              <label>Cobrar:</label></br>
              <button type="submit" class="enviarTicket btn btn-success"><i class="fa fa-money" style="font-size: 2.2rem;"></i></button>
            </div>
          </div>
          <div class="cobrar row">
            <div class="form-group col-xs-3">
                <label>Abono:</label></br>
                <input type="text" id="inputPago" name="inputPago" step=0.01 class="form-control calcChange" required title="Pago del cliente, obligatorio">
            </div>
            <div class="form-group col-xs-3">
                <label>Recibido:</label></br>
                <input type="text" id="inputRecibido" name="inputRecibido" step=0.01 class="form-control calcChange" required title="Dinero que entrega el cliente, obligatorio">
            </div>
            <div class="form-group col-xs-2">
              <label>Cambio:</label></br>
              <input type="text" id="inputCambio" name="inputCambio" readonly step=0.01 class="form-control" >
            </div>
            <div class="form-group col-xs-4">
              <label>Fecha de entrega:</label></br>
              <input type="date" id="inputFecEntrega" name="inputFecEntrega" class="form-control" required title="Fecha de entrega del pedido, obligatoria." min="<?= $dateNow; ?>">
            </div>
          <div class="cobrar form-inline">
            <div class="form-group">
                <label>Horario de entrega, de:</label>
                <input type="time" id="inputHEI" name="inputHEI" class="form-control" required title="Hora de entrega inicial, obligatoria">
            </div>
            <div class="form-group ">
                <label> a:</label>
                <input type="time" id="inputHEF" name="inputHEF" class="form-control" required title="Hora de entrega final, obligatoria">
            </div>
          </div>
          </div>
          
          <!-- ¿Se podrían donar los pedidos?
          <div class="cobrar row">
              <div class="form-group col-xs-3">
                <label><input type="checkbox" id="inputDonacion" name="inputDonacion" class="checkbox form-control">¿Donar?</label>
              </div>
              <div class="form-group col-xs-9 form-inline">
                  <label>Administrador</label>
                      <input type="password" id="inputAdmin" name="inputAdmin" class="checkbox form-control" readonly >
              </div>
          </div>
          -->
          <div class="line"></div>
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
            <tbody>
            </tbody>
          </table>
        </form>
      </div>
      <div class="teclado text-center">
        <form id="formTeclado" method="POST" class="form-inline">
          <div class="form-group">
            <input type="text" class="typeahead tt-query" autocomplete="off" spellcheck="false" placeholder="Busca el producto" id="inputCod" name="inputCod">
            <input type="hidden" name="idStore" value="<?= $idStore; ?>" >
          </div>
          <button type="submit" class="btn btn-success"><i class="fa fa-list"></i> Agregar</button>
          <div class="errorSearchProduct"></div>
        </form>
        <div id="teclado_numerico_2" class="text-center">
          <div class="numeric-form-sales">
            <span class="btn btn-info btn-numeric-form" onclick="teclado(7)">7</span>
            <span class="btn btn-info btn-numeric-form" onclick="teclado(8)">8</span>
            <span class="btn btn-info btn-numeric-form" onclick="teclado(9)">9</span>
            <br>
            <span class="btn btn-info btn-numeric-form" onclick="teclado(4)">4</span>
            <span class="btn btn-info btn-numeric-form" onclick="teclado(5)">5</span>
            <span class="btn btn-info btn-numeric-form" onclick="teclado(6)">6</span>
            <br>
            <span class="btn btn-info btn-numeric-form" onclick="teclado(1)">1</span>
            <span class="btn btn-info btn-numeric-form" onclick="teclado(2)">2</span>
            <span class="btn btn-info btn-numeric-form" onclick="teclado(3)">3</span>
            <br>
            <span class="btn btn-default btn-numeric-form erase"><i class="fa fa-arrow-left"></i></span>
            <span class="btn btn-info btn-numeric-form" onclick="teclado(0)">0</span>
            <span class="btn btn-default btn-numeric-form" onClick="borrarTeclado()" >C</span>
          </div>
        </div>
      </div>
    </div> <!--  fin IZQUIERDA-->
    <div class="col-sm-7 sales sales-derecha text-center">
      <div class="titulo-crud2 text-center">
        Pedidos
      </div>
      <div class="row productCategory div-sales">
        <?= $optCategories; ?>
      </div>
      <div class="line"></div>
      <div class="row productSubCategory div-sales"></div>
      <div class="line"></div>
      <div class="row productInfo div-sales"></div>
    </div><!--  fin DERECHA-->
  </div>


  <script type="text/javascript">
    $(document).ready(function () {
      $(".clickCategory").click(function () {
        var category = $(this).attr("title");
        //alert(category);
        $.ajax({
          type: "POST",
          url: "controllers/select_orders_sub_categories.php",
          data: {idCategory: category},
          success: function (msg) {
            //alert(msg);
            if (msg == "false") {
              $.ajax({
                type: "POST",
                url: "controllers/select_orders_sub_products.php",
                data: {idCategory: category, tarea: "catProduct", idStore: <?= $idStore; ?>},
                success: function (msg2) {
                  $(".productSubCategory").html('');
                  $(".productInfo").html(msg2);
                }
              });
            } else {
              $(".productInfo").html('');
              $(".productSubCategory").html(msg);
            }
          }
        });
      });

      $(".productSubCategory").on("click", ".clickSubCategory", function () {
        var subCategory = $(this).attr("title");
        //alert(subCategory);
        $.ajax({
          type: "POST",
          url: "controllers/select_orders_sub_products.php",
          data: {idSubCategory: subCategory, tarea: "subProduct", idStore: <?= $idStore; ?>},
          success: function (msg) {
            $(".productInfo").html(msg);
          }
        });
      });

      $(".productInfo").on("click", ".clickProduct", function () {
        var product = $(this).attr("title");
        //alert(product);
        $.ajax({
          type: "POST",
          url: "controllers/select_orders_product.php",
          data: {idProduct: product, idStore: <?= $idStore; ?>},
          success: function (msg) {
            $(".ticket #dataTicket tbody").append(msg);
            $(".ticket #dataTicket tbody #inputCant").focus();
            $(".ticket #dataTicket tbody #inputCant").select();
            calcTotal();
          }
        });
      });

      $(".ticket #dataTicket tbody").on("click", ".deleteItem", function (e) {
        e.preventDefault();
        $(this).parent().parent().remove();
        calcTotal();
      })

      $(".ticket #dataTicket tbody").on("focus", "#inputCant", function () {
        input = $(this);
        actTodo();
      });

      $(".ticket #dataTicket tbody").on("focusout blur change", "#inputCant", function () {
        actTodo();
      });

      $(".teclado #teclado_numerico_2").on("click", function () {
        actTodo();
      });

      $(".ticket #dataTicket tbody").on("keyup change blur keypress keydown", ".cant", actCant);

      $("#formTicket").on("change blur click", ".calcChange", calcChange);
      
      function calcChange(){
          var pago = parseFloat($(this).parent().parent().find("#inputPago").val());
          var recibido = parseFloat($(this).parent().parent().find("#inputRecibido").val());
        if(recibido < pago){
            //alert("El dinero recibido no puede ser menor al total de la venta.");
            $(".enviarTicket").attr("disabled", true);
        }else
            $(".enviarTicket").removeAttr("disabled");
        var cambio = recibido-pago;
          //alert(cambio);
          $(this).parent().parent().find("#inputCambio").val(cambio);
      }
      
      /* Por si se dona el pedido
      $("#inputDonacion").click(function(){
          if($('#inputDonacion').is(':checked')){
              $("#inputRecibido").attr("disabled", true);
              $("#inputAdmin").attr("readonly", false);
          }
          else{
              $("#inputRecibido").removeAttr("disabled");
              $("#inputAdmin").attr("readonly", true);
          }
          //alert("Donando sangre");
      });*/
      
      function actCant() {
        var precioU = parseFloat($(this).parent().parent().find("#inputPrecioU").val());
        var cantidad = parseInt($(this).parent().parent().find("#inputCant").val());
        //alert(cantidadMax);
        if (cantidad < 0) {
          //cantidad = 0;
          $(this).parent().parent().find("#inputCant").val("1");
        }
        var precioF = precioU * cantidad;
        $(this).parent().parent().find("#inputPrecioF").val(precioF);
        calcTotal();
      }

      function calcTotal() {
        var total = 0;
        $(".ticket #dataTicket tbody #inputPrecioF").each(function () {
          total += parseFloat($(this).val());
        });
        total = total.toFixed(2);
        $("#inputTotal").val(total);
        
        //calculamos cambio
        var pago = parseFloat($("#inputPago").val());
        var recibido = parseFloat($("#inputRecibido").val());
        var cambio = recibido-pago;
        //console.log(total);
        $("#inputCambio").val(cambio);
      }

      function actTodo() {
        $(".ticket #dataTicket tbody #inputCant").each(function () {
          var precioU = parseFloat($(this).parent().parent().find("#inputPrecioU").val());
          var cantidad = parseInt($(this).parent().parent().find("#inputCant").val());
          //alert(cantidadMax);
          if (cantidad < 0) {
            //cantidad = 0;
            $(this).parent().parent().find("#inputCant").val("1");
          }
          var precioF = precioU * cantidad;
          $(this).parent().parent().find("#inputPrecioF").val(precioF);
          calcTotal();
        })
      }

      $('input.typeahead').typeahead({
        name: 'inputCod',
        remote: 'controllers/select_orders_product_json.php?query=%QUERY&store=<?= $idStore; ?>',
        limit: 8
      });

      $('#formTeclado').validate({
        rules: {
          inputCod: {required: true}
        },
        messages: {
          inputCod: "Debes introducir un nombre o código de barras"
        },
        tooltip_options: {
          inputCod: {trigger: "focus", placement: 'bottom'}
        },
        submitHandler: function (form) {
          $.ajax({
            type: "POST",
            url: "controllers/select_orders_product_ticket.php",
            data: $('form#formTeclado').serialize(),
            success: function (msg) {
              //alert(msg);
              if (msg == "false") {
                $(".errorSearchProduct").html("Error al introducir producto");
              } else {
                $(".ticket #dataTicket tbody").append(msg);
                $(".ticket #dataTicket tbody #inputCant").focus();
                $(".ticket #dataTicket tbody #inputCant").select();
                calcTotal();
              }
            },
            error: function () {
              alert("Error al buscar producto ");
            }
          });
        }
      });


    });
    //var input;
  </script>

  <script type="text/javascript">
    var input;
    //var banFocusInput=false;
    $("input").on("focus", function () {
      input = $(this);
      //banFocusInput = false;
      //alert(input.val());
    });

    function teclado(numero) {
      if (input != null) {
        //alert(input);

        /*if(banFocusInput)input.val(numero);
         else input.val(input.val()+numero);*/

        input.val(input.val() + numero);
        //actCant();
      }
    }

    function borrarTeclado() {
      input.val("");
    }
    /*function actCant(){
     var precioU = parseFloat($(this).parent().parent().find("#inputPrecioU").val());
     var cantidad = parseInt($(this).parent().parent().find("#inputCant").val());
     var cantidadMax = parseInt($(this).parent().parent().find("#inputCantMax").val());
     //alert(cantidadMax);
     if(cantidad < 0){
     //cantidad = 0;
     $(this).parent().parent().find("#inputCant").val("0");
     }
     if(cantidad > cantidadMax){
     //cantidad = cantidadMax;
     $(this).parent().parent().find("#inputCant").val(cantidadMax);
     }
     var precioF = precioU * cantidad;
     $(this).parent().parent().find("#inputPrecioF").val(precioF);
     calcTotal();
     }
       
     function calcTotal(){
     var total=0;
     $(".ticket #dataTicket tbody #inputPrecioF").each(function(){
     total += parseFloat($(this).val());
     });
     total=total.toFixed(2);
     $("#inputTotal").val(total);
     }*/
  </script>
  <?php
}//fin else sesión
include ('footer.php');
?>
