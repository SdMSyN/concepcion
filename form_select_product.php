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

  /* Obtenemos las categorias */
  $sqlGetCategories = "SELECT id, nombre FROM $tCategory ";
  $resGetCategories = $con->query($sqlGetCategories);
  $optCategories = '<option></option>';
  while ($rowGetCategories = $resGetCategories->fetch_assoc()) {
    $optCategories .= '<option value="' . $rowGetCategories['id'] . '">' . $rowGetCategories['nombre'] . '</option>';
  }
  ?>

    <div class="row">
        <div id="loading">
            <img src="../assets/img/loading.gif" height="300" width="400">
        </div>
    </div>

  <!-- Cambio dinamico -->
  <div class="container">
    <div class="row">
      <div class="titulo-crud text-center">
        PRODUCTOS 
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
            <h4 class="modal-title" id="myModalLabel">Nuevo Producto</h4>
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
                <label>Código de barras</label>
                <input type="number" id="inputCB" name="inputCB" class="form-control">
              </div>
              <!-- <div class="form-group">           
                <label for="exampleInputFile">Imagen</label>
                <input type="file" id="inputImg" name="inputImg" >
                <p class="help-block">Tamaño Máximo 1Mb</p>
              </div>
              <div class="form-group">
                <label>Descripción</label>
                <input type="text" id="inputDesc" name="inputDesc" class="form-control">
              </div> -->
              <div class="form-group">
                <label>Categoría</label>
                <select id="inputCategoria" name="inputCategoria" class="form-control">
                  <?= $optCategories; ?>
                </select>
              </div>
              <div class="form-group">
                <label>Subcategoría</label>
                <select id="inputSubCategoria" name="inputSubCategoria" class="form-control"></select>
              </div>
              <!--
              <div class="form-group">
                <label>
                  <input type="checkbox" id="inputPanFrio" name="inputPanFrio" >Pan frío
                </label>
              </div>
              -->
              <input type="hidden" id="inputPanFrio" name="inputPanFrio" >
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                <button type="submit" class="btn btn-primary" >Crear producto</button>
              </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <br>
    <!-- datatable -->
    <table id="productos" class="display cell-border " style="width:100%">
      <thead>
        <tr>
          <th>ID</th>
          <th>Categoría</th>
          <th>Subcategoría</th>
          <th>Producto</th>
          <th>Precio</th>
          <th>Modificar</th>
          <th>Alta/baja</th>
        </tr>
      </thead>
    </table>

  </div><!-- fin container -->

  <script type="text/javascript">
    var ordenar = '';
    $('#loading').hide();
    $(document).ready(function () {

        //Funcion para llenar la DataTable haciendo solo una peticion a la base de datos
        var dataTable = $('#productos').DataTable({
            "language":	{
                "sProcessing":     "Procesando...",
                "sZeroRecords":    "No se encontraron resultados",
                "sEmptyTable":     "Ningún dato disponible en esta tabla",
                "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
                "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
                "sInfoPostFix":    "",
                "sSearch":         "Buscar:",
                "sUrl":            "",
                "sInfoThousands":  ",",
                "sLoadingRecords": "Cargando...",
                "oPaginate": {
                    "sFirst":    "Primero",
                    "sLast":     "Último",
                    "sNext":     "Siguiente",
                    "sPrevious": "Anterior"
                },
            },
            "responsive" : true,
            "processing" : true,
            "serverSide" : true,
            "ajax"       : {
                url  : "controllers/select_product.php",
                type : "post",
            },
            error : function() {
                $("#ventas-error").html("");
                $("#ventas").append('<tbody class="employee-grid-error"><tr><th colspan="3">No hay información en la baser</th></tr></tbody>');
                $("#ventas_processing").css("display", "none");
            }
        });

        
      $("#productos").on("click", ".delete", function(){
        var idProductDel = $(this).data('id');
        //alert("Eliminando..." + idUserDel);
        if (confirm("¿Está seguro(a) que desea dar de baja este registro?") == true) {
          $.ajax({
            type: 'POST',
            url: 'controllers/delete_product.php',
            data: {productDel: idProductDel, est: 1},
            success: function (msg) {
              if (msg == "true") {
                $('.error').css({color: "#77DD77"});
                alert("Se dio de baja el producto con éxito.");
                setTimeout(function () {
                  location.href = 'form_select_product.php';
                }, 2000);
              } else {
                $('.error').css({color: "#FF0000"});
                $('.error').html(msg);
              }
            }
          });
        }//end if confirm
      });

      $("#productos").on("click", ".activate", function(){
        var idProductDel = $(this).data('id');
        if (confirm("¿Está seguro(a) que desea dar de alta el registro?") == true) {
          $.ajax({
            type: 'POST',
            url: 'controllers/delete_product.php',
            data: {productDel: idProductDel, est: 0},
            success: function (msg) {
              if (msg == "true") {
                alert("Se activo el producto con éxito.");
                setTimeout(function () {
                  location.href = 'form_select_product.php';
                }, 2000);
              } else {
                $('.error').css({color: "#FF0000"});
                $('.error').html(msg);
              }
            }
          });
        }//end if confirm
      });

      $('#formAddProduct').submit(function (e) {
        if ($("#inputNombre").val() == "") {
          $("#inputNombre").tooltip({title: "Nombre del producto obligatorio", trigger: "focus", placement: 'bottom'});
          $("#inputNombre").tooltip('show');
          return false;
        }
        if ($("#inputPrecio").val() == "") {
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
        // if ($("#inputImg").val() == "") {
        //   //alert("No puede ser vacio");
        //   $("#inputImg").tooltip({title: "Imagen obligatoria", trigger: "focus", placement: 'bottom'});
        //   $("#inputImg").tooltip('show');
        //   return false;
        // }
        // ? Se quita la imagen y la descripción obligatoria
        // if (!$("#inputImg").val().match(/(?:gif|jpg|png|bmp)$/)) {
        //   $("#inputImg").tooltip({title: "Formato de imagen no admitido", trigger: "focus", placement: 'bottom'});
        //   $("#inputImg").tooltip('show');
        //   return false;
        // }
        // if ($("#inputDesc").val() == "") {
        //   $("#inputDesc").tooltip({title: "Descripción obligatoria", trigger: "focus", placement: 'bottom'});
        //   $("#inputDesc").tooltip('show');
        //   return false;
        // }
        if ($("#inputCategoria").val() == "") {
          //alert("No puede ser vacio");
          $("#inputCategoria").tooltip({title: "Debes de seleccionar una categoría", trigger: "focus", placement: 'bottom'});
          $("#inputCategoria").tooltip('show');
          return false;
        }
        var data = new FormData(this); //Creamos los datos a enviar con el formulario
        $.ajax({
          url: 'controllers/create_product.php', //URL destino
          data: data,
          processData: false, //Evitamos que JQuery procese los datos, daría error
          contentType: false, //No especificamos ningún tipo de dato
          type: 'POST',
          beforeSend: function () {
            //$('#exampleModalLabel').append("Loading...");
          },
          success: function (resultado) {
              var data = jQuery.parseJSON(resultado);
              if( data.error == 0 ){
                  $('#loading').empty();
                  $('#loading').append('<h2>Se añadió el producto con éxito.</h2>');
                  setTimeout(function () {
                      location.reload();
                  }, 1500);
              }else{
                  $('#loading').empty();
                  $('#loading').append('<img src="../assets/img/error.png" height="300" width="400" ><p>'+data.msgErr+'</p>');
                  setTimeout(function (){
                      $('#loading').hide();
                  }, 2000 );
              }
          }
        });
        e.preventDefault(); //Evitamos que se mande del formulario de forma convencional
      });

      $("#inputCategoria").change(function(){
         var category=$("#inputCategoria option:selected").val();
         //alert(category);
         $.ajax({
             url: 'controllers/select_sub_from_category.php',
             type: 'POST',
             data: {categoryId: category},
             success: function(res){
                 $("#inputSubCategoria").html("");
                 $("#inputSubCategoria").html(res);
             }
         })
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
