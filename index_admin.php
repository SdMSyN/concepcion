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
    <div class="row text-center">
      <div class="col-xs-12">
            <img src="assets/img/bginicioA.jpg" class="img-round"> 
      </div>
      <div class="col-md-12 titulo">
        BIENVENIDO AL SISTEMA ADMINISTRATIVO DE LA <br>
        PANADERIA LA CONCEPCION FAM
      </div>	  
    </div>
  </div>

  <?php
}//fin else sesión
include ('footer.php');
?>