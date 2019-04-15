<?php

require_once('../backend/config.php');
require_once('../backend/cliente.php');
require_once('../backend/utilsPedidos/facturaXML.php');

//Hacer como un print formateado que parezca una factura
//(Tablas html???)


$cliente = unserialize($_SESSION['cliente']);

$factura = new FacturaXML($_GET['id'], $cliente->username());

$infoPedido = $factura->getFactura();

if($infoPedido === null){
    echo "No se ha encontrado el pedido";
}
else{
    echo $infoPedido->Fecha;
}