<?php
session_start();
include('config/conexion.php');
include('header.php');
include ('menu.php');

?>

<!-- Cambio dinamico -->
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <form id="formLoginAdmin" name="formLoginAdmin" method="POST">
                <div class="error"></div>
                <legend>Administración</legend>
                <label>Administrador</label>
                <input type="text" id="inputAdmin" name="inputAdmin" >
                <label>Contraseña</label>
                <input type="text" id="inputPassAdmin" name="inputPassAdmin" >
                <button type="submit" >Iniciar Sesión</button>
            </form>
        </div>	  
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function(){
        
        $("#inputAdmin").focus(); //Enfocamos el cursor al input para la contraseña
         
        $('#formLoginAdmin').validate({
            rules: {
                    inputAdmin:{required: true},
                    inputPassAdmin:{required: true}
            },
            messages: {
                    inputAdmin: "Debes introducir un usuario",
                    inputPassAdmin: "Debes introducir una contraseña"
            },
            tooltip_options:{
                    inputAdmin:{trigger: "focus", placement:'bottom'},
                    inputPassAdmin:{trigger: "focus", placement:'bottom'}
            },
            submitHandler: function(form){
                $.ajax({
                   type: "POST",
                   url: "controllers/login_admin.php",
                   data: $('form#formLoginAdmin').serialize(),
                   success: function(msg){
                       //alert(msg);
                       if(msg == "true"){
                            location.href="index_admin.php";
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
    include ('footer.php');
?>