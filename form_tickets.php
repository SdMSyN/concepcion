<?php
session_start();
include('config/conexion.php');
include('header.php');
include ('menu.php');
if (!isset($_SESSION['storeId']))
    echo '<div class="row"><div class="col-sm-12 text-center"><h2>No ha iniciado sesión en tienda</h2></div></div>';
else if (!isset($_SESSION['sessU']))
    echo '<div class="row"><div class="col-sm-12 text-center"><h2>No ha iniciado sesión de usuario</h2></div></div>';
else {
    $idStore = $_SESSION['storeId'];
    $idUser = $_SESSION['userId'];
	include('config/variables.php');
  ?>
    <div class="row">
        <div class="col-md-12 report" id="myPrintArea">
            <table class="table table-striped" id="tableReport">
                <thead></thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
    <!-- Cambio dinamico -->


    <script type="text/javascript">
        $(document).ready(function (){
            getTicketsDay();
            function getTicketsDay(){
                $.ajax( {
                    type    : 'POST',
                    url     : 'controllers/select_report_store_3.php?action=day',
                    data    : {
                        inputStore : <?= $idStore; ?>,
                        typeUser   : 3
                    },
                    success : function ( data ) {
                        $('.report #tableReport thead').html('<tr><th>#</th><th>Ticket</th><th>SubTotal</th><th>Descuento</th><th>Total</th><th>Donación</th><th>Vendedor</th><th>Tienda</th><th>Fecha</th><th>Hora</th></tr>');
                        $('.report #tableReport tbody').html( data );
                    }
                });//end ajax
            }
        } );
    </script>

<?php
    }//fin else sesión
    include ('footer.php');
?>
