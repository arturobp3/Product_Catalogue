<?php

require_once("../config.php");
require_once("../pedido.php");
require_once("../producto.php");

//Aumenta en 1 la cantidad restante de los productos que contiene el pedido
Producto::incrementQuantity($_GET['id']);

//Cancela el pedido
Pedido::cancelarPedido($_GET['id']);

//Borrar XML factura
$ruta = '../mysql/facturas/'.$_GET['user'].'/pedido'.$_GET['id'].'.xml';
if ( file_exists($ruta) ) {
    if( unlink($ruta) ){

        $siguiente = "../../frontend/perfil.php";
        header('Location: '.$siguiente);

    }
    else{
        echo "Ha habido un error al borrar la factura";
        exit();
    }
}
else{
    echo "Ha habido un error al borrar la factura";
    exit();
}
