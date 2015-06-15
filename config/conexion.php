<?php
	
	date_default_timezone_set('America/Mexico_City');
	$host="localhost";
	$user="root";
	$pass="";
	$db="concepcion";
	$con=mysqli_connect($host, $user, $pass, $db);
	if($con->connect_error){
		die("Connection failed: ".$con->connect_error);
	}
	//echo 'Hola';
	$tStock="almacenes";
	$tCategory="categorias";
	$tSubCategory="subcategorias";
        $tDecrease="costales";
        $tPerfil="perfiles";
        $tProduct="productos";
        $tWaste="sobrantes";
        $tStore="tiendas";
        $tUser="usuarios";
        $tSaleInfo="ventas_info";
        $tSaleProd="ventas_prod";
        $tEst="estatus";
        $tOrderInfo="pedidos_info";
        $tOrderPay="pedidos_pagos";
        $tOrderProd="pedidos_prod";
        $tOrderEst="pedido_est";
        $tOrderEstPay="pedido_est_pago";
?>