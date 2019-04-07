<?php

//Inicio del procesamiento
require_once("../backend/config.php");

//Doble seguridad: unset + destroy
unset($_SESSION["login"]);
unset($_SESSION["cliente"]);
unset($_SESSION['listaProductos']);


session_destroy();
?>

<!DOCTYPE html>
<html lang="es">
<head>
	<title>Inicio | Product Catalog</title>
	<meta charset="UTF-8">

	<link rel="stylesheet" type="text/css" href="css/style.css">
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



