<html lang="en">
  <head>
    <?php
        include ('config/variables.php');
    ?>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>
      <?= $tit; ?>
    </title>

    <!-- Bootstrap -->
    <link href="assets/css/application.css" rel="stylesheet">
    
    <!-- jQuery -->
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/jquery.validate.min.js"></script>
    <script src="assets/js/additional-methods.min.js"></script>
    <script src="assets/js/jquery-validate.bootstrap-tooltip.min.js"></script>
    <script src="assets/js/application.js"></script>
    <script src="assets/js/jquery.PrintArea.js"></script>
    <!--
        <script src="assets/js/typeahead.js"></script>
        <script src="assets/js/typeahead.jquery.js"></script>
        <script src="assets/js/typeahead.bundle.js"></script>
        <script src="assets/js/bloodhound.js"></script>
        <script src="assets/js/typeahead.min.js"></script>
    -->
    <script src="assets/js/typeahead.min.js"></script>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  
  <body>    
    <div id="loader-wrapper">
      <div id="loader"></div>
      <div class="loader-section section-left"></div>
      <div class="loader-section section-right"></div>
    </div>