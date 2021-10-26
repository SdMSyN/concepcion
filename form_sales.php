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

    $sqlGetCategories = "SELECT * FROM categorias WHERE activo = 1 AND categorias.id != 5 ";
    $resGetCategories = $con->query($sqlGetCategories);
    $optCategories='';
    if($resGetCategories->num_rows > 0){
        while($rowGetCategories = $resGetCategories->fetch_assoc()){
            //$optCategories .= '<button type="button" class="clickCategory" title="'.$rowGetCategories['id'].'">'.$rowGetCategories['nombre'].'</button> ';
            $optCategories .= '<div class="col-xs-3"><img src="uploads/categories/'.$rowGetCategories['img'].'" class="clickCategory" title="'.$rowGetCategories['id'].'" width="50%">'.$rowGetCategories['nombre'].'</div>';
        }
    }else{
        $optCategories .= 'No hay categorias disponibles';
    }
  
    $sqlGetStore="SELECT * 
                  FROM tiendas 
                  WHERE id='$idStore' ";
    $resGetStore=$con->query($sqlGetStore);
    $rowGetStore=$resGetStore->fetch_assoc();

    $sqlGetUser="SELECT 
                  CONCAT(ap,' ',am,' ',nombre) as nombre 
                FROM usuarios 
                WHERE id='$idUser' ";
    $resGetUser=$con->query($sqlGetUser);
    $rowGetUser=$resGetUser->fetch_assoc();
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
            <input type="text" id="inputTotal" name="inputTotal" readonly step=0.01 class="form-control form-control-lg">
          </div>
          <div class="form-group col-xs-3">
            <label>Recibido:</label></br>
            <input type="text" id="inputRecibido" name="inputRecibido" step=0.01 class="form-control calcChange form-control-lg"
              required title="Pago del cliente, obligatorio">
          </div>
          <div class="form-group col-xs-3">
            <label>Cambio:</label></br>
            <input type="text" id="inputCambio" name="inputCambio" readonly step=0.01 class="form-control form-control-lg">
          </div>
          <div class="form-group col-xs-3">
            <label>Cobrar:</label></br>
            <!-- <button type="submit" class="enviarTicket btn btn-success"><i class="fa fa-money"
                style="font-size: 2.2rem;"></i></button> -->
            <!-- <button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#modalPay">
              <i class="fa fa-money" style="font-size: 2.2rem;"></i>
            </button> -->
            <button type="button" class="btn btn-primary" id="print" >
                <i class="fa fa-print" style="font-size: 2.2rem;"></i>
            </button>
          </div>
        </div>
        <div class="cobrar row form-inline">
          <div class="form-group col-xs-3">
            <label>¿Donar?</label>
            <input type="checkbox" id="inputDonacion" name="inputDonacion" class="checkbox form-control">
          </div>
          <div class="form-group col-xs-6">
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
            <input type="text" id="inpCantEfectivo" name="inpCantEfectivo" class="form-control" readonly>
          </div>
          <div class="form-group col-xs-3">
            <label>Pagar</label><br>
            <button class="enviarEfectivo btn btn-success"><i class="fa fa-money"
                style="font-size: 2.2rem;"></i></button>
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
      <div class="row teclado">
                <!-- <form id="formTeclado">
                    <div class="row">
                        <input type="text" id="inputCod" name="inputCod">
                        <button type="submit" class="">Enviar</button>
                    </div>
                </form> -->
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
    </div>
  </div> <!--  fin IZQUIERDA-->
  <div class="col-xs-6 ">
    <!-- <div class="titulo-crud2">
      Ventas
    </div> -->
    <div class="row productCategory div-sales">
      <?= $optCategories; ?>
    </div>
    <div class="line"></div>
    <div class="row productSubCategory div-sales"></div>
    <div class="line"></div>
    <div class="row productInfo div-sales">
      <!-- datatable -->
      <table id="ventas" class="display cell-border " style="width:100%">
        <thead>
          <tr>
            <th>ID</th>
            <th>Producto</th>
            <th>Precio</th>
            <th>Código</th>
          </tr>
        </thead>
      </table>
    </div>
  </div><!--  fin DERECHA-->
</div>


<!-- div oculto ticket -->
<div id="myPrintArea2" >
  <!-- <div class="col-sm-2 ticket" style="display: none"> -->
  <!-- <div class="col-sm-2 ticket" id="mdlTicket" style="opacity : 1"> -->
    <p class="text-center">"La concepción Apizaco"
      <br>Sucursal: <?= utf8_decode( $rowGetStore['nombre'] ) ?>
      <br>Dirección: <?= $rowGetStore['direccion'] ?>
      <br>CP: <?= $rowGetStore['cp'] ?>
      <br>RFC: <?= $rowGetStore['rfc'] ?>
      <br>Tel: <?= $rowGetStore['tel'] ?>
    </p>
    <p class="text-center">Le atendio: <?= $rowGetUser['nombre'] ?>
      </br>Fecha: <?= $dateNow ?>
      <br>Hora: <?= $timeNow ?>
    </p>
    <table id="tblMdlTicket">
      <thead>
        <tr>
          <th>Producto</th>
          <th>C.U.</th>
          <th>Cant.</th>
          <th>C.T.</th>
        </tr>
      </thead>
      <tbody>
      </tbody>
    </table>
    <p class="text-right">Total: <span id="inpMdlTotal"></span>
      <br>Efectivo: <span id="inpMdlEfec"></span>
      <br>Cambio: <span id="inpMdlCambio"></span>
    </p>
    <p class="text-center">Gracias por su preferencia.</p>
  <!-- </div> -->
  <!-- <div class="col-sm-10"></div> -->
