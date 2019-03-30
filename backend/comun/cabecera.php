<header>

	<a href="index.php" id="logo"><p>PRODUCT CATALOG</p></a>

	<?php
		if (isset($_SESSION["login"]) && ($_SESSION["login"]===true)){
			echo '<div id="formCabecera">
					<form action="#">
						<input type="search" name="searchMenu" placeholder=" Buscar un producto">
					</form>
				</div>' . 
				'<div id="enlaces">
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


<!--
<div class="cabecera">

	<div id="logo">
		<a href="index.php"><img src="img/logoasteyonombre.png" /></a>
	</div>
	<div id="link">
		
			if (isset($_SESSION["login"]) && ($_SESSION["login"]===true)) {
				echo "Bienvenido, " . $_SESSION['nombre'] . "." .
				"<a href='subirMeme.php' class='subirMeme'>Subir Meme</a>
				<a href='perfil.php' class='perfil'>Perfil</a>
				<a href='logout.php' class='salir'>Salir</a>";		
			} else {
				echo "<a href='login.php' class='login'>Iniciar sesión</a> 
				<a href='registro.php' class='registro'>Registrarse</a>";
			}
		?>
	</div>
</div>
		-->
