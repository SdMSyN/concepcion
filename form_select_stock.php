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

  /* Obtenemos los productos disponibles */
  $sqlGetStocks = "SELECT id, (SELECT nombre FROM $tProduct WHERE id=$tStock.producto_id) as producto, cantidad, ( SELECT nombre FROM $tStore WHERE id=$tStock.tienda_id) as tienda FROM $tStock ";
  $resGetStocks = $con->query($sqlGetStocks);
  $optStocks = '';
  if ($resGetStocks && $resGetStocks->num_rows > 0) {
    while ($rowGetStocks = $resGetStocks->fetch_assoc()) {
      $optStocks .= '<tr>';
      $optStocks .= '<td>' . $rowGetStocks['id'] . '</td>';
      $optStocks .= '<td>' . $rowGetStocks['producto'] . '</td>';
      $optStocks .= '<td>' . $rowGetStocks['cantidad'] . '</td>';
      $optStocks .= '<td>' . $rowGetStocks['tienda'] . '</td>';
      $optStocks .= '<td><a href="form_update_stock.php?id=' . $rowGetStocks['id'] . '" >Modificar</a></td>';
      $optStocks .= '<td><a class="delete" data-id="' . $rowGetStocks['id'] . '" >Vaciar</a></td>';
      $optStocks .= '</tr>';
    }
  } else {
    $optStocks.='<tr><td colspan="6">No existen productos en almacen aún.</td></tr>';
  }

  /* Obtenemos los productos */
  $sqlGetProducts = "SELECT id, nombre FROM $tProduct WHERE activo='1' ";
  $resGetProducts = $con->query($sqlGetProducts);
  $optProducts = '<option></option>';
  if ($resGetProducts->num_rows > 0) {
    while ($rowGetProducts = $resGetProducts->fetch_assoc()) {
      $optProducts.='<option value="' . $rowGetProducts['id'] . '">' . $rowGetProducts['nombre'] . '</option>';
    }
  } else {
    $optProducts = '<option>No existen productos aún</option>';
  }

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
      <div class="titulo-crud text-center">ALMACENES</div>  
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
        <div class="col-md-9 text-center" id="stockName"></div>
        <div class="col-md-3 buttonProduct"></div>
      </div>
      <div class="msg"></div>
      <div class="col-md-12">
        <form id="formSave" name="formSave" method="POST">
          <table class="table table-striped">
            <thead>
              <tr>
                <!--<td>Id</td>-->
                <td>Producto</td>
                <td>Categoría</td>
                <td>Cantidad</td>
                <td>Sumar/Restar</td>
              </tr>
            </thead>
            <tbody id="tableStockStore">
            </tbody>
          </table>
            <input type="hidden" name="inputUser" value="<?= $userId; ?>" > 
          <div id="saveButton"></div>
        </form>
      </div>
    </div>
  </div><!-- fin container -->
  <!-- Modal -->
  <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="myModalLabel">Agregar producto</h4>
        </div>
        <div class="error"></div>
        <form id="formAddProductStock" name="formAddProductStock" method="POST">
          <div class="modal-body">
            <div class="form-group">
              <label>Producto:</label>
              <select name="inputProduct" id="inputProduct" class="form-control">
                <?= $optProducts; ?>
              </select>
            </div>  
            <input type="text" name="inputCampo" id="inputCampo" class="hidden">
            <input type="text" name="inputUser" id="inputUser" class="hidden" value="<?= $userId; ?>">
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            <button type="submit" class="btn btn-primary" >Agregar producto</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <script type="text/javascript">
    $(document).ready(function () {
      $('#inputStore').focus();
      $('#inputStore').change(function () {
        var selectStore = $('#inputStore').val();
        //alert(selectStore);
        $('body').removeClass('loaded');
        $.ajax({
          type: 'POST',
          url: 'controllers/select_stock_store.php',
          data: {storeId: selectStore},
          success: function (msg) {
            //alert(msg);
            if (msg == "false") {
              $('#tableStockStore').html('<tr><td colspan="4">No existen productos en éste almacén</td></tr>');
            } else {
              $('#tableStockStore').html(msg);
            }
          $('body').addClass('loaded');
          }
        });//end ajax
        if (selectStore == "") {
          $('.buttonProduct').empty();
        } else {
          $('.buttonProduct').html('<button type="button" class="btn btn-primary" data-whatever="' + selectStore + '" data-toggle="modal" data-target="#myModal" id="buttonAddProduct">Añadir producto</button>');
          $('#saveButton').html('<button type="submit" class="btn btn-primary" >Guardar</button>');
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

      $('#myModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget)
        var recipient = button.data('whatever')
        var modal = $(this)
        modal.find('.modal-body #inputCampo').val(recipient)
      });

      $('#formAddProductStock').validate({
        rules: {
          inputProduct: {required: true}
        },
        messages: {
          inputProduct: "Nombre del producto obligatorio"
        },
        tooltip_options: {
          inputProduct: {trigger: "focus", placement: 'bottom'}
        },
        submitHandler: function (form) {
          $.ajax({
            type: "POST",
            url: "controllers/create_stock.php",
            data: $('form#formAddProductStock').serialize(),
            success: function (msg) {
              var selectStore = $('#inputCampo').val();
              //alert(msg);
              if (msg == "true") {
                $('.error').css({color: "#009900"});
                $('.error').html("Se añadio el producto con éxito.");
                setTimeout(function () {
                  pintarTabla(selectStore)
                }, 500);
              } else {
                $('.error').css({color: "#FF0000"});
                $('.error').html(msg);
              }
            },
            error: function () {
              alert("Error al añadir producto ");
            }
          });
        }

      });

      function pintarTabla(tienda) {
        var selectStore = tienda;
        //alert(selectStore);
        $.ajax({
          type: 'POST',
          url: 'controllers/select_stock_store.php',
          data: {storeId: selectStore},
          success: function (msg) {
            //alert(msg);
            if (msg == "false") {
              $('#myModal .error').css({color: "#FF0000"});
              $('#myModal .error').html('Error al añadir producto a almacén');
            } else {
              $('#myModal').modal('hide');
              $('#tableStockStore').html(msg);
            }
          }
        });//end ajax
      }
      function pintarTabla2(tienda) {
        //alert("tienda");
        var selectStore = tienda;
        $.ajax({
          type: 'POST',
          url: 'controllers/select_stock_store.php',
          data: {storeId: selectStore},
          success: function (msg) {
            if (msg == "false") {
              $('.error').css({color: "#FF0000"});
              $('.error').html('Error al añadir producto a almacén');
            } else {
              $('#tableStockStore').html(msg);
            }
            $('body').addClass('loaded');
          }
        });//end ajax
      }

      $('#formSave').submit(function (event) {
        var selectStore = $('#tienda').val();
        var timeM = 6000;
        //alert(selectStore);
        $('body').removeClass('loaded');
        $.ajax({
          type: "POST",
          url: "controllers/update_stock.php",
          data: $('form#formSave').serialize(),
          success: function (msg) {
            //alert(msg);
            if (msg == "true") {
              $('.msg').css({color: "#009900"});
              $('.msg').html("Se modifico el almacen con éxito");
              pintarTabla2(selectStore);
              alert("Se modifico el almacen con éxito");
              setTimeout(function () {
                  $('.msg').empty();
              },timeM);              
            } else {
              $('.msg').css({color: "#FF0000"});
              $('.msg').html(msg);
              $('body').addClass('loaded');
              alert("error al intentar modificar el almacen");
              setTimeout(function () {
                  $('.msg').empty();
              },timeM);
            }
          },
          error: function () {
            alert("Error al añadir producto ");
          }
        });
        event.preventDefault();
      });
      
      $('#myModal').on('shown.bs.modal', function () {
        $('#inputProduct').focus()
      })
    });
  </script>

  <?php
}//fin else sesión
include ('footer.php');
?>