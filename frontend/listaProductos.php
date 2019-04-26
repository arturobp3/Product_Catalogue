<?php
	//Inicio del procesamiento
	require_once("../backend/config.php");
	require_once("../backend/producto.php");

?>

<!DOCTYPE html>
<html lang="es">
<head>
	<title>Productos | Product Catalogue</title>
	<meta charset="UTF-8">

	<link rel="stylesheet" type="text/css" href="css/style.css">
	<link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
	<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
</head>
<body>

	<div class="contenedor">

		<?php require("comun/cabecera.php"); ?>

		<main>

			<?php 

				require("comun/sidebarIzq.php");

				if(isset($_GET['categoria'])){
					//Obtenemos gracias al controlador los productos deseados
					$result = Producto::buscarPorCategoria($_GET['categoria']);
				}
				else if(isset($_GET['searchMenu'])){
					//Buscamos el producto por lo que ha puesto el usuario en el buscador
					$result = Producto::buscarProductos($_GET['searchMenu']);
				}
				else{
					$result = false;
				}

				if($result === false){
					echo "<h1 class='mensaje'> No se han encontrado productos </h1>";
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