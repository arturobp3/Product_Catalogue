<?php

require_once('./config.php');


$producto = $_GET['id'];
$clave = array_search($producto, $_SESSION['listaProductos']);

unset($_SESSION['listaProductos'][$clave]);


$siguiente = "../frontend/listaCompra.php";

header('Location: '.$siguiente);