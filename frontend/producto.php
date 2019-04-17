<?php
	//Inicio del procesamiento
	require_once("../backend/config.php");
	require_once("../backend/producto.php");
?>

<!DOCTYPE html>
<html lang="es">
<head>
	<title>Producto | Product Catalog</title>
	<meta charset="UTF-8">

	<link rel="stylesheet" type="text/css" href="css/style.css">
	<link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
</head>
<body>

	<div class="contenedor">

		<?php require("comun/cabecera.php"); ?>

		<main>

			<?php 

				//Obtenemos gracias al controlador los productos deseados
				$result = Producto::buscarPorId($_GET['id']);

				if($result === false){
					echo "<h1 class='mensaje'> Ups! Ese producto no existe! </h1>";
					exit();
				}
			

				echo "<div class='content'>

						<script src='./javascript/productAvailable.js'></script>
			
						<div class='panel1'>
							<img src='../backend/mysql/products/".$result->id().".jpg'>

							<div class='panel1-2'>
								<h1>".$result->name()."</h1>
								<p> Proveedor: ".$result->brand()."</p>
								<br>
								<p>".$result->info()."</p>
							</div>
						</div>
						<div class='panel2'>
							<h2> Precio: ".$result->price()." € </h2>
							<form action='../backend/utilsCarrito/crearListaCompra.php?id=".$result->id()."' method='post' id='form'>
								<button type='submit' onclick='button()' name='comprar' id='comprar'>Comprar</button>
							</form>

						</div>

						<script> cambiarComprar(".$result->quantity()."); </script>

						
						<div class='panel3'>
							<h3> COMENTARIOS </h3>
							<div id='comentarios'>


							</div>
						</div>


					</div>";
			?>

		</main>

		<?php require("comun/pie.php"); ?>
		

	</div>

</body>
</html>