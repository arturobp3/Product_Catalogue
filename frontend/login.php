<?php
	//Inicio del procesamiento

	//require_once("backend/config.php");
	require_once("../backend/formularioLogin.php");
?>

<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="css/style.css" />
	<meta http-equiv="Content-Type" content="text/html" charset="utf-8">
	<title>Iniciar Sesión | Product Catalog</title>
</head>

<body>

	<div class="contenedor">

		<?php require("../backend/comun/cabecera.php"); ?>

		<main>

			<div id="formInicial">
				<?php
					$formulario = new formularioLogin("login");
					$formulario->gestiona();
				?>
			</div>

		</main>
			
		<?php require("../backend/comun/pie.php");?>


	</div>

</body>
</html>
