<?php
include ('header.php');
include ('menu.php');
?>

<?php
    include ('config/conexion.php');
    $sqlGetStores="SELECT id, nombre FROM $tStore ";
    $resGetStores=$con->query($sqlGetStores);
    $optStores='<option></option>';
    while($rowGetStores=$resGetStores->fetch_assoc()){
        $optStores.='<option value="'.$rowGetStores['id'].'">'.$rowGetStores['nombre'].'</option>';
    }
?>
    
<script language="javascript">
    function get_loc() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(coordenadas);
        }else{
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
    
<!-- Cambio dinamico -->
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <form id="formLoginStore" name="formLoginStore" method="POST">
                <label>Tienda: </label>
                <label></label>
                <select id="inputStoreName" name="inputStoreName">
                    <?= $optStores; ?>
                </select>
                <label>Contraseña: </label>
                <input type="password" name="inputStorePass" id="inputStorePass" />
                
                <input type="text" name="inputLat" id="inputLat" />   
                <input type="text" name="inputLon" id="inputLon" /> 
                
                <button type="submit" >Login</button>
            </form>
        </div>	  
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function(){
        $("#inputStoreName").change(function(){
            get_loc();
        });
        
        $('#formLoginStore').validate({
            rules: {
                    inputStoreName:{required: true},
                    inputStorePass:{required: true, digits: true}
            },
            messages: {
                    inputStoreName:{ required: "Debes seleccionar el nombre de la tienda" },
                    inputStorePass: {
                        required: "Debes introducir una contraseña",
                        digits: "Caracter no valido en la contraseña"
                    }
            },
            tooltip_options:{
                    inputStoreName:{trigger: "focus", placement:'bottom'},
                    inputStorePass:{trigger: "focus", placement:'bottom'}
            },
            submitHandler: function(form){
                $.ajax({
                   type: "POST",
                   url: "controllers/login_store.php",
                   data: $('form#formLoginStore').serialize(),
                   success: function(msg){
                       //alert(msg);
                       if(msg == "true"){
                           location.href="form_login_user.php";
                       }else{
                          $('.error').html(msg); 
                       }
                   },
                   error: function(){
                       alert("Error al iniciar sesión de Tienda");
                   }
                });
            }
        });
    });
</script>
    
<?php
    include ('footer.php');
?>