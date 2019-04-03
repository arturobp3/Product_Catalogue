<?php
	//Inicio del procesamiento
	require_once("../backend/config.php");
	require_once("../backend/formularioPerfil.php");
?>

<!DOCTYPE html>
<html lang="es">
<head>
	<title>Perfil | Product Catalog</title>
	<meta charset="UTF-8">

	<link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>

	<div class="contenedor">

		<?php require("comun/cabecera.php"); ?>

		<main>

			<div class="content">
				<div id="formInicial">
					<?php
						$formulario = new formularioPerfil("perfil");
						$formulario->gestiona();
					?>
				</div>
			</div>

		</main>
			
		<?php require("comun/pie.php");?>

	</div>

</body>
</html>