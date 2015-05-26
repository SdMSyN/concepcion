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
  // al logear al admin no deberia haber necesidad de identificar una tienda
  //$storeId = $_SESSION['storeId'];
  $categoryId = $_GET['id'];

  $sqlGetCategory = "SELECT nombre FROM $tCategory WHERE id='$categoryId' ";
  $resGetCategory = $con->query($sqlGetCategory);
  $rowGetCategory = $resGetCategory->fetch_assoc();
      
  ?>

  <!-- Cambio dinamico -->
  <div class="container">
    <div class="row">
        <div class="titulo-crud text-center">
            CATEGORIAS
        </div>
        <div class="msg"></div>
        <div class="col-md-12">	
            <form id="formUpdCategory" name="formUpdCategory" method="POST">
  	      <div class="modal-body">
  		<div class="form-group">
  		  <label>Nombre de la Categoría</label>
  		  <input type="text" id="inputCategory" name="inputCategory" class="form-control" value="<?= $rowGetCategory['nombre']; ?>">
  		</div>  
  		<input type="hidden" name="inputCategoryId" value="<?= $categoryId; ?>" >
  	      </div>
  	      <div class="modal-footer">
                  <a href="form_select_category.php" class="btn btn-default">Cerrar</a>
  		<button type="submit" class="btn btn-primary" >Modificar categoría</button>
  	      </div>
  	    </form>
        </div>
    </div>
  </div>

  <script type="text/javascript">
    $(document).ready(function () {
        
      $('#formUpdCategory').validate({
        rules: {
          inputCategory: {required: true}
        },
        messages: {
          inputCategory: "Debes introducir una categoría"
        },
        tooltip_options: {
          inputCategory: {trigger: "focus", placement: 'bottom'}
        },
        submitHandler: function (form) {
          $.ajax({
            type: "POST",
            url: "controllers/update_category.php",
            data: $('form#formUpdCategory').serialize(),
            success: function (msg) {
              //alert(msg);
              if (msg == "true") {
                  $('.msg').css({color: "#009900"});
                $('.msg').html("Se modifico la categoría con éxito.");
                setTimeout(function () {
                  location.href = 'form_select_category.php';
                }, 1500);
              } else {
                $('.msg').css({color: "#FF0000"});
                $('.msg').html(msg);
              }
            },
            error: function () {
              alert("Error al modificar la categoría ");
            }
          });
        }

      });
      
      $('#myModal').on('shown.bs.modal', function () {
        $('#inputCategory').focus()
      })
    });
  </script>

  <?php
}//fin else sesión
include ('footer.php');
?>