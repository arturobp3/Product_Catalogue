<?php
//Cargamos las clases necesarias primero

	require_once("../backend/producto.php");


	switch($_GET["categoria"]){
		
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

	if($_SESSION["queryProductos"] === "noCategory"){
		$_SESSION["queryProductosCorrecta"] = false;
	}
	else{
		$_SESSION["queryProductos"] = serialize($result);
		$_SESSION["queryProductosCorrecta"] = true;
	}


	header('Location: ../frontend/index.php');