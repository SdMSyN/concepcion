<?php
session_start();
include('config/conexion.php');
include('header.php');
include ('menu.php');
if(!isset($_SESSION['storeId']))	echo '<div class="row"><div class="col-sm-12 text-center"><h2>No ha iniciado sesión</h2></div></div>';
else{
	$storeId=$_SESSION['storeId'];
?>

<!-- Cambio dinamico -->
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <form id="formLoginUser" name="formLoginUser" method="POST">
                <div class="error"></div>
                <legend><?= $_SESSION['storeName']; ?></legend>
                <label>Usuario</label>
                <input type="text" id="inputPassUser" name="inputPassUser" >
                <button type="submit" >Login</button>
            </form>
        </div>	  
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function(){
        
        $("#inputPassUser").focus(); //Enfocamos el cursor al input para la contraseña
         
        $('#formLoginUser').validate({
            rules: {
                    inputPassUser:{required: true, digits: true}
            },
            messages: {
                    inputPassUser: {
                        required: "Debes introducir una contraseña",
                        digits: "Caracter no valido en la contraseña"
                    }
            },
            tooltip_options:{
                    inputPassUser:{trigger: "focus", placement:'bottom'}
            },
            submitHandler: function(form){
                $.ajax({
                   type: "POST",
                   url: "controllers/login_user.php",
                   data: $('form#formLoginUser').serialize(),
                   success: function(msg){
                       //alert(msg);
                       if(msg == "true"){
                            location.href="form_sales.php";
                       }else{
                          $('.error').html(msg); 
                       }
                   },
                   error: function(){
                       alert("Error al iniciar sesión de usuario");
                   }
                });
            }
            
        });
    });
</script>

<?php
}//fin else sesión
    include ('footer.php');
?>