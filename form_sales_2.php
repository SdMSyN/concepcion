<?php
session_start();
include('config/conexion.php');
include('header.php');
include ('menu.php');
if(!isset($_SESSION['storeId']))	echo '<div class="row"><div class="col-sm-12 text-center"><h2>No ha iniciado sesión en tienda</h2></div></div>';
else if(!isset($_SESSION['sessU']))	echo '<div class="row"><div class="col-sm-12 text-center"><h2>No ha iniciado sesión de usuario</h2></div></div>';
else{
    $idStore=$_SESSION['storeId'];
    $idUser=$_SESSION['userId'];
    
    $sqlGetCategories = "SELECT * FROM $tCategory WHERE  activo='1' ";
    $resGetCategories = $con->query($sqlGetCategories);
    $optCategories='';
    if($resGetCategories->num_rows > 0){
        while($rowGetCategories = $resGetCategories->fetch_assoc()){
            //$optCategories .= '<button type="button" class="clickCategory" title="'.$rowGetCategories['id'].'">'.$rowGetCategories['nombre'].'</button> ';
            $optCategories .= '<div class="col-md-2"><img src="uploads/'.$rowGetCategories['img'].'" class="clickCategory" title="'.$rowGetCategories['id'].'" width="100%">'.$rowGetCategories['nombre'].'</div>';
        }
    }else{
        $optCategories .= 'No hay categorias disponibles';
    }
    
?>

<!-- Cambio dinamico -->
<div class="container">
    <div class="row">
        <div class="col-md-7">
            <form id="formTicket" method="POST" action="controllers/set_sale.php" >
                <div class="row ticket">
                    <table id="dataTicket">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Precio U.</th>
                                <th>Cantidad</th>
                                <th>Precio F.</th>
                                <th><b>x</b></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr><td colspan="2" class="text-right"><b>Total:</b></td><td colspan="2"><input type="text" id="inputTotal" name="inputTotal" readonly step=0.01 ></td><td colspan="2"><button type="submit" class="enviarTicket">Cobrar</button></td></tr>
                        </tbody>
                    </table>
                </div>
            </form>
            <div class="row teclado">
                <form id="formTeclado" method="POST" >
                    <div class="row">
                        <input type="text" class="typeahead tt-query" autocomplete="off" spellcheck="false" placeholder="Type your Query" id="inputCod" name="inputCod">
                        <input type="hidden" name="idStore" value="<?=$idStore;?>" >
                        <button type="submit" class="">Enviar</button>
                    </div>
                </form>
                    <div id="teclado_numerico_2">
                        <div class="numeric-form text-center">
                          <span class="btn btn-info btn-numeric-form" onclick="teclado(7)">7</span>
                          <span class="btn btn-info btn-numeric-form" onclick="teclado(8)">8</span>
                          <span class="btn btn-info btn-numeric-form" onclick="teclado(9)">9</span>
                          <br>
                          <span class="btn btn-info btn-numeric-form" onclick="teclado(4)">4</span>
                          <span class="btn btn-info btn-numeric-form" onclick="teclado(5)">5</span>
                          <span class="btn btn-info btn-numeric-form" onclick="teclado(6)">6</span>
                          <br>
                          <span class="btn btn-info btn-numeric-form" onclick="teclado(1)">1</span>
                          <span class="btn btn-info btn-numeric-form" onclick="teclado(2)">2</span>
                          <span class="btn btn-info btn-numeric-form" onclick="teclado(3)">3</span>
                          <br>
                          <span class="btn btn-default btn-numeric-form erase"><i class="fa fa-arrow-left"></i></span>
                          <span class="btn btn-info btn-numeric-form" onclick="teclado(0)">0</span>
                          <span class="btn btn-default btn-numeric-form">C</span>
                        </div>
                      </div>
            </div>
        </div><!-- /col-md-4 -->
        <div class="col-md-5">
            <div class="row productCategory">
                <?= $optCategories; ?>
            </div>
            <div class="row productSubCategory">
                    
            </div>
            <div class="row productInfo">
                
            </div>
        </div><!-- /col-md-8 -->
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        $(".clickCategory").click(function(){
            var category=$(this).attr("title");
            //alert(category);
            $.ajax({
               type: "POST",
               url: "controllers/select_sales_sub_categories.php",
               data: {idCategory: category},
               success: function(msg){
                   //alert(msg);
                   if(msg=="false"){
                        $.ajax({
                            type: "POST",
                            url: "controllers/select_sales_sub_products.php",
                            data: {idCategory: category, tarea: "catProduct"},
                            success: function(msg2){
                                $(".productSubCategory").html('');
                                $(".productInfo").html(msg2);
                            }
                        });
                   }else{
                       $(".productInfo").html('');
                       $(".productSubCategory").html(msg);
                   }
               }
            });
        });
         
        $(".productSubCategory").on("click", ".clickSubCategory", function(){ 
        //$(".clickSubCategory").click(function(){
            var subCategory=$(this).attr("title");
            //alert(subCategory);
            $.ajax({
                type: "POST",
                url: "controllers/select_sales_sub_products.php",
                data: {idSubCategory: subCategory, tarea: "subProduct"},
                success: function(msg){
                    $(".productInfo").html(msg);
                }
            });
        });
        
        $(".productInfo").on("click", ".clickProduct", function(){ 
            var product=$(this).attr("title");
            //alert(product);
            $.ajax({
                type: "POST",
                url: "controllers/select_sales_product.php",
                data: {idProduct: product, idStore: <?= $idStore; ?>},
                success: function(msg){
                    $(".ticket #dataTicket tbody").append(msg);
                    $(".ticket #dataTicket tbody #inputCant").focus();
                    $(".ticket #dataTicket tbody #inputCant").select();
                    calcTotal();
                }
            });
        });
        
        $(".ticket #dataTicket tbody").on("click", ".deleteItem", function(e){
            e.preventDefault();
            $(this).parent().parent().remove();
            calcTotal();
        })
        
        $(".ticket #dataTicket tbody").on("focus", "#inputCant", function(){
            //alert("focus Cantidad");
            input = $(this);
            //banFocusInput = true;
            actTodo();
        });
        
        $(".ticket #dataTicket tbody").on("focusout blur change", "#inputCant", function(){
            actTodo();
        });
        
        //$(".teclado #teclado_numerico_2").on("keyup change click keyprees kewdown", ".cant", actCant);
        $(".teclado #teclado_numerico_2").on("click", function(){
            actTodo();
        });
        
        $(".ticket #dataTicket tbody").on("keyup change blur keypress keydown", ".cant", actCant);
        
        function actCant(){
            var precioU = parseFloat($(this).parent().parent().find("#inputPrecioU").val());
            var cantidad = parseInt($(this).parent().parent().find("#inputCant").val());
            var cantidadMax = parseInt($(this).parent().parent().find("#inputCantMax").val());
            //alert(cantidadMax);
            if(cantidad < 0){
                //cantidad = 0;
                $(this).parent().parent().find("#inputCant").val("0");
            }
            if(cantidad > cantidadMax){
                //cantidad = cantidadMax;
                $(this).parent().parent().find("#inputCant").val(cantidadMax);
            }
            var precioF = precioU * cantidad;
            $(this).parent().parent().find("#inputPrecioF").val(precioF);
            calcTotal();
        }
        
        function calcTotal(){
            var total=0;
            $(".ticket #dataTicket tbody #inputPrecioF").each(function(){
                total += parseFloat($(this).val());
            });
            total=total.toFixed(2);
            $("#inputTotal").val(total);
        }
        
        function actTodo(){
            $(".ticket #dataTicket tbody #inputCant").each(function(){
                var precioU = parseFloat($(this).parent().parent().find("#inputPrecioU").val());
                var cantidad = parseInt($(this).parent().parent().find("#inputCant").val());
                var cantidadMax = parseInt($(this).parent().parent().find("#inputCantMax").val());
                //alert(cantidadMax);
                if(cantidad < 0){
                    //cantidad = 0;
                    $(this).parent().parent().find("#inputCant").val("0");
                }
                if(cantidad > cantidadMax){
                    //cantidad = cantidadMax;
                    $(this).parent().parent().find("#inputCant").val(cantidadMax);
                }
                var precioF = precioU * cantidad;
                $(this).parent().parent().find("#inputPrecioF").val(precioF);
                calcTotal();
            })
        }
        /*$(".ticket #dataTicket tbody").on("keyup change blur keypress keydown", ".cant", function(){
            var precioU = parseFloat($(this).parent().parent().find("#inputPrecioU").val());
            var cantidad = parseInt($(this).parent().parent().find("#inputCant").val());
            var cantidadMax = parseInt($(this).parent().parent().find("#inputCantMax").val());
            //alert(cantidadMax);
            if(cantidad < 0){
                //cantidad = 0;
                $(this).parent().parent().find("#inputCant").val("0");
            }
            if(cantidad > cantidadMax){
                //cantidad = cantidadMax;
                $(this).parent().parent().find("#inputCant").val(cantidadMax);
            }
            var precioF = precioU * cantidad;
            $(this).parent().parent().find("#inputPrecioF").val(precioF);
            calcTotal();
        });*/
        
        /*function calcTotal(){
            var total=0;
            $(".ticket #dataTicket tbody #inputPrecioF").each(function(){
                total += parseFloat($(this).val());
            });
            total=total.toFixed(2);
            $("#inputTotal").val(total);
        }*/
        
        $('input.typeahead').typeahead({
            name: 'inputCod',
            remote:'controllers/select_sales_product_json.php?query=%QUERY&store=<?=$idStore;?>',
            limit : 5
        });
        
        $('#formTeclado').validate({
        rules: {
            inputCod: {required: true}
        },
        messages: {
            inputCod: "Debes introducir una nombre o código de barras"
        },
        tooltip_options: {
            inputCod: {trigger: "focus", placement: 'bottom'}
        },
        submitHandler: function (form) {
            $.ajax({
                type: "POST",
                url: "controllers/select_sales_product_ticket.php",
                data: $('form#formTeclado').serialize(),
                success: function (msg) {
                    //alert(msg);
                    $(".ticket #dataTicket tbody").append(msg);
                    $(".ticket #dataTicket tbody #inputCant").focus();
                    $(".ticket #dataTicket tbody #inputCant").select();
                    calcTotal();
                },
                error: function () {
                    alert("Error al buscar producto ");
                }
            });
        }
    });
        /*$('input.typeahead-devs').typeahead({
            name: 'inputCod',
            local: ['Sunday', 'Monday', 'Tuesday','Wednesday','Thursday','Friday','Saturday']
        });*/

        
    });
    //var input;
