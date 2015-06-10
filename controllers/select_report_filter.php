<?php
    include ('../config/conexion.php');
    include ('../config/variables.php');
    
    $store = $_POST['storeId'];
    
    $sqlGetSellers="SELECT id, CONCAT(nombre,' ',ap,' ',am) as nombre FROM $tUser WHERE perfil_id='3' ";
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
    $optStockStore .= '<button type="button" id="generateReport" class="btn btn-primary generateReport">Generar</button>';
    $optStockStore .= '</form>';

    echo $optStockStore;
?>