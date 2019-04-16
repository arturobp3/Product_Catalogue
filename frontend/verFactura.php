<?php

require_once('../backend/config.php');
require_once('../backend/cliente.php');
require_once('../backend/utilsPedidos/facturaXML.php');
?>

<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="css/style.css" />
	<meta http-equiv="Content-Type" content="text/html" charset="utf-8">
	<link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
	<title>Factura | Product Catalog</title>
</head>

<body style="background-color: white">
<?php
    $cliente = unserialize($_SESSION['cliente']);

    $factura = new FacturaXML($_GET['id'], $cliente->username());

    $infoPedido = $factura->getFactura();

    if($infoPedido === null){
        echo "No se ha encontrado el pedido";
    }
    else{

        $html = "
            <table>
                <tr>
                    <th colspan='4'> ".$infoPedido->Empresa." </th>
                </tr>
                <tr>
                    <td>Pedido Nº: ".$infoPedido->id_Pedido."</td> 
                    <td>Modo de compra: ".$infoPedido->ModoCompra."</td>
                    <td colspan='2'>Fecha: ".$infoPedido->Fecha."</td>
                </tr>
                <tr>
                    <th colspan='4'> Datos del Cliente </th>
                </tr>
                <tr>
                    <td colspan='2'>Usuario: ".$infoPedido->Cliente->Usuario."</td>
                    <td colspan='2'>id: ".$infoPedido->Cliente->id."</td>
                </tr>
                <tr>
                    <td>Nombre: ".$infoPedido->Cliente->Nombre."</td>
                    <td>Apellidos: ".$infoPedido->Cliente->Apellidos."</td>
                    <td colspan='2'>Dirección de Envío: ".$infoPedido->Cliente->DireccionEnvio."</td>
                </tr>
                <tr>
                    <th colspan='4'> Lista de Productos </th>
                </tr>
                <tr>
                    <th> id </th>
                    <th> Nombre </th>
                    <th> Proveedor </th>
                    <th> Precio </th>
                </tr>
                ";
                for($i = 0; $i < sizeof($infoPedido->ListaProductos->Producto); $i++){
                    $html .= "<tr>
                        <td>".$infoPedido->ListaProductos->Producto[$i]->id ."</td>
                        <td>".$infoPedido->ListaProductos->Producto[$i]->Nombre ."</td>
                        <td>".$infoPedido->ListaProductos->Producto[$i]->Proveedor ."</td>
                        <td>".$infoPedido->ListaProductos->Producto[$i]->Precio ." €</td>
                    </tr>";
                }
                $html .= 
                "<tr>
                    <th></th>
                    <th colspan='3'>Total: ".$infoPedido->PrecioTotal." €</th>
                </tr>
            </table>";


            echo $html;
    }
?>
<body>
</html>