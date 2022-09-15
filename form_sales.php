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

  <div class="row">
    <div id="loading">
      <img src="../assets/img/loading.gif" height="300" width="400">
    </div>
  </div>

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
                <label>¿Tarjeta?</label>
                <input type="checkbox" id="inputTarjeta" name="inputTarjeta" class="checkbox form-control">
              </div>
              <div class="form-group col-xs-3">
                <label>¿Donar?</label>
                <input type="checkbox" id="inputDonacion" name="inputDonacion" class="checkbox form-control">
              </div>
              <div class="form-group col-xs-6">
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
                  <input type="text" id="inpCantEfectivo" name="inpCantEfectivo" class="form-control" readonly>
              </div>
              <div class="form-group col-xs-3">
                  <label>Pagar</label><br>
                  <button class="enviarEfectivo btn btn-success">
                      <i class="fa fa-money" style="font-size: 2.2rem;"></i>
                  </button>
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
              <tbody>
              </tbody>
            </table>
          </div>
        </form>
      </div>
      <div class="text-center">
        <h3>Total de piezas: <span id="totalPiezas">0</span></h3>
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
            <br>
            <span class="btn btn-info btn-numeric-form" onclick="decimal('.50')">.50</span>
          </div>
        </div>
      </div>
    </div> <!--  fin IZQUIERDA-->
    <div class="col-sm-7 sales sales-derecha text-center">
      <div class="titulo-crud2">
        Ventas
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
      $('#loading').hide();
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
        calcChange();
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

      $("#formTicket").on("change blur click", ".calcChange", calcChange);

      function calcChange(){
          let total = parseFloat($(this).parent().parent().find("#inputTotal").val());
          let dinero = $(this).parent().parent().find("#inputRecibido").val();
          if( isNaN( dinero ) )
            dinero = 0;
          dinero = parseFloat(dinero);
          dinero = dinero.toFixed(2);
          //$(this).parent().parent().find("#inputRecibido").val(dinero);
          //var dinero = parseFloat($(this).parent().parent().find("#inputRecibido").val());
          // FIXME: se comenta por que no se logra solucionar, mejor que vaya por defecto 
          // if(dinero < total || isNaN(dinero)){
          //     $(this).parent().parent().find(".enviarTicket").attr("disabled", true);
          // }else
          //     $(this).parent().parent().find(".enviarTicket").removeAttr("disabled");
          let cambio = dinero-total;
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
        calcPiezas();
        let total = 0;
        $(".ticket #dataTicket tbody #inputPrecioF").each(function () {
          total += parseFloat($(this).val());
        });
        total = total.toFixed(2);
        $("#inputTotal").val(total);
        
        //calculamos cambio
        // let total = parseFloat($("#inputTotal").val());
        let dinero = parseFloat($("#inputRecibido").val());
        if( isNaN( dinero ) )
          dinero = 0;
        dinero = dinero.toFixed(2);
        let cambio = dinero-total;
        cambio = cambio.toFixed(2);
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


      // Función para añadir bolsa por defecto
      addBolsa();

      function addBolsa() {
        $.ajax({
          type: "POST",
          url: "controllers/select_sales_product.php",
          data: {
            idProduct: 172,
            idStore: <?= $idStore; ?>
          }, // FIXME: Cambiar id del producto bolsa si cambia la base
          success: function (msg) {
            $(".ticket #dataTicket tbody").append(msg);
            $(".ticket #dataTicket tbody #inputCant").focus();
            $(".ticket #dataTicket tbody #inputCant").select();
            calcTotal();
          }
        });
        $('.enviarEfectivo').attr("disabled", true);
      }

      $("#inputEfectivo").click(function () {
        if ($('#inputEfectivo').is(':checked')) {
          $('#inpCantEfectivo').attr("readonly", false);
          $(".enviarEfectivo").removeAttr("disabled");
          $('.enviarTicket').attr("disabled", true);
        } else {
          $("#inpCantEfectivo").attr("readonly", true);
          $('.enviarEfectivo').attr("disabled", true);
          $(".enviarTicket").removeAttr("disabled");
        }
      })

      $(".enviarEfectivo").click(function () {
        let cantEfectivo = $("#inpCantEfectivo").val();
        $.ajax({
          type: "POST",
          url: "controllers/create_efectivo.php",
          data: {
            cant: cantEfectivo,
            idStore: <?= $idStore; ?> ,
            idUser : <?= $idUser; ?>
          }, // FIXME: Cambiar id del producto efectivo si cambia la base
          success: function (msg) {
            var msg = jQuery.parseJSON(msg);
            if (msg.error == 0) {
              $('#loading').empty();
              $('#loading').append('<h2>Se dio efectivo con éxito.</h2>');
              setTimeout(function () {
                location.href = 'form_sales.php';
              }, 1500);
            } else {
              $('#loading').empty();
              $('#loading').append('<img src="../assets/img/error.png" height="300" width="400" ><p>' + msg
                .msgErr + '</p>');
              setTimeout(function () {
                $('#loading').hide();
              }, 2000);
            }
          }
        })
      });

      function calcPiezas(){
          let totalPiezas = $("#totalPiezas");
          let total = 0;
          let countCiclo = 0;
          let ban = false;
          $(".ticket #dataTicket tbody #inputCant").each(function () {
            let idProd = parseInt( $(this).parent().parent().find("#inpId").val() );
            let cant   = parseFloat( $(this).parent().parent().find("#inputCant").val() );
            console.log( idProd );
            if( idProd != 172 ){ // FIXME: Cambiar por ID de bolsa
              total += cant;
            }
          });
          $("#totalPiezas").html(total);
      }

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

    function decimal( valor ){
      if( valor == '.50' )
        input.val( input.val() + "." + 50 );
    }

    function borrarTeclado() {
      input.val("");
    }

  </script>
  <?php
}//fin else sesión
include ('footer.php');
?>
