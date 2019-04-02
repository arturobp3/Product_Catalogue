<?php
//Cargamos las clases necesarias primero

	require_once("../backend/producto.php");


	switch($_GET["categoria"]){
		case "moda": 
			$result = Producto::buscarPorCategoria("Moda"); 
			break;
		case "informatica": 
			$result = Producto::buscarPorCategoria("Informática"); 
			break;
		case "musica": 
			$result = Producto::buscarPorCategoria("Música"); 
			break;
		case "libros": 
			$result = Producto::buscarPorCategoria("Libros"); 
			break;
		case "deportes": 
			$result = Producto::buscarPorCategoria("Deportes"); 
			break;

		default: 
			$_SESSION["queryProductos"] = "noCategory";
			break;
	}


	$_SESSION["queryProductos"] = $result;

	header('Location: ../frontend/index.php');