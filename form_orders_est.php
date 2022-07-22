<?php
session_start();
include('config/conexion.php');
include('header.php');
include ('menu.php');
if (!isset($_SESSION['storeId']))
  echo '<div class="row"><div class="col-sm-12 text-center"><h2>No ha iniciado sesión en tienda</h2></div></div>';
else if (!isset($_SESSION['sessU']))
  echo '<div class="row"><div class="col-sm-12 text-center"><h2>No ha iniciado sesión de usuario</h2></div></div>';
else {
  $idStore = $_SESSION['storeId'];
  $idUser = $_SESSION['userId'];
  include('config/variables.php');
  
  ?>

  <!-- Cambio dinamico -->
  <div class="container">
    <div class="row">
      <div class="titulo-crud text-center">
        Seguimiento de pedidos
      </div>
    </div>
    <br>
     <div class="msg"></div>
     <div class="col-sm-12">
       <form id="frm_filtro" method="post" action="" class="form-inline">
           <div class="form-group">
             <input type="text" id="inputNombreCliente" name="inputNombreCliente" class="form-control" placeholder="Nombre del cliente">
           </div>
           <button type="button" id="btnfiltrar" class="btn btn-success">Filtrar</button>
           <a href="javascript:;" id="btncancel" class="btn btn-default">Todos</a>
         </form>
     </div>
    <table class="table table-striped" id="data">
      <thead>
        <tr>
            <th>Nombre Cliente</th>
            <th>Fecha de pedido</th>
            <th>Fecha de entrega</th>
            <th>Horario de entrega</th>
            <th>Total</th>
            <th>Pagado</th>
            <th>Pendiente</th>
            <th>Estatus</th>
            <th>Pagar</th>
        </tr>
      </thead>
      <tbody>
	
      </tbody>    
    </table>
  </div>

  <!-- Modal -->
        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  	<div class="modal-dialog">
  	  <div class="modal-content">
  	    <div class="modal-header">
  	      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  	      <h4 class="modal-title" id="myModalLabel">Realizar pago</h4>
  	    </div>
            <div class="error"></div>
  	    <form id="formAddPay" name="formAddPay" method="POST" >
  	      <div class="modal-body">
                <div class="form-group">
  		  <label>Cantidad pendiente</label>
  		  <input type="number" id="inputPend" name="inputPend" class="form-control" readonly>
  		</div> 
  		<div class="form-group">
  		  <label>Cantidad a pagar</label>
  		  <input type="number" id="inputPago" name="inputPago" class="form-control">
  		</div> 
                <div class="form-group">
                    <label>Recibido:</label></br>
                    <input type="number" id="inputRecibido" name="inputRecibido" step=0.01 class="form-control calcChange" required title="Dinero que entrega el cliente, obligatorio">
                </div>
                <div class="form-group">
                  <label>Cambio:</label></br>
                  <input type="number" id="inputCambio" name="inputCambio" readonly step=0.01 class="form-control" >
                </div>
  		<input type="hidden" name="inputCampo" id="inputCampo">
  		<input type="hidden" name="inputUser" value="<?= $idUser; ?>">
  	      </div>
  	      <div class="modal-footer">
  		<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
  		<button type="submit" class="btn btn-primary enviarPago" >Pagar <i class="fa fa-money" style="font-size: 2.2rem;"></i></button>
  	      </div>
  	    </form>
  	  </div>
  	</div>
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
                url: "controllers/select_orders_sale.php?action=listar",
                success: function(msg){
                    //$("#data tbody").empty();
                    $("#data tbody").html(msg);
                }
            });
        }
        
        //Ordenar por formulario
        $("#btnfiltrar").click(function(){ 
            filtrar();
            //alert("y ahora?");
        });
        
        // boton cancelar
	$("#btncancel").click(function(){ 
            $("#frm_filtro input").val("");
            filtrar() 
	});
        
        $('#myModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget)
            var recipient = button.data('whatever') 
            var pendiente = button.data('pend')
            var modal = $(this)
            modal.find('.modal-body #inputCampo').val(recipient)
            modal.find('.modal-body #inputPend').val(pendiente)
	});
        
        $('#formAddPay').validate({
            rules: {
              inputPago: {required: true}
            },
            messages: {
              inputPago: "Debes introducir una cantidad valida."
            },
            tooltip_options: {
              inputPago: {trigger: "focus", placement: 'bottom'}
            },
            submitHandler: function (form) {
              $.ajax({
                type: "POST",
                url: "controllers/update_order_payment.php",
                data: $('form#formAddPay').serialize(),
                success: function (msg) {
                  //alert(msg);
                  if (msg == "true") {
                    $('.error').css({color: "#77DD77"});
                    $('.error').html("Se hizo el pago con éxito.");
                    setTimeout(function () {
                      location.href = 'form_orders_est.php';
                    }, 1500);
                  } else {
                    $('.error').css({color: "#FF0000"});
                    $('.error').html(msg);
                  }
                },
                error: function () {
                  alert("Error al registrar pago ");
                }
              });
            }
          });
        
        $("#formAddPay").on("change blur click", ".calcChange", calcChange);
        
        function calcChange(){
            var pago = parseFloat($(this).parent().parent().find("#inputPago").val());
            var recibido = parseFloat($(this).parent().parent().find("#inputRecibido").val());
            if(recibido < pago){
              //alert("El dinero recibido no puede ser menor al total de la venta.");
              $(".enviarPago").attr("disabled", true);
            }else
              $(".enviarPago").removeAttr("disabled");
            var cambio = recibido-pago;
            //alert(cambio);
            $(this).parent().parent().find("#inputCambio").val(cambio);
        }
        
        $("#data tbody").on("click", ".entregar", function(){
            var idOrderGive = $(this).data('id');
            if(confirm("¿Está seguro(a) que desea entregar el pedido (¿Ya te pagaron?)?") == true){
                $.ajax({
                    type: 'POST',
                    url: 'controllers/update_order.php',
                    data: {orderId: idOrderGive},
                    success: function(msg){
                        //alert(msg);
                        if (msg == "true") {
                            $('.msg').css({color: "#77DD77"});
                            $('.msg').html("Se entrego el pedido con éxito.");
                                setTimeout(function () {
                                  location.href = 'form_orders_est.php';
                                }, 1500);
                        } else {
                            $('.msg').css({color: "#FF0000"});
                            $('.msg').html(msg);
                        }
                    }
		});
            }//end if confirm
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