</script>

 <script type="text/javascript">
    var input;
    //var banFocusInput=false;
        $("input").on("focus", function () {
         input = $(this);
         //banFocusInput = false;
         //alert(input.val());
        });
        
        function teclado(numero) {
            if (input != null){
                //alert(input);
                
                /*if(banFocusInput)input.val(numero);
                else input.val(input.val()+numero);*/
            
                input.val(input.val()+numero);
                //actCant();
            }
        }

        /*function actCant(){
            var precioU = parseFloat($(this).parent().parent().find("#inputPrecioU").val());
            var cantidad = parseInt($(this).parent().parent().find("#inputCant").val());
            var cantidadMax = parseInt($(this).parent().parent().find("#inputCantMax").val());
            //alert(cantidadMax);
            if(cantidad < 0){
                //cantidad = 0;
                $(this).parent().parent().find("#inputCant").val("0");
            }
            if(cantidad > cantidadMax){
                //cantidad = cantidadMax;
                $(this).parent().parent().find("#inputCant").val(cantidadMax);
            }
            var precioF = precioU * cantidad;
            $(this).parent().parent().find("#inputPrecioF").val(precioF);
            calcTotal();
        }
        
        function calcTotal(){
            var total=0;
            $(".ticket #dataTicket tbody #inputPrecioF").each(function(){
                total += parseFloat($(this).val());
            });
            total=total.toFixed(2);
            $("#inputTotal").val(total);
        }*/
 </script>
<?php
}//fin else sesión
    include ('footer.php');
?>