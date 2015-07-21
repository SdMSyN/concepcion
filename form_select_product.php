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
  $sqlGetProducts = "SELECT id, nombre, (SELECT nombre FROM $tCategory WHERE id=$tProduct.categoria_id) as categoria, precio, img FROM $tProduct WHERE activo='1' ";
  $resGetProducts = $con->query($sqlGetProducts);
  $optProducts = '';
  if ($resGetProducts->num_rows > 0) {
    while ($rowGetProducts = $resGetProducts->fetch_assoc()) {
      $optProducts .= '<tr>';
      $optProducts .= '<td>' . $rowGetProducts['id'] . '</td>';
      $optProducts .= '<td><img src="' . $rutaImgProd . $rowGetProducts['img'] . '" class="img-product-list"></td>';
      $optProducts .= '<td>' . $rowGetProducts['nombre'] . '</td>';
      $optProducts .= '<td>' . $rowGetProducts['categoria'] . '</td>';
      $optProducts .= '<td>' . $rowGetProducts['precio'] . '</td>';
      $optProducts .= '<td><a href="form_update_product.php?id=' . $rowGetProducts['id'] . '" >Modificar</a></td>';
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
              <div class="form-group">           
                <label for="exampleInputFile">Imagen</label>
                <input type="file" id="inputImg" name="inputImg" >
                <p class="help-block">Tamaño Máximo 1Mb</p>
              </div>
              <div class="form-group">
                <label>Descripción</label>
                <input type="text" id="inputDesc" name="inputDesc" class="form-control">
              </div>
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
  <div class="col-sm-12">
       <form id="frm_filtro" method="post" action="" class="form-inline">
           <div class="form-group">
             <select id="estatus" name="estatus" class="form-control">
               <option value="0"></option>
               <option value="1">Desactivo</option>
               <option value="2">Activo</option>
             </select>
           </div>
           <button type="button" id="btnfiltrar" class="btn btn-success">Filtrar</button>
           <a href="javascript:;" id="btncancel" class="btn btn-default">Todos</a>

         </form>
     </div>
  <table class="table table-striped" id="data">
    <thead>
      <tr>
          <th class="t-head-first"><span title="id">Id</span></th>
        <th class="t-head">Imagen</th>
        <th class="t-head"><span title="nombre">Nombre</span></th>
        <th class="t-head"><span title="categoria_id">Categoría</span></th>
        <th class="t-head"><span title="subcategoria_id">Subcategoría</span></th>
        <th class="t-head"><span title="precio">Precio</span></th>
        <th class="t-head"><span title="activo">Estatus</span></th>
        <th class="t-head">Modificar</th>
        <th class="t-head-last">Eliminar</th>
      </tr>
    </thead>
    <tbody>
      
    </tbody>    
  </table>

  </div><!-- fin container -->

  <script type="text/javascript">
    var ordenar = '';
    $(document).ready(function () {
        filtrar();
        function filtrar(){
            $.ajax({
                type: "POST",
                data: $("#frm_filtro").serialize()+ordenar,
                url: "controllers/select_product.php?action=listar",
                success: function(msg){
                    //$("#data tbody").empty();
                    $("#data tbody").html(msg);
                }
            });
        }
        
        //Ordenar ASC y DESC header tabla
        $("#data th span").click(function(){
            if($(this).hasClass("desc")){
                $("#data th span").removeClass("desc").removeClass("asc");
                $(this).addClass("asc");
                ordenar = "&orderby="+$(this).attr("title")+" asc";
            }else{
                $("#data th span").removeClass("desc").removeClass("asc");
                $(this).addClass("desc");
                ordenar = "&orderby="+$(this).attr("title")+" desc";
            }
            filtrar();
        });
        
        //Ordenar por formulario
        $("#btnfiltrar").click(function(){ 
            filtrar();
            //alert("y ahora?");
        });
        
        // boton cancelar
	$("#btncancel").click(function(){ 
            $("#frm_filtro select").find("option[value='0']").attr("selected",true)
            filtrar() 
	});
        
      $("#data tbody").on("click", ".delete", function(){
        var idProductDel = $(this).data('id');
        //alert("Eliminando..." + idUserDel);
        if (confirm("¿Está seguro(a) que desea dar de baja este registro?") == true) {
          $.ajax({
            type: 'POST',
            url: 'controllers/delete_product.php',
            data: {productDel: idProductDel, est: 1},
            success: function (msg) {
              //alert(msg);
              if (msg == "true") {
                $('.error').css({color: "#77DD77"});
                alert("Se dio de baja el producto con éxito.");
                /*setTimeout(function () {
                  location.href = 'form_select_product.php';
                }, 3000);*/
                filtrar();
              } else {
                $('.error').css({color: "#FF0000"});
                $('.error').html(msg);
              }
            }
          });
        }//end if confirm
      });
      $("#data tbody").on("click", ".activate", function(){
        var idProductDel = $(this).data('id');
        //alert("Eliminando..." + idUserDel);
        if (confirm("¿Está seguro(a) que desea dar de alta el registro?") == true) {
          $.ajax({
            type: 'POST',
            url: 'controllers/delete_product.php',
            data: {productDel: idProductDel, est: 0},
            success: function (msg) {
              //alert(msg);
              if (msg == "true") {
                alert("Se activo el producto con éxito.");
                /*setTimeout(function () {
                  location.href = 'form_select_product.php';
                }, 3000);*/
                filtrar();
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
          //alert("No puede ser vacio");
          $("#inputNombre").tooltip({title: "Nombre del producto obligatorio", trigger: "focus", placement: 'bottom'});
          $("#inputNombre").tooltip('show');
          return false;
        }
        if ($("#inputPrecio").val() == "") {
          //alert("No puede ser vacio");
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
        if ($("#inputImg").val() == "") {
          //alert("No puede ser vacio");
          $("#inputImg").tooltip({title: "Imagen obligatoria", trigger: "focus", placement: 'bottom'});
          $("#inputImg").tooltip('show');
          return false;
        }
        if (!$("#inputImg").val().match(/(?:gif|jpg|png|bmp)$/)) {
          // inputted file path is not an image of one of the above types
          $("#inputImg").tooltip({title: "Formato de imagen no admitido", trigger: "focus", placement: 'bottom'});
          $("#inputImg").tooltip('show');
          return false;
        }
        if ($("#inputDesc").val() == "") {
          //alert("No puede ser vacio");
          $("#inputDesc").tooltip({title: "Descripción obligatoria", trigger: "focus", placement: 'bottom'});
          $("#inputDesc").tooltip('show');
          return false;
        }
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
            //alert(resultado);
            if (resultado == "true") {
              $('#form-content').modal('hide');
              location.reload();
            } else {
              $('.error').html(resultado);
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
                 //alert(res);
                 $("#inputSubCategoria").html("");
                 $("#inputSubCategoria").html(res);
             }
         })
      });
      
      /*$("#myModalAdd #inputSubCategoria").on("change", function(){
          var subC=$("#inputSubCategoria option:selected").val();
          alert(subC);
      });*/
      
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
