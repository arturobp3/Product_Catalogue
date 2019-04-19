<script src='./javascript/buscador.js'></script>



<header>

	<a href="index.php" id="logo"><p>PRODUCT CATALOGUE</p></a>

	<?php
		if (isset($_SESSION["login"]) && ($_SESSION["login"]===true)){
			echo '<div id="formCabecera">
					<form action="listaProductos.php" method="get">
						<input id="buscador" onkeyup="actualizaBuscador()" type="search" name="searchMenu" 
								placeholder=" Buscar un producto" autocomplete="off">
					</form>
				</div>' . 
				'<div id="enlaces">
					<a href="listaCompra.php">'."\u{1F4C6}".'</a>
					<a href="perfil.php">Perfil</a>
					<a href="logout.php">Salir</a>
				</div>';

		}
		else{
			echo '<div id="enlaces">
					<a href="login.php">Iniciar sesión</a>
					<a href="registro.php">Registrarse</a>
				</div>';
		}
	?>

</header>

