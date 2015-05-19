
<nav class="navbar navbar-default">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
	<span class="sr-only">Toggle navigation</span>
	<span class="icon-bar"></span>
	<span class="icon-bar"></span>
	<span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="index_admin.php">Inicio</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
	<?php
	if ($_SESSION['perfil'] == "1") {
	  ?>
	  <li><a href="form_select_stock.php">Almacen</a></li>
	  <li><a href="form_select_product.php">Productos</a></li>
	  <li><a href="form_select_user.php">Usuario</a></li>
	  <li><a href="form_select_store.php">Tienda</a></li>
	  <li><a href="form_select_category.php">Categoría</a></li>
	  <?php
	}//fin else sesión
	?>


      </ul>
      <ul class="nav navbar-nav navbar-right">
	<?php
	if (isset($_SESSION['sessU'])) {
	  echo '<li class="no-a">Bienvenido ' . $_SESSION['userName'] . '</li>';
	  echo '<li><a href="controllers/proc_destroy_login.php">Cerrar Sesión</a></li>';
	}
	?>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>