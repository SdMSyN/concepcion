<?php
    include ('../config/conexion.php');
    include ('../config/variables.php');
    
    $store = $_POST['storeId'];
    $tarea = $_POST['tarea'];
    
    //$sqlGetSellers="SELECT id, CONCAT(nombre,' ',ap,' ',am) as nombre FROM $tUser WHERE perfil_id='3' ";
    $sqlGetSellers="SELECT id, CONCAT(nombre,' ',ap,' ',am) as nombre FROM $tUser  ";
    $resGetSellers=$con->query($sqlGetSellers);
    $optSellers='<option></option>';
    if($resGetSellers->num_rows > 0){
        while($rowGetSeller = $resGetSellers->fetch_assoc()){
            $optSellers.='<option value="'.$rowGetSeller['id'].'">'.$rowGetSeller['nombre'].'</option>';
        }
    }else{
        $optSellers='<option>No existen vendedores.</option>';
    }
    
    //Obtenemos los diferentes estatus del pedido
    $sqlGetEsts="SELECT id, nombre FROM $tOrderEst  ";
    $resGetEsts=$con->query($sqlGetEsts);
    $optEsts='<option></option>';
    while($rowGetEsts = $resGetEsts->fetch_assoc()){
        $optEsts.='<option value="'.$rowGetEsts['id'].'">'.$rowGetEsts['nombre'].'</option>';
    }
    
    //Obtenemos los diferentes estatus de pago del pedido
    $sqlGetEstsPay="SELECT id, nombre FROM $tOrderEstPay  ";
    $resGetEstsPay=$con->query($sqlGetEstsPay);
    $optEstsPay='<option></option>';
    while($rowGetEstsPay = $resGetEstsPay->fetch_assoc()){
        $optEstsPay.='<option value="'.$rowGetEstsPay['id'].'">'.$rowGetEstsPay['nombre'].'</option>';
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
    if($tarea=="order"){
        $optStockStore .= '</div><div class="form-group">';
            $optStockStore .= '<label for="inputEst">Estatus</label>';
            $optStockStore .= '<select id="inputEst" name="inputEst" class="form-control" >'.$optEsts.'</select>';
        $optStockStore .= '</div>';
        $optStockStore .= '</div><div class="form-group">';
            $optStockStore .= '<label for="inputEstPay">Estatus pago</label>';
            $optStockStore .= '<select id="inputEstPay" name="inputEstPay" class="form-control" >'.$optEstsPay.'</select>';
        $optStockStore .= '</div>';
    }
    $optStockStore .= '<div class="report-buttons">';
    $optStockStore .= '<button type="button" id="generateReport" class="btn btn-primary generateReport">Mostrar reporte pedidos</button>&nbsp;&nbsp;&nbsp;';
    $optStockStore .= '<button type="button" class="btn btn-default cleanReport">Limpiar filtro</button>&nbsp;&nbsp;&nbsp;';
    if($tarea!="order")
        $optStockStore .= '<button type="button" class="btn btn-primary reportStock">Mostrar reporte almacén</button>&nbsp;&nbsp;&nbsp;';
    $optStockStore .= '<a href="javascript:void(0)" id="imprime" class="btn btn-success">Imprimir <span class="glyphicon glyphicon-print"></span></a>';
    $optStockStore .= '</div>';
    $optStockStore .= '</form>';

    echo $optStockStore;
?>