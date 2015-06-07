<nav class="navbar navbar-default">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
        <span class="sr-only">Menu</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <?php
      if (isset($_SESSION['perfil']) && $_SESSION['perfil'] == "1") {
        if (isset($_SESSION['sessA'])) {
          ?>
          <a class="navbar-brand" href="index_admin.php">Inicio</a>
          <?php
        } else {
          ?>
          <a class="navbar-brand" href="form_sales.php">Inicio</a>
          <?php
        }
      } elseif (isset($_SESSION['perfil']) && $_SESSION['perfil'] == "3" && isset($_SESSION['sess'])) {
        ?>
        <a class="navbar-brand" href="form_sales.php">Inicio</a>
        <?php
      } else {
        ?>
        <a class="navbar-brand" href="form_login_store.php">Inicio</a>
        <?php
      }
      ?>      
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <?php
        if (isset($_SESSION['perfil']) && $_SESSION['perfil'] == "1" && isset($_SESSION['sessA'])) {
          ?>
          <li><a href="form_select_stock_2.php">Almacen</a></li>
          <li><a href="form_select_product.php">Productos</a></li>
          <li><a href="form_select_user.php">Usuarios</a></li>
          <li><a href="form_select_store.php">Tiendas</a></li>
          <li><a href="form_select_category.php">Categorías</a></li>
          <li><a href="form_select_subcategory.php">Subcategorías</a></li>
          <?php
        } elseif (isset($_SESSION['perfil']) && $_SESSION['perfil'] == "3" && isset($_SESSION['sess'])) {
          ?>
          <!--          <li><a href="form_select_stock_2.php">Hola mundo</a></li>-->
          <?php
        }
        ?>


      </ul>
      <ul class="nav navbar-nav navbar-right">
        <?php
        if (isset($_SESSION['perfil'])) {
          echo '<li class="no-a user-name">Bienvenido ' . $_SESSION['userName'] . '</li>';
          echo '<li><a href="controllers/proc_destroy_login_admin.php">Cerrar Sesión</a></li>';
        }
        ?>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>