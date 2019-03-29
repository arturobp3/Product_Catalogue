<!DOCTYPE html>
<html lang="es">
<head>
	<title>Inicio | Product Catalog</title>
	<meta charset="UTF-8">

	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>


	<div class="contenedor">

		<header>

			<a href="index.html" id="logo"><h1>PRODUCT CATALOG</h1></a>

			<form action="#" class="formCabecera">
				<input type="search" name="searchMenu" placeholder=" Buscar un producto">
			</form>

			<div id="enlaces">
					<?php
						if (isset($_SESSION["login"]) && ($_SESSION["login"]===true)) {
							echo "Bienvenido, " . $_SESSION['nombre'] .
							". <a href='perfil.php' class='perfil'>Perfil</a>
							<a href='logout.php' class='salir'>Salir</a>";		
						} else {
							//Poner class para los enlaces?? y enlazarlo con CSS
							echo "<a href='login.php' class='login'>Iniciar sesión</a> 
							<a href='registro.php' class='registro'>Registrarse</a>";
						}
					?>
			</div>

		</header>



			<!--<section class="main">

				<nav class="leftSideBar">
					<ul>
						<li><a href="#">Inicio</a></li>
						<li><a href="#">Categorías</a></li>
					</ul>
				</nav>


			</section>

			<footer>

				<h2>Esto es un pie de página</h2>
				
			</footer>-->


	</div>


</body>
</html>