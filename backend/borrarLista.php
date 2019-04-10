<?php

require_once('./config.php');


$producto = $_GET['id'];

unset($_SESSION['listaProductos'][$producto]);


$siguiente = "../frontend/listaCompra.php";

header('Location: '.$siguiente);