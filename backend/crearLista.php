<?php

require_once('./config.php');
require_once('../controller.php');


//Obtenemos el producto por su id
$producto = Controller::prodPorId($_GET['id']);

//Guardamos el producto con la clave de su id
$_SESSION['listaProductos'][$_GET['id']] = serialize($producto);


$siguiente = "../frontend/producto.php?id=".$_GET['id'];

header('Location: '.$siguiente);