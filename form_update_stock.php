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
  $stockId = $_GET['id'];

  /* Obtenemos el producto */
  $sqlGetStock = "SELECT * FROM $tStock WHERE id='$stockId' ";
  $resGetStock = $con->query($sqlGetStock);
  $rowGetStock = $resGetStock->fetch_assoc();

  /* Obtenemos los productos */
  $sqlGetProducts="SELECT id, nombre FROM $tProduct";
  $resGetProducts=$con->query($sqlGetProducts);
  $optProducts='<option></option>';
  if($resGetProducts -> num_rows > 0){
      while($rowGetProducts = $resGetProducts -> fetch_assoc()){
            if($rowGetProducts['id'] == $rowGetStock['producto_id'])
                $optProducts.='<option value="'.$rowGetProducts['id'].'" selected>'.$rowGetProducts['nombre'].'</option>';
            else
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
            if($rowGetStores['id'] == $rowGetStock['tienda_id'])
                $optStores.='<option value="'.$rowGetStores['id'].'" selected>'.$rowGetStores['nombre'].'</option>';
            else
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
    </div>

      <div class="msg"></div>
      <form id="formUpdStock" name="formUpdStock" method="POST">
            <div class="modal-body">
              <div class="form-group">
                  <input type="hidden" value="<?= $rowGetStock['id']; ?>" name="inputIdStock" >
                <label>Producto</label>
                <select id="inputProducto" name="inputProducto" class="form-control">
                    <?= $optProducts; ?>
                </select>
              </div>              
              <div class="form-group">
                <label>Cantidad</label>
                <input type="number" id="inputCant" name="inputCant" class="form-control" value="<?= $rowGetStock['cantidad']; ?>">
              </div>
              <div class="form-group">
                <label>Tienda</label>
                <select id="inputTienda" name="inputTienda" class="form-control">
                    <?= $optStores; ?>
                </select>
              </div>
              
              <div class="modal-footer">
                <a href="form_select_stock.php" class="btn btn-default" >Cerrar</a>
                <button type="submit" class="btn btn-primary" >Actualizar</button>
              </div>
          </form>

  </div><!-- fin container -->

  <script type="text/javascript">
    $(document).ready(function () {

        $('#formUpdStock').validate({
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
                    url: "controllers/update_stock.php",
                    data: $('form#formUpdStock').serialize(),
                    success: function (msg) {
                        //alert(msg);
                        if (msg == "true") {
                            $('.msg').css({color: "#00FF00"});
                            $('.msg').html("Se actualizo el producto en almacén con éxito.");
                            setTimeout(function () {
                                location.href = 'form_select_stock.php';
                            }, 1500);
                        } else {
                            $('.msg').css({color: "#FF0000"});
                            $('.msg').html(msg);
                        }
                    },
                    error: function () {
                        alert("Error al modificar producto en almacén ");
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