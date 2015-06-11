<?php
    include ('../config/conexion.php');
    include ('../config/variables.php');
    
    $store = $_POST['storeId'];
    
    //$sqlGetSellers="SELECT id, CONCAT(nombre,' ',ap,' ',am) as nombre FROM $tUser WHERE perfil_id='3' ";
    $sqlGetSellers="SELECT id, CONCAT(nombre,' ',ap,' ',am) as nombre FROM $tUser  ";
    $resGetSellers=$con->query($sqlGetSellers);
    $optSellers='<<option></option>';
    if($resGetSellers->num_rows > 0){
        while($rowGetSeller = $resGetSellers->fetch_assoc()){
            $optSellers.='<option value="'.$rowGetSeller['id'].'">'.$rowGetSeller['nombre'].'</option>';
        }
    }else{
        $optSellers='<option>No existen vendedores.</option>';
    }
    
    $optStockStore = '';
    $optStockStore .= '<form method="POST" id="formSelectReport" class="form-inline">';
    $optStockStore .= '<input type="hidden" id="inputStore" name="inputStore" value="'.$store.'">';
    $optStockStore .= '<div class="form-group"><label for="inputSellers">Vendedores</label>';
        $optStockStore .= '<select id="inputSellers" name="inputSellers" class="form-control">'.$optSellers.'</select>';
    $optStockStore .= '</div><div class="form-group">';
        $optStockStore .= '<label for="inputMonth">Mes</label>';
        $optStockStore .= '<input type="month" id="inputMonth" name="inputMonth" class="form-control">';
    $optStockStore .= '</div><div class="form-group">';
        $optStockStore .= '<label for="inputWeek">Semana</label>';
        $optStockStore .= '<input type="week" id="inputWeek" name="inputWeek" class="form-control" >';
    $optStockStore .= '</div>';
    $optStockStore .= '<div class="col-sm-12 text-center">';
    $optStockStore .= '<button type="button" id="generateReport" class="btn btn-primary generateReport">Mostrar reporte tienda</button>&nbsp;&nbsp;&nbsp;';
    $optStockStore .= '<button type="button" class="btn btn-default cleanReport">Limpiar filtro</button>&nbsp;&nbsp;&nbsp;';
    $optStockStore .= '<button type="button" class="btn btn-primary reportStock">Mostrar reporte almacén</button>&nbsp;&nbsp;&nbsp;';
    $optStockStore .= '<a href="javascript:void(0)" id="imprime" class="btn btn-success">Imprimir <span class="glyphicon glyphicon-print"></span></a>';
    $optStockStore .= '</div>';
    $optStockStore .= '</form>';

    echo $optStockStore;
?>