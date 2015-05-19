<?php
include ('header.php');
?>

<?php
include ('config/conexion.php');
$sqlGetStores = "SELECT id, nombre FROM $tStore ";
$resGetStores = $con->query($sqlGetStores);
$optStores = '<option></option>';
while ($rowGetStores = $resGetStores->fetch_assoc()) {
  $optStores.='<option value="' . $rowGetStores['id'] . '">' . $rowGetStores['nombre'] . '</option>';
}
?>

<script language="javascript">
  function get_loc() {
    if (navigator.geolocation) {
      navigator.geolocation.getCurrentPosition(coordenadas);
    } else {
      alert('Tu navegador no soporta la API de geolocalizacion');
    }
  }

  function coordenadas(position) {
    var lat = position.coords.latitude;
    var lon = position.coords.longitude;
    document.getElementById("inputLat").value = lat;
    document.getElementById("inputLon").value = lon;
  }
</script>

<!-- Cambio dinamico -->
<div class="container" >
  <a href="form_login_admin.php" class="btn btn-primary pull-right " style="margin-top: 1rem;">Administrador</a>
  <div class="row">
    <div class="col-sm-12 col-md-offset-2 col-md-8">
      <div class="titulo text-center">
	<?= $tit; ?>
      </div>
      <form id="formLoginStore" name="formLoginStore" method="POST">
	<div class="error"></div>
	<div class="form-group">
	  <label>Tienda: </label>
	  <select id="inputStoreName" name="inputStoreName" class="form-control">
	    <?= $optStores; ?>
	  </select>
	</div>
	<div class="form-group">
	  <label>Contraseña: </label>
	  <input type="password" name="inputStorePass" id="inputStorePass" class="form-control" />
	</div>
	<input type="text" name="inputLat" id="inputLat" class="hide" />   
	<input type="text" name="inputLon" id="inputLon" class="hide" /> 
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
    $("#inputStoreName").change(function () {
      get_loc();
    });

    $('#formLoginStore').validate({
      rules: {
        inputStoreName: {required: true},
        inputStorePass: {required: true, digits: true}
      },
      messages: {
        inputStoreName: {required: "Debes seleccionar el nombre de la tienda"},
        inputStorePass: {
          required: "Debes introducir una contraseña",
          digits: "Caracter no valido en la contraseña"
        }
      },
      tooltip_options: {
        inputStoreName: {trigger: "focus", placement: 'bottom'},
        inputStorePass: {trigger: "focus", placement: 'bottom'}
      },
      submitHandler: function (form) {
        $.ajax({
          type: "POST",
          url: "controllers/login_store.php",
          data: $('form#formLoginStore').serialize(),
          success: function (msg) {
            //alert(msg);
            if (msg == "true") {
              location.href = "form_login_user.php";
            } else {
              $('.error').html(msg);
            }
          },
          error: function () {
            alert("Error al iniciar sesión de Tienda");
          }
        });
      }
    });
  });
// variable para indicar la pantalla para el teclado numerico
  var input = $('#inputStorePass');
</script>

<?php
include ('footer.php');
?>