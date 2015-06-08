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
  $sqlGetProducts="SELECT id, nombre FROM $tProduct";
  $resGetProducts=$con->query($sqlGetProducts);
  $optProducts='<option></option>';
  if($resGetProducts -> num_rows > 0){
      while($rowGetProducts = $resGetProducts -> fetch_assoc()){
          $optProducts.='<option value="'.$rowGetProducts['id'].'">'.$rowGetProducts['nombre'].'</option>';
      }
  }else{
      $optProducts='<option>No existen productos aún</option>';
  }
  
  /* Obtenemos las tiendas */
  $sqlGetStores="SELECT id, nombre FROM $tStore";
  $resGetStores=$con->query($sqlGetStores);
  $optStores='<option></option>';
  if($resGetStores -> num_rows > 0){
      while($rowGetStores = $resGetStores -> fetch_assoc()){
          $optStores.='<option value="'.$rowGetStores['id'].'">'.$rowGetStores['nombre'].'</option>';
      }
  }else{
      $optStores='<option>No existen tiendas aún</option>';
  }
  ?>

  <!-- Cambio dinamico -->
  <div class="container">
    <div class="row">
      <div class="titulo-crud text-center">
        Almacenes
      </div>
      <div class="col-md-12">
        <button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModalAdd">
          Nuevo Producto en Almacén
        </button>
      </div>	  
    </div>

    <!-- Modal -->
    <div class="modal fade" id="myModalAdd" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="myModalLabel">Añadir Producto en Almacén</h4>
          </div>
          <div class="error"></div>
          <form id="formAddStock" name="formAddStock" method="POST">
            <div class="modal-body">
              <div class="form-group">
                <label>Producto</label>
                <select id="inputProducto" name="inputProducto" class="form-control">
                    <?= $optProducts; ?>
                </select>
              </div>              
              <div class="form-group">
                <label>Cantidad</label>
                <input type="number" id="inputCant" name="inputCant" class="form-control">
              </div>
              <div class="form-group">
                <label>Tienda</label>
                <select id="inputTienda" name="inputTienda" class="form-control">
                    <?= $optStores; ?>
                </select>
              </div>
              
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                <button type="submit" class="btn btn-primary" >Añadir a almacén</button>
              </div>
          </form>
        </div>
      </div>
    </div>
  </div>

    </br>
    <div class="msg"></div>
  <br>
  <table class="table table-striped">
    <thead>
      <tr>
        <td class="t-head-first">Id</td>
        <td class="t-head">Producto</td>
        <td class="t-head">Cantidad</td>
        <td class="t-head">Tienda</td>
        <td class="t-head">Modificar</td>
        <td class="t-head-last">Vaciar</td>
      </tr>
    </thead>
    <tbody>
      <?= $optStocks; ?>
    </tbody>    
  </table>
  </table>

  </div><!-- fin container -->

  <script type="text/javascript">
    $(document).ready(function () {

      $('.delete').click(function () {
            var idStockDel = $(this).data('id');
            //alert("Eliminando..." + idUserDel);
            if(confirm("¿Seguro que desea vaciar?") == true){
                $.ajax({
                    type: 'POST',
                    url: 'controllers/delete_stock.php',
                    data: {stockDel: idStockDel},
                    success: function(msg){
                        //alert(msg);
                        if (msg == "true") {
                            $('.error').css({color: "#77DD77"});
                            $('.msg').html("Se vacio el producto de almacén con éxito.");
                                setTimeout(function () {
                                  location.href = 'form_select_stock.php';
                                }, 2000);
                        } else {
                            $('.error').css({color: "#FF0000"});
                            $('.error').html(msg);
                        }
                    }
		});
            }//end if confirm
        });

        $('#formAddStock').validate({
            rules: {
                inputProducto: {required: true},
                inputCant: {required: true, digits: true},
                inputTienda: {required: true}
            },
            messages: {
                inputProducto: "Producto obligatorio",
                inputCant: {
                    required: "Cantidad obligatoria",
                    digits: "La cantidad solo permite dígitos"
                },
                inputTienda: "Tienda obligatoria"
            },
            tooltip_options: {
                inputProducto: {trigger: "focus", placement: 'bottom'},
                inputCant: {trigger: "focus", placement: 'bottom'},
                inputTienda: {trigger: "focus", placement: 'bottom'}
            },
            submitHandler: function (form) {
                $.ajax({
                    type: "POST",
                    url: "controllers/create_stock.php",
                    data: $('form#formAddStock').serialize(),
                    success: function (msg) {
                        //alert(msg);
                        if (msg == "true") {
                            $('.error').css({color: "#77DD77"});
                            $('.error').html("Se creo el producto en almacén con éxito.");
                            setTimeout(function () {
                                location.href = 'form_select_stock.php';
                            }, 3000);
                        } else {
                            $('.error').css({color: "#FF0000"});
                            $('.error').html(msg);
                        }
                    },
                    error: function () {
                        alert("Error al crear producto en almacén ");
                    }
                });
            }
        });
        
      $('#myModalAdd').on('shown.bs.modal', function () {
        $('#inputProducto').focus()
      });
    });
  </script>

  <?php
}//fin else sesión
include ('footer.php');
?>