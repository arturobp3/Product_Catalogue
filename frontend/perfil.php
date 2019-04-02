<?php

	require_once("../backend/config.php");
	require_once("../backend/cliente.php");

?>
<!DOCTYPE html>
	<html>
		<head>
			<link rel="stylesheet" type="text/css" href="css/estilo.css" />
			<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
			<title>Perfil | Asteyo</title>
		</head>
		<body>
			<?php

			require("includes/comun/cabecera.php");

		?>

			<div class="principal">

				<?php require("includes/comun/sidebarIzq.php"); ?>

				<div id="contenido">						
					<a href='editarPerfil.php' id='edit'>Editar</a>
					<div id="panel-perfil">
						<div id="foto">
						<?php
							$imgPerfil = "mysql/img/".$_SESSION["nombre"]."/fotoPerfil.jpg";
							echo '<img id="img-perfil" src='.$imgPerfil.'>';
						?>
	                	</div>
	                	<div id="perfil">
							<?php
								$cliente = cliente::Buscacliente($_SESSION["nombre"]);
								//echo "Nombre: ".$_SESSION["nombre"];

								echo "<p>Nombre: ".$cliente->username()."</p>";
								$rango = $cliente->rol();
								echo "<p>Rango: ".$rango."</p>";

							?>
						</div>
					</div>
					<div id="panel-memes">
						<h3>Memes</h3>
						<?php
							$rtMemes= cliente::memes($cliente->username());
							
							if($rtMemes){
								foreach ($rtMemes as $key => $value) {
									echo '<img id="meme"src='.$value.'>';
								}
							}
						?>
					</div>
				</div>

			</div>

		<?php require("includes/comun/pie.php"); ?>
		</body>
	</html>