</div>

<script type="text/javascript">
  $(document).ready(function () {
    var subCategory = 0;
    var dataSet = [];
    //Funcion para llenar la DataTable haciendo solo una peticion a la base de datos
    var dataTable = $('#ventas').DataTable({
      "language": {
        "sProcessing": "Procesando...",
        "sZeroRecords": "No se encontraron resultados",
        "sEmptyTable": "Ningún dato disponible en esta tabla",
        "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
        "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
        "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
        "sInfoPostFix": "",
        "sSearch": "Buscar:",
        "sUrl": "",
        "sInfoThousands": ",",
        "sLoadingRecords": "Cargando...",
        "lengthMenu": "Mostrando _MENU_ registros",
        "oPaginate": {
          "sFirst": "Primero",
          "sLast": "Último",
          "sNext": "Siguiente",
          "sPrevious": "Anterior"
        },
      },
      "responsive": true,
      data: dataSet,
      "order": [[ 1, "asc" ]],
      "columnDefs": [
            {
                "targets": [ 0 ],
                "visible": false,
                "searchable": true
            }
        ],
      columns: [
        {
          title: "ID"
        },
        {
          title: "Producto"
        },
        {
          title: "Precio"
        },
        {
          title: "Código"
        }
      ]
    });
    
    $("#print").click(function(){
        $.ajax({
          type : "POST",
          url: "controllers/set_sale_2.php",
          data: $('form#formTicket').serialize(),
          success: function(data){
            var dataRes = jQuery.parseJSON(data);
            if(dataRes.error == 0){
              window.print();
            }else{
              alert( dataRes.msgErr )
            }
          }
        })
    })

    // Recargar la página después de imprimir
    window.onafterprint = function(){
      window.location.reload(true);
    }
    
    $(".clickCategory").click(function () {
      var category = $(this).attr("title");
      //alert(category);
      $.ajax({
        type: "POST",
        url: "controllers/select_sales_sub_categories.php",
        data: {
          idCategory: category
        },
        success: function (msg) {
          //alert(msg);
          if (msg == "false") {
            $.ajax({
              type: "POST",
              url: "controllers/select_sales_sub_products.php",
              data: {
                idCategory: category,
                tarea: "catProduct"
              },
              success: function (msg2) {
                $(".productSubCategory").html('');
                // $(".productInfo").html(msg2);
              }
            });
          } else {
            // $(".productInfo").html('');
            $(".productSubCategory").html(msg);
          }
        }
      });
    });

    $(".productSubCategory").on("click", ".clickSubCategory", function () {
      subCategory = $(this).attr("title");
      //alert(subCategory);
      $.ajax({
        type: "POST",
        url: "controllers/select_sales_sub_products.php",
        data: {
          idSubCategory: subCategory,
          tarea: "subProduct"
        },
        success: function (msg) {
          // $(".productInfo").html(msg);
          init();
        }
      });
    });

    function init() {
      $.ajax({
        type: "POST",
        url: "controllers/select_sales_products_json2.php?idSubCat=" + subCategory,
        success: function (msg) {
          let data = jQuery.parseJSON(msg);
          if (data.error == 0) {
            dataSet = data.dataRes;
            dataTable.clear().rows.add(dataSet).draw();
          }
        }
      });
    }

    $('#loading').hide();

    // Callbacks
    $('#ventas tbody').on('click', 'tr', function () {
      if ($(this).hasClass('selected')) {
        $(this).removeClass('selected');
      } else {
        dataTable.$('tr.selected').removeClass('selected');
        $(this).addClass('selected');
      }
    });

    $('#ventas tbody').on('dblclick', 'tr', function () {
      let data = dataTable.row(this).data();
      $.ajax({
        type: "POST",
        url: "controllers/select_sales_product.php",
        data: {
          idProduct: data[0],
          idStore: <?= $idStore; ?>
        },
        success: function (msg) {
          $(".ticket #dataTicket tbody").append(msg);
          $(".ticket #dataTicket tbody #inputCant").focus();
          $(".ticket #dataTicket tbody #inputCant").select();
          calcTotal();
        }
      });
    });

    // Función para añadir bolsa por defecto
    addBolsa();

    function addBolsa() {
      $.ajax({
        type: "POST",
        url: "controllers/select_sales_product.php",
        data: {
          idProduct: 65,
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

    $("#formTicket").on("change blur click focusout", ".calcChange", calcChange);

    function calcChange() {
      let total = parseFloat($(this).parent().parent().find("#inputTotal").val());
      let dinero = parseFloat($(this).parent().parent().find("#inputRecibido").val()) || 0;
      dinero = dinero.toFixed(2);
      if (dinero < total || isNaN(dinero) || dinero == 0) {
        $(this).parent().parent().find(".enviarTicket").attr("disabled", true);
      } else
        $(this).parent().parent().find(".enviarTicket").removeAttr("disabled");
      let cambio = (dinero != 0) ? dinero - total : 0;
      cambio = cambio.toFixed(2);
      $(this).parent().parent().find("#inputCambio").val(cambio);
      $("#mdlTotal").html( total );
      $("#mdlCambio").html( cambio );
      $("#inpMdlTotal").html( total.toFixed(2) );
      $("#inpMdlEfec").html( dinero );
      $("#inpMdlCambio").html( cambio );
    }

    $("#inputDonacion").click(function () {
      if ($('#inputDonacion').is(':checked')) {
        $("#inputRecibido").attr("disabled", true);
        $("#inputAdmin").attr("readonly", false);
      } else {
        $("#inputRecibido").removeAttr("disabled");
        $("#inputAdmin").attr("readonly", true);
      }
    });

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
      console.log("efectivo");
      let cantEfectivo = $("#inpCantEfectivo").val();
      console.log(cantEfectivo);
      $.ajax({
        type: "POST",
        url: "controllers/create_efectivo.php",
        data: {
          cant: cantEfectivo,
          idStore: <?= $idStore; ?> ,
          idUser : <?= $idUser; ?>
        }, // FIXME: Cambiar id del producto bolsa si cambia la base
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

      let filas = $("#dataTicket tbody").find("tr");
      let i = 0;
      let celda;
      let tableMdlTicket = '';
      for( i = 0; i < filas.length; i++ ){
        celda = $(filas[i]).find("td");
        console.log( $(celda[0]).text() );
        console.log( $(celda[1]).text() );
        console.log( $( $( celda[ 2 ] ).children("input")[0] ).val() );
        console.log( $( $( celda[ 3 ] ).children("input")[0] ).val() );
        tableMdlTicket += '<tr>';
        tableMdlTicket += '<td>' + $(celda[0]).text() + '</td>';
        tableMdlTicket += '<td>' + $(celda[1]).text() + '</td>';
        tableMdlTicket += '<td>' + $( $( celda[ 2 ] ).children("input")[0] ).val() + '</td>';
        tableMdlTicket += '<td>' + $( $( celda[ 3 ] ).children("input")[0] ).val() + '</td>';
        tableMdlTicket += '</tr>';
      }

      $("#tblMdlTicket tbody").html('');
      $("#tblMdlTicket tbody").html( tableMdlTicket );

      //calculamos cambio
      // let total = parseFloat($("#inputTotal").val());
      let dinero = parseFloat($("#inputRecibido").val()) || 0;
      dinero = dinero.toFixed(2);

      if (dinero < total || isNaN(dinero) || dinero == 0) {
        $(this).parent().parent().find(".enviarTicket").attr("disabled", true);
      } else
        $(this).parent().parent().find(".enviarTicket").removeAttr("disabled");

      let cambio = (dinero != 0) ? dinero - total : 0;
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

    $('#imprime').click(function() {
        $("div#myPrintArea").printArea();
    });

    $(".teclado #teclado_numerico_2").on("click", function () {
        actTodo();
        let total = parseFloat($(this).parent().parent().find("#inputTotal").val());
        let dinero = parseFloat($(this).parent().parent().find("#inputRecibido").val()) || 0;
        dinero = dinero.toFixed(2);
        if (dinero < total || isNaN(dinero) || dinero == 0) {
          $(this).parent().parent().find(".enviarTicket").attr("disabled", true);
        } else
          $(this).parent().parent().find(".enviarTicket").removeAttr("disabled");
        let cambio = (dinero != 0) ? dinero - total : 0;
        cambio = cambio.toFixed(2);
        $(this).parent().parent().find("#inputCambio").val(cambio);
        $("#mdlTotal").html( total );
        $("#mdlCambio").html( cambio );
        $("#inpMdlTotal").html( total.toFixed(2) );
        $("#inpMdlEfec").html( dinero );
        $("#inpMdlCambio").html( cambio );
      });

  });
</script>

<script type="text/javascript">
    var input;
    // var banFocusInput=false;
        $("input").on("focus", function () {
         input = $(this);
        //  banFocusInput = false;
         //alert(input.val());
        });
        
        function teclado(numero) {
            if (input != null){
                //alert(input);
                // if(banFocusInput)input.val(numero);
                // else 
                input.val(input.val()+numero);
                //input.val(input.val()+numero);
                
            }
        }

    function borrarTeclado() {
      input.val("");
    }
        
 </script>

<?php
}//fin else sesión
include ('footer.php');
?>