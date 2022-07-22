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
    $userId=$_SESSION['userId'];
  ?>

  <!-- Cambio dinamico -->
  <div class="container">
    <div class="row">
      <div class="titulo-crud text-center">
        CATEGORIAS
      </div>
      <div class="col-md-12">	
        <button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal">
          Nueva Categoría
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
  	    <form id="formAddCategory" name="formAddCategory" method="POST" enctype="multipart/form-data">
  	      <div class="modal-body">
  		<div class="form-group">
  		  <label>Nombre de la Categoría</label>
  		  <input type="text" id="inputCategory" name="inputCategory" class="form-control">
  		</div>  
                  <div class="form-group">           
                    <label for="inputImg">Imagen</label>
                    <input type="file" id="inputImg" name="inputImg" >
                    <p class="help-block">Tamaño Máximo 1Mb</p>
                  </div>
  		<input type="hidden" name="inputUser" value="<?= $userId; ?>" >
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
     <div class="msg"></div>
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
            <!--<th ><span title="id">Id</span></th>-->
            <th ><span title="nombre">Nombre</span></th>
            <th >Imagen</th>
            <th ><span title="created">Fecha de creación</span></th>
            <th ><span title="created_by_user_id">Creado por</span></th>
            <th ><span title="activo">Estatus</span></th>
            <th >Modificar</th>
            <th >Eliminar</th>
        </tr>
      </thead>
      <tbody>
	
      </tbody>    
    </table>
  </div>

  <script type="text/javascript">
      var ordenar = '';
    $(document).ready(function () {
        //Ordenamiento
        filtrar();
        function filtrar(){
            $.ajax({
                type: "POST",
                data: $("#frm_filtro").serialize()+ordenar,
                url: "controllers/select_category.php?action=listar",
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
        
        /*Carga de función por que no funcionaba por si sola, ya que los elementos (función ajax hacia php) se cargaban después de cargar el script:
         http://www.forosdelweb.com/f179/javascript-no-funciona-luego-carga-ajax-1118659/
         */
        $("#data tbody").on("click", ".delete", function(){
            //alert("Hope");
            var idCatDel = $(this).data('id');
            if(confirm("¿Está seguro(a) que desea dar de baja este registro?") == true){
                $.ajax({
                    type: 'POST',
                    url: 'controllers/delete_category.php',
                    data: {categoryDel: idCatDel, est: 1},
                    success: function(msg){
                        //alert(msg);
                        if (msg == "true") {
                            $('.msg').css({color: "#77DD77"});
                            $('.msg').html("Se dio de Baja la categoría con éxito.");
                                setTimeout(function () {
                                  location.href = 'form_select_category.php';
                                }, 1500);
                        } else {
                            $('.msg').css({color: "#FF0000"});
                            $('.msg').html(msg);
                        }
                    }
		});
            }//end if confirm
        });
        $("#data tbody").on("click", ".activate", function(){
            //alert("Hope");
            var idCatAct = $(this).data('id');
            //alert("Eliminando..." + idCatAct);
            if(confirm("¿Está seguro(a) que desea dar de Alta el registro?") == true){
                $.ajax({
                    type: 'POST',
                    url: 'controllers/delete_category.php',
                    data: {categoryDel: idCatAct, est: 0},
                    success: function(msg){
                        //alert(msg);
                        if (msg == "true") {
                            $('.msg').css({color: "#77DD77"});
                            $('.msg').html("Se activo la Categoría con éxito.");
                                setTimeout(function () {
                                  location.href = 'form_select_category.php';
                                }, 1500);
                        } else {
                            $('.msg').css({color: "#FF0000"});
                            $('.msg').html(msg);
                        }
                    }
		});
            }//end if confirm
        });
        
        /*function filtrar(){
            $.ajax({
               data:$("#frm_filtro").serialize()+ordenar,
               type: "POST",
               dataType: "json",
               url: "controllers/select_category.php?action=listar",
               success: function(data){
                   var html = '';
                   if(data.length > 0){
                       $.each(data, function(i, item){
                           html += '<tr>';
                           html += '<td>'+item.id+'</td>';
                           html += '<td>'+item.name+'</td>';
                           html += '<td>'+item.created+'</td>';
                           html += '<td>'+item.created_by+'</td>';
                           html += '<td>'+item.status+'</td>';
                           html += '<td>'+item.mod+'</td>';
                           html += '<td><a class="delete" data-id="'+item.id+'" onClick="delete2()" >Dar de baja</a></td> ';
                           html += '</tr>';
                       });
                   }
                   $("#data tbody").html(html);
               }
            });
        }*/
         
        /*$('.delete').click(function () {
            var idCatDel = $(this).data('id');
            alert("Eliminando..." + idUserDel);
            if(confirm("Seguro que deseas eliminar?") == true){
                $.ajax({
                    type: 'POST',
                    url: 'controllers/delete_category.php',
                    data: {categoryDel: idCatDel},
                    success: function(msg){
                        //alert(msg);
                        if (msg == "true") {
                            $('.msg').css({color: "#00FFF0"});
                            $('.msg').html("Se elimino la categoría con éxito.");
                                setTimeout(function () {
                                  location.href = 'form_select_category.php';
                                }, 1500);
                        } else {
                            $('.msg').css({color: "#FF0000"});
                            $('.msg').html(msg);
                        }
                    }
		});
            }//end if confirm
        });*/
        
      $('#formAddCategory').validate({
        rules: {
          inputCategory: {required: true},
          inputImg: {required: true, extension: "jpg|png|bmp|jpeg|gif"}
        },
        messages: {
          inputCategory: "Debes introducir una categoría",
          inputImg:{
              required: "Imagen obligatoria",
              extension: "Formato de imagen no valido"
          }
        },
        tooltip_options: {
          inputCategory: {trigger: "focus", placement: 'bottom'},
          inputImg: {trigger: "focus", placement: 'bottom'}
        },
        submitHandler: function (form) {
          //var data = new FormData();
          //data.append('file', $('#inputImg')[0].files[0]);
          //form.preventDefault();
          $.ajax({
            type: "POST",
            url: "controllers/create_category.php",
            //data: $('form#formAddCategory').serialize(),
            //data: data,
            data: new FormData($("form#formAddCategory")[0]),
            contentType: false,
            processData: false,
            //contentType: "multipart/form-data",
            //cache: false,
            //mimeType: "multipart/form-data",
            success: function (msg) {
              //alert(msg);
              if (msg == "true") {
                $('.error').css({color: "#77DD77"});
                $('.error').html("Se creo la categoría con éxito.");
                setTimeout(function () {
                  location.href = 'form_select_category.php';
                }, 3000);
              } else {
                $('.error').css({color: "#FF0000"});
                $('.error').html(msg);
              }
            },
            error: function () {
              alert("Error al crear categoría ");
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
