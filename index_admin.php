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
  ?>
  <!-- Cambio dinamico -->
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <div class="titulo text-center">
          Bienvenido <?php $_SESSION['userName'] ?>
        </div>
      </div>	  
    </div>
  </div>

  <?php
}//fin else sesión
include ('footer.php');
?>