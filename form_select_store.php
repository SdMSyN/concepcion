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
                <h4 class="modal-title" id="myModalLabel">Nueva Tienda</h4>
              </div>
              <div class="error"></div>
              <form id="formAddStore" name="formAddStore" method="POST">
                <div class="modal-body">
                  <div class="form-group">
                    <label>Nombre</label>
                    <input type="text" name="inputNombre" id="inputNombre" class="form-control">
                  </div>
                  <div class="form-group">
                    <label>Dirección</label>
                    <input type="text" name="inputDir" id="inputDir" class="form-control">
                  </div> 
                  <div class="form-group">
                    <label>RFC</label>
                    <input type="text" name="inputRfc" id="inputRfc" class="form-control">
                  </div>
                  <div class="form-group">
                    <label>CP</label>
                    <input type="text" name="inputCp" id="inputCp" class="form-control">
                  </div>
                  <div class="form-group">
                    <label>Teléfono</label>
                    <input type="text" name="inputTel" id="inputTel" class="form-control">
                  </div>
                  <div class="form-group">
                    <label>Contraseña</label>
                    <input type="text" name="inputPass" id="inputPass" class="form-control">
                  </div>
                  <input type="text" name="inputLat" id="inputLat" class="hidden" />   
                  <input type="text" name="inputLon" id="inputLon" class="hidden" />
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                  <button type="submit" class="btn btn-primary" >Crear tienda</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>	  
    </div>

    <br>
    <div class="error2"></div>
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
          <!--<th class="t-head-first"><span title="id">Id</span></th>-->
          <th class="t-head"><span title="nombre">Nombre</span></th>
          <th class="t-head">Dirección</th>
          <th class="t-head"><span title="created">Fecha de creación</span></th>
          <th class="t-head"><span title="activo">Activo</span></th>
          <th class="t-head">Ver en el mapa</th>
          <th class="t-head">Modificar</th>
          <th class="t-head">Eliminar</th>
        </tr>
      </thead>
      <tbody>
        <!--<?= $optStore; ?>-->
      </tbody>    
    </table>
  </div>

  <script type="text/javascript">
    var ordenar = '';
    $(document).ready(function () {
        filtrar();
        function filtrar(){
            $.ajax({
                type: "POST",
                data: $("#frm_filtro").serialize()+ordenar,
                url: "controllers/select_store.php?action=listar",
                success: function(msg){
                    //$("#data tbody").empty();
                    //alert(msg);
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
        var idStoreDel = $(this).data('id');
        //alert("Eliminando..." + idUserDel);
        if (confirm("¿Está seguro(a) que desea dar de baja este registro?") == true) {
          $.ajax({
            type: 'POST',
            url: 'controllers/delete_store.php',
            data: {storeDel: idStoreDel, est: 1},
            success: function (msg) {
              //alert(msg);
              if (msg == "true") {
                $('.error2').css({color: "#77DD77"});
                $('.error2').html("Se dio de baja la tienda con éxito.");
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
      $("#data tbody").on("click", ".activate", function(){
        var idStoreDel = $(this).data('id');
        //alert("Eliminando..." + idUserDel);
        if (confirm("¿Seguro que desea dar de alta el registro?") == true) {
          $.ajax({
            type: 'POST',
            url: 'controllers/delete_store.php',
            data: {storeDel: idStoreDel, est: 0},
            success: function (msg) {
              //alert(msg);
              if (msg == "true") {
                $('.error2').html("Se activo la tienda con éxito.");
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
                $('.error').css({color: "#77DD77"});
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
