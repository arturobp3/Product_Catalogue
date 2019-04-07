<?php

require_once('./config.php');


$producto = $_GET['id'];

$_SESSION['listaProductos'][] = $producto;


$siguiente = "../frontend/producto.php?id=".$producto;

header('Location: '.$siguiente);