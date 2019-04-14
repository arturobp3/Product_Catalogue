<?php

require_once('./config.php');
require_once('producto.php');


//Obtenemos el producto por su id
$producto = Producto::buscarPorId($_GET['id']);

//Guardamos el producto con la clave de su id
$_SESSION['listaProductos'][$_GET['id']] = serialize($producto);


$siguiente = "../frontend/producto.php?id=".$_GET['id'];

header('Location: '.$siguiente);