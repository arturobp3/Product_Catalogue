<?php
	//Inicio del procesamiento
	require_once("../backend/config.php");
	require_once("../controller.php");
?>

<!DOCTYPE html>
<html lang="es">
<head>
	<title>Producto | Product Catalog</title>
	<meta charset="UTF-8">

	<link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>

	<div class="contenedor">

		<?php require("comun/cabecera.php"); ?>

		<main>

			<?php 

				//Obtenemos gracias al controlador los productos deseados
				$result = Controller::prodPorId($_GET['id']);

				if($result === false){
					echo "<h1 class='mensaje'> Ups! Ese producto no existe! </h1>";
					exit();
				}
			
			?>

			<div class="content">
                <script src='./javascript/contentMain.js'></script>
                
                <div class='panel1'>
                    foto
                    titulo descripcion
                </div>
                <div class='panel2'>
                    precio
                    comprar
                </div>

                <div class='panel3'>
                    comentarios
                </div>

                
			</div>

		</main>

		<?php require("comun/pie.php"); ?>
		

	</div>

</body>
</html>