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

  /* Obtenemos los usuarios activos */
  $sqlGetUsers = "SELECT id, CONCAT(nombre,' ',ap,' ',am) as nombre, (SELECT perfil FROM $tPerfil WHERE id=$tUser.perfil_id) as perfil, created FROM $tUser WHERE activo='1' ";
  $resGetUsers = $con->query($sqlGetUsers);
  $optUsers = '';
  if ($resGetUsers && $resGetUsers->num_rows > 0) {
    while ($rowGetUsers = $resGetUsers->fetch_assoc()) {
      $optUsers .= '<tr>';
      $optUsers .= '<td>' . $rowGetUsers['id'] . '</td>';
      $optUsers .= '<td>' . $rowGetUsers['nombre'] . '</td>';
      $optUsers .= '<td>' . $rowGetUsers['created'] . '</td>';
      $optUsers .= '<td>' . $rowGetUsers['perfil'] . '</td>';
      $optUsers .= '<td><a href="form_update_user.php?id=' . $rowGetUsers['id'] . '" >Modificar</a></td>';
      $optUsers .= '<td><a class="delete" data-id="' . $rowGetUsers['id'] . '" >Dar de baja</a></td>';
      $optUsers .= '</tr>';
    }
  } else {
    $optUsers.='<tr><td colspan="4">No existen usuarios aún.</td></tr>';
  }

  /* Obtenemos los perfiles */
  $sqlGetPerfils = "SELECT id, perfil FROM $tPerfil ";
  $resGetPerfils = $con->query($sqlGetPerfils);
  $optPerfils = '<option></option>';
  while ($rowGetPerfils = $resGetPerfils->fetch_assoc()) {
    $optPerfils .= '<option value="' . $rowGetPerfils['id'] . '">' . $rowGetPerfils['perfil'] . '</option>';
  }
  ?>

  <!-- Cambio dinamico -->
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModalAdd">
          Nuevo Usuario
        </button>
      </div>	  
    </div>

    <!-- Modal -->
    <div class="modal fade" id="myModalAdd" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="myModalLabel">Nuevo Usuario</h4>
          </div>
          <div class="error"></div>
          <form id="formAddUser" name="formAddUser" method="POST">
            <div class="modal-body">
              <div class="form-group">
                <label>Nombre</label>
                <input type="text" id="inputNombre" name="inputNombre" class="form-control">
              </div>              
              <div class="form-group">
                <label>Apellido Paterno</label>
                <input type="text" id="inputAP" name="inputAP" class="form-control">
              </div>
              <div class="form-group">
                <label>Apellido Materno</label>
                <input type="text" id="inputAM" name="inputAM" class="form-control">
              </div>
              <div class="form-group">
                <label>Usuario</label>
                <input type="text" id="inputUser" name="inputUser" class="form-control">
              </div>
              <div class="form-group">
                <label>Contraseña</label>
                <input type="text" id="inputPass" name="inputPass" class="form-control">
              </div>
              <div class="form-group">
                <label>Perfil</label>
                <select id="inputPerfil" name="inputPerfil" class="form-control">
                  <?= $$optPerfils; ?>
                </select>
              </div>
              <div class="form-group">
                <label>Dirección</label>
                <input type="text" id="inputDir" name="inputDir" class="form-control">
              </div>
              <div class="form-group">
                <label>Número Interior</label>
                <input type="text" id="inputNumInt" name="inputNumInt" class="form-control">
              </div>
              <div class="form-group">
                <label>Número Exterior</label>
                <input type="text" id="inputNumExt" name="inputNumExt" class="form-control">
              </div>
              <div class="form-group">
                <label>Colonia</label>
                <input type="text" id="inputCol" name="inputCol" class="form-control">
              </div>
              <div class="form-group">
                <label>Municipio</label>
                <input type="text" id="inputMun" name="inputMun" class="form-control">
              </div>
              <div class="form-group">
                <label>Teléfono</label>
                <input type="number" id="inputTel" name="inputTel" class="form-control">
              </div>
              <div class="form-group">
                <label>Celular</label>
                <input type="number" id="inputCel" name="inputCel" class="form-control">
              </div>
              <div class="form-group">
                <label>Fecha de nacimiento</label>
                <input type="date" id="inputNacimiento" name="inputNacimiento"  class="form-control">
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                <button type="submit" class="btn btn-primary" >Crear usuario</button>
              </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal Update -->
  <div class="modal fade" id="myModalUpd" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="myModalLabel">Nuevo Usuario</h4>
        </div>
        <div class="modal-body">
          <form id="formAddUser" name="formAddUser" method="POST">
            <input type="text" id="inputUserUpd" name="inputUserUpd">
          </form>
        </div>
      </div>
    </div>
  </div>

  <br>
  <table class="table table-striped">
    <thead>
      <tr>
        <td class="t-head-first">Id</td>
        <td class="t-head">Nombre</td>
        <td class="t-head">Fecha de creación</td>
        <td class="t-head">Perfil</td>
        <td class="t-head">Modificar</td>
        <td class="t-head-last">Eliminar</td>
      </tr>
    </thead>
    <tbody>
      <?= $optUsers; ?>
    </tbody>    
  </table>
  </table>

  </div><!-- fin container -->

  <script type="text/javascript">
    $(document).ready(function () {

      $('.delete').click(function () {
        var idUserDel = $(this).data('id');
        alert("Eliminando..." + idUserDel);
      });

      $('#formAddUser').validate({
        rules: {
          inputNombre: {required: true},
          inputAP: {required: true},
          inputAM: {required: true},
          //inputUser: {required: true},
          inputPass: {required: true, digits: true},
          inputPerfil: {required: true},
          //inputDir: {required: true},
          //inputNumInt: {required: true},
          //inputNumExt: {required: true},
          //inputCol: {required: true},
          //inputMun: {required: true},
          inputTel: {digits: true},
          inputCel: {digits: true}
          //inputNacimiento: {required: true}
        },
        messages: {
          inputNombre: "Nombre obligatorio",
          inputAP: "Apellido paterno obligatorio",
          inputAM: "Apellido materno obligatorio",
          inputPass: {
            required: "Contraseña obligatoria",
            digits: "La contraseña solo permite dígitos"
          },
          inputPerfil: "Debes seleccionar un perfil para el usuario",
          inputTel: "Solo se aceptan dígitos",
          inputCel: "Solo se aceptan dígitos"
        },
        tooltip_options: {
          inputCategory: {trigger: "focus", placement: 'bottom'},
          inputCategory: {trigger: "focus", placement: 'bottom'},
          inputNombre: {trigger: "focus", placement: 'bottom'},
          inputAP: {trigger: "focus", placement: 'bottom'},
          inputAM: {trigger: "focus", placement: 'bottom'},
          inputPass: {trigger: "focus", placement: 'bottom'},
          inputPerfil: {trigger: "focus", placement: 'bottom'},
          inputTel: {trigger: "focus", placement: 'bottom'},
          inputCel: {trigger: "focus", placement: 'bottom'}
        },
        submitHandler: function (form) {
          $.ajax({
            type: "POST",
            url: "controllers/create_user.php",
            data: $('form#formAddUser').serialize(),
            success: function (msg) {
              //alert(msg);
              if (msg == "true") {
                $('.error').html("Se creo el usuario con éxito.");
                setTimeout(function () {
                  location.href = 'form_select_user.php';
                }, 3000);
              } else {
                $('.error').css({color: "#FF0000"});
                $('.error').html(msg);
              }
            },
            error: function () {
              alert("Error al crear usuario ");
            }
          });
        }
      });
      $('#myModalAdd').on('shown.bs.modal', function () {
        $('#inputNombre').focus()
      });
      $('#myModalUpd').on('shown.bs.modal', function () {
        $('#inputNombre').focus()
      });
    });
  </script>

  <?php
}//fin else sesión
include ('footer.php');
?>