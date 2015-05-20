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
  $storeId = $_GET['id'];

  $sqlGetStore = "SELECT * FROM $tStore WHERE id='$storeId' ";
  $resGetStore = $con->query($sqlGetStore);
  $rowGetStore = $resGetStore->fetch_assoc();
  
  
  ?>

  <!-- Cambio dinamico -->
  <div class="container">
    <div class="row">
      <div class="titulo-crud text-center">
        TIENDAS
      </div>
      <div class="col-md-12">	
          <div class="error2"></div>
	  <form id="formUpdStore" name="formUpdStore" method="POST">
                    <input type="hidden" value="<?= $rowGetStore['id']; ?>" name="idStore">
                  <label>Nombre</label>
                  <input type="text" name="inputNombre" id="inputNombre" value="<?= $rowGetStore['nombre']; ?>">
                  <label>Dirección</label>
                  <input type="text" name="inputDir" id="inputDir" value="<?= $rowGetStore['direccion']; ?>" >
                  <label>RFC</label>
                  <input type="text" name="inputRfc" id="inputRfc" value="<?= $rowGetStore['rfc']; ?>" >
                  <label>CP</label>
                  <input type="text" name="inputCp" id="inputCp" value="<?= $rowGetStore['cp']; ?>" >
                  <label>Teléfono</label>
                  <input type="text" name="inputTel" id="inputTel" value="<?= $rowGetStore['tel']; ?>" >
                  <label>Contraseña</label>
                  <input type="text" name="inputPass" id="inputPass" value="<?= $rowGetStore['password']; ?>" >
                  
  		<button type="submit" class="btn btn-primary" >Crear categoría</button>
  	    </form>
    </div>

    <br>
    
  </div>

  <script type="text/javascript">
    $(document).ready(function () {

      $('#formUpdStore').validate({
        rules: {
          inputNombre: {required: true},
          inputDir: {required: true},
          inputRfc: {required: true},
          inputCp: {required: true},
          inputTel: {required: true},
          inputPass: {required: true, digits: true}
        },
        messages: {
          inputNombre: "Nombre de la tienda obligatorio",
          inputDir: "Dirección de la tienda obligatorio",
          inputRfc: "RFC de la tienda obligatorio",
          inputCp: "Código Postal de la tienda obligatorio",
          inputTel: "Teléfono de la tienda obligatorio",
          inputPass: {
              required: "Contraseña para la tienda obligatoria", 
              digits: "La contraseña solo admite números"
          }
        },
        tooltip_options: {
          inputNombre: {trigger: "focus", placement: 'bottom'},
          inputDir: {trigger: "focus", placement: 'bottom'},
          inputRfc: {trigger: "focus", placement: 'bottom'},
          inputCp: {trigger: "focus", placement: 'bottom'},
          inputTel: {trigger: "focus", placement: 'bottom'},
          inputPass: {trigger: "focus", placement: 'bottom'}
        },
        submitHandler: function (form) {
          $.ajax({
            type: "POST",
            url: "controllers/update_store.php",
            data: $('form#formUpdStore').serialize(),
            success: function (msg) {
              alert(msg);
              if (msg == "true") {
                $('.error').html("Se modifico la tienda con éxito.");
                setTimeout(function () {
                  location.href = 'form_select_store.php';
                }, 3000);
              } else {
                $('.error').css({color: "#FF0000"});
                $('.error').html(msg);
              }
            },
            error: function () {
              alert("Error al modificar Tienda ");
            }
          });
        }

      });
      
    });
  </script>

  <?php
}//fin else sesión
include ('footer.php');
?>