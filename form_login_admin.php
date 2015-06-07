<?php
session_start();
include('config/conexion.php');
include('header.php');
?>

<!-- Cambio dinamico -->
<div class="container">
  <a href="form_login_store.php" class="btn btn-primary pull-right " style="margin-top: 1rem;">Regresar</a>
  <div class="row">
    <div class="col-sm-12 col-md-offset-2 col-md-8">
      <div class="titulo text-center">
	<?= $tit; ?>
      </div>
      <form id="formLoginAdmin" name="formLoginAdmin" method="POST">
	<div class="error"></div>
	<legend>Administración</legend>
	<div class="form-group">
	  <label>Administrador</label>
	  <input type="text" id="inputAdmin" name="inputAdmin" class="form-control">
	</div>
	<div class="form-group">
	  <label>Contraseña: </label>
	  <input type="password" name="inputPassAdmin" id="inputPassAdmin" class="form-control" />
	</div>
	<?php include ('teclado_numerico.php'); ?>
	<div class="numeric-form text-center">
	  <button type="submit" class="btn btn-success">Iniciar Sesión</button>
	</div>
      </form>
    </div>	  
  </div>
</div>

<script type="text/javascript">
  $(document).ready(function () {

    $("#inputAdmin").focus(); //Enfocamos el cursor al input para la contraseña

    $('#formLoginAdmin').validate({
      rules: {
        inputAdmin: {required: true},
        inputPassAdmin: {required: true, digits: true}
      },
      messages: {
        inputAdmin: "Debes introducir un usuario",
        inputPassAdmin: {
            required: "Debes introducir una contraseña",
            digits: "Caracter invalido "
        }
      },
      tooltip_options: {
        inputAdmin: {trigger: "focus", placement: 'bottom'},
        inputPassAdmin: {trigger: "focus", placement: 'bottom'}
      },
      submitHandler: function (form) {
        $.ajax({
          type: "POST",
          url: "controllers/login_admin.php",
          data: $('form#formLoginAdmin').serialize(),
          success: function (msg) {
            //alert(msg);
            if (msg == "true") {
              location.href = "index_admin.php";
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
  var input = $('#inputPassAdmin');
</script>

<?php
include ('footer.php');
?>