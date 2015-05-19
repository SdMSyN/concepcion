<?php
session_start();
include('config/conexion.php');
include('header.php');
include ('menu.php');
if(!isset($_SESSION['sessA']))	echo '<div class="row"><div class="col-sm-12 text-center"><h2>No ha iniciado sesión de Administrador</h2></div></div>';
else if($_SESSION['perfil'] != "1") echo '<div class="row><div class="col-sm-12 text-center"><h2>No tienes permiso para entrar a esta sección</h2></div></div>';
else{    
?>
<!-- Cambio dinamico -->
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <a href="form_select_stock.php">Almacen</a>
            <a href="form_select_product.php">Productos</a>
            <a href="form_select_user.php">Usuario</a>
            <a href="form_select_store.php">Tienda</a>
            <a href="form_select_category.php">Categoría</a>
        </div>	  
    </div>
</div>

<?php
}//fin else sesión
    include ('footer.php');
?>