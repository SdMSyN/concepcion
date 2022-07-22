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
  $subCategoryId = $_GET['id'];
  $userId = $_SESSION['userId'];
  include('config/variables.php');
  $sqlGetSubCategory = "SELECT * FROM $tSubCategory WHERE id='$subCategoryId' ";
  $resGetSubCategory = $con->query($sqlGetSubCategory);
  $rowGetSubCategory = $resGetSubCategory->fetch_assoc();
  
  /* Obtenemos las categorías */
  $sqlGetCategories="SELECT id, nombre FROM $tCategory WHERE activo='1' ";
    $resGetCategories=$con->query($sqlGetCategories);
    $optCategories='<option></option>';
    while($rowGetCategories = $resGetCategories->fetch_assoc()){
        if($rowGetCategories['id'] == $rowGetSubCategory['categoria_id'])
            $optCategories .= '<option value="'.$rowGetCategories['id'].'" selected>'.$rowGetCategories['nombre'].'</option>';
        else
            $optCategories .= '<option value="'.$rowGetCategories['id'].'" >'.$rowGetCategories['nombre'].'</option>';
    }
    
  ?>

  <!-- Cambio dinamico -->
  <div class="container">
    <div class="row">
      <div class="titulo-crud text-center">
        SUBCATEGORIAS
      </div>
      <div class="msg"></div>
      <div class="col-md-12">
          <legend>Modificación de datos de Subcategoria</legend>       
            <div class="error"></div>
        <form id="formUpdSubCategory" name="formUpdSubCategory" method="POST" class="form-horizontal"  enctype="multipart/form-data">
            <input type="hidden" name="inputSubCategoryId" value="<?= $subCategoryId; ?>" >
            <input type="hidden" name="inputUser" value="<?= $userId; ?>" >
            <div class="form-group">
              <label class="col-sm-2 control-label">Categoría Superior</label>
              <div class="col-sm-10">
                  <select id="inputCategory" name="inputCategory" class="form-control">
                      <?= $optCategories; ?>
                  </select>
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-2 control-label">Nombre de la Categoría</label>
              <div class="col-sm-10">
                <input type="text" id="inputSubCategory" name="inputSubCategory" class="form-control" value="<?= $rowGetSubCategory['nombre']; ?>">
              </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2">Imagen de la subcategoría</label>
                <div class="col-sm-10">
                    <img src="<?=$rutaImgSubCat.$rowGetSubCategory['img'];?>" width="20%">
                    <input type="file" id="inputImg" name="inputImg" >
                    <p class="help-block">Tamaño Máximo 1Mb</p>
                </div>
            </div>
            <div class="form-group">
              <div class="col-sm-offset-0 col-sm-12">
                <a href="form_select_category.php" class="btn btn-default"><i class="fa fa-mail-reply"></i> Atras</a>
                <button type="submit" class="btn btn-primary" >Guardar cambios</button>
              </div>
            </div>
          </form>
      </div>
    </div>
  </div>

  <script type="text/javascript">
    $(document).ready(function () {

      $('#formUpdSubCategory').validate({
        rules: {
          inputCategory: {required: true},
          inputSubCategory: {required: true},
          inputImg: {extension: "jpg|png|bmp|jpeg|gif"}
        },
        messages: {
          inputCategory: "Debes introducir una categoría",
          inputSubCategory: "Debes introducir una categoría",
          inputImg: "Formato de imagen no valido"
        },
        tooltip_options: {
          inputCategory: {trigger: "focus", placement: 'bottom'},
          inputSubCategory: {trigger: "focus", placement: 'bottom'},
          inputImg: {trigger: "focus", placement: 'bottom'}
        },
        submitHandler: function (form) {
          $.ajax({
            type: "POST",
            url: "controllers/update_subcategory.php",
            //data: $('form#formUpdSubCategory').serialize(),
            data: new FormData($("form#formUpdSubCategory")[0]),
            contentType: false,
            processData: false,
            success: function (msg) {
              //alert(msg);
              if (msg == "true") {
                $('.msg').css({color: "#009900"});
                $('.msg').html("Se modifico la Subcategoría con éxito.");
                setTimeout(function () {
                  location.href = 'form_select_subcategory.php';
                }, 1500);
              } else {
                $('.msg').css({color: "#FF0000"});
                $('.msg').html(msg);
              }
            },
            error: function () {
              alert("Error al modificar la Subcategoría ");
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