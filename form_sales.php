<?php
session_start();
include('config/conexion.php');
include('header.php');
include ('menu.php');
if(!isset($_SESSION['storeId']))	echo '<div class="row"><div class="col-sm-12 text-center"><h2>No ha iniciado sesión</h2></div></div>';
else{
	$storeId = $_SESSION['storeId'];
        $userId = $_SESSION['userId'];
        $userName = $_SESSION['userName'];
        $userPerfil = $_SESSION['perfil'];
        
        $sqlGetProd="SELECT * FROM $tProduct WHERE activo = '1' ";
        $resGetProd=$con->query($sqlGetProd);
        $optProd='';
        while($rowGetProd = $resGetProd->fetch_assoc()){
            $optProd .= ''.$rowGetProd['nombre'].'';
            $optProd .= ''.$rowGetProd['precio'].'';
            $optProd .= ''.$rowGetProd['img'].'';
            $optProd .= ''.$rowGetProd['descripcion'].'';
        }
?>

<!-- Cambio dinamico -->
<div class="container">
    <div class="row">
        <div class="col-md-12">
            CONTENIDO AQUI
        </div>	  
    </div>
</div>

<?php
}//fin else sesión
    include ('footer.php');
?>