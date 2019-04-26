<?php
	//Inicio del procesamiento
	require_once("../backend/config.php");
	require_once("../backend/producto.php");
?>

<!DOCTYPE html>
<html lang="es">
<head>
	<title>Inicio | Product Catalogue</title>
	<meta charset="UTF-8">

	<link rel="stylesheet" type="text/css" href="css/style.css">
	<link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
	<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
</head>
<body>

	<div class="contenedor">

		<?php 
			require("comun/cabecera.php");
			require("comun/main.php"); 
			require("comun/pie.php");
		?>

	</div>

</body>
</html>