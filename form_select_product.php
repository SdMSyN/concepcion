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
  $userId = $_SESSION['userId'];

  /* Obtenemos los productos */
  $sqlGetProducts = "SELECT id, nombre, (SELECT nombre FROM $tCategory WHERE id=$tProduct.categoria_id) as categoria, precio, img FROM $tProduct ";
  $resGetProducts = $con->query($sqlGetProducts);
  $optProducts = '';
  if ($resGetProducts->num_rows > 0) {
    while ($rowGetProducts = $resGetProducts->fetch_assoc()) {
      $optProducts .= '<tr>';
      $optProducts .= '<td>' . $rowGetProducts['id'] . '</td>';
      $optProducts .= '<td><img src="'.$rutaImgProd.$rowGetProducts['img'].'" width="50px"></td>';
      $optProducts .= '<td>' . $rowGetProducts['nombre'] . '</td>';
      $optProducts .= '<td>' . $rowGetProducts['categoria'] . '</td>';
      $optProducts .= '<td>' . $rowGetProducts['precio'] . '</td>';
      $optProducts .= '<td><a href="form_update_user.php?id=' . $rowGetProducts['id'] . '" >Modificar</a></td>';
      $optProducts .= '<td><a class="delete" data-id="' . $rowGetProducts['id'] . '" >Dar de baja</a></td>';
      $optProducts .= '</tr>';
    }
  } else {
    $optProducts.='<tr><td colspan="7">No existen productos aún.</td></tr>';
  }

  /* Obtenemos las categorias */
  $sqlGetCategories = "SELECT id, nombre FROM $tCategory ";
  $resGetCategories = $con->query($sqlGetCategories);
  $optCategories = '<option></option>';
  while ($rowGetCategories = $resGetCategories->fetch_assoc()) {
    $optCategories .= '<option value="' . $rowGetCategories['id'] . '">' . $rowGetCategories['nombre'] . '</option>';
  }
  ?>

  <!-- Cambio dinamico -->
  <div class="container">
    <div class="row">
      <div class="titulo-crud text-center">
        Productos
      </div>
      <div class="col-md-12">
        <button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModalAdd">
          Nuevo Producto
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
          <form id="formAddProduct" name="formAddProduct" method="POST" >
            <div class="modal-body">
                <input type="hidden" name="userId" value="<?= $userId; ?>" >
              <div class="form-group">
                <label>Nombre</label>
                <input type="text" id="inputNombre" name="inputNombre" class="form-control">
              </div>              
              <div class="form-group">
                <label>Precio</label>
                <input type="number" step="any" id="inputPrecio" name="inputPrecio" class="form-control">
              </div>
              <div class="form-group">
                <label>Imagen (Máximo 1Mb)</label>
                <input type="file" id="inputImg" name="inputImg" class="form-control">
              </div>
              <div class="form-group">
                <label>Descripción</label>
                <input type="text" id="inputDesc" name="inputDesc" class="form-control">
              </div>
              <div class="form-group">
                <label>Pan frío</label>
                <input type="checkbox" id="inputPanFrio" name="inputPanFrio" class="form-control">
              </div>
              <div class="form-group">
                <label>Categoría</label>
                <select id="inputCategoria" name="inputCategoria" class="form-control">
                  <?= $optCategories; ?>
                </select>
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

  <br>
  <table class="table table-striped">
    <thead>
      <tr>
        <td class="t-head-first">Id</td>
        <td class="t-head">Imagen</td>
        <td class="t-head">Nombre</td>
        <td class="t-head">Categoría</td>
        <td class="t-head">Precio</td>
        <td class="t-head">Modificar</td>
        <td class="t-head-last">Eliminar</td>
      </tr>
    </thead>
    <tbody>
      <?= $optProducts; ?>
    </tbody>    
  </table>
  </table>

  </div><!-- fin container -->

  <script type="text/javascript">
    $(document).ready(function () {

      $('.delete').click(function () {
            var idUserDel = $(this).data('id');
            //alert("Eliminando..." + idUserDel);
            if(confirm("Seguro que deseas eliminar?") == true){
                $.ajax({
                    type: 'POST',
                    url: 'controllers/delete_user.php',
                    data: {userDel: idUserDel},
                    success: function(msg){
                        //alert(msg);
                        if (msg == "true") {
                            $('.error').html("Se elimino el usuario con éxito.");
                                setTimeout(function () {
                                  location.href = 'form_select_user.php';
                                }, 3000);
                        } else {
                            $('.error').css({color: "#FF0000"});
                            $('.error').html(msg);
                        }
                    }
		});
            }//end if confirm
        });

      $('#formAddProduct').submit(function (e) {
            var data = new FormData(this); //Creamos los datos a enviar con el formulario
            $.ajax({
                    url: 'controllers/create_product.php', //URL destino
                    data: data,
                    processData: false, //Evitamos que JQuery procese los datos, daría error
                    contentType: false, //No especificamos ningún tipo de dato
                    type: 'POST',
                    beforeSend: function(){
                            //$('#exampleModalLabel').append("Loading...");
                    },
                    success: function (resultado) {
                            //alert(resultado);
                            if(resultado=="true"){
                                    $('#form-content').modal('hide');
                                    location.reload();
                            }else{
                                    $('.error').html(resultado);
                            }
                    }
            });
            e.preventDefault(); //Evitamos que se mande del formulario de forma convencional
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