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
        <form id="formTicket" method="POST" action="controllers/set_sale.php" >
          <input type="hidden" name="idStore" value="<?= $idStore; ?>">
          <input type="hidden" name="idUser" value="<?= $idUser; ?>">
          <div class="cobrar row">
            <div class="form-group col-xs-3">
              <label>Total:</label></br>
              <input type="text" id="inputTotal" name="inputTotal" readonly step=0.01 class="form-control col-xs-12" >
            </div>
            <div class="form-group col-xs-3">
                <label>Recibido:</label></br>
                <input type="text" id="inputRecibido" name="inputRecibido" step=0.01 class="form-control calcChange" required title="Pago del cliente, obligatorio">
            </div>
            <div class="form-group col-xs-3">
              <label>Cambio:</label></br>
              <input type="text" id="inputCambio" name="inputCambio" readonly step=0.01 class="form-control" >
            </div>
            <div class="form-group col-xs-3">
              <label>Cobrar:</label></br>
              <button type="submit" class="enviarTicket btn btn-success"><i class="fa fa-money" style="font-size: 2.2rem;"></i></button>
            </div>
          </div>
          <div class="cobrar row form-inline">
              <div class="form-group col-xs-3">
                <label>¿Donar?</label>
                <input type="checkbox" id="inputDonacion" name="inputDonacion" class="checkbox form-control">
              </div>
              <div class="form-group col-xs-9">
                  <label>Administrador</label> 
                      <input type="password" id="inputAdmin" name="inputAdmin" class="form-control" readonly >
              </div>
              </div>
              <div class="efectivo row form-inline">
                <div class="form-group col-xs-3">
                  <label>Efectivo</label>
                  <input type="checkbox" id="inputEfectivo" name="inputEfectivo" class="checkbox from-control">
                </div>
                <div class="form-group col-xs-6">
                  <label>Cantidad</label>
                  <input type="text" id="inputCantidad" name="inputCantidad" class="form-control" readonly>
                </div>
                <div class="form-group col-xs-3">
                  <label>Pagar</label><br>
                  <button type="submit" class="enviarpago btn btn-success"><i class="fa fa-money" style="font-size: 2.2rem;"></i></button>
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
       <table id="ventas" class="table table-striped table-bordered" style="width:100%">
        <thead>
            <tr>
              <th>ID</th>
              <th>Nombre</th>
              <th>Imagen</th>
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
$(document).ready(function ( ){
  //Funcion para llenar la DataTable haciendo solo una peticion a la base de datos
  product();
  function product(){
    $.ajax({
      type: "POST",
      url: "controllers/select_sales_products_json.php",
      success: function(msg){
        var msg = jQuery.parseJSON(msg);
        console.log( msg );
        if(msg.error == 0){
<<<<<<< HEAD
            alert(msg.productos[0].idP);
          $("#ventas, tbody");
          $.each(msg.productos, function(i, item){
=======
          $("#ventas");
          $.each(msg.dataRes, function(i, item){
>>>>>>> 6c3b58e335e39458c32e2fd4353f54dc017215e4
            var newRow = '<tr>'
            +'<td>'+msg.dataRes[i].idProducto+'</td>'
            +'<td>'+msg.dataRes[i].nameProducto+'</td>'
            +'<td>'+msg.dataRes[i].imgProducto+'</td>'
            '</tr>';
<<<<<<< HEAD
            $(newRow).appendTo("#ventas tbody");
          } 
          )}
=======
            $(newRow).appendTo("#ventas");
          } ); 
        }
>>>>>>> 6c3b58e335e39458c32e2fd4353f54dc017215e4
      }
    });
  }


   /* $(document).ready(function () {
      $(".clickCategory").click(function () {
        var category = $(this).attr("title");
        //alert(category);
        $.ajax({
          type: "POST",
          url: "controllers/select_sales_sub_categories.php",
          data: {idCategory: category},
          success: function (msg) {
            //alert(msg);
            if (msg == "false") {
              $.ajax({
                type: "POST",
                url: "controllers/select_sales_sub_products.php",
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
        //$(".clickSubCategory").click(function(){
        var subCategory = $(this).attr("title");
        //alert(subCategory);
        $.ajax({
          type: "POST",
          url: "controllers/select_sales_sub_products.php",
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
          url: "controllers/select_sales_product.php",
          data: {idProduct: product, idStore: <?= $idStore; ?>},
          success: function (msg) {
            $(".ticket #dataTicket tbody").append(msg);
            $(".ticket #dataTicket tbody #inputCant").focus();
            $(".ticket #dataTicket tbody #inputCant").select();
            calcTotal();
          }
        });
      });
      */
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

      //$(".teclado #teclado_numerico_2").on("keyup change click keyprees kewdown", ".cant", actCant);
      $(".teclado #teclado_numerico_2").on("click", function () {
        actTodo();
      });

      //$(".ticket #dataTicket tbody").on("keyup change blur keypress keydown", ".cant", actCant);
      $(".ticket #dataTicket tbody").on("keyup change blur keypress keydown click mouseup", ".cant", actCant);

      /*$("#formTicket").on("change blur click", ".calcChange", function(){
          var total = parseFloat($(this).parent().parent().find("#inputTotal").val());
          var dinero = parseFloat($(this).val());
          var cambio = dinero-total;
          //alert(cambio);
          $("#inputCambio").val(cambio);
          calcChange();
      });*/
      $("#formTicket").on("change blur click", ".calcChange", calcChange);
      function calcChange(){
          var total = parseFloat($(this).parent().parent().find("#inputTotal").val());
          var dinero = $(this).parent().parent().find("#inputRecibido").val();
          dinero = parseFloat(dinero);
          dinero = dinero.toFixed(2);
          //$(this).parent().parent().find("#inputRecibido").val(dinero);
          //var dinero = parseFloat($(this).parent().parent().find("#inputRecibido").val());
        if(dinero < total || isNaN(dinero)){
            //alert("El dinero recibido no puede ser menor al total de la venta.");
            $(this).parent().parent().find(".enviarTicket").attr("disabled", true);
        }else
            $(this).parent().parent().find(".enviarTicket").removeAttr("disabled");
        var cambio = dinero-total;
          //alert(cambio);
          cambio = cambio.toFixed(2);
          $(this).parent().parent().find("#inputCambio").val(cambio);
      }
      
      $("#inputDonacion").click(function(){
          if($('#inputDonacion').is(':checked')){
              $("#inputRecibido").attr("disabled", true);
              $("#inputAdmin").attr("readonly", false);
            //$(this).parent().parent().find("#inputRecibido").attr("disabled", true);
            //$(this).parent().parent().find("#inputAdmin").attr("readonly", true);
            //inputAdmin
          }
          else{
              $("#inputRecibido").removeAttr("disabled");
              $("#inputAdmin").attr("readonly", true);
              //$(this).parent().parent().find("#inputRecibido").removeAttr("disabled");
              //$(this).parent().parent().find("#inputAdmin").attr("readonly", false);
          }
          //alert("Donando sangre");
      });

      $("#inputEfectivo").click(function(){
        if($('#inputEfectivo').is(':checked')){
            $('#inputRecibido').attr("disabled", true);
            $('#inputRecibido').attr("readonly", false);
        }
        else{
          $("inputEfectivo").removeAttr("disabled");
          $("inputCantidad").attr("readonly", true);
        }
      })
      
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
        var total = 0;
        $(".ticket #dataTicket tbody #inputPrecioF").each(function () {
          total += parseFloat($(this).val());
        });
        total = total.toFixed(2);
        $("#inputTotal").val(total);
        
        //calculamos cambio
        var total = parseFloat($("#inputTotal").val());
        var dinero = parseFloat($("#inputRecibido").val());
        dinero = dinero.toFixed(2);
        var cambio = dinero-total;
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
      /*$(".ticket #dataTicket tbody").on("keyup change blur keypress keydown", ".cant", function(){
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
       });*/

      /*function calcTotal(){
       var total=0;
       $(".ticket #dataTicket tbody #inputPrecioF").each(function(){
       total += parseFloat($(this).val());
       });
       total=total.toFixed(2);
       $("#inputTotal").val(total);
       }*/

      $('input.typeahead').typeahead({
        name: 'inputCod',
        remote: 'controllers/select_sales_product_json.php?query=%QUERY&store=<?= $idStore; ?>',
        limit: 8
      });

      $('#formTeclado').validate({
        rules: {
          inputCod: {required: true}
        },
        messages: {
          inputCod: "Debes introducir una nombre o código de barras"
        },
        tooltip_options: {
          inputCod: {trigger: "focus", placement: 'bottom'}
        },
        submitHandler: function (form) {
          $.ajax({
            type: "POST",
            url: "controllers/select_sales_product_ticket.php",
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
      /*$('input.typeahead-devs').typeahead({
       name: 'inputCod',
       local: ['Sunday', 'Monday', 'Tuesday','Wednesday','Thursday','Friday','Saturday']
       });*/


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
    function actCant(){
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
     }
  </script>
  <?php
}//fin else sesión
include ('footer.php');
?>
