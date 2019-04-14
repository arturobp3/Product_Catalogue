<?php
	//Inicio del procesamiento
	require_once("../backend/config.php");
	require_once("../backend/producto.php");

?>

<!DOCTYPE html>
<html lang="es">
<head>
	<title>Productos | Product Catalog</title>
	<meta charset="UTF-8">

	<link rel="stylesheet" type="text/css" href="css/style.css">
	<link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
</head>
<body>

	<div class="contenedor">

		<?php require("comun/cabecera.php"); ?>

		<main>

			<?php 

				require("comun/sidebarIzq.php");

				//Obtenemos gracias al controlador los productos deseados
				$result = Producto::buscarPorCategoria($_GET['categoria']);

				if($result === false){
					echo "<h1 class='mensaje'> Ups! Esa categoría no existe! </h1>";
					exit();
				}
			
			?>

			<div class="content">
				<script src='./javascript/contentMain.js'></script>

				<?php

					foreach ($result as $key => $value) {
						if($value->quantity() > 0) $stock = "En stock";
						else $stock = "Agotado";

						echo "<a id='productos' href='./producto.php?id=".$value->id()."'>
								<div id='panelProducto'>
									<p>".$value->name()."</p>
									<div id='parteInf'>
										<img src='../backend/mysql/products/".$value->id().".jpg'>
										<p class='stock'>".$stock."</p>
										<p id='precio'>".$value->price()."€</p>
									</div>
								</div>
							</a>";
					}
				?>

				<script> cambiaStock(); </script>
				
			</div>

		</main>

		<?php require("comun/pie.php"); ?>
		

	</div>

</body>
</html>