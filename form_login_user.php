<?php
session_start();
include('config/conexion.php');
include('header.php');

if (!isset($_SESSION['storeId']))
  echo '<div class="row"><div class="col-sm-12 text-center"><h2>No ha iniciado sesión</h2></div></div>';
else {
  $storeId = $_SESSION['storeId'];
  ?>

  <!-- Cambio dinamico -->
  <div class="container login_user">
    <a href="form_login_store.php" class="btn btn-primary pull-right " style="margin-top: 1rem;">Regresar</a>
    <div class="row">
      <div class="col-sm-12 col-md-offset-2 col-md-8">
        <div class="titulo text-center">
	  <?= $_SESSION['storeName']; ?>
        </div>
        <form id="formLoginUser" name="formLoginUser" method="POST">
	  <div class="error"></div>
	  <div class="form-group">
	    <label>Usuario:</label>
            <input type="password" id="inputPassUser" name="inputPassUser" class="form-control" >
	  </div>
	    <?php include ('teclado_numerico.php'); ?>
	  <div class="numeric-form text-center">
	    <button type="submit" class="btn btn-success">Entrar</button>
	  </div>
        </form>
      </div>	  
    </div>
  </div>

  <script type="text/javascript">
    $(document).ready(function () {

      $("#inputPassUser").focus(); //Enfocamos el cursor al input para la contraseña

      $('#formLoginUser').validate({
        rules: {
          inputPassUser: {required: true, digits: true}
        },
        messages: {
          inputPassUser: {
            required: "Debes introducir una contraseña",
            digits: "Caracter no valido en la contraseña"
          }
        },
        tooltip_options: {
          inputPassUser: {trigger: "focus", placement: 'bottom'}
        },
        submitHandler: function (form) {
          $.ajax({
            type: "POST",
            url: "controllers/login_user.php",
            data: $('form#formLoginUser').serialize(),
            success: function (msg) {
              //alert(msg);
              if (msg == "true") {
                location.href = "form_sales.php";
              } else {
                $('.error').html(msg);
              }
            },
            error: function () {
              alert("Error al iniciar sesión de usuario");
            }
          });
        }

      });
    });
    // variable para indicar la pantalla para el teclado numerico
    var input = $('#inputPassUser');
  </script>
  <?php
}//fin else sesión
include ('footer.php');
?>