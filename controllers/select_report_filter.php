<?php
    include ('../config/conexion.php');
    include ('../config/variables.php');
    
    $store = $_POST['storeId'];
    $tarea = $_POST['tarea'];
    
    //$sqlGetSellers="SELECT id, CONCAT(nombre,' ',ap,' ',am) as nombre FROM $tUser WHERE perfil_id='3' ";
    //Obtenemos los vendedores
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
    
    //obtenemos las categorias
    $sqlGetCategories="SELECT * FROM $tCategory ";
    $resGetCategories=$con->query($sqlGetCategories);
    $optCategories='<option></option>';
    while($rowGetCategories = $resGetCategories->fetch_assoc()){
        $optCategories.='<option value="'.$rowGetCategories['id'].'">'.$rowGetCategories['nombre'].'</option>';
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
    $optStockStore .= '<form method="POST" id="formSelectReport" class="form-horizontal" action="controllers/select_report_store_2.php" >';
    $optStockStore .= '<input type="hidden" id="inputStore" name="inputStore" value="'.$store.'">';
    //filtro vendedor
    $optStockStore .= '<div class="col-md-6">';
      $optStockStore .= '<div class="form-group">';
          $optStockStore .= '<label class="col-sm-3 control-label" for="inputSellers">Vendedor: </label>';
          $optStockStore .= '<div class="col-sm-9">';
            $optStockStore .= '<select id="inputSellers" name="inputSellers" class="form-control">'.$optSellers.'</select>';
          $optStockStore .= '</div>';
      $optStockStore .= '</div>';
      //filtro por mes
      $optStockStore .= '<div class="form-group">';
          $optStockStore .= '<label class="col-sm-3 control-label" for="inputMonth">Mes: </label>';
          $optStockStore .= '<div class="col-sm-9">';
            $optStockStore .= '<input type="month" id="inputMonth" name="inputMonth" class="form-control">';
          $optStockStore .= '</div>';
      $optStockStore .= '</div>';
      //filtro por semana
      $optStockStore .= '<div class="form-group">';
          $optStockStore .= '<label class="col-sm-3 control-label" for="inputWeek">Semana: </label>';
          $optStockStore .= '<div class="col-sm-9">';
            $optStockStore .= '<input type="week" id="inputWeek" name="inputWeek" class="form-control" >';
          $optStockStore .= '</div>';
      $optStockStore .= '</div>';
    $optStockStore .= '</div>';
    //filtro por día
    $optStockStore .= '<div class="col-md-6">';
      $optStockStore .= '<div class="form-group">';
          $optStockStore .= '<label class="col-sm-3 control-label" for="inputDay">Día: </label>';
          $optStockStore .= '<div class="col-sm-9">';
            $optStockStore .= '<input type="date" id="inputDay" name="inputDay" class="form-control" >';
          $optStockStore .= '</div>';
      $optStockStore .= '</div>';
      //filtro por categoría
      $optStockStore .= '<div class="form-group">';
          $optStockStore .= '<label class="col-sm-3 control-label" for="inputCategory">Categoria: </label>';
          $optStockStore .= '<div class="col-sm-9">';
            $optStockStore .= '<select id="inputCategory" name="inputCategory" class="form-control">'.$optCategories.'</select>';
          $optStockStore .= '</div>';
      $optStockStore .= '</div>';
      //filtros de pedidos
      if($tarea=="order"){
          //filtro por estatus del pedido
          $optStockStore .= '<div class="form-group">';
              $optStockStore .= '<label class="col-sm-3 control-label" for="inputEst">Estatus: </label>';
              $optStockStore .= '<div class="col-sm-9">';
                $optStockStore .= '<select id="inputEst" name="inputEst" class="form-control" >'.$optEsts.'</select>';
              $optStockStore .= '</div>';
          $optStockStore .= '</div>';
          //filtro por estatus de pago del pedido
          $optStockStore .= '<div class="form-group">';
              $optStockStore .= '<label class="col-sm-3 control-label" for="inputEstPay">Estatus pago: </label>';
              $optStockStore .= '<div class="col-sm-9">';
                $optStockStore .= '<select id="inputEstPay" name="inputEstPay" class="form-control" >'.$optEstsPay.'</select>';
              $optStockStore .= '</div>';
          $optStockStore .= '</div>';
      }
    $optStockStore .= '</div>';
    
    //filtro de botones de reportes e impresiones
    $optStockStore .= '<div class="col-md-12">';
      $optStockStore .= '<div class="report-buttons text-center">';
      $optStockStore .= '<button type="button" class="btn btn-default cleanReport">Limpiar filtro</button>&nbsp;&nbsp;&nbsp;';
        if($tarea!="order"){
            $optStockStore .= '<button type="button" id="generateReport" class="btn btn-primary generateReport">Mostrar reporte ventas</button>&nbsp;&nbsp;&nbsp;';
            $optStockStore .= '<button type="submit" class="btn btn-success">Imprimir ventas <span class="glyphicon glyphicon-print"></span></button>&nbsp;&nbsp;&nbsp;';
        }
        else
          $optStockStore .= '<button type="button" id="generateReport" class="btn btn-primary generateReport">Mostrar reporte pedidos</button>&nbsp;&nbsp;&nbsp;';
        if($tarea!="order")
            $optStockStore .= '<button type="button" class="btn btn-primary reportStock">Mostrar reporte almacén</button>&nbsp;&nbsp;&nbsp;';
        if($tarea=="order")
            $optStockStore .= '<a href="javascript:void(0)" id="imprime" class="btn btn-success">Imprimir <span class="glyphicon glyphicon-print"></span></a>';
        else
            $optStockStore .= '<a href="controllers/select_report_store_stock.php?idStore='.$store.'&inputCategory=0"  class="btn btn-success" id="printStock">Imprimir almacén <span class="glyphicon glyphicon-print"></span></button>';
      $optStockStore .= '</div>';
    $optStockStore .= '</div>';
    $optStockStore .= '</form>';
   
    

    echo $optStockStore;
?>