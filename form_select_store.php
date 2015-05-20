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

  $sqlGetStore = "SELECT * FROM $tStore ";
  $resGetStore = $con->query($sqlGetStore);
  $optStore = '';
  if ($resGetStore->num_rows > 0) {
    while ($rowGetStore = $resGetStore->fetch_assoc()) {
      $optStore .= '<tr>';
      $optStore .= '<td>' . $rowGetStore['id'] . '</td>';
      $optStore .= '<td>' . $rowGetStore['nombre'] . '</td>';
      $optStore .= '<td>' . $rowGetStore['direccion'] . '</td>';
      $optStore .= '<td>' . $rowGetStore['created'] . '</td>';
      $optStore .= '<td><a href="https://www.google.com.mx/maps/@'.$rowGetStore['latitud'].','.$rowGetStore['longitud'].',15z" target="_about">Ver</a></td>';
      $optStore .= '<td><a href="form_update_store.php?id=' . $rowGetStore['id'] . '" >Modificar</a></td>';
      $optStore .= '<td><a class="delete" data-id="' . $rowGetStore['id'] . '" >Dar de baja</a></td>';
      $optStore .= '</tr>';
    }
  } else {
    $optCategory.='<tr><td colspan="4">No existen categorías aún.</td></tr>';
  }
  ?>

  <!-- Cambio dinamico -->
  <div class="container">
    <div class="row">
      <div class="titulo-crud text-center">
        TIENDAS
      </div>
      <div class="col-md-12">	
        <button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal">
          Nueva Tienda
        </button>
        <!-- Modal -->
        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  	<div class="modal-dialog">
  	  <div class="modal-content">
  	    <div class="modal-header">
  	      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  	      <h4 class="modal-title" id="myModalLabel">Nueva Categoría</h4>
  	    </div>
            <div class="error"></div>
  	    <form id="formAddStore" name="formAddStore" method="POST">
  	      <div class="modal-body">
                  <label>Nombre</label>
                  <input type="text" name="inputNombre" id="inputNombre" >
                  <label>Dirección</label>
                  <input type="text" name="inputDir" id="inputDir" >
                  <label>RFC</label>
                  <input type="text" name="inputRfc" id="inputRfc" >
                  <label>CP</label>
                  <input type="text" name="inputCp" id="inputCp" >
                  <label>Teléfono</label>
                  <input type="text" name="inputTel" id="inputTel" >
                  <label>Contraseña</label>
                  <input type="text" name="inputPass" id="inputPass" >
                  <input type="text" name="inputLat" id="inputLat" class="hidden" />   
                  <input type="text" name="inputLon" id="inputLon" class="hidden" />
  	      </div>
  	      <div class="modal-footer">
  		<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
  		<button type="submit" class="btn btn-primary" >Crear categoría</button>
  	      </div>
  	    </form>
  	  </div>
  	</div>
        </div>
      </div>	  
    </div>

    <br>
    <div class="error2"></div>
    <table class="table table-striped">
      <thead>
        <tr>
  	<td class="t-head-first">Id</td>
  	<td class="t-head">Nombre</td>
  	<td class="t-head">Dirección</td>
  	<td class="t-head">Fecha de creación</td>
  	<td class="t-head">Ver en el mapa</td>
  	<td class="t-head">Modificar</td>
  	<td class="t-head">Eliminar</td>
        </tr>
      </thead>
      <tbody>
	<?= $optStore; ?>
      </tbody>    
    </table>
  </div>

  <script type="text/javascript">
    $(document).ready(function () {

        $('.delete').click(function () {
            var idStoreDel = $(this).data('id');
            //alert("Eliminando..." + idUserDel);
            if(confirm("¿Seguro que deseas eliminar?") == true){
                $.ajax({
                    type: 'POST',
                    url: 'controllers/delete_store.php',
                    data: {storeDel: idStoreDel},
                    success: function(msg){
                        //alert(msg);
                        if (msg == "true") {
                            $('.error2').html("Se elimino la tienda con éxito.");
                                setTimeout(function () {
                                  location.href = 'form_select_store.php';
                                }, 3000);
                        } else {
                            $('.error2').css({color: "#FF0000"});
                            $('.error2').html(msg);
                        }
                    }
		});
            }//end if confirm
        });
        
      $('#formAddStore').validate({
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
            url: "controllers/create_store.php",
            data: $('form#formAddStore').serialize(),
            success: function (msg) {
              //alert(msg);
              if (msg == "true") {
                $('.error').html("Se creo la tienda con éxito.");
                setTimeout(function () {
                  location.href = 'form_select_store.php';
                }, 3000);
              } else {
                $('.error').css({color: "#FF0000"});
                $('.error').html(msg);
              }
            },
            error: function () {
              alert("Error al crear Tienda ");
            }
          });
        }

      });
      
      $('#myModal').on('shown.bs.modal', function () {
        $('#inputCategory').focus();
        get_loc();
      })
    });
  </script>

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

  <?php
}//fin else sesión
include ('footer.php');
?>