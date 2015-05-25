<?php
session_start();
include('config/conexion.php');
include('config/variables.php');
include('header.php');
include ('menu.php');
if (!isset($_SESSION['sessA']))
  echo '<div class="row"><div class="col-sm-12 text-center"><h2>No ha iniciado sesión de Administrador</h2></div></div>';
else if ($_SESSION['perfil'] != "1")
  echo '<div class="row><div class="col-sm-12 text-center"><h2>No tienes permiso para entrar a esta sección</h2></div></div>';
else {
  $productId = $_GET['id'];
  $userId = $_SESSION['userId'];

  /* obtenemos el producto */
  $sqlGetProduct = "SELECT * FROM $tProduct WHERE id='$productId' ";
  $resGetProduct = $con->query($sqlGetProduct);
  $rowGetProduct = $resGetProduct->fetch_assoc();

  /* Obtenemos las categorias */
  $sqlGetCategories = "SELECT id, nombre FROM $tCategory ";
  $resGetCategories = $con->query($sqlGetCategories);
  $optCategories = '<option></option>';
  while ($rowGetCategories = $resGetCategories->fetch_assoc()) {
    if ($rowGetCategories['id'] == $rowGetProduct['categoria_id'])
      $optCategories .= '<option value="' . $rowGetCategories['id'] . '" selected>' . $rowGetCategories['nombre'] . '</option>';
    else
      $optCategories .= '<option value="' . $rowGetCategories['id'] . '">' . $rowGetCategories['nombre'] . '</option>';
  }

  /* Comprobamos si es pan frio */
  $optPanFrio = '';
  if ($rowGetProduct['pan_frio'] == '0')
    $optPanFrio.='<input type="checkbox" id="inputPanFrio" name="inputPanFrio" >';
  else
    $optPanFrio.='<input type="checkbox" id="inputPanFrio" name="inputPanFrio" checked>';
  ?>

  <!-- Cambio dinamico -->
  <div class="container">
    <div class="row">
      <form role="form" id="formUpdProduct" name="formUpdProduct" method="POST" >
        <legend>Modificación de datos de: <?= $rowGetProduct['nombre']; ?></legend>
        <div class="error"></div>
        <input type="hidden" name="productId" value="<?= $productId; ?>" >
        <input type="hidden" name="userId" value="<?= $userId; ?>" >
        <div class="form-group">
          <label>Nombre</label>
          <input type="text" id="inputNombre" name="inputNombre" class="form-control" value="<?= $rowGetProduct['nombre']; ?>">
        </div>              
        <div class="form-group">
          <label>Precio</label>
          <input type="text" step="any" id="inputPrecio" name="inputPrecio" class="form-control" value="<?= $rowGetProduct['precio']; ?>">
        </div>
        <div class="form-group">           
          <label for="exampleInputFile">Imagen</label>
          <input type="file" id="inputImg" name="inputImg" >
          <p class="help-block">Tamaño Máximo 1Mb</p>
        </div>
        <div class="form-group">
          <label>Descripción</label>
          <input type="text" id="inputDesc" name="inputDesc" class="form-control" value="<?= $rowGetProduct['descripcion']; ?>">
        </div>
        <div class="form-group">
          <label>Categoría</label>
          <select id="inputCategoria" name="inputCategoria" class="form-control" value="<?= $rowGetProduct['categoria_id']; ?>">
            <?= $optCategories; ?>
          </select>
        </div>
        <div class="checkbox">
          <label>
            <?= $optPanFrio; ?> Pan frío
          </label>
        </div>
        <a href="form_select_product.php" class="btn btn-default"><i class="fa fa-mail-reply"></i> Atras</a>
        <button type="submit" class="btn btn-primary" >Modificar producto</button>
      </form>

    </div>

  </div><!-- fin container -->

  <script type="text/javascript">
    $(document).ready(function () {

      $('#formUpdProduct').submit(function (e) {
        if ($("#inputNombre").val() == "") {
          //alert("No puede ser vacio");
          $("#inputNombre").tooltip({title: "Nombre del producto obligatorio", trigger: "focus", placement: 'bottom'});
          $("#inputNombre").tooltip('show');
          return false;
        }
        if ($("#inputPrecio").val() == "") {
          //alert("No puede ser vacio");
          $("#inputPrecio").tooltip({title: "Precio del producto obligatorio", trigger: "focus", placement: 'bottom'});
          $("#inputPrecio").tooltip('show');
          return false;
        }
        if (!$("#inputPrecio").val().match(/^-?[0-9]+([\.][0-9]*)?$/)) {
          // inputted file path is not an image of one of the above types
          $("#inputPrecio").tooltip({title: "Formato de precio incorrecto", trigger: "focus", placement: 'bottom'});
          $("#inputPrecio").tooltip('show');
          return false;
        }
        if ($("#inputDesc").val() == "") {
          //alert("No puede ser vacio");
          $("#inputDesc").tooltip({title: "Descripción obligatoria", trigger: "focus", placement: 'bottom'});
          $("#inputDesc").tooltip('show');
          return false;
        }
        if ($("#inputCategoria").val() == "") {
          //alert("No puede ser vacio");
          $("#inputCategoria").tooltip({title: "Debes de seleccionar una categoría", trigger: "focus", placement: 'bottom'});
          $("#inputCategoria").tooltip('show');
          return false;
        }
        var data = new FormData(this); //Creamos los datos a enviar con el formulario
        $.ajax({
          url: 'controllers/update_product.php', //URL destino
          data: data,
          processData: false, //Evitamos que JQuery procese los datos, daría error
          contentType: false, //No especificamos ningún tipo de dato
          type: 'POST',
          beforeSend: function () {
            //$('#exampleModalLabel').append("Loading...");
          },
          success: function (resultado) {
            //alert(resultado);
            if (resultado == "true") {
              $('.error').html("Se modifico el producto con éxito.");
              setTimeout(function () {
                location.href = 'form_select_product.php';
              }, 3000);
            } else {
              $('.error').html(resultado);
            }
          }
        });
        e.preventDefault(); //Evitamos que se mande del formulario de forma convencional
      });

    });
  </script>

  <?php
}//fin else sesión
include ('footer.php');
?>