<?php
session_start();
include('config/conexion.php');
include('header.php');
include ('menu.php');
if(!isset($_SESSION['storeId']))	echo '<div class="row"><div class="col-sm-12 text-center"><h2>No ha iniciado sesión</h2></div></div>';
else if($_SESSION['perfil'] != "1") echo '<div class="row><div class="col-sm-12 text-center"><h2>No tienes permiso para entrar a esta sección</h2></div></div>';
else{
    $storeId = $_SESSION['storeId'];
    $userId = $_SESSION['userId'];
    
    $sqlGetCategory = "SELECT id, nombre, created, (SELECT CONCAT(nombre,' ',ap,' ',am) FROM $tUser WHERE id=$tCategory.created_by_user_id ) as created_by FROM $tCategory ";
    $resGetCategory = $con->query($sqlGetCategory);
    $optCategory='';
    if($resGetCategory->num_rows > 0){
        while($rowGetCategory=$resGetCategory->fetch_assoc()){
            $optCategory .= '<tr>';
            $optCategory .= '<td>'.$rowGetCategory['id'].'</td>';
            $optCategory .= '<td>'.$rowGetCategory['nombre'].'</td>';
            $optCategory .= '<td>'.$rowGetCategory['created'].'</td>';
            $optCategory .= '<td>'.$rowGetCategory['created_by'].'</td>';
            $optCategory .= '</tr>';
        }
    }else{
        $optCategory.='<tr><td colspan="4">No existen categorías aún.</td></tr>';
    }
?>

<!-- Cambio dinamico -->
<div class="container">
    <div class="row">
        <div class="col-md-12 error"></div>
        <div class="col-md-12">
            <form id="formAddCategory" name="formAddCategory" method="POST">
                <div class="error"></div>
                <legend><?= $_SESSION['storeName']; ?></legend>
                <label>Nombre de la Categoría</label>
                <input type="text" id="inputCategory" name="inputCategory" >
                <input type="hidden" name="inputUser" value="<?= $userId; ?>" >
                <button type="submit" >Añadir</button>
            </form>
        </div>	  
    </div>
    <table border="2">
        <thead>
            <tr>
                <td>Id</td><td>Nombre</td><td>Fecha de creación</td><td>Creado por</td>
            </tr>
        </thead>
        <tbody>
            <?= $optCategory; ?>
        </tbody>    
    </table>
</div>

<script type="text/javascript">
    $(document).ready(function(){
        
        $('#formAddCategory').validate({
            rules: {
                    inputCategory:{required: true}
            },
            messages: {
                    inputCategory: "Debes introducir una categoría"
            },
            tooltip_options:{
                    inputCategory:{trigger: "focus", placement:'bottom'}
            },
            submitHandler: function(form){
                $.ajax({
                   type: "POST",
                   url: "controllers/create_category.php",
                   data: $('form#formAddCategory').serialize(),
                   success: function(msg){
                       //alert(msg);
                       if(msg == "true"){
                            $('.error').html("Se creo la categoría con éxito.").css({color: "#00FF00"});
                            setTimeout(function(){
				location.href='form_add_category.php';
                            }, 3000);
                       }else{
                            $('.error').css({color: "#FF0000"});
                            $('.error').html(msg); 
                       }
                   },
                   error: function(){
                       alert("Error al crear categoría ");
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